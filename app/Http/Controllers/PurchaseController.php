<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountTransaction;
use App\Product;
use App\ProductVariant;
use App\Purchase;
use App\PurchaseItem;
use App\Supplier;
use App\SupplierTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $data = Purchase::with('get_supplier')->latest()->paginate(20);
        return view('backEnd.admin.purchase.index', compact('data'));
    }

    public function create()
    {
        $products = Product::where(['is_combo' => 0, 'is_package' => 0, 'status' => 1, 'theme_id' => activeThemeData()->id])
            ->latest()
            ->pluck('name', 'id');
        $suppliers = Supplier::where([['status', 1], ['type', '!=', 2]])->pluck('name', 'id');
        $accounts = Account::where('status', 1)->get();

        $latestPurchase = Purchase::latest('id')->first();
        if ($latestPurchase && $latestPurchase->memo_no) {
            $lastNumber = (int) str_replace('MEMO-', '', $latestPurchase->memo_no);
            $memo_no = 'MEMO-' . ($lastNumber + 1);
        } else {
            $memo_no = 'MEMO-1';
        }

        return view('backEnd.admin.purchase.create', compact('products', 'suppliers', 'accounts', 'memo_no'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required',
            'status' => 'required',
            'paid_amount' => 'required|numeric|min:0',
            'product_id' => 'required|array',
            'subtotal' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            $totalAmount = $request->total;
            $paidAmount = $request->paid_amount;
            $dueAmount = max(0, $totalAmount - $paidAmount);

            // 1. Purchase Create (Paid amount initially 0 rekhe pore update/transaction handle korbo)
            $purchase = Purchase::create($request->except(['paid_amount', 'due_amount']) + [
                'purchase_date' => date('Y-m-d', strtotime($request->purchase_date)),
                'paid_amount' => 0,
                'due_amount' => $totalAmount,
            ]);

            foreach ($request->product_id as $key => $product_id) {
                $product = Product::with('get_variants')->findOrFail($product_id);
                $orderedQty = $request->purchase_quantity[$key];

                if ($request->status == 'received') {
                    if (count($product->get_variants) > 0 && !empty($request->sku[$key])) {
                        $product_attribute = ProductVariant::where('sku', $request->sku[$key])->first();
                        if ($product_attribute) {
                            $product_attribute->stock += $orderedQty;
                            $product_attribute->purchase_price = $request->purchase_cost[$key] ?? $product_attribute->purchase_price;
                            $product_attribute->save();
                        }
                    }
                    $product->stock += $orderedQty;
                    $product->purchase_price = $request->purchase_cost[$key] ?? $product->purchase_price;
                    $product->save();
                }

                PurchaseItem::create([
                    'product_id' => $product_id,
                    'purchase_id' => $purchase->id,
                    'sku' => $request->sku[$key] ?? null,
                    'ordered_quantity' => $orderedQty,
                    'received_quantity' => $request->status == 'received' ? $orderedQty : 0,
                    'stock_quantity' => $request->status == 'received' ? $orderedQty : 0,
                    'purchase_cost' => $request->purchase_cost[$key],
                    'total' => $request->single_purchase_total[$key],
                ]);
            }

            // Supplier Model
            $supplier = Supplier::findOrFail($request->supplier_id);
            $currentBalance = $supplier->balance ?? 0;

            // 1. Purchase Transaction (Rule 1)
            $balanceAfterPurchase = $currentBalance + $totalAmount;
            SupplierTransaction::create([
                'supplier_id' => $supplier->id,
                'type' => 'purchase',
                'amount' => $totalAmount,
                'previous_balance' => $currentBalance,
                'new_balance' => $balanceAfterPurchase,
                'notes' => 'Purchase created with memo: ' . $purchase->memo_no,
            ]);
            $currentBalance = $balanceAfterPurchase;

            // 2. Initial Payment Transaction (Rule 2)
            if ($paidAmount > 0) {
                if (!$request->account_id) {
                    throw new \Exception('Payment account is required for paid amount!');
                }
                $account = Account::findOrFail($request->account_id);
                if ($account->balance < $paidAmount) {
                    throw new \Exception('Insufficient account balance!');
                }
                $account->decrement('balance', $paidAmount);

                AccountTransaction::create([
                    'purchase_id' => $purchase->id,
                    'account_id' => $request->account_id,
                    'amount' => $paidAmount,
                    'transaction_type' => 1,
                    'purpose' => 'Initial Purchase Payment (Memo: ' . $purchase->memo_no . ')',
                ]);

                $balanceAfterPayment = max(0, $currentBalance - $paidAmount);
                SupplierTransaction::create([
                    'supplier_id' => $supplier->id,
                    'type' => 'payment',
                    'amount' => $paidAmount,
                    'previous_balance' => $currentBalance,
                    'new_balance' => $balanceAfterPayment,
                    'notes' => 'Initial payment for memo: ' . $purchase->memo_no,
                ]);
                $currentBalance = $balanceAfterPayment;
            }

            // Update Purchase paid & due amount
            $purchase->update([
                'paid_amount' => $paidAmount,
                'due_amount' => max(0, $totalAmount - $paidAmount),
            ]);

            // Update Supplier Final Balance
            $supplier->update([
                'balance' => $currentBalance,
            ]);

            DB::commit();
            return redirect()->route('admin.purchase')->with('success', 'Product purchase successfully created.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $data = Purchase::with('get_purchase_items')->findOrFail($id);
        $products = Product::where(['is_combo' => 0, 'is_package' => 0, 'status' => 1, 'theme_id' => activeThemeData()->id])
            ->latest()
            ->pluck('name', 'id');
        $suppliers = Supplier::where([['status', 1], ['type', '!=', 2]])->pluck('name', 'id');
        $accounts = Account::where('status', 1)->get();

        return view('backEnd.admin.purchase.edit', compact('data', 'products', 'suppliers', 'accounts'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required',
            'status' => 'required',
            'product_id' => 'required|array',
            'subtotal' => 'required|numeric',
            'total' => 'required|numeric',
            'paid_amount' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $purchase = Purchase::with('get_purchase_items')->findOrFail($id);
            $supplier = Supplier::findOrFail($request->supplier_id);
            $currentBalance = $supplier->balance ?? 0;

            // 1. Revert previous stock if it was received
            if ($purchase->status == 'received') {
                foreach ($purchase->get_purchase_items as $oldItem) {
                    $product = Product::with('get_variants')->find($oldItem->product_id);
                    if ($product) {
                        $qtyToRevert = $oldItem->received_quantity ?? $oldItem->ordered_quantity;
                        if (count($product->get_variants) > 0 && !empty($oldItem->sku)) {
                            $product_attribute = ProductVariant::where('sku', $oldItem->sku)->first();
                            if ($product_attribute) {
                                $product_attribute->stock -= $qtyToRevert;
                                $product_attribute->save();
                            }
                        }
                        $product->stock -= $qtyToRevert;
                        $product->save();
                    }
                }
            }

            // 2. Delete old purchase items (Rule 3: Old financial history delete hobe na, shudhu items update hobe)
            PurchaseItem::where('purchase_id', $id)->delete();

            $oldTotal = $purchase->total;
            $newTotal = $request->total;
            $totalDifference = $newTotal - $oldTotal; // Positive hole amount barse, negative hole komse

            // Rule 4: Purchase total change -> adjustment transaction
            // if ($totalDifference != 0 ) {
            //     dd(1);
            //     $balanceAfterAdj = $currentBalance + $totalDifference;
            //     SupplierTransaction::create([
            //         'supplier_id' => $supplier->id,
            //         'type' => 'adjustment', // ba purchase adjustment
            //         'amount' => abs($totalDifference),
            //         'previous_balance' => $currentBalance,
            //         'new_balance' => $balanceAfterAdj,
            //         'notes' => 'Purchase total adjusted for memo: ' . $purchase->memo_no . ' (Diff: ' . $totalDifference . ')',
            //     ]);
            //     $currentBalance = $balanceAfterAdj;
            // }

            // Rule 5: Update-er somoy notun payment hole -> notun payment transaction
            $newAdditionalPaid = $request->paid_amount ?? 0;
            if ($newAdditionalPaid > 0) {
                // dd(2);
                if (!$request->account_id) {
                    throw new \Exception('Payment account is required for new payment!');
                }
                $account = Account::findOrFail($request->account_id);
                if ($account->balance < $newAdditionalPaid) {
                    throw new \Exception('Insufficient account balance!');
                }
                $account->decrement('balance', $newAdditionalPaid);

                AccountTransaction::create([
                    'purchase_id' => $purchase->id,
                    'account_id' => $request->account_id,
                    'amount' => $newAdditionalPaid,
                    'transaction_type' => 1,
                    'purpose' => 'Additional Payment during Update (Memo: ' . $purchase->memo_no . ')',
                ]);

                $balanceAfterNewPay = max(0, $currentBalance - $newAdditionalPaid);
                SupplierTransaction::create([
                    'supplier_id' => $supplier->id,
                    'type' => 'payment',
                    'amount' => $newAdditionalPaid,
                    'previous_balance' => $currentBalance,
                    'new_balance' => $balanceAfterNewPay,
                    'notes' => 'Additional payment during update, memo: ' . $purchase->memo_no,
                ]);
                $currentBalance = $balanceAfterNewPay;
            }

            $totalPaidSoFar = $purchase->paid_amount + $newAdditionalPaid;
            $finalDue = max(0, $newTotal - $totalPaidSoFar);

            // Update Purchase info
            $purchase->update($request->except(['paid_amount', 'due_amount']) + [
                'purchase_date' => date('Y-m-d', strtotime($request->purchase_date)),
                'paid_amount' => $totalPaidSoFar,
                'due_amount' => $finalDue,
            ]);

            // Update Supplier Balance
            $supplier->update([
                'balance' => $currentBalance,
            ]);

            // 4. Insert new items and adjust stock if status is received
            foreach ($request->product_id as $key => $product_id) {
                $product = Product::with('get_variants')->findOrFail($product_id);
                $orderedQty = $request->purchase_quantity[$key];
                $isReceived = ($request->status == 'received');

                if ($isReceived) {
                    if (count($product->get_variants) > 0 && !empty($request->sku[$key])) {
                        $product_attribute = ProductVariant::where('sku', $request->sku[$key])->first();
                        if ($product_attribute) {
                            $product_attribute->stock += $orderedQty;
                            $product_attribute->purchase_price = $request->purchase_cost[$key] ?? $product_attribute->purchase_price;
                            $product_attribute->save();
                        }
                    }
                    $product->stock += $orderedQty;
                    $product->purchase_price = $request->purchase_cost[$key] ?? $product->purchase_price;
                    $product->save();
                }

                PurchaseItem::create([
                    'product_id' => $product_id,
                    'purchase_id' => $purchase->id,
                    'sku' => $request->sku[$key] ?? null,
                    'ordered_quantity' => $orderedQty,
                    'received_quantity' => $isReceived ? $orderedQty : 0,
                    'stock_quantity' => $isReceived ? $orderedQty : 0,
                    'purchase_cost' => $request->purchase_cost[$key],
                    'total' => $request->single_purchase_total[$key],
                ]);
            }

            DB::commit();
            return redirect()->route('admin.purchase')->with('success', 'Product purchase updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function status(Request $request, $id)
    {
        $data = Purchase::findOrFail($id);
        $data->status = $request->status;
        $data->save();

        return back()->with('success', 'Status updated successfully.');
    }

    public function delete(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $purchase = Purchase::findOrFail($id);
            PurchaseItem::where('purchase_id', $id)->delete();
            $purchase->delete();

            DB::commit();
            return back()->with('success', 'Purchase deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function ajaxGetPurchaseProduct(Request $request)
    {
        $product = Product::with('get_variants')->findOrFail($request->id);
        return view('backEnd.admin.purchase.partials.ajax_get_purchase_product', compact('product'))->render();
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:purchases,id'
        ]);
        try {
            DB::beginTransaction();
            foreach ($request->ids as $id) {
                PurchaseItem::where('purchase_id', $id)->delete();
                Purchase::destroy($id);
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

    public function recieve(Request $request)
    {
        $data = Purchase::latest()->paginate(20);
        return view('backEnd.admin.purchase.recieve.index', compact('data'));
    }

    public function receiveModal(Request $request, $id)
    {
        $purchase = Purchase::with(['get_purchase_items.get_product', 'get_supplier'])->findOrFail($id);
        if ($request->ajax()) {
            return view('backEnd.admin.purchase.recieve.receive_modal', compact('purchase'));
        }
    }

    public function receiveUpdateStore(Request $request)
    {
        $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'items' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $purchase = Purchase::with('get_purchase_items')->findOrFail($request->purchase_id);

            foreach ($request->items as $itemId => $receiveNow) {
                $receiveNow = (int) $receiveNow;

                if ($receiveNow > 0) {
                    $purchaseItem = PurchaseItem::findOrFail($itemId);
                    $currentReceived = $purchaseItem->received_quantity ?? 0;
                    $newReceivedQty = $currentReceived + $receiveNow;
                    $purchase_cost = $purchaseItem->purchase_cost ?? 0;

                    if ($newReceivedQty <= $purchaseItem->ordered_quantity) {
                        $purchaseItem->received_quantity = $newReceivedQty;
                        $purchaseItem->stock_quantity = $newReceivedQty;
                        $purchaseItem->save();

                        $product = Product::with('get_variants')->find($purchaseItem->product_id);
                        if ($product) {
                            if (count($product->get_variants) > 0 && !empty($purchaseItem->sku)) {
                                $product_attribute = ProductVariant::where('sku', $purchaseItem->sku)->first();
                                if ($product_attribute) {
                                    $product_attribute->stock += $receiveNow;
                                    $product_attribute->purchase_price = $purchase_cost;
                                    $product_attribute->save();
                                }
                            }
                            $product->stock += $receiveNow;
                            $product->purchase_price = $purchase_cost;
                            $product->save();
                        }
                    }
                }
            }

            $allReceived = true;
            foreach ($purchase->get_purchase_items()->get() as $item) {
                if (($item->received_quantity ?? 0) < $item->ordered_quantity) {
                    $allReceived = false;
                    break;
                }
            }

            $purchase->status = $allReceived ? 'received' : 'partial';
            $purchase->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Stock successfully updated!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'change' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function payModal(Request $request, $id)
    {
        $purchase = Purchase::with('get_supplier', 'get_purchase_items')->findOrFail($id);
        $accounts = Account::where('status', 1)->get();

        if ($request->ajax()) {
            return view('backEnd.admin.purchase.partials.pay_modal', compact('purchase', 'accounts'));
        }
    }

    public function payStore(Request $request) // Rule 6: Due Payment -> Notun payment transaction
    {
        $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'paid_amount' => 'required|numeric|min:0.01',
            'account_id' => 'required|exists:accounts,id',
        ]);

        DB::beginTransaction();
        try {
            $account = Account::findOrFail($request->account_id);
            if ($account->balance < $request->paid_amount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient account balance!'
                ], 422);
            }

            $purchase = Purchase::findOrFail($request->purchase_id);

            if ($request->paid_amount > $purchase->due_amount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Paid amount cannot be greater than due amount!'
                ], 422);
            }

            // Purchase Balance Update
            $purchase->paid_amount += $request->paid_amount;
            $purchase->due_amount -= $request->paid_amount;
            $purchase->save();

            // Account Balance & Transaction
            $account->decrement('balance', $request->paid_amount);

            AccountTransaction::create([
                'purchase_id' => $purchase->id,
                'account_id' => $request->account_id,
                'amount' => $request->paid_amount,
                'transaction_type' => 1,
                'purpose' => 'Purchase Due Payment (Memo: ' . $purchase->memo_no . ')',
            ]);

            // Supplier Balance & Transaction Record
            $supplier = Supplier::findOrFail($purchase->supplier_id);
            $previousBalance = $supplier->balance ?? 0;
            $newBalance = max(0, $previousBalance - $request->paid_amount);

            $supplier->update([
                'balance' => $newBalance,
            ]);

            SupplierTransaction::create([
                'supplier_id' => $supplier->id,
                'type' => 'payment',
                'amount' => $request->paid_amount,
                'previous_balance' => $previousBalance,
                'new_balance' => $newBalance,
                'notes' => $request->note ?? 'Paid for purchase memo: ' . $purchase->memo_no,
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Payment successfully completed!'
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
