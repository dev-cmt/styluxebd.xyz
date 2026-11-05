@extends('backEnd.admin.layouts.master')
@section('title')
    Edit Purchase
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('backEnd/assets/libs/select2/css/select2.css') }}">
@endpush
@php
    $currency_sign = $data['currency_sign'] ?? [];
@endphp
@section('content')
    <div class="dashboard-wrapper">
        <div class="dashboard-ecommerce">
            <div class="container-fluid dashboard-content ">
                <div class="row mt-2">
                    <div class="col-12 d-flex justify-content-between">
                        <h3>Edit Purchase</h3>
                        <small class="float-end">
                            <a href="{{ route('admin.purchase') }}" class="btn btn-dark btn-sm">
                                <i class="ti ti-arrow-left"></i>
                                Back
                            </a>
                        </small>
                    </div>
                </div>

                <form action="{{ route('admin.purchase.update', $data->id) }}" method="POST" id="add-form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row row-deck row-cards">

                        <div class="col-md-12 col-12 mb-3">
                            <div class="card custom-card">
                                <div class="card-header justify-content-between">
                                    <div class="card-title">
                                        Edit Purchase
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="col-md-12 col-12 mb-3">
                                        <select class="select2-client-search form-control" name="product_id"
                                            id="product_select">
                                            <option value="">--Select Product--</option>
                                            @foreach ($products as $key => $product)
                                                <option value="{{ $key }}">{{ $product }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('product_id'))
                                            <span class="text-danger">{{ $errors->first('product_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="table-responsive mb-md-3 mb-2">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr class="bg-primary text-white">
                                                        <th>Product Name</th>
                                                        <th>Purchase Quantity</th>
                                                        <th>Purchase Price</th>
                                                        <th>Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="product-put">
                                                    @if (count($data->get_purchase_items) > 0)
                                                        @foreach ($data->get_purchase_items->groupBy('product_id') as $key => $items)
                                                            @php
                                                                $product = $items[0]->get_product;
                                                            @endphp
                                                            @if ($product && count($product->get_variants) > 0)
                                                                <tr class="product-group-row">
                                                                    <td colspan="4" class="p-2 bg-light text-dark">
                                                                        <strong>{{ $product->name }}</strong> <span
                                                                            class="text-dark font-12">(Variants)</span>
                                                                    </td>
                                                                    <td style="text-align: center; vertical-align: middle;"
                                                                        class="bg-light">
                                                                        <a href="javascript:void(0);"
                                                                            class="remove_product_group text-danger fs-5"
                                                                            data-product-id="{{ $product->id }}">
                                                                            <i class='ti ti-trash'></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                @foreach ($product->get_variants as $attribute)
                                                                    @php
                                                                        $purchasedItem = $items
                                                                            ->where('sku', $attribute->sku)
                                                                            ->first();
                                                                        $variant_name = $attribute->items
                                                                            ->map(function ($item) {
                                                                                $attrName =
                                                                                    $item->attribute->name ?? '';
                                                                                $itemName = $item->name ?? '';
                                                                                return $attrName . ': ' . $itemName;
                                                                            })
                                                                            ->implode(' / ');
                                                                    @endphp
                                                                    <tr class="variant-row-{{ $product->id }}">
                                                                        <td class="ps-4">
                                                                            <span
                                                                                class="text-primary">{{ $variant_name }}</span>
                                                                            ({{ $attribute->sku }})
                                                                            <input type="hidden" name="sku[]"
                                                                                value="{{ $attribute->sku }}">
                                                                            <input type="hidden" name="product_id[]"
                                                                                value="{{ $product->id }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" name="purchase_quantity[]"
                                                                                class="form-control purchase_quantity purchase_quantity_{{ $product->id }}"
                                                                                data-id="{{ $product->id }}"
                                                                                value="{{ $purchasedItem ? $purchasedItem->ordered_quantity : 1 }}"
                                                                                required>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" name="purchase_cost[]"
                                                                                class="form-control purchase_cost purchase_cost_{{ $product->id }}"
                                                                                value="{{ formatNumber($purchasedItem ? $purchasedItem->purchase_cost : $attribute->purchase_price) ?? 0 }}"
                                                                                step="0.01"
                                                                                data-id="{{ $product->id }}" required>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number"
                                                                                class="form-control single_purchase_total"
                                                                                name="single_purchase_total[]"
                                                                                step="0.01"
                                                                                value="{{ $purchasedItem ? $purchasedItem->total : 0 }}"
                                                                                required readonly>
                                                                        </td>
                                                                        <td
                                                                            style="text-align: center; vertical-align: middle;">
                                                                            <a href="javascript:void(0);"
                                                                                class="remove_product_attribute text-danger fs-5"><i
                                                                                    class='ti ti-trash'></i></a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                @foreach ($items as $item)
                                                                    <tr>
                                                                        <td>
                                                                            <span
                                                                                class="text-primary">#{{ $item->sku }}</span><br>
                                                                            {{ $item->get_product->name ?? '' }}
                                                                            <input type="hidden" name="sku[]"
                                                                                value="{{ $item->sku }}">
                                                                            <input type="hidden" name="product_id[]"
                                                                                value="{{ $item->product_id }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" name="purchase_quantity[]"
                                                                                class="form-control purchase_quantity"
                                                                                value="{{ $item->ordered_quantity ?? 1 }}"
                                                                                required>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" name="purchase_cost[]"
                                                                                class="form-control purchase_cost"
                                                                                value="{{ formatNumber($item->purchase_cost) ?? 0 }}"
                                                                                step="0.01" required>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number"
                                                                                class="form-control single_purchase_total"
                                                                                name="single_purchase_total[]"
                                                                                step="0.01"
                                                                                value="{{ formatNumber($item->total) ?? 0 }}"
                                                                                required readonly>
                                                                        </td>
                                                                        <td
                                                                            style="text-align: center; vertical-align: middle;">
                                                                            <a href="javascript:void(0);"
                                                                                class="remove_product_btn text-danger fs-5"><i
                                                                                    class='ti ti-trash'></i></a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                        <tr class="no-product d-none">
                                                            <td colspan="12" class="text-danger text-center">No Product
                                                                Selected</td>
                                                        </tr>
                                                    @else
                                                        <tr class="no-product">
                                                            <td colspan="12" class="text-danger text-center">No Product
                                                                Selected</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-5">
                                            <div class="row mb-1">
                                                <div class="col-md-9 text-end">
                                                    <label class="col-form-label" for="">Sub Total</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control" name="subtotal"
                                                        id="sub_total" value="{{ formatNumber($data->subtotal) ?? 0 }}"
                                                        readonly step="0.01">
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-md-9 text-end">
                                                    <label class="col-form-label" for="">Discount (−):</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control auto-select-number"
                                                        name="discount" id="discount"
                                                        value="{{ formatNumber($data->discount) ?? 0 }}" step="0.01">
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <div class="col-md-9 text-end">
                                                    <label class="col-form-label" for="">Tax (+):</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control auto-select-number"
                                                        name="tax" id="tax"
                                                        value="{{ formatNumber($data->tax) ?? 0 }}" step="0.01">
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-md-9 text-end">
                                                    <label class="col-form-label" for="">Shipping Cost
                                                        (+):</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control auto-select-number"
                                                        name="shipping_cost" id="shipping_cost"
                                                        value="{{ formatNumber($data->shipping_cost) ?? 0 }}"
                                                        step="0.01">
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <div class="col-md-9 text-end">
                                                    <label class="col-form-label" for="">Grand Total</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control" name="total"
                                                        id="grand_total" readonly=""
                                                        value="{{ formatNumber($data->total) ?? 0 }}" step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <div class="card custom-card">
                                <div class="card-header justify-content-between">
                                    <div class="card-title">
                                        Payment
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 col-12 mb-3">
                                            <label for="account_id" class="form-label">Account</label>
                                            <select name="account_id" id="account_id" class="form-select">
                                                <option value="">-- Select Account --</option>
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}"
                                                        {{ $data->account_id == $account->id ? 'selected' : '' }}>

                                                        @if ($account->account_type == 1)
                                                            Bank - {{ $account->bank_account_no }}
                                                        @elseif ($account->account_type == 2)
                                                            Bkash - {{ $account->bkash_no }}
                                                        @elseif ($account->account_type == 3)
                                                            Nagad - {{ $account->nagad_no }}
                                                        @elseif ($account->account_type == 4)
                                                            Rocket - {{ $account->rocket_no }}
                                                        @elseif ($account->account_type == 5)
                                                            Cash
                                                        @endif

                                                        ({{ $web_settings->currency_sign }}{{ number_format($account->balance, 2) }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('account_id'))
                                                <span class="text-danger">{{ $errors->first('account_id') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-4 col-12 mb-3">
                                            <label for="paid_amount" class="form-label">Paid amount <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" name="paid_amount" id="paid_amount"
                                                class="form-control" value="{{ formatNumber($data->paid_amount) }}"
                                                placeholder="0.00" step="0.01" required>
                                            @if ($errors->has('paid_amount'))
                                                <span class="text-danger">{{ $errors->first('paid_amount') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-4 col-12 mb-3">
                                            <label for="due_amount" class="form-label">Due amount <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" name="due_amount" id="due_amount" class="form-control"
                                                value="{{ formatNumber($data->due_amount) }}" step="0.01" readonly
                                                required>
                                        </div>
                                        {{-- <div class="col-md-12 col-12 mb-3">
                                            <label for="note" class="form-label">Note </label>
                                            <textarea name="note" id="note" rows="2" class="form-control">{{ $data->note }}</textarea>
                                        </div> --}}
                                        {{-- <div class="col-md-12 col-12">
                                            <button type="submit" class="btn btn-success float-end">Update</button>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <div class="card custom-card">
                                <div class="card-header justify-content-between">
                                    <div class="card-title">
                                        Purchase Information
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4 col-12 mb-3">
                                            <label for="supplier_id" class="form-label">Supplier <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" name="supplier_id" id="purchase_select"
                                                required>
                                                <option value="">--Select Supplier--</option>
                                                @foreach ($suppliers as $key => $supplier)
                                                    <option value="{{ $key }}"
                                                        {{ $data->supplier_id == $key ? 'selected' : '' }}>
                                                        {{ $supplier }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('supplier_id'))
                                                <span class="text-danger">{{ $errors->first('supplier_id') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-4 col-12 mb-3">
                                            <label for="purchase_date" class="form-label">Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="purchase_date" id="purchase_date"
                                                value="{{ date('d-m-Y', strtotime($data->purchase_date)) }}"
                                                class="form-control" required>
                                            @if ($errors->has('purchase_date'))
                                                <span class="text-danger">{{ $errors->first('purchase_date') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-4 col-12 mb-3">
                                            <label for="status" class="form-label">Status <span
                                                    class="text-danger">*</span></label>
                                            <select name="status" id="status" class="form-select">
                                                <option value="ordered"
                                                    {{ $data->status == 'ordered' ? 'selected' : '' }}>Ordered</option>
                                                <option value="received"
                                                    {{ $data->status == 'received' ? 'selected' : '' }}>Received</option>
                                            </select>
                                            @if ($errors->has('status'))
                                                <span class="text-danger">{{ $errors->first('status') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="memo_no" class="form-label">Memo number</label>
                                            <input type="text" name="memo_no" id="memo_no" class="form-control"
                                                value="{{ $data->memo_no }}">
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="remarks" class="form-label">Remarks</label>
                                            <textarea name="remarks" id="remarks" rows="1" class="form-control">{{ $data->remarks }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12 col-12 float-end">
                            <button type="submit" class="btn btn-success float-end">Puchase Update</button>
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
        function total() {
            let subtotal = parseFloat($('#sub_total').val()) || 0;
            let discount = parseFloat($('#discount').val()) || 0;
            let tax = parseFloat($('#tax').val()) || 0;
            let shipping_cost = parseFloat($('#shipping_cost').val()) || 0;
            let paid = parseFloat($('#paid_amount').val()) || 0;

            // Subtotal theke discount biyog, ebong tax & shipping_cost jog hobe
            let grandTotal = (subtotal - discount) + tax + shipping_cost;
            let due = grandTotal - paid;

            $('#grand_total').val(grandTotal.toFixed(2));
            $('#due_amount').val(due.toFixed(2));
        }

        function subtotal() {
            var subtotal = 0;
            $('.single_purchase_total').each(function(index, val) {
                let valFloat = parseFloat($(this).val());
                if (!isNaN(valFloat)) {
                    subtotal += valFloat;
                }
            });
            $('#sub_total').val(subtotal.toFixed(2));
        }

        // Purchase Quantity Change Event
        $(document).on('keyup change', '.purchase_quantity', function() {
            let parent = $(this).parents('tr');
            let productId = parent.find('input[name="product_id[]"]').val();

            // Check kori eta ki prothom variant row kina
            let isFirstVariantRow = parent.is('.product-group-row + tr') || parent.index() === parent.siblings(
                '.variant-row-' + productId).first().index();

            // Jodi prothom row hoy, tahole baki gulateo value set hobe
            if (isFirstVariantRow && parent.hasClass('variant-row-' + productId)) {
                let firstVal = $(this).val();
                $('.variant-row-' + productId).not(parent).each(function() {
                    $(this).find('.purchase_quantity').val(firstVal);
                    let q = parseFloat(firstVal) || 0;
                    let c = parseFloat($(this).find('.purchase_cost').val()) || 0;
                    $(this).find('.single_purchase_total').val((q * c).toFixed(2));
                });
            }

            let qty = parseFloat($(this).val()) || 0;
            let purchase_cost = parseFloat(parent.find('.purchase_cost').val()) || 0;
            let single_purchase_total = purchase_cost * qty;
            parent.find('.single_purchase_total').val(single_purchase_total.toFixed(2));

            subtotal();
            total();
        });

        // Purchase Cost Change Event
        $(document).on('keyup change', '.purchase_cost', function() {
            let parent = $(this).parents('tr');
            let productId = parent.find('input[name="product_id[]"]').val();

            let isFirstVariantRow = parent.is('.product-group-row + tr') || parent.index() === parent.siblings(
                '.variant-row-' + productId).first().index();

            // Jodi prothom row-er price change hoy, tahole baki gulateo price set hobe
            if (isFirstVariantRow && parent.hasClass('variant-row-' + productId)) {
                let firstCost = $(this).val();
                $('.variant-row-' + productId).not(parent).each(function() {
                    $(this).find('.purchase_cost').val(firstCost);
                    let c = parseFloat(firstCost) || 0;
                    let q = parseFloat($(this).find('.purchase_quantity').val()) || 0;
                    $(this).find('.single_purchase_total').val((q * c).toFixed(2));
                });
            }

            let qty = parseFloat(parent.find('.purchase_quantity').val()) || 0;
            let cost = parseFloat($(this).val()) || 0;
            let single_purchase_total = qty * cost;
            parent.find('.single_purchase_total').val(single_purchase_total.toFixed(2));

            subtotal();
            total();
        });

        $(document).on('keyup change', '#discount, #tax, #shipping_cost', function() {
            total();
        });



        $(document).on('click', '.remove_product_btn, .remove_product_attribute', function() {
            let tr = $(this).closest("tr");
            let prevTr = tr.prev('.product-group-row');

            // If it's part of a variant group and it's the last/only attribute or similar, handle cleanup if needed
            tr.remove();
            if (prevTr.length && prevTr.next('tr').length === 0 || (prevTr.length && prevTr.next('tr').hasClass(
                    'product-group-row'))) {
                prevTr.remove();
            }

            subtotal();
            total();
            if ($('#sub_total').val() == 0 || $('#product-put tr').length === 0) {
                $('.no-product').removeClass('d-none').css('display', 'table-row');
            } else {
                $('.no-product').addClass('d-none').css('display', 'none');
            }
        });

        $(document).on('click', '.remove_product_group', function() {
            let productId = $(this).data('product-id');
            $('.variant-row-' + productId).remove();
            $(this).closest('tr').remove();
            subtotal();
            total();
            if ($('#sub_total').val() == 0 || $('#sub_total').val() == '' || $('#product-put tr').length === 0) {
                $('.no-product').removeClass('d-none').css('display', 'table-row');
            } else {
                $('.no-product').addClass('d-none').css('display', 'none');
            }
        });

        //paid_amount
        $(document).on('keyup change', '#paid_amount', function() {
            let grand_total = parseFloat($('#grand_total').val()) || 0;
            let paid_amount = parseFloat($(this).val()) || 0;
            let due_amount = grand_total - paid_amount;
            $('#due_amount').val(due_amount.toFixed(2));
        });

        $(document).on('change', '#product_select', function() {
            var that = $(this);
            var CSRF_TOKEN = `{{ csrf_token() }}`;
            $.ajax({
                url: '{{ route('admin.ajax.get.purchase.product') }}',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    id: $(this).val()
                },
                success: function(data) {
                    if (data) {
                        $('.no-product').addClass('d-none').hide();
                        $('#product-put').append(data);

                        $('.purchase_quantity, .purchase_cost').trigger('change');

                        subtotal();
                        total();
                    }
                }
            });
        });
    </script>
@endpush
