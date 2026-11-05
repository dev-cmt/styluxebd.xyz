@if (!empty($colorImages) && count($colorImages) > 0)
    <div class="row g-3">
        @foreach ($colorImages as $attrId => $items)
            @php
                $attrName = DB::table('attributes')->where('id', $attrId)->value('name');
            @endphp

            @if (is_array($items) && count($items) > 0)
                <div class="col-md-12 mt-2">
                    <div class="card border-0 bg-slate-50 shadow-none p-3 rounded-3 mb-2">
                        <h6 class="fw-bold text-dark text-capitalize mb-3 fs-7">
                            <i class="ti ti-palette me-1 text-primary"></i>
                            {{ $attrName ?? 'Variant' }} Images
                        </h6>
                        <div class="row g-3">
                            @foreach ($items as $itemId => $data)
                                <div class="col-md-6 col-lg-4">
                                    <div
                                        class="p-3 bg-white border rounded-3 h-100 d-flex align-items-center justify-content-between gap-3">

                                        <!-- Left Side: Item Name & Upload Option -->
                                        <div class="flex-grow-1">
                                            <label class="form-label fw-semibold text-dark fs-8 mb-2 d-block">
                                                {{ $data['name'] ?? 'N/A' }}
                                            </label>

                                            <!-- Hidden Field for Old Image Persistence -->
                                            <input type="hidden"
                                                name="attribute_images_old[{{ $attrId }}][{{ $itemId }}]"
                                                value="{{ $data['image_old'] ?? '' }}">

                                            <!-- Dropzone / File Input -->
                                            <div
                                                class="p-2 border-dashed-2 rounded-3 bg-slate-50 hover-border-indigo transition-all cursor-pointer text-center">
                                                <input type="file" class="d-none color-image-input"
                                                    id="attribute_images_{{ $attrId }}_{{ $itemId }}"
                                                    name="attribute_images[{{ $attrId }}][{{ $itemId }}]"
                                                    accept="image/*" data-attr="{{ $attrId }}"
                                                    data-item="{{ $itemId }}">

                                                <label for="attribute_images_{{ $attrId }}_{{ $itemId }}"
                                                    class="cursor-pointer mb-0 w-100 d-flex align-items-center justify-content-center gap-1">
                                                    <i class="ti ti-cloud-upload fs-5 text-primary"></i>
                                                    <span class="fs-8 text-muted">Choose File</span>
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Right Side: Image Preview (If exists or selected) -->
                                        <div id="preview-wrapper-{{ $attrId }}-{{ $itemId }}"
                                            class="image-preview-wrapper flex-shrink-0 {{ !empty($data['image']) ? '' : 'd-none' }}">
                                            <div class="image-preview-card position-relative border rounded-2 p-1 bg-light"
                                                style="width: 70px; height: 70px;">
                                                <img id="colorPreview-{{ $attrId }}-{{ $itemId }}"
                                                    src="{{ $data['image'] ?? '' }}" alt="{{ $data['name'] ?? '' }}"
                                                    class="w-100 h-100 object-fit-cover rounded-2">

                                                <button type="button"
                                                    class="remove-btn remove-attr-img btn btn-danger btn-sm p-0 rounded-circle position-absolute top-0 end-0 translate-middle-y me-n1 mt-n1"
                                                    style="width: 20px; height: 20px; line-height: 1;top: 12px !important;
    right: 2px !important;"
                                                    data-attr="{{ $attrId }}"
                                                    data-item="{{ $itemId }}">&times;</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif
