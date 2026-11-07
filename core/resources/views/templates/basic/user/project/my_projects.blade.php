@extends($activeTemplate . 'layouts.master')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@lang('My Projects')</h5>
            <a href="{{ route('user.project.create') }}" class="btn btn--primary btn--sm">
                <i class="fas fa-plus"></i> @lang('Submit New Project')
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table custom--table">
                <thead>
                    <tr>
                        <th>@lang('Project')</th>
                        <th>@lang('Funding Goal')</th>
                        <th>@lang('Equity')</th>
                        <th>@lang('Stage')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                    <tr>
                        <td>
                            <div>
                                <h6 class="mb-1">{{ $project->title }}</h6>
                                <small class="text-muted">{{ $project->company_name }}</small>
                            </div>
                        </td>
                        <td>{{ showAmount($project->funding_goal) }}</td>
                        <td>{{ $project->equity_offered }}%</td>
                        <td>{{ ucfirst($project->stage) }}</td>
                        <td>
                            @if($project->status == 1)
                                <span class="badge badge--success">@lang('Approved')</span>
                            @else
                                <span class="badge badge--warning">@lang('Pending')</span>
                            @endif
                        </td>
                        <td>
                            <a href="#" class="btn btn--sm btn-outline--primary">
                                <i class="las la-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            <div class="empty-state">
                                <i class="fas fa-project-diagram fa-3x text-muted mb-3"></i>
                                <h5>@lang('No Projects Found')</h5>
                                <p class="text-muted">@lang('Submit your first project to get started')</p>
                                <a href="{{ route('user.project.create') }}" class="btn btn--primary">
                                    @lang('Submit Project')
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection