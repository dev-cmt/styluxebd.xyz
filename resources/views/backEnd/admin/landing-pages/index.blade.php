@extends('backEnd.admin.layouts.master')

@section('title', 'Landing Pages')

@section('content')
    <div class="page-body mt-3">
        <div class="container-xl">
            <div class="d-flex align-items-center gap-2 justify-content-between">
                <h2 class="page-title">Landing Pages</h2>
                <div class="d-flex align-items-center gap-2">
                    <div class="d-flex align-items-center gap-1">
                        <span class="fw-bold">Total:</span>
                        <span class="badge bg-primary text-white">{{ $pages->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="card  shadow-sm  rounded border-0 mt-2">
                <div class="card-header d-flex gap-2 align-items-center py-2">
                    @can('landing.page.create')
                        <a href="{{ route('admin.landing.pages.create') }}" class="btn btn-success btn-sm add-btn gap-1">
                            <i class="ti ti-plus"></i> Add Page
                        </a>
                    @endcan
                    {{-- Clean Production Bulk Delete Button --}}
                    @can('landing.page.delete')
                        <button type="button" id="bulk_delete_btn"
                            class="btn btn-gradient-danger btn-sm d-flex align-items-center gap-1">
                            <i class="ti ti-trash"></i> Bulk Delete
                            <span id="selected_count" class="badge bg-white text-danger ms-1 d-none">0</span>
                        </button>
                    @endcan
                </div>

                <div class="table-responsive">
                    {{-- @include('backEnd.admin.includes.top-paginate', ['items' => $data]) --}}
                    <table class="table align-top card-table datatable">
                        <thead>
                            <tr class="align-middle">
                                <th class="w-1">
                                    SL. <input class="form-check-input m-0 align-middle" type="checkbox"
                                        aria-label="Select all invoices" id="master">
                                </th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Theme</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i = 1)
                            @foreach ($pages as $key => $page)
                                <tr @if ($i % 2 == 0) style="background:#f5f5f5" @endif>
                                    <td class="sl-cell">
                                        {{ $i++ }}.
                                        <input class="form-check-input m-0 align-middle sub_chk" type="checkbox"
                                            data-id="{{ $page->id }}">
                                    </td>
                                    <td>
                                        @if ($page->theme->imageFile)
                                            <img src="{{ asset($page->theme->imageFile->file_url) }}" width="80"
                                                class="rounded">
                                        @else
                                            <img src="https://placehold.co/300x250?text=No+Image" width="80"
                                                class="rounded">
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('landing-theme.home', $page->slug) }}" target="_blank">
                                            {{ $page->title }}
                                        </a>
                                    </td>
                                    <td>{{ $page->theme->title ?? '-' }}</td>
                                    <td>{{ $page->status ? 'Active' : 'Inactive' }}</td>
                                    <td class="w-1">
                                        <a href="{{ route('admin.landing.pages.customize', $page->slug) }}"
                                            class="btn-gradient-primary padding-2-6  border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1"
                                            target="_blank">
                                            <i class="ti ti-brush"></i> Customize
                                        </a>
                                        <a href="{{ route('admin.landing.pages.edit', $page->id) }}"
                                            class="btn-gradient-info padding-2-6 border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1">
                                            <i class="ti ti-edit"></i> Edit
                                        </a>
                                        <a href="{{ route('admin.landing.pages.delete', $page->id) }}"
                                            class="btn-gradient-danger padding-2-6 border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1"
                                            onclick="return confirm('Delete this?')">
                                            <i class="ti ti-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

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
                            url: "{{ route('admin.landing.pages.bulk-delete') }}",
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
