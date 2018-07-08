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

                <div class="avatar">
                    <img data-toggle="tooltip" data-placement="left" title="Updated by {{ $redirect->editor->fullName() }}" src="{{ $redirect->editor->avatar }}" alt="">
                </div>

                <div class="details">
                    <div class="title">
                        Redirect from: <a href="{{ route('admin.redirects.edit', $redirect->id) }}">{{ url($redirect->from()) }}</a>
                    </div>
                    <div class="website">
                        Redirect to: {{ url($redirect->to()) }}
                    </div>
                </div>

                <div class="console">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('admin.redirects.edit', ['name' => $redirect->id]) }}">Edit</a></li>
                        <li><a href="{{ route('admin.redirects.destroy', ['menu' => $redirect->id]) }}" data-type="alert" data-confirm="Are you sure you want to remove this menu?" data-method="delete">Remove</a></li>
                    </ul>
                </div>

                <div class="stats">
                    <div class="views">
                        Clicks: Untracked
                    </div>
                    <div class="timestamp">
                        updated {{ $menu->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        @endforeach

    </div>

@endsection