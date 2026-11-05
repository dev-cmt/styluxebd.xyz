<?php

namespace App\Http\Controllers;

use App\AccountTransaction;
use App\Admin;
use App\ApiCourier;
use App\CarrybeeCity;
use App\CarrybeeZone;
use App\Courier;
use App\Exports\OrderExport;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderAssign;
use App\OrderComboItem;
use App\OrderNote;
use App\OrderProduct;
use App\PathaoCity;
use App\PathaoZone;
use App\PrintSetting;
use App\Product;
use App\ProductAttribute;
use App\ProductVariant;
use App\RedxArea;
use App\Services\StockManager;
use App\ShippingMethod;
use App\User;
use App\WebSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{

    public function index(Request $request)
    {

        $themeId = activeThemeData()->id;
        $perPage = (int) $request->get('per_page', 20);
        $courier_id     = $request->courier_id;
        $source         = $request->source;
        $payment_status = $request->payment_status;
        $search         = $request->input('query');
        $sts            = $request->status ?: 'pending';

        $statusMap = [
            'pending'        => 1,
            'confirm'        => 2,
            'processing'     => 3,
            'hold'           => 4,
            'printed'        => 5,
            'packaging'      => 6,
            'courier_entry'  => 7,
            'on_delivery'    => 8,
            'delivered'      => 9,
            'partial_delivered' => 14,
            'cancelled'      => 10,
            'returned'       => 11,
            'return_received' => 12,
            'exchange'       => 13
        ];

        /* ===============================
            BASE QUERY
        =============================== */
        $baseQuery = Order::query()->where('theme_id', $themeId);

        /* ===============================
            FILTERS
        =============================== */
        $baseQuery->when($courier_id, fn($q) => $q->where('courier_id', $courier_id))
            ->when($source, fn($q) => $q->where('source', $source))
            ->when($payment_status !== null && $payment_status !== '', fn($q) => $q->where('payment_status', $payment_status))
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('customer_phone', 'LIKE', "%{$search}%")
                        ->orWhere('customer_name', 'LIKE', "%{$search}%")
                        ->orWhere('invoice_id', 'LIKE', "%{$search}%");
                });
            });

        /* ===============================
            DATE RANGE
        =============================== */
        $start = $end = null;
        if ($request->filled('date_range')) {
            $range = is_array($request->date_range) ? $request->date_range : json_decode($request->date_range, true);
            if (!empty($range['start']) && !empty($range['end'])) {
                $start = Carbon::parse($range['start'])->startOfDay();
                $end   = Carbon::parse($range['end'])->endOfDay();
                $baseQuery->whereBetween('created_at', [$start, $end]);
            }
        }

        /* ===============================
            STATUS COUNTS
        =============================== */
        $statusCounts = (clone $baseQuery)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->map(fn($val) => (int) $val); // String থেকে Integer conversion



        $data = [
            'total_order'               => $statusCounts->sum(),
            'total_pending_order'       => $statusCounts[1]  ?? 0,
            'total_confirm_order'       => $statusCounts[2]  ?? 0,
            'total_processing_order'    => $statusCounts[3]  ?? 0,
            'total_hold_order'          => $statusCounts[4]  ?? 0,
            'total_printed_order'       => $statusCounts[5]  ?? 0,
            'total_packaging_order'     => $statusCounts[6]  ?? 0,
            'total_courier_entry_order' => $statusCounts[7]  ?? 0,
            'total_on_delivery_order'   => $statusCounts[8]  ?? 0,
            'total_delivered_order'     => $statusCounts[9]  ?? 0,
            'total_partial_delivered_order'   => $statusCounts[14] ?? 0,
            'total_cancelled_order'     => $statusCounts[10] ?? 0,
            'total_returned_order'      => $statusCounts[11] ?? 0,
            'total_return_received_order'     => $statusCounts[12] ?? 0,
            'total_exchange_order'            => $statusCounts[13] ?? 0,
            'total_trash_order'         => Order::onlyTrashed()->where('theme_id', $themeId)->count(),
        ];

        /* ===============================
            STATUS FILTER
        =============================== */
        $filteredQuery = clone $baseQuery;
        if ($sts && $sts !== 'total' && isset($statusMap[$sts])) {
            $filteredQuery->where('status', $statusMap[$sts]);
        }

        // dd($filteredQuery);

        /* ===============================
            PAGINATED ORDERS FETCHING
        =============================== */
        $orders = $filteredQuery
            ->select([
                'id',
                'theme_id',
                'invoice_id',
                'order_date',
                'created_at',
                'source',
                'customer_name',
                'customer_phone',
                'customer_address',
                'device_id',
                'ip_address',
                'customer_activity',
                'sub_total',
                'discount',
                'coupon_discount',
                'shipping_cost',
                'total',
                'paid',
                'due',
                'courier_id',
                'consignment_id',
                'tracking_id',
                'courier_status',
                'courier_city_id',
                'courier_zone_id',
                'payment_status',
                'status'
            ])
            ->with([
                'get_products:id,order_id,product_id,qty,price,discount,attributes',
                'get_products.get_product:id,name,slug,sku,has_variant,thumb,is_combo',
                'get_products.get_product.get_thumb:id,file_url',
                'get_courier:id,courier_name',
                'get_assigned:id,order_id,employee_id',
                'get_assigned.get_employee:id,name',
                'get_staff_notes' => fn($q) => $q->latest()->limit(1),
                'get_customer_notes' => fn($q) => $q->latest()->limit(1),
            ])
            ->orderByDesc('id')
            ->paginate($perPage);

        // dd($orders);

        /* ===============================
            DUPLICATE CHECK (PAGE LEVEL ONLY)
        =============================== */
        $pagePhones = $orders->pluck('customer_phone')->filter()->unique()->toArray();
        $duplicatePhones = [];

        if (!empty($pagePhones)) {
            $duplicatePhones = Order::where('theme_id', $themeId)
                ->whereIn('customer_phone', $pagePhones)
                ->select('customer_phone')
                ->groupBy('customer_phone')
                ->havingRaw('COUNT(*) > 1')
                ->pluck('customer_phone')
                ->toArray();
        }

        $orders->transform(function ($order) use ($duplicatePhones) {
            $order->is_duplicate = in_array($order->customer_phone, $duplicatePhones);
            return $order;
        });

        $data['orders'] = $orders;
        $couriers = Courier::where('status', 1)->pluck('courier_name', 'id');

        // Check AJAX standard request
        if ($request->ajax()) {
            return response()->json([
                'counter_html' => view('backEnd.admin.orders.partials.counter-order', [
                    'statusCards' => $this->getStatusCards($data),
                    'status'      => $sts,
                ])->render(),
                'table_html'   => view('backEnd.admin.orders.partials.order-table-body', [
                    'orders'   => $orders,
                    'couriers' => $couriers,
                ])->render(),
            ]);
        }
        // dd($orders);

        return view('backEnd.admin.orders.index', compact(
            'data',
            'couriers',
            'courier_id',
            'search',
            'sts',
            'payment_status',
            'source',
            'start',
            'end'
        ));
    }

    private function getStatusCards($data)
    {
        return [
            ['title' => 'Orders', 'value' => $data['total_order'], 'status' => 'total', 'color' => 'secondary', 'textColor' => 'text-secondary'],
            ['title' => 'Pending', 'value' => $data['total_pending_order'], 'status' => 'pending', 'color' => 'warning', 'textColor' => 'text-warning'],
            ['title' => 'Confirmed', 'value' => $data['total_confirm_order'], 'status' => 'confirm', 'color' => 'primary', 'textColor' => 'text-primary'],
            ['title' => 'Processing', 'value' => $data['total_processing_order'], 'status' => 'processing', 'color' => 'info', 'textColor' => 'text-info'],
            ['title' => 'Hold', 'value' => $data['total_hold_order'], 'status' => 'hold', 'color' => 'purple', 'textColor' => 'text-purple'],
            ['title' => 'Printed', 'value' => $data['total_printed_order'], 'status' => 'printed', 'color' => 'secondary', 'textColor' => 'text-secondary'],
            ['title' => 'Packaged', 'value' => $data['total_packaging_order'], 'status' => 'packaging', 'color' => 'orange', 'textColor' => 'text-orange'],
            ['title' => 'Courier Entry', 'value' => $data['total_courier_entry_order'], 'status' => 'courier_entry', 'color' => 'azure', 'textColor' => 'text-azure'],
            ['title' => 'On Delivery', 'value' => $data['total_on_delivery_order'], 'status' => 'on_delivery', 'color' => 'teal', 'textColor' => 'text-teal'],
            ['title' => 'Delivered', 'value' => $data['total_delivered_order'], 'status' => 'delivered', 'color' => 'success', 'textColor' => 'text-success'],
            ['title' => 'Partial Delivered', 'value' => $data['total_partial_delivered_order'], 'status' => 'partial_delivered', 'color' => 'cyan', 'textColor' => 'text-cyan'],
            ['title' => 'Cancelled', 'value' => $data['total_cancelled_order'], 'status' => 'cancelled', 'color' => 'danger', 'textColor' => 'text-danger'],
            ['title' => 'Return', 'value' => $data['total_returned_order'], 'status' => 'returned', 'color' => 'cyan', 'textColor' => 'text-cyan'],
            ['title' => 'Return Received', 'value' => $data['total_return_received_order'], 'status' => 'return_received', 'color' => 'indigo', 'textColor' => 'text-indigo'],
            ['title' => 'Exchange', 'value' => $data['total_exchange_order'], 'status' => 'exchange', 'color' => 'pink', 'textColor' => 'text-pink']
        ];
    }

    public function create()
    {
        $products = Product::where('status', 1)->where('theme_id', activeThemeData()->id)->select('id', 'name', 'has_variant')->latest()->get();
        $courier = Courier::where('status', 1)->pluck('courier_name', 'id');
        $shipping_methods = ShippingMethod::where('status', 1)->get();
        $invoice_id = invoice_generate();

        // dd($invoice_id);
        return view('backEnd.admin.orders.add', compact('products', 'courier', 'invoice_id', 'shipping_methods'));
    }

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $check_cus = User::where('phone', $request->phone)->first();
            if ($check_cus) {
                $user_id = $check_cus;
            } else {
                $user_id = User::create([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'password' => Hash::make($request->phone),
                ]);
            }

            $inputs = array_merge($request->all(), [
                'order_date' => Carbon::parse($request->order_date)->format('Y-m-d'),
                'theme_id' => activeThemeData()->id,
                'customer_id' => $user_id->id ?? 0,
                'customer_name' => $request->name,
                'customer_phone' => $request->phone,
                'customer_address' => $request->address,
                'payment_method' => $request->payment_method ?? null,
                'payment_status' => $request->payment_status ?? 0,
                'shipping_method' => $request->shipping_method_id ?? null,
                'sub_total' => $request->sub_total ?? 0,
                'shipping_cost' => $request->delivery_cost ?? 0,
                'discount' => $request->discount ?? 0,
                'total' => $request->sub_total + $request->delivery_cost ?? 0,
                'source' => $request->source ?? null,
                'due' => $request->due_amount ?? 0,
                'paid' => $request->paid_amount ?? 0,
            ]);

            $order = Order::create($inputs);

            if ($request->has('products') && is_array($request->products)) {
                foreach ($request->products as $p) {
                    $product_id     = $p['product_id'] ?? null;
                    $qty            = $p['qty'] ?? 1;
                    $price          = $p['price'] ?? 0;
                    $variant_name   = $p['variant_name'] ?? null;
                    $variant_choice = $p['variant_choice'] ?? null;
                    $is_combo       = $p['is_combo'] ?? 0;
                    if ($is_combo == 1) {
                        $sku = Product::find($product_id)->sku ?? null;
                    } else {
                        $sku = $p['sku'] ?? null;
                    }

                    $product = Product::find($product_id);
                    $purchase_price = StockManager::getPurchasePrice($product, $sku, $variant_choice);

                    $comboPurchasePriceSum = 0;
                    $comboItemsData = [];

                    if ($is_combo == 1 && isset($p['combo_items']) && is_array($p['combo_items'])) {
                        foreach ($p['combo_items'] as $childId => $itemData) {
                            $childProduct = Product::find($childId);
                            $childSku = $childProduct->sku ?? null;
                            $childVariantId = $itemData['variant_id'] ?? null;
                            $childQty = $itemData['qty'] ?? 1;

                            $childVariantChoice = null;
                            if (!empty($childVariantId)) {
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
                                'product_id' => $childId,
                                'sku'        => $childSku,
                                'qty'        => $childQty,
                                'variant_id' => $childVariantId,
                            ];
                        }
                        $purchase_price = $comboPurchasePriceSum;
                    }
                    $orderProduct = OrderProduct::create([
                        'order_id'       => $order->id,
                        'product_id'     => $product_id,
                        'product_sku'    => $sku,
                        'qty'            => $qty,
                        'price'          => $price,
                        'purchase_price' => $purchase_price,
                        'attributes'     => $variant_choice ? str_replace(',', '-', $variant_choice) : null,
                    ]);

                    if ($is_combo == 1 && !empty($comboItemsData)) {
                        foreach ($comboItemsData as $item) {
                            OrderComboItem::create([
                                'order_product_id' => $orderProduct->id,
                                'product_id'       => $item['product_id'],
                                'sku'              => $item['sku'],
                                'qty'              => $item['qty'],
                                'variant_id'       => $item['variant_id'],
                            ]);
                        }
                    }
                }
            }

            if ((int)$order->status === 8) {
                StockManager::decreaseStockForOrder($order->get_products);
            }
            $employees = Admin::where('is_order_assign', 1)
                ->where('status', 1)
                ->withCount('get_order_assign')
                ->get();
            if ($employees->count() > 0) {
                $minOrder = $employees->min('get_orders_count');
                $leastLoadedEmployees = $employees->where('get_orders_count', $minOrder);
                $selectedEmployee = $leastLoadedEmployees->random();
                OrderAssign::create([
                    'order_id' => $order->id,
                    'employee_id' => $selectedEmployee->id,
                ]);
            }


            // Determine User Context safely
            $isAdmin = Auth::guard('admin')->check();
            $userId  = $isAdmin ? Auth::guard('admin')->id() : (Auth::check() ? Auth::id() : null);
            $userName = $isAdmin ? Auth::guard('admin')->user()->name : (Auth::check() ? Auth::user()->name : 'System/Guest');
            $role     = $isAdmin ? Auth::guard('admin')->user()->role : ($request->type === 'customer' ? 'Customer' : 'Staff');

            // 1. OrderNote টেবিলে নতুন এন্ট্রি তৈরি
            if ($request->has('staff_note')  && !empty($request->staff_note)) {
                // dd($request->staff_note);
                $noteText = $request->staff_note;
                OrderNote::create([
                    'order_id'   => $order->id,
                    'user_id'    => $userId,
                    'user_name'  => $userName,
                    'user_role'  => $role,
                    'note'       => $noteText,
                    'user_type'  => 'staff',
                ]);
            }
            // if ($request->has('customer_note')) {
            //     $noteText = $request->customer_note;
            //     OrderNote::create([
            //         'order_id'   => $order->id,
            //         'user_id'    => $userId,
            //         'user_name'  => $userName,
            //         'user_role'  => $role,
            //         'note'       => $noteText,
            //         'user_type'  => 'customer',
            //     ]);
            // }


            return redirect()->route('admin.orders')->with('success', 'Order Created Successfully');
        });
    }

    public function edit($id)
    {
        $data = Order::with('get_products', 'get_activities')->findOrFail($id);
        $shipping_methods = ShippingMethod::where('status', 1)->get();
        $products = Product::with('get_variants')->where('status', 1)->where('theme_id', activeThemeData()->id)->select('id', 'name', 'has_variant')->latest()->get();
        $product_id = [];
        foreach ($data->get_products as $order_item) {
            array_push($product_id, $order_item->get_product->id);
        }

        $cities = null;
        $zones = null;
        if ($data->courier_id == 2) {
            $cities = PathaoCity::pluck('name', 'parent_id');
            $zones = PathaoZone::pluck('name', 'id');
        }

        return view('backEnd.admin.orders.edit', compact('data', 'products', 'shipping_methods', 'product_id', 'cities', 'zones'));
    }

    public function update(Request $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $order = Order::findOrFail($id);
            $oldStatus = (int) $order->status;

            $couponCode = $request->coupon_code ?? $order->coupon_code;
            $couponDiscount = $request->coupon_discount ?? $order->coupon_discount;
            $couponAppliedOn = $request->coupon_applied_on ?? $order->coupon_applied_on;

            $inputs = array_merge($request->all(), [
                'order_date'        => Carbon::parse($request->order_date)->format('Y-m-d'),
                'customer_name'     => $request->name,
                'customer_phone'    => $request->phone,
                'customer_address'  => $request->address,
                'shipping_method'   => $request->shipping_method_id ?? null,
                'sub_total'         => $request->sub_total ?? 0,
                'shipping_cost'     => $request->delivery_cost ?? 0,
                'discount'          => $request->discount ?? 0,
                'total'             => $request->sub_total + ($request->delivery_cost ?? 0),
                'paid_amount'       => $request->paid_amount ?? 0,
                'due_amount'        => $request->due_amount ?? 0,
                'payment_status'    => $request->paid_amount == $request->grand_total ? 1 : ($request->paid_amount == 0 ? 0 : 2),
                'source'            => $request->source ?? null,
                'due'               => $request->due_amount ?? 0,
                'paid'              => $request->paid_amount ?? 0,
                'coupon_code'       => $couponCode,
                'coupon_discount'   => $couponDiscount,
                'coupon_applied_on' => $couponAppliedOn,
            ]);

            $order->update($inputs);
            $newStatus = (int) $order->status;

            $existingProducts = OrderProduct::where('order_id', $order->id)->get()->keyBy(function ($item) {
                return $item->product_id . '_' . ($item->product_sku ?? 'default');
            });

            if ($oldStatus === 8) {
                StockManager::increaseStockForOrder($existingProducts);
            }

            $processedKeys = [];

            if ($request->has('products') && is_array($request->products)) {
                foreach ($request->products as $p) {
                    $product_id     = $p['product_id'] ?? null;
                    $sku            = $p['sku'] ?? null;
                    $newQty         = (int) ($p['qty'] ?? 1);
                    $price          = $p['price'] ?? 0;
                    $variant_choice = $p['variant_choice'] ?? null;
                    $attributes     = $variant_choice ? str_replace(',', '-', $variant_choice) : null;
                    $is_combo       = $p['is_combo'] ?? 0;

                    if (!$product_id) continue;

                    if ($is_combo == 1) {
                        $sku = Product::find($product_id)->sku ?? null;
                    }

                    $itemKey = $product_id . '_' . ($sku ?? 'default');
                    $processedKeys[] = $itemKey;

                    $product = Product::find($product_id);
                    $purchase_price = StockManager::getPurchasePrice($product, $sku, $variant_choice);

                    $comboPurchasePriceSum = 0;
                    $comboItemsData = [];

                    if ($is_combo == 1 && isset($p['combo_items']) && is_array($p['combo_items'])) {
                        foreach ($p['combo_items'] as $childId => $itemData) {
                            $childProduct = Product::find($childId);
                            $childSku = $childProduct->sku ?? null;
                            $childVariantId = $itemData['variant_id'] ?? null;
                            $childQty = $itemData['qty'] ?? 1;

                            $childVariantChoice = null;
                            if (!empty($childVariantId)) {
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
                                'product_id' => $childId,
                                'sku'        => $childSku,
                                'qty'        => $childQty,
                                'variant_id' => $childVariantId,
                            ];
                        }
                        $purchase_price = $comboPurchasePriceSum;
                    }

                    if ($existingProducts->has($itemKey)) {
                        $existingItem = $existingProducts->get($itemKey);
                        $existingItem->update([
                            'qty'            => $newQty,
                            'price'          => $price,
                            'purchase_price' => $purchase_price,
                            'attributes'     => $attributes,
                        ]);

                        if ($is_combo == 1) {
                            $existingItem->orderComboItems()->delete();
                            foreach ($comboItemsData as $item) {
                                OrderComboItem::create([
                                    'order_product_id' => $existingItem->id,
                                    'product_id'       => $item['product_id'],
                                    'sku'              => $item['sku'],
                                    'qty'              => $item['qty'],
                                    'variant_id'       => $item['variant_id'],
                                ]);
                            }
                        }
                    } else {
                        $orderProduct = OrderProduct::create([
                            'order_id'       => $order->id,
                            'product_id'     => $product_id,
                            'product_sku'    => $sku,
                            'qty'            => $newQty,
                            'price'          => $price,
                            'purchase_price' => $purchase_price,
                            'attributes'     => $attributes,
                        ]);

                        if ($is_combo == 1 && !empty($comboItemsData)) {
                            foreach ($comboItemsData as $item) {
                                OrderComboItem::create([
                                    'order_product_id' => $orderProduct->id,
                                    'product_id'       => $item['product_id'],
                                    'sku'              => $item['sku'],
                                    'qty'              => $item['qty'],
                                    'variant_id'       => $item['variant_id'],
                                ]);
                            }
                        }
                    }
                }
            }

            foreach ($existingProducts as $key => $existingItem) {
                if (!in_array($key, $processedKeys)) {
                    $existingItem->delete();
                }
            }

            $order->load('get_products');
            if ($newStatus === 8) {
                StockManager::decreaseStockForOrder($order->get_products);
            }


            // Determine User Context safely
            $isAdmin = Auth::guard('admin')->check();
            $userId  = $isAdmin ? Auth::guard('admin')->id() : (Auth::check() ? Auth::id() : null);
            $userName = $isAdmin ? Auth::guard('admin')->user()->name : (Auth::check() ? Auth::user()->name : 'System/Guest');
            $role     = $isAdmin ? Auth::guard('admin')->user()->role : ($request->type === 'customer' ? 'Customer' : 'Staff');

            // 1. OrderNote টেবিলে নতুন এন্ট্রি তৈরি
            if ($request->has('staff_note')  && !empty($request->staff_note) && $request->staff_note != $order->staff_note) {
                $noteText = $request->staff_note;
                OrderNote::create([
                    'order_id'   => $order->id,
                    'user_id'    => $userId,
                    'user_name'  => $userName,
                    'user_role'  => $role,
                    'note'       => $noteText,
                    'user_type'  => 'staff',
                ]);
            }
            // if ($request->has('customer_note')) {
            //     $noteText = $request->customer_note;
            //     OrderNote::create([
            //         'order_id'   => $order->id,
            //         'user_id'    => $userId,
            //         'user_name'  => $userName,
            //         'user_role'  => $role,
            //         'note'       => $noteText,
            //         'user_type'  => 'customer',
            //     ]);
            // }


            return redirect()->route('admin.orders')->with('success', 'Order Updated Successfully');
        });
    }

    public function paymentStatus(Request $request, $id, $status)
    {
        $account = DB::table('accounts')->where('is_default', 1)->first();
        $order = Order::findOrFail($id);
        if ($status == 1) { // Full Paid
            $paidAmount = $order->due > 0 ? $order->due : $order->total;
            $order->update([
                'payment_status' => 1,
                'paid'           => $paidAmount,
                'due'            => 0,
            ]);
            if ($account) {
                $trans_one = AccountTransaction::create([
                    'account_id'       => $account->id,
                    'order_id'         => $id,
                    'amount'           => $paidAmount,
                    'transaction_type' => 0,
                    'purpose'          => 'Order full payment.',
                ]);
                DB::table('accounts')->where('id', $account->id)->increment('balance', $paidAmount);
            }
        } elseif ($status == 0) { // Unpaid
            $order->update([
                'payment_status' => 0,
                'paid'           => 0,
                'due'            => $order->due,
            ]);
            if ($order->get_transactions && count($order->get_transactions) > 0) {
                foreach ($order->get_transactions as $transaction) {
                    if ($transaction->transaction_type == 0) {
                        DB::table('accounts')->where('id', $transaction->account_id)->decrement('balance', $transaction->amount);
                    } else {
                        DB::table('accounts')->where('id', $transaction->account_id)->increment('balance', $transaction->amount);
                    }
                }
                $order->get_transactions()->delete();
            }
        } elseif ($status == 2) { // Partial Payment
            $request->validate([
                'amount' => 'required|numeric|min:1',
            ]);
            $partialAmount = (float) $request->amount;
            $newPaid = $order->paid + $partialAmount;
            $newDue = max(0, $order->total - $newPaid);
            // Calculate if payment is fully cleared through partial payments
            $finalStatus = ($newDue == 0) ? 1 : 2;
            $order->update([
                'payment_status' => $finalStatus,
                'paid'           => $newPaid,
                'due'            => $newDue,
            ]);
            if ($account) {
                $trans_one = AccountTransaction::create([
                    'account_id'       => $account->id,
                    'order_id'         => $id,
                    'amount'           => $partialAmount,
                    'transaction_type' => 0,
                    'purpose'          => 'Order partial payment: ' . $partialAmount,
                ]);
                DB::table('accounts')->where('id', $account->id)->increment('balance', $partialAmount);
            }
        }

        return back()->with('success', 'Payment Status Updated Successfully.');
    }

    public function statusChange(Request $request, $id, $status)
    {
        // dd((int)$status);
        $order = Order::with('get_products')->find($id);
        if ((int)$status === 8) {
            // dd(1);
            StockManager::decreaseStockForOrder($order->get_products);
        }
        // Jodi AJAX request hoy tahole JSON response dibe, nahole back() korbe
        if ($request->ajax()) {
            if (intval($status) == 12) { // Return Received
                $orderProducts = $order->get_products;
                return response()->json([
                    'status' => 'return_modal',
                    'order_id' => $id,
                    'html' => view('backEnd.admin.orders.partials.return-receive-modal', compact('orderProducts', 'order'))->render()
                ]);
            }
            $order->update([
                'status' => $status,
            ]);


            return response()->json(['status' => 200, 'message' => 'Status Changed Successfully']);
        }

        return back()->with('success', 'Status Changed Successfully');
    }
    public function returnRestock(Request $request)
    {
        $orderId = $request->order_id;
        $submittedProducts = $request->products ?? [];

        $order = Order::with('get_products.orderComboItems')->findOrFail($orderId);

        foreach ($submittedProducts as $pData) {
            $productId = $pData['product_id'] ?? null;
            $sku = $pData['sku'] ?? null;
            $qty = $pData['qty'] ?? 1;
            $isCombo = $pData['is_combo'] ?? 0;

            $product = Product::find($productId);
            if (!$product) continue;

            // 1. If Combo Product
            if ($isCombo == 1) {
                // Combo parent stock decrease/increase na kore child gular stock handle hobe
                if (isset($pData['combo_children']) && is_array($pData['combo_children'])) {
                    foreach ($pData['combo_children'] as $child) {
                        if (isset($child['selected']) && $child['selected'] == 1) {
                            $childProduct = Product::find($child['product_id']);
                            $childSku = $child['sku'] ?? null;
                            $childQty = $child['qty'] ?? 1;

                            if ($childProduct) {
                                $childProduct->increment('stock', $childQty);
                                if ($childSku) {
                                    $childProductAttribute = ProductVariant::where('product_id', $childProduct->id)->where('sku', $childSku)->first();
                                    if ($childProductAttribute) {
                                        $childProductAttribute->increment('stock', $childQty);
                                    }
                                }

                                // Advanced Purchase Table support for combo child
                                StockManager::managePurchaseTableStockStatic($childProduct, $childSku, $childQty, 'increase');
                            }
                        }
                    }
                }
            } else {
                // 2. Regular Product Stock Increase
                $product->increment('stock', $qty);
                // 3. Product Variant Stock Increase
                if ($sku) {
                    $productAttribute = ProductVariant::where('product_id', $productId)->where('sku', $sku)->first();
                    if ($productAttribute) {
                        $productAttribute->increment('stock', $qty);
                    }
                }
                // Advanced Purchase Table support for regular product
                StockManager::managePurchaseTableStockStatic($product, $sku, $qty, 'increase');
            }
        }

        // Order status update to Return Received (12)
        $order->update(['status' => 12]);

        return redirect()->back()->with('success', 'Products successfully returned and added to stock!');
    }

    public function delete($id)
    {
        $order = Order::find($id);
        // dd($order);
        $order->delete();
        // order activity
        // OrderActivity::create([
        //     'order_id' => $id,
        //     'user_type' => Auth::guard('admin')->user()->role,
        //     'created_by' => Auth::guard('admin')->user()->id,
        //     'activity_type' => 3,
        //     'text' => 'Order Trash by ' . Auth::guard('admin')->user()->name . ' (' . Auth::guard('admin')->user()->role . ')',
        // ]);

        return back()->with('success', 'Order Deleted Successfully');
    }

    public function ajaxGetProductAttributeModal(Request $request)
    {
        // dd(1);
        $data = Product::with('get_product_variants')->find($request->id);

        // dd($data->get_product_choice_attributes);
        return view('backEnd.admin.orders.partials.variant_choice', compact('data'));
    }

    public function ajaxGetProductAttributeModalEdit(Request $request)
    {
        // dd(2);variant_choice
        $data = Product::with('get_product_variants')->find($request->id);

        return view('backEnd.admin.orders.partials.variant_choice_edit', compact('data'));
    }

    public function ajaxGetProducts(Request $request)
    {
        $data = Product::find($request->id);

        //  dd($data);
        return view('backEnd.admin.orders.partials.ajax_products', compact('data'))->render();
    }

    public function ajaxGetModalChoiceAttributes(Request $request)
    {
        // dd($request->all());
        if (is_array($request->choice_variants) && count($request->choice_variants) > 0) {
            $quantity = $request->quantity;
            $choice_variants = $request->choice_variants;
            $variant_attr = '';
            // dd($choice_variant );
            foreach ($choice_variants as $key => $choice_variant) {
                if ($key == array_key_first($choice_variants)) {
                    $variant_attr .= $choice_variant;
                } else {
                    $variant_attr .= '-' . $choice_variant;
                }
            }
            $product_variant = ProductAttribute::where([['product_id', $request->id], ['variant', strtolower(str_replace(' ', '_', $variant_attr))]])->first();
            $price = $product_variant->sale_price > 0 ? number_format($product_variant->sale_price, 2) : number_format($product_variant->regular_price, 2);
            $sku = $product_variant->sku;
            $stock = $product_variant->stock;
            $data = Product::find($request->id);
            $variant = $product_variant;

            //  dd($data, $variant, $choice_variants, $sku, $price, $stock);
            return view('backEnd.admin.orders.partials.product_variants', compact('data', 'variant', 'choice_variants', 'sku', 'price', 'stock'))->render();
        }

        // dd($product_attributes);
    }

    public function ajaxGetChoiceAttributes(Request $request)
    {

        // dd($request->all());
        $quantity = $request->quantity;
        $choice_variants = $request->choice_variants ?? [];
        $product_id = $request->id;

        $variant_string = implode('-', $choice_variants);

        $product_attribute = ProductAttribute::where([
            ['product_id', $product_id],
            ['variant', strtolower(str_replace(' ', '_', $variant_string))],
        ])->first();

        // dd($product_attribute);

        if ($product_attribute) {
            $sku = $product_attribute->sku;
            $price = $product_attribute->sale_price > 0 ? number_format($product_attribute->sale_price, 2) : number_format($product_attribute->regular_price, 2);
            $stock = $product_attribute->stock;
        } else {
            $sku = '';
            $price = 0;
            $stock = 0;
        }
        // dd( $choice_variants, $sku, $price, $stock, $quantity);

        // Any additional data you need to send to the view
        $data = Product::find($product_id);
        $variants = $choice_variants;

        // Render Blade to HTML
        if ($product_attribute) {
            $html = view('backEnd.admin.orders.partials.attr_checkbox', compact('data', 'variants', 'choice_variants', 'sku', 'price', 'stock', 'quantity'))->render();
            // return view('backEnd.admin.orders.attr_checkbox', compact('data', 'attributes', 'choice_attributes', 'sku', 'price', 'stock', 'quantity'))->render();

            return response()->json([
                'html' => $html,
                'sku' => $sku,
                'price' => $price,
                'subtotal' => $price * $quantity,
                'stock' => $stock,
            ]);
        }
    }

    public function printInvoice(Request $request)
    {
        // dd($request->all());
        $data = Order::find($request->id);
        // order activity
        // OrderActivity::create([
        //     'order_id' => $data->id,
        //     'note' => 'Invoice Printed by ' . Auth::guard('admin')->user()->name . ' (' . Auth::guard('admin')->user()->role . ')',
        // ]);

        $web_settings = WebSettings::first();

        $printSetting = PrintSetting::first();

        if ($printSetting->single_print == 0) {
            return view('backEnd.admin.print.layout.single_default', compact('data', 'web_settings'))->render();
        } elseif ($printSetting->single_print == 1) {
            return view('backEnd.admin.print.layout.single_layout_1', compact('data', 'web_settings'))->render();
        }
    }

    public function printBulkInvoice(Request $request)
    {
        // dd($request->all());
        $orders = Order::find($request->all_inv_id);
        foreach ($orders as $order) {
            // order activity
            // OrderActivity::create([
            //     'order_id' => $order->id,
            //     'note' => 'Invoice Printed by ' . Auth::guard('admin')->user()->name . ' (' . Auth::guard('admin')->user()->role . ')',
            // ]);
        }
        $web_settings = WebSettings::first();
        $printSetting = PrintSetting::first();

        if ($printSetting->bulk_print == 0) {
            return view('backEnd.admin.print.layout.bulk_default', compact('orders', 'web_settings'))->render();
        } elseif ($printSetting->bulk_print == 1) {
            return view('backEnd.admin.print.layout.bulk_layout_1', compact('orders', 'web_settings'))->render();
        } elseif ($printSetting->bulk_print == 2) {
            return view('backEnd.admin.print.layout.bulk_3_2_layout', compact('orders', 'web_settings'))->render();
        }
    }

    public function allStatusChange(Request $request)
    {
        if ($request->status_update) {
            foreach (explode(',', $request->all_status) as $item) {
                $order_id = Order::with('get_products')->find($item);
                $order_id->update([
                    'status' => $request->status,
                ]);
                $sts = $this->getOrderStatusName($order_id->status);

                if ((int)$order_id->status === 8) {
                    StockManager::decreaseStockForOrder($order_id->get_products);
                }
            }

            return back()->with('success', 'Status Changed Successfully');
        }
        if ($request->status_delete) {
            foreach (explode(',', $request->all_delete_id) as $item) {
                $order_id = Order::find($item);

                // order activity
                $sts = $this->getOrderStatusName($order_id->status);

                $order_id->delete();
            }

            return back()->with('success', 'Order Delete Successfully');
        }
    }

    // courier courier_csv
    public function courierCsv(Request $request)
    {
        $orders_id = explode(',', $request->oders_id);
        if ($request->status == 1) {
            $name = 'stead_fast';
        } elseif ($request->status == 2) {
            $name = 'pathao';
        } elseif ($request->status == 3) {
            $name = 'redx';
        } elseif ($request->status == 4) {
            $name = 'carrybee';
        }
        $file_name = $name . '_' . date('d-M-Y') . '.xlsx';

        return Excel::download(new OrderExport(explode(',', $request->oders_id), $request->status), $file_name);
    }

    public function sendToCourier(Request $request)
    {
        if ($request->courier_id == 3 || $request->courier_id == 2) {
            if ($request->courier_id == 3) {
                $order = Order::find($request->order_id);
                $courier_id = $request->courier_id;

                return view('backEnd.admin.orders.courier_modal', compact('order', 'courier_id'))->render();
            }
            if ($request->courier_id == 2) {

                $order = Order::find($request->order_id);
                $courier_id = $request->courier_id;

                return view('backEnd.admin.orders.courier_modal', compact('order', 'courier_id'))->render();
            }
        } else {
            $order = Order::find($request->order_id);
            $order->update([
                'courier_id' => $request->courier_id,
            ]);

            return response()->json(['status' => 200]);
        }
    }

    public function sendToCourierStore(Request $request)
    {
        // dd($request->all());
        $order = Order::with('get_city', 'get_zone')->find($request->order_id);
        // dd($order);

        if ($request->courier_id == 3) {

            $credential = DB::table('api_couriers')->select('pathao_access_token')->where('id', 1)->first();
            // dd($credential);
            // dd($credential);
            $url = 'https://api-hermes.pathao.com//aladdin/api/v1/orders';
            $ch = curl_init();
            $data = [
                'store_id' => 70676,
                'merchant_order_id' => $order->invoice_id,
                'name' => $order->customer_name ?? 'Mr. X',
                'contact_name' => $order->customer_name ?? 'Mr. X',
                'contact_number' => '01846464646',
                'address' => 'House-1, Road-1, Block-A, Mirpur-1, Dhaka-1216',
                'city_id' => $request->city ?? 1,
                'zone_id' => $request->zone ?? 1,
                'area_id' => 1,
                'delivery_type' => 48,
                'item_type' => 2,
                'special_instruction' => 'Need to Delivery before 5 PM',
                'item_quantity' => 1,
                'item_weight' => '0.5',
                'item_description' => 'this is a Cloth item, price- 3000',
                'amount_to_collect' => 900,
            ];
            // dd($data);

            $datas = json_encode($data);
            // dd($datas);
            $headers = [
                'accept: application/json',
                'content-type: application/json',
                'authorization: Bearer ' . $credential->pathao_access_token,
            ];
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($response, true);
            // dd($response);

        }

        // order activity
        // OrderActivity::create([
        //     'order_id' => $request->order_id,
        //     'note' => 'Order Sent to Courier by ' . Auth::guard('admin')->user()->name . ' (' . Auth::guard('admin')->user()->role . ')',
        // ]);

        $order->update([
            'courier_id' => $request->courier_id,
            'courier_city_id' => $request->city,
            'courier_zone_id' => $request->zone,
        ]);

        return back()->with('success', 'Order Sent To Courier Successfully');
    }

    public function bulkSendToCourier(Request $request)
    {
        if ($request->courier_id == 3 || $request->courier_id == 2) {
            $orders = Order::whereIn('id', explode(',', $request->order_id))->get();
            $courier_id = $request->courier_id;

            return view('backEnd.admin.orders.bulk_courier_modal', compact('orders', 'courier_id'))->render();
        } else {
            $orders = Order::whereIn('id', explode(',', $request->order_id))->get();
            foreach ($orders as $order) {
                $order->update([
                    'courier_id' => $request->courier_id,
                ]);
            }

            return response()->json(['status' => 200]);
        }
    }

    public function bulkSendToCourierStore(Request $request)
    {
        $orders = Order::whereIn('id', $request->order_id)->get();
        foreach ($orders as $key => $order) {
            $order->update([
                'courier_id' => $request->courier_id,
                'courier_city_id' => $request->city[$key],
                'courier_zone_id' => $request->zone[$key],
            ]);
        }

        // // order activity
        //         OrderActivity::create([
        //             'order_id' => $request->order_id,
        //             'note' => 'Order Sent to Courier by ' . Auth::guard('admin')->user()->name . ' (' . Auth::guard('admin')->user()->role . ')',
        //         ]);

        return back()->with('success', 'Order Sent To Courier Successfully');
    }

    public function courierZone(Request $request)
    {
        $pathao_zones = PathaoZone::where('pathao_city_id', $request->city_id)->pluck('name', 'id');

        // dd($pathao_zones);
        return view('backEnd.admin.orders.pathao_zone', compact('pathao_zones'))->render();
    }

    public function getCities(Request $request)
    {
        // dd($request->all());
        $courier_id = $request->courier_id;
        $data = [];
        if ($courier_id == 2) {   // Pathao
            $zones = DB::table('pathao_cities as c')->join('pathao_zones as z', 'c.parent_id', '=', 'z.city_id')->select('c.parent_id as city_id', 'c.name as city_name', 'z.parent_id as zone_id', 'z.name as zone_name')->get();
        } elseif ($courier_id == 3) {   // RedX
            $zones = DB::table('redx_areas')->select('parent_id', 'district', 'division', 'name')->get();
        } elseif ($courier_id == 4) {   // CarryBee
            // $zones = DB::table('carrybee_zones')
            //     ->join('carrybee_cities', 'carrybee_zones.city_id', '=', 'carrybee_cities.id')
            //     ->select(
            //         'carrybee_zones.id as zone_id',
            //         'carrybee_zones.name as zone_name',
            //         'carrybee_cities.name as city_name'
            //     )
            //     ->get();
            $zones = CarryBeeZone::with('city')
                ->get()
                ->map(function ($zone) {
                    return [
                        'zone_id'   => $zone->id,
                        'zone_name' => $zone->name,
                        'city_name' => $zone->city->name ?? null,
                    ];
                });
            // dd($zones);
        } else {

            return response()->json([
                'success' => false,
                'data' => [],
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $zones,
            'courier_id' => $courier_id,
        ]);
    }

    public function getZones(Request $request)
    {
        $courier_id = $request->courier_id;
        $city_id = $request->city_id;

        if ($courier_id == 2) { // Pathao
            $zones = PathaoZone::where('city_id', $city_id)->pluck('name', 'id');
            // dd($zones);
        } elseif ($courier_id == 4) { // CarryBee
            // $zones = CarrybeeZone::where('city_id', $city_id)->pluck('name', 'id');
        } else {
            return response()->json(['success' => false]);
        }

        return response()->json([
            'success' => true,
            'zones' => $zones,
        ]);
    }


    /**
     * Handle Staff/Customer Note Modal Request & Submission
     */
    public function storeNote(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'note'     => 'required|string|max:1000',
            'type'     => 'required|in:staff,customer',
        ]);

        // dd($request->all());

        $noteText = trim($request->note);

        // Determine User Context safely
        $isAdmin = Auth::guard('admin')->check();
        $userId  = $isAdmin ? Auth::guard('admin')->id() : (Auth::check() ? Auth::id() : null);
        $userName = $isAdmin ? Auth::guard('admin')->user()->name : (Auth::check() ? Auth::user()->name : 'System/Guest');
        $role     = $isAdmin ? Auth::guard('admin')->user()->role : ($request->type === 'customer' ? 'Customer' : 'Staff');

        // 1. OrderNote টেবিলে নতুন এন্ট্রি তৈরি
        $note = OrderNote::create([
            'order_id'  => $request->order_id,
            'note'      => $noteText,
            'user_id'   => $userId,
            'user_type' => $request->type,
        ]);

        // 2. Order টেবিলে সর্বশেষ নোটটি সিঙ্ক করা
        $order = Order::find($request->order_id);
        if ($order) {
            if ($request->type === 'staff') {
                $order->update(['staff_note' => $noteText]);
            } else {
                $order->update(['customer_note' => $noteText]);
            }
        }



        return response()->json([
            'status'  => 200,
            'message' => 'Note saved successfully!',
            'note'    => $note
        ]);
    }

    public function updateNote(Request $request, $id)
    {
        $request->validate(['note' => 'required|string|max:1000']);

        $noteText    = trim($request->note);
        $note        = OrderNote::findOrFail($id);
        $oldNoteText = $note->note;

        // Update Note
        $note->update(['note' => $noteText]);

        // Sync Main Table with Latest Note
        $order = Order::find($note->order_id);
        if ($order) {
            $latestNote = OrderNote::where('order_id', $note->order_id)
                ->where('user_type', $note->user_type)
                ->latest()
                ->first();

            if ($note->user_type === 'staff') {
                $order->update(['staff_note' => $latestNote ? $latestNote->note : null]);
            } else {
                $order->update(['customer_note' => $latestNote ? $latestNote->note : null]);
            }
        }

        $isAdmin  = Auth::guard('admin')->check();
        $userName = $isAdmin ? Auth::guard('admin')->user()->name : (Auth::check() ? Auth::user()->name : 'System');
        $role     = $isAdmin ? Auth::guard('admin')->user()->role : 'Customer';

        return response()->json(['status' => 200, 'message' => 'Note updated successfully!']);
    }

    public function getNotesHistory(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'type'     => 'required|in:staff,customer'
        ]);

        $notes = OrderNote::with(['admin', 'customer'])
            ->where('order_id', $request->order_id)
            ->where('user_type', $request->type)
            ->latest()
            ->get();

        $type = $request->type;

        return view('backEnd.admin.orders.partials.notes_history_modal', compact('notes', 'type'))->render();
    }

    public function getNoteModalContent(Request $request)
    {
        $orderId = $request->order_id;
        $type = $request->type ?? 'staff';
        $noteId = $request->note_id ?? null;
        $note = $noteId ? OrderNote::find($noteId) : null;

        return view('backEnd.admin.orders.partials.note_form_modal', compact('orderId', 'type', 'note'))->render();
    }

    // order activity
    public function activies(Request $request)
    {
        $order = Order::with('get_activities')->find($request->order_id);

        return view('backEnd.admin.orders.partials.activities', compact('order'))->render();
    }

    // bulkAssign
    public function bulkAssign(Request $request)
    {
        $orderIds = is_array($request->order_id)
            ? $request->order_id
            : explode(',', $request->order_id);

        foreach ($orderIds as $id) {
            $orderId = trim($id);
            if (empty($orderId)) {
                continue;
            }
            OrderAssign::updateOrCreate(
                ['order_id'    => $orderId],
                ['employee_id' => $request->user_id]
            );
        }

        return back()->with('success', 'Order Assigned Successfully');
    }


    public function sendToCourierOrderIds(Request $request)
    {
        // dd($request->all());
        $ordersIds = collect(explode(',', (string) $request->query('ids')))
            ->map(fn($id) => (int) trim($id))
            ->filter(fn($id) => $id > 0)
            ->values()
            ->all();

        // dd($ordersIds);

        $orders = Order::whereIn('id', $ordersIds)
            ->with('get_courier')
            ->get();

        if ($orders->isEmpty()) {
            return back()->with('error', 'No orders found.');
        }

        foreach ($orders as $order) {
            if ($order->courier_id == 2 && $order->city_id == null && $order->zone_id == null) { // Pathao Courier
                $pathao = ApiCourier::where('courier_name', 'pathao')->first();
                $credential = $pathao->config ?? [];

                $response = Http::withHeaders(
                    [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . $credential['access_token']
                    ]
                )->post('https://merchant.pathao.com/api/v1/address-parser', [
                    'address' => $order->customer_address ?? ''
                ]);

                $responseData = $response->json();

                if ($response->successful() && isset($response['data'])) {
                    $order->update([
                        'city_id' => $responseData['data']['district_id'],
                        'zone_id' => $responseData['data']['zone_id'],
                    ]);
                }
            } elseif ($order->courier_id == 4 && $order->city_id == null && $order->zone_id == null) { // CarryBee Courier
                // CarryBee Courier
                // $carrybee = ApiCourier::where('courier_name', 'carrybee')->first();
                // $credential = $carrybee->config ?? [];

                // $response = Http::withHeaders([
                //     'Content-Type' => 'application/json',
                //     'Authorization' => 'Bearer ' . $credential['access_token'],
                // ])->post('https://api-merchant.carrybee.com/api/v2/businesses/206/address-parser', [
                //     'query' => $order->customer_address ?? ''
                // ]);

                // $responseData = $response->json();

                // if ($response->successful() && isset($response['data'])) {
                //     $order->update([
                //         'city_id' => $responseData['data']['city_id'],
                //         'zone_id' => $responseData['data']['zone_id'],
                //     ]);
                // }
            }
        }

        $courierIds = $orders->pluck('courier_id')->filter()->unique()->values();
        // dd(count($courierIds));

        if (count($courierIds) < 0) {
            return back()->with('warning', 'Please select orders with same courier.');
        }

        $courierId = (int) $courierIds->first();

        if ($courierId === 2) {
            $cityZones = DB::table('pathao_cities as c')
                ->join('pathao_zones as z', 'c.parent_id', '=', 'z.city_id')
                ->select('c.parent_id as city_id', 'c.name as city_name', 'z.parent_id as zone_id', 'z.name as zone_name')
                ->get();
            // dd(1);
        } elseif ($courierId === 4) {
            $cityZones = DB::table('carrybee_cities as c')
                ->join('carrybee_zones as z', 'c.parent_id', '=', 'z.city_id')
                ->select('c.parent_id as city_id', 'c.name as city_name', 'z.parent_id as zone_id', 'z.name as zone_name')
                ->get();
            // dd(2);
        } else {
            $cityZones = collect();
            // dd(3);
        }

        $pathaoCities = PathaoCity::pluck('name', 'id');
        $pathaoZones = PathaoZone::pluck('name', 'id');
        $carrybeeCities = CarrybeeCity::pluck('name', 'id');
        $carrybeeZones = CarrybeeZone::pluck('name', 'id');

        return view('backEnd.admin.orders.send-to-courier', compact(
            'orders',
            'cityZones',
            'pathaoCities',
            'pathaoZones',
            'carrybeeCities',
            'carrybeeZones',
            'ordersIds',
        ));
    }


    public function sendToCourierItems(Request $request)
    {
        // dd($request->all());
        $order = Order::with(['get_courier', 'get_products.get_product'])->find($request->order_id);
        // dd($order);
        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found',
                'courier' => null,
                'consignment_id' => null
            ]);
        }
        // Check if already sent to courier
        if ($order->is_sent_to_courier == 1) {
            return response()->json([
                'status' => true,
                'message' => "⚠ Already sent" . ($order->consignment_id ? " (ID: {$order->consignment_id})" : ""),
                'courier' => $order->get_courier->name ?? 'Unknown',
                'consignment_id' => $order->consignment_id ?? null
            ]);
        }

        $orderItems = collect($order->get_products ?? []);
        // dd($orderItems);
        if ($request->city_id && $request->zone_id) {
            $order->update([
                'courier_city_id' => $request->city_id,
                'courier_zone_id' => $request->zone_id,
            ]);
        }

        $courier_id = $order->courier_id;
        // dd($courier_id);

        if ($courier_id == 1) {
            // Steadfast Courier
            $steadfast = ApiCourier::where('courier_name', 'steadfast')->first();
            $credential = $steadfast->config ?? [];
        } elseif ($courier_id == 2) {
            // Pathao Courier
            $pathao = ApiCourier::where('courier_name', 'pathao')->first();
            $credential = $pathao->config ?? [];
        } elseif ($courier_id == 3) {
            // RedX Courier
            $redx = ApiCourier::where('courier_name', 'redx')->first();
            $credential = $redx->config ?? [];
        } elseif ($courier_id == 4) {
            // CarryBee Courier
            $carrybee = ApiCourier::where('courier_name', 'carrybee')->first();
            $credential = $carrybee->config ?? [];
        }
        // dd($steadfast);
        // Fail Any How
        $attempt = 0;
        $maxAttempts = 2; // try twice (initial + one retry)
        $success = false;
        $response = null;
        try {
            // dd(1);
            if ($courier_id == 2 && $pathao->status == 1) { // 1 = Pathao
                if ($order->consignment_id == null && $order->is_sent_to_courier == 0) { //if consignment id null and not sent to courier then take data for entry
                    $item_description = '';
                    foreach ($orderItems as $key => $get_product) { // collection of item_description
                        if ($key != 0) {
                            $item_description .= "\n";
                        }
                        $item_description .= ($get_product->qty ?? 0) . " x " . ($get_product->get_product->name ?? 'N/A');
                    }

                    $pathao_data = [
                        'store_id' => $credential['store_id'] ?? null,
                        'merchant_order_id' => $order->invoice_id ?? null,
                        'recipient_name' => $order->customer_name ?? null,
                        'recipient_phone' => $order->customer_phone ?? null,
                        'recipient_address' => $order->customer_address ?? null,
                        'recipient_city' =>  null,
                        'recipient_zone' =>  null,
                        'recipient_area' => null,
                        'delivery_type' => 48,
                        'item_type' => 2,
                        'special_instruction' => $order->order_note ?? null,
                        'item_quantity' => $orderItems->sum('qty') ?: 1,
                        'item_weight' => 0.5,
                        'amount_to_collect' => (int)round($order->due ?? 0),
                        'item_description' => $item_description ?? null,
                    ];

                    $pathao_json_string = json_encode($pathao_data);
                    // dd($store_info->pathao_access_token);

                    $url = 'https://api-hermes.pathao.com/aladdin/api/v1/orders';
                    $headers = [
                        'accept: application/json',
                        'content-type: application/json',
                        'authorization: Bearer ' . $credential['access_token']
                    ];
                    // retry
                    while ($attempt < $maxAttempts && !$success) {
                        $attempt++;

                        $curl = curl_init();

                        curl_setopt($curl, CURLOPT_URL, $url);
                        curl_setopt($curl, CURLOPT_POST, true);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $pathao_json_string);
                        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        $curlResponse = curl_exec($curl);
                        $response = json_decode($curlResponse, true);
                        curl_close($curl);

                        // dd($response);
                        if (isset($response['code']) && $response['code'] == 200) {
                            $success = true;
                            $order->update([
                                'is_sent_to_courier' => 1,
                                'status' => 7,
                                'consignment_id' => $response['data']['consignment_id'] ?? null,
                            ]);
                            //dd($data['data']->consignment_id);
                        } elseif (isset($response['code']) && $response['code'] == 422) {
                            $success = false;
                            $errorMessage = "Validation error";
                            if (!empty($response['errors'])) {
                                $firstKey = array_key_first($response['errors']);
                                $errorMessage = $response['errors'][$firstKey][0] ?? $errorMessage;
                            }
                            return response()->json(['status' => false, 'message' => $errorMessage]);
                        } else {
                            if ($attempt < $maxAttempts) {
                                sleep(2); // wait 2 seconds before retry
                            }
                        }
                    }

                    // Log failure if still unsuccessful
                    if (!$success) {
                        $date = now() . "\n";
                        $fp = fopen(base_path('storage/logs/pathao_entry_log.txt'), 'a');
                        fwrite($fp, $date . "FAILED after retry: " . json_encode($response) . "\n\n");
                        fclose($fp);
                    }
                }
            } elseif ($courier_id == 1 && $steadfast->status == 1) { // 2 = Setadfast
                $setadfast_data = [];
                if ($order->consignment_id == null && $order->is_sent_to_courier == 0) { //if consignment id null then take data for entry
                    $setadfast_data[] = [
                        'invoice' => $order->invoice_id ?? null,
                        'recipient_name' => $order->customer_name ?? null,
                        'recipient_phone' => $order->customer_phone ?? null,
                        'recipient_address' => $order->customer_address ?? null,
                        'cod_amount' => number_format($order->due, 0, '.', '') ?? 0,
                        'note' => $order->order_note ?? null,
                    ];
                }
                $steadfast_json_string = json_encode($setadfast_data);
                //dd($json_string);

                $setadfast_headers = [
                    'Api-Key: ' . $credential['api_key'],
                    'Secret-Key: ' . $credential['secret_key'],
                    'Content-Type: application/json',
                ];
                //dd($headers);
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://portal.packzy.com/api/v1/create_order/bulk-order',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $steadfast_json_string,
                    CURLOPT_HTTPHEADER => $setadfast_headers,
                ));

                $response = curl_exec($curl);
                curl_close($curl);

                //dd($response);
                $steadfastResponse = json_decode($response);
                $steadfastItems = collect($steadfastResponse->data ?? []);

                foreach ($steadfastItems as $item2) {
                    if ($item2->status == 'success') {
                        $order->update([
                            'status' => 7,
                            'consignment_id' => $item2->consignment_id ?? null,
                            'tracking_id' => $item2->tracking_link ?? null,
                            'is_sent_to_courier' => 1
                        ]);

                        // // Api for update data into particular store
                        // if ($store_info->status == 1) {
                        //     $url = $store_info->base_url . $store_info->ep_order_status . '?status=7' . '&invoice_no=' . $item2->invoice;
                        //     //dd($url);
                        //     $response = api_call($url, 'GET', null);
                        //     //dd($response);
                        // }

                    } elseif ($item2->status == 'error') {
                        $date = Carbon::now() . "\n";
                        $fp = fopen(base_path('storage/logs/stead_fast_entry_log.txt'), 'a'); //opens file in append mode
                        fwrite($fp, $date . $item2 . "\n\n");
                        fclose($fp);
                    }
                }
            } elseif ($courier_id == 3) { // 3 = redx
                // next add your code for redx courier here
            } elseif ($courier_id == 4 && $carrybee->status == 1) { // 4 = carrybee
                if ($order->consignment_id == null && $order->is_sent_to_courier == 0) {
                    // Build item description
                    $item_description = '';
                    foreach ($orderItems as $key => $get_product) {
                        if ($key != 0) $item_description .= "\n";
                        $item_description .= ($get_product->qty ?? 0) . " x " . ($get_product->get_product->name ?? 'N/A');
                    }

                    $carrybee_data = [
                        "store_id" => $credential['store_id'],
                        "merchant_order_id" => $order->invoice_id ?? null,
                        "delivery_type" => 1,
                        "product_type" => 1,
                        "recipient_secendary_phone" => null,
                        'recipient_name' => $order->customer_name ?? null,
                        'recipient_phone' => $order->customer_phone ?? null,
                        'recipient_address' => $order->customer_address ?? null,
                        'city_id' => $order->courier_city_id ?? null,
                        'zone_id' => $order->courier_zone_id ?? null,
                        "area_id" => null,
                        'special_instruction' => $order->order_note ?? null,
                        'product_description' => $item_description ?? null,
                        'item_weight' => 1,
                        'item_quantity' => $orderItems->sum('qty') ?: 1,
                        'collectable_amount' => (float)($order->due ?? 0),
                    ];

                    // $url = 'https://stage-sandbox.carrybee.com/api/v2/orders';
                    $url = 'https://developers.carrybee.com/api/v2/orders';
                    $carrybee_headers = [
                        'Content-Type: application/json',
                        'Client-ID: ' . $credential['client_id'],
                        'Client-Secret: ' . $credential['client_secret'],
                        'Client-Context: ' . $credential['client_context'],
                    ];

                    $curl = curl_init();
                    curl_setopt_array($curl, [
                        CURLOPT_URL => $url,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => json_encode($carrybee_data),
                        CURLOPT_HTTPHEADER => $carrybee_headers,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_TIMEOUT => 30,
                    ]);

                    $curlResponse = curl_exec($curl);
                    curl_close($curl);

                    // Decode response as array for safe access
                    $response = json_decode($curlResponse, true);

                    // dd($response);
                    if (is_array($response) && empty($response['error'])) {
                        $orderData = $response['data']['order'] ?? [];
                        $consignmentId = $orderData['consignment_id'] ?? null;

                        $order->update([
                            'status' => 7,
                            'consignment_id' => $consignmentId,
                            'is_sent_to_courier' => 1
                        ]);

                        // // Api for update data into particular store
                        // if ($store_info->status == 1) {
                        //     $url = $store_info->base_url . $store_info->ep_order_status . '?status=7' . '&invoice_no=' . $order->invoice_id;
                        //     $response = api_call($url, 'GET', null);
                        //     //dd($response);
                        // }
                    } else {
                        $response = is_array($response) ? ($response['message'] ?? 'N/A') : 'Invalid Carrybee response';
                        // Log::info($response);
                    }
                }
            }

            sleep(2);

            $couriers = [1 => 'Steadfast', 2 => 'Pathao', 3 => 'RedX', 4 => 'Carrybee'];
            $courierName = $couriers[$courier_id] ?? 'Unknown Courier';

            if (isset($couriers[$courier_id]) && $order->consignment_id != null) {
                return response()->json([
                    'status' => true,
                    'courier' => $courierName,
                    'consignment_id' => $order->consignment_id ?? null,
                    'message' => "Sent to {$courierName}" . ($order->consignment_id ? " (Consignment ID: {$order->consignment_id})" : "")
                ]);
            } else {
                return response()->json(['status' => false, 'message' => $response]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function getOrderStatusName($status)
    {
        $status = (int) $status;
        switch ($status) {
            case 1:
                return 'Pending';
            case 2:
                return 'Confirm';
            case 3:
                return 'Processing';
            case 4:
                return 'Hold';
            case 5:
                return 'Printed';
            case 6:
                return 'Packaging';
            case 7:
                return 'Courier Entry';
            case 8:
                return 'On Delivery';
            case 9:
                return 'Delivered';
            case 14:
                return 'Partial Delivered';
            case 10:
                return 'Cancelled';
            case 11:
                return 'Returned';
            case 12:
                return 'Return Received';
            case 13:
                return 'Exchange';

            default:
                return 'Unknown';
        }
    }
}
