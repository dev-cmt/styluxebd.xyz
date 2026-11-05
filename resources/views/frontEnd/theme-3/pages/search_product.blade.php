@extends('frontEnd.' . $theme->path . '.layouts.master')
@section('title')
    Search Products
@endsection

@push('css')
    <style>
        #facilities-section {
            display: none;
        }

        #newsletter-section {
            display: none;
        }

        #footer-section {
            display: none;
        }

        #copyright-section {
            display: none;
        }

        /* Offcanvas background + text color */
        #categoryOffcanvas {
            background: #fff !important;
            color: #333 !important;
        }

        /* Desktop category-sidebar এর fixed style remove (only inside offcanvas) */
        #categoryOffcanvas .category-sidebar {
            position: relative !important;
            width: 100% !important;
            height: auto !important;
            top: 0 !important;
            left: 0 !important;
            padding-left: 0 !important;
            background: transparent !important;
            overflow-y: visible !important;
        }

        /* Offcanvas label, text visible fix */
        #categoryOffcanvas label,
        #categoryOffcanvas li,
        #categoryOffcanvas .form-check-label {
            color: #333 !important;
        }

        /* Modern E-commerce Product Card Styles - Premium Redesign */
        .category-product-card {
            background: #ffffff;
            border: 1px solid #eaeaea;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        }

        .category-product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
            border-color: #d1d5db;
        }

        .category-product-card .product-image {
            position: relative;
            background: #f8fafc;
            overflow: hidden;
            width: 100%;
        }

        .category-product-card .product-image img {
            width: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .category-product-card:hover .product-image img {
            transform: scale(1.06);
        }

        /* Stock Out Status Badge (Top Right) - Hidden if Stock In */
        .category-product-card .sale-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            z-index: 2;
            font-size: 10px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            color: #fff;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .category-product-card .sale-badge.bg-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        }

        /* Save Badge on Image Top Left */
        .category-product-card .save-badge-overlay {
            position: absolute;
            top: 12px;
            left: 12px;
            z-index: 2;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            color: #fff !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 4px;
            letter-spacing: 0.3px;
        }

        /* Free Delivery Badge Modernized (Adjusted position or combined if needed) */
        .category-product-card .free-delivery-badge {
            position: absolute;
            top: 45px;
            left: 12px;
            z-index: 2;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(4px);
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            color: #374151;
        }

        .category-product-card .free-delivery-badge img {
            width: 12px;
            height: 12px;
        }

        /* Product Info Structure - Attractive Polish */
        .category-product-card .product-info {
            padding: 10px 12px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            text-align: left;
            background: #ffffff;
        }

        .category-product-card .product-name {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
            line-height: 1.45;
            height: 40px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            margin-bottom: 10px;
            transition: color 0.2s ease;
        }

        .category-product-card:hover .product-name {
            color: #2563eb;
        }

        /* Price Layout - Clean & Prominent */
        .category-product-card .price {
            display: flex;
            align-items: baseline;
            gap: 8px;
            margin-bottom: 0;
            margin-top: auto;
        }

        .category-product-card .old-price {
            text-decoration: line-through;
            color: #9ca3af;
            font-size: 13px;
            font-weight: 500;
        }

        .category-product-card .new-price {
            color: #0f172a;
            font-weight: 800;
            font-size: 16px;
            letter-spacing: -0.3px;
        }

        /* Modern Full-Width Bottom Button Styles with Interactive Glow */
        .category-product-card .buy-now-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            background: #0f172a;
            color: #ffffff;
            text-align: center;
            padding: 11px 0;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s ease;
            border-top: 1px solid #f3f4f6;
        }

        .category-product-card .buy-now-button:hover {
            background: #2563eb;
            color: #ffffff;
        }

        /* Category Search Bar Polish */
        .category_search {
            position: relative;
            margin-bottom: 20px;
        }

        .category_search .category_search_input {
            border-radius: 8px;
            padding: 12px 18px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
            transition: all 0.2s;
        }

        .category_search .category_search_input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .category_search .category-search-button {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #6b7280;
            padding: 6px 14px;
        }

        .category-wrapper {
            margin-top: 100px;
        }

        @media (max-width: 767px) {
            .category-wrapper {
                margin-top: 20px;
            }

            .category-product-card .save-badge-overlay {
                position: absolute;
                top: 2px;
                left: 2px;
                font-size: 10px;
            }

            .category-product-card .sale-badge {
                position: absolute;
                top: 2px;
                right: 2px;
                font-size: 10px;
            }

            .category-product-card .buy-now-button {
                display: flex;
                gap: 0px;
                padding: 6px 0;
                font-size: 13px;
            }

        }
    </style>
@endpush

@section('content')
    <section id="category-product-section" class="py-4">
        <div class="container-fluid">
            <div class="row">

                <!-- Desktop Sidebar -->
                <div class="col-lg-3 col-md-4 d-none d-md-block">
                    <div class="category-sidebar">
                        <ul>
                            @foreach ($categories as $category)
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input category_checkbox" name="category_id[]" type="checkbox"
                                            value="{{ $category->id }}" id="category-{{ $category->id }}">
                                        <label class="form-check-label main-parent" for="category-{{ $category->id }}">
                                            {{ $category->category_name }}
                                        </label>
                                    </div>
                                    <span
                                        class="product-count-badge">{{ $category->get_products->where('theme_id', $theme->id)->where('status', 1)->count() }}</span>
                                </li>

                                @if (count($category->children) > 0)
                                    <div style="padding-left: 18px">
                                        @include(
                                            'frontEnd.' . $theme->path . '.pages.partials.search_sub_category',
                                            [
                                                'children' => $category->children,
                                                'currentTheme' => $theme,
                                            ]
                                        )
                                    </div>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- Mobile Filter Button -->
                <div class="d-block d-md-none mb-3 text-end">
                    <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#categoryOffcanvas">
                        <i class="fa fa-filter"></i> Filter
                    </button>
                </div>

                <!-- Offcanvas Sidebar (Mobile View) -->
                <div class="offcanvas offcanvas-start" tabindex="-1" id="categoryOffcanvas" style="width: 70%">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title">Filter By Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                    </div>
                    <div class="offcanvas-body">
                        {{-- <div class="col-12">
                            <form action="">
                                @csrf
                                <div class="category_search">
                                    <input type="text" name="category_search" class="form-control category_search_input"
                                           placeholder="Search product" required>
                                    <button type="submit" class="category-search-button"><i
                                            class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div> --}}

                        <div class="category-sidebar">
                            <ul>
                                @foreach ($categories as $category)
                                    <li>
                                        <div class="form-check">
                                            <input class="form-check-input category_checkbox" name="category_id[]"
                                                type="checkbox" value="{{ $category->id }}"
                                                id="m-category-{{ $category->id }}">
                                            <label class="form-check-label main-parent"
                                                for="m-category-{{ $category->id }}">
                                                {{ $category->category_name }}
                                            </label>
                                        </div>
                                        <span class="product-count-badge">{{ $category->get_products->count() }}</span>
                                    </li>

                                    @if (count($category->children) > 0)
                                        <div style="padding-left: 18px">
                                            @include(
                                                'frontEnd.' . $theme->path . '.pages.partials.search_sub_category',
                                                [
                                                    'children' => $category->children,
                                                    'currentTheme' => $theme,
                                                ]
                                            )
                                        </div>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9 col-md-8 col-12">
                    <div class="category-wrapper">

                        <div class="col-12">
                            <form action="">
                                @csrf
                                <div class="category_search">
                                    <input type="text" name="category_search" class="form-control category_search_input"
                                        placeholder="Search product..." required>
                                    <button type="submit" class="category-search-button"><i
                                            class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="row category-product-wrapper" id="product-list">
                            @if ($products->count() > 0)
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
                                            <a href="javascript:void(0);" class="buy-now-button buyBowBtn"
                                                data-id="{{ $product->id }}"><i class="fa fa-shopping-cart"></i> Buy
                                                Now</a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12">
                                    <h5 class="text-center fw-bold text-danger">No data found.</h5>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            {{-- @if ($products->hasMorePages())
                                <div class="text-center my-5">
                                    <button id="load-more-btn"
                                        class="btn btn-outline-danger text-dark bg-danger-subtle w-25"
                                        data-url="{{ $theme->is_active
                                            ? route('product.load.category', request()->query())
                                            : route('theme.product.load.category', array_merge(['path' => $theme->path], request()->query())) }}"
                                        data-page="1" data-category="{{ $category->id }}">
                                        Load More
                                    </button>
                                </div>
                            @endif --}}
                            @if ($products->hasMorePages())
                                <div class="text-center my-5">
                                    <button id="load-more-btn"
                                        class="btn btn-outline-danger text-dark bg-danger-subtle w-25"
                                        data-next="{{ $theme->is_active
                                            ? route('product.load.category', request()->query())
                                            : route('theme.product.load.category', array_merge(['path' => $theme->path], request()->query())) }}"
                                        data-page="1" data-category="{{ $category->id }}">
                                        Load More
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="text-center my-3 d-none" id="scroll-loader">
        <div class="spinner-border"></div>
    </div>

@endsection
@push('js')
    <script>
        let loading = false;
        let offset = {{ $products->count() ?? 0 }};

        $(document).on('click', '#load-more-btn', function(e) {
            e.preventDefault();

            if (loading) return;
            loading = true;

            let btn = $(this);
            let route = btn.data('next');
            let page = btn.data('page');
            let categoryId = btn.data('category');


            btn.prop('disabled', true).text('Loading...');

            $.get(route, {
                page: page,
                category_id: categoryId,
                offset: offset
            }, function(res) {
                $('#product-list').append(res.html);
                offset = res.next_offset;

                if (res.has_more) {
                    btn.data('page', page + 1);
                    btn.prop('disabled', false).text('Load More');
                } else {
                    btn.remove();
                }

                loading = false;
            });
        });
    </script>
@endpush
