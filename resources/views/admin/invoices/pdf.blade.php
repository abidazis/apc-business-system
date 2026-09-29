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
    $footerNote = \App\Support\Settings::get('footer_note');
    $whatsapp = \App\Support\Settings::get('whatsapp');

    // Format WA number display
    $waDisplay = $whatsapp ? '0' . substr($whatsapp, 2) : '';

    $order = $invoice->order;

    // Calculate totals
    $subtotal = (float) $order->items->sum('subtotal');
    $discount = (float) $invoice->discount;
    $shipping = (float) $invoice->shipping_cost;
    $total = (float) $invoice->total;
    $paid = (float) $order->payments->sum('amount');
    $outstanding = max(0, $total - $paid);
    $totalQty = (float) $order->items->sum('quantity');
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $invoice->invoice_number }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #111;
            line-height: 1.4;
            padding: 0;
        }

        /* Top Contact Bar */
        .top-bar {
            background: #111;
            color: #fff;
            padding: 8px 50px;
            display: flex;
            justify-content: flex-end;
            gap: 30px;
            font-size: 11px;
        }
        .top-bar span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Main Container */
        .container {
            padding: 30px 50px;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Invoice Title Section */
        .invoice-header {
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 4px solid #FFC600;
        }
        .invoice-title {
            font-size: 42px;
            font-weight: 900;
            color: #111;
            letter-spacing: 0.15em;
            line-height: 1;
        }
        .invoice-subtitle {
            font-size: 13px;
            color: #555;
            margin-top: 6px;
        }
        .invoice-subtitle strong {
            color: #111;
            font-size: 14px;
        }

        /* Info Grid */
        .info-section {
            margin-bottom: 20px;
        }
        .info-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        .info-row {
            display: table-row;
        }
        .info-cell {
            display: table-cell;
            width: 50%;
            padding: 10px 12px;
            vertical-align: top;
        }
        .info-cell:first-child {
            background: #f5f5f5;
            border-radius: 6px 0 0 6px;
        }
        .info-cell:last-child {
            background: #f5f5f5;
            border-radius: 0 6px 6px 0;
        }

        .info-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #888;
            margin-bottom: 4px;
        }
        .info-value {
            font-size: 13px;
            font-weight: 700;
            color: #111;
        }
        .info-value.small {
            font-size: 11px;
            font-weight: 400;
            color: #555;
            margin-top: 2px;
        }
        .info-value.address {
            font-size: 11px;
            font-weight: 400;
            color: #444;
            line-height: 1.5;
            white-space: pre-line;
        }

        /* Invoice Details Row */
        .invoice-details {
            display: flex;
            gap: 40px;
            margin-bottom: 20px;
            padding: 14px 16px;
            background: #f9f9f9;
            border-radius: 6px;
            border-left: 3px solid #FFC600;
        }
        .detail-box {
            display: flex;
            flex-direction: column;
        }
        .detail-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #888;
        }
        .detail-value {
            font-size: 13px;
            font-weight: 600;
            color: #111;
        }
        .detail-value.highlight {
            font-size: 16px;
            font-weight: 800;
            color: #FFC600;
            background: #111;
            padding: 4px 12px;
            border-radius: 4px;
            margin-top: 2px;
            display: inline-block;
        }

        /* Invoice Table */
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
            font-size: 11px;
        }
        .invoice-table thead {
            background: #111;
            color: #fff;
        }
        .invoice-table th {
            padding: 10px 12px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 600;
        }
        .invoice-table th:nth-child(2),
        .invoice-table th:nth-child(3),
        .invoice-table th:nth-child(4) {
            text-align: right;
        }
        .invoice-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
        }
        .invoice-table td:nth-child(2),
        .invoice-table td:nth-child(3),
        .invoice-table td:nth-child(4) {
            text-align: right;
            font-family: 'Courier New', monospace;
        }
        .invoice-table tbody tr:nth-child(even) {
            background: #fafafa;
        }

        /* Table Footer - Total Row */
        .invoice-table tfoot {
            background: #f0f0f0;
        }
        .invoice-table tfoot td {
            padding: 10px 12px;
            font-weight: 600;
            border-bottom: none;
        }
        .invoice-table tfoot td:nth-child(2),
        .invoice-table tfoot td:nth-child(3),
        .invoice-table tfoot td:nth-child(4) {
            text-align: right;
            font-family: 'Courier New', monospace;
        }
        .invoice-table tfoot td:nth-child(1) {
            text-align: right;
            font-weight: 700;
        }

        /* Summary Section */
        .summary-section {
            display: flex;
            justify-content: flex-end;
            margin: 16px 0 20px;
        }
        .summary-box {
            width: 300px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 14px;
            font-size: 12px;
            border-bottom: 1px solid #eee;
        }
        .summary-row.total {
            background: #111;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            border-radius: 6px 6px 0 0;
        }
        .summary-row.dp {
            background: #e8f5e9;
            color: #2e7d32;
        }
        .summary-row.balance {
            background: #fff8e1;
            color: #f57f17;
            border-radius: 0 0 6px 6px;
            font-weight: 700;
        }
        .summary-row .amount {
            font-family: 'Courier New', monospace;
            font-weight: 600;
        }

        /* Payment Instructions */
        .payment-box {
            background: #111;
            color: #fff;
            padding: 18px 22px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .payment-title {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #FFC600;
            margin-bottom: 12px;
        }
        .payment-grid {
            display: flex;
            gap: 30px;
        }
        .payment-item {
            display: flex;
            flex-direction: column;
        }
        .payment-item label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #888;
            margin-bottom: 2px;
        }
        .payment-item span {
            font-size: 12px;
        }
        .payment-item .account-number {
            font-size: 16px;
            font-weight: 700;
            color: #FFC600;
            font-family: 'Courier New', monospace;
            letter-spacing: 0.05em;
        }

        /* Notes */
        .notes-box {
            background: #f9f9f9;
            padding: 14px 16px;
            border-radius: 6px;
            margin-bottom: 24px;
            font-size: 11px;
            color: #555;
            border-left: 3px solid #FFC600;
        }
        .notes-box strong {
            color: #111;
            display: block;
            margin-bottom: 4px;
        }

        /* Signature Section */
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }
        .signature-box {
            width: 180px;
            text-align: center;
        }
        .signature-date {
            font-size: 11px;
            color: #666;
            margin-bottom: 50px;
        }
        .signature-line {
            border-bottom: 1px solid #333;
            margin-bottom: 4px;
        }
        .signature-name {
            font-size: 12px;
            font-weight: 600;
            color: #111;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .footer p {
            font-size: 10px;
            color: #888;
            font-style: italic;
        }
    </style>
</head>
<body>
    {{-- Top Contact Bar --}}
    <div class="top-bar">
        @if($ig)
        <span>IG: @{{ $ig }}</span>
        @endif
        @if($waDisplay)
        <span>WA: {{ $waDisplay }}</span>
        @endif
    </div>

    {{-- Main Container --}}
    <div class="container">

        {{-- Invoice Header --}}
        <div class="invoice-header">
            <div class="invoice-title">INVOICE</div>
            <div class="invoice-subtitle">
                <strong>{{ $invoice->invoice_number }}</strong>
            </div>
        </div>

        {{-- From / Bill To Section --}}
        <div class="info-section">
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">From</div>
                        <div class="info-value">{{ $bizName }}</div>
                        <div class="info-value small">By Ganapatra Group</div>
                        @if($address)
                        <div class="info-value address">{{ $address }}</div>
                        @endif
                        @if($phone)
                        <div class="info-value small">{{ $phone }}</div>
                        @endif
                        @if($email)
                        <div class="info-value small">{{ $email }}</div>
                        @endif
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Bill To</div>
                        <div class="info-value">{{ $invoice->customer->name }}</div>
                        @if($invoice->customer->organization)
                        <div class="info-value small">{{ $invoice->customer->organization }}</div>
                        @endif
                        @if($invoice->customer->address)
                        <div class="info-value address">{{ $invoice->customer->address }}</div>
                        @endif
                        @if($invoice->customer->phone)
                        <div class="info-value small">{{ $invoice->customer->phone }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Invoice Details --}}
        <div class="invoice-details">
            <div class="detail-box">
                <span class="detail-label">Invoice Date</span>
                <span class="detail-value">{{ \App\Services\Formatter::dateId($invoice->issue_date) }}</span>
            </div>
            <div class="detail-box">
                <span class="detail-label">Order Number</span>
                <span class="detail-value">{{ $order->order_number }}</span>
            </div>
            <div class="detail-box">
                <span class="detail-label">Balance Due</span>
                <span class="detail-value highlight">{{ \App\Services\Formatter::money($outstanding) }}</span>
            </div>
        </div>

        {{-- Invoice Table --}}
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Rate</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ \App\Services\Formatter::money($item->unit_price) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ \App\Services\Formatter::money($item->subtotal) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong>{{ \App\Services\Formatter::money($subtotal) }}</strong></td>
                </tr>
            </tfoot>
        </table>

        {{-- Summary Section --}}
        <div class="summary-section">
            <div class="summary-box">
                @if($discount > 0)
                <div class="summary-row">
                    <span>Discount</span>
                    <span class="amount">- {{ \App\Services\Formatter::money($discount) }}</span>
                </div>
                @endif
                <div class="summary-row total">
                    <span>TOTAL</span>
                    <span>{{ \App\Services\Formatter::money($total) }}</span>
                </div>
                @if($paid > 0)
                <div class="summary-row dp">
                    <span>Down Payment</span>
                    <span class="amount">- {{ \App\Services\Formatter::money($paid) }}</span>
                </div>
                @endif
                <div class="summary-row balance">
                    <span>Balance Due</span>
                    <span class="amount">{{ \App\Services\Formatter::money($outstanding) }}</span>
                </div>
            </div>
        </div>

        {{-- Payment Instructions --}}
        @if($bankName || $bankAccNum)
        <div class="payment-box">
            <div class="payment-title">Payment Instructions</div>
            <div class="payment-grid">
                @if($bankName)
                <div class="payment-item">
                    <label>Bank Transfer</label>
                    <span>{{ $bankName }}</span>
                </div>
                @endif
                @if($bankAccName)
                <div class="payment-item">
                    <label>Account Name</label>
                    <span>{{ $bankAccName }}</span>
                </div>
                @endif
                @if($bankAccNum)
                <div class="payment-item">
                    <label>Account Number</label>
                    <span class="account-number">{{ $bankAccNum }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Notes --}}
        @if($footerNote)
        <div class="notes-box">
            <strong>Catatan:</strong>
            {{ $footerNote }}
        </div>
        @endif

        {{-- Signature Section --}}
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-date">{{ \App\Services\Formatter::dateId($invoice->issue_date) }}</div>
                <div class="signature-line"></div>
                <div class="signature-line"></div>
                <div class="signature-name">{{ $bizName }}</div>
            </div>
            <div class="signature-box">
                <div class="signature-date">{{ \App\Services\Formatter::dateId($invoice->issue_date) }}</div>
                <div class="signature-line"></div>
                <div class="signature-line"></div>
                <div class="signature-name">{{ $invoice->customer->name }}</div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>{{ $footerNote }}</p>
        </div>

    </div>
</body>
</html>
