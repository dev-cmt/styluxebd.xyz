@extends('backEnd.admin.layouts.master')
@section('title', 'Lot / Batch Stock & Sale Priority Control')

@php
    $purchaseItems = $purchaseItems ?? [];
@endphp

@section('content')
    <div class="page-body mt-3">
        <div class="container-xl">
            <div class="row">
                <div class="col-12 d-flex justify-content-between align-items-center gap-2">
                    <h2 class="page-title">Lot / Batch Stock & Sale Priority Control</h2>
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center gap-1">
                            <span class="fw-bold">Total:</span>
                            <span
                                class="badge bg-primary text-white">{{ method_exists($purchaseItems, 'total') ? $purchaseItems->total() : count($purchaseItems) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottom py-3">
                <form action="" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control "
                            placeholder="Search by Product, SKU, Memo..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="supplier_id" class="form-control ">
                            <option value="">All Suppliers</option>
                            @foreach ($suppliers ?? [] as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-1">
                        <button type="submit" class="btn  btn-primary w-100">
                            <i class="ti ti-search"></i> Filter
                        </button>
                        <a href="{{ url()->current() }}" class="btn  btn-secondary">
                            <i class="ti ti-refresh"></i>
                        </a>
                    </div>
                </form>
            </div>
            <div class="row row-deck row-cards mt-2">
                <div class="col-12 m-0">

                    <div class="card" style="border-top: none">
                        <div class="table-responsive">
                            @include('backEnd.admin.includes.top-paginate', ['items' => $purchaseItems])
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr class="align-middle">
                                        <th class="w-1">SL.</th>
                                        <th>Product Name</th>
                                        <th>Memo / Date</th>
                                        <th>Supplier</th>
                                        <th>Available Stock</th>
                                        <th style="width: 150px;">Sale Priority</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i = 1)
                                    @if (count($purchaseItems) > 0)
                                        @foreach ($purchaseItems as $key => $item)
                                            <tr @if ($i % 2 == 0) style="background-color:#f5f5f5" @endif
                                                class="align-middle">
                                                <td class="sl-cell fw-bold">
                                                    {{ method_exists($purchaseItems, 'firstItem') ? $purchaseItems->firstItem() + ($i - 1) : $i }}.
                                                </td>
                                                <td>
                                                    <strong>{{ $item->get_product->name ?? 'N/A' }}</strong>
                                                    @if ($item->sku)
                                                        <br><small class="text-muted">SKU: {{ $item->sku }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-blue-lt">Memo:
                                                        {{ $item->get_purchase->memo_no ?? 'N/A' }}</span><br>
                                                    <small
                                                        class="text-secondary">{{ $item->get_purchase->purchase_date ?? '' }}</small>
                                                </td>
                                                <td>{{ $item->get_purchase->get_supplier->name ?? 'N/A' }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-success text-white px-2 py-1">{{ $item->stock_quantity }}</span>
                                                </td>
                                                <td>
                                                    <!-- Priority Input Field -->
                                                    <input type="number"
                                                        class="form-control form-control-sm priority-input text-center"
                                                        data-id="{{ $item->id }}" value="{{ $item->sale_priority }}">
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-primary btn-save-priority">
                                                        <i class="ti ti-check"></i> Save
                                                    </button>
                                                </td>
                                            </tr>
                                            @php($i++)
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center text-danger font-weight-bold py-4">No
                                                Items Found!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            @include('backEnd.admin.includes.bottom-paginate', ['items' => $purchaseItems])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).on('click', '.btn-save-priority', function() {
            let $row = $(this).closest('tr');
            let id = $row.find('.priority-input').data('id');
            let priority = $row.find('.priority-input').val();

            $.ajax({
                url: "{{ route('admin.stock.priority.update') }}",
                type: "POST",
                data: {
                    id: id,
                    sale_priority: priority,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: res.message,
                            timer: 1200,
                            showConfirmButton: false
                        });
                    }
                },
                error: function() {
                    alert('Something went wrong!');
                }
            });
        });
    </script>
@endpush
