<?php
// path: app/Services/OrderActivityLogger.php

namespace App\Services;

use App\Admin;
use App\OrderActivity;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Throwable;

/**
 * সব Observer এই একটাই static log() method কল করবে।
 * ডুপ্লিকেট logic (causer resolve, afterCommit wrap, error handling) এখানে একবারই লেখা আছে।
 */
class OrderActivityLogger
{

    protected static $batchUuid = null;

    public static function log(int $orderId, string $activityType, array $attributes = [])
    {
        try {
            // causer এবং request-নির্ভর তথ্য এখনই resolve করে রাখা হচ্ছে
            [$causerType, $causerId] = static::resolveCauser();

            // যদি attributes থেকে সরাসরি causer পাস করা হয়
            if (isset($attributes['causer_type']) && isset($attributes['causer_id'])) {
                $causerType = $attributes['causer_type'];
                $causerId   = $attributes['causer_id'];
            }

            $payload = [
                'order_id'      => $orderId,
                'causer_type'   => $causerType,
                'causer_id'     => $causerId,
                'activity_type' => $activityType,
                'field'         => $attributes['field'] ?? null,
                'old_value'     => static::stringify($attributes['old_value'] ?? null),
                'new_value'     => static::stringify($attributes['new_value'] ?? null),
                'text'          => $attributes['text'] ?? null,
            ];

            // Laravel 7 Compatibility: সরাসরি ডাটাবেজে রেকর্ড ইনসার্ট করা হচ্ছে
            OrderActivity::create($payload);
        } catch (Throwable $e) {
            Log::error('OrderActivityLogger: failed to schedule activity log', [
                'error'          => $e->getMessage(),
                'order_id'       => $orderId,
                'activity_type'  => $activityType,
            ]);
        }
    }

    /**
     * কে করল সেটা resolve করা হবে — Admin guard, User guard, বা console/system।
     */
    protected static function resolveCauser()
    {
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();

            return [Admin::class, $admin->getKey()];
        }

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            return [User::class, $user->getKey()];
        }

        return [null, null];
    }

    protected static function resolveIp()
    {
        if (app()->runningInConsole()) {
            return null;
        }

        try {
            return Request::ip();
        } catch (Throwable $e) {
            return null;
        }
    }

    /**
     * array/object হলে JSON বানিয়ে string করে রাখা হবে।
     */
    protected static function stringify($value)
    {
        if (is_null($value)) {
            return null;
        }

        if (is_array($value) || is_object($value)) {
            return json_encode($value, JSON_UNESCAPED_UNICODE);
        }

        return (string) $value;
    }
}
