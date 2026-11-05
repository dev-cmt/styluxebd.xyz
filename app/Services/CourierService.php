<?php

namespace App\Services;

use App\ApiCourier;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use function Symfony\Component\Finder\ignoreDotFiles;

class CourierService
{
    public static function fetchDetails($order)
    {
        // Log::info("CourierService fetchDetails called for Order ID: " . ($order->id ?? 'N/A'), [
        //     'courier_id' => $order->courier_id ?? null,
        //     'consignment_id' => $order->consignment_id ?? null
        // ]);

        $courierId = $order->courier_id ?? null;
        $consignmentId = $order->consignment_id ?? null;

        if (empty($courierId) || empty($consignmentId)) {
            // Log::warning("CourierService: Missing courier_id or consignment_id for Order ID: " . ($order->id ?? 'N/A'));
            return null;
        }

        switch (strtolower(trim($courierId))) {
            case 2:
                $pathaoIsActive = ApiCourier::where('courier_name', 'pathao')->first();
                // dd($pathaoIsActive);
                $credential = $pathaoIsActive->config ?? [];
                if ($pathaoIsActive->status == 1 && !empty($credential)) {
                    return self::getPathaoDetails($consignmentId, $order, $credential);
                } else {
                    // Log::warning("CourierService: Pathao is inactive for Order ID: " . $order->id);
                    return null;
                }

            case 1:
                return null;

            case 3:
                $redxIsActive = ApiCourier::where('courier_name', 'redx')->first();
                $credential = $redxIsActive->config ?? [];
                if ($redxIsActive->status == 1 && !empty($credential)) {
                    return self::getRedxDetails($consignmentId, $order, $credential);
                } else {
                    // Log::warning("CourierService: RedX is inactive for Order ID: " . $order->id);
                    return null;
                }

            case 4:
                $carrybeeIsActive = ApiCourier::where('courier_name', 'carrybee')->first();
                $credential = $carrybeeIsActive->config ?? [];
                if ($carrybeeIsActive->status == 1 && !empty($credential)) {
                    return self::getCarrybeeDetails($consignmentId, $order, $credential);
                } else {
                    // Log::warning("CourierService: CarryBee is inactive for Sale ID: " . $order->id);
                    return null;
                }

            default:
                // Log::warning("CourierService: Unsupported courier [{$courierId}] for Sale ID: " . ($order->id ?? 'N/A'));
                return null;
        }
    }
    private static function getSteadfastDetails($consignmentId, $order)
    {
        $store = $order->get_store;
        try {
            $store = $order->get_store;
            $baseUrl = 'https://portal.packzy.com/api/v1/status_by_invoice/' . $consignmentId;
            $response = Http::withHeaders([
                'Api-Key'    => $store->steadfast_api_key,
                'Secret-Key' => $store->setadfast_secret_key,
                'Content-Type' => 'application/json'
            ])->get($baseUrl . "/v1/status_by_cid/{$consignmentId}");

            if ($response->successful()) {
                $data = $response->json()['delivery_status'] ?? [];
                return [
                    'target_amount'    => $data['cod_amount'] ?? 0,
                    'delivery_charge'  => $data['delivery_charge'] ?? 0,
                    'cod_charge'       => $data['cod_charge'] ?? 0,
                    'discount'         => $data['discount'] ?? 0,
                    'collected_amount' => $data['collected_amount'] ?? 0,
                    'payment_status'   => $data['status'] ?? 'paid',
                ];
            }
        } catch (\Throwable $e) {
            Log::error("CourierService Steadfast Error [CID: {$consignmentId}]: " . $e->getMessage());
        }

        return null;
    }
    private static function getPathaoDetails($consignmentId, $order, $credential)
    {
        //  dd($credential);
        try {
            $accessToken  = $credential['access_token'];
            // dd($accessToken);
            $baseUrl = 'https://api-hermes.pathao.com';
            $response = Http::withToken($accessToken)->get($baseUrl . "/aladdin/api/v1/orders/{$consignmentId}");
            // dd($response->body());

            if ($response->successful()) {
                $data = $response->json()['data'] ?? [];
                //    dd($data);
                // ЁЯЫая╕П рж╕рзЗржлржЯрж┐ ржЪрзЗржХ: ржЕржмржЬрзЗржХрзНржЯ ржмрж╛ ржЖржЗржбрж┐ ржкрзНрж░рж┐ржирзНржЯ ржХрж░рж╛рж░ ржЬржирзНржп
                // Log::info("Pathao Sale ID: " . ($order->id ?? 'N/A'), [
                //     'pathao' => $data,
                // ]);

                $apiStatus = strtolower(trim($data['order_status'] ?? ''));
                if (in_array($apiStatus, ['Partial Delivery', 'Paid Return'])) {
                    $paymentStatus = 2;
                } elseif (in_array($apiStatus, ['Delivered'])) {
                    $paymentStatus = $data['billing_status'] == 'Paid' ? 1 : 0;
                } elseif (in_array($apiStatus, ['Return'])) {
                    $paymentStatus = 0;
                } else {
                    $paymentStatus = 0;
                }

                return [
                    'target_amount'    => $data['order_amount'] ?? 0,
                    'delivery_charge'  => $data['delivery_fee'] ?? 0,
                    'cod_charge'       => $data['cod_fee'] ?? 0,
                    'discount'         => $data['discount'] ?? 0,
                    'collected_amount' => $order->c_collected_amount ?? 0,
                    'payment_status'   => $paymentStatus,
                ];
            }
        } catch (\Throwable $e) {
            Log::error("CourierService Pathao Error [CID: {$consignmentId}]: " . $e->getMessage());
        }

        return null;
    }
    private static function getRedxDetails($consignmentId, $order, $credential)
    {
        try {
            $store = $order->get_store ?? null;
            $baseUrl = "https://developers.carrybee.com/api/v2/orders/" . $consignmentId . "/details'";
            $response = Http::withToken($store->redx_api_token)->get($baseUrl);

            if ($response->successful()) {
                $data = $response->json()['parcel'] ?? [];
                /*if ($data['payment_status'] == 'paid'){
                    $paymentStatus = 1;
                }
                elseif ($data['payment_status'] == 'processing'){
                    $paymentStatus = 2;
                }
                else{
                    $paymentStatus = 0;
                }*/
                return [
                    'target_amount'    => $data['cash_collection_amount'] ?? 0,
                    'delivery_charge'  => $data['charge'] ?? 0,
                    'cod_charge'       => 0, // Not present in the response
                    'discount'         => 0,
                    'collected_amount' => $data['cash_collection_amount'] ?? 0, // Adjust if your logic tracks partial collection differently
                    'payment_status'   => 1,
                ];
            }
        } catch (\Throwable $e) {
            Log::error("CourierService RedX Error [CID: {$consignmentId}]: " . $e->getMessage());
        }

        return null;
    }
    private static function getCarrybeeDetails($consignmentId, $order, $credential)
    {
        try {
            // Store Relationship Check
            $clientId =  $credential['client_id'] ?? null;
            $clientSecret =  $credential['client_secret'] ?? null;
            $clientContext =  $credential['client_context'] ?? null;
            $baseUrl = "https://developers.carrybee.com/api/v2/orders/" . $consignmentId . "/details";
            if (empty($clientId) || empty($clientSecret) || empty($clientContext)) {

                Log::warning("CourierService Carrybee Warning: Store details not found for Sale ID {$order->id}");
                return null;
            }

            // Send API Request with required Carrybee headers
            $response = Http::withHeaders([
                'Content-Type'   => 'application/json',
                'Client-ID'      =>  $clientId,
                'Client-Secret'  => $clientSecret,
                'Client-Context' => $clientContext,
            ])->get($baseUrl);

            if ($response->successful()) {
                $responseData = $response->json();
                $data = $responseData['data'] ?? $responseData;
                if ($data['payment_status'] == 'paid') {
                    $paymentStatus = 1;
                } elseif ($data['payment_status'] == 'processing') {
                    $paymentStatus = 2;
                } else {
                    $paymentStatus = 0;
                }
                return [
                    'target_amount'    => $data['collectable_amount'] ?? 0,
                    'delivery_charge'  => $data['delivery_fee'] ?? 0,
                    'cod_charge'       => $data['cod_fee'] ?? 0,
                    'discount'         => 0,
                    'collected_amount' => $data['collected_amount'] ?? 0,
                    'payment_status'   => $paymentStatus,
                ];
            } else {
                Log::error("CourierService Carrybee API Failed [CID: {$consignmentId}]: " . $response->body());
            }
        } catch (\Throwable $e) {
            Log::error("CourierService Carrybee Exception [CID: {$consignmentId}]: " . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }

        return null;
    }
    public static function checkOrderStatus($order)
    {
        $courierId = $order->courier_id;
        $consignmentId = $order->consignment_id;
        $store = $order->get_store ?? null;

        if (empty($courierId) || empty($consignmentId) || !$store) {
            return null;
        }

        try {
            switch (strtolower(trim($courierId))) {
                case 1: // Pathao
                    if (($store->pathao_is_active ?? 0) == 1) {
                        $response = Http::withToken($store->pathao_access_token)->get(env('PATHAO_BASE_URL') . "/v1/orders/{$consignmentId}");

                        if ($response->successful()) {
                            $data = $response->json()['data'] ?? [];
                            $apiStatus = strtolower(trim($data['order_status'] ?? ''));

                            if (in_array($apiStatus, ['partial delivery', 'paid return'])) {
                                return 10;
                            } elseif (in_array($apiStatus, ['delivered'])) {
                                return 9;
                            } elseif (in_array($apiStatus, ['return', 'cancelled'])) {
                                return 11;
                            }
                        }
                    }
                    break;

                case 2: // Steadfast
                    $response = Http::withHeaders([
                        'Api-Key'      => $store->steadfast_api_key,
                        'Secret-Key'   => $store->setadfast_secret_key,
                        'Content-Type' => 'application/json'
                    ])->get(env('STEADFAST_BASE_URL') . "/v1/status_by_cid/{$consignmentId}");

                    if ($response->successful()) {
                        $resData = $response->json() ?? [];
                        $data = $resData['consignment'] ?? $resData;
                        $apiStatus = strtolower(trim($data['delivery_status'] ?? ''));

                        if (in_array($apiStatus, ['partial_delivered'])) {
                            return 10;
                        } elseif (in_array($apiStatus, ['delivered'])) {
                            return 9;
                        } elseif (in_array($apiStatus, ['cancelled', 'returned'])) {
                            return 11;
                        }
                    }
                    break;

                case 3: // RedX
                    $response = Http::withToken($store->redx_api_token)
                        ->get(env('REDX_BASE_URL') . "/parcel/info/{$consignmentId}");

                    if ($response->successful()) {
                        $data = $response->json()['parcel'] ?? [];
                        $apiStatus = strtolower(trim($data['status'] ?? ''));

                        if (in_array($apiStatus, ['partial-delivered', 'paid-returned'])) {
                            return 10;
                        } elseif (in_array($apiStatus, ['delivered'])) {
                            return 9;
                        } elseif (in_array($apiStatus, ['returned'])) {
                            return 11;
                        }
                    }
                    break;

                case 5: // CarryBee
                    $response = Http::withHeaders([
                        'Content-Type'   => 'application/json',
                        'Client-ID'      => $store->carrybee_client_id,
                        'Client-Secret'  => $store->carrybee_client_secret,
                        'Client-Context' => $store->carrybee_client_context,
                    ])->get(env('CARRYBEE_BASE_URL') . "/v2/orders/{$consignmentId}/details");

                    if ($response->successful()) {
                        $responseData = $response->json();
                        $data = $responseData['data'] ?? $responseData;
                        $apiStatus = strtolower(trim($data['transfer_status'] ?? ''));

                        if (in_array($apiStatus, ['partial_delivery', 'paid_return'])) {
                            return 10;
                        } elseif (in_array($apiStatus, ['delivered'])) {
                            return 9;
                        } elseif (in_array($apiStatus, ['return'])) {
                            return 11;
                        }
                    }
                    break;
            }
        } catch (\Throwable $e) {
            Log::error("CourierService checkOrderStatus Error [Courier: {$courierId}, CID: {$consignmentId}]: " . $e->getMessage());
        }

        return null;
    }
}
