@extends('frontEnd.' . $theme->path . '.layouts.master')
@section('title')
    Order Confirm
@endsection

@section('PixelCode')
    @php
        $contents = $order->get_products
            ->map(function ($item) {
                return [
                    'id' => (string) $item->product_id,
                    'quantity' => (int) $item->qty,
                    'item_price' => (float) $item->price,
                ];
            })
            ->values()
            ->toArray();

        $eventId = 'purchase_' . $order->invoice_id;
    @endphp

    <script>
        console.log('Purchase Pixel Loaded');

        if (typeof fbq === 'function') {

            fbq('track', 'Purchase', {
                value: {{ (float) $order->total }},
                currency: 'BDT',
                content_type: 'product',
                contents: {!! json_encode($contents) !!}
            }, {
                eventID: '{{ $eventId }}'
            });

            console.log('Purchase Event Sent:', '{{ $eventId }}');

        } else {
            console.error('Facebook Pixel fbq is not loaded!');
        }
    </script>
@endsection

@section('content')
    <style>
        .order-card {
            background: #ffffff;
            max-width: 550px;
            width: 100%;
        }

        .success-icon img {
            animation: pop 0.4s ease-out;
        }

        @keyframes pop {
            0% {
                transform: scale(0.6);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .order-info-box p {
            font-size: 15px;
            margin-bottom: 6px;
        }

        .btn-primary {
            border-radius: 8px;
            font-weight: 600;
        }

        #order-confirm-section {
            background: #f8f9fb;
            margin-top: 60px;
            /* Default for desktop */
        }

        /* Tablet (md) */
        @media (max-width: 992px) {
            #order-confirm-section {
                margin-top: 80px;
            }
        }

        /* Mobile (sm) */
        @media (max-width: 768px) {
            #order-confirm-section {
                margin-top: 60px;
            }
        }

        /* Extra small mobile */
        @media (max-width: 480px) {
            #order-confirm-section {
                margin-top: 40px;
            }
        }
    </style>
    <section id="order-confirm-section" class="py-5">
        <div class="container d-flex justify-content-center">
            <div class="order-card shadow-sm rounded-4 p-4 p-md-5">
                <div class="text-center">
                    <div class="success-icon mb-3">
                        <img src="{{ asset('frontEnd/' . $theme->path . '/assets/images/check-mark.png') }}" alt="success"
                            width="70">
                    </div>

                    <h3 class="fw-bold mb-2">Order Confirmed!</h3>

                    <p class="text-muted mb-1">
                        Thank you for your purchase. Your order has been successfully placed.
                    </p>

                    <div class="order-info-box text-start mt-4">
                        <p><strong>Invoice ID:</strong> {{ $order->invoice_id }}</p>
                        <p><strong>Total Amount:</strong> BDT {{ $order->total }}</p>
                        <p><strong>Payment Method:</strong>
                            {{ $order->payment_method == 'cod' ? 'Cash On Delivery' : ucfirst($order->payment_method) }}
                        </p>
                        <p><strong>Shipping Address:</strong> {{ $order->customer_address }}</p>
                    </div>

                    <a href="{{ $theme->is_active != 1 ? route('theme.home', ['path' => $theme->path]) : route('home') }}"
                        class="btn btn-success mt-4 px-4 py-2 w-100">
                        Shop Again
                    </a>
                </div>

            </div>
        </div>
    </section>
@endsection
