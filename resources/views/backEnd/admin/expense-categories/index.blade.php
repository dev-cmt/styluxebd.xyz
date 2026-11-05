@extends('backEnd.admin.layouts.master')
@section('title')
    Expense Categories
@endsection

@section('content')

    <div class="page-body mt-3">
        <div class="container-xl">
            <div class="row">
                <div class="col-12 d-flex align-items-center justify-content-between">
                    <h2 class="page-title">Expense Categories</h2>
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center gap-1">
                            <span class="fw-bold">Total:</span>
                            <span class="badge bg-primary text-white">{{ $data->total() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12">

                </div>
            </div>
            <div class="row row-deck row-cards mt-2">
                <!-- Page Header Close -->
                <div class="col-12 m-0">
                    <div class="card" style="border-top:none">
                        <div class="card-header d-flex align-items-center gap-2 flex-wrap py-2">
                            @can('expenses.category.create')
                                <a href="javascript:void(0);" class="btn btn-success btn-sm add_expense_category">
                                    <i class="ti ti-plus"></i>
                                    Add Category</a>
                            @endcan
                            {{-- Clean Production Bulk Delete Button --}}
                            @can('expenses.category.delete')
                                <button type="button" id="bulk_delete_btn"
                                    class="btn btn-gradient-danger btn-sm d-flex align-items-center gap-1">
                                    <i class="ti ti-trash"></i> Bulk Delete
                                    <span id="selected_count" class="badge bg-white text-danger ms-1 d-none">0</span>
                                </button>
                            @endcan
                            {{-- {{ $data->links('backEnd.admin.includes.paginate') }} --}}
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
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th style="width: 5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data) > 0)
                                        @php($i = 1)
                                        @foreach ($data as $key => $item)
                                            <tr @if ($i % 2 == 0) style="background-color:#f5f5f5" @endif>
                                                <td class="sl-cell">
                                                    {{ $i++ }}.
                                                    <input class="form-check-input m-0 align-middle sub_chk" type="checkbox"
                                                        data-id="{{ $item->id }}">
                                                </td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    {{-- @if ($item->status == 1)
                                                        <a href="{{ route('admin.expense.category.status', [$item->id, 0]) }}"
                                                            onclick="return confirm('Are you sure want to change this status?')"><span
                                                                class="badge bg-success">Inactive</span></a>
                                                    @else
                                                        <a href="{{ route('admin.expense.category.status', [$item->id, 1]) }}"
                                                            onclick="return confirm('Are you sure want to change this status?')"><span
                                                                class="badge bg-danger">Active</span></a>
                                                    @endif --}}
                                                    @if ($item->status == 1)
                                                        <a href="{{ route('admin.expense.category.status', [$item->id, 0]) }}"
                                                            onclick="return confirm('Are you sure want to change this status?')"><span
                                                                class="badge bg-success">Active</span></a>
                                                    @else
                                                        <a href="{{ route('admin.expense.category.status', [$item->id, 1]) }}"
                                                            onclick="return confirm('Are you sure want to change this status?')"><span
                                                                class="badge bg-danger">Inactive</span></a>
                                                    @endif
                                                </td>
                                                <td class="w-1">

                                                    @can('expenses.category.edit')
                                                        <a href="javascript:void(0);"
                                                            class="btn-gradient-info padding-2-6  border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1  edit_expense_category"
                                                            data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                            data-status="{{ $item->status }}">
                                                            <i class="ti ti-edit"></i> &nbsp;Edit
                                                        </a>
                                                    @endcan
                                                    @can('expenses.category.delete')
                                                        <form action="{{ route('admin.expense.category.delete', $item->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn-gradient-danger padding-2-6 border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1"
                                                                onclick="return confirm('Are you sure want to delete this?')"><i
                                                                    class="ti ti-trash"></i>&nbsp;Delete</button>
                                                        </form>
                                                    @endcan
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
    <!-- Add Modal -->
    <div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="card-header">
                    <h5 class="modal-title">Add Expense</h5>
                    <button type="button" class="btn-close btn-sm" style="width: 40px;height:40px" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.expense.category.store') }}" method="POST">
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-success float-end">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="card-header">
                    <h5 class="modal-title">Edit Expense</h5>
                    <button type="button" class="btn-close btn-sm" style="width: 40px;height:40px"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.expense.category.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="col-12 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-success float-end">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).on('click', '.add_expense_category', function() {
            $('#add_modal').modal('show');
        });

        $(document).on('click', '.edit_expense_category', function() {
            $('#edit_modal').modal('show');
            $('#id').val($(this).data('id'));
            $('#name').val($(this).data('name'));
            $('#status').val($(this).data('status'));
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
                            url: "{{ route('admin.expense.category.bulk.delete') }}",
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
