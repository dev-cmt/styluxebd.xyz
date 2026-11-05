@include('backEnd.admin.includes.top-paginate', ['items' => $data])
<table class="table table-vcenter card-table">
    <thead>
        <tr class="align-middle">
            <th class="w-1">
                SL. <input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"
                    id="master">
            </th>
            <th>IP Address</th>
            <th>Total Order</th>
            <th>Status</th>
            <th style="width: 5%">Action</th>
        </tr>
    </thead>
    <tbody id="ip_address_table_body">
        @php($i = $data->firstItem() ?? 1)
        @if (count($data) > 0)
            @foreach ($data as $key => $item)
                <tr @if (($key + 1) % 2 == 0) style="background-color:#f5f5f5" @endif>
                    <td class="sl-cell">
                        {{ $i++ }}.
                        <input class="form-check-input m-0 align-middle sub_chk" type="checkbox"
                            data-id="{{ $item->id }}">
                    </td>
                    <td>{{ $item->ip_address }}</td>
                    <td>{{ $item->total_order }}</td>
                    <td>
                        @if ($item->status == 1)
                            <a href="{{ route('admin.ip.address.status', $item->id) }}"
                                onclick="return confirm('Are you sure want to block this?')"
                                class="badge bg-success">Unblocked</a>
                        @else
                            <a href="{{ route('admin.ip.address.status', $item->id) }}"
                                onclick="return confirm('Are you sure want to unblock this?')"
                                class="badge bg-danger">Blocked</a>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex">
                            @can('ip_address.delete')
                                <form action="{{ route('admin.ip.address.delete', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn-gradient-danger  padding-2-6 border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1"
                                        onclick="return confirm('Are you sure want to delete this?')"><i
                                            class="ti ti-trash"></i>
                                        Delete</button>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="10" class="text-center"> <span class="text-danger"><b>No data
                            found.</b></span></td>
            </tr>
        @endif
    </tbody>
</table>
<!-- Bottom Pagination Links -->
@include('backEnd.admin.includes.bottom-paginate', ['items' => $data])
