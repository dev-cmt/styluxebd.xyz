@extends('backEnd.admin.layouts.master')
@section('title')
    IP Address
@endsection
@section('content')
    <div class="page-body mt-3">
        <div class="container-xl">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h2 class="m-0"> IP Address</h2>
                <div class="d-flex align-items-center gap-2">
                    <div class="d-flex align-items-center gap-1">
                        <span class="fw-bold">Total:</span>
                        <span class="badge bg-primary text-white" id="total_count_badge">{{ $data->total() }}</span>
                    </div>
                </div>

            </div>
            <div class="row">
                <!-- Page Header Close -->
                <div class="col-md-12 col-12 mb-3">
                    <div class="card" style="border-top:none">
                        <div class="card-header d-flex justify-content-between  align-items-center gap-2 flex-wrap py-2">
                            {{-- Clean Production Bulk Delete Button --}}
                            @can('ip_address.delete')
                                <button type="button" id="bulk_delete_btn"
                                    class="btn btn-gradient-danger btn-sm d-flex align-items-center gap-1">
                                    <i class="ti ti-trash"></i> Bulk Delete
                                    <span id="selected_count" class="badge bg-white text-danger ms-1 d-none">0</span>
                                </button>
                            @endcan
                            <div class="search">
                                {{-- Live Search Input --}}
                                <div class="d-flex gap-1">
                                    <input type="text" class="form-control form-control-sm search-input cool-select"
                                        id="searchInput" placeholder="Search devices..." autocomplete="off"
                                        value="{{ request()->get('search', '') }}">
                                    {{-- Reset Button --}}
                                    <a href="{{ route('admin.ip.address') }}"
                                        class="btn btn-gradient-dark btn-sm d-flex align-items-center gap-1"
                                        title="Reset Search">
                                        <i class="ti ti-refresh"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        {{-- Table Section Container --}}
                        <div class="table-responsive" id="table_container">
                            <div id="table_data">
                                @include('backEnd.admin.ip-address.partials.table', ['data' => $data])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            let searchTimer = null;
            // ==========================================
            // ১. Universal AJAX Fetch Function
            // ==========================================
            function fetchIPAddresses(page = 1, search = '', perPage = null) {
                // যদি perPage ম্যানুয়ালি না পাঠানো হয়, ইনপুট থেকে তুলে নেবে
                if (!perPage) {
                    perPage = $('#perPageInput').val() || 20;
                }
                let loaderHtml = `
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                                <div class="spinner-border text-primary" role="status" style="width: 2.2rem; height: 2.2rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <span class="fw-semibold text-secondary small">Searching...</span>
                            </div>
                        </td>
                    </tr>
                `;
                $('#ip_address_table_body').html(loaderHtml);

                $.ajax({
                    url: "{{ route('admin.ip.address') }}?page=" + page +
                        "&search=" + encodeURIComponent(search) +
                        "&per_page=" + perPage,
                    type: "GET",
                    dataType: "json",
                    success: function(res) {
                        $('#table_data').css('opacity', '0.4');
                        setTimeout(function() {
                            $('#table_data').html(res.html).css('opacity', '1');

                            // 🔥 সার্চ কুয়েরি থাকলে টেক্সট কালারিং/হাইলাইট হ্যান্ডেল করবে
                            let currentSearch = $.trim($('#searchInput').val());
                            if (currentSearch.length > 0) {
                                highlightTableText(currentSearch);
                            }

                        }, 100);
                        $('#total_count_badge').text(res.total);
                        // Reset Checkboxes
                        $('#selected_count').addClass('d-none').text(0);
                        $('#master').prop('checked', false);
                    },
                    error: function(xhr) {
                        console.error('Fetch Error:', xhr);
                        $('#table_data').css('opacity', '1');
                    }
                });
            }
            // ==========================================
            // ২. Real-Time Search Debounce Input
            // ==========================================
            $(document).on('keyup input', '#searchInput', function() {
                clearTimeout(searchTimer);
                let query = $.trim($(this).val());

                searchTimer = setTimeout(function() {
                    if (query.length >= 3) {
                        fetchIPAddresses(1, query);
                    } else if (query.length === 0) {
                        fetchIPAddresses(1, '');
                    }
                }, 400);
            });

            // ==========================================
            // ৩. Per Page Input Handler (AJAX Trigger)
            // ==========================================
            $(document).on('change', '#perPageInput', function() {
                let perPage = $(this).val();
                if (perPage > 0) {
                    let query = $.trim($('#searchInput').val());
                    fetchIPAddresses(1, query, perPage);
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

                fetchIPAddresses(page, query, perPage);
            });

            // ==========================================
            // Text Highlight Helper Function
            // ==========================================
            function highlightTableText(keyword) {
                if (!keyword || keyword.length < 1) return;

                // টার্গেটেড সেলগুলোতে হাইলাইট প্রয়োগ (SL, Action বা Button বাদ দিয়ে)
                $('#ip_address_table_body tr').each(function() {
                    $(this).find('td').not('.sl-cell, :last-child').each(function() {
                        // বাটন, লিংক বা ফর্ম ইনপুটের ভেতরের HTML নস্ট না করার জন্য safe node replace
                        let node = $(this);
                        let html = node.html();

                        // RegEx দিয়ে Case-Insensitive matching
                        let regex = new RegExp('(' + escapeRegExp(keyword) + ')', 'gi');

                        // HTML ট্যাগগুলোর ক্ষতি না করে শুধু টেক্সট নোড কালার করা
                        let newHtml = html.replace(regex,
                            '<mark class="search-highlight">$1</mark>');
                        node.html(newHtml);
                    });
                });
            }

            // Special character escaping for RegEx
            function escapeRegExp(string) {
                return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
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
                            url: "{{ route('admin.ip.address.bulk.delete') }}",
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
