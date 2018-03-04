@extends('dashboard::frame')

@section('title')
    Edit Article
@endsection

@section('information')
    Edit an article already existing on your website application.
@endsection

@section('content')

    <?php /** @var \App\Model\Article $article */ ?>

    <script type="text/javascript" src="/packages/barryvdh/elfinder/js/standalonepopup.min.js"></script>

    @include('dashboard::structure.validation')

    <form action="{{ route('admin.articles.update', $article->slug) }}" method="post">

        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PATCH">

        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="title" aria-describedby="titleHelp" value="{{ old('title', $article->title) }}">
                    <small id="titleHelp" class="form-text text-muted">The page title to be displayed.</small>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" name="category" id="category">
                        <option value=""></option>
                        @if($article->category && $article->category->id)
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $article->category->id == $category->id ? 'selected' : null }}>{{ $category->title }}</option>
                            @endforeach
                        @else
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" name="status" id="status">
                        <option value="1" {{ $article->status == 1 ? 'selected' : null }}>Public</option>
                        <option value="0" {{ $article->status == 0 ? 'selected' : null }}>Private</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="featured_image">Featured Image</label>
            <div class="input-group">
                <div class="input-group">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary popup_selector" data-inputid="image" type="button">Select Image</button>
                            </span>
                    <input id="image" type="text" class="form-control" name="image" value="{{ old('image', $article->featured_img) }}">
                </div>
            </div>
            <small id="helpId" class="form-text text-muted">The image used to represent this post and entice users.</small>
        </div>

        <div class="form-group">
            <label for="content">Article Content</label>
            <textarea class="form-control editor" name="content" id="content" aria-describedby="contentHelp" rows="18">{{ old('content', $article->content) }}</textarea>
            <small id="contentHelp" class="form-text text-muted">The content that should be set for the article.</small>
        </div>

        <div class="form-actions">

            <button type="submit" class="btn btn-create">Update Article</button>

            <div class="pull-right">
                <button type="reset" class="btn btn-reset">Reset</button>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-cancel">Cancel</a>
            </div>
        </div>

    </form>

@endsection