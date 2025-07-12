@extends('layouts.layoutMaster')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="card-title mb-2">Welcome to Admin Dashboard</h2>
                    <p class="card-text text-muted">Manage Invoices, Salaries, Credit Notes & RMA</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Cards -->
    <div class="row mt-4">
        <!-- Invoices Card -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="avatar avatar-md mx-auto mb-3">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="ti ti-file-invoice fs-3"></i>
                        </span>
                    </div>
                    <h5 class="card-title">Invoices</h5>
                    <p class="card-text text-muted">{{ $invoiceCount ?? 0 }} total invoices</p>
                    <a href="{{ route('admin.invoices.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="ti ti-arrow-right me-1"></i>Go to Invoices
                    </a>
                </div>
            </div>
        </div>

        <!-- Salary Slips Card -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="avatar avatar-md mx-auto mb-3">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="ti ti-cash fs-3"></i>
                        </span>
                    </div>
                    <h5 class="card-title">Salary Slips</h5>
                    <p class="card-text text-muted">{{ $salaryCount ?? 0 }} total salary slips</p>
                    <a href="{{ route('admin.salaries.index') }}" class="btn btn-sm btn-outline-success">
                        <i class="ti ti-arrow-right me-1"></i>Go to Salaries
                    </a>
                </div>
            </div>
        </div>

        <!-- Credit Notes Card -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="avatar avatar-md mx-auto mb-3">
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="ti ti-receipt fs-3"></i>
                        </span>
                    </div>
                    <h5 class="card-title">Credit Notes</h5>
                    <p class="card-text text-muted">{{ $creditNoteCount ?? 0 }} total credit notes</p>
                    <a href="{{ route('admin.credit-notes.index') }}" class="btn btn-sm btn-outline-info">
                        <i class="ti ti-arrow-right me-1"></i>Go to Credit Notes
                    </a>
                </div>
            </div>
        </div>

        <!-- RMA Forms Card -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="avatar avatar-md mx-auto mb-3">
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="ti ti-file-download fs-3"></i>
                        </span>
                    </div>
                    <h5 class="card-title">RMA Forms</h5>
                    <p class="card-text text-muted">Return Merchandise Authorization</p>
                    <a href="{{ route('rma.index') }}" class="btn btn-sm btn-outline-warning">
                        <i class="ti ti-arrow-right me-1"></i>Go to RMA Forms
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Row -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary w-100">
                                <i class="ti ti-plus me-2"></i>Create Invoice
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.salaries.create') }}" class="btn btn-success w-100">
                                <i class="ti ti-plus me-2"></i>Create Salary Slip
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.credit-notes.create') }}" class="btn btn-info w-100">
                                <i class="ti ti-plus me-2"></i>Create Credit Note
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('rma.download') }}" class="btn btn-warning w-100">
                                <i class="ti ti-download me-2"></i>Download RMA Form
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 