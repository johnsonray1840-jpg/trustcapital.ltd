@extends('admin.layouts.app')
@section('panel')
    @php
        $isFundedRoute = request()->routeIs('admin.manage.project.funded');
        $isPendingRoute = request()->routeIs('admin.manage.project.pending');
    @endphp
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Project')</th>
                                    <th>@lang('Company') | @lang('Industry')</th>
                                    <th>@lang('Funding Goal') | @lang('Equity')</th>
                                    <th>@lang('Raised Amount') | @lang('Progress')</th>
                                    <th>@lang('Stage')</th>
                                    <th>@lang('Is Featured')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($projects as $project)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                             
                                             <div class="bg-light rounded me-2" style="width:50px;height:50px;"></div>


                                                <div>
                                                    <strong>{{ __(@$project->title) }}</strong><br>
                                                  <small class="text-muted">{{ Str::limit(@$project->problem_statement, 50) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ @$project->company_name }}</strong><br>
                                                <span class="badge bg-primary">{{ @$project->industry }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="fw-bold">{{ showAmount($project->funding_goal) }}</span><br>
                                                <span class="badge bg-success">{{ @$project->equity_offered }}% Equity</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span>
                                                    {{ showAmount(@$project->investments_sum_paid_amount ?? 0) }} |
                                                    {{ getAmount(@$project->funding_progress) }}%
                                                </span>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: {{ getAmount(@$project->funding_progress) }}%">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @php 
                                                $stageColors = [
                                                    'idea' => 'warning',
                                                    'prototype' => 'info', 
                                                    'mvp' => 'primary',
                                                    'revenue' => 'success',
                                                    'scaling' => 'dark'
                                                ];
                                                $color = $stageColors[$project->stage] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $color }}">{{ ucfirst($project->stage) }}</span>
                                        </td>
                                        <td>
                                            @if ($project->is_featured == Status::YES)
                                                <span class="badge badge--success">@lang('Yes')</span>
                                            @else
                                                <span class="badge badge--warning">@lang('No')</span>
                                            @endif
                                        </td>
                                        <td>@php echo @$project->statusBadge; @endphp</td>
                                        <td>
                                            <div class="button--group">
                                                <a href="{{ route('admin.manage.project.edit', $project->id) }}"
                                                    class="btn btn-sm btn-outline--primary">
                                                    <i class="la la-pencil"></i>@lang('Edit')
                                                </a>
                                                <button class="btn btn-sm btn-outline--info" data-bs-toggle="dropdown" type="button"
                                                    aria-expanded="false"><i class="las la-ellipsis-v"></i>@lang('More')</button>
                                                <div class="dropdown-menu">
                                                    @if ($project->is_featured == Status::NO)
                                                        <button class="dropdown-item threshold confirmationBtn" data-question="@lang('Are you sure to feature this project?')"
                                                            data-action="{{ route('admin.manage.project.featured.status', $project->id) }}">
                                                            <i class="las la-certificate"></i> @lang('Make Featured')
                                                        </button>
                                                    @else
                                                        <button class="dropdown-item threshold confirmationBtn" data-question="@lang('Are you sure to un-feature this project?')"
                                                            data-action="{{ route('admin.manage.project.featured.status', $project->id) }}">
                                                            <i class="las la-certificate"></i> @lang('Remove Featured')
                                                        </button>
                                                    @endif
                                                    @if ($project->status == Status::DISABLE)
                                                        <button class="dropdown-item threshold confirmationBtn" data-question="@lang('Are you sure to approve this project?')"
                                                            data-action="{{ route('admin.manage.project.status', $project->id) }}">
                                                            <i class="la la-check-circle"></i> @lang('Approve')
                                                        </button>
                                                    @else
                                                        <button class="dropdown-item threshold confirmationBtn" data-question="@lang('Are you sure to disable this project?')"
                                                            data-action="{{ route('admin.manage.project.status', $project->id) }}">
                                                            <i class="la la-times-circle"></i> @lang('Disable')
                                                        </button>
                                                    @endif
                                                    @if($isPendingRoute)
                                                    <a href="{{ route('admin.manage.project.edit', $project->id) }}?step=1" 
                                                       class="dropdown-item">
                                                        <i class="las la-edit"></i> @lang('Review Project')
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">{{ __($emptyMessage ?? 'No projects found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($projects->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($projects) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Search by project title or company" />
    @if (request()->routeIs('admin.manage.project.index'))
        <a href="{{ route('admin.manage.project.create') }}" class="btn btn-sm btn-outline--primary">
            <i class="las la-plus"></i>@lang('Add New Project')
        </a>
    @endif
    @if (request()->routeIs('admin.manage.project.pending'))
        <a href="{{ route('admin.manage.project.index') }}" class="btn btn-sm btn-outline--info">
            <i class="las la-list"></i>@lang('All Projects')
        </a>
    @endif
    @if (request()->routeIs('admin.manage.project.funded'))
        <a href="{{ route('admin.manage.project.index') }}" class="btn btn-sm btn-outline--info">
            <i class="las la-list"></i>@lang('All Projects')
        </a>
    @endif
@endpush

@push('style')
    <style>
        .progress {
            height: 8px;
        }
        .table img {
            object-fit: cover;
        }
    </style>
@endpush