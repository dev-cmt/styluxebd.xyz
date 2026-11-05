<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountTransaction;
use App\Coupon;
use App\Courier;
use App\Expense;
use App\Exports\AccountTransactionExport;
use App\Exports\ProductStockReportExport;
use App\Exports\ProfitLossReportExport;
use App\Order;
use App\Product;
use App\PurchaseItem;
use App\Supplier;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function salesOrderReport(Request $request)
    {
        $start = Carbon::today()->startOfDay();
        $end = Carbon::today()->endOfDay();

        if ($request->filled('date_range')) {
            $range = json_decode($request->date_range, true);
            if (!empty($range['start']) && !empty($range['end'])) {
                $start = Carbon::parse($range['start'])->startOfDay();
                $end = Carbon::parse($range['end'])->endOfDay();
            }
        } elseif ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
        }

        $query = Order::with(['get_products.get_product', 'get_courier', 'get_transactions'])
            ->whereBetween('created_at', [$start, $end]);

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }
        if ($request->filled('payment_status') && $request->payment_status !== 'All') {
            $query->where('payment_status', $request->payment_status);
        }
        if ($request->filled('payment_method') && $request->payment_method !== 'All') {
            $query->where('payment_method', $request->payment_method);
        }
        if ($request->filled('order_status') && $request->order_status !== 'All') {
            $query->where('status', $request->order_status);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        $sales = $orders->map(function ($order) {
            $purchaseCost = $order->get_products->sum(function ($item) {
                return ($item->purchase_price ?? $item->get_product->purchase_price ?? 0) * $item->qty;
            });

            $totalQty = $order->get_products->sum('qty');
            $subTotal = $order->sub_total ?? $order->get_products->sum(function ($item) {
                return $item->price * $item->qty;
            });

            $discount = $order->discount ?? 0;
            $shipping = $order->shipping_cost ?? 0;
            $total = $order->total ?? 0;

            // Courier related fields
            $cPaidAmount = $order->c_paid_amount ?? 0;
            $cCollectedAmount = $order->c_collected_amount ?? 0;

            // যদি কুরিয়ার ডেলিভারি ফি বা টোটাল ডেলিভারি ফি থাকে সেটি ধরবে, না থাকলে অর্ডারের নিজস্ব শিপিং কস্ট ধরবে
            $courierDeliveryFee = $order->total_delivery_fee > 0 ? $order->total_delivery_fee : ($order->c_delivery_charge ?? $shipping);

            // Actual Net Profit Calculation:
            // Delivered (status == 9) বা সফল অর্ডারের ক্ষেত্রে কুরিয়ার চার্জ বা ডেলিভারি ফি সহ হিসাব করা হয়
            // Formula: Total Sales (বা Collected) - Purchase Cost - Discount - Courier Delivery Fee
            $netProfit = $total - $purchaseCost - $discount - $courierDeliveryFee;

            return [
                'order_id' => $order->invoice_id ?? $order->id,
                'date' => $order->created_at->format('d-m-Y'),
                'customer' => $order->customer_name ?? 'Guest',
                'phone' => $order->customer_phone ?? '-',
                'qty' => $totalQty,
                'discount' => $discount,
                'shipping' => $shipping,
                'courier_fee' => $courierDeliveryFee,
                'sub_total' => $subTotal,
                'sales' => $total,
                'purchase' => $purchaseCost,
                'profit' => $netProfit,
                'c_paid_amount' => $cPaidAmount,
                'c_collected_amount' => $cCollectedAmount,
                'paid' => $order->paid ?? 0,
                'due' => $order->due ?? 0,
                'courier_name' => $order->get_courier->courier_name ?? '-',
                'method' => $order->payment_method ? ucfirst($order->payment_method) : 'Cash on Delivery',
                'status' => $this->getOrderStatusName($order->status),
                'payment_status' => $order->payment_status == 1 ? 'Paid' : 'Unpaid',
            ];
        });

        $footer = [
            'total_orders' => $sales->count(),
            'total_qty' => $sales->sum('qty'),
            'total_discount' => $sales->sum('discount'),
            'total_shipping' => $sales->sum('shipping'),
            'total_courier_fee' => $sales->sum('courier_fee'),
            'total_sub_total' => $sales->sum('sub_total'),
            'total_sales' => $sales->sum('sales'),
            'total_purchase' => $sales->sum('purchase'),
            'total_profit' => $sales->sum('profit'),
            'total_paid' => $sales->sum('paid'),
            'total_due' => $sales->sum('due'),
        ];

        $customers = User::all();

        return view('backEnd.admin.report.order_sales', compact('sales', 'footer', 'start', 'end', 'customers'));
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

    public function salesProductReport(Request $request)
    {
        $start = Carbon::today()->startOfDay();
        $end = Carbon::today()->endOfDay();

        // Date range filter
        if ($request->filled('date_range')) {
            $range = json_decode($request->date_range, true);
            if (! empty($range['start']) && ! empty($range['end'])) {
                $start = Carbon::parse($range['start'])->startOfDay();
                $end = Carbon::parse($range['end'])->endOfDay();
            }
        }

        // Fetch orders with products and courier info
        $orders = Order::with(['get_products.get_product', 'get_courier'])
            ->whereIn('status', [9, 14]) // Delivered/Completed and Partially Delivered Orders
            ->whereBetween('order_date', [$start, $end])
            ->get();

        $products = collect();

        foreach ($orders as $order) {
            $orderDiscount = $order->discount ?? 0;
            $orderShipping = $order->shipping_cost ?? 0;

            // Courier Delivery Fee Calculation
            $orderCourierFee = $order->total_delivery_fee > 0 ? $order->total_delivery_fee : ($order->c_delivery_charge ?? $orderShipping);

            $orderCoupon = $order->coupon_discount ?? 0;

            $orderTotalQty = $order->get_products->sum('qty');
            if ($orderTotalQty == 0) {
                continue;
            }

            // Get coupon applied product ids if product type coupon
            $couponAppliedProducts = [];
            if ($order->coupon_applied_on === 'product' && ! empty($order->coupon_code)) {
                $coupon = Coupon::where('code', $order->coupon_code)->first();
                $couponAppliedProducts = $coupon ? ($coupon->product_ids ?? []) : [];
            }

            foreach ($order->get_products as $item) {
                $productId = $item->product_id;

                $prod = $products->get($productId, [
                    'product_name' => $item->get_product->name ?? 'Unknown',
                    'sku' => $item->get_product->sku ?? '-',
                    'qty' => 0,
                    'sales' => 0,
                    'purchase' => 0,
                    'discount' => 0,
                    'shipping' => 0,
                    'courier_fee' => 0,
                    'coupon' => 0,
                    'profit' => 0,
                ]);

                $totalPrice = $item->price * $item->qty;
                $totalPurchase = ($item->purchase_price ?? $item->get_product->purchase_price ?? 0) * $item->qty;

                $proportion = $item->qty / $orderTotalQty;

                // Normal order discount proportional
                $distributedDiscount = $orderDiscount * $proportion;

                // Shipping & Courier Fee proportional
                $distributedShipping = $orderShipping * $proportion;
                $distributedCourierFee = $orderCourierFee * $proportion;

                // Coupon discount
                $distributedCoupon = 0;
                if ($orderCoupon > 0) {
                    if ($order->coupon_applied_on === 'cart') {
                        $distributedCoupon = $orderCoupon * $proportion;
                    } elseif ($order->coupon_applied_on === 'product') {
                        if (in_array($productId, $couponAppliedProducts)) {
                            $distributedCoupon = $orderCoupon;
                        }
                    }
                }

                // Actual Net Profit Formula: Total Price - Purchase Cost - Discount - Courier Delivery Fee - Coupon
                $netProfit = $totalPrice - $totalPurchase - $distributedDiscount - $distributedCourierFee - $distributedCoupon;

                $prod['qty'] += $item->qty;
                $prod['sales'] += $totalPrice;
                $prod['purchase'] += $totalPurchase;
                $prod['discount'] += $distributedDiscount;
                $prod['shipping'] += $distributedShipping;
                $prod['courier_fee'] += $distributedCourierFee;
                $prod['coupon'] += $distributedCoupon;
                $prod['profit'] += $netProfit;

                $products->put($productId, $prod);
            }
        }

        $footer = [
            'total_qty' => $products->sum('qty'),
            'total_sales' => $products->sum('sales'),
            'total_purchase' => $products->sum('purchase'),
            'total_discount' => $products->sum('discount'),
            'total_shipping' => $products->sum('shipping'),
            'total_courier_fee' => $products->sum('courier_fee'),
            'total_coupon' => $products->sum('coupon'),
            'total_profit' => $products->sum('profit'),
        ];

        return view('backEnd.admin.report.product_sales', compact('products', 'footer', 'start', 'end'));
    }

    public function profit_loss(Request $request)
    {
        // dd($request->all());
        $start = Carbon::today()->subDays(29);
        $end = Carbon::today();

        if ($request->has('date_range')) {
            $range = json_decode($request->date_range, true);
            if (isset($range['start']) && isset($range['end'])) {
                $start = Carbon::parse($range['start']);
                $end = Carbon::parse($range['end']);
            }
        }
        $trans = AccountTransaction::query();
        $totalPurchaseCost = 0;
        $totalExpenseCost = 0;
        $totalSell = 0;
        if ($request->start_date && $request->end_date) {
            $start = Carbon::parse($request->start_date)->startOfDay()->format('Y-m-d H:i:s');
            $end = Carbon::parse($request->end_date)->endOfDay()->format('Y-m-d H:i:s');
            $tranRange = $trans->whereBetween('created_at', [$start, $end]);
            $totalPurchaseCost = $tranRange->where('purchase_id', '!=', null)->sum('amount');
            $totalSell = $tranRange->where('order_id', '!=', null)->sum('amount');
            $totalExpenseCost = $tranRange->where('expense_id', '!=', null)->sum('amount');
            $daterange = date('d/m/Y', strtotime($request->start_date)) . ' - ' . date('d/m/Y', strtotime($request->end_date));
            if ($request->has('export')) {
                // dd($totalPurchaseCost, $totalSell, $totalExpenseCost);
                $name = 'profit_loss_report';
                $file_name = $name . '_' . date('d-M-Y') . '.xlsx';

                return Excel::download(new ProfitLossReportExport($totalSell, $totalPurchaseCost, $totalExpenseCost), $file_name);
            } else {
                return view('backEnd.admin.report.profit_loss', compact('totalPurchaseCost', 'totalSell', 'totalExpenseCost', 'daterange', 'start', 'end'));
            }
        } else {
            $trans = $trans->whereDate('created_at', now()->toDateString());
            $totalPurchaseCost = $trans->where('purchase_id', '!=', null)->sum('amount');
            $totalSell = $trans->where('order_id', '!=', null)->sum('amount');
            $totalExpenseCost = $trans->where('expense_id', '!=', null)->sum('amount');
            if ($request->has('export')) {
                // dd($totalPurchaseCost,$totalSell ,$totalExpenseCost);
                $name = 'profit_loss_report';
                $file_name = $name . '_' . date('d-M-Y') . '.xlsx';

                return Excel::download(new ProfitLossReportExport($totalSell, $totalPurchaseCost, $totalExpenseCost), $file_name);
            } else {
                return view('backEnd.admin.report.profit_loss', compact('totalPurchaseCost', 'totalSell', 'totalExpenseCost', 'start', 'end'));
            }
        }

        // return view('backEnd.admin.report.profit_loss', compact('totalPurchaseCost', 'totalSell', 'totalExpenseCost'));

    }

    public function productStock(Request $request)
    {
        $query = Product::with(['get_variants', 'get_purchase_items'])
            ->where('is_combo', 0)
            ->where('theme_id', activeThemeData()->id);
        $product_list = DB::table('products')->where('is_combo', 0)->where('theme_id', activeThemeData()->id)->pluck('name', 'id');
        $product_id = $request->input('product_id');

        if ($product_id) {
            $query->where('id', $product_id);
        }

        $setting = DB::table('web_settings')->select('stock_management')->first();
        $stockManagement = $setting->stock_management ?? 0;

        $allProductsForTotal = (clone $query)->where('status', 1)->get();

        $calculatedTotalStock = 0;
        $calculatedTotalPurchaseCost = 0;

        foreach ($allProductsForTotal as $p) {
            $currentStock = 0;
            if ($stockManagement == 1) {
                $currentStock = $p->get_purchase_items->sum('stock_quantity');
                // Purchase items theke cost calculation (stock_quantity * purchase_cost)
                foreach ($p->get_purchase_items as $pItem) {
                    $calculatedTotalPurchaseCost += ($pItem->stock_quantity * ($pItem->purchase_cost ?? 0));
                }
            } else {
                if ($p->get_variants && count($p->get_variants) > 0) {
                    $currentStock = $p->get_variants->sum('stock');
                    foreach ($p->get_variants as $variant) {
                        $calculatedTotalPurchaseCost += ($variant->stock * ($variant->purchase_price ?? $p->purchase_price ?? 0));
                    }
                } else {
                    $currentStock = $p->stock;
                    $calculatedTotalPurchaseCost += ($p->stock * ($p->purchase_price ?? 0));
                }
            }
            $calculatedTotalStock += $currentStock;
        }

        $totalProductsCount = $allProductsForTotal->count();

        $productRange = $query->where('status', 1)->latest()->paginate(10)->appends($request->query());

        return view('backEnd.admin.report.product-stock', compact('productRange', 'product_list', 'calculatedTotalStock', 'calculatedTotalPurchaseCost', 'totalProductsCount', 'product_id', 'stockManagement'));
    }

    public function account_trans(Request $request)
    {
        // dd($request->all());
        $data = AccountTransaction::query();
        $cashIn = 0;
        $cashOut = 0;
        if ($request->start_date && $request->end_date) {
            $start = Carbon::parse($request->start_date)->startOfDay()->format('Y-m-d H:i:s');
            $end = Carbon::parse($request->end_date)->endOfDay()->format('Y-m-d H:i:s');
            $filteredData = $data->whereBetween('created_at', [$start, $end])->get();
            $cashOut = $filteredData->where('transaction_type', 1)->sum('amount');
            $cashIn = $filteredData->where('transaction_type', 0)->sum('amount');

            // dd($cashIn, $cashOut);
            $daterange = date('d/m/Y', strtotime($request->start_date)) . ' - ' . date('d/m/Y', strtotime($request->end_date));
            if ($request->has('export')) {
                $name = 'transaction_report';
                $file_name = $name . '_' . date('d-M-Y') . '.xlsx';

                return Excel::download(new AccountTransactionExport($cashIn, $cashOut), $file_name);
            } else {
                return view('backEnd.admin.report.account-trans', compact('cashIn', 'cashOut', 'daterange', 'start', 'end'));
            }
        } else {
            $data = $data->whereDate('created_at', now()->toDateString());
            $cashOut = $data->where('transaction_type', 1)->sum('amount');
            $cashIn = $data->where('transaction_type', 0)->sum('amount');
            $daterange = date('d/m/Y', strtotime(now()->toDateString()));
            if ($request->has('export')) {
                $name = 'transaction_report';
                $file_name = $name . '_' . date('d-M-Y') . '.xlsx';

                return Excel::download(new AccountTransactionExport($cashIn, $cashOut), $file_name);
            } else {
                return view('backEnd.admin.report.account-trans', compact('cashIn', 'cashOut', 'daterange'));
            }
        }
    }

    public function product_report()
    {

        $data['products'] = Product::latest()->paginate(30);

        return view('backEnd.admin.report.product-stock', compact('data'));
    }

    public function productReport()
    {

        $products = Product::with('get_order_products')->where('status', 1)->get();
        $productReports = [];
        foreach ($products as $key => $product) {
            $pending = 0;
            $confirmed = 0;
            $processing = 0;
            $hold = 0;
            $printed = 0;
            $packaging = 0;
            $on_delivery = 0;
            $delivered = 0;
            $cancelled = 0;
            $returned = 0;
            if ($product->get_order_products->count() > 0) {
                foreach ($product->get_order_products as $key => $item) {
                    // dd($item->get_order->status);
                    if ($item->get_order->status) {
                        if ($item->get_order->status == 1) {
                            $pending += 1;
                        }
                        if ($item->get_order->status == 2) {
                            $confirmed += 1;
                        }
                        if ($item->get_order->status == 3) {
                            $processing += 1;
                        }
                        if ($item->get_order->status == 4) {
                            $hold += 1;
                        }
                        if ($item->get_order->status == 5) {
                            $printed += 1;
                        }
                        if ($item->get_order->status == 6) {
                            $packaging += 1;
                        }
                        if ($item->get_order->status == 7) {
                            $on_delivery += 1;
                        }
                        if ($item->get_order->status == 8) {
                            $delivered += 1;
                        }
                        if ($item->get_order->status == 9) {
                            $cancelled += 1;
                        }
                        if ($item->get_order->status == 10) {
                            $returned += 1;
                        }
                    }
                }
                $productReports[$product->name] = [
                    'pending' => $pending,
                    'confirmed' => $confirmed,
                    'processing' => $processing,
                    'hold' => $hold,
                    'printed' => $printed,
                    'packaging' => $packaging,
                    'on_delivery' => $on_delivery,
                    'delivered' => $delivered,
                    'cancelled' => $cancelled,
                    'returned' => $returned,
                ];
            } else {
                $productReports[$product->name] = [
                    'pending' => 0,
                    'confirmed' => 0,
                    'processing' => 0,
                    'hold' => 0,
                    'printed' => 0,
                    'packaging' => 0,
                    'on_delivery' => 0,
                    'delivered' => 0,
                    'cancelled' => 0,
                    'returned' => 0,
                ];
            }
        }

        return view('backEnd.admin.report.product', compact('productReports'));
    }

    // courierReport
    public function courierReport()
    {
        $couriers = Courier::with('get_orders')->get();
        foreach ($couriers as $key => $courier) {
            $pending = 0;
            $confirmed = 0;
            $processing = 0;
            $hold = 0;
            $printed = 0;
            $packaging = 0;
            $on_delivery = 0;
            $delivered = 0;
            $cancelled = 0;
            $returned = 0;
            if ($courier->get_orders->count() > 0) {
                foreach ($courier->get_orders as $key => $item) {
                    if ($item->status == 1) {
                        $pending += 1;
                    }
                    if ($item->status == 2) {
                        $confirmed += 1;
                    }
                    if ($item->status == 3) {
                        $processing += 1;
                    }
                    if ($item->status == 4) {
                        $hold += 1;
                    }
                    if ($item->status == 5) {
                        $printed += 1;
                    }
                    if ($item->status == 6) {
                        $packaging += 1;
                    }
                    if ($item->status == 7) {
                        $on_delivery += 1;
                    }
                    if ($item->status == 8) {
                        $delivered += 1;
                    }
                    if ($item->status == 9) {
                        $cancelled += 1;
                    }
                    if ($item->status == 10) {
                        $returned += 1;
                    }
                }
                $courierReports[$courier->courier_name] = [
                    'pending' => $pending,
                    'confirmed' => $confirmed,
                    'processing' => $processing,
                    'hold' => $hold,
                    'printed' => $printed,
                    'packaging' => $packaging,
                    'on_delivery' => $on_delivery,
                    'delivered' => $delivered,
                    'cancelled' => $cancelled,
                    'returned' => $returned,
                ];
            } else {
                $courierReports[$courier->courier_name] = [
                    'pending' => 0,
                    'confirmed' => 0,
                    'processing' => 0,
                    'hold' => 0,
                    'printed' => 0,
                    'packaging' => 0,
                    'on_delivery' => 0,
                    'delivered' => 0,
                    'cancelled' => 0,
                    'returned' => 0,
                ];
            }
        }

        return view('backEnd.admin.report.courier', compact('courierReports'));
    }



    public function balanceSheet()
    {
        // --- ASSETS (সম্পদ) ---
        // ১. ক্যাশ ও ব্যাংক ব্যালেন্স
        $totalCashAndBank = Account::where('status', 1)->sum('balance');

        // ২. স্টকে থাকা পণ্যের মোট ক্রয়মূল্য (Inventory Value)
        $totalInventoryValue = PurchaseItem::all()->sum(function ($product) {
            return $product->stock_quantity * ($product->purchase_cost ?? 0);
        });

        // ৩. গ্রাহকের কাছে বকেয়া (Accounts Receivable)
        $totalAccountsReceivable = Order::sum('due');

        // মোট সম্পদ (Total Assets)
        $totalAssets = $totalCashAndBank + $totalInventoryValue + $totalAccountsReceivable;


        // --- LIABILITIES (দায়) ---
        // ১. সাপ্লায়ার এবং সার্ভিস প্রোভাইডারদের মোট বকেয়া (Accounts Payable)
        $totalSupplierPayable = Supplier::sum('balance');
        $suppliersList = Supplier::select('id', 'name', 'balance', 'type', 'phone')->get();

        $totalLiabilities = $totalSupplierPayable;


        // --- EXPENSES BY CATEGORY ---
        $expensesByCategory = Expense::with('get_category')
            ->select('category_id', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('category_id')
            ->get();


        // --- REVENUE & EXPENSES ---
        // ১. প্রকৃত বিক্রয় রেভিনিউ (ডেলিভারি ফি বাদ দিয়ে)
        $totalRevenue = Order::all()->sum(function ($order) {
            $deliveryFee = $order->total_delivery_fee > 0 ? $order->total_delivery_fee : ($order->shipping_cost ?? 0);
            return ($order->total ?? 0) - $deliveryFee;
        });

        // ২. মোট অপারেটিং খরচ
        $totalExpenses = Expense::sum('amount');

        // ৩. নিট প্রফিট / লস
        $netProfitOrLoss = $totalRevenue - $totalExpenses;


        // --- EQUITY (মালিকানা স্বত্ব) ---
        // Accounting Equation (Assets = Liabilities + Equity) সমতা বজায় রাখার জন্য
        // Equity = Total Assets - Total Liabilities
        $totalEquity = $totalAssets - $totalLiabilities;

        // মোট দায় এবং মালিকানা স্বত্ব
        $totalLiabilitiesAndEquity = $totalLiabilities + $totalEquity;

        return view('backEnd.admin.report.balance_sheet', compact(
            'totalCashAndBank',
            'totalInventoryValue',
            'totalAccountsReceivable',
            'totalAssets',
            'totalSupplierPayable',
            'suppliersList',
            'totalLiabilities',
            'totalRevenue',
            'totalExpenses',
            'expensesByCategory',
            'netProfitOrLoss',
            'totalEquity',
            'totalLiabilitiesAndEquity'
        ));
    }
}
