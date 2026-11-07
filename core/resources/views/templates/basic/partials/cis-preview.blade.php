<!-- CIS Document Section -->
<section class="cis-section py-5 bg-white">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-8">
                <h2 class="display-6 fw-bold mb-3">Corporate Documentation</h2>
                <p class="lead text-muted mb-0">Access our official Client Information Sheet (CIS) with verified corporate credentials and compliance documentation.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ asset('../assets/documents/Trust-Capital-CIS.pdf') }}" 
                   target="_blank" 
                   class="btn btn-primary btn-lg px-4">
                    <i class="las la-file-pdf me-2"></i> View CIS Document
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="cis-card card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <div class="icon-wrapper bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px;">
                                <i class="las la-user-tie text-white fs-2"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-3">Executive Verification</h5>
                        <p class="text-muted">Verified details of company leadership and executive credentials.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="cis-card card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <div class="icon-wrapper bg-success rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px;">
                                <i class="las la-building text-white fs-2"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-3">Corporate Details</h5>
                        <p class="text-muted">Complete business registration and incorporation information.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="cis-card card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <div class="icon-wrapper bg-info rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px;">
                                <i class="las la-file-contract text-white fs-2"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-3">Compliance Ready</h5>
                        <p class="text-muted">Documentation suitable for due diligence and regulatory compliance.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- PDF Preview Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="pdf-preview card border-0 shadow">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="las la-file-pdf text-danger me-2"></i>
                            Document Preview: Trust Capital Limited CIS
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center">
                                <div class="pdf-icon mb-3">
                                    <i class="las la-file-pdf text-danger" style="font-size: 5rem;"></i>
                                </div>
                                <div class="file-info">
                                    <div class="badge bg-light text-dark mb-2">PDF Document</div>
                                    <div class="file-size text-muted">~500KB</div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h6>Document Contains:</h6>
                                <ul class="mb-4">
                                    <li>Executive profile and credentials</li>
                                    <li>Corporate registration details</li>
                                    <li>Business address verification</li>
                                    <li>Contact information</li>
                                    <li>Compliance declarations</li>
                                </ul>
                                <div class="d-flex gap-3">
                                    <a href="{{ asset('../assets/documents/Trust-Capital-CIS.pdf') }}" 
                                       target="_blank" 
                                       class="btn btn-primary px-4">
                                        <i class="las la-eye me-2"></i> View in Browser
                                    </a>
                                    <a href="{{ asset('../assets/documents/Trust-Capital-CIS.pdf') }}" 
                                       download="Trust-Capital-CIS-{{ date('Y-m-d') }}.pdf" 
                                       class="btn btn-outline-primary px-4">
                                        <i class="las la-download me-2"></i> Download PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.cis-section {
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
}
.cis-card {
    border-radius: 12px;
    transition: all 0.3s ease;
}
.cis-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}
.icon-wrapper {
    transition: transform 0.3s ease;
}
.cis-card:hover .icon-wrapper {
    transform: scale(1.1) rotate(5deg);
}
.pdf-preview {
    border-radius: 12px;
    overflow: hidden;
}
</style>