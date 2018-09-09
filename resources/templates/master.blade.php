<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>

    <?php /** @var \App\Classes\Library\PageLoader\Webpage $webpage */ ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial -scale=1">

    {{-- Normal page loading meta tags. --}}
    <title>@yield("webpage.title", $webpage->title())</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" value=``"@yield('webpage.keywords', $webpage->keywords())">
    <meta name="description" value="@yield('webpage.description', $webpage->description())">

    {{-- Favicon Image Icon --}}
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('favicon.ico') }}"/>
    
    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    {{-- Styles --}}
    <link href="{{ mix('assets/frontend.css') }}" rel="stylesheet">
    <!-- <link href="{{ mix('assets/modules.css') }}" rel="stylesheet"> -->
    @stack("styles")

    {{-- Scripts --}}
    <script src="{{ mix('assets/frontend.js') }}"></script>
    <script src="{{ mix('assets/modules.js') }}"></script>
    @stack("scripts")

    {{-- Google analytics tracking --}}
    @if (config()->has('website.webmaster.google.tracking'))
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('website.webmaster.google.tracking') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{ config('website.webmaster.google.tracking') }}');
        </script>
    @endif

</head>

    @yield('webpage.content')

</html>
