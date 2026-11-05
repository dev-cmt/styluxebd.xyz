<?php

namespace App\Services\Pixel;

use App\ConversionApi;

class ConversionApiService
{
    public static function getConversionApi($event_name, $event_id, $user_data = [], $custom_data = [])
    {
        $credentails = ConversionApi::where('name', 'facebook')->first();
        //dd($credentails);
        $access_token = $credentails->data['fb_access_token'] ?? null;
        $pixel_id = $credentails->data['fb_pixel_id'] ?? null;
        $url = "https://graph.facebook.com/v17.0/$pixel_id/events?access_token=$access_token";
        //dd($url);
        $payload = [
            'data' => [
                [
                    'event_name' => $event_name,
                    'event_time' => time(),
                    'event_id' => $event_id,
                    'user_data' => $user_data,   // hashed email, phone etc.
                    'custom_data' => $custom_data,
                    'action_source' => 'website'
                ]
            ],
            //'test_event_code' => 'TEST85277'
        ];
        //dd($payload);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        // dd($response);
        return $response;
    }
}
