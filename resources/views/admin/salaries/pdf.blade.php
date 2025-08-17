<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Slip - {{ $salary->employee_name }}</title>
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

        /* Employee Info Section */
        .employee-info {
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

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        th,
        td {
            padding: 12px 8px;
            text-align: left;
            font-size: 12px;
            border-bottom: 1px solid #f7fafc;
        }

        th {
            background: #667eea;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        td {
            background: white;
        }

        tr:nth-child(even) td {
            background: #f7fafc;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .amount {
            font-weight: bold;
            color: #48bb78;
        }

        .amount-deduction {
            color: #e53e3e;
            font-weight: bold;
        }

        .no-data {
            text-align: center;
            color: #718096;
            font-style: italic;
            padding: 20px;
        }

        /* Summary Section */
        .summary {
            background: #f0fff4;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
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
            border: none;
            margin: 0;
        }

        .summary-row table td {
            border: none;
            background: transparent;
            padding: 4px 0;
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

        .summary-amount {
            color: #48bb78;
        }

        .summary-deduction {
            color: #e53e3e;
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

            th {
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
                <div class="document-title">Salary Slip</div>
                <div class="generated-date">Generated on: {{ $salary->generated_date->format('F d, Y') }}</div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content">
            <!-- Employee Information -->
            <div class="employee-info">
                <div class="info-grid">
                    <div class="info-row-container">
                        <div class="info-row-left">
                            <div class="info-row">
                                <div class="info-label">Employee Name</div>
                                <div class="info-value">{{ $salary->employee_name }}</div>
                            </div>
                        </div>
                        <div class="info-row-right">
                            <div class="info-row">
                                <div class="info-label">Employee ID</div>
                                <div class="info-value">{{ $salary->employee_id_number }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="info-row-container">
                        <div class="info-row-left">
                            <div class="info-row">
                                <div class="info-label">Designation</div>
                                <div class="info-value">{{ $salary->designation }}</div>
                            </div>
                        </div>
                        <div class="info-row-right">
                            <div class="info-row">
                                <div class="info-label">Period</div>
                                <div class="info-value">{{ $salary->period_from->format('M d, Y') }} -
                                    {{ $salary->period_to->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Salary Payments -->
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
                                <td class="text-right amount">₹{{ number_format($payment->amount, 2) }}</td>
                                <td class="text-center">{{ $payment->received_date->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="no-data">No payments found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Deductions -->
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
                                    <td class="text-right amount-deduction">₹{{ number_format($deduction->amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Summary -->
            <div class="summary">
                <div class="summary-row">
                    <table>
                        <tr>
                            <td class="summary-label">Total Paid:</td>
                            <td class="summary-value summary-amount">₹{{ number_format($salary->total_paid, 2) }}</td>
                        </tr>
                    </table>
                </div>
                <div class="summary-row">
                    <table>
                        <tr>
                            <td class="summary-label">Total Deductions:</td>
                            <td class="summary-value summary-deduction">
                                ₹{{ number_format($salary->total_deductions, 2) }}</td>
                        </tr>
                    </table>
                </div>
                <div class="summary-row total-row">
                    <table>
                        <tr>
                            <td class="summary-label">Net Salary:</td>
                            <td class="summary-value summary-amount">₹{{ number_format($salary->net_salary, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-logo">
                <img src="https://tslhk.com/assets/img/logo.png" alt="TSLHK Logo"
                    style="max-width: 100%; height: auto;">
            </div>
            <div class="footer-company">TOTAL SUPPORT LIMITED</div>
            <div class="footer-tagline">YOUR ONE STOP SOLUTION</div>
            <div class="footer-text">This is a computer generated document. No signature is required.</div>
            <div class="footer-text">For any queries, please contact the HR department.</div>
        </div>
    </div>
</body>

</html>