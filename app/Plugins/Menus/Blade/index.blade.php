@extends('dashboard::frame')

@section('title')
    Website Menus
@endsection

@section('information')
    The navigation bar is made up from a collection of menus, this module controls the layout and structure of that navigation bar.
@endsection

@section('content')

    <div class="webshelf-scope-menu">

        <ul class="list-unstyled">

            @foreach($menus as $menu)

                <?php /** @var \App\Model\Menu $menu */ ?>

                <li class="item">
                    <a href="{{ route('admin.menus.group', ["group_id" => $menu->id]) }}" class="{{ Request::segment(4) == $menu->id ? 'active' : null }}">
                        <span class="title">{{ $menu->title }}</span>
                        <span class="badge">{{ count($menu->children->toArray()) }}</span>
                    </a>
                </li>

            @endforeach

        </ul>

    </div>

    <div class="alert alert-warning" role="alert">
        <i class="fa fa-fire" aria-hidden="true"></i> Reorder your menus by dragging and dropping to the designated spot. 
    </div>

    <form>
        <div class="searchbar">
            <div class="text form-row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Search..." id="search-table">
                </div>
            </div>
            <div class="pull-right ml-2">
                <a href="{{ route('admin.menus.create') }}" class="btn btn-create">Create Menu</a>
            </div>
        </div>
    </form>

    <div class="webshelf-table" id="sortable_menu">

        @if (count($list) == 0)
            No Submenus exist for this Parent Menu, Why not create one.
        @endif

        @foreach($list as $menu)
            <div class="row" data-id="{{ $menu->id }}">

                {{--<i class="fas fa-list"></i>--}}

                <div class="details">
                    <div class="title">
                        <a href="">{{ $menu->title }}</a>
                    </div>
                    <div class="website">
                        {{ $menu->link->url()}}
                    </div>
                </div>

                <div class="console">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('admin.menus.edit', ['name' => $menu]) }}">Edit</a></li>
                        <li><a href="{{ route('admin.menus.destroy', ['menu' => $menu->id]) }}" data-type="alert" data-confirm="Are you sure you want to remove this menu?" data-method="delete">Remove</a></li>
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

    <script>
        let menu = Sortable.create(sortable_menu, {
            animation: 119,
            sort: true,
            // Element dragging ended
            onSort: function (/**Event*/evt) {
                axios.post('/admin/menus/reorder', {
                    data: menu.toArray(evt.to)
                })
                    .then(function (response) {
                        //console.log(response);
                    })
                    .catch(function (error) {
                        //console.log(error);
                    });
            },
        });
    </script>

@endsection
