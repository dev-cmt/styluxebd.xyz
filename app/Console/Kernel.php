<?php

namespace App\Console;

use App\Account;
use App\AccountTransaction;
use App\Order;
use App\Services\CourierService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {

            // Fetch Orders with Null customer_activity and status = 1
            $sales = DB::table('orders')
                ->select('id', 'customer_phone', 'customer_activity')
                ->whereNull('customer_activity')
                ->where('status', 1)
                ->limit(20)
                ->get();

            foreach ($sales as $order) {
                $phone = $order->customer_phone;

                if (!preg_match('/^01[3-9]\d{8}$/', $phone)) {
                    continue;
                }

                try {
                    /* ================= API CALL (Laravel Http Client) ================= */
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . env('FROODLY_TOKEN'),
                        'Content-Type' => 'application/json',
                    ])->timeout(5)->post(env('FROODLY_URL'), [
                        'phone' => $phone,
                    ]);

                    if ($response->successful()) {
                        $result = $response->json();

                        if (isset($result['status']) && $result['status'] == 'success' && isset($result['data'])) {
                            $f2 = $result['data'];

                            // Format 2 থেকে Format 1 এ রূপান্তর (Mapping)
                            $formattedData = [
                                "Summaries" => [
                                    "Redx" => [
                                        "total"   => $f2['redx']['total_parcel'] ?? 0,
                                        "success" => $f2['redx']['success_parcel'] ?? 0,
                                        "cancel"  => $f2['redx']['cancelled_parcel'] ?? 0,
                                    ],
                                    "SteadFast" => [
                                        "total"   => $f2['steadfast']['total_parcel'] ?? 0,
                                        "success" => $f2['steadfast']['success_parcel'] ?? 0,
                                        "cancel"  => $f2['steadfast']['cancelled_parcel'] ?? 0,
                                    ],
                                    "Pathao" => [
                                        "total"   => $f2['pathao']['total_parcel'] ?? 0,
                                        "success" => $f2['pathao']['success_parcel'] ?? 0,
                                        "cancel"  => $f2['pathao']['cancelled_parcel'] ?? 0,
                                    ],
                                    "Carrybee" => [
                                        "total"   => $f2['carrybee']['total_parcel'] ?? 0,
                                        "success" => $f2['carrybee']['success_parcel'] ?? 0,
                                        "cancel"  => $f2['carrybee']['cancelled_parcel'] ?? 0,
                                    ],
                                    "Paperfly" => [
                                        "total"   => $f2['paperfly']['total_parcel'] ?? 0,
                                        "success" => $f2['paperfly']['success_parcel'] ?? 0,
                                        "cancel"  => $f2['paperfly']['cancelled_parcel'] ?? 0,
                                    ],
                                ],
                                "totalSummary" => [
                                    "total"       => $f2['summary']['total_parcel'] ?? 0,
                                    "success"     => $f2['summary']['success_parcel'] ?? 0,
                                    "cancel"      => $f2['summary']['cancelled_parcel'] ?? 0,
                                    "successRate" => $f2['summary']['success_ratio'] ?? 0,
                                    "cancelRate"  => isset($f2['summary']['total_parcel']) && $f2['summary']['total_parcel'] > 0
                                        ? round(($f2['summary']['cancelled_parcel'] / $f2['summary']['total_parcel']) * 100, 2)
                                        : 0,
                                ]
                            ];

                            $dataToSave = json_encode($formattedData);

                            // DB Query Builder দিয়ে ডাটাবেজে সেভ করা
                            DB::table('orders')
                                ->where('id', $order->id)
                                ->update([
                                    'customer_activity' => $dataToSave,
                                ]);
                        }
                    }
                } catch (\Exception $e) {
                    Log::error("Courier check failed for Order ID {$order->id}: " . $e->getMessage());
                }
            }


            // Courier  check for orders with courier_status = 1 and is_sent_to_courier = 1
            $orders = Order::with('get_courier')
                ->whereNotNull('consignment_id')
                ->whereIn('status', [9, 14])
                ->where('is_courier_detailed', 0)
                ->get();

            if ($orders->isEmpty()) {
                return response()->json(['message' => 'No orders found'], 404);
            }

            foreach ($orders as $order) {
                if ($order->courier_id != 1 && $order->is_sent_to_courier == 1) {
                    // Log::info("Fetching courier details for Order ID: {$order->id}");
                    $courierData = CourierService::fetchDetails($order);
                    //  dd($courierData);
                    if (!$courierData) {
                        continue;
                    }
                    $cTargetAmount    = floatval($courierData['target_amount'] ?? 0);
                    $cDeliveryCharge  = floatval($courierData['delivery_charge'] ?? 0);
                    $cCodCharge       = floatval($courierData['cod_charge'] ?? 0);
                    $cDiscount        = floatval($courierData['discount'] ?? 0);

                    // c_delivery_fee = c_delivery_charge + c_cod_charge - c_discount
                    $cDeliveryFee     = $cDeliveryCharge + $cCodCharge - $cDiscount;
                    $cCollectedAmount = floatval($courierData['collected_amount'] ?? 0);


                    // c_paid_amount = c_target_amount - total_delivery_fee
                    $cPaidAmount      = $cTargetAmount - $cDeliveryFee;
                    $paymentStatus    = $courierData['payment_status'];
                } else {
                    // dd(2);
                    // যদি পেমেন্ট স্ট্যাটাস আগেই 1 হয়ে থাকে, তবে বর্তমান ডেটার ওপর ভিত্তি করেই সেটেলমেন্ট হবে
                    $cTargetAmount    = floatval($order->c_target_amount ?? 0);
                    $cDeliveryCharge  = floatval($order->c_delivery_charge ?? 0);
                    $cCodCharge       = floatval($order->cod_charge ?? 0);
                    $cDiscount        = floatval($order->c_discount ?? 0);
                    $cDeliveryFee     = floatval($order->total_delivery_fee ?? ($cDeliveryCharge + $cCodCharge - $cDiscount));
                    $cCollectedAmount = floatval($order->c_collected_amount ?? 0);
                    $cPaidAmount      = floatval($order->c_paid_amount ?? ($cCollectedAmount - $cDeliveryFee));
                    $paymentStatus    = $order->payment_status;
                }
                Log::info("Courier Info for Order ID {$order->invoice_id}: Target Amount: {$cTargetAmount}, Delivery Charge: {$cDeliveryCharge}, COD Charge: {$cCodCharge}, Discount: {$cDiscount}, Delivery Fee: {$cDeliveryFee}, Collected Amount: {$cCollectedAmount}, Paid Amount: {$cPaidAmount}, Payment Status: {$paymentStatus}");
                // dd($cTargetAmount, $cDeliveryCharge, $cCodCharge, $cDiscount, $cDeliveryFee, $cCollectedAmount, $cPaidAmount, $paymentStatus);

                try {
                    // Sales Table Update (Tenant Connection)
                    $order->update([
                        'c_delivery_charge'       => $cDeliveryCharge,
                        'c_target_amount'         => $cTargetAmount,
                        'c_discount'              => $cDiscount,
                        'c_collected_amount'      => $cCollectedAmount,
                        'c_paid_amount'           => $cPaidAmount,
                        'cod_charge'              => $cCodCharge,
                        'total_delivery_fee'      => $cDeliveryFee,
                        // 'payment_status'          => $paymentStatus,
                        'is_courier_detailed'     => 1,
                        'updated_at'              => now(),
                    ]);
                } catch (\Throwable $e) {
                    Log::error("CourierInfo Error: " . $e->getMessage());
                }
            }


            // Account and Account Transaction
            $orders = Order::where('payment_status', 1)
                ->where('is_accounted', 0)
                ->whereNotNull('consignment_id')
                ->whereIn('status', [9, 14])
                ->where('c_paid_amount', '>', 0)
                ->get();
            foreach ($orders as $order) {
                try {
                    DB::transaction(function () use ($order) {
                        // Lock order to prevent concurrent processing
                        $lockedOrder = Order::where('id', $order->id)
                            ->lockForUpdate()
                            ->first();

                        if (!$lockedOrder || $lockedOrder->is_accounted != 0) {
                            return;
                        }
                        $account = Account::where('is_default', 1)
                            ->lockForUpdate()
                            ->first();
                        if (!$account) {
                            throw new \Exception('Default account not found.');
                        }
                        $amount = (float) $lockedOrder->c_paid_amount;
                        $transaction = AccountTransaction::create([
                            'account_id'       => $account->id,
                            'order_id'         => $lockedOrder->id,
                            'amount'           => $amount,
                            'transaction_type' => 0,
                            'purpose'      => 'Payment received for Order Invoice ID: '
                                . $lockedOrder->invoice_id,
                        ]);
                        $account->increment('balance', $amount);
                        $lockedOrder->update([
                            'is_accounted' => 1,
                        ]);
                    });

                    Log::info("Accounting completed for Order ID: {$order->id}");
                } catch (\Throwable $e) {
                    Log::error(
                        "Account Error for Order ID {$order->id}: "
                            . $e->getMessage()
                    );
                }
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
