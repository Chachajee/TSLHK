<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit Note - {{ $creditNote->customer_name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .document-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .customer-info {
            margin-bottom: 30px;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            width: 150px;
        }
        .info-value {
            flex: 1;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            background-color: #f5f5f5;
            padding: 8px;
            margin-bottom: 15px;
            border-left: 4px solid #007bff;
        }
        .summary {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .total-row {
            font-weight: bold;
            border-top: 2px solid #333;
            padding-top: 8px;
            margin-top: 8px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .amount-positive {
            color: #28a745;
            font-weight: bold;
        }
        .amount-negative {
            color: #dc3545;
            font-weight: bold;
        }
        .amount-neutral {
            color: #6c757d;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">TSL Company</div>
        <div class="document-title">CREDIT NOTE</div>
        <div>Generated on: {{ $creditNote->created_at->format('F d, Y') }}</div>
    </div>

    <div class="customer-info">
        <div class="info-row">
            <div class="info-label">Customer Name:</div>
            <div class="info-value">{{ $creditNote->customer_name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Credit Note ID:</div>
            <div class="info-value">#{{ $creditNote->id }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Created Date:</div>
            <div class="info-value">{{ $creditNote->created_at->format('M d, Y') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Last Updated:</div>
            <div class="info-value">{{ $creditNote->updated_at->format('M d, Y') }}</div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Financial Summary</div>
        <div class="summary">
            <div class="summary-row">
                <span><strong>Amount Paid:</strong></span>
                <span class="amount-positive">₹{{ number_format($creditNote->amount_paid, 2) }}</span>
            </div>
            <div class="summary-row">
                <span><strong>Amount Spent:</strong></span>
                <span class="amount-negative">₹{{ number_format($creditNote->amount_spent, 2) }}</span>
            </div>
            <div class="summary-row total-row">
                <span><strong>Credit Balance:</strong></span>
                <span class="{{ $creditNote->credit_balance > 0 ? 'amount-positive' : ($creditNote->credit_balance < 0 ? 'amount-negative' : 'amount-neutral') }}">
                    ₹{{ number_format($creditNote->credit_balance, 2) }}
                </span>
            </div>
        </div>
    </div>

    @if($creditNote->notes)
    <div class="section">
        <div class="section-title">Notes</div>
        <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px;">
            <p style="margin: 0;">{{ $creditNote->notes }}</p>
        </div>
    </div>
    @endif

    <div class="footer">
        <p>This is a computer generated credit note. No signature is required.</p>
        <p>For any queries, please contact the accounting department.</p>
        <p>Credit Note ID: #{{ $creditNote->id }} | Generated: {{ $creditNote->created_at->format('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html> 