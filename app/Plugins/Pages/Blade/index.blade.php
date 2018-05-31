@extends('dashboard::frame')

@section('title')
    Pages
@endsection

@section('information')
    View the pages that your website currently holds along with the status of each.
@endsection

@section('content')

    <div class="webshelf-scope-menu">

        <ul class="list-unstyled">

            <li class="item">
                <a href="{{ route('admin.pages.index') }}" class="{{ Request::segment(3) == '' ? 'active' : null }}">
                    <span class="title">Normal</span>
                </a>
            </li>
            <li class="item">
                <a href="{{ route('admin.pages.special') }}" class="{{ Request::segment(3) == 'special' ? 'active' : null }}">
                    <span class="title">Special</span>
                </a>
            </li>

        </ul>

    </div>

    <form>
        <div class="searchbar">
            <div class="text form-row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Search...">
                </div>
            </div>
            <div class="pull-right ml-2">
                <a href="{{ route('admin.pages.create') }}" class="btn btn-create">Create Page</a>
        </div>
        </div>
    </form>

    <div class="webshelf-table">

        @foreach($pages as $page)
            <div class="row">

                <div class="details">
                    <div class="title">
                        <a href="{{ route('admin.pages.edit', ["name"=>$page->slug]) }}">{{ $page->seo_title }}</a>
                    </div>
                    <div class="website">
                        {{ $page->route() }}
                    </div>
                </div>

                <div class="console">
                    <ul class="list-unstyled">
                        <li data-toggle="tooltip" data-placement="bottom" title="Edit">{!! css()->link->edit(route('admin.pages.edit', $page->slug)) !!}</li>
                        <li data-toggle="tooltip" data-placement="bottom" title="Sitemap Status">{!! css()->status->sitemap($page->sitemap) !!}</li>
                        <li data-toggle="tooltip" data-placement="bottom" title="Visibility Status">{!! css()->status->status($page->enabled) !!}</li>
                        <li data-toggle="tooltip" data-placement="bottom" title="Delete">{!! css()->link->destroy(route('admin.pages.destroy', $page->slug)) !!}</li>
                        <li data-toggle="tooltip" data-placement="bottom" title="View Onlineedit">{!! css()->link->view(url($page->route())) !!}</li>
                    </ul>
                </div>

                <div class="stats">
                    <div class="views">
                        <i class="fa fa-eye" aria-hidden="true"></i> {{ $page->views }}
                    </div>
                    <div class="timestamp">
                        updated {{ $page->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        @endforeach

    </div>

@endsection