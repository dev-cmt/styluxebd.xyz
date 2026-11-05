@extends('backEnd.admin.layouts.master')

@section('title')
    Themes
@endsection

@php
    $data = $data ?? [];
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
                    <h3 class="page-title">All Themes</h3>
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
                    <div class="card  shadow-sm  rounded" style="border-top: none">
                        <div class="card-header d-flex gap-2 align-items-center py-2 px-3">
                            @can('theme.list')
                                <a href="javascript:void(0);" class="btn btn-success btn-sm add_theme">
                                    <i class="ti ti-plus"></i> Add Theme
                                </a>
                            @endcan
                            {{-- Clean Production Bulk Delete Button --}}
                            <button type="button" id="bulk_delete_btn"
                                class="btn btn-gradient-danger btn-sm d-flex align-items-center gap-1">
                                <i class="ti ti-trash"></i> Bulk Delete
                                <span id="selected_count" class="badge bg-white text-danger ms-1 d-none">0</span>
                            </button>
                        </div>
                        <div class="table-responsive">
                            @include('backEnd.admin.includes.top-paginate', ['items' => $data])
                            <table class="table align-top card-table datatable">
                                <thead>
                                    <tr class="align-middle">
                                        <th class="w-1">
                                            SL. <input class="form-check-input m-0 align-middle" type="checkbox"
                                                aria-label="Select all invoices" id="master">
                                        </th>
                                        <th>Preview</th>
                                        <th>URL</th>
                                        <th>Name</th>
                                        {{-- <th>Status</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i = 1)
                                    @if ($data->count() > 0)
                                        @foreach ($data as $item)
                                            <tr @if ($i % 2 == 0) style="background-color:#f5f5f5" @endif>
                                                <td class="sl-cell">
                                                    {{ $i++ }}.
                                                    <input class="form-check-input m-0 align-middle sub_chk" type="checkbox"
                                                        data-id="{{ $item->id }}">
                                                </td>
                                                <td>
                                                    <img src="{{ asset($item->image) }}" width="100"
                                                        style="border-radius:8px">
                                                </td>
                                                <td>
                                                    @if ($item->is_active == 1)
                                                        <a href="{{ route('home') }}"
                                                            target="_blank">{{ $item->path }}</a>
                                                    @else
                                                        <a href="{{ route('theme.home', $item->path) }}"
                                                            target="_blank">{{ $item->path }}</a>
                                                    @endif
                                                </td>
                                                <td>{{ $item->name }}</td>
                                                {{-- <td>
                                                    @if ($item->status == 1)
                                                        <a href="{{ route('admin.themes.status', $item->id) }}"
                                                            class=" btn btn-outline-success btn-sm mb-1"
                                                            onclick="return confirm('Are you sure to status change this theme?')">
                                                            Published
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.themes.status', $item->id) }}"
                                                            class="btn btn-outline-danger btn-sm mb-1"
                                                            onclick="return confirm('Are you sure to status change this theme?')">
                                                            Unpublished
                                                        </a>
                                                    @endif
                                                </td> --}}
                                                <td class="w-1 text-center">
                                                    {{-- <a href="{{ route('admin.themes.activate', $item->id) }}"
                                                        class="btn btn-outline-success btn-sm mb-1 w-100"
                                                        onclick="return confirm('Are you sure to activate this theme? All other themes will be removed!')">
                                                        <i class="ti ti-check"></i> Activate
                                                    </a> --}}
                                                    @can('theme.status')
                                                        @if ($item->is_active == 1)
                                                            <a href="{{ route('admin.themes.activate', ['id' => $item->id, 'status' => 0]) }}"
                                                                class="btn-gradient-success padding-2-6 border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1"
                                                                onclick="return confirm('Are you sure to Deactivate this theme?')">
                                                                Activated
                                                            </a>
                                                        @else
                                                            <a href="{{ route('admin.themes.activate', ['id' => $item->id, 'status' => 1]) }}"
                                                                class="btn-gradient-info padding-2-6  border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1"
                                                                onclick="return confirm('Are you sure to activate this theme? All other themes will be removed!')">
                                                                Deactivated
                                                            </a>
                                                        @endif
                                                    @endcan

                                                    @can('theme.delete')
                                                        <form action="{{ route('admin.themes.destroy', $item->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn-gradient-danger padding-2-6 border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1"
                                                                onclick="return confirm('Are you sure want to delete this theme?')">
                                                                <i class="ti ti-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center text-danger fw-bold">No Theme Found!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            @include('backEnd.admin.includes.bottom-paginate', ['items' => $data])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Theme Modal -->
    <div class="modal fade" id="add_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="card-header">
                    <h5 class="modal-title">Add Theme</h5>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.themes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Theme Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Theme Path Name</label>
                            <input type="text" name="path" class="form-control" required>
                            <small class="text-danger">* Example: theme-1, theme-2, theme-3 etc.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Preview Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-success float-end w-100">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Theme Modal -->
    {{-- <div class="modal fade" id="edit_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="card-header">
                    <h5 class="modal-title">Edit Theme</h5>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.themes.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label class="form-label">Theme Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Preview Image</label>
                            <input type="file" name="preview_image" class="form-control">
                            <img id="preview_img" src="" width="100" class="mt-2 rounded">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-success btn-sm w-100">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@push('js')
    <script>
        $(document).on('click', '.add_theme', function() {
            $('#add_modal').modal('show');
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
                            url: "{{ route('admin.themes.bulk.delete') }}",
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
