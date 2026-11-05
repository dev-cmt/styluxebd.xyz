@extends('backEnd.admin.layouts.master')
@section('title')
    Role & Permissions
@endsection
@section('content')
    <div class="page-body mt-3">
        <div class="container-xl">
            <div class="row">
                <!-- Page Header -->
                <div class="col-12 d-flex justify-content-between align-items-center    ">
                    <h2 class="page-title">Role & Permissions</h2>
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center gap-1">
                            <span class="fw-bold">Total:</span>
                            <span class="badge bg-primary text-white">{{ $roles->count() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <h2 class="page-title">

                    </h2>
                </div>
            </div>
            <div class="row mt-2">
                <!-- Page Header Close -->
                <div class="col-12">
                    <div class="card" style="border-top: none">
                        <div class="card-header  py-2 d-flex align-items-center  gap-2 flex-wrap">
                            @can('roles.create')
                                <a href="{{ route('admin.role.create') }}" class="btn btn-success btn-sm">
                                    <i class="ti ti-plus"></i>
                                    Add Roles & Permissions</a>
                            @endcan
                            {{-- Clean Production Bulk Delete Button --}}

                            @can('roles.delete')
                                <button type="button" id="bulk_delete_btn"
                                    class="btn btn-gradient-danger btn-sm d-flex align-items-center gap-1">
                                    <i class="ti ti-trash"></i> Bulk Delete
                                    <span id="selected_count" class="badge bg-white text-danger ms-1 d-none">0</span>
                                </button>
                            @endcan



                        </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr class="align-middle">
                                        <th class="w-1">
                                            SL. <input class="form-check-input m-0 align-middle" type="checkbox"
                                                aria-label="Select all invoices" id="master">
                                        </th>
                                        <th>Name</th>
                                        <Th>Permissions</Th>
                                        <th style="width: 5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($roles->count() > 0)
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($roles as $key => $role)
                                            <tr @if (($key + 1) % 2 == 0) style="background-color:#f5f5f5" @endif>
                                                <td class="sl-cell">
                                                    {{ $i++ }}.
                                                    <input class="form-check-input m-0 align-middle sub_chk" type="checkbox"
                                                        data-id="{{ $role->id }}">
                                                </td>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    @foreach ($role->permissions as $key => $permission)
                                                        @php
                                                            $name = collect(
                                                                explode('.', str_replace('_', ' ', $permission->name)),
                                                            )
                                                                ->map(function ($item) {
                                                                    return ucfirst($item);
                                                                })
                                                                ->implode(' ');
                                                        @endphp
                                                        <span class="badge bg-blue-lt mb-2">{{ ucwords($name) }}</span>
                                                        @if (($key + 1) % 10 == 0)
                                                            <br>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        @can('roles.edit')
                                                            <a href="{{ route('admin.role.edit', $role->id) }}"
                                                                class="btn-gradient-info padding-2-6 border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1">
                                                                <i class="ti ti-edit"></i>Edit
                                                            </a>
                                                        @endcan
                                                        @can('roles.delete')
                                                            <form action="{{ route('admin.role.delete', $role->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                @can('role_delete')
                                                                    <button type="submit"
                                                                        class="btn-gradient-danger padding-2-6 border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1"
                                                                        onclick="return confirm('Are you sure want to delete this?')"><i
                                                                            class="ti ti-trash"></i>
                                                                        Delete</button>
                                                                @endcan
                                                            </form>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9" class="text-danger text-center fw-bold">No Data Found !
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>
        $(document).on('click', '#all_permissions_checked', function() {
            if ($('#all_permissions_checked').is(':checked')) {
                $('.check-input').prop('checked', true);
            } else {
                $('.check-input').prop('checked', false);
            }
        });

        $(document).on('click', '.manage_check', function() {
            if ($(this).is(':checked')) {
                let parent = $(this).closest('.row');
                $(parent.find('.child_input')).each(function() {
                    $(this).prop('checked', true);
                });
            } else {
                let parent = $(this).closest('.row');
                $(parent.find('.child_input')).each(function() {
                    $(this).prop('checked', false);
                });
            }
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
                            url: "{{ route('admin.role.bulk.delete') }}",
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
