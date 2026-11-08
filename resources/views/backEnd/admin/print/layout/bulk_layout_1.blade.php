<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Invoice Print</title>

    <style>
        @page {
            size: A4;
            margin: 8mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            margin: 0;
            color: #111;
        }

        .sheet {
            width: 100%;
        }

        /* ===== INVOICE CARD ===== */
        .invoice {
            height: 500px;
            border: 1px solid #222;
            padding: 10px;
            margin-bottom: 8mm;
            box-sizing: border-box;
            position: relative;
        }

        /* CUT LINE */
        .invoice:after {
            content: "";
            position: absolute;
            bottom: -6mm;
            left: 0;
            width: 100%;
            border-bottom: 1px dashed #444;
        }

        /* ===== TOP BAR ===== */
        .top-bar {
            display: flex;
            align-items: flex-start;
            border-bottom: 2px solid #000;
            padding-bottom: 6px;
            margin-bottom: 6px;
        }

        .logo {
            width: 35%;
        }

        .logo img {
            max-height: 45px;
        }

        .company-info {
            font-size: 10px;
            margin-top: 4px;
            line-height: 1.3;
        }

        .invoice-title {
            width: 35%;
            text-align: center;
        }

        .invoice-title h2 {
            margin: 0;
            font-size: 18px;
            letter-spacing: 2px;
        }

        .invoice-meta {
            width: 30%;
            text-align: right;
            font-size: 10px;
        }

        /* ===== INFO BOX ===== */
        .info-row {
            display: flex;
            margin-top: 6px;
            gap: 6px;
        }

        .info-box {
            width: 50%;
            border: 1px solid #000;
            padding: 6px;
        }

        .info-box h4 {
            margin: 0 0 4px;
            font-size: 11px;
            border-bottom: 1px solid #000;
        }

        .info-box p {
            margin: 2px 0;
        }

        /* ===== TABLE ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
        }

        th {
            background: #eee;
            font-size: 11px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        /* ===== TOTAL BAR ===== */
        .total-bar {
            display: flex;
            justify-content: flex-end;
            margin-top: 6px;
            font-weight: bold;
            font-size: 12px;
        }

        /* ===== FOOTER ===== */
        .footer {
            position: absolute;
            bottom: 6px;
            left: 10px;
            right: 10px;
            display: flex;
            justify-content: space-between;
            font-size: 9px;
        }

        .barcode {
            margin-top: 3px;
        }
    </style>
</head>

<body>

    <div class="sheet">

        @foreach ($orders as $data)
            <div class="invoice">

                <!-- TOP BAR -->
                <div class="top-bar">
                    <div class="logo">
                        <img src="{{ isset($web_settings->get_header) ? asset($web_settings->get_header->file_url) : asset('images/logo.png') }}"
                            alt="">
                        <div class="company-info">
                            <strong>{{ $web_settings->website_name ?? config('app.name') }}</strong><br>
                            {{ $web_settings->website_address }}<br>
                            {{ $web_settings->website_phone }}
                        </div>
                    </div>

                    <div class="invoice-title">
                        <h2>INVOICE</h2>
                    </div>

                    <div class="invoice-meta">
                        <strong>#{{ $data->invoice_id }}</strong><br>
                        {{ date('d M Y', strtotime($data->order_date)) }}
                        <div class="barcode">
                            <img style="width: 120px" src="{{ asset('/') }}barcode.webp" alt="">
                            {{--                    {!! DNS1D::getBarcodeHTML($data->invoice_id,'C128',1.2,28) !!} --}}
                        </div>
                    </div>
                </div>

                <!-- INFO -->
                <div class="info-row">
                    <div class="info-box">
                        <h4>Customer Information</h4>
                        <p><strong>Name:</strong> {{ $data->customer_name }}</p>
                        <p><strong>Phone:</strong> {{ $data->customer_phone }}</p>
                        <p><strong>Address:</strong> {{ $data->customer_address }}</p>
                    </div>

                    <div class="info-box">
                        <h4>Company Information</h4>
                        <p>{{ $web_settings->website_name }}</p>
                        <p>{{ $web_settings->website_address }}</p>
                        <p>{{ $web_settings->website_phone }}</p>
                    </div>
                </div>

                <!-- PRODUCT TABLE -->
                <table>
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Item</th>
                            <th width="10%">Qty</th>
                            <th width="20%" class="text-right">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = 1)
                        @foreach ($data->get_products as $item)
                            <tr>
                                <td class="center">{{ $i++ }}</td>
                                <td>
                                    {{ $item->get_product->name }}<br>
                                    @if (!empty($item->attributes))
                                        <?php
                                        $ids = explode('-', $item->attributes);
                                        $attributes = $item->get_product
                                            ->get_variants()
                                            ->with('items')
                                            ->get()
                                            ->pluck('items') // সব variant এর items
                                            ->flatten()
                                            ->whereIn('attribute_item_id', $ids)
                                            ->unique('attribute_item_id');
                                        // dd($attributes);
                                        ?>
                                        @foreach ($attributes as $v_item)
                                            <?php
                                            $attrItem = $v_item->name;
                                            $attribute = $v_item->attribute;
                                            ?>
                                            @if ($loop->first)
                                            @else
                                                ,
                                            @endif
                                            <small class="text-primary mt-1">{{ $attribute->name }}
                                                : {{ $attrItem }}
                                            </small>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="center">{{ $item->qty }}</td>
                                <td class="right">{{ $web_settings->currency_sign }} {{ $item->price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- TOTAL -->
                <div class="total-bar">
                    Sub Total: {{ $web_settings->currency_sign }} {{ $data->sub_total }}
                </div>
                <div class="total-bar">
                    Delivery Cost (+) : {{ $web_settings->currency_sign }} {{ $data->shipping_cost }}
                </div>
                <div class="total-bar">
                    Discount (-) : {{ $web_settings->currency_sign }} {{ $data->discount }}
                </div>
                @if (!empty($data->coupon_discount) && $data->coupon_discount > 0)
                    <div class="total-bar">
                        Coupon Discount (-) : {{ $web_settings->currency_sign }} {{ $data->coupon_discount }}
                    </div>
                @endif
                <div class="total-bar">
                    Total: {{ $web_settings->currency_sign }} {{ $data->total }}
                </div>

                <!-- FOOTER -->
                <div class="footer">
                    <div>Courier: {{ isset($data->get_courier) ? $data->get_courier->courier_name : 'N/A' }}</div>
                    <div>Thank you for your business</div>
                </div>

            </div>
        @endforeach

    </div>

    <script>
        window.onload = function() {
            window.print();
            window.close();
        }
    </script>

</body>

</html>
