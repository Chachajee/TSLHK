<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_no }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #1a202c;
            background: #f7fafc;
        }

        .container {
            max-width: 100%;
            margin: 0;
            background: white;
        }

        /* Header Section */
        .header {
            background: #667eea;
            color: white;
            padding: 30px;
            margin-bottom: 20px;
        }

        .header-content {
            width: 100%;
            display: table;
        }

        .company-info {
            display: table-cell;
            width: 60%;
            vertical-align: top;
        }

        .invoice-header {
            display: table-cell;
            width: 40%;
            vertical-align: top;
            text-align: right;
        }

        .company-logo-section {
            margin-bottom: 15px;
        }

        .company-logo {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            display: inline-block;
            vertical-align: top;
            margin-right: 15px;
            text-align: center;
            line-height: 60px;
        }

        .company-logo img {
            max-width: 50px;
            max-height: 50px;
            vertical-align: middle;
        }

        .company-details {
            display: inline-block;
            vertical-align: top;
            margin-top: 5px;
        }

        .company-details h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .company-tagline {
            font-size: 14px;
            margin-bottom: 8px;
        }

        .company-address {
            font-size: 12px;
            line-height: 1.4;
        }

        .invoice-title {
            font-size: 42px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .invoice-number {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 12px;
            border-radius: 4px;
            display: inline-block;
        }

        .invoice-date {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-paid {
            background: #48bb78;
            color: white;
        }

        .status-unpaid {
            background: #f56565;
            color: white;
        }

        .status-partial {
            background: #ed8936;
            color: white;
        }

        /* Main Content */
        .content {
            padding: 20px 30px;
        }

        .content-row {
            width: 100%;
            display: table;
            margin-bottom: 20px;
        }

        .left-column {
            display: table-cell;
            width: 60%;
            vertical-align: top;
            padding-right: 20px;
        }

        .right-column {
            display: table-cell;
            width: 40%;
            vertical-align: top;
        }

        /* Address Sections */
        .address-section {
            margin-bottom: 20px;
            padding: 20px;
            background: #f7fafc;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }

        .address-title {
            font-size: 16px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        .address-company-name {
            font-weight: bold;
            color: #1a202c;
            margin-bottom: 8px;
            font-size: 16px;
        }

        .address-details {
            color: #4a5568;
            margin-bottom: 12px;
            line-height: 1.5;
            font-size: 14px;
        }

        .contact-info {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #718096;
        }

        .contact-row {
            margin-bottom: 4px;
            padding: 2px 0;
        }

        .contact-row table {
            width: 100%;
        }

        .contact-label {
            font-weight: bold;
            color: #2d3748;
        }

        /* Invoice Details */
        .invoice-details {
            background: #edf2f7;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .details-title {
            font-size: 16px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .detail-item {
            margin-bottom: 8px;
            padding: 6px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .detail-item table {
            width: 100%;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: bold;
            color: #4a5568;
            font-size: 12px;
        }

        .detail-value {
            color: #1a202c;
            font-weight: bold;
            font-size: 12px;
            text-align: right;
        }

        /* Items Table */
        .items-section {
            margin-bottom: 30px;
        }

        .items-title {
            font-size: 18px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .items-table th {
            background: #667eea;
            color: white;
            font-weight: bold;
            padding: 12px 8px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            border-bottom: 1px solid #e2e8f0;
        }

        .items-table td {
            padding: 12px 8px;
            border-bottom: 1px solid #f7fafc;
            font-size: 12px;
            background: white;
        }

        .items-table tr:nth-child(even) td {
            background: #f7fafc;
        }

        .items-table tr:last-child td {
            border-bottom: none;
        }

        .items-table .text-center {
            text-align: center;
        }

        .items-table .text-right {
            text-align: right;
        }

        .items-table .amount {
            font-weight: bold;
            color: #667eea;
        }

        .totals-row {
            background: #f7fafc;
            border-top: 2px solid #667eea;
        }

        .totals-label {
            font-weight: bold;
            color: #2d3748;
            font-size: 13px;
        }

        .totals-quantity {
            font-weight: bold;
            color: #667eea;
            font-size: 13px;
        }

        .totals-rate {
            font-weight: bold;
            color: #667eea;
            font-size: 13px;
        }

        .totals-amount {
            font-weight: bold;
            color: #667eea;
            font-size: 13px;
        }

        .no-items {
            text-align: center;
            color: #718096;
            font-style: italic;
            padding: 30px;
        }

        /* Totals Section */
        .totals-section {
            text-align: right;
            margin-bottom: 30px;
        }

        .totals-table {
            width: 350px;
            margin-left: auto;
            border-collapse: collapse;
            background: #f7fafc;
            border-radius: 8px;
            overflow: hidden;
        }

        .totals-table td {
            padding: 10px 15px;
            border: none;
            font-size: 14px;
        }

        .totals-table .label {
            font-weight: bold;
            color: #4a5568;
            text-align: left;
        }

        .totals-table .value {
            text-align: right;
            font-weight: bold;
            color: #1a202c;
        }

        .totals-table .subtotal-row {
            border-top: 1px solid #e2e8f0;
        }

        .totals-table .total-row {
            border-top: 2px solid #667eea;
            font-size: 16px;
            font-weight: bold;
            background: #667eea;
            color: white;
        }

        .totals-table .total-row .label,
        .totals-table .total-row .value {
            color: white;
        }

        .totals-table .balance-row {
            background: #f56565;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }

        .totals-table .balance-row .label,
        .totals-table .balance-row .value {
            color: white;
        }

        /* Payment Section */
        .payment-section {
            background: #f0fff4;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #48bb78;
        }

        .payment-title {
            font-size: 18px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .payment-grid {
            width: 100%;
        }

        .payment-row {
            width: 100%;
            display: table;
            margin-bottom: 10px;
        }

        .payment-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 10px;
        }

        .payment-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-left: 10px;
        }

        .payment-item {
            margin-bottom: 8px;
            padding: 8px 0;
            border-bottom: 1px solid rgba(72, 187, 120, 0.2);
        }

        .payment-item table {
            width: 100%;
        }

        .payment-label {
            font-weight: bold;
            color: #4a5568;
            font-size: 12px;
        }

        .payment-value {
            color: #1a202c;
            font-weight: bold;
            font-size: 13px;
            text-align: right;
        }

        /* Notes Section */
        .notes-section {
            background: #fffaf0;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #ed8936;
            margin-bottom: 30px;
        }

        .notes-title {
            font-size: 16px;
            font-weight: bold;
            color: #744210;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        .notes-content {
            font-style: italic;
            color: #744210;
            line-height: 1.5;
            font-size: 13px;
        }

        /* Footer */
        .footer {
            background: #2d3748;
            color: white;
            padding: 20px 30px;
            text-align: center;
            margin-top: 20px;
        }

        .footer-content {
            width: 100%;
            display: table;
            font-size: 12px;
        }

        .footer-left {
            display: table-cell;
            width: 33.33%;
            text-align: left;
            vertical-align: top;
        }

        .footer-center {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            vertical-align: top;
        }

        .footer-right {
            display: table-cell;
            width: 33.33%;
            text-align: right;
            vertical-align: top;
        }

        .footer-logo {
            width: 40px;
            height: 40px;
            margin-bottom: 8px;
        }

        .footer-logo img {
            max-width: 40px;
            max-height: 40px;
        }

        .footer-company {
            font-weight: bold;
            color: white;
            margin-bottom: 4px;
            font-size: 12px;
        }

        .footer-tagline {
            font-style: italic;
        }

        .footer-generated {
            color: #a0aec0;
        }

        .footer-thank-you {
            font-size: 14px;
            font-weight: bold;
            color: white;
            margin-bottom: 6px;
        }

        /* Page Break */
        .page-break {
            page-break-before: always;
        }

        /* Print optimizations */
        @page {
            margin: 0.5in;
        }

        @media print {
            body {
                background: white;
                margin: 0;
                padding: 0;
            }

            .container {
                margin: 0;
                padding: 0;
            }

            .header {
                background: #667eea !important;
                -webkit-print-color-adjust: exact;
            }

            .totals-table .total-row {
                background: #667eea !important;
                -webkit-print-color-adjust: exact;
            }

            .totals-table .balance-row {
                background: #f56565 !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <div class="company-info">
                    <div class="company-logo-section">
                        <div class="company-logo">
                            <img src="https://tslhk.com/assets/img/logo.png" alt="TSLHK Logo"
                                style="max-width: 100%; height: auto;">
                        </div>
                        <div class="company-details">
                            <h1>TOTAL SUPPORT LIMITED</h1>
                            <div class="company-tagline">YOUR ONE STOP SOLUTION</div>
                            <div class="company-address">
                                1/F MAU LAM COMM 16-18 MAU LAM ST JORDAN HONG KONG<br>
                                Phone: +852 56445012 | Email: tslhk2023@gmail.com<br>
                                Website: www.tslhk.com
                            </div>
                        </div>
                    </div>
                </div>

                <div class="invoice-header">
                    <div class="invoice-title">Invoice</div>
                    <div class="invoice-number">#{{ $invoice->invoice_no }}</div>
                    <div class="invoice-date">
                        {{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('F d, Y') : 'N/A' }}
                    </div>
                    <div style="margin-top: 10px;">
                        <span
                            class="status-badge status-{{ $invoice->balance_due > 0 ? ($invoice->paid > 0 ? 'partial' : 'unpaid') : 'paid' }}">
                            {{ $invoice->balance_due > 0 ? ($invoice->paid > 0 ? 'Partial' : 'Unpaid') : 'Paid' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="content-row">
                <div class="left-column">
                    <!-- Bill To -->
                    <div class="address-section">
                        <div class="address-title">Bill To</div>
                        <div class="address-content">
                            <div class="address-company-name">{{ $billTo->company_name ?? 'N/A' }}</div>
                            <div class="address-details">{{ $billTo->address ?? 'N/A' }}</div>
                            <div class="contact-info">
                                <div class="contact-row">
                                    <table>
                                        <tr>
                                            <td class="contact-label">VAT:</td>
                                            <td style="text-align: right;">{{ $billTo->vat_no ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="contact-row">
                                    <table>
                                        <tr>
                                            <td class="contact-label">EORI:</td>
                                            <td style="text-align: right;">{{ $billTo->eori ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="contact-row">
                                    <table>
                                        <tr>
                                            <td class="contact-label">Phone:</td>
                                            <td style="text-align: right;">{{ $billTo->phone ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="contact-row">
                                    <table>
                                        <tr>
                                            <td class="contact-label">Email:</td>
                                            <td style="text-align: right;">{{ $billTo->email ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ship To -->
                    <div class="address-section">
                        <div class="address-title">Ship To</div>
                        <div class="address-content">
                            <div class="address-company-name">{{ $shipTo->company_name ?? 'N/A' }}</div>
                            <div class="address-details">{{ $shipTo->address ?? 'N/A' }}</div>
                            <div class="contact-info">
                                <div class="contact-row">
                                    <table>
                                        <tr>
                                            <td class="contact-label">VAT:</td>
                                            <td style="text-align: right;">{{ $shipTo->vat_no ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="contact-row">
                                    <table>
                                        <tr>
                                            <td class="contact-label">EORI:</td>
                                            <td style="text-align: right;">{{ $shipTo->eori ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="contact-row">
                                    <table>
                                        <tr>
                                            <td class="contact-label">Phone:</td>
                                            <td style="text-align: right;">{{ $shipTo->phone ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="contact-row">
                                    <table>
                                        <tr>
                                            <td class="contact-label">Email:</td>
                                            <td style="text-align: right;">{{ $shipTo->email ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="right-column">
                    <!-- Invoice Details -->
                    <div class="invoice-details">
                        <div class="details-title">Invoice Details</div>
                        <div class="details-grid">
                            <div class="detail-item">
                                <table>
                                    <tr>
                                        <td class="detail-label">Order ID:</td>
                                        <td class="detail-value">{{ $invoice->order_id ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="detail-item">
                                <table>
                                    <tr>
                                        <td class="detail-label">Date:</td>
                                        <td class="detail-value">
                                            {{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') : 'N/A' }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            @if($invoice->ship_via)
                            <div class="detail-item">
                                <table>
                                    <tr>
                                        <td class="detail-label">Ship Via:</td>
                                        <td class="detail-value">{{ $invoice->ship_via }}</td>
                                    </tr>
                                </table>
                            </div>
                            @endif
                            @if($invoice->tracking_no)
                            <div class="detail-item">
                                <table>
                                    <tr>
                                        <td class="detail-label">Tracking:</td>
                                        <td class="detail-value">{{ $invoice->tracking_no }}</td>
                                    </tr>
                                </table>
                            </div>
                            @endif
                            <div class="detail-item">
                                <table>
                                    <tr>
                                        <td class="detail-label">Tax ID:</td>
                                        <td class="detail-value">{{ $invoice->tax_id ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice Items -->
            <div class="items-section">
                <div class="items-title">Invoice Items</div>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-right">Rate</th>
                            <th class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($items && count($items) > 0)
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->description ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $item->quantity ?? 0 }}</td>
                                    <td class="text-right">US${{ number_format($item->rate ?? 0, 2) }}</td>
                                    <td class="text-right amount">US${{ number_format($item->amount ?? 0, 2) }}</td>
                                </tr>
                            @endforeach
                            @if(count($items) > 1)
                                <!-- Totals Row -->
                                <tr class="totals-row">
                                    <td class="totals-label"><strong>Totals:</strong></td>
                                    <td class="text-center totals-quantity"><strong>{{ $items->sum('quantity') ?? 0 }}</strong></td>
                                    <td class="text-right totals-rate"><strong>US${{ number_format($items->avg('rate') ?? 0, 2) }}</strong></td>
                                    <td class="text-right totals-amount"><strong>US${{ number_format($items->sum('amount') ?? 0, 2) }}</strong></td>
                                </tr>
                            @endif
                        @else
                            <tr>
                                <td colspan="4" class="no-items">No items found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Totals -->
            <div class="totals-section">
                <table class="totals-table">
                    <tr>
                        <td class="label">Subtotal:</td>
                        <td class="value">US${{ number_format($invoice->subtotal ?? 0, 2) }}</td>
                    </tr>
                    <tr class="subtotal-row">
                        <td class="label">Shipping:</td>
                        <td class="value">US${{ number_format($invoice->shipping ?? 0, 2) }}</td>
                    </tr>
                    <tr class="total-row">
                        <td class="label">Total:</td>
                        <td class="value">US${{ number_format($invoice->total ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="label">Paid:</td>
                        <td class="value">US${{ number_format($invoice->paid ?? 0, 2) }}</td>
                    </tr>
                    <tr class="{{ $invoice->balance_due > 0 ? 'balance-row' : 'total-row' }}">
                        <td class="label">Balance Due:</td>
                        <td class="value">US${{ number_format($invoice->balance_due ?? 0, 2) }}</td>
                    </tr>
                </table>
            </div>

            <!-- Payment Instructions -->
            @if($paymentInstructions)
                <div class="payment-section">
                    <div class="payment-title">Payment Instructions</div>
                    <div class="payment-grid">
                        <div class="payment-row">
                            <div class="payment-left">
                                <div class="payment-item">
                                    <table>
                                        <tr>
                                            <td class="payment-label">Bank Name:</td>
                                            <td class="payment-value">{{ $paymentInstructions->bank_name ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="payment-item">
                                    <table>
                                        <tr>
                                            <td class="payment-label">SWIFT/BIC:</td>
                                            <td class="payment-value">{{ $paymentInstructions->swift_bic ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="payment-item">
                                    <table>
                                        <tr>
                                            <td class="payment-label">Account Name:</td>
                                            <td class="payment-value">
                                                {{ $paymentInstructions->account_name ?? 'TOTAL SUPPORT LIMITED' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="payment-right">
                                <div class="payment-item">
                                    <table>
                                        <tr>
                                            <td class="payment-label">Bank Code:</td>
                                            <td class="payment-value">{{ $paymentInstructions->bank_code ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="payment-item">
                                    <table>
                                        <tr>
                                            <td class="payment-label">Account No:</td>
                                            <td class="payment-value">
                                                {{ $paymentInstructions->multi_currency_ac_no ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="payment-item">
                                    <table>
                                        <tr>
                                            <td class="payment-label">Bank Address:</td>
                                            <td class="payment-value">{{ $paymentInstructions->bank_address ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Notes -->
            @if($invoice->notes)
                <div class="notes-section">
                    <div class="notes-title">Notes</div>
                    <div class="notes-content">{{ $invoice->notes }}</div>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-content">
                <div class="footer-left">
                    <div class="footer-logo">
                        <img src="https://tslhk.com/assets/img/logo.png" alt="TSLHK Logo"
                            style="max-width: 100%; height: auto;">
                    </div>
                    <div class="footer-company">TOTAL SUPPORT LIMITED</div>
                    <div class="footer-tagline">YOUR ONE STOP SOLUTION</div>
                </div>
                <div class="footer-center">
                    <div class="footer-thank-you">Thank you for your business!</div>
                </div>
                <div class="footer-right">
                    <div class="footer-generated">Generated on {{ now()->format('M d, Y \a\t g:i A') }}</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>