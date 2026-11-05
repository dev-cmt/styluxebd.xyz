<?php

namespace App\Http\Controllers\Theme;

use App\AbandonedCart;
use App\Admin;
use App\Category;
use App\Coupon;
use App\CouponUser;
use App\DeviceTrack;
use App\Http\Controllers\Controller;
use App\IpAddress;
use App\Order;
use App\OrderAssign;
use App\OrderComboItem;
use App\OrderNote;
use App\OrderProduct;
use App\PageSetting;
use App\Product;
use App\ProductVariant;
use App\PromotionalBanner;
use App\Services\StockManager;
use App\ShippingMethod;
use App\Slider;
use App\Subscribe;
use App\Theme;
use App\User;
use Carbon\Carbon;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Theme3Controller extends Controller
{
    public function index(Request $request, Theme $theme)
    {
        // dd($theme);
        visitor()->visit();
        $products = Product::where('theme_id', $theme->id)->latest()->paginate(20);
        $categories = Category::where('status', 1)
            ->where('theme_id', $theme->id)
            ->get();

        $topCategories = Category::where('status', 1)
            ->where('theme_id', $theme->id)
            ->get()
            ->filter(function ($category) {
                return isset($category->extra_fields['is_top_category'])
                    && $category->extra_fields['is_top_category'] == 1;
            })->take(12);

        $bannerCategories = Category::where('status', 1)->where('is_show_home', 1)->where('theme_id', $theme->id)->latest()->get();
        $sliders = Slider::with('get_img')->where('theme_id', $theme->id)->where('status', 1)->orderBy('position', 'asc')->get();
        // Promotion (should be cached)
        // Promotion (should be cached)
        $promotion = cache()->rememberForever(
            'theme_' . $theme->id . '_promotion_banner',
            function () use ($theme) {
                return $theme->sections()->with('banners')
                    ->where('section', 'middle')
                    ->first();
            }
        );

        return view('frontEnd.' . $theme->path . '.pages.index', compact('theme', 'products', 'categories', 'topCategories', 'sliders', 'bannerCategories', 'promotion'));
    }

    public function aboutUs(Request $request, Theme $theme)
    {
        visitor()->visit();
        $currentTheme = $theme;
        $data = PageSetting::find(1);

        return view('frontEnd.' . $currentTheme->path . '.pages.about_us', compact('theme', 'data'));
    }

    public function contactUs(Request $request, Theme $theme)
    {
        visitor()->visit();
        $currentTheme = $theme;
        $data = PageSetting::find(1);

        return view('frontEnd.' . $currentTheme->path . '.pages.contact_us', compact('theme', 'data'));
    }

    public function returnPolicy(Request $request, Theme $theme)
    {
        visitor()->visit();
        $data = PageSetting::find(1);

        return view('frontEnd.' . $theme->path . '.pages.return_refund_policy', compact('data', 'theme'));
    }

    public function termsCondition(Request $request, Theme $theme)
    {
        visitor()->visit();
        $data = PageSetting::find(1);
        $currentTheme = $theme;

        return view('frontEnd.' . $theme->path . '.pages.terms_and_conditions', compact('theme', 'data', 'currentTheme'));
    }

    public function privacyPolicy(Request $request, Theme $theme)
    {
        visitor()->visit();
        $data = PageSetting::find(1);

        return view('frontEnd.' . $theme->path . '.pages.privacy_policy', compact('data', 'theme'));
    }

    public function howToOrder(Request $request, Theme $theme)
    {
        visitor()->visit();
        $data = PageSetting::find(1);

        return view('frontEnd.' . $theme->path . '.pages.how_to_order', compact('theme', 'data'));
    }

    public function whyUs(Request $request, Theme $theme)
    {
        visitor()->visit();
        $data = PageSetting::find(1);

        return view('frontEnd.' . $theme->path . '.pages.why_us', compact('theme', 'data'));
    }

    public function deliveryPolicy(Request $request, Theme $theme)
    {
        visitor()->visit();
        $data = PageSetting::find(1);

        return view('frontEnd.' . $theme->path . '.pages.delivery_policy', compact('data', 'theme'));
    }

    public function newsletter(Request $request, Theme $theme)
    {
        $request->validate([
            'email' => 'required | email',
        ]);

        $check = Subscribe::where('email', $request->email)->first();

        if ($check) {
            return back()->with('error', 'Already Subscribed!');
        } else {
            Subscribe::create(['email' => $request->email]);

            return back()->with('success', 'Thank You For Subscribe!');
        }
    }

    public function trackOrder(Request $request, Theme $theme)
    {
        visitor()->visit();
        return view('frontEnd.' . $theme->path . '.pages.trackorder.index', compact('theme'));
    }

    public function trackOrderResult(Request $request, Theme $theme)
    {
        $request->validate([
            'tracking_number' => 'required',
        ]);

        $order = Order::where('invoice_id', $request->tracking_number)->first();

        if ($order) {
            // status বের করি
            $currentStatus = $this->mapOrderStatus($order->status);

            return response()->json([
                'status' => true,
                'html' => view('frontEnd.' . $theme->path . '.pages.trackorder.partial', [
                    'order' => $order,
                    'currentStatus' => $currentStatus,
                ])->render(),
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Order not found!',
        ]);
    }

    private function mapOrderStatus($statusCode)
    {
        $statusCode = (int) $statusCode;

        if (in_array($statusCode, [1, 4])) {
            return 'pending';
        }

        if (in_array($statusCode, [2, 3, 5, 6, 7])) {
            return 'processing';
        }

        if ($statusCode === 8) {
            return 'on delivery';
        }

        if ($statusCode === 9) {
            return 'delivered';
        }

        if ($statusCode === 11) {
            return 'returned';
        }

        if ($statusCode === 10) {
            return 'cancelled';
        }

        return 'pending';
    }

    public function abandonedCart(Request $request)
    {
        $carts = \Cart::getContent();
        $total = 0;
        $subtotal = 0;
        foreach ($carts as $key => $item) {
            $abandoned_item[$key] = [
                'product_id' => $item->associatedModel->id,
                'qty' => $item->quantity,
                'price' => $item->price,
                'sku' => $item->id,
                'variant' => $item->attributes->count() > 0 ? $item->attributes[0] : null,
            ];
            $total += $item->quantity * $item->price;
            $subtotal += $item->quantity * $item->price;
        }
        $abandoned_item = json_encode($abandoned_item);
        $input = [
            'customer_name' => $request->data['name'],
            'customer_phone' => $request->data['phone'],
            'customer_address' => $request->data['address'],
            'shipping_cost' => $request->data['shipping_cost'] ?? 0,
            'total' => $total + $request->data['shipping_cost'] ?? 0,
            'subtotal' => $subtotal,
            'theme_id' => Theme::where('is_active', 1)->first()->id,
            'abandoned_item' => $abandoned_item,
            // 'note' => $request->data['note'],
        ];

        if (session()->has('abandoned_cart_id')) {
            $abandoned = AbandonedCart::where('id', session()->get('abandoned_cart_id'))->first();
            if ($abandoned) {
                $abandoned->update($input);
            } else {
                $id = AbandonedCart::create($input);
                session()->put('abandoned_cart_id', $id->id);
            }
        } else {
            $id = AbandonedCart::create($input);
            session()->put('abandoned_cart_id', $id->id);
        }
    }

    public function getSingleProduct(Request $request, Theme $theme, $slug)
    {
        visitor()->visit();
        $product = Product::where('theme_id', $theme->id)->with('get_feature_image', 'get_categories')->where('status', 1)->where('slug', $slug)->first();
        if ($product) {
            if (! empty($product->related_products)) {
                $relatedProducts = Product::whereIn('id', $product->related_products)->where('theme_id', $theme->id)->get();
            } else {
                $relatedProducts = [];
            }

            $currentTheme = $theme;
            $shippingMethods = ShippingMethod::where('status', 1)->get();
            return view('frontEnd.' . $theme->path . '.pages.product_details', compact('product', 'theme', 'relatedProducts', 'shippingMethods'));
        } else {
            return back()->with('error', 'Product Not Found In This Theme.');
        }
    }


    public function getSingleCategory(Request $request, Theme $theme, $slug)
    {
        $category = Category::where('slug', $slug)
            ->where('theme_id', $theme->id)
            ->firstOrFail();

        $cat_name = $category->category_name;

        // dd($category);

        $categories = Category::where('status', 1)
            ->whereNull('parent_id')
            ->where('theme_id', $theme->id)
            ->with('children', 'childrenRecursive')
            ->get();

        $data = $category->get_products()
            ->where('theme_id', $theme->id)
            ->where('status', 1)
            ->latest()
            ->paginate(12);

        return view(
            'frontEnd.' . $theme->path . '.pages.category_product',
            compact('category', 'data', 'cat_name', 'theme', 'categories')
        );
    }

    public function getProductModal(Request $request, Theme $theme)
    {
        $product = \App\Product::find($request->id);
        $type = $request->type;

        return view('frontEnd.' . $theme->path . '.pages.ajax_get_product', compact('product', 'type', 'theme'))->render();
    }
    public function ajaxGetSearchProduct(Request $request, Theme $theme)
    {
        $product_name = $request->search_product;
        $products = \App\Product::where('theme_id', $theme->id)->where('name', 'LIKE', "%{$product_name}%")->where('status', 1)->latest()->get();

        return view('frontEnd.' . $theme->path . '.pages.ajax_get_search_products', compact('products', 'theme'));
    }
    public function search(Request $request, Theme $theme)
    {
        // dd($request->all());
        $product_name = $request->search_product;
        $categories = Category::where('status', 1)
            ->whereNull('parent_id')->where('theme_id', $theme->id)
            ->with('children', 'childrenRecursive')
            ->get();

        $products = \App\Product::where('theme_id', $theme->id)->where('name', 'LIKE', "%{$product_name}%")
            ->where('status', 1)
            ->latest()
            ->paginate(12)
            ->withQueryString();
        $currentTheme = $theme;
        $products->nextPageUrl();

        return view('frontEnd.' . $theme->path . '.pages.search_product', compact('categories', 'products', 'theme', 'product_name'));
    }
    public function loadMoreProducts(Request $request, Theme $theme)
    {
        $product_name = $request->search_product;
        $limit  = 12;
        $offset = $request->offset ?? 0;

        $products = \App\Product::where('theme_id', $theme->id)->where('name', 'LIKE', "%{$product_name}%")->where('status', 1)->latest()
            ->skip($offset)
            ->take($limit)
            ->get();

        $html = view(
            'frontEnd.' . $theme->path . '.pages.ajax_get_category_products',
            compact('products', 'theme')
        )->render();

        return response()->json([
            'html' => $html,
            'next_offset' => $offset + $limit, // 👈 important
            'has_more' => $products->count() == $limit
        ]);
    }
    public function loadMoreCategoryProducts(Request $request, Theme $theme)
    {
        $limit  = 12;
        $offset = $request->offset ?? 0;

        $category = Category::find($request->category_id);

        $products = $category->get_products()
            ->where('theme_id', $theme->id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->skip($offset)
            ->take($limit)
            ->get();
        // dd($products);

        $html = view(
            'frontEnd.' . $theme->path . '.pages.ajax_get_category_products',
            compact('products', 'theme')
        )->render();

        return response()->json([
            'html' => $html,
            'next_offset' => $offset + $limit, // 👈 important
            'has_more' => $products->count() == $limit
        ]);
    }
    public function ajaxGetAttributes(Request $request)
    {
        $productId = $request->product_id;
        $selectedItemIds = $request->attribute_item_id;

        if (! $productId || ! $selectedItemIds || ! is_array($selectedItemIds)) {
            return response()->json([
                'success' => 400,
                'message' => 'Invalid request data.',
            ]);
        }

        // Product সহ তার Variants লোড করা
        $product = Product::with([
            'get_variants.items.attribute',
            'get_variants.items.attribute_item',
            'get_variants.items.item_image',
        ])->find($productId);

        if (! $product) {
            return response()->json([
                'success' => 404,
                'message' => 'Product not found.',
            ]);
        }

        // Selected attribute item ids থেকে variant key বানানো
        // (যেমন: [2,5,7] => "2-5-7")
        $variantKey = implode('-', $selectedItemIds);

        // Variant খুঁজা
        $matchedVariant = $product->get_variants->firstWhere('variant', $variantKey);

        if (! $matchedVariant) {
            return response()->json([
                'success' => 404,
                'message' => 'Variant not found for selected attributes.',
            ]);
        }

        // Response
        return response()->json([
            'success' => 200,
            'message' => 'Variant found successfully.',
            'data' => [
                'sku' => $matchedVariant->sku,
                'regular_price' => $matchedVariant->regular_price,
                'sale_price' => $matchedVariant->sale_price,
                'stock' => $matchedVariant->stock,
                'variant_items' => $matchedVariant->items->map(function ($item) {
                    return [
                        'attribute_item' => $item->attribute_item->name ?? null,
                    ];
                }),
            ],
        ]);
    }
    public function ajaxGetCategoryProduct(Request $request, Theme $theme)
    {
        $ids = explode(',', $request->category_ids);
        $product_name = $request->product_name;
        $products = \App\Product::where('theme_id', $theme->id)->whereHas('get_categories', function ($query) use ($ids) {
            $query->whereIn('category_id', $ids);
        })->where('name', 'LIKE', "%{$product_name}%")->where('status', 1)->latest()->get();
        $products = \App\Product::query()->where('theme_id', $theme->id)->where('status', 1);

        // Category filter (if category_ids exists)
        if (! empty($request->category_ids)) {
            $ids = explode(',', $request->category_ids);

            $products->whereHas('get_categories', function ($query) use ($ids) {
                $query->whereIn('category_id', $ids);
            });
        }

        // Product name filter (if product_name exists)
        if (! empty($request->product_name)) {
            $products->where('name', 'LIKE', "%{$request->product_name}%");
        }

        $products = $products->latest()->get();

        return view('frontEnd.' . $theme->path . '.pages.ajax_get_category_products', compact('products', 'theme'));
    }
    public function cartItemPlus(Request $request, Theme $theme, $id)
    {
        // Check cart item exists
        $item = \Cart::get($request->id);
        if (! $item) {
            return response()->json(['error' => 'Cart item not found']);
        }

        if (\Cart::getContent()->count() > 0) {
            \Cart::update($request->id, [
                'quantity' => 1,
            ]);

            return response()->json(['success' => 'Cart quantity updated successfully!']);
        } else {
            return response()->json(['error' => 'error']);
        }
    }
    public function cartItemMinus(Request $request, Theme $theme, $id)
    {
        $item = \Cart::get($request->id);
        if (! $item) {
            return response()->json(['error' => 'Cart item not found']);
        }

        if (\Cart::getContent()->count() > 0) {
            \Cart::update($request->id, [
                'quantity' => -1,
            ]);

            return response()->json(['success' => 'Cart quantity updated successfully!']);
        } else {
            return response()->json(['error' => 'error']);
        }
    }
    public function addCart(Request $request, $theme = null)
    {
        //        dd($request->all());
        $quantity = $request->quantity ?? 1;
        $product = Product::find($request->product_id);

        if (! $product) {
            return back()->with('error', 'Product not found');
        }

        // Determine variant key
        $variantKey = null;
        if ($request->attribute_item_id && is_array($request->attribute_item_id)) {
            $variantKey = strtolower(implode('-', $request->attribute_item_id));
        }

        // Try to fetch ProductVariant
        $variant = null;
        if ($variantKey) {
            $variant = ProductVariant::where('product_id', $product->id)
                ->where('variant', $variantKey)
                ->first();
        }

        // Decide which data to use: variant or main product
        $sku = $variant->sku ?? $product->sku;
        $name = $variant->product->name ?? $product->name;
        $price = $variant
            ? ($variant->sale_price > 0 ? $variant->sale_price : $variant->regular_price)
            : ($product->sale_price > 0 ? $product->sale_price : $product->regular_price);

        // dd($price);

        // Add or update cart
        if (\Cart::get($sku)) {
            \Cart::update($sku, [
                'quantity' => ['relative' => false, 'value' => $quantity],
            ]);
        } else {
            \Cart::add([
                'id' => $sku,
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
                'attributes' => $variantKey ?? null,
                'associatedModel' => $product,
            ]);
        }

        $add_to_cart_event = [
            'name' => $product->name,
            'id' => $product->id,
            'price' => $price,
            'category' => $product->get_categories->first()->category_name ?? '',
            'quantity' => $quantity
        ];
        session()->put('add_to_cart_event', $add_to_cart_event);




        $currentTheme = $theme;
        $total_cart = count(\Cart::getContent());

        if ($request->buy_now) {

            if ($currentTheme->is_active == 1) {
                $redirectUrl = route('checkout');
            } else {
                $redirectUrl = route('theme.checkout', ['path' => $currentTheme->path]);
            }

            return response()->json([
                'success' => 'Product added successfully!',
                'buy_now_redirect' => $redirectUrl,
                'total_cart' => $total_cart,
            ]);
        } elseif ($request->order_now == 1) {

            if ($currentTheme->is_active == 1) {
                $redirectUrl = route('checkout');
            } else {
                $redirectUrl = route('theme.checkout', ['path' => $currentTheme->path]);
            }

            return response()->json([
                'success' => 'Product added successfully!',
                'buy_now_redirect' => $redirectUrl,
                'total_cart' => $total_cart,
            ]);
        } elseif ($request->add_cart) {

            return response()->json([
                'success' => 'Cart added successfully!',
                'total_cart' => $total_cart,
            ]);
        } else {
            return back()->with('error', 'Something Went Wrong!');
        }
    }
    public function cartPage(Request $request, Theme $theme)
    {
        visitor()->visit();
        $carts = \Cart::getContent();

        $cartProductIds = $carts->pluck('associatedModel.id')->filter()->unique()->values();

        $relatedIds = $carts
            ->pluck('associatedModel.related_products')   // get related products array from each associated model
            ->filter()                                    // remove null
            ->flatten()                                   // flatten nested arrays
            ->map(fn($id) => (int) $id)                    // convert to integers
            ->unique()                                    // remove duplicates
            ->values();

        // Remove products already in cart
        $relatedIds = $relatedIds->diff($cartProductIds);
        // Query only once
        $relatedProducts = Product::whereIn('id', $relatedIds)->get();

        return view('frontEnd.' . $theme->path . '.pages.cart', [
            'theme' => $theme,
            'carts' => $carts,
            'relatedProducts' => $relatedProducts,
        ]);
    }
    public function cartItemQtyUpdate(Request $request, Theme $theme)
    {
        // Check cart item exists
        $item = \Cart::get($request->id);
        if (! $item) {
            return response()->json(['error' => 'Cart item not found']);
        }

        // Update quantity
        \Cart::update($request->id, [
            'quantity' => [
                'relative' => false,   // ❗important: stops auto-increase
                'value' => $request->quantity,
            ],
        ]);

        return response()->json(['success' => 'Cart quantity updated successfully!']);
    }
    public function cartItemDelete(Request $request, Theme $theme, $id)
    {
        \Cart::remove($id);
        $total = \Cart::getTotal();
        $total_cart = count(\Cart::getContent());
        if ($request->ajax()) {
            return response()->json([
                'success' => 'Cart Item Deleted Successfully.',
                'total' => $total,
                'total_cart' => $total_cart,
            ]);
        } else {
            return back()->with('success', 'Cart item delete successfully.');
        }
    }
    public function cartClear()
    {
        \Cart::clear();

        return response()->json([
            'success' => 200,
            'message' => 'Cart cleared successfully',
        ]);
    }

    public function checkout(Request $request, Theme $theme)
    {
        visitor()->visit();
        $shipping_methods = ShippingMethod::where('status', 1)->get();
        $currentTheme = $theme;
        $carts = \Cart::getContent();

        return view('frontEnd.' . $theme->path . '.pages.checkout', compact('theme', 'shipping_methods', 'theme', 'carts'));
    }
    public function couponApply(Request $request)
    {
        // dd($request->all());
        $couponCode = $request->coupon;
        $phone = $request->phone;
        $user = null;
        if (! empty($phone)) {
            $user = User::where('phone', $phone)->first();
        }

        // 1) Coupon exists?
        $coupon = Coupon::where('code', $couponCode)
            ->where('status', 1)
            ->first();
        // dd($request->all());

        if (! $coupon) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Coupon Code',
            ]);
        }

        // 2) Date validity
        $today = Carbon::today();

        if ($coupon->start_date && $today->lt(Carbon::parse($coupon->start_date))) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon is not active yet',
            ]);
        }
        if ($coupon->end_date && $today->gt(Carbon::parse($coupon->end_date))) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon expired',
            ]);
        }

        // 3) Usage limit
        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon usage limit reached',
            ]);
        }

        // 4) Per user usage
        if ($coupon->per_user_limit && $user) {
            $couponUser = CouponUser::where('user_id', $user->id)
                ->where('coupon_id', $coupon->id)
                ->first();
            $usedCount = $couponUser->used_count ?? 0;

            if ($usedCount >= $coupon->per_user_limit) {
                return response()->json([
                    'status' => false,
                    'message' => 'You have already used this coupon maximum allowed times',
                ]);
            }
        }

        // 5) Cart total
        $cart = \Cart::getContent();
        $subtotal = \Cart::getSubTotal();

        // 6) Min purchase
        if ($coupon->min_purchase && $subtotal < $coupon->min_purchase) {
            return response()->json([
                'status' => false,
                'message' => 'Minimum purchase amount is {{ $web_settings->currency_sign }}' . $coupon->min_purchase,
            ]);
        }

        if ($coupon->apply_on === 'product') {

            if (! $coupon->product_ids) {
                return response()->json([
                    'status' => false,
                    'message' => 'No product is assigned to this coupon',
                ]);
            }

            $allowedProducts = $coupon->product_ids;
            $affectedProducts = [];
            $discount = 0;

            // 🔹 Group cart items by PRODUCT (variant ignored)
            $groupedProducts = \Cart::getContent()->groupBy(function ($item) {
                return $item->associatedModel->id; // product_id
            });

            // 🔹 Calculate matched total (only allowed products)
            $matchedTotal = 0;
            foreach ($groupedProducts as $pid => $items) {
                if (in_array($pid, $allowedProducts)) {
                    $matchedTotal += $items->sum(function ($i) {
                        return $i->price * $i->quantity;
                    });
                }
            }

            if ($matchedTotal <= 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'This coupon is not applicable for selected products',
                ]);
            }

            // 🔹 Apply coupon ONCE per product
            foreach ($groupedProducts as $productId => $items) {

                if (! in_array($productId, $allowedProducts)) {
                    continue;
                }

                // total price of all variants of this product
                $productTotal = $items->sum(function ($item) {
                    return $item->price * $item->quantity;
                });

                if ($coupon->type === 'fixed') {
                    $productDiscount = ($productTotal / $matchedTotal) * $coupon->amount;
                }

                if ($coupon->type === 'percentage') {
                    $productDiscount = ($productTotal * $coupon->amount) / 100;

                    if ($coupon->max_discount && $productDiscount > $coupon->max_discount) {
                        $productDiscount = $coupon->max_discount;
                    }
                }
                $firstItem = $items->first();

                $affectedProducts[] = [
                    'product_id' => $productId,
                    'name' => $firstItem->name, // ✅ product name
                    'qty' => $items->sum('quantity'), // all variants qty
                    'price' => $productTotal,           // all variants price
                    'discount' => round($productDiscount, 2),
                ];

                $discount += $productDiscount;
            }
        }

        if ($coupon->apply_on === 'shipping') {
            $shippingCost = session('shipping_cost') ?? 0;

            if ($shippingCost <= 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Shipping charge not calculated yet',
                ]);
            }

            if ($coupon->type === 'fixed') {
                $discount = min($coupon->amount, $shippingCost);
            }

            if ($coupon->type === 'percentage') {
                $discount = ($shippingCost * $coupon->amount) / 100;

                if ($coupon->max_discount && $discount > $coupon->max_discount) {
                    $discount = $coupon->max_discount;
                }
            }
        }

        if ($coupon->apply_on === 'payment') {

            $selectedPayment = session('selected_payment_method'); // save when selecting

            if (! $selectedPayment) {
                return response()->json([
                    'status' => false,
                    'message' => 'Select payment method first',
                ]);
            }

            if ($selectedPayment !== $coupon->payment_method) {
                return response()->json([
                    'status' => false,
                    'message' => 'Coupon valid only for ' . ucfirst($coupon->payment_method),
                ]);
            }
            if ($coupon->type === 'fixed') {
                $discount = min($coupon->amount, $subtotal);
            }

            if ($coupon->type === 'percentage') {
                $discount = ($subtotal * $coupon->amount) / 100;

                if ($coupon->max_discount && $discount > $coupon->max_discount) {
                    $discount = $coupon->max_discount;
                }
            }
        }

        if ($coupon->apply_on === 'first_time') {

            if (! $user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Login required to apply this coupon',
                ]);
            }

            $userOrderCount = order()->where('user_id', $user->id)->count();

            if ($userOrderCount > 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'This coupon is only for first time customers',
                ]);
            }
            if ($coupon->type === 'fixed') {
                $discount = min($coupon->amount, $subtotal);
            }

            if ($coupon->type === 'percentage') {
                $discount = ($subtotal * $coupon->amount) / 100;

                if ($coupon->max_discount && $discount > $coupon->max_discount) {
                    $discount = $coupon->max_discount;
                }
            }
        }

        if ($coupon->apply_on === 'cart') {

            if ($coupon->type === 'fixed') {
                $discount = $coupon->amount;
            }

            if ($coupon->type === 'percentage') {
                $discount = ($subtotal * $coupon->amount) / 100;
                if ($coupon->max_discount && $discount > $coupon->max_discount) {
                    $discount = $coupon->max_discount;
                }
            }
        }
        if ($discount > $subtotal) {
            $discount = $subtotal;
        }

        session()->put('applied_coupon', [
            'code' => $coupon->code,
            'discount' => $discount,
            'applied_on' => $coupon->apply_on,
            'affected_products' => $affectedProducts ?? [],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Coupon applied successfully',
            'discount' => $discount,
            'applied_on' => $coupon->apply_on,
            'affected_products' => $affectedProducts ?? [],
            'coupon_code' => $coupon->code,
        ]);
    }

    public function couponCheckLimit(Request $request)
    {
        // dd($request->all());
        $phone = $request->phone;
        $couponCode = $request->coupon;

        // Coupon না থাকলে কিছু বলার দরকার নেই
        if (! $couponCode) {
            return response()->json([
                'allow_apply' => true,
            ]);
        } else {
        }

        $coupon = Coupon::where('code', $couponCode)->first();

        // Coupon invalid হলে remove signal পাঠাও
        if (! $coupon) {
            return response()->json([
                'remove_coupon' => true,
                'message' => 'Invalid coupon.',
            ]);
        }

        // 1️⃣ **Global usage limit check**
        if (! is_null($coupon->usage_limit) && $coupon->used_count >= $coupon->usage_limit) {
            return response()->json([
                'remove_coupon' => true,
                'message' => 'This coupon usage limit has expired.',
            ]);
        }

        // 2️⃣ **Per-user limit check (correct field = per_user_limit)**
        $usedByUser = Order::where('customer_phone', $phone)
            ->where('coupon_code', $couponCode)
            ->count();

        if (! is_null($coupon->per_user_limit) && $usedByUser >= $coupon->per_user_limit) {
            return response()->json([
                'remove_coupon' => true,
                'message' => 'You have already used this coupon.',
            ]);
        }

        // Valid coupon
        return response()->json([
            'allow_apply' => true,
        ]);
    }

    // ❌ REMOVE COUPON
    public function couponRemove()
    {
        session()->forget('applied_coupon');

        return response()->json([
            'status' => true,
            'message' => 'Coupon removed',
        ]);
    }

    public function getShippMeth(Request $request, Theme $theme)
    {
        $shippingMethod = ShippingMethod::find($request->shipping_area);

        if (!$shippingMethod) {
            return response()->json([
                'amount' => 0,
                'error' => 'Shipping method not found'
            ], 404);
        }

        $amount = $shippingMethod->amount;

        $cart = \Cart::getContent();

        // Check if any item has free delivery
        $hasFreeDelivery = true;
        foreach ($cart as $item) {
            if ($item->associatedModel->free_shipping == 0) {
                $hasFreeDelivery = false;
                break;
            }
        }

        if ($hasFreeDelivery) {
            $amount = 0;
        }

        // Update session
        session()->forget('shipping_amount');
        session()->put('shipping_amount', $amount);

        return response()->json([
            'amount' => $amount,
        ]);
    }

    private function getDeviceInfo(): array
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

        // Detect Browser
        $browser = 'Unknown Browser';
        $browserArray = [
            '/msie/i' => 'Internet Explorer',
            '/trident/i' => 'Internet Explorer',
            '/firefox/i' => 'Firefox',
            '/chrome/i' => 'Chrome',
            '/safari/i' => 'Safari',
            '/opera/i' => 'Opera',
            '/edg/i' => 'Edge',
        ];
        foreach ($browserArray as $regex => $name) {
            if (preg_match($regex, $userAgent)) {
                $browser = $name;
                break;
            }
        }

        // Detect OS / Platform
        $platform = 'Unknown OS';
        $osArray = [
            '/windows nt 10/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.1/i' => 'Windows XP',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/android/i' => 'Android',
            '/iphone/i' => 'iOS',
            '/linux/i' => 'Linux',
        ];
        foreach ($osArray as $regex => $name) {
            if (preg_match($regex, $userAgent)) {
                $platform = $name;
                break;
            }
        }

        // Detect device type
        $deviceType = 'Desktop';
        if (preg_match('/mobile/i', $userAgent)) {
            $deviceType = 'Mobile';
        } elseif (preg_match('/tablet|ipad/i', $userAgent)) {
            $deviceType = 'Tablet';
        }

        // Return array
        return [
            'device_type' => $deviceType,
            'device_name' => $platform . ' - ' . $browser,
        ];
    }
    private function generateUniqueDeviceId()
    {
        do {
            $deviceId = Str::random(16);
            $exists = DeviceTrack::where('device_id', $deviceId)->exists();
        } while ($exists);

        return $deviceId;
    }
    // public function placeOrder(Request $request, Theme $theme)
    // {
    //     // dd($request->all());
    //     $request->validate([
    //         'customer_name' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
    //         'customer_phone' => ['required', 'digits:11'],
    //         'customer_address' => ['required', 'string', 'min:10'], // min 10 characters
    //     ], [
    //         'customer_name.required' => 'আপনার পুরো নাম লিখুন।',
    //         'customer_name.regex' => 'নামে শুধুমাত্র অক্ষর এবং স্পেস ব্যবহার করা যাবে।',
    //         'customer_phone.required' => 'আপনার মোবাইল নাম্বার লিখুন।',
    //         'customer_phone.digits' => 'মোবাইল নাম্বার অবশ্যই ঠিক ১১ সংখ্যার হতে হবে।',
    //         'customer_address.required' => 'আপনার ঠিকানা লিখুন।',
    //         'customer_address.min' => 'ঠিকানাটি কমপক্ষে ১০ অক্ষরের হতে হবে।',
    //     ]);
    //     $appliedCoupon = session('applied_coupon');

    //     // ip address
    //     $ip_address = IpAddress::where('ip_address', $request->ip())->first();
    //     if ($ip_address) {
    //         if ($ip_address->status == 0) {
    //             return redirect()->route('home')->with('error', 'You are blocked');
    //         } elseif ($ip_address->status == 1) {
    //             $ip_address->increment('total_order');
    //         }
    //     } else {
    //         IpAddress::create([
    //             'ip_address' => $request->ip(),
    //             'total_order' => 1,
    //             'status' => 1,
    //         ]);
    //     }

    //     // check user block or not
    //     $user = User::where('phone', $request->customer_phone)->first();
    //     if ($user) {
    //         if ($user->status == 0) {
    //             return redirect()->route('home')->with('error', 'You are blocked');
    //         }
    //     }

    //     $deviceId = request()->cookie('device_id');
    //     if (! $deviceId) {
    //         $deviceId = $this->generateUniqueDeviceId();
    //         cookie()->queue('device_id', $deviceId, 60 * 24 * 365);
    //     }

    //     $deviceInfo = $this->getDeviceInfo();
    //     $device_track = DeviceTrack::firstOrCreate(
    //         ['device_id' => $deviceId],
    //         [
    //             'user_id' => $user->id ?? null,
    //             'device_type' => $deviceInfo['device_type'],
    //             'device_name' => $deviceInfo['device_name'],
    //             'status' => 1, // explicitly active for new devices
    //         ]
    //     );
    //     if ($user && $device_track->user_id !== $user->id) {
    //         $device_track->update(['user_id' => $user->id]);
    //     }
    //     if ($device_track->status == 0) {
    //         return redirect()->route('home')->with('error', 'You browser are blocked by admin. Please contact with admin for blocked');
    //     }

    //     if ($appliedCoupon && $user) {
    //         $coupon = Coupon::where('code', $appliedCoupon['code'])->first();
    //         if ($coupon) {
    //             $couponUser = CouponUser::firstOrCreate(
    //                 [
    //                     'coupon_id' => $coupon->id,
    //                     'user_id' => $user->id,
    //                 ],
    //                 [
    //                     'used_count' => 0,
    //                 ]
    //             );
    //             if ($coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
    //                 return redirect()->route('home')->with('error', 'Coupon global usage limit exceeded');
    //             }
    //             if ($coupon->per_user_limit !== null && $couponUser->used_count >= $coupon->per_user_limit) {
    //                 return redirect()->route('home')->with('error', 'You have already used this coupon maximum time');
    //             }
    //             $couponUser->increment('used_count');
    //             $coupon->increment('used_count');
    //         }
    //     }

    //     $carts = \Cart::getContent();
    //     // dd($carts);
    //     if ($carts->count() > 0) {

    //         // create customer account
    //         $check_cus = User::where('phone', $request->customer_phone)->first();
    //         if ($check_cus) {
    //             $customer_id = $check_cus;
    //         } else {
    //             $customer_id = User::create([
    //                 'name' => $request->customer_name,
    //                 'phone' => $request->customer_phone,
    //                 'address' => $request->customer_address,
    //                 'password' => Hash::make($request->customer_phone),
    //             ]);
    //         }

    //         $shippingCost = ShippingMethod::find($request->shipping_method_id)->amount;
    //         // Auth::login($customer_id);
    //         $coupon_discount = $request->coupon_discount ?? 0;
    //         $subtotal = \Cart::getSubTotal();
    //         $total = ($subtotal + $shippingCost) - $coupon_discount;

    //         $order_input = array_merge($request->all(), [
    //             'invoice_id' => invoice_generate(),
    //             'theme_id' => $theme->id,
    //             'order_date' => Carbon::now()->toDateString(),
    //             'customer_id' => $customer_id->id,
    //             'payment_method' => $request->payment_method,
    //             'shipping_method' => $request->shipping_method_id,
    //             'shipping_cost' => $shippingCost,
    //             'sub_total' => $subtotal,
    //             'total' => $total,
    //             'status' => 1,
    //             'source' => 'website',
    //             'ip_address' => $request->ip(),
    //             'device_id' => $deviceId,
    //             'due' => $total,
    //             'coupon_code' => $appliedCoupon['code'] ?? null,
    //             'coupon_discount' => $coupon_discount,
    //             // 'discount' => $coupon_discount,
    //             'coupon_applied_on' => $appliedCoupon['applied_on'] ?? null,
    //         ]);
    //         $order = Order::create($order_input);

    //         // add product into order product table
    //         foreach ($carts as $item) {
    //             $quantity = $item->quantity;
    //             $attributes = $item->attributes[0] ?? null;
    //             $product = Product::find($item->associatedModel->id);
    //             $variant_name = null;
    //             $purchase_price = null;
    //             $sku = $item->id;
    //             $purchase_price = StockManager::getPurchasePrice($product, $sku, $attributes);
    //             $products[] = [
    //                 'product_id' => $product->id ?? $item->associatedModel->id,
    //                 'product_sku' => $item->id,
    //                 'qty' => $quantity,
    //                 'price' => $item->price,
    //                 'variant_name' => $variant_name,
    //             ];

    //             $product_discount = 0;
    //             if ($appliedCoupon && $appliedCoupon['applied_on'] === 'product') {
    //                 $affected = collect($appliedCoupon['affected_products']);
    //                 $match = $affected->firstWhere('product_id', $product->id ?? $item->associatedModel->id);
    //                 if ($match) {
    //                     $product_discount = $match['discount'] ?? 0;
    //                 }
    //             }

    //             OrderProduct::create([
    //                 'order_id' => $order->id,
    //                 'product_id' => $product->id ?? $item->associatedModel->id,
    //                 'product_sku' => $item->id,
    //                 'qty' => $quantity,
    //                 'price' => $item->price,
    //                 'purchase_price' => $purchase_price,
    //                 'attributes' => $attributes,
    //             ]);
    //         }

    //         // abandoned cart delete
    //         if (session()->has('abandoned_cart_id')) {
    //             // update abandoned cart
    //             $abandoned = AbandonedCart::where('id', session()->get('abandoned_cart_id'))->first();
    //             if ($abandoned) {
    //                 $abandoned->delete();
    //                 // dd(session()->get('abandoned_cart_id'));
    //             }
    //             session()->forget('abandoned_cart_id');
    //         }
    //         session()->forget('add_to_cart_event');

    //         // assign employee
    //         $b = Admin::with('get_order_assign')->where('is_order_assign', 1)->where('status', 1)->get();
    //         // dd($b);
    //         if ($b->count() > 0) {
    //             $a = $b->min('get_order_assign');
    //             // dd($a);
    //             if ($a->isNotEmpty()) {
    //                 $b = $a->pluck('employee_id')->toArray();
    //                 $assign = OrderAssign::create([
    //                     'order_id' => $order->id,
    //                     'employee_id' => $b[array_rand($b)],
    //                 ]);
    //             } else {
    //                 $i = $b->random()->id;
    //                 OrderAssign::create([
    //                     'order_id' => $order->id,
    //                     'employee_id' => $i,
    //                 ]);
    //             }
    //         }

    //         // customer note
    //         if ($request->customer_note) {
    //             OrderNote::create([
    //                 'order_id' => $order->id,
    //                 'note' => $request->customer_note,
    //                 'user_id' => $customer_id->id,
    //                 'user_type' => 'customer',
    //             ]);
    //         }

    //         // clear the cart
    //         \Cart::clear();
    //         $currentTheme = $theme;
    //         if ($currentTheme->is_active == 1) {
    //             return redirect()->route('confirm.order', ['invoice_id' => $order->invoice_id])->with('success', 'Order Placed Successfully');
    //         } else {
    //             return redirect()->route('theme.confirm.order', ['path' => $currentTheme->path, 'invoice_id' => $order->invoice_id])->with('success', 'Order Placed Successfully');
    //         }
    //     } else {
    //         return redirect()->route('home')->with('error', 'Please Select Products');
    //     }
    // }



    public function placeOrder(Request $request, Theme $theme)
    {
        // dd($request->all());
        $request->validate([
            'customer_name' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'customer_phone' => ['required', 'digits:11'],
            'customer_address' => ['required', 'string', 'min:10'], // min 10 characters
        ], [
            'customer_name.required' => 'আপনার পুরো নাম লিখুন।',
            'customer_name.regex' => 'নামে শুধুমাত্র অক্ষর এবং স্পেস ব্যবহার করা যাবে।',
            'customer_phone.required' => 'আপনার মোবাইল নাম্বার লিখুন।',
            'customer_phone.digits' => 'মোবাইল নাম্বার অবশ্যই ঠিক ১১ সংখ্যার হতে হবে।',
            'customer_address.required' => 'আপনার ঠিকানা লিখুন।',
            'customer_address.min' => 'ঠিকানাটি কমপক্ষে ১০ অক্ষরের হতে হবে।',
        ]);
        $appliedCoupon = session('applied_coupon');

        // ip address
        $ip_address = IpAddress::where('ip_address', $request->ip())->first();
        if ($ip_address) {
            if ($ip_address->status == 0) {
                return redirect()->route('home')->with('error', 'You are blocked');
            } elseif ($ip_address->status == 1) {
                $ip_address->increment('total_order');
            }
        } else {
            IpAddress::create([
                'ip_address' => $request->ip(),
                'total_order' => 1,
                'status' => 1,
            ]);
        }

        // check user block or not
        $user = User::where('phone', $request->customer_phone)->first();
        if ($user) {
            if ($user->status == 0) {
                return redirect()->route('home')->with('error', 'You are blocked');
            }
        }

        $deviceId = request()->cookie('device_id');
        if (! $deviceId) {
            $deviceId = $this->generateUniqueDeviceId();
            cookie()->queue('device_id', $deviceId, 60 * 24 * 365);
        }

        $deviceInfo = $this->getDeviceInfo();
        $device_track = DeviceTrack::firstOrCreate(
            ['device_id' => $deviceId],
            [
                'user_id' => $user->id ?? null,
                'device_type' => $deviceInfo['device_type'],
                'device_name' => $deviceInfo['device_name'],
                'status' => 1, // explicitly active for new devices
            ]
        );
        if ($user && $device_track->user_id !== $user->id) {
            $device_track->update(['user_id' => $user->id]);
        }
        if ($device_track->status == 0) {
            return redirect()->route('home')->with('error', 'You browser are blocked by admin. Please contact with admin for blocked');
        }

        if ($appliedCoupon && $user) {
            $coupon = Coupon::where('code', $appliedCoupon['code'])->first();
            if ($coupon) {
                $couponUser = CouponUser::firstOrCreate(
                    [
                        'coupon_id' => $coupon->id,
                        'user_id' => $user->id,
                    ],
                    [
                        'used_count' => 0,
                    ]
                );
                if ($coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
                    return redirect()->route('home')->with('error', 'Coupon global usage limit exceeded');
                }
                if ($coupon->per_user_limit !== null && $couponUser->used_count >= $coupon->per_user_limit) {
                    return redirect()->route('home')->with('error', 'You have already used this coupon maximum time');
                }
                $couponUser->increment('used_count');
                $coupon->increment('used_count');
            }
        }

        $carts = \Cart::getContent();
        // dd($carts);
        if ($carts->count() > 0) {

            // create customer account
            $check_cus = User::where('phone', $request->customer_phone)->first();
            if ($check_cus) {
                $customer_id = $check_cus;
            } else {
                $customer_id = User::create([
                    'name' => $request->customer_name,
                    'phone' => $request->customer_phone,
                    'address' => $request->customer_address,
                    'password' => Hash::make($request->customer_phone),
                ]);
            }

            $shippingCost = ShippingMethod::find($request->shipping_method_id)->amount;
            $coupon_discount = $request->coupon_discount ?? 0;
            $subtotal = \Cart::getSubTotal();
            $total = ($subtotal + $shippingCost) - $coupon_discount;

            $order_input = array_merge($request->all(), [
                'invoice_id' => invoice_generate(),
                'theme_id' => $theme->id,
                'order_date' => Carbon::now()->toDateString(),
                'customer_id' => $customer_id->id,
                'payment_method' => $request->payment_method,
                'shipping_method' => $request->shipping_method_id,
                'shipping_cost' => $shippingCost,
                'sub_total' => $subtotal,
                'total' => $total,
                'status' => 1,
                'source' => 'website',
                'ip_address' => $request->ip(),
                'device_id' => $deviceId,
                'due' => $total,
                'coupon_code' => $appliedCoupon['code'] ?? null,
                'coupon_discount' => $coupon_discount,
                'coupon_applied_on' => $appliedCoupon['applied_on'] ?? null,
            ]);
            $order = Order::create($order_input);

            // add product into order product table
            foreach ($carts as $item) {
                $quantity = $item->quantity;
                $attributes = $item->attributes[0] ?? null;
                $product = Product::find($item->associatedModel->id);

                if (!$product) continue;

                $variant_choice = $attributes ? str_replace('-', ',', $attributes) : null;
                $is_combo = $product->is_combo ?? 0;

                if ($is_combo == 1) {
                    $sku = $product->sku ?? null;
                } else {
                    $sku = $item->id;
                }

                $purchase_price = StockManager::getPurchasePrice($product, $sku, $variant_choice);

                $comboPurchasePriceSum = 0;
                $comboItemsData = [];

                // Handle Combo Items if product is combo
                if ($is_combo == 1) {
                    $comboItems = $product->comboItems; // Product model relation
                    foreach ($comboItems as $comboItem) {
                        // dd($comboItem);
                        $childProduct = Product::with('get_variants')->find($comboItem->product_id);
                        // dd($childProduct);
                        if (!$childProduct) continue;

                        $childSku = $comboItem->sku ?? ($childProduct->sku ?? null);
                        $childVariantId = $comboItem->variant_id ?? null;
                        $childQty = ($comboItem->qty ?? 1);

                        $childVariantChoice = null;
                        // dd($childProduct->has_variant, $childProduct->get_variants->count());

                        // Jodi child product-er variant thake ebong variant_id explicitly set na thake,
                        // tahole prothom/default variant ti automatic select kore nibe
                        if (empty($childVariantId) && $childProduct->has_variant == 1 && $childProduct->get_variants->count() > 0) {
                            $firstVariant = $childProduct->get_variants->first();
                            if ($firstVariant) {
                                $childVariantId = $firstVariant->id;
                                if (!empty($firstVariant->sku)) {
                                    $childSku = $firstVariant->sku;
                                }
                                if (method_exists($firstVariant, 'items')) {
                                    $childVariantChoice = $firstVariant->items->pluck('attribute_item_id')->implode(',');
                                }
                            }
                        } elseif (!empty($childVariantId)) {
                            $variant = ProductVariant::with('items')->find($childVariantId);
                            if ($variant) {
                                if (!empty($variant->sku)) {
                                    $childSku = $variant->sku;
                                }
                                if (method_exists($variant, 'items')) {
                                    $childVariantChoice = $variant->items->pluck('attribute_item_id')->implode(',');
                                }
                            }
                        }

                        $childPurchasePrice = StockManager::getPurchasePrice($childProduct, $childSku, $childVariantChoice);
                        $comboPurchasePriceSum += ($childPurchasePrice * $childQty);

                        $comboItemsData[] = [
                            'product_id' => $childProduct->id ?? null,
                            'sku'        => $childSku,
                            'qty'        => $childQty,
                            'variant_id' => $childVariantId,
                        ];
                    }
                    $purchase_price = $comboPurchasePriceSum;
                }

                $orderProduct = OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_sku' => $sku,
                    'qty' => $quantity,
                    'price' => $item->price,
                    'purchase_price' => $purchase_price,
                    'attributes' => $attributes,
                ]);

                // Save Combo Child items to OrderComboItem table
                if ($is_combo == 1 && !empty($comboItemsData)) {
                    foreach ($comboItemsData as $comboData) {
                        OrderComboItem::create([
                            'order_product_id' => $orderProduct->id,
                            'product_id'       => $comboData['product_id'],
                            'sku'              => $comboData['sku'],
                            'qty'              => $comboData['qty'],
                            'variant_id'       => $comboData['variant_id'],
                        ]);
                    }
                }
            }

            // If order status is 8 (On Delivery), decrease stock immediately
            // if ((int)$order->status === 8) {
            //     StockManager::decreaseStockForOrder($order->load('get_products.orderComboItems')->get_products);
            // }

            // abandoned cart delete
            if (session()->has('abandoned_cart_id')) {
                $abandoned = AbandonedCart::where('id', session()->get('abandoned_cart_id'))->first();
                if ($abandoned) {
                    $abandoned->delete();
                }
                session()->forget('abandoned_cart_id');
            }
            session()->forget('add_to_cart_event');

            // assign employee
            $b = Admin::with('get_order_assign')->where('is_order_assign', 1)->where('status', 1)->get();
            if ($b->count() > 0) {
                $a = $b->min('get_order_assign');
                if ($a && $a->isNotEmpty()) {
                    $b = $a->pluck('employee_id')->toArray();
                    OrderAssign::create([
                        'order_id' => $order->id,
                        'employee_id' => $b[array_rand($b)],
                    ]);
                } else {
                    $i = $b->random()->id;
                    OrderAssign::create([
                        'order_id' => $order->id,
                        'employee_id' => $i,
                    ]);
                }
            }

            // customer note
            if ($request->customer_note) {
                OrderNote::create([
                    'order_id' => $order->id,
                    'note' => $request->customer_note,
                    'user_id' => $customer_id->id,
                    'user_type' => 'customer',
                ]);
            }

            // clear the cart
            \Cart::clear();
            $currentTheme = $theme;
            if ($currentTheme->is_active == 1) {
                return redirect()->route('confirm.order', ['invoice_id' => $order->invoice_id])->with('success', 'Order Placed Successfully');
            } else {
                return redirect()->route('theme.confirm.order', ['path' => $currentTheme->path, 'invoice_id' => $order->invoice_id])->with('success', 'Order Placed Successfully');
            }
        } else {
            return redirect()->route('home')->with('error', 'Please Select Products');
        }
    }


    public function confirmOrder(Request $request, Theme $theme)
    {
        $currentTheme = $theme;
        $order = Order::where('invoice_id', $request->invoice_id)->first();
        if ($theme->is_active == 1) {
            return view('frontEnd.' . $theme->path . '.pages.order_confirm', compact('order', 'theme', 'currentTheme'));
        } else {
            return view('frontEnd.' . $theme->path . '.pages.order_confirm', compact('order', 'theme', 'currentTheme'));
        }
    }
}
