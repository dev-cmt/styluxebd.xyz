@extends('frontEnd.' . $theme->path . '.layouts.master')
@section('title')
    {{ $product->name }}
@endsection
@section('PixelCode')
    <script>
        // সার্ভার থেকে জেনারেট করা বা ফ্রন্টএন্ডের ইউনিক ইভেন্ট আইডি
        const eventId = 'vc_' + '{{ $product->id }}_' + Date.now();
        fbq('track', 'ViewContent', {
            content_name: '{{ $product->name }}',
            content_ids: ['{{ $product->id }}'],
            content_type: 'product',
            value: {{ $product->sale_price != 0 ? $product->sale_price : $product->price }},
            currency: 'BDT'
        }, {
            eventID: eventId
        });
    </script>
@endsection
@push('css')
    <!-- Swiper CSS -->
    <style>
        /* Main image container */
        .product-main {
            width: 100%;
            overflow: hidden;
            border-radius: 8px;
            background: #f7f7f7;
            position: relative;
        }

        /* Zoom image */
        .product-main img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.2s ease-out;
            transform-origin: center center;
        }

        /* Thumbnail styling */
        .product-thumbs .swiper-slide {
            width: 50px;
            height: auto;
            opacity: .6;
            border-radius: 6px;
            overflow: hidden;
            cursor: pointer;
        }

        .product-thumbs .swiper-slide-thumb-active {
            opacity: 1;
            border: 2px solid #000;
        }

        /* Custom Prev-Next Buttons */
        .custom-prev,
        .custom-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 11;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #fff;
            font-size: 22px;
            font-weight: bold;
            color: #111;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            opacity: 0.2;
        }

        .custom-prev {
            left: 10px;
        }

        .custom-next {
            right: 10px;
        }

        .custom-prev:hover,
        .custom-next:hover {
            background: #111;
            color: #fff;
        }

        /* Thin light arrows for thumbnail slider */
        .thumb-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 26px;
            height: 26px;
            font-size: 14px;
            color: #444;
            border: 1px solid #ccc;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 20;
            /* important: make sure it's above swiper wrapper */
            transition: 0.2s;
        }

        .thumb-arrow:hover {
            background: #eee;
            border-color: #999;
        }

        .thumb-prev {
            left: 0;
            opacity: 0.6;
        }

        .thumb-next {
            right: 0;
            opacity: 0.6;
        }

        @media(max-width: 768px) {
            .thumb-prev {
                left: -25px;
            }

            .thumb-next {
                right: -25px;
            }
        }
    </style>
@endpush

@section('content')
    <style>
        .variant-group {
            margin-bottom: 15px;
        }

        .variant-label {
            font-weight: 600;
            display: block;
            margin-bottom: 5px;
        }

        .variant-items {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .variant-items input {
            display: none;
        }

        .variant-item {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px 8px;
            border: 1px solid #ddd;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .variant-item.active,
        .variant-item:hover {
            border-color: #000;
            box-shadow: 0 2px 6px rgba(127, 173, 57, 0.3);
        }

        .variant-item img {
            max-width: 50px;
            max-height: 50px;
            border-radius: 5px;
        }
    </style>
    <section id="product-details-section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 mb-3">

                    <!-- Main Slider -->
                    <div class="swiper productSwiperMain" style="position:relative;">

                        <!-- Prev / Next -->
                        <div class="custom-prev"><i class="fa fa-arrow-left"></i></div>
                        <div class="custom-next"><i class="fa fa-arrow-right"></i></div>

                        <div class="swiper-wrapper">

                            {{-- Feature Image --}}
                            @if ($product->get_feature_image)
                                <div class="swiper-slide">
                                    <div class="product-main hover-zoom">
                                        <img src="{{ asset($product->get_feature_image->file_url) }}" alt="">
                                    </div>
                                </div>
                            @endif

                            {{-- Gallery --}}
                            @foreach ($product->gallery_images() as $image)
                                <div class="swiper-slide">
                                    <div class="product-main hover-zoom">
                                        <img src="{{ asset($image->file_url) }}" alt="">
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <!-- Thumbs -->
                    <div class="swiper productSwiperThumbs mt-3 product-thumbs" style="position:relative;">

                        <!-- Thin & Light Prev/Next buttons -->
                        <div class="thumb-prev thumb-arrow"><i class="fa fa-arrow-left"></i></div>
                        <div class="thumb-next thumb-arrow"><i class="fa fa-arrow-right"></i></div>

                        <div class="swiper-wrapper">

                            @if ($product->get_feature_image)
                                <div class="swiper-slide">
                                    <img src="{{ asset($product->get_feature_image->file_url) }}"
                                        style="width:100%; height:100%; object-fit:contain;">
                                </div>
                            @endif

                            @php
                                $allImages = collect($product->gallery_images())
                                    ->pluck('file_url')
                                    ->merge($product->getImagesAttribute())
                                    ->unique();
                            @endphp

                            @foreach ($allImages as $img)
                                <div class="swiper-slide">
                                    <img src="{{ asset($img) }}" style="width:100%;height:100%;object-fit:contain;">
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <form
                        action="{{ $theme->is_active == 1 ? route('add.cart') : route('theme.add.cart', ['path' => $theme->path]) }}"
                        id="addToCartForm" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="product-details">
                            <h4 class="product-name">{{ $product->name }}</h4>
                            <p class="text-muted"><strong>code</strong> - {{ $product->sku }}</p>
                            <div class="price">
                                @if ($product->sale_price > 0)
                                    <p style="font-size: 25px !important;">
                                        {{ $web_settings->currency_sign ?? 'TK' }} <span id="old-price"
                                            style="text-decoration: line-through; color: #888; font-size: 25px;"
                                            class="old-price">{{ number_format($product->regular_price, 2) }}</span></p>
                                    <p style="font-size: 25px !important;">
                                        {{ $web_settings->currency_sign ?? 'TK' }} <span id="new-price"
                                            class="new-price">{{ number_format($product->sale_price, 2) }}</span></p>
                                @else
                                    <p style="font-size: 25px !important;">
                                        {{ $web_settings->currency_sign ?? 'TK' }} <span id="new-price"
                                            class="new-price">{{ number_format($product->regular_price, 2) }}</span></p>
                                @endif

                            </div>
                        </div>
                        @if ($product->has_variant && $product->get_variants && count($product->get_variants) > 0)
                            @foreach ($product->get_attribute_with_items() as $attributeBlock)
                                @php
                                    $attribute = $attributeBlock['attribute'];
                                    $items = $attributeBlock['items'];
                                @endphp
                                {{-- @dd($attribute, $items); --}}

                                <div class="variant-group mb-3">
                                    {{-- Attribute Name --}}
                                    <label class="variant-label fw-bold d-block mb-2">
                                        {{ ucfirst($attribute->name) }}: <span class="variant-name"></span>
                                    </label>

                                    {{-- Items --}}
                                    <div class="variant-items d-flex flex-wrap gap-2">
                                        @foreach ($items as $key => $item)
                                            @php
                                                $isImageType = $attribute->is_image ?? false;
                                                $itemImage =
                                                    $isImageType && $item->item_image
                                                        ? asset($item->item_image->file_url)
                                                        : '';
                                            @endphp

                                            @if ($isImageType && $itemImage)
                                                <label
                                                    class="variant-item variant-item-image {{ $key == 0 ? 'active' : '' }}">
                                                    <input type="radio" class="attr_checkbox attr_image_checkbox d-none"
                                                        name="attribute_item_id[{{ $attribute->id }}]"
                                                        data-image="{{ $itemImage }}"
                                                        data-price="{{ $item->sale_price ?? $product->sale_price }}"
                                                        data-regular="{{ $item->regular_price ?? $product->regular_price }}"
                                                        value="{{ $item->attribute_item_id }}"
                                                        {{ $key == 0 ? 'checked' : '' }}>
                                                    <img src="{{ $itemImage }}" alt="{{ $item->name }}">
                                                </label>
                                            @else
                                                <label class="variant-item text-btn {{ $key == 0 ? 'active' : '' }}">
                                                    <input type="radio" class="attr_checkbox d-none"
                                                        name="attribute_item_id[{{ $attribute->id }}]"
                                                        data-image="{{ $itemImage }}"
                                                        data-price="{{ $item->sale_price ?? $product->sale_price }}"
                                                        data-regular="{{ $item->regular_price ?? $product->regular_price }}"
                                                        value="{{ $item->attribute_item_id }}"
                                                        {{ $key == 0 ? 'checked' : '' }}>
                                                    {{ ucfirst($item->name) }}
                                                </label>
                                            @endif
                                        @endforeach

                                    </div>
                                </div>
                            @endforeach
                        @endif
                        @if ($product->get_size_chart)
                            <div class="mb-3 mt-3">
                                <button type="button"
                                    class="btn btn-outline-dark btn-sm rounded-pill px-3 py-1 fw-semibold d-inline-flex align-items-center gap-1"
                                    data-bs-toggle="modal" data-bs-target="#sizeChartModal" style="font-size: 13px;">
                                    <i class="ti ti-ruler-2 fs-5"></i> View Size Chart
                                </button>
                            </div>

                            <!-- Size Chart Modal -->
                            <div class="modal fade" id="sizeChartModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                        <div class="modal-header bg-light py-2 px-3">
                                            <h5 class="modal-title fw-bold text-dark fs-6">
                                                <i class="ti ti-ruler-2 text-primary me-1"></i> Product Size Chart
                                            </h5>
                                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center p-3 bg-white">
                                            <img src="{{ asset($product->get_size_chart->file_url) }}" alt="Size Chart"
                                                class="img-fluid rounded shadow-sm"
                                                style="max-height: 500px; width: auto; object-fit: contain;">
                                        </div>
                                        <div class="modal-footer bg-light py-2 px-3 justify-content-center">
                                            <button type="button" class="btn btn-dark btn-sm rounded-pill px-4"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- <div class="cart-container">
                            <div class="product-quantity">
                                <span class="quantity-minus-button"><i class="fa fa-minus"></i></span>
                                <input type="number" name="quantity" class="quantity-input" min="1" value="1"
                                    readonly>
                                <span class="quantity-plus-button"><i class="fa fa-plus"></i></span>
                            </div>

                            <input type="checkbox" hidden id="order_now_input"
                                class="btn px-4 btn-success order_now_btn order_now_btn_m mt-0" name="order_now"
                                value="1">

                            <input type="hidden" class="btn px-4 add-to-cart-button" name="add_cart" value="add-to-cart">
                            <button type="submit" class="add-to-cart-button"><i class="fa fa-plus"></i> Add To
                                Cart</button>
                            <button type="button" class="add-to-cart-button order-now-btn bg-success"> Buy Now</button>
                        </div> --}}
                        <div class="cart-container-modern">
                            <!-- Quantity Selector (নিচে নামানো হয়েছে) -->
                            <div class="product-quantity-box">
                                <span class="quantity-label">পরিমাণ:</span>
                                <div class="product-quantity">
                                    <span class="quantity-minus-button"><i class="fa fa-minus"></i></span>
                                    <input type="number" name="quantity" class="quantity-input" min="1"
                                        value="1" readonly>
                                    <span class="quantity-plus-button"><i class="fa fa-plus"></i></span>
                                </div>
                            </div>

                            <!-- Hidden Inputs -->
                            <input type="checkbox" hidden id="order_now_input" name="order_now" value="1">
                            <input type="hidden" name="add_cart" value="add-to-cart">

                            <!-- Action Buttons: Prothom Buy Now, then Cart Icon -->
                            <div class="action-buttons-group">
                                <button type="button" class="btn-buy-now order-now-btn">
                                    <i class="fa fa-bolt me-2"></i> Buy Now
                                </button>

                                <button type="submit" class="btn-cart-icon" title="Add To Cart">
                                    <i class="fa fa-shopping-cart"></i>
                                </button>
                            </div>
                        </div>

                        <style>
                            /* Modern Cart & Buy Now Design */
                            .cart-container-modern {
                                background: #fdfdfd;
                                border: 1px solid #eee;
                                padding: 15px;
                                border-radius: 12px;
                                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
                                margin-bottom: 15px;
                            }

                            .product-quantity-box {
                                display: flex;
                                align-items: center;
                                gap: 10px;
                                margin-bottom: 15px;
                                /* background: #f1f3f5; */
                                padding: 8px 12px;
                                border-radius: 8px;
                            }

                            .quantity-label {
                                font-weight: 600;
                                color: #333;
                                font-size: 14px;
                            }

                            .product-quantity {
                                display: flex;
                                align-items: center;
                                gap: 8px;
                            }

                            .product-quantity span {
                                width: 30px;
                                height: 30px;
                                background: #fff;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                border-radius: 6px;
                                cursor: pointer;
                                border: 1px solid #ddd;
                                font-size: 12px;
                                transition: 0.2s;
                            }

                            .product-quantity span:hover {
                                background: #000;
                                color: #fff;
                                border-color: #000;
                            }

                            .quantity-input {
                                width: 45px;
                                text-align: center;
                                border: 1px solid #ddd;
                                border-radius: 6px;
                                height: 30px;
                                font-weight: 600;
                                background: #fff;
                            }

                            .action-buttons-group {
                                display: flex;
                                gap: 10px;
                                align-items: center;
                            }

                            .btn-buy-now {
                                /* flex: 1; */
                                background: #198754;
                                color: #fff;
                                border: none;
                                padding: 12px 20px;
                                border-radius: 8px;
                                font-weight: 600;
                                font-size: 16px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                transition: 0.3s;
                                box-shadow: 0 4px 10px rgba(25, 135, 84, 0.2);
                                max-width: 250px;
                                width: 100%;
                            }

                            .btn-buy-now:hover {
                                background: #157347;
                                transform: translateY(-1px);
                            }

                            .btn-cart-icon {
                                width: 48px;
                                height: 48px;
                                background: #212529;
                                color: #fff;
                                border: none;
                                border-radius: 8px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                font-size: 18px;
                                transition: 0.3s;
                                box-shadow: 0 4px 10px rgba(33, 37, 41, 0.2);
                            }

                            .btn-cart-icon:hover {
                                background: #000;
                                transform: translateY(-1px);
                            }
                        </style>

                    </form>
                    <hr style="border-top: 1px solid #000;">
                    <p class="text-muted text-center">* স্থানীয় কুরিয়ার ডেলিভারির জন্য কোনও খরচ হবে না</p>
                    @if ($shippingMethods->count() > 0 && $product->free_shipping == 0)
                        <div class="shipping-card mt-3">

                            <div class="shipping-header">
                                🚚 কুরিয়ার ডেলিভারি খরচ
                            </div>

                            <div class="shipping-body">

                                @foreach ($shippingMethods as $item)
                                    <div class="shipping-row">
                                        <span class="shipping-name">{{ $item->text }}</span>
                                        <span
                                            class="shipping-price">{{ $item->amount == 0 ? 'FREE' : $web_settings->currency_sign . ' ' . $item->amount }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <style>
                            .shipping-card {
                                border: 1px solid #e5e7eb;
                                border-radius: 12px;
                                background: #fff;
                                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
                                overflow: hidden;
                                font-size: 15px;
                            }

                            .shipping-header {
                                background: #f8f9fa;
                                padding: 12px;
                                font-weight: 600;
                                text-align: center;
                                border-bottom: 1px solid #e5e7eb;
                            }

                            .shipping-body {
                                padding: 10px 15px;
                            }

                            .shipping-row {
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                                padding: 8px 0;
                                border-bottom: 1px dashed #e5e7eb;
                            }

                            .shipping-row:last-child {
                                border-bottom: none;
                            }

                            .shipping-price {
                                font-weight: 600;
                                color: #16a34a;
                            }
                        </style>
                    @else
                        <div class="delivery-card mt-3">
                            <div class="delivery-header">
                                🚚 কুরিয়ার ডেলিভারি খরচ
                            </div>
                            <div class="delivery-body">
                                <span class="free-badge">FREE DELIVERY</span>
                            </div>
                        </div>
                        <style>
                            .delivery-card {
                                border: 1px solid #e5e7eb;
                                border-radius: 10px;
                                background: #fff;
                                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                                overflow: hidden;
                                text-align: center;
                            }

                            .delivery-header {
                                background: #f8f9fa;
                                font-weight: 600;
                                padding: 10px;
                                font-size: 16px;
                            }

                            .delivery-body {
                                padding: 15px;
                            }

                            .free-badge {
                                background: #16a34a;
                                color: #fff;
                                padding: 8px 18px;
                                border-radius: 30px;
                                font-weight: 600;
                                font-size: 14px;
                            }
                        </style>
                    @endif
                    <div class="product-share-box text-center mt-3">

                        <p class="fw-semibold mb-2">Share this product</p>

                        <div class="d-flex justify-content-center gap-3">

                            <a id="share-facebook" class="share-btn facebook" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>

                            <a id="share-twitter" class="share-btn twitter" target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>

                            <a id="share-instagram" class="share-btn instagram" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>

                        </div>
                    </div>
                    <style>
                        .product-share-box {
                            background: #f8f9fa;
                            padding: 15px;
                            border-radius: 10px;
                        }

                        .share-btn {
                            width: 45px;
                            height: 45px;
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            color: #fff;
                            font-size: 18px;
                            transition: .3s;
                            text-decoration: none;
                        }

                        .share-btn:hover {
                            transform: scale(1.1);
                        }

                        .facebook {
                            background: #1877f2;
                        }

                        .twitter {
                            background: #1da1f2;
                        }

                        .instagram {
                            background: #e4405f;
                        }

                        /* mobile */
                        @media(max-width:576px) {
                            .share-btn {
                                width: 40px;
                                height: 40px;
                                font-size: 16px;
                            }
                        }
                    </style>

                </div>
            </div>
            <div class="row">
                <div class="col-12">

                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs nav-tabs-mod" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#descriptionTab" role="tab">
                                Description
                            </a>
                        </li>

                        {{-- <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#reviewTab" role="tab">
                                Review
                            </a>
                        </li> --}}

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#returnPolicyTab" role="tab">
                                Return Policy
                            </a>
                        </li>

                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content tab-content-mod border">

                        <!-- ⭐ DESCRIPTION -->
                        <div class="tab-pane fade show active" id="descriptionTab" role="tabpanel">
                            <div class="product-description p-3">
                                {{--                                {!! $product->description !!} --}}
                                {!! html_entity_decode($product->description) !!}
                            </div>
                        </div>
                        <style>
                            .product-description iframe {
                                width: 100%;
                                aspect-ratio: 16/9;
                                height: auto;
                            }

                            /* wrapper */
                            .product-description {
                                width: 100%;
                                line-height: 1.6;
                            }

                            /* images */
                            .product-description img {
                                max-width: 100% !important;
                                height: auto !important;
                                display: block;
                                border-radius: 8px;
                            }

                            /* iframe / youtube */
                            .product-description iframe {
                                width: 100% !important;
                                aspect-ratio: 16/9;
                                height: auto !important;
                                display: block;
                                border-radius: 8px;
                            }

                            /* prevent overflow */
                            .product-description * {
                                max-width: 100%;
                            }
                        </style>
                        @php
                            $data = \App\PageSetting::find(1);
                        @endphp

                        <div class="tab-pane fade" id="returnPolicyTab" role="tabpanel">
                            <div class=" p-3">
                                {!! $data->return_policy ?? ' ' !!}
                            </div>
                        </div>
                        <!-- ⭐ REVIEW -->
                        {{-- <div class="tab-pane fade" id="reviewTab" role="tabpanel">

                            <!-- Review List -->
                            <h5 class="mb-3">Customer Reviews</h5>

                            --}}{{--                                @forelse($reviews as $review) --}}{{--
                            <div class="border rounded p-3 mb-3">
                                <strong> --}}{{-- {{ $review->name }} --}}{{-- Tanvir Hasan Nahid</strong>
                                <br>
                                <span class="text-warning">
                                        --}}{{-- Dynamic Stars Later --}}{{--
                                        ★★★★★
                                    </span>
                                <p class="mb-0"> --}}{{-- {{ $review->comment }} --}}{{-- Good product . I used this product for four
                                    month. you can trust this seller.</p>
                            </div>
                            --}}{{--                                @empty --}}{{--
                            --}}{{--                                    <p class="text-muted">No reviews yet.</p> --}}{{--
                            --}}{{--                                @endforelse --}}{{--

                            <hr>

                            <!-- Review Form -->
                            <h5 class="mb-3">Write a Review</h5>

                            <form action=" --}}{{-- {{ route('product.review.store') }} --}}{{-- " method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value=" --}}{{-- {{ $product->id }} --}}{{-- ">

                                <div class="form-group">
                                    <label>Your Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Rating</label>
                                    <div class="star-rating">
                                        <input type="radio" id="star5" name="rating" value="5" required>
                                        <label for="star5" title="5 stars">★</label>

                                        <input type="radio" id="star4" name="rating" value="4">
                                        <label for="star4" title="4 stars">★</label>

                                        <input type="radio" id="star3" name="rating" value="3">
                                        <label for="star3" title="3 stars">★</label>

                                        <input type="radio" id="star2" name="rating" value="2">
                                        <label for="star2" title="2 stars">★</label>

                                        <input type="radio" id="star1" name="rating" value="1">
                                        <label for="star1" title="1 star">★</label>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label>Your Review</label>
                                    <textarea name="comment" class="form-control" rows="3" required></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    Submit Review
                                </button>
                            </form>

                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="related-product-section" style="margin: 40px;">
        <div class="container">
            <div class="related-product-title">
                <h5>You may also like</h5>
            </div>
            <div class="related-product">
                <div class="row">
                    @foreach ($relatedProducts as $relatedProduct)
                        <div class="col-md-2 col-6 mb-3">
                            <a href="{{ $theme->is_active == 1 ? route('single.product', $relatedProduct->slug) : route('theme.single.product', ['path' => $theme->path, 'slug' => $relatedProduct->slug]) }}"
                                class="product-link">
                                <div class="product_card">
                                    <div class="product-image">
                                        <img src="{{ asset($relatedProduct->get_feature_image ? $relatedProduct->get_feature_image->file_url : 'frontEnd/' . $theme->path . '/assets/images/no_image.png') }}"
                                            alt="{{ $relatedProduct->name }}">
                                    </div>
                                    <div class="product-price d-flex align-items-center justify-content-center gap-2">
                                        @if ($relatedProduct->sale_price > 0)
                                            <p class="new-price">
                                                {{ number_format($relatedProduct->sale_price, 2) }}
                                                {{ $web_settings->currency_sign }}
                                            </p>
                                            <p class="old-price"
                                                style="text-decoration: line-through; font-size: 0.85rem;; color: #888;">
                                                {{ number_format($relatedProduct->regular_price, 2) }}
                                                {{ $web_settings->currency_sign }}
                                            </p>
                                        @else
                                            <p class="new-price">
                                                {{ number_format($relatedProduct->regular_price, 2) }}
                                                {{ $web_settings->currency_sign }}
                                            </p>
                                        @endif

                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="{{ asset('frontEnd/' . $theme->path . '/assets/plugins/swiper/js/swiper-bundle.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            /* ==========================================================
               1️⃣  SWIPER INITIALIZATION
            ========================================================== */
            const thumbs = new Swiper(".productSwiperThumbs", {
                slidesPerView: 5,
                spaceBetween: 10,
                watchSlidesProgress: true,
            });

            const mainSlider = new Swiper(".productSwiperMain", {
                spaceBetween: 10,
                thumbs: {
                    swiper: thumbs
                },
                speed: 300,
            });

            // Custom arrows
            document.querySelector(".custom-prev").addEventListener("click", () => mainSlider.slidePrev());
            document.querySelector(".custom-next").addEventListener("click", () => mainSlider.slideNext());
            document.querySelector(".thumb-prev").addEventListener("click", () => thumbs.slidePrev());
            document.querySelector(".thumb-next").addEventListener("click", () => thumbs.slideNext());


            /* ==========================================================
               2️⃣  IMAGE ZOOM SYSTEM (DESKTOP + MOBILE)
            ========================================================== */

            function initZoom(container) {
                const img = container.querySelector("img");

                let scale = 1;
                let lastScale = 1;

                let startX = 0,
                    startY = 0;
                let currentX = 0,
                    currentY = 0;

                let maxX = 0,
                    maxY = 0;
                let isDragging = false;

                let lastTap = 0;
                let startPinchDistance = 0;


                /* ---------- BOUNDS ---------- */
                function updateBounds() {
                    const rect = container.getBoundingClientRect();
                    const w = img.offsetWidth * scale;
                    const h = img.offsetHeight * scale;

                    maxX = Math.max(0, (w - rect.width) / 2);
                    maxY = Math.max(0, (h - rect.height) / 2);
                }

                function clamp() {
                    currentX = Math.min(maxX, Math.max(-maxX, currentX));
                    currentY = Math.min(maxY, Math.max(-maxY, currentY));
                }

                function applyTransform() {
                    img.style.transform = `scale(${scale}) translate(${currentX}px, ${currentY}px)`;
                }


                /* ==========================================================
                   DESKTOP HOVER ZOOM
                ========================================================== */
                container.addEventListener("mousemove", function(e) {
                    if (window.innerWidth < 768) return;

                    const rect = container.getBoundingClientRect();
                    const x = (e.clientX - rect.left) / rect.width * 100;
                    const y = (e.clientY - rect.top) / rect.height * 100;

                    img.style.transformOrigin = `${x}% ${y}%`;
                    img.style.transform = "scale(2.2)";
                });

                container.addEventListener("mouseleave", function() {
                    img.style.transform = "scale(1)";
                    img.style.transformOrigin = "center center";
                });


                /* ==========================================================
                   MOBILE ZOOM — DOUBLE TAP + PINCH + DRAG
                ========================================================== */

                container.addEventListener("touchstart", function(e) {
                    const now = Date.now();

                    /* ---- DOUBLE TAP ---- */
                    if (now - lastTap < 300 && e.touches.length === 1) {
                        img.style.transition = "transform 0.25s ease";

                        if (scale === 1) {
                            scale = 2.2;
                        } else {
                            scale = 1;
                            currentX = 0;
                            currentY = 0;
                        }

                        updateBounds();
                        applyTransform();
                    }

                    lastTap = now;

                    /* ---- DRAG START ---- */
                    if (scale > 1 && e.touches.length === 1) {
                        isDragging = true;
                        img.style.transition = "";
                        startX = e.touches[0].clientX;
                        startY = e.touches[0].clientY;
                    }

                    /* ---- PINCH START ---- */
                    if (e.touches.length === 2) {
                        img.style.transition = "";
                        isDragging = false;

                        const dx = e.touches[0].clientX - e.touches[1].clientX;
                        const dy = e.touches[0].clientY - e.touches[1].clientY;
                        startPinchDistance = Math.sqrt(dx * dx + dy * dy);

                        lastScale = scale;
                    }
                });


                container.addEventListener("touchmove", function(e) {
                    if (scale === 1) return;

                    e.preventDefault();

                    /* ---- PINCH ZOOM ---- */
                    if (e.touches.length === 2) {
                        const dx = e.touches[0].clientX - e.touches[1].clientX;
                        const dy = e.touches[0].clientY - e.touches[1].clientY;

                        const dist = Math.sqrt(dx * dx + dy * dy);

                        scale = lastScale * (dist / startPinchDistance);
                        scale = Math.max(1, Math.min(3, scale));

                        updateBounds();
                        clamp();
                        applyTransform();
                        return;
                    }

                    /* ---- DRAG ---- */
                    if (isDragging) {
                        const t = e.touches[0];
                        currentX += (t.clientX - startX);
                        currentY += (t.clientY - startY);

                        clamp();
                        applyTransform();

                        startX = t.clientX;
                        startY = t.clientY;
                    }
                });

                container.addEventListener("touchend", () => {
                    isDragging = false;
                });
            }


            /* Attach Zoom to all image containers */
            document.querySelectorAll(".hover-zoom").forEach(initZoom);


            // =========================
            // 3️⃣ AJAX function to get attributes
            // =========================
            function getAttributes() {
                const attribute_item_id = [];
                $('.variant-item input:checked').each(function() {
                    attribute_item_id.push($(this).val());
                });

                $.ajax({
                    url: "{{ $theme->is_active == 1 ? route('ajax.get.attributes') : route('theme.ajax.get.attributes', ['path' => $theme->path]) }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_id: {{ $product->id }},
                        attribute_item_id: attribute_item_id
                    },
                    success: function(res) {
                        if (res.success == 200) {
                            $('.loaderr').show();
                            const data = res.data;

                            // Update price
                            const salePrice = parseFloat(data.sale_price) || 0;
                            const regularPrice = parseFloat(data.regular_price) || 0;
                            $('#new-price').text(salePrice.toFixed(2));
                            $('#old-price').text(regularPrice.toFixed(2));
                            $('.product-details-content .save-money').removeClass('d-none').text(
                                'Save: {{ $web_settings->currency_sign }} ' + (regularPrice -
                                    salePrice).toFixed(2));

                            // Update stock
                            if (data.stock <= 0) {
                                $('.product-cart').addClass('d-none');
                                $('.product-cart-out').removeClass('d-none');
                                $('.product-quantity .in-stock').text('Out of Stock').removeClass(
                                    'text-success').addClass('text-danger');
                            } else {
                                $('.product-cart').removeClass('d-none');
                                $('.product-cart-out').addClass('d-none');
                                $('.product-quantity .in-stock').text(data.stock + ' in stock')
                                    .removeClass('text-danger').addClass('text-success');
                            }

                            // Update SKU
                            $('.choice_attribute_sku').text('SKU: ' + data.sku);
                            $('input[name="sku"]').val(data.sku);

                            // Update variant names
                            $.each(data.variant_items, function(key, value) {
                                $('.variant-name').eq(key).text(value.attribute_item);
                            });

                            // Update main slider image if variant image exists
                            if (data.image) {
                                let targetIndex = -1;

                                mainSlider.slides.forEach((slideEl, index) => {
                                    // Only check **real slides** if loop enabled
                                    const img = slideEl.querySelector("img");
                                    if (!img) return;

                                    const slideFile = img.src.split('/').pop();
                                    const dataFile = data.image.split('/').pop();

                                    if (slideFile === dataFile) targetIndex = index;
                                });

                                if (targetIndex !== -1) {
                                    // slideToRealIndex ensures correct slide even with loop
                                    mainSlider.slideTo(mainSlider.getSlideIndex(mainSlider.slides[
                                        targetIndex]));
                                }
                            }

                            $('.loaderr').hide();

                        } else {
                            console.warn(res.message);
                        }
                    },
                    error: function(err) {
                        console.error('AJAX Error:', err);
                    }
                });
            }

            // =========================
            // 4️⃣ Initialize selected variant on page load
            // =========================
            getAttributes();

            /* ==========================================================
               3️⃣  VARIANT CHANGE — UPDATE SLIDER + ZOOM IMAGE
            ========================================================== */
            $(document).on("change", ".variant-item input", function() {
                $('.variant-item input').each(function() {
                    if ($(this).is(':checked')) {
                        $(this).closest('.variant-item').addClass('active').siblings().removeClass(
                            'active');
                    }
                });
                const vImage = $(this).attr("data-image");

                if (vImage) {
                    // Remove previous dynamic images
                    $(".dynamic-variant-slide").remove();

                    // Prepend new slide to Main slider
                    mainSlider.prependSlide(`
                <div class="swiper-slide dynamic-variant-slide">
                    <div class="product-main hover-zoom">
                        <img src="${vImage}">
                    </div>
                </div>
            `);

                    // Prepend new slide to Thumbs
                    thumbs.prependSlide(`
                <div class="swiper-slide dynamic-variant-slide">
                    <img src="${vImage}" style="width:100%;height:100%;object-fit:contain;">
                </div>
            `);

                    setTimeout(() => {
                        mainSlider.slideTo(0);
                        thumbs.slideTo(0);

                        // Reinitialize zoom for new image
                        initZoom(document.querySelector(".product-main.hover-zoom"));
                    }, 20);
                }

                getAttributes(); // your existing AJAX function
            });

        });
    </script>
    <script>
        $(document).ready(function() {

            let $checkbox = $('#order_now_input');
            let $form = $('#addToCartForm');

            // ✅ Order Now → toggle checked/unchecked
            $('.order-now-btn').on('click', function() {
                $checkbox.prop('checked', true);
                $form.trigger('submit');
            });
        });
    </script>

    <script>
        let url = encodeURIComponent(window.location.href);
        let text = encodeURIComponent(document.title);

        $("#share-facebook").attr(
            "href",
            `https://www.facebook.com/sharer/sharer.php?u=${url}`
        );

        $("#share-twitter").attr(
            "href",
            `https://twitter.com/intent/tweet?url=${url}&text=${text}`
        );

        // Instagram direct share possible না → profile open
        $("#share-instagram").attr(
            "href",
            "https://www.instagram.com/"
        );
    </script>
@endpush
