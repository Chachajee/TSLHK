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
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #2c3e50;
            background: white;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
        }
        
        /* Header Section */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 3px solid #3498db;
        }
        
        .company-info {
            flex: 1;
        }
        
        .company-logo {
            font-size: 28px;
            font-weight: bold;
            color: #3498db;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }
        
        .company-tagline {
            font-size: 12px;
            color: #7f8c8d;
            font-style: italic;
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
            color: #3498db;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .invoice-date {
            font-size: 12px;
            color: #7f8c8d;
        }
        
        /* Main Content */
        .content {
            display: flex;
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .left-column {
            flex: 2;
        }
        
        .right-column {
            flex: 1;
        }
        
        /* Address Sections */
        .address-section {
            margin-bottom: 30px;
            padding: 15px;
            background: #f8f9fa;
            border-left: 4px solid #3498db;
            border-radius: 5px;
        }
        
        .address-title {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .address-content {
            font-size: 11px;
            line-height: 1.6;
        }
        
        .company-name {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .address-details {
            color: #5a6c7d;
        }
        
        .contact-info {
            margin-top: 8px;
            font-size: 10px;
            color: #7f8c8d;
        }
        
        /* Invoice Details */
        .invoice-details {
            background: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        
        .details-title {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
        }
        
        .detail-label {
            font-weight: bold;
            color: #5a6c7d;
        }
        
        .detail-value {
            color: #2c3e50;
        }
        
        /* Items Table */
        .items-section {
            margin-bottom: 30px;
        }
        
        .items-title {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            overflow: hidden;
        }
        
        .items-table th {
            background: #3498db;
            color: white;
            font-weight: bold;
            padding: 12px 8px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .items-table td {
            padding: 10px 8px;
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
            color: #2c3e50;
        }
        
        /* Totals Section */
        .totals-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }
        
        .totals-table {
            width: 300px;
            border-collapse: collapse;
        }
        
        .totals-table td {
            padding: 8px 15px;
            border: none;
            font-size: 11px;
        }
        
        .totals-table .label {
            font-weight: bold;
            color: #5a6c7d;
            text-align: right;
        }
        
        .totals-table .value {
            text-align: right;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .totals-table .subtotal-row {
            border-top: 1px solid #bdc3c7;
            padding-top: 10px;
        }
        
        .totals-table .total-row {
            border-top: 2px solid #3498db;
            font-size: 13px;
            font-weight: bold;
            color: #2c3e50;
            padding-top: 12px;
        }
        
        .totals-table .balance-row {
            background: #e74c3c;
            color: white;
            font-weight: bold;
        }
        
        .totals-table .balance-row .label,
        .totals-table .balance-row .value {
            color: white;
        }
        
        /* Payment Section */
        .payment-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
            border-left: 4px solid #27ae60;
        }
        
        .payment-title {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
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
        }
        
        .payment-label {
            font-weight: bold;
            color: #5a6c7d;
            font-size: 10px;
        }
        
        .payment-value {
            color: #2c3e50;
            font-weight: bold;
        }
        
        /* Notes Section */
        .notes-section {
            background: #fff3cd;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #f39c12;
            margin-bottom: 30px;
        }
        
        .notes-title {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .notes-content {
            font-style: italic;
            color: #5a6c7d;
            line-height: 1.6;
        }
        
        /* Footer */
        .footer {
            margin-top: 50px;
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
            color: #3498db;
            margin-bottom: 5px;
        }
        
        .footer-tagline {
            font-style: italic;
        }
        
        .footer-generated {
            color: #95a5a6;
        }
        
        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
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
        
        /* Page Break */
        .page-break {
            page-break-before: always;
        }
        
        /* Responsive adjustments for PDF */
        @media print {
            .container {
                padding: 20px;
            }
            
            .header {
                margin-bottom: 30px;
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
                <div class="company-logo">TSLHK</div>
                <div class="company-tagline">Professional Logistics Solutions</div>
            </div>
            
            <div class="invoice-header">
                <div class="invoice-title">Invoice</div>
                <div class="invoice-number">#{{ $invoice->invoice_no }}</div>
                <div class="invoice-date">
                    {{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('F d, Y') : 'N/A' }}
                </div>
                <div style="margin-top: 10px;">
                    <span class="status-badge status-{{ $invoice->balance_due > 0 ? ($invoice->paid > 0 ? 'partial' : 'unpaid') : 'paid' }}">
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
                        <div class="company-name">{{ $billTo->company_name ?? 'N/A' }}</div>
                        <div class="address-details">{{ $billTo->address ?? 'N/A' }}</div>
                        <div class="contact-info">
                            <strong>VAT:</strong> {{ $billTo->vat_no ?? 'N/A' }} | 
                            <strong>EORI:</strong> {{ $billTo->eori ?? 'N/A' }}<br>
                            <strong>Phone:</strong> {{ $billTo->phone ?? 'N/A' }} | 
                            <strong>Email:</strong> {{ $billTo->email ?? 'N/A' }}
                        </div>
                    </div>
                </div>

                <!-- Ship To -->
                <div class="address-section">
                    <div class="address-title">Ship To</div>
                    <div class="address-content">
                        <div class="company-name">{{ $shipTo->company_name ?? 'N/A' }}</div>
                        <div class="address-details">{{ $shipTo->address ?? 'N/A' }}</div>
                        <div class="contact-info">
                            <strong>VAT:</strong> {{ $shipTo->vat_no ?? 'N/A' }} | 
                            <strong>EORI:</strong> {{ $shipTo->eori ?? 'N/A' }}<br>
                            <strong>Email:</strong> {{ $shipTo->email ?? 'N/A' }}
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
                            <span class="detail-label">Date:</span>
                            <span class="detail-value">{{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') : 'N/A' }}</span>
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
                                <td class="text-right">${{ number_format($item->rate ?? 0, 2) }}</td>
                                <td class="text-right amount">${{ number_format($item->amount ?? 0, 2) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center" style="color: #7f8c8d; font-style: italic;">No items found</td>
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
                    <td class="value">${{ number_format($invoice->subtotal ?? 0, 2) }}</td>
                </tr>
                <tr class="subtotal-row">
                    <td class="label">Shipping:</td>
                    <td class="value">${{ number_format($invoice->shipping ?? 0, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td class="label">Total:</td>
                    <td class="value">${{ number_format($invoice->total ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td class="label">Paid:</td>
                    <td class="value">${{ number_format($invoice->paid ?? 0, 2) }}</td>
                </tr>
                <tr class="{{ $invoice->balance_due > 0 ? 'balance-row' : 'total-row' }}">
                    <td class="label">Balance Due:</td>
                    <td class="value">${{ number_format($invoice->balance_due ?? 0, 2) }}</td>
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
                    <div class="footer-company">TSLHK</div>
                    <div class="footer-tagline">Professional Logistics Solutions</div>
                </div>
                <div class="footer-center">
                    <div>Thank you for your business!</div>
                </div>
                <div class="footer-right">
                    <div class="footer-generated">Generated on {{ now()->format('M d, Y \a\t g:i A') }}</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 