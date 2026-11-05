{{-- CREATE / EDIT ATTRIBUTE COLOR IMAGE SECTION --}}
@if (!empty($colorImages) && count($colorImages) > 0)
    <div class="row g-3">
        @foreach ($colorImages as $key => $attribute)
            @php
                $attrName = DB::table('attributes')->where('id', $key)->value('name');
            @endphp
            @if (!empty($attribute) && count($attribute) > 0)
                <div class="col-md-12 mt-2">
                    <div class="card border-0 bg-slate-50 shadow-none p-3 rounded-3 mb-2">
                        <h6 class="fw-bold text-dark text-capitalize mb-3 fs-7">
                            <i class="ti ti-palette me-1 text-primary"></i>
                            {{ $attrName ?? 'Variant' }} Images
                        </h6>
                        <div class="row g-3">
                            @foreach ($attribute as $value)
                                @php
                                    $item = DB::table('attribute_items')->where('id', $value)->first();
                                    $itemName = $item ? $item->name : 'N/A';

                                    // Check existing image in Edit Mode
                                    $existingImg = '';
                                    if (isset($color_images[$key][$value]) && !empty($color_images[$key][$value])) {
                                        $existingImg = asset($color_images[$key][$value]);
                                    } elseif ($item && !empty($item->image)) {
                                        $existingImg = asset($item->image);
                                    }
                                @endphp
                                <div class="col-md-6 col-lg-4">
                                    <div
                                        class="p-3 bg-white border rounded-3 h-100 d-flex align-items-center justify-content-between gap-3">

                                        <!-- Left Side: Item Name & Upload Option -->
                                        <div class="flex-grow-1">
                                            <label class="form-label fw-semibold text-dark fs-8 mb-2 d-block">
                                                {{ $itemName }}
                                            </label>

                                            <!-- Dropzone / File Input -->
                                            <div
                                                class="p-2 border-dashed-2 rounded-3 bg-slate-50 hover-border-indigo transition-all cursor-pointer text-center">
                                                <input type="file" class="d-none color-image-input"
                                                    id="attribute_images_{{ $key }}_{{ $value }}"
                                                    name="attribute_images[{{ $key }}][{{ $value }}]"
                                                    accept="image/*" data-attr="{{ $key }}"
                                                    data-item="{{ $value }}">

                                                <label for="attribute_images_{{ $key }}_{{ $value }}"
                                                    class="cursor-pointer mb-0 w-100 d-flex align-items-center justify-content-center gap-1">
                                                    <i class="ti ti-cloud-upload fs-5 text-primary"></i>
                                                    <span class="fs-8 text-muted">Choose File</span>
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Right Side: Image Preview (If exists or selected) -->
                                        <div id="preview-wrapper-{{ $key }}-{{ $value }}"
                                            class="image-preview-wrapper flex-shrink-0 {{ $existingImg ? '' : 'd-none' }}">
                                            <div class="image-preview-card position-relative border rounded-2 p-1 bg-light"
                                                style="width: 70px; height: 70px;">
                                                <img id="colorPreview-{{ $key }}-{{ $value }}"
                                                    src="{{ $existingImg }}" alt="{{ $itemName }}"
                                                    class="w-100 h-100 object-fit-cover rounded-2">
                                                <button type="button"
                                                    class="remove-btn remove-attr-img btn btn-danger btn-sm p-0 rounded-circle position-absolute top-0 end-0 translate-middle-y me-n1 mt-n1"
                                                    style="width: 20px; height: 20px; line-height: 1;top: 12px !important;
    right: 2px !important;"
                                                    data-attr="{{ $key }}"
                                                    data-item="{{ $value }}">&times;</button>
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
