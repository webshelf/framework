@extends('dashboard::frame')

@section('title')
    <h1>Frontend Pages</h1>
@endsection
@section('information')
    <p>Pages are stored content viewable to a user in a form of a page, these can be modified, viewed and edited by clicking on the page name on the below table.<br>
        The best pages are those that are easy to view and read in which they also stay true to the title.</p>
@endsection

@section('javascript')

    <script>
        $(document).ready(function(){
            $('#table-datatables').DataTable({
                'iDisplayLength': 25
            });
        });
    </script>

@endsection

@section('content')

    <div class="table-panel border light">


        <table id="table-datatables" class="table table-striped table-bordered table-hover row-border order-column">

            <thead>
            <tr>
                <th>Title</th>
                <th>Anchor</th>
                <th>Modified</th>
                <th>Status</th>
                <th>Sitemap</th>
                <th>Menu</th>
                <th>Creator</th>
            </tr>
            </thead>

            <tbody>
            @foreach($pages as $page)
                <tr>
                    <td><a href="{{ route('EditPage', ["name"=>$page->slug()]) }}" name="{{ $page->seoTitle() }}" title="Manage, Review & Revise this page">{{ $page->seoTitle() }}</a></td>
                    <td><a style="color: #00A000" href="{{ makeUrl($page) }}" title="View the page on your website '{{ ucwords($page->seoTitle()) }}'" target="_blank">{{ makeUrl($page) }}</a></td>
                    <td><a href="{{ route('EditPage', ["name"=>$page->slug()]) }}" data-toggle="tooltip" data-placement="bottom" title="Last Modified {{ $page->updatedAt()->diffForHumans() }}">{{ $page->updatedAt()->format('F dS Y') }}</a></td>
                    <td title="Allow the public to view this page, or keep it private">{!! bool2Status($page->isEnabled(),'Published', 'Private') !!}</td>
                    <td title="The status on which this should appear for google search">{!! bool2Status($page->isSitemap(), 'Enabled', 'Disabled') !!}</td>
                    <td title="Pages that have a parent menu element for users to click">{!! bool2Status((count($page->menus) >= 1), 'Active', 'Inactive' ) !!}</td>
                    <td>
                        <i class="fa profile-image small" aria-hidden="true">
                            <img src="{{$page->creator->gravatarImageUrl() }}" width="24" height="24" alt="profile image">
                        </i>
                        <span class="margin-left-medium">{{ $page->creator->fullName() }} [{{ $page->creator->role->title() }}]</span>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>

    </div>

@endsection