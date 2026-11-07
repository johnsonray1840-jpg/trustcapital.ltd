@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @include($activeTemplate . 'sections.banner')
    @include('templates.basic.partials.founders-preview')
     <!-- Add CIS Section -->
@include('templates.basic.partials.cis-preview')
    @if (@$sections->secs != null)
        @foreach (json_decode(@$sections->secs) as $sec)
            @includeif($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
