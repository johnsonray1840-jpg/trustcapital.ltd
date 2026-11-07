@extends($activeTemplate . 'layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="las la-project-diagram"></i> @lang('My Projects')</h5>
                    <a href="{{ route('user.project.create') }}" class="btn btn-primary btn-sm">
                        <i class="las la-plus"></i> @lang('New Project')
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($projects->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>@lang('Project Details')</th>
                                <th>@lang('Funding')</th>
                                <th>@lang('Stage')</th>
                                <th>@lang('Documents')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                            <tr>
                               <td>
    <div class="d-flex align-items-start">
        <div class="flex-shrink-0 me-3">
            @if($project->thumb_image)
                {{-- Use direct path instead of getFilePath --}}
                <img src="{{ asset('assets/images/property/thumb/thumb_' . $project->thumb_image) }}" 
                     alt="{{ $project->title }}" width="60" class="rounded">
            @else
                {{-- Default image if no thumb --}}
                <img src="{{ asset('assets/images/default.png') }}" 
                     alt="{{ $project->title }}" width="60" class="rounded">
            @endif
        </div>
        <div class="flex-grow-1">
            <h6 class="mb-1">{{ $project->title }}</h6>
            <p class="text-muted mb-1">{{ $project->company_name }}</p>
            <small class="text-muted">
                <i class="las la-industry"></i> {{ $project->industry }}
            </small>
        </div>
    </div>
</td>
                                <td>
                                    <div>
                                        <strong>{{ showAmount($project->funding_goal) }}</strong><br>
                                        <span class="badge bg-info">{{ $project->equity_offered }}% Equity</span>
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
                                    @if($project->pitch_deck_url)
                                        <span class="badge bg-success">
                                            <i class="las la-file-pdf"></i> @lang('Pitch Deck')
                                        </span>
                                    @endif
                                    @if($project->projectDocuments->count() > 0)
                                        <span class="badge bg-primary">
                                            <i class="las la-file"></i> {{ $project->projectDocuments->count() }} @lang('Docs')
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($project->status == 1)
                                        <span class="badge bg-success">@lang('Approved')</span>
                                    @elseif($project->status == 2)
                                        <span class="badge bg-danger">@lang('Rejected')</span>
                                    @else
                                        <span class="badge bg-warning">@lang('Pending Review')</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ $project->slug ? route('project.details', $project->slug) : '#' }}" 
   class="btn btn-outline-primary" title="@lang('View')"
   @if(!$project->slug) onclick="return false;" @endif>
    <i class="las la-eye"></i>
</a>
                                        @if($project->status == 0)
                                        <a href="{{ route('user.project.edit', $project->id) }}" 
                                           class="btn btn-outline-info" title="@lang('Edit')">
                                            <i class="las la-edit"></i>
                                        </a>
                                        @endif
                                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" 
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="las la-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" 
                                                   data-bs-target="#documentModal{{ $project->id }}">
                                                    <i class="las la-file-upload"></i> @lang('Upload Document')
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('user.project.investors', $project->id) }}">
                                                    <i class="las la-users"></i> @lang('View Investors')
                                                </a>
                                            </li>
                                            @if($project->projectDocuments->count() > 0)
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" 
                                                   data-bs-target="#documentsModal{{ $project->id }}">
                                                    <i class="las la-folder-open"></i> @lang('View Documents')
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                    
                                    <!-- Document Upload Modal -->
                                    <div class="modal fade" id="documentModal{{ $project->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">@lang('Upload Document')</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('user.project.document.upload', $project->id) }}" 
                                                      method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>@lang('Document Type')</label>
                                                            <select class="form-control" name="document_type" required>
                                                                <option value="pitch_deck">Pitch Deck</option>
                                                                <option value="business_plan">Business Plan</option>
                                                                <option value="financials">Financial Projections</option>
                                                                <option value="legal">Legal Documents</option>
                                                                <option value="other">Other</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>@lang('Select File')</label>
                                                            <input type="file" class="form-control" name="document" required 
                                                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.ppt,.pptx">
                                                            <small class="text-muted">Max: 10MB | Supported: PDF, DOC, JPG, PNG, PPT</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            @lang('Close')
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="las la-upload"></i> @lang('Upload')
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Documents List Modal -->
                                    @if($project->projectDocuments->count() > 0)
                                    <div class="modal fade" id="documentsModal{{ $project->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">@lang('Project Documents')</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>@lang('Type')</th>
                                                                    <th>@lang('File Name')</th>
                                                                    <th>@lang('Uploaded')</th>
                                                                    <th>@lang('Action')</th>
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
                                                                       <a href="{{ asset('assets/files/project_documents/' . $document->file_path) }}" 
   target="_blank" class="btn btn-sm btn-outline-primary">
                                                                        <form action="{{ route('user.project.document.delete', $document->id) }}" 
                                                                              method="POST" class="d-inline">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-sm btn-outline-danger confirmationBtn">
                                                                                <i class="las la-trash"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($projects->hasPages())
                    <div class="mt-3">
                        {{ paginateLinks($projects) }}
                    </div>
                @endif
                
                @else
                <div class="text-center py-5">
                    <i class="fas fa-project-diagram fa-3x text-muted mb-3"></i>
                    <h5>@lang('No Projects Found')</h5>
                    <p class="text-muted mb-4">@lang('You haven\'t submitted any projects yet')</p>
                    <a href="{{ route('user.project.create') }}" class="btn btn-primary btn-lg">
                        <i class="las la-plus"></i> @lang('Submit Your First Project')
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<x-confirmation-modal />
@endsection