@extends('backEnd.admin.layouts.master')

@section('title')
    Combo Products
@endsection
@section('content')

    <div class="page-body mt-3">
        <div class="container-xl">
            <div class="row">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h2 class="page-title">
                        Combo Products
                    </h2>
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center gap-1">
                            <span class="fw-bold">Total:</span>
                            <span class="badge bg-primary text-white">{{ $products->total() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row row-deck row-cards mt-2 product-index">
                <div class="col-12 m-0">
                    <div class="card  shadow-sm  rounded" style="border-top: none">
                        <div class=" card-header bg-white border-bottom py-2 px-3 d-flex gap-2 align-items-center">
                            @can('products.combo.create')
                                <a href="{{ route('admin.combo-products.create') }}" class="btn btn-success btn-sm">
                                    <i class="ti ti-plus"></i>
                                    Add Combo Product</a>
                            @endcan
                            @can('products.combo.delete')
                                <button type="button" id="bulk_delete_btn"
                                    class="btn btn-gradient-danger btn-sm d-flex align-items-center gap-1">
                                    <i class="ti ti-trash"></i> Bulk Delete
                                    <span id="selected_count" class="badge bg-white text-danger ms-1 d-none">0</span>
                                </button>
                            @endcan

                        </div>
                        <div class="table-responsive order_table">
                            @include('backEnd.admin.includes.top-paginate', ['items' => $products])
                            <table class="table table-vcenter card-table order-table">
                                <thead>
                                    <tr class="align-middle">
                                        <th class="w-1">
                                            <span>SL.</span>
                                            <input class="form-check-input m-0 align-middle" type="checkbox"
                                                aria-label="Select all invoices" id="master">
                                        </th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Category Name</th>
                                        <th>Items</th>
                                        {{-- <th>Stock</th> --}}
                                        <th>Prices</th>
                                        <th>Status</th>
                                        {{-- <th>Free Shipping</th> --}}
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i = 1)
                                    @if ($products->count() > 0)
                                        {{-- @dd($products) --}}
                                        @foreach ($products as $item)
                                            {{-- @dd($item) --}}
                                            {{-- @dd($item->comboItems) --}}
                                            <tr class="custom-tr"
                                                @if ($i % 2 == 0) style="background-color:#f5f5f5" @endif>
                                                <td class="sl-cell">
                                                    {{ $i++ }}.
                                                    <input class="form-check-input m-0 align-middle sub_chk" type="checkbox"
                                                        data-id="{{ $item->id }}">
                                                </td>
                                                {{-- <td>
                                                    <img width="60"
                                                        src="{{ $item->get_thumb ? asset($item->get_thumb->file_url) : asset('frontEnd/images/no-image.jpg') }}"
                                                        alt="">
                                                </td> --}}
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
                                                <td class="text-truncate" style="max-width: 300px">
                                                    <a href="{{ route('single.product', $item->slug) }}"
                                                        style="font-size: 14px;color: #000;font-weight: 600;">
                                                        {{ $item->name }} </a> <br>

                                                </td>
                                                <td style="width:20%">
                                                    @foreach ($item->get_categories as $key => $cat)
                                                        {{ $key != 0 ? ', ' : '' }}
                                                        {{ $cat->category_name }}
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($item->comboItems as $key => $comboItem)
                                                        <?php
                                                        $childProduct = $comboItem->product;
                                                        $childStock = $childProduct ? $childProduct->stock : 0;
                                                        ?>

                                                        @if ($loop->first)
                                                            <strong>{{ $childProduct->name ?? '' }}</strong>
                                                            (Qty: {{ $comboItem->quantity ?? 1 }})
                                                            <span class="badge bg-secondary text-white"
                                                                style="font-size: 10px;">Stock: {{ $childStock }}</span>
                                                        @else
                                                            <br>
                                                            <strong>{{ $childProduct->name ?? '' }}</strong>
                                                            (Qty: {{ $comboItem->quantity ?? 1 }})
                                                            <span class="badge bg-secondary text-white"
                                                                style="font-size: 10px;">Stock: {{ $childStock }}</span>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                {{-- <td>{{ $item->sku }}</td> --}}
                                                {{-- <td>{{ $item->stock }}</td> --}}
                                                {{-- <td>{{ $web_settings->currency_sign }} {{ $item->price }}</td> --}}
                                                <td>

                                                    <strong>Regular Price: </strong>{{ $web_settings->currency_sign }}
                                                    {{ formatNumber($item->regular_price) }}
                                                    <br>
                                                    <strong>Sale Price: </strong>{{ $web_settings->currency_sign }}
                                                    {{ formatNumber($item->sale_price) }}
                                                    <br>
                                                    {{-- <strong>Purchase Price: </strong>{{ $web_settings->currency_sign }}
                                                    {{ formatNumber(
                                                        $item->comboItems->sum(function ($comboItem) {
                                                            return $comboItem->product->purchase_price * $comboItem->quantity;
                                                        }),
                                                    ) }} --}}
                                                    <br>


                                                </td>

                                                <td>
                                                    @if ($item->status == 1)
                                                        <a href="{{ route('admin.product.status', $item->id) }}"
                                                            class="badge bg-success"
                                                            onclick="return confirm('Are You Sure To Change This?')">
                                                            Published
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.product.status', $item->id) }}"
                                                            class="badge bg-danger"
                                                            onclick="return confirm('Are You Sure To Change This?')">
                                                            Unpublished
                                                        </a>
                                                    @endif
                                                </td>
                                                {{-- <td>
                                                    <input type="checkbox" hidden="hidden" data-id="{{ $item->id }}"
                                                        id="username-{{ $item->id }}" class="free_shiiping"
                                                        {{ $item->free_shipping == 1 ? 'checked' : '' }}>
                                                    <label class="switch" for="username-{{ $item->id }}"></label>
                                                </td> --}}
                                                <td class="w-1">
                                                    @can('products.combo.edit')
                                                        <a href="{{ route('admin.combo-products.edit', $item->id) }}"
                                                            class="btn-gradient-info padding-2-6 border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1 edit-btn">
                                                            <i class="ti ti-edit"></i>
                                                            Edit
                                                        </a>
                                                    @endcan
                                                    @can('products.combo.delete')
                                                        <a href="{{ route('admin.product.delete', $item->id) }}"
                                                            onclick="return confirm('Are You Sure To Delete This?')"
                                                            class="btn-gradient-danger padding-2-6 border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1">
                                                            <i class="ti ti-trash"></i>
                                                            Delete
                                                        </a>
                                                    @endcan

                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="11" class="text-center text-danger font-weight-bold">No
                                                products Found!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            @include('backEnd.admin.includes.bottom-paginate', ['items' => $products])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
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
        $(document).ready(function() {

            // ১. Master Checkbox Toggle
            $(document).on('change', '#master', function() {
                let isChecked = $(this).is(':checked');
                $('.sub_chk').prop('checked', isChecked).trigger('change');
            });

            // ২. Row Selection & Badge Update Logic
            $(document).on('change', '.sub_chk', function() {
                let $row = $(this).closest('tr');

                // Check/Uncheck UI highlight
                if ($(this).is(':checked')) {
                    $row.addClass('table-primary');
                } else {
                    $row.removeClass('table-primary');
                    $('#master').prop('checked', false);
                }

                // Count Update
                let totalChecked = $('.sub_chk:checked').length;
                if (totalChecked > 0) {
                    $('#selected_count').removeClass('d-none').text(totalChecked);
                } else {
                    $('#selected_count').addClass('d-none').text(0);
                }
            });

            // ৩. Bulk Delete Action with SweetAlert2 & AJAX
            $(document).on('click', '#bulk_delete_btn', function(e) {
                e.preventDefault();

                let selectedIds = [];
                $('.sub_chk:checked').each(function() {
                    selectedIds.push($(this).data('id'));
                });

                // যদি কোনো চেকবাক্স সিলেক্ট না থাকে
                if (selectedIds.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Items Selected',
                        text: 'Please select at least one item to delete.',
                        confirmButtonColor: '#0054a6'
                    });
                    return;
                }

                // Confirmation Alert
                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete ${selectedIds.length} item(s)! This cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, Delete All',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Loader Alert
                        Swal.fire({
                            title: 'Deleting...',
                            text: 'Please wait while we delete selected items.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // AJAX Request
                        $.ajax({
                            url: "{{ route('admin.combo-products.bulk-delete') }}",
                            type: "POST",
                            data: {
                                ids: selectedIds,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                if (res.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: res.message,
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        // Reload or DOM remove (Reload safer for pagination count)
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Failed',
                                        text: res.message ||
                                            'Something went wrong!',
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Server Error',
                                    text: xhr.responseJSON?.message ||
                                        'Failed to process request. Please try again.',
                                });
                            }
                        });
                    }
                });
            });

        });
    </script>
@endpush
