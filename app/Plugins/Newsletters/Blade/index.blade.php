@extends('dashboard::frame')

@section('title')
    Newsletters
@endsection

@section('information')
    Manage the users who have signed up for newsletters on your site.
@endsection

@section('content')

    {{--<form>--}}
        {{--<div class="searchbar">--}}
            {{--<div class="text form-row">--}}
                {{--<div class="col">--}}
                    {{--<input type="text" class="form-control" placeholder="Search...">--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="pull-right ml-2">--}}
                {{--<a href="{{ route('admin.articles.create') }}" class="btn btn-create">Create Newsletter</a>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</form>--}}

    <div class="webshelf-table">

        <?php /** @var \App\Model\Article $article */ ?>

        @foreach($newsletters as $newsletter)
            <div class="row">

                <div class="details">
                    <div class="title">
                        <a href="{{ route('admin.articles.edit', $newsletter->id) }}">{{ $newsletter->title }}</a>
                    </div>
                    <div class="website">
                        {{--{{ $article->route() }}--}}
                    </div>
                </div>

                <div class="console">
                    <ul class="list-unstyled">
                        {{--<li>{!! css()->link->edit(route('admin.articles.edit', $article->slug)) !!}</li>--}}
                        {{--<li>{!! css()->status->sitemap($article->sitemap) !!}</li>--}}
                        {{--<li>{!! css()->status->status($article->status) !!}</li>--}}
                        {{--<li>{!! css()->link->destroy(route('admin.articles.destroy', $article->slug)) !!}</li>--}}
                        {{--<li>{!! css()->link->view(url($article->route())) !!}</li>--}}
                    </ul>
                </div>

                <div class="stats">
                    <div class="views">
{{--                        <i class="fa fa-eye" aria-hidden="true"></i> {{ $article->views }}--}}
                    </div>
                    <div class="timestamp">
{{--                        updated {{ $article->updated_at->diffForHumans() }}--}}
                    </div>
                </div>
            </div>
        @endforeach

    </div>

@endsection