@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10">
            <div class="card-body p-0">
                <div class="table-responsive--md table-responsive">
                    <ul class="nav nav-tabs nav-tabs-line mb-4" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link @if($step == 1) active @endif" 
                               href="{{ route('admin.manage.project.edit', @$project->id) }}?step=1">
                               @lang('Basic Information')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if($step == 2) active @endif" 
                               href="{{ route('admin.manage.project.edit', @$project->id) }}?step=2">
                               @lang('Investment Details')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if($step == 3) active @endif" 
                               href="{{ route('admin.manage.project.edit', @$project->id) }}?step=3">
                               @lang('SEO Information')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if($step == 4) active @endif" 
                               href="{{ route('admin.manage.project.edit', @$project->id) }}?step=4">
                               @lang('Video')
                            </a>
                        </li>
                    </ul>

                    @if($step == 1)
                    <form action="{{ route('admin.manage.project.store', @$project->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="step" value="1">

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>@lang('Project Title') <span class="text--danger">*</span></label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title', @$project->title) }}" required>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Company Name') <span class="text--danger">*</span></label>
                                    <input type="text" class="form-control" name="company_name" value="{{ old('company_name', @$project->company_name) }}" required>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Industry') <span class="text--danger">*</span></label>
                                    <input type="text" class="form-control" name="industry" value="{{ old('industry', @$project->industry) }}" placeholder="e.g., Technology, Healthcare, E-commerce" required>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Stage') <span class="text--danger">*</span></label>
                                    <select class="form-control" name="stage" required>
                                        <option value="idea" @selected(old('stage', @$project->stage) == 'idea')>Idea Stage</option>
                                        <option value="prototype" @selected(old('stage', @$project->stage) == 'prototype')>Prototype</option>
                                        <option value="mvp" @selected(old('stage', @$project->stage) == 'mvp')>MVP (Minimum Viable Product)</option>
                                        <option value="revenue" @selected(old('stage', @$project->stage) == 'revenue')>Generating Revenue</option>
                                        <option value="scaling" @selected(old('stage', @$project->stage) == 'scaling')>Scaling</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Problem Statement') <span class="text--danger">*</span></label>
                                    <textarea class="form-control" name="problem_statement" rows="3" required>{{ old('problem_statement', @$project->problem_statement) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Solution') <span class="text--danger">*</span></label>
                                    <textarea class="form-control" name="solution" rows="3" required>{{ old('solution', @$project->solution) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Business Model') <span class="text--danger">*</span></label>
                                    <textarea class="form-control" name="business_model" rows="3" required>{{ old('business_model', @$project->business_model) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Project Details') <span class="text--danger">*</span></label>
                                    <textarea class="form-control trumEdit" name="details" rows="8" required>{{ old('details', @$project->details) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Keywords')</label>
                                    <textarea class="form-control" name="keywords" rows="2">{{ old('keywords', @$project->keywords) }}</textarea>
                                    <small class="text-muted">@lang('Separate keywords by comma (,)')</small>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>@lang('Slug') <span class="text--danger">*</span></label>
                                    <input type="text" class="form-control" name="slug" value="{{ old('slug', @$project->slug) }}" required>
                                    <small class="text-muted">@lang('URL-friendly version of the title')</small>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Thumbnail Image') <span class="text--danger">*</span></label>
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url({{ getImage(getFilePath('propertyThumb') . '/' . @$project->thumb_image, getFileSize('propertyThumb')) }})">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" name="thumb_image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                <label for="profilePicUpload1" class="btn btn--success btn-block btn-lg">@lang('Upload Image')</label>
                                                <small class="text-muted mt-2">@lang('Supported files'): <b>@lang('jpeg, jpg, png')</b>. @lang('Image will be resized into') {{ getFileSize('propertyThumb') }}@lang('px')</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Project Gallery')</label>
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" name="gallery_image[]" id="galleryUpload" accept=".png, .jpg, .jpeg" multiple>
                                                <label for="galleryUpload" class="btn btn--success btn-block btn-lg">@lang('Upload Gallery Images')</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3" id="galleryPreview">
                                        @if(@$images)
                                            @foreach($images as $image)
                                                <input type="hidden" name="old[]" value="{{ $image['id'] }}">
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <button type="submit" class="btn btn--primary w-100 btn-lg">@lang('Save & Continue')</button>
                            </div>
                        </div>
                    </form>

                    @elseif($step == 2)
                    <form action="{{ route('admin.manage.project.store', @$project->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="step" value="2">

                        <div class="row">
                            <div class="col-lg-6">
                                <h6 class="mb-3">@lang('Basic Investment Settings')</h6>
                                
                                <div class="form-group">
                                    <label>@lang('Investment Type') <span class="text--danger">*</span></label>
                                    <select class="form-control" name="invest_type" required>
                                        <option value="1" @selected(old('invest_type', @$project->invest_type) == 1)>@lang('One Time Investment')</option>
                                        <option value="2" @selected(old('invest_type', @$project->invest_type) == 2)>@lang('Installment Investment')</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Maximum Investors') <span class="text--danger">*</span></label>
                                    <input type="number" class="form-control" name="max_investors" value="{{ old('max_investors', @$project->max_investors) }}" required>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Minimum Investment') <span class="text--danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ $general->cur_sym }}</span>
                                        <input type="number" class="form-control" name="minimum_investment" value="{{ old('minimum_investment', @$project->minimum_investment) }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Funding Goal') <span class="text--danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ $general->cur_sym }}</span>
                                        <input type="number" class="form-control" name="funding_goal" value="{{ old('funding_goal', @$project->funding_goal) }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Equity Offered') % <span class="text--danger">*</span></label>
                                    <input type="number" class="form-control" name="equity_offered" value="{{ old('equity_offered', @$project->equity_offered) }}" min="1" max="100" required>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Capital Back') <span class="text--danger">*</span></label>
                                    <select class="form-control" name="is_capital_back" required>
                                        <option value="1" @selected(old('is_capital_back', @$project->is_capital_back) == 1)>@lang('Yes')</option>
                                        <option value="0" @selected(old('is_capital_back', @$project->is_capital_back) == 0)>@lang('No')</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <h6 class="mb-3">@lang('Profit Settings')</h6>
                                
                                <div class="form-group">
                                    <label>@lang('Profit Type') <span class="text--danger">*</span></label>
                                    <select class="form-control" name="profit_type" required>
                                        <option value="1" @selected(old('profit_type', @$project->profit_type) == 1)>@lang('Fixed')</option>
                                        <option value="2" @selected(old('profit_type', @$project->profit_type) == 2)>@lang('Range')</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Profit Amount Type') <span class="text--danger">*</span></label>
                                    <select class="form-control" name="profit_amount_type" required>
                                        <option value="1" @selected(old('profit_amount_type', @$project->profit_amount_type) == 1)>@lang('Fixed Amount')</option>
                                        <option value="2" @selected(old('profit_amount_type', @$project->profit_amount_type) == 2)>@lang('Percentage')</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Profit Amount') <span class="text--danger">*</span></label>
                                    <input type="number" class="form-control" name="profit_amount" value="{{ old('profit_amount', @$project->profit_amount) }}" step="any" required>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Profit Schedule') <span class="text--danger">*</span></label>
                                    <select class="form-control" name="profit_schedule" required>
                                        <option value="1" @selected(old('profit_schedule', @$project->profit_schedule) == 1)>@lang('One Time')</option>
                                        <option value="2" @selected(old('profit_schedule', @$project->profit_schedule) == 2)>@lang('Lifetime')</option>
                                        <option value="3" @selected(old('profit_schedule', @$project->profit_schedule) == 3)>@lang('Repeated Time')</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Profit Schedule Period')</label>
                                    <select class="form-control" name="profit_schedule_period">
                                        <option value="">@lang('Select One')</option>
                                        @foreach($times as $time)
                                        <option value="{{ $time->id }}" @selected(old('profit_schedule_period', @$project->profit_schedule_period) == $time->id)>
                                            {{ __($time->name) }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn--primary w-100 btn-lg">@lang('Save & Continue')</button>
                            </div>
                        </div>
                    </form>

                    @elseif($step == 3)
                    <form action="{{ route('admin.manage.project.store', @$project->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="step" value="3">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>@lang('Social Title')</label>
                                    <input type="text" class="form-control" name="social_title" value="{{ old('social_title', @$project->seo_content->social_title ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label>@lang('Social Description')</label>
                                    <textarea class="form-control" name="social_description" rows="3">{{ old('social_description', @$project->seo_content->social_description ?? '') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Tags')</label>
                                    <textarea class="form-control" name="keywords" rows="3">{{ old('keywords', @$project->seo_content->keywords ?? '') }}</textarea>
                                    <small class="text-muted">@lang('Separate by comma')</small>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>@lang('Meta Description')</label>
                                    <textarea class="form-control" name="description" rows="3">{{ old('description', @$project->seo_content->description ?? '') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Social Image')</label>
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url({{ getImage(getFilePath('seo') . '/' . (@$project->seo_content->image ?? '')) }})">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" name="image" id="profilePicUpload2" accept=".png, .jpg, .jpeg">
                                                <label for="profilePicUpload2" class="btn btn--success btn-block btn-lg">@lang('Upload Image')</label>
                                                <small class="text-muted mt-2">@lang('Supported files'): <b>@lang('jpeg, jpg, png')</b></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn--primary w-100 btn-lg">@lang('Save & Continue')</button>
                            </div>
                        </div>
                    </form>

                    @elseif($step == 4)
                    <form action="{{ route('admin.manage.project.store', @$project->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="step" value="4">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>@lang('Project Video URL') <span class="text--danger">*</span></label>
                                    <input type="text" class="form-control" name="video" value="{{ old('video', @$project->video) }}" placeholder="https://www.youtube.com/watch?v=..." required>
                                    <small class="text-muted">@lang('YouTube video URL')</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn--primary w-100 btn-lg">@lang('Save Project')</button>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    (function ($) {
        "use strict";
        
        $('.trumEdit').trumbowyg({
            btns: [
                ['viewHTML'],
                ['undo', 'redo'],
                ['formatting'],
                ['strong', 'em', 'del'],
                ['superscript', 'subscript'],
                ['link'],
                ['insertImage'],
                ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                ['unorderedList', 'orderedList'],
                ['horizontalRule'],
                ['removeformat'],
                ['fullscreen']
            ]
        });
    })(jQuery);
</script>
@endpush