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

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-117148224-1"></script>

    @if (settings()->getValue('google_site_tag'))
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{ settings()->getValue('google_site_tag') }}');
    </script>
    @endif


</head>

    @yield('webpage.content')

</html>