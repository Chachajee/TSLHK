@extends('layouts/layoutMaster')

@section('title', 'Create Invoice')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/flatpickr/flatpickr.js',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
])
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Flatpickr for date
    flatpickr('#invoice_date', {dateFormat: 'Y-m-d'});
    // Select2 for dropdowns
    $('.select2').select2();

    // Dynamic invoice items
    let itemRowCount = 1;
    function addItemRow(animated = true) {
        const tbody = document.getElementById('invoice-items-tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td><input type="text" class="form-control" name="description[]" placeholder="Item description" required></td>
            <td><input type="number" class="form-control quantity" name="quantity[]" min="1" value="1" required></td>
            <td><input type="number" class="form-control rate" name="rate[]" min="0" step="0.01" value="0.00" required></td>
            <td><input type="number" class="form-control amount" name="amount[]" readonly></td>
            <td><button type="button" class="btn btn-danger btn-icon btn-sm remove-row" aria-label="Remove item" data-bs-toggle="tooltip" title="Remove item"><i class="ti ti-trash"></i></button></td>
        `;
        if (animated) {
            newRow.style.opacity = 0;
            tbody.appendChild(newRow);
            setTimeout(() => { newRow.style.transition = 'opacity 0.3s'; newRow.style.opacity = 1; }, 10);
        } else {
            tbody.appendChild(newRow);
        }
        itemRowCount++;
        // Add event listeners
        const quantityInput = newRow.querySelector('.quantity');
        const rateInput = newRow.querySelector('.rate');
        const amountInput = newRow.querySelector('.amount');
        quantityInput.addEventListener('input', calculateRowAmount);
        rateInput.addEventListener('input', calculateRowAmount);
        calculateRowAmount.call(quantityInput);
    }
    function removeItemRow(button) {
        const row = button.closest('tr');
        row.style.transition = 'opacity 0.3s';
        row.style.opacity = 0;
        setTimeout(() => { row.remove(); calculateTotals(); }, 300);
    }
    function calculateRowAmount() {
        const row = this.closest('tr');
        const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
        const rate = parseFloat(row.querySelector('.rate').value) || 0;
        const amount = quantity * rate;
        row.querySelector('.amount').value = amount.toFixed(2);
        calculateTotals();
    }
    function calculateTotals() {
        let subtotal = 0;
        document.querySelectorAll('.amount').forEach(amount => { subtotal += parseFloat(amount.value) || 0; });
        const shipping = parseFloat(document.getElementById('shipping').value) || 0;
        const total = subtotal + shipping;
        const paid = parseFloat(document.getElementById('paid').value) || 0;
        const balanceDue = total - paid;
        document.getElementById('subtotal').value = subtotal.toFixed(2);
        document.getElementById('total').value = total.toFixed(2);
        document.getElementById('balance_due').value = balanceDue.toFixed(2);
        // Badge color
        const badge = document.getElementById('balance-badge');
        badge.className = 'badge rounded-pill ' + (balanceDue > 0 ? 'bg-danger' : 'bg-success');
        badge.textContent = '$' + balanceDue.toFixed(2);
    }
    document.getElementById('add-item-row').addEventListener('click', () => addItemRow(true));
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            removeItemRow(e.target.closest('.remove-row'));
        }
    });
    document.getElementById('shipping').addEventListener('input', calculateTotals);
    document.getElementById('paid').addEventListener('input', calculateTotals);
    addItemRow(false);
});
</script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <form action="{{ route('admin.invoices.store') }}" method="POST" autocomplete="off">
        @csrf
        <!-- Sticky Action Bar -->
        <div class="sticky-top bg-white py-2 mb-3 border-bottom d-flex justify-content-between align-items-center" style="z-index: 10;">
            <h4 class="mb-0"><i class="ti ti-file-invoice me-2"></i>Create Invoice</h4>
            <!-- <div>
                <button type="submit" class="btn btn-primary"><i class="ti ti-check me-1"></i>Save</button>
                <a href="{{ route('admin.invoices.index') }}" class="btn btn-outline-secondary ms-2"><i class="ti ti-x me-1"></i>Cancel</a>
            </div> -->
        </div>
        <div class="row g-4">
            <!-- Invoice Header -->
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-light d-flex align-items-center">
                        <i class="ti ti-file-invoice text-primary me-2"></i>
                        <span class="fw-bold">Invoice Header</span>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="invoice_no" class="form-label">Invoice Number</label>
                            <input type="text" class="form-control form-control-lg @error('invoice_no') is-invalid @enderror" id="invoice_no" name="invoice_no" value="{{ old('invoice_no') }}" required>
                            @error('invoice_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="invoice_date" class="form-label">Invoice Date</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-calendar"></i></span>
                                <input type="text" class="form-control @error('invoice_date') is-invalid @enderror" id="invoice_date" name="invoice_date" value="{{ old('invoice_date') }}" required aria-label="Invoice Date">
                                @error('invoice_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bill To -->
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-light d-flex align-items-center">
                        <i class="ti ti-user text-primary me-2"></i>
                        <span class="fw-bold">Bill To</span>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="bill_company_name" class="form-label">Company Name</label>
                            <input type="text" class="form-control @error('bill_company_name') is-invalid @enderror" id="bill_company_name" name="bill_company_name" value="{{ old('bill_company_name') }}" required>
                            @error('bill_company_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="bill_address" class="form-label">Address</label>
                            <textarea class="form-control @error('bill_address') is-invalid @enderror" id="bill_address" name="bill_address" rows="2" required>{{ old('bill_address') }}</textarea>
                            @error('bill_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label for="bill_vat_no" class="form-label">VAT Number</label>
                                <input type="text" class="form-control @error('bill_vat_no') is-invalid @enderror" id="bill_vat_no" name="bill_vat_no" value="{{ old('bill_vat_no') }}" required>
                                @error('bill_vat_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="bill_eori" class="form-label">EORI</label>
                                <input type="text" class="form-control @error('bill_eori') is-invalid @enderror" id="bill_eori" name="bill_eori" value="{{ old('bill_eori') }}" required>
                                @error('bill_eori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="row g-2 mt-2">
                            <div class="col-md-6">
                                <label for="bill_phone" class="form-label">Phone</label>
                                <input type="text" class="form-control @error('bill_phone') is-invalid @enderror" id="bill_phone" name="bill_phone" value="{{ old('bill_phone') }}" required>
                                @error('bill_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="bill_email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ti ti-mail"></i></span>
                                    <input type="email" class="form-control @error('bill_email') is-invalid @enderror" id="bill_email" name="bill_email" value="{{ old('bill_email') }}" required aria-label="Bill To Email">
                                    @error('bill_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ship To -->
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm h-100 mt-4">
                    <div class="card-header bg-light d-flex align-items-center">
                        <i class="ti ti-truck text-primary me-2"></i>
                        <span class="fw-bold">Ship To</span>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="ship_company_name" class="form-label">Company Name</label>
                            <input type="text" class="form-control @error('ship_company_name') is-invalid @enderror" id="ship_company_name" name="ship_company_name" value="{{ old('ship_company_name') }}" required>
                            @error('ship_company_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="ship_address" class="form-label">Address</label>
                            <textarea class="form-control @error('ship_address') is-invalid @enderror" id="ship_address" name="ship_address" rows="2" required>{{ old('ship_address') }}</textarea>
                            @error('ship_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label for="ship_vat_no" class="form-label">VAT Number</label>
                                <input type="text" class="form-control @error('ship_vat_no') is-invalid @enderror" id="ship_vat_no" name="ship_vat_no" value="{{ old('ship_vat_no') }}" required>
                                @error('ship_vat_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="ship_eori" class="form-label">EORI</label>
                                <input type="text" class="form-control @error('ship_eori') is-invalid @enderror" id="ship_eori" name="ship_eori" value="{{ old('ship_eori') }}" required>
                                @error('ship_eori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="row g-2 mt-2">
                            <div class="col-md-6">
                                <label for="ship_email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ti ti-mail"></i></span>
                                    <input type="email" class="form-control @error('ship_email') is-invalid @enderror" id="ship_email" name="ship_email" value="{{ old('ship_email') }}" required aria-label="Ship To Email">
                                    @error('ship_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Shipping Details -->
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm h-100 mt-4">
                    <div class="card-header bg-light d-flex align-items-center">
                        <i class="ti ti-package text-primary me-2"></i>
                        <span class="fw-bold">Shipping Details</span>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="ship_via" class="form-label">Ship Via</label>
                            <input type="text" class="form-control @error('ship_via') is-invalid @enderror" id="ship_via" name="ship_via" value="{{ old('ship_via') }}" required>
                            @error('ship_via')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="tracking_no" class="form-label">Tracking Number</label>
                            <input type="text" class="form-control @error('tracking_no') is-invalid @enderror" id="tracking_no" name="tracking_no" value="{{ old('tracking_no') }}" required>
                            @error('tracking_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="tax_id" class="form-label">Tax ID</label>
                            <input type="text" class="form-control @error('tax_id') is-invalid @enderror" id="tax_id" name="tax_id" value="{{ old('tax_id') }}">
                            @error('tax_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
            <!-- Invoice Items -->
            <div class="col-12 mt-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light d-flex align-items-center justify-content-between">
                        <div>
                            <i class="ti ti-list-details text-primary me-2"></i>
                            <span class="fw-bold">Invoice Items</span>
                        </div>
                        <button type="button" class="btn btn-success btn-sm" id="add-item-row"><i class="ti ti-plus"></i> Add Item</button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0 align-middle">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th scope="col" data-bs-toggle="tooltip" title="Item description">Description</th>
                                        <th scope="col" data-bs-toggle="tooltip" title="Quantity">Qty</th>
                                        <th scope="col" data-bs-toggle="tooltip" title="Rate per item">Rate ($)</th>
                                        <th scope="col" data-bs-toggle="tooltip" title="Total amount">Amount ($)</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="invoice-items-tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Invoice Totals -->
            <div class="col-12 col-lg-6 mt-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-light d-flex align-items-center">
                        <i class="ti ti-currency-dollar text-primary me-2"></i>
                        <span class="fw-bold">Invoice Totals</span>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="subtotal" class="form-label">Subtotal ($)</label>
                            <input type="number" class="form-control" id="subtotal" name="subtotal" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="shipping" class="form-label">Shipping ($)</label>
                            <input type="number" class="form-control @error('shipping') is-invalid @enderror" id="shipping" name="shipping" value="{{ old('shipping') }}" required>
                            @error('shipping')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="total" class="form-label">Total ($)</label>
                            <input type="number" class="form-control" id="total" name="total" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="paid" class="form-label">Paid ($)</label>
                            <input type="number" class="form-control @error('paid') is-invalid @enderror" id="paid" name="paid" value="{{ old('paid') }}" required>
                            @error('paid')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="balance_due" class="form-label">Balance Due</label>
                            <span id="balance-badge" class="badge rounded-pill bg-danger ms-2">$0.00</span>
                            <input type="hidden" id="balance_due" name="balance_due">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Notes -->
            <div class="col-12 col-lg-6 mt-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-light d-flex align-items-center">
                        <i class="ti ti-notes text-primary me-2"></i>
                        <span class="fw-bold">Notes</span>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control @error('notes') is-invalid @enderror" name="notes" rows="4" placeholder="Additional notes...">{{ old('notes') }}</textarea>
                        @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            <!-- Payment Instructions -->
            <div class="col-12 mt-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light d-flex align-items-center">
                        <i class="ti ti-credit-card text-primary me-2"></i>
                        <span class="fw-bold">Payment Instructions</span>
                    </div>
                    <div class="card-body row g-3">
                        <div class="col-md-3">
                            <label for="bank_name" class="form-label">Bank Name</label>
                            <input type="text" class="form-control @error('bank_name') is-invalid @enderror" id="bank_name" name="bank_name" value="{{ old('bank_name') }}" required>
                            @error('bank_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-3">
                            <label for="bank_code" class="form-label">Bank Code</label>
                            <input type="text" class="form-control @error('bank_code') is-invalid @enderror" id="bank_code" name="bank_code" value="{{ old('bank_code') }}" required>
                            @error('bank_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-3">
                            <label for="swift_bic" class="form-label">SWIFT/BIC</label>
                            <input type="text" class="form-control @error('swift_bic') is-invalid @enderror" id="swift_bic" name="swift_bic" value="{{ old('swift_bic') }}" required>
                            @error('swift_bic')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-3">
                            <label for="multi_currency_ac_no" class="form-label">Multi-Currency Account No</label>
                            <input type="text" class="form-control @error('multi_currency_ac_no') is-invalid @enderror" id="multi_currency_ac_no" name="multi_currency_ac_no" value="{{ old('multi_currency_ac_no') }}" required>
                            @error('multi_currency_ac_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sticky Action Bar Bottom -->
        <div class="sticky-bottom bg-white py-3 mt-4 border-top d-flex justify-content-end align-items-center" style="z-index: 10;">
            <button type="submit" class="btn btn-primary"><i class="ti ti-check me-1"></i>Save</button>
            <a href="{{ route('admin.invoices.index') }}" class="btn btn-outline-secondary ms-2"><i class="ti ti-x me-1"></i>Cancel</a>
        </div>
    </form>
</div>
@endsection 