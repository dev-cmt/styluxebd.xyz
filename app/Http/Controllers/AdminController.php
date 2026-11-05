<?php

namespace App\Http\Controllers;

use App\AbandonedCart;
use App\Account;
use App\Admin;
use App\Expense;
use App\ExpenseBill;
use App\ExpenseCategory;
use App\Order;
use App\OrderProduct;
use App\Product;
use App\Services\Courier\PathaoCourier;
use App\Services\Courier\RedxCourier;
use App\Services\Courier\SteadfastCourier;
use App\Services\CourierService;
use App\Subscribe;
use App\Theme;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // public function __construct()
    // {
    //     if (file_exists(base_path('vendor/laravel/framework/src/Illuminate/license.dat'))) {
    //         $file = fopen(base_path() . "/vendor/laravel/framework/src/Illuminate/license.dat", 'r');
    //         $read = fgets($file);
    //         fclose($file);
    //         if ($read != str_replace('www.', '', $_SERVER['SERVER_NAME'])) {
    //             function getIPAddress()
    //             {
    //                 if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    //                     $ip = $_SERVER['HTTP_CLIENT_IP'];
    //                 } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    //                     $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    //                 } else {
    //                     $ip = $_SERVER['REMOTE_ADDR'];
    //                 }
    //                 return $ip;
    //             }

    //             $ip = getIPAddress();
    //             if ($ip == '::1') {
    //                 $ip = gethostname();
    //             }
    //             $client = new \GuzzleHttp\Client();
    //             $url = 'https://license.prodevsltd.com/activation/attempt/store';
    //             $url2 = 'http://' . $_SERVER['SERVER_NAME'];
    //             $form_params = [
    //                 'ip' => $ip,
    //                 'parent' => $file,
    //                 'url' => $url2,
    //             ];
    //             $response = $client->post($url, ['form_params' => $form_params]);
    //             $response->getBody()->getContents();
    //             dd('This Product Is Pirated. Please Contact with ask@prodevsltd.com or www.prodevsltd.com');
    //         }
    //     } else {
    //         function getIPAddress()
    //         {
    //             if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    //                 $ip = $_SERVER['HTTP_CLIENT_IP'];
    //             } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    //                 $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    //             } else {
    //                 $ip = $_SERVER['REMOTE_ADDR'];
    //             }
    //             return $ip;
    //         }

    //         $parent = env('APP_NAME') . ', ' . env('APP_URL');

    //         $ip = getIPAddress();
    //         if ($ip == '::1') {
    //             $ip = gethostname();
    //         }
    //         $client = new \GuzzleHttp\Client();
    //         $url = 'https://license.prodevsltd.com/activation/attempt/store';
    //         $url2 = 'http://' . $_SERVER['SERVER_NAME'];
    //         $form_params = [
    //             'ip' => $ip,
    //             'parent' => $parent,
    //             'url' => $url2,
    //         ];
    //         $response = $client->post($url, ['form_params' => $form_params]);
    //         $response->getBody()->getContents();
    //         dd('This Product Is Pirated. Please Contact with ask@prodevsltd.com or www.prodevsltd.com');
    //     }
    // }


    public function dashboard(Request $request)
    {
        $activeThemeId = Theme::where('is_active', 1)->value('id');

        /*
    |--------------------------------------------------------------------------
    | Date Range (Default: Current Month)
    |--------------------------------------------------------------------------
    */
        $start = null;
        $end   = null;

        if ($request->filled('date_range')) {
            $dates = explode(' - ', $request->date_range);

            if (count($dates) === 2) {
                try {
                    $start = Carbon::parse(trim($dates[0]))->startOfDay();
                    $end   = Carbon::parse(trim($dates[1]))->endOfDay();
                } catch (\Exception $e) {
                    $start = Carbon::now()->startOfMonth();
                    $end   = Carbon::now()->endOfMonth();
                }
            }
        } else {
            // Default to Current Month if no filter is provided
            $start = Carbon::now()->startOfMonth();
            $end   = Carbon::now()->endOfMonth();
        }

        /*
    |--------------------------------------------------------------------------
    | Helper for Date Filter
    |--------------------------------------------------------------------------
    */
        $applyOrderDate = function ($query) use ($start, $end) {
            if ($start && $end) {
                $query->whereBetween('order_date', [$start, $end]);
            }
            return $query;
        };

        /*
    |--------------------------------------------------------------------------
    | ORDER STATUS COUNTS
    |--------------------------------------------------------------------------
    */
        $statusCountsQuery = Order::select(
            'status',
            DB::raw('COUNT(*) as total')
        );

        $applyOrderDate($statusCountsQuery);

        $statusCounts = $statusCountsQuery
            ->groupBy('status')
            ->pluck('total', 'status');

        /*
    |--------------------------------------------------------------------------
    | Order Status Data
    |--------------------------------------------------------------------------
    */
        $data['total_pending_order']         = isset($statusCounts[1]) ? $statusCounts[1] : 0;
        $data['total_confirm_order']         = isset($statusCounts[2]) ? $statusCounts[2] : 0;
        $data['total_processing_order']      = isset($statusCounts[3]) ? $statusCounts[3] : 0;
        $data['total_hold_order']            = isset($statusCounts[4]) ? $statusCounts[4] : 0;
        $data['total_printed_order']         = isset($statusCounts[5]) ? $statusCounts[5] : 0;
        $data['total_packaging_order']       = isset($statusCounts[6]) ? $statusCounts[6] : 0;
        $data['total_courier_entry_order']   = isset($statusCounts[7]) ? $statusCounts[7] : 0;
        $data['total_on_delivery_order']     = isset($statusCounts[8]) ? $statusCounts[8] : 0;
        $data['total_delivered_order']       = isset($statusCounts[9]) ? $statusCounts[9] : 0;
        $data['total_cancelled_order']       = isset($statusCounts[10]) ? $statusCounts[10] : 0;
        $data['total_returned_order']        = isset($statusCounts[11]) ? $statusCounts[11] : 0;
        $data['total_return_received_order'] = isset($statusCounts[12]) ? $statusCounts[12] : 0;
        $data['total_exchange_order']        = isset($statusCounts[13]) ? $statusCounts[13] : 0;

        /*
    |--------------------------------------------------------------------------
    | Total Orders
    |--------------------------------------------------------------------------
    */
        $orderCountQuery = Order::query();
        $applyOrderDate($orderCountQuery);
        $data['total_order'] = $orderCountQuery->count();

        /*
    |--------------------------------------------------------------------------
    | DELIVERED & PARTIALLY DELIVERED SALES (REVENUE)
    |--------------------------------------------------------------------------
    */
        $ordersQuery = Order::whereIn('status', [9, 14]);
        $applyOrderDate($ordersQuery);
        $totalSales = $ordersQuery->sum('total');

        $data['total_revenue'] = $totalSales;

        /*
    |--------------------------------------------------------------------------
    | DELIVERED & PARTIALLY DELIVERED ORDER COUNT
    |--------------------------------------------------------------------------
    */
        $deliveredCountQuery = Order::whereIn('status', [9, 14]);
        $applyOrderDate($deliveredCountQuery);
        $deliveredCount = $deliveredCountQuery->count();

        /*
    |--------------------------------------------------------------------------
    | PRODUCT COST
    |--------------------------------------------------------------------------
    */
        $productCostQuery = OrderProduct::whereHas('get_order', function ($q) use ($start, $end) {
            $q->whereIn('status', [9, 14]);
            if ($start && $end) {
                $q->whereBetween('order_date', [$start, $end]);
            }
        });

        $totalProductCost = $productCostQuery
            ->sum(DB::raw('purchase_price * qty'));

        /*
    |--------------------------------------------------------------------------
    | TOTAL COURIER / DELIVERY FEE (FOR SUCCESSFUL ORDERS)
    |--------------------------------------------------------------------------
    */
        $totalCourierFee = Order::whereIn('status', [9, 14])
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->whereBetween('order_date', [$start, $end]);
            })
            ->select(DB::raw('SUM(CASE WHEN total_delivery_fee > 0 THEN total_delivery_fee ELSE shipping_cost END) as total_fee'))
            ->value('total_fee') ?? 0;

        /*
    |--------------------------------------------------------------------------
    | GROSS PROFIT (Total Sales - Product Cost - Courier Delivery Fee)
    |--------------------------------------------------------------------------
    */
        $data['gross_profit'] = $totalSales - $totalProductCost - $totalCourierFee;

        //     /*
        // |--------------------------------------------------------------------------
        // | GROSS PROFIT
        // |--------------------------------------------------------------------------
        // */
        //     $data['gross_profit'] = $totalSales - $totalProductCost;

        /*
    |--------------------------------------------------------------------------
    | EXPENSE (OUTGOING)
    |--------------------------------------------------------------------------
    */
        $expenseQuery = Expense::query();
        if ($start && $end) {
            $expenseQuery->whereBetween('created_at', [$start, $end]);
        }
        //  expense Bill er jonno total expense ber korar jonno query

        $expenseBillQuery = ExpenseBill::query();
        if ($start && $end) {
            $expenseBillQuery->whereBetween('created_at', [$start, $end]);
        }


        $data['total_expense'] = $expenseQuery->sum('amount') + $expenseBillQuery->sum('amount');

        /*
    |--------------------------------------------------------------------------
    | NET PROFIT
    |--------------------------------------------------------------------------
    */
        $data['net_profit'] = $data['gross_profit'] - $data['total_expense'];

        /*
    |--------------------------------------------------------------------------
    | PROFIT MARGIN
    |--------------------------------------------------------------------------
    */
        $data['profit_margin'] = $totalSales > 0
            ? round(($data['net_profit'] / $totalSales) * 100, 2)
            : 0;

        /*
    |--------------------------------------------------------------------------
    | AVERAGE ORDER VALUE
    |--------------------------------------------------------------------------
    */
        $data['avg_order_value'] = $deliveredCount > 0
            ? round($totalSales / $deliveredCount, 2)
            : 0;

        /*
    |--------------------------------------------------------------------------
    | CUSTOMERS
    |--------------------------------------------------------------------------
    */
        $customerQuery = User::query();
        if ($start && $end) {
            $customerQuery->whereBetween('created_at', [$start, $end]);
        }
        $data['total_customer'] = $customerQuery->count();

        /*
    |--------------------------------------------------------------------------
    | PRODUCTS
    |--------------------------------------------------------------------------
    */
        $data['total_product'] = Product::where('is_combo', 0)->where('theme_id', $activeThemeId)->count();

        /*
    |--------------------------------------------------------------------------
    | STAFF
    |--------------------------------------------------------------------------
    */
        $data['total_staff'] = Admin::count();

        /*
    |--------------------------------------------------------------------------
    | ABANDONED ORDERS
    |--------------------------------------------------------------------------
    */
        $abandonedQuery = AbandonedCart::query();
        if ($start && $end) {
            $abandonedQuery->whereBetween('created_at', [$start, $end]);
        }
        $data['total_abandoned_order'] = $abandonedQuery->count();

        /*
    |--------------------------------------------------------------------------
    | DELIVERY / RETURN / CANCEL RATE
    |--------------------------------------------------------------------------
    */
        $completedOrFailed =
            $data['total_delivered_order'] +
            $data['total_cancelled_order'] +
            $data['total_returned_order'];

        $data['delivery_success_rate'] = $completedOrFailed > 0
            ? round(($data['total_delivered_order'] / $completedOrFailed) * 100, 1)
            : 0;

        $data['return_rate'] = $completedOrFailed > 0
            ? round(($data['total_returned_order'] / $completedOrFailed) * 100, 1)
            : 0;

        $data['cancel_rate'] = $completedOrFailed > 0
            ? round(($data['total_cancelled_order'] / $completedOrFailed) * 100, 1)
            : 0;

        /*
    |--------------------------------------------------------------------------
    | RECENT ORDERS
    |--------------------------------------------------------------------------
    */
        $recentOrdersQuery = Order::select(
            'id',
            'order_date',
            'customer_name',
            'customer_phone',
            'total',
            'status'
        );
        $applyOrderDate($recentOrdersQuery);
        $data['recent_orders'] = $recentOrdersQuery
            ->orderBy('order_date', 'desc')
            ->limit(10)
            ->get();

        /*
    |--------------------------------------------------------------------------
    | STAFF ORDER ASSIGNMENT
    |--------------------------------------------------------------------------
    */
        $data['staff_order_breakdown'] = Admin::where('id', '!=', 1)
            ->withCount([
                'get_order_assign as assigned_orders_count' => function ($q) use ($start, $end) {
                    if ($start && $end) {
                        $q->whereHas('get_order', function ($o) use ($start, $end) {
                            $o->whereBetween('order_date', [$start, $end]);
                        });
                    }
                }
            ])
            ->orderBy('assigned_orders_count', 'desc')
            ->limit(10)
            ->get();

        /*
    |--------------------------------------------------------------------------
    | TOP SELLING PRODUCTS
    |--------------------------------------------------------------------------
    */
        $soldProductsQuery = OrderProduct::select(
            'product_id',
            DB::raw('SUM(qty) as total_sold')
        )
            ->whereHas('get_order', function ($q) use ($start, $end) {
                $q->where('status', 9);
                if ($start && $end) {
                    $q->whereBetween('order_date', [$start, $end]);
                }
            })
            ->groupBy('product_id');

        $data['top_selling_products'] = Product::where('is_combo', 0)->where('theme_id', $activeThemeId)
            ->joinSub(
                $soldProductsQuery,
                'sold_products',
                function ($join) {
                    $join->on('products.id', '=', 'sold_products.product_id');
                }
            )
            ->select('products.*', 'sold_products.total_sold')
            ->orderBy('sold_products.total_sold', 'desc')
            ->limit(5)
            ->get();

        /*
    |--------------------------------------------------------------------------
    | COURIER DISTRIBUTION
    |--------------------------------------------------------------------------
    */
        $courierStatsQuery = Order::select(
            'courier_id',
            DB::raw('COUNT(*) as total')
        )
            ->whereNotNull('courier_id');
        $applyOrderDate($courierStatsQuery);
        $data['courier_breakdown'] = $courierStatsQuery
            ->groupBy('courier_id')
            ->get();

        /*
    |--------------------------------------------------------------------------
    | EXPENSE CATEGORY
    |--------------------------------------------------------------------------
    */
        $expenseCatQuery = Expense::select(
            'category_id',
            DB::raw('SUM(amount) as total_amount')
        );

        if ($start && $end) {
            $expenseCatQuery->whereBetween('created_at', [$start, $end]);
        }

        $expenseBillQuery = ExpenseBill::select(
            'category_id',
            DB::raw('SUM(amount) as total_amount')
        );

        if ($start && $end) {
            $expenseBillQuery->whereBetween('created_at', [$start, $end]);
        }

        $expenseData = $expenseCatQuery
            ->groupBy('category_id')
            ->get();

        $expenseBillData = $expenseBillQuery
            ->groupBy('category_id')
            ->get();

        $merged = $expenseData->concat($expenseBillData)
            ->groupBy('category_id')
            ->map(function ($items, $categoryId) {
                return (object) [
                    'category_id'  => $categoryId,
                    'total_amount' => $items->sum('total_amount'),
                ];
            })
            ->sortByDesc('total_amount')
            ->take(5)
            ->values();

        $data['expense_categories'] = $merged->map(function ($item) {
            $item->get_category = ExpenseCategory::find($item->category_id);
            return $item;
        });

        /*
    |--------------------------------------------------------------------------
    | FINANCIAL ACCOUNTS
    |--------------------------------------------------------------------------
    */
        $accountsQuery = Account::query();
        if ($start && $end) {
            $accountsQuery->whereBetween('created_at', [$start, $end]);
        }
        $data['accounts_balance'] = $accountsQuery->get();

        return view(
            'backEnd.admin.dashboard',
            compact('data', 'start', 'end')
        );
    }

    // change password
    public function change_pass()
    {
        return view('backEnd.admin.change_pass');
    }

    public function update_pass(Request $request)
    {

        $user_id = Auth::guard('admin')->user()->id;
        if (Hash::check($request->old_pass, Admin::find($user_id)->password)) {
            Admin::find($user_id)->update([
                'password' => Hash::make($request->password),
            ]);

            $this->guard_admin()->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return $this->loggedOut($request) ?: redirect()->route('admin.home')->with('success', 'Password Changed Successfully');
        } else {
            return back()->with('error', 'Incorrect Old Password');
        }
    }

    protected function loggedOut(Request $request) {}

    // ckeditor image upload
    public function ckeditorUpload(Request $request)
    {
        // dd($request->all());
        $file = $request->file('upload');
        $file_name = uniqid() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('uploads');
        $file->move($destinationPath, $file_name);
        $url = 'uploads/' . $file_name;
        $msg = 'Image Uploaded Successfully';

        return response()->json(['fileName' => $file_name, 'uploaded' => 1, 'url' => asset($url)]);
    }

    // newsletter
    public function newsletter()
    {
        $data = Subscribe::orderBy('id', 'desc')->paginate(10);

        return view('backEnd.admin.newsletter.index', compact('data'));
    }

    // delete newsletter
    public function newsletterDelete(Request $request)
    {
        Subscribe::where('id', $request->id)->delete();

        return back()->with('success', 'Deleted Successfully');
    }
    //newsletterBulkDelete
    public function newsletterBulkDelete(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:subscribes,id' // আপনার ডাটাবেজ টেবিল নাম দেবেন
        ]);
        try {
            DB::beginTransaction();
            // Perform Bulk Delete
            Subscribe::whereIn('id', $request->ids)->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => count($request->ids) . ' item(s) deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // fraudChecker
    public function fraudChecker($id)
    {
        $order = Order::find($id);
        if (! $order) {
            return back()->with('error', 'Order not found');
        }
        $baseUrl = env('FROODLY_URL');
        $token   = env('FROODLY_TOKEN');
        if (! $baseUrl || ! $token) {
            return back()->with('error', 'Fraud API configuration missing');
        }
        $phone = $order->customer_phone;
        try {
            /* ================= API CALL (Laravel Http Client) ================= */
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
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
            return back()->with('success', 'Courier check completed for Order ID ' . $order->id);
        } catch (\Exception $e) {
            Log::error("Courier check failed for Order ID {$order->id}: " . $e->getMessage());
        }
    }

    // pathaoWebhook
    // public function pathaoWebhook(Request $request)
    // {
    //     // Get RAW JSON
    //     $json = file_get_contents('php://input');
    //     $object = json_decode($json, true);

    //     // Invalid JSON means Pathao will not retry
    //     if (json_last_error() !== JSON_ERROR_NONE) {
    //         return response('Unsupported Media Type', 415);
    //     }

    //     // Step 1: Handle Pathao webhook integration test
    //     if (isset($object['event']) && $object['event'] === 'webhook_integration') {
    //         return response('Accepted', 202)
    //             ->header(
    //                 'X-Pathao-Merchant-Webhook-Integration-Secret',
    //                 'f3992ecc-59da-4cbe-a049-a13da2018d51'
    //             );
    //     }

    //     // Step 2: Process all other events
    //     $pathaoService = new PathaoCourier;
    //     $pathaoService->webhook($object);

    //     // Step 3: Must return 202 for ALL Pathao webhooks
    //     return response('Accepted', 202)
    //         ->header(
    //             'X-Pathao-Merchant-Webhook-Integration-Secret',
    //             'f3992ecc-59da-4cbe-a049-a13da2018d51'
    //         );
    // }

    // public function steadfastWebhook(Request $request)
    // {
    //     // Get RAW JSON
    //     $json = file_get_contents('php://input');
    //     $object = json_decode($json, true);
    //     if (json_last_error() !== JSON_ERROR_NONE) {
    //         exit(header('HTTP/1.0 415 Unsupported Media Type'));
    //     }
    //     $steadfastService = new SteadfastCourier;
    //     $steadfastService->webhook($object);
    // }

    public function redxWebhook(Request $request)
    {

        $token = $request->query('token');
        if ($token !== env('REDX_WEBHOOK_TOKEN')) {
            return response()->json(['error' => 'Invalid token'], 403);
        }
        $json = file_get_contents('php://input');
        $object = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            exit(header('HTTP/1.0 415 Unsupported Media Type'));
        }
        $steadfastService = new RedxCourier;
        $steadfastService->webhook($object);
    }


    public function pathaoWebhook(Request $request)
    {
        $json = file_get_contents('php://input');
        if (empty($json)) {
            return response()->json(['message' => 'Empty request body'], 400);
        }
        $object = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($object)) {
            return response()->json(['message' => 'Invalid JSON payload'], 422);
        }

        log::info('Pathao Webhook Received: ' . json_encode($object));

        if (isset($object['event']) && $object['event'] == 'webhook_integration') {
            $data = [
                'status' => 'accepted',
                'message' => 'Webhook received successfully'
            ];
            return response()->json($data, 202)->header('X-Pathao-Merchant-Webhook-Integration-Secret', 'f3992ecc-59da-4cbe-a049-a13da2018d51');
        }
        try {


            if ($object['event'] == 'order.created') {
                Order::where([['invoice_id', $object['merchant_order_id']]])->update([
                    'courier_status' => 'Order Created',
                    'consignment_id' => $object['consignment_id'],
                    'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
                ]);
            } elseif ($object['event'] == 'order.updated') {
                Order::where([['consignment_id', $object['consignment_id']]])->update([
                    'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                    'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
                ]);
            } elseif ($object['event'] == 'order.pickup-requested') {
                Order::where([['consignment_id', $object['consignment_id']]])->update([
                    'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                    'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
                ]);
            } elseif ($object['event'] == 'order.assigned-for-pickup') {
                Order::where([['consignment_id', $object['consignment_id']]])->update([
                    'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                    'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
                ]);
            } elseif ($object['event'] == 'order.picked') {
                Order::where([['consignment_id', $object['consignment_id']]])->update([
                    'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                    'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
                ]);
            } elseif ($object['event'] == 'order.pickup-failed') {
                Order::where([['consignment_id', $object['consignment_id']]])->update([
                    'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                    'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
                ]);
            } elseif ($object['event'] == 'order.pickup-cancelled') {
                Order::where([['consignment_id', $object['consignment_id']]])->update([
                    'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                    'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
                ]);
            } elseif ($object['event'] == 'order.at-the-sorting-hub') {
                Order::where([['consignment_id', $object['consignment_id']]])->update([
                    'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                    'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
                ]);
            } elseif ($object['event'] == 'order.in-transit') {
                Order::where([['consignment_id', $object['consignment_id']]])->update([
                    'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                    'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
                ]);
            } elseif ($object['event'] == 'order.received-at-last-mile-hub') {
                Order::where([['consignment_id', $object['consignment_id']]])->update([
                    'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                    'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
                ]);
            } elseif ($object['event'] == 'order.assigned-for-delivery') {
                Order::where([['consignment_id', $object['consignment_id']]])->update([
                    'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                    'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
                ]);
            } elseif ($object['event'] == 'order.delivered') {
                $order = Order::where('consignment_id', $object['consignment_id'])->first();
                if ($order) {
                    $order->update([
                        'status'             => 9,
                        'courier_status'     => $object['order_status'] ?? null,
                        'paid' => $object['collected_amount'] ?? 0,
                        'c_collected_amount' => $object['collected_amount'] ?? 0,
                        'due' => 0,
                        'payment_status' => 1,
                        //  'delivered_at'       => Carbon::now(),
                    ]);
                }
            } elseif ($object['event'] == 'order.partial-delivery') {
                $order = Order::where('consignment_id', $object['consignment_id'])->first();
                if ($order) {
                    $order->update([
                        'status'             => 14,
                        'courier_status'     => 'partial-delivery',
                        'courier_reason_msg'     => $object['reason'],
                        'paid' => $object['collected_amount'] ?? 0,
                        'c_collected_amount' => $object['collected_amount'] ?? 0,
                        'due' => 0,
                        'payment_status' => 1,
                        // 'delivered_at'       => Carbon::now(),
                    ]);
                }
            } elseif ($object['event'] == 'order.returned') {
                Order::where([['consignment_id', $object['consignment_id']]])->update([
                    'status' => 11,
                    'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                    'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                ]);
            } elseif ($object['event'] == 'order.delivery-failed') {
                Order::where([['consignment_id', $object['consignment_id']]])->update([
                    'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                    'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                ]);
            } elseif ($object['event'] == 'order.on-hold') {
                Order::where([['consignment_id', $object['consignment_id']]])->update([
                    'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                    'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                ]);
            } elseif ($object['event'] == 'order.paid') {
                $order_id = Order::where([['consignment_id', $object['consignment_id']]])->update([
                    'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                    'courier_reason_msg'     => $object['reason'],
                    'paid' => $object['collected_amount'] ?? 0,
                    'due' => 0,
                    'payment_status' => 1,
                ]);
            } elseif ($object['event'] == 'order.paid-return') {
                $order = Order::where('consignment_id', $object['consignment_id'])->first();
                if ($order) {
                    $order->update([
                        'status'             => 14,
                        'courier_status'     => $object['order_status'] ?? null,
                        'courier_reason_msg'     => $object['reason'],
                        'paid' => $object['collected_amount'] ?? 0,
                        'c_collected_amount' => $object['collected_amount'] ?? 0,
                        'due' => 0,
                        'payment_status' => 1,

                        // 'delivered_at'       => Carbon::now(),
                    ]);
                }
            } elseif ($object['event'] == 'order.exchanged') {
                Order::where([['consignment_id', $object['consignment_id']]])->update([
                    'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                    'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                    'status' => 13,
                ]);
            }
            return response()->json()->header('X-Pathao-Merchant-Webhook-Integration-Secret', 'f3992ecc-59da-4cbe-a049-a13da2018d51');
        } catch (\Exception $e) {
            Log::error("Pathao Webhook Error: " . $e->getMessage());
        }
    }

    public function steadfastWebhook(Request $request)
    {
        $json = file_get_contents('php://input');
        $object = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['message' => 'Invalid JSON'], 415);
        }

        Log::info('Steadfast Webhook Received: ' . json_encode($object));
        try {

            if ($object['notification_type'] == 'delivery_status') {
                $order = Order::where([['consignment_id', $object['consignment_id']], ['invoice_id', $object['invoice']]])->first();
                if ($order) {
                    if ($object['status'] == 'delivered') {

                        $order->update([
                            'courier_status' => array_key_exists('status', $object) ? $object['status'] : null,
                            'status' => 9,
                            'courier_reason_msg' => array_key_exists('tracking_message', $object) ? $object['tracking_message'] : null,
                            // 'delivered_at'       => Carbon::now(),
                            'c_delivery_charge'       => $object['delivery_charge'],
                            'c_target_amount'         => $object['tracking_message'],
                            'c_discount'              => 0,
                            'c_collected_amount'      => $object['cod_amount'],
                            'c_paid_amount'           => $object['cod_amount'] - $object['delivery_charge'],
                            'cod_charge'              => 0,
                            'updated_at'              => now(),
                            'total_delivery_fee'      => $object['delivery_charge'],
                            // 'courier_settlement_done' => 1,
                            // 'courier_settled_at'      => now(),
                        ]);
                    } elseif ($object['status'] == 'partial_delivered') {

                        $order->update([
                            'courier_status' => array_key_exists('status', $object) ? $object['status'] : null,
                            //'status' => 10,
                            'courier_reason_msg' => array_key_exists('tracking_message', $object) ? $object['tracking_message'] : null,
                            // 'delivered_at'          => Carbon::now(),
                            'c_delivery_charge'     => $object['delivery_charge'],
                            'c_target_amount'       => $object['tracking_message'],
                            'c_discount'            => 0,
                            'c_collected_amount'    => $object['cod_amount'],
                            'c_paid_amount'         => $object['cod_amount'],
                            'cod_charge'            => 0,
                            'total_delivery_fee'      => $object['delivery_charge'],
                            // 'courier_settlement_done' => 1,
                            // 'courier_settled_at'      => now(),
                            'updated_at'              => now(),
                        ]);
                    } elseif ($object['status'] == 'cancelled')
                        $order->update([
                            'courier_status' => array_key_exists('status', $object) ? $object['status'] : null,
                            'status' => 11,
                            'courier_reason_msg' => array_key_exists('tracking_message', $object) ? $object['tracking_message'] : null,
                            // 'updated_at'              => now(),
                            //// 'total_delivery_fee' => array_key_exists('delivery_charge', $object) ? $object['delivery_charge'] : null,
                        ]);
                }
            }
            if ($object['notification_type'] == 'tracking_update') {

                $order = Order::where([
                    ['consignment_id', $object['consignment_id']],
                    ['invoice_id', $object['invoice']]
                ])->first();

                if ($order) {
                    $order->update([
                        'courier_status' => array_key_exists('tracking_message', $object)
                            ? $object['tracking_message']
                            : null,
                    ]);
                }
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {

            Log::error("Steadfast Webhook Error [DB: " . ($dbName ?? 'unknown') . "] : " . $e->getMessage());

            return response()->json([
                'success' => false
            ], 500);
        }
    }

    public function carryBeeWebhook(Request $request)
    {
        $json = file_get_contents('php://input');
        //file_put_contents(base_path('callback.txt'), $json);
        $object = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            die(header('HTTP/1.0 415 Unsupported Media Type'));
        }

        //for webhook integration
        if ($object['event'] == 'webhook.integration') {
            $data = [
                'status' => 'accepted',
                'message' => 'Webhook received successfully'
            ];
            return response()->json($data, 202)->header('X-CB-Webhook-Integration-Header', '40489fe0-9386-4fc9-8e92-2b2fcb9d451c');
        }


        if ($object['event'] == 'order.updated') {
            DB::table('orders')->where('consignment_id', $object['consignment_id'])->update([
                'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
            ]);
        } elseif ($object['event'] == 'order.pickup-requested') {
            DB::table('orders')->where('consignment_id', $object['consignment_id'])->update([
                'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
            ]);
        } elseif ($object['event'] == 'order.assigned-for-pickup') {
            DB::table('orders')->where('consignment_id', $object['consignment_id'])->update([
                'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
            ]);
        } elseif ($object['event'] == 'order.picked') {
            DB::table('orders')->where('consignment_id', $object['consignment_id'])->update([
                'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
            ]);
        } elseif ($object['event'] == 'order.pickup-failed') {
            DB::table('orders')->where('consignment_id', $object['consignment_id'])->update([
                'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
            ]);
        } elseif ($object['event'] == 'order.pickup-cancelled') {
            DB::table('orders')->where('consignment_id', $object['consignment_id'])->update([
                'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
            ]);
        } elseif ($object['event'] == 'order.at-the-sorting-hub') {
            DB::table('orders')->where('consignment_id', $object['consignment_id'])->update([
                'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
            ]);
        } elseif ($object['event'] == 'order.on-the-way-to-central-warehouse') {
            DB::table('orders')->where('consignment_id', $object['consignment_id'])->update([
                'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
            ]);
        } elseif ($object['event'] == 'order.at-central-warehouse') {
            DB::table('orders')->where('consignment_id', $object['consignment_id'])->update([
                'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
            ]);
        } elseif ($object['event'] == 'order.in-transit') {
            DB::table('orders')->where('consignment_id', $object['consignment_id'])->update([
                'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
            ]);
        } elseif ($object['event'] == 'order.received-at-last-mile-hub') {
            DB::table('orders')->where('consignment_id', $object['consignment_id'])->update([
                'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
            ]);
        } elseif ($object['event'] == 'order.assigned-for-delivery') {
            DB::table('orders')->where('consignment_id', $object['consignment_id'])->update([
                'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
            ]);
        } elseif ($object['event'] == 'order.delivery-on-hold') {
            DB::table('orders')->where('consignment_id', $object['consignment_id'])->update([
                'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
            ]);
        } elseif ($object['event'] == 'order.delivered') {

            // ১. প্রথমে Sale Model দিয়ে অর্ডারটি ডাটাবেজ থেকে খুঁজে বের করুন
            $order = Order::where('consignment_id', $object['consignment_id'])->first();

            if ($order) {
                // Sale ডাটা আপডেট করুন
                $order->update([
                    'courier_status'        => $object['order_status'] ?? null,
                    'status'                => 9,
                    'courier_reason_msg' => $object['reason'] ?? null,
                    'paid'    => $object['collected_amount'] ?? 0,
                    'c_collected_amount' => $object['collected_amount'] ?? 0,
                    'due'     => 0,
                    // 'delivered_at'       => Carbon::now(),
                ]);
            }
        } elseif ($object['event'] == 'order.partials-delivery') {
            $order = Order::where('consignment_id', $object['consignment_id'])->first();
            if ($order) {
                // Sale ডাটা আপডেট করুন
                $order->update([
                    'courier_status'        => $object['order_status'] ?? null,
                    'status'                => 14,
                    'courier_reason_msg' => $object['reason'] ?? null,
                    'total_delivery_fee'    => $object['delivery_fee'] ?? 0,
                    // 'delivered_at'       => Carbon::now(),
                    'paid'    => $object['collected_amount'] ?? 0,
                    'c_collected_amount' => $object['collected_amount'] ?? 0,
                    'due'     => 0
                ]);
            }
        } elseif ($object['event'] == 'order.delivery-failed') {
            DB::table('orders')->where('consignment_id', $object['consignment_id'])->update([
                'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
            ]);
        } elseif ($object['event'] == 'order.returned') {
            DB::table('orders')->where('consignment_id', $object['consignment_id'])->update([
                'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                'status' => 11,
                'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
            ]);
        } elseif ($object['event'] == 'order.paid-return') {
            $order = Order::where('consignment_id', $object['consignment_id'])->first();
            if ($order) {
                // Sale ডাটা আপডেট করুন
                $order->update([
                    'courier_status'        => $object['order_status'] ?? null,
                    'status'                => 14,
                    'courier_reason_msg' => $object['reason'] ?? null,
                    'total_delivery_fee'    => $object['delivery_fee'] ?? 0,
                    // 'delivered_at'       => Carbon::now(),
                    'paid'    => $object['collected_amount'] ?? 0,
                    'c_collected_amount' => $object['collected_amount'] ?? 0,
                    'due'     => 0
                ]);
            }
        } elseif ($object['event'] == 'order.exchange') {
            DB::table('orders')->where('consignment_id', $object['consignment_id'])->update([
                'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                'status' => 13,
                'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
            ]);
        } elseif ($object['event'] == 'order.paid') {
            DB::table('orders')->where('consignment_id', $object['consignment_id'])->update([
                'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
            ]);
        } elseif ($object['event'] == 'order.returned-at-sorting') {
            DB::table('orders')->where('consignment_id', $object['consignment_id'])->update([
                'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
            ]);
        } elseif ($object['event'] == 'order.returned-to-merchant') {
            DB::table('orders')->where('consignment_id', $object['consignment_id'])->update([
                'courier_status' => array_key_exists('order_status', $object) ? $object['order_status'] : null,
                'courier_reason_msg' => array_key_exists('reason', $object) ? $object['reason'] : null,
                'total_delivery_fee' => array_key_exists('delivery_fee', $object) ?? $object['delivery_fee'],
            ]);
        }

        //62gb0TjPkKaNsbF9MNWZoR7
        return response()->json()
            ->header('X-BEE-Signature', 'qts6wiriqasgd')
            ->header('Accept', 'application/json')
            ->header('Content-Type', 'application/json')
            ->header('Content-Length', 185);
    }

    //courierInfo
    public function courierInfo()
    {
        // স্ট্যাটাস Delivered, consignment_id আছে এবং settlement করা হয়নি এমন সেলস ফিল্টার করা
        $orders = Order::with('get_courier')
            ->whereNotNull('consignment_id')
            ->whereIn('status', [9, 14])
            ->get();

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No orders found'], 404);
        }

        foreach ($orders as $order) {
            if ($order->payment_status != 1 && $order->courier_id != 1) {
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

                // c_paid_amount = c_collected_amount - total_delivery_fee
                $cPaidAmount      = $cCollectedAmount - $cDeliveryFee;
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
                    'payment_status'          => $paymentStatus,
                    'updated_at'              => now(),
                ]);
            } catch (\Throwable $e) {
                Log::error("CourierInfo Error: " . $e->getMessage());
            }
        }

        // return response()->json([
        //     'success' => true,
        //     'info' => CourierService::fetchDetails($order)
        // ]);
    }
}
