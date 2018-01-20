@extends('dashboard::frame')

@section('title')
    Sitemap
@endsection

@section('information')
    What search engines see when they visit your site.
@endsection

@section('content')

    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">Location</th>
            <th scope="col">Modified</th>
            <th scope="col">Checkup</th>
            <th scope="col">Priority</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($sitemaps as $sitemap)
            <tr>
                <td>{{ $sitemap['url_location'] }}</td>
                <td>{{ $sitemap['last_modified'] }}</td>
                <td>{{ $sitemap['change_frequency'] }}</td>
                <td>{{ $sitemap['priority'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection