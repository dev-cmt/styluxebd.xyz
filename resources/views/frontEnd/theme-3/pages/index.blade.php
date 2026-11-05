@extends('frontEnd.' . $theme->path . '.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('/') }}frontEnd/{{ $theme->path }}/assets/css/swiper-bundle.min.css" />
    <style>
        /* --- Banner Section --- */
        #banner-section {
            position: relative;
            width: 100%;
            height: 75vh;
            overflow: hidden;
            background: #f8f9fa;
        }

        #banner-section .swiper-slide img {
            width: 100%;
            height: 75vh;
            display: block;
            object-fit: cover;
        }

        @media (max-width: 1024px) {

            #banner-section,
            #banner-section .swiper-slide img {
                height: 55vh;
            }
        }

        @media (max-width: 768px) {

            #banner-section,
            #banner-section .swiper-slide img {
                height: 40vh;
            }
        }

        @media (max-width: 480px) {

            #banner-section,
            #banner-section .swiper-slide img {
                height: 25vh;
            }
        }

        /* Swiper Navigation Customization */
        .swiper-button-next::after,
        .swiper-button-prev::after {
            content: none !important;
        }

        .swiper-button-next,
        .swiper-button-prev {
            width: 42px;
            height: 42px;
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(4px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            transition: all 0.3s ease;
        }

        .swiper-button-next i,
        .swiper-button-prev i {
            font-size: 16px;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background: rgba(0, 0, 0, 0.75);
            transform: scale(1.05);
        }

        .swiper-button-prev {
            left: 15px;
        }

        .swiper-button-next {
            right: 15px;
        }

        .swiper-pagination-bullet {
            background: #fff;
            opacity: 0.7;
        }

        .swiper-pagination-bullet-active {
            opacity: 1;
            background: #0d6efd;
        }

        /* --- Marquee Category Slider --- */
        .marquee-container {
            width: 100%;
            overflow: hidden;
            position: relative;
            padding: 10px 0;
        }

        .marquee-track {
            display: flex;
            /* width: max-content; */
            animation: marquee 35s linear infinite;
            justify-content: space-between;
        }

        .marquee-container:hover .marquee-track {
            animation-play-state: paused;
        }

        .marquee-content {
            display: flex;
            align-items: center;
            gap: 28px;
            padding-right: 28px;
        }

        @keyframes marquee {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        .cat-link {
            display: inline-flex;
            justify-content: center;
            text-decoration: none;
            color: #333;
        }

        .cat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            min-width: 90px;
        }

        .cat-name {
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 8px;
            font-size: 13px;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .cat-item img {
            width: 85px;
            height: 85px;
            border-radius: 50%;
            object-fit: cover;
            background: #f1f3f5;
            padding: 3px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .cat-link:hover img {
            transform: translateY(-4px);
            border-color: #0d6efd;
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.15);
        }

        .cat-link:hover .cat-name {
            color: #0d6efd;
        }

        @media (max-width: 768px) {
            .cat-item {
                min-width: 70px;
            }

            .cat-item img {
                width: 60px;
                height: 60px;
            }

            .cat-name {
                font-size: 11px;
            }

            .marquee-track {
                animation-duration: 25s;
            }
        }

        /* --- Modern Cards & Pricing Utility --- */
        .product_card,
        .category_card {
            background: #fff;
            border-radius: 12px;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            overflow: hidden;
            border: 1px solid #f1f3f5;
            margin-bottom: 20px;
            padding: 12px;
        }

        .product_card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.07);
        }

        .old-price {
            text-decoration: line-through;
            font-size: 0.85rem;
            color: #adb5bd;
            margin-bottom: 0;
        }

        .new-price {
            font-weight: 700;
            color: #212529;
            margin-bottom: 0;
        }

        .category-card-bg {
            position: relative;
            width: 100%;
            padding-top: 40%;
            background-size: cover;
            background-position: center;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .category-card:hover .category-card-bg {
            transform: scale(1.02);
        }

        .category-card-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 10px;
        }

        .category-card-overlay h2 {
            font-size: 20px;
            font-weight: 600;
            color: #fff;
            margin: 0;
        }
    </style>
@endpush

@section('title')
    Home
@endsection

@section('content')
    {{-- Banner Section Slider --}}
    <section id="banner-section">
        <div class="swiper bannerSwiper">
            <div class="swiper-wrapper">
                @foreach ($sliders as $slider)
                    <div class="swiper-slide">
                        <a href="{{ $slider->url ?? '#' }}">
                            <img src="{{ asset($slider->get_img->file_url ?? '') }}" alt="Banner Image">
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-next"><i class="fa fa-arrow-right"></i></div>
            <div class="swiper-button-prev"><i class="fa fa-arrow-left"></i></div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    {{-- Marquee Category Slider --}}
    <section class="menu-section py-3 bg-white border-bottom" id="menu-section">
        <div class="container-fluid">
            <div class="shop-cat-wrapper">
                <div class="marquee-container">
                    <div class="marquee-track">
                        {{-- First Loop --}}
                        <div class="marquee-content">
                            @foreach ($categories as $cat)
                                <a href="{{ $theme->is_active == 1 ? route('single.category', $cat->slug) : route('theme.single.category', ['path' => $theme->path, 'slug' => $cat->slug]) }}"
                                    class="cat-link">
                                    <div class="cat-item text-center">
                                        <img src="{{ asset($cat->file_url ? $cat->file_url : 'frontEnd/' . $theme->path . '/assets/images/no_image.png') }}"
                                            alt="{{ $cat->category_name }}">
                                        <span class="cat-name">{{ $cat->category_name }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        {{-- Duplicate Loop for Seamless Infinite Animation --}}
                        <div class="marquee-content">
                            @foreach ($categories as $cat)
                                <a href="{{ $theme->is_active == 1 ? route('single.category', $cat->slug) : route('theme.single.category', ['path' => $theme->path, 'slug' => $cat->slug]) }}"
                                    class="cat-link">
                                    <div class="cat-item text-center">
                                        <img src="{{ asset($cat->file_url ? $cat->file_url : 'frontEnd/' . $theme->path . '/assets/images/no_image.png') }}"
                                            alt="{{ $cat->category_name }}">
                                        <span class="cat-name">{{ $cat->category_name }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Top Categories Section --}}
    <section id="new-arrival" class="py-4">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="fw-bold m-0">TOP CATEGories</h5>
            </div>
            <div class="row g-3">
                @foreach ($topCategories as $category)
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                        <div class="category_card text-center">
                            <a
                                href="{{ $theme->is_active == 1 ? route('single.category', $category->slug) : route('theme.single.category', ['path' => $theme->path, 'slug' => $category->slug]) }}">
                                <img class="rounded-circle mb-2" style="width: 100px; height: 100px; object-fit: cover;"
                                    src="{{ asset($category->file_url ? $category->file_url : 'frontEnd/' . $theme->path . '/assets/images/no_image.png') }}"
                                    alt="{{ $category->category_name }}">
                            </a>
                            <a href="{{ $theme->is_active == 1 ? route('single.category', $category->slug) : route('theme.single.category', ['path' => $theme->path, 'slug' => $category->slug]) }}"
                                class="category-name text-dark fw-semibold text-decoration-num d-block text-truncate">{{ $category->category_name }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Category Banner Section --}}
    <section id="category-banner-section" class="py-3">
        <div class="container">
            <div class="row g-3">
                @foreach ($categories->take(3) as $category)
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <a href="{{ $theme->is_active == 1 ? route('single.category', $category->slug) : route('theme.single.category', ['path' => $theme->path, 'slug' => $category->slug]) }}"
                            class="text-decoration-none">
                            <div class="position-relative rounded-4 overflow-hidden shadow-sm">
                                <div class="category-banner-image">
                                    <img src="{{ asset($category->file_url) }}" alt="{{ $category->category_name }}"
                                        class="w-100 object-fit-cover">
                                </div>
                                <div
                                    class="position-absolute bottom-0 start-0 w-100 p-3 bg-dark bg-opacity-50 text-white backdrop-blur">
                                    <h5 class="m-0 fw-bold">{{ $category->category_name }}</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @php
        $firstCategory = $bannerCategories->first();
        $remainingCategories = $bannerCategories->slice(1);
    @endphp

    {{-- First Category Products Section --}}
    @if ($firstCategory)
        <section id="category-section" class="py-4">
            <div class="container">
                <div class="row g-4">
                    <div class="col-xl-4 col-lg-3 col-md-4 d-none d-md-block">
                        <a href="{{ $theme->is_active == 1 ? route('single.category', $firstCategory->slug) : route('theme.single.category', ['path' => $theme->path, 'slug' => $firstCategory->slug]) }}"
                            class="category-link text-decoration-none">
                            <div class="category-image rounded-4 overflow-hidden shadow-sm mb-3">
                                <img src="{{ $firstCategory->file_url ? asset($firstCategory->file_url) : asset('frontEnd/' . $theme->path . '/assets/images/no_image.png') }}"
                                    alt="{{ $firstCategory->category_name }}" class="w-100 object-fit-cover">
                            </div>
                            <div class="category-name text-center">
                                <h2 class="h4 fw-bold text-dark">{{ $firstCategory->category_name }}</h2>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-8 col-lg-9 col-md-8 col-12">
                        <div class="row g-3">
                            @foreach ($firstCategory->get_products->where('status', 1)->where('theme_id', $theme->id)->take(8) as $product)
                                <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                    <div class="product_card h-d-flex flex-column justify-content-between">
                                        <div class="product-image mb-2">
                                            <a href="{{ $theme->is_active == 1 ? route('single.product', $product->slug) : route('theme.single.product', ['path' => $theme->path, 'slug' => $product->slug]) }}"
                                                class="product-link">
                                                <img class="w-100 rounded" style="aspect-ratio: 1/1; object-fit: cover;"
                                                    src="{{ $product->get_thumb ? asset($product->get_thumb->file_url) : asset('frontEnd/' . $theme->path . '/assets/images/no_image.png') }}"
                                                    alt="{{ $product->name }}">
                                            </a>
                                        </div>
                                        <h6 class="text-truncate small mb-1"><a
                                                href="{{ $theme->is_active == 1 ? route('single.product', $product->slug) : route('theme.single.product', ['path' => $theme->path, 'slug' => $product->slug]) }}"
                                                class="text-dark text-decoration-none">{{ $product->name }}</a></h6>
                                        <div class="product-details text-center my-2">
                                            <div
                                                class="product-price d-flex align-items-center justify-content-center gap-2">
                                                @if ($product->sale_price > 0)
                                                    <p class="new-price">
                                                        {{ number_format($product->sale_price, 2) }}
                                                        {{ $web_settings->currency_sign ?? 'TK' }}
                                                    </p>
                                                    <p class="old-price">
                                                        {{ number_format($product->regular_price, 2) }}
                                                        {{ $web_settings->currency_sign ?? 'TK' }}
                                                    </p>
                                                @else
                                                    <p class="new-price">
                                                        {{ number_format($product->regular_price, 2) }}
                                                        {{ $web_settings->currency_sign ?? 'TK' }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <button class="btn btn-dark btn-sm w-100 buy-now-button buyBowBtn rounded-pill"
                                                data-id="{{ $product->id }}">Buy Now</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Promotion / Comfort Section --}}
    <section id="comfort-section" class="py-3">
        <div class="container">
            @if (!empty($promotion) && isset($promotion->banners))
                <div class="row g-3">
                    @foreach ($promotion->banners as $banner)
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="image overflow-hidden rounded-4 shadow-sm">
                                <a href="{{ $banner->link ?? '#' }}">
                                    <img src="{{ asset($banner->image) }}" alt="Promotion Banner"
                                        class="w-100 object-fit-cover" />
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Remaining Category Sections --}}
    @foreach ($remainingCategories as $cat)
        <section id="category-section" class="py-4">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-md-4 col-12 d-none d-md-block">
                        <a href="{{ $theme->is_active == 1 ? route('single.category', $cat->slug) : route('theme.single.category', ['path' => $theme->path, 'slug' => $cat->slug]) }}"
                            class="category-link text-decoration-none">
                            <div class="category-image rounded-4 overflow-hidden shadow-sm mb-3">
                                <img src="{{ asset($cat->file_url ? $cat->file_url : 'frontEnd/' . $theme->path . '/assets/images/no_image.png') }}"
                                    alt="{{ $cat->category_name }}" class="w-100 object-fit-cover">
                            </div>
                            <div class="category-name text-center">
                                <h2 class="h4 fw-bold text-dark">{{ $cat->category_name }}</h2>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-12 d-block d-md-none">
                        <a href="{{ $theme->is_active == 1 ? route('single.category', $cat->slug) : route('theme.single.category', ['path' => $theme->path, 'slug' => $cat->slug]) }}"
                            class="category-card text-decoration-none">
                            <div class="category-card-bg shadow-sm"
                                style="background-image: url('{{ asset($cat->file_url ? $cat->file_url : 'frontEnd/' . $theme->path . '/assets/images/no_image.png') }}');">
                                <div class="category-card-overlay">
                                    <h2>{{ $cat->category_name }}</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-8 col-12">
                        <div class="row g-3">
                            @foreach ($cat->get_products()->where('theme_id', $theme->id)->orderBy('id', 'desc')->take(8)->get() as $product)
                                <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                    <div class="product_card h-100 d-flex flex-column justify-content-between">
                                        <div class="product-image mb-2">
                                            <a href="{{ $theme->is_active == 1 ? route('single.product', $product->slug) : route('theme.single.product', ['path' => $theme->path, 'slug' => $product->slug]) }}"
                                                class="product-link">
                                                <img class="w-100 rounded" style="aspect-ratio: 1/1; object-fit: cover;"
                                                    src="{{ $product->get_thumb ? asset($product->get_thumb->file_url) : asset('frontEnd/' . $theme->path . '/assets/images/no_image.png') }}"
                                                    alt="{{ $product->name }}">
                                            </a>
                                        </div>
                                        <div class="product-details text-center my-2">
                                            <h6 class="text-truncate small mb-1"><a
                                                    href="{{ $theme->is_active == 1 ? route('single.product', $product->slug) : route('theme.single.product', ['path' => $theme->path, 'slug' => $product->slug]) }}"
                                                    class="text-dark text-decoration-none">{{ $product->name }}</a></h6>
                                            <div
                                                class="product-price d-flex align-items-center justify-content-center gap-2">
                                                <p class="new-price">
                                                    {{ $web_settings ? $web_settings->currency_sign : 'TK' }}
                                                    {{ number_format($product->sale_price > 0 ? $product->sale_price : $product->regular_price, 2) }}
                                                </p>
                                                @if ($product->sale_price > 0)
                                                    <p class="old-price">
                                                        {{ $web_settings ? $web_settings->currency_sign : 'TK' }}
                                                        {{ number_format($product->regular_price, 2) }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <button class="btn btn-dark btn-sm w-100 buy-now-button buyBowBtn rounded-pill"
                                                data-id="{{ $product->id }}">Buy Now</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach
@endsection

@push('js')
    <script src="{{ asset('/') }}frontEnd/{{ $theme->path }}/assets/js/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new Swiper(".bannerSwiper", {
                loop: true,
                effect: 'fade',
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                speed: 800,
            });
        });
    </script>
@endpush
