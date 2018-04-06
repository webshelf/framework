<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>

    <?php /** @var \App\Classes\Library\PageLoader\Webpage $webpage */ ?>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield("webpage.title", $webpage->title())</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ mix('assets/frontend.css') }}" rel="stylesheet">
    @stack("webpage.styles")

    <!-- Scripts -->
    <script src="{{ mix('assets/frontend.js') }}"></script>
    @stack("webpage.scripts")

</head>

    @yield('webpage.content')

</html>