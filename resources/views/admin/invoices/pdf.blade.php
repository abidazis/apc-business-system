@php
    $bizName = \App\Support\Settings::get('business_name');
    $bizShort = \App\Support\Settings::get('business_short');
    $address = \App\Support\Settings::get('address');
    $phone = \App\Support\Settings::get('phone');
    $email = \App\Support\Settings::get('email');
    $ig = \App\Support\Settings::get('instagram');
    $bankName = \App\Support\Settings::get('bank_name');
    $bankAccName = \App\Support\Settings::get('bank_account_name');
    $bankAccNum = \App\Support\Settings::get('bank_account_number');
    $order = $invoice->order;
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #111; margin: 0; padding: 24px; }
        h1, h2, h3 { margin: 0; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 3px solid #C1272D; padding-bottom: 16px; margin-bottom: 24px; }
        .brand h2 { color: #C1272D; font-size: 22px; }
        .brand p { font-size: 11px; color: #555; margin: 2px 0; }
        .invoice-meta { text-align: right; }
        .invoice-meta h1 { font-size: 22px; color: #C1272D; }
        .invoice-meta p { margin: 2px 0; font-size: 11px; }
        .customer { margin-bottom: 24px; }
        .customer h3 { font-size: 13px; margin-bottom: 4px; color: #555; text-transform: uppercase; letter-spacing: .05em; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        th { background: #F3F4F6; color: #111; padding: 8px; text-align: left; border-bottom: 2px solid #C1272D; font-size: 11px; text-transform: uppercase; letter-spacing: .03em; }
        td { padding: 8px; border-bottom: 1px solid #E5E7EB; }
        .text-end { text-align: right; }
        .totals { width: 320px; margin-left: auto; }
        .totals td { border: none; padding: 4px 8px; }
        .totals .grand td { font-weight: bold; font-size: 14px; border-top: 2px solid #C1272D; padding-top: 8px; }
        .footer { margin-top: 32px; border-top: 1px solid #E5E7EB; padding-top: 16px; font-size: 11px; color: #555; }
        .footer .row { display: flex; justify-content: space-between; }
    </style>
</head>
<body>
    <div class="header">
        <div class="brand">
            <h2>{{ $bizShort }}</h2>
            <p><strong>{{ $bizName }}</strong></p>
            @if($address)<p>{{ $address }}</p>@endif
            @if($phone)<p>Telp: {{ $phone }}</p>@endif
            @if($email)<p>{{ $email }}</p>@endif
            @if($ig)<p>IG: @ {{ $ig }}</p>@endif
        </div>
        <div class="invoice-meta">
            <h1>INVOICE</h1>
            <p><strong>{{ $invoice->invoice_number }}</strong></p>
            <p>Tanggal: {{ \App\Services\Formatter::dateId($invoice->issue_date) }}</p>
            @if($invoice->due_date)<p>Jatuh Tempo: {{ \App\Services\Formatter::dateId($invoice->due_date) }}</p>@endif
            <p>Order: {{ $order->order_number }}</p>
        </div>
    </div>

    <div class="customer">
        <h3>Customer</h3>
        <p style="font-size: 13px;">
            <strong>{{ $invoice->customer->name }}</strong><br>
            @if($invoice->customer->organization){{ $invoice->customer->organization }}<br>@endif
            @if($invoice->customer->phone){{ $invoice->customer->phone }}<br>@endif
            @if($invoice->customer->address){!! nl2br(e($invoice->customer->address)) !!}@endif
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th class="text-end" style="width: 60px;">Qty</th>
                <th class="text-end" style="width: 110px;">Harga</th>
                <th class="text-end" style="width: 120px;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $it)
                <tr>
                    <td>{{ $it->description }}</td>
                    <td class="text-end">{{ $it->quantity }}</td>
                    <td class="text-end">{{ \App\Services\Formatter::money($it->unit_price) }}</td>
                    <td class="text-end">{{ \App\Services\Formatter::money($it->subtotal) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @php
        $paid = (float) $order->payments->sum('amount');
        $outstanding = max(0, (float) $invoice->total - $paid);
    @endphp

    <table class="totals">
        <tr><td>Subtotal</td><td class="text-end">{{ \App\Services\Formatter::money($invoice->subtotal) }}</td></tr>
        <tr><td>Discount</td><td class="text-end">{{ \App\Services\Formatter::money($invoice->discount) }}</td></tr>
        <tr><td>Shipping</td><td class="text-end">{{ \App\Services\Formatter::money($invoice->shipping_cost) }}</td></tr>
        <tr class="grand"><td>TOTAL</td><td class="text-end">{{ \App\Services\Formatter::money($invoice->total) }}</td></tr>
        <tr><td>Terbayar</td><td class="text-end">{{ \App\Services\Formatter::money($paid) }}</td></tr>
        <tr><td><strong>Outstanding</strong></td><td class="text-end"><strong>{{ \App\Services\Formatter::money($outstanding) }}</strong></td></tr>
    </table>

    @if($bankName || $bankAccNum)
        <div style="margin-top: 24px; padding: 12px; background: #F9FAFB; border-radius: 4px;">
            <strong style="color: #C1272D;">Informasi Pembayaran</strong><br>
            @if($bankName)Bank: {{ $bankName }}<br>@endif
            @if($bankAccName)a.n. {{ $bankAccName }}<br>@endif
            @if($bankAccNum)No. Rekening: <strong>{{ $bankAccNum }}</strong>@endif
        </div>
    @endif

    @if($invoice->notes)
        <div style="margin-top: 16px; font-size: 11px;">
            <strong>Catatan:</strong><br>
            {!! nl2br(e($invoice->notes)) !!}
        </div>
    @endif

    <div class="footer">
        <p>{{ \App\Support\Settings::get('footer_note') }}</p>
    </div>
</body>
</html>