@extends('dashboard::frame')

@section('title')
    <h1>File Management System</h1>
@endsection

@section('information')
    <p> Manage and control the images and media stored on your web application servers or previous assets your website uses. </p>
@endsection

@section('content')

    <!-- elFinder initialization (REQUIRED) -->
    <script type="text/javascript" charset="utf-8">
        // Documentation for client options:
        // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
        $().ready(function() {
            $('#elfinder').elfinder({
                customData: {
                    lang: 'end',
                    _token: '<?= csrf_token() ?>'
                },
                url : '<?= route("elfinder.connector") ?>'  // connector URL
            });
        });
    </script>

    <!-- Element where elFinder will be created (REQUIRED) -->
    <div id="elfinder"></div>

    <iframe style="height:500px; width:100%; border:none;" src="{{ route('elfinder.popup', 1) }}"></iframe>

@endsection