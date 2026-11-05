<!-- Bottom Pagination Links -->
<div class="card-footer d-flex flex-wrap justify-content-between align-items-center gap-2 py-2">
    <div class="text-muted small">
        Showing <strong>{{ $items->firstItem() ?? 0 }}</strong> to
        <strong>{{ $items->lastItem() ?? 0 }}</strong> of
        <strong>{{ $items->total() }}</strong> entries
    </div>
    <!-- Right: Pagination Links (Always Showed) -->
    <div class="custom-pagination d-flex justify-content-end align-items-center flex-grow-1" style="margin-left: auto;">
        @if ($items->hasPages())
            {{ $items->appends(request()->query())->links('pagination::bootstrap-4') }}
        @else
            <div class="text-secondary small me-2">
                Showing <span class="text-dark">{{ $items->firstItem() ?? 0 }}</span>
                to <span class="text-dark">{{ $items->lastItem() ?? 0 }}</span>
                of <span class="text-dark">{{ $items->total() }}</span> entries
            </div>
            {{-- ১ পেজের কম হলেও Bootstrap 5 Pagination এর সাথে হুবহু ম্যাচ করার জন্য --}}
            <ul class="pagination mb-0 gap-1">
                <li class="page-item disabled" aria-disabled="true" aria-label="&laquo; Previous">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>

                <li class="page-item active" aria-current="page">
                    <span class="page-link">1</span>
                </li>

                <li class="page-item disabled" aria-disabled="true" aria-label="Next &raquo;">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            </ul>
        @endif
    </div>
</div>
