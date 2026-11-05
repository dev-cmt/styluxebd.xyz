@extends('backEnd.admin.layouts.master')

@section('title')
    Sales & Actual Profit Report
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('backEnd/assets/plugin/datepicker/daterangepicker.css') }}" />
    <style>
        .card-stat {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .card-stat:hover {
            transform: translateY(-3px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .08) !important;
        }

        /* Standard height and clear appearance for filters */
        .form-select,
        .form-control {
            height: 40px;
            font-size: 14px;
            border-color: #d1d5db;
            color: #000 !important;
        }

        .form-select option {
            background-color: #ffffff;
            color: #1f2937;
            padding: 10px 12px;
        }
    </style>
@endpush

@section('content')
    <div class="page-body mt-3">
        <div class="container-fluid">
            <!-- Header Section -->
            <div class="row mb-3">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="page-title fw-bold text-dark">Sales & Profit Analytics</h2>
                        <p class="text-muted small mb-0">Detailed order insights, purchase cost, and courier actual profit
                            breakdown.</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary-lt text-primary px-3 py-2 fw-semibold fs-6">
                            Total Orders: {{ $footer['total_orders'] }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Filter & Search Card Section -->
            <div class="row row-deck row-cards mb-3">
                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body bg-white rounded-3 p-3 border">
                            <form action="{{ route('admin.report.sales.order') }}" method="GET" id="sales_filter_form">
                                <div class="d-flex flex-wrap align-items-end gap-3">

                                    {{-- Date Range --}}
                                    <div style="flex: 1 1 240px; min-width: 230px;">
                                        <label for="date_range_display"
                                            class="form-label small fw-bold text-secondary mb-1">
                                            Date Range
                                        </label>
                                        <div class="input-group shadow-sm rounded">
                                            <span class="input-group-text bg-light border-end-0 text-muted"><i
                                                    class="ti ti-calendar"></i></span>
                                            <input type="text" id="date_range_display" placeholder="Select date range"
                                                class="form-control bg-light border-start-0" autocomplete="off"
                                                value="{{ $start->format('Y-m-d') }} - {{ $end->format('Y-m-d') }}">
                                            <input type="hidden" name="date_range" id="date_range">
                                        </div>
                                    </div>

                                    {{-- Customer --}}
                                    <div style="flex: 1 1 180px; min-width: 160px;">
                                        <label class="form-label small fw-bold text-secondary mb-1">Customer</label>
                                        <select name="customer_id" class="form-select bg-light shadow-sm">
                                            <option value="">All Customers</option>
                                            @foreach ($customers as $c)
                                                <option value="{{ $c->id }}"
                                                    {{ request('customer_id') == $c->id ? 'selected' : '' }}>
                                                    {{ $c->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Payment Status --}}
                                    <div style="flex: 1 1 150px; min-width: 140px;">
                                        <label class="form-label small fw-bold text-secondary mb-1">Payment</label>
                                        <select name="payment_status" class="form-select bg-light shadow-sm">
                                            <option value="All">All Payments</option>
                                            <option value="1" {{ request('payment_status') == '1' ? 'selected' : '' }}>
                                                Paid</option>
                                            <option value="0" {{ request('payment_status') == '0' ? 'selected' : '' }}>
                                                Due</option>
                                        </select>
                                    </div>

                                    {{-- Order Status --}}
                                    <div style="flex: 1 1 190px; min-width: 170px;">
                                        <label class="form-label small fw-bold text-secondary mb-1">Order Status</label>
                                        <select name="order_status" class="form-select bg-light shadow-sm">
                                            <option value="All">All Status</option>
                                            <option value="1" {{ request('order_status') == '1' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="2" {{ request('order_status') == '2' ? 'selected' : '' }}>
                                                Confirm</option>
                                            <option value="3" {{ request('order_status') == '3' ? 'selected' : '' }}>
                                                Processing</option>
                                            <option value="4" {{ request('order_status') == '4' ? 'selected' : '' }}>
                                                Hold</option>
                                            <option value="5" {{ request('order_status') == '5' ? 'selected' : '' }}>
                                                Printed</option>
                                            <option value="6" {{ request('order_status') == '6' ? 'selected' : '' }}>
                                                Packaging</option>
                                            <option value="7" {{ request('order_status') == '7' ? 'selected' : '' }}>
                                                Courier Entry</option>
                                            <option value="8" {{ request('order_status') == '8' ? 'selected' : '' }}>
                                                On Delivery</option>
                                            <option value="9" {{ request('order_status') == '9' ? 'selected' : '' }}>
                                                Delivered</option>
                                            <option value="10" {{ request('order_status') == '10' ? 'selected' : '' }}>
                                                Cancelled</option>
                                            <option value="11" {{ request('order_status') == '11' ? 'selected' : '' }}>
                                                Returned</option>
                                            <option value="12" {{ request('order_status') == '12' ? 'selected' : '' }}>
                                                Return Received</option>
                                            <option value="13" {{ request('order_status') == '13' ? 'selected' : '' }}>
                                                Exchange</option>
                                        </select>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="d-flex gap-2" style="flex: 0 0 auto; min-width: 130px; height: 40px;">
                                        <button type="submit"
                                            class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-1 shadow-sm h-100">
                                            <i class="ti ti-search"></i> Filter
                                        </button>
                                        <a href="{{ route('admin.report.sales.order') }}"
                                            class="btn btn-outline-secondary px-2 shadow-sm h-100 d-flex align-items-center justify-content-center"
                                            title="Reset Filters">
                                            <i class="ti ti-refresh"></i>
                                        </a>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Cards Section -->
            <div class="row row-cards g-3 mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-stat shadow-sm border-0 rounded-3 py-2"
                        style="border-left-color: #206bc4 !important;">
                        <div class="card-body py-2 px-3">
                            <div class="text-muted small fw-semibold text-uppercase">Total Sales</div>
                            <div class="h3 fw-bold text-primary mb-0 mt-1">৳ {{ number_format($footer['total_sales'], 2) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-stat shadow-sm border-0 rounded-3 py-2"
                        style="border-left-color: #f59f00 !important;">
                        <div class="card-body py-2 px-3">
                            <div class="text-muted small fw-semibold text-uppercase">Purchase Cost</div>
                            <div class="h3 fw-bold text-warning mb-0 mt-1">৳
                                {{ number_format($footer['total_purchase'], 2) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-stat shadow-sm border-0 rounded-3 py-2"
                        style="border-left-color: #d63939 !important;">
                        <div class="card-body py-2 px-3">
                            <div class="text-muted small fw-semibold text-uppercase">Courier / Shipping Fee</div>
                            <div class="h3 fw-bold text-danger mb-0 mt-1">৳
                                {{ number_format($footer['total_courier_fee'], 2) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-stat shadow-sm border-0 rounded-3 py-2"
                        style="border-left-color: #2fb344 !important;">
                        <div class="card-body py-2 px-3">
                            <div class="text-muted small fw-semibold text-uppercase">Actual Net Profit</div>
                            <div
                                class="h3 fw-bold {{ $footer['total_profit'] >= 0 ? 'text-success' : 'text-danger' }} mb-0 mt-1">
                                ৳ {{ number_format($footer['total_profit'], 2) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                <div class="card-header bg-white py-3">
                    <h3 class="card-title fw-bold text-dark m-0">Orders Profit Breakdown</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-vcenter card-table text-nowrap mb-0 align-middle">
                        <thead class="table-light text-uppercase fs-7">
                            <tr>
                                <th class="text-center">#</th>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Customer Info</th>
                                <th class="text-center">Qty</th>
                                <th>Discount</th>
                                <th>Shipping</th>
                                <th>Courier Fee</th>
                                <th>Total Sales</th>
                                <th>Pur. Cost</th>
                                <th>Actual Profit</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Courier</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sales as $key => $row)
                                <tr>
                                    <td class="text-center text-muted">{{ $key + 1 }}</td>
                                    <td>{{ $row['date'] }}</td>
                                    <td><span class="fw-bold text-primary">#{{ $row['order_id'] }}</span></td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $row['customer'] }}</div>
                                        <div class="text-muted small">{{ $row['phone'] }}</div>
                                    </td>
                                    <td class="text-center"><span
                                            class="badge bg-secondary-lt">{{ $row['qty'] }}</span></td>
                                    <td>৳ {{ number_format($row['discount'], 2) }}</td>
                                    <td>৳ {{ number_format($row['shipping'], 2) }}</td>
                                    <td class="text-danger fw-medium">৳ {{ number_format($row['courier_fee'], 2) }}</td>
                                    <td class="fw-bold text-dark">৳ {{ number_format($row['sales'], 2) }}</td>
                                    <td class="text-secondary">৳ {{ number_format($row['purchase'], 2) }}</td>
                                    <td class="fw-bold {{ $row['profit'] >= 0 ? 'text-success' : 'text-danger' }}">
                                        ৳ {{ number_format($row['profit'], 2) }}
                                    </td>
                                    <td class="text-info fw-medium">৳ {{ number_format($row['paid'], 2) }}</td>
                                    <td class="text-danger fw-medium">৳ {{ number_format($row['due'], 2) }}</td>
                                    <td><span class="badge bg-azure-lt">{{ $row['courier_name'] }}</span></td>
                                    <td class="text-center">
                                        <span class="badge bg-blue-lt px-2 py-1">{{ $row['status'] }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge {{ $row['payment_status'] == 'Paid' ? 'bg-success-lt text-success' : 'bg-warning-lt text-warning' }} px-2 py-1">
                                            {{ $row['payment_status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="16" class="text-center text-muted py-5">
                                        <i class="ti ti-database-off fs-1 mb-2 d-block"></i>
                                        No Sales Orders Found in This Date Range
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td colspan="4" class="text-end text-uppercase">Total Summary:</td>
                                <td class="text-center">{{ $footer['total_qty'] }}</td>
                                <td>৳ {{ number_format($footer['total_discount'], 2) }}</td>
                                <td>৳ {{ number_format($footer['total_shipping'], 2) }}</td>
                                <td class="text-danger">৳ {{ number_format($footer['total_courier_fee'], 2) }}</td>
                                <td class="text-primary">৳ {{ number_format($footer['total_sales'], 2) }}</td>
                                <td class="text-secondary">৳ {{ number_format($footer['total_purchase'], 2) }}</td>
                                <td class="{{ $footer['total_profit'] >= 0 ? 'text-success' : 'text-danger' }}">
                                    ৳ {{ number_format($footer['total_profit'], 2) }}
                                </td>
                                <td class="text-info">৳ {{ number_format($footer['total_paid'], 2) }}</td>
                                <td class="text-danger">৳ {{ number_format($footer['total_due'], 2) }}</td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('backEnd/assets/plugin/datepicker/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backEnd/assets/plugin/datepicker/daterangepicker.js') }}"></script>
    <script>
        $(document).ready(function() {
            var start = moment("{{ $start->format('Y-m-d') }}");
            var end = moment("{{ $end->format('Y-m-d') }}");

            function updateDisplay(start, end) {
                $('#date_range_display').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                $('#date_range').val(JSON.stringify({
                    start: start.format('YYYY-MM-DD'),
                    end: end.format('YYYY-MM-DD')
                }));
            }

            $('#date_range_display').daterangepicker({
                startDate: start,
                endDate: end,
                autoUpdateInput: false,
                locale: {
                    format: 'YYYY-MM-DD'
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            }, updateDisplay);

            $('#date_range_display').on('apply.daterangepicker', function(ev, picker) {
                updateDisplay(picker.startDate, picker.endDate);
            });
        });
    </script>
@endpush
