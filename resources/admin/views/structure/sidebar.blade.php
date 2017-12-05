<div class="nav-sidebar">
    <div class="head">
        <div class="logo">
            <img src="{{ asset('packages/webshelf/images/logo.png') }}" style="height: 100%; width: 100%; display:block;">
        </div>
        <div class="glance">
            <div class="website-name">CorpusChristiPS</div>
        </div>
    </div>
    <div class="content">
        <ul class="list-unstyled">

            <li>

                <a href="{{ route('dashboard') }}">

                    <i class="nav-icon fa fa-tachometer icon" aria-hidden="true"></i>

                    <span class="nav-title">Dashboard</span>

                </a>

            </li>

            <li class="heading">

                <h5>Plugins</h5>

            </li>

            @foreach(plugins()->viewable() as $plugin)

                <li>
                        <a href="{{ $plugin->adminUrl() }}">

                            <i class="nav-icon fa {{ $plugin->icon() }}" aria-hidden="true"></i>

                            <span class="nav-title">{{ ucfirst($plugin->name()) }}</span>

                        </a>
                </li>

            @endforeach

            <li class="heading">

                <h5>Modules</h5>

            </li>

            @foreach(config('modules') as $module)

                <li>

                        <a href="{{ url($module['url']) }}">

                            <i class="nav-icon fa {{ $module['icon'] }}" aria-hidden="true"></i>

                            <span class="nav-title">{{ $module['title'] }}</span>

                        </a>

                </li>

            @endforeach

        </ul>
    </div>
    <div class="foot">
        <ul class="list-unstyled">
            <li><a href="#">Collapse Sidebar</a></li>
        </ul>
    </div>
</div>