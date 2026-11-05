@extends('backEnd.admin.layouts.master')
@section('title')
    Receive Purchase List
@endsection

@section('content')
    <div class="page-body mt-3">
        <div class="container-xl">
            <div class="row">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h2 class="page-title">Receive Purchase List</h2>
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center gap-1">
                            <span class="fw-bold">Total:</span>
                            <span class="badge bg-primary text-white">{{ $data->total() }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-deck row-cards mt-2">
                <!-- Page Header Close -->
                <div class="col-12 m-0">
                    <div class="card" style="border-top:none">
                        <div class="card-header d-flex  align-items-center gap-2 py-2">
                            @can('purchases.create')
                                <a href="{{ route('admin.purchase.create') }}" class="btn btn-success btn-sm add_supplier">
                                    <i class="ti ti-plus"></i>
                                    Add Purchase</a>
                            @endcan
                            {{-- Clean Production Bulk Delete Button --}}
                            {{-- <button type="button" id="bulk_delete_btn"
                                class="btn btn-gradient-danger btn-sm d-flex align-items-center gap-1">
                                <i class="ti ti-trash"></i> Bulk Delete
                                <span id="selected_count" class="badge bg-white text-danger ms-1 d-none">0</span>
                            </button> --}}

                        </div>
                        <div class="table-responsive">
                            @include('backEnd.admin.includes.top-paginate', ['items' => $data])
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr class="align-middle">
                                        <th class="w-1">
                                            SL. <input class="form-check-input m-0 align-middle" type="checkbox"
                                                aria-label="Select all invoices" id="master">
                                        </th>
                                        <th>Details Info</th>
                                        <th>Purchase Items</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data) > 0)
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($data as $key => $item)
                                            <tr @if ($key + (1 % 2) == 0) style="background-color:#f5f5f5" @endif>
                                                <td class="sl-cell">
                                                    {{ $i++ }}.
                                                    <input class="form-check-input m-0 align-middle sub_chk" type="checkbox"
                                                        data-id="{{ $item->id }}">
                                                </td>
                                                <!-- Lot / Voucher & Supplier Info Column -->
                                                <td>
                                                    <div class="d-flex flex-column gap-1">
                                                        <div>
                                                            <span class="fw-bold text-dark"><i
                                                                    class="ti ti-receipt"></i></span>
                                                            <span
                                                                class="text-primary fw-semibold">{{ $item->memo_no ?? 'N/A' }}</span>
                                                            <br>

                                                            <span class="text-muted"><i class="ti ti-calendar"></i>
                                                                {{ date('d M Y', strtotime($item->purchase_date)) }}</span>
                                                        </div>
                                                        <div>
                                                            <span class="fw-bold text-dark"><i
                                                                    class="ti ti-user"></i></span>
                                                            <span
                                                                class="text-primary fw-semibold">{{ $item->get_supplier->name ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-top">
                                                    <table class="table table-sm table-bordered mb-0"
                                                        style="font-size: 11px;">
                                                        <thead>
                                                            <tr class="table-light">
                                                                <th>Product Name</th>
                                                                <th class="text-center">Ord</th>
                                                                <th class="text-center">Rec</th>
                                                                <th class="text-center">Rem</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($item->get_purchase_items as $purchaseItem)
                                                                @php
                                                                    $ordered = $purchaseItem->ordered_quantity;
                                                                    $received = $purchaseItem->received_quantity ?? 0;
                                                                    $remaining = $ordered - $received;
                                                                @endphp
                                                                <tr>
                                                                    <td>
                                                                        {{ $purchaseItem->get_product->name ?? 'Product' }}
                                                                        @if ($purchaseItem->sku)
                                                                            <small
                                                                                class="text-muted">({{ $purchaseItem->sku }})</small>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center fw-bold text-primary">
                                                                        {{ $ordered }}</td>
                                                                    <td class="text-center">
                                                                        <span
                                                                            class="badge bg-success  px-1">{{ $received }}</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span
                                                                            class="badge bg-danger  px-1">{{ $remaining }}</span>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td>
                                                    <div class="p-2 border rounded bg-light">
                                                        <div class="d-flex justify-content-between mb-1">
                                                            <span class="text-muted">Subtotal:</span>
                                                            <strong
                                                                class="text-muted">{{ $web_settings->currency_sign }}{{ number_format($item->subtotal, 2, '.', '') }}</strong>
                                                        </div>
                                                        <div class="d-flex justify-content-between mb-1">
                                                            <span class="text-danger">Discount (−):</span>
                                                            <strong
                                                                class="text-danger">{{ $web_settings->currency_sign }}{{ number_format($item->discount, 2, '.', '') }}</strong>
                                                        </div>
                                                        <div class="d-flex justify-content-between mb-1">
                                                            <span class="text-success">Tax (+):</span>
                                                            <strong
                                                                class="text-success">{{ $web_settings->currency_sign }}{{ number_format($item->tax, 2, '.', '') }}</strong>
                                                        </div>
                                                        <div class="d-flex justify-content-between mb-1">
                                                            <span class="text-info">Shipping (+):</span>
                                                            <strong
                                                                class="text-info">{{ $web_settings->currency_sign }}{{ number_format($item->shipping_cost, 2, '.', '') }}</strong>
                                                        </div>
                                                        <div class="d-flex justify-content-between mb-1">
                                                            <span class="text-warning">Due:</span>
                                                            <strong
                                                                class="text-warning">{{ $web_settings->currency_sign }}{{ number_format($item->due_amount, 2, '.', '') }}</strong>
                                                        </div>
                                                        {{-- paid --}}
                                                        <div class="d-flex justify-content-between mb-1">
                                                            <span class="text-primary">Paid:</span>
                                                            <strong
                                                                class="text-primary">{{ $web_settings->currency_sign }}{{ number_format($item->paid_amount, 2, '.', '') }}</strong>
                                                        </div>

                                                        <hr class="my-1">
                                                        <div class="d-flex justify-content-between">
                                                            <span class="fw-bold text-dark">Total:</span>
                                                            <span
                                                                class="fw-bold text-dark">{{ $web_settings->currency_sign }}{{ number_format($item->total, 2, '.', '') }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($item->status == 'ordered')
                                                        <span class="badge bg-warning">Ordered</span>
                                                    @elseif($item->status == 'received')
                                                        <span class="badge bg-success">Received</span>
                                                    @elseif($item->status == 'partial')
                                                        <span class="badge bg-info">Partial</span>
                                                    @endif
                                                </td>
                                                <td class="w-1">
                                                    {{-- recieve button --}}
                                                    @if ($item->status == 'ordered' || $item->status == 'partial')
                                                        <a href="{{ route('admin.purchase.receive.modal', $item->id) }}"
                                                            class="btn btn-sm btn-primary open-receive-modal">
                                                            <i class="ti ti-check me-1"></i> Receive
                                                        </a>
                                                    @elseif ($item->status == 'received')
                                                        {{-- @can('purchases.receive') --}}
                                                        <span
                                                            class="btn-gradient-success  padding-2-6 border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1">
                                                            <i class="ti ti-check"></i> Received
                                                        </span>
                                                        {{-- @endcan --}}
                                                    @endif


                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" class="text-center"> <span class="text-danger"><b>No data
                                                        found.</b></span></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            @include('backEnd.admin.includes.bottom-paginate', ['items' => $data])
                        </div>

                        {{-- <div>
                            {{ $data->links('backEnd.admin.includes.paginate') }}

                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Container -->
    <div class="modal fade" id="receiveModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content" id="receiveModalContent">
                <!-- AJAX Content will load here -->
            </div>
        </div>
    </div>

@endsection
@push('js')
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
                            url: "{{ route('admin.purchase.bulk.delete') }}",
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
    <script>
        $(document).on('click', '.open-receive-modal', function(e) {
            // alert('clicked');
            e.preventDefault();
            let url = $(this).attr('href');
            // alert(url);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    $('#receiveModalContent').html(response);
                    $('#receiveModal').modal('show');
                },
                error: function() {
                    alert('Failed to load data.');
                }
            });
        });

        // Max button & calculation logic inside modal
        $(document).on('click', '.btn-max', function() {
            let input = $(this).siblings('.receive-now-input');
            let max = input.data('remaining');
            input.val(max);
        });

        // Validation for Receive Now input (Cannot exceed remaining)
        $(document).on('keyup change', '.receive-now-input', function() {
            let max = parseInt($(this).data('remaining')) || 0;
            let val = parseInt($(this).val()) || 0;

            if (val > max) {
                $(this).val(max);
            } else if (val < 0) {
                $(this).val(0);
            }
        });



        // Receive Update Button Click Handler
        $(document).on('click', '#btnReceiveUpdate', function() {
            let formData = $('#receiveUpdateForm').serialize();

            // Disable button to prevent double click
            let $btn = $(this);
            $btn.prop('disabled', true).html('<i class="ti ti-loader"></i> Updating...');

            $.ajax({
                url: "{{ route('admin.purchase.receive.update') }}", // আপনার রাউট নাম অনুযায়ী দিন
                type: "POST",
                data: formData,
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            $('#receiveModal').modal('hide');
                            location.reload(); // পেজ রিফ্রেশ করে আপডেট দেখাবে
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: res.message || 'Something went wrong!',
                        });
                        $btn.prop('disabled', false).html('<i class="ti ti-check"></i> Receive Update');
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: xhr.responseJSON?.message || 'Failed to process request.',
                    });
                    $btn.prop('disabled', false).html('<i class="ti ti-check"></i> Receive Update');
                }
            });
        });
    </script>
@endpush
