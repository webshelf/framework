<!doctype html>
<html lang="en">
<head>
    <title>{{ framework()->package }} v{{ framework()->version }}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ mix('assets/backend.css') }}">
    <script src="{{ mix('assets/backend.js') }}"></script>

</head>

<body>

    @include('dashboard::structure.navbar')

    @include('dashboard::structure.sidebar')

    @include('dashboard::structure.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    {{--<div class="container">--}}
        {{--<div class="information">--}}
            {{--<h3>@yield('title', ucwords(currentURI()))</h3>--}}
            {{--<p>@yield('information', '')</p>--}}
        {{--</div>--}}
    {{--</div>--}}

    <div class="container page-details">
        <h3>@yield('title')</h3>
        <p>@yield('information')</p>
        <hr>
    </div>

    <div class="container">

        @yield('content')

    </div>

</body>

</html>
