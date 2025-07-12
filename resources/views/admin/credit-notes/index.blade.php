@extends('layouts/layoutMaster')

@section('title', 'Credit Notes')

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
<style>
.ti-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentCreditNoteId = null;
    
    // Initialize DataTable
    const creditNoteTable = $('#credit-note-table').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        order: [[0, 'desc']],
        language: {
            search: '',
            searchPlaceholder: 'Search credit notes...',
        }
    });

    // View credit note modal
    window.viewCreditNote = function(creditNoteId) {
        currentCreditNoteId = creditNoteId;
        fetch(`/admin/credit-notes/${creditNoteId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const creditNote = data.creditNote;

                    // Populate modal content with null checks and professional formatting
                    document.getElementById('modal-customer-name').textContent = creditNote.customer_name || 'N/A';
                    document.getElementById('modal-amount-paid').innerHTML = `<span class='badge bg-success'>${data.formatted_amount_paid}</span>`;
                    document.getElementById('modal-amount-spent').innerHTML = `<span class='badge bg-warning'>${data.formatted_amount_spent}</span>`;
                    document.getElementById('modal-credit-balance').innerHTML = `<span class='badge bg-primary'>${data.formatted_credit_balance}</span>`;
                    document.getElementById('modal-notes').textContent = creditNote.notes || 'No notes';
                    document.getElementById('modal-created-date').textContent = creditNote.created_at ? new Date(creditNote.created_at).toLocaleDateString() : 'N/A';
                    document.getElementById('modal-updated-date').textContent = creditNote.updated_at ? new Date(creditNote.updated_at).toLocaleDateString() : 'N/A';

                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('creditNoteModal'));
                    modal.show();
                } else {
                    Swal.fire('Error', 'Failed to load credit note details', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Failed to load credit note details', 'error');
            });
    };

    // Download credit note
    window.downloadCreditNote = function(creditNoteId) {
        const downloadBtn = document.getElementById('modal-download-btn');
        const originalText = downloadBtn.innerHTML;
        
        // Show loading state
        downloadBtn.innerHTML = '<i class="ti ti-loader ti-spin me-1"></i>Generating PDF...';
        downloadBtn.disabled = true;
        
        // Trigger download
        window.location.href = `/admin/credit-notes/${creditNoteId}/download`;
        
        // Reset button after a short delay
        setTimeout(() => {
            downloadBtn.innerHTML = originalText;
            downloadBtn.disabled = false;
        }, 2000);
    };

    // Delete credit note
    window.deleteCreditNote = function(creditNoteId, customerName) {
        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to delete credit note for ${customerName}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/credit-notes/${creditNoteId}`, {
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
                    Swal.fire('Error!', 'Failed to delete credit note', 'error');
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
                    <h4 class="card-title">Credit Notes</h4>
                    <a href="{{ route('admin.credit-notes.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i>Create Credit Note
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
                        <table class="table table-bordered" id="credit-note-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Amount Paid</th>
                                    <th>Amount Spent</th>
                                    <th>Credit Balance</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($creditNotes as $creditNote)
                                <tr>
                                    <td>{{ $creditNote->customer_name }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            ${{ number_format($creditNote->amount_paid, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">
                                            ${{ number_format($creditNote->amount_spent, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">
                                            ${{ number_format($creditNote->credit_balance, 2) }}
                                        </span>
                                    </td>
                                    <td>{{ $creditNote->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-info" onclick="viewCreditNote({{ $creditNote->id }})">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                            <a href="{{ route('admin.credit-notes.edit', $creditNote->id) }}" class="btn btn-sm btn-warning">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.credit-notes.download', $creditNote->id) }}" class="btn btn-sm btn-outline-primary" title="Download PDF">
                                                <i class="ti ti-download"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger" onclick="deleteCreditNote({{ $creditNote->id }}, '{{ $creditNote->customer_name }}')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $creditNotes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Credit Note Modal -->
<div class="modal fade" id="creditNoteModal" tabindex="-1" aria-labelledby="creditNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="creditNoteModalLabel">Credit Note Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-semibold">Customer Information</h6>
                        <table class="table table-sm">
                            <tr>
                                <td class="fw-semibold">Customer Name:</td>
                                <td id="modal-customer-name"></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Created Date:</td>
                                <td id="modal-created-date"></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Last Updated:</td>
                                <td id="modal-updated-date"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-semibold">Financial Summary</h6>
                        <table class="table table-sm">
                            <tr>
                                <td class="fw-semibold">Amount Paid:</td>
                                <td id="modal-amount-paid"></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Amount Spent:</td>
                                <td id="modal-amount-spent"></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Credit Balance:</td>
                                <td id="modal-credit-balance"></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="fw-semibold">Notes</h6>
                        <div class="card bg-light">
                            <div class="card-body">
                                <p id="modal-notes" class="mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="modal-download-btn" onclick="downloadCreditNote(currentCreditNoteId)">
                    <i class="ti ti-download me-1"></i>Download PDF
                </button>
            </div>
        </div>
    </div>
</div>
@endsection 