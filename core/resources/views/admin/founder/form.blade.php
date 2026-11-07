@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.founders.store', @$founder->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label>@lang('Full Name') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', @$founder->name) }}" required>
                            </div>
                            
                           <div class="form-group">
    <label>@lang('Position/Title') <span class="text-danger">*</span></label>
    <input type="text" class="form-control" name="designation" 
           value="{{ old('designation', @$founder->designation) }}" required>
</div>
                            
                            <div class="form-group">
                                <label>@lang('Company')</label>
                                <input type="text" class="form-control" name="company" value="{{ old('company', @$founder->company) }}">
                            </div>
                            
                            <div class="form-group">
                                <label>@lang('Biography') <span class="text-danger">*</span></label>
                                <textarea class="form-control trumEdit" name="bio" rows="8" required>{{ old('bio', @$founder->bio) }}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>@lang('Display Order')</label>
                                <input type="number" class="form-control" name="display_order" value="{{ old('display_order', @$founder->display_order ?? 0) }}">
                                <small class="text-muted">@lang('Lower numbers display first')</small>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>@lang('Profile Photo')</label>
                                <div class="image-upload">
                                    <div class="thumb">
                                        <div class="avatar-preview">
                                            <div class="profilePicPreview" style="background-image: url({{ @$founder->photo_url }})">
                                                <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <div class="avatar-edit">
                                            <input type="file" class="profilePicUpload" name="photo" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                            <label for="profilePicUpload1" class="btn btn--success btn-block btn-lg">@lang('Upload Photo')</label>
                                            <small class="text-muted mt-2">@lang('Supported files'): jpeg, jpg, png</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">@lang('Social Links')</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"><i class="lab la-linkedin"></i></span>
                                    <input type="url" class="form-control" name="social_links[linkedin]" 
                                           value="{{ old('social_links.linkedin', @$founder->social_links['linkedin'] ?? '') }}" 
                                           placeholder="LinkedIn URL">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"><i class="lab la-twitter"></i></span>
                                    <input type="url" class="form-control" name="social_links[twitter]" 
                                           value="{{ old('social_links.twitter', @$founder->social_links['twitter'] ?? '') }}" 
                                           placeholder="Twitter URL">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="las la-globe"></i></span>
                                    <input type="url" class="form-control" name="social_links[website]" 
                                           value="{{ old('social_links.website', @$founder->social_links['website'] ?? '') }}" 
                                           placeholder="Personal Website">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">@lang('Status')</label>
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" 
                                       data-offstyle="-danger" data-toggle="toggle" data-on="Active" 
                                       data-off="Inactive" name="status" @checked(@$founder->status ?? true)>
                            </div>
                            
                            <button type="submit" class="btn btn--primary w-100 btn-lg">
                                @lang('Save Founder')
                            </button>
                        </div>
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