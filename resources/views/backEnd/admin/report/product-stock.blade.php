@extends('backEnd.admin.layouts.master')

@section('title')
    Product Stock Reports
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('backEnd/assets/plugin/datepicker/daterangepicker.css') }}" />
@endpush

@section('content')
    <div class="page-body mt-3">
        <div class="container-fluid">
            <!-- Header Section -->
            <div class="row">
                <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                    <h2 class="page-title">Product Stock Reports</h2>
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center gap-1">
                            <span class="fw-bold">Total Products:</span>
                            <span
                                class="badge bg-primary text-white">{{ $totalProductsCount ?? ($productRange->total() ?? count($productRange)) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter & Search Card Section -->
            <div class="row row-deck row-cards mt-2">
                <div class="col-12 m-0">
                    <div class="card shadow-sm rounded" style="border-top: none">
                        <div class="card-header bg-white border-bottom p-3">
                            <form action="{{ route('admin.report.product.stock') }}" method="GET" id="search_form"
                                class="w-100 d-flex flex-wrap align-items-end justify-content-between gap-2">
                                <input type="hidden" name="export" id="export_field" value="">
                                <div class="row g-2 align-items-end flex-wrap w-100">

                                    {{-- Product Select --}}
                                    <div class="col-md-4 col-12" style="min-width: 250px;">
                                        <select class="form-control form-control-sm select2 cool-select" name="product_id"
                                            id="product_id_select">
                                            <option value="">-- All Products --</option>
                                            @foreach ($product_list as $key => $product)
                                                <option value="{{ $key }}"
                                                    {{ (isset($product_id) ? $product_id : request()->query('product_id')) == $key ? 'selected' : '' }}>
                                                    {{ $product }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="col-auto d-flex gap-2 align-items-end">
                                        <button type="submit" id="search_btn"
                                            class="btn btn-sm btn-gradient-primary d-flex align-items-center gap-1"
                                            style="height: 31px;">
                                            <i class="ti ti-search me-1"></i> Search
                                        </button>
                                        <a href="{{ route('admin.report.product.stock') }}"
                                            class="btn btn-outline-secondary btn-sm px-2 d-flex align-items-center"
                                            title="Reset Filters" style="height: 31px;">
                                            <i class="ti ti-refresh"></i>
                                        </a>
                                    </div>

                                    {{-- CSV Export Button on Right --}}
                                    {{-- <div class="col-auto ms-auto">
                                        <button type="button" id="export_btn"
                                            class="btn btn-success btn-sm pdf-button d-flex align-items-center gap-1"
                                            style="height: 31px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                <path d="M7 11l5 5l5 -5" />
                                                <path d="M12 4l0 12" />
                                            </svg> CSV Export
                                        </button>
                                    </div> --}}

                                </div>
                            </form>
                        </div>

                        <!-- Summary Cards Section -->
                        <div class="card-body py-2">
                            <div class="row row-cards g-2">
                                <div class="col-sm-4 col-md-4">
                                    <div class="card p-3 text-center shadow-sm border-0 bg-light">
                                        <div class="text-muted small">Total Products</div>
                                        <div class="h4 fw-bold text-primary mb-0">
                                            {{ $totalProductsCount ?? ($productRange->total() ?? count($productRange)) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="card p-3 text-center shadow-sm border-0 bg-light">
                                        <div class="text-muted small">Total Stock Qty</div>
                                        <div class="h4 fw-bold text-success mb-0">
                                            {{ $calculatedTotalStock ?? 0 }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="card p-3 text-center shadow-sm border-0 bg-light">
                                        <div class="text-muted small">Total Purchase Cost</div>
                                        <div class="h4 fw-bold text-danger mb-0">
                                            ৳ {{ number_format($calculatedTotalPurchaseCost ?? 0, 2) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table Section -->
                        <div class="table-responsive">
                            <div class="p-3 pb-0">
                                {{ $productRange->links('backEnd.admin.includes.paginate') }}
                            </div>
                            <table class="table table-bordered table-vcenter card-table text-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th style="width: 80px;">Image</th>
                                        <th>Product Information</th>
                                        <th>Available Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i = ($productRange->currentPage() - 1) * $productRange->perPage() + 1)
                                    @forelse ($productRange as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>

                                                @if ($item->get_thumb)
                                                    <img src="{{ asset($item->get_thumb->file_url) }}"
                                                        class="image-modal-trigger rounded object-fit-cover shadow-sm cursor-pointer"
                                                        style="width: 75px; height: 75px;"
                                                        data-src="{{ asset($item->get_thumb->file_url) }}"
                                                        data-bs-toggle="modal" data-bs-target="#imageModal">
                                                @else
                                                    <div class="bg-light border rounded d-flex align-items-center justify-content-center text-muted"
                                                        style="width: 75px; height: 75px;" title="No image available">
                                                        <i class="ti ti-photo-off fs-6"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('single.product', $item->slug) }}"
                                                    style="font-size: 14px;color: #000;font-weight: 600;">
                                                    {{ $item->name }} ({{ $item->sku }}) </a> <br>
                                                @if ($item->get_variants && $item->get_variants->count() > 0)
                                                    <strong style="font-size:12px">Variants:</strong> <br>
                                                    @foreach ($item->get_variants as $variant)
                                                        <?php
                                                        $variantInfo = $variant->items
                                                            ->map(function ($subItem) {
                                                                $attrName = $subItem->attribute->name ?? '';
                                                                $itemName = $subItem->name ?? '';
                                                                return $attrName . ': ' . $itemName;
                                                            })
                                                            ->implode(', ');
                                                        ?>
                                                        <small>
                                                            ({{ $variantInfo }})
                                                            - Stock: {{ $variant->stock }}
                                                        </small><br>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                <?php
                                                if (isset($stockManagement) && $stockManagement == 1) {
                                                    $totalStockVal = $item->get_purchase_items->sum('stock_quantity');
                                                } else {
                                                    $totalStockVal = $item->get_variants && count($item->get_variants) > 0 ? $item->get_variants->sum('stock') : $item->stock;
                                                }
                                                ?>
                                                @if ($totalStockVal > 0)
                                                    <span class="badge bg-success text-white">{{ $totalStockVal }}
                                                        Units</span>
                                                @else
                                                    <span class="badge bg-danger text-white">Out of Stock (0)</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">No Products Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr class="fw-bold bg-light text-dark">
                                        <td colspan="3" class="text-end">Total Stock Qty:</td>
                                        <td>{{ $calculatedTotalStock ?? 0 }} Units</td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="p-3">
                                {{ $productRange->links('backEnd.admin.includes.paginate') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: 'resolve'
            });

            // Handle Search Submit
            $('#search_btn').on('click', function(e) {
                $('#export_field').val('');
                $('#search_form').submit();
            });

            // Handle Export Submit
            $('#export_btn').on('click', function(e) {
                $('#export_field').val('1');
                $('#search_form').submit();
                $('#export_field').val(''); // Reset after submit
            });
        });
    </script>
@endpush
