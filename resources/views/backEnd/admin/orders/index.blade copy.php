@extends('backEnd.admin.layouts.master')

@section('title')
@if (!$sts)
All Orders
@else
{{ Str::ucfirst(str_replace('_', ' ', $sts)) }} Orders
@endif
@endsection
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('backEnd/assets/plugin/datepicker/daterangepicker.css') }}" />
<style>
    .telephone {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #06b6d4;
        color: white;
        text-decoration: none;
        box-shadow: 0 2px 5px rgba(6, 182, 212, 0.2);
        transition: box-shadow .2s ease;
    }
</style>
<style>
    /* Dropdown UI Refinement */
    .cursor-pointer {
        cursor: pointer;
    }

    /* Dynamic focus state for the select dropdown */
    #perPageSelect:focus {
        outline: none;
        box-shadow: none;
    }

    /* Bootstrap 5 Pagination Button Fine-Tuning */
    .custom-pagination .pagination {
        margin-bottom: 0;
        gap: 4px;
    }

    .custom-pagination .page-item .page-link {
        border-radius: 6px !important;
        padding: 0.25rem 0.6rem;
        font-size: 13px;
        color: #495057;
        border: 1px solid #e2e8f0;
    }

    .custom-pagination .page-item.active .page-link {
        background-color: #206bc4;
        border-color: #206bc4;
        color: #fff;
    }

    /* Bootstrap 5 Pagination Button Fine-Tuning */
    .custom-pagination .pagination {
        margin-bottom: 0;
        gap: 4px;
    }

    .custom-pagination .page-item .page-link {
        border-radius: 8px !important;
        /* ছবিতে থাকা হালকা গোলাকার বর্ডার */
        padding: 0.3rem 0.65rem;
        font-size: 13px;
        color: #206bc4;
        border: 1px solid #e2e8f0;
        background-color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
    }

    .custom-pagination .page-item.active .page-link {
        background-color: #206bc4;
        border-color: #206bc4;
        color: #fff;
    }

    .custom-pagination .page-item.disabled .page-link {
        color: #a5a5a5;
        background-color: #fff;
        border-color: #e2e8f0;
    }
</style>
<style>
    p.small {
        margin-bottom: 0;
        font-size: 0.75rem;
        margin-right: 0.5rem;
    }
</style>
@endpush
@php
$orders = $data['orders'] ?? 0;
$total_order = $data['total_order'] ?? 0;
$total_pending_order = $data['total_pending_order'] ?? 0;
$total_confirm_order = $data['total_confirm_order'] ?? 0;
$total_processing_order = $data['total_processing_order'] ?? 0;
$total_hold_order = $data['total_hold_order'] ?? 0;
$total_printed_order = $data['total_printed_order'] ?? 0;
$total_packaging_order = $data['total_packaging_order'] ?? 0;
$total_courier_entry_order = $data['total_courier_entry_order'] ?? 0;
$total_on_delivery_order = $data['total_on_delivery_order'] ?? 0;
$total_delivered_order = $data['total_delivered_order'] ?? 0;
$total_cancelled_order = $data['total_cancelled_order'] ?? 0;
$total_returned_order = $data['total_returned_order'] ?? 0;
$total_trash_order = $data['total_trash_order'] ?? 0;

$couriers = \Illuminate\Support\Facades\DB::table('couriers')->where('status', 1)->pluck('courier_name', 'id');
$query = request()->query('query') ?? null;
$source = $source ?? null;
$payment_status = $payment_status ?? null;
$courier_id = $courier_id ?? null;
$status = $sts ?? null;
@endphp
{{-- @dd($sts) --}}
@section('content')

<div class="page-body mt-0">
    <div class="container-xl">
        <div class="order-header d-flex justify-content-between align-items-start flex-wrap gap-2" style="">
            <div class="d-flex align-items-center">
                <h2 class="mb-0 me-2">
                    @if (!$sts)
                    All Orders
                    @else
                    <span class="text-capitalize text-success">
                        {{ Str::ucfirst(str_replace('_', ' ', $sts)) }} Orders
                    </span>
                    @endif
                </h2>

                <a href="{{ route('admin.orders.trash') }}" class="btn btn-dark btn-sm d-flex align-items-center gap-1"
                    title="Trash">
                    <i class="ti ti-trash"></i>
                    Trash
                    <span class="badge bg-danger ms-1">{{ $data['total_trash_order'] ?? 0 }}</span>
                </a>
            </div>
            <div class="d-flex align-items-center  premium-form">
                <form action="{{ route('admin.orders') }}" class="d-flex align-items-start gap-2" id="search_form">

                    <input type="hidden" name="status" value="{{ $status ?? null }}">

                    <div>
                        <input type="text" placeholder="Select date range" id="date_range_display"
                            class="form-control search-input  form-control-sm date_range date_range_display"
                            autocomplete="off">
                        <input type="hidden" name="date_range" id="date_range">
                    </div>

                    <select name="source" id="source" class="form-select form-select-sm cool-select">
                        <option value="">Source</option>
                        <option value="direct" {{ $source == 'website' ? 'selected' : '' }}>Direct</option>
                        <option value="page" {{ $source == 'page' ? 'selected' : '' }}>Page</option>
                        <option value="whatsapp" {{ $source == 'whatsapp' ? 'selected' : '' }}>Whatsapp</option>
                        <option value="ab_cart" {{ $source == 'ab_cart' ? 'selected' : '' }}>AB Cart</option>
                        <option value="call" {{ $source == 'call' ? 'selected' : '' }}>Call</option>
                        <option value="office_sell" {{ $source == 'office_sell' ? 'selected' : '' }}>Office Sell
                        </option>
                        <option value="instagram" {{ $source == 'instagram' ? 'selected' : '' }}>Instagram</option>
                        <option value="lp" {{ $source == 'lp' ? 'selected' : '' }}>Landing Page</option>
                    </select>

                    <select name="payment_status" id="payment_status" class="form-select form-select-sm  cool-select">
                        <option value="">Payment</option>
                        <option value="1" {{ $payment_status == '1' ? 'selected' : '' }}>Paid</option>
                        <option value="0" {{ $payment_status == '0' ? 'selected' : '' }}>Unpaid</option>
                    </select>

                    <select name="courier_id" id="courier_id" class="form-select form-select-sm  cool-select">
                        <option value="">Courier</option>
                        @foreach ($couriers as $key => $item)
                        <option value="{{ $key }}" {{ $courier_id == $key ? 'selected' : '' }}>
                            {{ $item }}
                        </option>
                        @endforeach
                    </select>

                    <div>
                        <input type="text" class="form-control form-control-sm search-input  cool-select"
                            placeholder="Search..." id="search" value="{{ $query }}" name="query">
                        <div class="search-msg">

                        </div>
                    </div>

                    {{-- <button type="submit" class="btn btn-gradient-info btn-sm d-flex align-items-center gap-1">
                            <i class="ti ti-search"></i> Search
                        </button> --}}

                    <a href="{{ route('admin.orders') }}"
                        class="btn btn-gradient-dark btn-sm d-flex align-items-center gap-1">
                        <i class="ti ti-refresh"></i>
                    </a>

                </form>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-1 mb-2">
            @php
            $statusCards = [
            [
            'title' => 'Orders',
            'value' => $total_order,
            'status' => 'total',
            'color' => 'secondary',
            'textColor' => 'text-secondary',
            ],
            [
            'title' => 'Pending',
            'value' => $total_pending_order,
            'status' => 'pending',
            'color' => 'warning',
            'textColor' => 'text-warning',
            ],
            [
            'title' => 'Confirmed',
            'value' => $total_confirm_order,
            'status' => 'confirm',
            'color' => 'primary',
            'textColor' => 'text-primary',
            ],
            [
            'title' => 'Processing',
            'value' => $total_processing_order,
            'status' => 'processing',
            'color' => 'info',
            'textColor' => 'text-info',
            ],
            [
            'title' => 'Hold',
            'value' => $total_hold_order,
            'status' => 'hold',
            'color' => 'purple',
            'textColor' => 'text-purple',
            ],
            [
            'title' => 'Printed',
            'value' => $total_printed_order,
            'status' => 'printed',
            'color' => 'secondary',
            'textColor' => 'text-secondary',
            ],
            [
            'title' => 'Packaged',
            'value' => $total_packaging_order,
            'status' => 'packaging',
            'color' => 'orange',
            'textColor' => 'text-orange',
            ],
            [
            'title' => 'Courier Entry',
            'value' => $total_courier_entry_order,
            'status' => 'courier_entry',
            'color' => 'azure',
            'textColor' => 'text-azure',
            ],
            [
            'title' => 'On Delivery',
            'value' => $total_on_delivery_order,
            'status' => 'on_delivery',
            'color' => 'teal',
            'textColor' => 'text-teal',
            ],
            [
            'title' => 'Delivered',
            'value' => $total_delivered_order,
            'status' => 'delivered',
            'color' => 'success',
            'textColor' => 'text-success',
            ],
            [
            'title' => 'Cancelled',
            'value' => $total_cancelled_order,
            'status' => 'cancelled',
            'color' => 'danger',
            'textColor' => 'text-danger',
            ],
            [
            'title' => 'Return',
            'value' => $total_returned_order,
            'status' => 'returned',
            'color' => 'cyan',
            'textColor' => 'text-cyan',
            ],
            ];
            @endphp

        </div>

        <style>
            .order_table thead th {
                position: sticky;
                top: 0;
                /* distance from top */
                background-color: #fff;
                /* header background color */
                z-index: 10;
                /* make sure it stays above rows */
            }
        </style>
        <div class="row">

            <div class="col-12">
                <div class="card" style="border-top: none">

                    @include('backEnd.admin.orders.partials.counter-order', [
                    'statusCards' => $statusCards,
                    'status' => $status,
                    ])


                    <div class="buttons d-flex flex-nowrap gap-2 overflow-auto align-items-start px-3 py-1">

                        {{-- Left Section --}}
                        <div class="d-flex gap-2 flex-nowrap">
                            @can('orders.create')
                            <a href="{{ route('admin.orders.create') }}"
                                class="btn btn-gradient-success btn-sm d-flex align-items-center gap-1">
                                <i class="ti ti-plus"></i> Add Order
                            </a>
                            @endcan

                            @can('orders.bulk.delete')
                            <form action="{{ route('admin.orders.all.status', ['status_delete' => 'delete']) }}"
                                method="post" id="all_delete_form" class="d-flex">
                                @csrf
                                <input type="hidden" id="all_delete_id" name="all_delete_id" class="all_delete_id">
                                <button type="button" id="bulk_delete_btn"
                                    onclick="return confirm('Are you sure to Delete selected orders?')"
                                    class="btn btn-gradient-danger btn-sm d-flex align-items-center gap-1">
                                    <i class="ti ti-trash"></i> Bulk Delete
                                </button>
                            </form>
                            @endcan

                            @can('orders.bulk.print')
                            <form action="{{ route('admin.orders.bulk.print') }}" method="post" id="all_print_form"
                                class="d-flex">
                                @csrf
                                <button type="button" id="bulk_print_btn"
                                    class="btn btn-gradient-info btn-sm d-flex align-items-center gap-1">
                                    <i class="ti ti-printer"></i> Bulk Print
                                </button>
                            </form>
                            @endcan
                            {{-- @dd($packaging_sts) --}}
                            @can('orders.bulk.send_courier')
                            <a href="javascript:void(0);" type="button"
                                class="btn btn-sm btn-gradient-primary d-flex align-items-center gap-1"
                                id="send_to_courier">
                                <i class="ti ti-truck"></i>
                                Send To Courier</a>
                            @endcan
                        </div>

                        {{-- Right Section --}}
                        <div class="d-flex gap-2 flex-nowrap">
                            @can('orders.bulk.status')
                            <form action="{{ route('admin.orders.all.status', ['status_update' => 'update']) }}"
                                method="post" id="all_status_form">
                                @csrf
                                <input type="hidden" id="all_status" name="all_status" class="all_status">
                                <select name="status" id="status" class="form-select form-select-sm cool-select">
                                    <option value="">Select Status</option>
                                    <option value="1">Pending</option>
                                    <option value="2">Confirmed</option>
                                    <option value="3">Processing</option>
                                    <option value="4">Hold</option>
                                    <option value="5">Printed</option>
                                    <option value="6">Packaging</option>
                                    <option value="7">Courier Entry</option>
                                    <option value="8">On Delivery</option>
                                    <option value="9">Delivered</option>
                                    <option value="10">Cancelled</option>
                                    <option value="11">Returned</option>
                                </select>
                            </form>
                            @endcan

                            <form action="{{ route('admin.orders.courier_csv') }}" method="post" id="courier-form">
                                @csrf
                                <input type="hidden" id="oders_id" name="oders_id">
                                <select name="status" id="status" class="form-select form-select-sm cool-select">
                                    <option value="">Select Courier</option>
                                    <option value="1">Stead Fast</option>
                                    <option value="2">Redex</option>
                                </select>
                            </form>

                            {{-- @can('order_bulk_send_courier')
                            <form action="{{ route('admin.orders.bulk.send.to.courier') }}" method="post"
                            id="bulk_send_to_courier_form">
                            @csrf
                            <input type="hidden" id="order_id" name="order_id" class="order_id">
                            <select name="courier_id" id="bulk_courier_id"
                                class="form-select form-select-sm cool-select">
                                <option value="">Send To Courier</option>
                                @foreach ($couriers as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            </form>
                            @endcan --}}

                            <form action="{{ route('admin.orders.bulk.assign') }}" method="post"
                                id="bulk_assign_form">
                                @csrf
                                <input type="hidden" id="order_id" name="order_id" class="order_id">
                                <select name="user_id" id="bulk_user_id"
                                    class="form-select form-select-sm cool-select">
                                    <option value="">Assign User</option>
                                    @foreach (DB::table('admins')->where([['status', 1], ['role', 'employee']])->get() as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive order_table" style="height: 100vh; overflow-y: auto;">

                        <style>
                            /* Selected Row Background Color */
                            .table-active-row {
                                background-color: #e2e8f0 !important;
                                /* আপনার পছন্দমতো কালার কোড দিতে পারেন */
                            }

                            /* SL cell-কে ক্লিকযোগ্য করার জন্য */
                            .sl-cell {
                                cursor: pointer;
                                user-select: none;
                                /* টেক্সট সিলেক্ট হওয়া বন্ধ রাখার জন্য */
                            }
                        </style>
                        <style>
                            /* Force Pagination UL to align right */
                            .custom-pagination .pagination {
                                margin-bottom: 0 !important;
                                justify-content: flex-end !important;
                                gap: 4px;
                            }
                        </style>

                        <!-- Table Header Pagination Bar -->
                        <div class="card-header bg-white border-bottom py-1 px-3">
                            <div class="d-flex align-items-center justify-content-between w-100 gap-3">

                                <!-- Left: Per Page Number Input & Counter Info -->
                                <div class="d-flex align-items-center gap-3 flex-shrink-0">

                                    <!-- Clean & Readable Summary Text -->
                                    <div class="text-secondary small">
                                        Showing <strong class="text-dark">{{ $orders->firstItem() ?? 0 }}</strong>
                                        to <strong class="text-dark">{{ $orders->lastItem() ?? 0 }}</strong>
                                        of <strong class="text-dark">{{ $orders->total() }}</strong> entries
                                    </div>

                                    <!-- Compact Number Input Box Only -->
                                    <div class="d-flex align-items-center border rounded-2 px-1 bg-light shadow-sm">
                                        <input type="number" id="perPageInput"
                                            class="form-control form-control-sm border-0 bg-transparent p-0 text-center fw-semibold text-dark shadow-none"
                                            style="width: 30px; font-size: 12px;"
                                            value="{{ request('per_page', 20) }}" min="1"
                                            onchange="changePerPage(this.value)"
                                            onkeydown="if(event.key === 'Enter') changePerPage(this.value)">
                                    </div>

                                </div>

                                <!-- Right: Pagination Links (Always Showed) -->
                                <div class="custom-pagination d-flex justify-content-end align-items-center flex-grow-1"
                                    style="margin-left: auto;">
                                    @if ($orders->hasPages())
                                    {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
                                    @else
                                    <div class="text-secondary small me-2">
                                        Showing <span class="text-dark">{{ $orders->firstItem() ?? 0 }}</span>
                                        to <span class="text-dark">{{ $orders->lastItem() ?? 0 }}</span>
                                        of <span class="text-dark">{{ $orders->total() }}</span> entries
                                    </div>
                                    {{-- ১ পেজের কম হলেও Bootstrap 5 Pagination এর সাথে হুবহু ম্যাচ করার জন্য --}}
                                    <ul class="pagination mb-0 gap-1">
                                        <li class="page-item disabled" aria-disabled="true"
                                            aria-label="&laquo; Previous">
                                            <span class="page-link" aria-hidden="true">&lsaquo;</span>
                                        </li>

                                        <li class="page-item active" aria-current="page">
                                            <span class="page-link">1</span>
                                        </li>

                                        <li class="page-item disabled" aria-disabled="true"
                                            aria-label="Next &raquo;">
                                            <span class="page-link" aria-hidden="true">&rsaquo;</span>
                                        </li>
                                    </ul>
                                    @endif
                                </div>

                            </div>
                        </div>
                        <table class="datatable table table-vcenter card-table order-table">
                            <thead>
                                <tr>
                                    <th class="w-1">
                                        SL. <input class="form-check-input m-0 align-middle" type="checkbox"
                                            aria-label="Select all invoices" id="master">
                                    </th>
                                    {{-- <th></th> --}}
                                    <th>Invoice & Date</th>
                                    <th>Customer Info</th>
                                    <th>Activity</th>
                                    <th>Products</th>
                                    <th style="width: 10%">Amount</th>
                                    <th>Courier</th>
                                    {{-- <th>Date</th> --}}
                                    <th>payment</th>
                                    <th>Status</th>
                                    <th style="width: 10%">Notes</th>
                                    <th>Assigned</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @dd($orders) --}}
                                @php($i = 1)
                                @if ($orders->count() > 0)
                                @foreach ($orders as $item)
                                <tr id="tr_{{ $item->id }}"
                                    class="{{ $item->is_duplicate ? 'table-danger' : '' }}"
                                    @if ($i % 2==0) style="background-color:#f5f5f5" @endif>
                                    <td class="sl-cell">
                                        {{ $i++ }}.
                                        <input class="form-check-input m-0 align-middle sub_chk"
                                            type="checkbox" data-id="{{ $item->id }}">
                                    </td>
                                    {{-- <td class="w-1">{{ $i++ }}</td> --}}

                                    <td style="width: 10%;">
                                        <div class="d-flex flex-column gap-1">

                                            <!-- 1. Source Badge -->
                                            <div>
                                                <span class="badge {{ $item->source_color }} badge-sm">
                                                    {{ $item->source_name }}
                                                </span>
                                            </div>

                                            <!-- 2. Invoice ID -->
                                            <div>
                                                <span class="fw-bold text-dark font-monospace"
                                                    style="font-size: 0.88rem;">
                                                    #{{ $item->invoice_id }}
                                                </span>
                                            </div>

                                            <!-- 3. Date -->
                                            <div class="text-muted small d-flex align-items-center gap-1"
                                                style="font-size: 0.78rem;">
                                                <i class="ti ti-calendar fs-6 opacity-75"></i>
                                                <span>{{ date('d M, Y', strtotime($item->order_date)) }}</span>
                                            </div>

                                            <!-- 4. Time -->
                                            <div class="text-muted small d-flex align-items-center gap-1"
                                                style="font-size: 0.78rem;">
                                                <i class="ti ti-clock fs-6 opacity-75"></i>
                                                <small>{{ date('h:i A', strtotime($item->created_at)) }}</small>
                                            </div>

                                        </div>
                                    </td>

                                    <td style="width: 15%;">
                                        <div class="customer-info-section d-flex flex-column gap-1">

                                            <!-- Device ID -->
                                            <div class="d-flex align-items-center text-muted small"
                                                title="Device ID" style="font-size: 0.82rem;">
                                                <i
                                                    class="ti ti-device-laptop fs-5 me-2 text-secondary flex-shrink-0"></i>
                                                <span
                                                    class="font-monospace text-dark">{{ $item->device_id ?? '--' }}</span>
                                            </div>

                                            <!-- IP Address -->
                                            <div class="d-flex align-items-center text-muted small"
                                                title="IP Address" style="font-size: 0.82rem;">
                                                <i
                                                    class="ti ti-network fs-5 me-2 text-secondary flex-shrink-0"></i>
                                                <span
                                                    class="font-monospace text-dark">{{ $item->ip_address ?? '--' }}</span>
                                            </div>

                                            <!-- Customer Name -->
                                            <div class="d-flex align-items-center text-dark fw-semibold"
                                                title="Customer Name" style="font-size: 0.88rem;">
                                                <i class="ti ti-user fs-5 me-2 text-primary flex-shrink-0"></i>
                                                <span
                                                    class="text-truncate">{{ $item->customer_name ?? 'N/A' }}</span>
                                            </div>

                                            <!-- Phone Number & Direct Call -->
                                            <div class="d-flex align-items-center gap-1"
                                                title="Customer Phone" style="font-size: 0.85rem;">
                                                <i
                                                    class="ti ti-phone fs-5 me-2 text-success flex-shrink-0"></i>

                                                <span class="order-phone fw-semibold font-monospace text-dark"
                                                    data-phone="{{ $item->customer_phone }}">
                                                    {{ $item->customer_phone ?? 'N/A' }}
                                                </span>

                                                @if (!empty($item->customer_phone))
                                                <a href="tel:{{ $item->customer_phone }}"
                                                    class="btn btn-sm btn-icon btn-soft-success rounded-circle ms-1 d-inline-flex align-items-center justify-content-center"
                                                    style="width: 24px; height: 24px; padding: 0;"
                                                    title="Call Customer">
                                                    <i class="ti ti-phone-call fs-6"></i>
                                                </a>
                                                @endif
                                            </div>

                                            <!-- Address -->
                                            <div class="d-flex align-items-start text-secondary"
                                                title="Customer Address"
                                                style="font-size: 0.82rem; line-height: 1.3;">
                                                <i
                                                    class="ti ti-map-pin fs-5 me-2 text-danger flex-shrink-0 mt-1"></i>
                                                <span
                                                    class="text-wrap text-break">{{ $item->customer_address ?? 'N/A' }}</span>
                                            </div>

                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        $summary = $item->customer_activity['totalSummary'] ?? [];
                                        $successRate = (int) ($summary['successRate'] ?? 0);

                                        // Success Rate অনুযায়ী ডাইনামিক কালার এবং ব্যাজ ক্লাস
                                        $badgeClass = $successRate >= 70 ? 'bg-success-subtle text-success border-success' : ($successRate >= 30 ? 'bg-warning-subtle text-warning border-warning' : 'bg-danger-subtle text-danger border-danger');
                                        ?>

                                        {{-- Circle Chart Trigger Button --}}
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="javascript:void(0)"
                                                class="customer_activity_btn d-inline-block transition-hover"
                                                data-total="{{ $summary['total'] ?? 0 }}"
                                                data-total_delivered="{{ $summary['success'] ?? 0 }}"
                                                data-total_returned="{{ $summary['cancel'] ?? 0 }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#courierDetailsModal_{{ $item->id }}"
                                                title="Click to view courier details">
                                                <canvas class="successChart" data-rate="{{ $successRate }}"
                                                    width="65" height="65"
                                                    data-orders="{{ $summary['total'] ?? 0 }} Order"></canvas>
                                            </a>
                                        </div>

                                        <!-- Courier Details Modal -->
                                        <div class="modal fade" id="courierDetailsModal_{{ $item->id }}"
                                            tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content border-0 shadow-lg">

                                                    {{-- Modal Header --}}
                                                    <div class="modal-header bg-dark text-white py-3">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <i
                                                                class="ti ti-truck-delivery fs-3 text-warning"></i>
                                                            <h5 class="modal-title m-0 fw-semibold">
                                                                Courier Activity: <span
                                                                    class="text-info">{{ $item->customer_name }}</span>
                                                            </h5>
                                                        </div>

                                                        <div class="d-flex align-items-center gap-2">
                                                            {{-- Fraud Checker / Refresh Button --}}
                                                            <a href="{{ route('admin.fraud.checker', $item->id) }}"
                                                                class="btn btn-sm btn-icon {{ $badgeClass }} border d-inline-flex align-items-center justify-content-center p-1"
                                                                title="Re-check Courier Data"
                                                                style="width: 32px; height: 32px; border-radius: 6px;">
                                                                <i class="ti ti-refresh fs-5"></i>
                                                            </a>

                                                            <button type="button"
                                                                class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                    </div>

                                                    {{-- Modal Body --}}
                                                    <div class="modal-body p-4">
                                                        {{-- Summary Overview Cards --}}
                                                        <div class="row g-2 mb-3">
                                                            <div class="col-4">
                                                                <div
                                                                    class="p-2 border rounded bg-light text-center">
                                                                    <span
                                                                        class="text-muted small d-block">Total
                                                                        Orders</span>
                                                                    <strong
                                                                        class="fs-5 text-dark">{{ $summary['total'] ?? 0 }}</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div
                                                                    class="p-2 border border-success-subtle bg-success-subtle rounded text-center">
                                                                    <span
                                                                        class="text-success small d-block">Delivered</span>
                                                                    <strong
                                                                        class="fs-5 text-success">{{ $summary['success'] ?? 0 }}</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div
                                                                    class="p-2 border border-danger-subtle bg-danger-subtle rounded text-center">
                                                                    <span
                                                                        class="text-danger small d-block">Cancelled</span>
                                                                    <strong
                                                                        class="fs-5 text-danger">{{ $summary['cancel'] ?? 0 }}</strong>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- Details Table --}}
                                                        <div class="table-responsive rounded border">
                                                            <table
                                                                class="table table-hover table-striped align-middle m-0">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th class="py-2">Courier Name</th>
                                                                        <th class="py-2 text-center">Total</th>
                                                                        <th
                                                                            class="py-2 text-center text-success">
                                                                            Delivered</th>
                                                                        <th
                                                                            class="py-2 text-center text-danger">
                                                                            Cancelled</th>
                                                                        <th class="py-2 text-end">Success Rate
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if (!empty($item->customer_activity['Summaries']))
                                                                    @foreach ($item->customer_activity['Summaries'] as $courierName => $courier)
                                                                    <?php
                                                                    $cTotal = $courier['total'] ?? 0;
                                                                    $cSuccess = $courier['success'] ?? 0;
                                                                    $cRatio = $cTotal > 0 ? round(($cSuccess / $cTotal) * 100, 1) : 0;
                                                                    ?>
                                                                    <tr>
                                                                        <td
                                                                            class="fw-semibold text-capitalize text-dark">
                                                                            {{ $courierName }}
                                                                        </td>
                                                                        <td
                                                                            class="text-center font-monospace">
                                                                            {{ $cTotal }}
                                                                        </td>
                                                                        <td
                                                                            class="text-center font-monospace text-success fw-bold">
                                                                            {{ $cSuccess }}
                                                                        </td>
                                                                        <td
                                                                            class="text-center font-monospace text-danger">
                                                                            {{ $courier['cancel'] ?? 0 }}
                                                                        </td>
                                                                        <td class="text-end">
                                                                            <span
                                                                                class="badge {{ $cRatio >= 70 ? 'bg-success' : ($cRatio >= 30 ? 'bg-warning' : 'bg-danger') }}">
                                                                                {{ number_format($cRatio, 2) }}%
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                    @else
                                                                    <tr>
                                                                        <td colspan="5"
                                                                            class="text-center py-4 text-muted">
                                                                            <i
                                                                                class="ti ti-alert-circle fs-3 d-block mb-1 opacity-50"></i>
                                                                            No detailed courier information
                                                                            available.
                                                                        </td>
                                                                    </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    {{-- Modal Footer --}}
                                                    <div class="modal-footer bg-light py-2">
                                                        <button type="button"
                                                            class="btn btn-sm btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td width="30%">
                                        <div class="d-flex flex-column gap-2">
                                            @foreach ($item->get_products as $product)
                                            @if ($prod = $product->get_product)
                                            <div
                                                class="d-flex align-items-start gap-2 p-1 rounded hover-bg-light">

                                                <!-- Product Image / Placeholder -->
                                                <div class="flex-shrink-0 position-relative">
                                                    @if ($thumbUrl = $prod->get_thumb->file_url ?? null)
                                                    <img src="{{ asset($thumbUrl) }}"
                                                        alt="{{ $prod->name }}"
                                                        class="image-modal-trigger rounded border object-fit-cover shadow-xs cursor-pointer"
                                                        style="width: 40px; height: 40px;"
                                                        data-src="{{ asset($thumbUrl) }}"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#imageModal"
                                                        title="Click to view">
                                                    @else
                                                    <div class="bg-light border rounded d-flex align-items-center justify-content-center text-muted"
                                                        style="width: 40px; height: 40px;"
                                                        title="No image available">
                                                        <i
                                                            class="ti ti-photo-off fs-5 opacity-50"></i>
                                                    </div>
                                                    @endif
                                                </div>

                                                <!-- Product Details -->
                                                <div class="flex-grow-1 min-w-0">

                                                    <!-- Title & Quantity -->
                                                    <div
                                                        class="d-flex align-items-center gap-1 flex-wrap">
                                                        <span
                                                            class="badge bg-danger text-white fw-bold px-1 py-0"
                                                            style="font-size: 0.75rem;">
                                                            {{ $product->qty }}x
                                                        </span>

                                                        <a href="{{ route('single.product', $prod->slug) }}"
                                                            target="_blank"
                                                            class="text-dark fw-medium text-truncate text-decoration-none lh-sm"
                                                            style="max-width: 300px; font-size: 0.85rem;"
                                                            title="{{ $prod->name }}">
                                                            {{ $prod->name }}
                                                        </a>

                                                        @if ($product->discount > 0)
                                                        <span
                                                            class="badge bg-warning text-white fw-bold ms-auto"
                                                            style="font-size: 0.7rem;">
                                                            -{{ $product->discount }}
                                                        </span>
                                                        @endif
                                                    </div>

                                                    <!-- SKU & Variants Row -->
                                                    <div class="d-flex align-items-start flex-column gap-1 flex-wrap mt-1"
                                                        style="font-size: 0.78rem;">
                                                        @if ($prod->sku)
                                                        <span class="text-muted font-monospace">
                                                            SKU: <strong
                                                                class="text-secondary">{{ $prod->sku }}</strong>
                                                        </span>
                                                        @endif

                                                        <!-- Dynamic Attributes / Variants -->
                                                        @if (!empty($product->formatted_attributes_list) && $product->formatted_attributes_list->count() > 0)
                                                        <div class="d-inline-flex gap-1 flex-wrap">
                                                            @foreach ($product->formatted_attributes_list as $v_item)
                                                            <span
                                                                class="badge bg-blue text-white font-weight-normal px-1 py-0"
                                                                style="font-size: 0.72rem;">
                                                                {{ $v_item->attribute->name ?? '' }}:
                                                                {{ $v_item->name }}
                                                            </span>
                                                            @endforeach
                                                        </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </td>

                                    {{-- <td>{{ $web_settings->currency_sign }} {{ $item->total }}</td> --}}
                                    <td>
                                        <div class="d-flex flex-column gap-1 p-2 rounded bg-light-subtle border border-dashed"
                                            style="min-width: 150px; font-size: 0.80rem;">

                                            <!-- Sub Total -->
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted">Sub:</span>
                                                <span
                                                    class="fw-semibold">{{ 0 + number_format($item->sub_total, 2, '.', '') }}</span>
                                            </div>

                                            <!-- Item Discount -->
                                            @if ($item->discount > 0)
                                            <div
                                                class="d-flex justify-content-between align-items-center text-danger">
                                                <span>Dis:</span>
                                                <span
                                                    class="fw-semibold">-{{ 0 + number_format($item->discount, 2, '.', '') }}</span>
                                            </div>
                                            @endif

                                            <!-- Coupon Discount -->
                                            @if ($item->coupon_discount > 0)
                                            <div
                                                class="d-flex justify-content-between align-items-center text-danger">
                                                <span>C.Dis:</span>
                                                <span
                                                    class="fw-semibold">-{{ 0 + number_format($item->coupon_discount, 2, '.', '') }}</span>
                                            </div>
                                            @endif

                                            <!-- Delivery Charge -->
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted">D. Charge:</span>
                                                <span
                                                    class="fw-semibold">{{ 0 + number_format($item->shipping_cost, 2, '.', '') }}</span>
                                            </div>



                                            <hr class="my-1 border-secondary-subtle">

                                            <!-- Total -->
                                            <div
                                                class="d-flex justify-content-between align-items-center fw-bold">
                                                <span class="text-dark">Total:</span>
                                                <span
                                                    class="text-dark">{{ 0 + number_format($item->total, 2, '.', '') }}</span>
                                            </div>

                                            <!-- Paid Amount -->
                                            <div
                                                class="d-flex justify-content-between align-items-center text-success">
                                                <span>Paid:</span>
                                                <span
                                                    class="fw-bold">{{ 0 + number_format($item->paid, 2, '.', '') }}</span>
                                            </div>

                                            <!-- Due Amount -->
                                            <div
                                                class="d-flex justify-content-between align-items-center text-danger">
                                                <span>Due:</span>
                                                <span
                                                    class="fw-bold">{{ 0 + number_format($item->due, 2, '.', '') }}</span>
                                            </div>

                                        </div>
                                    </td>
                                    <td>
                                        @if ($item->get_courier)
                                        @if ($item->courier_id == 1 || $item->courier_id == 2 || $item->courier_id == 4)
                                        @if ($item->consignment_id)
                                        <small class="badge bg-info mb-1">
                                            {{ $item->consignment_id }}
                                        </small>
                                        @endif

                                        @if ($item->courier_id == 1)
                                        <span class="d-flex align-items-center  gap-1">
                                            <small>{{ $item->get_courier->courier_name }}</small>
                                            @if ($item->tracking_id)
                                            <a href="https://steadfast.com.bd/t/{{ $item->tracking_id }}"
                                                target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    width="20" height="20"
                                                    style="color: red;height: 15px;width: 15px;margin-bottom: 2px;"
                                                    viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin">
                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                        fill="none" />
                                                    <path
                                                        d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                                    <path
                                                        d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" />
                                                </svg>
                                            </a>
                                            @endif
                                        </span>
                                        {{-- <br> --}}
                                        @if ($item->courier_status)
                                        <small class="text-info">
                                            {{ $item->courier_status }}
                                        </small>
                                        @endif
                                        @elseif ($item->courier_id == 4)
                                        {{-- @dd(4) --}}
                                        <span class="d-flex align-items-center  gap-1">
                                            <small>{{ $item->get_courier->courier_name }}</small>
                                            @if ($item->consignment_id)
                                            <a href="https://merchant.carrybee.com/order-track/{{ $item->consignment_id }}"
                                                target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    width="20" height="20"
                                                    style="color: red;height: 15px;width: 15px;margin-bottom: 2px;"
                                                    viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin">
                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                        fill="none" />
                                                    <path
                                                        d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                                    <path
                                                        d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" />
                                                </svg>
                                            </a>
                                            @endif
                                        </span>
                                        <small>
                                            <strong>C:</strong>
                                            <?php
                                            $city = DB::table('carry_bee_cities')->where('parent_id', $item->courier_city_id)->first()->name;
                                            ?>
                                            {{ $city }}
                                        </small>
                                        <br>
                                        <small>
                                            <strong>Z:</strong>
                                            <?php
                                            $zone = DB::table('carry_bee_zones')->where('id', $item->courier_zone_id)->first()->name;
                                            ?>
                                            {{ $zone }}
                                        </small>
                                        <br>
                                        @if ($item->courier_status)
                                        <small class="text-info">
                                            {{ $item->courier_status }}
                                        </small>
                                        @endif
                                        @else
                                        <span class="d-flex align-items-center  gap-1">
                                            <small>{{ $item->get_courier->courier_name }}</small>
                                            @if ($item->consignment_id)
                                            <a href="https://merchant.pathao.com/tracking?consignment_id={{ $item->consignment_id }}&phone={{ $item->customer_phone }}"
                                                target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    width="20" height="20"
                                                    style="color: red;height: 15px;width: 15px;margin-bottom: 2px;"
                                                    viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin">
                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                        fill="none" />
                                                    <path
                                                        d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                                    <path
                                                        d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" />
                                                </svg>
                                            </a>
                                            @endif
                                        </span>
                                        <small>
                                            <strong>C:</strong>
                                            <?php
                                            $city = DB::table('pathao_cities')->where('parent_id', $item->courier_city_id)->first()->name;
                                            ?>
                                            {{ $city }}
                                        </small>
                                        <br>
                                        <small>
                                            <strong>Z:</strong>
                                            <?php
                                            $zone = DB::table('pathao_zones')->where('parent_id', $item->courier_zone_id)->first()->name;
                                            ?>
                                            {{ $zone }}
                                        </small>
                                        <br>
                                        @if ($item->courier_status)
                                        <small class="text-info">
                                            {{ $item->courier_status }}
                                        </small>
                                        @endif
                                        @endif
                                        @else
                                        @if ($item->tracking_id)
                                        <small class="badge bg-info mb-1">
                                            {{ $item->tracking_id }}
                                        </small>
                                        @endif

                                        {{-- @if ($item->tracking_id) --}}
                                        <span class="d-flex align-items-center  gap-1">
                                            <small>{{ $item->get_courier->courier_name }}</small>
                                            @if ($item->tracking_id)
                                            <a href="https://redx.com.bd/track-parcel/?trackingId={{ $item->tracking_id }}"
                                                target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    width="20"
                                                    style="color: red;height: 15px;width: 15px;margin-bottom: 2px;"
                                                    height="20" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin">
                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                        fill="none" />
                                                    <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                                    <path
                                                        d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" />
                                                </svg>
                                            </a>
                                            @endif
                                        </span>
                                        <?php
                                        $city = DB::table('redx_areas')->where('parent_id', $item->courier_zone_id)->first();
                                        ?>
                                        <small>
                                            <strong>C:</strong>

                                            {{ $city->district }}
                                        </small>
                                        <br>
                                        <small>
                                            <strong>Z:</strong>
                                            {{ $city->name }}
                                        </small>
                                        @endif
                                        @else
                                        <span>---</span> <br>
                                        @endif


                                    </td>

                                    <td>
                                        <span
                                            class="badge {{ $item->payment_status == 1 ? 'bg-success' : '' }} {{ $item->payment_status == 0 ? 'bg-danger' : '' }} {{ $item->payment_status == 0 ? 'bg-primary' : '' }} dropdown dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                            @if ($item->payment_status == 1)
                                            Paid
                                            @endif
                                            @if ($item->payment_status == 0)
                                            Unpaid
                                            @endif
                                            @if ($item->payment_status == 2)
                                            Partial
                                            @endif
                                        </span>
                                        @can('orders.payment_status')
                                        <span class="dropdown-menu">
                                            <a class="dropdown-item {{ $item->payment_status == 1 ? 'd-none' : '' }}"
                                                href="{{ route('admin.orders.payment', [$item->id, 1]) }}">Paid</a>
                                            <a class="dropdown-item {{ $item->payment_status == 0 ? 'd-none' : '' }}"
                                                href="{{ route('admin.orders.payment', [$item->id, 0]) }}">Unpaid</a>
                                            <a class="dropdown-item {{ $item->payment_status == 2 ? 'd-none' : '' }}"
                                                href="{{ route('admin.orders.payment', [$item->id, 2]) }}">Partial</a>
                                        </span>
                                        @endcan
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $item->status == 1 ? 'bg-warning' : '' }} {{ $item->status == 2 ? 'bg-success' : '' }}{{ $item->status == 3 ? 'bg-info' : '' }}{{ $item->status == 4 ? 'bg-secondary' : '' }}{{ $item->status == 5 ? 'bg-azure' : '' }}{{ $item->status == 6 ? 'bg-primary' : '' }}{{ $item->status == 7 ? 'bg-info' : '' }}{{ $item->status == 8 ? 'bg-teal' : '' }}{{ $item->status == 9 ? 'bg-teal' : '' }}{{ $item->status == 10 ? 'bg-lime' : '' }} status_btn  btn-sm dropdown dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                            @if ($item->status == 1)
                                            Pending
                                            @endif
                                            @if ($item->status == 2)
                                            Confirm
                                            @endif
                                            @if ($item->status == 3)
                                            Processing
                                            @endif
                                            @if ($item->status == 4)
                                            Hold
                                            @endif
                                            @if ($item->status == 5)
                                            Printed
                                            @endif
                                            @if ($item->status == 6)
                                            Packaged
                                            @endif
                                            @if ($item->status == 7)
                                            Courier Entry
                                            @endif
                                            @if ($item->status == 8)
                                            On Delivery
                                            @endif
                                            @if ($item->status == 9)
                                            Delivered
                                            @endif
                                            @if ($item->status == 10)
                                            Cancelled
                                            @endif
                                            @if ($item->status == 11)
                                            Returned
                                            @endif
                                        </span>
                                        @can('orders.status')
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item {{ $item->status == 1 ? 'd-none' : '' }}"
                                                href="{{ route('admin.orders.status', [$item->id, 1]) }}">Pending
                                            </a>
                                            <a class="dropdown-item {{ $item->status == 2 ? 'd-none' : '' }}"
                                                href="{{ route('admin.orders.status', [$item->id, 2]) }}">Confirm
                                            </a>
                                            <a class="dropdown-item {{ $item->status == 3 ? 'd-none' : '' }}"
                                                href="{{ route('admin.orders.status', [$item->id, 3]) }}">Processing
                                            </a>
                                            <a class="dropdown-item {{ $item->status == 4 ? 'd-none' : '' }}"
                                                href="{{ route('admin.orders.status', [$item->id, 4]) }}">Hold
                                            </a>
                                            <a class="dropdown-item {{ $item->status == 5 ? 'd-none' : '' }}"
                                                href="{{ route('admin.orders.status', [$item->id, 5]) }}">Printed
                                            </a>
                                            <a class="dropdown-item {{ $item->status == 6 ? 'd-none' : '' }}"
                                                href="{{ route('admin.orders.status', [$item->id, 6]) }}">Packaging
                                            </a>
                                            <a class="dropdown-item {{ $item->status == 7 ? 'd-none' : '' }}"
                                                href="{{ route('admin.orders.status', [$item->id, 7]) }}">
                                                Courier Entry
                                            </a>
                                            <a class="dropdown-item {{ $item->status == 8 ? 'd-none' : '' }}"
                                                href="{{ route('admin.orders.status', [$item->id, 8]) }}">On
                                                Delivery
                                            </a>


                                            <a class="dropdown-item {{ $item->status == 9 ? 'd-none' : '' }}"
                                                href="{{ route('admin.orders.status', [$item->id, 9]) }}">Delivered
                                            </a>
                                            <a class="dropdown-item {{ $item->status == 10 ? 'd-none' : '' }}"
                                                href="{{ route('admin.orders.status', [$item->id, 10]) }}">Cancelled
                                            </a>
                                            <a class="dropdown-item {{ $item->status == 11 ? 'd-none' : '' }}"
                                                href="{{ route('admin.orders.status', [$item->id, 11]) }}">Returned
                                            </a>
                                        </div>
                                        @endcan
                                    </td>
                                    <td style="min-width: 180px;">
                                        <?php
                                        $lastStaffNote = $item->get_staff_notes->last();
                                        $lastCustomerNote = $item->get_customer_notes->last();
                                        ?>

                                        <div class="notes-container d-flex flex-column gap-1">

                                            {{-- 1. Staff Note Section --}}
                                            <div class="border rounded p-1 bg-white shadow-xs">
                                                <div
                                                    class="d-flex align-items-center justify-content-between mb-1 pb-1 border-bottom">
                                                    <span
                                                        class="text-info fw-semibold font-monospace px-1 py-0"
                                                        style="font-size: 10px;">
                                                        S. Note
                                                    </span>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <a href="javascript:void(0)"
                                                            class="text-primary btn-note-action"
                                                            data-action="add" data-type="staff"
                                                            data-id="{{ $item->id }}"
                                                            title="Add Staff Note">
                                                            <i class="ti ti-plus fs-5"></i>
                                                        </a>
                                                        @if ($lastStaffNote)
                                                        <a href="javascript:void(0)"
                                                            class="text-warning btn-note-action"
                                                            data-action="edit" data-type="staff"
                                                            data-id="{{ $item->id }}"
                                                            data-note-id="{{ $lastStaffNote->id }}"
                                                            title="Edit Staff Note">
                                                            <i class="ti ti-pencil fs-5"></i>
                                                        </a>
                                                        @endif
                                                        <a href="javascript:void(0)"
                                                            class="text-info btn-note-history"
                                                            data-type="staff" data-id="{{ $item->id }}"
                                                            title="View History">
                                                            <i class="ti ti-history fs-5"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="text-secondary text-break small lh-sm"
                                                    style="font-size: 0.78rem;">
                                                    {{ $lastStaffNote->note ?? 'No staff notes.' }}
                                                </div>
                                            </div>

                                            {{-- 2. Customer Note Section --}}
                                            <div class="border rounded p-1 bg-white shadow-xs">
                                                <div
                                                    class="d-flex align-items-center justify-content-between mb-1 pb-1 border-bottom">
                                                    <span
                                                        class="text-info fw-semibold font-monospace px-1 py-0"
                                                        style="font-size: 10px;">
                                                        C. Note
                                                    </span>
                                                    <div class="d-flex align-items-center gap-1">
                                                        @if ($lastCustomerNote)
                                                        <a href="javascript:void(0)"
                                                            class="text-warning btn-note-action"
                                                            data-action="edit" data-type="customer"
                                                            data-id="{{ $item->id }}"
                                                            data-note-id="{{ $lastCustomerNote->id }}"
                                                            title="Edit Customer Note">
                                                            <i class="ti ti-pencil fs-5"></i>
                                                        </a>
                                                        @endif
                                                        <a href="javascript:void(0)"
                                                            class="text-info btn-note-history"
                                                            data-type="customer"
                                                            data-id="{{ $item->id }}"
                                                            title="View History">
                                                            <i class="ti ti-history fs-5"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="text-secondary text-break small lh-sm"
                                                    style="font-size: 0.78rem;">
                                                    {{ $lastCustomerNote->note ?? 'No customer notes.' }}
                                                </div>
                                            </div>

                                        </div>
                                    </td>

                                    <td>
                                        {{ $item->get_assigned ? $item->get_assigned->get_employee->name : '' }}
                                    </td>

                                    <td class="w-1">
                                        @can('orders.print')
                                        <a href="javascript:void(0)"
                                            class="btn-gradient-primary  padding-2-6  border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1 print"
                                            data-id="{{ $item->id }}">
                                            <i class="ti ti-printer"></i>
                                            Print
                                        </a>
                                        @endcan
                                        @can('orders.edit')
                                        <a href="{{ route('admin.orders.edit', $item->id) }}"
                                            class="btn-gradient-info  padding-2-6  border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1">
                                            <i class="ti ti-edit"></i> Edit
                                        </a>
                                        @endcan

                                        @can('orders.delete')
                                        <a href="javascript:void(0)" data-id="{{ $item->id }}"
                                            class="btn-gradient-success  padding-2-6  border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1 order_activities">
                                            <i class="ti ti-history"></i> Activies
                                        </a>
                                        @endcan

                                        @can('orders.delete')
                                        <a href="{{ route('admin.orders.delete', $item->id) }}"
                                            class="btn-gradient-danger padding-2-6  border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1"
                                            onclick="return confirm('Are you sure to move this to trash?')">
                                            <i class="ti ti-trash"></i>
                                            Trash</a>
                                        @endcan

                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="12" class="text-center text-danger font-weight-bold">No
                                        Data Found!
                                    </td>
                                </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                    <div class="col-12">
                        <!-- Bottom Pagination Links -->
                        <div
                            class="card-footer d-flex flex-wrap justify-content-between align-items-center gap-2 py-2">
                            <div class="text-muted small">
                                Showing <strong>{{ $orders->firstItem() ?? 0 }}</strong> to
                                <strong>{{ $orders->lastItem() ?? 0 }}</strong> of
                                <strong>{{ $orders->total() }}</strong> entries
                            </div>
                            <!-- Right: Pagination Links (Always Showed) -->
                            <div class="custom-pagination d-flex justify-content-end align-items-center flex-grow-1"
                                style="margin-left: auto;">
                                @if ($orders->hasPages())
                                {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
                                @else
                                <div class="text-secondary small me-2">
                                    Showing <span class="text-dark">{{ $orders->firstItem() ?? 0 }}</span>
                                    to <span class="text-dark">{{ $orders->lastItem() ?? 0 }}</span>
                                    of <span class="text-dark">{{ $orders->total() }}</span> entries
                                </div>
                                {{-- ১ পেজের কম হলেও Bootstrap 5 Pagination এর সাথে হুবহু ম্যাচ করার জন্য --}}
                                <ul class="pagination mb-0 gap-1">
                                    <li class="page-item disabled" aria-disabled="true"
                                        aria-label="&laquo; Previous">
                                        <span class="page-link" aria-hidden="true">&lsaquo;</span>
                                    </li>

                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link">1</span>
                                    </li>

                                    <li class="page-item disabled" aria-disabled="true"
                                        aria-label="Next &raquo;">
                                        <span class="page-link" aria-hidden="true">&rsaquo;</span>
                                    </li>
                                </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal for Send to Courier -->
<div class="modal fade" id="sendToCourierModal" tabindex="-1" aria-labelledby="sendToCourierModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>

{{-- bulk send to courier modal --}}
<div class="modal fade" id="bulkSendToCourierModal" tabindex="-1" aria-labelledby="bulkSendToCourierModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>

<!-- Modal for Staff Note -->
<div class="modal fade" id="staffNoteModal" tabindex="-1" aria-labelledby="staffNoteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>

<!-- Modal for Customer Note -->
<div class="modal fade" id="customerNoteModal" tabindex="-1" aria-labelledby="customerNoteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>

<!-- Modal for all notes -->
<div class="modal fade" id="allNotesModal" tabindex="-1" aria-labelledby="allNotesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>

<!-- Modal for order activities -->
<div class="modal fade" id="orderActivitiesModal" tabindex="-1" aria-labelledby="orderActivitiesModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>

<!-- Modal for view more -->
<div class="modal fade" id="viewMoreModal" tabindex="-1" aria-labelledby="viewMoreModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

        </div>
    </div>
</div>

{{-- Image Preview Modal --}}
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title d-flex align-items-center gap-2" id="imageModalLabel">
                    <i class="ti ti-photo text-primary fs-4"></i>
                    <span>Image Preview</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body text-center">
                <div class="image-wrapper bg-light rounded p-2 mb-3">
                    {{-- এই id="modalPreviewImage" টি গুরুত্বপূর্ণ --}}
                    <img id="modalPreviewImage" src="" alt="Preview" class="img-fluid rounded"
                        style="max-height: 70vh; object-fit: contain;">
                </div>
            </div>

            {{-- <div class="modal-footer border-0 pt-0 d-flex justify-content-between">
                <a id="downloadImageBtn" href="#" download class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                    <i class="ti ti-download fs-5"></i>
                    <span>Download</span>
                </a>
                <button type="button" class="btn btn-secondary btn-sm d-flex align-items-center gap-1" data-bs-dismiss="modal">
                    <i class="ti ti-x fs-5"></i>
                    <span>Close</span>
                </button>
            </div> --}}
        </div>
    </div>
</div>


{{-- 1. Add / Edit Note Modal --}}
<div class="modal fade" id="noteActionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h5 class="modal-title fs-6" id="noteModalTitle">Manage Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="noteActionForm">
                @csrf
                <div class="modal-body py-3">
                    <input type="hidden" name="order_id" id="modal_order_id">
                    <input type="hidden" name="note_id" id="modal_note_id">
                    <input type="hidden" name="type" id="modal_note_type">
                    <input type="hidden" name="action" id="modal_action_type">

                    <div class="mb-2">
                        <label class="form-label mb-1 fw-bold fs-7" id="noteTypeLabel">Note</label>
                        <textarea name="note" id="modal_note_text" class="form-control" rows="4"
                            placeholder="Type your note here..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary" id="saveNoteBtn">Save Note</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 2. View Note History Modal --}}
<div class="modal fade" id="noteHistoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2 bg-light">
                <h5 class="modal-title fs-6" id="historyModalTitle">Note History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3" style="max-height: 450px; overflow-y: auto;">
                <div id="historyTimeline" class="timeline">
                    {{-- AJAX দিয়ে ডায়নামিক টাইমলাইন আসবে --}}
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('js')
<script src="{{ asset('backEnd/assets/plugin/datepicker/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backEnd/assets/plugin/datepicker/daterangepicker.js') }}"></script>
<script>
    //view more
    $(document).on('click', '.view-more', function() {
        var orderId = $(this).data('id');
        $.ajax({
            url: '{{ route('
            admin.orders.view.more ') }}',
            type: 'POST',
            data: {
                _token: @json(csrf_token()),
                order_id: orderId
            },
            success: function(data) {
                $('#viewMoreModal .modal-content').html(data);
                $('#viewMoreModal').modal('show');
                $('#orderActivitiesModal').modal('hide');
            }
        });

    });

    //order activities
    $(document).on('click', '.order_activities', function() {
        var orderId = $(this).data('id');
        $.ajax({
            url: '{{ route('
            admin.orders.activies ') }}',
            type: 'POST',
            data: {
                _token: @json(csrf_token()),
                order_id: orderId
            },
            success: function(data) {
                $('#orderActivitiesModal .modal-content').html(data);
                $('#orderActivitiesModal').modal('show');
            }
        });
    });


    //bulk_assign_form
    $(document).on('change', '#bulk_assign_form', function() {
        var allVals = [];
        $(".sub_chk:checked").each(function() {
            allVals.push($(this).attr('data-id'));
        });
        if (allVals.length <= 0) {
            alert("Please select row.");
        } else {
            $('.order_id').val(allVals);
            $('#bulk_assign_form').submit();
        }
    });

    $(document).on('change', '.city', function() {
        var that = $(this);
        var city_id = $(this).find(':selected').val();
        // console.log(city_id);

        $.ajax({
            url: '{{ route('
            admin.orders.courier.zone ') }}',
            type: 'POST',
            data: {
                _token: @json(csrf_token()),
                city_id: city_id
            },
            success: function(data) {
                that.parents('.card').find('.zone').html(data);
                that.parents('.card').find('.zone').prop('disabled', false);
            }
        });
    });
</script>

<script>
    $(document).on('change', '#bulk_courier_id', function() {

        var allVals = [];
        $(".sub_chk:checked").each(function() {
            allVals.push($(this).attr('data-id'));
        });
        var courierId = $(this).val();
        var order_id = $('#order_id').val(allVals);
        var all_ids = order_id.val();
        // alert(order_id.val());
        if (allVals.length <= 0) {
            alert("Please select row.");
        } else {
            $.ajax({
                url: '{{ Auth::guard('
                admin ')->check() ? route('
                admin.orders.bulk.send.to.courier ') : (Auth::guard('
                manager ')->check() ? route('
                manager.orders.send.to.courier ') : '
                ') }}',
                type: 'POST',
                data: {
                    _token: @json(csrf_token()),
                    order_id: all_ids,
                    courier_id: courierId
                },
                success: function(data) {
                    if (data.status == 200) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Order sent to courier successfully!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        $('.table-responsive').load(location.href + ' .table-responsive');

                    } else {
                        $('#bulkSendToCourierModal .modal-content').html(data);
                        $('.zone').prop('disabled', true);
                        $('#bulkSendToCourierModal').modal('show');
                    }
                }

            });

            // $('#bulk_send_to_courier_form').submit();
        }
    });
</script>
<script>
    $('.print').on('click', function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '{{ route('
            admin.orders.print ') }}',
            type: 'POST',
            data: {
                _token: @json(csrf_token()),
                id: $(this).data('id')
            },
            success: function(data) {
                newWin = window.open("");
                newWin.document.write(data);
                newWin.document.close();
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {

        $('#master').on('click', function(e) {
            // alert(4);
            if ($(this).is(':checked', true)) {
                // alert(4)
                $(".sub_chk").prop('checked', true);
            } else {
                // alert(5)
                $(".sub_chk").prop('checked', false);
            }
        });


        $('#status').on('change', function(e) {
            var allVals = [];
            $(".sub_chk:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });
            // alert(allVals)
            if (allVals.length <= 0) {
                alert("Please select row.");
            } else {
                $('.all_status').val(allVals);
                $('#all_status_form').submit();
            }
        });
        $('#bulk_delete_btn').on('click', function(e) {
            var allVals = [];
            $(".sub_chk:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });
            if (allVals.length <= 0) {
                alert("Please select row.");
            } else {
                $('.all_delete_id').val(allVals);
                $('#all_delete_form').submit();
            }
        });

        $('#bulk_print_btn').on('click', function(e) {

            var allVals = [];
            $(".sub_chk:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });

            if (allVals.length <= 0) {
                alert("Please select row.");
            } else {

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{ route('
                    admin.orders.bulk.print ') }}',
                    type: 'POST',
                    data: {
                        _token: @json(csrf_token()),
                        all_inv_id: allVals
                    },
                    success: function(data) {
                        newWin = window.open("");
                        newWin.document.write(data);
                        newWin.document.close();
                    }
                });
            }
        });

        //courier export
        $('.courier_export').on('change', function(e) {
            // alert($(this).val());
            var allVals = [];
            $(".sub_chk:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });

            if (allVals.length <= 0) {
                alert("Please select row.");
            } else {
                $('#oders_id').val(allVals);
                $('#courier-form').submit();
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const counters = document.querySelectorAll('.count-up');
        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const increment = target / 200;
                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    requestAnimationFrame(updateCount);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("search_form");
        const searchInput = document.getElementById("search");

        form.querySelectorAll('select').forEach(select => {
            select.addEventListener('change', function() {
                form.submit();
            });
        });

        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                form.submit();
            }
        });
    });
</script>
<script>
    //send to courier
    $(document).on('click', '#send_to_courier', function(e) {
        e.preventDefault();

        var allVals = [];
        $(".sub_chk:checked").each(function() {
            allVals.push($(this).attr('data-id'));
        });

        if (allVals.length <= 0) {
            alert("Please select at least one row.");
        } else {
            if (confirm("Are you sure you want to send the selected orders to the courier?")) {
                var ids = allVals.join(',');
                var url = "{{ route('admin.orders.bulk-ids.send.to.courier') }}?ids=" + ids;
                window.location.href = url;
            }
        }


    });
</script>

<script>
    $(document).ready(function() {

        let hasRange = "{{ $start && $end ? 'yes' : '' }}";

        let start = null;
        let end = null;

        if (hasRange) {
            start = moment("{{ $start }}");
            end = moment("{{ $end }}");
        }

        function updateDisplay(start, end) {
            $('.date_range_display').val(
                start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY')
            );

            $('#date_range').val(JSON.stringify({
                start: start.format('YYYY-MM-DD'),
                end: end.format('YYYY-MM-DD')
            }));
        }

        $('.date_range_display').daterangepicker({
            startDate: start ?? moment(),
            endDate: end ?? moment(),
            autoUpdateInput: false,
            opens: 'left',
            locale: {
                format: 'MMM D, YYYY'
            },
            alwaysShowCalendars: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [
                    moment().subtract(1, 'month').startOf('month'),
                    moment().subtract(1, 'month').endOf('month')
                ]
            }
        });

        // ✅ Apply → set + submit
        $('.date_range_display').on('apply.daterangepicker', function(ev, picker) {
            updateDisplay(picker.startDate, picker.endDate);
            $('#search_form').submit();
        });

        // ✅ Cancel → clear + placeholder show
        $('.date_range_display').on('cancel.daterangepicker', function() {
            $(this).val('');
            $('#date_range').val('');
        });

        // Click → open picker
        $('.date_range_display').on('click', function() {
            $(this).data('daterangepicker').show();
        });

        // ✅ Only set value if start & end exist
        if (start && end) {
            updateDisplay(start, end);
        }
        // else → placeholder থাকবে
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.successChart').forEach(canvas => {
                const ctx = canvas.getContext('2d');
                const rate = parseInt(canvas.dataset.rate);

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [rate, 100 - rate],
                            backgroundColor: [
                                rate < 30 ? '#e74c3c' :
                                    rate < 70 ? '#f1c40f' :
                                        '#2ecc71',
                                '#eaeaea'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        cutout: '80%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false
                            }
                        }
                    },
                    plugins: [{
                        id: 'centerText',
                        beforeDraw(chart) {
                            const {
                                ctx,
                                chartArea: {
                                    width,
                                    height
                                }
                            } = chart;
                            ctx.save();
                            ctx.font = 'bold 12px Arial';
                            ctx.fillStyle = '#333';
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';
                            ctx.fillText(rate + '%', width / 2, height / 2);
                            ctx.restore();
                        }
                    }]
                });

            });
        });
    </script> --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.successChart').forEach(canvas => {
            const ctx = canvas.getContext('2d');
            const rate = parseInt(canvas.dataset.rate); // e.g. 100
            const orders = canvas.dataset.orders ?? '2 Order'; // optional

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [rate, 100 - rate],
                        backgroundColor: [
                            rate < 30 ? '#e74c3c' :
                            rate < 70 ? '#f1c40f' :
                            '#2ecc71',
                            '#eaeaea'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    cutout: '80%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: false
                        }
                    }
                },
                plugins: [{
                    id: 'centerText',
                    beforeDraw(chart) {
                        const {
                            ctx,
                            chartArea
                        } = chart;
                        const centerX = (chartArea.left + chartArea.right) / 2;
                        const centerY = (chartArea.top + chartArea.bottom) / 2;

                        ctx.save();

                        // 🔥 Main Percentage
                        ctx.font = 'bold 18px Arial';
                        ctx.fillStyle = '#333';
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        ctx.fillText(rate + '%', centerX, centerY - 6);

                        // 🔹 Sub text (Order)
                        ctx.font = 'normal 11px Arial';
                        ctx.fillStyle = '#777';
                        ctx.fillText(orders, centerX, centerY + 12);

                        ctx.restore();
                    }
                }]
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalImage = document.getElementById('modalPreviewImage');
        const downloadBtn = document.getElementById('downloadImageBtn');

        // image-modal-trigger ক্লাসে ক্লিক করলে মোডালে ছবি সেট হবে
        document.querySelectorAll('.image-modal-trigger').forEach(image => {
            image.addEventListener('click', function() {
                const imageSrc = this.getAttribute('data-src');

                if (modalImage && imageSrc) {
                    modalImage.src = imageSrc;
                }
                if (downloadBtn && imageSrc) {
                    downloadBtn.href = imageSrc;
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {

        // ১. রেডিও বাটন সিলেক্ট করলে কাস্টম টেক্সট ইনপুট হাইড/শো করার লজিক
        $(document).on('change', '.staff-preset-radio', function() {
            let val = $(this).val();
            if (val === 'other') {
                $('#customNoteInputGroup').removeClass('d-none');
                $('#modal_note_text').val('').attr('required', true).focus();
            } else {
                $('#customNoteInputGroup').addClass('d-none');
                $('#modal_note_text').val(val).removeAttr('required');
            }
        });

        // ২. Modal Open Handler (Staff vs Customer toggle)
        $(document).on('click', '.btn-note-action', function() {
            let action = $(this).data('action');
            let type = $(this).data('type'); // 'staff' or 'customer'
            let orderId = $(this).data('id');
            let noteId = $(this).data('note-id') || '';

            $('#modal_order_id').val(orderId);
            $('#modal_note_id').val(noteId);
            $('#modal_note_type').val(type);
            $('#modal_action_type').val(action);

            // Reset Inputs
            $('.staff-preset-radio').prop('checked', false);
            $('#modal_note_text').val('');

            if (type === 'staff') {
                $('#staffNoteRadioGroup').removeClass('d-none');
                $('#noteModalTitle').text(action === 'edit' ? 'Edit Staff Note' : 'Add Staff Note');

                // Edit Mode Check
                if (action === 'edit') {
                    let currentText = $(this).closest('.notes-container').find('.text-break').text()
                        .trim();
                    let matchedRadio = $(`.staff-preset-radio[value="${currentText}"]`);

                    if (matchedRadio.length > 0) {
                        matchedRadio.prop('checked', true).trigger('change');
                    } else if (currentText && currentText !== 'No staff notes.') {
                        $('#radioOther').prop('checked', true);
                        $('#customNoteInputGroup').removeClass('d-none');
                        $('#modal_note_text').val(currentText).attr('required', true);
                    } else {
                        $('#radioOther').prop('checked', true);
                        $('#customNoteInputGroup').removeClass('d-none');
                    }
                } else {
                    // Add mode
                    $('#radioOther').prop('checked', true);
                    $('#customNoteInputGroup').removeClass('d-none');
                }
            } else {
                // Customer Note: Only Text Input
                $('#staffNoteRadioGroup').addClass('d-none');
                $('#customNoteInputGroup').removeClass('d-none');
                $('#noteModalTitle').text(action === 'edit' ? 'Edit Customer Note' :
                    'Add Customer Note');
                $('#noteTypeLabel').text('Customer Note Text');

                if (action === 'edit') {
                    let currentText = $(this).closest('.notes-container').find('.text-break').text()
                        .trim();
                    if (currentText !== 'No customer notes.') {
                        $('#modal_note_text').val(currentText);
                    }
                }
            }

            $('#noteActionModal').modal('show');
        });

        // ৩. Submit Form
        $('#noteActionForm').on('submit', function(e) {
            e.preventDefault();

            let action = $('#modal_action_type').val();
            let url = action === 'edit' ?
                "admin/orders/notes/update/" + $('#modal_note_id').val() :
                "{{ route('admin.orders.notes.store') }}";

            $.ajax({
                url: url,
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status === 200) {
                        $('#noteActionModal').modal('hide');
                        location.reload();
                    }
                },
                error: function() {
                    alert('An error occurred. Please check your inputs.');
                }
            });
        });

    });
</script>
<script>
    // ১. SL cell-এর যেকোনো জায়গায় ক্লিক করলে চেক/আনচেক ও Row Bg Change হওয়াব
    $(document).on('click', '.sl-cell', function(e) {
        // যদি সরাসরি Checkbox-এই ক্লিক হয়ে থাকে, তবে টগল ডাবল হওয়ার সমস্যা এড়াতে এটি হ্যান্ডেল করা
        let $checkbox = $(this).find('.sub_chk');
        if (!$(e.target).is(':checkbox')) {
            $checkbox.prop('checked', !$checkbox.prop('checked')).trigger('change');
        }
    });

    // ২. Checkbox change হলে Row background toggle করা
    $(document).on('change', '.sub_chk', function() {
        let $row = $(this).closest('tr');
        if ($(this).is(':checked')) {
            $row.addClass('table-active-row');
        } else {
            $row.removeClass('table-active-row');
        }

        // মাস্টার চেকক্সের অবস্থা আপডেট রাখা
        if ($('.sub_chk:checked').length === $('.sub_chk').length) {
            $('#master').prop('checked', true);
        } else {
            $('#master').prop('checked', false);
        }
    });

    // ৩. Master Checkbox (Select All) এ ক্লিক করলেও সব Row-এর Bg Change হওয়া
    $('#master').on('click', function(e) {
        let isChecked = $(this).is(':checked');
        $('.sub_chk').prop('checked', isChecked).trigger('change');
    });
</script>
<script>
    function changePerPage(perPage) {
        let currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set('per_page', perPage);
        currentUrl.searchParams.set('page', 1); // Reset to page 1 on limit change
        window.location.href = currentUrl.toString();
    }
</script>
@endpush
@push('css')
<style>
    .duplicate-order {
        background-color: #fde2e2 !important;
        border-left: 4px solid #dc3545;
    }
</style>
@endpush
