@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10">
            <div class="card-body p-0">
                <div class="table-responsive--md table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('Photo')</th>
                                <th>@lang('Name & Position')</th>
                                <th>@lang('Company')</th>
                                <th>@lang('Display Order')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($founders as $founder)
                            <tr>
                                <td>
                                    <img src="{{ $founder->photo_url }}" width="60" height="60" class="rounded-circle" alt="{{ $founder->name }}">
                                </td>
                                <td>
                                    <strong>{{ $founder->name }}</strong><br>
                                    <small class="text-muted">{{ $founder->position }}</small>
                                </td>
                                <td>{{ $founder->company ?? 'N/A' }}</td>
                                <td>{{ $founder->display_order }}</td>
                                <td>
                                    @if($founder->status)
                                        <span class="badge badge--success">@lang('Active')</span>
                                    @else
                                        <span class="badge badge--danger">@lang('Inactive')</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="button--group">
                                        <a href="{{ route('admin.founders.edit', $founder->id) }}" 
                                           class="btn btn-sm btn-outline--primary">
                                            <i class="la la-pencil"></i> @lang('Edit')
                                        </a>
                                        <button class="btn btn-sm btn-outline--{{ $founder->status ? 'danger' : 'success' }} confirmationBtn"
                                                data-question="{{ $founder->status ? 'Are you sure to disable this founder?' : 'Are you sure to activate this founder?' }}"
                                                data-action="{{ route('admin.founders.status', $founder->id) }}">
                                            <i class="la la-{{ $founder->status ? 'eye-slash' : 'eye' }}"></i>
                                            {{ $founder->status ? 'Disable' : 'Activate' }}
                                        </button>
                                        <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                                data-question="Are you sure to delete this founder?"
                                                data-action="{{ route('admin.founders.delete', $founder->id) }}">
                                            <i class="la la-trash"></i> @lang('Delete')
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="100%" class="text-center">@lang('No founders found')</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($founders->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($founders) }}
                </div>
            @endif
        </div>
    </div>
</div>

<x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.founders.create') }}" class="btn btn-sm btn-outline--primary">
        <i class="las la-plus"></i> @lang('Add New Founder')
    </a>
@endpush