@extends('dashboard::frame')

@section('title', '<h1>Viewing your website articles</h1>')

@section('information', '<p>Placing articles into their correct categories and keeping the information relevant to the article keeps people engaged.</p>')

@section('content')

        <div class="table-panel border light">

            <table id="table-datatables" class="table table-striped table-bordered table-hover row-border order-column">

                <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Status</th>
                    <th>Posted</th>
                    <th>Modifier</th>
                    <th>Creator</th>
                </tr>
                </thead>

                <tbody>
                @foreach($articles as $article)
                    <tr>
                        <td>{{ $article->title() }}</td>
                        <td>{{ str_limit($article->content(), 150, '...') }}</td>
                        <td>{{ bool2Status($article->publish(), 'Published', 'Hidden') }}</td>
                        <td>{{ $article->publishDate() }}</td>
                        <td>N/A</td>
                        <td>N/A</td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>

@endsection

@section('javascript', "<script> $(document).ready(function(){ $('#table-datatables').DataTable({ 'iDisplayLength': 25 }); });</script>")