@extends('backEnd.admin.layouts.master')

@section('title', 'Testimonials')

@push('css')
    <style>
        .testimonial-img-preview {
            width: 150px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }

        .text-warning-star {
            color: #ffc107;
        }
    </style>
@endpush

@php $testimonials = $testimonials ?? []; @endphp

@section('content')
    {{--
    <div class="page-body mt-3">
        <div class="container-xl">
            <!-- Page Header -->
            <div class="d-flex flex-column align-items-start mb-3">
                <h2>Testimonials</h2>
                <button class="btn btn-success btn-sm add_testimonial">
                    <i class="ti ti-plus"></i>
                    Add Testimonial
                </button>
            </div>

            <!-- Testimonials Table -->
            <div class="card"> --}}
    <div class="page-body mt-3">
        <div class="container-xl">
            <div class="row">
                <div class="col-12 d-flex justify-content-between align-items-center gap-2">
                    <h2 class="page-title">Testimonials</h2>
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center gap-1">
                            <span class="fw-bold">Total:</span>
                            <span class="badge bg-primary text-white">{{ $testimonials->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-deck row-cards mt-2">
                <!-- Page Header Close -->
                <div class="col-12 m-0">
                    <div class="card" style="border-top: none">
                        <div class="card-header d-flex align-items-center gap-2">
                            @can('testimonials.create')
                                <button class="btn btn-success btn-sm add_testimonial">
                                    <i class="ti ti-plus"></i>
                                    Add Testimonial
                                </button>
                            @endcan
                            {{-- Clean Production Bulk Delete Button --}}
                            {{-- <button type="button" id="bulk_delete_btn"
                                class="btn btn-gradient-danger btn-sm d-flex align-items-center gap-1">
                                <i class="ti ti-trash"></i> Bulk Delete
                                <span id="selected_count" class="badge bg-white text-danger ms-1 d-none">0</span>
                            </button> --}}
                        </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr class="align-middle">
                                        <th class="w-1">
                                            SL. <input class="form-check-input m-0 align-middle" type="checkbox"
                                                aria-label="Select all invoices" id="master">
                                        </th>
                                        <th>Image</th>
                                        <th class="text-start">Review</th>
                                        <th>Rating</th>
                                        <th>Position</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @forelse($testimonials as $item)
                                        <tr @if ($i % 2 == 0) style="background-color:#f5f5f5" @endif>
                                            <td class="sl-cell">
                                                {{ $i++ }}.
                                                <input class="form-check-input m-0 align-middle sub_chk" type="checkbox"
                                                    data-id="{{ $item->id }}">
                                            </td>
                                            <td class="">
                                                <img src="{{ asset($item->get_image->file_url) }}"
                                                    class="testimonial-img-preview">
                                            </td>
                                            <td class="text-start" style="max-width: 300px;">
                                                <div class="text-truncate-3" title="{{ $item->review }}">
                                                    {{ Str::limit($item->review, 120, '...') }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-warning-star">
                                                    @for ($star = 1; $star <= 5; $star++)
                                                        <i
                                                            class="{{ $star <= $item->rating ? 'ti ti-star-filled' : 'ti ti-star' }}"></i>
                                                    @endfor
                                                </div>
                                                <span class="small text-muted">({{ $item->rating }}/5)</span>
                                            </td>
                                            <td style="width: 100px">
                                                <input type="text" readonly
                                                    class="form-control form-control-sm text-center"
                                                    value="{{ $item->position }}">
                                            </td>
                                            <td class="">
                                                <span class="badge {{ $item->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $item->status == 1 ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td style="width: 120px">
                                                <button
                                                    class="btn-gradient-info padding-2-6 border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1 edit_testimonial_btn"
                                                    data-id="{{ $item->id }}" data-position="{{ $item->position }}"
                                                    data-status="{{ $item->status }}" data-review="{{ $item->review }}"
                                                    data-rating="{{ $item->rating }}"
                                                    data-image_url="{{ asset($item->get_image->file_url) }}">
                                                    <i class="ti ti-edit"></i> Edit
                                                </button>

                                                <a href="{{ route('admin.testimonials.delete', $item->id) }}"
                                                    class="btn-gradient-danger padding-2-6 border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1"
                                                    onclick="return confirm('Are you sure you want to delete this testimonial?')">
                                                    <i class="ti ti-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-danger fw-bold">No Testimonials Found!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 1. ADD TESTIMONIAL MODAL -->
    <!-- ========================================== -->
    <div class="modal fade" id="add_testimonial_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Testimonial</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label required">Image</label>
                            <input type="file" class="form-control" name="image" required accept="image/*">
                            <small class="text-muted">Recommended size: 1000x1000 px</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Review Text</label>
                            <textarea class="form-control" name="review" rows="4"
                                placeholder="Write the customer testimonial review here..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Rating</label>
                            <select class="form-select" name="rating" required>
                                <option value="5" selected>⭐⭐⭐⭐⭐ (5 Stars)</option>
                                <option value="4">⭐⭐⭐⭐ (4 Stars)</option>
                                <option value="3">⭐⭐⭐ (3 Stars)</option>
                                <option value="2">⭐⭐ (2 Stars)</option>
                                <option value="1">⭐ (1 Star)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Position</label>
                            <input type="number" class="form-control" name="position"
                                placeholder="Enter display position">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save Testimonial</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 2. EDIT TESTIMONIAL MODAL -->
    <!-- ========================================== -->
    <div class="modal fade" id="edit_testimonial_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="edit_testimonial_form" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="testimonial_id_edit">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Testimonial</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 text-center">
                            <label class="form-label d-block text-start">Current Image</label>
                            <img id="img_append" src="" class="img-thumbnail mb-2" style="max-height: 120px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Change Image</label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                            <small class="text-muted">Leave empty to keep existing image</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Review Text</label>
                            <textarea class="form-control" name="review" id="review_edit" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Rating</label>
                            <select class="form-select" name="rating" id="rating_edit" required>
                                <option value="5">⭐⭐⭐⭐⭐ (5 Stars)</option>
                                <option value="4">⭐⭐⭐⭐ (4 Stars)</option>
                                <option value="3">⭐⭐⭐ (3 Stars)</option>
                                <option value="2">⭐⭐ (2 Stars)</option>
                                <option value="1">⭐ (1 Star)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Position</label>
                            <input type="number" class="form-control" name="position" id="position_edit">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" id="status_edit">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">Update Testimonial</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Open Create Modal
            $('.add_testimonial').click(function() {
                $('#add_testimonial_modal').modal('show');
            });

            // Open Edit Modal & Populate Form Data
            $(document).on('click', '.edit_testimonial_btn', function() {
                let id = $(this).data('id');
                let position = $(this).data('position');
                let status = $(this).data('status');
                let review = $(this).data('review');
                let rating = $(this).data('rating');
                let imageUrl = $(this).data('image_url');

                // ফর্ম অ্যাকশন ডায়নামিকালি সেট করা
                let updateUrl = "{{ route('admin.testimonials.update', ':id') }}".replace(':id', id);
                $('#edit_testimonial_form').attr('action', updateUrl);

                $('#testimonial_id_edit').val(id);
                $('#position_edit').val(position);
                $('#status_edit').val(status);
                $('#review_edit').val(review);
                $('#rating_edit').val(rating);
                $('#img_append').attr('src', imageUrl);

                $('#edit_testimonial_modal').modal('show');
            });
        });
    </script>
@endsection
