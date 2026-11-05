@php
    $steps = ['pending', 'processing', 'on delivery', 'delivered', 'returned', 'cancelled'];
    $currentIndex = array_search($currentStatus, $steps);
@endphp
<style>
    /* Desktop / large screens */
    .track-timeline {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-bottom: 20px;
        flex-wrap: nowrap;
    }

    .timeline-step {
        position: relative;
        flex: 1;
        text-align: center;
    }

    .timeline-step .circle {
        width: 30px;
        height: 30px;
        margin: 0 auto 5px;
        border-radius: 50%;
        background: #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: #555;
        z-index: 2;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
    }

    .timeline-step .circle.active {
        background: linear-gradient(135deg, #0d6efd, #6610f2);
        color: #fff;
    }

    .timeline-step .circle.current {
        border: 2px solid #0d6efd;
        background: #fff;
        color: #0d6efd;
    }

    .timeline-step .circle.cancelled {
        background: #dc3545;
        color: #fff;
        border: 2px solid #dc3545;
    }

    .timeline-step .line {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 3px;
        background: #e0e0e0;
        z-index: 1;
        transform: translateX(0);
        transition: all 0.3s;
    }

    .timeline-step .line.active {
        background: #0d6efd;
    }

    .timeline-step .line.cancelled-line {
        background: #dc3545;
    }

    /* Mobile / small screens */
    /* Mobile / small screens vertical timeline */
    @media (max-width: 768px) {
        .track-timeline {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding-left: 20px;
            /* space for vertical line */
        }

        .timeline-step .line {
            display: none !important;
        }

        /* The vertical line spanning all steps */
        .track-timeline::before {
            content: '';
            position: absolute;
            top: 15px;
            /* start slightly below top */
            left: 14px;
            /* center under circles (half of circle width) */
            width: 2px;
            height: calc(100% - 15px);
            /* span the full height */
            background: #e0e0e0;
            z-index: 1;
        }

        /* Each step */
        .timeline-step {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: start;
            margin-bottom: 20px;
        }

        .timeline-step .circle {
            z-index: 2;
            /* above the line */
            flex-shrink: 0;
        }

        /* Optional: color the part of the line for completed steps */
        .timeline-step.completed~.timeline-step::before {
            background: #0d6efd;
        }
    }

    /* Glow Animation */
    @keyframes glowBorder {
        0% {
            box-shadow: 0 0 10px rgba(255, 120, 0, 0.7),
                0 0 10px rgba(255, 140, 0, 0.6);
        }

        50% {
            box-shadow: 0 0 10px rgba(36, 243, 108, 0.9),
                0 0 10px rgba(21, 236, 57, 0.8);
        }

        100% {
            box-shadow: 0 0 10px rgba(255, 120, 0, 0.7),
                0 0 10px rgba(243, 62, 125, 0.6);
        }
    }

    .circle.glow {
        animation: glowBorder 1.0s infinite ease-in-out;
    }
</style>
<div class="order-track-widget p-3 mb-4 shadow-sm rounded-3 bg-white orderResult">

    <h6 class="mb-3 text-uppercase fw-bold text-center" style="font-size: 18px; font-family: Jost, sans-serif">
        Order Tracking - {{ $order->invoice_id }}
    </h6>

    {{-- Timeline --}}
    <div class="track-timeline d-flex align-items-center justify-content-between position-relative mb-4">
        @foreach ($steps as $index => $step)
            <div class="timeline-step text-center flex-fill position-relative">
                <div
                    class="circle
                {{ $currentStatus == 'cancelled' ? 'cancelled' : '' }}
                {{ $index <= $currentIndex && $currentStatus != 'cancelled' ? 'active' : '' }}
                {{ $index == $currentIndex && $currentStatus != 'cancelled' ? 'glow' : '' }}">

                    @if ($currentStatus == 'cancelled')
                        &#10006; {{-- cross mark --}}
                    @else
                        @if ($index < $currentIndex)
                            &#10003; {{-- previous steps --}}
                        @elseif($index == $currentIndex)
                            &#10003; {{-- current step tick --}}
                        @else
                            {{ $index + 1 }} {{-- upcoming steps --}}
                        @endif
                    @endif
                </div>

                <small class="d-block mt-1 text-capitalize" style="font-size: 12px">{{ $step }}</small>

                @if ($index < count($steps) - 1)
                    <div
                        class="line
                    {{ $currentStatus == 'cancelled' ? 'cancelled-line' : ($index < $currentIndex ? 'active' : '') }}">
                    </div>
                @endif
            </div>
        @endforeach
    </div>


    {{-- Order Info --}}
    <div class="order-info p-3 mt-3 bg-white rounded-3 shadow-sm border">
        <h5 class="fw-bold mb-3 text-uppercase" style="font-size: 16px; color: #212529; letter-spacing: 0.5px;">
            Order Information
        </h5>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="info-item mb-2">
                    <span class="fw-semibold text-success"
                        style="font-size: 16px; font-family: Jost, sans-serif">Customer</span>
                    <span class="d-block text-dark"
                        style="font-size: 14px; font-weight: 200; font-family: Jost, sans-serif">{{ $order->customer_name }}</span>
                </div>
                <div class="info-item mb-2">
                    <span class="fw-semibold text-success"
                        style="font-size: 16px; font-family: Jost, sans-serif">Phone</span>
                    <span class="d-block text-dark"
                        style="font-size: 14px; font-weight: 200; font-family: Jost, sans-serif">{{ $order->customer_phone }}</span>
                </div>
                <div class="info-item mb-2">
                    <span class="fw-semibold text-success"
                        style="font-size: 16px; font-family: Jost, sans-serif">Address</span>
                    <span class="d-block text-dark"
                        style="font-size: 14px; font-weight: 200; font-family: Jost, sans-serif">{{ $order->customer_address }}</span>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="info-item mb-2">
                    <span class="fw-semibold text-success"
                        style="font-size: 16px; font-family: Jost, sans-serif">Total</span>
                    <span class="d-block text-dark"
                        style="font-size: 14px; font-weight: 500; font-family: Jost, sans-serif">{{ number_format($order->total, 2) }}
                        {{ $web_settings->currency_sign }}</span>
                </div>
                <div class="info-item mb-2">
                    <span class="fw-semibold text-success"
                        style="font-size: 16px; font-family: Jost, sans-serif">Date</span>
                    <span class="d-block text-dark"
                        style="font-size: 14px; font-weight: 500; font-family: Jost, sans-serif">{{ \Carbon\Carbon::parse($order->order_date)->format('d M, Y') }}</span>
                </div>
                <div class="info-item mb-2">
                    <span class="fw-semibold text-success"
                        style="font-size: 16px; font-family: Jost, sans-serif">Status</span><br>
                    <span
                        class="badge
                        {{ $currentStatus == 'pending' ? 'bg-secondary' : '' }}
                    {{ $currentStatus == 'processing' ? 'bg-info text-dark' : '' }}
                    {{ $currentStatus == 'on delivery' ? 'bg-warning text-dark' : '' }}
                    {{ $currentStatus == 'delivered' ? 'bg-success' : '' }}
                    {{ $currentStatus == 'returned' ? 'bg-dark text-white' : '' }}
                    {{ $currentStatus == 'cancelled' ? 'bg-danger' : '' }}
                        text-capitalize"
                        style="font-size: 12px; font-weight: 500; padding: 0.35em 0.6em;">
                        {{ ucfirst($currentStatus) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <style>
        .order-info {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .order-info .badge {
            border-radius: 12px;
        }

        @media (max-width: 768px) {
            .order-info .text-md-end {
                text-align: left !important;
            }
        }
    </style>
</div>
