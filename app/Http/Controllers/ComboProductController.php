<?php

namespace App\Http\Controllers;

use App\Category;
use App\ComboProduct;
use App\Product;
use App\Services\StockManager;
use App\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ComboProductController extends Controller
{
    public function index()
    {
        $products = Product::where('is_combo', 1)->latest()->paginate(20);

        return view('backEnd.admin.combo-products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $products = Product::where(['is_combo' => 0, 'status' => 1])->get();

        return view('backEnd.admin.combo-products.create', compact('categories', 'products'));
    }

    // AJAX: SKU unique check
    public function checkSku(Request $request)
    {
        // dd($request->all());
        // $sku = $request->get('sku');
        // $exists = Product::where('sku', $sku)->exists();
        // return response()->json(['exists' => $exists]);
    }

    // AJAX: fetch selected products details
    public function fetchProductsDetails(Request $request)
    {
        $ids = $request->get('ids', []);
        $products = Product::whereIn('id', $ids)->get(['id', 'name', 'purchase_price', 'regular_price', 'sale_price', 'sku', 'stock', 'package_qty']);

        // dd($products);
        return response()->json(['products' => $products]);
    }

    public function store(Request $request)
    {

        // dd($request->all());

        DB::beginTransaction();
        try {

            $image_id = uploadFile($request->file('image') ?? null, 1000, 1000);
            $gallery_image_ids = uploadMultipleFile($request->file('gallery_image') ?? null, 1000, 1000);
            $size_chart_id = uploadFile($request->file('size_chart') ?? null, 1000, 1000);
            // $stocks = $request->combo_product_ids;
            // $stocks = collect($stocks)->map(function ($item) {
            //     // sum the quantity of each product
            //     return Product::find($item)->stock;
            // })->sum();
            // dd($stocks);
            $activeThemeId = Theme::where('is_active', 1)->value('id');
            $input = array_merge(
                $request->all(),
                [
                    'thumb' => $image_id,
                    'image' => $image_id,
                    'gallery_images' => $gallery_image_ids,
                    'size_chart' => $size_chart_id,
                    'slug' => Str::slug($request->name),
                    'sku' => str_replace(' ', '-', strtolower($request->sku)),
                    'stock' => 0,
                    'has_variant' => 0,
                    'is_combo' => 1,
                    'theme_id' => $activeThemeId,
                ]
            );

            $product = Product::create($input);
            if ($request->has('category_id')) {
                foreach ($request->category_id as $cat) {
                    DB::table('category_products')->insert([
                        'category_id' => $cat,
                        'product_id' => $product->id,
                    ]);
                }
            }


            foreach ($request->combo_product_ids as $key => $product_id) {
                $child_product = Product::find($product_id);
                $sku = $child_product->sku;
                $variant_choice = null; // or the actual variant choice if applicable
                $purchase_price = StockManager::getPurchasePrice($child_product, $sku, $variant_choice);
                // dd($purchase_price);
                ComboProduct::create([
                    'combo_product_id' => $product->id,
                    'product_id' => $product_id,
                    'purchase_price' => $purchase_price,
                    'regular_price' => $request->cp_regular[$key],
                    'sale_price' => $request->cp_sale[$key],
                    'quantity' => $request->cp_qty[$key],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.combo-products.index')->with('success', 'Combo product created.');
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();

            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $product = Product::with('comboItems')->findOrFail($id);
        $selectedProducts = $product->comboItems->pluck('product_id')->toArray();
        $cats = $product->get_category_products->pluck('category_id')->toArray();
        $categories = Category::where('status', 1)->get();
        // available child products (exclude combo products)
        $products = Product::where(['is_combo' => 0, 'status' => 1])->get();

        return view('backEnd.admin.combo-products.edit', compact('product', 'categories', 'products', 'cats', 'selectedProducts'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            if ($request->has('image')) {
                $image_id = uploadFile($request->file('image'), 1000, 1000);
                if ($product->image) {
                    deleteFile($product->image);
                }
            } else {
                $image_id = $product->image;
            }

            if ($request->has('gallery_image')) {
                if ($product->gallery_images) {
                    deleteMultipleFiles($product->gallery_images);
                }
                $gallery_image_ids = uploadMultipleFile($request->file('gallery_image'), 1000, 1000);
            } else {
                $gallery_image_ids = $product->gallery_images;
            }
            // Size Chart Handle
            if ($request->hasFile('size_chart')) {
                $size_chart_id = uploadFile($request->file('size_chart'), 1000, 1000);
                if ($product->size_chart) {
                    deleteFile($product->size_chart);
                }
            } else {
                $size_chart_id = $request->size_chart_old;
            }

            // $stocks = $request->combo_product_ids;
            // $stocks = collect($stocks)->map(function ($item) {
            //     // sum the quantity of each product
            //     return Product::find($item)->stock;
            // })->sum();

            $activeThemeId = Theme::where('is_active', 1)->value('id');

            $input = array_merge(
                $request->all(),
                [
                    'thumb' => $image_id,
                    'image' => $image_id,
                    'gallery_images' => $gallery_image_ids,
                    'size_chart' => $size_chart_id,
                    'slug' => Str::slug($request->name),
                    'sku' => str_replace(' ', '-', strtolower($request->sku)),
                    'stock' => 0,
                    'has_variant' => 0,
                    'is_combo' => 1,
                    'theme_id' => $activeThemeId,
                ]
            );
            $product->update($input);
            $product->get_categories()->sync($request->category_id);

            // ✅ Sync combo product items
            ComboProduct::where('combo_product_id', $product->id)->delete();

            foreach ($request->combo_product_ids as $key => $comboId) {
                // dd($comboId);
                $child_product = Product::find($comboId);
                $sku = $child_product->sku;
                $variant_choice = null; // or the actual variant choice if applicable
                $purchase_price = StockManager::getPurchasePrice($child_product, $sku, $variant_choice);
                // dd($purchase_price);
                ComboProduct::create([
                    'combo_product_id' => $product->id,
                    'product_id' => $comboId,
                    'purchase_price' => $purchase_price,
                    'regular_price' => $request->cp_regular[$key],
                    'sale_price' => $request->cp_sale[$key],
                    'quantity' => $request->cp_qty[$key],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.combo-products.index')
                ->with('success', 'Combo product updated successfully!');
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();

            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        // deleting product will cascade to combo_products due to FK
        $product->delete();

        return redirect()->route('admin.combo-products.index')->with('success', 'Combo deleted.');
    }


    public function bulkDelete(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id' // আপনার ডাটাবেজ টেবিল নাম দেবেন
        ]);
        try {
            DB::beginTransaction();
            // ১. কম্বো রিলেশনের ডাটা আগে ডিলিট করা
            ComboProduct::whereIn('combo_product_id', $request->ids)->delete();

            // ২. সরাসরি বাল্ক ডিলিট (১টি মাত্র SQL কোয়েরি চলবে)
            Product::whereIn('id', $request->ids)->where('is_combo', 1)->delete();
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
