<!-- Table Header Pagination Bar -->
<div class="card-header bg-white border-bottom py-1 px-3">
    <div class="d-flex align-items-center justify-content-between w-100 gap-3">

        <!-- Left: Per Page Number Input & Counter Info -->
        <div class="d-flex align-items-center gap-3 flex-shrink-0">

            <!-- Clean & Readable Summary Text -->
            <div class="text-secondary small">
                Showing <strong class="text-dark">{{ $items->firstItem() ?? 0 }}</strong>
                to <strong class="text-dark">{{ $items->lastItem() ?? 0 }}</strong>
                of <strong class="text-dark">{{ $items->total() }}</strong> entries
            </div>

            <!-- Compact Number Input Box -->
            <div class="d-flex align-items-center border rounded-2 bg-light shadow-sm">
                <input type="number" id="perPageInput"
                    class="form-control form-control-sm border-0 bg-transparent px-2 fw-semibold text-dark shadow-none"
                    style="width: 35px; font-size: 12px;" value="{{ request('per_page', 20) }}" min="1">
            </div>

        </div>

        <!-- Right: Pagination Links -->
        <div class="custom-pagination d-flex justify-content-end align-items-center flex-grow-1"
            style="margin-left: auto;">
            @if ($items->hasPages())
                {{ $items->appends(request()->query())->links('pagination::bootstrap-4') }}
            @else
                <div class="text-secondary small me-2">
                    Showing <span class="text-dark">{{ $items->firstItem() ?? 0 }}</span>
                    to <span class="text-dark">{{ $items->lastItem() ?? 0 }}</span>
                    of <span class="text-dark">{{ $items->total() }}</span> entries
                </div>
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
</div>
