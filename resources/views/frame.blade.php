<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php /** @var \App\Classes\Library\PageLoader\Webpage $webpage */ ?>
    <title>{{ $webpage->title() }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ mix('assets/frontend.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ mix('assets/frontend.js') }}"></script>

    <style>
        html, body {
            background-color: #fff;
            color: #8f8f8f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .framework {
            color: #e57319;
            font-size: 84px;
        }

        .content-page {
            color: #19bbe5;
            font-size: 25px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .links > a {
            padding:15px;
        }

        .links > a.active {
            background-color:#636b6f1c;
        }

        .links > a:hover {
            background-color: #abe3ff24;
        }
    </style>

</head>

<body>

    <div class="flex-center position-ref full-height">
        <div class="top-right links">
            <?php /** @var \App\Classes\Library\PageLoader\Webpage $webpage */ ?>
            <?php /** @var \App\Model\Menu $menu */ ?>

            @foreach ($webpage->navigation->main() as $menu)
                <a class="{{ $menu->classState() }}" href="{{ $menu->route() }}">{{ $menu->title }}</a>
            @endforeach

            @if (Auth::check() == false)
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

</html>