<table>
    <thead>
    <tr>
        <th>ItemType</th>
        <th>StoreName</th>
        <th>MerchantOrderId</th>
        <th>RecipientName(*)</th>
        <th>RecipientPhone(*)</th>
        <th>RecipientAddress(*)</th>
        <th>RecipientCity(*)</th>
        <th>RecipientZone(*)</th>
        <th>RecipientArea</th>
        <th>AmountToCollect(*)</th>
        <th>ItemQuantity</th>
        <th>ItemWeight</th>
        <th>ItemDesc</th>
        <th>SpecialInstruction</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $item)
        <tr>
            <td>parcel</td>
            <td></td>
            <td>{{ $item->invoice_id }}</td>
            <td>{{ $item->customer_name }}</td>
            <td>{{ $item->customer_phone }}</td>
            <td>{{ $item->customer_address }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $item->total }}</td>
            <td>{{ $item->get_products()->sum('qty') }}</td>
            <td>0.5</td>
            <td>
                @foreach($item->get_products as $key => $prod)
                    @if($key!=0)
                        <br>
                    @endif
                    {{ $prod->get_product->name }}
                @endforeach
            </td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>
