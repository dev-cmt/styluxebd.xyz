@extends('frontEnd.' . $theme->path . '.layouts.master')
@section('title')
    Carts
@endsection
@section('PixelCode')
    @php
        $carts = Cart::getContent();
    @endphp
    {{-- initiate checkout --}}
    @if ($carts->count() > 0)
        <script>
            const checkoutEventId = 'ic_' + Date.now();
            const cartItemIds = [
                @foreach ($carts as $item)
                    '{{ $item->id }}',
                @endforeach
            ];

            fbq('track', 'InitiateCheckout', {
                content_type: 'product',
                content_ids: cartItemIds,
                num_cart_items: {{ $carts->count() }},
                value: {{ Cart::getTotal() }},
                currency: 'BDT'
            }, {
                eventID: checkoutEventId
            });
        </script>
    @endif
@endsection
@section('content')
    <section id="checkout-section">
        <div class="container">
            <form method="POST"
                action="{{ $theme->is_active == 1 ? route('place.order') : route('theme.place.order', ['path' => $theme->path]) }}">
                @csrf
                <div class="row g-4">
                    <!-- Left: Billing & Shipping Information -->
                    <div class="col-lg-5">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="d-flex justify-content-between align-items-center mb-3  card-header text-white fw-bold"
                                style="background-color: #322E7E">
                                Billing & Shipping Information
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="customer_name" name="customer_name" class="form-control"
                                            placeholder="Full Name" value="{{ old('customer_name') }}" required>
                                        @error('customer_name')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Mobile <span
                                                class="text-danger">*</span></label>
                                        <input type="tel" id="customer_phone" name="customer_phone" class="form-control"
                                            placeholder="01234567890" value="{{ old('customer_phone') }}" required>
                                        @error('customer_phone')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Address <span
                                                class="text-danger">*</span></label>
                                        <textarea name="customer_address" id="customer_address" class="form-control" rows="2" placeholder="Full Address"
                                            required>{{ old('customer_address') }}</textarea>
                                        @error('customer_address')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div
                                        style="padding:10px; border:1px dashed #ff9e9e; border-radius:8px; margin-bottom:10px;">
                                        <div class="col-md-12">
                                            <label class="form-label fw-semibold">🚚 Shipping Method <span
                                                    class="text-danger">*</span></label>
                                            @foreach ($shipping_methods as $key => $item)
                                                <div class="form-check shipping_method" id="shipping_method">
                                                    <input type="radio" id="shipping_{{ $item->id }}"
                                                        name="shipping_method_id" value="{{ $item->id }}"
                                                        data-amount="{{ $item->amount }}" data-id="{{ $item->id }}"
                                                        {{ $key == 0 ? 'checked' : '' }}>

                                                    <label class="form-check-label shipping_method_label shipping_method"
                                                        for="shipping_{{ $item->id }}">
                                                        {{ $item->text }}
                                                    </label>
                                                </div>
                                            @endforeach
                                            @error('city_id')
                                                <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <textarea id="customer_note" name="customer_note" class="form-control" rows="4"
                                            placeholder="Order note (optional)">{{ old('customer_note') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Cart Summary / Total Items -->
                    <div class="col-lg-7 checkout-summery">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="d-flex justify-content-between align-items-center mb-3 card-header text-white fw-bold"
                                style="background-color: #322E7E">
                                Total Items
                                <a href="{{ $theme->is_active == 1 ? route('cart.page') : route('theme.cart.page', ['path' => $theme->path]) }}"
                                    class="btn text-white border-white btn-sm">Modify</a>
                            </div>
                            <div class="card-body text-center">
                                @if (count($carts) > 0)
                                    <ul class="list-group mb-3">
                                        @foreach ($carts as $cart)
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="d-flex align-items-start">
                                                    <a
                                                        href="{{ $theme->is_active == 1 ? route('single.product', $cart['associatedModel']->slug) : route('theme.single.product', ['path' => $theme->path, 'slug' => $cart['associatedModel']->slug]) }}">
                                                        <img src="{{ $cart['associatedModel']->get_feature_image ? asset($cart['associatedModel']->get_feature_image->file_url) : 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg' }}"
                                                            alt="{{ $cart['name'] }}" class="rounded me-2"
                                                            style="width:50px; height:50px; object-fit:cover;">
                                                    </a>

                                                    <div class="text-start px-1">
                                                        <a href="{{ $theme->is_active == 1 ? route('single.product', $cart['associatedModel']->slug) : route('theme.single.product', ['path' => $theme->path, 'slug' => $cart['associatedModel']->slug]) }}"
                                                            class="text-dark">
                                                            <p class="mb-1 fw-semibold">{{ $cart['name'] }} (
                                                                x{{ $cart['quantity'] }})</p>
                                                        </a>

                                                        @if ($cart->attributes && count($cart->attributes) > 0)
                                                            @foreach (json_decode($cart['attributes'], true) as $attribute_name => $attr)
                                                                @php
                                                                    $attribute = DB::table('attributes')
                                                                        ->where('id', $attr)
                                                                        ->first();

                                                                @endphp

                                                                @foreach (explode('-', $cart->attributes[0]) as $ite)
                                                                    @php
                                                                        $attributeItem = \App\AttributeItem::find($ite);
                                                                        $attribute = \App\Attribute::find(
                                                                            $attributeItem->attribute_id,
                                                                        );
                                                                    @endphp
                                                                    <span class="text-dark"><strong
                                                                            class="fw-bold">{{ ucfirst($attribute->name) }}
                                                                            : </strong>
                                                                        {{ ucfirst($attributeItem->name) }}</span>
                                                                @endforeach
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <span
                                                    class="fw-bold mt-1">{{ $web_settings->currency_sign }}{{ number_format($cart['price'], 2) }}</span>
                                            </li>
                                        @endforeach

                                    </ul>

                                    <div class="mb-3 fw-bold fs-5 payable-card">
                                        <p class="text-center mb-2">Your total payable amount is</p>
                                        <h2 class="text-center text-primary mb-3" id="order_total">
                                            {{ number_format(\Cart::getTotal()) }} {{ $web_settings->currency_sign }}
                                        </h2>
                                        <table class="table table-bordered mb-3">
                                            <thead>
                                                <tr>
                                                    <th>Purpose</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Total</td>
                                                    <td>
                                                        <span
                                                            id="net_total">{{ number_format(\Cart::getTotal(), 2) }}</span>{{ $web_settings->currency_sign }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Shipping <span id="cart_shipping_cost_text"
                                                            style="font-size: 10px; color: #322E7E"></span></td>
                                                    <td> <span id="cart_shipping_cost"> 0 </span>
                                                        {{ $web_settings->currency_sign }}</td>
                                                </tr>
                                                <tr class="coupon_row d-none">
                                                    <td>Coupon Discount</td>
                                                    <td><span id="coupon_text"> {{ $web_settings->currency_sign }} 0
                                                        </span></td>
                                                </tr>

                                                <input type="hidden" id="shipping_cost"
                                                    value="{{ session('shipping_amount') }}">
                                            </tbody>
                                        </table>
                                        <p class="text-center text-muted">Delivery <span class="fw-semibold">within 2-3
                                                Days</span> after confirmation.</p>
                                    </div>
                                    <div class="my-2 p-3 border rounded" id="coupon_box">
                                        <h6 class="fw-bold text-start mb-2">Apply Coupon</h6>

                                        <div class="input-group">
                                            <input type="text" id="coupon_code" class="form-control coupon_code"
                                                placeholder="Enter coupon code">
                                            <button type="button" id="apply_coupon_btn" class="btn btn-info">
                                                Apply
                                            </button>
                                        </div>

                                        <small id="coupon_message" class="text-danger d-block mt-2"></small>

                                        <div class="mt-3 d-none" id="applied_coupon_area">
                                            <div class="d-flex justify-content-between">
                                                <span class="fw-bold text-success">
                                                    Coupon Applied: <span id="applied_coupon_code"></span>
                                                </span>
                                                <button type="button" id="remove_coupon_btn"
                                                    class="btn btn-sm btn-danger">Remove</button>
                                            </div>

                                            <input type="hidden" name="coupon_code" id="hidden_coupon_code">
                                            <input type="hidden" name="coupon_discount" id="hidden_coupon_discount">
                                        </div>

                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="card shadow-sm p-4" id="confirmOrder">
                                                <h5 class="text-primary mb-3">Payment Option</h5>
                                                <div class="d-flex gap-3 flex-wrap">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="cod"
                                                            name="payment_method" id="payment1" checked>
                                                        <label class="form-check-label" for="payment1">
                                                            Cash On Delivery
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-success w-100 py-2">Confirm Order</button>
                                @else
                                    <p class="mb-3">Cart is empty</p>
                                    <a href="{{ $theme->is_active == 1 ? route('home') : route('theme.home', ['path' => $theme->path]) }}"
                                        class="btn btn-success w-100 py-2">Continue Shopping</a>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </section>
@endsection

@push('js')
    <script>
        function calculateFinalTotal() {

            let subtotal = {{ \Cart::getTotal() }};
            let shipping = parseFloat($("#shipping_cost").val()) || 0;
            let discount = parseFloat($("#hidden_coupon_discount").val()) || 0;

            let final = subtotal + shipping - discount;

            $("#order_total").text(final.toFixed(2) + " {{ $web_settings->currency_sign }} ");
            $("#coupon_text").text(discount.toFixed(2) + " {{ $web_settings->currency_sign }} ");
            if (discount > 0) {
                $(".coupon_row").removeClass('d-none');
            } else {
                $(".coupon_row").addClass('d-none');
            }

        }

        /* ===============================
           ROUTE HELPER
        =============================== */
        function getRoute(type) {
            let active = @json($theme->is_active == 1);

            const routes = {
                couponApply: active ?
                    "{{ route('coupon.apply') }}" : "{{ route('theme.coupon.apply', ['path' => $theme->path]) }}",

                couponRemove: active ?
                    "{{ route('coupon.remove') }}" : "{{ route('theme.coupon.remove', ['path' => $theme->path]) }}",

                couponCheckLimit: active ?
                    "{{ route('coupon.check.limit') }}" :
                    "{{ route('theme.coupon.check.limit', ['path' => $theme->path]) }}"
            };

            return routes[type];
        }


        /* ===============================
           APPLY COUPON
        =============================== */
        $(document).on('click', '#apply_coupon_btn', function() {

            let code = $("#coupon_code").val();
            let phone = $("#customer_phone").val();

            if (!code) {
                $("#coupon_message").text("Please enter coupon code");
                return;
            }

            $.post(getRoute('couponApply'), {
                _token: '{{ csrf_token() }}',
                coupon: code,
                phone: phone
            }, function(res) {

                if (!res.status) {
                    $("#coupon_message").text(res.message);
                    return;
                }

                $("#coupon_message").text("");
                $("#applied_coupon_area").removeClass('d-none');

                $("#applied_coupon_code").text(res.coupon_code);
                $("#hidden_coupon_code").val(res.coupon_code);
                $("#hidden_coupon_discount").val(res.discount);

                calculateFinalTotal();
            });
        });


        /* ===============================
           REMOVE COUPON
        =============================== */
        $(document).on('click', '#remove_coupon_btn', function() {

            $.post(getRoute('couponRemove'), {
                _token: '{{ csrf_token() }}'
            }, function() {

                $("#applied_coupon_area").addClass('d-none');

                $("#hidden_coupon_code").val('');
                $("#hidden_coupon_discount").val('');

                calculateFinalTotal();
            });
        });

        /* ===============================
           CHECK LIMIT ON PHONE BLUR
        =============================== */
        $('#customer_phone').on('blur', function() {

            let phone = $(this).val();
            let coupon = $("#hidden_coupon_code").val();

            $.post(getRoute('couponCheckLimit'), {
                _token: '{{ csrf_token() }}',
                phone: phone,
                coupon: coupon
            }, function(res) {

                if (res.remove_coupon) {
                    $("#remove_coupon_btn").click();
                    iziToast.error({
                        title: "Coupon Removed",
                        message: res.message,
                        position: 'bottomRight'
                    });
                }

                $(".coupon_code, #apply_coupon_btn").prop('disabled', !res.allow_apply);
            });
        });
    </script>

    <script>
        $(document).on('click', '.cart-overview-button', function() {
            if ($('.checkout-summery').hasClass('show')) {
                // $('.checkout-summery').removeClass('show');
            } else {
                $('.checkout-summery').addClass('show');
            }
        });

        let activePath = @json($theme->is_active == 1 ? 'active' : 'theme');
        let routes = {
            custmoerPhone: {
                active: "{{ route('abandoned.cart') }}",
                theme: "{{ route('theme.abandoned.cart', ['path' => $theme->path]) }}"
            }
        };

        function getCustomerPhoneUrl() {
            return activePath === 'active' ? routes.custmoerPhone.active : routes.custmoerPhone.theme;
        }
        $('#customer_phone').on('blur', function() {
            var phone = $(this).val();
            var name = $('#customer_name').val();
            var address = $('#customer_address').val();
            var note = $('#customer_note').val();
            var shipping_method = $('#shipping_method').val();
            var shipping_cost = $('#shipping_cost').val();
            var data = {
                phone: phone,
                name: name,
                address: address,
                shipping_method: shipping_method,
                shipping_cost: shipping_cost,
                note: note,
            };

            if (phone.length == 11) {
                $.ajax({
                    url: getCustomerPhoneUrl(),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        data: data
                    },
                    success: function(data) {
                        // console.log(data)
                    }
                });
            }
        });


        $(document).on('click', '.cart-overview-close', function() {
            $('.checkout-summery').removeClass('show');
        });

        function updateShippingAmount(shipping_area) {
            $.ajax({
                url: "{{ $theme->is_active == 1 ? route('ajax.get.shipp.meth') : route('theme.ajax.get.shipp.meth', ['path' => $theme->path]) }}",
                type: 'POST',
                data: {
                    _token: @json(csrf_token()),
                    shipping_area: shipping_area
                },
                success: function(data) {
                    if (data.amount == 0) {
                        $("#cart_shipping_cost_text").text('(Free Delivery)');
                        $("#cart_shipping_cost").text('0');
                        $("#shipping_cost").val(0);
                    } else {
                        $("#cart_shipping_cost").text(data.amount);
                        $("#shipping_cost").val(data.amount);
                    }
                    calculateFinalTotal();
                }
            });
        }


        // ✅ change event (radio)
        $(document).on('change', 'input[name="shipping_method_id"]', function() {
            updateShippingAmount($(this).val());
        });


        // ✅ auto call on page load
        $(document).ready(function() {
            let default_id = $('input[name="shipping_method_id"]:checked').val();

            if (default_id) {
                updateShippingAmount(default_id);
            }
        });

        $(document).on('change', '#term_condition', function() {
            if ($(this).is(':checked')) {
                $('.order-confirm-button').prop('disabled', false);
                $('.order-confirm-button').css('opacity', 1);
            } else {
                $('.order-confirm-button').prop('disabled', true);
                $('.order-confirm-button').css('opacity', .7);
            }
        })
    </script>
@endpush
