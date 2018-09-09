<div class="menu {{$class ?? ''}}">

    <ul>

        @foreach($webpage->navigation->main() as $menu)

            <li><a href="{{ $menu->route() }}" class="nav-item {{ $menu->classState() }}" target="{{ $menu->target }}">{{ $menu->title }}</a></li>

        @endforeach

    </ul>

</div>