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
                    <input type="text" name="title" class="form-control" placeholder="Enter Category Name" required>
                </div>
            </div>
            <div class="ml-2">
                <button class="btn btn-create">Add This Category</button>
            </div>
        </div>
    </form>

    <div class="webshelf-table">

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
                        <li><a href="{{ route('admin.articles.categories.destroy', $category->slug) }}" data-type="alert" data-confirm="Are you sure you want to delete this category?" data-method="delete">Delete</a></li>
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