<!doctype html>
<html lang="en">

<head>
    {!! $web_settings->gtm_head_script ?? null !!}
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <meta name="description" content="">
    <meta property="og:site_name" content="{{ env('APP_NAME') }}">
    <meta property="og:image"
        content="{{ $web_settings->get_logo ? asset($web_settings->get_logo->file_url) : 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg' }}">
    <meta property="og:title" content="{{ env('APP_NAME') }}">
    <meta property="og:description" content="">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:type" content="e-commerce">
    <meta name="twitter:title" content="{{ env('APP_NAME') }}">
    <meta name="twitter:description" content="">
    <link rel="shortcut icon"
        href="{{ $web_settings->get_fav ? asset($web_settings->get_fav->file_url) : 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg' }}">

    <link href="{{ asset('frontEnd/' . $theme->path . '/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontEnd/' . $theme->path . '/assets/css/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        referrerpolicy="no-referrer">
    <link rel="stylesheet"
        href="{{ asset('frontEnd/' . $theme->path . '/assets/plugins/swiper/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontEnd/' . $theme->path . '/assets/css/toastr.min.css') }}">
    <link href="{{ asset('frontEnd/' . $theme->path . '/assets/css/font-awesome-all.css') }}" rel="stylesheet">
    @stack('css')

    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1017471384626636');
        fbq('track', 'PageView');
    </script>
    @if (session()->has('add_to_cart_event'))
        @php
            $cartData = session('add_to_cart_event');
            $atcEventId = 'atc_' . $cartData['id'] . '_' . time();

            // session()->forget('add_to_cart_event');

        @endphp

        <script>
            fbq('track', 'AddToCart', {
                content_name: @json($cartData['name']),
                content_ids: [@json($cartData['id'])],
                content_type: 'product',
                value: {{ $cartData['price'] * $cartData['quantity'] }},
                currency: 'BDT'
            }, {
                eventID: @json($atcEventId)
            });
        </script>
    @endif
    @yield('PixelCode')
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=1017471384626636&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->

    <style>
        html,
        body {
            overflow-x: hidden;
        }

        img,
        .product_card,
        .offcanvas {
            max-width: 100%;
            box-sizing: border-box;
        }
    </style>
    <style>
        .qty-box {
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #ddd;
            padding: 5px 10px;
            border-radius: 6px;
            width: max-content;
        }

        .qty-btn {
            width: 32px;
            height: 32px;
            border: none;
            background: #f1f1f1;
            font-size: 18px;
            line-height: 32px;
            text-align: center;
            border-radius: 4px;
            cursor: pointer;
        }

        .qty-btn:hover {
            background: #ddd;
        }

        .qty-input {
            width: 45px;
            text-align: center;
            border: none;
            font-size: 15px;
            background: transparent;
        }
    </style>
    <style>
        /* Spinner overlay style */
        .category-product-wrapper {
            position: relative;
            /* spinner overlay এর জন্য relative */
        }

        .category-product-wrapper .search-loader {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            /* semi-transparent overlay */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999;
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
    </style>
</head>

<body style="overflow-x: hidden" class="overflow-x-hidden gotop">

    @if (isset($planExpiredData['website_status']) && $planExpiredData['website_status'] == 2)
        {{-- TERMINATED: FULL BLOCK MODE --}}
        <div
            style="
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    width: 100%;
    padding: 20px;
    background: #f8f8f8;
">
            <div
                style="
        background: #fff4f4;
        border: 1px solid #ffcccc;
        padding: 45px;
        max-width: 1000px;
        width: 100%;
        border-radius: 16px;
        text-align: center;
        box-shadow: 0 6px 18px rgba(0,0,0,0.12);
    ">
                <h2 style="color:#8b0000; font-size: 36px; margin-bottom: 15px;">
                    ⛔ Website Terminated
                </h2>

                <p style="font-size: 18px; color:#444;">
                    This website has been <strong>terminated</strong>. Immediate action is required.
                </p>

                <p style="margin-top: 25px; color:#555; font-size: 18px;">
                    Need help? Contact: <strong>{{ $planExpiredData['support_phone'] }}</strong>
                </p>
            </div>
        </div>
    @else
        {{-- @dd(\App\PDCart::getContent()) --}}
        @include('frontEnd.' . $theme->path . '.includes.header')

        @yield('content')

        {{-- Facilities Section  --}}
        @include('frontEnd.' . $theme->path . '.includes.facilities')

        {{-- Newsletter Section   --}}
        @include('frontEnd.' . $theme->path . '.includes.newsletter')
        @include('frontEnd.' . $theme->path . '.includes.mobile_footer_nav')

        {{-- Footer Section  --}}
        @include('frontEnd.' . $theme->path . '.includes.footer')

        {{-- Copyright Section   --}}
        @include('frontEnd.' . $theme->path . '.includes.copyright')
    @endif



    {{--     @dd(Cart::getContent()) --}}
    <a href="javascript:void(0);" class="shopping-cart" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
        aria-controls="offcanvasRight"> <i class="fa fa-shopping-cart"></i>
        <span class="badge bg-primary cart-badge cart-count">{{ count(\Cart::getContent()) }}</span>
    </a>
    {{-- product cart  --}}
    <div class="offcanvas offcanvas-end shipping-cart-offcanvas" tabindex="-1" id="offcanvasRight"
        aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M18 6l-12 12" />
                    <path d="M6 6l12 12" />
                </svg>
            </button>
            <h5 id="offcanvasRightLabel">CART</h5>
        </div>
        <div class="offcanvas-body cart-items">
            @if (count(\Cart::getContent()) > 0)
                <table class="cart-table table table-condensed">
                    <tbody class="">
                        @foreach (\Cart::getContent() as $key => $item)
                            <tr>
                                <td>
                                    <div class="product-info">
                                        <div class="product-name">
                                            <a
                                                href="{{ $theme->is_active == 1 ? route('single.product', $item['associatedModel']->slug) : route('theme.single.product', ['path' => $theme->path, 'slug' => $item['associatedModel']->slug]) }}">{{ $item['name'] }}</a>
                                        </div>
                                        <div class="product-image">
                                            <img src="{{ $item['associatedModel']->get_feature_image ? asset($item['associatedModel']->get_feature_image->file_url) : asset('frontEnd/' . $theme->path . '/images/no_image.png') }}"
                                                alt="{{ $item['name'] }}">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="product-price">
                                        <p>Price</p>
                                        @if ($item['attributes'])
                                            <p>
                                                @if ($item['associatedModel']->sale_price > 0)
                                                    <span
                                                        class="old_price text-decoration-line-through">{{ $web_settings->currency_sign }}{{ number_format($item['associatedModel']->regular_price, 2) }}</span>
                                                    <span
                                                        class="new_price">{{ $web_settings->currency_sign }}{{ number_format($item['price'], 2) }}</span>
                                                @else
                                                    <span
                                                        class="new_price">{{ $web_settings->currency_sign }}{{ number_format($item['price'], 2) }}</span>
                                                @endif
                                            </p>
                                        @else
                                            <p>
                                                @if ($item['associatedModel']->sale_price > 0)
                                                    <span
                                                        class="old_price text-decoration-line-through">{{ $web_settings->currency_sign }}{{ $item['associatedModel']->regular_price }}</span>
                                                    <span
                                                        class="new_price">{{ $web_settings->currency_sign }}{{ number_format($item['associatedModel']->sale_price, 2) }}</span>
                                                @else
                                                    <span
                                                        class="new_price">{{ $web_settings->currency_sign }}{{ number_format($item['product']->regular_price, 2) }}</span>
                                                @endif
                                            </p>
                                        @endif
                                    </div>
                                </td>
                                @foreach (json_decode($item['attributes'], true) as $attribute_name => $attr)
                                    @php
                                        $attribute = DB::table('attributes')->where('id', $attr)->first();

                                    @endphp
                                    <td>
                                        <div class="product-attribute">
                                            <p>Variant</p>
                                        </div>
                                        @foreach (explode('-', $item->attributes[0]) as $ite)
                                            @php
                                                $attributeItem = \App\AttributeItem::find($ite);
                                                $attribute = \App\Attribute::find($attributeItem->attribute_id);
                                            @endphp
                                            <span class="text-dark">{{ ucfirst($attribute->name) }} :
                                                {{ ucfirst($attributeItem->name) }}</span>
                                            <br>
                                        @endforeach
                                    </td>
                                @endforeach
                                <td>
                                    <div class="product-data-title">
                                        <h5>Quantity</h5>
                                    </div>

                                    <div class="qty-box">
                                        <button class="qty-btn qty-minus" data-id="{{ $key }}">−</button>

                                        <input type="text" class="qty-input" value="{{ $item['quantity'] }}"
                                            readonly>

                                        <button class="qty-btn qty-plus" data-id="{{ $key }}">+</button>
                                    </div>
                                </td>
                                <td>
                                    <div class="subtotal">
                                        <p>Subtotal</p>
                                        <p>{{ $web_settings->currency_sign }}{{ number_format($item->getPriceSum(), 2) }}
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <div class="action">
                                        <a href="javascript:void(0);"
                                            class="add-to-cart-button add-another-cart addToCart"
                                            data-id="{{ $item['associatedModel']->id }}"><i class="fa fa-plus"></i>
                                            Add another Variant</a>
                                        <a href="javascript:void(0);"
                                            data-href="{{ $theme->is_active == 1 ? route('cart.delete', $item->id) : route('theme.cart.delete', ['path' => $theme->path, 'id' => $item->id]) }}"
                                            class="remove-cart-button remove-cart-item"><i
                                                class="fa fa-trash-can"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h5 class="text-center text-danger fw-bold">Your cart is empty!</h5>
            @endif
        </div>
        <div class="offcanvas-footer">
            <div class="cart-total">
                <span>Cart total</span>
                <span>{{ $web_settings->currency_sign }} {{ number_format(\Cart::getTotal(), 2) }}</span>
            </div>
            <a href="{{ $theme->is_active == 1 ? route('checkout') : route('theme.checkout', ['path' => $theme->path]) }}"
                class="checkout-button">Checkout <svg xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-right">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 6l6 6l-6 6" />
                </svg></a>
        </div>
    </div>

    {{-- product modal  --}}
    <div class="modal" tabindex="-1" id="product_modal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chose</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="product_put">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="scrolltop" style="">
        <div class="scroll">
            <i class="fa fa-angle-up"></i>
        </div>
    </div>
    <style>
        .scrolltop {
            position: fixed;
            right: 27px !important;
            bottom: 90px !important;
            width: 40px !important;
            background: #3C7D17 !important;
            height: 40px !important;
            line-height: 40px !important;
            border-radius: 50% !important;
            text-align: center !important;
            color: #ffff !important;
            font-size: 24px !important;
            cursor: pointer;
            z-index: 99;
        }
    </style> --}}

    @include('frontEnd.' . $theme->path . '.pages.partials.social-button')
    {{-- Jquery  --}}
    <script src="{{ asset('frontEnd/' . $theme->path . '/assets/js/jquery.js') }}"></script>

    {{-- Bootstrap  Js --}}
    <script src="{{ asset('frontEnd/' . $theme->path . '/assets/js/bootstrap.bundle.min.js') }}"></script>

    {{-- Swipper Js  --}}
    {{--    <script src="{{ asset('frontEnd/'. $theme->path .'/assets/plugins/swiper/js/swiper-bundle.min.js') }}"></script> --}}

    {{-- Toastr JS --}}
    <script src="{{ asset('frontEnd/' . $theme->path . '/assets/js/toastr.min.js') }}"></script>
    <script src="{{ asset('frontEnd/' . $theme->path . '/assets/js/fontawesome.js') }}" crossorigin="anonymous"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
        }
    </script>
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if ($errors->any())
            toastr.error("{{ $errors->first() }}");
        @endif
    </script>

    <script>
        const swiper = new Swiper('.swiper', {
            speed: 400,
            spaceBetween: 30,
            grabCursor: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },

            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            // // If we need pagination
            // pagination: {
            //     el: '.swiper-pagination',
            //     clickable: false,
            // },
            // Responsive breakpoints
            breakpoints: {
                // when window width is >= 640px
                640: {
                    slidesPerView: 2,
                },
                // when window width is >= 768px
                768: {
                    slidesPerView: 4,
                },
                // when window width is >= 1024px
                1024: {
                    slidesPerView: 8,
                }
            },
        });
    </script>
    <script>
        "use strict";

        const dropdownContent = document.querySelector(".dropdown");
        const chevron = document.getElementById("chevron");

        function showMenu() {
            dropdownContent.classList.toggle("active");
            chevron.classList.toggle("rotate");
        }

        window.onclick = (event) => {
            if (!event.target.matches(".dropdown-button")) {
                dropdownContent.classList.remove("active");
                chevron.classList.remove("rotate");
            }
        };
    </script>
    <script>
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) {
                $(".scrolltop:hidden").stop(true, true).fadeIn();
            } else {
                $(".scrolltop").stop(true, true).fadeOut();
            }
        });
        $(function() {
            $(".scroll").click(function() {
                $("html,body").animate({
                    scrollTop: $(".gotop").offset().top
                }, "1000");
                return false;
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(window).scroll(function() {
                if ($(window).width() > 500) {
                    if ($(this).scrollTop() > $('.top-nav').height()) {
                        $('.custom-nav').addClass('mobile-sticky');
                        $('.category-sidebar').css('top', '60px');
                    } else {
                        $('.category-menu').removeClass('show');
                        $('.custom-nav').removeClass('mobile-sticky');
                        var source = "{!! asset('frontEnd/' . $theme->path . '/assets/images/menu_icon.png') !!}";
                        $('.menu-bar').find('img').attr('src', source);
                        $('.category-sidebar').css('top', '120px');
                    }
                }
            });
            if ($(window).width() > 500) {
                if ($(this).scrollTop() > $('.top-nav').height()) {
                    $('.category-sidebar').css('top', '60px');
                    $('.custom-nav').addClass('mobile-sticky');
                } else {
                    $('.category-menu').removeClass('show');
                    $('.custom-nav').removeClass('mobile-sticky');
                    var source = "{!! asset('frontEnd/' . $theme->path . '/assets/images/menu_icon.png') !!}";
                    $('.menu-bar').find('img').attr('src', source);
                    $('.category-sidebar').css('top', '120px');
                }
            }
        });
        $(document).on('click', '.submenu-dropdown', function() {
            let submenuContent = $(this).parent().find('.submenu-content');
            if (submenuContent.hasClass('show')) {
                $(this).css('font-weight', '400');
                $(this).find('i').addClass('fa-plus');
                $(this).find('i').remove('fa-minus');
                submenuContent.removeClass('show');
            } else {
                $(this).css('font-weight', 'bold');
                $(this).find('i').removeClass('fa-plus');
                $(this).find('i').addClass('fa-minus');
                submenuContent.addClass('show');
            }
        });
        $(document).on('click', '.menu-bar-show', function() {
            let page_type = $(this).data('page');
            if (page_type == 'category_page') {
                if ($('.category-sidebar').hasClass('show')) {
                    $('.category-sidebar').removeClass('show');
                    var source = "{!! asset('frontEnd/' . $theme->path . '/assets/images/menu_icon.png') !!}";
                    $(this).find('img').attr('src', source);
                } else {
                    $('.category-sidebar').addClass('show');
                    var source = "{!! asset('frontEnd/' . $theme->path . '/assets/images/cross_icon.png') !!}";
                    $(this).find('img').attr('src', source);
                }
            } else {
                if ($('.category-menu').hasClass('show')) {
                    $('.category-menu').removeClass('show');
                    var source = "{!! asset('frontEnd/' . $theme->path . '/assets/images/menu_icon.png') !!}";
                    $(this).find('img').attr('src', source);
                } else {
                    $('.category-menu').addClass('show');
                    var source = "{!! asset('frontEnd/' . $theme->path . '/assets/images/cross_icon.png') !!}";
                    $(this).find('img').attr('src', source);
                }
            }

        });
        /*$(document).on('click', '.search-button', function() {
            if ($('.search').hasClass('show')) {
                $('.search').removeClass("show");
            } else {
                $('.search').addClass("show");
            }
        });*/

        $(document).on('click', '.quantity-plus-button', function() {
            let qty = $(this).parent().find('.quantity-input').val();
            $(this).parent().find('.quantity-input').val(parseInt(qty) + 1);
        });

        $(document).on('click', '.quantity-minus-button', function() {
            let qty = $(this).parent().find('.quantity-input').val();
            if (qty > 1) {
                $(this).parent().find('.quantity-input').val(parseInt(qty) - 1);
            }
        });

        function refreshCart(total_cart = null) {

            // Smooth partial reload
            $.ajax({
                url: location.href,
                type: "GET",
                success: function(data) {
                    let html = $(data);

                    $(".cart-items").html(html.find(".cart-items").html());
                    $(".cart-total").html(html.find(".cart-total").html());
                    $(".cart-page-table").load(location.href + " .cart-page-table>*");
                    $(".total_price").html(html.find(".total_price").html());
                    $("#cart-section").html(html.find("#cart-section").html());

                    if (total_cart !== null) {
                        $(".cart-count").text(total_cart);
                    }

                }
            });
        }


        $(document).on('click', '.addToCart', function() {
            let id = $(this).data('id');
            // 🔥 Offcanvas auto close
            let offcanvasEl = document.getElementById('offcanvasRight');
            let offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvasEl);
            if (offcanvasInstance) {
                offcanvasInstance.hide();
            }

            $.ajax({
                url: "{{ $theme->is_active == 1 ? route('ajax.get.product.modal') : route('theme.ajax.get.product.modal', ['path' => $theme->path]) }}",
                type: "GET",
                data: {
                    id: id,
                    type: 'addToCart',
                },
                success: function(data) {
                    if (data) {
                        $('#product_modal').modal('show');
                        $('.product_put').html(data);
                    }
                }
            })
        });
        $(document).on('click', '.buyBowBtn', function() {
            let id = $(this).data('id');
            $.ajax({
                url: "{{ $theme->is_active == 1 ? route('ajax.get.product.modal') : route('theme.ajax.get.product.modal', ['path' => $theme->path]) }}",
                type: "GET",
                data: {
                    id: id,
                    type: 'buyNow',
                },
                success: function(data) {
                    if (data) {
                        $('#product_modal').modal('show');
                        $('.product_put').html(data);
                    }
                }
            })
        });

        $(document).on('click', '.remove-cart-item', function() {
            let url = $(this).data('href');
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.success);
                        refreshCart(response.total_cart);
                    }
                }
            });
        });
        $(document).on('click', '.clear-cart-btn', function() {

            let url = $(this).data('href');

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.success);
                        refreshCart(0);
                        $("#cart-section").load("#cart-section");
                    }
                },
                error: function() {
                    toastr.error("Something went wrong!");
                }
            });

        });

        $(document).on('click', '.attribute_label', function() {
            $('.attribute_label').removeClass('checked');
            $(this).addClass('checked');
        });

        // ===============================
        let actionType = null;

        // detect which button pressed
        $(document).on('click', '#addToAnotherCartForm button[type="submit"]', function() {
            actionType = $(this).val();
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

                success: function(response) {
                    if (response.success) {
                        if (response.buy_now_redirect) {
                            window.location.href = response.buy_now_redirect;
                        } else {
                            toastr.success(response.success);
                            refreshCart(response.total_cart);
                            $('#product_modal').modal('hide');
                        }
                    }

                    if (response.error) {
                        toastr.error(response.error);
                    }
                },

                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });


        $(document).on("click", ".qty-plus", function() {
            let id = $(this).data("id");
            let input = $(this).siblings(".qty-input");
            let currentQty = parseInt(input.val());
            let url =
                "{{ $theme->is_active == 1 ? route('cart.plus', ['id' => ':id']) : route('theme.cart.plus', ['path' => $theme->path, 'id' => ':id']) }}";
            url = url.replace(':id', id);

            // Immediately update UI
            let newQty = currentQty + 1;
            input.val(newQty);

            // Then call AJAX to update backend
            updateCartQty(id, newQty, url);
        });

        $(document).on("click", ".qty-minus", function() {
            let id = $(this).data("id");
            let input = $(this).siblings(".qty-input");
            let currentQty = parseInt(input.val());
            let url =
                "{{ $theme->is_active == 1 ? route('cart.minus', ['id' => ':id']) : route('theme.cart.minus', ['path' => $theme->path, 'id' => ':id']) }}";
            url = url.replace(':id', id);
            if (currentQty > 1) {
                // Immediately update UI
                let newQty = currentQty - 1;
                input.val(newQty);

                // Then call AJAX to update backend
                updateCartQty(id, newQty, url);
            }
        });


        // AJAX function
        function updateCartQty(id, qty, url) {
            $.ajax({
                url: url,
                type: "GET",
                data: {
                    id: id,
                    quantity: qty,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    toastr.success(response.success);
                    refreshCart();
                }
            });
        }

        $(document).on('change', '.update_attribute', function() {
            let id = $(this).find(":selected").data('id');
            let attribute = [];

            let attributes = $(this).parents('tr').find('.update_attribute');

            attributes.each(function() {
                attribute.push($(this).find(":selected").val());
            });

            $.ajax({
                url: "{{-- {{ route('update.cart.attribute') }} --}}",
                type: 'POST',
                data: {
                    _token: @json(csrf_token()),
                    id: id,
                    attribute: attribute,
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.success);
                        $('#cart').load(' #cart');
                        $('.cart-page-table').load(' .cart-page-table');
                        $('.cart-table').load(' .cart-table');
                    }
                    if (response.error) {
                        toastr.error(response.error);
                    }
                }
            });
        });

        let searchTimeout;

        $(document).on('keyup', '.search_product', function() {
            let search_product = $(this).val();

            // Clear previous timer
            clearTimeout(searchTimeout);

            // Set new timer
            searchTimeout = setTimeout(function() {
                // Loader দেখানোর জন্য
                if ($('.search-loader').length === 0) {
                    $('.put_search_product').html(
                        '<div class="search-loader" style="text-align:center;padding:20px;"><i class="fa fa-spinner fa-spin fa-2x"></i></div>'
                    );
                } else {
                    $('.search-loader').show();
                }

                $.ajax({
                    url: "{{ $theme->is_active == 1 ? route('ajax.search.product') : route('theme.ajax.search.product', ['path' => $theme->path]) }}",
                    type: "POST",
                    data: {
                        _token: @json(csrf_token()),
                        search_product: search_product
                    },
                    beforeSend: function() {
                        $('.put_search_product').css('display', 'block');
                    },
                    success: function(data) {
                        $('.put_search_product').html(data);
                    },
                    error: function() {
                        $('.put_search_product').html(
                            '<p style="text-align:center;color:red;">Something went wrong!</p>'
                        );
                    },
                    complete: function() {
                        $('.search-loader').hide();
                    }
                });
            }, 1000); // 1 সেকেন্ড debounce
        });
        $(document).on('click', function(e) {

            // যদি click search input বা suggestion box এর ভিতরে না হয়
            if (!$(e.target).closest('.search_product, .put_search_product').length) {
                $('.put_search_product').hide();
            }

        });
    </script>
    @stack('js')

    <script>
        $(document).on('click', '.product-slider-item', function() {
            let imgUrl = $(this).find('img').attr('src');
            $('.product-slider-image').find('img').attr('src', imgUrl);
        });
    </script>
    <script>
        let categorySearchTimeout = null;

        // Function to show loader/spinner overlay
        function showCategorySpinner() {
            if ($('.category-product-wrapper .search-loader').length === 0) {
                $('.category-product-wrapper').append(
                    '<div class="search-loader"><i class="fa fa-spinner fa-spin fa-2x"></i></div>');
            } else {
                $('.category-product-wrapper .search-loader').show();
            }
        }

        function hideCategorySpinner() {
            $('.category-product-wrapper .search-loader').hide();
        }

        // Checkbox change
        $(document).on('change', '.category_checkbox', function() {

            let category_ids = [];
            let product_name = $('.category_search_input').val();

            $('.category_checkbox:checked').each(function() {
                category_ids.push($(this).val());
            });

            showCategorySpinner();

            /* ===============================
               🔥 URL UPDATE (NO RELOAD)
            =============================== */
            let params = new URLSearchParams();

            if (product_name && product_name.length > 0) {
                params.set('search_product', product_name);
            }

            if (category_ids.length > 0) {
                params.set('categories', category_ids.join(','));
            }

            let newUrl = window.location.pathname;
            if (params.toString() !== '') {
                newUrl += '?' + params.toString();
            }

            window.history.pushState({}, '', newUrl);

            /* ===============================
               AJAX CALL
            =============================== */
            $.ajax({
                url: "{{ $theme->is_active == 1 ? route('ajax.filter.category.product') : route('theme.ajax.filter.category.product', ['path' => $theme->path]) }}",
                type: "POST",
                data: {
                    _token: @json(csrf_token()),
                    category_ids: category_ids.join(","),
                    product_name: product_name
                },
                success: function(data) {
                    $('.category-product-wrapper').html(data);
                },
                error: function() {
                    $('.category-product-wrapper').html(
                        '<p class="text-center text-danger">Something went wrong!</p>'
                    );
                },
                complete: function() {
                    hideCategorySpinner();
                }
            });
        });

        // Search input keyup with debounce


        $(document).on('keyup', '.category_search_input', function() {

            let product_name = $(this).val();
            let category_ids = [];

            $('.category_checkbox:checked').each(function() {
                category_ids.push($(this).val());
            });

            clearTimeout(categorySearchTimeout);

            categorySearchTimeout = setTimeout(function() {

                showCategorySpinner();

                /* ===============================
                   🔥 URL UPDATE (NO RELOAD)
                =============================== */
                let params = new URLSearchParams();

                if (product_name.length > 0) {
                    params.set('search_product', product_name);
                    $('#load-more-btn').data('search_product', product_name);
                }

                if (category_ids.length > 0) {
                    params.set('categories', category_ids.join(','));
                }

                let newUrl = window.location.pathname + '?' + params.toString();
                window.history.pushState({}, '', newUrl);

                /* ===============================
                   AJAX CALL
                =============================== */
                $.ajax({
                    url: "{{ $theme->is_active == 1 ? route('ajax.filter.category.product') : route('theme.ajax.filter.category.product', ['path' => $theme->path]) }}",
                    type: "POST",
                    data: {
                        _token: @json(csrf_token()),
                        category_ids: category_ids.join(","),
                        product_name: product_name
                    },
                    success: function(data) {
                        $('.category-product-wrapper').html(data);
                    },
                    error: function() {
                        $('.category-product-wrapper').html(
                            '<p class="text-center text-danger">Something went wrong!</p>'
                        );
                    },
                    complete: function() {
                        hideCategorySpinner();
                    }
                });

            }, 1000);
        });
    </script>


    @stack('js')

    <!-- </script> -->
</body>

</html>
