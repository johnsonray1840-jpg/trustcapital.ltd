@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-edit"></i> {{ $pageTitle }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.manage.project.update', $project->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Project Title') *</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title', $project->title) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Company Name') *</label>
                                <input type="text" class="form-control" name="company_name" value="{{ old('company_name', $project->company_name) }}" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Industry') *</label>
                                <input type="text" class="form-control" name="industry" value="{{ old('industry', $project->industry) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Stage') *</label>
                                <select class="form-control" name="stage" required>
                                    <option value="idea" {{ $project->stage == 'idea' ? 'selected' : '' }}>Idea/Concept</option>
                                    <option value="prototype" {{ $project->stage == 'prototype' ? 'selected' : '' }}>Prototype</option>
                                    <option value="mvp" {{ $project->stage == 'mvp' ? 'selected' : '' }}>MVP</option>
                                    <option value="revenue" {{ $project->stage == 'revenue' ? 'selected' : '' }}>Revenue Generating</option>
                                    <option value="scaling" {{ $project->stage == 'scaling' ? 'selected' : '' }}>Scaling</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Funding Goal') *</label>
                                <div class="input-group">
                                    <span class="input-group-text">{{ gs()->cur_sym }}</span>
                                    <input type="number" class="form-control" name="funding_goal" value="{{ old('funding_goal', $project->funding_goal) }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Equity Offered') % *</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="equity_offered" value="{{ old('equity_offered', $project->equity_offered) }}" required>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">@lang('Problem Statement') *</label>
                        <textarea class="form-control" name="problem_statement" rows="3" required>{{ old('problem_statement', $project->problem_statement) }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">@lang('Solution') *</label>
                        <textarea class="form-control" name="solution" rows="3" required>{{ old('solution', $project->solution) }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">@lang('Business Model') *</label>
                        <textarea class="form-control" name="business_model" rows="3" required>{{ old('business_model', $project->business_model) }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">@lang('Project Details') *</label>
                        <textarea class="form-control trumEdit" name="details" rows="8" required>{{ old('details', $project->details) }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">@lang('Status')</label>
                        <select class="form-control" name="status">
                            <option value="0" {{ $project->status == 0 ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ $project->status == 1 ? 'selected' : '' }}>Approved</option>
                            <option value="2" {{ $project->status == 2 ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="las la-save"></i> @lang('Update Project')
                        </button>
                        <a href="{{ route('admin.manage.project.index') }}" class="btn btn-secondary">
                            <i class="las la-times"></i> @lang('Cancel')
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    (function ($) {
        "use strict";
        $('.trumEdit').trumbowyg();
    })(jQuery);
</script>
@endpush