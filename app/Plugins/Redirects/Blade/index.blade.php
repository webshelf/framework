@extends('dashboard::frame')

@section('title')
   Redirects
@endsection

@section('information')
    Redirect website visitors from one location to another.
@endsection

@section('content')

    <form>
        <div class="searchbar">
            <div class="text form-row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Search...">
                </div>
            </div>
            <div class="pull-right ml-2">
                <a href="{{ route('admin.redirects.create') }}" class="btn btn-create">Create Redirect</a>
            </div>
        </div>
    </form>

    <div class="webshelf-table">

        @foreach($redirects as $redirect)
            <div class="row">

                <div class="details">
                    <div class="title">
                        <a href="{{ route('admin.redirects.edit', $redirect->id) }}">{{ url($redirect->from()) }}</a>
                    </div>
                    <div class="website">
                        => {{ url($redirect->to()) }}
                    </div>
                </div>

                <div class="console">
                    <ul class="list-unstyled">
                        <li>{!! css()->link->edit(route('admin.redirects.edit', $redirect->id)) !!}</li>
                        <li>{!! css()->link->destroy(route('admin.redirects.destroy', $redirect->id)) !!}</li>
                    </ul>
                </div>

                <div class="stats">
                    <div class="views">
                        {{--<i class="fa fa-eye" aria-hidden="true"></i> {{ $page->views }}--}}
                    </div>
                    <div class="timestamp">
                        updated {{ $redirect->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        @endforeach

    </div>

@endsection