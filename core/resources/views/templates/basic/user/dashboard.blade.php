@extends($activeTemplate . 'layouts.master')
@php
    $kycContent = getContent('kyc_instruction.content', true);
@endphp

@section('content')
    <!-- KYC Status Alerts -->
    @if ($user->kv == Status::KYC_UNVERIFIED && $user->kyc_rejection_reason)
        <div class="mb-4">
            <div class="card border-danger bg-danger bg-opacity-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle text-danger fs-4 me-3"></i>
                        <div>
                            <h6 class="mb-1 text-danger">@lang('KYC Verification Required')</h6>
                            <p class="mb-2 small">Your KYC documents were rejected. Please review the reason and resubmit.</p>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#kycRejectionReason">
                                    <i class="fas fa-eye me-1"></i> @lang('View Reason')
                                </button>
                                <a href="{{ route('user.kyc.data') }}" class="btn btn-sm btn-danger">
                                    <i class="fas fa-file-upload me-1"></i> @lang('Resubmit KYC')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif($user->kv == Status::KYC_UNVERIFIED)
        <div class="mb-4">
            <div class="card border-info bg-info bg-opacity-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-id-card text-info fs-4 me-3"></i>
                        <div>
                            <h6 class="mb-1 text-info">@lang('Complete Your Profile')</h6>
                            <p class="mb-2 small">KYC verification is required to access all investment features.</p>
                            <a href="{{ route('user.kyc.form') }}" class="btn btn-sm btn-info">
                                <i class="fas fa-shield-alt me-1"></i> @lang('Start Verification')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif($user->kv == Status::KYC_PENDING)
        <div class="mb-4">
            <div class="card border-warning bg-warning bg-opacity-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-clock text-warning fs-4 me-3"></i>
                        <div>
                            <h6 class="mb-1 text-warning">@lang('Verification in Progress')</h6>
                            <p class="mb-2 small">Your KYC documents are under review. This usually takes 1-2 business days.</p>
                            <a href="{{ route('user.kyc.data') }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-history me-1"></i> @lang('Check Status')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Welcome Section -->
    <div class="card mb-4 border-0 bg-gradient-primary text-white">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-2">Welcome back, {{ $user->fullname }}!</h4>
                    <p class="mb-0 opacity-75">Track your investments, manage projects, and grow your portfolio.</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('user.project.create') }}" class="btn btn-light">
                        <i class="fas fa-plus me-2"></i> @lang('Submit New Project')
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Portfolio Overview -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>@lang('Portfolio Overview')</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Available Balance -->
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card border-0 h-100 shadow-sm hover-shadow">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm rounded-circle bg-primary bg-opacity-10 p-3">
                                                <i class="fas fa-wallet text-primary fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">@lang('Available Balance')</h6>
                                            <h3 class="mt-2 mb-0">{{ showAmount(@$widget['balance']) }}</h3>
                                        </div>
                                    </div>
                                    <small class="text-muted">Funds available for investment</small>
                                </div>
                            </div>
                        </div>

                        <!-- Total Investment -->
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card border-0 h-100 shadow-sm hover-shadow">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm rounded-circle bg-success bg-opacity-10 p-3">
                                                <i class="fas fa-chart-pie text-success fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">@lang('Total Money Funded')</h6>
                                            <h3 class="mt-2 mb-0">{{ showAmount(@$widget['total_investment']) }}</h3>
                                        </div>
                                    </div>
                                    <small class="text-muted">Money funded In Total</small>
                                </div>
                            </div>
                        </div>

                        <!-- Total Returns -->
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card border-0 h-100 shadow-sm hover-shadow">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm rounded-circle bg-warning bg-opacity-10 p-3">
                                                <i class="fas fa-hand-holding-usd text-warning fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">@lang('Total Returns')</h6>
                                            <h3 class="mt-2 mb-0">{{ showAmount(@$widget['total_profit']) }}</h3>
                                        </div>
                                    </div>
                                    <small class="text-muted">Cumulative profit earned</small>
                                </div>
                            </div>
                        </div>

                        <!-- Active Projects -->
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card border-0 h-100 shadow-sm hover-shadow">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm rounded-circle bg-info bg-opacity-10 p-3">
                                                <i class="fas fa-briefcase text-info fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">@lang('Active Projects')</h6>
                                            <h3 class="mt-2 mb-0">{{ @$widget['total_projects'] }}</h3>
                                        </div>
                                    </div>
                                    <small class="text-muted">Projects you've invested in</small>
                                </div>
                            </div>
                        </div>

                        <!-- Network Value -->
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card border-0 h-100 shadow-sm hover-shadow">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm rounded-circle bg-purple bg-opacity-10 p-3">
                                                <i class="fas fa-users text-purple fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">@lang('Network')</h6>
                                            <h3 class="mt-2 mb-0">{{ @$widget['referral'] }}</h3>
                                        </div>
                                    </div>
                                    <small class="text-muted">Your referral network</small>
                                </div>
                            </div>
                        </div>

                        <!-- Transaction Fee -->
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card border-0 h-100 shadow-sm hover-shadow">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm rounded-circle bg-secondary bg-opacity-10 p-3">
                                                <i class="fas fa-receipt text-secondary fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">@lang('Transaction Fee Paid')</h6>
                                            <h3 class="mt-2 mb-0">{{ showAmount(@$widget['total_deposit']) }}</h3>
                                        </div>
                                    </div>
                                    <small class="text-muted">Transaction fees paid</small>
                                </div>
                            </div>
                        </div>

                        <!-- Withdrawals -->
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card border-0 h-100 shadow-sm hover-shadow">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm rounded-circle bg-danger bg-opacity-10 p-3">
                                                <i class="fas fa-arrow-up text-danger fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">@lang('Withdrawals')</h6>
                                            <h3 class="mt-2 mb-0">{{ showAmount(@$widget['total_withdraw']) }}</h3>
                                        </div>
                                    </div>
                                    <small class="text-muted">Funds withdrawn</small>
                                </div>
                            </div>
                        </div>

                        <!-- Support Tickets -->
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card border-0 h-100 shadow-sm hover-shadow">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm rounded-circle bg-dark bg-opacity-10 p-3">
                                                <i class="fas fa-headset text-dark fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">@lang('Support')</h6>
                                            <h3 class="mt-2 mb-0">{{ $widget['total_ticket'] }}</h3>
                                        </div>
                                    </div>
                                    <small class="text-muted">Active support tickets</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- My Projects Section -->
    @if(isset($recentProjects) && $recentProjects->count() > 0)
    <div class="card mb-4">
        <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-rocket me-2"></i>@lang('My Projects')</h5>
            <a href="{{ route('user.project.my') }}" class="btn btn-sm btn-outline-dark">
                <i class="fas fa-list me-1"></i> @lang('View All')
            </a>
        </div>
        <div class="card-body">
            <div class="row g-4">
                @foreach($recentProjects as $project)
                <div class="col-xl-4 col-lg-6">
                    <div class="card border-0 shadow-sm h-100 hover-lift">
                        <div class="position-relative">
                            @if($project->thumb_image)
                            <img src="{{ getImage(getFilePath('propertyThumb') . '/thumb_' . @$project->thumb_image, getFileSize('propertyThumb')) }}" 
                                 class="card-img-top" alt="{{ $project->title }}" style="height: 200px; object-fit: cover;">
                            @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-project-diagram fa-3x text-muted"></i>
                            </div>
                            @endif
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-{{ $project->status == 1 ? 'success' : ($project->status == 0 ? 'warning' : 'danger') }}">
                                    {{ $project->status == 1 ? 'Active' : ($project->status == 0 ? 'Pending' : 'Rejected') }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title fw-bold mb-2">{{ Str::limit($project->title, 45) }}</h6>
                            <p class="card-text text-muted small mb-3">
                                {{ Str::limit($project->problem_statement, 100) }}
                            </p>
                            
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-bullseye text-primary me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Funding Goal</small>
                                            <strong>{{ gs()->cur_sym }}{{ number_format($project->funding_goal) }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-percentage text-success me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Equity</small>
                                            <strong>{{ $project->equity_offered }}%</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-industry me-1"></i> {{ $project->industry }}
                                </span>
                                <div class="btn-group">
                                    @if(!empty($project->slug))
                                    <a href="{{ route('project.details', $project->slug) }}" class="btn btn-dark btn-sm">
                                        <i class="fas fa-eye me-1"></i> @lang('View')
                                    </a>
                                    @endif
                                    <a href="{{ route('user.project.edit', $project->id) }}" class="btn btn-outline-dark btn-sm">
                                        <i class="fas fa-edit me-1"></i> @lang('Edit')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Recent Investments -->
    @if(isset($recentInvestments) && $recentInvestments->count() > 0)
    <div class="card">
        <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-history me-2"></i>@lang('Recent Investments')</h5>
            <a href="{{ route('user.invest.history') }}" class="btn btn-sm btn-outline-dark">
                <i class="fas fa-chart-bar me-1"></i> @lang('Investment History')
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>@lang('Project')</th>
                            <th>@lang('Investment')</th>
                            <th>@lang('Equity')</th>
                            <th>@lang('Date')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentInvestments as $investment)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($investment->project->thumb_image ?? false)
                                    <img src="{{ getImage(getFilePath('propertyThumb') . '/thumb_' . @$investment->project->thumb_image, getFileSize('propertyThumb')) }}" 
                                         class="rounded-circle me-3" width="40" height="40" alt="">
                                    @else
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-project-diagram text-muted"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <strong>{{ Str::limit($investment->project->title ?? 'N/A', 30) }}</strong>
                                        <div class="small text-muted">{{ $investment->project->company_name ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <strong class="text-success">{{ showAmount($investment->amount) }}</strong>
                            </td>
                            <td>
                                @if($investment->project->equity_offered ?? false)
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    {{ $investment->project->equity_offered }}%
                                </span>
                                @else
                                <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <div>{{ showDateTime($investment->created_at, 'd M Y') }}</div>
                                <small class="text-muted">{{ showDateTime($investment->created_at, 'h:i A') }}</small>
                            </td>
                            <td>
                                @if($investment->status == 1)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i> @lang('Active')
                                    </span>
                                @elseif($investment->status == 2)
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock me-1"></i> @lang('Pending')
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle me-1"></i> @lang('Failed')
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    @if($investment->project->id ?? false)
                                    <a href="{{ route('user.invest.installment.details', $investment->id) }}" 
                                       class="btn btn-outline-dark" title="@lang('Installments')">
                                        <i class="fas fa-calendar-alt"></i>
                                    </a>
                                    <a href="{{ route('user.invest.contract.download', $investment->id) }}" 
                                       class="btn btn-outline-dark" title="@lang('Contract')">
                                        <i class="fas fa-file-contract"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Empty States -->
    @if((!isset($recentProjects) || $recentProjects->count() == 0) && (!isset($recentInvestments) || $recentInvestments->count() == 0))
    <div class="card border-0 bg-light">
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <i class="fas fa-project-diagram fa-4x text-muted opacity-25"></i>
            </div>
            <h4 class="mb-3">@lang('Welcome to Your Dashboard')</h4>
            <p class="text-muted mb-4">Start your investment journey by exploring projects or submitting your own.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('user.project.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> @lang('Submit Project')
                </a>
                
            </div>
        </div>
    </div>
    @endif

    <!-- KYC Rejection Modal -->
    @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
    <div id="kycRejectionReason" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        @lang('KYC Rejection Details')
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light border">
                        <p class="mb-0">{{ auth()->user()->kyc_rejection_reason }}</p>
                    </div>
                    <p class="text-muted small">Please address these issues and resubmit your documents for verification.</p>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('user.kyc.data') }}" class="btn btn-danger">
                        <i class="fas fa-redo me-2"></i> @lang('Resubmit Documents')
                    </a>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@push('style')
<style>
    .bg-purple {
        background-color: #6f42c1 !important;
    }
    .text-purple {
        color: #6f42c1 !important;
    }
    .hover-shadow {
        transition: all 0.3s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    .hover-lift {
        transition: all 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-3px);
    }
    .avatar-sm {
        width: 60px;
        height: 60px;
    }
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }
    .btn-dark {
        background-color: #1a1a1a;
        border-color: #1a1a1a;
    }
    .btn-dark:hover {
        background-color: #000;
        border-color: #000;
    }
</style>
@endpush