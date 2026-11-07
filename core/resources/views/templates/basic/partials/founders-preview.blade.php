<!-- Founders Preview Section for Homepage -->
<section class="founders-preview py-5 bg-light">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-8">
                <h2 class="display-6 fw-bold mb-3">Meet Our Executive Leadership</h2>
                <p class="lead text-muted mb-0">Driving innovation and shaping the future of equity investment through expertise and commitment.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('founders') }}" class="btn btn-primary btn-lg px-4">
                    View Full Team <i class="las la-arrow-right ms-2"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            
            <!-- Druzina sesok Preview -->
            <div class="col-md-6">
                <div class="founder-preview-card card border-0 shadow-sm h-100">
                    <div class="row g-0 h-100">
                        <div class="col-md-5">
                            <div class="founder-image h-100">
                                <img src="{{ asset('../assets/images/sesok.png') }}" 
                                     alt="Šešok Druzina" 
                                     class="img-fluid h-100 w-100 object-fit-cover">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="card-body p-4">
                                <h4 class="fw-bold mb-1">Šešok Druzina</h4>
                                <p class="text-primary fw-bold mb-2">CEO & Co-Founder</p>
                                <p class="text-muted mb-3">
                                    CEO & Co-Founder of Šešok Capital Partners.
18 years of pioneering strategic equity deployment and growth capital structuring for industry-transforming ventures.
                                </p>
                                <div class="founder-badges mb-3">
                                    <span class="badge bg-light text-dark me-1 mb-1">Venture Capital</span>
                                    <span class="badge bg-light text-dark me-1 mb-1">Large Scale Investment</span>
                                    <span class="badge bg-light text-dark mb-1">Equity Funding</span>
                                </div>
                                <div class="founder-stats">
                                    <small class="text-muted">
                                        <i class="las la-history me-1"></i> 18+ Years Experience
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            
            
            <!-- Dora Nikolaus Preview -->
            <div class="col-md-6">
                <div class="founder-preview-card card border-0 shadow-sm h-100">
                    <div class="row g-0 h-100">
                        <div class="col-md-5">
                            <div class="founder-image h-100">
                                <img src="{{ asset('../assets/images/dora.png') }}" 
                                     alt="Dora Nikolaus" 
                                     class="img-fluid h-100 w-100 object-fit-cover">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="card-body p-4">
                                <h4 class="fw-bold mb-1">Dora Nikolaus</h4>
                                <p class="text-primary fw-bold mb-2">CEO & Co-Founder</p>
                                <p class="text-muted mb-3">
                                    Co-Owner & Managing Director of Trust Capital Limited. 
                                    10+ years experience in structuring growth capital for transformative projects.
                                </p>
                                <div class="founder-badges mb-3">
                                    <span class="badge bg-light text-dark me-1 mb-1">Venture Capital</span>
                                    <span class="badge bg-light text-dark me-1 mb-1">Strategic Growth</span>
                                    <span class="badge bg-light text-dark mb-1">Equity Funding</span>
                                </div>
                                <div class="founder-stats">
                                    <small class="text-muted">
                                        <i class="las la-history me-1"></i> 10+ Years Experience
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Investor Preview -->
            <div class="col-md-6">
                <div class="founder-preview-card card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="row align-items-center h-100">
                            <div class="col-md-4 text-center">
                                <div class="investor-avatar mb-3 mb-md-0">
                                    <img src="https://images.unsplash.com/photo-1582750433449-648ed127bb54?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                                         alt="Sarah Williams" 
                                         class="rounded-circle img-fluid border border-3 border-primary"
                                         style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h4 class="fw-bold mb-1">DR Jeffery Williams</h4>
                                <p class="text-success fw-bold mb-2">Lead Investor & Board Advisor</p>
                                <p class="text-muted mb-3">
                                    Angel investor with 30+ early-stage investments. 
                                    Former Google executive with deep Silicon Valley connections.
                                </p>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="text-center">
                                            <div class="h5 fw-bold text-primary mb-1">45</div>
                                            <small class="text-muted">Investments</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-center">
                                            <div class="h5 fw-bold text-primary mb-1">$150M</div>
                                            <small class="text-muted">Capital Deployed</small>
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
</section>

<style>
.founders-preview {
    background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%);
}
.founder-preview-card {
    border-radius: 15px;
    transition: all 0.3s ease;
    overflow: hidden;
}
.founder-preview-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
}
.founder-preview-card .founder-image img {
    transition: transform 0.5s ease;
}
.founder-preview-card:hover .founder-image img {
    transform: scale(1.05);
}
.object-fit-cover {
    object-fit: cover;
}
.border-primary {
    border-color: #667eea !important;
}
.bg-light {
    background-color: #f8fafc !important;
}
</style>