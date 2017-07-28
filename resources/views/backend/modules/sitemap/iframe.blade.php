@extends('dashboard::frame')

@section('javascript')

    <script>
        $(document).ready(function(){
            $('#table-datatables').DataTable({
                'iDisplayLength': 50
            });
        });
    </script>

@endsection

@section('title')
    <h1>Seo Sitemap</h1>
@endsection

@section('information')
    <p>
        The most vital part of being found on the world wide web, is a sitemap that tells the world what you have to offer.
        <br>
        Your application gives you the power to choose what you want search engines to see, while automatically generating data from your content.
    </p>
@endsection

@section('content')

    <div class="table-panel border light">

        <table id="table-datatables" class="table table-striped table-bordered table-hover row-border order-column">

        <thead>
        <tr>
            <th>Content Location</th>
            <th>SEO Modified Date</th>
            <th>SEO Frequency</th>
            <th>SEO Priority</th>
        </tr>
        </thead>

        <tbody>
        @foreach($sitemaps as $sitemap)
            <tr>
                <td><a href="{{ $sitemap['url_location'] }}" style="color:green">{{ $sitemap['url_location'] }}</a></td>
                <td>{{ $sitemap['last_modified'] }}</td>
                <td>{{ $sitemap['change_frequency'] }}</td>
                <td>{{ $sitemap['priority'] }}</td>
            </tr>
        @endforeach
        </tbody>

    </table>

    </div>

@endsection