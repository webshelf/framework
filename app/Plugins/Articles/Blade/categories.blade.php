@extends('dashboard::frame')

@section('title')
    Article Categories.
@endsection

@section('information')
    Manage your article category listing for better seo and organization.
@endsection

@section('content')

    @include('dashboard::structure.validation')

    <form action="{{ route('admin.articles.categories.store') }}" method="post">

        {{ csrf_field() }}

        <div class="searchbar" style="background-color: white">
            <div class="text form-row">
                <div class="col">
                    <input type="text" name="name" class="form-control" placeholder="Enter Category Name" required>
                </div>
            </div>
            <div class="ml-2">
                <button class="btn btn-create">Add This Category</button>
            </div>
        </div>
    </form>

    <div class="webshelf-table">

        <?php /** @var \App\Model\ArticleCategory $category */ ?>

        @foreach($categories as $category)
            <div class="row">

                <div class="details">
                    <div class="title">
                        {{ $category->title }}
                    </div>
                    <div class="website">
                       {{ $category->articles()->count() }} {{ str_plural('Article', $category->articles()->count()) }}
                    </div>
                </div>

                <div class="console">
                    <ul class="list-unstyled">
                        {{--<li>{!! css()->link->edit(route('admin.articles.edit', $article->slug)) !!}</li>--}}
                        {{--<li>{!! css()->status->sitemap($article->sitemap) !!}</li>--}}
                        {{--<li>{!! css()->status->status($article->status) !!}</li>--}}
                        <li>{!! css()->link->destroy(route('admin.articles.categories.destroy', $category->id)) !!}</li>
                        {{--<li>{!! css()->link->view(url($article->route())) !!}</li>--}}
                    </ul>
                </div>

                <div class="stats">
                    <div class="views">
                        {{ $category->creator->fullName() }}
                    </div>
                    <div class="timestamp">
                        updated {{ $category->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        @endforeach

    </div>


@endsection