<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit Note - {{ $creditNote->customer_name }}</title>
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
            text-align: center;
            margin-bottom: 20px;
        }

        .header-content {
            position: relative;
        }

        .company-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 15px;
            display: block;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 8px;
            text-align: center;
        }

        .company-logo img {
            max-width: 70px;
            max-height: 70px;
            vertical-align: middle;
        }

        .company-name {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .document-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .generated-date {
            font-size: 14px;
            opacity: 0.8;
        }

        /* Main Content */
        .content {
            padding: 20px 30px;
        }

        /* Customer Info Section */
        .customer-info {
            background: #f7fafc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border: 1px solid #e2e8f0;
        }

        .info-grid {
            width: 100%;
        }

        .info-row-container {
            width: 100%;
            display: table;
            margin-bottom: 15px;
        }

        .info-row-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 15px;
        }

        .info-row-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-left: 15px;
        }

        .info-row {
            margin-bottom: 12px;
        }

        .info-label {
            font-weight: bold;
            color: #4a5568;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .info-value {
            font-weight: bold;
            color: #1a202c;
            font-size: 15px;
        }

        /* Section Styling */
        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            background: #667eea;
            color: white;
            padding: 12px 20px;
            margin-bottom: 15px;
            border-radius: 8px;
            text-transform: uppercase;
        }

        /* Summary Section */
        .summary {
            background: #f0fff4;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid rgba(72, 187, 120, 0.2);
        }

        .summary-row {
            width: 100%;
            margin-bottom: 12px;
            padding: 8px 0;
            border-bottom: 1px solid rgba(72, 187, 120, 0.2);
        }

        .summary-row table {
            width: 100%;
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .total-row {
            font-weight: bold;
            font-size: 14px;
            border-top: 2px solid #48bb78;
            padding-top: 12px;
            margin-top: 12px;
            color: #2d3748;
        }

        .summary-label {
            font-weight: bold;
            color: #2d3748;
        }

        .summary-value {
            text-align: right;
            font-weight: bold;
        }

        .amount-positive {
            color: #48bb78;
        }

        .amount-negative {
            color: #e53e3e;
        }

        .amount-neutral {
            color: #6c757d;
        }

        /* Notes Section */
        .notes-section {
            background: #fffaf0;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid rgba(237, 137, 54, 0.2);
        }

        .notes-content {
            font-style: italic;
            color: #744210;
            line-height: 1.5;
            font-size: 11px;
        }

        /* Footer */
        .footer {
            background: #2d3748;
            color: white;
            padding: 20px 30px;
            text-align: center;
            margin-top: 20px;
        }

        .footer-logo {
            width: 30px;
            height: 30px;
            margin: 0 auto 12px;
            display: block;
        }

        .footer-logo img {
            max-width: 30px;
            max-height: 30px;
        }

        .footer-text {
            font-size: 10px;
            color: #a0aec0;
            margin-bottom: 6px;
        }

        .footer-company {
            font-weight: bold;
            color: white;
            font-size: 12px;
            margin-bottom: 3px;
        }

        .footer-tagline {
            font-size: 10px;
            color: #a0aec0;
            font-style: italic;
            margin-bottom: 8px;
        }

        .footer-details {
            font-size: 9px;
            color: #718096;
            margin-top: 8px;
            border-top: 1px solid #4a5568;
            padding-top: 8px;
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

            .section-title {
                background: #667eea !important;
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
                <div class="company-logo">
                    <img src="https://tslhk.com/assets/img/logo.png" alt="TSLHK Logo"
                        style="max-width: 100%; height: auto;">
                </div>
                <div class="company-name">TOTAL SUPPORT LIMITED</div>
                <div class="document-title">Credit Note</div>
                <div class="generated-date">Generated on: {{ $creditNote->created_at->format('F d, Y') }}</div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content">
            <!-- Customer Information -->
            <div class="customer-info">
                <div class="info-grid">
                    <div class="info-row-container">
                        <div class="info-row-left">
                            <div class="info-row">
                                <div class="info-label">Customer Name</div>
                                <div class="info-value">{{ $creditNote->customer_name }}</div>
                            </div>
                        </div>
                        <div class="info-row-right">
                            <div class="info-row">
                                <div class="info-label">Credit Note ID</div>
                                <div class="info-value">#{{ $creditNote->id }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="info-row-container">
                        <div class="info-row-left">
                            <div class="info-row">
                                <div class="info-label">Created Date</div>
                                <div class="info-value">{{ $creditNote->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                        <div class="info-row-right">
                            <div class="info-row">
                                <div class="info-label">Last Updated</div>
                                <div class="info-value">{{ $creditNote->updated_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Summary -->
            <div class="section">
                <div class="section-title">Financial Summary</div>
                <div class="summary">
                    <div class="summary-row">
                        <table>
                            <tr>
                                <td class="summary-label">Amount Paid:</td>
                                <td class="summary-value amount-positive">
                                    ₹{{ number_format($creditNote->amount_paid, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="summary-row">
                        <table>
                            <tr>
                                <td class="summary-label">Amount Spent:</td>
                                <td class="summary-value amount-negative">
                                    ₹{{ number_format($creditNote->amount_spent, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="summary-row total-row">
                        <table>
                            <tr>
                                <td class="summary-label">Credit Balance:</td>
                                <td
                                    class="summary-value {{ $creditNote->credit_balance > 0 ? 'amount-positive' : ($creditNote->credit_balance < 0 ? 'amount-negative' : 'amount-neutral') }}">
                                    ₹{{ number_format($creditNote->credit_balance, 2) }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if($creditNote->notes)
                <div class="section">
                    <div class="section-title">Notes</div>
                    <div class="notes-section">
                        <div class="notes-content">{{ $creditNote->notes }}</div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-logo">
                <img src="https://tslhk.com/assets/img/logo.png" alt="TSLHK Logo"
                    style="max-width: 100%; height: auto;">
            </div>
            <div class="footer-company">TOTAL SUPPORT LIMITED</div>
            <div class="footer-tagline">YOUR ONE STOP SOLUTION</div>
            <div class="footer-text">This is a computer generated credit note. No signature is required.</div>
            <div class="footer-text">For any queries, please contact the accounting department.</div>
            <div class="footer-details">Credit Note ID: #{{ $creditNote->id }} | Generated:
                {{ $creditNote->created_at->format('Y-m-d H:i:s') }}
            </div>
        </div>
    </div>
</body>

</html>