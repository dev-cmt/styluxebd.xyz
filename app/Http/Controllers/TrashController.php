<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderActivity;
use App\OrderAssign;
use App\OrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrashController extends Controller
{
    // index method
    public function orderTrash(Request $request)
    {
        // dd($request->all());
        $phone = $request->input('search');
        $source = $request->input('source');
        $daterange = '';
        $data['orders'] = Order::query();
        if ($phone) {
            $data['orders'] = $data['orders']->where('customer_phone', 'like', '%' . $phone . '%');
        }
        if ($source) {
            $data['orders'] = $data['orders']->where('source', $source);
        }

        if ($request->start_date && $request->end_date) {
            $start = Carbon::parse($request->start_date)->startOfDay()->format('Y-m-d H:i:s');
            $end = Carbon::parse($request->end_date)->endOfDay()->format('Y-m-d H:i:s');

            $data['orders'] = $data['orders']->whereBetween('created_at', [$start, $end]);
            $daterange = date('d/m/Y', strtotime($request->start_date)) . ' - ' . date('d/m/Y', strtotime($request->end_date));
        }

        $orders = $data['orders']->with('get_products')->onlyTrashed()->latest()->paginate(10);

        // dd($orders);
        return view('backEnd.admin.trash.order-trash', compact('orders', 'daterange'));
    }

    public function restore($id)
    {
        $order = Order::withTrashed()->find($id);
        if ($order) {
            $order->restore();
            // order activity
            OrderActivity::create([
                'order_id' => $id,
                'user_type' => Auth::guard('admin')->user()->role,
                'created_by' => Auth::guard('admin')->user()->id,
                'activity_type' => 3,
                'text' => 'Order Restored by ' . Auth::guard('admin')->user()->name . ' (' . Auth::guard('admin')->user()->role . ')',
            ]);

            return back()->with('success', 'Order restored successfully');
        }
    }

    public function forceDelete($id)
    {
        $order = Order::withTrashed()->find($id);

        if ($order->status == 9) {
            return back()->with('warning', 'Completed Order Can\'t Be Deleted!');
        } else {
            if ($order) {
                OrderProduct::where('order_id', $id)->delete();
                OrderAssign::where('order_id', $id)->delete();
                $order->forceDelete();

                return back()->with('success', 'Order deleted successfully');
            }
        }
    }

    public function bulkAction(Request $request)
    {
        // রিস্টোর অথবা ডিলিট যেটাই হোক তার সঠিক ইনপুট ধরবে
        $ids = $request->input('all_restore_id') ?? $request->input('all_delete_id');

        if (!is_array($ids)) {
            $ids = explode(',', $ids);
        }

        if (empty($ids) || count($ids) <= 0 || $ids[0] == '') {
            return back()->with('error', 'Please select at least one row.');
        }

        $action = $request->input('status_delete');

        if ($action === 'restore') {
            foreach ($ids as $id) {
                $order = Order::withTrashed()->find($id);
                if ($order) {
                    $order->restore();

                    // Order Activity Log
                    OrderActivity::create([
                        'order_id' => $id,
                        'user_type' => Auth::guard('admin')->user()->role ?? 'admin',
                        'created_by' => Auth::guard('admin')->user()->id ?? 1,
                        'activity_type' => 3,
                        'text' => 'Order Restored by ' . (Auth::guard('admin')->user()->name ?? 'Admin'),
                    ]);
                }
            }
            return back()->with('success', 'Selected orders restored successfully.');
        } elseif ($action === 'delete') {
            foreach ($ids as $id) {
                $order = Order::withTrashed()->find($id);

                if ($order && $order->status != 9) {
                    OrderProduct::where('order_id', $id)->delete();
                    OrderAssign::where('order_id', $id)->delete();
                    $order->forceDelete();
                }
            }
            return back()->with('success', 'Selected orders deleted permanently.');
        }

        return back()->with('error', 'Invalid action selected.');
    }
}
