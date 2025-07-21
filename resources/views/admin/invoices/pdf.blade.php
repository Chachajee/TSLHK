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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #2c3e50;
            background: white;
        }

        .container {
            max-width: 850px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Section */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #1e3c72;
        }

        .company-info {
            flex: 1;
        }

        .company-logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }

        .company-logo {
            width: 60px;
            height: 60px;
            background: #1e3c72;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 20px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #1e3c72;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .company-tagline {
            font-size: 12px;
            color: #7f8c8d;
            font-style: italic;
        }

        .company-address {
            margin-top: 10px;
            font-size: 10px;
            color: #5a6c7d;
            line-height: 1.4;
        }

        .invoice-header {
            text-align: right;
            flex: 1;
        }

        .invoice-title {
            font-size: 32px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .invoice-number {
            font-size: 16px;
            color: #1e3c72;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .invoice-date {
            font-size: 12px;
            color: #7f8c8d;
            margin-bottom: 10px;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-paid {
            background: #27ae60;
            color: white;
        }

        .status-unpaid {
            background: #e74c3c;
            color: white;
        }

        .status-partial {
            background: #f39c12;
            color: white;
        }

        /* Main Content */
        .content {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
        }

        .left-column {
            flex: 2;
        }

        .right-column {
            flex: 1;
        }

        /* Address Sections */
        .address-section {
            margin-bottom: 25px;
            padding: 20px;
            background: #f8f9fa;
            border-left: 4px solid #1e3c72;
            border-radius: 8px;
        }

        .address-title {
            font-size: 14px;
            font-weight: bold;
            color: #1e3c72;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .address-content {
            font-size: 11px;
            line-height: 1.6;
        }

        .address-company-name {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .address-details {
            color: #5a6c7d;
            margin-bottom: 10px;
        }

        .contact-info {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #e9ecef;
            font-size: 10px;
            color: #7f8c8d;
        }

        .contact-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }

        .contact-label {
            font-weight: bold;
            color: #1e3c72;
        }

        /* Invoice Details */
        .invoice-details {
            background: #ecf0f1;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .details-title {
            font-size: 14px;
            font-weight: bold;
            color: #1e3c72;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 8px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid #d5d8dc;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: bold;
            color: #5a6c7d;
            font-size: 10px;
        }

        .detail-value {
            color: #2c3e50;
            font-weight: 600;
            font-size: 10px;
        }

        /* Items Table */
        .items-section {
            margin-bottom: 30px;
        }

        .items-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e3c72;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #bdc3c7;
            border-radius: 8px;
            overflow: hidden;
        }

        .items-table th {
            background: #1e3c72;
            color: white;
            font-weight: bold;
            padding: 15px 10px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #ecf0f1;
            font-size: 11px;
        }

        .items-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .items-table .text-center {
            text-align: center;
        }

        .items-table .text-right {
            text-align: right;
        }

        .items-table .amount {
            font-weight: bold;
            color: #1e3c72;
        }

        .no-items {
            text-align: center;
            color: #7f8c8d;
            font-style: italic;
            padding: 20px;
        }

        /* Totals Section */
        .totals-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }

        .totals-table {
            width: 350px;
            border-collapse: collapse;
            background: #f8f9fa;
            border-radius: 8px;
            overflow: hidden;
        }

        .totals-table td {
            padding: 12px 20px;
            border: none;
            font-size: 12px;
        }

        .totals-table .label {
            font-weight: bold;
            color: #5a6c7d;
            text-align: left;
        }

        .totals-table .value {
            text-align: right;
            font-weight: bold;
            color: #2c3e50;
        }

        .totals-table .subtotal-row {
            border-top: 1px solid #bdc3c7;
        }

        .totals-table .total-row {
            border-top: 2px solid #1e3c72;
            font-size: 14px;
            font-weight: bold;
            background: #1e3c72;
            color: white;
        }

        .totals-table .total-row .label,
        .totals-table .total-row .value {
            color: white;
        }

        .totals-table .balance-row {
            background: #e74c3c;
            color: white;
            font-weight: bold;
            font-size: 14px;
        }

        .totals-table .balance-row .label,
        .totals-table .balance-row .value {
            color: white;
        }

        /* Payment Section */
        .payment-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #27ae60;
        }

        .payment-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e3c72;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .payment-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .payment-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .payment-label {
            font-weight: bold;
            color: #5a6c7d;
            font-size: 10px;
        }

        .payment-value {
            color: #2c3e50;
            font-weight: bold;
            font-size: 11px;
        }

        /* Notes Section */
        .notes-section {
            background: #fff3cd;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #f39c12;
            margin-bottom: 30px;
        }

        .notes-title {
            font-size: 14px;
            font-weight: bold;
            color: #856404;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .notes-content {
            font-style: italic;
            color: #856404;
            line-height: 1.6;
            font-size: 11px;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            text-align: center;
            padding-top: 20px;
            border-top: 2px solid #ecf0f1;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 10px;
            color: #7f8c8d;
        }

        .footer-left {
            text-align: left;
        }

        .footer-center {
            text-align: center;
        }

        .footer-right {
            text-align: right;
        }

        .footer-company {
            font-weight: bold;
            color: #1e3c72;
            margin-bottom: 5px;
        }

        .footer-tagline {
            font-style: italic;
        }

        .footer-generated {
            color: #95a5a6;
        }

        .footer-thank-you {
            font-size: 16px;
            font-weight: bold;
            color: #1e3c72;
            margin-bottom: 5px;
        }

        /* Page Break */
        .page-break {
            page-break-before: always;
        }

        /* Print Styles */
        @media print {
            .container {
                padding: 15px;
            }

            .header {
                margin-bottom: 20px;
            }

            .content {
                gap: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <div class="company-logo-section">
                    <div class="company-logo">TSL</div>
                    <div>
                        <div class="company-name">TOTAL SUPPORT LIMITED</div>
                        <div class="company-tagline">Professional Logistics Solutions</div>
                    </div>
                </div>
                <div class="company-address">
                    1/F MAU LAM COMM 16-18 MAU LAM ST JORDAN HONG KONG<br>
                    Phone: +852 56445012 | Email: tslhk2023@gmail.com<br>
                    Website: www.tslhk.com
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

        <!-- Main Content -->
        <div class="content">
            <div class="left-column">
                <!-- Bill To -->
                <div class="address-section">
                    <div class="address-title">Bill To</div>
                    <div class="address-content">
                        <div class="address-company-name">{{ $billTo->company_name ?? 'N/A' }}</div>
                        <div class="address-details">{{ $billTo->address ?? 'N/A' }}</div>
                        <div class="contact-info">
                            <div class="contact-row">
                                <span class="contact-label">VAT:</span>
                                <span>{{ $billTo->vat_no ?? 'N/A' }}</span>
                            </div>
                            <div class="contact-row">
                                <span class="contact-label">EORI:</span>
                                <span>{{ $billTo->eori ?? 'N/A' }}</span>
                            </div>
                            <div class="contact-row">
                                <span class="contact-label">Phone:</span>
                                <span>{{ $billTo->phone ?? 'N/A' }}</span>
                            </div>
                            <div class="contact-row">
                                <span class="contact-label">Email:</span>
                                <span>{{ $billTo->email ?? 'N/A' }}</span>
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
                                <span class="contact-label">VAT:</span>
                                <span>{{ $shipTo->vat_no ?? 'N/A' }}</span>
                            </div>
                            <div class="contact-row">
                                <span class="contact-label">EORI:</span>
                                <span>{{ $shipTo->eori ?? 'N/A' }}</span>
                            </div>
                            <div class="contact-row">
                                <span class="contact-label">Phone:</span>
                                <span>{{ $shipTo->phone ?? 'N/A' }}</span>
                            </div>
                            <div class="contact-row">
                                <span class="contact-label">Email:</span>
                                <span>{{ $shipTo->email ?? 'N/A' }}</span>
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
                            <span class="detail-label">Order ID:</span>
                            <span class="detail-value">{{ $invoice->order_id ?? 'N/A' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Date:</span>
                            <span
                                class="detail-value">{{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') : 'N/A' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Ship Via:</span>
                            <span class="detail-value">{{ $invoice->ship_via ?? 'N/A' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Tracking:</span>
                            <span class="detail-value">{{ $invoice->tracking_no ?? 'N/A' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Tax ID:</span>
                            <span class="detail-value">{{ $invoice->tax_id ?? 'N/A' }}</span>
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
                    <div class="payment-item">
                        <span class="payment-label">Bank Name:</span>
                        <span class="payment-value">{{ $paymentInstructions->bank_name ?? 'N/A' }}</span>
                    </div>
                    <div class="payment-item">
                        <span class="payment-label">Bank Code:</span>
                        <span class="payment-value">{{ $paymentInstructions->bank_code ?? 'N/A' }}</span>
                    </div>
                    <div class="payment-item">
                        <span class="payment-label">SWIFT/BIC:</span>
                        <span class="payment-value">{{ $paymentInstructions->swift_bic ?? 'N/A' }}</span>
                    </div>
                    <div class="payment-item">
                        <span class="payment-label">Account No:</span>
                        <span class="payment-value">{{ $paymentInstructions->multi_currency_ac_no ?? 'N/A' }}</span>
                    </div>
                    <div class="payment-item">
                        <span class="payment-label">Account Name:</span>
                        <span
                            class="payment-value">{{ $paymentInstructions->account_name ?? 'TOTAL SUPPORT LIMITED' }}</span>
                    </div>
                    <div class="payment-item">
                        <span class="payment-label">Bank Address:</span>
                        <span class="payment-value">{{ $paymentInstructions->bank_address ?? 'N/A' }}</span>
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

        <!-- Footer -->
        <div class="footer">
            <div class="footer-content">
                <div class="footer-left">
                    <div class="footer-company">TOTAL SUPPORT LIMITED</div>
                    <div class="footer-tagline">Professional Logistics Solutions</div>
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