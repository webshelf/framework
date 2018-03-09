@extends('dashboard::frame')

@section('title')
    Articles
@endsection

@section('information')
    All the articles contained on your website.
@endsection

@section('content')

    <form>
        <div class="searchbar">
            <div class="text form-row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Search...">
                </div>
            </div>
            <div class="pull-right ml-2">
                <a href="{{ route('admin.articles.create') }}" class="btn btn-create">Create Article</a>
            </div>
            <div class="pull-right ml-2">
                <a href="{{ route('admin.articles.categories.index') }}" class="btn btn-create">Create Category</a>
            </div>
        </div>
    </form>

    <div class="webshelf-table">

        <?php /** @var \App\Model\Article $article */ ?>

        @foreach($articles as $article)
            <div class="row">

                <div class="details">
                    <div class="title">
                        <a href="{{ route('admin.articles.edit', ["name"=>$article->slug]) }}">{{ $article->title }}</a>
                    </div>
                    <div class="website">
                        {{ $article->route() }}
                    </div>
                </div>

                <div class="console">
                    <ul class="list-unstyled">
                        <li>{!! css()->link->edit(route('admin.articles.edit', $article->slug)) !!}</li>
                        <li>{!! css()->status->sitemap($article->sitemap) !!}</li>
                        <li>{!! css()->status->visibility($article->status) !!}</li>
                        <li>{!! css()->link->destroy(route('admin.articles.destroy', $article->slug)) !!}</li>
                        <li>{!! css()->link->view(url($article->route())) !!}</li>
                    </ul>
                </div>

                <div class="stats">
                    <div class="views">
                        <i class="fa fa-eye" aria-hidden="true"></i> {{ $article->views }}
                    </div>
                    <div class="timestamp">
                        updated {{ $article->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        @endforeach

    </div>

@endsection