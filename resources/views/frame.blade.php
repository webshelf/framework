@extends("webpage::master")

@section('webpage.title', sprintf("%s Landing v%s", framework()->package, framework()->version))

@section('webpage.content')

<body>

    <div class="heading heading-fixed">

        <div class="container">
            <div class="menu-bar">
                <div class="brand">
                    <h2 class="button">{{  framework()->package }}</h2>
                </div>
                <nav class="menu">
                    <ul>
                        <li><a class="button active" href="#">Home</a></li>
                        <li><a class="button" href="#">Page</a></li>
                        <li><a class="button" href="#">Articles</a></li>
                    </ul>
                </nav>
            </div>
        </div>

    </div>

    <div class="container">

        <h1>Webshelf</h1>

    </div>

    @yield('content')

</body>

@endsection