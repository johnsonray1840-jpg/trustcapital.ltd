@extends($activeTemplate . 'layouts.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-10">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="las la-plus-circle"></i> @lang('Submit New Project')</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user.project.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Project Title') *</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Company Name') *</label>
                                <input type="text" class="form-control" name="company_name" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">@lang('Industry/Sector') *</label>
        <select class="form-control" name="industry" required>
            <option value="">@lang('Select Industry')</option>
            @foreach($industries as $industry)
                <option value="{{ $industry->name }}" {{ old('industry') == $industry->name ? 'selected' : '' }}>
                    {{ $industry->name }}
                </option>
                            @endforeach

                <option value="Technology">Technology</option>
                <option value="Healthcare">Healthcare</option>
                <option value="FinTech">FinTech</option>
                <option value="E-commerce">E-commerce</option>
                <option value="Real Estate">Real Estate</option>
                <option value="Education">Education</option>
                <option value="Food & Beverage">Food & Beverage</option>
                <option value="Renewable Energy">Renewable Energy</option>
                <option value="Manufacturing">Manufacturing</option>
                <option value="Transportation">Transportation</option>
                <option value="Other">Other</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">@lang('Project Stage') *</label>
            <select class="form-control" name="stage" required>
                <option value="idea">@lang('Idea/Concept Stage')</option>
                <option value="prototype">@lang('Prototype/Development')</option>
                <option value="mvp">@lang('MVP (Minimum Viable Product)')</option>
                <option value="revenue">@lang('Revenue Generating')</option>
                <option value="scaling">@lang('Scaling/Growth Stage')</option>
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
                                    <input type="number" class="form-control" name="funding_goal" min="1000" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Equity Offered') % *</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="equity_offered" min="1" max="100" value="20" required>
                                    <span class="input-group-text">%</span>
                                </div>
                                <small class="text-muted">@lang('Percentage of equity offered to investors')</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">@lang('Problem Statement') *</label>
                        <textarea class="form-control" name="problem_statement" rows="3" required placeholder="@lang('What specific problem are you solving?')"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">@lang('Your Solution') *</label>
                        <textarea class="form-control" name="solution" rows="3" required placeholder="@lang('How does your project solve this problem?')"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">@lang('Business Model') *</label>
                        <textarea class="form-control" name="business_model" rows="3" required placeholder="@lang('How will your project generate revenue?')"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">@lang('Project Details/Description') *</label>
                       <textarea class="form-control" name="details" rows="8" required></textarea>

                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">@lang('Team Members') (Optional)</label>
                        <div id="teamMembers">
                            <div class="team-member row mb-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="team_members[0][name]" placeholder="@lang('Full Name')">
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="team_members[0][role]" placeholder="@lang('Role/Position')">
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-sm remove-member" style="display: none;">
                                        <i class="las la-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addTeamMember">
                            <i class="las la-user-plus"></i> @lang('Add Team Member')
                        </button>
                    </div>
                    
                    <!--<div class="form-group">-->
                    <!--    <label class="form-label">@lang('Pitch Deck') (Optional)</label>-->
                    <!--    <input type="file" class="form-control" name="pitch_deck" accept=".pdf,.ppt,.pptx,.doc,.docx">-->
                    <!--    <small class="text-muted">@lang('Supported formats: PDF, PPT, PPTX, DOC, DOCX')</small>-->
                    <!--</div>-->
                    
                    <div class="alert alert-info">
                        <i class="las la-info-circle"></i>
                        <strong>@lang('Important:')</strong> 
                        @lang('Your project will be reviewed by our team. Required documents:')
                        <ul class="mb-0 mt-2">
                            <li>@lang('Detailed business plan')</li>
                            <li>@lang('Financial projections')</li>
                            <li>@lang('Team background information')</li>
                            <li>@lang('Market analysis')</li>
                        </ul>
                        <p class="mb-0 mt-2">@lang('You can upload additional documents after submission.')</p>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="las la-paper-plane"></i> @lang('Submit Project for Review')
                        </button>
                        <a href="{{ route('user.project.my') }}" class="btn btn-outline-secondary">
                            <i class="las la-list"></i> @lang('View My Projects')
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
        
        // $('.trumEdit').trumbowyg();
        
        // Team members functionality
        let memberCount = 1;
        $('#addTeamMember').on('click', function() {
            const html = `
            <div class="team-member row mb-2">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="team_members[${memberCount}][name]" placeholder="@lang('Full Name')">
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="team_members[${memberCount}][role]" placeholder="@lang('Role/Position')">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-member">
                        <i class="las la-times"></i>
                    </button>
                </div>
            </div>`;
            $('#teamMembers').append(html);
            memberCount++;
            
            // Show remove button on first member
            $('.team-member:first-child .remove-member').show();
        });
        
        $(document).on('click', '.remove-member', function() {
            $(this).closest('.team-member').remove();
        });
    })(jQuery);
</script>
@endpush