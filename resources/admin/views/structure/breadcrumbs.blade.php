<div class="container">
    <div class="breadcrumb-container">
        <div class="breadcrumbs">
            <ul class="list-unstyled breadcrumbs-list js-breadcrumbs-list d-flex">
                @if($breadcrumbs)

                    @if($breadcrumbs->hasHome())

                        <i class="fa fa-home"></i>

                    @endif

                    @foreach($breadcrumbs->crumbs() as $breadcrumb)

                        @if($breadcrumb->url())

                            <li><a href="{{ $breadcrumb->url() }}">{{ $breadcrumb->title() }}</a></li>

                        @else

                            <li><a href="#">{{ $breadcrumb->title() }}</a></li>

                        @endif

                    @endforeach

                @endif
            </ul>
        </div>
    </div>
</div>