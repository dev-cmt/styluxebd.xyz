@extends('backEnd.admin.layouts.master')

@section('title')
    Product Sales & Profit Report
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('backEnd/assets/plugin/datepicker/daterangepicker.css') }}" />
    <style>
        .form-select,
        .form-control {
            height: 40px;
            font-size: 14px;
            border-color: #d1d5db;
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
                        <h2 class="page-title fw-bold text-dark">Product Sales & Profit Report</h2>
                        <p class="text-muted small mb-0">Detailed product sales insights, purchase cost, and courier actual
                            profit breakdown.</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary-lt text-primary px-3 py-2 fw-semibold fs-6">
                            Total Products: {{ count($products) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Filter & Search Card Section -->
            <div class="row row-deck row-cards mb-3">
                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body bg-white rounded-3 p-3 border">
                            <form action="{{ route('admin.report.sales.product') }}" method="GET" id="sales_filter_form">
                                <div class="d-flex flex-wrap align-items-end gap-3">

                                    {{-- Date Range --}}
                                    <div style="flex: 0 0 320px; max-width: 100%;">
                                        <label for="date_range_display"
                                            class="form-label small fw-bold text-secondary mb-1">
                                            Date Range
                                        </label>
                                        <div class="input-group shadow-sm rounded">
                                            <span class="input-group-text  border-end-0 text-muted"><i
                                                    class="ti ti-calendar"></i></span>
                                            <input type="text" id="date_range_display" placeholder="Select date range"
                                                class="form-control  border-start-0" autocomplete="off"
                                                value="{{ $start->format('Y-m-d') }} - {{ $end->format('Y-m-d') }}">
                                            <input type="hidden" name="date_range" id="date_range">
                                        </div>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="d-flex gap-2" style="flex: 0 0 auto; min-width: 130px; height: 40px;">
                                        <button type="submit"
                                            class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-1 shadow-sm h-100">
                                            <i class="ti ti-search"></i> Filter
                                        </button>
                                        <a href="{{ route('admin.report.sales.product') }}"
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

            <!-- Table Section -->
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                <div class="card-header bg-white py-3">
                    <h3 class="card-title fw-bold text-dark m-0">Product Profit Breakdown</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-vcenter card-table text-nowrap mb-0 align-middle">
                        <thead class="table-light text-uppercase fs-7">
                            <tr>
                                <th class="text-center">#</th>
                                <th>Product</th>
                                <th>SKU</th>
                                <th class="text-center">Total Qty</th>
                                <th>Total Sales</th>
                                <th>Pur. Cost</th>
                                <th>Discount</th>
                                <th>Courier Fee</th>
                                <th>Coupon</th>
                                <th>Actual Profit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i = 1)
                            @forelse ($products as $key => $prod)
                                <tr>
                                    <td class="text-center text-muted">{{ $i++ }}</td>
                                    <td><span class="fw-semibold text-dark">{{ $prod['product_name'] }}</span></td>
                                    <td><span class="badge bg-secondary-lt">{{ $prod['sku'] }}</span></td>
                                    <td class="text-center"><span class="badge bg-blue-lt">{{ $prod['qty'] }}</span></td>
                                    <td class="fw-bold text-dark">৳ {{ number_format($prod['sales'], 2) }}</td>
                                    <td class="text-secondary">৳ {{ number_format($prod['purchase'], 2) }}</td>
                                    <td>৳ {{ number_format($prod['discount'] ?? 0, 2) }}</td>
                                    <td class="text-danger fw-medium">৳ {{ number_format($prod['courier_fee'] ?? 0, 2) }}
                                    </td>
                                    <td>৳ {{ number_format($prod['coupon'] ?? 0, 2) }}</td>
                                    <td class="fw-bold {{ $prod['profit'] >= 0 ? 'text-success' : 'text-danger' }}">
                                        ৳ {{ number_format($prod['profit'], 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-5">
                                        <i class="ti ti-database-off fs-1 mb-2 d-block"></i>
                                        No Products Found in This Date Range
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td colspan="3" class="text-end text-uppercase">Total Summary:</td>
                                <td class="text-center">{{ $footer['total_qty'] }}</td>
                                <td class="text-primary">৳ {{ number_format($footer['total_sales'], 2) }}</td>
                                <td class="text-secondary">৳ {{ number_format($footer['total_purchase'], 2) }}</td>
                                <td>৳ {{ number_format($footer['total_discount'] ?? 0, 2) }}</td>
                                <td class="text-danger">৳ {{ number_format($footer['total_courier_fee'] ?? 0, 2) }}</td>
                                <td>৳ {{ number_format($footer['total_coupon'] ?? 0, 2) }}</td>
                                <td class="{{ $footer['total_profit'] >= 0 ? 'text-success' : 'text-danger' }}">
                                    ৳ {{ number_format($footer['total_profit'], 2) }}
                                </td>
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
