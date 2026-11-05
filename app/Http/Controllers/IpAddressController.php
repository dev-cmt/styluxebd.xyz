<?php

namespace App\Http\Controllers;

use App\IpAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IpAddressController extends Controller
{
    // index
    public function index(Request $request)
    {
        // dd($request->all());
        $perPage = $request->get('per_page', 20);
        $query = IpAddress::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ip_address', 'like', "%{$search}%");
            });
        }

        // Pagination-এর সাথে query parameters (search, per_page) ধরে রাখা
        $data = $query->paginate($perPage)->appends($request->all());
        if ($request->ajax()) {
            return response()->json([
                'html' => view('backEnd.admin.ip-address.partials.table', compact('data'))->render(),
                'total' => $data->total(),
            ]);
        }

        return view('backEnd.admin.ip-address.index', compact('data'));
    }

    public function delete($id)
    {
        IpAddress::find($id)->delete();

        return back()->with('success', 'IP Address delete Successfully');
    }

    public function status($id)
    {
        $data = IpAddress::find($id);
        $data->status = $data->status == 1 ? 0 : 1;
        $data->save();

        return back()->with('success', 'Status Change Successfully');
    }
    public function bulkDelete(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:ip_addresses,id' // আপনার ডাটাবেজ টেবিল নাম দেবেন
        ]);
        try {
            DB::beginTransaction();
            // Perform Bulk Delete
            IpAddress::whereIn('id', $request->ids)->delete();
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
}
