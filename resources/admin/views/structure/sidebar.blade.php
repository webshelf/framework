<div id="nav-sidebar">
    <div class="head">
        <div class="logo">
            <img src="{{ url(config('app.logo')) }}" style="height: 100%; width: 100%; display:block;">
        </div>
        <div class="glance">
            <div class="website-name">{{ config('app.name') }}</div>
        </div>
    </div>
    <div class="content">
        <ul class="list-unstyled">

            <li>

                <a href="{{ route('dashboard') }}" class="{{ ($breadcrumbs->contain('admin', 1) && $breadcrumbs->hasCount(2)) ? 'active' : 'inactive' }}">

                    <i class="nav-icon fas fa-columns icon" aria-hidden="true"></i>

                    <span class="nav-title">Dashboard</span>

                </a>

            </li>

            @foreach(plugins()->viewable() as $plugin)

                <li>
                    <a href="{{ $plugin->adminUrl() }}" class="{{ $breadcrumbs->contain($plugin->name(), 2) ? 'active' : 'inactive' }}">

                        <i class="nav-icon {{ $plugin->icon() }}" aria-hidden="true"></i>

                        <span class="nav-title">{{ ucfirst($plugin->name()) }}</span>

                    </a>
                </li>

            @endforeach

            @foreach(config('modules') as $module)

                @role($module['role'])
                <li>

                    <a href="{{ url($module['url']) }}" class="{{ $breadcrumbs->contain($module['title'], 2) ? 'active' : 'inactive' }}">

                        <i class="nav-icon {{ $module['icon'] }}" aria-hidden="true"></i>

                        <span class="nav-title">{{ $module['title'] }}</span>

                    </a>

                </li>
                @endif

            @endforeach

        </ul>

        <hr>

    </div>

</div>
