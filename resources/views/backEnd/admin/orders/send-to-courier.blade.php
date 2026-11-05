@extends('backEnd.admin.layouts.master')
@section('title', 'Send To Courier')

@section('content')
    <div class="m-3 page-body">
        <div class="my-3 row send-courier-header-row">
            <div class="flex-wrap gap-2 col-12 d-flex justify-content-between align-items-center">
                <div class="gap-2 d-flex align-items-center">
                    <h3 class="send-courier-title">Send To Courier</h3>
                    {{-- Print Invoice Form --}}
                    {{-- @can('order_bulk_print')
                        <form action="{{ route('master.orders.bulk.print') }}" method="POST" id="all_print_form" target="_blank">
                            @csrf
                            @foreach ($ordersIds as $id)
                                <input type="hidden" name="all_inv_id[]" value="{{ $id }}">
                            @endforeach

                            <button type="submit" class="btn btn-info custom-btn">
                                Print Invoice
                            </button>
                        </form>
                    @endcan --}}

                    {{-- Print POS Form --}}
                    {{-- @can('order_bulk_print')
                        <form action="{{ route('master.pos.bulk.print') }}" method="post" id="all_pos_print_form"
                            target="_blank">
                            @csrf

                            @foreach ($ordersIds as $id)
                                <input type="hidden" name="all_inv_id[]" value="{{ $id }}">
                            @endforeach
                            <div class="form-group">
                                <button type="button" id="bulk_pos_print_btn" class="btn btn-warning custom-btn">
                                    Print POS
                                </button>
                            </div>
                        </form>
                    @endcan --}}
                </div>
                <div class="flex-wrap gap-2 d-flex justify-content-end align-items-center send-courier-actions">
                    <!-- Summary Buttons -->
                    <div id="courierSummary" class="flex-wrap gap-2 d-flex send-courier-summary">
                        <button class="btn btn-outline-dark btn-sm summary-chip" disabled>
                            Total: <span id="totalCount">0</span>
                        </button>
                        <button class="btn btn-outline-success btn-sm summary-chip" disabled>
                            ✅ Success: <span id="successCount">0</span>
                        </button>
                        <button class="btn btn-outline-danger btn-sm summary-chip" disabled>
                            ❌ Failed: <span id="failedCount">0</span>
                        </button>
                    </div>

                    <!-- Action Buttons -->
                    <button class="btn btn-success btn-sm d-none" id="submitToCourier">
                        <i class='bx bx-revision'></i> Re-Submit
                    </button>
                    <a href="{{ route('admin.orders') }}" class="btn btn-danger btn-sm d-none" id="backToList">
                        <i class='bx bxs-share'></i> Back
                    </a>
                </div>

            </div>
        </div>
        <div class="shadow-sm card send-courier-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle table-bordered table-hover send-courier-table" id="courierTable">
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Invoice No</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Location</th>
                                <th>Courier</th>
                                <th>Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $index => $order)
                                <tr data-id="{{ $order->id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>

                                        <span class="badge bg-success">
                                            {{ $order->invoice_id }}
                                        </span>
                                    </td>
                                    <td class="text-start">
                                        <b>Name: </b>{{ $order->customer_name ?? '' }}<br>
                                        <b>Phone: </b>{{ $order->customer_phone ?? '' }}
                                        <a href="tel:{{ $order->customer_phone ?? '' }}">
                                            <i class="fas fa-phone"></i>
                                        </a>
                                        <br><b>Address: </b>{{ $order->customer_address ?? '' }}
                                    </td>
                                    <td>{{ number_format($order->total, 2) }}</td>
                                    <td>
                                        <b>Search City / Zone:</b>
                                        <select class="form-control form-control-sm city-zone-dropdown select2">
                                            <option value="">--Search--</option>
                                            @foreach ($cityZones as $cz)
                                                <option value="{{ $cz->city_id }}_{{ $cz->zone_id }}">
                                                    {{ $cz->city_name }} → {{ $cz->zone_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($order->courier_id == 2)
                                            @php
                                                $currentCity = $pathaoCities[$order->courier_city_id] ?? '';
                                                $currentZone = $pathaoZones[$order->courier_zone_id] ?? '';
                                            @endphp
                                            @if ($currentCity || $currentZone)
                                                <span class="pt-2 current-location d-block">{{ $currentCity }} →
                                                    {{ $currentZone }}</span>
                                            @endif
                                        @elseif($order->courier_id == 4)
                                            @php
                                                $currentCity = $carrybeeCities[$order->courier_city_id] ?? '';
                                                $currentZone = $carrybeeZones[$order->courier_zone_id] ?? '';
                                            @endphp
                                            @if ($currentCity || $currentZone)
                                                <span class="pt-2 current-location d-block">{{ $currentCity }} →
                                                    {{ $currentZone }}</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order->consignment_id)
                                            <span
                                                class="badge bg-secondary consignment-id">{{ $order->consignment_id }}</span>
                                            <br>
                                        @endif
                                        <span
                                            class="courier-name">{{ $order->get_courier ? $order->get_courier->courier_name : '---' }}</span>
                                    </td>
                                    <td class="text-center align-middle result-cell">
                                        <div class="spinner-border d-none" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <span class="result-text"></span>
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

@push('css')
    <style>
        .send-courier-header-row {
            margin-top: 0 !important;
            margin-bottom: 0.9rem !important;
        }

        .send-courier-title {
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        .send-courier-summary {
            position: relative;
            transition: all 0.25s ease;
            z-index: 1050;
        }

        .send-courier-summary.sticky {
            position: fixed;
            top: 70px;
            right: 20px;
            background: #ffffff;
            border: 1px solid #e8ebf0;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
            padding: 8px;
        }

        .send-courier-summary .summary-chip {
            border-radius: 999px;
            font-weight: 600;
            padding: 0.3rem 0.7rem;
        }

        .send-courier-card {
            border: 1px solid #eceff3;
            border-radius: 12px;
            overflow: hidden;
        }

        .send-courier-table thead th {
            white-space: nowrap;
            font-size: 0.83rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            background: #f8fafc;
        }

        .send-courier-table tbody td {
            vertical-align: middle;
            font-size: 0.92rem;
        }

        .send-courier-table tbody tr:nth-child(2n) {
            background: #fbfdff;
        }

        .send-courier-table .result-cell {
            min-width: 190px;
        }

        .send-courier-table .current-location {
            color: #0f766e;
            font-weight: 600;
            font-size: 0.84rem;
        }

        .send-courier-table .badge {
            font-size: 0.75rem;
        }

        .select2-container {
            width: 100% !important;
        }

        @media (max-width: 991.98px) {
            .send-courier-summary.sticky {
                top: auto;
                bottom: 12px;
                right: 12px;
                max-width: calc(100vw - 24px);
            }

            .send-courier-actions {
                width: 100%;
            }

            .send-courier-actions .btn {
                flex: 1 1 auto;
            }

            .send-courier-table .result-cell {
                min-width: 150px;
            }
        }
    </style>
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            const summary = document.getElementById('courierSummary');
            const offsetTop = summary ? summary.offsetTop : 0;

            window.addEventListener('scroll', function() {
                if (!summary) {
                    return;
                }

                if (window.scrollY >= offsetTop) {
                    summary.classList.add('sticky');
                } else {
                    summary.classList.remove('sticky');
                }
            });

            // Initialize Select2
            $('.city-zone-dropdown').select2({
                width: '100%',
                placeholder: "Search...",
                allowClear: true
            });

            var isProcessing = false;
            courierEntry();

            function courierEntry() {
                var rows = $('#courierTable tbody tr').toArray();
                var totalSuccess = 0;
                var totalFailed = 0;

                // Hide re-submit button at start
                $('#totalCount').text(rows.length);

                isProcessing = true; // mark processing started

                function updateSummary() {
                    $('#successCount').text(totalSuccess);
                    $('#failedCount').text(totalFailed);
                }

                function sendRow(index) {
                    if (index >= rows.length) {
                        isProcessing = false;

                        // Show re-submit button if any failures
                        if (totalFailed > 0) {
                            $('#submitToCourier').removeClass('d-none');
                        } else {
                            $('#backToList').removeClass('d-none');
                            alert("✅ All rows processed successfully!");
                        }
                        return;
                    }

                    var row = $(rows[index]);
                    var orderId = row.data('id');
                    var selected = row.find('.city-zone-dropdown').val();
                    var parts = selected ? selected.split('_') : [null, null];
                    var spinner = row.find('.spinner-border');
                    var resultText = row.find('.result-text');
                    var courierNameEl = row.find('.courier-name');
                    var consignmentEl = row.find('.consignment-id');

                    spinner.removeClass('d-none');
                    resultText.addClass('d-none');

                    // Auto scroll to current row
                    $('html, body').animate({
                        scrollTop: row.offset().top - 100
                    }, 300);

                    $.ajax({
                        url: "{{ route('admin.ordercourier.send.row') }}",
                        type: "POST",
                        data: {
                            order_id: orderId,
                            city_id: parts[0],
                            zone_id: parts[1],
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            spinner.addClass('d-none');
                            if (res.status) {
                                resultText
                                    .removeClass('d-none text-muted text-danger')
                                    .addClass('text-success')
                                    .text('✅ ' + res.message);

                                totalSuccess++;
                                updateSummary();

                                if (res.consignment_id) {
                                    if (consignmentEl.length) {
                                        consignmentEl.text(res.consignment_id);
                                    } else {
                                        row.find('td:nth-child(6)').prepend(
                                            '<span class="badge bg-secondary consignment-id">' + res
                                            .consignment_id + '</span><br>');
                                    }
                                }
                                courierNameEl.text(res.courier ?? courierNameEl.text());
                            } else {
                                resultText
                                    .removeClass('d-none text-muted text-success')
                                    .addClass('text-danger')
                                    .text('❌ ' + (res.message || 'Failed'));

                                totalFailed++;
                                updateSummary();
                            }
                            setTimeout(() => sendRow(index + 1), 1000);
                        },
                        error: function(xhr, status, error) {
                            spinner.addClass('d-none');

                            // Try to parse JSON from response
                            let message = '❌ Error';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = '❌ ' + xhr.responseJSON.message;
                            } else if (xhr.responseText) {
                                message = '❌ ' + xhr.responseText;
                            }
                            resultText
                                .removeClass('d-none text-muted text-success')
                                .addClass('text-danger')
                                .text(message);

                            totalFailed++;
                            updateSummary();
                            setTimeout(() => sendRow(index + 1), 1000);
                        }
                    });
                }

                sendRow(0); // start sending from first row
            }

            // Submit button click
            $('#submitToCourier').on('click', function() {
                courierEntry();
            });

            // Warn user if they try to reload or leave page
            window.addEventListener('beforeunload', function(e) {
                if (isProcessing) {
                    e.preventDefault();
                    e.returnValue = "⚠️ Courier process is running. Are you sure you want to leave?";
                }
            });


        });
    </script>
    <script>
        $(document).ready(function() {
            // Invoice প্রিন্ট বাটন
            $('#bulk_print_btn').on('click', function(e) {
                e.preventDefault();
                $('#all_print_form').submit();
            });

            // POS প্রিন্ট বাটন
            $('#bulk_pos_print_btn').on('click', function(e) {
                e.preventDefault();
                $('#all_pos_print_form').submit();
            });
        });
    </script>
@endpush
