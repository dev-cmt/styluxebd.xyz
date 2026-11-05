@extends('frontEnd.' . $theme->path . '.layouts.master')

@push('css')
<link rel="stylesheet" href="{{ asset('/') }}frontEnd/{{ $theme->path }}/assets/css/swiper-bundle.min.css" />
<style>
    #banner-section {
        position: relative;
        width: 100%;
        height: 75vh;
        /* default height large screens */
        overflow: hidden;
    }

    /* Slider Images */
    #banner-section .swiper-slide img {
        width: 100%;
        height: 75vh;
        /* full height of banner-section */
        display: block;
        object-fit: fill;
        /* maintain aspect ratio & fill container */
    }

    /* Small devices: tablets */
    @media (max-width: 1024px) {
        #banner-section {
            height: 55vh;
        }

        #banner-section .swiper-slide img {
            height: 55vh;
        }
    }

    /* Mobile devices */
    @media (max-width: 768px) {
        #banner-section {
            height: 45vh;
        }

        #banner-section .swiper-slide img {
            height: 45vh;
        }
    }

    /* Extra small mobile */
    @media (max-width: 480px) {
        #banner-section {
            height: 20vh;
        }

        #banner-section .swiper-slide img {
            height: 20vh;
        }
    }

    #banner-section .swiper-button-next,
    #banner-section .swiper-button-prev {
        color: #fff;
        /* or any color you want */
    }

    /* Remove default Swiper "Next"/"Prev" text */
    .swiper-button-next::after,
    .swiper-button-prev::after {
        content: none !important;
    }

    /* Make button circular + icon visible */
    .swiper-button-next,
    .swiper-button-prev {
        width: 38px;
        height: 38px;
        background: rgba(0, 0, 0, 0.4);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        /* icon color */
        top: 50%;
        transform: translateY(18%);
    }

    .swiper-button-next i,
    .swiper-button-prev i {
        font-size: 16px;
    }

    .swiper-button-next:hover,
    .swiper-button-prev:hover {
        background: rgba(0, 0, 0, 0.6);
    }

    /* Positioning */
    .swiper-button-prev {
        left: 10px;
    }

    .swiper-button-next {
        right: 10px;
    }
</style>
<style>
    .shop-cat-fixed {
        position: sticky;
        top: 0;
        z-index: 999;
        background: white;
        padding: 10px 0;
        display: flex;
        flex-direction: column;
        gap: 10px;
        border-bottom: 1px solid #eee;
    }

    .shop-now-btn {
        background: #ff5722;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 6px;
        font-weight: 600;
        white-space: nowrap;
    }

    .category-list-wrapper {
        overflow: hidden;
    }

    .category-list {
        display: flex;
        gap: 12px;
        white-space: nowrap;
    }
</style>
<style>
    /* Remove fixed positioning */
    .shop-cat-wrapper {
        position: relative;
        /* instead of fixed */
        width: 100%;
        z-index: 1;
    }

    .category-list-wrapper {
        overflow-x: auto;
        white-space: nowrap;
    }

    .category-list {
        display: flex;
        gap: 1rem;
    }

    /*.cat-item a:hover {
                                                                                background-color: #007bff;
                                                                                color: #fff;
                                                                            }*/

    /* Optional: for responsive scrolling */
    .category-list-wrapper::-webkit-scrollbar {
        display: none;
    }
</style>
<style>
    .marquee-container {
        width: 100%;
        overflow: hidden;
        position: relative;
    }

    .marquee-track {
        display: flex;
        /* width: max-content; */
        animation: marquee 35s linear infinite;
        justify-content: space-between;
    }

    /* hover pause */
    .marquee-container:hover .marquee-track {
        animation-play-state: paused;
    }

    .marquee-content {
        display: flex;
        align-items: center;
        gap: 32px;
        padding-right: 32px;
    }

    .cat-item {
        white-space: nowrap;
        flex-shrink: 0;
    }

    /* animation */
    @keyframes marquee {
        from {
            transform: translateX(50vw);
            /* start from center */
        }

        to {
            transform: translateX(-100%);
        }
    }

    /* mobile */
    @media (max-width: 768px) {
        .marquee-track {
            animation-duration: 60s;
        }

        .marquee-content {
            gap: 20px;
        }
    }

    .marquee-content {
        display: flex;
        align-items: center;
        gap: 24px;
    }


    /* clickable wrapper */
    .cat-link {
        display: inline-flex;
        /* 🔥 important */
        justify-content: center;
        text-align: center;
        text-decoration: none;
        color: black;
    }

    /* card */
    .cat-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        /* 🔥 horizontal center */
        justify-content: center;
        text-align: center;
        /* 🔥 text center (desktop fix) */
        min-width: 90px;
    }

    /* text under image */
    .cat-name {
        display: block;
        width: 100%;
        text-align: center !important;
        /* 🔥 force center */
        margin-top: 8px;
        font-size: 13px;
    }

    /* image */
    .cat-item img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        /* 🔥 circle */
        object-fit: cover;
        background: #f2f2f2;
        padding: 4px;
        transition: transform .3s ease, box-shadow .3s ease;
    }

    /* hover effect */
    .cat-link:hover img {
        transform: scale(1.08);
        box-shadow: 0 6px 16px rgba(0, 0, 0, .15);
    }


    /* hover text */
    .cat-link:hover .cat-name {
        color: #0d6efd;
    }

    /* mobile */
    @media (max-width: 768px) {
        .cat-item {
            min-width: 75px;
        }

        .cat-item img {
            width: 56px;
            height: 56px;
        }

        .cat-name {
            font-size: 12px;
        }
    }
</style>
<style>
    .category-card {
        display: block;
        position: relative;
        width: 100%;
        text-decoration: none;
        color: white;
        overflow: hidden;
        border-radius: 12px;
    }

    .category-card-bg {
        position: relative;
        width: 100%;
        padding-top: 30%;
        /* aspect ratio, adjust as needed */
        background-size: cover;
        background-position: center;
        transition: transform 0.3s ease;
    }

    .category-card:hover .category-card-bg {
        transform: scale(1.05);
        /* subtle zoom effect on hover */
    }

    .category-card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        /* semi-transparent overlay */
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 0 10px;
    }

    .category-card-overlay h2 {
        font-size: 24px;
        font-weight: 600;
        margin: 0;
        color: #fff;
    }
</style>
@endpush
@section('title')
Home
@endsection

{{-- @php
    $web_settings = DB::table('general_settings')->first();
    $home_page_settings = DB::table('home_page_settings')->first();
@endphp --}}

@section('content')
{{-- Banner Section Slider --}}
<section id="banner-section">
    <div class="swiper bannerSwiper">

        <div class="swiper-wrapper">
            @foreach ($sliders as $slider)
            <div class="swiper-slide">
                <a href="{{ $slider->url ?? '' }}">
                    <img src="{{ asset($slider->get_img->file_url) }}" alt="">
                </a>
            </div>
            @endforeach
        </div>

        <!-- Navigation arrows with icons only -->
        <div class="swiper-button-next"><i class="fa fa-arrow-right"></i></div>
        <div class="swiper-button-prev"><i class="fa fa-arrow-left"></i></div>

        <!-- Pagination dots -->
        <div class="swiper-pagination"></div>
    </div>
</section>
<section class="menu-section py-3" id="menu-section">
    <div class="category-slider">
        <div class="shop-cat-wrapper">
            <div class="category-list-wrapper marquee-container">
                <div class="marquee-track">

                    <div class="marquee-content">
                        @foreach ($categories as $cat)
                        <a href="{{ $theme->is_active == 1
                                    ? route('single.category', $cat->slug)
                                    : route('theme.single.category', ['path' => $theme->path, 'slug' => $cat->slug]) }}"
                            class="cat-link">

                            <div class="cat-item text-center">
                                <img src="{{ asset($cat->file_url ? $cat->file_url : 'frontEnd/' . $theme->path . '/assets/images/no_image.png') }}"
                                    alt="{{ $cat->category_name }}">
                                <span class="cat-name">{{ $cat->category_name }}</span>
                            </div>

                        </a>
                        @endforeach
                    </div>

                    <!-- 🔁 duplicate for seamless loop -->
                    <div class="marquee-content">
                        @foreach ($categories as $cat)
                        <a href="{{ $theme->is_active == 1
                                    ? route('single.category', $cat->slug)
                                    : route('theme.single.category', ['path' => $theme->path, 'slug' => $cat->slug]) }}"
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
{{-- New Arrival Section  --}}
<section id="new-arrival">
    <div class="container">
        <div class="new-arrival-card">
            <h5 class="card-title">TOP CATEGORIES</h5>
        </div>
        <div class="category_wrapper">
            <div class="row">
                @foreach ($topCategories as $category)
                <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                    <div class="category_card">
                        <a
                            href="{{ $theme->is_active == 1 ? route('single.category', $category->slug) : route('theme.single.category', ['path' => $theme->path, 'slug' => $category->slug]) }}">
                            <img style="aspect-ratio: 3/3"
                                src="{{ asset($category->file_url ? $category->file_url : 'frontEnd/' . $theme->path . '/assets/images/no_image.png') }}"
                                alt="{{ $category->category_name }}">
                        </a>
                        <div class="category-button">
                            <a href="{{ $theme->is_active == 1 ? route('single.category', $category->slug) : route('theme.single.category', ['path' => $theme->path, 'slug' => $category->slug]) }}"
                                class="category-name">{{ $category->category_name }}</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Category Banner Section  --}}
<section id="category-banner-section">
    <div class="container">
        <div class="row">
            @foreach ($categories->take(3) as $category)
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-4">
                <a
                    href="{{ $theme->is_active == 1 ? route('single.category', $category->slug) : route('theme.single.category', ['path' => $theme->path, 'slug' => $category->slug]) }}">
                    <div class="category-banner-image">
                        <img src="{{ asset($category->file_url) }}" alt="{{ $category->category_name }}">
                    </div>
                    <div class="category-name">
                        <h5>{{ $category->category_name }}</h5>
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
{{-- Category Section  --}}
@if ($firstCategory)
<section id="category-section">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <a href="{{ $theme->is_active == 1 ? route('single.category', $firstCategory->slug) : route('theme.single.category', ['path' => $theme->path, 'slug' => $firstCategory->slug]) }}"
                    class="category-link">
                    <div class="category-image">
                        <img src="{{ $firstCategory->file_url ? asset($firstCategory->file_url) : asset('frontEnd/' . $theme->path . '/assets/images/no_image.png') }}"
                            alt="{{ $firstCategory->category_name }}">
                    </div>
                    <div class="category-name">
                        <h2>{{ $firstCategory->category_name }}</h2>
                    </div>
                </a>
            </div>
            <div class="col-xl-8 col-lg-9 col-md-8 col-sm-6 col-xs-12">
                <div class="row">
                    @foreach ($firstCategory->get_products->where('status', 1)->where('theme_id', $theme->id)->take(8) as $key => $product)
                    @if ($key < 7)
                        <div class="col-md-3 col-6">
                        <div class="product_card">
                            <div class="product-image">
                                <a href="{{ $theme->is_active == 1 ? route('single.product', $product->slug) : route('theme.single.product', ['path' => $theme->path, 'slug' => $product->slug]) }}"
                                    class="product-link">
                                    <img style="aspect-ratio: 3/3"
                                        src="{{ $product->get_thumb ? asset($product->get_thumb->file_url) : asset('frontEnd/' . $theme->path . '/assets/images/no_image.png') }}"
                                        alt="{{ $product->name }}">
                                </a>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <div
                                    class="product-price d-flex align-items-center justify-content-center gap-2">
                                    @if ($product->sale_price > 0)
                                    <p class="new-price">
                                        {{ number_format($product->sale_price, 2) }}
                                        {{ $web_settings->currency_sign }}
                                    </p>
                                    <p class="old-price"
                                        style="text-decoration: line-through; font-size: 0.85rem;; color: #888;">
                                        {{ number_format($product->regular_price, 2) }}
                                        {{ $web_settings->currency_sign }}
                                    </p>
                                    @else
                                    <p class="new-price">
                                        {{ number_format($product->regular_price, 2) }}
                                        {{ $web_settings->currency_sign }}
                                    </p>
                                    @endif


                                </div>
                            </div>
                            <div class="">
                                <button class="btn btn-dark btn-sm w-100 buy-now-button buyBowBtn"
                                    data-id="{{ $product->id }}">Buy Now</button>
                            </div>
                        </div>
                </div>
                @else
                <div class="col-md-3 col-6">
                    <a href="{{ $theme->is_active == 1 ? route('single.product', $product->slug) : route('theme.single.product', ['path' => $theme->path, 'slug' => $product->slug]) }}"
                        class="product-link">
                        <div class="product_card">
                            <div class="product-image">
                                <img src="{{ asset($product->get_feature_image ? $product->get_feature_image->file_url : 'no_available.jpg') }}"
                                    alt="{{ $product->name }}">
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <div
                                    class="product-price d-flex align-items-center justify-content-center gap-2">
                                    @if ($product->sale_price > 0)
                                    <p class="new-price">
                                        {{ number_format($product->sale_price, 2) }}
                                        {{ $web_settings->currency_sign }}
                                    </p>
                                    <p class="old-price"
                                        style="text-decoration: line-through; font-size: 0.85rem;; color: #888;">
                                        {{ number_format($product->regular_price, 2) }}
                                        {{ $web_settings->currency_sign }}
                                    </p>
                                    @else
                                    <p class="new-price">
                                        {{ number_format($product->regular_price, 2) }}
                                        {{ $web_settings->currency_sign }}
                                    </p>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="">
                            <button class="btn btn-dark btn-sm w-100 buy-now-button buyBowBtn"
                                data-id="{{ $product->id }}">Buy Now</button>
                        </div>
                    </a>
                    <a href="{{ $theme->is_active == 1 ? route('single.category', $firstCategory->slug) : route('theme.single.category', ['path' => $theme->path, 'slug' => $firstCategory->slug]) }}"
                        class="category-view-more"><span>View</span><span>More</span></a>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
    </div>
</section>
@endif
{{-- Comfort Section  --}}
<section id="comfort-section">
    <div class="container">
        @if (!empty($promotion))
        <div class="row">
            @foreach ($promotion->banners as $banner)
            <div class="col-lg-6 col-md-6 col-sm-6 mb-1">
                <div class="image">
                    <a href="{{ $banner->link }}">
                        <img src="{{ asset($banner->image) }}" alt="" />
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

{{-- Category Section  --}}
@foreach ($remainingCategories as $cat)
<section id="category-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-12 d-none d-md-block">
                <a href="{{ $theme->is_active == 1 ? route('single.category', $cat->slug) : route('theme.single.category', ['path' => $theme->path, 'slug' => $cat->slug]) }}"
                    class="category-link">
                    <div class="category-image">
                        <img src="{{ asset($cat->file_url ? $cat->file_url : 'frontEnd/' . $theme->path . '/assets/images/no_image.png') }}"
                            alt="{{ $cat->category_name }}">
                    </div>
                    <div class="category-name">
                        <h2>{{ $cat->category_name }}</h2>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-12 d-block d-md-none">
                <a href="{{ $theme->is_active == 1 ? route('single.category', $cat->slug) : route('theme.single.category', ['path' => $theme->path, 'slug' => $cat->slug]) }}"
                    class="category-card">
                    <div class="category-card-bg"
                        style="background-image: url('{{ asset($cat->file_url ? $cat->file_url : 'frontEnd/' . $theme->path . '/assets/images/no_image.png') }}');">
                        <div class="category-card-overlay">
                            <h2>{{ $cat->category_name }}</h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-8">
                <div class="row">
                    @foreach ($cat->get_products()->where('theme_id', $theme->id)->orderBy('id', 'desc')->take(8)->get() as $key => $product)
                    <div class="col-md-3 col-6">
                        <div class="product_card">
                            <div class="product-image">
                                <a href="{{ $theme->is_active == 1 ? route('single.product', $product->slug) : route('theme.single.product', ['path' => $theme->path, 'slug' => $product->slug]) }}"
                                    class="product-link">
                                    <img style="aspect-ratio: 3/3"
                                        src="{{ $product->get_thumb ? asset($product->get_thumb->file_url) : asset('frontEnd/' . $theme->path . '/assets/images/no_image.png') }}"
                                        alt="{{ $product->name }}">
                                </a>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="product-price">
                                    <p class="new-price">
                                        <strong>{{ $web_settings ? $web_settings->currency_sign : 'TK' }}
                                            {{ number_format($product->sale_price, 2) }}</strong>
                                    </p>
                                    <p class="old-price">
                                        <strike>{{ $web_settings ? $web_settings->currency_sign : 'TK' }}
                                            {{ number_format($product->regular_price, 2) }}</strike>
                                    </p>

                                </div>
                            </div>
                            <div class="">
                                <button class="btn btn-dark btn-sm w-100 buy-now-button buyBowBtn"
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
        const bannerSwiper = new Swiper(".bannerSwiper", {
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

<script>
    const slider = document.getElementById('marqueeSlider');
    let speed = 0.4;
    let pos = 0;

    function marquee() {
        pos -= speed;
        if (Math.abs(pos) >= slider.scrollWidth / 2) pos = 0;
        slider.style.transform = `translateX(${pos}px)`;
        requestAnimationFrame(marquee);
    }

    // Start marquee
    marquee();

    // Pause on hover/touch
    slider.addEventListener('mouseenter', () => speed = 0);
    slider.addEventListener('mouseleave', () => speed = 0.4);
    slider.addEventListener('touchstart', () => speed = 0);
    slider.addEventListener('touchend', () => speed = 0.4);
</script>
@endpush
