@if($breadcrumbs)

        @if($breadcrumbs->hasHome())

            <i class="fa fa-home"></i>

        @endif

        @foreach($breadcrumbs->crumbs() as $breadcrumb)

            @if($breadcrumb->url())

                <div class="crumb"><a href="{{ $breadcrumb->url() }}">{{ $breadcrumb->title() }} <i class="fa fa-angle-right"></i></a></div>

            @else

                <div class="crumb">{{ $breadcrumb->title() }}</div>

            @endif

        @endforeach

@endif
