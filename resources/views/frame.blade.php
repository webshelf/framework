@extends("webpage::master")

@section('webpage.title', sprintf("%s Landing v%s", framework()->package, framework()->version))

@section('webpage.content')

<body>

    <div class="flex-center position-ref full-height">
        <div class="top-right links">
            <?php /** @var \App\Classes\Library\PageLoader\Webpage $webpage */ ?>
            <?php /** @var \App\Model\Menu $menu */ ?>

            @foreach ($webpage->navigation->main() as $menu)
                <a class="{{ $menu->classState() }}" href="{{ $menu->route() }}">{{ $menu->title }}</a>
            @endforeach

            @if (auth()->check() == false)
                <a href="{{ route('login') }}">Login</a>
            @endif
        </div>

        <div class="content">

            <div class="title m-b-md">
                <span class="content-page">@yield('content')</span>
                <br>
                <span class="framework">{{ framework()->package }} v{{ framework()->version }}</span>
            </div>

            <div class="links">
                @foreach ($webpage->navigation->sidebar() as $menu)
                    <a href="{{ $menu->route() }}" class="{{ $menu->classState() }}">{{ $menu->title }}</a>
                @endforeach
            </div>
        </div>
    </div>

    @yield('content')

</body>

@endsection