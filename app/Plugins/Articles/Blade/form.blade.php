@extends('dashboard::frame')

@section('title')
    @if($article->exists)
        Edit Article
    @else
        Create Article
    @endif
@endsection

@section('information')
    @if($article->exists)
        Edit an article already existing on your website application.
    @else
        Provide your website users with new articles to gaze upon and read
    @endif
@endsection

@section('content')

    <script type="text/javascript" src="/packages/barryvdh/elfinder/js/standalonepopup.min.js"></script>

    @include('dashboard::structure.validation')

    @if($article->exists)
        <form action="{{ route('admin.articles.update', $article->slug) }}" method="post">
        <input type="hidden" name="_method" value="PATCH">
    @else
        <form action="{{ route('admin.articles.store') }}" method="post">
    @endif

        {{ csrf_field() }}

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="title" aria-describedby="titleHelp" value="{{ old('title', optional($article)->title) }}">
                    <small id="titleHelp" class="form-text text-muted">The page title to be displayed.</small>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select class="form-control" name="category_id" id="category_id">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category', optional($article->category)->id) == $category->id ? 'selected' : null }}>{{ $category->title }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Group articles together.</small>
                </div>
            </div>
        </div>

        <div class="row">
        <div class="col-4">
                <div class="form-group">
                    <label for="status">Publish Status</label>
                    <select class="form-control" name="status" id="status">
                        <option value="{{ App\Model\Article::STATUS_PUBLIC }}" {{  old('status', optional($article)->status) == App\Model\Article::STATUS_PUBLIC ? 'selected' : null }}>Public</option>
                        <option value="{{ App\Model\Article::STATUS_PRIVATE }}" {{  old('status', optional($article)->status) == App\Model\Article::STATUS_PRIVATE ? 'selected' : null }}>Private</option>
                    </select>
                    <small class="form-text text-muted">Set the visability status of this article to others.</small>
                </div>
            </div>
            <script>
                $(document).ready(function () {
                    // load datetime picker to this class.
                    $('#publish_date').datetimepicker({
                        format : 'MM/DD/YYYY',
                        defaultDate: '{{  old('publish_date', optional($article->publish_date)->format("m/d/y")) ?: \Carbon\Carbon::now()->format("m/d/y")}}',
                    });
                })
            </script>
            <div class="col-4">
                <div class="form-group">
                    <label for="">Publish Date</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend btn-clear-form">
                            <div class="input-group-text"><i class="fas fa-sync"></i></div>
                        </div>
                        <input type="datetime" class="form-control datetimepicker" name="publish_date" id="publish_date" aria-describedby="publish_date_help">
                    </div>
                    <small id="publish_date_help" class="form-text text-muted">[Month, Day, Year] The Starting point for uploading the article.</small>
                </div>
            </div>
            <script>
                $(document).ready(function () {
                    $('#unpublish_date').datetimepicker({
                        format : 'MM/DD/YYYY',
                        defaultDate: '{{  old('unpublish_date', optional($article->unpublish_date)->format("m/d/y")) }}',
                    });
                });
                </script>
            <div class="col-4">
                <div class="form-group">
                    <label for="">Unpublish Date</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend btn-clear-form">
                            <div class="input-group-text"><i class="fas fa-sync"></i></div>
                        </div>
                        <input type="datetime" class="form-control datetimepicker" name="unpublish_date" id="unpublish_date" aria-describedby="unpublish_date_help">
                    </div>
                    <small id="unpublish_date_help" class="form-text text-muted">[Month, Day, Year] The Ending point for removing the article.</small>
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
                    <input id="image" type="text" class="form-control" name="image" value="{{ old('image', optional($article)->featured_img) }}">
                </div>
            </div>
            <small id="helpId" class="form-text text-muted">The image used to represent this post and entice users.</small>
        </div>

        <div class="form-group">
            <label for="content">Article Content</label>
            <textarea class="form-control editor" name="content" id="content" aria-describedby="contentHelp" rows="18">{{ old('content', optional($article)->content) }}</textarea>
            <small id="contentHelp" class="form-text text-muted">The content that should be set for the article.</small>
        </div>

        <div class="form-actions">

            @if ($article->exists)
                <button type="submit" class="btn btn-create">Edit Article</button>
            @else
                <button type="submit" class="btn btn-create">Create Article</button>
            @endif

            <div class="pull-right">
                <button type="reset" class="btn btn-reset">Reset</button>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-cancel">Cancel</a>
            </div>
        </div>

    </form>

@endsection
