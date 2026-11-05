{{-- Manage Note Modal --}}
<div class="modal fade" id="noteActionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h5 class="modal-title fs-6" id="noteModalTitle">Manage Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="noteActionForm">
                @csrf
                <div class="modal-body py-3">
                    <input type="hidden" name="order_id" id="modal_order_id">
                    <input type="hidden" name="note_id" id="modal_note_id">
                    <input type="hidden" name="type" id="modal_note_type">
                    <input type="hidden" name="action" id="modal_action_type">

                    {{-- Staff Note Options (Quick Radio Buttons) --}}
                    <div id="staffNoteRadioGroup" class="mb-3 d-none">
                        <label class="form-label mb-2 fw-bold fs-7">Select Preset Message:</label>
                        <div class="d-flex flex-column gap-1">
                            <label class="form-check mb-1">
                                <input class="form-check-input staff-preset-radio" type="radio" name="preset_note"
                                    value="Call Unreachable">
                                <span class="form-check-label fs-7">Call Unreachable</span>
                            </label>
                            <label class="form-check mb-1">
                                <input class="form-check-input staff-preset-radio" type="radio" name="preset_note"
                                    value="Order Confirmed over Phone">
                                <span class="form-check-label fs-7">Order Confirmed over Phone</span>
                            </label>
                            <label class="form-check mb-1">
                                <input class="form-check-input staff-preset-radio" type="radio" name="preset_note"
                                    value="Customer Requested Delay">
                                <span class="form-check-label fs-7">Customer Requested Delay</span>
                            </label>
                            <label class="form-check mb-1">
                                <input class="form-check-input staff-preset-radio" type="radio" name="preset_note"
                                    value="Address Incomplete">
                                <span class="form-check-label fs-7">Address Incomplete</span>
                            </label>
                            <label class="form-check mb-1">
                                <input class="form-check-input staff-preset-radio" type="radio" name="preset_note"
                                    value="other" id="radioOther">
                                <span class="form-check-label fs-7 fw-bold text-primary">Other (Type custom
                                    message)</span>
                            </label>
                        </div>
                    </div>

                    {{-- Text Field (For Customer ALWAYS, For Staff when 'Other' selected or editing custom text) --}}
                    <div class="mb-2" id="customNoteInputGroup">
                        <label class="form-label mb-1 fw-bold fs-7" id="noteTypeLabel">Note</label>
                        <textarea name="note" id="modal_note_text" class="form-control" rows="3" placeholder="Type note here..."></textarea>
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">Save Note</button>
                </div>
            </form>
        </div>
    </div>
</div>
