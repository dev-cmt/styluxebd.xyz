<form id="purchasePayForm">
    @csrf
    <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">

    <div class="modal-header">
        <h5 class="modal-title">Pay Due - Memo: {{ $purchase->memo_no }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Supplier Name</label>
            <input type="text" class="form-control" value="{{ $purchase->get_supplier->name ?? 'N/A' }}" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Total Due Amount</label>
            <input type="text" id="total_due_amount" class="form-control text-danger fw-bold"
                value="{{ $purchase->due_amount }}" readonly>
        </div>

        <!-- Is Full Paid Checkbox -->
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_full_paid">
            <label class="form-check-label fw-bold text-primary" for="is_full_paid">Is Full Paid</label>
        </div>

        <div class="mb-3">
            <label class="form-label">Paying Amount <span class="text-danger">*</span></label>
            <input type="number" step="any" name="paid_amount" id="paid_amount_input" class="form-control"
                placeholder="Enter amount to pay" max="{{ $purchase->due_amount }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Account <span class="text-danger">*</span></label>
            <select name="account_id" class="form-control" required>
                <option value="">Select Account</option>
                @foreach ($accounts as $account)
                    <option value="{{ $account->id }}">{{ $account->account_name }} (Balance: {{ $account->balance }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Note</label>
            <textarea name="note" class="form-control" rows="2" placeholder="Optional note..."></textarea>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success btn-sm px-4">Pay</button>
    </div>
</form>

<script>
    // Is Full Paid checkbox check korle total due amount automatically paying amount-e bose jabe
    $(document).on('change', '#is_full_paid', function() {
        let dueAmount = $('#total_due_amount').val();
        if ($(this).is(':checked')) {
            $('#paid_amount_input').val(dueAmount);
        } else {
            $('#paid_amount_input').val('');
        }
    });
</script>
