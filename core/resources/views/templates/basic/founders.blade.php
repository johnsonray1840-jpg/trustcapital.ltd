@extends($activeTemplate . 'layouts.master')

@section('content')
<div class="founders-page">
    <!-- Hero Section -->
    <section class="hero-section py-5 bg-gradient-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Meet Our Visionary Leaders</h1>
                    <p class="lead mb-4">Driving innovation and shaping the future of equity investment through expertise, passion, and commitment.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="hero-stats bg-white text-dark p-4 rounded shadow">
                        <h3 class="text-primary mb-3">Leadership Impact</h3>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <div class="stat-number display-6 fw-bold">7+</div>
                                <div class="stat-label">Years Experience</div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="stat-number display-6 fw-bold">$2B+</div>
                                <div class="stat-label">Capital Deployed</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Founders Grid -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Our Executive Leadership</h2>
                <p class="text-muted">Meet the minds behind our investment success</p>
            </div>

            <div class="row justify-content-center">
                <!-- Founder 1: Sesok -->
                <div class="col-lg-6 mb-5">
                    <div class="founder-card card border-0 shadow-lg h-100 hover-lift">
                        <div class="row g-0 h-100">
                            <div class="col-md-5">
                                <div class="founder-image h-100">
                                    <img src="{{ asset('../assets/images/sesok.png') }}" 
                                         alt="Sesok Druzina" class="img-fluid h-100 w-100 object-fit-cover">
                                    <div class="social-overlay p-3">
                                        <a href="#" class="btn btn-light btn-sm rounded-circle me-2"><i class="lab la-linkedin-in"></i></a>
                                        <a href="#" class="btn btn-light btn-sm rounded-circle me-2"><i class="lab la-twitter"></i></a>
                                        <a href="#" class="btn btn-light btn-sm rounded-circle"><i class="las la-globe"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="card-body p-4">
                                    <h3 class="card-title mb-1">Sesok Druzina</h3>
                                    <p class="text-primary fw-bold mb-3">Chairman & Co-Founder</p>
                                    
                                    <div class="badge bg-light text-dark mb-3 p-2">
                                        <i class="las la-industry me-1"></i> Iskra Group Legacy
                                    </div>
                                    
                                    <p class="card-text mb-4">
                                        The architect behind the Šešok family's equity empire. In 2006, Sesok led the management buyout of the historic Iskra company, executing a strategic leveraged buyout that laid the foundation for the family's wealth. His industrial expertise and deal-making acumen transformed Iskra into a powerhouse generating €295 million in revenue. With decades of operational experience, he now provides invaluable strategic guidance and scalability insights to portfolio companies, having masterfully built the two pillars of the family's wealth: industrial holdings and real estate investments.
                                    </p>
                                    
                                    <div class="expertise-tags">
                                        <span class="badge bg-light text-dark me-2 mb-2">Leveraged Buyouts</span>
                                        <span class="badge bg-light text-dark me-2 mb-2">Corporate Turnaround</span>
                                        <span class="badge bg-light text-dark me-2 mb-2">Industrial Strategy</span>
                                        <span class="badge bg-light text-dark mb-2">Real Estate</span>
                                    </div>
                                    
                                    <div class="mt-4 pt-3 border-top">
                                        <small class="text-muted">
                                            <i class="las la-history me-1"></i> 35+ Years Experience
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Founder 2: Dora Nikolaus -->
                <div class="col-lg-6 mb-5">
                    <div class="founder-card card border-0 shadow-lg h-100 hover-lift">
                        <div class="row g-0 h-100">
                            <div class="col-md-5">
                                <div class="founder-image h-100">
                                    <img src="{{ asset('../assets/images/dora.png') }}" 
                                         alt="Dora Nikolaus" class="img-fluid h-100 w-100 object-fit-cover">
                                    <div class="social-overlay p-3">
                                        <a href="#" class="btn btn-light btn-sm rounded-circle me-2"><i class="lab la-linkedin-in"></i></a>
                                        <a href="#" class="btn btn-light btn-sm rounded-circle me-2"><i class="lab la-twitter"></i></a>
                                        <a href="#" class="btn btn-light btn-sm rounded-circle"><i class="las la-globe"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="card-body p-4">
                                    <h3 class="card-title mb-1">Dora Nikolaus</h3>
                                    <p class="text-primary fw-bold mb-3">CEO & Co-Founder</p>
                                    
                                    <div class="badge bg-light text-dark mb-3 p-2">
                                        <i class="las la-building me-1"></i> Trust Capital Partners
                                    </div>
                                    
                                    <p class="card-text mb-4">
                                        A dynamic financial strategist who played a pivotal role in consolidating the family's control of Iskra by acquiring a 41.2% stake and securing 47% total ownership. As administrator of Finadria, the family's Taiwan-based holding company, Dora brings a global perspective and modern investment vision. She combines European roots with deep Asian market expertise, having led Trust Capital Limited since its 2016 incorporation. Specializes in due diligence, complex deal structuring, and fostering long-term partnerships between investors and innovators.
                                    </p>
                                    
                                    <div class="expertise-tags">
                                        <span class="badge bg-light text-dark me-2 mb-2">Venture Capital</span>
                                        <span class="badge bg-light text-dark me-2 mb-2">Tech Startups</span>
                                        <span class="badge bg-light text-dark me-2 mb-2">Strategic Growth</span>
                                        <span class="badge bg-light text-dark mb-2">IPO Advisory</span>
                                    </div>
                                    
                                    <div class="mt-4 pt-3 border-top">
                                        <small class="text-muted">
                                            <i class="las la-history me-1"></i> 10+ Years Experience
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lead Investor -->
                <div class="col-lg-8">
                    <div class="investor-card card border-0 shadow-lg">
                        <div class="card-body p-5">
                            <div class="row align-items-center">
                                <div class="col-md-3 text-center mb-4 mb-md-0">
                                    <div class="investor-avatar mx-auto">
                                        <img src="https://images.unsplash.com/photo-1582750433449-648ed127bb54?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                                             alt="DR Jeffery Williams" class="rounded-circle img-fluid border border-4 border-primary">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <h3 class="mb-2">DR Jeffery Williams</h3>
                                    <p class="text-success fw-bold mb-3">Lead Investor & Board Advisor</p>
                                    
                                    <p class="mb-4">
                                        Angel investor with 30+ early-stage investments. 
                                        Former Google executive with deep connections in Silicon Valley. 
                                        Focus on disruptive technology and sustainable ventures.
                                    </p>
                                    
                                    <div class="row">
                                        <div class="col-6 col-md-3 mb-3">
                                            <div class="text-center">
                                                <div class="display-6 fw-bold text-primary">45</div>
                                                <small class="text-muted">Investments</small>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 mb-3">
                                            <div class="text-center">
                                                <div class="display-6 fw-bold text-primary">$150M</div>
                                                <small class="text-muted">Capital Invested</small>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 mb-3">
                                            <div class="text-center">
                                                <div class="display-6 fw-bold text-primary">8</div>
                                                <small class="text-muted">Board Seats</small>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 mb-3">
                                            <div class="text-center">
                                                <div class="display-6 fw-bold text-primary">22</div>
                                                <small class="text-muted">Exits</small>
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

    <!-- CTA Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="mb-4">Partner with Industry Leaders</h2>
                    <p class="lead mb-4">Our team brings decades of experience in identifying, funding, and scaling groundbreaking ventures.</p>
                    <a href="{{ route('contact') }}" class="btn btn-primary btn-lg px-5">
                        <i class="las la-handshake me-2"></i> Connect With Us
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.founders-page {
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
}
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.founder-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 20px;
    overflow: hidden;
}
.founder-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
}
.founder-image {
    position: relative;
    overflow: hidden;
}
.founder-image img {
    transition: transform 0.5s ease;
}
.founder-card:hover .founder-image img {
    transform: scale(1.05);
}
.social-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.7));
    opacity: 0;
    transition: opacity 0.3s ease;
}
.founder-card:hover .social-overlay {
    opacity: 1;
}
.section-title {
    position: relative;
    display: inline-block;
    padding-bottom: 10px;
}
.section-title:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background: linear-gradient(to right, #667eea, #764ba2);
}
.investor-card {
    border-radius: 20px;
    background: white;
}
.investor-avatar {
    width: 150px;
    height: 150px;
    overflow: hidden;
}
.investor-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.hover-lift:hover {
    transform: translateY(-5px);
}
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}
.object-fit-cover {
    object-fit: cover;
}
</style>
@endsection