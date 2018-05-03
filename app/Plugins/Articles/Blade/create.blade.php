@extends('dashboard::frame')

@section('title')
    Create Article
@endsection

@section('information')
    Provide your website users with new articles to gaze upon and read.
@endsection

@section('content')

    <script type="text/javascript" src="/packages/barryvdh/elfinder/js/standalonepopup.min.js"></script>

    @include('dashboard::structure.validation')

    <form action="{{ route('admin.articles.store') }}" method="post">

        {{ csrf_field() }}

        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="title" aria-describedby="titleHelp" value="{{ old('title') }}">
                    <small id="titleHelp" class="form-text text-muted">The page title to be displayed.</small>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" name="category" id="category">
                        <option value=""></option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Group articles together.</small>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="status">Visibility</label>
                    <select class="form-control" name="status" id="status">
                        <option value="{{ \App\Model\Article::STATUS_PUBLIC }}" selected>Public</option>
                        <option value="{{ \App\Model\Article::STATUS_PRIVATE }}">Private</option>
                    </select>
                    <small class="form-text text-muted">Set the visibility of this article to others.</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Publish Date</label>
                    <input type="datetime" class="form-control" name="publish_date" id="publish_date" aria-describedby="publish_date_help" placeholder="">
                    <small id="publish_date_help" class="form-text text-muted">The starting date that this article will be viewable on.</small>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Unpublish Date</label>
                    <input type="datetime" class="form-control" name="unpublish_date" id="unpublish_date" aria-describedby="unpublish_date_help" placeholder="">
                    <small id="unpublish_date_help" class="form-text text-muted">The date at which this article will be no longer viewable.</small>
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
                    <input id="image" type="text" class="form-control" name="image" value="{{ old('image') }}">
                </div>
            </div>
            <small id="helpId" class="form-text text-muted">The image used to represent this post and entice users.</small>
        </div>

        <div class="form-group">
            <label for="content">Article Content</label>
            <textarea class="form-control editor" name="content" id="content" aria-describedby="contentHelp" rows="18">{{ old('content') }}</textarea>
            <small id="contentHelp" class="form-text text-muted">The content that should be set for the article.</small>
        </div>

        <div class="form-actions">

            <button type="submit" class="btn btn-create">Create Article</button>

            <div class="pull-right">
                <button type="reset" class="btn btn-reset">Reset</button>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-cancel">Cancel</a>
            </div>
        </div>

    </form>

@endsection