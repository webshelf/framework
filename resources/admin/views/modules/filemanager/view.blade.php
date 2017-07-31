@extends('dashboard::frame')

@section('information')
    <p>
        The most vital part of being found on the world wide web, is a sitemap that tells the world what you have to offer.
        <br>
        Your application gives you the power to choose what you want search engines to see, while automatically generating data from your content.
    </p>
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