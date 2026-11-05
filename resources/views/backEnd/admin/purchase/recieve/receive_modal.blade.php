<div class="modal-header bg-light">
    <h5 class="modal-title">
        <i class="ti ti-package"></i> Purchase Item(s) — Receive Stock
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <!-- Top Info Row -->
    <div class="card mb-3 bg-light-subtle">
        <div class="card-body py-2">
            <div class="row">
                <div class="col-md-4">
                    <small class="text-muted d-block">VOUCHER / MEMO NO</small>
                    <strong>{{ $purchase->memo_no ?? '#PUR-' . $purchase->id }}</strong>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block">SUPPLIER</small>
                    <strong>{{ $purchase->get_supplier->name ?? 'N/A' }}</strong>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block">PURCHASE DATE</small>
                    <strong>{{ date('d M Y', strtotime($purchase->purchase_date)) }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Process Form & Table -->
    <form id="receiveUpdateForm">
        @csrf
        <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr class="table-light">
                        <th>SL</th>
                        <th>PRODUCT DETAILS</th>
                        <th class="text-center">PURCHASE QTY</th>
                        <th class="text-center">RECEIVED</th>
                        <th class="text-center">REMAINING</th>
                        <th class="text-center" style="width: 150px;">RECEIVE NOW</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchase->get_purchase_items as $key => $item)
                        @php
                            $remaining = $item->ordered_quantity - ($item->received_quantity ?? 0);
                        @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <span class="fw-bold">{{ $item->get_product->name ?? 'Product' }}</span>
                                @if ($item->sku)
                                    <br><span class="badge bg-info" style="font-size: 10px;">{{ $item->sku }}</span>
                                @endif
                            </td>
                            <td class="text-center fw-bold">{{ $item->ordered_quantity }}</td>
                            <td class="text-center"><span
                                    class="badge bg-success text-white">{{ $item->received_quantity ?? 0 }}</span></td>
                            <td class="text-center"><span class="badge bg-danger text-white">{{ $remaining }}</span>
                            </td>
                            <td class="text-center">
                                <div class="input-group input-group-sm">
                                    <input type="number" name="items[{{ $item->id }}]"
                                        class="form-control receive-now-input text-center" value="{{ $remaining }}"
                                        max="{{ $remaining }}" min="0" data-remaining="{{ $remaining }}">
                                    <button class="btn btn-outline-secondary btn-max" type="button">Max</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>
</div>
<div class="modal-footer">
    {{-- <button type="button" class="btn btn-secondary  btn-sm" data-bs-dismiss="modal">Close</button> --}}
    <button type="button" class="btn btn-success btn-sm" id="btnReceiveUpdate">
        <i class="ti ti-check"></i> Receive Update
    </button>
</div>
