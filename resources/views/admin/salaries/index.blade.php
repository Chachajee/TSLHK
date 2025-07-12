@extends('layouts/layoutMaster')

@section('title', 'Salary Slips')

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
    let currentSalaryId = null;
    
    // Initialize DataTable
    const salaryTable = $('#salary-table').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        order: [[0, 'desc']],
        language: {
            search: '',
            searchPlaceholder: 'Search salary slips...',
        }
    });

    // View salary modal
    window.viewSalary = function(salaryId) {
        currentSalaryId = salaryId;
        fetch(`/admin/salaries/${salaryId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const salary = data.salary;
                    const payments = data.payments;
                    const deductions = data.deductions;

                    // Populate modal content with null checks and professional formatting
                    document.getElementById('modal-employee-name').textContent = salary.employee_name || 'N/A';
                    document.getElementById('modal-employee-id').textContent = salary.employee_id_number || 'N/A';
                    document.getElementById('modal-designation').textContent = salary.designation || 'N/A';
                    document.getElementById('modal-period').textContent = salary.period || 'N/A';
                    document.getElementById('modal-generated-date').textContent = salary.generated_date ? new Date(salary.generated_date).toLocaleDateString() : 'N/A';
                    
                    // Financial Summary
                                    document.getElementById('modal-total-paid').innerHTML = `<span class='badge bg-success'>₹${parseFloat(data.total_paid || 0).toFixed(2)}</span>`;
                document.getElementById('modal-total-deductions').innerHTML = `<span class='badge bg-warning'>₹${parseFloat(data.total_deductions || 0).toFixed(2)}</span>`;
                document.getElementById('modal-net-salary').innerHTML = `<span class='badge bg-primary'>₹${parseFloat(data.net_salary || 0).toFixed(2)}</span>`;

                    // Salary Payments
                    const paymentsTable = document.getElementById('modal-payments-table');
                    paymentsTable.innerHTML = '';
                    if (payments && payments.length > 0) {
                        payments.forEach(payment => {
                            const row = paymentsTable.insertRow();
                            row.innerHTML = `
                                <td><span class='fw-semibold'>${payment.payment_method || 'N/A'}</span></td>
                                <td class='text-end'><span class='badge bg-success'>$${parseFloat(payment.amount || 0).toFixed(2)}</span></td>
                                <td class='text-center'>${payment.received_date ? new Date(payment.received_date).toLocaleDateString() : 'N/A'}</td>
                            `;
                        });
                    } else {
                        const row = paymentsTable.insertRow();
                        row.innerHTML = `<td colspan='3' class='text-center text-muted'>No payments found</td>`;
                    }

                    // Salary Deductions
                    const deductionsTable = document.getElementById('modal-deductions-table');
                    deductionsTable.innerHTML = '';
                    if (deductions && deductions.length > 0) {
                        deductions.forEach(deduction => {
                            const row = deductionsTable.insertRow();
                            row.innerHTML = `
                                <td><span class='fw-semibold'>${deduction.deduction_type || 'N/A'}</span></td>
                                <td>${deduction.description || 'N/A'}</td>
                                <td class='text-end'><span class='badge bg-warning'>$${parseFloat(deduction.amount || 0).toFixed(2)}</span></td>
                            `;
                        });
                    } else {
                        const row = deductionsTable.insertRow();
                        row.innerHTML = `<td colspan='3' class='text-center text-muted'>No deductions found</td>`;
                    }

                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('salaryModal'));
                    modal.show();
                } else {
                    Swal.fire('Error', 'Failed to load salary slip details', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Failed to load salary slip details', 'error');
            });
    };

    // Download salary slip
    window.downloadSalary = function(salaryId) {
        const downloadBtn = document.getElementById('modal-download-btn');
        const originalText = downloadBtn.innerHTML;
        
        // Show loading state
        downloadBtn.innerHTML = '<i class="ti ti-loader ti-spin me-1"></i>Generating PDF...';
        downloadBtn.disabled = true;
        
        // Trigger download
        window.location.href = `/admin/salaries/${salaryId}/download`;
        
        // Reset button after a short delay
        setTimeout(() => {
            downloadBtn.innerHTML = originalText;
            downloadBtn.disabled = false;
        }, 2000);
    };

    // Delete salary slip
    window.deleteSalary = function(salaryId, employeeName) {
        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to delete salary slip for ${employeeName}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/salaries/${salaryId}`, {
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
                    Swal.fire('Error!', 'Failed to delete salary slip', 'error');
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
                    <h4 class="card-title">Salary Slips</h4>
                    <a href="{{ route('admin.salaries.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i>Create Salary Slip
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
                        <table class="table table-bordered" id="salary-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Employee</th>
                                    <th>ID</th>
                                    <th>Designation</th>
                                    <th>Period</th>
                                    <th>Total Paid</th>
                                    <th>Deductions</th>
                                    <th>Net Salary</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salarySlips as $salary)
                                <tr>
                                    <td>{{ $salary->employee_name }}</td>
                                    <td>{{ $salary->employee_id_number }}</td>
                                    <td>{{ $salary->designation }}</td>
                                    <td>{{ $salary->period }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            ₹{{ number_format($salary->total_paid, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">
                                            ₹{{ number_format($salary->total_deductions, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">
                                            ₹{{ number_format($salary->net_salary, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-info" onclick="viewSalary({{ $salary->id }})">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                            <a href="{{ route('admin.salaries.edit', $salary->id) }}" class="btn btn-sm btn-warning">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.salaries.download', $salary->id) }}" class="btn btn-sm btn-outline-primary" title="Download PDF">
                                                <i class="ti ti-download"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger" onclick="deleteSalary({{ $salary->id }}, '{{ $salary->employee_name }}')">
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
                        {{ $salarySlips->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Salary Modal -->
<div class="modal fade" id="salaryModal" tabindex="-1" aria-labelledby="salaryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="salaryModalLabel">Salary Slip Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-semibold">Employee Information</h6>
                        <table class="table table-sm">
                            <tr>
                                <td class="fw-semibold">Name:</td>
                                <td id="modal-employee-name"></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">ID:</td>
                                <td id="modal-employee-id"></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Designation:</td>
                                <td id="modal-designation"></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Period:</td>
                                <td id="modal-period"></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Generated Date:</td>
                                <td id="modal-generated-date"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-semibold">Financial Summary</h6>
                        <table class="table table-sm">
                            <tr>
                                <td class="fw-semibold">Total Paid:</td>
                                <td id="modal-total-paid"></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Total Deductions:</td>
                                <td id="modal-total-deductions"></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Net Salary:</td>
                                <td id="modal-net-salary"></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <h6 class="fw-semibold">Salary Payments</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Method</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody id="modal-payments-table">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-semibold">Deductions</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="modal-deductions-table">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="modal-download-btn" onclick="downloadSalary(currentSalaryId)">
                    <i class="ti ti-download me-1"></i>Download PDF
                </button>
            </div>
        </div>
    </div>
</div>
@endsection 