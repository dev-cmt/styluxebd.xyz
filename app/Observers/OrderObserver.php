<?php
// path: app/Observers/OrderObserver.php

namespace App\Observers;

use App\Admin;
use App\Order;
use App\Services\OrderActivityLogger;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderObserver
{
    protected static array $trackedFields = [
        'order_date',
        'theme_id',
        'invoice_id',
        'ip_address',
        'device_id',
        'memo_number',
        'customer_activity',
        'customer_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
        'courier_id',
        'courier_city_id',
        'courier_zone_id',
        'payment_method',
        'shipping_method',
        'shipping_cost',
        'discount',
        'sub_total',
        'total',
        'paid',
        'due',
        'status',
        'customer_note',
        'staff_note',
        'payment_status',
        'source',
        'consignment_id',
        'courier_status',
        'courier_reason_msg',
        'courier_error_msg',
        'tracking_id',
        'coupon_code',
        'coupon_discount',
        'coupon_applied_on',
    ];

    protected static array $statusMap = [
        1 => 'pending',
        2 => 'confirm',
        3 => 'processing',
        4 => 'hold',
        5 => 'printed',
        6 => 'packaging',
        7 => 'courier_entry',
        8 => 'on_delivery',
        9 => 'delivered',
        10 => 'cancelled',
        11 => 'returned',
    ];

    protected static array $paymentStatusMap = [
        0 => 'unpaid',
        1 => 'paid',
        2 => 'partial',
    ];

    // static array-তে কুরিয়ার লিস্ট ক্যাশ রাখা হবে যাতে বারবার DB Query না চলে
    protected static array $courierCache = [];
    protected static array $shippingMethodCache = [];

    /**
     * Fast Helper to get Courier Name without extra queries
     */
    protected function getCourierName($id)
    {
        if (!$id) {
            return '';
        }

        // রিকোয়েস্ট লাইফসাইকেলে একবার ক্যাশ হলে আর DB Query চলবে না
        if (!isset(static::$courierCache[$id])) {
            static::$courierCache[$id] = DB::table('couriers')
                ->where('id', $id)
                ->value('courier_name') ?? 'Unknown';
        }

        return static::$courierCache[$id];
    }

    protected function getShippingMethodName($id)
    {
        if (!$id) {
            return '';
        }

        // রিকোয়েস্ট লাইফসাইকেলে একবার ক্যাশ হলে আর DB Query চলবে না
        if (!isset(static::$shippingMethodCache[$id])) {
            static::$shippingMethodCache[$id] = DB::table('shipping_methods')
                ->where('id', $id)
                ->value('type') ?? 'Unknown';
        }

        return static::$shippingMethodCache[$id];
    }



    public function created(Order $order)
    {
        $causerType = null;
        $causerId   = null;
        $text       = 'অর্ডার তৈরি হয়েছে';

        if (Auth::guard('admin')->check()) {
            $causerType = Admin::class;
            $causerId   = Auth::guard('admin')->id();
            $text       = 'Admin created the order';
        } elseif ($order->customer_id) {
            $causerType = User::class;
            $causerId   = $order->customer_id;
            $text       = 'Customer placed order from website';
        }


        OrderActivityLogger::log($order->id, 'created', [
            'text'        => $text,
            'causer_type' => $causerType,
            'causer_id'   => $causerId,
        ]);
    }

    public function updated(Order $order)
    {
        foreach (static::$trackedFields as $field) {
            if (! $order->isDirty($field)) {
                continue;
            }

            $oldValue = $order->getOriginal($field);
            $newValue = $order->getAttribute($field);

            $formattedOld = $oldValue ?? ' ';
            $formattedNew = $newValue ?? ' ';

            // Status Mapping
            if ($field === 'status') {
                $formattedOld = static::$statusMap[(int) $oldValue] ?? $formattedOld;
                $formattedNew = static::$statusMap[(int) $newValue] ?? $formattedNew;
            }

            // Payment Status Mapping
            if ($field === 'payment_status') {
                $formattedOld = static::$paymentStatusMap[(int) $oldValue] ?? $formattedOld;
                $formattedNew = static::$paymentStatusMap[(int) $newValue] ?? $formattedNew;
            }

            // High-Performance Courier Name Mapping
            if ($field === 'courier_id') {
                $formattedOld = $this->getCourierName($oldValue);
                $formattedNew = $this->getCourierName($newValue);
            }

            // Shipping Method Name Mapping
            if ($field === 'shipping_method') {
                $formattedOld = $this->getShippingMethodName($oldValue);
                $formattedNew = $this->getShippingMethodName($newValue);
            }
            OrderActivityLogger::log($order->id, 'updated', [
                'field'     => $field,
                'old_value' => $formattedOld,
                'new_value' => $formattedNew,
                'text'      => sprintf('%s পরিবর্তন হয়েছে: %s → %s', $field, $formattedOld, $formattedNew),
            ]);
        }
    }

    public function deleted(Order $order)
    {
        OrderActivityLogger::log($order->id, 'deleted', [
            'text' => 'অর্ডার ডিলিট হয়েছে',
        ]);
    }
}
