@extends('backEnd.admin.layouts.master')

@section('title')
    Trashed Orders
@endsection
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('backEnd/assets/plugin/datepicker/daterangepicker.css') }}" />
@endpush

@section('content')
    <div class="page-body mt-3">
        <div class="container-xl">
            <div class="row">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h2 class="page-title">
                        Trashed Orders
                    </h2>
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center gap-1">
                            <span class="fw-bold">Total:</span>
                            <span class="badge bg-primary text-white">{{ $orders->total() }}</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row row-deck rounded row-cards mt-2">
                <div class="card mt-0" style="border-top: none">
                    <div class="buttons d-flex flex-nowrap gap-2 overflow-auto border-bottom align-items-start px-3 py-2">

                        {{-- bulk restore --}}
                        @can('orders.bulk.restore')
                            <form action="{{ route('orders.trash.bulk.action', ['status_delete' => 'restore']) }}"
                                method="post" id="all_restore_form" class="d-flex">
                                @csrf
                                <input type="hidden" id="all_restore_id" name="all_restore_id" class="all_restore_id">
                                <button type="button" id="bulk_restore_btn"
                                    onclick="return confirm('Are you sure to Restore selected orders?')"
                                    class="btn btn-gradient-success btn-sm d-flex align-items-center gap-1">
                                    <i class="ti ti-reload"></i> Bulk Restore
                                </button>
                            </form>
                        @endcan

                        {{-- bulk delete --}}
                        @can('orders.bulk.delete')
                            <form action="{{ route('orders.trash.bulk.action', ['status_delete' => 'delete']) }}" method="post"
                                id="all_delete_form" class="d-flex">
                                @csrf
                                <input type="hidden" id="all_delete_id" name="all_delete_id" class="all_delete_id">
                                <button type="button" id="bulk_delete_btn"
                                    onclick="return confirm('Are you sure to Delete selected orders?')"
                                    class="btn btn-gradient-danger btn-sm d-flex align-items-center gap-1">
                                    <i class="ti ti-trash"></i> Bulk Delete
                                </button>
                            </form>
                        @endcan
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

                            @include('backEnd.admin.trash.order-table-body', [
                                'orders' => $orders,
                                // 'couriers' => $couriers,
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
@endsection

@push('js')
    <script src="{{ asset('backEnd/assets/plugin/datepicker/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backEnd/assets/plugin/datepicker/daterangepicker.js') }}"></script>
    <script>
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
        $('#bulk_restore_btn').on('click', function(e) {
            var allVals = [];
            $(".sub_chk:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });
            if (allVals.length <= 0) {
                alert("Please select row.");
            } else {
                $('.all_restore_id').val(allVals);
                $('#all_restore_form').submit();
            }
        });
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
