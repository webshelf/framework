@extends('website::frame')

@section('content')

    <div class="flex-center position-ref full-height">
        <div class="top-right links">
            @foreach($page['menus'] as $menu)
                <a class="{{ $menu['active'] }}" href="{{ url($menu['link']) }}">{{ $menu['title'] }}</a>
            @endforeach

            @if (Auth::check() == false)
                <a href="{{ route('login') }}">Login</a>
            @endif
        </div>

        <div class="content">

            <div class="title m-b-md">

                <span class="content-page">@yield('error.message', 'index.blade.php')</span>

                <br>

                <span class="framework">Laravel 5.4</span>

            </div>

            <div class="links">
                <a href="https://laravel.com/docs">Documentation</a>
                <a href="https://laracasts.com">Laracasts</a>
                <a href="https://laravel-news.com">News</a>
                <a href="https://forge.laravel.com">Forge</a>
                <a href="https://github.com/laravel/laravel">GitHub</a>
            </div>
        </div>
    </div>

@endsection