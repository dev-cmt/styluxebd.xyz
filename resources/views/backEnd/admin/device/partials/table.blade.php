@include('backEnd.admin.includes.top-paginate', ['items' => $data])
{{-- @dd($data) --}}
<table class="table align-top card-table datatable">
    <thead>
        <tr class="align-middle">
            <th class="w-1">
                SL. <input class="form-check-input m-0 align-middle" type="checkbox" id="master">
            </th>
            <th>Customer Infos</th>
            <th>Device Infos</th>
            <th>Total Order</th>
            <th width="10%">Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="device_table_body">
        @php($i = $data->firstItem() ?? 1)
        @if ($data->count() > 0)
            @foreach ($data as $item)
                <tr id="tr_{{ $item->id }}"
                    @if ($loop->even) style="background-color:#f5f5f5" @endif>
                    <td class="sl-cell">
                        {{ $i++ }}.
                        <input class="form-check-input m-0 align-middle sub_chk" type="checkbox"
                            data-id="{{ $item->id }}">
                    </td>
                    <td>
                        <span><strong>Name:</strong> {{ $item->user ? $item->user->name : '' }}</span> <br>
                        <span><strong>Email:</strong> {{ $item->user ? $item->user->email : '' }}</span> <br>
                        <span><strong>Phone:</strong> {{ $item->user ? $item->user->phone : '' }}</span> <br>
                        <span><strong>Address:</strong> {{ $item->user ? $item->user->address : '' }}</span>
                    </td>
                    <td>
                        <span><strong>Device Name:</strong> {{ $item->device_name }}</span> <br>
                        <span><strong>Device Id:</strong> {{ $item->device_id }}</span>
                    </td>
                    <td>
                        @php($total_order = $item->user ? $item->user->get_orders->count() ?? 0 : 0)
                        <span class="badge bg-success me-2">{{ $total_order }}</span>
                    </td>
                    <td>
                        @if ($item->status == 1)
                            <a href="{{ route('admin.customer.device.status', [$item->id, 0]) }}"
                                onclick="return confirm('Are you sure want to change this status?')">
                                <span class="badge bg-success">Unblocked</span>
                            </a>
                        @else
                            <a href="{{ route('admin.customer.device.status', [$item->id, 1]) }}"
                                onclick="return confirm('Are you sure want to change this status?')">
                                <span class="badge bg-danger">Blocked</span>
                            </a>
                        @endif
                    </td>
                    <td class="w-1">
                        <form action="{{ route('admin.customer.delete', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn-gradient-danger padding-2-6 border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1"
                                onclick="return confirm('Are you sure want to delete this?')">
                                <i class="ti ti-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6" class="text-center text-danger font-weight-bold py-3">No Data Found!</td>
            </tr>
        @endif
    </tbody>
</table>

@include('backEnd.admin.includes.bottom-paginate', ['items' => $data])
