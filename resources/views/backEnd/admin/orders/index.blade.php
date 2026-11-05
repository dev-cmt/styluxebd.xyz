@extends('backEnd.admin.layouts.master')

@section('title')
    @if (!$sts)
        All Orders
    @else
        {{ Str::ucfirst(str_replace('_', ' ', $sts)) }} Orders
    @endif
@endsection
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('backEnd/assets/plugin/datepicker/daterangepicker.css') }}" />
@endpush
@php
    $orders = $data['orders'] ?? 0;
    $total_order = $data['total_order'] ?? 0;
    $total_pending_order = $data['total_pending_order'] ?? 0;
    $total_confirm_order = $data['total_confirm_order'] ?? 0;
    $total_processing_order = $data['total_processing_order'] ?? 0;
    $total_hold_order = $data['total_hold_order'] ?? 0;
    $total_printed_order = $data['total_printed_order'] ?? 0;
    $total_packaging_order = $data['total_packaging_order'] ?? 0;
    $total_courier_entry_order = $data['total_courier_entry_order'] ?? 0;
    $total_on_delivery_order = $data['total_on_delivery_order'] ?? 0;
    $total_delivered_order = $data['total_delivered_order'] ?? 0;
    $total_partial_delivered_order = $data['total_partial_delivered_order'] ?? 0;
    $total_cancelled_order = $data['total_cancelled_order'] ?? 0;
    $total_returned_order = $data['total_returned_order'] ?? 0;
    $total_return_received_order = $data['total_return_received_order'] ?? 0;
    $total_exchange_order = $data['total_exchange_order'] ?? 0;
    $total_trash_order = $data['total_trash_order'] ?? 0;

    $couriers = \Illuminate\Support\Facades\DB::table('couriers')->where('status', 1)->pluck('courier_name', 'id');
    $query = request()->query('query') ?? null;
    $source = $source ?? null;
    $payment_status = $payment_status ?? null;
    $courier_id = $courier_id ?? null;
    $status = $sts ?? null;
@endphp
{{-- @dd($sts) --}}
{{-- @dd($data['orders']) --}}
@section('content')
    <div class="page-body mt-0">
        <div class="container-xl">
            <div class="order-header d-flex justify-content-between align-items-start flex-wrap gap-2" style="">
                <div class="d-flex align-items-center">
                    <h2 class="mb-0 me-2">
                        @if (!$sts)
                            All Orders
                        @else
                            <span class="text-capitalize text-success">
                                {{ Str::ucfirst(str_replace('_', ' ', $sts)) }} Orders
                            </span>
                        @endif
                    </h2>

                    <a href="{{ route('admin.orders.trash') }}" class="btn btn-dark btn-sm d-flex align-items-center gap-1"
                        title="Trash">
                        <i class="ti ti-trash"></i>
                        Trash
                        <span class="badge bg-danger ms-1">{{ $data['total_trash_order'] ?? 0 }}</span>
                    </a>
                </div>
                <div class="d-flex align-items-center  premium-form">
                    <form action="{{ route('admin.orders') }}" class="d-flex align-items-start gap-2" id="search_form">

                        <input type="hidden" name="status" value="{{ $status ?? null }}">

                        <div>
                            <input type="text" placeholder="Select date range" id="date_range_display"
                                class="form-control search-input  form-control-sm date_range date_range_display"
                                autocomplete="off">
                            <input type="hidden" name="date_range" id="date_range">
                        </div>

                        <select name="source" id="source" class="form-select form-select-sm cool-select">
                            <option value="">Source</option>
                            <option value="website" {{ $source == 'website' ? 'selected' : '' }}>Website</option>
                            <option value="whatsapp" {{ $source == 'whatsapp' ? 'selected' : '' }}>Whatsapp</option>
                            <option value="page" {{ $source == 'page' ? 'selected' : '' }}>Page</option>
                            <option value="call" {{ $source == 'call' ? 'selected' : '' }}>Call</option>
                            <option value="instagram" {{ $source == 'instagram' ? 'selected' : '' }}>Instagram</option>
                            <option value="tiktok" {{ $source == 'tiktok' ? 'selected' : '' }}>Tiktok</option>
                            <option value="office_sell" {{ $source == 'office_sell' ? 'selected' : '' }}>Office Sell
                            </option>
                            <option value="incomplete" {{ $source == 'incomplete' ? 'selected' : '' }}>Incomplete
                            </option>
                            <option value="landing" {{ $source == 'landing' ? 'selected' : '' }}>Landing</option>
                        </select>

                        <select name="payment_status" id="payment_status" class="form-select form-select-sm  cool-select">
                            <option value="">Payment</option>
                            <option value="1" {{ $payment_status == '1' ? 'selected' : '' }}>Paid</option>
                            <option value="0" {{ $payment_status == '0' ? 'selected' : '' }}>Unpaid</option>
                        </select>

                        <select name="courier_id" id="courier_id" class="form-select form-select-sm  cool-select">
                            <option value="">Courier</option>
                            @foreach ($couriers as $key => $item)
                                <option value="{{ $key }}" {{ $courier_id == $key ? 'selected' : '' }}>
                                    {{ $item }}</option>
                            @endforeach
                        </select>

                        <div>
                            <input type="text" class="form-control form-control-sm search-input  cool-select"
                                placeholder="Search..." id="search" value="{{ $query }}" name="query">
                            <div class="search-msg">

                            </div>
                        </div>

                        {{-- <button type="submit" class="btn btn-gradient-info btn-sm d-flex align-items-center gap-1">
                            <i class="ti ti-search"></i> Search
                        </button> --}}

                        <a href="{{ route('admin.orders') }}"
                            class="btn btn-gradient-dark btn-sm d-flex align-items-center gap-1">
                            <i class="ti ti-refresh"></i>
                        </a>

                    </form>
                </div>
            </div>
            @php
                $statusCards = [
                    [
                        'title' => 'Orders',
                        'value' => $total_order,
                        'status' => 'total',
                        'color' => 'secondary',
                        'textColor' => 'text-secondary',
                    ],
                    [
                        'title' => 'Pending',
                        'value' => $total_pending_order,
                        'status' => 'pending',
                        'color' => 'warning',
                        'textColor' => 'text-warning',
                    ],
                    [
                        'title' => 'Confirmed',
                        'value' => $total_confirm_order,
                        'status' => 'confirm',
                        'color' => 'primary',
                        'textColor' => 'text-primary',
                    ],
                    [
                        'title' => 'Processing',
                        'value' => $total_processing_order,
                        'status' => 'processing',
                        'color' => 'info',
                        'textColor' => 'text-info',
                    ],
                    [
                        'title' => 'Hold',
                        'value' => $total_hold_order,
                        'status' => 'hold',
                        'color' => 'purple',
                        'textColor' => 'text-purple',
                    ],
                    [
                        'title' => 'Printed',
                        'value' => $total_printed_order,
                        'status' => 'printed',
                        'color' => 'secondary',
                        'textColor' => 'text-secondary',
                    ],
                    [
                        'title' => 'Packaged',
                        'value' => $total_packaging_order,
                        'status' => 'packaging',
                        'color' => 'orange',
                        'textColor' => 'text-orange',
                    ],
                    [
                        'title' => 'Courier Entry',
                        'value' => $total_courier_entry_order,
                        'status' => 'courier_entry',
                        'color' => 'azure',
                        'textColor' => 'text-azure',
                    ],
                    [
                        'title' => 'On Delivery',
                        'value' => $total_on_delivery_order,
                        'status' => 'on_delivery',
                        'color' => 'teal',
                        'textColor' => 'text-teal',
                    ],
                    [
                        'title' => 'Delivered',
                        'value' => $total_delivered_order,
                        'status' => 'delivered',
                        'color' => 'success',
                        'textColor' => 'text-success',
                    ],
                    [
                        'title' => 'Partial Delivered',
                        'value' => $total_partial_delivered_order,
                        'status' => 'partial_delivered',
                        'color' => 'cyan',
                        'textColor' => 'text-cyan',
                    ],
                    [
                        'title' => 'Cancelled',
                        'value' => $total_cancelled_order,
                        'status' => 'cancelled',
                        'color' => 'danger',
                        'textColor' => 'text-danger',
                    ],
                    [
                        'title' => 'Return',
                        'value' => $total_returned_order,
                        'status' => 'returned',
                        'color' => 'cyan',
                        'textColor' => 'text-cyan',
                    ],
                    [
                        'title' => 'Return Received',
                        'value' => $total_return_received_order,
                        'status' => 'return_received',
                        'color' => 'indigo',
                        'textColor' => 'text-indigo',
                    ],
                    [
                        'title' => 'Exchange',
                        'value' => $total_exchange_order,
                        'status' => 'exchange',
                        'color' => 'pink',
                        'textColor' => 'text-pink',
                    ],
                ];
            @endphp


            <style>
                .order_table thead th {
                    position: sticky;
                    top: 0;
                    /* distance from top */
                    background-color: #fff;
                    /* header background color */
                    z-index: 10;
                    /* make sure it stays above rows */
                }
            </style>
            <div class="row">

                <div class="col-12">
                    <div class="card" style="border-top: none">
                        <div class="status-counter-wrapper">
                            @include('backEnd.admin.orders.partials.counter-order', [
                                'statusCards' => $statusCards,
                                'status' => $status,
                            ])
                        </div>

                        <div
                            class="buttons d-flex flex-nowrap gap-2 overflow-auto border-bottom align-items-start px-3 py-2">

                            {{-- Left Section --}}
                            <div class="d-flex gap-2 flex-nowrap">
                                @can('orders.create')
                                    <a href="{{ route('admin.orders.create') }}"
                                        class="btn btn-gradient-success btn-sm d-flex align-items-center gap-1">
                                        <i class="ti ti-plus"></i> Add Order
                                    </a>
                                @endcan

                                @can('orders.bulk.delete')
                                    <form action="{{ route('admin.orders.all.status', ['status_delete' => 'delete']) }}"
                                        method="post" id="all_delete_form" class="d-flex">
                                        @csrf
                                        <input type="hidden" id="all_delete_id" name="all_delete_id" class="all_delete_id">
                                        <button type="button" id="bulk_delete_btn"
                                            onclick="return confirm('Are you sure to Delete selected orders?')"
                                            class="btn btn-gradient-danger btn-sm d-flex align-items-center gap-1">
                                            <i class="ti ti-trash"></i> Bulk Delete
                                        </button>
                                    </form>
                                @endcan

                                @can('orders.bulk.print')
                                    <form action="{{ route('admin.orders.bulk.print') }}" method="post" id="all_print_form"
                                        class="d-flex">
                                        @csrf
                                        <button type="button" id="bulk_print_btn"
                                            class="btn btn-gradient-info btn-sm d-flex align-items-center gap-1">
                                            <i class="ti ti-printer"></i> Bulk Print
                                        </button>
                                    </form>
                                @endcan
                                {{-- @dd($packaging_sts) --}}
                                @can('orders.bulk.send_courier')
                                    <a href="javascript:void(0);" type="button"
                                        class="btn btn-sm btn-gradient-primary d-flex align-items-center gap-1"
                                        id="send_to_courier">
                                        <i class="ti ti-truck"></i>
                                        Send To Courier</a>
                                @endcan
                            </div>

                            {{-- Right Section --}}
                            <div class="d-flex gap-2 flex-nowrap">
                                @can('orders.bulk.status')
                                    <form action="{{ route('admin.orders.all.status', ['status_update' => 'update']) }}"
                                        method="post" id="all_status_form">
                                        @csrf
                                        <input type="hidden" id="all_status" name="all_status" class="all_status">
                                        <select name="status" id="status" class="form-select form-select-sm cool-select">
                                            <option value="">Select Status</option>
                                            <option value="1">Pending</option>
                                            <option value="2">Confirmed</option>
                                            <option value="3">Processing</option>
                                            <option value="4">Hold</option>
                                            <option value="5">Printed</option>
                                            <option value="6">Packaging</option>
                                            <option value="7">Courier Entry</option>
                                            <option value="8">On Delivery</option>
                                            <option value="9">Delivered</option>
                                            <option value="10">Cancelled</option>
                                            <option value="11">Returned</option>
                                            {{-- <option value="12">Return Received</option> --}}
                                            <option value="13">Exchange</option>

                                        </select>
                                    </form>
                                @endcan

                                @can('orders.courier_export')
                                    <form action="{{ route('admin.orders.courier_csv') }}" method="post"
                                        id="courier-csv-form">
                                        @csrf
                                        <input type="hidden" id="oders_id" name="oders_id">
                                        <select name="status" id="status"
                                            class="form-select form-select-sm cool-select courier_export">
                                            <option value="">Select Export Courier</option>
                                            <option value="1">Stead Fast</option>
                                            <option value="2">Pathao</option>
                                            <option value="3">Redx</option>
                                            <option value="4">CarryBee</option>
                                        </select>
                                    </form>
                                @endcan

                                @can('orders.bulk.assign')
                                    <form action="{{ route('admin.orders.bulk.assign') }}" method="post"
                                        id="bulk_assign_form">
                                        @csrf
                                        <input type="hidden" id="order_id" name="order_id" class="order_id">
                                        <select name="user_id" id="bulk_user_id"
                                            class="form-select form-select-sm cool-select">
                                            <option value="">Assign User</option>
                                            @foreach (DB::table('admins')->where([['status', 1], ['role', 'employee']])->get() as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                @endcan
                            </div>
                        </div>
                        <!-- AJAX Loading Overlay & Container -->
                        <div class="position-relative">
                            <div id="table-loading-spinner"
                                class="position-absolute top-0 start-0 w-100 h-100 bg-white opacity-75 d-none d-flex justify-content-center align-items-center"
                                style="z-index: 100;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <div class="table-responsive order_table" style="height: 100vh; overflow-y: auto;">
                                @include('backEnd.admin.orders.partials.order-table-body', [
                                    'orders' => $data['orders'],
                                    'couriers' => $couriers,
                                ])
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal for Send to Courier -->
    <div class="modal fade" id="sendToCourierModal" tabindex="-1" aria-labelledby="sendToCourierModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
            </div>
        </div>
    </div>

    {{-- bulk send to courier modal --}}
    <div class="modal fade" id="bulkSendToCourierModal" tabindex="-1" aria-labelledby="bulkSendToCourierModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
            </div>
        </div>
    </div>



    {{-- UPDATED: Dynamic Clean Activity Log Modal --}}
    <div class="modal fade" id="orderActivitiesModal" tabindex="-1" aria-labelledby="orderActivitiesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div
                    class="modal-header bg-primary bg-opacity-10 py-3 d-flex align-items-center justify-content-between gap-2">
                    <h5 class="modal-title fw-bold text-capitalize mb-0 lh-1">Order Activities</h5>
                    <button type="button" class="btn-close  opacity-75 btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" id="activityModalBody">
                    {{-- AJAX দিয়ে ডায়নামিক টাইমলাইন কার্ডটি রেন্ডার হবে --}}
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
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


    {{-- Add / Edit Note Modal --}}
    <div class="modal fade" id="noteActionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg overflow-hidden">

                {{-- Modal Header --}}
                <div class="modal-header bg-primary py-2 px-3 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <div
                            class="avatar avatar-xs bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center">
                            <i class="ti ti-notebook fs-5"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-white mb-0 lh-1" id="noteModalTitle">
                                Manage Note
                            </h5>
                            <small class="text-white-50" style="font-size: 0.72rem;">Add or update order notes</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white opacity-75" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                {{-- Form --}}
                <form id="noteActionForm">
                    @csrf
                    <div class="modal-body p-4 bg-light-subtle">

                        {{-- Hidden Inputs --}}
                        <input type="hidden" name="order_id" id="modal_order_id">
                        <input type="hidden" name="note_id" id="modal_note_id">
                        <input type="hidden" name="type" id="modal_note_type">
                        <input type="hidden" name="action" id="modal_action_type">

                        {{-- Note Textarea Group --}}
                        <div class="mb-0">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label fw-bold text-dark small mb-0" id="noteTypeLabel">
                                    <i class="ti ti-pencil me-1 text-primary"></i>Note Content
                                </label>
                                <span class="text-muted font-monospace" style="font-size: 0.72rem;">
                                    <span id="charCount">0</span>/500
                                </span>
                            </div>

                            <textarea name="note" id="modal_note_text"
                                class="form-control border-secondary-subtle rounded-3 shadow-none focus-ring focus-ring-primary" rows="4"
                                maxlength="500" placeholder="Type your detailed note here..." style="font-size: 0.85rem; resize: none;" required></textarea>
                        </div>

                    </div>

                    {{-- Modal Footer --}}
                    <div
                        class="modal-footer py-2 px-4 bg-white border-top border-light-subtle d-flex align-items-center justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveNoteBtn">
                            <i class="ti ti-device-floppy me-1"></i>
                            <span>Save Note</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- 2. View Note History Modal --}}
    <div class="modal fade" id="noteHistoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div id="historyTimeline" class="timeline">
                    {{-- AJAX দিয়ে ডায়নামিক টাইমলাইন আসবে --}}
                </div>
            </div>
        </div>
    </div>


    <!-- Partial Payment Modal (Add this at the bottom of the blade file) -->
    <div class="modal fade" id="partialPaymentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-2 bg-primary text-white">
                    <h5 class="modal-title">Partial Payment Entry</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="partialPaymentForm" method="POST" action="">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Already Paid
                                Amount</label>
                            <input type="text" id="modal_already_paid" class="form-control " readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Current Due
                                Amount</label>
                            <input type="text" id="modal_due_amount" class="form-control border border-secondary"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Paying Amount <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="amount" id="modal_pay_amount"
                                class="form-control" placeholder="Enter amount to pay" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save
                            Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Return Received Stock Modal -->
    <div class="modal fade" id="returnReceiveModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-indigo text-white py-2">
                    <h5 class="modal-title">Return Received & Restock Products</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="returnReceiveForm" action="{{ route('admin.orders.return.restock') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" id="modal_return_order_id">
                    <div class="modal-body" id="returnModalBody">
                        <!-- Dynamic Products Checkbox List will load here -->
                    </div>
                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-sm">Confirm & Restock</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('backEnd/assets/plugin/datepicker/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backEnd/assets/plugin/datepicker/daterangepicker.js') }}"></script>
    <script>
        function changeOrderStatus(select) {
            var $select = $(select);
            var orderId = $select.data('order-id');
            var newStatus = $select.val();
            var oldStatus = $select.data('current-status');
            $select.prop('disabled', true);
            $.ajax({
                url: "{{ route('admin.orders.status', ['__ORDER_ID__', '__STATUS__']) }}"
                    .replace('__ORDER_ID__', orderId)
                    .replace('__STATUS__', newStatus),
                type: "GET",
                success: function(response) {
                    // console.log('Response:', response);
                    if (response.status === 'return_modal') {
                        $('#modal_return_order_id').val(response.order_id);
                        $('#returnModalBody').html(response.html);
                        $('#returnReceiveModal').modal('show');
                    } else {
                        window.location.reload();
                    }

                    // $select
                    //     .removeClass(function(index, className) {
                    //         return (className.match(/(^|\s)status-\S+/g) || []).join(' ');
                    //     })
                    //     .addClass('status-' + newStatus)
                    //     .data('current-status', newStatus);

                    // toastr.success('Order status updated successfully.');
                },

                error: function(xhr) {
                    $select.val(oldStatus);
                    alert('Failed to update order status. Please try again.');
                },

                complete: function() {
                    $select.prop('disabled', false);
                }
            });
        }
        $(document).on('change', '.order-status-select', function(e) {
            changeOrderStatus(this);
        });

        // 1. Header checkbox click korle sob gulo row checkbox toggle hobe
        $(document).on('change', '#selectAllRestock', function() {
            let isChecked = $(this).is(':checked');
            $('.restock-checkbox').prop('checked', isChecked);
        });

        // 2. Proti-ti row checkbox change hole header checkbox- er state update hobe
        $(document).on('change', '.restock-checkbox', function() {
            let totalCheckboxes = $('.restock-checkbox').length;
            let checkedCheckboxes = $('.restock-checkbox:checked').length;

            if (totalCheckboxes === checkedCheckboxes) {
                $('#selectAllRestock').prop('checked', true);
                $('#selectAllRestock').prop('indeterminate', false);
            } else if (checkedCheckboxes === 0) {
                $('#selectAllRestock').prop('checked', false);
                $('#selectAllRestock').prop('indeterminate', false);
            } else {
                // Kichu checkbox checked thakle indeterminate (dash sign) hobe
                $('#selectAllRestock').prop('checked', false);
                $('#selectAllRestock').prop('indeterminate', true);
            }
        });






        //order activities
        $(document).on('click', '.order_activities', function() {
            var orderId = $(this).data('id');
            $.ajax({
                url: '{{ route('admin.orders.activies') }}',
                type: 'POST',
                data: {
                    _token: @json(csrf_token()),
                    order_id: orderId
                },
                success: function(data) {
                    $('#activityModalBody').html(data);
                    $('#orderActivitiesModal').modal('show');
                }
            });
        });


        //bulk_assign_form
        $(document).on('change', '#bulk_assign_form', function() {
            var allVals = [];
            $(".sub_chk:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });
            if (allVals.length <= 0) {
                alert("Please select row.");
            } else {
                $('.order_id').val(allVals);
                $('#bulk_assign_form').submit();
            }
        });

        $(document).on('change', '.city', function() {
            var that = $(this);
            var city_id = $(this).find(':selected').val();
            // console.log(city_id);

            $.ajax({
                url: '{{ route('admin.orders.courier.zone') }}',
                type: 'POST',
                data: {
                    _token: @json(csrf_token()),
                    city_id: city_id
                },
                success: function(data) {
                    that.parents('.card').find('.zone').html(data);
                    that.parents('.card').find('.zone').prop('disabled', false);
                }
            });
        });
    </script>

    <script>
        $(document).on('change', '#bulk_courier_id', function() {

            var allVals = [];
            $(".sub_chk:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });
            var courierId = $(this).val();
            var order_id = $('#order_id').val(allVals);
            var all_ids = order_id.val();
            // alert(order_id.val());
            if (allVals.length <= 0) {
                alert("Please select row.");
            } else {
                $.ajax({
                    url: '{{ Auth::guard('admin')->check() ? route('admin.orders.bulk.send.to.courier') : (Auth::guard('manager')->check() ? route('manager.orders.send.to.courier') : '') }}',
                    type: 'POST',
                    data: {
                        _token: @json(csrf_token()),
                        order_id: all_ids,
                        courier_id: courierId
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Order sent to courier successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1000
                            });
                            $('.table-responsive').load(location.href + ' .table-responsive');

                        } else {
                            $('#bulkSendToCourierModal .modal-content').html(data);
                            $('.zone').prop('disabled', true);
                            $('#bulkSendToCourierModal').modal('show');
                        }
                    }

                });

                // $('#bulk_send_to_courier_form').submit();
            }
        });
    </script>
    <script>
        $('.print').on('click', function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{ route('admin.orders.print') }}',
                type: 'POST',
                data: {
                    _token: @json(csrf_token()),
                    id: $(this).data('id')
                },
                success: function(data) {
                    newWin = window.open("");
                    newWin.document.write(data);
                    newWin.document.close();
                }
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            $('#master').on('click', function(e) {
                // alert(4);
                if ($(this).is(':checked', true)) {
                    // alert(4)
                    $(".sub_chk").prop('checked', true);
                } else {
                    // alert(5)
                    $(".sub_chk").prop('checked', false);
                }
            });


            $('#status').on('change', function(e) {
                var allVals = [];
                $(".sub_chk:checked").each(function() {
                    allVals.push($(this).attr('data-id'));
                });
                // alert(allVals)
                if (allVals.length <= 0) {
                    alert("Please select row.");
                } else {
                    $('.all_status').val(allVals);
                    $('#all_status_form').submit();
                }
            });
            $('#bulk_delete_btn').on('click', function(e) {
                var allVals = [];
                $(".sub_chk:checked").each(function() {
                    allVals.push($(this).attr('data-id'));
                });
                if (allVals.length <= 0) {
                    alert("Please select row.");
                } else {
                    $('.all_delete_id').val(allVals);
                    $('#all_delete_form').submit();
                }
            });

            $('#bulk_print_btn').on('click', function(e) {

                var allVals = [];
                $(".sub_chk:checked").each(function() {
                    allVals.push($(this).attr('data-id'));
                });

                if (allVals.length <= 0) {
                    alert("Please select row.");
                } else {

                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: '{{ route('admin.orders.bulk.print') }}',
                        type: 'POST',
                        data: {
                            _token: @json(csrf_token()),
                            all_inv_id: allVals
                        },
                        success: function(data) {
                            newWin = window.open("");
                            newWin.document.write(data);
                            newWin.document.close();
                        }
                    });
                }
            });

            //courier export
            $('.courier_export').on('change', function(e) {
                // alert($(this).val());
                var allVals = [];
                $(".sub_chk:checked").each(function() {
                    allVals.push($(this).attr('data-id'));
                });

                if (allVals.length <= 0) {
                    alert("Please select row.");
                } else {
                    $('#oders_id').val(allVals);
                    $('#courier-csv-form').submit();
                }
            });
        });
    </script>
    <script>
        // document.addEventListener('DOMContentLoaded', () => {
        //     const counters = document.querySelectorAll('.count-up');
        //     counters.forEach(counter => {
        //         const updateCount = () => {
        //             const target = +counter.getAttribute('data-target');
        //             const count = +counter.innerText;
        //             const increment = target / 200;
        //             if (count < target) {
        //                 counter.innerText = Math.ceil(count + increment);
        //                 requestAnimationFrame(updateCount);
        //             } else {
        //                 counter.innerText = target;
        //             }
        //         };
        //         updateCount();
        //     });
        // });
    </script>
    <script>
        // document.addEventListener("DOMContentLoaded", function() {
        //     const form = document.getElementById("search_form");
        //     const searchInput = document.getElementById("search");

        //     form.querySelectorAll('select').forEach(select => {
        //         select.addEventListener('change', function() {
        //             form.submit();
        //         });
        //     });

        //     searchInput.addEventListener('keydown', function(e) {
        //         if (e.key === 'Enter') {
        //             e.preventDefault();
        //             form.submit();
        //         }
        //     });
        // });
    </script>
    <script>
        //send to courier
        $(document).on('click', '#send_to_courier', function(e) {
            e.preventDefault();

            var allVals = [];
            $(".sub_chk:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });

            if (allVals.length <= 0) {
                alert("Please select at least one row.");
            } else {
                if (confirm("Are you sure you want to send the selected orders to the courier?")) {
                    var ids = allVals.join(',');
                    var url = "{{ route('admin.orders.bulk-ids.send.to.courier') }}?ids=" + ids;
                    window.location.href = url;
                }
            }


        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.successChart').forEach(canvas => {
                const ctx = canvas.getContext('2d');
                const rate = parseInt(canvas.dataset.rate); // e.g. 100
                const orders = canvas.dataset.orders ?? '2 Order'; // optional

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [rate, 100 - rate],
                            backgroundColor: [
                                rate < 30 ? '#e74c3c' :
                                rate < 70 ? '#f1c40f' :
                                '#2ecc71',
                                '#eaeaea'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        cutout: '80%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false
                            }
                        }
                    },
                    plugins: [{
                        id: 'centerText',
                        beforeDraw(chart) {
                            const {
                                ctx,
                                chartArea
                            } = chart;
                            const centerX = (chartArea.left + chartArea.right) / 2;
                            const centerY = (chartArea.top + chartArea.bottom) / 2;

                            ctx.save();

                            // 🔥 Main Percentage
                            ctx.font = 'bold 18px Arial';
                            ctx.fillStyle = '#333';
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';
                            ctx.fillText(rate + '%', centerX, centerY - 6);

                            // 🔹 Sub text (Order)
                            ctx.font = 'normal 11px Arial';
                            ctx.fillStyle = '#777';
                            ctx.fillText(orders, centerX, centerY + 12);

                            ctx.restore();
                        }
                    }]
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.successChart').forEach(canvas => {
                const ctx = canvas.getContext('2d');
                const rate = parseInt(canvas.dataset.rate); // e.g. 100
                const orders = canvas.dataset.orders ?? '2 Order'; // optional

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [rate, 100 - rate],
                            backgroundColor: [
                                rate < 30 ? '#e74c3c' :
                                rate < 70 ? '#f1c40f' :
                                '#2ecc71',
                                '#eaeaea'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        cutout: '80%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false
                            }
                        }
                    },
                    plugins: [{
                        id: 'centerText',
                        beforeDraw(chart) {
                            const {
                                ctx,
                                chartArea
                            } = chart;
                            const centerX = (chartArea.left + chartArea.right) / 2;
                            const centerY = (chartArea.top + chartArea.bottom) / 2;

                            ctx.save();

                            // 🔥 Main Percentage
                            ctx.font = 'bold 18px Arial';
                            ctx.fillStyle = '#333';
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';
                            ctx.fillText(rate + '%', centerX, centerY - 6);

                            // 🔹 Sub text (Order)
                            ctx.font = 'normal 11px Arial';
                            ctx.fillStyle = '#777';
                            ctx.fillText(orders, centerX, centerY + 12);

                            ctx.restore();
                        }
                    }]
                });
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

            // ১. রেডিও বাটন সিলেক্ট করলে কাস্টম টেক্সট ইনপুট হাইড/শো করার লজিক
            $(document).on('change', '.staff-preset-radio', function() {
                let val = $(this).val();
                if (val === 'other') {
                    $('#customNoteInputGroup').removeClass('d-none');
                    $('#modal_note_text').val('').attr('required', true).focus();
                } else {
                    $('#customNoteInputGroup').addClass('d-none');
                    $('#modal_note_text').val(val).removeAttr('required');
                }
            });

            // ২. Modal Open Handler (Add / Edit Note Modal)
            $(document).on('click', '.btn-note-action', function() {
                let action = $(this).data('action'); // 'add' or 'edit'
                let type = $(this).data('type'); // 'staff' or 'customer'
                let orderId = $(this).data('order-id');
                let noteId = $(this).data('note-id') || '';
                let noteText = $(this).data('note-text') || '';

                $('#modal_order_id').val(orderId);
                $('#modal_note_id').val(noteId);
                $('#modal_note_type').val(type);
                $('#modal_action_type').val(action);

                $('#noteModalTitle').text((action === 'edit' ? 'Edit ' : 'Add ') + (type === 'staff' ?
                    'Staff' : 'Customer') + ' Note');
                $('#noteTypeLabel').text((type === 'staff' ? 'Staff Note' : 'Customer Note'));
                $('#modal_note_text').val(noteText);

                $('#noteActionModal').modal('show');
            });

            // ৩. Submit Add/Edit Note Form via AJAX
            $(document).on('submit', '#noteActionForm', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                let actionType = $('#modal_action_type').val();
                let noteId = $('#modal_note_id').val();

                let url = (actionType === 'edit' && noteId) ?
                    "{{ url('admin/orders/notes/update') }}/" + noteId :
                    "{{ route('admin.orders.notes.store') }}";

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        if (response.status === 200) {
                            $('#noteActionModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            // Reload grid or updated area
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Something went wrong. Please check your inputs.');
                    }
                });
            });

            // ৪. View Note History Modal AJAX
            $(document).on('click', '.btn-note-history', function() {
                // alert('clicked');
                let orderId = $(this).data('order-id');
                let type = $(this).data('type');

                $('#historyModalTitle').text((type === 'staff' ? 'Staff' : 'Customer') + ' Note History');

                $.ajax({
                    url: "{{ route('admin.orders.notes.history') }}",
                    type: 'GET',
                    data: {
                        order_id: orderId,
                        type: type
                    },
                    success: function(data) {
                        $('#historyTimeline').html(data);
                        $('#noteHistoryModal').modal('show');
                    }
                });
            });
            // Live Character Counter for Note Textarea
            $('#modal_note_text').on('input', function() {
                let currentLength = $(this).val().length;
                $('#charCount').text(currentLength);
            });


        });
    </script>

    <script>
        function changePerPage(perPage) {
            let currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('per_page', perPage);
            currentUrl.searchParams.set('page', 1); // Reset to page 1 on limit change
            window.location.href = currentUrl.toString();
        }
    </script>
    <script>
        $(document).ready(function() {

            /* ==========================================================================
               1. INITIAL SETUP & DATE RANGE PICKER
               ========================================================================== */
            let hasRange = "{{ $start && $end ? 'yes' : '' }}";
            let start = hasRange ? moment("{{ $start }}") : null;
            let end = hasRange ? moment("{{ $end }}") : null;

            function updateDisplay(start, end) {
                $('.date_range_display').val(
                    start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY')
                );

                // Controller-এ পাঠাতে ডেট অবজেক্ট ফরম্যাট
                $('#date_range').val(JSON.stringify({
                    start: start.format('YYYY-MM-DD'),
                    end: end.format('YYYY-MM-DD')
                }));
            }

            $('.date_range_display').daterangepicker({
                startDate: start || moment(),
                endDate: end || moment(),
                autoUpdateInput: false,
                opens: 'left',
                locale: {
                    format: 'MMM D, YYYY'
                },
                alwaysShowCalendars: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            });

            // Apply Date Filter
            $('.date_range_display').on('apply.daterangepicker', function(ev, picker) {
                updateDisplay(picker.startDate, picker.endDate);
                fetchFilteredOrders();
            });

            // Clear Date Filter
            $('.date_range_display').on('cancel.daterangepicker', function() {
                $(this).val('');
                $('#date_range').val('');
                fetchFilteredOrders();
            });

            if (start && end) {
                updateDisplay(start, end);
            }

            /* ==========================================================================
               2. CHART.JS RE-RENDER FUNCTION (Fixes Chart Disappearing on Ajax)
               ========================================================================== */
            function renderSuccessCharts() {
                document.querySelectorAll('.successChart').forEach(canvas => {
                    // আগের চার্ট থাকলে তা ডেস্ট্রয় করে নতুন করে আকবে
                    let existingChart = Chart.getChart(canvas);
                    if (existingChart) {
                        existingChart.destroy();
                    }

                    const ctx = canvas.getContext('2d');
                    const rate = parseInt(canvas.dataset.rate) || 0;
                    const orders = canvas.dataset.orders ?? '0 Order';

                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            datasets: [{
                                data: [rate, Math.max(0, 100 - rate)],
                                backgroundColor: [
                                    rate < 30 ? '#e74c3c' : rate < 70 ? '#f1c40f' :
                                    '#2ecc71',
                                    '#eaeaea'
                                ],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            cutout: '80%',
                            responsive: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    enabled: false
                                }
                            }
                        },
                        plugins: [{
                            id: 'centerText',
                            beforeDraw(chart) {
                                const {
                                    ctx,
                                    chartArea
                                } = chart;
                                const centerX = (chartArea.left + chartArea.right) / 2;
                                const centerY = (chartArea.top + chartArea.bottom) / 2;

                                ctx.save();
                                ctx.font = 'bold 12px Sans-Serif';
                                ctx.fillStyle = '#333';
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';
                                ctx.fillText(rate + '%', centerX, centerY - 4);

                                ctx.font = 'normal 9px Sans-Serif';
                                ctx.fillStyle = '#777';
                                ctx.fillText(orders, centerX, centerY + 10);
                                ctx.restore();
                            }
                        }]
                    });
                });
            }

            // Initial Chart Load
            renderSuccessCharts();

            /* ==========================================================================
               3. AJAX FETCH FUNCTION FOR FILTERING & PAGINATION
               ========================================================================== */
            function fetchFilteredOrders(url = null) {
                let fetchUrl = url || "{{ route('admin.orders') }}";
                let formData = $('#search_form').serialize();

                $('#table-loading-spinner').removeClass('d-none');

                $.ajax({
                    url: fetchUrl,
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        // DOM Update
                        $('.table-responsive.order_table').html(response.table_html);
                        if (response.counter_html) {
                            $('.status-counter-wrapper').html(response.counter_html);
                        }

                        $('#table-loading-spinner').addClass('d-none');

                        // Re-render Chart.js
                        renderSuccessCharts();

                        // URL update without refreshing page
                        let newUrl = fetchUrl + (fetchUrl.includes('?') ? '&' : '?') + formData;
                        window.history.pushState({
                            path: newUrl
                        }, '', newUrl);
                    },
                    error: function() {
                        $('#table-loading-spinner').addClass('d-none');
                        console.error('Error fetching filtered orders');
                    }
                });
            }

            /* ==========================================================================
               4. EVENT LISTENERS (Inputs, Status Tabs, Reset)
               ========================================================================== */

            // Direct Input / Select Filters Trigger Ajax
            $(document).on('keyup change', '#search_form input:not(.date_range_display), #search_form select',
                function() {
                    // ফিল্টার করলে স্ট্যাটাস নির্বাচন করা না থাকলে 'total' active হবে
                    let currentStatus = $('input[name="status"]').val();
                    if (!currentStatus || currentStatus === 'pending') {
                        // নির্দিষ্ট ফিল্টার দিলে Total Active হবে
                        if ($('#search_form input[name="query"]').val() || $(
                                '#search_form select[name="courier_id"]').val()) {
                            $('input[name="status"]').val('total');
                        }
                    }
                    fetchFilteredOrders();
                });

            // Status Tab Click Event
            $(document).on('click', '.status-card-link', function(e) {
                e.preventDefault();
                let selectedStatus = $(this).data('status');

                // Form-এর Hidden input-এ status বসানো
                if ($('input[name="status"]').length === 0) {
                    $('#search_form').append(
                        `<input type="hidden" name="status" value="${selectedStatus}">`);
                } else {
                    $('input[name="status"]').val(selectedStatus);
                }

                // Active CSS toggle
                $('.status-card-link').removeClass('active');
                $(this).addClass('active');

                fetchFilteredOrders();
            });

            // Reset Search Button Click (Back to Default Initial State)
            $(document).on('click', '#reset_search', function(e) {
                e.preventDefault();

                // 1. Form inputs reset
                $('#search_form')[0].reset();

                // 2. Clear Hidden Inputs
                $('#search_form input[type="hidden"]').val('');

                // 3. Set Default Status to Pending (প্রথমবারের স্টেট)
                if ($('input[name="status"]').length === 0) {
                    $('#search_form').append('<input type="hidden" name="status" value="pending">');
                } else {
                    $('input[name="status"]').val('pending');
                }

                // 4. Reset Date Display & Inputs
                $('.date_range_display').val('');
                $('#date_range').val('');

                // 5. Fetch Initial Orders List
                fetchFilteredOrders("{{ route('admin.orders') }}");
            });

            // Handle Pagination Clicks via Ajax
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let pageUrl = $(this).attr('href');
                if (pageUrl) {
                    fetchFilteredOrders(pageUrl);
                }
            });


            // ==========================================
            // ৩. Per Page Input Handler (AJAX Trigger)
            // ==========================================
            $(document).on('change', '#perPageInput', function() {
                let perPage = $(this).val();
                if (perPage > 0) {
                    let query = $.trim($('#searchInput').val());
                    fetchFilteredOrders("{{ route('admin.orders') }}?per_page=" + perPage + "&query=" +
                        encodeURIComponent(query));
                }
            });

            $(document).on('keydown', '#perPageInput', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    $(this).trigger('change');
                }
            });

            // ==========================================
            // ৪. Pagination Click Event (Preserving Parameters)
            // ==========================================
            $(document).on('click', '#table_data .pagination a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                if (!url || url === '#') return;

                let page = 1;
                try {
                    let urlObj = new URL(url, window.location.origin);
                    page = urlObj.searchParams.get('page') || 1;
                } catch (err) {
                    let match = url.match(/page=(\d+)/);
                    if (match) page = match[1];
                }

                let query = $.trim($('#searchInput').val());
                let perPage = $('#perPageInput').val() || 20;

                fetchFilteredOrders("{{ route('admin.orders') }}?page=" + page + "&per_page=" + perPage +
                    "&query=" + encodeURIComponent(query));
            });



        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Confirm Alert for Paid Status
        function confirmPaid(url) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to mark this order as PAID?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#206bc4',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Mark as Paid!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }

        // Open Partial Payment Modal
        function openPartialModal(orderId, dueAmount, paidAmount) {
            let routeUrl = "{{ route('admin.orders.payment.partial', [':id', 2]) }}".replace(':id', orderId);

            $('#partialPaymentForm').attr('action', routeUrl);
            $('#modal_already_paid').val(paidAmount);
            $('#modal_due_amount').val(dueAmount);
            $('#modal_pay_amount').val('').attr('max', dueAmount);

            var partialModal = new bootstrap.Modal(document.getElementById('partialPaymentModal'));
            partialModal.show();
        }
    </script>
@endpush
@push('css')
    <style>
        .duplicate-order {
            background-color: #fde2e2 !important;
            border-left: 4px solid #dc3545;
        }
    </style>
@endpush
