@extends('backEnd.admin.layouts.master')
@section('title')
    Incomplete Orders
@endsection
@php
    $theme = App\Theme::where('status', 1)->first();
@endphp
@section('css')
    <style>
        .row>* {
            padding-right: calc(var(--tblr-gutter-x) * .4);
            padding-left: calc(var(--tblr-gutter-x) * .4);
        }
    </style>
@endsection
@section('content')
    <div class="page-body mt-3">
        <div class="container-xl">
            <div class="row">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h2 class="page-title"> Incomplete Orders</h2>
                    {{-- total cart --}}
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
                        <div
                            class="d-flex card-header py-2 bg-white m-0 border-bottom justify-content-between align-items-center">

                            {{-- LEFT: Bulk Order --}}
                            {{-- LEFT: Bulk Action Buttons --}}
                            <div class="d-flex gap-2 align-items-center">
                                @can('abandoned.order.create')
                                    <button id="bulkOrderBtn" class="btn btn-sm btn-success  d-flex align-items-center gap-1">
                                        <i class="ti ti-shopping-cart"></i> Bulk Create Order
                                    </button>
                                @endcan

                                {{-- Clean Production Bulk Delete Button --}}
                                @can('abandoned.order.delete')
                                    <button type="button" id="bulk_delete_btn"
                                        class="btn btn-gradient-danger btn-sm d-flex align-items-center gap-1">
                                        <i class="ti ti-trash"></i> Bulk Delete
                                        <span id="selected_count" class="badge bg-white text-danger ms-1 d-none">0</span>
                                    </button>
                                @endcan
                            </div>

                            {{-- RIGHT: Search --}}
                            <form method="GET" action="{{ route('admin.abandoned.cart') }}"
                                class="d-flex align-items-center gap-2 premium-form">

                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control form-control-sm search-input  cool-select"
                                    placeholder="Search by phone or customer name" autocomplete="off">
                                <button type="submit"
                                    class="btn btn-gradient-success btn-sm d-flex align-items-center gap-1">
                                    <i class="ti ti-search"></i>
                                </button>

                                @if (request('search'))
                                    <a class="btn btn-gradient-dark btn-sm d-flex align-items-center gap-1"
                                        href="{{ route('admin.abandoned.cart') }}">
                                        Reset
                                    </a>
                                @endif
                            </form>

                        </div>

                        {{-- <div>
                            {{ $data->links('backEnd.admin.includes.paginate') }}
                        </div> --}}
                        <div class="table-responsive">
                            @include('backEnd.admin.includes.top-paginate', ['items' => $data])
                            <table class="table align-top card-table datatable">
                                <thead>
                                    <tr class="align-middle">
                                        <th class="w-1">
                                            SL. <input class="form-check-input m-0 align-middle" type="checkbox"
                                                aria-label="Select all invoices" id="master">
                                        </th>
                                        <th>Date</th>
                                        <th>Customer Info</th>
                                        <th>Products</th>
                                        <th>Amount</th>
                                        <th>Note</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i = 1)
                                    @if (count($data) > 0)
                                        @foreach ($data as $item)
                                            <tr id="tr_{{ $item->id }}"
                                                @if ($i % 2 == 0) style="background-color:#f5f5f5" @endif>
                                                <td class="sl-cell">
                                                    {{ $i++ }}.
                                                    <input class="form-check-input m-0 align-middle sub_chk" type="checkbox"
                                                        data-id="{{ $item->id }}">
                                                </td>
                                                <td class="text-wrap" align="justify" width="8%">
                                                    {{ date('d-m-Y h:i:s A', strtotime($item->created_at)) }}
                                                </td>

                                                <td style="width: 15%;">
                                                    <div class="customer-info-section d-flex flex-column gap-1">

                                                        {{-- <!-- Device ID -->
                                               <div class="d-flex align-items-center text-muted small" title="Device ID"
                                                   style="font-size: 0.82rem;">
                                                   <i
                                                       class="ti ti-device-laptop fs-5 me-2 text-secondary flex-shrink-0"></i>
                                                   <span
                                                       class="font-monospace text-dark">{{ $item->device_id ?? '--' }}</span>
                                               </div>

                                               <!-- IP Address -->
                                               <div class="d-flex align-items-center text-muted small"
                                                   title="IP Address" style="font-size: 0.82rem;">
                                                   <i class="ti ti-network fs-5 me-2 text-secondary flex-shrink-0"></i>
                                                   <span
                                                       class="font-monospace text-dark">{{ $item->ip_address ?? '--' }}</span>
                                               </div> --}}

                                                        <!-- Customer Name -->
                                                        <div class="d-flex align-items-center text-dark fw-semibold"
                                                            title="Customer Name" style="font-size: 0.88rem;">
                                                            <i class="ti ti-user fs-5 me-2 text-primary flex-shrink-0"></i>
                                                            <span
                                                                class="text-truncate">{{ $item->customer_name ?? 'N/A' }}</span>
                                                        </div>

                                                        <!-- Phone Number & Direct Call -->
                                                        <div class="d-flex align-items-center gap-1" title="Customer Phone"
                                                            style="font-size: 0.85rem;">
                                                            <i class="ti ti-phone fs-5 me-2 text-success flex-shrink-0"></i>

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
                                                <td class="text-wrap" width="30%">
                                                    <div class="d-flex flex-column gap-2">
                                                        @foreach (json_decode($item->abandoned_item, true) as $key => $abandoned_item)
                                                            <?php
                                                            $product = \App\Product::with(['get_thumb'])->find($abandoned_item['product_id']);
                                                            ?>

                                                            @if ($product)
                                                                <div
                                                                    class="d-flex align-items-start gap-2 p-2 rounded hover-bg-light  transition-all">

                                                                    <!-- Product Image / Placeholder -->
                                                                    <div class="flex-shrink-0 position-relative">
                                                                        <?php
                                                                        $thumbUrl = $product->get_thumb->file_url ?? null;
                                                                        ?>

                                                                        @if ($thumbUrl)
                                                                            <img src="{{ asset($thumbUrl) }}"
                                                                                alt="{{ $product->name }}"
                                                                                class="image-modal-trigger rounded border object-fit-cover shadow-xs cursor-pointer"
                                                                                style="width: 45px; height: 45px;"
                                                                                data-src="{{ asset($thumbUrl) }}"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#imageModal"
                                                                                title="Click to view image">
                                                                        @else
                                                                            <div class=" border rounded d-flex align-items-center justify-content-center text-muted"
                                                                                style="width: 45px; height: 45px;"
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
                                                                                {{ $abandoned_item['qty'] }}x
                                                                            </span>

                                                                            <a href="{{ route('single.product', $product->slug) }}"
                                                                                target="_blank"
                                                                                class="text-dark fw-medium text-truncate text-decoration-none lh-sm flex-grow-1"
                                                                                style="max-width: 220px; font-size: 0.85rem;"
                                                                                title="{{ $product->name }}">
                                                                                {{ $product->name }}
                                                                            </a>
                                                                        </div>

                                                                        <!-- SKU & Variants Row -->
                                                                        <div class="d-flex align-items-center flex-wrap gap-1 mt-1"
                                                                            style="font-size: 0.78rem;">
                                                                            @if ($product->sku)
                                                                                <span
                                                                                    class="text-muted font-monospace me-1">
                                                                                    SKU: <strong
                                                                                        class="text-secondary">{{ $product->sku }}</strong>
                                                                                </span>
                                                                            @endif

                                                                            <!-- Dynamic Attributes / Variants -->
                                                                            @if (!empty($abandoned_item['variant']))
                                                                                <?php
                                                                                $ids = explode('-', $abandoned_item['variant']);
                                                                                $attributes = \App\AttributeItem::with('attribute')->whereIn('id', $ids)->get();
                                                                                ?>

                                                                                <div class="d-inline-flex gap-1 flex-wrap">
                                                                                    @foreach ($attributes as $v_item)
                                                                                        <span
                                                                                            class="badge bg-primary  border border-primary-subtle font-weight-normal px-1 py-0"
                                                                                            style="font-size: 0.70rem;">
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
                                                <td>
                                                    <!-- Total -->
                                                    <div class="d-flex align-items-center fw-bold">
                                                        <span class="text-dark">Total:</span>
                                                        <span
                                                            class="text-dark">{{ 0 + number_format($item->total, 2, '.', '') }}</span>
                                                    </div>
                                                </td>
                                                <td class="text-wrap note-cell" width="20%"
                                                    data-id="{{ $item->id }}" data-note="{{ $item->note ?? '' }}">
                                                    {{--                                                    <span class="note-text {{ $item->note ?: 'btn btn-sm btn-outline-danger' }}">{{ $item->note ?: 'Double click to add note' }}</span> --}}
                                                    <span class="note-text" title="Double click to edit note"
                                                        style="cursor:pointer;">
                                                        {{ $item->note ?: 'Double click to add note' }}
                                                        <i class="ti ti-pencil ms-1 text-danger"></i>
                                                    </span>
                                                    <div class="note-edit d-none">
                                                        <textarea class="form-control form-control-sm note-input" rows="2"></textarea>

                                                        <div class="mt-1 text-end">
                                                            <i class="ti ti-check text-success note-save"
                                                                style="cursor:pointer;font-size:18px"></i>
                                                            <i class="ti ti-x text-danger note-cancel ms-2"
                                                                style="cursor:pointer;font-size:18px"></i>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="text-wrap" width="10%">
                                                    @can('abandoned.order.create')
                                                        <a href="{{ route('admin.abandoned.cart.create.order', $item->id) }}"
                                                            class="btn-gradient-success padding-2-6  border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1">
                                                            <i class="ti ti-shopping-cart"></i> Create Order
                                                        </a>
                                                    @endcan
                                                    @can('abandoned.order.delete')
                                                        <a href="{{ route('admin.abandoned.cart.delete', $item->id) }}"
                                                            onclick="return confirm('Are You Sure?')"
                                                            class="btn-gradient-danger padding-2-6  border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1">
                                                            <i class="ti ti-trash"></i> Delete
                                                        </a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="11" class="text-danger text-center fw-bold">No Data Found !
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            @include('backEnd.admin.includes.bottom-paginate', ['items' => $data])
                        </div>
                        {{--
                        <div>
                            {{ $data->links('backEnd.admin.includes.paginate') }}
                        </div> --}}
                    </div>
                </div>
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

@endsection
@push('js')
    <script>
        $(document).on('change', '#master', function() {
            $('.sub_chk').prop('checked', $(this).is(':checked'));
        });
    </script>
    <script>
        $(document).on('click', '#bulkOrderBtn', function() {
            let selectedIds = [];

            $('.sub_chk:checked').each(function() {
                selectedIds.push($(this).closest('tr').attr('id').replace('tr_', ''));
            });

            if (selectedIds.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No cart selected',
                    text: 'Please select at least one abandoned cart.',
                    timer: 1000,
                    showConfirmButton: false
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "Orders will be created for selected carts!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, create orders',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#198754',
                cancelButtonColor: '#dc3545',
                reverseButtons: true
            }).then((result) => {

                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Creating orders, please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: "{{ route('admin.abandoned.cart.bulk.create.order') }}",
                        type: "POST",
                        data: {
                            ids: selectedIds,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            if (res.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: res.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed',
                                    text: 'Something went wrong!',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Server Error',
                                text: 'Please try again later.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let phoneMap = {};

            $('.datatable tbody tr').each(function() {
                let phone = $(this).find('.phone-number')
                    .clone()
                    .children()
                    .remove()
                    .end()
                    .text()
                    .trim();

                if (!phone) return;

                if (!phoneMap[phone]) {
                    phoneMap[phone] = [];
                }
                phoneMap[phone].push(this);
            });

            $.each(phoneMap, function(phone, rows) {
                if (rows.length > 1) {
                    $(rows).css('background-color', '#f3c2c2');
                }
            });
        });
    </script>
    <script>
        /* Double click → edit */
        $(document).on('dblclick', '.note-cell', function() {
            let cell = $(this);

            cell.find('.note-text').addClass('d-none');
            cell.find('.note-edit').removeClass('d-none');

            let note = cell.data('note');
            cell.find('.note-input').val(note).focus();
        });

        /* Cancel edit */
        $(document).on('click', '.note-cancel', function() {
            let cell = $(this).closest('.note-cell');

            cell.find('.note-edit').addClass('d-none');
            cell.find('.note-text').removeClass('d-none');
        });

        /* Save note */
        $(document).on('click', '.note-save', function() {
            let cell = $(this).closest('.note-cell');
            let id = cell.data('id');
            let note = cell.find('.note-input').val();

            $.ajax({
                url: "{{ route('admin.abandoned.cart.update.note') }}",
                type: "POST",
                data: {
                    id: id,
                    note: note,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.success) {

                        cell.data('note', res.note);

                        cell.find('.note-text')
                            .text(res.note ? res.note : 'Double click to add note')
                            .css('background-color', '#d1e7dd'); // light green

                        cell.find('.note-edit').addClass('d-none');
                        cell.find('.note-text').removeClass('d-none');

                        // remove highlight after 1s
                        setTimeout(function() {
                            cell.find('.note-text').css('background-color', 'transparent');
                        }, 1000);
                    }
                }
            });
        });
    </script>
    <script>
        /* Double click → edit */
        $(document).on('dblclick', '.editable', function() {
            let box = $(this);

            box.find('.editable-text').addClass('d-none');
            box.find('.editable-edit').removeClass('d-none');

            let value = box.data('value');
            box.find('.editable-input').val(value).focus();
        });

        /* Cancel */
        $(document).on('click', '.editable-cancel', function() {
            let box = $(this).closest('.editable');

            box.find('.editable-edit').addClass('d-none');
            box.find('.editable-text').removeClass('d-none');
        });

        /* Save */
        $(document).on('click', '.editable-save', function() {
            let box = $(this).closest('.editable');
            let cell = box.closest('.customer-cell');

            let id = cell.data('id');
            let field = box.data('field');
            let value = box.find('.editable-input').val();

            $.ajax({
                url: "{{ route('admin.abandoned.cart.update.field') }}",
                type: "POST",
                data: {
                    id: id,
                    field: field,
                    value: value,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.success) {
                        box.data('value', value);

                        box.find('.editable-text')
                            .contents()
                            .filter(function() {
                                return this.nodeType === 3;
                            })
                            .remove();

                        box.find('.editable-text')
                            .prepend(' ' + (value || 'Click to add'))
                            .css('background-color', '#d1e7dd');

                        box.find('.editable-edit').addClass('d-none');
                        box.find('.editable-text').removeClass('d-none');

                        setTimeout(() => {
                            box.find('.editable-text').css('background-color', 'transparent');
                        }, 1000);
                    }
                }
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
                            url: "{{ route('admin.abandoned.cart.bulk.delete') }}",
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
