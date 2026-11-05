@extends('backEnd.admin.layouts.master')

@section('title')
    Dashboard
@endsection

@php
    $net_profit = $data['net_profit'] ?? 0;
    $gross_profit = $data['gross_profit'] ?? 0;
    $total_expense = $data['total_expense'] ?? 0;
    $total_revenue = $data['total_revenue'] ?? 0;
    $profit_margin = $data['profit_margin'] ?? 0;
    $avg_order_value = $data['avg_order_value'] ?? 0;

    $total_customer = $data['total_customer'] ?? 0;
    $total_product = $data['total_product'] ?? 0;
    $total_staff = $data['total_staff'] ?? 0;
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
    $total_return_received_order = $data['total_return_received_order'] ?? 0;
    $total_exchange_order = $data['total_exchange_order'] ?? 0;
    $total_abandoned_order = $data['total_abandoned_order'] ?? 0;

    $delivery_success_rate = $data['delivery_success_rate'] ?? 0;
    $return_rate = $data['return_rate'] ?? 0;
    $cancel_rate = $data['cancel_rate'] ?? 0;

    $top_selling_products = $data['top_selling_products'] ?? collect([]);
    $recent_orders = $data['recent_orders'] ?? collect([]);
@endphp

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('backEnd/assets/plugin/datepicker/daterangepicker.css') }}" />
    <style>
        .biz-card {
            transition: all 0.25s ease-in-out;
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
            border-radius: 12px;
        }

        .biz-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06) !important;
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }

        .pipeline-card {
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 10px;
            padding: 12px 16px;
            transition: all 0.2s ease-in-out;
        }

        .pipeline-card:hover {
            background-color: var(--tblr-bg-surface-secondary);
            border-color: rgba(0, 0, 0, 0.12);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.15);
            border-radius: 10px;
        }
    </style>
@endpush

@section('content')
    <!-- Page Header & Date Range Filter -->
    <div class="page-header d-print-none mb-3">
        <div class="container-xl">
            <div class="row g-2 align-items-center justify-content-between">
                <div class="col-md-5">
                    <div class="page-pretitle text-muted fw-semibold">Business Performance Dashboard</div>
                    <h2 class="page-title fw-bold text-dark">Executive Overview</h2>
                </div>

                <div class="col-md-7 d-flex justify-content-md-end align-items-center gap-2 flex-wrap">
                    @can('dashboard.order.range')
                        <form action="{{ route('admin.home') }}" method="GET" class="d-flex align-items-center gap-2"
                            id="dashboard_filter_form">
                            <div>
                                <input type="text" placeholder="Select date range" id="date_range_display"
                                    class="form-control search-input form-control-sm date_range date_range_display"
                                    autocomplete="off"
                                    value="{{ isset($start) && isset($end) ? \Carbon\Carbon::parse($start)->format('Y-m-d') . ' - ' . \Carbon\Carbon::parse($end)->format('Y-m-d') : request('date_range') }}">
                                <input type="hidden" name="date_range" id="date_range"
                                    value="{{ request('date_range', isset($start) && isset($end) ? \Carbon\Carbon::parse($start)->format('YYYY-MM-DD') . ' - ' . \Carbon\Carbon::parse($end)->format('YYYY-MM-DD') : '') }}">
                            </div>
                            <button type="submit" class="btn btn-sm btn-gradient-primary d-flex align-items-center gap-1">
                                <i class="ti ti-filter me-1"></i> Filter
                            </button>
                            @if (request()->filled('date_range'))
                                <a href="{{ route('admin.home') }}"
                                    class="btn btn-sm btn-gradient-danger d-flex align-items-center gap-1" title="Reset Filter"
                                    style="height: 27px;text-align: center;">
                                    <i class="ti ti-x me-1"></i> Clear
                                </a>
                            @endif
                        </form>
                    @endcan

                    <div class="btn-list">
                        @can('orders.create')
                            <a href="{{ route('admin.orders.create') }}"
                                class="btn btn-sm btn-gradient-primary d-flex align-items-center gap-1">
                                <i class="ti ti-plus me-1"></i> Create Order
                            </a>
                        @endcan

                        @can('products.create')
                            <a href="{{ route('admin.product.create') }}"
                                class="btn btn-sm btn-gradient-success d-flex align-items-center gap-1">
                                <i class="ti ti-box me-1"></i> Add Product
                            </a>
                        @endcan

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="page-body">
        <div class="container-xl">

            <!-- SECTION 1: Profit & Loss Statement Summary (Current Month / Filtered) -->
            @can('dashboard.financial')
                <div class="row row-cards mb-3 g-3">
                    {{-- Net Profit --}}
                    <div class="col-sm-6 col-lg-4 col-xl-3 mt-0">
                        <div class="card biz-card shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-uppercase text-muted fw-bold fs-6">Net Profit</span>
                                    <div class="stat-icon bg-success-lt text-success">
                                        <i class="ti ti-cash fs-1"></i>
                                    </div>
                                </div>
                                <div class="h1 mb-1 fw-extrabold {{ $net_profit < 0 ? 'text-danger' : 'text-success' }}">
                                    <span>{{ $web_settings->currency_sign }}</span>
                                    <span>{{ number_format($net_profit, 2) }}</span>
                                </div>
                                <div class="text-muted small d-flex align-items-center justify-content-between">
                                    <span>Net Margin: <strong>{{ $profit_margin }}%</strong></span>
                                    <span
                                        class="badge {{ $net_profit >= 0 ? 'bg-success-lt text-success' : 'bg-danger-lt text-danger' }}">
                                        {{ $net_profit >= 0 ? 'Profitable' : 'Loss' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Gross Profit --}}
                    <div class="col-sm-6 col-lg-4 col-xl-3 mt-0">
                        <div class="card biz-card shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-uppercase text-muted fw-bold fs-6">Gross Profit</span>
                                    <div class="stat-icon bg-primary-lt text-primary">
                                        <i class="ti ti-chart-bar fs-1"></i>
                                    </div>
                                </div>
                                <div class="h1 mb-1 fw-extrabold text-dark">
                                    <span>{{ $web_settings->currency_sign }}</span>
                                    <span>{{ number_format($gross_profit, 2) }}</span>
                                </div>
                                <div class="text-muted small d-flex align-items-center gap-1">
                                    <span class="badge bg-primary-lt text-primary">Revenue</span>
                                    <span>Sales - Product Cost</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Total Expense (Outgoing) --}}
                    <div class="col-sm-6 col-lg-4 col-xl-3 mt-0">
                        <div class="card biz-card shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-uppercase text-muted fw-bold fs-6">Total Expenses</span>
                                    <div class="stat-icon bg-danger-lt text-danger">
                                        <i class="ti ti-report-money fs-1"></i>
                                    </div>
                                </div>
                                <div class="h1 mb-1 fw-extrabold text-dark">
                                    <span>{{ $web_settings->currency_sign }}</span>
                                    <span>{{ number_format($total_expense, 2) }}</span>
                                </div>
                                <div class="text-muted small d-flex align-items-center gap-1">
                                    <span class="badge bg-danger-lt text-danger">Outgoings</span>
                                    <span>Ads, Courier, Rent etc</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Total Sales Revenue --}}
                    <div class="col-sm-6 col-lg-4 col-xl-3 mt-0">
                        <div class="card biz-card shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-uppercase text-muted fw-bold fs-6">Total Delivered Sales</span>
                                    <div class="stat-icon bg-azure-lt text-azure">
                                        <i class="ti ti-currency-dollar fs-1"></i>
                                    </div>
                                </div>
                                <div class="h1 mb-1 fw-extrabold text-dark">
                                    <span>{{ $web_settings->currency_sign }}</span>
                                    <span>{{ number_format($total_revenue, 2) }}</span>
                                </div>
                                <div class="text-muted small d-flex align-items-center gap-1">
                                    <span>Avg Order Value:
                                        <strong>{{ $web_settings->currency_sign }}{{ number_format($avg_order_value, 2) }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            <!-- SECTION 2: Order Lifecycle Pipeline & Overall Health -->
            <div class="row row-cards mb-3 g-3">
                @can('dashboard.order.status')
                    <div class="col-xl-8 col-lg-7">
                        <div class="card border-0 shadow-sm h-100 rounded-3">
                            <div
                                class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                                <h3 class="card-title fw-bold">
                                    <i class="ti ti-git-commit me-2 text-primary"></i>Order Fulfillment Pipeline
                                </h3>
                                @if (isset($start) && isset($end))
                                    <span class="badge bg-primary-lt">
                                        {{ $start->format('d M Y') }} - {{ $end->format('d M Y') }}
                                    </span>
                                @endif
                            </div>
                            <div class="card-body p-3">
                                <div class="row g-2">
                                    <div class="col-6 col-sm-4 col-md-3">
                                        <a href="{{ route('admin.orders', ['status' => 'pending']) }}"
                                            class="text-decoration-none">
                                            <div class="pipeline-card">
                                                <div class="text-muted fs-6 fw-semibold">Pending</div>
                                                <div class="h2 mb-0 text-warning fw-bold">
                                                    {{ number_format($total_pending_order) }}</div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-4 col-md-3">
                                        <a href="{{ route('admin.orders', ['status' => 'confirm']) }}"
                                            class="text-decoration-none">
                                            <div class="pipeline-card">
                                                <div class="text-muted fs-6 fw-semibold">Confirmed</div>
                                                <div class="h2 mb-0 text-primary fw-bold">
                                                    {{ number_format($total_confirm_order) }}</div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-4 col-md-3">
                                        <a href="{{ route('admin.orders', ['status' => 'processing']) }}"
                                            class="text-decoration-none">
                                            <div class="pipeline-card">
                                                <div class="text-muted fs-6 fw-semibold">Processing</div>
                                                <div class="h2 mb-0 text-info fw-bold">
                                                    {{ number_format($total_processing_order) }}</div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-4 col-md-3">
                                        <a href="{{ route('admin.orders', ['status' => 'hold']) }}"
                                            class="text-decoration-none">
                                            <div class="pipeline-card">
                                                <div class="text-muted fs-6 fw-semibold">Hold</div>
                                                <div class="h2 mb-0 text-purple fw-bold">
                                                    {{ number_format($total_hold_order) }}</div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-4 col-md-3">
                                        <a href="{{ route('admin.orders', ['status' => 'packaging']) }}"
                                            class="text-decoration-none">
                                            <div class="pipeline-card">
                                                <div class="text-muted fs-6 fw-semibold">Packaging</div>
                                                <div class="h2 mb-0 text-orange fw-bold">
                                                    {{ number_format($total_packaging_order) }}</div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-4 col-md-3">
                                        <a href="{{ route('admin.orders', ['status' => 'courier_entry']) }}"
                                            class="text-decoration-none">
                                            <div class="pipeline-card">
                                                <div class="text-muted fs-6 fw-semibold">Courier Entry</div>
                                                <div class="h2 mb-0 text-blue fw-bold">
                                                    {{ number_format($total_courier_entry_order) }}</div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-4 col-md-3">
                                        <a href="{{ route('admin.orders', ['status' => 'on_delivery']) }}"
                                            class="text-decoration-none">
                                            <div class="pipeline-card">
                                                <div class="text-muted fs-6 fw-semibold">On Delivery</div>
                                                <div class="h2 mb-0 text-azure fw-bold">
                                                    {{ number_format($total_on_delivery_order) }}</div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-4 col-md-3">
                                        <a href="{{ route('admin.orders', ['status' => 'delivered']) }}"
                                            class="text-decoration-none">
                                            <div class="pipeline-card">
                                                <div class="text-muted fs-6 fw-semibold">Delivered</div>
                                                <div class="h2 mb-0 text-success fw-bold">
                                                    {{ number_format($total_delivered_order) }}</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                {{-- Business Health Ratios --}}
                @can('dashboard.order.ratio')
                    <div class="col-xl-4 col-lg-5">
                        <div class="card border-0 shadow-sm h-100 rounded-3">
                            <div
                                class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                                <h3 class="card-title fw-bold">
                                    <i class="ti ti-activity me-2 text-success"></i>Business Health Ratios
                                </h3>
                                @if (isset($start) && isset($end))
                                    <span class="badge bg-primary-lt">
                                        {{ $start->format('d M Y') }} - {{ $end->format('d M Y') }}
                                    </span>
                                @endif
                            </div>
                            <div class="card-body p-3 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-muted fw-semibold">Delivery Success Ratio</span>
                                        <span class="fw-bold text-success">{{ $delivery_success_rate }}%</span>
                                    </div>
                                    <div class="progress progress-sm mb-2">
                                        <div class="progress-bar bg-success" style="width: {{ $delivery_success_rate }}%">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-muted fw-semibold">Return Ratio (Loss Factor)</span>
                                        <span class="fw-bold text-danger">{{ $return_rate }}%</span>
                                    </div>
                                    <div class="progress progress-sm mb-2">
                                        <div class="progress-bar bg-danger" style="width: {{ $return_rate }}%"></div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-muted fw-semibold">Cancel Ratio</span>
                                        <span class="fw-bold text-warning">{{ $cancel_rate }}%</span>
                                    </div>
                                    <div class="progress progress-sm mb-3">
                                        <div class="progress-bar bg-warning" style="width: {{ $cancel_rate }}%"></div>
                                    </div>
                                </div>

                                <div class="row text-center g-2 pt-2 border-top">
                                    <div class="col-4">
                                        <div class="text-muted fs-6">Customers</div>
                                        <div class="h3 mb-0 fw-bold text-dark">{{ number_format($total_customer) }}</div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-muted fs-6">Products</div>
                                        <div class="h3 mb-0 fw-bold text-primary">{{ number_format($total_product) }}</div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-muted fs-6">Staffs</div>
                                        <div class="h3 mb-0 fw-bold text-info">{{ number_format($total_staff) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

            </div>

            <!-- SECTION 3: Stock Warning & Top Selling Products -->
            <div class="row row-cards mb-3 g-3">
                {{-- Low Stock Warning --}}
                @can('dashboard.stock.warning')
                    <div class="col-xl-6 col-lg-6">
                        <div class="card border-0 shadow-sm h-100 rounded-3">
                            <div
                                class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                                <h3 class="card-title fw-bold text-warning">
                                    <i class="ti ti-alert-triangle me-2"></i>Stock Warning
                                </h3>
                                <a href="{{ route('admin.product') }}" class="btn btn-sm btn-ghost-warning">Catalog</a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive custom-scrollbar" style="max-height: 450px; overflow-y: auto;">
                                    {{-- <div class="table-responsive custom-scrollbar" style="max-height: 380px; overflow-y: auto;"> --}}
                                    @php
                                        $setting = DB::table('web_settings')->first();
                                        $stock_alert = $setting->stock_alert ?? 0;
                                        $products = DB::table('products')
                                            // ->where('theme_id', $activeThemeId)
                                            ->where('is_combo', 0)
                                            ->when($stock_alert > 0, function ($q) use ($stock_alert) {
                                                $q->where('stock', '<=', $stock_alert);
                                            })
                                            ->take(10)
                                            ->get();
                                    @endphp
                                    <table class="table table-vcenter card-table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th class="text-end">Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($products as $p)
                                                <tr>
                                                    <td class="text-truncate" style="max-width: 180px;">{{ $p->name }}
                                                    </td>
                                                    <td class="text-end">
                                                        <span class="badge bg-warning-lt text-warning fw-bold px-2 py-1">
                                                            {{ $p->stock }} Pcs
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2" class="text-center text-muted py-4">
                                                        <i class="ti ti-circle-check text-success fs-2 d-block mb-1"></i>
                                                        Stock levels are healthy.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    {{-- </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
                @can('dashboard.top.products')
                    {{-- Top Selling Products --}}
                    <div class="col-xl-6 col-lg-6">
                        <div class="card border-0 shadow-sm h-100 rounded-3">
                            <div
                                class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                                <h3 class="card-title fw-bold">
                                    <i class="ti ti-flame me-2 text-danger"></i>Top Selling Products
                                </h3>
                                @if (isset($start) && isset($end))
                                    <span class="badge bg-primary-lt">
                                        {{ $start->format('d M Y') }} - {{ $end->format('d M Y') }}
                                    </span>
                                @endif
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive custom-scrollbar" style="max-height: 450px; overflow-y: auto;">
                                    <table class="table table-vcenter card-table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th class="text-end">Total Sold</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($top_selling_products as $product)
                                                <tr>
                                                    <td class="text-truncate fw-semibold text-dark" style="max-width: 180px;">
                                                        {{ $product->name }}</td>
                                                    <td class="text-end">
                                                        <span class="badge bg-primary-lt text-primary fw-bold px-2 py-1">
                                                            {{ $product->total_sold }} Sold
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2" class="text-center text-muted py-4">No top selling
                                                        products found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>

            <!-- SECTION 4: Courier, Expense, Financial Accounts & Staff Workload -->
            <div class="row row-cards mb-3 g-3">
                @can('dashboard.courier.status')
                    {{-- Courier Distribution Breakdown --}}
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card border-0 shadow-sm h-100 rounded-3">
                            <div
                                class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                                <h3 class="card-title fw-bold fs-5">
                                    <i class="ti ti-truck me-1 text-azure"></i>Courier Wise
                                </h3>
                                @if (isset($start) && isset($end))
                                    <span class="badge bg-primary-lt">{{ $start->format('d M Y') }} -
                                        {{ $end->format('d M Y') }}</span>
                                @endif
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive custom-scrollbar" style="max-height: 320px; overflow-y: auto;">
                                    <table class="table table-vcenter card-table table-hover fs-6">
                                        <tbody>
                                            @forelse ($data['courier_breakdown'] ?? [] as $courierItem)
                                                @php
                                                    $courierNames = [
                                                        1 => 'Steadfast',
                                                        2 => 'Pathao',
                                                        3 => 'Redx',
                                                        4 => 'Carrybee',
                                                    ];
                                                    $cName =
                                                        $courierNames[$courierItem->courier_id] ??
                                                        'Courier #' . $courierItem->courier_id;
                                                @endphp
                                                <tr>
                                                    <td class="text-dark">{{ $cName }}</td>
                                                    <td class="text-end">
                                                        <span
                                                            class="badge bg-azure-lt text-azure fw-bold">{{ number_format($courierItem->total) }}</span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2" class="text-center text-muted py-3">No data</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('dashboard.expense')
                    {{-- Expense Category Breakdown --}}
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card border-0 shadow-sm h-100 rounded-3">
                            <div
                                class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                                <h3 class="card-title fw-bold fs-5">
                                    <i class="ti ti-chart-pie me-1 text-danger"></i>Expense Categories
                                </h3>
                                @if (isset($start) && isset($end))
                                    <span class="badge bg-primary-lt">{{ $start->format('d M Y') }} -
                                        {{ $end->format('d M Y') }}</span>
                                @endif
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive custom-scrollbar" style="max-height: 320px; overflow-y: auto;">
                                    <table class="table table-vcenter card-table table-hover fs-6">
                                        <tbody>
                                            @forelse ($data['expense_categories'] ?? [] as $exp)
                                                <tr>
                                                    <td class="text-dark">{{ $exp->get_category->name ?? 'General' }}</td>
                                                    <td class="text-end fw-bold text-danger">
                                                        {{ $web_settings->currency_sign }}{{ number_format($exp->total_amount, 2) }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2" class="text-center text-muted py-3">No expense</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('dashboard.account')
                    {{-- Financial Accounts Balance Overview --}}
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card border-0 shadow-sm h-100 rounded-3">
                            <div
                                class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                                <h3 class="card-title fw-bold fs-5">
                                    <i class="ti ti-wallet me-1 text-success"></i>Accounts Balance
                                </h3>
                                @if (isset($start) && isset($end))
                                    <span class="badge bg-primary-lt">{{ $start->format('d M Y') }} -
                                        {{ $end->format('d M Y') }}</span>
                                @endif
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive custom-scrollbar" style="max-height: 320px; overflow-y: auto;">
                                    <table class="table table-vcenter card-table table-hover fs-6">
                                        <tbody>
                                            @forelse ($data['accounts_balance'] ?? [] as $acc)
                                                <tr>
                                                    <td class="text-dark">{{ $acc->get_account_name() }}</td>
                                                    <td class="text-end fw-bold text-success">
                                                        {{ $web_settings->currency_sign }}{{ number_format($acc->balance, 2) }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2" class="text-center text-muted py-3">No accounts
                                                        configured</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('dashboard.staff')
                    {{-- Staff Workload / Order Assignment Breakdown --}}
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card border-0 shadow-sm h-100 rounded-3">
                            <div class="card-header bg-transparent border-bottom">
                                <h3 class="card-title fw-bold fs-5">
                                    <i class="ti ti-users me-1 text-info"></i>Staff Workload
                                </h3>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive custom-scrollbar" style="max-height: 320px; overflow-y: auto;">
                                    <table class="table table-vcenter card-table table-hover fs-6">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th class="text-end">Status</th>
                                                <th class="text-end">Orders</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data['staff_order_breakdown'] ?? [] as $staff)
                                                <tr>
                                                    <td class="text-dark">{{ $staff->name }}</td>
                                                    <td class="text-end">
                                                        @if ($staff->status == 1)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-end">
                                                        <span class="badge bg-info-lt text-info fw-bold">
                                                            {{ number_format($staff->assigned_orders_count) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted py-3">No staff
                                                        assignments</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>

        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('backEnd/assets/plugin/datepicker/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backEnd/assets/plugin/datepicker/daterangepicker.js') }}"></script>
    <script>
        $(document.body).ready(function() {
            var $dateInput = $('#date_range_display');

            $dateInput.daterangepicker({
                autoUpdateInput: {{ request()->filled('date_range') ? 'true' : 'false' }},
                startDate: moment(
                    "{{ isset($start) ? $start->format('Y-m-d') : Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}"
                ),
                endDate: moment(
                    "{{ isset($end) ? $end->format('Y-m-d') : Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}"
                ),
                locale: {
                    cancelLabel: 'Clear',
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
            });

            $dateInput.on('apply.daterangepicker', function(ev, picker) {
                var formattedRange = picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format(
                    'YYYY-MM-DD');
                $(this).val(formattedRange);
                $('#date_range').val(formattedRange);
            });

            $dateInput.on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                $('#date_range').val('');
            });
        });
    </script>
@endpush
