@extends('backEnd.admin.layouts.master')

@section('title')
    Stock Adjustment List
@endsection

@php
    $data = $data ?? [];
@endphp

@section('content')
    <div class="page-body mt-3">
        <div class="container-xl">
            <div class="row">
                <div class="col-12 d-flex justify-content-between align-items-center gap-2">
                    <h2 class="page-title">Stock Adjustment List</h2>
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center gap-1">
                            <span class="fw-bold">Total:</span>
                            <span class="badge bg-primary text-white">{{ $data->total() }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-deck row-cards mt-2">
                <div class="col-12 m-0">
                    <div class="card" style="border-top: none">
                        <div class="card-header d-flex align-items-center gap-2">
                            <a href="{{ route('admin.stock.adjustment.create') }}" class="btn btn-success btn-sm">
                                <i class="ti ti-plus"></i> Add New Adjustment
                            </a>
                        </div>
                        <div class="table-responsive">
                            @include('backEnd.admin.includes.top-paginate', ['items' => $data])
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr class="align-middle">
                                        <th class="w-1">SL.</th>
                                        <th style="width: 15%;">Date</th>
                                        <th style="width: 25%;">Reason & Note</th>
                                        <th style="width: 55%;">Products Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i = 1)
                                    @if ($data->count() > 0)
                                        @foreach ($data as $item)
                                            <tr @if ($i % 2 == 0) style="background-color:#f5f5f5" @endif
                                                class="align-middle">
                                                <td class="sl-cell fw-bold">
                                                    {{ $data->firstItem() + ($i - 1) }}.
                                                </td>
                                                <td>
                                                    <span class="fw-semibold text-secondary">
                                                        {{ date('d M, Y', strtotime($item->adjustment_date)) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-info text-dark px-2 py-1 mb-1">{{ $item->reason }}</span>
                                                    @if ($item->note)
                                                        <p class="text-muted mb-0 small"><i class="ti ti-note"></i>
                                                            {{ $item->note }}</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-bordered mb-0 bg-light rounded">
                                                            <thead>
                                                                <tr class="table-secondary">
                                                                    <th>Product Name / SKU</th>
                                                                    <th class="text-center" style="width: 20%;">Qty</th>
                                                                    <th class="text-center" style="width: 25%;">Type</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($item->items as $adjustmentItem)
                                                                    <tr>
                                                                        <td>
                                                                            <span
                                                                                class="fw-medium text-dark">{{ $adjustmentItem->product->name ?? 'N/A' }}</span>
                                                                            @if ($adjustmentItem->sku)
                                                                                <br><small class="text-muted">SKU:
                                                                                    {{ $adjustmentItem->sku }}</small>
                                                                            @endif
                                                                        </td>
                                                                        <td class="text-center text-dark fw-semibold">
                                                                            {{ $adjustmentItem->adjusted_quantity }}</td>
                                                                        <td class="text-center">
                                                                            <span
                                                                                class="badge bg-{{ $adjustmentItem->type == 'addition' ? 'success' : 'danger' }} px-2">
                                                                                {{ ucfirst($adjustmentItem->type) }}
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php($i++)
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center text-danger font-weight-bold py-4">No
                                                Stock Adjustments Found!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            @include('backEnd.admin.includes.bottom-paginate', ['items' => $data])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
