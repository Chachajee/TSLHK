@extends('layouts/layoutMaster')

@section('title', 'Edit Salary Slip')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/flatpickr/flatpickr.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/flatpickr/flatpickr.js'
])
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize flatpickr for date inputs
    flatpickr('.flatpickr-date', {
        dateFormat: 'Y-m-d',
        allowInput: true
    });

    // Initialize select2 for dropdowns
    $('.select2').select2({
        placeholder: 'Select an option',
        allowClear: true
    });

    // Add payment row
    window.addPaymentRow = function() {
        const paymentContainer = document.getElementById('payment-container');
        const paymentIndex = paymentContainer.children.length;
        
        const paymentRow = document.createElement('div');
        paymentRow.className = 'row mb-3 payment-row';
        paymentRow.innerHTML = `
            <div class="col-md-4">
                <label class="form-label">Payment Method</label>
                <select name="payment_method[]" class="form-select" required>
                    <option value="">Select Method</option>
                    <option value="Cash">Cash</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Check">Check</option>
                    <option value="Autopay">Autopay</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Amount</label>
                <input type="number" name="payment_amount[]" class="form-control payment-amount" step="0.01" min="0" required onchange="calculateTotals()">
            </div>
            <div class="col-md-3">
                <label class="form-label">Received Date</label>
                <input type="text" name="payment_received_date[]" class="form-control flatpickr-date" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <button type="button" class="btn btn-danger btn-sm w-100" onclick="removePaymentRow(this)">
                    <i class="ti ti-trash"></i> Remove
                </button>
            </div>
        `;
        
        paymentContainer.appendChild(paymentRow);
        
        // Initialize flatpickr for the new date input
        flatpickr(paymentRow.querySelector('.flatpickr-date'), {
            dateFormat: 'Y-m-d',
            allowInput: true
        });
    };

    // Remove payment row
    window.removePaymentRow = function(button) {
        button.closest('.payment-row').remove();
        calculateTotals();
    };

    // Add deduction row
    window.addDeductionRow = function() {
        const deductionContainer = document.getElementById('deduction-container');
        const deductionIndex = deductionContainer.children.length;
        
        const deductionRow = document.createElement('div');
        deductionRow.className = 'row mb-3 deduction-row';
        deductionRow.innerHTML = `
            <div class="col-md-3">
                <label class="form-label">Deduction Type</label>
                <select name="deduction_type[]" class="form-select" required>
                    <option value="">Select Type</option>
                    <option value="Tax">Tax</option>
                    <option value="Insurance">Insurance</option>
                    <option value="Loan">Loan</option>
                    <option value="Advance">Advance</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Description</label>
                <input type="text" name="deduction_description[]" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Amount</label>
                <input type="number" name="deduction_amount[]" class="form-control deduction-amount" step="0.01" min="0" required onchange="calculateTotals()">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeDeductionRow(this)">
                    <i class="ti ti-trash"></i> Remove
                </button>
            </div>
        `;
        
        deductionContainer.appendChild(deductionRow);
    };

    // Remove deduction row
    window.removeDeductionRow = function(button) {
        button.closest('.deduction-row').remove();
        calculateTotals();
    };

    // Calculate totals
    window.calculateTotals = function() {
        let totalPaid = 0;
        let totalDeductions = 0;

        // Calculate total payments
        document.querySelectorAll('.payment-amount').forEach(input => {
            totalPaid += parseFloat(input.value) || 0;
        });

        // Calculate total deductions
        document.querySelectorAll('.deduction-amount').forEach(input => {
            totalDeductions += parseFloat(input.value) || 0;
        });

        // Update display
        document.getElementById('total-paid').textContent = '$' + totalPaid.toFixed(2);
        document.getElementById('total-deductions').textContent = '$' + totalDeductions.toFixed(2);
        document.getElementById('net-salary').textContent = '$' + (totalPaid - totalDeductions).toFixed(2);
    };

    // Load existing data
    loadExistingData();
});

// Load existing data function
function loadExistingData() {
    // Load existing payments
    @if($salary->payments->count() > 0)
        @foreach($salary->payments as $payment)
            addPaymentRow();
            const paymentRows = document.querySelectorAll('.payment-row');
            const lastPaymentRow = paymentRows[paymentRows.length - 1];
            
            lastPaymentRow.querySelector('select[name="payment_method[]"]').value = '{{ $payment->payment_method }}';
            lastPaymentRow.querySelector('input[name="payment_amount[]"]').value = '{{ $payment->amount }}';
            lastPaymentRow.querySelector('input[name="payment_received_date[]"]').value = '{{ $payment->received_date->format('Y-m-d') }}';
        @endforeach
    @else
        addPaymentRow();
    @endif

    // Load existing deductions
    @if($salary->deductions->count() > 0)
        @foreach($salary->deductions as $deduction)
            addDeductionRow();
            const deductionRows = document.querySelectorAll('.deduction-row');
            const lastDeductionRow = deductionRows[deductionRows.length - 1];
            
            lastDeductionRow.querySelector('select[name="deduction_type[]"]').value = '{{ $deduction->deduction_type }}';
            lastDeductionRow.querySelector('input[name="deduction_description[]"]').value = '{{ $deduction->description }}';
            lastDeductionRow.querySelector('input[name="deduction_amount[]"]').value = '{{ $deduction->amount }}';
        @endforeach
    @endif

    // Calculate initial totals
    calculateTotals();
}
</script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Salary Slip</h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.salaries.update', $salary->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Employee Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="mb-3">Employee Information</h5>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Employee Name</label>
                                <input type="text" name="employee_name" class="form-control" value="{{ old('employee_name', $salary->employee_name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Employee ID Number</label>
                                <input type="text" name="employee_id_number" class="form-control" value="{{ old('employee_id_number', $salary->employee_id_number) }}" required>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="form-label">Designation</label>
                                <input type="text" name="designation" class="form-control" value="{{ old('designation', $salary->designation) }}" required>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="form-label">Generated Date</label>
                                <input type="text" name="generated_date" class="form-control flatpickr-date" value="{{ old('generated_date', $salary->generated_date->format('Y-m-d')) }}" required>
                            </div>
                        </div>

                        <!-- Salary Period -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="mb-3">Salary Period</h5>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Period From</label>
                                <input type="text" name="period_from" class="form-control flatpickr-date" value="{{ old('period_from', $salary->period_from->format('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Period To</label>
                                <input type="text" name="period_to" class="form-control flatpickr-date" value="{{ old('period_to', $salary->period_to->format('Y-m-d')) }}" required>
                            </div>
                        </div>

                        <!-- Salary Payments -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">Salary Payments</h5>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="addPaymentRow()">
                                        <i class="ti ti-plus me-1"></i>Add Payment
                                    </button>
                                </div>
                                <div id="payment-container">
                                    <!-- Payment rows will be added here dynamically -->
                                </div>
                            </div>
                        </div>

                        <!-- Salary Deductions -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">Deductions (Optional)</h5>
                                    <button type="button" class="btn btn-warning btn-sm" onclick="addDeductionRow()">
                                        <i class="ti ti-plus me-1"></i>Add Deduction
                                    </button>
                                </div>
                                <div id="deduction-container">
                                    <!-- Deduction rows will be added here dynamically -->
                                </div>
                            </div>
                        </div>

                        <!-- Summary -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Summary</h6>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <strong>Total Paid:</strong> <span id="total-paid" class="text-success">$0.00</span>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Total Deductions:</strong> <span id="total-deductions" class="text-warning">$0.00</span>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Net Salary:</strong> <span id="net-salary" class="text-primary">$0.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti ti-check me-1"></i>Update Salary Slip
                                    </button>
                                    <a href="{{ route('admin.salaries.index') }}" class="btn btn-secondary">
                                        <i class="ti ti-x me-1"></i>Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 