@extends('dashboard::frame')

@section('title')
    Menus
@endsection

@section('information')
    Menus are what allow users to click through your web pages. <br>
    <br>
    <b>Usage:</b> Reorder your menus by dragging and dropping to the designated spot.
@endsection

@section('content')

    <div class="webshelf-scope-menu">

        <ul class="list-unstyled">

            @foreach($menus as $menu)

                <?php /** @var \App\Model\Menu $menu */ ?>

                <li class="item">
                    <a href="{{ route('admin.menus.group', ["group_id" => $menu->id]) }}">
                        <span class="title">{{ $menu->title }}</span>
                        <span class="badge">{{ count($menu->children->toArray()) }}</span>
                    </a>
                </li>

            @endforeach

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
                <a href="{{ route('admin.menus.create') }}" class="btn btn-create">Create Menu</a>
            </div>
        </div>
    </form>

    <div class="webshelf-table" id="sortable_menu">

        @foreach($list as $menu)
            <div class="row" data-id="{{ $menu->id }}">

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
                        <li data-toggle="tooltip" data-placement="bottom" title="Edit attached Page">{!! css()->link->edit(route('admin.menus.edit', ['name' => $menu])) !!}</li>
                        {{--<li data-toggle="tooltip" data-placement="bottom" title="Edit attached Page">{!! css()->link->page(route('admin.pages.edit', $menu->page->slug)) !!}</li>--}}
                        <li>{!! css()->link->destroy(route('admin.menus.destroy', ['menu' => $menu->id])) !!}</li>
                        <li>{!! css()->status->status($menu->status) !!}</li>
                        {{--<li>{!! css()->link->edit(route('admin.pages.edit', ["name"=>$page->slug])) !!}</li>--}}
                        {{--<li>{!! css()->status->sitemap($page->sitemap) !!}</li>--}}
                        {{--<li>{!! css()->status->status($page->enabled) !!}</li>--}}
                        {{--<li>{!! css()->link->view(makeUrl($page)) !!}</li>--}}
                    </ul>
                </div>

                <div class="stats">
                    <div class="views">
                        {{--<i class="fa fa-eye" aria-hidden="true"></i> {{ $page->views }}--}}
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
