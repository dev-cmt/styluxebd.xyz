@extends('backEnd.admin.layouts.master')
@section('title', 'Balance Sheet Report')

@section('content')
    <div class="page-body mt-3">
        <div class="container-fluid">
            <!-- Header & Overview Cards -->
            <div class="row mb-3">
                <div class="col-12 text-center mb-3">
                    <h3><b>Company Balance Sheet & Financial Overview</b></h3>
                    <p class="text-muted">As of Today: {{ date('d M, Y') }}</p>
                    <div class="badge bg-primary text-white p-2 font-size-14">
                        Equation Check: Total Assets (৳ {{ number_format($totalAssets, 2) }}) = Liabilities & Equity (৳
                        {{ number_format($totalLiabilitiesAndEquity, 2) }})
                    </div>
                </div>

                <!-- Quick Overview Cards -->
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body p-3">
                            <div class="text-uppercase fw-bold small">Total Assets (সম্পদ)</div>
                            <div class="h3 m-0">৳ {{ number_format($totalAssets, 2) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body p-3">
                            <div class="text-uppercase fw-bold small">Total Liabilities (দায়)</div>
                            <div class="h3 m-0">৳ {{ number_format($totalLiabilities, 2) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body p-3">
                            <div class="text-uppercase fw-bold small">Total Equity (মূলধন/স্বত্ব)</div>
                            <div class="h3 m-0">৳ {{ number_format($totalEquity, 2) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body p-3">
                            <div class="text-uppercase fw-bold small">Net Operating Profit</div>
                            <div class="h3 m-0">৳ {{ number_format($netProfitOrLoss, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Balance Sheet Rows -->
            <div class="row">
                <!-- ASSETS SIDE -->
                <div class="col-md-6">
                    <div class="card border border-success mb-3">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Assets (সম্পদসমূহ)</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Cash & Bank Balance (Accounts)</td>
                                        <td class="text-right">৳ {{ number_format($totalCashAndBank, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Inventory Stock Value (পণ্য স্টক)</td>
                                        <td class="text-right">৳ {{ number_format($totalInventoryValue, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Accounts Receivable (Customer Due)</td>
                                        <td class="text-right">৳ {{ number_format($totalAccountsReceivable, 2) }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="font-weight-bold ">
                                        <td>
                                            <h5 class="mb-0">Total Assets (মোট সম্পদ)</h5>
                                        </td>
                                        <td class="text-right text-success">
                                            <h5 class="mb-0">৳ {{ number_format($totalAssets, 2) }}</h5>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- EXPENSE CATEGORY WISE BREAKDOWN -->
                    <div class="card border border-warning">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">Expense Breakdown by Category (ক্যাটাগরি ভিত্তিক খরচ)</h5>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Category Name</th>
                                        <th class="text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($expensesByCategory as $exp)
                                        <tr>
                                            <td>{{ $exp->get_category->name ?? 'Uncategorized' }}</td>
                                            <td class="text-right">৳ {{ number_format($exp->total_amount, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-muted">No expenses recorded.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr class="font-weight-bold ">
                                        <td>Total Expenses</td>
                                        <td class="text-right text-danger">৳ {{ number_format($totalExpenses, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- LIABILITIES & EQUITY SIDE -->
                <div class="col-md-6">
                    <div class="card border border-danger mb-3">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">Liabilities & Equity (দায় ও মূলধন)</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr class="table-active">
                                        <td colspan="2"><b>Liabilities (দায় - Supplier & Vendor Dues)</b></td>
                                    </tr>
                                    @forelse($suppliersList as $sup)
                                        <tr>
                                            <td class="ps-3">&bull; {{ $sup->name }} <span
                                                    class="text-muted font-italic">({{ $sup->type == 1 ? 'Product Supplier' : 'Service Provider' }})</span>
                                            </td>
                                            <td class="text-right">৳ {{ number_format($sup->balance, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-muted">No supplier dues found.</td>
                                        </tr>
                                    @endforelse
                                    <tr class="font-weight-bold table-warning">
                                        <td>Total Liabilities (মোট দায়)</td>
                                        <td class="text-right">৳ {{ number_format($totalLiabilities, 2) }}</td>
                                    </tr>

                                    <tr class="table-active">
                                        <td colspan="2"><b>Equity & Profitability (মালিকানা স্বত্ব ও আয়)</b></td>
                                    </tr>
                                    <tr>
                                        <td>Product Sales Revenue (Excl. Shipping)</td>
                                        <td class="text-right">৳ {{ number_format($totalRevenue, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Operating Expenses</td>
                                        <td class="text-right">(-) ৳ {{ number_format($totalExpenses, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Net Operating Profit</td>
                                        <td class="text-right text-primary fw-bold">৳
                                            {{ number_format($netProfitOrLoss, 2) }}</td>
                                    </tr>
                                    <tr class="font-weight-bold table-info">
                                        <td>Total Retained Equity (নেট মূলধন/স্বত্ব)</td>
                                        <td class="text-right">৳ {{ number_format($totalEquity, 2) }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="font-weight-bold ">
                                        <td class="text-dark">
                                            <h5 class="mb-0">Total Liabilities & Equity</h5>
                                        </td>
                                        <td class="text-right text-danger">
                                            <h5 class="mb-0">৳ {{ number_format($totalLiabilitiesAndEquity, 2) }}</h5>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
