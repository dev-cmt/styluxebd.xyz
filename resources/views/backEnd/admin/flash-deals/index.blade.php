@extends('backEnd.admin.layouts.master')

@section('title')
    Flash Deals
@endsection

@section('content')
    <div class="page-body mt-3">
        <div class="container-xl">

            <div class="row">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h2 class="page-title">Flash Deal List</h2>
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center gap-1">
                            <span class="fw-bold">Total:</span>
                            <span class="badge bg-primary text-white">{{ $deals->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row row-deck row-cards mt-2 product-index">
                <div class="col-12 m-0">
                    <div class="card  shadow-sm  rounded" style="border-top: none">
                        <div class=" card-header bg-white border-bottom py-2 px-3 action-btn d-flex gap-2">
                            @can('flash.deal.create')
                                <a href="{{ route('admin.flash.deal.create') }}" class="btn btn-success btn-sm">
                                    <i class="ti ti-plus" style="margin-bottom:2px"></i> Add Flash Deal
                                </a>
                            @endcan
                            {{-- Clean Production Bulk Delete Button --}}
                            @can('flash.deal.delete')
                                <button type="button" id="bulk_delete_btn"
                                    class="btn btn-gradient-danger btn-sm d-flex align-items-center gap-1">
                                    <i class="ti ti-trash"></i> Bulk Delete
                                    <span id="selected_count" class="badge bg-white text-danger ms-1 d-none">0</span>
                                </button>
                            @endcan
                        </div>
                        <div class="table-responsive order_table">

                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr class="align-middle">
                                        <th class="w-1">
                                            SL. <input class="form-check-input m-0 align-middle" type="checkbox"
                                                aria-label="Select all invoices" id="master">
                                        </th>
                                        <th>Title</th>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th>Status</th>
                                        <th>Products</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php($i = 1)
                                    @if ($deals->count() > 0)
                                        @foreach ($deals as $deal)
                                            <tr class="deal-row{{ $deal->id }}"
                                                @if ($i % 2 == 0) style="background:#f5f5f5" @endif>

                                                <td class="sl-cell">
                                                    {{ $i++ }}.
                                                    <input class="form-check-input m-0 align-middle sub_chk" type="checkbox"
                                                        data-id="{{ $deal->id }}">
                                                </td>

                                                <td>{{ $deal->title }}</td>

                                                <td>{{ $deal->start_time->format('d M Y — h:i A') }}</td>

                                                <td>{{ $deal->end_time->format('d M Y — h:i A') }}</td>

                                                <td>
                                                    <form action="{{ route('admin.flash.deal.toggle', $deal->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button
                                                            class="btn btn-sm {{ $deal->status ? 'btn-success' : 'btn-secondary' }} padding-2-6">
                                                            {{ $deal->status ? 'Active' : 'Inactive' }}
                                                        </button>
                                                    </form>
                                                </td>

                                                <td>{{ $deal->products->count() }}</td>

                                                <td class="w-1">
                                                    @can('flash.deal.edit')
                                                        <a href="{{ route('admin.flash.deal.edit', $deal->id) }}"
                                                            class="btn-gradient-info padding-2-6  border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1">
                                                            <i class="ti ti-edit"></i> Edit
                                                        </a>
                                                    @endcan
                                                    @can('flash.deal.create')
                                                        <form action="{{ route('admin.flash.deal.destroy', $deal->id) }}"
                                                            method="POST" onsubmit="return confirm('Are you sure?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn-gradient-danger padding-2-6  border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1">
                                                                <i class="ti ti-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center text-danger fw-bold">
                                                No Flash Deals Found!
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            {{-- Pagination --}}
                            {{-- {{ $deals->links('backEnd.admin.includes.paginate') }} --}}

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
                            url: "{{ route('admin.flash.deals.bulk.delete') }}",
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
