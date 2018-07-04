<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>{{ $page['seo']['title'] }}</title>

    <link rel="shortcut icon" href="{{ url('/favicon.ico') }}" type="image/ico"/>

    <!-- Required meta tags -->
    <meta name="cache-control" content="public">
    <meta name="keywords"      content="{{ $page['seo']['keywords'] }}">
    <meta name="description"   content="{{ $page['seo']['description'] }}">
    <meta name="author"        content="//webshelf.com">

    <script>window.Laravel =  {!! json_encode(['csrfToken' => csrf_token()]) !!}</script>

    <!-- THIS SHOULD BE AVAILABLE TO ALL APPLICATIONS REGARDLESS IF ITS ACTUALLY NEEDED -->
    @if(settings()->getValue('bing_webmaster_code'))
        <meta name="msvalidate.01" content="{{ settings()->getValue('bing_webmaster_code') }}"/>
    @endif

    @if(settings()->getValue('google_analitycs_code'))
        @include('website::templates.google.analytics')
        <meta name="google-site-verification" content="{{ settings()->getValue('google_webmaster_code') }}" />
    @endif

    @if(settings()->getValue('enable_website') == false)
        <span style="color:white; background-color: red; padding:5px 0; text-align: center">Website is currently offline to the public</span>
    @endif

    @yield('html.header')

</head>