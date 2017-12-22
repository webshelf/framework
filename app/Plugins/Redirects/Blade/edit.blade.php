@extends('dashboard::frame')

@section('title')
    Create Redirect
@endsection

@section('information')
    Redirect an existing page to another on your website.
@endsection

@section('content')

    @include('dashboard::structure.validation')

    <form action="{{ route('admin.redirects.update', $redirect->id) }}" method="post">

        <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <?php /** @var \App\Model\Page $page */ ?>

        <div class="form-group">
            <label for="redirectFromPage">Redirect From Page</label>
            <select class="form-control" name="redirectFromPage" id="redirectFromPage">
                @foreach ($pages as $page)
                    <option value="{{ $page->id }}" {{ $redirect->from == $page->id ? 'selected' : 'null' }}>{{ $page->seo_title }}</option>
                @endforeach
            </select>
            <small id="titleHelp" class="form-text text-muted">Select the page you wish to redirect from.</small>
        </div>

        <div class="form-group">
            <label for="redirectToPage">Redirect To Page</label>
            <select class="form-control" name="redirectToPage" id="redirectToPage">
                @foreach ($pages as $page)
                    <option value="{{ $page->id }}" {{ $redirect->to == $page->id ? 'selected' : 'null' }}>{{ $page->seo_title }}</option>
                @endforeach
            </select>
            <small id="titleHelp" class="form-text text-muted">Redirect the page to this page.</small>
        </div>

        <div class="form-actions">

            <button type="submit" class="btn btn-create">Create Redirect</button>

            <div class="pull-right">
                <button type="reset" class="btn btn-reset">Reset</button>
                <a href="{{ route('admin.redirects.index') }}" class="btn btn-cancel">Cancel</a>
            </div>
        </div>

    </form>

@endsection