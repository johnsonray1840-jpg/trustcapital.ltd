@extends($activeTemplate . 'layouts.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-10">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="las la-edit"></i> @lang('Edit Project')</h5>
                    <a href="{{ route('user.project.my') }}" class="btn btn-sm btn-light">
                        <i class="las la-arrow-left"></i> @lang('Back to Projects')
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('user.project.update', $project->id) }}" method="POST">
                    @csrf
                    
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
                                <label class="form-label">@lang('Industry/Sector') *</label>
                                <input type="text" class="form-control" name="industry" value="{{ old('industry', $project->industry) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Project Stage') *</label>
                                <select class="form-control" name="stage" required>
                                    <option value="idea" @selected(old('stage', $project->stage) == 'idea')>@lang('Idea/Concept Stage')</option>
                                    <option value="prototype" @selected(old('stage', $project->stage) == 'prototype')>@lang('Prototype/Development')</option>
                                    <option value="mvp" @selected(old('stage', $project->stage) == 'mvp')>@lang('MVP (Minimum Viable Product)')</option>
                                    <option value="revenue" @selected(old('stage', $project->stage) == 'revenue')>@lang('Revenue Generating')</option>
                                    <option value="scaling" @selected(old('stage', $project->stage) == 'scaling')>@lang('Scaling/Growth Stage')</option>
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
                                    <input type="number" class="form-control" name="funding_goal" 
                                           value="{{ old('funding_goal', $project->funding_goal) }}" min="1000" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Equity Offered') % *</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="equity_offered" 
                                           value="{{ old('equity_offered', $project->equity_offered) }}" min="1" max="100" required>
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
                        <label class="form-label">@lang('Your Solution') *</label>
                        <textarea class="form-control" name="solution" rows="3" required>{{ old('solution', $project->solution) }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">@lang('Business Model') *</label>
                        <textarea class="form-control" name="business_model" rows="3" required>{{ old('business_model', $project->business_model) }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">@lang('Project Details/Description') *</label>
                        <textarea class="form-control trumEdit" name="details" rows="8" required>{{ old('details', $project->details) }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">@lang('Team Members')</label>
                        <div id="teamMembers">
                            @php
                                $teamMembers = $project->team_members ?? [];
                                $memberIndex = 0;
                            @endphp
                            
                            @if(!empty($teamMembers) && is_array($teamMembers))
                                @foreach($teamMembers as $index => $member)
                                <div class="team-member row mb-2">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" 
                                               name="team_members[{{ $index }}][name]" 
                                               value="{{ $member['name'] ?? '' }}" 
                                               placeholder="@lang('Full Name')">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" 
                                               name="team_members[{{ $index }}][role]" 
                                               value="{{ $member['role'] ?? '' }}" 
                                               placeholder="@lang('Role/Position')">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm remove-member">
                                            <i class="las la-times"></i>
                                        </button>
                                    </div>
                                </div>
                                @php $memberIndex = $index + 1; @endphp
                                @endforeach
                            @else
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
                            @endif
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addTeamMember">
                            <i class="las la-user-plus"></i> @lang('Add Team Member')
                        </button>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="las la-info-circle"></i>
                        <strong>@lang('Note:')</strong> 
                        @lang('Your project will need to be reviewed again after editing.')
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="las la-save"></i> @lang('Update Project')
                        </button>
                        <a href="{{ route('user.project.my') }}" class="btn btn-outline-secondary">
                            <i class="las la-times"></i> @lang('Cancel')
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Document Management Section -->
        <div class="card mt-4">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0"><i class="las la-file-alt"></i> @lang('Project Documents')</h6>
            </div>
            <div class="card-body">
                @if($project->projectDocuments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>@lang('Document Type')</th>
                                <th>@lang('File Name')</th>
                                <th>@lang('Uploaded')</th>
                                <th>@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($project->projectDocuments as $document)
                            <tr>
                                <td>
                                    <span class="badge bg-{{ $document->document_type == 'pitch_deck' ? 'primary' : 'info' }}">
                                        {{ ucfirst(str_replace('_', ' ', $document->document_type)) }}
                                    </span>
                                </td>
                                <td>{{ $document->original_filename }}</td>
                                <td>{{ showDateTime($document->created_at, 'd M Y') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('user.download.attachment', encrypt(getFilePath('projectDocuments') . '/' . $document->file_path)) }}" 
                                           class="btn btn-outline-primary">
                                            <i class="las la-download"></i>
                                        </a>
                                        <form action="{{ route('user.project.document.delete', $document->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger confirmationBtn">
                                                <i class="las la-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-3">
                    <i class="las la-file-alt fa-2x text-muted mb-3"></i>
                    <p class="text-muted mb-0">@lang('No documents uploaded yet')</p>
                </div>
                @endif
                
                <!-- Document Upload Form -->
                <div class="mt-4">
                    <h6 class="mb-3">@lang('Upload New Document')</h6>
                    <form action="{{ route('user.project.document.upload', $project->id) }}" 
                          method="POST" enctype="multipart/form-data" class="row g-3">
                        @csrf
                        <div class="col-md-4">
                            <select class="form-control" name="document_type" required>
                                <option value="pitch_deck">Pitch Deck</option>
                                <option value="business_plan">Business Plan</option>
                                <option value="financials">Financial Projections</option>
                                <option value="legal">Legal Documents</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="file" class="form-control" name="document" required 
                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.ppt,.pptx">
                            <small class="text-muted">Max: 10MB | Supported: PDF, DOC, JPG, PNG, PPT</small>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="las la-upload"></i> @lang('Upload')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<x-confirmation-modal />
@endsection

@push('script')
<script>
    (function ($) {
        "use strict";
        
        $('.trumEdit').trumbowyg();
        
        // Team members functionality
        let memberCount = {{ $memberIndex ?? 1 }};
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
            
            // Show remove button on first member if not already shown
            if ($('.team-member').length > 1) {
                $('.team-member:first-child .remove-member').show();
            }
        });
        
        $(document).on('click', '.remove-member', function() {
            $(this).closest('.team-member').remove();
            // Hide remove button if only one member left
            if ($('.team-member').length <= 1) {
                $('.team-member .remove-member').hide();
            }
        });
        
        // Show remove button if there are existing members
        if ($('.team-member').length > 1) {
            $('.team-member .remove-member').show();
        }
    })(jQuery);
</script>
@endpush