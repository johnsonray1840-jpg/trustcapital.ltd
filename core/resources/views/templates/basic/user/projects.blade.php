@extends($activeTemplate . 'layouts.master')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between mb-4">
            <h4 class="mb-0">@lang('My Projects')</h4>
            <a href="{{ route('startups.submit') }}" class="btn btn--primary btn--sm">
                <i class="fas fa-plus"></i> @lang('Submit New Project')
            </a>
        </div>
        
        <div class="table-responsive">
            <table class="table custom--table">
                <thead>
                    <tr>
                        <th>@lang('Project')</th>
                        <th>@lang('Stage')</th>
                        <th>@lang('Funding Goal')</th>
                        <th>@lang('Raised')</th>
                        <th>@lang('Equity')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                   @if(@$seoContents->image)
    <img src="{{ asset('assets/images/seo/' . $seoContents->image) }}">
@endif
                                    <div>
                                        <h6 class="mb-0">{{ str_limit($project->title, 40) }}</h6>
                                        <small class="text-muted">{{ $project->industry ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {!! $project->stage_badge !!}
                            </td>
                            <td>
                                {{ showAmount($project->funding_goal) }}
                            </td>
                            <td>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar" role="progressbar" 
                                         style="width: {{ $project->funding_progress }}%;"></div>
                                </div>
                                <small>{{ showAmount($project->investments()->sum('paid_amount')) }} / {{ showAmount($project->funding_goal) }}</small>
                            </td>
                            <td>
                                {{ $project->equity_offered }}%
                            </td>
                            <td>
                                {!! $project->funding_status !!}
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('project.details', $project->slug) }}" 
                                       class="btn btn--sm btn-outline--primary" title="@lang('View')">
                                        <i class="las la-eye"></i>
                                    </a>
                                    <a href="{{ route('user.project.edit', $project->id) }}" 
                                       class="btn btn--sm btn-outline--info" title="@lang('Edit')">
                                        <i class="las la-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                <div class="empty-state">
                                    <i class="fas fa-project-diagram fa-3x text-muted mb-3"></i>
                                    <h5>@lang('No Projects Found')</h5>
                                    <p class="text-muted">@lang('Start by submitting your first project')</p>
                                    <a href="{{ route('startups.submit') }}" class="btn btn--primary">
                                        @lang('Submit Project')
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            @if($projects->hasPages())
                {{ paginateLinks($projects) }}
            @endif
        </div>
    </div>
</div>
@endsection