@extends($activeTemplate . 'layouts.frontend')
@section('content')
<div class="project-page py-120 bg-pattern">
    <div class="container">
        <div class="project-page-inner">
            <aside id="project-page-sidebar" class="project-page-sidebar">
                <button class="close-btn" type="button">
                    <i class="fas fa-times"></i>
                </button>
                <form action="{{ url()->current() }}" class="filter-form">
                    <div class="filter-form__block">
                        <h6 class="title">@lang('Search Project')</h6>
                        <div class="form-group">
                            <input class="form--control" type="text" name="search" value="{{ request()->search }}"
                                placeholder="@lang('What project are you looking for')?">
                        </div>
                        <div class="form-group">
                            <input class="form--control" type="text" name="industry" value="{{ request()->industry }}"
                                placeholder="@lang('Industry (e.g., Tech, Healthcare)')">
                        </div>
                        <div class="form-group">
                            <select name="stage" class="form-control form--control select2 on-change-submit">
                                <option value="">@lang('All Stages')</option>
                                <option value="idea" @selected(request()->stage == 'idea')>Idea Stage</option>
                                <option value="prototype" @selected(request()->stage == 'prototype')>Prototype</option>
                                <option value="mvp" @selected(request()->stage == 'mvp')>MVP</option>
                                <option value="revenue" @selected(request()->stage == 'revenue')>Revenue Generating</option>
                                <option value="scaling" @selected(request()->stage == 'scaling')>Scaling</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="form--label">@lang('Investment Range')</label>
                            <div class="range-slider">
                                <div class="range-slider__inputs">
                                    <div class="input-group">
                                        <span class="input-group-text">{{ gs('cur_sym') }}</span>
                                        <input id="min-range" class="form--control" type="number"
                                            name="minimum_invest" value="{{ request()->minimum_invest }}">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ gs('cur_sym') }}</span>
                                        <input id="max-range" class="form--control" type="number"
                                            name="maximum_invest" value="{{ request()->maximum_invest }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn--sm btn btn-outline--base w-100">
                        <i class="las la-filter"></i> @lang('Filter')
                    </button>
                </form>
            </aside>
            <div class="project-page-content">
                <div class="text-end d-lg-none mb-4">
                    <button class="btn btn--sm btn-outline--base btn--sidebar-open" type="button" data-toggle="sidebar"
                        data-target="#project-page-sidebar">
                        <i class="las la-filter"></i>
                    </button>
                </div>
                <div class="row gy-4 g-sm-3 g-md-4 justify-content-center">
                    @if($projects->count() > 0)
                        @foreach($projects as $project)
                        <div class="col-md-6 col-lg-4">
                            <div class="project-card">
                                <div class="project-card__thumb">
                                    <a href="{{ route('project.details', $project->slug ?: 'project-' . $project->id) }}">
                                       @if($project->thumb_image && file_exists(public_path('assets/images/property/thumb/thumb_' . $project->thumb_image)))
    <img src="{{ asset('assets/images/property/thumb/thumb_' . $project->thumb_image) }}" 
         alt="{{ $project->title }}" width="60" class="rounded">
@else
    <img src="{{ asset('assets/images/default.png') }}" 
         alt="{{ $project->title }}" width="60" class="rounded">
@endif
                                    </a>
                                </div>
                                <div class="project-card__content">
                                    <h6 class="title">
                                        <a href="{{ route('project.details', $project->slug) }}">
                                            {{ __(@$project->title) }}
                                        </a>
                                    </h6>
                                    <div class="project-meta">
                                        <span class="badge bg-primary">{{ $project->industry }}</span>
                                        <span class="badge bg-{{ $project->stage == 'idea' ? 'warning' : ($project->stage == 'revenue' ? 'success' : 'info') }}">
                                            {{ ucfirst($project->stage) }}
                                        </span>
                                    </div>
                                    <div class="project-info">
                                        <div class="d-flex justify-content-between">
                                            <span>Goal: {{ showAmount($project->funding_goal) }}</span>
                                            <span>Equity: {{ $project->equity_offered }}%</span>
                                        </div>
                                        <div class="progress mt-2" style="height: 6px;">
                                            <div class="progress-bar" role="progressbar" 
                                                 style="width: {{ $project->funding_progress }}%;">
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ getAmount($project->funding_progress) }}% funded</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="col-12">
                        <div class="empty-state text-center py-5">
                            <i class="fas fa-project-diagram fa-3x text-muted mb-3"></i>
                            <h4>@lang('No Projects Found')</h4>
                            <p class="text-muted">@lang('Check back later for new investment opportunities')</p>
                        </div>
                    </div>
                    @endif
                </div>
                @if ($projects->hasPages())
                    {{ paginateLinks($projects) }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.select2').select2();
        })(jQuery);
    </script>
@endpush