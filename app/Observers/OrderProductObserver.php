<?php
// path: app/Observers/OrderProductObserver.php

namespace App\Observers;

use App\OrderProduct;
use App\Services\OrderActivityLogger;

class OrderProductObserver
{
    /**
     * যে ফিল্ডগুলোর পরিবর্তন ট্র্যাক করা হবে।
     */
    protected static array $trackedFields = [
        'qty',
        'price',
        'purchase_price',
        'attributes',
        'product_sku',
        'discount',
    ];

    public function created(OrderProduct $orderProduct)
    {
        $productName = $orderProduct->get_product->name ?? ('Product #' . $orderProduct->product_id);

        OrderActivityLogger::log($orderProduct->order_id, 'product_added', [
            'field'     => 'product',
            'new_value' => $productName . ' (qty: ' . $orderProduct->qty . ')',
            'text'      => sprintf('"%s" (qty: %s) অর্ডারে যুক্ত হয়েছে', $productName, $orderProduct->qty),
        ]);
    }

    public function updated(OrderProduct $orderProduct)
    {
        $productName = $orderProduct->get_product->name ?? ('Product #' . $orderProduct->product_id);

        foreach (static::$trackedFields as $field) {
            // যদি এই ফিল্ডে কোনো পরিবর্তন না আসে, তবে পরের ফিল্ডে চলে যাবে
            if (! $orderProduct->isDirty($field)) {
                continue;
            }

            $oldValue = $orderProduct->getOriginal($field);
            $newValue = $orderProduct->getAttribute($field);

            $activityType = ($field === 'qty') ? 'qty_changed' : $field . '_changed';
            $fieldLabel = str_replace('_', ' ', $field);

            OrderActivityLogger::log($orderProduct->order_id, $activityType, [
                'field'     => $field,
                'old_value' => $oldValue,
                'new_value' => $newValue,
                'text'      => sprintf(
                    '"%s" এর %s পরিবর্তন হয়েছে: %s → %s',
                    $productName,
                    $fieldLabel,
                    $oldValue ?? 'null',
                    $newValue ?? 'null'
                ),
            ]);
        }
    }

    public function deleted(OrderProduct $orderProduct)
    {
        $productName = $orderProduct->get_product->name ?? ('Product #' . $orderProduct->product_id);

        OrderActivityLogger::log($orderProduct->order_id, 'product_removed', [
            'field'     => 'product',
            'old_value' => $productName . ' (qty: ' . $orderProduct->qty . ')',
            'text'      => sprintf('"%s" অর্ডার থেকে রিমুভ হয়েছে', $productName),
        ]);
    }
}
