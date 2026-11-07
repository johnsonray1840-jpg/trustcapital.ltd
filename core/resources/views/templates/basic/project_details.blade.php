@extends($activeTemplate . 'layouts.master')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ $project->title }}</h4>
                    <small>{{ $project->company_name }} • {{ $project->industry }}</small>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Stage:</strong> {{ ucfirst($project->stage) }}</p>
                            <p><strong>Funding Goal:</strong> {{ gs('cur_sym') }}{{ showAmount($project->funding_goal) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Equity Offered:</strong> {{ $project->equity_offered }}%</p>
                            <p><strong>Minimum Investment:</strong> {{ gs('cur_sym') }}{{ showAmount($project->minimum_investment ?? 0) }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h5>Problem Statement</h5>
                        <p>{{ $project->problem_statement }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5>Solution</h5>
                        <p>{{ $project->solution }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5>Business Model</h5>
                        <p>{{ $project->business_model }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5>Project Details</h5>
                        <p>{!! nl2br($project->details) !!}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Investment Summary</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <h3>{{ gs('cur_sym') }}{{ showAmount($project->investments_sum_paid_amount ?? 0) }}</h3>
                        <p class="text-muted">Total Invested</p>
                        
                        <div class="progress mb-3" style="height: 20px;">
                            @php
                                $percentage = $project->funding_goal > 0 ? (($project->investments_sum_paid_amount ?? 0) / $project->funding_goal) * 100 : 0;
                                $percentage = min(100, $percentage);
                            @endphp
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentage }}%">
                                {{ round($percentage, 1) }}%
                            </div>
                        </div>
                        
                        <p>{{ $project->investments_count ?? 0 }} investors</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection