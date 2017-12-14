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

    </head>

    <body>

        @include('dashboard::structure.navbar')

        @include('dashboard::structure.sidebar')

        @include('dashboard::structure.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

        @include('dashboard::structure.information')

        @include('dashboard::structure.content')

    </body>

    <script src="{{ mix('assets/backend.js') }}"></script>

</html>
