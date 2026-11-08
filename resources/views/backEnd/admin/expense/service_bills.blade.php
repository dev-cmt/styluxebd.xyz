@extends('backEnd.admin.layouts.master')

@section('title')
    Services & Providers
@endsection

@section('content')
    <div class="page-body mt-3">
        <div class="container-xl">
            <div class="row">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h2 class="page-title">Services & Providers</h2>
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center gap-1">
                            <span class="fw-bold">Total:</span>
                            <span class="badge bg-primary text-white">{{ $suppliers->total() }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-deck row-cards mt-2">
                <div class="col-12 m-0">
                    <div class="card" style="border-top: none">
                        <div class="card-header d-flex align-items-center gap-2 flex-wrap py-2">
                            <a href="javascript:void(0);" class="btn btn-success btn-sm add_service_btn">
                                <i class="ti ti-plus"></i> Add Service Provider
                            </a>
                        </div>
                        <div class="table-responsive">
                            @include('backEnd.admin.includes.top-paginate', ['items' => $suppliers])

                            <table class="table table-vcenter card-table text-nowrap">
                                <thead>
                                    <tr class="align-middle">
                                        <th class="w-1">SL.</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Current Due (Balance)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($suppliers) > 0)
                                        @php($i = 1)
                                        @foreach ($suppliers as $item)
                                            <tr>
                                                <td>{{ $i++ }}.</td>
                                                <td class="fw-bold">{{ $item->name }}</td>
                                                <td>{{ $item->phone ?? '---' }}</td>
                                                <td>{{ $item->email ?? '---' }}</td>
                                                <td class="text-danger fw-bold">
                                                    {{ $web_settings->currency_sign }}{{ number_format($item->balance, 2) }}
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <!-- Edit Button -->
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-primary btn-sm edit_service_btn"
                                                            data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                            data-phone="{{ $item->phone }}"
                                                            data-email="{{ $item->email }}"
                                                            data-address="{{ $item->address }}">
                                                            <i class="ti ti-edit"></i> Edit
                                                        </a>

                                                        <!-- Payment Button -->
                                                        @if ($item->balance > 0)
                                                            <a href="javascript:void(0);"
                                                                class="btn btn-success btn-sm pay_due_btn"
                                                                data-id="{{ $item->id }}"
                                                                data-name="{{ $item->name }}"
                                                                data-balance="{{ $item->balance }}">
                                                                <i class="ti ti-cash"></i> Payment
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-danger"><b>No data found.</b>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            @include('backEnd.admin.includes.bottom-paginate', ['items' => $suppliers])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="card-header">
                    <h5 class="modal-title">Add Service Provider</h5>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.services.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="2"> <!-- 2 = Service Vendor -->
                        <div class="col-12 mb-3">
                            <label class="form-label">Provider Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-success float-end">Save</button>
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
                    <h5 class="modal-title">Edit Service Provider</h5>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.services.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="edit_id">
                        <div class="col-12 mb-3">
                            <label class="form-label">Provider Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" id="edit_address" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-success float-end">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="payment_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="card-header">
                    <h5 class="modal-title">Make Payment to Provider</h5>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.services.pay.due') }}" method="POST">
                        @csrf
                        <input type="hidden" name="supplier_id" id="pay_supplier_id">

                        <div class="col-12 mb-3">
                            <label class="form-label">Provider Name</label>
                            <input type="text" id="pay_supplier_name" class="form-control" readonly>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Current Due Balance</label>
                            <input type="text" id="pay_supplier_balance" class="form-control" readonly>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Payment Account <span class="text-danger">*</span></label>
                            <select name="account_id" class="form-select" required>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}">
                                        {{ $account->get_account_name() }} ({{ $web_settings->currency_sign }}{{ number_format($account->balance, 2) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Payment Amount <span class="text-danger">*</span></label>
                            <input type="number" step="any" name="amount" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-success float-end">Submit Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).on('click', '.add_service_btn', function() {
            $('#add_modal').modal('show');
        });

        $(document).on('click', '.edit_service_btn', function() {
            $('#edit_modal').modal('show');
            $('#edit_id').val($(this).data('id'));
            $('#edit_name').val($(this).data('name'));
            $('#edit_phone').val($(this).data('phone'));
            $('#edit_email').val($(this).data('email'));
            $('#edit_address').val($(this).data('address'));
        });

        $(document).on('click', '.pay_due_btn', function() {
            $('#payment_modal').modal('show');
            $('#pay_supplier_id').val($(this).data('id'));
            $('#pay_supplier_name').val($(this).data('name'));
            $('#pay_supplier_balance').val($(this).data('balance'));
        });
    </script>
@endpush
