<div class="modal-header bg-primary text-white">
    <div class="d-flex align-items-center gap-2">

        <div>
            <h5 class="modal-title fw-bold text-capitalize text-white mb-0 lh-1">
                {{ $type }} Notes History
            </h5>
            <small class="text-white-50" style="font-size: 0.72rem;">Complete log of {{ $type }} notes for this
                order</small>
        </div>
    </div>
    <button type="button" class="btn-close btn-close-white opacity-75" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body px-2 py-2 bg-light" style="max-height: 480px; overflow-y: auto;">
    @if ($notes && $notes->count() > 0)
        @foreach ($notes as $index => $item)
            <!-- Note Card -->
            <div
                class="card shadow-xs border border-1 border-light rounded-3 bg-white transition-all mb-3 timeline-modern">
                <div class="card-body p-3">

                    <!-- Author & Time Header -->
                    <div
                        class="d-flex align-items-center justify-content-between gap-2 mb-2 pb-2 border-bottom border-light">
                        <div class="d-flex align-items-center gap-2">
                            <div
                                class="avatar avatar-xs bg-primary rounded-circle d-flex align-items-center justify-content-center">
                                <i class="ti ti-user fs-5"></i>
                            </div>

                            <span class="fw-bold text-dark lh-1" style="font-size: 0.82rem;">
                                {{ $item->author_name ?? ($item->user->name ?? 'System User') }}
                            </span>
                        </div>

                        <span class="badge bg-light text-dark border font-monospace fw-normal px-2 py-1"
                            style="font-size: 0.72rem;">
                            <i class="ti ti-clock me-1 opacity-75"></i>{{ $item->created_at->format('d M, Y • h:i A') }}
                        </span>
                    </div>

                    <!-- Note Content Body -->
                    <div class="note-content text-secondary text-break lh-base" style="font-size: 0.83rem;">
                        {{ $item->note }}
                    </div>

                </div>
            </div>
        @endforeach
    @else
        <!-- Empty State Design -->
        <div class="text-center py-5">
            <h1 class="fw-semibold text-dark mb-1">No Notes Found</h1>
        </div>
    @endif
</div>

<div class="modal-footer py-2 px-4 bg-white border-top border-light justify-content-between">
    <span class="text-muted small" style="font-size: 0.75rem;">
        Total Records: <strong class="text-dark">{{ $notes ? $notes->count() : 0 }}</strong>
    </span>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
