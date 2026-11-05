@extends('backEnd.admin.layouts.master')
@section('title')
    Create Product
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('backEnd/assets/libs/select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('backEnd/assets/libs/summernote/summernote-lite.min.css') }}">
    <style>
        .bg-slate-50 {
            background-color: #f8fafc !important;
        }

        .bg-indigo-subtle {
            background-color: #eef2ff !important;
        }

        .text-indigo {
            color: #4f46e5 !important;
        }

        .border-dashed-2 {
            border: 2px dashed #cbd5e1 !important;
        }

        .hover-border-indigo:hover {
            border-color: #6366f1 !important;
            background-color: #f5f3ff !important;
        }

        .fs-7 {
            font-size: 0.8125rem !important;
        }

        .fs-8 {
            font-size: 0.75rem !important;
        }

        /* Image Dropzone Preview Styling */
        .image-preview-card {
            position: relative;
            width: 80px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .image-preview-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-preview-card .remove-btn {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 20px;
            height: 20px;
            background: rgba(239, 68, 68, 0.9);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            line-height: 1;
            border: none;
        }

        .image-preview-card .remove-btn:hover {
            background: #dc2626;
            transform: scale(1.1);
        }
    </style>
@endpush



@section('content')
    <div class="dashboard-wrapper">
        <div class="dashboard-ecommerce">
            <div class="container-fluid dashboard-content">

                <!-- Page Title -->
                <div class="row mb-3 mt-3">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <h3 class="fw-bold mb-0 text-dark">Create New Product</h3>
                        <a href="{{ route('admin.product') }}" class="btn btn-outline-dark btn-sm rounded-2">
                            <i class="ti ti-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data"
                    id="productCreateForm">
                    @csrf

                    <div class="row">
                        <!-- Left Main Column -->
                        <div class="col-lg-8">

                            <!-- Basic Information Card -->
                            <div class="card border-0 shadow-sm rounded-3  mb-3">
                                <div class="card-header  border-bottom-0  bg-blue-lt  py-2 px-3 ">
                                    <div class="card-title">Basic Product Details</div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark fs-7" for="name">
                                            Product Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="e.g. Premium Cotton Jersey T-Shirt" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark fs-7" for="slug">
                                            Product Slug <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="slug" name="slug" class="form-control"
                                            placeholder="auto-generated-slug">
                                        <small id="slug-message" class="fw-semibold mt-1 d-block"></small>
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-semibold text-dark fs-7" for="description">Product
                                            Description</label>
                                        <textarea name="description" class="summernote"></textarea>

                                    </div>
                                </div>
                            </div>

                            <!-- Pricing & Base Inventory Card -->
                            <div class="card border-0 shadow-sm rounded-3  mb-3">
                                <div class="card-header  bg-blue-lt  border-bottom-0   py-2 px-3">
                                    <div class="card-title">Pricing & Base Inventory</div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold text-dark fs-7" for="sku">
                                                Base SKU <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="sku" class="form-control product_sku"
                                                id="sku" placeholder="PROD-001" required>
                                            <span class="sku_text fw-bold fs-8 mt-1 d-block"></span>
                                        </div>
                                        @if ($web_settings->stock_management == 0)
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold text-dark fs-7" for="purchase_price">
                                                    Purchase Price <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <span
                                                        class="input-group-text  bg-slate-50">{{ $web_settings->currency_sign }}</span>
                                                    <input type="number" name="purchase_price" min="0"
                                                        value="0" step="0.01" class="form-control"
                                                        id="purchase_price" required>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold text-dark fs-7" for="regular_price">
                                                Regular Price <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text  bg-slate-50">{{ $web_settings->currency_sign }}</span>
                                                <input type="number" class="form-control" id="regular_price"
                                                    name="regular_price" value="0" step="0.01" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold text-dark fs-7" for="sale_price">Sale
                                                Price</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text  bg-slate-50">{{ $web_settings->currency_sign }}</span>
                                                <input type="number" class="form-control text-success fw-semibold"
                                                    id="sale_price" name="sale_price" min="0" value="0"
                                                    step="0.01">
                                            </div>
                                        </div>

                                        @if ($web_settings->stock_management == 0)
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold text-dark fs-7" for="stock">Base
                                                    Stock</label>
                                                <input type="number" name="stock" id="stock" class="form-control"
                                                    min="0" value="0">
                                            </div>
                                        @endif

                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold text-dark fs-7" for="package_qty">Package
                                                Quantity</label>
                                            <input type="number" name="package_qty" id="package_qty"
                                                class="form-control" min="0" value="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Attributes & Variations Card -->
                            <div class="card border-0 shadow-sm rounded-3  mb-3" id="product-attributes"
                                style="overflow: visible !important;">
                                <input type="hidden" name="v_purchase_price" id="v_purchase_price">
                                <input type="hidden" name="v_regular_price" id="v_regular_price">
                                <input type="hidden" name="v_sale_price" id="v_sale_price">
                                <input type="hidden" name="h_sku" id="h_sku">

                                <div class="card-header  bg-blue-lt  border-bottom-0   py-2 px-3">
                                    <div class="card-title">Attributes & Variations</div>
                                </div>

                                <div class="card-body p-3" style="overflow: visible !important;">
                                    <!-- Attribute Checkbox List -->
                                    <div class="row g-3 attribute-row">
                                        @foreach ($attributes as $key => $attribute)
                                            <div class="col-md-4 form-group">
                                                <div class="p-3 border rounded-3 bg-slate-50 transition-all h-100">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <label class="form-check form-switch mb-0 cursor-pointer"
                                                            for="attribute_switch_{{ $key }}">
                                                            <input type="checkbox"
                                                                id="attribute_switch_{{ $key }}"
                                                                data-target="#attribute_select_{{ $key }}"
                                                                data-is_image="{{ $attribute->is_image }}"
                                                                class="form-check-input attribute_id cursor-pointer"
                                                                value="{{ $attribute->id }}">
                                                            <span
                                                                class="form-check-label text-capitalize fw-bold text-dark fs-7 ms-2">
                                                                {{ $attribute->name }}
                                                            </span>
                                                        </label>

                                                        <button type="button"
                                                            class="btn btn-xs btn-outline-primary item-add-btn rounded-2 px-2 py-1 fs-8"
                                                            disabled
                                                            onclick="$('#hidden_attribute_id').val({{ $attribute->id }})">
                                                            <i class="ti ti-plus me-0"></i> Add
                                                        </button>
                                                    </div>

                                                    <select name="attribute[{{ $attribute->id }}][]"
                                                        id="attribute_select_{{ $key }}"
                                                        class="form-select select2-attribute attribute_item_id" multiple
                                                        disabled required style="width: 100%;">
                                                        @foreach ($attribute->items as $att_item)
                                                            <option data-name="{{ $att_item->name }}"
                                                                value="{{ $att_item->id }}">
                                                                {{ $att_item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Variant Color/Image Container -->
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="card border-0 bg-transparent attribute-div"
                                                style="display: none;">
                                                <div class="attribute-image-container"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Quick Bulk Apply Section -->
                                    <div id="bulk-apply-wrapper"
                                        class="  p-3 bg-indigo-subtle border border-indigo-subtle rounded-3 d-none">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="fw-bold text-indigo fs-7">
                                                <i class="ti ti-bolt me-1"></i> Quick Apply to All Variations
                                            </span>
                                            <small class="text-muted fs-8">Type value and click apply</small>
                                        </div>
                                        <div class="row g-2">
                                            {{-- <div class="col">
                                                <input type="number" id="bulk_purchase" class="form-control"
                                                    placeholder="Purchase">
                                            </div> --}}
                                            <div class="col">
                                                <input type="number" id="bulk_regular" class="form-control"
                                                    placeholder="Regular">
                                            </div>
                                            <div class="col">
                                                <input type="number" id="bulk_sale" class="form-control"
                                                    placeholder="Sale">
                                            </div>
                                            @if ($web_settings->stock_management == 0)
                                                <div class="col">
                                                    <input type="number" id="bulk_stock" class="form-control"
                                                        placeholder="Stock">
                                                </div>
                                            @endif
                                            <div class="col-auto">
                                                <button type="button" id="btn-apply-bulk" class="btn  btn-primary px-3">
                                                    Apply All
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- AJAX Generated Combinations Table -->
                                    <div class="row mt-2">
                                        <div class="col-12" id="attribute-table-put"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- SEO Information Card -->
                            <div class="card border-0 shadow-sm rounded-3 mb-3">
                                <div
                                    class="card-header  bg-blue-lt  border-bottom-0   py-2 px-3  d-flex align-items-center justify-content-between">
                                    <div class="card-title">
                                        <i class="ti ti-seo me-1 text-primary"></i> Search Engine Optimization (SEO)
                                    </div>
                                </div>
                                <div class="card-body p-3">

                                    <!-- Meta Title Input -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label fw-semibold text-dark fs-7 mb-0"
                                                for="meta_title">Meta Title</label>
                                            <span class="fs-8 text-muted"><span id="meta_title_count">0</span> / 60
                                                characters</span>
                                        </div>
                                        <input type="text" class="form-control" id="meta_title" name="meta_title"
                                            placeholder="e.g. Premium Cotton T-Shirt | Best Price in BD" maxlength="70">
                                        <small class="text-muted fs-8">Leave empty to use default Product Name.</small>
                                    </div>

                                    <!-- Meta Description Input -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label fw-semibold text-dark fs-7 mb-0"
                                                for="meta_description">Meta Description</label>
                                            <span class="fs-8 text-muted"><span id="meta_desc_count">0</span> / 160
                                                characters</span>
                                        </div>
                                        <textarea name="meta_description" id="meta_description" rows="3" class="form-control"
                                            placeholder="Write a clear, concise description for search engine results..." maxlength="170"></textarea>
                                    </div>

                                    <!-- Meta Keywords Input -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark fs-7" for="meta_keywords">
                                            Meta Keywords
                                        </label>
                                        <input type="text" class="form-control" id="meta_keywords"
                                            name="meta_keywords"
                                            placeholder="e.g. t-shirt, jersey, cotton tshirt, mens wear (comma separated)">
                                        <small class="text-muted fs-8">Separate each keyword with a comma (,)</small>
                                    </div>

                                    <!-- Custom Social / OpenGraph Meta Image -->
                                    <div class="mb-0">
                                        <label class="form-label fw-semibold text-dark fs-7">Meta Image (Social Sharing
                                            Preview)</label>
                                        <div
                                            class="p-3 border-dashed-2 rounded-3 bg-slate-50 text-center hover-border-indigo transition-all">
                                            <input type="file" class="d-none" id="metaImage" name="meta_image"
                                                accept="image/*">
                                            <label for="metaImage" class="cursor-pointer mb-0">
                                                <i class="ti ti-photo-share fs-2 text-primary d-block mb-1"></i>
                                                <span class="fs-7 fw-semibold text-dark">Click to upload Custom Meta
                                                    Image</span>
                                                <span class="d-block fs-8 text-muted mt-1">(Recommended: 1200 x 630 px.
                                                    Falls back to Feature Image if empty)</span>
                                            </label>
                                        </div>
                                        <div id="metaImagePreview" class="d-flex flex-wrap gap-2 mt-2"></div>
                                    </div>

                                </div>
                            </div>




                        </div>

                        <!-- Right Sidebar Column -->
                        <div class="col-lg-4">

                            <!-- Categories & Status Card -->
                            <div class="card border-0 shadow-sm rounded-3  mb-3">
                                <div class="card-header  bg-blue-lt  border-bottom-0   py-2 px-3">
                                    <div class="card-title">Organization</div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark fs-7" for="category_id">
                                            Product Category <span class="text-danger">*</span>
                                        </label>
                                        <select name="category_id[]" id="category_id" class="form-control select2"
                                            required multiple style="width: 100%;">
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark fs-7" for="status">Publication
                                            Status</label>
                                        <select name="status" id="status" class="form-select">
                                            <option value="1">Published</option>
                                            <option value="0">Unpublished</option>
                                        </select>
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-semibold text-dark fs-7"
                                            for="related_products">Related Products</label>
                                        <select name="related_products[]" id="related_products"
                                            class="form-control select2" multiple style="width: 100%;">
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}
                                                    #{{ $product->sku }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Media Upload Card (With Cross Remove) -->
                            <div class="card border-0 shadow-sm rounded-3  mb-3">
                                <div class="card-header  bg-blue-lt  border-bottom-0   py-2 px-3">
                                    <div class="card-title">Product Images</div>
                                </div>
                                <div class="card-body p-3">

                                    <!-- Feature Image -->
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold text-dark fs-7">Feature Image</label>
                                        <div
                                            class="p-3 border-dashed-2 rounded-3 bg-slate-50 text-center hover-border-indigo transition-all">
                                            <input type="file" class="d-none" id="featureImage" name="image"
                                                accept="image/*">
                                            <label for="featureImage" class="cursor-pointer mb-0">
                                                <i class="ti ti-cloud-upload fs-2 text-primary d-block mb-1"></i>
                                                <span class="fs-7 fw-semibold text-dark">Click to upload Feature
                                                    Image</span>
                                            </label>
                                        </div>
                                        <div id="featurePreview" class="d-flex flex-wrap gap-2 mt-2"></div>
                                    </div>

                                    <!-- Hover Image (If Applicable) -->
                                    @php
                                        $hover_image = null;
                                        foreach ($extraFields as $key => $field) {
                                            if ($field['field_name'] == 'hover_image') {
                                                $hover_image = $field;
                                            }
                                        }
                                    @endphp

                                    @if ($hover_image)
                                        <div class="mb-4">
                                            <label
                                                class="form-label fw-semibold text-dark fs-7">{{ $hover_image['field_label'] }}</label>
                                            <div
                                                class="p-3 border-dashed-2 rounded-3 bg-slate-50 text-center hover-border-indigo transition-all">
                                                <input type="file" class="d-none" id="hover_image"
                                                    name="{{ $hover_image['field_name'] }}" accept="image/*"
                                                    {{ $hover_image['is_required'] ? 'required' : '' }}>
                                                <label for="hover_image" class="cursor-pointer mb-0">
                                                    <i class="ti ti-photo fs-2 text-primary d-block mb-1"></i>
                                                    <span class="fs-7 fw-semibold text-dark">Upload
                                                        {{ $hover_image['field_label'] }}</span>
                                                </label>
                                            </div>
                                            <div id="hoverPreview" class="d-flex flex-wrap gap-2 mt-2"></div>
                                        </div>
                                    @endif

                                    <!-- Gallery Multi Images -->
                                    <div class="mb-0">
                                        <label class="form-label fw-semibold text-dark fs-7">Gallery Images</label>
                                        <div
                                            class="p-3 border-dashed-2 rounded-3 bg-slate-50 text-center hover-border-indigo transition-all">
                                            <input type="file" class="d-none" id="gallery_image"
                                                name="gallery_image[]" multiple accept="image/*">
                                            <label for="gallery_image" class="cursor-pointer mb-0">
                                                <i class="ti ti-photo-plus fs-2 text-primary d-block mb-1"></i>
                                                <span class="fs-7 fw-semibold text-dark">Click to upload multiple
                                                    images</span>
                                            </label>
                                        </div>
                                        <div id="galleryPreview" class="d-flex flex-wrap gap-2 mt-3"></div>
                                    </div>

                                    <!-- Size Chart Image -->
                                    <div class="mb-0 mt-3">
                                        <label class="form-label fw-semibold text-dark fs-7">Size Chart Image</label>
                                        <div
                                            class="p-3 border-dashed-2 rounded-3 bg-slate-50 text-center hover-border-indigo transition-all">
                                            <input type="file" class="d-none" id="sizeChartImage" name="size_chart"
                                                accept="image/*">
                                            <label for="sizeChartImage" class="cursor-pointer mb-0">
                                                <i class="ti ti-ruler-2 fs-2 text-primary d-block mb-1"></i>
                                                <span class="fs-7 fw-semibold text-dark">Click to upload Size Chart</span>
                                            </label>
                                        </div>
                                        <div id="sizeChartPreview" class="d-flex flex-wrap gap-2 mt-2"></div>
                                    </div>

                                </div>
                            </div>

                            <!-- Submit Action Button -->
                            <div class="card border-0 shadow-sm rounded-3">
                                <div class="card-body p-3">
                                    <button type="submit" class="btn btn-success w-100 p-3 fw-bold rounded-2 fs-4"
                                        id="form_add_btn">
                                        <i class="ti ti-check me-1"></i> Save & Publish Product
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Attribute Item Create Modal -->
    <div class="modal fade" id="attributeItemCreateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header  ">
                    <h5 class="modal-title fw-bold">Add Attribute Value</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="attributeItemForm">
                    @csrf
                    <input type="hidden" name="hidden_attribute_id" id="hidden_attribute_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="modal_item_name" class="form-label fw-semibold fs-7">Attribute Value Name</label>
                            <input type="text" class="form-control" id="modal_item_name" name="name"
                                placeholder="e.g. XL, Blue, Cotton" required>
                            <span class="text-danger name_error mt-2 d-block fs-8"></span>
                        </div>
                    </div>
                    <div class="modal-footer  ">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-3">Save Value</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('backEnd/assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('backEnd/assets/libs/summernote/summernote-lite.min.js') }}"></script>


    <script>
        $(document).ready(function() {

            // Single File Input Preview (Feature Image)
            $('#featureImage').on('change', function() {
                let container = $('#featurePreview');
                container.empty();
                if (this.files && this.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let previewHtml = `
                            <div class="image-preview-card">
                                <img src="${e.target.result}" alt="Preview">
                                <button type="button" class="remove-btn" id="removeFeatureBtn">&times;</button>
                            </div>`;
                        container.html(previewHtml);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            $(document).on('click', '#removeFeatureBtn', function() {
                $('#featureImage').val('');
                $('#featurePreview').empty();
            });

            // Single File Input Preview (Hover Image)
            $('#hover_image').on('change', function() {
                let container = $('#hoverPreview');
                container.empty();
                if (this.files && this.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let previewHtml = `
                            <div class="image-preview-card">
                                <img src="${e.target.result}" alt="Preview">
                                <button type="button" class="remove-btn" id="removeHoverBtn">&times;</button>
                            </div>`;
                        container.html(previewHtml);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });


            $(document).on('click', '#removeHoverBtn', function() {
                $('#hover_image').val('');
                $('#hoverPreview').empty();
            });




            // Size Chart File Preview
            $('#sizeChartImage').on('change', function() {
                let container = $('#sizeChartPreview');
                container.empty();
                if (this.files && this.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let previewHtml = `
                <div class="image-preview-card">
                    <img src="${e.target.result}" alt="Size Chart Preview">
                    <button type="button" class="remove-btn" id="removeSizeChartBtn">&times;</button>
                </div>`;
                        container.html(previewHtml);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            $(document).on('click', '#removeSizeChartBtn', function() {
                $('#sizeChartImage').val('');
                $('#sizeChartPreview').empty();
            });









            // Gallery Multiple Image Handler with DataTransfer Object
            let galleryFiles = new DataTransfer();

            $('#gallery_image').on('change', function() {
                let files = this.files;
                for (let i = 0; i < files.length; i++) {
                    galleryFiles.items.add(files[i]);
                }
                this.files = galleryFiles.files;
                renderGalleryPreviews();
            });

            function renderGalleryPreviews() {
                let container = $('#galleryPreview');
                container.empty();

                Array.from(galleryFiles.files).forEach((file, index) => {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let previewHtml = `
                            <div class="image-preview-card">
                                <img src="${e.target.result}" alt="Gallery Preview">
                                <button type="button" class="remove-btn remove-gallery-btn" data-index="${index}">&times;</button>
                            </div>`;
                        container.append(previewHtml);
                    }
                    reader.readAsDataURL(file);
                });
            }

            $(document).on('click', '.remove-gallery-btn', function() {
                let indexToRemove = $(this).data('index');
                let newDt = new DataTransfer();

                Array.from(galleryFiles.files).forEach((file, i) => {
                    if (i !== indexToRemove) {
                        newDt.items.add(file);
                    }
                });

                galleryFiles = newDt;
                document.getElementById('gallery_image').files = galleryFiles.files;
                renderGalleryPreviews();
            });
        });
    </script>

    <!-- Select2 Init -->
    {{-- <script>
        $(document).ready(function() {
            $('.select').select2({
                placeholder: "Select items"
            });
            $('.select2').select2();
        });
    </script> --}}

    <!-- Summernote Editor -->
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 250,
                callbacks: {
                    onImageUpload: function(files) {
                        for (let i = 0; i < files.length; i++) {
                            uploadImage(files[i]);
                        }
                    },
                    onMediaDelete: function(target) {
                        deleteImage(target[0].src);
                    }
                }
            });

            function uploadImage(file) {
                let data = new FormData();
                data.append('image', file);
                data.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: '{{ route('summernote.upload') }}',
                    method: 'POST',
                    data: data,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        $('.summernote').summernote('insertImage', res.url);
                    }
                });
            }

            function deleteImage(src) {
                $.ajax({
                    url: '{{ route('summernote.delete') }}',
                    method: 'POST',
                    data: {
                        src: src,
                        _token: '{{ csrf_token() }}'
                    }
                });
            }
        });
    </script>

    <!-- Variant Generation & Bulk Price Application -->
    <script>
        $('.attribute_id').on('click', function() {
            var parent = $(this).closest('.form-group');
            if ($(this).is(':checked')) {
                parent.find('select').prop('disabled', false);
                parent.find('.item-add-btn').prop('disabled', false);
            } else {
                parent.find('select').prop('disabled', true);
                parent.find('.item-add-btn').prop('disabled', true);
            }
        });

        function variants() {
            $('#v_purchase_price').val($('#purchase_price').val());
            $('#v_sale_price').val($('#sale_price').val());
            $('#v_regular_price').val($('#regular_price').val());
            $('#h_sku').val($('#sku').val());

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                type: "POST",
                url: `{{ route('admin.product.ajax.get.combined.attributes') }}`,
                data: $("#product-attributes").find('select, input').serialize(),
                success: function(data) {
                    if (data && $.trim(data) !== '') {
                        $('#attribute-table-put').empty().html(data);
                        $('#bulk-apply-wrapper').removeClass('d-none');
                    } else {
                        $('#attribute-table-put').empty();
                        $('#bulk-apply-wrapper').addClass('d-none');
                    }
                }
            });
        }

        // Bulk Apply Trigger
        $(document).on('click', '#btn-apply-bulk', function() {
            let regular = $('#bulk_regular').val();
            let sale = $('#bulk_sale').val();
            let stock = $('#bulk_stock').val();

            if (regular !== '') $('input[name="variant_regular_price[]"]').val(regular);
            if (sale !== '') $('input[name="variant_sale_price[]"]').val(sale);
            if (stock !== undefined && stock !== '') $('input[name="variant_stock[]"]').val(stock);
        });

        $(document).on('keyup', '#sku', function() {
            let value = $(this).val().replaceAll(' ', '-').toLowerCase();
            variants();
        });

        $(document).on('input', '#slug', function() {
            let value = $(this).val().replaceAll(' ', '-').toLowerCase();
            $(this).val(value);
            variants();
        });

        function updateVariantImages() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                type: "POST",
                url: `{{ route('admin.product.ajax.get.color.image') }}`,
                data: $(".attribute-row").find('input, select').serialize(),
                success: function(data) {
                    if (data) {
                        $('.attribute-div').show();
                        $('.attribute-image-container').empty().html(data);
                    } else {
                        $('.attribute-div').hide();
                        $('.attribute-image-container').empty();
                    }
                }
            });
        }

        $(document).on('change', '.attribute_item_id', function() {
            updateVariantImages();
            variants();
        });

        $('#purchase_price, #regular_price, #sale_price').on('keyup', function() {
            variants();
        });
    </script>

    <!-- Modal Form Submit AJAX -->
    <script>
        function resetVariantModal(attributeId) {
            $('#attributeItemForm')[0].reset();
            $('#hidden_attribute_id').val(attributeId);
            $('.name_error').text('');
        }

        $(document).on('click', '.item-add-btn', function() {
            $('#attributeItemCreateModal').modal('show');
            resetVariantModal($('#hidden_attribute_id').val());
        });

        $(document).on('submit', '#attributeItemForm', function(e) {
            e.preventDefault();
            var $form = $(this);

            $.ajax({
                type: "POST",
                url: `{{ route('admin.product.attribute.item.store') }}`,
                data: $form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': `{{ csrf_token() }}`
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $('#attributeItemCreateModal').modal('hide');
                        $form[0].reset();

                        var attributeId = $('#hidden_attribute_id').val();
                        var $select = $(`select[name="attribute[${attributeId}][]"]`);
                        var newOption = new Option(response.item.name, response.item.id, true, true);
                        $select.append(newOption).trigger('change');
                    } else {
                        $('.name_error').text(response.message);
                    }
                }
            });
        });

        // Slug Auto Generator
        $(document).ready(function() {
            function generateSlug(text) {
                return text.toString().toLowerCase()
                    .replace(/\s+/g, '-')
                    .replace(/[^\w\-]+/g, '')
                    .replace(/\-\-+/g, '-')
                    .replace(/^-+/, '')
                    .replace(/-+$/, '');
            }

            $("#name").on("input", function() {
                let slug = generateSlug($(this).val());
                $("#slug").val(slug);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2-attribute').select2({
                placeholder: "Select items",
                allowClear: true,
                width: '100%'
            });

        });
    </script>
    <script>
        // Dynamic File Preview Event Delegation
        $(document).off('change', '.color-image-input').on('change', '.color-image-input', function() {
            let attr = $(this).data('attr');
            let item = $(this).data('item');
            let input = this;

            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#colorPreview-' + attr + '-' + item).attr('src', e.target.result);
                    $('#preview-wrapper-' + attr + '-' + item).removeClass('d-none');
                };
                reader.readAsDataURL(input.files[0]);
            }
        });

        // Remove Attribute Image Handler
        $(document).off('click', '.remove-attr-img').on('click', '.remove-attr-img', function(e) {
            e.preventDefault();
            let attr = $(this).data('attr');
            let item = $(this).data('item');

            $('#attribute_images_' + attr + '_' + item).val('');
            $('#colorPreview-' + attr + '-' + item).attr('src', '');
            $('#preview-wrapper-' + attr + '-' + item).addClass('d-none');
        });

        // Attribute Item / Switch Toggle Fix
        $(document).off('change', '.attribute_id').on('change', '.attribute_id', function() {
            var parent = $(this).closest('.form-group');
            var targetSelect = $(this).data('target');

            if ($(this).is(':checked')) {
                $(targetSelect).prop('disabled', false).trigger('change.select2');
                parent.find('.item-add-btn').prop('disabled', false);
            } else {
                $(targetSelect).val(null).trigger('change').prop('disabled', true).trigger('change.select2');
                parent.find('.item-add-btn').prop('disabled', true);

                if (typeof updateVariantImages === "function") updateVariantImages();
                if (typeof variants === "function") variants();
            }
        });
    </script>
    <script>
        $(document).ready(function() {

            // Auto Sync Product Name to Meta Title & Preview
            $('#name').on('input', function() {
                let val = $(this).val();
                if ($('#meta_title').val() === '') {
                    $('#seo-preview-title').text(val ? val : 'Product Name - Your Brand');
                }
            });

            // Auto Sync Slug to Preview
            $('#slug').on('input', function() {
                let val = $(this).val();
                $('#seo-preview-slug').text(val ? val : 'product-slug');
            });

            // Meta Title Dynamic Handler & Character Count
            $('#meta_title').on('input', function() {
                let len = $(this).val().length;
                let val = $(this).val();
                $('#meta_title_count').text(len);

                if (len > 60) {
                    $('#meta_title_count').addClass('text-danger').removeClass('text-muted');
                } else {
                    $('#meta_title_count').removeClass('text-danger').addClass('text-muted');
                }

                if (val.trim() !== '') {
                    $('#seo-preview-title').text(val);
                } else {
                    let fallback = $('#name').val();
                    $('#seo-preview-title').text(fallback ? fallback : 'Product Name - Your Brand');
                }
            });

            // Meta Description Dynamic Handler & Character Count
            $('#meta_description').on('input', function() {
                let len = $(this).val().length;
                let val = $(this).val();
                $('#meta_desc_count').text(len);

                if (len > 160) {
                    $('#meta_desc_count').addClass('text-danger').removeClass('text-muted');
                } else {
                    $('#meta_desc_count').removeClass('text-danger').addClass('text-muted');
                }

                if (val.trim() !== '') {
                    $('#seo-preview-description').text(val);
                } else {
                    $('#seo-preview-description').text(
                        'Enter a meta description to see how this product will show up in search engine result pages.'
                    );
                }
            });

            // Single File Input Preview (Meta Image)
            $('#metaImage').on('change', function() {
                let container = $('#metaImagePreview');
                container.empty();
                if (this.files && this.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let previewHtml = `
                        <div class="image-preview-card">
                            <img src="${e.target.result}" alt="Meta Preview">
                            <button type="button" class="remove-btn" id="removeMetaImgBtn">&times;</button>
                        </div>`;
                        container.html(previewHtml);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            $(document).on('click', '#removeMetaImgBtn', function() {
                $('#metaImage').val('');
                $('#metaImagePreview').empty();
            });

        });
    </script>
@endpush
