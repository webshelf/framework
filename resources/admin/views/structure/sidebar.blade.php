<div id="nav-sidebar">
    <div class="head">
        <div class="logo">
            <img src="{{ url(settings()->getDefault('website_logo')) }}" style="height: 100%; width: 100%; display:block;">
        </div>
        <div class="glance">
            <div class="website-name">{{ settings()->getDefault('website_name') }}</div>
        </div>
    </div>
    <div class="content">
        <ul class="list-unstyled">

            <li>

                <a href="{{ route('dashboard') }}" class="{{ $breadcrumbs->contain('admin', 3) ? 'active' : 'inactive' }}">

                    <i class="nav-icon fa fa-tachometer icon" aria-hidden="true"></i>

                    <span class="nav-title">Dashboard</span>

                </a>

            </li>

            {{--<li class="heading">--}}

                {{--<h5>Plugins</h5>--}}

            {{--</li>--}}

            @foreach(plugins()->viewable() as $plugin)

                <li>
                        <a href="{{ $plugin->adminUrl() }}" class="{{ $breadcrumbs->contain($plugin->name(), 3) ? 'active' : 'inactive' }}">

                            <i class="nav-icon fa {{ $plugin->icon() }}" aria-hidden="true"></i>

                            <span class="nav-title">{{ ucfirst($plugin->name()) }}</span>

                        </a>
                </li>

            @endforeach

            {{--<li class="heading">--}}

                {{--<h5>Modules</h5>--}}

            {{--</li>--}}

            @foreach(config('modules') as $module)

                <li>

                        <a href="{{ url($module['url']) }}" class="{{ $breadcrumbs->contain($module['title'], 3) ? 'active' : 'inactive' }}">

                            <i class="nav-icon fa {{ $module['icon'] }}" aria-hidden="true"></i>

                            <span class="nav-title">{{ $module['title'] }}</span>

                        </a>

                </li>

            @endforeach

        </ul>
    </div>
</div>