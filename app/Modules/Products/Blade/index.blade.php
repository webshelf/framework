@extends('dashboard::frame')

@section('title')
    Product Overview
@endsection

@section('information')
    Products are interfaces which can be switched on and off, allowing complete control of your system.
@endsection

@section('content')

    <div class="webshelf-table">

        @foreach(config('modules') as $module)
            <div class="row">

                <div class="details">
                    <div class="title">
                        {{ ucwords($module['title']) }}
                    </div>
                    <div class="website">
                        Version {{ $module['version'] }}
                    </div>
                </div>

                <div class="console">
                    <ul class="list-unstyled">

                        @if (account()->hasRole($module['role']))
                            @if ($module['enabled'] == true)
                                <li><a href="{{ route('admin.products.toggle', $module['title']) }}">Uninstall</a></li>
                            @else
                                <li><a href="{{ route('admin.products.toggle', $module['title']) }}">Install</a></li>
                            @endif
                        @else
                            @if ($module['enabled'])
                                <li>Currently Active</li>
                            @else
                                <li>Disabled</li>
                            @endif
                        @endif
                    </ul>
                </div>

                <div class="stats">
                    <div class="views">
                        {!! css()->status->check($module['enabled']) !!}
                    </div>
                </div>
            </div>
        @endforeach

    </div>

@endsection