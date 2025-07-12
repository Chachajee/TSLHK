@extends('layouts.blankLayout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12 text-center">
            <h2>Welcome, Admin!</h2>
            <p class="mb-4">You are logged in to the admin dashboard.</p>
            
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="ti ti-file-invoice me-2"></i>
                                Invoice Management
                            </h5>
                            <p class="card-text">Manage company invoices, create new invoices, and generate PDF reports.</p>
                            <a href="{{ route('admin.invoices.index') }}" class="btn btn-primary">
                                <i class="ti ti-arrow-right me-1"></i>Manage Invoices
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="ti ti-cash me-2"></i>
                                Salary Slips
                            </h5>
                            <p class="card-text">Manage employee salary slips, create new slips, and generate PDF reports.</p>
                            <a href="{{ route('admin.salaries.index') }}" class="btn btn-success">
                                <i class="ti ti-arrow-right me-1"></i>Manage Salary Slips
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="ti ti-receipt me-2"></i>
                                Credit Notes
                            </h5>
                            <p class="card-text">Manage customer credit notes, track payments and balances, generate PDF reports.</p>
                            <a href="{{ route('admin.credit-notes.index') }}" class="btn btn-info">
                                <i class="ti ti-arrow-right me-1"></i>Manage Credit Notes
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="ti ti-file-download me-2"></i>
                                RMA Form
                            </h5>
                            <p class="card-text">Access Return Merchandise Authorization forms and policy information.</p>
                            <a href="{{ route('rma.index') }}" class="btn btn-warning">
                                <i class="ti ti-arrow-right me-1"></i>RMA Forms
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="ti ti-logout me-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 