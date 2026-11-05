@extends('backEnd.admin.layouts.master')

@section('title')
    Supplier List
@endsection

@section('content')
    <div class="page-body mt-3">
        <div class="container-xl">
            <div class="row">
                <div class="col-12 d-flex justify-content-between align-items-center gap-2">
                    <h2 class="page-title">Supplier List</h2>
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
                        <div class="card-header d-flex align-items-center gap-2">
                            @can('suppliers.create')
                                <a href="javascript:void(0);" class="btn btn-success btn-sm add_btn">
                                    <i class="ti ti-plus"></i> Add Supplier
                                </a>
                            @endcan

                            {{-- @can('suppliers.delete')
                                <button type="button" id="bulk_delete_btn"
                                    class="btn btn-gradient-danger btn-sm d-flex align-items-center gap-1">
                                    <i class="ti ti-trash"></i> Bulk Delete
                                    <span id="selected_count" class="badge bg-white text-danger ms-1 d-none">0</span>
                                </button>
                            @endcan --}}
                        </div>

                        <div class="table-responsive">
                            @include('backEnd.admin.includes.top-paginate', ['items' => $data])

                            <table class="table table-vcenter card-table table-striped">
                                <thead>
                                    <tr class="align-middle">
                                        <th class="w-1">
                                            SL. <input class="form-check-input m-0 align-middle" type="checkbox"
                                                aria-label="Select all suppliers" id="master">
                                        </th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Due Balance</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $item)
                                        <tr>
                                            <td class="sl-cell">
                                                {{-- continues numbering across pages --}}
                                                {{ $data->firstItem() + $loop->index }}.
                                                <input class="form-check-input m-0 align-middle sub_chk" type="checkbox"
                                                    data-id="{{ $item->id }}">
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>TK {{ number_format($item->balance ?? 0, 2) }}</td>
                                            <td>
                                                @can('suppliers.status')
                                                    @if ($item->status == 1)
                                                        <a href="{{ route('admin.supplier.status', ['id' => $item->id]) }}"
                                                            onclick="return confirm('Are you sure you want to block this supplier?')"
                                                            class="badge bg-success">
                                                            Active
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.supplier.status', ['id' => $item->id]) }}"
                                                            onclick="return confirm('Are you sure you want to activate this supplier?')"
                                                            class="badge bg-danger">
                                                            Blocked
                                                        </a>
                                                    @endif
                                                @endcan
                                            </td>
                                            <td class="w-1">
                                                @can('suppliers.edit')
                                                    <a href="javascript:void(0);"
                                                        class="btn-gradient-info padding-2-6 border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1 edit_btn"
                                                        data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                        data-email="{{ $item->email }}" data-phone="{{ $item->phone }}"
                                                        data-balance="{{ $item->balance }}" data-status="{{ $item->status }}">
                                                        <i class="ti ti-edit"></i>Edit
                                                    </a>
                                                @endcan

                                                <button type="button"
                                                    class="btn-gradient-info padding-2-6 border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#transactionModal_{{ $item->id }}">
                                                    <i class="ti ti-list-check"></i>Transactions
                                                </button>

                                                <!-- Payment Button -->
                                                @if (($item->balance ?? 0) > 0)
                                                    <button type="button"
                                                        class="btn-gradient-success padding-2-6 border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1 pay_due_btn"
                                                        data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                        data-balance="{{ $item->balance }}">
                                                        <i class="ti ti-cash"></i> Payment
                                                    </button>
                                                @endif


                                                @can('suppliers.delete')
                                                    <a href="{{ route('admin.supplier.delete', $item->id) }}"
                                                        class="btn-gradient-danger padding-2-6 border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1"
                                                        onclick="return confirm('Are you sure you want to delete this?')">
                                                        <i class="ti ti-trash"></i>Delete
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-danger fw-bold">No Supplier Found!
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            @include('backEnd.admin.includes.bottom-paginate', ['items' => $data])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Transaction modals live OUTSIDE the table (a <div> inside <tbody> is invalid HTML) --}}
    @foreach ($data as $item)
        @php
            // Uses eager-loaded relation if the controller provided it, otherwise falls back to one query per supplier.
            $transactions = $item->relationLoaded('transactions')
                ? $item->transactions->sortByDesc('created_at')->take(20)
                : $item->transactions()->latest()->take(20)->get();
        @endphp

        <div class="modal modal-blur fade" id="transactionModal_{{ $item->id }}" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Transaction History - <span class="text-primary">{{ $item->name }}</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold text-muted">Showing Latest 20 Transactions</span>
                            <span class="badge bg-info text-white">
                                Current Balance: TK {{ number_format($item->balance ?? 0, 2) }}
                            </span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table table-bordered">
                                <thead>
                                    <tr class="align-middle">
                                        <th>SL.</th>
                                        <th>Date &amp; Time</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Prev Balance</th>
                                        <th>New Balance</th>
                                        {{-- <th>Note</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transactions as $trx)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>
                                                <div class="text-dark fw-semibold">
                                                    {{ $trx->created_at ? $trx->created_at->format('d M Y, h:i A') : 'N/A' }}
                                                </div>
                                            </td>
                                            <td>
                                                @if (strtolower($trx->type ?? '') === 'payment')
                                                    <span class="badge bg-success text-white">Payment</span>
                                                @else
                                                    <span
                                                        class="badge bg-info text-white">{{ ucfirst($trx->type ?? 'N/A') }}</span>
                                                @endif
                                            </td>
                                            <td><span class="fw-bold">TK {{ number_format($trx->amount ?? 0, 2) }}</span>
                                            </td>
                                            <td>TK {{ number_format($trx->previous_balance ?? 0, 2) }}</td>
                                            <td>
                                                <span class="text-primary fw-bold">
                                                    TK {{ number_format($trx->new_balance ?? 0, 2) }}
                                                </span>
                                            </td>
                                            {{-- <td>{{ $trx->notes ?? 'N/A' }}</td> --}}
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-danger py-3">
                                                <b>No transactions found for this supplier!</b>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Add Modal -->
    <div class="modal modal-blur fade" id="add_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.supplier.store') }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control mt-1" id="name" name="name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control mt-1" id="email" name="email">
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone">Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control mt-1" id="phone" name="phone" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="balance">Balance</label>
                            <input type="number" step="0.01" class="form-control mt-1" id="balance"
                                name="balance">
                        </div>
                        <div class="form-group mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control mt-1">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success float-end">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal modal-blur fade" id="edit_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.supplier.update') }}" method="post">
                        @csrf
                        <input type="hidden" id="id_e" name="id">
                        <div class="form-group mb-3">
                            <label for="name_e">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control mt-1" id="name_e" name="name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email_e">Email</label>
                            <input type="email" class="form-control mt-1" id="email_e" name="email">
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone_e">Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control mt-1" id="phone_e" name="phone" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="balance_e">Balance</label>
                            <input type="number" step="0.01" class="form-control mt-1" id="balance_e"
                                name="balance">
                        </div>
                        <div class="form-group mb-3">
                            <label for="status_e">Status</label>
                            <select name="status" id="status_e" class="form-control mt-1">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success float-end">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Payment Modal -->
    <div class="modal fade" id="payment_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Make Purchase Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.supplier.pay.purchase.due') }}" method="POST">
                        @csrf
                        <input type="hidden" name="supplier_id" id="pay_supplier_id">

                        <div class="mb-3">
                            <label class="form-label">Supplier Name</label>
                            <input type="text" id="pay_supplier_name" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Total Supplier Due Balance</label>
                            <input type="text" id="pay_supplier_balance" class="form-control" readonly>
                        </div>

                        <!-- Select Purchase Memo -->
                        <div class="mb-3">
                            <label class="form-label">Select Purchase Memo <span class="text-danger">*</span></label>
                            <select name="purchase_id" id="pay_purchase_id" class="form-select" required>
                                <option value="">-- Select Purchase Memo --</option>
                            </select>
                        </div>

                        <!-- Current Purchase Due Field -->
                        <div class="mb-3">
                            <label class="form-label">Selected Purchase Due Amount</label>
                            <input type="text" id="selected_purchase_due" class="form-control text-danger fw-bold"
                                readonly placeholder="0.00">
                        </div>

                        <!-- Select Account -->
                        <div class="mb-3">
                            <label class="form-label">Payment Account <span class="text-danger">*</span></label>
                            <select name="account_id" class="form-select" required>
                                <option value="">-- Select Account --</option>
                                @foreach (\App\Account::where('status', 1)->get() as $account)
                                    <option value="{{ $account->id }}">
                                        {{ $account->get_account_name() }} (Balance: TK
                                        {{ number_format($account->balance, 2) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Payment Amount -->
                        <div class="mb-3">
                            <label class="form-label">Payment Amount <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="amount" id="pay_amount" class="form-control"
                                placeholder="Enter Amount" required>
                        </div>

                        <div class="modal-footer px-0 pb-0">
                            <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success btn-sm">Submit Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            // Open a Bootstrap modal (works with or without the jQuery plugin interface)
            function showModal(selector) {
                const el = document.querySelector(selector);
                if (window.bootstrap && bootstrap.Modal) {
                    bootstrap.Modal.getOrCreateInstance(el).show();
                } else {
                    $(el).modal('show');
                }
            }

            // ---------- Add / Edit ----------
            $(document).on('click', '.add_btn', function() {
                showModal('#add_modal');
            });

            $(document).on('click', '.edit_btn', function() {
                const $btn = $(this);
                $('#id_e').val($btn.data('id'));
                $('#name_e').val($btn.data('name'));
                $('#email_e').val($btn.data('email'));
                $('#phone_e').val($btn.data('phone'));
                $('#balance_e').val((parseFloat($btn.data('balance')) || 0).toFixed(2));
                $('#status_e').val($btn.data('status'));
                showModal('#edit_modal');
            });

            // ---------- Checkbox selection ----------
            function updateSelectedCount() {
                const total = $('.sub_chk').length;
                const checked = $('.sub_chk:checked').length;

                $('#selected_count').toggleClass('d-none', checked === 0).text(checked);
                $('#master').prop('checked', total > 0 && checked === total);
            }

            $(document).on('change', '#master', function() {
                const isChecked = $(this).is(':checked');
                $('.sub_chk').prop('checked', isChecked).each(function() {
                    $(this).closest('tr').toggleClass('table-primary', isChecked);
                });
                updateSelectedCount();
            });

            $(document).on('change', '.sub_chk', function() {
                $(this).closest('tr').toggleClass('table-primary', $(this).is(':checked'));
                updateSelectedCount();
            });

            // ---------- Bulk delete ----------
            $(document).on('click', '#bulk_delete_btn', function(e) {
                e.preventDefault();

                const selectedIds = $('.sub_chk:checked').map(function() {
                    return $(this).data('id');
                }).get();

                if (selectedIds.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Items Selected',
                        text: 'Please select at least one item to delete.',
                        confirmButtonColor: '#0054a6'
                    });
                    return;
                }

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
                    if (!result.isConfirmed) return;

                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait while we delete selected items.',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    $.ajax({
                        url: "{{ route('admin.supplier.bulk.delete') }}",
                        type: "POST",
                        dataType: "json",
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
                                }).then(() => location.reload());
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed',
                                    text: res.message || 'Something went wrong!'
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Server Error',
                                text: xhr.responseJSON?.message ||
                                    'Failed to process request. Please try again.'
                            });
                        }
                    });
                });
            });
        });
    </script>
    <script>
        $(document).on('click', '.pay_due_btn', function() {
            // alert('Payment functionality is currently disabled for testing purposes.');
            const supplierId = $(this).data('id');
            const supplierName = $(this).data('name');
            const supplierBalance = $(this).data('balance');

            $('#pay_supplier_id').val(supplierId);
            $('#pay_supplier_name').val(supplierName);
            $('#pay_supplier_balance').val('TK ' + parseFloat(supplierBalance).toFixed(2));
            $('#selected_purchase_due').val('0.00');
            $('#pay_amount').val('');

            const $purchaseSelect = $('#pay_purchase_id');
            $purchaseSelect.html('<option value="">Loading Purchases...</option>');

            // AJAX request for supplier's purchases
            $.ajax({
                url: "{{ route('admin.supplier.purchases', ':id') }}".replace(':id', supplierId),
                type: "GET",
                dataType: "json",
                success: function(purchases) {
                    $purchaseSelect.html('<option value="">-- Select Purchase Memo --</option>');
                    if (purchases.length > 0) {
                        $.each(purchases, function(index, purchase) {
                            $purchaseSelect.append(
                                `<option value="${purchase.id}" data-due="${purchase.due_amount}">
                        Memo #${purchase.memo_no} - (Due: TK ${parseFloat(purchase.due_amount).toFixed(2)})
                    </option>`
                            );
                        });
                    } else {
                        $purchaseSelect.html(
                            '<option value="">No pending due purchases found!</option>');
                    }
                    $('#payment_modal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch purchases!');
                }
            });
        });

        // Purchase select korle dynamic due_amount set ebong payment amount pre-fill hobe
        $(document).on('change', '#pay_purchase_id', function() {
            const selectedDue = $(this).find(':selected').data('due');
            if (selectedDue !== undefined) {
                $('#selected_purchase_due').val('TK ' + parseFloat(selectedDue).toFixed(2));
                $('#pay_amount').val(parseFloat(selectedDue).toFixed(2));
            } else {
                $('#selected_purchase_due').val('0.00');
                $('#pay_amount').val('');
            }
        });
    </script>
@endpush
