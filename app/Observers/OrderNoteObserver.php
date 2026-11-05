<?php
// path: app/Observers/OrderNoteObserver.php

namespace App\Observers;

use App\OrderNote;
use App\Services\OrderActivityLogger;

class OrderNoteObserver
{
    public function created(OrderNote $orderNote)
    {
        // কলামের নাম আপনার টেবিলে ভিন্ন হলে (যেমন 'body', 'content') এখানে পরিবর্তন করে নিন
        OrderActivityLogger::log($orderNote->order_id, 'note_added', [
            'field'   => 'note',
            'text'    => 'একটি নতুন নোট যুক্ত হয়েছে',
            'new_value' => $orderNote->note,
        ]);
    }
}
