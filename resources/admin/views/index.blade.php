@extends('dashboard::frame')

@section('title')
    Welcome, {{ ucfirst(account()->fullName()) }}
@endsection

@section('information')
    This is the heart of your CMS Application, giving you a quick overview glance of everything that has been going on lately. <br>
    Our live statistical feeds come straight from google analytics, giving you the professional data you can rely on.
@endsection

@section('content')
    content
@endsection