@extends('dashboard::frame')

<?php use App\Plugins\Pages\Model; ?>

@section('title')
    Website Pages
@endsection

@section('information')
    A Page represents the information that will be shown on the url link when visited, these can be attached to the navigation through the menus modules.
@endsection

@section('content')

    <div class="webshelf-scope-menu">

        <ul class="list-unstyled">

            <li class="item">
                <a href="{{ route('admin.pages.index') }}" class="{{ Request::segment(3) == '' ? 'active' : null }}">
                    <span class="title">Normal Pages</span>
                </a>
            </li>
            <li class="item">
                <a href="{{ route('admin.pages.plugin') }}" class="{{ Request::segment(3) == 'plugin' ? 'active' : null }}">
                    <span class="title">Plugin Pages</span>
                </a>
            </li>
            <li class="item">
                <a href="{{ route('admin.pages.error') }}" class="{{ Request::segment(3) == 'error' ? 'active' : null }}">
                    <span class="title">Error Pages</span>
                </a>
            </li>

        </ul>

    </div>

    <form>
        <div class="searchbar">
            <div class="text form-row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Search..." id="search-table">
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

                <div class="avatar">
                    <img data-toggle="tooltip" data-placement="left" title="Updated by {{ $page->editor->fullName() }}" src="{{ $page->editor->avatar }}" alt="">
                </div>

                <div class="details">
                    <div class="title">
                        <a href="{{ route('admin.pages.edit', ["name"=>$page->slug]) }}">{{ $page->seo_title }}</a>
                    </div>
                    <div class="website">
                        Updated {{ $page->updated_at->diffForHumans() }}
                    </div>
                </div>

                <div class="console">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('admin.pages.edit', $page->slug) }}">Edit</a></li>
                        <li><a href="{{ url($page->route()) }}">View</a></li>
                        <li><a href="{{ route('admin.pages.destroy', $page->slug) }}" data-type="alert" data-confirm="Are you sure you want to delete this page?" data-method="delete">Delete</a></li>
                    </ul>
                </div>

                <div class="stats">
                    <div class="views">
                        <i class="fa fa-eye" aria-hidden="true"></i> Total Views: {{ $page->views }}
                    </div>
                    <div class="timestamp">
                        {{ url($page->route()) }}
                    </div>
                </div>
            </div>
        @endforeach

    </div>

@endsection