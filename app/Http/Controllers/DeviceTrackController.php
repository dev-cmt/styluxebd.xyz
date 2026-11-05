<?php

namespace App\Http\Controllers;

use App\DeviceTrack;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DeviceTrackController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $query = DeviceTrack::with('user');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('device_name', 'like', "%{$search}%")
                    ->orWhere('device_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        // Pagination-এর সাথে query parameters (search, per_page) ধরে রাখা
        $data = $query->paginate($perPage)->appends($request->all());

        if ($request->ajax()) {
            return response()->json([
                'html' => view('backEnd.admin.device.partials.table', compact('data'))->render(),
                'total' => $data->total(),
            ]);
        }

        return view('backEnd.admin.device.index', compact('data'));
    }

    public function status($id, $status)
    {
        DeviceTrack::findOrFail($id)->update(['status' => $status]);

        return back()->with('success', 'Customer status updated successfully.');
    }

    public function bulkDelete(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:device_tracks,id' // আপনার ডাটাবেজ টেবিল নাম দেবেন
        ]);
        try {
            DB::beginTransaction();
            // Perform Bulk Delete
            DeviceTrack::whereIn('id', $request->ids)->delete();
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
