<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page Editor</title>

    <link rel="stylesheet" href="{{ asset('landing-page/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing-page/assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing-page/assets/css/spectrum.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing-page/landing-page-8/css/style.css') }}">

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
    <!-- Landing Page 3 -->
    @php
        $content = json_decode($landingPage->content ?? '[]', true);
        $style = json_decode($landingPage->style ?? '[]', true);

        $subtitle = $content['subtitle'] ?? ['এই শীতে পা ঠাণ্ডায় জমে যাচ্ছে?'];

        $main_text = $content['main_text'] ?? [
            0 => 'এই শীতে মা-বাবাকে উপহার দিন ',
            1 => 'Tahkeek এর Synthetic Leather মোজা',
            2 => '🎁 Tahkeek-এর মোজা কিনলে, আপনি পেয়ে যাচ্ছেন iPhone বা উমরাহ করার মতো সুবর্ণ সুযোগ!',
            3 => 'অজুর সময় আর মোজা খুলতে হবে না!',
            4 => 'মুগীরা ইবনু শু`বা (রাঃ) বলেন, আমি নবী করিম (সা.) এর সঙ্গে সফরে ছিলাম। আমি তার চামড়ার মোজা খুলে দিতে চাইলাম। তখন তিনি বললেন, `এগুলো ছাড়ো, আমি এগুলো অজুর পর পরেছি।` এরপর তিনি মোজার ওপর মাসেহ করলেন।',
            5 => 'এই শীতে আপনি হয়তো নিজের জন্য অনেক কিছু কিনবেন… কিন্তু যাদের জন্য শীতটা সবচেয়ে বেশি কষ্টের, সেই বাবা-মায়ের জন্য কিছু ভেবেছেন?',
            6 => 'ছোটবেলার সেই শীতের দিনের কথা মনে আছে কি? মা বাবা সবসময় নিশ্চিত করতেন আমরা যেন ঠান্ডায় কোনোভাবে কষ্ট না পায়। আমরা বড় হয়েছি, কিন্তু আমরা কি বাবা মায়ের শীতে কষ্ট পাওয়ার বিষয়টি খেয়াল রেখেছি? এই শীতে মা-বাবাকে উপহার দিন Tahkeek এর Synthetic Leather মোজা এই শীতে শুধু নিজের নয়, বাবা-মা আর পরিবারের সবার দিকেও রাখুন খেয়াল!',
            7 => 'বাজারে অনেক মোজা আছে, কিন্তু Tahkeek কেন সবচেয়ে বেশি পছন্দের?',
            8 => 'আমাদের এই মোজা এমনভাবে ডিজাইন করা, যা দেখতেও দারুণ  ব্যবহারেও অত্যন্ত আরামদায়ক।',
            9 => '২ জোড়া মোজা অর্ডার করলে সারা বাংলাদেশে ডেলিভারি চার্জ সম্পূর্ণ ফ্রি',
            10 => 'Tahkeek-এর মোজা কিনলে, আপনি পেয়ে যাচ্ছেন iPhone 17 Pro Max বা উমরাহ করার মতো সুবর্ণ সুযোগ!',
            11 => 'রেগুলার মূল্য',
            12 => '১৪০০',
            13 => 'টাকা',
            14 => 'অফার মূল্য ৯৯০ টাকা',
            15 => 'Tahkeek টিম আপনাকে কল করে সঠিক সাইজ নিশ্চিত করবে, তারপর যত দ্রুত সম্ভব আপনার ঠিকানায় মোজাটি পৌঁছে দেওয়া হবে।',
            16 => 'প্রোডাক্ট হাতে পাওয়ার পরও যদি সাইজ নিয়ে সমস্যা হয়,Tahkeek এক্সচেঞ্জের সুবিধা দিচ্ছে।',
            17 => 'ফোনে অর্ডার করতে অথবা মোজা সম্পর্কে বিস্তারিত জানতে',
            18 => '01769908770',
            19 => 'অথবা',
            20 => '01969908770',
            21 => 'এই শীতে শুধু নিজের নয়, বাবা, মা এবং পরিবারের কথাও ভাবুন',
            22 => '২ জোড়া মোজা অর্ডার করলে সারা বাংলাদেশে ডেলিভারি চার্জ সম্পূর্ণ ফ্রি।',
            23 => 'আপনার তথ্যটি পরিপূর্ণভাবে দিন',
            24 => 'পরিপূর্ণ তথ্য ঠিক আছে কিনা দেখে নিন',
            25 => 'পণ্য হাতে পেয়ে পেমেন্ট করুন',
            26 => 'কোনো Advance ছাড়াই অর্ডার করুন — পণ্য হাতে পেয়ে টাকা পরিশোধ করুন',
        ];

        $subtext_one = $content['subtext_one'] ?? [
            'প্রতি শতক জলাকারে 100 গ্রাম সেফ ফিশ পানিতে ভাল করে মিশিয়ে পুরো পুকুরে ছিটিয়ে দিতে হবে ।',
            '২য় ডোজঃ তিন দিন পরে (গ্রোথ ফাস্টার)',
            'প্রতি শতক জলাকারে 100 গ্রাম গ্রোথ ফাস্টার পানিতে ভাল করে মিশিয়ে পুরো পুকুরে ছিটিয়ে দিতে হবে ।',
            'তিন মাসের মধ্যে আর কোন কিছু ব্যবহার করতে হবে না ।',
        ];

        $button_text = $content['button_text'] ?? [
            1 => 'অর্ডার করতে ক্লিক করুন',
            2 => 'অর্ডার করতে ক্লিক করুন',
            3 => 'অর্ডার করতে ক্লিক করুন',
            4 => 'অর্ডার করতে ক্লিক করুন',
            5 => 'অর্ডার করতে ক্লিক করুন',
            6 => 'অর্ডার করতে ক্লিক করুন',
            7 => 'কল করুন',
            8 => 'WhatsApp',
        ];

        $videos = $content['videos'] ?? [
            1 => 'https://www.youtube.com/embed/npqaq1Pnwrk',
            2 => 'https://www.youtube.com/embed/4w2PmVFegC8',
        ];

        $images = $content['images'] ?? [
            1 => 'landing-page/' . optional($landingTheme)->slug . '/images/image-1.jpg',
            2 => 'landing-page/' . optional($landingTheme)->slug . '/images/image-2.jpg',
            3 => 'landing-page/' . optional($landingTheme)->slug . '/images/image-3.jpg',
            4 => 'landing-page/' . optional($landingTheme)->slug . '/images/image-4.jpg',
        ];

        $section_status = $content['section_status'] ?? [
            'section_1' => 'section_on',
            'section_2' => 'section_on',
            'section_3' => 'section_on',
            'section_4' => 'section_on',
            'section_5' => 'section_on',
            'section_6' => 'section_on',
        ];
    @endphp

    <!-- Banner Section -->
    <section
        class="banner-section {{ empty($enableEdit) && $section_status['section_1'] !== 'section_on' ? 'd-none' : '' }}">
        <div class="section-off-on-buttons">
            <input type="checkbox" name="section_one" class="section_switch" hidden="hidden" data-section="1"
                id="section_one_switch" {{ $section_status['section_1'] == 'section_on' ? 'checked' : '' }}>
            <label class="switch" for="section_one_switch"></label><span class="text-white">1</span>
        </div>
        <div class="container {{ $section_status['section_1'] ?? '' }}">
            <div class="banner-content">
                <h5 class="section-title">{{ $subtitle[0] ?? '' }}</h5>
                <h2 class="banner-title">
                    <span class="lp_text_editable get_main_text_0" style="{{ $style['get_style_0'] ?? '' }}">
                        {{ $main_text[0] ?? '' }}
                    </span>
                    <span class="lp_text_editable get_main_text_1 highlight-yellow"
                        style="{{ $style['get_style_1'] ?? '' }}">
                        {{ $main_text[1] ?? '' }}
                    </span>
                </h2>
                <div class="banner-image lp_image_editable" data-image_id="1">
                    <img src="{{ asset($images[1] ?? '') }}" alt="" class="img-fluid">
                </div>
                <a @if (!isset($enableEdit)) href="#order-form" @endif class="btn-order my-4">
                    <span class="lp_text_editable get_button_text_1">{{ $button_text[1] ?? '' }}</span>
                </a>
                <p class="lp_text_editable get_main_text_2 banner-text" style="{{ $style['get_style_2'] ?? '' }}">
                    {{ $main_text[2] ?? '' }}
                </p>
            </div>
        </div>
    </section>

    <!-- Motivation Section -->
    <section
        class="motivation-section {{ empty($enableEdit) && $section_status['section_2'] !== 'section_on' ? 'd-none' : '' }}">
        <div class="section-off-on-buttons">
            <input type="checkbox" name="section_two" class="section_switch" hidden="hidden" data-section="2"
                id="section_two_switch" {{ $section_status['section_2'] == 'section_on' ? 'checked' : '' }}>
            <label class="switch" for="section_two_switch"></label></label><span class="text-white">2</span>
        </div>
        <div class="container {{ $section_status['section_2'] ?? '' }}">
            <div class="motivation-content">
                <h3 class="lp_text_editable get_main_text_3 motivation-title"
                    style="{{ $style['get_style_3'] ?? '' }}">
                    {{ $main_text[3] ?? '' }}
                </h3>
                <div class="row align-items-center">
                    <div class="col-md-6 text-start">
                        <p class="lp_text_editable get_main_text_4 motivation-text">
                            {{ $main_text[4] ?? '' }}
                        </p>
                        <a @if (!isset($enableEdit)) href="#order-form" @endif class="btn-order mt-4">
                            <span class="lp_text_editable get_button_text_2">{{ $button_text[2] ?? '' }}</span>
                        </a>
                    </div>
                    <div class="col-md-6 mt-4 mt-md-0 lp_image_editable" data-image_id="2">
                        <img src="{{ asset($images[2] ?? '') }}" class="img-fluid rounded" alt="Wudu Illustration">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <h3 class="lp_text_editable get_main_text_5 motivation-subtitle"
                            style="{{ $style['get_style_5'] ?? '' }}">
                            {{ $main_text[5] ?? '' }}
                        </h3>
                        <p class="lp_text_editable get_main_text_6 motivation-text">
                            {{ $main_text[6] ?? '' }}
                        </p>
                    </div>
                    <div class="col-md-12 text-center mt-4 mt-md-0">
                        <a @if (!isset($enableEdit)) href="#order-form" @endif class="btn-order mt-4">
                            <span class="lp_text_editable get_button_text_3">{{ $button_text[3] ?? '' }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Section -->
    <section
        class="feature-section {{ empty($enableEdit) && $section_status['section_3'] !== 'section_on' ? 'd-none' : '' }}">
        <div class="section-off-on-buttons">
            <input type="checkbox" name="section_three" class="section_switch" hidden="hidden" data-section="3"
                id="section_three_switch" {{ $section_status['section_3'] == 'section_on' ? 'checked' : '' }}>
            <label class="switch" for="section_three_switch"></label><span class="text-white">3</span>
        </div>
        <div class="container {{ $section_status['section_3'] ?? '' }}">
            <h2 class="lp_text_editable get_main_text_7 feature-title" style="{{ $style['get_style_7'] ?? '' }}">
                {{ $main_text[7] ?? '' }}
            </h2>
            <h4 class="lp_text_editable get_main_text_8 feature-text" style="{{ $style['get_style_8'] ?? '' }}">
                {{ $main_text[8] ?? '' }}
            </h4>

            <div class="row align-items-center">
                <div class="col-md-5 lp_image_editable" data-image_id="3">
                    <img src="{{ asset($images[3] ?? '') }}" class="img-fluid rounded" alt="Feature Image">
                </div>
                <div class="col-md-7 text-start">
                    <ul class="feature-list">
                        @if (count($subtext_one) > 0)
                            @foreach ($subtext_one as $key => $sub_text_one)
                                <li class="feature-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="currentColor"
                                        class="icon icon-tabler icons-tabler-filled icon-tabler-copy-check">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M18.333 6a3.667 3.667 0 0 1 3.667 3.667v8.666a3.667 3.667 0 0 1 -3.667 3.667h-8.666a3.667 3.667 0 0 1 -3.667 -3.667v-8.666a3.667 3.667 0 0 1 3.667
                                            -3.667zm-3.333 -4c1.094 0 1.828 .533 2.374 1.514a1 1 0 1 1 -1.748 .972c-.221 -.398 -.342 -.486 -.626 -.486h-10c-.548 0 -1 .452 -1 1v9.998c0 .32 .154 .618
                                            .407 .805l.1 .065a1 1 0 1 1 -.99 1.738a3 3 0 0 1 -1.517 -2.606v-10c0 -1.652 1.348 -3 3 -3zm1.293 9.293l-3.293 3.292l-1.293 -1.292a1 1 0 0 0 -1.414 1.414l2
                                            2a1 1 0 0 0 1.414 0l4 -4a1 1 0 0 0 -1.414 -1.414" />
                                    </svg>
                                    <span class="lp_text_editable subtext_one subtext_one_{{ $key }}"
                                        style="{{ $style['subtext_one_' . $key] ?? '' }}">
                                        {{ $sub_text_one }}
                                    </span>
                                    <button class="card_list_delete_button" data-type="1"
                                        data-key="{{ $key }}">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="#fff" stroke-width="2">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M18 6l-12 12" />
                                            <path d="M6 6l12 12" />
                                        </svg>
                                    </button>
                                </li>
                            @endforeach
                            <button class="card_list_append_button" data-type="1">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="#fff" stroke-width="2">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg> Add Item
                            </button>
                        @endif
                    </ul>
                    <div class="text-center mt-2">
                        <a @if (!isset($enableEdit)) href="#order-form" @endif class="btn-order">
                            <span class="lp_text_editable get_button_text_4">{{ $button_text[4] ?? '' }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section
        class="pricing-section {{ empty($enableEdit) && $section_status['section_4'] !== 'section_on' ? 'd-none' : '' }}">
        <div class="section-off-on-buttons">
            <input type="checkbox" name="section_four" class="section_switch" hidden="hidden" data-section="4"
                id="section_four_switch" {{ $section_status['section_4'] == 'section_on' ? 'checked' : '' }}>
            <label class="switch" for="section_four_switch"></label><span>4</span>
        </div>
        <div class="container {{ $section_status['section_4'] ?? '' }}">
            <div class="pricing-content">
                <h3 class="pricing-title lp_text_editable get_main_text_9" style="{{ $style['get_style_9'] ?? '' }}">
                    {{ $main_text[9] ?? '' }}
                </h3>
                <h5 class="pricing-text lp_text_editable get_main_text_10"
                    style="{{ $style['get_style_10'] ?? '' }}">
                    {{ $main_text[10] ?? '' }}
                </h5>

                <div class="regular-price">
                    <span class="lp_text_editable get_main_text_11" style="{{ $style['get_style_11'] ?? '' }}">
                        {{ $main_text[11] ?? '' }}
                    </span>
                    <span class="lp_text_editable get_main_text_12 strike"
                        style="{{ $style['get_style_12'] ?? '' }}">
                        {{ $main_text[12] ?? '' }}
                    </span>
                    <span class="lp_text_editable get_main_text_13" style="{{ $style['get_style_13'] ?? '' }}">
                        {{ $main_text[13] ?? '' }}
                    </span>
                </div>
                <div class="price-offer">
                    <h3 class="lp_text_editable get_main_text_14" style="{{ $style['get_style_14'] ?? '' }}">
                        {{ $main_text[14] ?? '' }}
                    </h3>
                </div>

                <a @if (!isset($enableEdit)) href="#order-form" @endif class="btn-order">
                    <span class="lp_text_editable get_button_text_5">{{ $button_text[5] ?? '' }}</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Size Chart Section -->
    <section
        class="sizechart-section {{ empty($enableEdit) && $section_status['section_5'] !== 'section_on' ? 'd-none' : '' }}">
        <div class="section-off-on-buttons">
            <input type="checkbox" name="section_five" class="section_switch" hidden="hidden" data-section="5"
                id="section_five_switch" {{ $section_status['section_5'] == 'section_on' ? 'checked' : '' }}>
            <label class="switch" for="section_five_switch"></label><span>5</span>
        </div>
        <div class="container {{ $section_status['section_5'] ?? '' }}">
            <div class="sizechart-content">
                <h2 class="lp_text_editable get_main_text_15 sizechart-title"
                    style="{{ $style['get_style_15'] ?? '' }}">
                    {{ $main_text[15] ?? '' }}
                </h2>
                <h5 class="lp_text_editable get_main_text_16 sizechart-title"
                    style="{{ $style['get_style_16'] ?? '' }}">
                    {{ $main_text[16] ?? '' }}
                </h5>

                <!--Sizechart Table-->
                <div class="lp_image_editable" data-image_id="4">
                    <img src="{{ asset($images[4] ?? '') }}" class="img-fluid rounded" alt="Feature Image">
                </div>

                <div class="text-center mt-2">
                    <span class="lp_text_editable get_main_text_17 sizechart-text"
                        style="{{ $style['get_style_17'] ?? '' }}">
                        {{ $main_text[17] ?? '' }}
                    </span>
                    <a @if (!isset($enableEdit)) href="tel:{{ $main_text[18] ?? '' }}" @endif
                        class="sizechart-call-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-phone-ringing">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M20 4l-2 2" />
                            <path d="M22 10.5l-2.5 -.5" />
                            <path d="M13.5 2l.5 2.5" />
                            <path
                                d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2c-8.072 -.49 -14.51 -6.928 -15 -15a2 2 0 0 1 2 -2" />
                        </svg>
                        <span class="lp_text_editable get_button_text_6">{{ $button_text[6] ?? '' }}</span>
                        <span class="lp_text_editable get_main_text_18">{{ $main_text[18] ?? '' }}</span>
                    </a>
                    <span class="lp_text_editable get_main_text_19 sizechart-text"
                        style="{{ $style['get_style_19'] ?? '' }}">
                        {{ $main_text[19] ?? '' }}
                    </span>
                    <a @if (!isset($enableEdit)) href="https://wa.me/{{ $main_text[20] ?? '' }}" @endif
                        class="sizechart-whatsapp-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24"
                            fill="currentColor"
                            class="icon icon-tabler icons-tabler-filled icon-tabler-brand-whatsapp">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M18.497 4.409a10 10 0 0 1 -10.36 16.828l-.223 -.098l-4.759 .849l-.11 .011a1 1 0 0 1 -.11 0l-.102 -.013l-.108 -.024l-.105
                            -.037l-.099 -.047l-.093 -.058l-.014 -.011l-.012 -.007l-.086 -.073l-.077 -.08l-.067 -.088l-.056 -.094l-.034 -.07l-.04 -.108l-.028 -.128l-.012
                            -.102a1 1 0 0 1 0 -.125l.012 -.1l.024 -.11l.045 -.122l1.433 -3.304l-.009 -.014a10 10 0 0 1 1.549 -12.454l.215 -.203a10
                            10 0 0 1 13.226 -.217m-8.997 3.09a1.5 1.5 0 0 0 -1.5 1.5v1a6 6 0 0 0 6 6h1a1.5 1.5 0 0 0 0 -3h-1l-.144 .007a1.5 1.5 0 0 0 -1.128
                            .697l-.042 .074l-.022 -.007a4.01 4.01 0 0 1 -2.435 -2.435l-.008 -.023l.075 -.041a1.5 1.5 0 0 0 .704 -1.272v-1a1.5 1.5 0 0 0 -1.5 -1.5" />
                        </svg>
                        <span class="lp_text_editable get_button_text_7">{{ $button_text[7] ?? '' }}</span>
                        <span class="lp_text_editable get_main_text_20">{{ $main_text[20] ?? '' }}</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Order Section -->
    <section
        class="order-section {{ empty($enableEdit) && $section_status['section_6'] !== 'section_on' ? 'd-none' : '' }}"
        id="order">
        <div class="section-off-on-buttons">
            <input type="checkbox" name="section_six" class="section_switch" hidden="hidden" data-section="6"
                id="section_six_switch" {{ $section_status['section_6'] == 'section_on' ? 'checked' : '' }}>
            <label class="switch" for="section_six_switch"></label><span>6</span>
        </div>
        <div class="container {{ $section_status['section_6'] ?? '' }}">
            <div class="order-content">
                <h2 class="lp_text_editable get_main_text_21 order-title" style="{{ $style['get_style_21'] ?? '' }}">
                    {{ $main_text[21] ?? '' }}
                </h2>
                <h5 class="lp_text_editable get_main_text_22 order-text" style="{{ $style['get_style_22'] ?? '' }}">
                    {{ $main_text[22] ?? '' }}
                </h5>
                <form action="{{ route('landing.place-order') }}" method="post" id="order-form">
                    @csrf
                    <div class="row">
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

                                {{-- @dd(\Cart::getContent()); --}}

                                <div class="col-md-12 col-12 mb-2">
                                    <div class="product-card" data-product-id="{{ $item->id }}"
                                        style="border: {{ $isChecked ? '2px solid #6EC1E4;' : '' }}  ">

                                        <input type="hidden" class="product-id" value="{{ $item->id }}">
                                        <input type="hidden" class="base-price" value="{{ $basePrice }}">
                                        <input type="hidden" class="variant-price" value="0">
                                        <input type="hidden" class="variant-sku"
                                            value="{{ $cartItem ? $cartItem->id : $item->sku ?? $item->id }}">
                                        <input type="hidden" class="variant-name-value" value="">

                                        <div class="product-item">
                                            <div class="product-input">
                                                <input class="form-check-input product-toggle" type="checkbox"
                                                    name="product_ids[]" value="{{ $item->id }}"
                                                    {{ $isChecked }}>
                                            </div>

                                            <div class="product-image my-2">
                                                <img src="{{ $item->get_thumb ? asset($item->get_thumb->file_url) : asset('frontEnd/assets/images/image.png') }}"
                                                    alt="{{ $item->name }}" class="img-fluid"
                                                    style="max-width: 100px;">
                                            </div>

                                            <div class="product-info">
                                                <div class="product-name-quantity">
                                                    <span class="name product-name fw-bold">{{ $item->name }}</span>
                                                </div>

                                                <div
                                                    class="product-quantity-price d-flex align-items-center gap-3 mt-2">
                                                    <div class="quantity d-flex border rounded">
                                                        <span class="quantity-minus px-3 py-1 border-end"
                                                            style="cursor:pointer">-</span>
                                                        <input type="number"
                                                            class="quantity-input border-0 text-center"
                                                            name="quantity[{{ $item->id }}]"
                                                            value="{{ $quantity }}" min="1" readonly
                                                            style="width: 50px;">
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
                                                                    class="selected-variant-display text-muted small"></span>
                                                            </label>
                                                            <div class="variant-items d-flex flex-wrap gap-2">
                                                                @foreach ($attr_items as $key => $v_item)
                                                                    @php
                                                                        // Check if this specific item is selected in the cart
                                                                        $isThisSelected = in_array(
                                                                            $v_item->attribute_item_id,
                                                                            $selectedAttributeIds,
                                                                        );
                                                                        if (empty($selectedAttributeIds) && $key == 0) {
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

                        <div class="col-md-6 col-12 my-3">
                            <div class="billing-details">
                                <h3 class="lp_text_editable get_main_text_23 order-subtitle"
                                    style="{{ $style['get_style_23'] ?? '' }}">
                                    {{ $main_text[23] ?? '' }}
                                </h3>
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
                                    <input type="number" name="customer_phone"
                                        class="form-control customer_phone @error('customer_phone') is-invalid @enderror"
                                        value="{{ old('customer_phone') }}" maxlength="11" minlength="11"
                                        pattern="[0-9]{11}" placeholder="আপনার 11 ডিজিটের মোবাইল নাম্বার" required>
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
                                        placeholder="বাসা নং, রোড নং, গ্রাম, উপজেলা, জেলা" minlength="1" required>{{ old('customer_address') }}</textarea>
                                    @error('customer_address')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label">শিপিং মেথড <span>*</span></label>
                                    <div class="shipping-options d-flex flex-column gap-2">
                                        @foreach ($shippingCost as $key => $method)
                                            <div class="form-check">
                                                <input class="form-check-input shipping_method_radio" type="radio"
                                                    name="shipping_method" id="shipping_method_{{ $method->id }}"
                                                    value="{{ $method->id }}"
                                                    data-amount="{{ $method->amount }}"
                                                    {{ $key == 0 ? 'checked' : '' }} required>
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
                            </div>
                        </div>
                        <div class="col-md-6 col-12 my-3">
                            <div class="order-details">
                                <h3 class="lp_text_editable get_main_text_24 order-subtitle"
                                    style="{{ $style['get_style_24'] ?? '' }}">
                                    {{ $main_text[24] ?? '' }}
                                </h3>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th class="text-end">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody id="order-summary-body"></tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="fs-5">Total</th>
                                                <th class="fs-5 text-primary text-end">
                                                    {{ $web_settings->currency_sign ?? 'TK' }} <span
                                                        id="summary-total">0.00</span></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="card border-0 rounded-4 bg-peach" style="max-width: 400px; margin: auto;">
                                <div class="card-body p-4">
                                    <h5 class="lp_text_editable get_main_text_25 mb-4 fw-normal text-dark"
                                        style="{{ $style['get_style_25'] ?? '' }}">
                                        {{ $main_text[25] ?? '' }}
                                    </h5>
                                    <div class="bg-white p-4 rounded-1 speech-bubble">
                                        <p class="lp_text_editable get_main_text_26 mb-0 fw-medium text-dark"
                                            style="{{ $style['get_style_26'] ?? '' }}">
                                            {{ $main_text[26] ?? '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" id="submit_btn" class="order-place-button">
                                অর্ডার কনফার্ম করুন
                                {{ $web_settings->currency_sign ?? 'TK' }} 0.00
                            </button>
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
                                $card.css('border', '2px solid #6EC1E4');
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
                                url: "{{ route('landing.get.attributes') }}",
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    product_id: $card.find('.product-id').val(),
                                    attribute_item_id: attrs
                                },
                                success: function(res) {
                                    if (res.success == 200) {
                                        let price = parseFloat(res.data.sale_price) > 0 ? res.data.sale_price : res
                                            .data.regular_price;
                                        $card.find('.variant-price').val(price);

                                        // Update variant name display
                                        let names = '';
                                        if (res.data.variant_items && res.data.variant_items.length > 0) {
                                            names = res.data.variant_items.map(i => i.attribute_item).join(', ');
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
                                            shipping_cost: $('.shipping_method_radio:checked').data('amount') ||
                                                0
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
                                    let productName = $card.find('.product-name').text();
                                    let quantity = $card.find('.quantity-input').val();

                                    $tbody.append(`
                                        <tr>
                                            <td>
                                                <strong>${productName} × ${quantity}</strong><br>
                                                ${variantText ? `<small class="text-muted">${variantText}</small> ` : ''}
                                            </td>
                                            <td class="text-end">${currency} ${linePrice.toFixed(2)}</td>
                                        </tr>
                                    `);
                                }
                            });

                            // Shipping logic
                            let $selectedShipping = $('.shipping_method_radio:checked');
                            let shippingAmount = 0;
                            if (subtotal > 0 && $selectedShipping.length) {
                                shippingAmount = parseFloat($selectedShipping.data('amount')) || 0;

                                // Add Subtotal row
                                $tbody.append(`
                                    <tr class="subtotal-row" style="border-top: 2px solid #eee;">
                                        <td><strong>Subtotal</strong></td>
                                        <td class="text-end">${currency} ${subtotal.toFixed(2)}</td>
                                    </tr>
                                `);

                                // Add Shipping row
                                $tbody.append(`
                                    <tr class="shipping-row">
                                        <td><strong>Shipping</strong></td>
                                        <td class="text-end">${currency} ${shippingAmount.toFixed(2)}</td>
                                    </tr>
                                `);
                            }

                            let grandTotal = subtotal > 0 ? (subtotal + shippingAmount) : 0;

                            $('#summary-total').text(grandTotal.toFixed(2));
                            $('.order-place-button').html(`অর্ডার কনফার্ম করুন ${currency} ${grandTotal.toFixed(2)}`);
                            $('#submit_btn').prop('disabled', subtotal <= 0);
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

                        $(document).on('change', '.shipping_method_radio', function() {
                            updateSummary();
                        });
                    });
                </script>


            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="copy-right-text">
                <h2>Copyright © {{ date('Y') }} Pro Devs Ltd.</h2>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('landing-page/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('landing-page/assets/js/bootstrap.bundle.min.js') }}"></script>


    <script src="{{ asset('landing-page/assets/js/landing-page-edit.js') }}"></script>
    <script src="{{ asset('landing-page/assets/js/landing-page-3.js') }}"></script>



    @if (isset($enableEdit))
        <!-- Modals -->
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
                    const element = $('.lp_text_editable.editing-active');
                    element.css('font-size', size + 'px');
                    $('.text_editor').find('.font_size').text(size);
                    $('.editor_card').removeClass('show');
                });

                // Toggle text styles
                $(document).on('click', '.font-bold, .font-italic, .font-underline', function(e) {
                    e.stopPropagation();
                    const style = $(this).data('style');
                    const element = $('.lp_text_editable.editing-active');
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
                        <li class="feature-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"
                                class="icon icon-tabler icons-tabler-filled icon-tabler-copy-check">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M18.333 6a3.667 3.667 0 0 1 3.667 3.667v8.666a3.667 3.667 0 0 1 -3.667 3.667h-8.666a3.667 3.667 0 0 1 -3.667 -3.667v-8.666a3.667 3.667 0 0 1 3.667
                                    -3.667zm-3.333 -4c1.094 0 1.828 .533 2.374 1.514a1 1 0 1 1 -1.748 .972c-.221 -.398 -.342 -.486 -.626 -.486h-10c-.548 0 -1 .452 -1 1v9.998c0 .32 .154 .618
                                    .407 .805l.1 .065a1 1 0 1 1 -.99 1.738a3 3 0 0 1 -1.517 -2.606v-10c0 -1.652 1.348 -3 3 -3zm1.293 9.293l-3.293 3.292l-1.293 -1.292a1 1 0 0 0 -1.414 1.414l2
                                    2a1 1 0 0 0 1.414 0l4 -4a1 1 0 0 0 -1.414 -1.414"
                                />
                            </svg>
                            <span class="lp_text_editable ${listType} ${listType}_${itemCount}" style="">
                                New item ${itemCount + 1}
                            </span>
                            <button class="card_list_delete_button" data-type="${type}" data-key="${itemCount}">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
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
                            button_text: {},
                            videos: {},
                            images: {},
                            section_status: {}
                        },
                        style: {}
                    };

                    // Main text
                    for (let i = 0; i <= 30; i++) {
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
                        data.content.subtext_two[i] = $(this).clone().find('.card_list_delete_button')
                            .remove().end().text().trim();
                    });

                    // Button Text
                    for (let i = 0; i <= 20; i++) {
                        const el = $(`.get_button_text_${i}`);
                        if (!el.length) continue;
                        data.content.button_text[i] = el.text().trim();
                    }

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
