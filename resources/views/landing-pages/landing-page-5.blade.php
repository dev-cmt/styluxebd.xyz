<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $landingPage->title ?? 'Landing Page' }}</title>
    <link rel="stylesheet" href="{{ asset('landing-page/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing-page/assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing-page/assets/css/spectrum.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing-page/landing-page-5/assets/css/style.css') }}">
    @if (isset($enableEdit))
        <link rel="stylesheet" href="{{ asset('landing-page/assets/css/text-editor.css') }}">
    @else
        <style>
            .section-off-on-buttons span,
            .card_list_append_button,
            .card_list_delete_button {
                display: none;
            }
        </style>
    @endif

</head>

<body>

    @php
        $content = json_decode($landingPage->content ?? '[]', true);
        $style = json_decode($landingPage->style ?? '[]', true);

        $main_text = $content['main_text'] ?? [];

        $subtext_one = $content['subtext_one'] ?? [
            'তোসর ফেব্রিক্স',
            'কারচুপি, সিকুয়েন্স, ডলার ও সোনালী সুতার কাজ',
            'ফ্রি সাইজ ড্রেস',
            'সেলোয়ার ২.৫ গজ',
            'ওড়না ৫ হাত',
            'আনস্টিচ থ্রি পিস',
        ];

        $subtext_two = $content['subtext_two'] ?? [
            'প্রত্যেকটা কাপড় মারাত্মক সুন্দর',
            'খুবই রিজনেবল প্রাইজে গরমের মধ্যে আরামদায়ক কাপড়।',
            'কালার গ্যারান্টিড',
            'গলায় সিকোন্সের কাজ করা',
            'বডি ৫০+ পড়তে পারবে',
            'সালোয়ার প্রায় ২.৫ গজ কাপড় দেয়া আছে',
            'সাথে নামাজি বড় ওরনা',
            'দারুন সব কালার এবং ডিজাইন',
        ];
        $subtext_three = $content['subtext_three'] ?? [
            'ডেনিম ফেব্রিক ১০০% কটন টুইল বা স্টেচ টুইল দিয়ে তৈরি হয়।',
            'সহজে ভাঁজ পড়ে না। ফলে আয়রনের ঝামেলা ছাড়াই পরা যায়।',
            'ডেনিম ফেব্রিক দিয়ে তৈরি পোশাক অনেকদিন ব্যবহার করা যায়।',
        ];
        $subtext_four = $content['subtext_four'] ?? [
            'Spandax- 2%',
            'জিন্স বারবার ধোয়ার প্রয়োজন হয় না।',
            'ডেনিম ফেব্রিক ১০০% কটন টুইল বা স্টেচ টুইল দিয়ে তৈরি হয়।',
        ];
        $images = $content['images'] ?? [
            1 => 'landing-page/landing-page-5/images/banner1.png',
            2 => 'landing-page/landing-page-5/images/banner2.png',
            3 => 'landing-page/landing-page-5/images/banner-3.png',
            4 => 'landing-page/landing-page-5/images/banner4.png',
            5 => 'landing-page/landing-page-5/images/banner5.png',
            6 => 'landing-page/landing-page-5/images/banner-6.png',
            7 => 'landing-page/landing-page-5/images/delivery-1.png',
            8 => 'landing-page/landing-page-5/images/delivery-2.png',
            9 => 'landing-page/landing-page-5/images/delivery-3.png',
            10 => 'landing-page/landing-page-5/images/delivery-1.png',
            11 => 'landing-page/landing-page-5/images/call.png',
            12 => 'landing-page/landing-page-5/images/hand.png',
            13 => 'landing-page/landing-page-5/images/checked.png',
            14 => 'landing-page/landing-page-5/images/right-arrow.png',
        ];

        $videos = $content['videos'] ?? [
            1 => 'https://www.youtube.com/watch?v=Ak6BNwpM_q4',
            2 => 'https://www.youtube.com/embed/4w2PmVFegC8',
        ];

        $section_status = $content['section_status'] ?? [
            'section_1' => 'section_on',
            'section_2' => 'section_on',
            'section_3' => 'section_on',
            'section_4' => 'section_on',
            'section_5' => 'section_on',
            'section_6' => 'section_on',
            'section_7' => 'section_on',
            'section_8' => 'section_on',
        ];
    @endphp

    <div
        class="hero {{ empty($enableEdit) && data_get($section_status, 'section_1') !== 'section_on' ? 'd-none' : '' }}">
        <div class="section-off-on-buttons">
            <input type="checkbox" name="section_one" class="section_switch" hidden="hidden" data-section="1"
                id="section_one_switch" {{ ($section_status['section_1'] ?? '') == 'section_on' ? 'checked' : '' }}>
            <label class="switch" for="section_one_switch"></label>
            <div class="section-count">
                <span>1</span>
            </div>
        </div>
        <div class="custom-container {{ $section_status['section_1'] ?? '' }}">
            <div class="col-md-10 hero-header">
                <h1 class="lp_text_editable get_main_text_0" style="{{ $style['get_style_0'] ?? '' }}">
                    {{ $main_text[0] ?? '2023 নিউ কলেশন সুন্দর গর্জিয়াস আনারকলি এবং গারারা থ্রি পিস' }}
                </h1>
                <div class="subtitle">
                    <h4 class="lp_text_editable get_main_text_1" style="{{ $style['get_style_1'] ?? '' }}">
                        {{ $main_text[1] ?? 'সুপার সাইক্লোন ধামাকা অফার ফিক্সড-' }}

                    </h4>
                    <span class="lp_text_editable get_main_text_2" style="{{ $style['get_style_2'] ?? '' }}">
                        {{ $main_text[2] ?? '{{ $web_settings->currency_sign ?>' }} 500.00' }}
                    </span>
                </div>
            </div>
            <div class="col-md-10">
                <div class="row hero-images">
                    <div class="col-md-6 lp_image_editable" data-image_id="1">
                        <img src="{{ asset($images[1] ?? 'landing-page/landing-page-5/images/banner1.png') }}"
                            alt="">
                    </div>
                    <div class="col-md-6 lp_image_editable" data-image_id="2">
                        <img src="{{ asset($images[2] ?? 'landing-page/landing-page-5/images/banner2.png') }}"
                            alt="">

                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="order">
                    <a href="/landing-40#placeAnOrder">এখনই অর্ডার করতে চাই</a>
                </div>
            </div>
        </div>
    </div>

    <div
        class="three-pices {{ empty($enableEdit) && data_get($section_status, 'section_2') !== 'section_on' ? 'd-none' : '' }}">
        <div class="section-off-on-buttons">
            <input type="checkbox" name="section_two" class="section_switch" hidden="hidden" data-section="2"
                id="section_two_switch" {{ ($section_status['section_2'] ?? '') == 'section_on' ? 'checked' : '' }}>
            <label class="switch" for="section_two_switch"></label>
            <div class="section-count">
                <span>2</span>
            </div>
        </div>
        <div class="custom-container {{ $section_status['section_2'] ?? '' }}">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <div class="header">
                        <h2 class="lp_text_editable get_main_text_3" style="{{ $style['get_style_3'] ?? '' }}">
                            {{ $main_text[3] ?? 'সুতির থ্রি পিস ড্রেস মেটেরিয়াল' }}
                        </h2>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row content">
                        <div class="col-md-6">

                            <ul>
                                @if (count($subtext_one) > 0)
                                    @foreach ($subtext_one as $key => $sub_text_one)
                                        <li><img src="{{ asset('landing-page/landing-page-5/images') }}/checked.png"
                                                alt="">
                                            <h4 class="lp_text_editable subtext_one subtext_one_{{ $key }}"
                                                style="{{ $style['subtext_one_' . $key] ?? '' }}">
                                                {{ $sub_text_one }}
                                            </h4>
                                            <button class="card_list_delete_button" data-type="1"
                                                data-key="{{ $key }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M18 6l-12 12" />
                                                    <path d="M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                            <div class="order">
                                <a href="/landing-40#placeAnOrder">
                                    এখনই অর্ডার করতে চাই
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="image lp_image_editable" data-image_id="3">
                                <img src="{{ asset($images[3] ?? 'landing-page/landing-page-5/images/banner4.png') }}"
                                    alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div
        class="youtube {{ empty($enableEdit) && data_get($section_status, 'section_3') !== 'section_on' ? 'd-none' : '' }}">
        <div class="section-off-on-buttons">
            <input type="checkbox" name="section_three" class="section_switch" hidden="hidden" data-section="3"
                id="section_three_switch" {{ ($section_status['section_3'] ?? '') == 'section_on' ? 'checked' : '' }}>
            <label class="switch" for="section_three_switch"></label>
            <div class="section-count">
                <span>3</span>
            </div>
        </div>
        <div class="custom-container  {{ $section_status['section_3'] ?? '' }}">
            <div class="video lp_video_editable" data-video_id="1">
                <iframe src="{{ $videos[1] ?? 'https://www.youtube.com/embed/4w2PmVFegC8' }}" frameborder="0"
                    allowfullscreen=""
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin"
                    title="Funnel Liner Logo Launching Vedio | The First Automated E Commerce Sales Funnel in Bangladesh."
                    width="100%" height="100%" id="widget2"></iframe>
            </div>
        </div>
    </div>

    <div
        class="why-purchase {{ empty($enableEdit) && data_get($section_status, 'section_4') !== 'section_on' ? 'd-none' : '' }}">
        <div class="section-off-on-buttons">
            <input type="checkbox" name="section_four" class="section_switch" hidden="hidden" data-section="4"
                id="section_four_switch" {{ ($section_status['section_4'] ?? '') == 'section_on' ? 'checked' : '' }}>
            <label class="switch" for="section_four_switch"></label>
            <div class="section-count">
                <span>4</span>
            </div>
        </div>
        <div class="custom-container  {{ $section_status['section_4'] ?? '' }}">
            <div class="list-content">
                <div class="header">
                    <h2 class="lp_text_editable get_main_text_4" style="{{ $style['get_style_4'] ?? '' }}">
                        {{ $main_text[4] ?? 'আমাদের এই ইন্ডিয়ান রাজস্থানী বুটিক 3 পিস কেন নিবেন !' }}

                    </h2>
                </div>
                <div class="ul-list">
                    <ul>
                        @if (count($subtext_two) > 0)
                            @foreach ($subtext_two as $key => $sub_text_two)
                                <li><img src="{{ asset('landing-page/landing-page-5') }}/images/right-arrow.png"
                                        alt="">
                                    <h4 class="lp_text_editable subtext_two subtext_two_{{ $key }}"
                                        style="{{ $style['subtext_two_' . $key] ?? '' }}">
                                        {{ $sub_text_two }}
                                    </h4>
                                    <button class="card_list_delete_button" data-type="1"
                                        data-key="{{ $key }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M18 6l-12 12" />
                                            <path d="M6 6l12 12" />
                                        </svg>
                                    </button>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>


            <div class="order-template">
                <h3 class="lp_text_editable get_main_text_6 " style="{{ $style['get_style_6'] ?? '' }}">
                    {{ $main_text[6] ?? 'পূর্বের মূল্য —  546456' }}
                </h3>
                <h2 class="lp_text_editable get_main_text_7" style="{{ $style['get_style_7'] ?? '' }}">
                    {{ $main_text[7] ?? '{{ $web_settings->currency_sign ?>' }} ৯৯৯' }}
                </h2>
                <div class="order">
                    <a href="/landing-40#placeAnOrder">
                        এখনই অর্ডার করতে চাই
                    </a>
                </div>
            </div>

        </div>
    </div>

    <div
        class="product {{ empty($enableEdit) && data_get($section_status, 'section_5') !== 'section_on' ? 'd-none' : '' }}">
        <div class="section-off-on-buttons">
            <input type="checkbox" name="section_five" class="section_switch" hidden="hidden" data-section="5"
                id="section_five_switch" {{ ($section_status['section_5'] ?? '') == 'section_on' ? 'checked' : '' }}>
            <label class="switch" for="section_five_switch"></label>
            <div class="section-count">
                <span>5</span>
            </div>
        </div>
        <div class="custom-container  text-center {{ $section_status['section_5'] ?? '' }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="custom-header">
                        <h2 class="lp_text_editable get_main_text_8" style="{{ $style['get_style_8'] ?? '' }}">
                            {{ $main_text[8] ?? 'আমাদের পিয়ানি কটন থ্রি-পিস কালেকশন কিছু ছবি' }}

                        </h2>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row images">
                        <div class="col-sm-4">
                            <div class="product-image lp_image_editable" data-image_id="4">
                                <img src="{{ asset($images[4] ?? 'landing-page/landing-page-5/images/banner4.png') }}"
                                    alt="">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="product-image lp_image_editable" data-image_id="5">
                                <img src="{{ asset($images[5] ?? 'landing-page/landing-page-5/images/banner5.png') }}"
                                    alt="">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="product-image lp_image_editable" data-image_id="6">
                                <img src="{{ asset($images[6] ?? 'landing-page/landing-page-5/images/banner6.png') }}"
                                    alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div
        class="delivery-section {{ empty($enableEdit) && data_get($section_status, 'section_6') !== 'section_on' ? 'd-none' : '' }}">
        <div class="section-off-on-buttons">
            <input type="checkbox" name="section_six" class="section_switch" hidden="hidden" data-section="6"
                id="section_six_switch" {{ ($section_status['section_6'] ?? '') == 'section_on' ? 'checked' : '' }}>
            <label class="switch" for="section_six_switch"></label>
            <div class="section-count">
                <span>6</span>
            </div>
        </div>
        <div class="custom-container {{ $section_status['section_6'] ?? '' }}">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="delivery-image">
                        <div class="img lp_image_editable" data-image_id="7">
                            <img src="{{ asset($images[7] ?? 'landing-page/landing-page-5/images/delivery-1.png') }}"
                                alt="">
                        </div>
                        <h4 class="lp_text_editable get_main_text_9" style="{{ $style['get_style_9'] ?? '' }}">
                            {{ $main_text[9] ?? 'আকর্ষনীয় প্যাকিং সুবিধা।' }}

                        </h4>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="delivery-image ">
                        <div class="img lp_image_editable" data-image_id="8">
                            <img src="{{ asset($images[8] ?? 'landing-page/landing-page-5/images/delivery-2.png') }}"
                                alt="">
                        </div>
                        <h4 class="lp_text_editable get_main_text_10" style="{{ $style['get_style_10'] ?? '' }}">
                            {{ $main_text[10] ?? 'সারাদেশে হোম ডেলিভারি।' }}

                        </h4>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="delivery-image ">
                        <div class="img lp_image_editable" data-image_id="9">
                            <img src="{{ asset($images[9] ?? 'landing-page/landing-page-5/images/delivery-3.png') }}"
                                alt="">
                        </div>
                        <h4 class="lp_text_editable get_main_text_11" style="{{ $style['get_style_11'] ?? '' }}">
                            {{ $main_text[11] ?? '৩ দিনের রিটার্ন গ্যারান্টি।' }}

                        </h4>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="delivery-image ">
                        <div class="img lp_image_editable" data-image_id="10">
                            <img src="{{ asset($images[10] ?? 'landing-page/landing-page-5/images/delivery-1.png') }}"
                                alt="">
                        </div>
                        <h4 class="lp_text_editable get_main_text_12" style="{{ $style['get_style_12'] ?? '' }}">
                            {{ $main_text[12] ?? 'স্লিম ফিট স্ট্রেচেবল ডেনিম জিন্স ফর মেন' }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div
        class="delivery-charge {{ empty($enableEdit) && data_get($section_status, 'section_7') !== 'section_on' ? 'd-none' : '' }}">
        <div class="section-off-on-buttons">
            <input type="checkbox" name="section_seven" class="section_switch" hidden="hidden" data-section="7"
                id="section_seven_switch" {{ ($section_status['section_7'] ?? '') == 'section_on' ? 'checked' : '' }}>
            <label class="switch" for="section_seven_switch"></label>
            <div class="section-count">
                <span>7</span>
            </div>
        </div>
        <div class="custom-container {{ $section_status['section_7'] ?? '' }}">

            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <p class="lp_text_editable get_main_text_13" style="{{ $style['get_style_13'] ?? '' }}">
                            {{ $main_text[13] ??
                                'নিজের পছন্দে ড্রেস তৈরী করে নিতে কে না পছন্দ করে? মেলা লাইফস্টাইলের আনস্টিচ থ্রি-পিস গুলো
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            হতে পারে আপনার সবসময়ের কম্ফোর্টেবল ড্রেস। সেটের সাথে জামার, প্যান্টের কাপড় থাকবে এবং
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            সাথে থাকবে ওড়না। যেকোন সাইজে নিজের ইচ্ছামত তৈরী করে নিতে পারছেন।' }}

                        </p>

                        <div class="charge-content">
                            <ul>
                                <li><img src="{{ asset('landing-page/landing-page-5/images/hand.png') }}"
                                        alt="">
                                    <h4 class="lp_text_editable get_main_text_14"
                                        style="{{ $style['get_style_14'] ?? '' }}">
                                        {{ $main_text[14] ?? 'ঢাকা সিটির মধ্যে ডেলিভারি চার্জ 80 টাকা।' }}

                                    </h4>
                                </li>
                                <li><img src="{{ asset('landing-page/landing-page-5/images/hand.png') }}"
                                        alt="">
                                    <h4 class="lp_text_editable get_main_text_15"
                                        style="{{ $style['get_style_15'] ?? '' }}">
                                        {{ $main_text[15] ?? 'ঢাকা সিটির বাহিরে ডেলিভারি চার্জ 150 টাকা।' }}

                                    </h4>
                                </li>
                            </ul>
                        </div>
                        <div class="calling"><img src="{{ asset('landing-page/landing-page-5/images/call.png') }}"
                                alt="">
                            <div class="order-text">
                                <p class="lp_text_editable get_main_text_16"
                                    style="{{ $style['get_style_16'] ?? '' }}">
                                    {{ $main_text[16] ?? 'অর্ডার করতে কল করুন' }}

                                </p>
                                <h2 class="lp_text_editable get_main_text_17"
                                    style="{{ $style['get_style_17'] ?? '' }}">
                                    {{ $main_text[17] ?? '০১৮৮০০০০০০০' }}

                                </h2>
                            </div>
                        </div>
                        <div class="order text-center">
                            <a href="/landing-40#placeAnOrder">
                                এখনই অর্ডার করতে চাই
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        /* ===== ORDER SECTION ===== */
        .order-section {
            background: #882a32;
            padding: 70px 0;
            color: #fff;
        }

        /* Heading */
        .order-heading h2 {
            font-size: 50px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 40px;
        }

        /* Card Common Style */
        .product-card,
        .billing-details,
        .order-details {
            background: #ffffff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: 0.3s ease;
            cursor: pointer;
            color: #333;
        }

        .product-card:hover {
            transform: translateY(-4px);
        }

        /* Section Titles */
        .order-title {
            font-size: 20px;
            font-weight: 600;
            /* margin-bottom: 20px; */
            color: #333;
        }

        /* Product Item */
        .product-item {
            display: flex;
            gap: 15px;
        }

        .product-name {
            font-size: 16px;
            color: #333;
        }

        /* Quantity Box */
        .quantity {
            overflow: hidden;
        }

        .quantity span {
            background: #f1f1f1;
            font-weight: 600;
        }

        .quantity-input {
            font-weight: 600;
        }

        /* Variant */
        .variant-item {
            padding: 5px 10px;
            background: #f8f9fa;
            transition: 0.2s;
        }

        .variant-item.active {
            background: #882a32;
            color: #fff;
            border-color: #882a32 !important;
        }

        /* Billing Form */
        .billing-details label {
            font-weight: 600;
            color: #333;
        }

        .billing-details input,
        .billing-details textarea {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 12px;
        }

        .billing-details input:focus,
        .billing-details textarea:focus {
            border-color: #882a32;
            box-shadow: 0 0 0 3px rgba(255, 70, 109, 0.2);
        }

        .shipping-options input {
            padding: 8px;
        }

        /* Order Table */
        .order-details table {
            margin-bottom: 0;
        }

        .order-details th {
            font-weight: 600;
        }

        /* #summary-total {
            color: #882a32;
            font-weight: 700;
        } */

        /* Button */
        .order-place-button {
            background: #882a32 !important;
            border: none !important;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 600;
            padding: 12px;
            transition: 0.3s ease;
        }

        .order-place-button:hover {
            background: #882a32 !important;
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .product-item {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
        }
    </style>
    <!-- Order Section -->
    {{-- @dd($shippingCost) --}}

    <section
        class="order-section {{ empty($enableEdit) && data_get($section_status, 'section_8') !== 'section_on' ? 'd-none' : '' }}"
        id="order">
        <div class="section-off-on-buttons">
            <input type="checkbox" name="section_eight" class="section_switch" hidden="hidden" data-section="8"
                id="section_eight_switch" {{ ($section_status['section_8'] ?? '') == 'section_on' ? 'checked' : '' }}>
            <label class="switch" for="section_eight_switch"></label>
            <div class="section-count">
                <span>8</span>
            </div>
        </div>
        <div class="container">
            <div class="order-content">
                <div class="order-heading">
                    <h2 class="lp_text_editable get_main_text_22" style="{{ $style['get_style_22'] ?? '' }}">
                        {{ $main_text[22] ?? 'অর্ডার করতে সঠিক তথ্য দিয়ে নিচের ফর্ম পূরন করুন' }}
                    </h2>
                </div>
                <form action="{{ route('landing.place-order') }}" method="post" id="order-form">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="product-details">
                                <h4 class="text-white" style="font-weight: 600;font-size: 30px;margin-bottom: 20px;">
                                    Your Products</h4>
                            </div>
                            <style>
                                .products-list {
                                    display: grid;
                                    grid-template-columns: repeat(auto-fill, minmax(450px, 1fr));
                                    gap: 15px;
                                    align-items: stretch;
                                    /* important */
                                }

                                .product-item-details {
                                    display: flex;
                                    gap: 10px;
                                }

                                .product-card {
                                    display: flex;
                                    flex-direction: column;
                                    width: 100%;
                                    height: 100%;
                                }

                                @media (max-width: 768px) {
                                    .products-list {
                                        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                                    }
                                }
                            </style>
                            <div class="products-list">
                                {{-- @dd($products) --}}
                                @if (!empty($products))
                                    @forelse ($products as $item)
                                        @php
                                            $cart = \Cart::getContent();
                                            $cartItem =
                                                $cart->where('name', $item->name)->first() ??
                                                $cart->where('id', $item->sku)->first();

                                            $isChecked = $cartItem ? 'checked' : '';
                                            $quantity = $cartItem ? $cartItem->quantity : 1;
                                            $basePrice = $item->sale_price ?? ($item->regular_price ?? 0);

                                            $selectedAttributeIds = [];
                                            if ($cartItem && $item->has_variant) {
                                                foreach ($cartItem->attributes as $attrValue) {
                                                    // Extract numeric IDs from strings like "18-2"
                                                    $parts = explode('-', $attrValue);
                                                    foreach ($parts as $part) {
                                                        if (is_numeric($part)) {
                                                            $selectedAttributeIds[] = (int) $part;
                                                        }
                                                    }
                                                }
                                            }
                                            // dd($cartItem->attributes, $selectedAttributeIds);
                                        @endphp

                                        <div class="products-item">
                                            <div class="product-card" data-product-id="{{ $item->id }}"
                                                style="border: {{ $isChecked ? '4px solid #0d6efd;' : '' }}  ">

                                                <input type="hidden" class="product-id"
                                                    value="{{ $item->id }}">
                                                <input type="hidden" class="base-price"
                                                    value="{{ $basePrice }}">
                                                <input type="hidden" class="variant-price" value="0">
                                                <input type="hidden" class="variant-sku"
                                                    value="{{ $cartItem ? $cartItem->id : $item->sku ?? $item->id }}">
                                                <input type="hidden" class="variant-name-value" value="">
                                                <input type="hidden" class="shipping-cost" name="shipping_cost"
                                                    value="{{ $shippingCost ?? 0 }}">


                                                <div class="product-item-details">
                                                    <div class="product-input">
                                                        <input class="form-check-input product-toggle" type="checkbox"
                                                            name="product_ids[]" value="{{ $item->id }}"
                                                            {{ $isChecked }}>
                                                    </div>

                                                    <div class="product-image my-2">
                                                        {{-- @dd($item->get_thumb) --}}
                                                        <img src="{{ $item->get_thumb ? asset($item->get_thumb->file_url) : asset('no_available.jpg') }}"
                                                            alt="{{ $item->name }}" class="img-fluid rounded"
                                                            style="max-width: 100px;">
                                                    </div>

                                                    <div class="product-info">
                                                        <div class="product-name-quantity">
                                                            <span class="name product-name fw-bold">
                                                                {{ \Illuminate\Support\Str::words($item->name, 10, '...') }}

                                                            </span>
                                                        </div>

                                                        <div
                                                            class="product-quantity-price d-flex align-items-center gap-3 mt-2">
                                                            <div class="quantity d-flex border rounded">
                                                                <span class="quantity-minus px-3 py-1 border-end"
                                                                    style="cursor:pointer">-</span>
                                                                <input type="number"
                                                                    class="quantity-input border-0 text-center"
                                                                    name="quantity[{{ $item->id }}]"
                                                                    value="{{ $quantity }}" min="1"
                                                                    readonly style="width: 50px;">
                                                                <span class="quantity-plus px-3 py-1 border-start"
                                                                    style="cursor:pointer">+</span>
                                                            </div>
                                                            <div class="price fw-bold text-primary">
                                                                {{ $web_settings->currency_sign ?? 'TK' }} <span
                                                                    class="line-price">0.00</span>
                                                            </div>
                                                        </div>

                                                        {{-- Variant Selection Logic --}}
                                                        @if ($item->has_variant && count($item->get_variants ?? []) > 0)
                                                            @foreach ($item->get_attribute_with_items() as $attributeBlock)
                                                                @php
                                                                    $attribute = $attributeBlock['attribute'];
                                                                    $attr_items = $attributeBlock['items'];
                                                                @endphp
                                                                <div class="variant-group mt-2">
                                                                    <label class="variant-label fw-bold d-block mb-1">
                                                                        {{ ucfirst($attribute->name) }}: <span
                                                                            class="selected-variant-display  small"
                                                                            style="color: #882a32 !important;"></span>
                                                                    </label>
                                                                    <div class="variant-items d-flex flex-wrap gap-2">
                                                                        @foreach ($attr_items as $key => $v_item)
                                                                            @php
                                                                                // Check if this specific item is selected in the cart
                                                                                $isThisSelected = in_array(
                                                                                    $v_item->attribute_item_id,
                                                                                    $selectedAttributeIds,
                                                                                );
                                                                                if (
                                                                                    empty($selectedAttributeIds) &&
                                                                                    $key == 0
                                                                                ) {
                                                                                    $isThisSelected = true;
                                                                                }
                                                                            @endphp
                                                                            <label
                                                                                class="variant-item {{ $isThisSelected ? 'active border-primary' : '' }} border rounded"
                                                                                style="cursor:pointer">
                                                                                <input type="radio"
                                                                                    class="attr_checkbox d-none"
                                                                                    name="attribute_item_id[{{ $item->id }}][{{ $attribute->id }}]"
                                                                                    value="{{ $v_item->attribute_item_id }}"
                                                                                    data-variant-name="{{ $v_item->name }}"
                                                                                    {{ $isThisSelected ? 'checked' : '' }}>

                                                                                @if (($attribute->is_image ?? false) && $v_item->item_image)
                                                                                    <img src="{{ asset($v_item->item_image->file_url) }}"
                                                                                        width="30" height="30"
                                                                                        alt="{{ $v_item->name }}">
                                                                                @else
                                                                                    <span
                                                                                        class="px-2">{{ ucfirst($v_item->name) }}</span>
                                                                                @endif
                                                                            </label>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center">No products found.</div>
                                    @endforelse
                                @else
                                    <div class="col-12 text-center">No products found.</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 col-12 mb-2">
                            <div class="billing-details">
                                <h3 class="order-title">Billing details</h3>

                                <div class="col-12 mb-4">
                                    <label class="form-label">আপনার নাম <span>*</span></label>
                                    <input type="text" name="customer_name"
                                        class="form-control customer_name @error('customer_name') is-invalid @enderror"
                                        value="{{ old('customer_name') }}" placeholder="আপনার নাম লিখুন" required>
                                    @error('customer_name')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label">আপনার মোবাইল নাম্বার <span>*</span></label>
                                    <input type="text" name="customer_phone"
                                        class="form-control customer_phone @error('customer_phone') is-invalid @enderror"
                                        value="{{ old('customer_phone') }}" maxlength="11" minlength="11"
                                        placeholder="আপনার 11 ডিজিটের মোবাইল নাম্বার" required>
                                    @error('customer_phone')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    <div class="phone-error text-danger small" style="display:none;">সঠিক মোবাইল
                                        নাম্বার দিন।</div>
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label">আপনার ঠিকানা <span>*</span></label>
                                    <textarea name="customer_address"
                                        class="form-control customer_address @error('customer_address') is-invalid @enderror"
                                        placeholder="বাসা নং, রোড নং, গ্রাম, উপজেলা, জেলা" minlength="10" required>{{ old('customer_address') }}</textarea>
                                    @error('customer_address')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{--   $shippingCost  = ShippingMethod::select('amount', 'text')->get(); --}}
                                <div class="col-12 mb-4">
                                    <label class="form-label">শিপিং মেথড <span>*</span></label>
                                    <div class="shipping-options d-flex flex-column gap-2">
                                        @foreach ($shippingCost as $method)
                                            <div class="form-check">
                                                <input class="form-check-input shipping_method_radio" type="radio"
                                                    name="shipping_method" id="shipping_method_{{ $method->id }}"
                                                    value="{{ $method->id }}"
                                                    data-amount="{{ $method->amount }}" required>
                                                <label class="form-check-label"
                                                    for="shipping_method_{{ $method->id }}">
                                                    {{ $method->type }}
                                                    @if ($method->amount > 0)
                                                        ({{ $web_settings->currency_sign ?? 'TK' }}
                                                        {{ $method->amount }})
                                                    @endif
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                    @error('shipping_method')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <script>
                                    $(document).on('change', '.shipping_method_radio', function() {
                                        const shippingAmount = parseFloat($(this).data('amount')) || 0;
                                        const currency = "{{ $web_settings->currency_sign ?? 'TK' }}";

                                        // Update order summary total
                                        let subtotal = parseFloat($('#summary-total').text()) || 0;
                                        let grandTotal = subtotal + shippingAmount;
                                        $('#summary-total').text(grandTotal.toFixed(2));
                                        $('.order-place-button').html(`Place Order ${currency} ${grandTotal.toFixed(2)}`);
                                    });
                                </script>



                                <button type="submit" id="submit_btn"
                                    class="order-place-button btn btn-primary btn-lg w-100">
                                    Place Order
                                    {{ $web_settings->currency_sign ?? 'TK' }}
                                    0.00
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <div class="order-details">
                                <h3 class="order-title">Your order</h3>
                                <div class="order_review">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody id="order-summary-body"></tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="fs-5">Subtotal</th>
                                                <th class="fs-5">
                                                    {{ $web_settings->currency_sign ?? 'TK' }} <span
                                                        id="summary-subtotal">0.00</span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="fs-5">Shipping</th>
                                                <th class="fs-5">
                                                    {{ $web_settings->currency_sign ?? 'TK' }} <span
                                                        id="summary-shipping">0.00</span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="fs-5">Total</th>
                                                <th class="fs-5">
                                                    {{ $web_settings->currency_sign ?? 'TK' }} <span
                                                        id="summary-total">0.00</span>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    document.addEventListener('click', function(e) {

                        const card = e.target.closest('.product-card');
                        if (!card) return;

                        // ❌ Ignore these areas
                        if (
                            e.target.closest('.quantity') ||
                            e.target.closest('.variant-group') ||
                            e.target.closest('input') ||
                            e.target.closest('label')
                        ) {
                            return;
                        }

                        const checkbox = card.querySelector('.product-toggle');
                        if (!checkbox) return;

                        checkbox.checked = !checkbox.checked;

                        // ✅ jQuery change trigger
                        $(checkbox).trigger('change');
                    });
                </script>
                <script>
                    $(document).ready(function() {
                        const currency = "{{ $web_settings->currency_sign ?? 'TK' }}";

                        // Auto-select first product on page load
                        let $firstCard = $('.product-card:first');
                        let $firstCheckbox = $firstCard.find('.product-toggle');
                        if ($firstCheckbox.length && !$firstCheckbox.is(':checked')) {
                            $firstCheckbox.prop('checked', true);
                            $firstCard.css('border', '4px solid #0d6efd');
                            addToCart($firstCard);
                        }



                        /* shipping method */
                        // Auto-select first shipping method on page load
                        if ($('.shipping_method_radio:checked').length === 0) {
                            $('.shipping_method_radio:first').prop('checked', true);
                        }
                        updateGrandTotal();

                        $(document).on('change', '.shipping_method_radio', function() {
                            updateGrandTotal();
                        });



                        /* 1. Initialize variant selection on page load */
                        $('.product-card').each(function() {
                            let $card = $(this);
                            // Set active class for checked variant items
                            $card.find('.variant-item input:checked').each(function() {
                                $(this).closest('.variant-item').addClass('active border-primary');
                            });

                            // Initialize variant name display
                            updateVariantDisplay($card);
                        });

                        /* 1. Toggle Checkbox (Add/Remove) */
                        $(document).on('change', '.product-toggle', function() {
                            let $card = $(this).closest('.product-card');
                            let isChecked = $(this).is(':checked');

                            if (isChecked) {
                                $card.css('border', '4px solid #0d6efd');
                                addToCart($card);
                            } else {
                                $card.css('border', '');
                                removeFromCart($card);
                            }
                        });

                        /* 2. Variant Selection - FIXED */
                        $(document).on('click', '.variant-item', function(e) {
                            e.preventDefault();
                            let $item = $(this);
                            let $card = $item.closest('.product-card');
                            let $radioInput = $item.find('input[type="radio"]');
                            let $group = $item.closest('.variant-group');

                            // Don't do anything if already selected
                            if ($item.hasClass('active')) return;

                            // Update selection within the same group only
                            $group.find('.variant-item').removeClass('active border-primary');
                            $item.addClass('active border-primary');
                            $group.find('input[type="radio"]').prop('checked', false);
                            $radioInput.prop('checked', true);

                            // Update variant display
                            updateVariantDisplay($card);

                            // Re-fetch price and then auto-update cart if already checked
                            fetchVariantPrice($card, function() {
                                if ($card.find('.product-toggle').is(':checked')) {
                                    addToCart($card); // Re-add updates existing item in cart
                                } else {
                                    // Just update UI if not in cart
                                    updateProductUI($card);
                                    updateSummary();
                                }
                            });
                        });

                        /* 3. Quantity Controls */
                        $(document).on('click', '.quantity-plus, .quantity-minus', function(e) {
                            e.preventDefault();
                            let $card = $(this).closest('.product-card');
                            let $input = $card.find('.quantity-input');
                            let qty = parseInt($input.val());

                            if ($(this).hasClass('quantity-plus')) {
                                qty++;
                            } else if ($(this).hasClass('quantity-minus') && qty > 1) {
                                qty--;
                            }

                            $input.val(qty);

                            if ($card.find('.product-toggle').is(':checked')) {
                                updateCartQuantity($card);
                            } else {
                                updateProductUI($card);
                                updateSummary();
                            }
                        });

                        /* 4. API Actions */
                        function addToCart($card) {
                            let productId = $card.find('.product-id').val();
                            let variantData = [];

                            $card.find('.attr_checkbox:checked').each(function() {
                                variantData.push($(this).val());
                            });

                            $.ajax({
                                url: "{{ route('landing.add-to-cart') }}",
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    id: productId,
                                    qty: $card.find('.quantity-input').val(),
                                    attribute_item_id: variantData
                                },
                                success: function(res) {
                                    if (res.success) {
                                        $card.find('.variant-sku').val(res.cart_id);
                                        updateProductUI($card);
                                        updateSummary();
                                    }
                                }
                            });
                        }

                        function removeFromCart($card) {
                            let sku = $card.find('.variant-sku').val();
                            $.ajax({
                                url: "{{ route('landing.remove-from-cart') }}",
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    id: sku
                                },
                                success: function(res) {
                                    if (res.success) {
                                        updateProductUI($card);
                                        updateSummary();
                                    }
                                }
                            });
                        }

                        function updateCartQuantity($card) {
                            let sku = $card.find('.variant-sku').val();
                            $.ajax({
                                url: "{{ route('landing.update-cart-quantity') }}",
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    id: sku,
                                    qty: $card.find('.quantity-input').val()
                                },
                                success: function(res) {
                                    if (res.success) {
                                        updateProductUI($card);
                                        updateSummary();
                                    }
                                }
                            });
                        }

                        function fetchVariantPrice($card, callback = null) {
                            let attrs = [];
                            $card.find('.variant-item input:checked').each(function() {
                                attrs.push($(this).val());
                            });

                            // If no variants are selected, use base price
                            if (attrs.length === 0) {
                                let basePrice = parseFloat($card.find('.base-price').val()) || 0;
                                $card.find('.variant-price').val(basePrice);
                                updateProductUI($card);
                                if (callback) callback();
                                updateSummary();
                                return;
                            }

                            $.ajax({
                                url: "{{ route('ajax.get.attributes') }}",
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    product_id: $card.find('.product-id').val(),
                                    attribute_item_id: attrs
                                },
                                success: function(res) {
                                    if (res.success == 200) {
                                        let price = parseFloat(res.data.sale_price) > 0 ? res.data.sale_price :
                                            res
                                            .data.regular_price;
                                        $card.find('.variant-price').val(price);

                                        // Update variant name display
                                        let names = '';
                                        if (res.data.variant_items && res.data.variant_items.length > 0) {
                                            names = res.data.variant_items.map(i => i.attribute_item).join(
                                                ', ');
                                        }
                                        $card.find('.variant-name-value').val(names);

                                        // Update display for each variant group
                                        if (res.data.variant_items) {
                                            $card.find('.selected-variant-display').each(function(index) {
                                                if (res.data.variant_items[index]) {
                                                    $(this).text(res.data.variant_items[index]
                                                        .attribute_item);
                                                } else {
                                                    $(this).text('');
                                                }
                                            });
                                        }

                                        updateProductUI($card);
                                        if (callback) callback();
                                        updateSummary();
                                    }
                                },
                                error: function() {
                                    // Fallback to base price if API fails
                                    let basePrice = parseFloat($card.find('.base-price').val()) || 0;
                                    $card.find('.variant-price').val(basePrice);
                                    updateProductUI($card);
                                    if (callback) callback();
                                    updateSummary();
                                }
                            });
                        }

                        /* 5. Helper function to update variant display */
                        function updateVariantDisplay($card) {
                            let variantTexts = [];
                            $card.find('.variant-group').each(function() {
                                let $group = $(this);
                                let $selected = $group.find('input[type="radio"]:checked');
                                if ($selected.length) {
                                    let variantName = $selected.data('variant-name');
                                    if (variantName) {
                                        variantTexts.push(variantName);
                                    }
                                    // Update the display span for this group
                                    $group.find('.selected-variant-display').text(variantName || '');
                                }
                            });
                            $card.find('.variant-name-value').val(variantTexts.join(', '));
                        }

                        /* 6. Abandoned Cart Logic - 11 Digit Trigger */
                        $(document).on('input', '.customer_phone', function() {
                            let phone = $(this).val().trim();
                            let phonePattern = /^01[3-9]\d{8}$/;

                            if (phone.length === 11 && phonePattern.test(phone)) {
                                $.ajax({
                                    url: "{{ route('landing.abandoned-cart') }}",
                                    type: 'POST',
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        data: {
                                            name: $('.customer_name').val(),
                                            phone: $('.customer_phone').val(),
                                            address: $('.customer_address').val(),
                                            shipping_cost: 0
                                        }
                                    },
                                    success: function(res) {
                                        console.log('Abandoned cart saved/updated');
                                    }
                                });
                            }
                        });

                        /* 7. UI Rendering */
                        function updateProductUI($card) {
                            let qty = parseInt($card.find('.quantity-input').val()) || 1;
                            let base = parseFloat($card.find('.base-price').val()) || 0;
                            let variant = parseFloat($card.find('.variant-price').val()) || 0;
                            let price = variant > 0 ? variant : base;

                            $card.find('.line-price').text((qty * price).toFixed(2));
                        }

                        function updateSummary() {
                            let $tbody = $('#order-summary-body');
                            $tbody.empty();
                            let subtotal = 0;

                            $('.product-card').each(function() {
                                let $card = $(this);
                                if ($card.find('.product-toggle').is(':checked')) {
                                    let linePrice = parseFloat($card.find('.line-price').text()) || 0;
                                    subtotal += linePrice;

                                    let variantText = $card.find('.variant-name-value').val();
                                    let productName = $card.find('.product-name').text().trim();
                                    let quantity = $card.find('.quantity-input').val();

                                    $tbody.append(`
                <tr>
                    <td>
                        <strong>${productName} × ${quantity}</strong><br>
                        ${variantText ? `<small class=""  style="color: #882a32 !important;">${variantText}</small>` : ''}
                    </td>
                    <td>${currency} ${linePrice.toFixed(2)}</td>
                </tr>
            `);
                                }
                            });

                            $('#summary-subtotal').text(subtotal.toFixed(2));
                            updateGrandTotal(subtotal);
                            $('#submit_btn').prop('disabled', subtotal <= 0);
                        }

                        function updateGrandTotal(subtotal = null) {
                            if (subtotal === null) {
                                subtotal = parseFloat($('#summary-subtotal').text()) || 0;
                            }

                            let shippingAmount = 0;
                            let $selectedShipping = $('.shipping_method_radio:checked');
                            if ($selectedShipping.length) {
                                shippingAmount = parseFloat($selectedShipping.data('amount')) || 0;
                            }

                            let grandTotal = subtotal + shippingAmount;

                            $('#summary-shipping').text(shippingAmount.toFixed(2));
                            $('.shipping-cost').val(shippingAmount.toFixed(2));
                            $('#summary-total').text(grandTotal.toFixed(2));
                            $('.order-place-button').html(`Place Order ${currency} ${grandTotal.toFixed(2)}`);
                            $('#submit_btn').prop('disabled', grandTotal <= 0 || subtotal <= 0);
                        }

                        // Initial price loading
                        $('.product-card').each(function() {
                            let $card = $(this);
                            if ($card.find('.variant-group').length > 0) {
                                // First update the display
                                updateVariantDisplay($card);
                                // Then fetch the price
                                fetchVariantPrice($card);
                            } else {
                                updateProductUI($card);
                            }
                        });

                        // Initial summary update
                        setTimeout(updateSummary, 500);
                    });
                </script>


            </div>
        </div>
    </section>

    <section class="footer">
        <div class="custom-container">
            <div class="content">
                <div class="left">
                    <a href="/landing-15#">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                            height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path fill="none" d="M0 0h24v24H0z"></path>
                            <path
                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z">
                            </path>
                        </svg>
                        Kuril, Vatara, Dhaka-1229, Bangladesh
                    </a>

                </div>
                <div class="right">
                    <a href="/landing-15"> Privacy Policy</a>
                    <a href="/landing-15"> Terms &amp; Conditions</a>
                </div>
            </div>
            <div class="copyright text-center">
                <p class="mt-3">© 2024 All Rights Reserved Designed by <a href="https://funnelliner.com/">Funnel
                        Liner</a> </p>
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <script src="{{ asset('landing-page/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('landing-page/assets/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('landing-page/assets/js/landing-page-edit.js') }}"></script> --}}
    @if (isset($enableEdit))
        <!-- Modals -->
        {{-- image modal --}}
        <div class="modal fade" id="image_modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="image_upload_form">
                            <div class="mb-3">
                                <label class="form-label">Select Image</label>
                                <input type="file" class="form-control" id="image_file" name="image"
                                    accept="image/*">
                            </div>
                            <input type="hidden" name="image_id" id="image_id">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- //video modal --}}
        <div class="modal fade" id="video_modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Video</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">YouTube Video URL</label>
                            <input type="text" class="form-control" id="video_url"
                                placeholder="https://www.youtube.com/embed/...">
                        </div>
                        <input type="hidden" id="video_modal_id">
                        <button type="button" class="btn btn-primary video-upload-button">Update Video</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action_buttons">
            <a href="{{ route('admin.landing.pages.index') }}" class="landing_page_preview_button" title="Back">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-back-up">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 14l-4 -4l4 -4" />
                    <path d="M5 10h11a4 4 0 1 1 0 8h-1" />
                </svg>
            </a>
            <button class="landing_page_save_button" type="button" title="Save">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                    <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M14 4l0 4l-6 0l0 -4" />
                </svg>
            </button>
            <a href="{{ route('landing-theme.home', $landingPage->slug) }}" target="_blank"
                class="landing_page_preview_button" title="Preview">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                </svg>
            </a>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('landing-page/assets/js/spectrum.min.js') }}"></script>
        <script src="{{ asset('landing-page/assets/js/toastr.min.js') }}"></script>

        <script>
            $(document).ready(function() {
                // Toastr Configuration
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-bottom-right",
                    timeOut: 3000
                };

                // Editor Templates
                const TEXT_EDITOR = `
                    <span class="text_editor" contenteditable="false">
                        <ul>
                            <li class="fonts">
                                <span class="font_size">16</span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M18 9c.852 0 1.297 .986 .783 1.623l-.076 .084l-6 6a1 1 0 0 1 -1.32 .083l-.094 -.083l-6 -6l-.083 -.094l-.054 -.077l-.054 -.096l-.017 -.036l-.027 -.067l-.032 -.108l-.01 -.053l-.01 -.06l-.004 -.057v-.118l.005 -.058l.009 -.06l.01 -.052l.032 -.108l.027 -.067l.07 -.132l.065 -.09l.073 -.081l.094 -.083l.077 -.054l.096 -.054l.036 -.017l.067 -.027l.108 -.032l.053 -.01l.06 -.01l.057 -.004l12.059 -.002z" />
                                </svg>
                            </li>
                            <li class="font-bold" data-style="font-weight">B</li>
                            <li class="font-italic" data-style="font-style">I</li>
                            <li class="font-underline" data-style="text-decoration">U</li>
                            <li class="colors">
                                <span class="color_picker_label">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-palette">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 21a9 9 0 0 1 0 -18c4.97 0 9 3.582 9 8c0 1.06 -.474 2.078 -1.318 2.828c-.844 .75 -1.989 1.172 -3.182 1.172h-2.5a2 2 0 0 0 -1 3.75a1.3 1.3 0 0 1 -1 2.25" />
                                        <path d="M7.5 10.5a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M11.5 7.5a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M15.5 10.5a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                    </svg>
                                </span>
                                <input type="text" class="color_picker" />
                            </li>
                            <li class="bg-color">
                                <span class="bg_color_picker_label">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"
                                    class="icon icon-tabler icons-tabler-filled icon-tabler-contrast-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M19 2a3 3 0 0 1 3 3v14a3 3 0 0 1 -3 3h-14a3 3 0 0 1 -3 -3v-14a3 3 0 0 1 3 -3zm0 2h-14a1 1 0 0 0 -1 1v14a1 1 0 0 0 .769 .973c3.499 -.347 7.082 -4.127 7.226 -7.747l.005 -.226c0 -3.687 3.66 -7.619 7.232 -7.974a1 1 0 0 0 -.232 -.026" />
                                    </svg>
                                </span>
                                <input type="text" class="bg_color_picker" />
                            </li>
                            <li>
                                <span class="close-button" title="Cancel">
                                    ✕
                                </span>
                            </li>
                        </ul>
                        <span class="editor_card">
                            <span class="font">
                                ${[12,14,16,18,20,22,24,26,28,30,32,34,36,38,40,42,44,48,52,56,60].map(size =>
                                    `<a href="javascript:void(0);" data-size="${size}" class="font-item">${size}</a>`
                                ).join('')}
                            </span>
                        </span>
                    </span>`;

                // Close all editors
                function closeAllEditors() {
                    $('.lp_text_editable').removeClass('editing-active')
                        .css('border', '1px dashed #aaaaaab3')
                        .prop('contenteditable', false)
                        .find('.text_editor').remove();
                    $('.text_editor').remove(); // Remove from body
                    $('.editor_card').removeClass('show');
                }

                // Initialize color pickers dynamically
                function initColorPickers(element) {
                    $('.text_editor').find('.color_picker').spectrum({
                        preferredFormat: "hex",
                        showInput: true,
                        showAlpha: true,
                        allowEmpty: false,
                        color: element.css('color') || '#000000',
                        change: function(color) {
                            $('.lp_text_editable.editing-active').css('color', color.toHexString());
                        }
                    });

                    $('.text_editor').find('.bg_color_picker').spectrum({
                        preferredFormat: "hex",
                        showInput: true,
                        showAlpha: true,
                        allowEmpty: false,
                        color: element.css('background-color') || '#ffffff',
                        change: function(color) {
                            $('.lp_text_editable.editing-active').css('background-color', color
                                .toHexString());
                        }
                    });
                }

                // Text Editing
                $(document).on('dblclick', '.lp_text_editable', function(e) {
                    e.stopPropagation();
                    closeAllEditors();

                    const element = $(this);
                    element.addClass('editing-active')
                        .css('border', '2px solid #3b97e3')
                        .prop('contenteditable', true);

                    let editorObj = $(TEXT_EDITOR);
                    $('body').append(editorObj);

                    let offset = element.offset();
                    editorObj.css({
                        position: 'absolute',
                        top: (offset.top - 50) + 'px',
                        left: offset.left + 'px',
                        zIndex: 9999
                    });

                    // Get current styles
                    const fontSize = parseInt(element.css('font-size')) || 16;
                    const fontWeight = element.css('font-weight');
                    const fontStyle = element.css('font-style');
                    const textDecoration = element.css('text-decoration');

                    // Update UI
                    editorObj.find('.font_size').text(fontSize);
                    editorObj.find('.font-bold').toggleClass('active', fontWeight === 'bold' || parseInt(
                        fontWeight) >= 700);
                    editorObj.find('.font-italic').toggleClass('active', fontStyle === 'italic');
                    editorObj.find('.font-underline').toggleClass('active', textDecoration.includes(
                        'underline'));

                    // Initialize color pickers
                    setTimeout(() => initColorPickers(element), 50);

                    // Focus
                    setTimeout(() => element.focus(), 100);
                });

                // Close editor
                $(document).on('click', '.close-button', function(e) {
                    e.stopPropagation();
                    closeAllEditors();
                });

                // Font size toggle
                $(document).on('click', '.fonts', function(e) {
                    e.stopPropagation();
                    $(this).closest('.text_editor').find('.editor_card').toggleClass('show');
                });

                // Apply font size
                $(document).on('click', '.font-item', function(e) {
                    e.stopPropagation();
                    const size = $(this).data('size');
                    const element = $(this).closest('.lp_text_editable');
                    element.css('font-size', size + 'px');
                    element.find('.font_size').text(size);
                    $('.editor_card').removeClass('show');
                });

                // Toggle text styles
                $(document).on('click', '.font-bold, .font-italic, .font-underline', function(e) {
                    e.stopPropagation();
                    const style = $(this).data('style');
                    const element = $(this).closest('.lp_text_editable');
                    const currentValue = element.css(style);

                    let newValue;
                    switch (style) {
                        case 'font-weight':
                            newValue = (currentValue === 'bold' || parseInt(currentValue) >= 700) ? 'normal' :
                                'bold';
                            break;
                        case 'font-style':
                            newValue = currentValue === 'italic' ? 'normal' : 'italic';
                            break;
                        case 'text-decoration':
                            newValue = currentValue.includes('underline') ? 'none' : 'underline';
                            break;
                        default:
                            newValue = currentValue;
                    }

                    element.css(style, newValue);
                    $(this).toggleClass('active', newValue !== 'normal' && newValue !== 'none');
                });

                // Open color pickers
                $(document).on('click', '.color_picker_label', function(e) {
                    e.stopPropagation();
                    $(this).closest('.colors').find('.color_picker').spectrum('show');
                });

                $(document).on('click', '.bg_color_picker_label', function(e) {
                    e.stopPropagation();
                    $(this).closest('.bg-color').find('.bg_color_picker').spectrum('show');
                });

                // Close on outside click
                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.text_editor, .lp_text_editable.editing-active').length) {
                        $('.editor_card').removeClass('show');
                    }
                });

                // Close on Escape
                $(document).on('keydown', function(e) {
                    if (e.key === 'Escape') closeAllEditors();
                });

                // ================ VIDEO FUNCTIONS ================
                function convertToEmbedUrl(url) {
                    const normal = url.match(/v=([^&]+)/);
                    const short = url.match(/youtu\.be\/([^?]+)/);
                    const id = normal ? normal[1] : short ? short[1] : "";
                    return id ? "https://www.youtube.com/embed/" + id : "";
                }

                $(document).on('click', '.lp_video_editable', function() {
                    $('#video_modal_id').val($(this).data('video_id'));
                    $('#video_url').val($(this).find('iframe').attr('src') || "");
                    $('#video_modal').modal('show');
                });

                $(document).on('click', '.video-upload-button', function() {
                    const videoId = $('#video_modal_id').val();
                    const embedUrl = convertToEmbedUrl($('#video_url').val().trim());

                    if (!embedUrl) return toastr.error('Invalid YouTube URL');

                    $('.lp_video_editable[data-video_id="' + videoId + '"] iframe').attr('src', embedUrl);
                    $('#video_modal').modal('hide');
                    // toastr.success('Video updated!');
                });

                // ================ IMAGE FUNCTIONS ================
                $(document).on('click', '.lp_image_editable', function() {
                    const imageId = $(this).data('image_id');
                    $('#image_id').val(imageId);
                    $('#image_modal').modal('show');
                });

                $('#image_upload_form').on('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const button = $(this).find('button[type="submit"]');
                    const originalText = button.text();

                    button.html('<span class="spinner-border spinner-border-sm"></span> Uploading...')
                        .prop('disabled', true);

                    $.ajax({
                        url: "{{ route('admin.landing.page.upload.image') }}",
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.success) {
                                const imageId = $('#image_id').val();
                                $('.lp_image_editable[data-image_id="' + imageId + '"] img')
                                    .attr('src', response.path + '?t=' + Date.now());
                                $('#image_modal').modal('hide');
                                // toastr.success('Image uploaded!');
                            } else {
                                toastr.error(response.message || 'Upload failed');
                            }
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Upload error');
                        },
                        complete: function() {
                            button.text(originalText).prop('disabled', false);
                            $('#image_file').val('');
                        }
                    });
                });

                // ================ LIST MANAGEMENT ================
                $(document).on('click', '.card_list_append_button', function(e) {
                    e.preventDefault();
                    const type = $(this).data('type');
                    const list = $(this).closest('.card-list').find('ul');
                    const itemCount = list.find('li').length;
                    const listType = type == 1 ? 'subtext_one' : 'subtext_two';

                    const newItem = `
                        <li class="${type == 1 ? 'rule-item' : 'why-use-item'}">
                            <span>
                                ${type == 1 ?
                                    '<svg aria-hidden="true" class="e-font-icon-svg e-fas-check-circle" viewBox="0 0 512 512"><path d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path></svg>' :
                                    '<svg aria-hidden="true" class="e-font-icon-svg e-far-hand-point-right" viewBox="0 0 512 512"><path d="M428.8 137.6h-86.177a115.52 115.52 0 0 0 2.176-22.4c0-47.914-35.072-83.2-92-83.2-45.314 0-57.002 48.537-75.707 78.784-7.735 12.413-16.994 23.317-25.851 33.253l-.131.146-.129.148C135.662 161.807 127.764 168 120.8 168h-2.679c-5.747-4.952-13.536-8-22.12-8H32c-17.673 0-32 12.894-32 28.8v230.4C0 435.106 14.327 448 32 448h64c8.584 0 16.373-3.048 22.12-8h2.679c28.688 0 67.137 40 127.2 40h21.299c62.542 0 98.8-38.658 99.94-91.145 12.482-17.813 18.491-40.785 15.985-62.791A93.148 93.148 0 0 0 393.152 304H428.8c45.435 0 83.2-37.584 83.2-83.2 0-45.099-38.101-83.2-83.2-83.2zm0 118.4h-91.026c12.837 14.669 14.415 42.825-4.95 61.05 11.227 19.646 1.687 45.624-12.925 53.625 6.524 39.128-10.076 61.325-50.6 61.325H248c-45.491 0-77.21-35.913-120-39.676V215.571c25.239-2.964 42.966-21.222 59.075-39.596 11.275-12.65 21.725-25.3 30.799-39.875C232.355 112.712 244.006 80 252.8 80c23.375 0 44 8.8 44 35.2 0 35.2-26.4 53.075-26.4 70.4h158.4c18.425 0 35.2 16.5 35.2 35.2 0 18.975-16.225 35.2-35.2 35.2zM88 384c0 13.255-10.745 24-24 24s-24-10.745-24-24 10.745-24 24-24 24 10.745 24 24z"></path></svg>'
                                }
                            </span>
                            <span class="lp_text_editable ${listType} ${listType}_${itemCount}" style="">
                                New item ${itemCount + 1}
                            </span>
                            <button class="card_list_delete_button" data-type="${type}" data-key="${itemCount}">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M18 6l-12 12" />
                                    <path d="M6 6l12 12" />
                                </svg>
                            </button>
                        </li>
                    `;

                    $(this).before(newItem);
                    // toastr.success('Item added!');
                });

                $(document).on('click', '.card_list_delete_button', function(e) {
                    e.stopPropagation();
                    if (confirm('Delete this item?')) {
                        $(this).closest('li').remove();
                        // toastr.success('Item deleted!');
                    }
                });

                // ================ SECTION TOGGLES ================
                $(document).on('change', '.section_switch', function() {
                    const section = $(this).data('section');
                    const isChecked = $(this).is(':checked');
                    const container = $(this).closest('section').find('.container');
                    container.toggleClass('section_off', !isChecked);
                    // toastr.success(`Section ${section} ${isChecked ? 'enabled' : 'disabled'}!`);
                });

                // ================ SAVE FUNCTION ================
                $(document).on('click', '.landing_page_save_button', function() {
                    closeAllEditors();

                    const button = $(this);
                    const originalHtml = button.html();
                    button.html('<div class="spinner-border spinner-border-sm text-white"></div>')
                        .prop('disabled', true);

                    // Collect data
                    const data = {
                        content: {
                            main_text: [],
                            subtext_one: [],
                            subtext_two: [],
                            subtext_three: [],
                            subtext_four: [],
                            videos: {},
                            images: {},
                            section_status: {}
                        },
                        style: {}
                    };

                    // Main text
                    for (let i = 0; i <= 50; i++) {
                        const el = $(`.get_main_text_${i}`);
                        if (!el.length) continue;

                        data.content.main_text[i] = el.text().trim();
                        let style = (el.attr('style') || '').replace(
                            /border:\s*1px\s*dashed\s*rgba\(170,\s*170,\s*170,\s*0\.7\);?/i, '').trim();
                        data.style[`get_style_${i}`] = style;
                    }

                    // Subtexts
                    $('.subtext_one').each(function(i) {
                        data.content.subtext_one[i] = $(this).clone().find('.card_list_delete_button')
                            .remove().end().text().trim();
                    });

                    $('.subtext_two').each(function(i) {
                        data.content.subtext_two[i] = $(this).clone().find(
                                '.card_list_delete_button')
                            .remove().end().text().trim();
                    });
                    $('.subtext_three').each(function(i) {
                        data.content.subtext_three[i] = $(this).clone().find(
                                '.card_list_delete_button')
                            .remove().end().text().trim();
                    });
                    $('.subtext_four').each(function(i) {
                        data.content.subtext_four[i] = $(this).clone().find(
                                '.card_list_delete_button')
                            .remove().end().text().trim();
                    });

                    // Media
                    $('.lp_video_editable').each(function() {
                        const id = $(this).data('video_id');
                        const src = $(this).find('iframe').attr('src');
                        if (src) data.content.videos[id] = src;
                    });

                    $('.lp_image_editable').each(function() {
                        const id = $(this).data('image_id');
                        const src = $(this).find('img').attr('src');
                        if (src) data.content.images[id] = src.split('?')[0];
                    });

                    // Section status
                    $('.section_switch').each(function() {
                        const section = $(this).data('section');
                        data.content.section_status[`section_${section}`] = $(this).is(':checked') ?
                            'section_on' : 'section_off';
                    });

                    // Save
                    $.ajax({
                        url: "{{ route('admin.landing.page.save', $landingPage->id ?? 0) }}",
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            content: data.content,
                            style: data.style,
                            section_status: data.content.section_status
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success('Saved successfully!');
                            } else {
                                toastr.error(response.message || 'Save failed');
                            }
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Save error');
                        },
                        complete: function() {
                            button.html(originalHtml).prop('disabled', false);
                        }
                    });
                });

                // CSRF setup
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });
            });
        </script>
    @endif
</body>

</html>
