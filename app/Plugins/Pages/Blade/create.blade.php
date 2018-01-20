@extends('dashboard::frame')

@section('title')
    Create Page
@endsection

@section('information')
    New page content that will be accessible to your website visitors.
@endsection

@section('content')

    @include('dashboard::structure.validation')

    <form action="{{ route('admin.pages.store') }}" method="POST">
    
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

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
                    <label for="slug">Slug</label>
                    <input type="text" class="form-control" name="slug" id="slug" aria-describedby="slugHelp" value="{{ old('slug') }}" readonly>
                    <small id="slugHelp" class="form-text text-muted">Create the url slug that will be used.</small>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="prefix">Prefix (Group)</label>
                    <input type="text" class="form-control" name="prefix" id="prefix" aria-describedby="prefixHelp" value="{{ old('prefix') }}">
                    <small id="prefixHelp" class="form-text text-muted">Group the page for better SEO.</small>
                </div>
            </div>
        </div>

        <div class="form-group">
          <label for="keywords">Keywords</label>
          <input type="text" class="form-control" name="keywords" id="keywords" aria-describedby="keywordsHelp" value="{{ old('keywords') }}">
          <small id="keywordsHelp" class="form-text text-muted">Tags help your page be found by search engines.</small>
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <textarea class="form-control" name="description" id="description" aria-describedby="descriptionHelp" rows="2">{{ old('description') }}</textarea>
          <small id="descriptionHelp" class="form-text text-muted">Describe your page to search engines and users.</small>
        </div>

        <div class="form-group">
          <label for="content">Content</label>
          <textarea class="form-control editor" name="content" id="content" aria-describedby="contentHelp" rows="18">{{ old('content') }}</textarea>
          <small id="contentHelp" class="form-text text-muted">The content that will be shown to users who view the page.</small>
        </div>

        <div class="form-actions">

            <button type="submit" class="btn btn-create">Create Page</button>

            <div class="pull-right">
                <button type="reset" class="btn btn-reset">Reset</button>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-cancel">Cancel</a>
            </div>
        </div>

    </form>

@endsection