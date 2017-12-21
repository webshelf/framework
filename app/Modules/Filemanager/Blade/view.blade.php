@extends('dashboard::frame')

@section('title')
    File Manager
@endsection

@section('information')
    Manage and control the images and media stored on your web application servers or previous assets your website users.
@endsection

@section('content')

    <!-- Element where elFinder will be created (REQUIRED) -->
    <div id="elfinder"></div>

    <iframe style="height:500px; width:100%; border:none;" src="{{ route('elfinder') }}"></iframe>

@endsection