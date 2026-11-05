@extends('backEnd.admin.layouts.master')

@section('title')
    Supplier Transactions - {{ $supplier->name }}
@endsection

@section('content')
    <div class="page-body mt-3">
        <div class="container-xl">
            <!-- Page Header -->
            <div class="row align-items-center mb-3">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="page-title mb-1">Transaction History</h2>
                        <p class="text-muted mb-0">Supplier: <span class="fw-bold text-primary">{{ $supplier->name }}</span>
                            (Phone: {{ $supplier->phone ?? 'N/A' }})</p>
                    </div>
                    <a href="{{ route('admin.supplier') }}" class="btn btn-secondary btn-sm d-flex align-items-center gap-1">
                        <i class="ti ti-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>

            <!-- Content Card -->
            <div class="row row-deck row-cards mt-2">
                <div class="col-12 m-0">
                    <div class="card" style="border-top: none">
                        <div class="card-header d-flex justify-content-between align-items-center py-2">
                            <div class="d-flex align-items-center gap-1">
                                <span class="fw-bold">Total Transactions:</span>
                                <span
                                    class="badge bg-primary text-white">{{ method_exists($transactions, 'total') ? $transactions->total() : count($transactions) }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-1">
                                <span class="fw-bold">Current Balance:</span>
                                <span class="badge bg-info text-white">TK
                                    {{ number_format($supplier->balance ?? 0, 2) }}</span>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr class="align-middle">
                                        <th class="w-1">SL.</th>
                                        <th>Date & Time</th>
                                        <th>Transaction Type</th>
                                        <th>Amount</th>
                                        <th>Previous Balance</th>
                                        <th>New Balance</th>
                                        <th>Note / Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($transactions) && count($transactions) > 0)
                                        @php($i = 1)
                                        @foreach ($transactions as $trx)
                                            <tr @if ($i % 2 == 0) style="background-color:#f5f5f5" @endif>
                                                <td class="sl-cell">{{ $i++ }}.</td>
                                                <td>
                                                    <div class="text-dark fw-semibold">
                                                        <i class="ti ti-calendar text-muted"></i>
                                                        {{ $trx->created_at ? $trx->created_at->format('d M Y') : 'N/A' }}
                                                    </div>
                                                    <small class="text-muted">
                                                        <i class="ti ti-clock"></i>
                                                        {{ $trx->created_at ? $trx->created_at->format('h:i:s A') : '' }}
                                                    </small>
                                                </td>
                                                <td>
                                                    @if (strtolower($trx->type) == 'payment')
                                                        <span class="badge bg-success text-white px-2 py-1">Payment</span>
                                                    @else
                                                        <span
                                                            class="badge bg-info text-white px-2 py-1">{{ ucfirst($trx->type) }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="fw-bold text-dark">TK
                                                        {{ number_format($trx->amount, 2) }}</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted">TK
                                                        {{ number_format($trx->previous_balance ?? 0, 2) }}</span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold text-primary">TK
                                                        {{ number_format($trx->new_balance ?? 0, 2) }}</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted">{{ $trx->notes ?? 'N/A' }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <span class="text-danger"><b>No transactions found for this
                                                        supplier!</b></span>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        @if (isset($transactions) && method_exists($transactions, 'links'))
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <div class="m-0 text-muted">
                                    Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }}
                                    of {{ $transactions->total() }} entries
                                </div>
                                <div>
                                    {{ $transactions->links() }}
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
