<!doctype html>

<html lang="{{ app()->getLocale() }}">

<head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php /** @var \App\Classes\Library\PageLoader\Webpage $webpage */ ?>
    <title>{{ $webpage->page->title() }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ mix('assets/frontend.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ mix('assets/frontend.js') }}"></script>

</head>

<body>

    <?php /** @var \App\Classes\Library\PageLoader\Webpage $webpage */ ?>

    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="sideNav">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">
            <span class="d-block d-lg-none" id="mobile-brand-title">Spes Mundi</span>
            <span class="d-none d-lg-block">
              <h1>Spes<br>Mundi</h1>
            </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
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
        <span class="d-none d-lg-block social">
              <i class="fa fa-facebook-square"></i>
              <i class="fa fa-youtube-square"></i>
              <i class="fa fa-twitter-square"></i>
        </span>

    </nav>

    <section id="main-wrapper" class="container-fluid p-0">

        @yield('content')

        <div id="newsletter-bar">

            <div class="container">

                <div class="row">

                    <div class="col-6">

                        <h1>Subscribe & Get our notifications</h1>

                    </div>

                    <div class="col-6">

                        <form method="post">

                            <div class="form-group">
                                <input type="text" class="form-control" name="email_address" id="email_address"
                                       aria-describedby="emailAddressHelp"
                                       placeholder="Email Address">
                            </div>

                            <button type="submit" class="btn info">Sign up</button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

        <footer>

            <div id="explore">

                <div class="container">

                    <div class="row">

                        <div class="col-5">

                            <h1>Support Our Work</h1>

                            <p>
                                We spend countless hours supporting the interests and needs for those in third world countries,
                                click the following banner to financial support us in our conquest.
                            </p>

                            <img src="{{ asset('uploads/assets/jusuit_banner_footer.png') }}" class="img-fluid" alt="Responsive image">

                        </div>

                        <div class="col-3 offset-md-1">

                            <h1>Jesuit Manual</h1>

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

                        <div class="col-3">

                            <h1>Explore Articles</h1>

                            <ul id="explore-articles">
                                <li><a href="#">Quis autem vel eum iure</a></li>
                                <li><a href="#">vel eum iure reprehenderit</a></li>
                                <li><a href="#">sed quia consequuntur magni</a></li>
                                <li><a href="#">Ut enim ad minima veniam</a></li>
                                <li><a href="#">Neque porro quisquam</a></li>
                                <li><a href="#">dolores eos qui ratione</a></li>
                                <li><a href="#">reprehenderit qui in ea</a></li>
                            </ul>

                        </div>

                    </div>

                </div>

            </div>

            <div id="copyright">

                <div class="container">

                    <div class="row">

                        <div class="col-6">© 2018 SpesMundi.com</div>

                        <div class="col-6">Powered by Webshelf v5.0.2</div>

                    </div>

                </div>

            </div>

        </footer>

    </section>

</body>

</html>