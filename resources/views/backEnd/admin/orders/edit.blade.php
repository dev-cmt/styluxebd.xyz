@extends('backEnd.admin.layouts.master')
@section('title')
    Edit Order
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('backEnd/assets/libs/select2/css/select2.css') }}">
@endpush
@section('content')
    <div class="dashboard-wrapper">
        <div class="dashboard-ecommerce">
            <div class="container-fluid dashboard-content ">

                <div class="row mb-3 mt-3">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <h3 class="fw-bold mb-0 text-dark">Edit Order</h3>
                        <a href="{{ route('admin.orders') }}" class="btn btn-outline-dark btn-sm rounded-2">
                            <i class="ti ti-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="row row-deck row-cards">
                    <!-- Page Header Close -->
                    <form action="{{ route('admin.orders.update', $data->id) }}" method="POST" id="add-form"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-7 col-12">
                                <div class="card border-0 shadow-sm rounded-3  mb-3">
                                    <div
                                        class="  card-header  py-2 px-3 bg-blue-lt  border-bottom-0 justify-content-between">
                                        <div class="card-title">
                                            Product and Summary
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <select id="product-select" class="form-select select">
                                                <option value="">--Select Product--</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        data-variant="{{ $product->has_variant }}"
                                                        data-custom-properties="&lt;span class=&quot;avatar avatar-xs&quot; style=&quot;background-image: url({{ asset($product->get_top_image ? $product->get_top_image->file_url : '') }})&quot;&gt;&lt;/span&gt;">
                                                        {{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="table-responsive mb-md-3 mb-2">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>SKU</th>
                                                        <th>Product(s)</th>
                                                        <th>Qty</th>
                                                        <th>Unit Price</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="prod_row">
                                                    @if (count($data->get_products) > 0)
                                                        @php $productIndex = 0; @endphp
                                                        @foreach ($data->get_products as $op)
                                                            @if ($op->get_product && $op->get_product->is_combo == 1)
                                                                {{-- Combo Product Row --}}
                                                                @include(
                                                                    'backEnd.admin.orders.partials.combo_product_row',
                                                                    [
                                                                        'product' => $op->get_product,
                                                                        'orderProduct' => $op,
                                                                        'index' => $productIndex++,
                                                                    ]
                                                                )
                                                            @elseif ($op->attributes)
                                                                {{-- Variant Product Row --}}
                                                                <?php
                                                                $ids = explode('-', $op->attributes);
                                                                $ids = array_map('intval', $ids);
                                                                $variant = $op->get_product->get_variants()->where('variant', $op->attributes)->first();
                                                                $variantItem = $op->get_product->get_variants()->with('items')->get()->pluck('items')->flatten()->whereIn('attribute_item_id', $ids)->unique('attribute_id')->values()->map(fn($item) => $item->name)->implode(', ');
                                                                ?>
                                                                @include(
                                                                    'backEnd.admin.orders.partials.product_row_variant',
                                                                    [
                                                                        'product' => $op->get_product,
                                                                        'sku' => $op->product_sku,
                                                                        'qty' => $op->qty,
                                                                        'price' => $op->price,
                                                                        'variant_name' => $variantItem,
                                                                        'variant_choice' => implode(',', $ids),
                                                                        'index' => $productIndex++,
                                                                        'stock' => $variant->stock ?? 0,
                                                                    ]
                                                                )
                                                            @else
                                                                {{-- Non-Variant Product Row --}}
                                                                @include(
                                                                    'backEnd.admin.orders.partials.product_row',
                                                                    [
                                                                        'product' => $op->get_product,
                                                                        'qty' => $op->qty,
                                                                        'price' => $op->price,
                                                                        'index' => $productIndex++,
                                                                    ]
                                                                )
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <h3 class="shipping_method_title mb-3">Shipping Method</h3>
                                                @foreach ($shipping_methods as $key => $shipping_method)
                                                    <label class="form-check form-check-inline form-label">
                                                        <input type="hidden" class="shipping_amount"
                                                            value="{{ $shipping_method->amount }}">
                                                        <input class="form-check-input shipping_method"
                                                            value="{{ $shipping_method->id }}" name="shipping_method_id"
                                                            type="radio"
                                                            {{ $shipping_method->id == $data->shipping_method ? 'checked' : '' }}>
                                                        <span class="form-check-label">{{ $shipping_method->text }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="row mb-1">
                                                    <div class="col-md-6 text-end">
                                                        <label class="col-form-label" for="">Sub Total</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="number" class="form-control" name="sub_total"
                                                            id="sub_total"
                                                            value="{{ number_format($data->sub_total, 2, '.', '') }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-md-6 text-end">
                                                        <label class="col-form-label" for="">Delivery Cost
                                                            (+)</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="number" class="form-control auto-select-number"
                                                            name="delivery_cost" id="delivery_cost"
                                                            value="{{ number_format($data->shipping_cost, 2, '.', '') }}">
                                                        {{-- @dd($data->shipping_cost) --}}
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-md-6 text-end">
                                                        <label class="col-form-label" for="">Discount (-)</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="number"
                                                            class="form-control auto-select-number discount" name="discount"
                                                            id="discount"
                                                            value="{{ number_format($data->discount, 2, '.', '') }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-md-6 text-end">
                                                        <label class="col-form-label" for="">Coupon Discount
                                                            (-)</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="number"
                                                            class="form-control auto-select-number discount"
                                                            name="coupon_discount" id="coupon_discount"
                                                            value="{{ number_format($data->coupon_discount, 2, '.', '') }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-md-6 text-end">
                                                        <label class="col-form-label" for="">Grand Total</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="number" class="form-control" name="grand_total"
                                                            id="grand_total" readonly=""
                                                            value="{{ number_format($data->total, 2, '.', '') }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-md-6 text-end">
                                                        <label class="col-form-label" for="">Paid (-)</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="number" class="form-control" name="paid_amount"
                                                            id="paid_amount" min = "0"
                                                            value="{{ number_format($data->paid, 2, '.', '') }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-md-6 text-end">
                                                        <label class="col-form-label" for="">Due</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="number" class="form-control" name="due_amount"
                                                            id="due_amount" readonly=""
                                                            value="{{ number_format($data->due, 2, '.', '') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                {{-- Activity Timeline --}}
                                <div class="card border-0 shadow-sm rounded-3  mb-3">
                                    <div
                                        class=" card-header  py-2 px-3   border-bottom-0  d-flex align-items-center justify-content-between py-2 bg-blue-lt ">
                                        <b class="card-title m-0">
                                            <i class="ti ti-history me-1 text-primary"></i> Activity Timeline
                                        </b>
                                        <span class="badge bg-primary border border-primary rounded-pill font-monospace"
                                            style="font-size: 0.75rem;">
                                            {{ count($data->activities ?? []) }} Record(s)
                                        </span>
                                    </div>

                                    {{-- Fixed Container with Auto Scroll --}}
                                    <div class="card-body p-2"
                                        style="max-height: 50vh; overflow-y: auto; scrollbar-width: thin;">
                                        @php $activities = $data->activities ?? collect(); @endphp

                                        @if ($activities->isEmpty())
                                            <div class="text-center py-3">
                                                <i class="ti ti-history-off fs-3 text-muted opacity-50"></i>
                                                <p class="text-secondary fw-medium mb-0 small">এখনো কোনো activity রেকর্ড
                                                    হয়নি।</p>
                                            </div>
                                        @else
                                            <div class="d-flex flex-column gap-1">
                                                @foreach ($activities as $activity)
                                                    @php
                                                        $type = strtolower($activity->activity_type ?? '');
                                                        $badgeClass = 'bg-secondary';
                                                        if (
                                                            str_contains($type, 'created') ||
                                                            str_contains($type, 'added')
                                                        ) {
                                                            $badgeClass = 'bg-success';
                                                        } elseif (
                                                            str_contains($type, 'updated') ||
                                                            str_contains($type, 'changed')
                                                        ) {
                                                            $badgeClass = 'bg-primary';
                                                        } elseif (
                                                            str_contains($type, 'deleted') ||
                                                            str_contains($type, 'removed')
                                                        ) {
                                                            $badgeClass = 'bg-danger';
                                                        } elseif (str_contains($type, 'status')) {
                                                            $badgeClass = 'bg-warning text-dark';
                                                        }
                                                    @endphp

                                                    {{-- Compact 2-Line Activity Row --}}
                                                    <div class="px-2 py-1  border-start border-3 border-primary rounded">

                                                        {{-- Line 1: Content (User, Action, Changes/Comments) --}}
                                                        <div class="d-flex align-items-center flex-wrap gap-1 text-dark lh-sm"
                                                            style="font-size:12px;">
                                                            {{-- User Name --}}
                                                            <span class="fw-bold text-dark me-1">
                                                                <i class="ti ti-user text-muted"></i>
                                                                {{ $activity->causer_name ?? 'System' }}
                                                            </span>

                                                            {{-- Action Badge --}}
                                                            <span
                                                                class="badge {{ $badgeClass }}  font-monospace px-1 py-0 me-1"
                                                                style="font-size: 0.65rem;">
                                                                {{ str_replace('_', ' ', $activity->activity_type) }}
                                                            </span>

                                                            {{-- Field Changes (If Any) --}}
                                                            @if ($activity->field)
                                                                <?php
                                                                $label = Str::title(str_replace('_', ' ', $activity->field));
                                                                $old = $activity->old_value;
                                                                $new = $activity->new_value;
                                                                ?>

                                                                <span class="text-secondary me-1">
                                                                    ({{ $label }}:

                                                                    {{-- ১. যদি পুরানো এবং নতুন দুটি ভ্যালুই থাকে --}}
                                                                    @if ($old && $new)
                                                                        <del class="text-danger">{{ $old }}</del>
                                                                        <i
                                                                            class="ti ti-arrow-right text-muted small mx-0.5"></i>
                                                                        <strong
                                                                            class="text-success">{{ $new }}</strong>

                                                                        {{-- ২. শুধু নতুন ভ্যালু থাকলে (যেমন: Product Added বা Assigned) --}}
                                                                    @elseif ($new)
                                                                        <strong
                                                                            class="text-success">{{ $new }}</strong>

                                                                        {{-- ৩. শুধু পুরানো ভ্যালু থাকলে (যেমন: Product Removed) --}}
                                                                    @elseif ($old)
                                                                        <del class="text-danger">{{ $old }}</del>
                                                                    @endif)
                                                                </span>
                                                            @endif

                                                            {{-- Comment / Note (If Any) --}}
                                                            @if ($activity->comment)
                                                                <span class="text-muted fst-italic ms-1">
                                                                    — "<span
                                                                        class="text-dark">{{ $activity->comment }}</span>"
                                                                </span>
                                                            @endif
                                                        </div>

                                                        {{-- Line 2: Time --}}
                                                        <div class=" font-monospace mt-1"
                                                            style="font-size: 11px; color: #000;">
                                                            <i class="ti ti-clock me-1"></i>
                                                            {{ $activity->created_at ? $activity->created_at->format('d M, Y • h:i:s A') : 'N/A' }}
                                                        </div>

                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>




                                <div class="card border-0 shadow-sm rounded-3  mb-3">
                                    <div class=" card-header  py-2 px-3   border-bottom-0  bg-blue-lt">
                                        <h5 class="modal-title">All Notes</h5>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                @if (!empty($data->get_notes))
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>SL</th>
                                                                    <th>Note</th>
                                                                    <th>Created At</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($data->get_notes as $key => $note)
                                                                    <tr>
                                                                        <td>{{ $key + 1 }}</td>
                                                                        <td>{{ $note->note . ' (' . ucfirst($note->user_type) . ')' }}
                                                                        </td>
                                                                        <td>{{ $note->created_at }}</td>

                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                @else
                                                    <p>No Notes Found</p>
                                                @endif

                                            </div>
                                        </div>
                                    </div>

                                </div>


                            </div>

                            <div class="col-md-5">
                                <div class="card border-0 shadow-sm rounded-3  mb-3">
                                    <div
                                        class=" card-header  py-2 px-3   border-bottom-0  justify-content-between bg-blue-lt">
                                        <div class="card-title">
                                            Order & Customer Information <small>#{{ $data->invoice_id }}</small>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label class="form-label required" for="price">Order Date</label>
                                                <input type="text" class="form-control"
                                                    value="{{ date('d-m-Y', strtotime(now())) }}" name="order_date"
                                                    id="order_date" autocomplete="off" required>
                                            </div>

                                            <div class="col">
                                                <label class="form-label" for="memo_no">Memo Number</label>
                                                <input type="text" value="{{ $data->memo_no }}" class="form-control"
                                                    name="custom_order_no">
                                            </div>
                                            <div class="col">
                                                <label class="form-label" for="invoice_id">Invoice ID</label>
                                                <input type="text" class="form-control" name="invoice_id"
                                                    value="{{ $data->invoice_id }}" readonly>

                                            </div>

                                        </div>

                                        <div class="row mb-3">
                                            <div class="col">
                                                <label class="form-label required" for="name">Customer Name</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $data->customer_name }}" name="name" id="name"
                                                    autocomplete="off" required>
                                            </div>

                                            <div class="col">
                                                <label class="form-label required" for="phone">Customer Phone</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $data->customer_phone }}" name="phone" id="phone"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col">
                                                <label class="form-label required" for="address">Customer Address</label>
                                                <textarea name="address" id="address" class="form-control" required>{{ $data->customer_address }}</textarea>
                                            </div>
                                        </div>
                                        {{-- Staff and Customer note --}}
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label class="form-label" for="staff_note">Staff Note</label>
                                                <textarea name="staff_note" id="staff_note" class="form-control">{{ $data->staff_note }}</textarea>
                                            </div>
                                            {{-- <div class="col">
                                                <label class="form-label" for="customer_note">Customer Note</label>
                                                <textarea name="customer_note" id="customer_note" class="form-control">{{ $data->customer_note }}</textarea>
                                            </div> --}}
                                        </div>



                                    </div>
                                </div>
                                <div class="card border-0 shadow-sm rounded-3  mb-3">
                                    <div
                                        class=" card-header  py-2 px-3   border-bottom-0  justify-content-between bg-blue-lt">
                                        <div class="card-title">
                                            Courier
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">

                                            {{-- COURIER --}}
                                            <div class="col-12 mb-3">
                                                <label class="form-label" for="courier_id">Select Courier</label>
                                                <select name="courier_id" id="courier_id" class="form-select">
                                                    <option value="">Select Courier</option>
                                                    @foreach (DB::table('couriers')->get() as $courier)
                                                        <option value="{{ $courier->id }}"
                                                            {{ $courier->id == $data->courier_id ? 'selected' : '' }}>
                                                            {{ $courier->courier_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            {{-- <div class="city_zone_wrapper d-none">
                                                <input type="hidden" name="selected_zone_id" id="selected_zone_id"
                                                    value="{{ $data->courier_zone_id }}">
                                                <label>City / Zone</label>
                                                <select id="courier_city_zone" class="form-control select2"
                                                    name="courier_zone_id">
                                                    <option value="">Select City → Zone</option>
                                                </select>
                                            </div> --}}

                                        </div>


                                    </div>
                                </div>
                                <div class="card border-0 shadow-sm rounded-3  mb-3">
                                    <div
                                        class=" card-header  py-2 px-3   border-bottom-0  justify-content-between bg-blue-lt">
                                        <div class="card-title">
                                            Action
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label class="form-label" for="status">Order Status</label>
                                                <select name="status" id="status" class="form-select">
                                                    <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>
                                                        Pending </option>
                                                    <option value="2" {{ $data->status == 2 ? 'selected' : '' }}>
                                                        Confirm</option>
                                                    <option value="3" {{ $data->status == 3 ? 'selected' : '' }}>
                                                        Processing</option>
                                                    <option value="4" {{ $data->status == 4 ? 'selected' : '' }}>Hold
                                                    </option>
                                                    <option value="5" {{ $data->status == 5 ? 'selected' : '' }}>
                                                        Printed</option>
                                                    <option value="6" {{ $data->status == 6 ? 'selected' : '' }}>
                                                        Packaging</option>
                                                    <option value="7" {{ $data->status == 7 ? 'selected' : '' }}>
                                                        Courier Entry</option>
                                                    <option value="8"{{ $data->status == 8 ? 'selected' : '' }}>On
                                                        Delivery</option>
                                                    <option value="9"{{ $data->status == 9 ? 'selected' : '' }}>
                                                        Delivered</option>
                                                    <option value="10"{{ $data->status == 10 ? 'selected' : '' }}>
                                                        Cancelled</option>
                                                    <option value="11"{{ $data->status == 11 ? 'selected' : '' }}>
                                                        Returned</option>
                                                    <option value="12"{{ $data->status == 12 ? 'selected' : '' }}
                                                        disabled>
                                                        Return Received</option>
                                                    <option value="13"{{ $data->status == 13 ? 'selected' : '' }}>
                                                        Exchange</option>

                                                </select>
                                            </div>
                                            {{-- <div class="col mb-3">
                                                <label class="form-label" for="payment_status">Payment Status</label>
                                                <select name="payment_status" id="payment_status" class="form-select"
                                                    disabled>
                                                    <option value="0"
                                                        {{ $data->payment_status == 0 ? 'selected' : '' }}>
                                                        Unpaid
                                                    </option>
                                                    <option value="1"
                                                        {{ $data->payment_status == 1 ? 'selected' : '' }}>
                                                        Paid
                                                    </option>
                                                    <option value="2"
                                                        {{ $data->payment_status == 2 ? 'selected' : '' }}>
                                                        Partial
                                                    </option>
                                                </select>
                                            </div> --}}
                                            <div class="col mb-3">
                                                <label class="form-label" for="source">Source
                                                </label>
                                                <select name="source" id="source" class="form-select"
                                                    {{ $data->source == 'website' || $data->source == 'incomplete' ? 'readonly' : '' }}
                                                    required="">
                                                    {{-- <option value="">Select Source</option> --}}
                                                    @if ($data->source == 'website')
                                                        <option value="website" selected>Website</option>
                                                    @elseif ($data->source == 'incomplete')
                                                        <option value="incomplete" selected>Incomplete</option>
                                                    @else
                                                        <option value="whatsapp"
                                                            {{ $data->source == 'whatsapp' ? 'selected' : '' }}>Whatsapp
                                                        </option>
                                                        <option value="page"
                                                            {{ $data->source == 'page' ? 'selected' : '' }}>Page
                                                        </option>
                                                        <option value="call"
                                                            {{ $data->source == 'call' ? 'selected' : '' }}>Call</option>
                                                        <option value="instagram"
                                                            {{ $data->source == 'instagram' ? 'selected' : '' }}>Instagram
                                                        </option>
                                                        <option value="tiktok"
                                                            {{ $data->source == 'tiktok' ? 'selected' : '' }}>Tiktok
                                                        </option>
                                                        <option value="office_sell"
                                                            {{ $data->source == 'office_sell' ? 'selected' : '' }}>Office
                                                            Sell
                                                        </option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-success float-end">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Product Variant -->
    <div class="modal fade" id="productVariant" tabindex="-1" role="dialog" aria-labelledby="productVariantLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel2">
                        Select Product Variant
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="variantOptions">
                        <!-- Variant options will be dynamically loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveVariantSelection">Add</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for view more -->
    <div class="modal fade" id="viewMoreModal" tabindex="-1" aria-labelledby="viewMoreModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">

            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('backEnd/assets/libs/select2/js/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#product-select').select2();
            // $('#courier_id').select2();
            $('#courier_city').select2({
                placeholder: 'Select city'
            });
            $('#courier_zone').select2({
                placeholder: 'Select zone'
            });

        });

        $(function() {


            // 🔸 Start index from existing rows count
            let productIndex = $('#prod_row tr').length;

            // 🔹 Calculate totals
            function finalCalc() {
                let subTotal = 0;
                $('#prod_row tr').each(function() {
                    let qty = parseFloat($(this).find('.qty').val() || 0);
                    let price = parseFloat($(this).find('.price').val() || 0);
                    subTotal += qty * price;
                    $(this).find('.total_price').text((qty * price).toFixed(2));
                });

                $('#sub_total').val(subTotal.toFixed(2));
                let delivery = parseFloat($('#delivery_cost').val() || 0);
                let discount = parseFloat($('#discount').val() || 0);
                let coupon_discount = parseFloat($('#coupon_discount').val() || 0);
                let grand = subTotal + delivery - discount - coupon_discount;
                $('#grand_total').val(grand.toFixed(2));

                let paid = parseFloat($('#paid_amount').val() || 0);
                $('#due_amount').val((grand - paid).toFixed(2));
            }

            // 🔹 Append new product row (replace placeholder index)
            function appendProductRow(rowHtml) {
                rowHtml = rowHtml.replace(/__INDEX__/g, productIndex);
                $('#prod_row').append(rowHtml);
                productIndex++;
                finalCalc();
            }

            // 🔹 Product selection
            $('#product-select').on('change', function() {
                let $opt = $(this).find(':selected');
                let product_id = $opt.val();
                if (!product_id) return;
                let has_variant = $opt.data('variant');
                let CSRF = "{{ csrf_token() }}";

                if (has_variant) {
                    $.post("{{ route('admin.ajax.get.product.modal') }}", {
                        _token: CSRF,
                        id: product_id
                    }, function(html) {
                        $('#variantOptions').html(html);
                        $('#productVariant').removeData('editing-row').modal({
                            backdrop: 'static',
                            keyboard: false
                        }).modal('show');
                    });
                } else {
                    $.post("{{ route('admin.ajax.get.products') }}", {
                        _token: CSRF,
                        id: product_id
                    }, function(rowHtml) {
                        appendProductRow(rowHtml);
                    });
                }
            });

            // 🔹 Edit variant button click
            $(document).on('click', '.edit_variant', function() {
                let row = $(this).closest('tr');
                let product_id = row.data('product-id');
                let choice_str = row.find('.variant_choice').val() || '';
                let selectedChoices = choice_str ? choice_str.split(',') : [];
                let CSRF = "{{ csrf_token() }}";

                $.post("{{ route('admin.ajax.get.product.modal') }}", {
                    _token: CSRF,
                    id: product_id,
                    choice_variants: selectedChoices
                }, function(html) {
                    $('#variantOptions').html(html);
                    $('#productVariant').data('editing-row', row).modal({
                        backdrop: 'static',
                        keyboard: false
                    }).modal('show');
                });
            });

            // 🔹 Save or update variant from modal
            $('#productVariant').on('click', '#saveVariantSelection', function() {
                let product_id = $('#variant_product_id').val();
                let qty = parseInt($('#modal_qty').val() || 1);
                let choice = [];
                $('#variantSelectionForm').find('input[type=radio]:checked').each(function() {
                    choice.push($(this).val());
                });

                let choice_key = choice.join(',');
                let editingRow = $('#productVariant').data('editing-row');
                let CSRF = "{{ csrf_token() }}";

                // ✅ Edit mode with duplicate check
                if (editingRow) {
                    let duplicateRow = null;
                    $('#prod_row tr').each(function() {
                        let rowProductId = $(this).data('product-id');
                        let rowChoice = $(this).find('.variant_choice').val();
                        // Ignore the currently editing row itself
                        if (rowProductId == product_id && rowChoice == choice_key && this !==
                            editingRow[0]) {
                            duplicateRow = $(this);
                            return false;
                        }
                    });

                    if (duplicateRow) {
                        // Add quantity to the existing duplicate row
                        let currentQty = parseInt(duplicateRow.find('.qty').val() || 1);
                        duplicateRow.find('.qty').val(currentQty + qty).trigger('change');
                        alert('Variant already exists in another row, quantity updated!');
                        $('#productVariant').removeData('editing-row').modal('hide');
                        return;
                    }

                    // ✅ No duplicate, update the editing row normally
                    $.post("{{ route('admin.ajax.get.modal.variant') }}", {
                        _token: CSRF,
                        id: product_id,
                        choice_variants: choice,
                        qty: qty,
                        modal: 1
                    }, function(rowHtml) {
                        let idx = editingRow.find('input[name^="products"]').attr('name').match(
                            /\d+/)[0];
                        rowHtml = rowHtml.replace(/__INDEX__/g, idx);
                        editingRow.replaceWith(rowHtml);
                        $('#productVariant').removeData('editing-row');
                        finalCalc();
                    });
                    return;
                }

                // ✅ New row duplicate check (existing logic)
                let existingRow = null;
                $('#prod_row tr').each(function() {
                    let rowProductId = $(this).data('product-id');
                    let rowChoice = $(this).find('.variant_choice').val();
                    if (rowProductId == product_id && rowChoice == choice_key) {
                        existingRow = $(this);
                        return false;
                    }
                });

                if (existingRow) {
                    let currentQty = parseInt(existingRow.find('.qty').val() || 1);
                    existingRow.find('.qty').val(currentQty + qty).trigger('change');
                    alert('Variant already exists, quantity updated!');
                    $('#productVariant').modal('hide');
                    return;
                }

                // ✅ Add new variant row
                $.post("{{ route('admin.ajax.get.modal.variant') }}", {
                    _token: CSRF,
                    id: product_id,
                    choice_variants: choice,
                    qty: qty,
                    modal: 1
                }, function(rowHtml) {
                    appendProductRow(rowHtml);
                });
            });


            // 🔹 Remove row
            $(document).on('click', '.remove_btn', function() {
                $(this).closest('tr').remove();
                finalCalc();
            });


            // Combo child item remove kora
            $(document).on('click', '.remove-combo-child', function() {
                let $childItem = $(this).closest('.combo-child-item');
                let $wrapper = $childItem.closest('.combo-children-wrapper');

                // Jodi shob child item gulo remove hoye jay, chaile parent combo row-o remove kore dite paren
                if ($wrapper.find('.combo-child-item').length <= 1) {
                    if (confirm('This is the last item in the combo. Remove entire combo package?')) {
                        $childItem.closest('tr').remove();
                    }
                } else {
                    $childItem.fadeOut(300, function() {
                        $(this).remove();
                    });
                }
                finalCalc();
            });






            // 🔹 Qty / Price change
            $(document).on('keyup change', '.qty,.price,.discount, #paid_amount, #delivery_cost, #coupon_discount',
                function() {
                    finalCalc();
                });

            $(document).on('change', '.shipping_method', function() {
                let amount = $(this).parent().find('.shipping_amount').val();
                $('#delivery_cost').val($(this).parent().find('.shipping_amount').val());
                finalCalc();
            });

        });
    </script>
@endpush
