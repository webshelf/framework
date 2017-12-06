@extends('dashboard::frame')

@section('content')
    <div class="overview">

        <div class="avatar">

            <img src="{{ asset('packages/webshelf/images/logo.png') }}">

        </div>

        <div class="title">

            <h3>{{ settings()->getDefault('site_name') }}</h3>

        </div>

        <div class="buttons">


        </div>

    </div>

    <hr>
    settings
    <hr>


@endsection