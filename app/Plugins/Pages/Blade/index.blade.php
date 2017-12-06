@extends('dashboard::frame')

@section('title')
    Pages
@endsection

@section('information')
    View the pages that your website currently holds along with the status of each.
@endsection

@section('content')

    <form>
        <div class="searchbar">
            <div class="text form-row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Search...">
                </div>
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
                        {{ makeUrl($page) }}
                    </div>
                </div>

                <div class="console">
                    <ul class="list-unstyled">
                        <li>{!! css()->link->edit(route('admin.pages.edit', ["name"=>$page->slug])) !!}</li>
                        <li>{!! css()->status->sitemap($page->sitemap) !!}</li>
                        <li>{!! css()->status->status($page->enabled) !!}</li>
                        <li>{!! css()->link->view(makeUrl($page)) !!}</li>
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