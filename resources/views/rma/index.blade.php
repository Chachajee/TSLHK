@extends('layouts/layoutMaster')

@section('title', 'Return Merchandise Authorization (RMA)')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
])
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Download RMA form with loading state
    window.downloadRMAForm = function() {
        const downloadBtn = document.getElementById('download-rma-btn');
        const originalText = downloadBtn.innerHTML;
        
        // Show loading state
        downloadBtn.innerHTML = '<i class="ti ti-loader ti-spin me-1"></i>Downloading...';
        downloadBtn.disabled = true;
        
        // Trigger download
        window.location.href = '{{ route("rma.download") }}';
        
        // Reset button after a short delay
        setTimeout(() => {
            downloadBtn.innerHTML = originalText;
            downloadBtn.disabled = false;
        }, 2000);
    };
});
</script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="ti ti-file-download me-2"></i>
                        Return Merchandise Authorization (RMA)
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- RMA Policy Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="alert alert-info" role="alert">
                                <h6 class="alert-heading">
                                    <i class="ti ti-info-circle me-2"></i>
                                    RMA Policy & Instructions
                                </h6>
                                <p class="mb-0">
                                    Please review our Return Merchandise Authorization (RMA) policy before submitting a return request. 
                                    All returns must be accompanied by a completed RMA form and approved by our customer service team.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Policy Details -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3">Return Policy Guidelines</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <i class="ti ti-clock me-2"></i>
                                                Return Timeframe
                                            </h6>
                                            <ul class="list-unstyled mb-0">
                                                <li><i class="ti ti-check text-success me-2"></i>30 days from purchase date</li>
                                                <li><i class="ti ti-check text-success me-2"></i>Original packaging required</li>
                                                <li><i class="ti ti-check text-success me-2"></i>Product must be unused</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <i class="ti ti-settings me-2"></i>
                                                Return Process
                                            </h6>
                                            <ul class="list-unstyled mb-0">
                                                <li><i class="ti ti-check text-success me-2"></i>Complete RMA form</li>
                                                <li><i class="ti ti-check text-success me-2"></i>Submit for approval</li>
                                                <li><i class="ti ti-check text-success me-2"></i>Ship with RMA number</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RMA Form Download Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="ti ti-download me-2"></i>
                                        Download RMA Form
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h6>Return Merchandise Authorization Form</h6>
                                            <p class="text-muted mb-0">
                                                Download the official RMA form in Excel format (.xlsx). 
                                                Fill out all required fields and submit according to our return policy guidelines.
                                            </p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <button type="button" class="btn btn-primary btn-lg" id="download-rma-btn" onclick="downloadRMAForm()">
                                                <i class="ti ti-download me-1"></i>Download RMA Form (.xlsx)
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Important Notes -->
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-warning" role="alert">
                                <h6 class="alert-heading">
                                    <i class="ti ti-alert-triangle me-2"></i>
                                    Important Notes
                                </h6>
                                <ul class="mb-0">
                                    <li>All returns must be accompanied by a completed RMA form</li>
                                    <li>RMA number must be clearly visible on the package</li>
                                    <li>Returns without proper RMA documentation will be refused</li>
                                    <li>Shipping costs for returns are the responsibility of the customer</li>
                                    <li>Processing time for returns is 5-7 business days after receipt</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="ti ti-headset me-2"></i>
                                        Need Help?
                                    </h6>
                                    <p class="mb-2">If you have questions about our RMA process or need assistance:</p>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Email:</strong> support@tslcompany.com
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Phone:</strong> +1 (555) 123-4567
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Hours:</strong> Mon-Fri 9AM-5PM EST
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 