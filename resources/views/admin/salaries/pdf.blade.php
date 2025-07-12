<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Slip - {{ $salary->employee_name }}</title>
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
        .employee-info {
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
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
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">TSL Company</div>
        <div class="document-title">SALARY SLIP</div>
        <div>Generated on: {{ $salary->generated_date->format('F d, Y') }}</div>
    </div>

    <div class="employee-info">
        <div class="info-row">
            <div class="info-label">Employee Name:</div>
            <div class="info-value">{{ $salary->employee_name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Employee ID:</div>
            <div class="info-value">{{ $salary->employee_id_number }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Designation:</div>
            <div class="info-value">{{ $salary->designation }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Period:</div>
            <div class="info-value">{{ $salary->period_from->format('M d, Y') }} - {{ $salary->period_to->format('M d, Y') }}</div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Salary Payments</div>
        <table>
            <thead>
                <tr>
                    <th>Payment Method</th>
                    <th class="text-right">Amount</th>
                    <th class="text-center">Received Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salary->payments as $payment)
                <tr>
                    <td>{{ $payment->payment_method }}</td>
                    <td class="text-right">₹{{ number_format($payment->amount, 2) }}</td>
                    <td class="text-center">{{ $payment->received_date->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">No payments found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($salary->deductions->count() > 0)
    <div class="section">
        <div class="section-title">Deductions</div>
        <table>
            <thead>
                <tr>
                    <th>Deduction Type</th>
                    <th>Description</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salary->deductions as $deduction)
                <tr>
                    <td>{{ $deduction->deduction_type }}</td>
                    <td>{{ $deduction->description }}</td>
                    <td class="text-right">₹{{ number_format($deduction->amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="summary">
        <div class="summary-row">
            <span><strong>Total Paid:</strong></span>
            <span><strong>₹{{ number_format($salary->total_paid, 2) }}</strong></span>
        </div>
        <div class="summary-row">
            <span><strong>Total Deductions:</strong></span>
            <span><strong>₹{{ number_format($salary->total_deductions, 2) }}</strong></span>
        </div>
        <div class="summary-row total-row">
            <span><strong>Net Salary:</strong></span>
            <span><strong>₹{{ number_format($salary->net_salary, 2) }}</strong></span>
        </div>
    </div>

    <div class="footer">
        <p>This is a computer generated document. No signature is required.</p>
        <p>For any queries, please contact the HR department.</p>
    </div>
</body>
</html> 