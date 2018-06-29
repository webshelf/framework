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

        <!-- Application webpack -->
        <script src="{{ mix('assets/backend.js') }}"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>

    </head>

    <body>

        <div id="root">

            @include('dashboard::structure.navbar')

            <section id="body-margin-top-40">

                @include('dashboard::structure.sidebar')

                @include('dashboard::structure.content')

            </section>

        </div>

    </body>

</html>
