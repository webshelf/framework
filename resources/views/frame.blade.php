<!doctype html>

<html lang="{{ app()->getLocale() }}">

<head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('uploads/favicon-32x32.png') }}" sizes="32x32" />

    <?php /** @var \App\Classes\Library\PageLoader\Webpage $webpage */ ?>
    <title>{{ $webpage->page->title() }}</title>

    <!-- Styles -->
    <link href="{{ mix('assets/frontend.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ mix('assets/frontend.js') }}"></script>

</head>

<body>

    <?php /** @var \App\Classes\Library\PageLoader\Webpage $webpage */ ?>

    <nav class="navbar navbar-expand-xl navbar-light fixed-top" id="sideNav">
        <a class="navbar-brand js-scroll-trigger" href="{{ url('/') }}">
            <span class="d-block d-xl-none" id="mobile-brand-title">Spes Mundi</span>
            <span class="d-none d-xl-block">
              <h1>Spes<br>Mundi</h1>
            </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="navbar-toggler-icon fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">

                <?php /** @var \App\Model\Menu $menu */ ?>
                @foreach ($webpage->navigation->main() as $menu)
                    <li class="nav-item {{ $menu->classState() }}">
                        <a class="nav-link" href="{{ $menu->route() }}" target="{{ $menu->target }}">{{ $menu->title }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <span class="d-none d-xl-block social">
            <a href="{{ $webpage->url_facebook() }}" class="facebook" target="_blank"><i class="fa fa-facebook-square"></i></a>
            <a href="{{ $webpage->url_youtube() }}" class="youtube" target="_blank"><i class="fa fa-youtube-square"></i></a>
            <a href="{{ $webpage->url_twitter() }}" class="twitter" target="_blank"><i class="fa fa-twitter-square"></i></a>
        </span>

    </nav>

    <section id="main-wrapper" class="container-fluid p-0">

        @yield('content')

        @if(plugins()->enabled('newsletters'))
            <div id="newsletter-bar">

            <div class="container pt-4 pb-4">

                <div class="row">

                    <div class="col-xs-12 col-md-6 ">

                        <h1>Subscribe & Get Notifications</h1>

                    </div>

                    <div class="col-xs-12 col-md-6 pt-3 pt-md-0">

                        <form method="post" action="{{ route('newsletter.join') }}">

                            {{ csrf_field() }}

                            <div class="form-group">
                                <input type="email" class="form-control" name="email_address" id="email_address" aria-describedby="emailAddressHelp" placeholder="Email Address" required>
                            </div>

                            <button type="submit" class="btn info">Sign up</button>

                        </form>

                    </div>

                </div>

            </div>

        </div>
        @endif

        <footer>

            <div id="explore">

                <div class="container">

                    <div class="row">

                        <div class="col-lg-5 col-sm-12 col-xs-12">

                            <h3>Support Our Work</h3>

                            <p>
                                The Jesuit Mission Office in Dublin supports my work in South Sudan. It also supports
                                the work of many other individuals and groups in others parts of the world where the
                                needs are great. If you are in a position to make a donation today, click the banner.
                            </p>

                            <a href="http://www.jesuitmissions.ie/donate"><img src="{{ asset('uploads/assets/jesuit_banner.png') }}" class="img-fluid" alt="Responsive image"></a>

                        </div>

                        <div class="col-lg-3 col-xs-6 offset-lg-1 col-sm-6 mt-sm-5 mt-lg-0 mt-5 mt-lg-0">

                            <h3>Jesuit Manual</h3>

                            <ul id="explore-jesuit">
                                <li><a href="http://jesuits.org/mission" target="_new">Mission Statement</a></li>
                                <li><a href="http://jesuits.org/aboutus" target="_new">About The Work</a></li>
                                <li><a href="http://jesuits.org/spirituality" target="_new">Ignatian Spirituality</a></li>
                                <li><a href="https://www.beajesuit.org/" target="_new">Becoming a Jesuit</a></li>
                                <li><a href="http://jesuits.org/worldwide" target="_new">Worldwide Vocation</a></li>
                                <li><a href="http://jesuits.org/whatwedo?PAGE=DTN-20130520124035" target="_new">Justice and Ecology</a></li>
                                <li><a href="http://jesuits.org/supportus" target="_new">Support Jesuit</a></li>
                            </ul>

                        </div>

                        <div class="col-lg-3 col-xs-6 col-sm-6 mt-sm-5 mt-lg-0 mt-5 mt-lg-0">

                            <h3>Explore Articles</h3>

                            <ul id="explore-articles">
                                @foreach ($webpage->plugins->articles()->articles->take(5) as $article)
                                    <li><a href="{{ route('articles.article', $article->slug) }}">{{ str_limit(ucfirst(strtolower($article->title)), 30, '...') }}</a></li>
                                @endforeach
                            </ul>

                        </div>

                    </div>

                </div>

            </div>

            <div id="copyright">

                <div class="container">

                    <div class="row">

                        <div class="col-xs-12 col-md-6 text-left text-md-left">
                            <a href="{{ $webpage->url_facebook() }}" class="facebook" target="_blank">Facebook</a> |
                            <a href="{{ $webpage->url_youtube() }}" class="youtube" target="_blank">Youtube</a> |
                            <a href="{{ route('sitemap') }}" target="_blank">Sitemap</a>
                        </div>

                        <div class="col-xs-12 col-md-6 text-left text-md-right">© 2018 SpesMundi.com | Powered by Webshelf v5.0.2</div>

                    </div>

                </div>

            </div>

        </footer>

    </section>

</body>

</html>