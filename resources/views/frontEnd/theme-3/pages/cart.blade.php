@extends('frontEnd.' . $theme->path . '.layouts.master')
@section('title')
    Carts
@endsection

@section('content')

    <section id="cart-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if (count($carts) > 0)
                        <h3 class="cart-title text-center">Your Cart</h3>
                        <div class="table-responsive table-bordered">
                            <table class="table table-condensed cart-page-table">
                                <thead>
                                    <tr>
                                        <th style="width: 45%">Product</th>
                                        <th style="width: 15%">Variant</th>
                                        <th style="width: 10%">Unit Price</th>
                                        <th style="width: 8%">Quantity</th>
                                        <th style="width: 10%">Subtotal</th>
                                        <th style="width: 12%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carts as $key => $cart)
                                        <tr>
                                            <td>
                                                <div class="product-info">
                                                    <a class="fw-normal fs-6"
                                                        href="{{ $theme->is_active == 1 ? route('single.product', $cart['associatedModel']->slug) : route('theme.single.product', ['path' => $theme->path, 'slug' => $cart['associatedModel']->slug]) }}">
                                                        <img style="width: 50px"
                                                            src="{{ $cart['associatedModel']->get_feature_image ? asset($cart['associatedModel']->get_feature_image->file_url) : asset('frontEnd/' . $theme->path . '/images/no_image.png') }}"
                                                            alt="{{ $cart['name'] }}">
                                                    </a>
                                                    <div class="product-name">
                                                        <div class="product-data-title">
                                                            <h5>Product</h5>
                                                        </div>
                                                        <a class="fw-normal fs-6"
                                                            href="{{ $theme->is_active == 1 ? route('single.product', $cart['associatedModel']->slug) : route('theme.single.product', ['path' => $theme->path, 'slug' => $cart['associatedModel']->slug]) }}">{{ $cart['name'] }}</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
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
                                                            <span class="text-dark">{{ ucfirst($attribute->name) }} :
                                                                {{ ucfirst($attributeItem->name) }}</span>
                                                            <br>
                                                        @endforeach
                                                    @endforeach
                                                @else
                                                    <h6 class="text-dark">No Variant</h6>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="product-data-title">
                                                    <h5>Price</h5>
                                                </div>
                                                @if ($cart['attributes'])
                                                    <div class="product-price">
                                                        <span
                                                            class="old-price text-decoration-line-through">{{ $web_settings->currency_sign }}{{ number_format($cart['associatedModel']->regular_price, 2) }}</span>
                                                        <span
                                                            class="new-price">{{ $web_settings->currency_sign }}{{ number_format($cart['price'], 2) }}</span>
                                                    </div>
                                                @else
                                                    <div class="product-price">
                                                        <span
                                                            class="old-price text-decoration-line-through">{{ $web_settings->currency_sign }}{{ $cart['associatedModel']->regular_price }}</span>
                                                        <span
                                                            class="new-price">{{ $web_settings->currency_sign }}{{ number_format($cart['associatedModel']->sale_price, 2) }}</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="product-data-title">
                                                    <h5>Quantity</h5>
                                                </div>

                                                <div class="qty-box">
                                                    <button class="qty-btn qty-minus"
                                                        data-id="{{ $key }}">−</button>

                                                    <input type="text" class="qty-input" value="{{ $cart['quantity'] }}"
                                                        readonly>

                                                    <button class="qty-btn qty-plus"
                                                        data-id="{{ $key }}">+</button>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="product-data-title">
                                                    <h5>Subtotal</h5>
                                                </div>
                                                <div class="subtotal">
                                                    <span class="new-price">{{ $web_settings->currency_sign }}
                                                        {{ number_format($cart->getPriceSum(), 2) }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="action">
                                                    <a href="javascript:void(0);"
                                                        class="add-to-cart-button add-another-cart addToCart"
                                                        data-id="{{ $cart['associatedModel']->id }}"><i
                                                            class="fa fa-plus"></i> Add
                                                        another
                                                    </a>
                                                    <a href="javascript:void(0);"
                                                        data-href="{{ $theme->is_active == 1 ? route('cart.delete', $cart->id) : route('theme.cart.delete', ['path' => $theme->path, 'id' => $cart->id]) }}"
                                                        class="remove-cart-button remove-cart-item"><i
                                                            class="fa fa-trash-can"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="">
                                        <td colspan="5"></td>
                                        <td>
                                            <div class="d-flex justify-content-end">
                                                <a href="javascript:void(0);"
                                                    data-href="{{ $theme->is_active == 1 ? route('cart.clear') : route('theme.cart.clear', ['path' => $theme->path]) }}"
                                                    class="btn btn-sm btn-danger clear-cart-btn w-100">Clear Cart</a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="cart-page-buttons">
                            <h4 class="cart-total-price">Total Amount ({{ $web_settings->currency_sign }}): <span
                                    class="total_price">{{ number_format(\Cart::getTotal(), 2) }}</span></h4>
                            <a href="{{ $theme->is_active == 1 ? route('checkout') : route('theme.checkout', ['path' => $theme->path]) }}"
                                class="place-order-button">Place Order</a>
                            <a href="{{ $theme->is_active == 1 ? route('home') : route('theme.home', ['path' => $theme->path]) }}"
                                class="shopping-button">Continue Shipping</a>
                        </div>
                    @else
                        <h3 class="text-danger text-center fw-bold mb-5 mt-5">Cart is empty.</h3>
                        <div class="text-center">
                            <a class="btn btn-success"
                                href="{{ $theme->is_active == 1 ? route('search') : route('theme.search', ['path' => $theme->path]) }}">Continue
                                Shopping</a>
                        </div>
                    @endif
                    <div class="bulk-order-message">
                        <p
                            style="font-style:italic;text-align:center; margin: 15px; padding: 15px; background:#f6f6f6; border: 0px solid; border-radius:5px;">
                            * If you wish to make a bulk order, please call us at <span
                                style="font-weight:bold">{{ $web_settings->website_phone }}
                            </span> or email
                            at <span style="font-weight:bold">{{ $web_settings->website_email }}</span> for more
                            information.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <a href="javascript:void(0);" class="shopping-cart cart-count" data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"> <i class="fa fa-shopping-cart "></i>
        <span class="badge bg-primary cart-badge ">{{ count(\Cart::getContent()) }}</span>
    </a>
@endsection

@push('js')
    {{-- <script>
        $(document).on('click', '.product-slider-item', function() {
            let imgUrl = $(this).find('img').attr('src');
            $('.product-slider-image').find('img').attr('src', imgUrl);
        });
        $(document).on('submit', '#addToCartForm', function(e) {
            e.preventDefault();
            let url = $(this).attr('action');
            let method = $(this).attr('method');

            $.ajax({
                url: url,
                type: method,
                data: new FormData(this),
                contentType: false,
                processData: false,
                cache: false,

                success: function(response){
                    if(response.success){
                        toastr.success(response.success);
                        $('#cart').load(' #cart');
                        $('.cart-badge').load(' .cart-badge');
                    }
                }
            })
        });
    </script> --}}
@endpush
