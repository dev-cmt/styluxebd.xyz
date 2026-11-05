<div class="card-body p-2" style="max-height: 50vh; overflow-y: auto; scrollbar-width: thin;">
    @php $activities = $order->activities ?? collect(); @endphp

    @if ($activities->isEmpty())
        <div class="text-center py-3">
            <i class="ti ti-history-off fs-3 text-muted opacity-50"></i>
            <p class="text-secondary fw-medium mb-0 small">এখনো কোনো activity রেকর্ড
                হয়নি।</p>
        </div>
    @else
        <div class="d-flex flex-column gap-1">
            @foreach ($activities as $activity)
                @php
                    $type = strtolower($activity->activity_type ?? '');
                    $badgeClass = 'bg-secondary';
                    if (str_contains($type, 'created') || str_contains($type, 'added')) {
                        $badgeClass = 'bg-success';
                    } elseif (str_contains($type, 'updated') || str_contains($type, 'changed')) {
                        $badgeClass = 'bg-primary';
                    } elseif (str_contains($type, 'deleted') || str_contains($type, 'removed')) {
                        $badgeClass = 'bg-danger';
                    } elseif (str_contains($type, 'status')) {
                        $badgeClass = 'bg-warning text-dark';
                    }
                @endphp

                {{-- Compact 2-Line Activity Row --}}
                <div class="px-2 py-1  border-start border-3 border-primary rounded">

                    {{-- Line 1: Content (User, Action, Changes/Comments) --}}
                    <div class="d-flex align-items-center flex-wrap gap-1 text-dark lh-sm" style="font-size:12px;">
                        {{-- User Name --}}
                        <span class="fw-bold text-dark me-1">
                            <i class="ti ti-user text-muted"></i>
                            {{ $activity->causer_name ?? 'System' }}
                        </span>

                        {{-- Action Badge --}}
                        <span class="badge {{ $badgeClass }}  font-monospace px-1 py-0 me-1"
                            style="font-size: 0.65rem;">
                            {{ str_replace('_', ' ', $activity->activity_type) }}
                        </span>

                        {{-- Field Changes (If Any) --}}
                        @if ($activity->field)
                            <?php
                            $label = Str::title(str_replace('_', ' ', $activity->field));
                            $old = $activity->old_value;
                            $new = $activity->new_value;
                            ?>

                            <span class="text-secondary me-1">
                                ({{ $label }}:

                                {{-- ১. যদি পুরানো এবং নতুন দুটি ভ্যালুই থাকে --}}
                                @if ($old && $new)
                                    <del class="text-danger">{{ $old }}</del>
                                    <i class="ti ti-arrow-right text-muted small mx-0.5"></i>
                                    <strong class="text-success">{{ $new }}</strong>

                                    {{-- ২. শুধু নতুন ভ্যালু থাকলে (যেমন: Product Added বা Assigned) --}}
                                @elseif ($new)
                                    <strong class="text-success">{{ $new }}</strong>

                                    {{-- ৩. শুধু পুরানো ভ্যালু থাকলে (যেমন: Product Removed) --}}
                                @elseif ($old)
                                    <del class="text-danger">{{ $old }}</del>
                                @endif)
                            </span>
                        @endif

                        {{-- Comment / Note (If Any) --}}
                        @if ($activity->comment)
                            <span class="text-muted fst-italic ms-1">
                                — "<span class="text-dark">{{ $activity->comment }}</span>"
                            </span>
                        @endif
                    </div>

                    {{-- Line 2: Time --}}
                    <div class=" font-monospace mt-1" style="font-size: 11px; color: #000;">
                        <i class="ti ti-clock me-1"></i>
                        {{ $activity->created_at ? $activity->created_at->format('d M, Y • h:i:s A') : 'N/A' }}
                    </div>

                </div>
            @endforeach
        </div>
    @endif
</div>
