@extends('backEnd.admin.layouts.master')
@section('title')
    Create Stock Adjustment[cite: 28]
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('backEnd/assets/libs/select2/css/select2.css') }}">[cite: 28]
@endpush
@section('content')
    <div class="dashboard-wrapper">
        <div class="dashboard-ecommerce">
            <div class="container-fluid dashboard-content ">
                <div class="row mt-2">
                    <div class="col-12 d-flex justify-content-between">
                        <h3>Create Stock Adjustment</h3>
                        <a href="{{ route('admin.stock.adjustment') }}" class="btn btn-dark btn-sm">
                            <i class="ti ti-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.stock.adjustment.store') }}" method="POST" id="add-form">
                    @csrf
                    <div class="row row-deck row-cards mt-2">
                        <div class="col-md-12 col-12 mb-3">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <div class="card-title">Select Product</div>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12 col-12 mb-3">
                                        <select class="select2-client-search form-control" id="product_select">
                                            <option value="">--Select Product--</option>
                                            @foreach ($products as $key => $product)
                                                <option value="{{ $key }}">{{ $product }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="table-responsive mb-3">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="bg-primary text-white">
                                                    <th>Product Name / Variant</th>
                                                    <th>Current Stock</th>
                                                    <th>Adjustment Qty</th>
                                                    <th>Type</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="product-put">
                                                <tr class="no-product">
                                                    <td colspan="5" class="text-danger text-center">No Product Selected
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 col-12 mb-3">
                                            <label for="adjustment_date" class="form-label">Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" name="adjustment_date" id="adjustment_date"
                                                value="{{ date('Y-m-d') }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 col-12 mb-3">
                                            <label for="reason" class="form-label">Reason</label>
                                            <select name="reason" id="reason" class="form-select">
                                                <option value="Damage">Damage</option>
                                                <option value="Loss">Loss</option>
                                                <option value="Stock Mismatch">Stock Mismatch</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-12 mb-3">
                                            <label for="note" class="form-label">Note</label>
                                            <textarea name="note" id="note" rows="1" class="form-control"></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <button type="submit" class="btn btn-success float-end">Submit Adjustment</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('backEnd/assets/libs/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#product_select').select2({});
        });

        $(document).on('change', '#product_select', function() {
            var productId = $(this).val();
            if (!productId) return;

            var CSRF_TOKEN = `{{ csrf_token() }}`;
            $.ajax({
                url: '{{ route('admin.ajax.get.adjustment.product') }}',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    id: productId
                },
                success: function(data) {
                    if (data) {
                        $('.no-product').addClass('d-none').hide();
                        $('#product-put').append(data);
                        $('#product_select').val('').trigger('change.select2');
                    }
                }
            });
        });

        // Remove entire product group (when clicking trash icon on variant group header)
        $(document).on('click', '.remove_product_group', function() {
            let groupRow = $(this).closest("tr");
            // Ei group-er under-e sob variant row-gula remove kore dewa
            let nextRows = groupRow.nextUntil('.product-group-row');
            nextRows.remove();
            groupRow.remove();

            // Jodi table-e ar kono product na thake, tahole 'No Product Selected' dekhabe
            if ($('#product-put tr').length === 0 || $('#product-put tr').not('.no-product').length === 0) {
                $('.no-product').removeClass('d-none').show();
            }
        });

        // Remove individual variant row
        $(document).on('click', '.remove_product_attribute', function() {
            let tr = $(this).closest("tr");
            let groupRow = tr.prevAll('.product-group-row').first();
            tr.remove();

            // Jodi oi product-er shob variant delete hoye jay, tahole header row-o remove hoye jabe
            let remainingVariants = groupRow.nextUntil('.product-group-row');
            if (remainingVariants.length === 0) {
                groupRow.remove();
            }

            if ($('#product-put tr').length === 0 || $('#product-put tr').not('.no-product').length === 0) {
                $('.no-product').removeClass('d-none').show();
            }
        });

        // Remove single product (without variants)
        $(document).on('click', '.remove_product_btn', function() {
            $(this).closest("tr").remove();
            if ($('#product-put tr').length === 0 || $('#product-put tr').not('.no-product').length === 0) {
                $('.no-product').removeClass('d-none').show();
            }
        });
    </script>
@endpush
