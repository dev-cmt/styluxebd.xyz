<?php

namespace App\Http\Controllers;

use App\ApiCourier;
use App\Services\Courier\PathaoCourier;
use Illuminate\Http\Request;

class ApiCourierController extends Controller
{
    // Single Unified Index Page for All Couriers
    public function index()
    {
        $couriers = ApiCourier::whereIn('courier_name', ['pathao', 'steadfast', 'redx', 'carrybee'])
            ->get()
            ->keyBy('courier_name');

        $pathao    = $couriers->get('pathao');
        $steadfast = $couriers->get('steadfast');
        $redx      = $couriers->get('redx');
        $carrybee  = $couriers->get('carrybee');

        return view('backEnd.admin.api-courier.index', compact('pathao', 'steadfast', 'redx', 'carrybee'));
    }

    // Individual Update Methods
    public function pathaoUpdate(Request $request)
    {
        $pathao = ApiCourier::firstOrNew(['courier_name' => 'pathao']);
        $newConfig = $request->only(['store_id', 'client_id', 'client_secret']);
        $config = array_merge($pathao->config ?? [], $newConfig);
        $otherData = $request->only(['base_url', 'username', 'password']);
        $otherData['status'] = $request->has('status') ? 1 : 0;

        ApiCourier::updateOrCreate(
            ['courier_name' => 'pathao'],
            array_merge(['config' => $config], $otherData)
        );

        return back()->with('success', 'Pathao settings updated successfully');
    }

    public function steadfastUpdate(Request $request)
    {
        $steadfast = ApiCourier::firstOrNew(['courier_name' => 'steadfast']);
        $newConfig = $request->only(['api_key', 'secret_key']);
        $config = array_merge($steadfast->config ?? [], $newConfig);
        $otherData = $request->only(['base_url', 'username', 'password']);
        $otherData['status'] = $request->has('status') ? 1 : 0;

        ApiCourier::updateOrCreate(
            ['courier_name' => 'steadfast'],
            array_merge(['config' => $config], $otherData)
        );

        return back()->with('success', 'Steadfast settings updated successfully');
    }

    public function redxUpdate(Request $request)
    {
        $redx = ApiCourier::firstOrNew(['courier_name' => 'redx']);
        $newConfig = $request->only(['api_token']);
        $config = array_merge($redx->config ?? [], $newConfig);
        $otherData = $request->only(['base_url', 'username', 'password']);
        $otherData['status'] = $request->has('status') ? 1 : 0;

        ApiCourier::updateOrCreate(
            ['courier_name' => 'redx'],
            array_merge(['config' => $config], $otherData)
        );

        return back()->with('success', 'Redx settings updated successfully');
    }

    public function carrybeeUpdate(Request $request)
    {
        $carrybee = ApiCourier::firstOrNew(['courier_name' => 'carrybee']);
        $newConfig = $request->only(['store_id', 'client_id', 'client_secret', 'client_context']);
        $config = array_merge($carrybee->config ?? [], $newConfig);
        $otherData = $request->only(['base_url', 'username', 'password']);
        $otherData['status'] = $request->has('status') ? 1 : 0;

        ApiCourier::updateOrCreate(
            ['courier_name' => 'carrybee'],
            array_merge(['config' => $config], $otherData)
        );

        return back()->with('success', 'Carrybee settings updated successfully');
    }

    public function pathaoGenerate(Request $request)
    {
        $pathao = ApiCourier::where('courier_name', 'pathao')->first();
        if ($pathao && $pathao->status == 1) {
            $courier = new PathaoCourier;
            $access_token = $courier->generateApiKey(['data' => $pathao]);

            if (isset($access_token['refresh_token']) && isset($access_token['access_token'])) {
                $config = $pathao->config ?? [];
                $config['access_token'] = $access_token['access_token'];
                $config['refresh_token'] = $access_token['refresh_token'];
                $pathao->update(['config' => $config]);

                return back()->with('success', 'New Access Token Generated Successfully');
            } else {
                return back()->with('error', 'Something went wrong');
            }
        } else {
            return back()->with('error', 'Pathao Courier is disabled');
        }
    }
}
