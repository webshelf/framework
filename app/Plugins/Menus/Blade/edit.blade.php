@extends('dashboard::frame')

@section('title')
    Edit Menu
@endsection

@section('information')
    Navigation on your website starts with the menus.
@endsection

@section('content')

    @include('dashboard::structure.validation')

    <?php /** @var \App\Model\Menu $menu */ ?>

    <form action="{{ route('admin.menus.update', ['menu' => $menu->id]) }}" method="post">

        <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control is-valid|is-invalid" name="title" id="title" aria-describedby="titleHelp" value="{{ $menu->title }}">
            <div class="invalid-feedback">
                Validation message
            </div>
            <small id="titleHelp" class="form-text text-muted">Text to appear in navigation menu.</small>
            <!-- TODO: This is for server side, there is another version for browser defaults -->
        </div>

        <div class="form-group">
            <label for="menu">Parent Menu</label>
            <select class="form-control" name="menu_id" id="menu" aria-describedby="menuHelp" {{ $menu->lock ? 'readonly' : 'null' }}>
                @if (!$menu->lock)
                    <option value="" {{ !$menu->parent ? 'selected' : 'null' }}></option>
                    @foreach($parents as $submenu)
                        <option value="{{ $submenu->id }}" {{ $menu->parent && $menu->parent->id == $submenu->id ? 'selected' : 'null' }}>{{ $submenu->title }}</option>
                    @endforeach
                @endif
            </select>
            <small id="menuHelp" class="form-text text-muted">Attach this navigation menu to a menu.</small>
        </div>

        <script>
            $(document).ready(function() {
                $("#hyperlinkUrl").on("change paste keyup", function() {
                    $("#linkable_object").val("");
                });
                $('#linkable_object').on('change', function() {
                    $("#hyperlinkUrl").val("");
                });
            });
        </script>

        <div class="row">
            <div class="col-5">
                <div class="form-group">
                    <label for="linkable_object">Link Internal Resource</label>
                    <select class="form-control" name="linkable_object" id="linkable_object" aria-describedby="pageHelp">

                        <?php /** @var \App\Classes\Interfaces\Linkable $item */ ?>
                        <option value="" selected></option>

                        @foreach ($linkableObjects as $item)
                            <option value="{{ json_encode(['key' => $item->getKey(), 'class' => $item->getMorphClass()]) }}" {{ optional($menu->link->to)->id == $item->getKey() ? 'selected' : null }}>{{ ucfirst($item->name()) }} - {{ $item->route() }}.html</option>
                        @endforeach

                        {{--@if ($menu->page)--}}
                        {{--<option value="{{ $menu->page->id }}">{{ ucfirst($menu->page->seo_title) }}</option>--}}
                        {{--@else--}}
                        {{--<option value="">No Page Content</option>--}}
                        {{--@endif--}}
                        {{--@foreach($pages as $page)--}}
                        {{--<option value="{{ $page->id }}">{{ ucfirst($page->seo_title) }}</option>--}}
                        {{--@endforeach--}}
                        {{--<option value="" {{ !$menu->page ? 'selected' : 'null'}}></option>--}}
                    </select>
                    <small id="pageHelp" class="form-text text-muted">Internal resources are those that exist on your website.</small>
                </div>
            </div>

            <div class="col-2 d-flex">
                <span style="align-self: center; text-align: center; flex: 1; margin-top: -5px;">Or</span>
            </div>

            <div class="col-5">
                <div class="form-group">
                    <label for="hyperlinkUrl">Link External Website</label>
                    <input type="text" class="form-control" name="hyperlinkUrl" id="hyperlinkUrl" aria-describedby="hyperlinkUrlHelp" value="{{ optional($menu->link)->external }}">
                    <small id="hyperlinkUrlHelp" class="form-text text-muted">This will link the menu to the assigned URL web address (# for Empty)</small>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="target">Target</label>
            <select class="form-control" name="target" id="target" aria-describedby="targetHelp">
                <option value="_self" {{ $menu->target == '_self' ? 'selected' : 'null' }}>_self (Page will open on the current browser window)</option>
                <option value="_blank" {{ $menu->target == '_blank' ? 'selected' : 'null' }}>_blank (Page will open on a new browser tab window)</option>
            </select>
            <small id="targetHelp" class="form-text text-muted">How this should open when clicked.</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-update">Edit Menu</button>
            <div class="pull-right">
                <button type="reset" class="btn btn-reset">Reset</button>
                <a href="{{ route('admin.menus.index') }}" class="btn btn-cancel">Cancel</a>
            </div>
        </div>

    </form>

@endsection