<?php

namespace App\Http\Controllers;

use App\PurchaseItem;
use App\Supplier;
use Illuminate\Http\Request;

class StockControlController extends Controller
{
    // স্টক কন্ট্রোল পেজ যেখানে সব লট বা আইটেম দেখাবে
    public function index(Request $request)
    {
        $query = PurchaseItem::with(['get_purchase.get_supplier', 'get_product']);

        // সার্চ ফিল্টার (Product Name, SKU অথবা Memo No দিয়ে)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('sku', 'LIKE', "%{$search}%")
                    ->orWhereHas('get_product', function ($sub) use ($search) {
                        $sub->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('get_purchase', function ($sub) use ($search) {
                        $sub->where('memo_no', 'LIKE', "%{$search}%");
                    });
            });
        }

        // সাপ্লায়ার অনুযায়ী ফিল্টার
        if ($request->filled('supplier_id')) {
            $query->whereHas('get_purchase', function ($q) use ($request) {
                $q->where('supplier_id', $request->supplier_id);
            });
        }

        // প্রায়োরিটি বা লেটেস্ট অনুযায়ী লিস্ট আনা এবং পেজিনেশনে রিকোয়েস্ট ধরে রাখা
        $purchaseItems = $query->orderBy('sale_priority', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->paginate(20)
            ->appends($request->all());

        $suppliers = Supplier::all();

        return view('backEnd.admin.stock_control.index', compact('purchaseItems', 'suppliers'));
    }

    // নির্দিষ্ট লটের sale_priority আপডেট করার AJAX মেথড
    public function updatePriority(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:purchase_items,id',
            'sale_priority' => 'required|integer',
        ]);

        $item = PurchaseItem::findOrFail($request->id);
        $item->sale_priority = $request->sale_priority;
        $item->save();

        return response()->json([
            'success' => true,
            'message' => 'Stock priority updated successfully!'
        ]);
    }
}
