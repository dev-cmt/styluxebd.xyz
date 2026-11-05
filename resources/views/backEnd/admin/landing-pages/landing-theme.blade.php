@extends('backEnd.admin.layouts.master')

@section('title', 'Landing Themes')

@section('content')
    {{-- <div class="page-body mt-3">
        <div class="container-xl">
            <div class="mt-3 d-print-none">

                <h3>Landing Themes</h3>

                <button class="btn btn-success btn-sm add-btn">
                    <i class="ti ti-plus"></i> Add Theme
                </button> --}}
    <div class="page-body mt-3">
        <div class="container-xl">
            <div class="d-flex align-items-center gap-2 justify-content-between">
                <h2 class="page-title">Landing Themes</h2>
                <div class="d-flex align-items-center gap-2">
                    <div class="d-flex align-items-center gap-1">
                        <span class="fw-bold">Total:</span>
                        <span class="badge bg-primary text-white">{{ $themes->count() }}</span>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm  rounded border-0 mt-2">
                <div class="card-header d-flex gap-2 align-items-center py-2">
                    <button class="btn btn-success btn-sm add-btn gap-1">
                        <i class="ti ti-plus"></i> Add Theme
                    </button>
                    {{-- Clean Production Bulk Delete Button --}}
                    <button type="button" id="bulk_delete_btn"
                        class="btn btn-gradient-danger btn-sm d-flex align-items-center gap-1">
                        <i class="ti ti-trash"></i> Bulk Delete
                        <span id="selected_count" class="badge bg-white text-danger ms-1 d-none">0</span>
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table align-top card-table datatable">
                        <thead>
                            <tr class="align-middle">
                                <th class="w-1">
                                    SL. <input class="form-check-input m-0 align-middle" type="checkbox"
                                        aria-label="Select all invoices" id="master">
                                </th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Slug</th>
                                <th class="text-center" style="width: 150px;">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php($i = 1)
                            @forelse ($themes as $item)
                                <tr @if ($i % 2 == 0) style="background:#f5f5f5" @endif>
                                    <td class="sl-cell">
                                        {{ $i++ }}.
                                        <input class="form-check-input m-0 align-middle sub_chk" type="checkbox"
                                            data-id="{{ $item->id }}">
                                    </td>
                                    <td>
                                        @if ($item->imageFile)
                                            <img src="{{ asset($item->imageFile->file_url) }}" width="80"
                                                class="rounded">
                                        @else
                                            <img src="https://placehold.co/300x250?text=No+Image" width="80"
                                                class="rounded">
                                        @endif
                                    </td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->category->title }}</td>
                                    <td>{{ $item->slug }}</td>

                                    <td class="w-1">
                                        <button
                                            class="btn-gradient-info  border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1 edit-btn"
                                            data-id="{{ $item->id }}" data-title="{{ $item->title }}"
                                            data-category_id="{{ $item->category_id }}"
                                            data-image="{{ $item->imageFile ? asset($item->imageFile->file_url) : '' }}">
                                            <i class="ti ti-edit"></i> Edit
                                        </button>
                                        <a href="{{ route('admin.landing.theme.delete', $item->id) }}"
                                            class="btn-gradient-danger   border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1"
                                            onclick="return confirm('Delete this?')">
                                            <i class="ti ti-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-danger text-center fw-bold">No Data Found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="add-modal">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">

                <div class="card-header">
                    <h5>Add Theme</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('admin.landing.theme.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label required">Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Category</label>
                            <select name="category_id" class="form-select">
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success btn-sm">Save</button>

                    </div>
                </form>

            </div>
        </div>
    </div>


    {{-- Edit Modal --}}
    <div class="modal fade" id="edit-modal">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">

                <div class="card-header">
                    <h5>Edit Theme</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('admin.landing.theme.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" id="id_e">

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label required">Title</label>
                            <input type="text" class="form-control" name="title" id="title_e" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Category</label>
                            <select name="category_id" id="category_id_e" class="form-select">
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- IMAGE PREVIEW --}}
                        <div class="mb-3">
                            <label>Current Image</label>
                            <div id="edit-image-preview"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image (Optional)</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success btn-sm">Update</button>

                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection


@push('js')
    <script>
        $(document).ready(function() {

            $(".add-btn").click(function() {
                $("#add-modal").modal('show');
            });

            $(".edit-btn").click(function() {
                $("#id_e").val($(this).data("id"));
                $("#title_e").val($(this).data("title"));
                $("#category_id_e").val($(this).data("category_id"));

                let imageUrl = $(this).data("image");

                if (imageUrl) {
                    $("#edit-image-preview").html(`
                    <img src="${imageUrl}" width="120" class="rounded border">
                `);
                } else {
                    $("#edit-image-preview").html(`<span class="text-muted">No Image</span>`);
                }

                $("#edit-modal").modal('show');
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
                            url: "{{ route('admin.landing.themes.bulk.delete') }}",
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
