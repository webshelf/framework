<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ framework()->package }} v{{ framework()->version  }}</title>

        <link href="{{ mix('assets/backend.css') }}" rel="stylesheet">
        <link href="{{ mix('assets/dashboard.css') }}" rel="stylesheet">
        <script src="{{ mix('assets/dashboard.js') }}"></script>

        <script type="text/javascript" src="{{ asset('packages/webshelf/tinymce/tinymce.min.js') }}"></script>

        <script>
            function elFinderBrowser (field_name, url, type, win) {
                tinymce.activeEditor.windowManager.open({
                    file: '<?= route('elfinder.tinymce4') ?>',// use an absolute path!
                    title: 'Webshelf File Manager',
                    width: 900,
                    height: 425,
                    resizable: 'yes'
                }, {
                    setUrl: function (url) {
                        win.document.getElementById(field_name).value = url;
                    }
                });
                return false;
            }
            tinymce.init({
                height: 375,
                width: 800,
                theme: 'modern',
                branding: false,
                selector: '#tinymce-textarea',
                fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                toolbar: "bold underline | fontsizeselect | undo redo | link image media | forecolor backcolor",
                plugins: 'image table link paste contextmenu textpattern autolink save image textcolor colorpicker',
                menu: {
                    file: {title: 'File', items: 'newdocument'},
                    edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall'},
                    insert: {title: 'Insert', items: 'link media | template hr'},
                    view: {title: 'View', items: 'visualaid'},
                    format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
                    table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
                    tools: {title: 'Tools', items: 'spellchecker code'}
                },
                content_css: [
                    "{{ mix('assets/frontend.css') }}",
                    "//www.tinymce.com/css/codepen.min.css"
                ],
                file_browser_callback : elFinderBrowser
            });
        </script>

        <meta id="token" name="csrf-token" content="{!! csrf_token() !!}">

    </head>

    <body>

        <header>

            <div class="application-logo">

                <h1>{{ framework()->package }} v{{ framework()->version  }} Beta</h1>

            </div>

            <div class="flex flex-display" id="nav">

                <nav class="nav-primary flex-display">

                    <ul>

                        <li>
                            <a href="{{ url('/admin') }}" title="View the Dashboard">
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li>
                            <a href="#" title="Application Information">
                                <p>Detail</p>
                            </a>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Add new data to your website">
                                <p>Create</p>
                            </a>
                            <ul class="dropdown-menu">
                                @if(plugins()->hasPlugin('pages')) <li><a href="{{ route('admin.pages.create') }}">New Page</a></li> @endif
                                @if(plugins()->hasPlugin('menus')) <li><a href="{{ route('CreateMenu') }}">New Menu</a></li> @endif
                                @if(plugins()->hasPlugin('redirects')) <li><a href="{{ route('MakeRedirect') }}">New Redirect</a></li> @endif
                                @if(account()->hasRole(App\Model\Role::ADMINISTRATOR)) <li><a href="{{ route('admin.accounts.create') }}">New Account</a></li> @endif
                            </ul>
                        </li>

                    </ul>

                </nav>

                <nav class="nav-secondary flex-display">

                    <ul>

                        <li id="search">
                            <form>
                                <input id="quick-search-bar" type="text" title="Quick Search" placeholder="Search" name="query">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </form>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Help & Guides">
                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="#">Help coming Soon...</a></li>
                            </ul>
                        </li>
                        @if(account()->hasRole(\App\Model\Role::SUPERUSER))
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Notifications">
                                <i class="fa fa-bell" aria-hidden="true"></i>
                                {{--@php($notification_count = count($notifications))--}}
                                {{--@if($notification_count >= 1)--}}
                                    {{--<span class="badge badge-default"> {{ $notification_count }}</span>--}}
                                {{--@endif--}}
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="#">Notifications coming Soon...</a></li>
                                {{--@if($notification_count == 0)--}}
                                    {{--<li><a href="#"> Your notifications inbox is empty !</a></li>--}}
                                {{--@else--}}
                                    {{--@foreach($notifications as $notification)--}}
                                        {{--<li><a href="#">{{ $notification->message() .'['. $notification->createdAt()->diffForHumans() .']'}}</a></li>--}}
                                    {{--@endforeach--}}
                                {{--@endif--}}
                            </ul>
                        </li>
                        @endif
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Settings">
                                <i class="fa fa-cog" aria-hidden="true"></i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="{{ route('settings') }}">System settings</a></li>
                            </ul>
                        </li>
                        <li id="avatar" class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Account profile for {{ account()->fullName() }} [{{ account()->role->title() }}]">
                                <i class="fa profile-image small" aria-hidden="true">
                                    <img src="{{ account()->avatar }}" width="24" height="24" alt="profile image">
                                </i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="#">My Profile</a></li>
                                <li><a href="{{ route('AuthLogout') }}">Log out</a></li>
                            </ul>
                        </li>

                    </ul>

                </nav>

            </div>

        </header>

        <div class="frame">

            <div class="content" id="vue-components">

                <div class="page-panel" id="sidebar">

                    <div class="head">

                        <div class="flex">

                            <div class="logo">

                                <img src="{{ asset('packages/webshelf/images/logo.png') }}" style="height: 50px; width: 50px; display:block;">

                            </div>

                            <div class="glance">

                                <small>

                                    <a href="{{ url('/') }}" target="_blank">{{ url('/') }} <i class="fa fa-external-link" aria-hidden="true"></i></a>

                					<br>

                                    @if(framework()->isLatestVersion())
                                        <span style="font-size: 12px; color:#c4d15a;">You have the latest version!</span>
                                    @else
                                        <span style="font-size: 12px; color:#FFA500;">A new version is available!</span>
                                    @endif

                                </small>

                            </div>


                        </div>

                    </div>

                    <div class="sidebar">

                        <nav id="nav-sidebar">

                            <ul>

                                <li>

                                    <div class="tile {{ (\Route::current()->uri() == 'admin') ? 'active open' : null }}">

                                        <a href="{{ route('dashboard') }}">

                                            <i class="fa fa-tachometer icon" aria-hidden="true"></i>

                                            <span class="title">Dashboard</span>

                                            <i class="fa fa-angle-left icon right" aria-hidden="true"></i>

                                        </a>

                                    </div>

                                </li>

                                <li class="heading">
                                    <h3>Plugins</h3>
                                </li>

                                @foreach(plugins()->viewable() as $plugin)

                                    <li>

                                        <div class="tile {{ $breadcrumbs->contain($plugin->name(), 3) ? 'active open' : null }}">

                                            <a href="{{ $plugin->adminUrl() }}">

                                                <i class="fa {{ $plugin->icon() }} icon" aria-hidden="true"></i>

                                                <span class="title">{{ ucfirst($plugin->name()) }}</span>

                                                <i class="fa fa-angle-left icon right" aria-hidden="true"></i>

                                            </a>

                                        </div>

                                    </li>

                                @endforeach

                                <li class="heading">
                                    <h3>Modules</h3>
                                </li>

                                @foreach(config('modules') as $module)

                                    <li>

                                        <div class="tile {{ $breadcrumbs->contain($module['title'], 3) ? 'active open' : null }}">

                                            <a href="{{ url($module['url']) }}">
                                                <i class="{{ $module['icon'] }} icon" aria-hidden="true"></i>

                                                <span class="title">{{ $module['title'] }}</span>

                                                <i class="fa fa-angle-left icon right" aria-hidden="true"></i>

                                            </a>

                                        </div>

                                    </li>

                                @endforeach

                            </ul>

                        </nav>

                    </div>

                    <div class="foot">

                        <p>
                            <!-- EMPTY -->
                        </p>

                    </div>
                </div>

                <div class="page-panel" id="view">

                    <div class="view">

                        <div class="top">

                            <div class="breadcrumbs">

                                @include('dashboard::components.breadcrumbs', ['breadcrumbs'=> $breadcrumbs])

                            </div>

                            <div class="head">

                                @yield('title', '<h1>'.ucwords(currentURI()).'</h1>')

                                @yield('information', '')

                            </div>

                        </div>

                        <div class="content">

                            @yield('content')

                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- Include all compiled javascript-->
        <!-- Javascript is needed for dom element on bootup, this should be minified for production -->

		
        @include('dashboard::popups')

        @yield('javascript')

    </body>

</html>
