<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductVariant;
use App\StockAdjustment;
use App\StockAdjustmentItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockAdjustmentController extends Controller
{
    public function index()
    {
        $data = StockAdjustment::with('items.product')->latest()->paginate(20);
        return view('backEnd.admin.stock_adjustment.index', compact('data'));
    }

    public function create()
    {
        $products = Product::where(['status' => 1, 'theme_id' => activeThemeData()->id])->pluck('name', 'id');
        return view('backEnd.admin.stock_adjustment.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'adjustment_date' => 'required',
            'product_id' => 'required|array',
            'adjusted_quantity' => 'required|array',
            'type' => 'required|array',
        ]);

        // Web settings theke stock_management check kora hocche
        $setting = DB::table('web_settings')->select('stock_management')->first();
        $stockManagement = $setting->stock_management ?? 0;

        DB::beginTransaction();
        try {
            // 1. Master Record Create
            $adjustment = StockAdjustment::create([
                'adjustment_date' => date('Y-m-d', strtotime($request->adjustment_date)),
                'reason' => $request->reason,
                'note' => $request->note,
            ]);

            // 2. Items Loop & Stock Adjust
            foreach ($request->product_id as $key => $product_id) {
                $product = Product::with(['get_variants', 'get_purchase_items'])->findOrFail($product_id);
                $sku = $request->sku[$key] ?? null;
                $qty = (int) $request->adjusted_quantity[$key];
                $type = $request->type[$key]; // 'addition' or 'subtraction'

                $currentStock = 0;

                // **Step A: Product/Variant Table Stock Update (Sobar jonnoi common)**
                if (count($product->get_variants) > 0 && !empty($sku)) {
                    $variant = ProductVariant::where('sku', $sku)->first();
                    if ($variant) {
                        if ($type == 'addition') {
                            $variant->stock += $qty;
                            $product->stock += $qty;
                        } else {
                            $variant->stock -= $qty;
                            $product->stock -= $qty;
                        }
                        $variant->save();
                    }
                } else {
                    if ($type == 'addition') {
                        $product->stock += $qty;
                    } else {
                        $product->stock -= $qty;
                    }
                }
                $product->save();
                $currentStock = $product->stock;

                // **Step B: Conditional Purchase Table Stock Update (Jodi stock_management 1 hoy)**
                if ($stockManagement == 1) {
                    $purchaseItem = null;
                    if (!empty($sku)) {
                        $purchaseItem = \App\PurchaseItem::where('product_id', $product_id)
                            ->where('sku', $sku)
                            ->when($type === 'subtraction', function ($q) {
                                return $q->where('stock_quantity', '>', 0);
                            })
                            ->orderBy('sale_priority', 'desc')
                            ->orderBy('id', 'asc')
                            ->first();
                    }

                    if (!$purchaseItem) {
                        $purchaseItem = \App\PurchaseItem::where('product_id', $product_id)
                            ->when($type === 'subtraction', function ($q) {
                                return $q->where('stock_quantity', '>', 0);
                            })
                            ->orderBy('sale_priority', 'desc')
                            ->orderBy('id', 'asc')
                            ->first();
                    }

                    if ($purchaseItem) {
                        if ($type == 'addition') {
                            $purchaseItem->increment('stock_quantity', $qty);
                        } else {
                            $purchaseItem->decrement('stock_quantity', min($purchaseItem->stock_quantity, $qty));
                        }
                        $purchaseItem->refresh();
                        // Jodi stock management active thake, tobe current stock hisebe purchase item er stock-o dekhate paren ba product stock rakhte paren.
                        $currentStock = $purchaseItem->stock_quantity;
                    }
                }

                // 3. Adjustment Item Insert
                StockAdjustmentItem::create([
                    'stock_adjustment_id' => $adjustment->id,
                    'product_id' => $product_id,
                    'sku' => $sku,
                    'current_stock' => $currentStock,
                    'adjusted_quantity' => $qty,
                    'type' => $type,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.stock.adjustment')->with('success', 'Stock adjusted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function ajaxGetAdjustmentProduct(Request $request)
    {
        $product = Product::with('get_variants')->findOrFail($request->id);
        return view('backEnd.admin.stock_adjustment.partials.ajax_get_adjustment_product', compact('product'))->render();
    }
}
