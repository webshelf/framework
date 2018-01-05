<div id="content-wrapper" class="container">

        <div class="breadcrumb-container">
        <div class="breadcrumbs">
                <ul class="list-unstyled breadcrumbs-list js-breadcrumbs-list d-flex">

                @if($breadcrumbs)

                        @foreach($breadcrumbs->crumbs() as $crumb)

                                <li><a href="{{ $crumb->path }}">{{ $crumb->title }}</a></li>

                        @endforeach

                @endif

                </ul>
        </div>
        </div>

        <div class="content">

                <div class="heading">

                        <h3>@yield('title')</h3>

                        <p>@yield('information')</p>

                </div>

                <hr>

                @yield('content')

        </div>

</div>