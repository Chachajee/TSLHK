@extends('layouts/layoutMaster')

@section('title', 'Edit Credit Note')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/cleavejs/cleave.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/cleavejs/cleave.js'
])
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Cleave.js for number formatting - CONSISTENT CURRENCY SYMBOL
    const amountPaidInput = new Cleave('#amount_paid', {
        numeral: true,
        numeralDecimalScale: 2,
        numeralPositiveOnly: true,
        prefix: '₹' // Fixed: Use consistent rupee symbol instead of $
    });

    const amountSpentInput = new Cleave('#amount_spent', {
        numeral: true,
        numeralDecimalScale: 2,
        numeralPositiveOnly: true,
        prefix: '₹' // Fixed: Use consistent rupee symbol instead of $
    });

    // Set initial values
    amountPaidInput.setRawValue('{{ $creditNote->amount_paid }}');
    amountSpentInput.setRawValue('{{ $creditNote->amount_spent }}');

    // Auto-calculate credit balance
    function calculateCreditBalance() {
        const amountPaid = parseFloat(amountPaidInput.getRawValue()) || 0;
        const amountSpent = parseFloat(amountSpentInput.getRawValue()) || 0;
        const creditBalance = amountPaid - amountSpent;
        
        document.getElementById('credit_balance_display').textContent = '₹' + creditBalance.toFixed(2);
        document.getElementById('credit_balance').value = creditBalance.toFixed(2);
        
        // Update color based on balance
        const displayElement = document.getElementById('credit_balance_display');
        if (creditBalance > 0) {
            displayElement.className = 'form-control-plaintext text-success fw-bold';
        } else if (creditBalance < 0) {
            displayElement.className = 'form-control-plaintext text-danger fw-bold';
        } else {
            displayElement.className = 'form-control-plaintext text-muted fw-bold';
        }
        
        // Update summary as well
        updateSummary();
    }

    // Update summary display
    function updateSummary() {
        const amountPaid = parseFloat(amountPaidInput.getRawValue()) || 0;
        const amountSpent = parseFloat(amountSpentInput.getRawValue()) || 0;
        const creditBalance = amountPaid - amountSpent;
        
        document.getElementById('summary-amount-paid').textContent = '₹' + amountPaid.toFixed(2);
        document.getElementById('summary-amount-spent').textContent = '₹' + amountSpent.toFixed(2);
        document.getElementById('summary-credit-balance').textContent = '₹' + creditBalance.toFixed(2);
    }

    // Add event listeners for auto-calculation
    document.getElementById('amount_paid').addEventListener('input', calculateCreditBalance);
    document.getElementById('amount_spent').addEventListener('input', calculateCreditBalance);

    // Initial calculation
    calculateCreditBalance();
});
</script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Credit Note</h4>
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

                    <form action="{{ route('admin.credit-notes.update', $creditNote->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Customer Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="mb-3">Customer Information</h5>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Customer Name</label>
                                <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{ old('customer_name', $creditNote->customer_name) }}" required>
                            </div>
                        </div>

                        <!-- Financial Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="mb-3">Financial Information</h5>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Amount Paid</label>
                                <input type="text" name="amount_paid" id="amount_paid" class="form-control" value="{{ old('amount_paid', $creditNote->amount_paid) }}" required>
                                <div class="form-text">Enter the total amount paid by the customer</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Amount Spent</label>
                                <input type="text" name="amount_spent" id="amount_spent" class="form-control" value="{{ old('amount_spent', $creditNote->amount_spent) }}" required>
                                <div class="form-text">Enter the total amount spent by the customer</div>
                            </div>
                        </div>

                        <!-- Credit Balance (Auto-calculated) -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Credit Balance</label>
                                <div class="form-control-plaintext fw-bold" id="credit_balance_display">₹{{ number_format($creditNote->credit_balance, 2) }}</div>
                                <input type="hidden" name="credit_balance" id="credit_balance" value="{{ $creditNote->credit_balance }}">
                                <div class="form-text">Automatically calculated (Paid - Spent)</div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="mb-3">Additional Information</h5>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Notes (Optional)</label>
                                <textarea name="notes" id="notes" class="form-control" rows="4" placeholder="Enter any additional notes or comments...">{{ old('notes', $creditNote->notes) }}</textarea>
                                <div class="form-text">Optional notes about this credit note</div>
                            </div>
                        </div>

                        <!-- Summary Card -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Summary</h6>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <strong>Amount Paid:</strong> <span id="summary-amount-paid" class="text-success">₹{{ number_format($creditNote->amount_paid, 2) }}</span>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Amount Spent:</strong> <span id="summary-amount-spent" class="text-warning">₹{{ number_format($creditNote->amount_spent, 2) }}</span>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Credit Balance:</strong> <span id="summary-credit-balance" class="text-primary">₹{{ number_format($creditNote->credit_balance, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Signature Options -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Signature Options</h6>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="show_signature" name="show_signature" value="1" {{ old('show_signature', $creditNote->show_signature) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="show_signature">
                                                Include company signature and stamp in PDF
                                            </label>
                                        </div>
                                        <small class="text-muted">
                                            When checked, the PDF will include the company signature and stamp section. 
                                            When unchecked, the signature section will not appear in the generated PDF.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti ti-check me-1"></i>Update Credit Note
                                    </button>
                                    <a href="{{ route('admin.credit-notes.index') }}" class="btn btn-secondary">
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