@extends('website::frame')

@section('content')

    <div class="container">
        <p>{!! $webpage->content() !!}</p>
        {{ debugVar($webpage) }}
    </div>

@endsection