@extends('dashboard::frame')

@section('title')
    Website Articles
@endsection

@section('information')
    Articles create the section of your website that contains the blog/news or related feature.
@endsection

@section('content')

    <form>
        <div class="searchbar">
            <div class="text form-row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Search..." id="search-table">
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

                <div class="avatar">
                    <img data-toggle="tooltip" data-placement="left" title="Updated by {{ $article->editor->fullName() }}" src="{{ $article->editor->avatar }}" alt="">
                </div>

                <div class="details">
                    <div class="title">
                        <a href="{{ route('admin.articles.edit', ["name"=>$article->slug]) }}">{{ ucwords( $article->title) }}</a>
                    </div>
                    <div class="website">
                        Updated {{ $article->updated_at->diffForHumans() }}
                    </div>
                </div>

                <div class="console">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('admin.articles.edit', $article->slug) }}">Edit</a></li>
                        @if ($article->isPublished()) <li><a href="{{ url($article->route()) }}">View</a></li> @endif
                        <li><a href="{{ route('admin.articles.destroy', $article->slug) }}" data-type="alert" data-confirm="Are you sure you want to delete this article?" data-method="delete">Delete</a></li>
                    </ul>
                </div>

                <div class="stats">
                    <div class="views">
                        <i class="fa fa-eye" aria-hidden="true"></i> Total Views: {{ $article->views }}
                    </div>
                    <div class="timestamp">
                        Publish Status: {!! $article->isPublished() ? '<b style="color: #2dc751">Public</b>' : '<b style="color: #dc3545">Private</b>' !!}
                    </div>
                </div>
            </div>
        @endforeach

    </div>

@endsection