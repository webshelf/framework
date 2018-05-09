<div id="content-wrapper" class="container">

        <div class="breadcrumbs-container">
                <div class="breadcrumbs-links">
                        <ul class="breadcrumbs-list">

                                @if($breadcrumbs)
                                
                                @foreach($breadcrumbs->crumbs() as $crumb)

                                <li>
                                        @if ($loop->last)
                                                <a href="{{  $crumb->path }}">{{  $crumb->title }}</a>
                                        @else
                                                <a href="{{  $crumb->path }}">{{  $crumb->title }}</a>
                                        @endif
                                       
                                        @if (! $loop->last)
                                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                                        @endif
                                </li>

                                @endforeach

                                @endif

                        </ul>
                </div>
        </div>

        <div class="content">

                @hasSection('title')
                        <div class="heading">

                                <h3>@yield('title')</h3>

                                <p>@yield('information')</p>

                        </div>
                @endif

                @yield('content')

        </div>

</div>