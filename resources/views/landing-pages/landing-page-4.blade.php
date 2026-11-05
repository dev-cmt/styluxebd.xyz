<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $landingPage->title ?? 'Landing Page' }}</title>
    <link rel="stylesheet" href="{{ asset('/') }}landing-page/landing-page-4/css/style.css">
    <link rel="stylesheet" href="{{ asset('/') }}landing-page/landing-page-4/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('landing-page/assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing-page/assets/css/spectrum.min.css') }}">
    @if (isset($enableEdit))
        <link rel="stylesheet" href="{{ asset('landing-page/landing-page-4/css/editor.css') }}">
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
            'কটন কাপড় দিয়ে তৈরি ',
            'ফর্মাল ওকেশন জন্য ',
            'রেগুলার ফিট ',
            'প্রিমিয়াম মেটাল বাটন ',
        ];

        $subtext_two = $content['subtext_two'] ?? [
            'কমফোর্টেবল ',
            'এক্সক্লুসিভ ডিজাইন ',
            'ঈদ স্পেশাল /ট্রেনডি /ইউনিক ',
            '100% পাকা রং আমাদের কাপড় গুলার ',
        ];
        $subtext_three = $content['subtext_three'] ?? [
            'জামা, ওড়না, সালোয়ার একসাথে ',
            '১০০% অরিজিনাল ',
            '৭ দিনের মধ্যে রিটার্ন ',
            '100% পাকা রং আমাদের কাপড় গুলার ',
        ];

        $videos = $content['videos'] ?? [
            1 => 'https://www.youtube.com/watch?v=qa69CcWQmRE',
            2 => 'https://www.youtube.com/embed/4w2PmVFegC8',
        ];

        $images = $content['images'] ?? [
            1 => 'landing-page/landing-page-4/images/logo.webp',
            2 => 'landing-page/landing-page-4/images/img1.png',
            3 => 'landing-page/landing-page-4/images/img4.png',
            4 => 'landing-page/landing-page-4/images/img10.png',
            5 => 'landing-page/landing-page-4/images/img11.png',
            6 => 'landing-page/landing-page-4/images/img12.png',
            7 => 'landing-page/landing-page-4/images/img13.png',
            8 => 'landing-page/landing-page-4/images/customer-review1.png',
            9 => 'landing-page/landing-page-4/images/customer-review1.png',
            10 => 'landing-page/landing-page-4/images/customer-review1.png',
            11 => 'landing-page/landing-page-4/images/customer-review1.png',
            12 => 'landing-page/landing-page-4/images/img15.png',
            13 => 'landing-page/landing-page-4/images/img16.webp',
            14 => 'landing-page/landing-page-4/images/img17.webp',
            15 => 'landing-page/landing-page-4/images/img18.webp',
            16 => 'landing-page/landing-page-4/images/img19.webp',
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
            'section_9' => 'section_on',
            'section_10' => 'section_on',
            'section_11' => 'section_on',
        ];
    @endphp
    <div class="full-page">

        <section class="hero {{ empty($enableEdit) && $section_status['section_1'] !== 'section_on' ? 'd-none' : '' }}">
            <div class="section-off-on-buttons">
                <input type="checkbox" name="section_1" class="section_switch" hidden="hidden" data-section="1"
                    id="section_one_switch" {{ $section_status['section_1'] == 'section_on' ? 'checked' : '' }}>
                <label class="switch" for="section_one_switch"></label><span>1</span>
            </div>
            <div class="custom-container  {{ $section_status['section_1'] ?? '' }}">
                <div class="">
                    <div class="row">
                        <div class="col-md-12 header-logo">
                            <div class="logo lp_image_editable" data-image_id="1">
                                <img src="{{ asset($images[1]) }}" alt="">
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="row content">
                                <div class="col-md-6">
                                    <div class="left">
                                        <h6 class="lp_text_editable get_main_text_0">
                                            {{ $main_text[0] ?? 'আমরা হয়তো রঙিন কাপড়ে দেখতে চাই বাবাকে' }}</h6>
                                        <img class="image1"
                                            src="{{ asset('/') }}landing-page/landing-page-4/images/img20.png"
                                            alt="">
                                        <img class="image2"
                                            src="{{ asset('/') }}landing-page/landing-page-4/images/img2.png"
                                            alt="">

                                        <h1 class="lp_text_editable get_main_text_1"
                                            style="{{ $style['get_style_1'] ?? '' }}">
                                            {{ $main_text[1] ?? 'তাই এবার ঈদে বাবাকে উপহার হিসেবে পাঞ্জাবির দিতে পারেন আমাদের পাঞ্জাবি গুলা .' }}
                                        </h1>
                                        <div class="banner-text">
                                            <h3>
                                                <span class="lp_text_editable get_main_text_2"
                                                    style="font-size: 50px; padding-left: 10px; z-index: 999999; {{ $style['get_style_2'] ?? '' }}">{{ $main_text[2] ?? '৯০০ টাকা' }}</span>
                                                <span class="lp_text_editable get_main_text_3"
                                                    style=" {{ $style['get_style_3'] ?? '' }}">
                                                    {{ $main_text[3] ?? ' থেকে  শুরু' }}</span>
                                            </h3>
                                            <img class="image3" style="z-index: 0000;"
                                                src="{{ asset('/') }}landing-page/landing-page-4/images/img3.png"
                                                alt="">
                                        </div>
                                        <a class="bg" href="/landing-24#placeAnOrder"> <svg stroke="currentColor"
                                                fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024"
                                                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M922.9 701.9H327.4l29.9-60.9 496.8-.9c16.8 0 31.2-12 34.2-28.6l68.8-385.1c1.8-10.1-.9-20.5-7.5-28.4a34.99 34.99 0 0 0-26.6-12.5l-632-2.1-5.4-25.4c-3.4-16.2-18-28-34.6-28H96.5a35.3 35.3 0 1 0 0 70.6h125.9L246 312.8l58.1 281.3-74.8 122.1a34.96 34.96 0 0 0-3 36.8c6 11.9 18.1 19.4 31.5 19.4h62.8a102.43 102.43 0 0 0-20.6 61.7c0 56.6 46 102.6 102.6 102.6s102.6-46 102.6-102.6c0-22.3-7.4-44-20.6-61.7h161.1a102.43 102.43 0 0 0-20.6 61.7c0 56.6 46 102.6 102.6 102.6s102.6-46 102.6-102.6c0-22.3-7.4-44-20.6-61.7H923c19.4 0 35.3-15.8 35.3-35.3a35.42 35.42 0 0 0-35.4-35.2zM305.7 253l575.8 1.9-56.4 315.8-452.3.8L305.7 253zm96.9 612.7c-17.4 0-31.6-14.2-31.6-31.6 0-17.4 14.2-31.6 31.6-31.6s31.6 14.2 31.6 31.6a31.6 31.6 0 0 1-31.6 31.6zm325.1 0c-17.4 0-31.6-14.2-31.6-31.6 0-17.4 14.2-31.6 31.6-31.6s31.6 14.2 31.6 31.6a31.6 31.6 0 0 1-31.6 31.6z">
                                                </path>
                                            </svg>
                                            অর্ডার করুন
                                        </a>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="right lp_image_editable" data-image_id="2">
                                        <img class="image4" src="{{ asset($images[2]) }}" alt="">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


            </div>
        </section>



        <div class="gap"></div>

        <section
            class="single-product {{ empty($enableEdit) && $section_status['section_2'] !== 'section_on' ? 'd-none' : '' }}">
            <div class="section-off-on-buttons">
                <input type="checkbox" name="section_2" class="section_switch" hidden="hidden" data-section="2"
                    id="section_2_switch" {{ $section_status['section_2'] == 'section_on' ? 'checked' : '' }}>
                <label class="switch" for="section_2_switch"></label><span>1</span>
            </div>
            <div class="custom-container  {{ $section_status['section_2'] ?? '' }}">
                <div class="row">
                    <div class=" col-lg-3 col-md-12 col-sm-12">
                        <div class="left lp_image_editable" data-image_id="3">
                            <img class="image1" src="{{ asset($images[3]) }}" alt="">
                        </div>

                    </div>
                    <div class="col-lg-9 col-md-12 col-sm-12">
                        <div class="right">
                            <div class="text-center" style="padding-left: 150px;">
                                <h2 class="lp_text_editable get_main_text_4" style="{{ $style['get_style_4'] ?? '' }}">
                                    {{ $main_text[4] ?? 'আমাদের লাক্সারি পাঞ্জাবি সাইজ' }}
                                </h2>
                                <div class="mt-4">
                                    <span class="lp_text_editable get_main_text_5 subtext-head"
                                        style="{{ $style['get_style_5'] ?? '' }}">{{ $main_text[5] ?? 'M' }}</span>
                                    <span class="lp_text_editable get_main_text_6 subtext-head"
                                        style="{{ $style['get_style_6'] ?? '' }}">{{ $main_text[6] ?? 'L' }}</span>
                                    <span class="lp_text_editable get_main_text_7 subtext-head"
                                        style="{{ $style['get_style_7'] ?? '' }}">{{ $main_text[7] ?? 'XL' }}</span>
                                    <span class="lp_text_editable get_main_text_8 subtext-head"
                                        style="{{ $style['get_style_8'] ?? '' }}">{{ $main_text[8] ?? '2XL' }}</span>
                                    <span class="lp_text_editable get_main_text_9 subtext-head"
                                        style="{{ $style['get_style_9'] ?? '' }}">{{ $main_text[9] ?? '3XL' }}</span>
                                </div>

                            </div>
                            <div class="content-text">

                                <h2 class="lp_text_editable get_main_text_10"
                                    style="{{ $style['get_style_10'] ?? '' }}">
                                    {{ $main_text[10] ?? 'স্পেশাল ফিচার জাভিয়ার প্রিমিয়াম পাঞ্জাবি' }}</h2>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ul>
                                            @if (count($subtext_one) > 0)
                                                @foreach ($subtext_one as $key => $sub_text_one)
                                                    <li>
                                                        <img src="{{ asset('/') }}landing-page/landing-page-4/images/img22.png"
                                                            alt="">
                                                        <h4 class="lp_text_editable subtext_one subtext_one_{{ $key }}"
                                                            style="{{ $style['subtext_one_' . $key] ?? '' }}">
                                                            {{ $sub_text_one }}</h4>
                                                        <button class="card_list_delete_button" data-type="1"
                                                            data-key="{{ $key }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z"
                                                                    fill="none" />
                                                                <path d="M18 6l-12 12" />
                                                                <path d="M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul>
                                            @if (count($subtext_two) > 0)
                                                @foreach ($subtext_two as $key => $sub_text_two)
                                                    <li>
                                                        <img src="{{ asset('/') }}landing-page/landing-page-4/images/img22.png"
                                                            alt="">
                                                        <h4 class="lp_text_editable subtext_two subtext_two_{{ $key }}"
                                                            style="{{ $style['subtext_two_' . $key] ?? '' }}">
                                                            {{ $sub_text_two }}</h4>
                                                        <button class="card_list_delete_button" data-type="1"
                                                            data-key="{{ $key }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z"
                                                                    fill="none" />
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
                            </div>
                        </div>
                    </div>
                    <div class="footer-image">
                        <img class="image2" src="{{ asset('/') }}landing-page/landing-page-4/images/img7.png"
                            alt="">
                        <img class="image3" src="{{ asset('/') }}landing-page/landing-page-4/images/img8.png"
                            alt="">
                    </div>
                </div>

            </div>
        </section>

        <div class="gap"></div>

        <section
            class="order-template {{ empty($enableEdit) && $section_status['section_3'] !== 'section_on' ? 'd-none' : '' }}">
            <div class="section-off-on-buttons">
                <input type="checkbox" name="section_3" class="section_switch" hidden="hidden" data-section="3"
                    id="section_3_switch" {{ $section_status['section_3'] == 'section_on' ? 'checked' : '' }}>
                <label class="switch" for="section_3_switch"></label><span>1</span>
            </div>
            <img src="{{ asset('/') }}landing-page/landing-page-4/images/img9.png" alt="">
            <div class="custom-container {{ $section_status['section_3'] ?? '' }}">
                <div class="abs-text">
                    <h4 class="lp_text_editable get_main_text_27" style="{{ $style['get_style_27'] ?? '' }}">
                        {{ $main_text[27] ?? '01894844452' }}</h4>
                    <h5 class="lp_text_editable get_main_text_11" style="{{ $style['get_style_11'] ?? '' }}">
                        {{ $main_text[11] ?? 'কল করে অর্ডার করুন ' }}</h5>
                    <h6 class="lp_text_editable get_main_text_12" style="{{ $style['get_style_12'] ?? '' }}">
                        {{ $main_text[12] ?? 'সাথে পাচ্ছেন সারা দেশে ক্যাশ অন ডেলিভারি' }}</h6>
                </div>
            </div>
        </section>

        <div class="gap"></div>

        <section
            class="products {{ empty($enableEdit) && $section_status['section_4'] !== 'section_on' ? 'd-none' : '' }}">
            <div class="section-off-on-buttons">
                <input type="checkbox" name="section_4" class="section_switch" hidden="hidden" data-section="4"
                    id="section_4_switch" {{ $section_status['section_4'] == 'section_on' ? 'checked' : '' }}>
                <label class="switch" for="section_4_switch"></label><span>1</span>
            </div>
            <div class="custom-card {{ $section_status['section_4'] ?? '' }}">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12 lp_image_editable" data-image_id="4">
                        <img class="image1" src="{{ asset($images[4]) }}" alt="">
                    </div>
                    <div class="col-lg-3 col-md-6 col-12 lp_image_editable" data-image_id="5">
                        <img class="image2" src="{{ asset($images[5]) }}" alt="">
                    </div>
                    <div class="col-lg-3 col-md-6 col-12 lp_image_editable" data-image_id="6">
                        <img class="image3" src="{{ asset($images[6]) }}" alt="">
                    </div>
                    <div class="col-lg-3 col-md-6 col-12 lp_image_editable" data-image_id="7">
                        <img class="image4" src="{{ asset($images[7]) }}" alt="">
                    </div>
                </div>
            </div>
        </section>

        <div class="gap"></div>

        <section
            class="delivery {{ empty($enableEdit) && $section_status['section_5'] !== 'section_on' ? 'd-none' : '' }}">
            <div class="section-off-on-buttons">
                <input type="checkbox" name="section_5" class="section_switch" hidden="hidden" data-section="5"
                    id="section_5_switch" {{ $section_status['section_5'] == 'section_on' ? 'checked' : '' }}>
                <label class="switch" for="section_5_switch"></label><span>1</span>
            </div>
            <img src="{{ asset('/') }}landing-page/landing-page-4/images/img14.8535e04e.png" alt="">

            <div class="content {{ $section_status['section_5'] ?? '' }}">
                <h4 class="lp_text_editable get_main_text_13" style="{{ $style['get_style_13'] ?? '' }}">
                    {{ $main_text[13] ??
                        'আমরা হয়তো রঙিন কাপড়ে দেখতে চাই বাবাকে ! এবার ঈদে বাবার পাঞ্জাবিতে সাজবেন তা হয়তো অনেকেই ভেবে
                                                                        ফেলেছেন' }}
                </h4>
                <div class="order2">
                    <div class="text">
                        <h5 class="lp_text_editable get_main_text_14" style="{{ $style['get_style_14'] ?? '' }}">
                            {{ $main_text[14] ?? 'সারা দেশে ফ্রি হোম ডেলিভারি' }}</h5>
                        <h4 class="lp_text_editable get_main_text_15" style="{{ $style['get_style_15'] ?? '' }}">
                            {{ $main_text[15] ?? 'মাত্র ৯০০ টাকা' }}</h4>
                        <a class="bg" href="#placeAnOrder">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024"
                                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M922.9 701.9H327.4l29.9-60.9 496.8-.9c16.8 0 31.2-12 34.2-28.6l68.8-385.1c1.8-10.1-.9-20.5-7.5-28.4a34.99 34.99 0 0 0-26.6-12.5l-632-2.1-5.4-25.4c-3.4-16.2-18-28-34.6-28H96.5a35.3 35.3 0 1 0 0 70.6h125.9L246 312.8l58.1 281.3-74.8 122.1a34.96 34.96 0 0 0-3 36.8c6 11.9 18.1 19.4 31.5 19.4h62.8a102.43 102.43 0 0 0-20.6 61.7c0 56.6 46 102.6 102.6 102.6s102.6-46 102.6-102.6c0-22.3-7.4-44-20.6-61.7h161.1a102.43 102.43 0 0 0-20.6 61.7c0 56.6 46 102.6 102.6 102.6s102.6-46 102.6-102.6c0-22.3-7.4-44-20.6-61.7H923c19.4 0 35.3-15.8 35.3-35.3a35.42 35.42 0 0 0-35.4-35.2zM305.7 253l575.8 1.9-56.4 315.8-452.3.8L305.7 253zm96.9 612.7c-17.4 0-31.6-14.2-31.6-31.6 0-17.4 14.2-31.6 31.6-31.6s31.6 14.2 31.6 31.6a31.6 31.6 0 0 1-31.6 31.6zm325.1 0c-17.4 0-31.6-14.2-31.6-31.6 0-17.4 14.2-31.6 31.6-31.6s31.6 14.2 31.6 31.6a31.6 31.6 0 0 1-31.6 31.6z">
                                </path>
                            </svg>
                            অর্ডার করুন
                        </a>
                    </div>
                </div>
            </div>


        </section>

        <div class="gap"></div>
        <section
            class="youtube-video {{ empty($enableEdit) && $section_status['section_6'] !== 'section_on' ? 'd-none' : '' }}">
            <div class="section-off-on-buttons">
                <input type="checkbox" name="section_6" class="section_switch" hidden="hidden" data-section="6"
                    id="section_6_switch" {{ $section_status['section_6'] == 'section_on' ? 'checked' : '' }}>
                <label class="switch" for="section_6_switch"></label><span>1</span>
            </div>
            <div class="custom-container {{ $section_status['section_6'] ?? '' }}">
                <div class="video-text">
                    <h2 class="lp_text_editable get_main_text_16" style="{{ $style['get_style_16'] ?? '' }}">
                        {{ $main_text[16] ?? 'বাবার ঈদের পোশাক আমাদের প্রিমিয়াম পাঞ্জাবি' }}</h2>
                    <p class="lp_text_editable get_main_text_17" style="{{ $style['get_style_17'] ?? '' }}">
                        {{ $main_text[17] ??
                            'ঈদে বাবাকে দেওয়ার জন্য পাঞ্জাবি ছাড়া অন্য কিছু কি ভাবা যায়? তবে ভারী কাজের পাঞ্জাবি থেকে বের হয়ে
                                                                                            এখন সবাই আগে ভাবছেন স্বস্তির কথা। আর স্বস্তি মানেই সুতি কাপড়। নানা ধরনের সুতি কাপড়ে এবার
                                                                                            পাঞ্জাবিগুলো তৈরি করা হয়েছে। এগুলো সিম্পল অথচ ক্লাসি। সুতি ছাড়াও থাকছে সাটিন ও ক্রিসপি সিল্ক।
                                                                                            পাঞ্জাবিগুলো এমনভাবে ডিজাইন করা হয়েছে, যেন স্টাইলের পাশাপাশি আরামও মেলে।' }}
                    </p>
                </div>
                <div class="video lp_video_editable" data-video_id="1">
                    @php
                        $video = $videos[1] ?? 'https://www.youtube.com/watch?v=qa69CcWQmRE';
                        $video = str_replace('watch?v=', 'embed/', $video);
                    @endphp

                    <iframe width="100%" height="100%" src="{{ $video }}" frameborder="0"
                        allowfullscreen>
                    </iframe>

                </div>
            </div>
        </section>

        <section
            class="customer-review {{ empty($enableEdit) && $section_status['section_7'] !== 'section_on' ? 'd-none' : '' }}">
            <div class="section-off-on-buttons">
                <input type="checkbox" name="section_7" class="section_switch" hidden="hidden" data-section="7"
                    id="section_7_switch" {{ $section_status['section_7'] == 'section_on' ? 'checked' : '' }}>
                <label class="switch" for="section_7_switch"></label><span>1</span>
            </div>
            <div class="custom-container {{ $section_status['section_7'] ?? '' }}">
                <div class="row">
                    <div class="col-md-12 text-center header-text">
                        <div>আমাদের কাস্টমার রিভিউ</div>
                    </div>
                    <div class="col-md-3 col-6 item lp_image_editable" data-image_id="8">
                        <img style="object-fit: fill;" src="{{ asset($images[8]) }}" alt="">
                    </div>
                    <div class="col-md-3 col-6 item lp_image_editable" data-image_id="9">
                        <img style="object-fit: fill;" src="{{ asset($images[9]) }}" alt="">
                    </div>
                    <div class="col-md-3 col-6 item lp_image_editable" data-image_id="10">
                        <img style="object-fit: fill;" src="{{ asset($images[10]) }}" alt="">
                    </div>
                    <div class="col-md-3 col-6 item lp_image_editable" data-image_id="11">
                        <img style="object-fit: fill;" src="{{ asset($images[11]) }}" alt="">
                    </div>
                </div>

            </div>
        </section>

        <div class="gap"></div>
        <section
            class="product-discount {{ empty($enableEdit) && $section_status['section_8'] !== 'section_on' ? 'd-none' : '' }}">
            <div class="section-off-on-buttons">
                <input type="checkbox" name="section_8" class="section_switch" hidden="hidden" data-section="8"
                    id="section_8_switch" {{ $section_status['section_8'] == 'section_on' ? 'checked' : '' }}>
                <label class="switch" for="section_8_switch"></label><span>1</span>
            </div>
            <div class="custom-container {{ $section_status['section_8'] ?? '' }}">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="left lp_image_editable" data-image_id="12">
                            <img src="{{ asset($images[12]) }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="right">
                            <h2 class="lp_text_editable get_main_text_18" style="{{ $style['get_style_18'] ?? '' }}">
                                {{ $main_text[18] ?? 'এই ঈদে আমরা সব পাঞ্জাবি উপরে ৫০% ডিসকাউন্ট দিচ্ছে ' }}</h2>
                            <p class="lp_text_editable get_main_text_19" style="{{ $style['get_style_19'] ?? '' }}">
                                {{ $main_text[19] ??
                                    'ঈদের পোশাক মানেই পাঞ্জাবি ডিজাইন ভিত্তিক পাঞ্জাবিগুলো বাঙালিরা এখন খুব পছন্দ করে এবং
                                                                                                                            পরতে ভালবাসে। তাই আমরা এই ঈদ বাবাদের জন্য ভাল মানের পাঞ্জাবি নিতে পারবেন আমাদের থেকে
                                                                                                                            গরমের জন্য আরামদায়ক সুতি কাপড়ে তৈরি দারুন সব ম্যাচিং পাঞ্জাবী সেট পাচ্ছেন আমাদের
                                                                                                                            থেকে পছন্দের প্রোডাক্টটি কিনতে পণ্যের কোড নম্বর সহ আপনার পূর্ণ ঠিকানা ইনবক্স করুন বা
                                                                                                                            আমাদের ফর্ম পূরণ করে সাবমিট বাটন ক্লিক করুন' }}
                            </p>

                            <h4 class="lp_text_editable get_main_text_20"
                                style="{{ $style['get_style_20'] ?? '' }}">{{ $main_text[20] ?? 'মাত্র ৯০০ টাকা' }}
                            </h4>
                            <a class="bg" href="/landing-24#placeAnOrder">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                    viewBox="0 0 1024 1024" height="1em" width="1em"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M922.9 701.9H327.4l29.9-60.9 496.8-.9c16.8 0 31.2-12 34.2-28.6l68.8-385.1c1.8-10.1-.9-20.5-7.5-28.4a34.99 34.99 0 0 0-26.6-12.5l-632-2.1-5.4-25.4c-3.4-16.2-18-28-34.6-28H96.5a35.3 35.3 0 1 0 0 70.6h125.9L246 312.8l58.1 281.3-74.8 122.1a34.96 34.96 0 0 0-3 36.8c6 11.9 18.1 19.4 31.5 19.4h62.8a102.43 102.43 0 0 0-20.6 61.7c0 56.6 46 102.6 102.6 102.6s102.6-46 102.6-102.6c0-22.3-7.4-44-20.6-61.7h161.1a102.43 102.43 0 0 0-20.6 61.7c0 56.6 46 102.6 102.6 102.6s102.6-46 102.6-102.6c0-22.3-7.4-44-20.6-61.7H923c19.4 0 35.3-15.8 35.3-35.3a35.42 35.42 0 0 0-35.4-35.2zM305.7 253l575.8 1.9-56.4 315.8-452.3.8L305.7 253zm96.9 612.7c-17.4 0-31.6-14.2-31.6-31.6 0-17.4 14.2-31.6 31.6-31.6s31.6 14.2 31.6 31.6a31.6 31.6 0 0 1-31.6 31.6zm325.1 0c-17.4 0-31.6-14.2-31.6-31.6 0-17.4 14.2-31.6 31.6-31.6s31.6 14.2 31.6 31.6a31.6 31.6 0 0 1-31.6 31.6z">
                                    </path>
                                </svg>
                                অর্ডার করুন
                            </a>

                        </div>
                    </div>
                </div>

            </div>
        </section>

        <div class="gap"></div>

        <section
            class="shipping {{ empty($enableEdit) && $section_status['section_9'] !== 'section_on' ? 'd-none' : '' }}">
            <div class="section-off-on-buttons">
                <input type="checkbox" name="section_9" class="section_switch" hidden="hidden" data-section="9"
                    id="section_9_switch" {{ $section_status['section_9'] == 'section_on' ? 'checked' : '' }}>
                <label class="switch" for="section_9_switch"></label><span>1</span>
            </div>
            <div class="custom-container {{ $section_status['section_9'] ?? '' }}">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="item">
                            <div id="img" class="lp_image_editable" data-image_id="13">
                                <img src="{{ asset($images[13]) }}" alt="">
                            </div>
                            <div id="text">
                                <p class="lp_text_editable get_main_text_21"
                                    style="{{ $style['get_style_21'] ?? '' }}">
                                    {{ $main_text[21] ?? 'Free 2 Days Shipping' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="item">
                            <div class="img lp_image_editable" data-image_id="14">
                                <img src="{{ asset($images[14]) }}" alt="">
                            </div>
                            <div class="text">
                                <p class="lp_text_editable get_main_text_22"
                                    style="{{ $style['get_style_22'] ?? '' }}">
                                    {{ $main_text[22] ?? 'Money Back Gurantee' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">

                        <div class="item">
                            <div class="img lp_image_editable" data-image_id="15">
                                <img src="{{ asset($images[15]) }}" alt="">
                            </div>
                            <div class="text">
                                <p class="lp_text_editable get_main_text_23"
                                    style="{{ $style['get_style_23'] ?? '' }}">
                                    {{ $main_text[23] ?? 'Return Upto 30 Days' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="item">
                            <div class="img lp_image_editable" data-image_id="16">
                                <img src="{{ asset($images[16]) }}" alt="">
                            </div>
                            <div class="text">
                                <p class="lp_text_editable get_main_text_24"
                                    style="{{ $style['get_style_24'] ?? '' }}">
                                    {{ $main_text[24] ?? '24/7 Customer Support' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="gap"></div>

        <section
            class="place-order {{ empty($enableEdit) && $section_status['section_10'] !== 'section_on' ? 'd-none' : '' }}">
            <div class="section-off-on-buttons">
                <input type="checkbox" name="section_10" class="section_switch" hidden="hidden" data-section="10"
                    id="section_10_switch" {{ $section_status['section_10'] == 'section_on' ? 'checked' : '' }}>
                <label class="switch" for="section_10_switch"></label><span>1</span>
            </div>
            <div class="custom-container {{ $section_status['section_10'] ?? '' }}">
                <form action="{{ route('landing.place-order') }}" method="post" id="order-form">
                    @csrf
                    <div class="row">
                        <h2 class="animation">তাই আর দেরি না করে আজই অর্ডার করুন</h2>
                        <div class="col-12 mb-3">

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

                                        <div class="col-lg-6 col-12 mb-2">
                                            <div class="product-card" data-product-id="{{ $item->id }}"
                                                style="border: {{ $isChecked ? '2px solid #6EC1E4;' : '' }}  ">

                                                <input type="hidden" class="product-id"
                                                    value="{{ $item->id }}">
                                                <input type="hidden" class="base-price"
                                                    value="{{ $basePrice }}">
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
                                                            <span
                                                                class="name product-name fw-bold">{{ $item->name }}</span>
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
                        <div class="col-lg-7 col-md-12 billing">
                            <div class="title">
                                Billing details
                            </div>
                            <div class="input-field">

                                <input type="text" required
                                    class="customer_name @error('customer_name') is-invalid @enderror"
                                    name="customer_name" value="{{ old('customer_name') }}"
                                    placeholder="আপনার নাম লিখুন *">
                                @error('customer_name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror

                                <input type="text" required maxlength="11" value="{{ old('customer_phone') }}"
                                    minlength="11"
                                    class="customer_phone @error('customer_phone') is-invalid @enderror"
                                    name="customer_phone" placeholder="আপনার 11 ডিজিটের মোবাইল নাম্বার *">
                                @error('customer_phone')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror

                                <input type="text" name="customer_address"
                                    class="customer_address @error('customer_address') is-invalid @enderror"
                                    placeholder="আপনার সম্পূর্ণ ঠিকানা লিখুন *"
                                    value="{{ old('customer_address') }}" required>
                                @error('customer_address')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror

                            </div>
                            {{--   $shippingCost  = ShippingMethod::select('amount', 'text')->get(); --}}
                            <div class="col-12 mb-4 text-white">
                                <label class="form-label">শিপিং মেথড <span>*</span></label>
                                <div class="shipping-options d-flex flex-column gap-2">
                                    @foreach ($shippingCost as $method)
                                        <div class="form-check">
                                            <input class="form-check-input shipping_method_radio" type="radio"
                                                name="shipping_method_id" id="shipping_method_{{ $method->id }}"
                                                value="{{ $method->id }}" data-amount="{{ $method->amount }}"
                                                required>
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
                            <div class="payment-card">
                                <h3>Payment</h3>
                                <div class="order-payment">
                                    <input type="checkbox" checked="">
                                    <label for="CashOn">ক্যাশ অন ডেলিভারি</label>
                                </div>
                                <div class="payment-footer">
                                    <p>Pay with cash on delivery.</p>
                                </div>

                            </div>
                        </div>
                        <div class=" col-lg-5 col-md-12 your-order">
                            <div class="title">
                                Your order
                            </div>

                            <div class="order_review bg-transparent" style="">
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
                                            <th style="width: 75%" class="fs-5">Total</th>
                                            <th style="width: 25%" class="fs-5 text-primary">
                                                {{ $web_settings->currency_sign ?? 'TK' }} <span
                                                    id="summary-total">0.00</span></th>
                                        </tr>

                                    </tfoot>
                                </table>
                            </div>

                            <button class="order-place-button text-dark" style="" id="submit_btn">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                                    height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M4.00436 6.41662L0.761719 3.17398L2.17593 1.75977L5.41857 5.00241H20.6603C21.2126 5.00241 21.6603 5.45012 21.6603 6.00241C21.6603 6.09973 21.6461 6.19653 21.6182 6.28975L19.2182 14.2898C19.0913 14.7127 18.7019 15.0024 18.2603 15.0024H6.00436V17.0024H17.0044V19.0024H5.00436C4.45207 19.0024 4.00436 18.5547 4.00436 18.0024V6.41662ZM6.00436 7.00241V13.0024H17.5163L19.3163 7.00241H6.00436ZM5.50436 23.0024C4.67593 23.0024 4.00436 22.3308 4.00436 21.5024C4.00436 20.674 4.67593 20.0024 5.50436 20.0024C6.33279 20.0024 7.00436 20.674 7.00436 21.5024C7.00436 22.3308 6.33279 23.0024 5.50436 23.0024ZM17.5044 23.0024C16.6759 23.0024 16.0044 22.3308 16.0044 21.5024C16.0044 20.674 16.6759 20.0024 17.5044 20.0024C18.3328 20.0024 19.0044 20.674 19.0044 21.5024C19.0044 22.3308 18.3328 23.0024 17.5044 23.0024Z">
                                    </path>
                                </svg>
                                Place Order BDT
                                {{ $web_settings->currency_sign ?? 'TK' }} 0.00
                            </button>

                        </div>
                    </div>
                </form>
            </div>
        </section>

        <section
            class="footer {{ empty($enableEdit) && $section_status['section_11'] !== 'section_on' ? 'd-none' : '' }}">
            <div class="section-off-on-buttons">
                <input type="checkbox" name="section_11" class="section_switch" hidden="hidden" data-section="11"
                    id="section_11_switch" {{ $section_status['section_11'] == 'section_on' ? 'checked' : '' }}>
                <label class="switch" for="section_11_switch"></label><span>1</span>
            </div>
            <div class="custom-container {{ $section_status['section_11'] ?? '' }}">
                <div class="content">
                    <div class="left lp_text_editable get_main_text_25" style="{{ $style['get_style_25'] ?? '' }}">
                        <a href="/landing-15#">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path fill="none" d="M0 0h24v24H0z"></path>
                                <path
                                    d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z">
                                </path>
                            </svg>
                            {{ $main_text[25] ?? 'Dhaka, Bangladesh' }}
                        </a>

                    </div>
                    <div class="right">
                        <a href="/landing-15"> Privacy Policy</a>
                        <a href="/landing-15"> Terms &amp; Conditions</a>
                    </div>
                </div>
                <div class="copyright text-center">
                    <p class="mt-3">
                        <span class="mt-3 lp_text_editable get_main_text_26"
                            style="{{ $style['get_style_26'] ?? '' }}">{{ $main_text[26] ?? '© 2024 All Rights Reserved Designed by' }}</span>
                        <a href="https://prodevsltd.com/">Pro Devs Ltd.</a>
                    </p>
                </div>
            </div>
        </section>




    </div>

    <!-- Scripts -->
    <script src="{{ asset('landing-page/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('landing-page/assets/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{asset('/')}}landing-page/landing-page-4/js/bootstrap.bundle.min.js"></script> --}}

    @if (isset($enableEdit))
        <!-- Scripts -->
        <script src="{{ asset('landing-page/assets/js/spectrum.min.js') }}"></script>
        <script src="{{ asset('landing-page/assets/js/toastr.min.js') }}"></script>

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
                            <input type="text" class="form-control" id="video_url" placeholder="">
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

        <script>
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
                $('.editor_card').removeClass('show');
            }

            // Initialize color pickers dynamically
            function initColorPickers(element) {
                element.find('.color_picker').spectrum({
                    preferredFormat: "hex",
                    showInput: true,
                    showAlpha: true,
                    allowEmpty: false,
                    color: element.css('color') || '#000000',
                    change: function(color) {
                        $(this).closest('.lp_text_editable').css('color', color.toHexString());
                    }
                });

                element.find('.bg_color_picker').spectrum({
                    preferredFormat: "hex",
                    showInput: true,
                    showAlpha: true,
                    allowEmpty: false,
                    color: element.css('background-color') || '#ffffff',
                    change: function(color) {
                        $(this).closest('.lp_text_editable').css('background-color', color
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
                    .prop('contenteditable', true)
                    .append(TEXT_EDITOR);

                // Get current styles
                const fontSize = parseInt(element.css('font-size')) || 16;
                const fontWeight = element.css('font-weight');
                const fontStyle = element.css('font-style');
                const textDecoration = element.css('text-decoration');

                // Update UI
                element.find('.font_size').text(fontSize);
                element.find('.font-bold').toggleClass('active', fontWeight === 'bold' || parseInt(
                    fontWeight) >= 700);
                element.find('.font-italic').toggleClass('active', fontStyle === 'italic');
                element.find('.font-underline').toggleClass('active', textDecoration.includes('underline'));

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

            // CSRF setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
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
        </script>

        <script>
            $(document).ready(function() {
                /* Video Management */
                $(document).on('click', '.lp_video_editable', function() {
                    $('#video_modal_id').val($(this).data('video_id'));
                    $('#video_url').val($(this).find('iframe').attr('src') || "");
                    $('#video_modal').modal('show');
                });
                // Media
                $('.lp_video_editable').each(function() {
                    const id = $(this).data('video_id');
                    const src = $(this).find('iframe').attr('src');
                    if (src) data.content.videos[id] = src;
                    console.log(src);
                });
            });
        </script>
        <script>
            function convertToEmbedUrl(url) {
                const normal = url.match(/v=([^&]+)/);
                const short = url.match(/youtu\.be\/([^?]+)/);
                const id = normal ? normal[1] : short ? short[1] : "";
                return id ? "https://www.youtube.com/embed/" + id : "";
            }
            $(document).on('click', '.video-upload-button', function() {
                const videoId = $('#video_modal_id').val();
                const embedUrl = convertToEmbedUrl($('#video_url').val().trim());

                if (!embedUrl) return toastr.error('Invalid YouTube URL');

                $('.lp_video_editable[data-video_id="' + videoId + '"] iframe').attr('src', embedUrl);
                $('#video_modal').modal('hide');
                // toastr.success('Video updated!');
            });
        </script>
        <script>
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
        </script>
    @endif
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

            /* shipping method */
            // Auto-select first shipping method on page load
            if ($('.shipping_method_radio:checked').length === 0) {
                $('.shipping_method_radio:first').prop('checked', true);
            }
            updateSummary();

            $(document).on('change', '.shipping_method_radio', function() {
                updateSummary();
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
                let grandTotal = 0;
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
</body>

</html>
