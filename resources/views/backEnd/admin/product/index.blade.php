@extends('backEnd.admin.layouts.master')
@section('title')
    Products
@endsection
@section('content')
    <div class="page-body mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h2 class="page-title">
                        Product List
                        </h3>
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-flex align-items-center gap-1">
                                <span class="fw-bold">Total:</span>
                                <span class="badge bg-primary text-white">{{ $products->total() }}</span>
                            </div>
                        </div>
                </div>
            </div>

            <div class="row row-deck row-cards mt-2 product-index">
                <div class="col-12 m-0">
                    <div class="card  shadow-sm  rounded" style="border-top: none">
                        <div class="card-header bg-white border-bottom py-2 px-3 d-flex justify-content-between">
                            <div class="action-btn mb-lg-0 mb-2 d-flex gap-2">
                                @can('products.create')
                                    <a href="{{ route('admin.product.create') }}" class="btn btn-success btn-sm">
                                        <i class="ti ti-plus"></i> Add Product
                                    </a>
                                @endcan
                                @can('products.delete')
                                    <button type="button" id="bulk_delete_btn"
                                        class="btn btn-gradient-danger btn-sm d-flex align-items-center gap-1">
                                        <i class="ti ti-trash"></i> Bulk Delete
                                        <span id="selected_count" class="badge bg-white text-danger ms-1 d-none">0</span>
                                    </button>
                                @endcan
                            </div>

                            {{-- Search and Filter Area --}}
                            <div class="search-section d-flex gap-2">
                                <select class="form-select form-select-sm cool-select me-1" name="status"
                                    id="product_status">
                                    <option value="">-- All Status --</option>
                                    <option value="1" {{ request()->status === '1' ? 'selected' : '' }}>Published
                                    </option>
                                    <option value="0" {{ request()->status === '0' ? 'selected' : '' }}>Unpublished
                                    </option>
                                </select>

                                <input type="text" class="form-control form-control-sm search-input cool-select"
                                    id="searchInput" placeholder="Search products..." autocomplete="off"
                                    value="{{ request()->get('search', '') }}">

                                <a href="{{ route('admin.product') }}"
                                    class="btn btn-gradient-dark btn-sm d-flex align-items-center gap-1"
                                    title="Reset Filters">
                                    <i class="ti ti-refresh"></i>
                                </a>
                            </div>
                        </div>

                        {{-- Table Section Container --}}
                        <div class="table-responsive" id="table_container">
                            <div id="table_data">
                                @include('backEnd.admin.product.partials.table', ['products' => $products])
                            </div>
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
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            let searchTimer = null;

            // ==========================================
            // ১. Universal AJAX Fetch Function (Search + Status + Per Page)
            // ==========================================
            function fetchProducts(page = 1) {
                let search = $.trim($('#searchInput').val());
                let status = $('#product_status').val();
                let perPage = $('#perPageInput').val() || 20;

                let loaderHtml = `
                <tr>
                    <td colspan="11" class="text-center py-5">
                        <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                            <div class="spinner-border text-primary" role="status" style="width: 2.2rem; height: 2.2rem;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <span class="fw-semibold text-secondary small">Searching...</span>
                        </div>
                    </td>
                </tr>
            `;
                $('#product_table_body').html(loaderHtml);

                $.ajax({
                    url: "{{ route('admin.product') }}",
                    type: "GET",
                    data: {
                        page: page,
                        search: search,
                        status: status,
                        per_page: perPage
                    },
                    dataType: "json",
                    success: function(res) {
                        $('#table_data').css('opacity', '0.4');
                        setTimeout(function() {
                            $('#table_data').html(res.html).css('opacity', '1');

                            if (search.length > 0) {
                                highlightTableText(search);
                            }
                        }, 100);

                        $('#total_count_badge').text(res.total);
                        $('.badge.bg-primary.text-white').text(res.total);

                        // Reset Selection
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
            // ২. Input & Select Event Listeners
            // ==========================================

            // Real-Time Search Debounce Input
            $(document).on('keyup input', '#searchInput', function() {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(function() {
                    fetchProducts(1);
                }, 400);
            });

            // Status Select Change Event
            $(document).on('change', '#product_status', function() {
                fetchProducts(1);
            });

            // Per Page Change Event
            $(document).on('change', '#perPageInput', function() {
                fetchProducts(1);
            });

            $(document).on('keydown', '#perPageInput', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    fetchProducts(1);
                }
            });

            // Pagination Click Event
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

                fetchProducts(page);
            });

            // Highlighting helper function
            function highlightTableText(keyword) {
                if (!keyword || keyword.length < 1) return;

                let regex = new RegExp('(' + escapeRegExp(keyword) + ')', 'gi');

                $('#product_table_body tr').each(function() {
                    $(this).find('td').not('.sl-cell, :last-child').each(function() {

                        // সেল-এর মধ্যকার কেবল টেক্সট নোডগুলো (Text Nodes) ফিল্টার করবে
                        $(this).find('*').addBack().contents().filter(function() {
                            return this.nodeType === 3 && this.nodeValue.trim().length > 0;
                        }).each(function() {
                            let text = this.nodeValue;
                            if (regex.test(text)) {
                                let span = document.createElement('span');
                                span.innerHTML = text.replace(regex,
                                    '<mark class="search-highlight">$1</mark>');
                                $(this).replaceWith(span.childNodes);
                            }
                        });

                    });
                });
            }

            function escapeRegExp(string) {
                return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("search_form");
            const searchInput = document.getElementById("search");

            form.querySelectorAll('select').forEach(select => {
                select.addEventListener('change', function() {
                    form.submit();
                });
            });

            // searchInput.addEventListener('keydown', function(e) {
            //     if (e.key === 'Enter') {
            //         e.preventDefault();
            //         form.submit();
            //     }
            // });
        });
    </script>
    <script>
        $(document).on('change', '.flagSwitch', function() {

            let id = $(this).data('id');
            let key = $(this).data('key');
            let value = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('product.updateFlag') }}",
                type: "POST",
                data: {
                    id: id,
                    key: key,
                    value: value,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: key.replace(/_/g, ' ').toUpperCase() + ' updated!',
                            showConfirmButton: false,
                            timer: 1200
                        });
                        //reload
                    }
                },
                error: function(xhr) {
                    console.log("Error:", xhr.responseText);
                }
            });

        });
    </script>
    <script>
        $(document).on('blur', '.positionInput', function() {
            let id = $(this).data('id');
            let position = $(this).val();
            let key = $(this).data('key');
            $.ajax({
                url: "{{ route('product.updatePosition') }}",
                method: "POST",
                data: {
                    id: id,
                    key: key,
                    position: position,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Position updated!',
                            timer: 1200,
                            showConfirmButton: false
                        });
                    }
                },

                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to update!',
                        timer: 1500
                    });
                }
            });
        });


        // ENTER চাপলে blur trigger
        $(document).on('keypress', '.positionInput', function(e) {
            if (e.which === 13) {
                $(this).blur(); // triggers the update ajax
            }
        });
    </script>

    <script>
        $(document).on('change', '.free_shiiping', function() {
            let productId = $(this).data('id');
            let isFree = $(this).is(':checked') ? 1 : 0;

            $.post("{{ route('admin.free.shipping') }}", {
                _token: "{{ csrf_token() }}",
                product_id: productId,
                free_shipping: isFree
            }, function(res) {
                if (res.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Free shipping updated!',
                        timer: 1200,
                        showConfirmButton: false
                    })
                }
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
                            url: "{{ route('admin.product.bulk.delete') }}",
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
