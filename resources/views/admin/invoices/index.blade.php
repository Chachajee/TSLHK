@extends('layouts/layoutMaster')

@section('title', 'Invoice List')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
])
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable
    const invoiceTable = $('#invoice-table').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        order: [[0, 'desc']],
        language: {
            search: '',
            searchPlaceholder: 'Search invoices...',
        }
    });

    // View invoice modal
    window.viewInvoice = function(invoiceId) {
        fetch(`/admin/invoices/${invoiceId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const invoice = data.invoice;
                    const billTo = data.billTo;
                    const shipTo = data.shipTo;
                    const items = data.items;
                    const payment = data.paymentInstructions;

                    // Populate modal content
                    document.getElementById('modal-invoice-no').textContent = invoice.invoice_no;
                    document.getElementById('modal-invoice-date').textContent = invoice.invoice_date;
                    document.getElementById('modal-ship-via').textContent = invoice.ship_via;
                    document.getElementById('modal-tracking-no').textContent = invoice.tracking_no;
                    document.getElementById('modal-tax-id').textContent = invoice.tax_id || 'N/A';
                    document.getElementById('modal-subtotal').textContent = '$' + parseFloat(invoice.subtotal).toFixed(2);
                    document.getElementById('modal-shipping').textContent = '$' + parseFloat(invoice.shipping).toFixed(2);
                    document.getElementById('modal-total').textContent = '$' + parseFloat(invoice.total).toFixed(2);
                    document.getElementById('modal-paid').textContent = '$' + parseFloat(invoice.paid).toFixed(2);
                    document.getElementById('modal-balance-due').textContent = '$' + parseFloat(invoice.balance_due).toFixed(2);
                    document.getElementById('modal-notes').textContent = invoice.notes || 'No notes';

                    // Bill To
                    document.getElementById('modal-bill-company').textContent = billTo.company_name;
                    document.getElementById('modal-bill-address').textContent = billTo.address;
                    document.getElementById('modal-bill-vat').textContent = billTo.vat_no;
                    document.getElementById('modal-bill-eori').textContent = billTo.eori;
                    document.getElementById('modal-bill-phone').textContent = billTo.phone;
                    document.getElementById('modal-bill-email').textContent = billTo.email;

                    // Ship To
                    document.getElementById('modal-ship-company').textContent = shipTo.company_name;
                    document.getElementById('modal-ship-address').textContent = shipTo.address;
                    document.getElementById('modal-ship-vat').textContent = shipTo.vat_no;
                    document.getElementById('modal-ship-eori').textContent = shipTo.eori;
                    document.getElementById('modal-ship-email').textContent = shipTo.email;

                    // Payment Instructions
                    document.getElementById('modal-bank-name').textContent = payment.bank_name;
                    document.getElementById('modal-bank-code').textContent = payment.bank_code;
                    document.getElementById('modal-swift-bic').textContent = payment.swift_bic;
                    document.getElementById('modal-account-no').textContent = payment.multi_currency_ac_no;

                    // Invoice Items
                    const itemsTable = document.getElementById('modal-items-table');
                    itemsTable.innerHTML = '';
                    items.forEach(item => {
                        const row = itemsTable.insertRow();
                        row.innerHTML = `
                            <td>${item.description}</td>
                            <td>${item.quantity}</td>
                            <td>$${parseFloat(item.rate).toFixed(2)}</td>
                            <td>$${parseFloat(item.amount).toFixed(2)}</td>
                        `;
                    });

                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('invoiceModal'));
                    modal.show();
                } else {
                    Swal.fire('Error', 'Failed to load invoice details', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Failed to load invoice details', 'error');
            });
    };

    // Delete invoice
    window.deleteInvoice = function(invoiceId, invoiceNo) {
        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to delete invoice ${invoiceNo}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/invoices/${invoiceId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Deleted!', data.message, 'success');
                        // Reload the page to refresh the table
                        location.reload();
                    } else {
                        Swal.fire('Error!', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error!', 'Failed to delete invoice', 'error');
                });
            }
        });
    };
});
</script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Invoice List</h4>
                    <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i>Create Invoice
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered" id="invoice-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Invoice No</th>
                                    <th>Date</th>
                                    <th>Bill To</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Balance</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->invoice_no }}</td>
                                    <td>{{ $invoice->invoice_date->format('M d, Y') }}</td>
                                    <td>{{ $invoice->billTo->company_name ?? 'N/A' }}</td>
                                    <td>${{ number_format($invoice->total, 2) }}</td>
                                    <td>${{ number_format($invoice->paid, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $invoice->balance_due > 0 ? 'warning' : 'success' }}">
                                            ${{ number_format($invoice->balance_due, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-info" onclick="viewInvoice({{ $invoice->id }})">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                            <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="btn btn-sm btn-warning">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger" onclick="deleteInvoice({{ $invoice->id }}, '{{ $invoice->invoice_no }}')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $invoices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Invoice Detail Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceModalLabel">Invoice Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Invoice Header -->
                    <div class="col-12 mb-4">
                        <h6 class="border-bottom pb-2">Invoice Information</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Invoice No:</strong><br>
                                <span id="modal-invoice-no"></span>
                            </div>
                            <div class="col-md-3">
                                <strong>Date:</strong><br>
                                <span id="modal-invoice-date"></span>
                            </div>
                            <div class="col-md-3">
                                <strong>Ship Via:</strong><br>
                                <span id="modal-ship-via"></span>
                            </div>
                            <div class="col-md-3">
                                <strong>Tracking No:</strong><br>
                                <span id="modal-tracking-no"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Bill To & Ship To -->
                    <div class="col-md-6 mb-4">
                        <h6 class="border-bottom pb-2">Bill To</h6>
                        <div id="modal-bill-company" class="fw-bold"></div>
                        <div id="modal-bill-address" class="text-muted"></div>
                        <div class="mt-2">
                            <small><strong>VAT:</strong> <span id="modal-bill-vat"></span></small><br>
                            <small><strong>EORI:</strong> <span id="modal-bill-eori"></span></small><br>
                            <small><strong>Phone:</strong> <span id="modal-bill-phone"></span></small><br>
                            <small><strong>Email:</strong> <span id="modal-bill-email"></span></small>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <h6 class="border-bottom pb-2">Ship To</h6>
                        <div id="modal-ship-company" class="fw-bold"></div>
                        <div id="modal-ship-address" class="text-muted"></div>
                        <div class="mt-2">
                            <small><strong>VAT:</strong> <span id="modal-ship-vat"></span></small><br>
                            <small><strong>EORI:</strong> <span id="modal-ship-eori"></span></small><br>
                            <small><strong>Email:</strong> <span id="modal-ship-email"></span></small>
                        </div>
                    </div>

                    <!-- Invoice Items -->
                    <div class="col-12 mb-4">
                        <h6 class="border-bottom pb-2">Invoice Items</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Rate</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="modal-items-table">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Totals -->
                    <div class="col-md-6 mb-4">
                        <h6 class="border-bottom pb-2">Invoice Totals</h6>
                        <div class="row">
                            <div class="col-6"><strong>Subtotal:</strong></div>
                            <div class="col-6" id="modal-subtotal"></div>
                        </div>
                        <div class="row">
                            <div class="col-6"><strong>Shipping:</strong></div>
                            <div class="col-6" id="modal-shipping"></div>
                        </div>
                        <div class="row">
                            <div class="col-6"><strong>Total:</strong></div>
                            <div class="col-6" id="modal-total"></div>
                        </div>
                        <div class="row">
                            <div class="col-6"><strong>Paid:</strong></div>
                            <div class="col-6" id="modal-paid"></div>
                        </div>
                        <div class="row">
                            <div class="col-6"><strong>Balance Due:</strong></div>
                            <div class="col-6" id="modal-balance-due"></div>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    <div class="col-md-6 mb-4">
                        <h6 class="border-bottom pb-2">Payment Instructions</h6>
                        <div><strong>Bank:</strong> <span id="modal-bank-name"></span></div>
                        <div><strong>Bank Code:</strong> <span id="modal-bank-code"></span></div>
                        <div><strong>SWIFT/BIC:</strong> <span id="modal-swift-bic"></span></div>
                        <div><strong>Account No:</strong> <span id="modal-account-no"></span></div>
                    </div>

                    <!-- Notes -->
                    <div class="col-12">
                        <h6 class="border-bottom pb-2">Notes</h6>
                        <div id="modal-notes"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection 