@if (count($products) > 0)
    {{-- <div class="col-12">

    </div> --}}
    @foreach ($products as $product)
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="category-product-card">
                {{-- Show STOCK OUT badge only if stock is <= 1 (Stock In has no badge) --}}
                {{-- @if ($product->stock <= 1)
                    <span class="sale-badge bg-danger">
                        STOCK OUT
                    </span>
                @endif --}}

                {{-- Save Badge moved to the image area (top-left) --}}
                @if ($product->sale_price > 0)
                    <span class="save-badge-overlay">Save
                        {{ number_format($product->regular_price - $product->sale_price, 0) }}
                        {{ $web_settings->currency_sign }}
                    </span>
                @endif

                @if ($product->free_shipping == 1)
                    <span class="free-delivery-badge">
                        <img src="{{ asset('frontEnd/' . $theme->path . '/assets/images/external-flash-photography-images-those-icons-lineal-color-those-icons.png') }}"
                            alt="">
                        Free
                    </span>
                @endif

                <a class="text-decoration-none"
                    href="{{ $theme->is_active == 1 ? route('single.product', $product->slug) : route('theme.single.product', ['path' => $theme->path, 'slug' => $product->slug]) }}">
                    <div class="product-image">
                        <img style="aspect-ratio: 5/6;"
                            src="{{ asset($product->get_feature_image ? $product->get_feature_image->file_url : 'frontEnd/' . $theme->path . '/assets/images/no_image.png') }}"
                            alt="{{ $product->name }}">
                    </div>
                    <div class="product-info">
                        <h6 class="product-name">
                            {{ $product->name }}
                        </h6>
                        <style>
                            .product-price {
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                                margin-top: auto;
                            }

                            @media (max-width: 576px) {
                                .product-price {
                                    flex-direction: column-reverse;
                                    align-items: center;
                                    gap: 5px;
                                }
                            }
                        </style>

                        <div class="product-price">
                            @if ($product->sale_price > 0)
                                <p class="price">
                                    <span
                                        class="new-price">{{ $web_settings->currency_sign }}{{ number_format($product->sale_price, 0) }}</span>
                                    <span
                                        class="old-price">{{ $web_settings->currency_sign }}{{ number_format($product->regular_price, 0) }}</span>
                                </p>
                            @else
                                <p class="price">
                                    <span
                                        class="new-price">{{ $web_settings->currency_sign }}{{ number_format($product->regular_price, 0) }}</span>
                                </p>
                            @endif
                        </div>
                    </div>
                </a>
                <a href="javascript:void(0);" class="buy-now-button buyBowBtn" data-id="{{ $product->id }}"><i
                        class="fa fa-shopping-cart"></i> Buy
                    Now</a>
            </div>
        </div>
    @endforeach
    {{-- @else
    <div class="col-12">
        <h5 class="text-center fw-bold text-danger">Product not found.</h5>
    </div> --}}
@endif
