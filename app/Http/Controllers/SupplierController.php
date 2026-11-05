<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountTransaction;
use App\Http\Controllers\Controller;
use App\Purchase;
use App\Supplier;
use App\SupplierTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index()
    {
        $data = Supplier::where('type', 1)->orderBy('id', 'desc')->paginate(25);
        return view('backEnd.admin.supplier.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);
        Supplier::create($request->all());

        return back()->with('success', 'Supplier Created Successfully');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);
        Supplier::find($request->id)->update($request->all());

        return back()->with('success', 'Supplier Updated Successfully');
    }

    public function delete($id)
    {
        $supplier = Supplier::with('transactions')->find($id);
        if ($supplier->transactions()->exists()) {
            return back()->with('error', 'Cannot delete supplier with existing transactions.');
        }
        $supplier->delete();
        return back()->with('success', 'Supplier Deleted Successfully');
    }

    public function status(Request $request)
    {
        // dd($request->all());
        $data = Supplier::find($request->id);
        $data->update([
            'status' => ! $data->status,
        ]);

        return back()->with('success', 'Status Updated Successfully');
    }

    public function bulkDelete(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:suppliers,id' // আপনার ডাটাবেজ টেবিল নাম দেবেন
        ]);
        try {
            DB::beginTransaction();
            // Perform Bulk Delete
            Supplier::whereIn('id', $request->ids)->delete();
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

    //transactions
    public function transactions($id)
    {
        $supplier = Supplier::findOrFail($id);
        $transactions = SupplierTransaction::where('supplier_id', $id)->paginate(10);

        return view('backEnd.admin.supplier.transactions', compact('supplier', 'transactions'));
    }


    // AJAX Endpoint: Supplier-er under-e due thaka purchase list anar jonno
    public function getSupplierPurchases($supplierId)
    {
        // dd($supplierId);
        $purchases = Purchase::where('supplier_id', $supplierId)
            // ->where('due_amount', '>', 0)
            ->select('id', 'memo_no', 'total', 'paid_amount', 'due_amount')
            ->get();

        return response()->json($purchases);
    }

    // Purchase Due Payment Store Method
    public function payPurchaseDue(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_id' => 'required|exists:purchases,id',
            'account_id'  => 'required|exists:accounts,id',
            'amount'      => 'required|numeric|min:0.01',
        ]);

        DB::transaction(function () use ($request) {
            $amount = $request->amount;
            $purchase = Purchase::findOrFail($request->purchase_id);
            $supplier = Supplier::findOrFail($request->supplier_id);
            $account = Account::findOrFail($request->account_id);

            // ১. Purchase record update (Paid increase & Due decrease)
            $newPurchasePaid = $purchase->paid_amount + $amount;
            $newPurchaseDue = max(0, $purchase->due_amount - $amount);
            $purchase->update([
                'paid_amount' => $newPurchasePaid,
                'due_amount'  => $newPurchaseDue,
            ]);

            // ২. Account balance decrease (Cash Out)
            $account->decrement('balance', $amount);

            // ৩. Account Transaction create
            AccountTransaction::create([
                'account_id'       => $account->id,
                'purchase_id'      => $purchase->id,
                'amount'           => $amount,
                'transaction_type' => 1, // Cash Out
                'purpose'          => 'Supplier Purchase Payment (Memo: ' . $purchase->memo_no . ')',
            ]);

            // ৪. Supplier balance & Supplier Transaction record update
            $previousBalance = $supplier->balance;
            $newBalance = $previousBalance - $amount;

            SupplierTransaction::create([
                'supplier_id'      => $supplier->id,
                'type'             => 'payment',
                'amount'           => $amount,
                'previous_balance' => $previousBalance,
                'new_balance'      => $newBalance,
                'notes'            => 'Paid for Purchase Memo #' . $purchase->memo_no,
            ]);

            $supplier->update(['balance' => $newBalance]);
        });

        return back()->with('success', 'Purchase Payment Successful!');
    }
}
