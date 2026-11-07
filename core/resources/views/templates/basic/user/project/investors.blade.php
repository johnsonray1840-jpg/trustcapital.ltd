@extends($activeTemplate . 'layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0"><i class="las la-users"></i> @lang('Project Investors')</h5>
                        <p class="mb-0 small">{{ $project->title }}</p>
                    </div>
                    <a href="{{ route('user.project.my') }}" class="btn btn-sm btn-light">
                        <i class="las la-arrow-left"></i> @lang('Back to Projects')
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Project Summary -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <h6 class="text-muted">@lang('Total Investors')</h6>
                                <h3 class="mb-0">{{ $investors->total() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <h6 class="text-muted">@lang('Funding Goal')</h6>
                                <h3 class="mb-0">{{ showAmount($project->funding_goal) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <h6 class="text-muted">@lang('Equity Offered')</h6>
                                <h3 class="mb-0">{{ $project->equity_offered }}%</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <h6 class="text-muted">@lang('Stage')</h6>
                                <h3 class="mb-0">
                                    <span class="badge bg-{{ $project->stage == 'idea' ? 'warning' : ($project->stage == 'revenue' ? 'success' : 'info') }}">
                                        {{ ucfirst($project->stage) }}
                                    </span>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($investors->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>@lang('Investor')</th>
                                <th>@lang('Investment Amount')</th>
                                <th>@lang('Equity Received')</th>
                                <th>@lang('Investment Date')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Contact')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($investors as $investment)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <img src="{{ getImage(getFilePath('userProfile') . '/' . @$investment->user->image, isAvatar: true) }}" 
                                                 alt="{{ $investment->user->fullname }}" width="45" class="rounded-circle">
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $investment->user->fullname }}</h6>
                                            <small class="text-muted">
                                                <i class="las la-map-marker"></i> {{ $investment->user->country_name ?? 'N/A' }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <strong class="text-success">{{ showAmount($investment->amount) }}</strong>
                                </td>
                                <td>
                                    @php
                                        $equityPercent = ($investment->amount / $project->funding_goal) * $project->equity_offered;
                                    @endphp
                                    <span class="badge bg-info">{{ getAmount($equityPercent, 2) }}%</span>
                                </td>
                                <td>
                                    {{ showDateTime($investment->created_at, 'd M Y') }}<br>
                                    <small class="text-muted">{{ diffForHumans($investment->created_at) }}</small>
                                </td>
                                <td>
                                    @if($investment->status == 1)
                                        <span class="badge bg-success">@lang('Active')</span>
                                    @else
                                        <span class="badge bg-warning">@lang('Pending')</span>
                                    @endif
                                </td>
                                <td>
                                    @if($investment->user->email)
                                    <a href="mailto:{{ $investment->user->email }}" 
                                       class="btn btn-sm btn-outline-primary" title="@lang('Send Email')">
                                        <i class="las la-envelope"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($investors->hasPages())
                    <div class="mt-3">
                        {{ paginateLinks($investors) }}
                    </div>
                @endif
                
                @else
                <div class="text-center py-5">
                    <i class="las la-users fa-3x text-muted mb-3"></i>
                    <h5>@lang('No Investors Yet')</h5>
                    <p class="text-muted mb-4">@lang('Your project doesn\'t have any investors yet. Promote your project to attract investors.')</p>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h6 class="mb-3">@lang('Tips to attract investors:')</h6>
                                    <ul class="text-start">
                                        <li>@lang('Complete all project documentation')</li>
                                        <li>@lang('Upload detailed financial projections')</li>
                                        <li>@lang('Share your project on social media')</li>
                                        <li>@lang('Update your project regularly')</li>
                                        <li>@lang('Be responsive to investor inquiries')</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    .investor-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
    }
    .investment-card {
        transition: transform 0.2s;
    }
    .investment-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
</style>
@endpush