<!-- Modern Tabler Status Filter Bar -->
<style>
    :root {
        --status-bg: #d9edff;
        --status-border: rgba(226, 232, 240, 0.8);
        --status-text: #64748b;
        --status-text-hover: #0f172a;
        --status-active-bg: #f8fafc;
        --status-active-accent: #206bc4;
    }

    /* Container Wrapper */
    .status-wrapper {
        position: relative;
        /* margin-bottom: 5px; */
        padding: 5px;
        background: var(--status-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        /* border: 1px solid var(--status-border); */
        border-bottom: 1px solid var(--status-border);
        /* border-radius: 5px; */
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04);
        transition: all 0.3s ease;
    }

    /* Scrollable Horizontal Track */
    .status-nav {
        display: flex;
        align-items: center;
        gap: 6px;
        overflow-x: auto;
        overflow-y: hidden;
        scrollbar-width: none;
        /* Firefox */
        -ms-overflow-style: none;
        /* IE/Edge */
        padding: 2px;
        flex-wrap: wrap;
    }

    .status-nav::-webkit-scrollbar {
        display: none;
        /* Chrome, Safari, Opera */
    }

    /* Individual Nav Item */
    .status-nav-item {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-shrink: 0;
        padding: 4px 8px;
        border-radius: 5px;
        text-decoration: none;
        color: var(--status-text);
        /* font-size: 12px; */
        font-size: .75rem;
        line-height: 1.5px;
        font-weight: 500;
        letter-spacing: -0.01em;
        white-space: nowrap;
        background: transparent;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent;
    }

    /* Hover State */
    .status-nav-item:hover {
        color: var(--status-text-hover);
        background: #f1f5f9;
        transform: translateY(-1px);
    }

    /* Active State */
    /* Active State Update (Ultra-Modern Approach) */
    .status-nav-item.active {
        color: #0f172a;
        background: #ffffff38;
        font-weight: 600;
        border-color: rgba(32, 107, 196, 0.3);
        /*  box-shadow: 0 2px 4px rgba(15, 23, 42, 0.05), 11px 14px 22px 3px rgb(32 107 196 / 21%);*/
    }

    /* Unique Top/Bottom Accent Strip for Active Item */
    /* .status-nav-item.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 12px;
        right: 12px;
        height: 2.5px;
        background: var(--status-active-accent, #206bc4);
        border-radius: 4px;
        animation: fadeInSlide 0.2s ease;
    } */

    @keyframes fadeInSlide {
        from {
            opacity: 0;
            transform: scaleX(0.5);
        }

        to {
            opacity: 1;
            transform: scaleX(1);
        }
    }

    /* Status Dot with Subtle Glow Effect */
    .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        flex-shrink: 0;
        display: inline-block;
        transition: transform 0.2s ease;
    }

    .status-nav-item:hover .status-dot,
    .status-nav-item.active .status-dot {
        transform: scale(1.25);
    }

    /* Counter Badge */
    .status-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 22px;
        height: 20px;
        padding: 0 5px;
        border-radius: 5px;
        background: #f1f5f9;
        color: #475569;
        font-size: 0.735rem;
        font-weight: 600;
        font-family: var(--tblr-font-monospace, ui-monospace, SFMono-Regular, monospace);
        transition: all 0.2s ease;
    }

    .status-nav-item:hover .status-count {
        background: #e2e8f0;
        color: #0f172a;
    }

    .status-nav-item.active .status-count {
        background: #0f172a;
        color: #ffffff;
    }

    /* Tabler Native Color Support */
    .bg-purple {
        background-color: #ae3ec9;
    }

    .bg-orange {
        background-color: #f76707;
    }

    .bg-azure {
        background-color: #4299e1;
    }

    .bg-teal {
        background-color: #0ca678;
    }

    .bg-cyan {
        background-color: #17a2b8;
    }

    .bg-green {
        background-color: #2fb344;
    }

    .bg-red {
        background-color: #d63939;
    }

    /* Responsive Tweaks */
    @media (max-width: 768px) {
        .status-wrapper {
            padding: 4px;
            border-radius: 14px;
        }

        .status-nav-item {
            padding: 7px 11px;
            font-size: 0.8rem;
        }
    }
</style>

@php
    // যদি রিকোয়েস্টে কোনো status না থাকে বা খালি থাকে, তবে ডিফল্ট 'pending' Active হবে
    $currentStatus = request()->get('status') ?? 'pending';

    // কিন্তু যদি সার্চ/ফিল্টারিং (যেমন date_range, query, courier, source) থাকে এবং status নির্দিষ্ট করা না থাকে, তবে 'total' Active হবে
    if (
        request()->hasAny(['query', 'date_range', 'source', 'payment_status', 'courier_id']) &&
        !request()->filled('status')
    ) {
        $currentStatus = 'total';
    }
@endphp

<div class="status-wrapper">
    <div class="status-nav">
        @foreach ($statusCards as $card)
            @php
                $isActive = $currentStatus == $card['status'];
            @endphp

            <a href="javascript:void(0)" data-status="{{ $card['status'] }}"
                class="status-nav-item status-card-link {{ $isActive ? 'active' : '' }}">

                <div class="d-flex align-items-center gap-2">
                    <span class="status-text text-{{ $card['color'] }}">{{ $card['title'] }}</span>
                </div>

                <span class="status-count" data-target="{{ $card['value'] ?? 0 }}">
                    {{ $card['value'] ?? 0 }}
                </span>
            </a>
        @endforeach
    </div>
</div>
