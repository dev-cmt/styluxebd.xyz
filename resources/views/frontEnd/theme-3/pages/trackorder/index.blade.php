@php
    $activePath = '';
    if ($theme->type == 'active') {
        $activePath = 'active';
    } elseif ($theme->type == 'preview') {
        $activePath = 'preview';
    }
    // dd($activePath);
@endphp
@extends('frontEnd.'.$theme->path.'.layouts.master')
@section('title')
    Track Your Order
@endsection
@push('css')
    <style>
        /* Section Styling */
        #dynamic-page {
            background: #f9f9f9;
        }

        .wrapper-heading {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .paragraph {
            font-size: 1rem;
            color: #555;
            margin-bottom: 40px;
        }

        /* Order Section */
        .order-section {
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .order-img img {
            /*max-width: 250px;*/
        }

        /* Form */
        .review-form label {
            font-weight: 600;
            color: #333;
        }

        .review-form input {
            border-radius: 6px;
            border: 1px solid #ccc;
            padding: 12px 15px;
            font-size: 1rem;
        }

        .shop-btn {
            background-color: #007bff;
            color: #fff;
            font-weight: 600;
            padding: 12px;
            border-radius: 6px;
            border: none;
            transition: all 0.3s ease;
        }

        .shop-btn:hover {
            background-color: #0056b3;
        }

        /* Ajax Result */
        #orderResult {
            padding: 15px;
            border-radius: 6px;
            background-color: #e9f5ff;
            border: 1px solid #b3d7ff;
            color: #007bff;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .order-section {
                padding: 20px;
            }

            .order-img img {
                max-width: 200px;
                margin-bottom: 20px;
            }
        }

        @media (max-width: 576px) {
            #dynamic-page {
                padding: 40px 10px;
            }

            .wrapper-heading {
                font-size: 1.6rem;
            }

            .paragraph {
                font-size: 0.95rem;
            }

            .review-form input {
                font-size: 0.95rem;
                padding: 10px;
            }

            .shop-btn {
                font-size: 0.95rem;
                padding: 10px;
            }
        }

    </style>
@endpush
@section('content')
    <section id="dynamic-page">
        <div class="container">
            <div class="order-title">
                <h5 class="wrapper-heading text-center">Track Your Order</h5>
                <p class="paragraph text-center">Enter your order tracking number and your secret ID.</p>

                <div class="order-section">
                    <div class="row align-items-center gy-5">
                        <!-- Image Column -->
                        <div class="col-lg-4 text-center">
                            <div class="order-img" data-aos="fade-right" data-aos-duration="1000">
                                <img src="{{asset('/frontEnd/'.$theme->path.'/track.webp')}}" alt="order" class="img-fluid">
                            </div>
                        </div>

                        <!-- Form Column -->
                        <div class="col-lg-8">
                            <div class="login-section p-4 shadow-sm rounded bg-white">
                                <div class="review-form">
                                    <div class="review-inner-form mb-3">
                                        <label for="track-number" class="form-label fw-semibold">Order Tracking Number *</label>
                                        <input type="text" id="track-number" class="form-control form-control-lg" placeholder="Order Invoice Number">
                                    </div>
                                    <button id="trackBtn" class="btn btn-primary btn-sm w-100">Track Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ajax Response -->
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div id="orderResult">
                            <p class="text-center mb-0" style="color: #3C7D17">🔍 অর্ডার ট্র্যাক করতে উপরের ফর্মে আপনার অর্ডার ইনভয়েস আইডি লিখে সার্চ করুন।</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')

    <script>
        $('#trackBtn').on('click', function (e) {
            e.preventDefault();
            let trackingNumber = $('#track-number').val();
            if (!trackingNumber) {
                Swal.fire({
                    icon: 'error',
                    title: "Please enter tracking number",
                    timer: 1000,
                    showConfirmButton: false
                });
                return;
            }

            $.ajax({
                url: "{{ $theme->is_active == 1 ? route('track.order.result') : route('theme.track.order.result',['path' => $theme->path]) }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    tracking_number: trackingNumber
                },
                beforeSend: function () {
                    $('#orderResult').html("<p>Loading...</p>");
                },
                success: function (response) {
                    if (response.status) {
                        $('#orderResult').html(response.html);
                    } else {
                        $('#orderResult').html("<p class='text-danger'>" + response.message + "</p>");
                    }
                },
                error: function () {
                    $('#orderResult').html("<p class='text-danger'>Something went wrong!</p>");
                }
            });
        });
    </script>

@endpush
