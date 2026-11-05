<?php

namespace App\Http\Controllers;

use App\AbandonedCart;
use App\Category;
use App\DeviceTrack;
use App\IpAddress;
use App\LandingCategory;
use App\LandingPage;
use App\LandingTheme;
use App\Order;
use App\OrderProduct;
use App\Product;
use App\ProductVariant;
use App\ShippingMethod;
use App\User;
use App\Coupon;
use App\CouponUser;
use App\OrderNote;
use App\OrderAssign;
use App\Admin;
use App\Theme;
use Carbon\Carbon;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class LandingPageController extends Controller
{
    // INDEX PAGE
    public function index()
    {
        $pages = LandingPage::with('theme')->orderBy('id', 'DESC')->get();

        return view('backEnd.admin.landing-pages.index', compact('pages'));
    }

    // CREATE PAGE
    public function create()
    {
        $themes = LandingTheme::orderBy('title')->get();
        $products = Product::orderBy('name')->where('status', true)->get();
        $categories = LandingCategory::orderBy('title')->with('themes')->where('status', true)->get();

        return view('backEnd.admin.landing-pages.create', compact('themes', 'products', 'categories'));
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'theme_id' => 'required|integer',
        ]);
        $page = LandingPage::create($request->all());

        // return redirect()->route('admin.landing.pages.index')->with('success', 'Page Created Successfully');
        return redirect()->route('admin.landing.pages.customize', $page->slug)->with('success', 'Page Created Successfully');
    }

    // EDIT PAGE
    public function edit($id)
    {
        $page = LandingPage::findOrFail($id);

        $products = Product::orderBy('name')->get();
        $categories = LandingCategory::with('themes')->orderBy('title')->get();

        // Determine active category tab
        $activeCategoryId = $page->theme ? $page->theme->category_id : $categories->first()->id;

        return view('backEnd.admin.landing-pages.edit', compact('page', 'products', 'categories', 'activeCategoryId'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $page = LandingPage::findOrFail($id);

        $request->validate([
            'title' => 'required|max:255',
            'theme_id' => 'required|integer',
        ]);

        $data = $page->theme_id != $request->theme_id ? ['style' => null, 'content' => null] : [];
        $page->update(array_merge($request->all(), $data));

        return redirect()->route('admin.landing.pages.customize', $page->slug)->with('success', 'Page Updated Successfully');
    }

    // DELETE
    public function destroy($id)
    {
        LandingPage::where('id', $id)->delete();

        return back()->with('success', 'Page Deleted Successfully');
    }

    public function bulkDelete(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:landing_pages,id' // আপনার ডাটাবেজ টেবিল নাম দেবেন
        ]);
        try {
            DB::beginTransaction();
            // Perform Bulk Delete
            LandingPage::whereIn('id', $request->ids)->delete();
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
    //bulkDeleteTheme
    public function bulkDeleteTheme(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:landing_themes,id' // আপনার ডাটাবেজ টেবিল নাম দেবেন
        ]);
        try {
            DB::beginTransaction();
            // Perform Bulk Delete
            LandingTheme::whereIn('id', $request->ids)->delete();
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

    //bulkDeleteCategory
    public function bulkDeleteCategory(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:landing_categories,id' // আপনার ডাটাবেজ টেবিল নাম দেবেন
        ]);
        try {
            DB::beginTransaction();
            // Perform Bulk Delete
            LandingCategory::whereIn('id', $request->ids)->delete();
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

    // CUSTOMIZE
    public function customize($slug)
    {
        $landingPage = LandingPage::where('slug', $slug)->firstOrFail();
        // Ensure the Blade file exists
        $this->createTemplate($landingPage->theme);

        $enableEdit = true;
        $landingTheme = $landingPage->theme;
        $products = Product::with('get_thumb', 'get_gallery_images', 'get_variants')->whereIn('id', $landingPage->product_ids)->get();
        $shippingCost  = ShippingMethod::select('amount', 'type', 'id')->get();

        return view('landing-pages.' . $landingPage->theme->slug, compact('landingPage', 'landingTheme', 'enableEdit', 'products', 'shippingCost'));
    }

    // THEME PREVIEW
    public function preview($slug)
    {
        $shippingCost = ShippingMethod::select('amount', 'type', 'id')->get();
        $landingTheme = LandingTheme::where('slug', $slug)->firstOrFail();
        // Ensure the Blade file exists
        $this->createTemplate($landingTheme);

        return view('landing-pages.' . $landingTheme->slug, compact('shippingCost', 'landingTheme'));
    }

    /**______________________________________________________________________________________________
     *_______________________________________________________________________________________________
     *Category
     *_______________________________________________________________________________________________
     *_______________________________________________________________________________________________
     */

    public function indexCategory()
    {
        $categories = LandingCategory::latest()->get();

        return view('backEnd.admin.landing-pages.landing-category', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:landing_categories,title',
            'status' => 'required',
        ]);

        LandingCategory::create($request->all());

        return redirect()->back()->with('success', 'Category Created Successfully');
    }

    public function updateCategory(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:landing_categories,title,' . $request->id,
            'status' => 'required',
        ]);

        $category = LandingCategory::find($request->id);

        $category->update($request->all());

        return redirect()->back()->with('success', 'Category Updated Successfully');
    }

    public function destroyCategory($id)
    {
        LandingCategory::where('id', $id)->delete();

        return back()->with('success', 'Page Deleted Successfully');
    }

    /**______________________________________________________________________________________________
     *_______________________________________________________________________________________________
     * Theme
     *_______________________________________________________________________________________________
     *_______________________________________________________________________________________________
     */
    public function indexTheme()
    {
        $themes = LandingTheme::with('category')->latest()->get();
        $categories = LandingCategory::where('status', 1)->get();

        return view('backEnd.admin.landing-pages.landing-theme', compact('themes', 'categories'));
    }

    public function storeTheme(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:landing_themes,title',
            'category_id' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $image_id = null;

        if ($request->hasFile('image')) {
            // Example: Resize to 600x400 (or whatever you want)
            $image_id = uploadFile($request->file('image'), 600, 400);
        }

        $theme = LandingTheme::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'image' => $image_id,
        ]);
        // File Create
        $this->createTemplate($theme);

        return back()->with('success', 'Theme Created Successfully');
    }

    public function updateTheme(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:landing_themes,title,' . $request->id,
            'category_id' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $theme = LandingTheme::findOrFail($request->id);

        $image_id = $theme->image; // keep old image

        if ($request->hasFile('image')) {
            // upload new file
            $image_id = uploadFile($request->file('image'), 600, 400);
        }

        $theme->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'image' => $image_id,
        ]);
        // File Create
        $this->createTemplate($theme);

        return back()->with('success', 'Theme Updated Successfully');
    }

    private function createTemplate(LandingTheme $theme)
    {

        $themeViewPath = resource_path('views/landing-pages/' . $theme->slug . '.blade.php');
        // dd($themeViewPath);

        if (! file_exists($themeViewPath)) {
            $defaultContent = <<<BLADE
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Landing Page - {$theme->title}</title>
                <link rel="stylesheet" href="{{ asset('landing-page/{$theme->slug}/css/style.css') }}">
            </head>
            <body>
                <div class="container">
                    <h1><strong>Theme Name:</strong> {$theme->title}</h1>
                </div>
            </body>
            </html>
            BLADE;

            // Ensure directory exists
            if (! is_dir(dirname($themeViewPath))) {
                mkdir(dirname($themeViewPath), 0755, true);
            }
            // Create the file
            file_put_contents($themeViewPath, $defaultContent);
        }

        // Public Path folder Create
        $publicFolder = public_path('landing-page/' . $theme->slug);
        if (! is_dir($publicFolder)) {
            mkdir($publicFolder, 0755, true);
        }
    }

    /**______________________________________________________________________________________________
     *_______________________________________________________________________________________________
     * CONTENT SAVE
     *_______________________________________________________________________________________________
     *_______________________________________________________________________________________________
     */
    public function save(Request $request, $id)
    {
        // dd($request->all());
        try {
            // $request->validate([
            //     'content' => 'required|array',
            //     'style' => 'required|array',
            //     'section_status' => 'nullable|array',
            // ]);

            $landingPage = LandingPage::findOrFail($id);

            $currentContent = json_decode($landingPage->content ?? '{}', true);
            $currentStyle = json_decode($landingPage->style ?? '{}', true);

            $newContent = array_merge($currentContent, $request->content);
            $newStyle = array_merge($currentStyle, $request->style);

            if ($request->has('section_status')) {
                $newContent['section_status'] = $request->section_status;
            }

            $landingPage->update([
                'content' => json_encode($newContent, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
                'style' => json_encode($newStyle, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Landing page saved successfully!',
                'data' => [
                    'id' => $landingPage->id,
                    'updated_at' => $landingPage->updated_at,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save landing page: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function uploadImage(Request $request)
    {
        // dd($request->all());
        try {
            // $request->validate([
            //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            //     'image_id' => 'required|integer',
            // ]);

            $image = $request->file('image');
            $imageId = $request->image_id;

            $destinationPath = 'uploads/landing-page/images';
            $absolutePath = public_path($destinationPath);
            $filename = 'lp-' . $imageId . '-' . time() . '.' . $image->getClientOriginalExtension();

            $image->move($absolutePath, $filename);

            $publicUrl = asset($destinationPath . '/' . $filename);

            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully!',
                'path' => $publicUrl,
            ]);
        } catch (\Exception $e) {
            // Log::error('Image Upload failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**______________________________________________________________________________________________
     *_______________________________________________________________________________________________
     * FRONTEND SITE
     *_______________________________________________________________________________________________
     *_______________________________________________________________________________________________
     */

    /**
     * Display landing page
     */
    public function homePage($slug)
    {
        $landingPage = LandingPage::where('slug', $slug)->firstOrFail();
        $landingTheme = $landingPage->theme;
        $products = Product::with('get_thumb', 'get_gallery_images', 'get_variants')->whereIn('id', $landingPage->product_ids)->get();

        $shippingCost  = ShippingMethod::select('amount', 'type', 'id')->get();

        // dd(\Cart::getContent());
        // \Cart::clear();
        return view('landing-pages.' . $landingPage->theme->slug, compact('landingPage', 'landingTheme', 'products', 'shippingCost'));
    }

    public function addToCart(Request $request)
    {
        // \Cart::clear();
        $quantity = (int) ($request->qty ?? 1);
        $product = Product::findOrFail($request->id);

        // ✅ Cart key সবসময় product_id — variant বদলালেও same key থাকবে
        $cartKey  = 'product_' . $product->id;
        $price    = $product->sale_price > 0 ? $product->sale_price : $product->regular_price;
        $variantKey = null;

        /* ---------- VARIANT HANDLING ---------- */
        if ($request->has('attribute_item_id') && is_array($request->attribute_item_id)) {
            $variantKey = implode('-', $request->attribute_item_id);
            $variant = ProductVariant::where('product_id', $product->id)
                ->where('variant', $variantKey)
                ->first();

            if ($variant) {
                $price = $variant->sale_price > 0 ? $variant->sale_price : $variant->regular_price;
            }
        }

        /* ---------- CHECK IF ITEM EXISTS IN CART ---------- */
        $existingItem = \Cart::get($cartKey);

        if ($existingItem) {
            // ✅ Same product — শুধু quantity, price ও variant আপডেট করো
            \Cart::update($cartKey, [
                'price'    => (float) $price,
                'quantity' => [
                    'relative' => false,
                    'value'    => $quantity,
                ],
                'attributes' => $variantKey,
            ]);
        } else {
            // ✅ নতুন প্রোডাক্ট — কার্টে অ্যাড করো
            \Cart::add([
                'id'             => $cartKey,
                'name'           => $product->name,
                'price'          => (float) $price,
                'quantity'       => $quantity,
                'attributes'     => $variantKey,
                'associatedModel' => $product,
            ]);
        }

        return response()->json([
            'success'     => true,
            'cart_id'     => $cartKey,
            'total_price' => number_format($price * $quantity, 2),
            'message'     => 'Cart updated successfully',
        ]);
    }

    /**
     * Remove product from cart (AJAX)
     */
    public function removeFromCart(Request $request)
    {
        Cart::remove($request->id);

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart',
            'cart_count' => Cart::getContent()->count(),
        ]);
    }

    /**
     * Update cart quantity (AJAX)
     */
    public function updateCartQuantity(Request $request)
    {
        Cart::update($request->id, [
            'quantity' => [
                'relative' => false,
                'value' => (int) $request->qty,
            ],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Quantity updated',
            'cart_count' => Cart::getContent()->count(),
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
    public function placeOrder(Request $request)
    {
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

            $shippingCost = ShippingMethod::find($request->shipping_method)->amount ?? 0;
            // Auth::login($customer_id);
            $coupon_discount = $request->coupon_discount ?? 0;
            $subtotal = \Cart::getSubTotal();
            $total = ($subtotal + $shippingCost) - $coupon_discount;

            $order_input = array_merge($request->all(), [
                'invoice_id' => invoice_generate(),
                'theme_id' => activeTheme()->id,
                'order_date' => Carbon::now()->toDateString(),
                'customer_id' => $customer_id->id,
                'payment_method' => $request->payment_method,
                'shipping_method' => $request->shipping_method,
                'shipping_cost' => $shippingCost,
                'sub_total' => $subtotal,
                'total' => $total,
                'status' => 1,
                'source' => 'landing',
                'ip_address' => $request->ip(),
                'due' => $total,
                'coupon_code' => $appliedCoupon['code'] ?? null,
                'coupon_discount' => $coupon_discount,
                // 'discount' => $coupon_discount,
                'coupon_applied_on' => $appliedCoupon['applied_on'] ?? null,
            ]);
            $order = Order::create($order_input);

            // add product into order product table
            foreach ($carts as $item) {
                $quantity = $item->quantity;
                $attributes = $item->attributes[0] ?? null;
                $product = Product::find($item->associatedModel->id);
                $variant_name = null;
                $purchase_price = null;

                if ($product && $product->has_variant == 1 && $attributes) {
                    $product_attr = ProductVariant::with('items')->where('sku', $item->id)->where('variant', $attributes)->first();
                    $purchase_price = $product_attr->purchase_price ?? $product->purchase_price;

                    if ($product_attr) {
                        $variant_name = $product_attr->items->map(fn($it) => $it->name)->implode(', ');
                        $product_attr->decrement('stock', $quantity);
                        $product->decrement('stock', $quantity);
                    }
                } elseif ($product) {
                    if ($product->is_package == 1) {
                        $product->decrement('stock', $quantity * $product->package_qty);
                    } elseif ($product->is_combo == 1) {
                        $comboItems = $product->comboItems()->get();
                        foreach ($comboItems as $comboItem) {
                            $comboItem->product->decrement('stock', $comboItem->quantity * $quantity);
                        }
                        $product->decrement('stock', $quantity);
                    } else {
                        $product->decrement('stock', $quantity);
                    }
                    $purchase_price = $product->purchase_price;
                }

                $products[] = [
                    'product_id' => $product->id ?? $item->associatedModel->id,
                    'product_sku' => $item->id,
                    'qty' => $quantity,
                    'price' => $item->price,
                    'variant_name' => $variant_name,
                ];
                $product_discount = 0;
                if ($appliedCoupon && $appliedCoupon['applied_on'] === 'product') {
                    $affected = collect($appliedCoupon['affected_products']);
                    $match = $affected->firstWhere('product_id', $product->id ?? $item->associatedModel->id);
                    if ($match) {
                        $product_discount = $match['discount'] ?? 0;
                    }
                }

                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id ?? $item->associatedModel->id,
                    'product_sku' => $item->id,
                    'qty' => $quantity,
                    'price' => $item->price,
                    'purchase_price' => $purchase_price,
                    'attributes' => $attributes,
                ]);
            }

            // abandoned cart delete
            if (session()->has('abandoned_cart_id')) {
                // update abandoned cart
                $abandoned = AbandonedCart::where('id', session()->get('abandoned_cart_id'))->first();
                $abandoned->delete();
                session()->forget('abandoned_cart_id');
            }

            // assign employee
            $employees = Admin::where('is_order_assign', 1)
                ->where('status', 1)
                ->withCount('get_order_assign')
                ->get();
            if ($employees->count() > 0) {
                $minOrder = $employees->min('get_orders_count');
                $leastLoadedEmployees = $employees->where('get_orders_count', $minOrder);
                $employee = $leastLoadedEmployees->random();
                OrderAssign::create([
                    'order_id' => $order->id,
                    'employee_id' => $employee->id,
                ]);
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

            $old_data = array_merge($order_input, [
                'products' => $products,
            ]);



            // clear the cart
            \Cart::clear();

            return redirect()->route('order.confirmation', ['order' => $order->invoice_id])->with('success', 'Order Placed Successfully!');
        } else {
            return redirect()->route('home')->with('error', 'Please Select Products');
        }
    }

    public function orderConfirmation($order)
    {
        // Retrieve the order with its products
        $order = Order::with('get_products')->where('invoice_id', $order)->firstOrFail();

        return view('landing-pages.order_confirmation', compact('order'));
    }

    public function abandonedCart(Request $request)
    {
        $carts = \Cart::getContent();

        if ($carts->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Cart is empty']);
        }

        $abandoned_item = [];
        $total = 0;
        $subtotal = 0;

        foreach ($carts as $key => $item) {
            $abandoned_item[$key] = [
                'product_id' => $item->associatedModel->id,
                'qty'        => $item->quantity,
                'price'      => $item->price,
                'sku'        => $item->id,
                'variant'    => $item->attributes->count() > 0 ? $item->attributes[0] : null,
            ];
            $total += $item->quantity * $item->price;
            $subtotal += $item->quantity * $item->price;
        }

        $shipping_cost = $request->data['shipping_cost'] ?? 0;

        $input = [
            'customer_name'    => $request->data['name'] ?? 'Guest Customer',
            'customer_phone'   => $request->data['phone'],
            'customer_address' => $request->data['address'] ?? '',
            'shipping_cost'    => $shipping_cost,
            'total'            => $total + $shipping_cost,
            'subtotal'         => $subtotal,
            'abandoned_item'   => json_encode($abandoned_item),
            'theme_id'         => Theme::where('is_active', 1)->first()->id ?? 1,
        ];

        // 🎯 রিকোয়েস্ট থেকে আসা আইডি অথবা সেশনের আইডি ট্র্যাক করা হচ্ছে
        $cartId = $request->data['abandoned_cart_id'] ?? session()->get('abandoned_cart_id');
        $abandoned = null;

        if (!empty($cartId)) {
            $abandoned = AbandonedCart::find($cartId);
        }

        if ($abandoned) {
            // আইডি খুঁজে পাওয়া গেলে আগের ডাটা আপডেট হবে
            $abandoned->update($input);
        } else {
            // আইডি না থাকলে নতুন করে তৈরি হবে
            $abandoned = AbandonedCart::create($input);
            session()->put('abandoned_cart_id', $abandoned->id);
        }


        return response()->json([
            'success' => true,
            'message' => 'Abandoned cart synced successfully',
            'abandoned_cart_id' => $abandoned->id
        ]);
    }
    public function getAttributes(Request $request)
    {
        $productId = $request->product_id;
        $selectedItemIds = $request->attribute_item_id;

        if (! $productId || ! $selectedItemIds || ! is_array($selectedItemIds)) {
            return response()->json([
                'success' => 400,
                'message' => 'Invalid request data.',
            ]);
        }

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

        $variantKey = implode('-', $selectedItemIds);
        $matchedVariant = $product->get_variants->firstWhere('variant', $variantKey);

        if (! $matchedVariant) {
            return response()->json([
                'success' => 404,
                'message' => 'Variant not found for selected attributes.',
            ]);
        }

        return response()->json([
            'success' => 200,
            'message' => 'Variant found successfully.',
            'data' => [
                'sku' => $matchedVariant->sku,
                'regular_price' => $matchedVariant->regular_price,
                'sale_price' => $matchedVariant->sale_price,
                'stock' => $matchedVariant->stock,
                'variant_key' => $matchedVariant->variant,
                'selected_ids' => $selectedItemIds,
                'variant_items' => $matchedVariant->items->map(function ($item) {
                    return [
                        'attribute_item' => $item->attribute_item->name ?? null,
                    ];
                }),
            ],
        ]);
    }
}
