<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountTransaction;
use App\Expense;
use App\ExpenseBill;
use App\ExpenseCategory;
use App\Supplier;
use App\SupplierTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function index()
    {
        $data = Expense::with('get_transaction')->paginate(20);
        // dd($data);
        $categories = ExpenseCategory::where('status', 1)->pluck('name', 'id');
        $accounts = Account::where('status', 1)->get();

        return view('backEnd.admin.expense.index', compact('data', 'categories', 'accounts'));
    }

    public function store(Request $request)
    {
        $expense = Expense::create($request->all());
        Account::findOrFail($request->account_id)->decrement('balance', $request->amount);
        AccountTransaction::create([
            'expense_id' => $expense->id,
            'account_id' => $request->account_id,
            'amount' => $request->amount,
            'transaction_type' => 1,
            'purpose' => $request->purpose,
        ]);

        return back()->with('success', 'Expense created successfully.');
    }

    public function update(Request $request)
    {
        $expense = Expense::find($request->id);
        $amount = $expense->amount;
        $expense->update($request->all());

        $account = Account::findOrFail($request->account_id);
        $account->increment('balance', $amount);
        $account->decrement('balance', $request->amount);

        $expense->get_transaction()->delete();

        AccountTransaction::create([
            'expense_id' => $request->id,
            'account_id' => $request->account_id,
            'amount' => $request->amount,
            'transaction_type' => 1,
            'purpose' => $request->note,
        ]);

        return back()->with('success', 'Expense updated successfully.');
    }

    public function status($id, $status)
    {
        $supplier = Expense::FindOrFail($id);
        $supplier->status = $status;
        $supplier->update();

        return back()->with('success', 'Expense Status Updated Successfully');
    }

    public function delete($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->get_transaction->get_account()->increment('balance', $expense->amount);
        $expense->get_transaction()->delete();
        $expense->delete();

        return back()->with('success', 'Expense deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:expenses,id' // আপনার ডাটাবেজ টেবিল নাম দেবেন
        ]);
        try {
            DB::beginTransaction();
            // Perform Bulk Delete
            Expense::whereIn('id', $request->ids)->delete();
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


    public function servicesIndex()
    {
        // Product supplier (type = 1) বাদে বাকি সব সার্ভিস প্রোভাইডার এবং তাদের ট্রানজাকশন লোড হবে[cite: 27]
        $suppliers = Supplier::where('type', '!=', 1)->with('transactions')->latest()->paginate(20);
        $accounts = Account::where('status', 1)->get();
        $expenseCategories = ExpenseCategory::where('status', 1)->get();
        return view('backEnd.admin.expense.services', compact('suppliers', 'accounts', 'expenseCategories'));
    }

    public function storeService(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'balance' => 'nullable|numeric',
        ]);

        DB::transaction(function () use ($request) {
            $openingBalance = $request->balance ?? 0.00;

            // ১. সার্ভিস প্রোভাইডার তৈরি
            $supplier = Supplier::create([
                'name'    => $request->name,
                'type'    => 2, // 2 = Service Provider / IT Firm
                'phone'   => $request->phone,
                'email'   => $request->email,
                'address' => $request->address,
                'balance' => $openingBalance,
            ]);

            // ২. যদি ওপেনিং ব্যালেন্স বা ডিউ থাকে, তবে ট্রানজাকশনে রেকর্ড রাখা
            if ($openingBalance > 0) {
                SupplierTransaction::create([
                    'supplier_id'      => $supplier->id,
                    'type'             => 'opening',
                    'amount'           => $openingBalance,
                    'previous_balance' => 0.00,
                    'new_balance'      => $openingBalance,
                    'notes'            => 'Opening due balance',
                ]);
            }
        });

        return back()->with('success', 'Service Provider Created Successfully');
    }

    public function updateService(Request $request)
    {
        $request->validate([
            'id'    => 'required|exists:suppliers,id',
            'name'  => 'required|string|max:255',
        ]);

        $supplier = Supplier::findOrFail($request->id);
        $supplier->update([
            'name'    => $request->name,
            'phone'   => $request->phone,
            'email'   => $request->email,
            'address' => $request->address,
        ]);

        return back()->with('success', 'Service Provider Updated Successfully');
    }

    public function payServiceDue(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'amount'      => 'required|numeric|min:0',
            'account_id'  => 'required|exists:accounts,id',
            'category_id' => 'nullable|exists:expense_categories,id',
        ]);

        DB::transaction(function () use ($request) {
            $amount = $request->amount;
            $supplierId = $request->supplier_id;

            // ১. ExpenseBill এ রেকর্ড রাখা (যাতে সহজে ডিলিট বা ট্র্যাক করা যায়)
            ExpenseBill::create([
                'supplier_id' => $supplierId,
                'category_id' => $request->category_id,
                'amount'      => $amount,
                'note'        => $request->note ?? 'Service bill payment',
            ]);

            // ২. Account থেকে টাকা কমানো (Cash Out) এবং Account Transaction এন্ট্রি
            $account = Account::find($request->account_id);
            $account->decrement('balance', $amount);

            AccountTransaction::create([
                'account_id'       => $account->id,
                'amount'           => $amount,
                'transaction_type' => 1, // Cash Out
                'purpose'          => 'Payment to service provider (Bill)',
            ]);

            // ৩. প্রোভাইডারের ব্যালেন্স হিসাব ও Supplier Transaction এন্ট্রি
            $supplier = Supplier::find($supplierId);
            $previousBalance = $supplier->balance;
            $newBalance = $previousBalance - $amount;

            SupplierTransaction::create([
                'supplier_id'      => $supplierId,
                'type'             => 'payment',
                'amount'           => $amount,
                'previous_balance' => $previousBalance,
                'new_balance'      => $newBalance,
                'notes'            => 'Service bill payment settled',
            ]);

            // ৪. Supplier এর মূল balance আপডেট করা
            $supplier->update(['balance' => $newBalance]);
        });

        return back()->with('success', 'Service Bill Paid Successfully');
    }
}
