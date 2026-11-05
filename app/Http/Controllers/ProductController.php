<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\AttributeItem;
use App\Category;
use App\Product;
use App\ProductVariant;
use App\ProductVariantItem;
use App\Theme;
use App\ThemeExtraField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $query = Product::query();

        // 1. Search Filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // 2. Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pagination & Active Theme Scope
        $products = $query->where(['is_combo' => 0, 'theme_id' => activeThemeData()->id])
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->appends($request->all());

        if ($request->ajax()) {
            return response()->json([
                'html' => view('backEnd.admin.product.partials.table', compact('products'))->render(),
                'total' => $products->total(),
            ]);
        }

        return view('backEnd.admin.product.index', compact('products'));
    }

    public function create()
    {
        $attributes = Attribute::with('items')->get();
        $categories = Category::where('status', 1)->Where('theme_id', activeThemeData()->id)->orderBy('category_name', 'asc')->get();
        $extraFields = ThemeExtraField::where('theme_path', activeThemeData()->path)
            ->select('field_name', 'field_label', 'field_type', 'is_required')
            ->where('model_type', 'App\Product')
            ->get()->toArray();

        $products = Product::where('theme_id', activeThemeData()->id)->latest()->get();

        return view('backEnd.admin.product.create', compact('attributes', 'categories', 'extraFields', 'products'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products,name',
            'sku' => 'required|unique:products,sku',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->getMessageBag()->toArray());
        }
        DB::transaction(function () use ($request) {
            $image_id = uploadFile($request->file('image') ?? null, 1000, 1000);
            $size_chart_id = uploadFile($request->file('size_chart') ?? null, 1000, 1000);
            $gallery_image_ids = uploadMultipleFile($request->file('gallery_image') ?? null, 1000, 1000);
            // Custom Meta Image Upload (fallback: feature image)
            if ($request->hasFile('meta_image')) {
                $imageName = time() . '_meta.' . $request->meta_image->extension();
                if (!file_exists(public_path('uploads/products/meta/'))) {
                    mkdir(public_path('uploads/products/meta/'), 0755, true);
                }
                $request->meta_image->move(public_path('uploads/products/meta/'), $imageName);
                $imagePath = 'uploads/products/meta/' . $imageName;
            }

            $input = array_merge(
                $request->all(),
                [
                    'thumb' => $image_id,
                    'image' => $image_id,
                    'gallery_images' => $gallery_image_ids,
                    'sku' => str_replace(' ', '-', strtolower($request->sku)),
                    // 'stock' => $request->stock ?? 0,
                    'has_variant' => $request->has('attribute') ? 1 : 0,
                    'is_package' => $request->package_qty > 1 ? 1 : 0,
                    'package_qty' => $request->package_qty,
                    'theme_id' => activeThemeData()->id,
                    'related_products' => $request->related_products ?? null,
                    'meta_title' => $request->meta_title ?? null,
                    'meta_description' => $request->meta_description ?? null,
                    'meta_keywords' => $request->meta_keywords ?? null,
                    'meta_image' => $imagePath ?? null,
                    'size_chart' => $size_chart_id ?? null,

                ]
            );
            $product = Product::create($input);
            if ($request->has('attribute')) {
                $attribute = $request->attribute ?? [];
                $attribute_values = array_values($attribute);
                // Cartesian combinations
                $combinations = [[]];
                foreach ($attribute_values as $values) {
                    $temp = [];
                    foreach ($combinations as $combo) {
                        foreach ($values as $val) {
                            $temp[] = array_merge($combo, [$val]);
                        }
                    }
                    $combinations = $temp;
                }

                $totalStock = 0;

                foreach ($combinations as $index => $combo) {
                    $variantKey = implode('-', $combo);
                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'sku' => $request->variant_sku[$index] ?? null,
                        'purchase_price' => $request->variant_purchase_price[$index] ?? 0,
                        'regular_price' => $request->variant_regular_price[$index] ?? 0,
                        'sale_price' => $request->variant_sale_price[$index] ?? 0,
                        // 'stock' => $request->variant_stock[$index] ?? 0,
                        'variant' => $variantKey,
                        // 'image' => $request->variant_image[$index] ?? null
                    ]);
                    $totalStock += $request->variant_stock[$index] ?? 0;

                    foreach ($combo as $attr_index => $item_id) {
                        $attribute_id = array_keys($attribute)[$attr_index];
                        $item_name = AttributeItem::find($item_id)->name ?? null;
                        $img = $request->attribute_images[$attribute_id][$item_id] ?? null;
                        $img_id = uploadFile($img, 1000, 1000);
                        // dd($img_id);

                        ProductVariantItem::create([
                            'product_variant_id' => $variant->id,
                            'attribute_id' => $attribute_id,
                            'attribute_item_id' => $item_id,
                            'name' => $item_name,
                            'image' => $img_id ?? null,
                        ]);
                    }
                }

                $product->update(['stock' => $totalStock]);
            }
            foreach ($request->category_id as $cat) {
                DB::table('category_products')->insert([
                    'category_id' => $cat,
                    'product_id' => $product->id,
                ]);
            }

            $extraFields = ThemeExtraField::where('theme_path', activeThemeData()->path)
                ->where('model_type', 'App\Product')
                ->get();

            if ($request->hasFile('hover_image')) {
                $hover_image_id = uploadFile($request->file('hover_image') ?? null, 1000, 1000);
            }
            if ($extraFields->count() > 0) {
                $specialFields = [
                    'hover_image' => $hover_image_id ?? null,
                    'position' => 0,
                ];
                $extraData = [];
                foreach ($extraFields as $field) {
                    $key = $field->field_name;

                    if (array_key_exists($key, $specialFields)) {
                        $extraData[$key] = $specialFields[$key];

                        continue;
                    }
                    $extraData[$key] = $request->$key ?? null;
                }

                $product->update([
                    'extra_fields' => $extraData,
                ]);
            }
        });

        return redirect()->route('admin.product')->with('success', 'Product create successfully.');
    }

    public function edit($id)
    {
        // dd($id);
        $data = Product::with('get_variants', 'get_variant_items')->findOrFail($id);
        // dd($data->hover_image_url);
        $categories = Category::where(['status' => 1, 'theme_id' => activeThemeData()->id])->pluck('category_name', 'id');
        $p_c = $data->get_categories()->pluck('category_name', 'categories.id');
        $prod_cat = '';
        foreach ($p_c as $key => $item) {
            $prod_cat .= ',' . $key;
        }
        $prod_cat = substr($prod_cat, 1);
        $attributes = Attribute::with('items')->get();
        $extraFields = ThemeExtraField::where('theme_id', $data->theme_id)
            ->where('model_type', 'App\Product')
            ->get();

        $theme_id = activeThemeData()->id;
        $products = Product::where('theme_id', $theme_id)->latest()->get();

        return view('backEnd.admin.product.edit', compact('data', 'categories', 'prod_cat', 'attributes', 'extraFields', 'products'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products,name,' . $id,
            'sku' => 'required|unique:products,sku,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        }

        DB::transaction(function () use ($request, $id) {
            $product = Product::findOrFail($id);

            // ১. ইমেজ হ্যান্ডলিং
            if ($request->hasFile('image')) {
                $image_id = uploadFile($request->file('image'), 1000, 1000);
                if ($product->image) {
                    deleteFile($product->image);
                }
            } else {
                $image_id = $request->image_old;
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




            if ($request->hasFile('gallery_image')) {
                if ($product->gallery_images) {
                    deleteMultipleFiles($product->gallery_images);
                }
                $gallery_image_ids = uploadMultipleFile($request->file('gallery_image'), 1000, 1000);
            } else {
                $gallery_image_ids = $request->gallery_images_old;
            }

            // Custom Meta Image Upload (fallback: feature image)
            if ($request->hasFile('meta_image')) {
                // Delete old meta image if exists
                if ($product->meta_image && file_exists(public_path($product->meta_image))) {
                    unlink(public_path($product->meta_image));
                }
                $imageName = time() . '_meta.' . $request->meta_image->extension();
                if (!file_exists(public_path('uploads/products/meta/'))) {
                    mkdir(public_path('uploads/products/meta/'), 0755, true);
                }
                $request->meta_image->move(public_path('uploads/products/meta/'), $imageName);
                $imagePath = 'uploads/products/meta/' . $imageName;
            }

            // ২. প্রোডাক্ট আপডেট
            $input = array_merge(
                $request->all(),
                [
                    'thumb' => $image_id,
                    'image' => $image_id,
                    'gallery_images' => $gallery_image_ids,
                    'sku' => str_replace(' ', '-', strtolower($request->sku)),
                    // 'stock' => $request->stock ?? 0,
                    'has_variant' => $request->has('attribute') ? 1 : 0,
                    'is_package' => $request->package_qty > 1 ? 1 : 0,
                    'package_qty' => $request->package_qty,
                    'theme_id' => $product->theme_id,
                    'related_products' => $request->related_products,
                    'meta_title' => $request->meta_title ?? null,
                    'meta_description' => $request->meta_description ?? null,
                    'meta_image' => $imagePath ?? null,
                    'meta_keywords' => $request->meta_keywords ?? null,
                    'size_chart' => $size_chart_id ?? null,
                ]
            );
            $product->update($input);
            $product->get_categories()->sync($request->category_id);

            // ৩. ভ্যারিয়েন্ট সিঙ্ক (Sync Logic)
            if ($request->has('attribute')) {
                $attribute = $request->attribute ?? [];
                $attribute_values = array_values($attribute);
                $combinations = [[]];

                foreach ($attribute_values as $values) {
                    $temp = [];
                    foreach ($combinations as $combo) {
                        foreach ($values as $val) {
                            $temp[] = array_merge($combo, [$val]);
                        }
                    }
                    $combinations = $temp;
                }

                // $totalStock = 0;
                $keptVariantIds = [];

                foreach ($combinations as $index => $combo) {
                    $variantKey = implode('-', $combo);

                    // আগে থেকে এই variant key থাকলে Update, না থাকলে Create
                    $variant = ProductVariant::updateOrCreate(
                        [
                            'product_id' => $product->id,
                            'variant'    => $variantKey,
                        ],
                        [
                            'sku'            => $request->variant_sku[$index] ?? null,
                            'purchase_price' => $request->variant_purchase_price[$index] ?? 0,
                            'regular_price'  => $request->variant_regular_price[$index] ?? 0,
                            'sale_price'     => $request->variant_sale_price[$index] ?? 0,
                            // 'stock'          => $request->variant_stock[$index] ?? 0,
                        ]
                    );

                    $keptVariantIds[] = $variant->id;
                    // $totalStock += $request->variant_stock[$index] ?? 0;

                    // Variant Items আপডেট বা ক্রিয়েট
                    $keptItemIds = [];
                    foreach ($combo as $attr_index => $item_id) {
                        $attribute_id = array_keys($attribute)[$attr_index];
                        $item_name = AttributeItem::find($item_id)->name ?? null;

                        $img = $request->attribute_images[$attribute_id][$item_id] ?? null;
                        $img_old = $request->attribute_images_old[$attribute_id][$item_id] ?? null;

                        $img_id = $img ? uploadFile($img, 1000, 1000) : $img_old;

                        $variantItem = ProductVariantItem::updateOrCreate(
                            [
                                'product_variant_id' => $variant->id,
                                'attribute_id'       => $attribute_id,
                                'attribute_item_id'  => $item_id,
                            ],
                            [
                                'name'  => $item_name,
                                'image' => $img_id ?? null,
                            ]
                        );

                        $keptItemIds[] = $variantItem->id;
                    }

                    // বাদ পড়া Variant Items মুছে ফেলা
                    ProductVariantItem::where('product_variant_id', $variant->id)
                        ->whereNotIn('id', $keptItemIds)
                        ->delete();
                }

                // যে ভ্যারিয়েন্টগুলো নতুন লিস্টে নেই সেগুলো মুছে ফেলা
                $removedVariants = ProductVariant::where('product_id', $product->id)
                    ->whereNotIn('id', $keptVariantIds)
                    ->get();

                foreach ($removedVariants as $removedVariant) {
                    $removedVariant->items()->delete();
                    $removedVariant->delete();
                }

                // $product->update(['stock' => $totalStock]);
            } else {
                // Attribute না থাকলে সব Variant মুছে দেওয়া
                $product->get_variants()->each(function ($variant) {
                    $variant->items()->delete();
                    $variant->delete();
                });
            }

            // ৪. Extra Fields আপডেট
            $extraFields = ThemeExtraField::where('theme_id', $product->theme_id)
                ->where('model_type', 'App\Product')
                ->get();

            if ($extraFields->count() > 0) {
                if ($request->hasFile('hover_image')) {
                    $hover_image_id = uploadFile($request->file('hover_image') ?? null, 1000, 1000);
                }

                $currentExtra = $product->extra_fields ?? [];
                $extraData = [];

                foreach ($extraFields as $field) {
                    $key = $field->field_name;
                    if ($key == 'hover_image') {
                        $extraData[$key] = $hover_image_id ?? ($currentExtra['hover_image'] ?? null);
                        continue;
                    }

                    if ($request->has($key)) {
                        $extraData[$key] = $request->get($key);
                    } else {
                        $extraData[$key] = ($key == 'position') ? ($currentExtra['position'] ?? 0) : ($currentExtra[$key] ?? null);
                    }
                }

                $product->update([
                    'extra_fields' => $extraData,
                ]);
            }
        });

        return redirect()->route('admin.product')->with('success', 'Product updated successfully.');
    }

    // public function update(Request $request, $id)
    // {
    //     dd($request->all());
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|unique:products,name,' . $id,
    //         'sku' => 'required|unique:products,sku,' . $id,
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
    //     }
    //     DB::transaction(function () use ($request, $id) {
    //         $product = Product::findOrFail($id);
    //         if ($request->has('image')) {
    //             $image_id = uploadFile($request->file('image'), 1000, 1000);
    //             if ($product->image) {
    //                 deleteFile($product->image);
    //             }
    //         } else {
    //             $image_id = $request->image_old;
    //         }

    //         if ($request->has('gallery_image')) {
    //             if ($product->gallery_images) {
    //                 deleteMultipleFiles($product->gallery_images);
    //             }
    //             $gallery_image_ids = uploadMultipleFile($request->file('gallery_image'), 1000, 1000);
    //         } else {
    //             $gallery_image_ids = $request->gallery_images_old;
    //         }
    //         $input = array_merge(
    //             $request->all(),
    //             [
    //                 'thumb' => $image_id,
    //                 'image' => $image_id,
    //                 'gallery_images' => $gallery_image_ids,
    //                 'sku' => str_replace(' ', '-', strtolower($request->sku)),
    //                 'stock' => $request->stock ?? 0,
    //                 'has_variant' => $request->has('attribute') ? 1 : 0,
    //                 'is_package' => $request->package_qty > 1 ? 1 : 0,
    //                 'package_qty' => $request->package_qty,
    //                 'theme_id' => $product->theme_id,
    //                 'related_products' => $request->related_products,
    //             ]
    //         );
    //         $product->update($input);
    //         $product->get_categories()->sync($request->category_id);

    //         $product->get_variants()->each(function ($variant) {
    //             $variant->items()->delete();
    //             $variant->delete();
    //         });

    //         if ($request->has('attribute')) {
    //             $attribute = $request->attribute ?? [];
    //             $attribute_values = array_values($attribute);
    //             $combinations = [[]];

    //             foreach ($attribute_values as $values) {
    //                 $temp = [];
    //                 foreach ($combinations as $combo) {
    //                     foreach ($values as $val) {
    //                         $temp[] = array_merge($combo, [$val]);
    //                     }
    //                 }
    //                 $combinations = $temp;
    //             }

    //             $totalStock = 0;

    //             foreach ($combinations as $index => $combo) {
    //                 $variantKey = implode('-', $combo);
    //                 $variant = ProductVariant::create([
    //                     'product_id' => $product->id,
    //                     'sku' => $request->variant_sku[$index] ?? null,
    //                     'purchase_price' => $request->variant_purchase_price[$index] ?? 0,
    //                     'regular_price' => $request->variant_regular_price[$index] ?? 0,
    //                     'sale_price' => $request->variant_sale_price[$index] ?? 0,
    //                     'stock' => $request->variant_stock[$index] ?? 0,
    //                     'variant' => $variantKey,
    //                 ]);

    //                 $totalStock += $request->variant_stock[$index] ?? 0;
    //                 foreach ($combo as $attr_index => $item_id) {
    //                     $attribute_id = array_keys($attribute)[$attr_index];
    //                     $item_name = AttributeItem::find($item_id)->name ?? null;

    //                     $img = $request->attribute_images[$attribute_id][$item_id] ?? null;
    //                     $img_old = $request->attribute_images_old[$attribute_id][$item_id] ?? null;

    //                     if ($img) {
    //                         $img_id = uploadFile($img, 1000, 1000);
    //                     } else {
    //                         $img_id = $img_old; // পুরনো image ধরে রাখা
    //                     }

    //                     ProductVariantItem::create([
    //                         'product_variant_id' => $variant->id,
    //                         'attribute_id' => $attribute_id,
    //                         'attribute_item_id' => $item_id,
    //                         'name' => $item_name,
    //                         'image' => $img_id ?? null,
    //                     ]);
    //                 }
    //             }

    //             $product->update(['stock' => $totalStock]);
    //         }



    //         $extraFields = ThemeExtraField::where('theme_id', $product->theme_id)
    //             ->where('model_type', 'App\Product')
    //             ->get();
    //         if ($extraFields->count() > 0) {
    //             if ($request->hasFile('hover_image')) {
    //                 $hover_image_id = uploadFile($request->file('hover_image') ?? null, 1000, 1000);
    //             }

    //             $currentExtra = $product->extra_fields ?? [];
    //             // dd($currentExtra);
    //             $extraData = [];
    //             foreach ($extraFields as $field) {
    //                 $key = $field->field_name;
    //                 if ($key == 'hover_image') {
    //                     $extraData[$key] = $hover_image_id ?? ($currentExtra['hover_image'] ?? null);

    //                     continue;
    //                 }
    //                 if ($key == 'position') {
    //                     $extraData[$key] = $currentExtra['position'];
    //                     // dd($extraData[$key]);
    //                 }

    //                 if ($request->has($key)) {
    //                     // dd($request->get($key));
    //                     $extraData[$key] = $request->get($key);
    //                 } else {
    //                     if ($key == 'position') {
    //                         $extraData[$key] = $currentExtra['position'] ?? 0;
    //                     }
    //                     // dd($extraData[$key]);
    //                     $extraData[$key] = $currentExtra[$key] ?? null;
    //                 }
    //             }
    //             // dd($extraData);
    //             $product->update([
    //                 'extra_fields' => $extraData,
    //             ]);
    //         }
    //     });

    //     return redirect()->route('admin.product')->with('success', 'Product updated successfully.');
    // }

    public function status(Request $request, $id)
    {

        $status = Product::findOrFail($id);
        $status->update(['status' => ! $status->status]);

        return back()->with('success', 'Product status updated successfully.');
    }

    public function delete($id)
    {
        $product = Product::with('get_order_products')->findOrFail($id);
        if ($product->get_order_products->count() > 0) {
            return back()->with('warning', 'Product can\'t be deleted because it has been used in an order.');
        }
        $product->delete();
        return back()->with('success', 'Product deleted successfully.');
    }

    // bulk delete
    public function bulkDelete(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id' // আপনার ডাটাবেজ টেবিল নাম দেবেন
        ]);
        try {
            DB::beginTransaction();
            // Model এর মাধ্যমে ফেচ করে ডিলিট করলে Model Event (deleting) ট্রিগার হবে
            $products = Product::whereIn('id', $request->ids)->get();
            foreach ($products as $product) {
                $product->delete(); // এটি মডেলে থাকা deleting hook ট্রিগার করবে এবং সব রিলেটেড ডাটা মুছে দেবে
            }
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

    public function checkUniqueSku(Request $request)
    {
        $sku = str_replace(' ', '-', strtolower($request->sku));
        $query = Product::where('sku', $sku);
        if ($request->productId) {
            $query->whereNotIn('id', [$request->productId]);
        }
        $product = $query->first();

        if ($product) {
            return response()->json(['error' => 'Already exists!']);
        } else {
            return response()->json(['success' => 'Valid!']);
        }
    }

    public function ajaxGetCombinedAttributes(Request $request)
    {
        // dd($request->all());
        $arrays = $request->attribute;

        if ($arrays) {
            $result = [[]];

            foreach ($arrays as $attribute_id => $attribute_items) {
                $tmp = [];
                foreach ($result as $result_item) {
                    foreach ($attribute_items as $item_id) {

                        $attribute_name = Attribute::find($attribute_id)->name ?? '';
                        $item_name = AttributeItem::find($item_id)->name ?? '';

                        // Merge previous combinations + new attribute pair
                        $tmp[] = array_merge($result_item, [
                            $attribute_name => $item_name,
                        ]);
                    }
                }
                $result = $tmp;
            }

            $combinations = collect($result);
            $v_regular_price = $request->v_regular_price;
            $v_purchase_price = $request->v_purchase_price;
            $v_sale_price = $request->v_sale_price;
            $product_sku = $request->h_sku;

            if ($combinations->count()) {
                return view('backEnd.admin.product.partials.generate_combination', compact(
                    'combinations',
                    'v_regular_price',
                    'v_sale_price',
                    'v_purchase_price',
                    'product_sku'
                ));
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function ajaxGetCombinedAttributesEdit(Request $request)
    {
        $arrays = $request->attribute;
        $product = Product::with('get_variants')->find($request->id);

        if ($arrays) {
            $result = [[]];

            foreach ($arrays as $attribute_id => $attribute_items) {
                $tmp = [];
                foreach ($result as $result_item) {
                    foreach ($attribute_items as $item_id) {
                        $attribute_name = Attribute::find($attribute_id)->name ?? '';
                        $item_name = AttributeItem::find($item_id)->name ?? '';

                        $tmp[] = array_merge($result_item, [
                            $attribute_name => $item_name,
                        ]);
                    }
                }
                $result = $tmp;
            }

            $combinations = $result;
            $v_purchase_price = $request->v_purchase_price ?? 0;
            $v_regular_price = $request->v_regular_price ?? 0;
            $v_sale_price = $request->v_sale_price ?? 0;
            $product_sku = $request->h_sku;
            $product_id = $request->id;

            if ($combinations) {
                return view('backEnd.admin.product.partials.generate_combination_edit', compact(
                    'combinations',
                    'product',
                    'v_purchase_price',
                    'v_regular_price',
                    'v_sale_price',
                    'product_sku',
                    'product_id'
                ));
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function ajaxGetColorImage(Request $request)
    {
        $colorImages = [];

        if ($request->has('attribute')) {
            // Attribute ID-গুলোর মধ্যে যেগুলোর 'is_image' = 1, শুধু সেগুলো একবারে query করে নেওয়া
            $attributeIds = array_keys($request->attribute);
            $imageAttributeIds = Attribute::whereIn('id', $attributeIds)
                ->where('is_image', 1)
                ->pluck('id')
                ->toArray();

            foreach ($request->attribute as $key => $var) {
                if (in_array($key, $imageAttributeIds)) {
                    $colorImages[$key] = $var;
                }
            }
        }

        return view('backEnd.admin.product.color-image.color-create', compact('colorImages'));
    }

    public function ajaxGetColorImageEdit(Request $request)
    {
        $attribute_data = $request->attribute ?? [];
        $product_id = $request->id;
        $product = Product::find($product_id);
        $colorImages = [];

        foreach ($attribute_data as $attrId => $itemIds) {
            $attribute = Attribute::find($attrId);

            // শুধুমাত্র ইমেজের জন্য সিলেক্টেড অ্যাট্রিবিউট প্রসেস করবে (is_image == 1)
            if ($attribute && $attribute->is_image == 1) {
                foreach ($itemIds as $itemId) {
                    $item = AttributeItem::find($itemId);
                    // dd($item, $attrId, $itemId, $product_id);

                    // ডাটাবেজ থেকে এই স্পেসিফিক ভ্যারিয়েন্ট আইটেমের ইমেজ আইডি বের করা
                    $variantItem = ProductVariantItem::whereHas('variant', function ($q) use ($product_id) {
                        $q->where('product_id', $product_id);
                    })
                        ->where('attribute_id', $attrId)
                        ->where('attribute_item_id', intval($itemId))
                        ->first();
                    // dd($variantItem);

                    $imageUrl = '';
                    $rawImg = $variantItem->image ?? '';

                    if (!empty($rawImg)) {
                        // ইমেজ যদি Media Table-এর ID হয় তবে URL বের করা, অন্যথায় ডিরেক্ট পাথ
                        if (is_numeric($rawImg)) {
                            $media = \App\Media::find($rawImg);
                            $imageUrl = $media ? asset($media->file_url) : '';
                        } else {
                            $imageUrl = asset($rawImg);
                        }
                    }

                    $colorImages[$attrId][$itemId] = [
                        'name'      => $item->name ?? 'N/A',
                        'image'     => $imageUrl,      // Preview করার জন্য Full URL
                        'image_old' => $rawImg         // Form submit-এ ডাটা ধরে রাখার জন্য Raw Value
                    ];
                }
            }
        }

        // dd($colorImages);

        return view('backEnd.admin.product.color-image.color-edit', compact('colorImages'))->render();
    }

    public function attributeItemStore(Request $request)
    {
        // dd($request->all());

        // check if variant item in exist in variant
        $variant_item = AttributeItem::where('name', strtolower($request->name))->where('attribute_id', $request->hidden_attribute_id)->first();
        if ($variant_item) {
            return response()->json(['status' => 'error', 'message' => 'Variant item already exist']);
        }

        $item = AttributeItem::create([
            'attribute_id' => $request->hidden_attribute_id,
            'name' => strtolower($request->name),
        ]);

        return response()->json(['status' => 'success', 'item' => $item]);
    }

    public function updateFlag(Request $request)
    {
        $product = Product::findOrFail($request->id);

        if ($product) {
            $flags = $product->extra_fields ?? [];
            // update single key
            $flags[$request->key] = $request->value;
            $product->extra_fields = $flags;
            $product->save();

            return response()->json(['success' => true]);
        }
    }

    public function updatePosition(Request $request)
    {
        // dd($request->all());
        $product = Product::findOrFail($request->id);
        $flags = $product->extra_fields ?? [];
        $flags[$request->key] = $request->position;
        $product->extra_fields = $flags;
        $product->save();

        return response()->json(['success' => true]);
    }

    public function checkSlug(Request $request)
    {
        $slug = $request->slug;
        $exists = Product::where('slug', $slug)->exists();

        return response()->json([
            'exists' => $exists,
        ]);
    }

    public function quickSlugUpdate(Request $request)
    {
        $product = Product::findOrFail($request->id);

        // slug unique check
        $exists = Product::where('slug', $request->slug)
            ->where('id', '!=', $product->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'This slug is already taken!',
            ]);
        }

        $product->update([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Saved successfully!',
        ]);
    }
    public function freeShipping(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'free_shipping' => 'required|in:0,1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $product->update([
            'free_shipping' => !$product->free_shipping
        ]);


        return response()->json([
            'status' => true,
            'free_shipping' => $product->free_shipping
        ]);
    }
}
