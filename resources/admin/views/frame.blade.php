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

        <section id="body-margin-top-40">

            @include('dashboard::structure.sidebar')
            
            @include('dashboard::structure.content')

        </section>

    </body>

</html>
