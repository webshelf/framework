@extends('website::frame')

@section('content')

    <div id="landing">

        <div id="title">

            <h1>Maban, South Sudan</h1>

        </div>

    </div>

    <div id="information">

        <div class="container">

            <div class="row">

                <div class="col-7">

                    <h1>Finding and Spreading Hope in our World!</h1>

                    <p>
                        Hello, I'm Tony O'Riordan, An Irish Jesuit Priest now assigned to work with the refugees and
                        internally displaced people of South Sudan, I am the leader of the refugee service team and I
                        wish to document my work with you through my website.
                    </p>
                    
                    <a href="{{ url('about') }}"><button type="button" class="btn btn-primary">Read More...</button></a>
                    
                    <button type="button" class="btn btn-outline-primary">Explore Analysis of South Sudan (PDF)</button>

                </div>

                <div class="col-5">

                    <div class="pull-right" id="selfie">

                        <img src="{{ url('uploads/assets/landing_carousel.jpg') }}" class="img-fluid" alt="Responsive image">

                    </div>

                </div>
            </div>

        </div>

    </div>

    <!-- Accent the color from information -->
    <div id="information-accent"> </div>

    <div class="quick-glance">

        <div class="container">

            <h2>Latest Articles</h2>

            <div class="article-group row">

                <article class="col-xs-12 col-sm-4">

                    <a href="">

                        <div class="image" style="background-color: #00b8d9">

                            <img src="https://ak1.picdn.net/shutterstock/videos/17091301/thumb/1.jpg" class="img-fluid" alt="Responsive image">

                        </div>

                        <div class="category">
                            Sudan // 29th January 2019
                        </div>

                        <div class="title">
                            Vestibulum interdum, mauris nec lacinia lobortis, augue neque tincidunt turpis.
                        </div>

                    </a>

                </article>

                <article class="col-xs-12 col-sm-4">

                    <div class="image" style="background-color: #6554c0">

                        <img src="data:image/jpeg;base64,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" class="img-fluid" alt="Responsive image">

                    </div>

                    <div class="category">
                        Sudan // 22th January 2019
                    </div>

                    <div class="title">
                        Morbi bibendum aliquet dolor, nec ornare lorem fringilla sit amet.
                    </div>

                </article>

                <article class="col-xs-12 col-sm-4">

                    <div class="image" style="background-color: #ff5630">

                        <img src="https://ak4.picdn.net/shutterstock/videos/2526056/thumb/1.jpg" class="img-fluid" alt="Responsive image">

                    </div>

                    <div class="category">
                        General // 16th January 2019
                    </div>

                    <div class="title">
                        Proin non sagittis lacus, vehicula dignissim diam. Aenean suscipit pellentesque.
                    </div>

                </article>

            </div>

        </div>

    </div>

    <div class="quick-glance">

        <div class="container">

            <h2>Latest Videos</h2>

            <div class="article-group row">

                <article class="col-xs-12 col-sm-4">

                    <div class="image" style="background-color: #00b8d9">

                        <img src="https://marketingland.com/wp-content/ml-loads/2014/08/youtube-iconsbkgd-fade-1920.jpg" class="img-fluid" alt="Responsive image">

                    </div>

                    <div class="category">
                        General // 1st February 2019
                    </div>

                    <div class="title">
                        Nullam interdum laoreet dui at pellentesque. Suspendisse cursus lobortis nulla.
                    </div>

                </article>

                <article class="col-xs-12 col-sm-4">

                    <div class="image" style="background-color: #6554c0">

                        <img src="https://marketingland.com/wp-content/ml-loads/2014/08/youtube-iconsbkgd-fade-1920.jpg" class="img-fluid" alt="Responsive image">

                    </div>

                    <div class="category">
                        Sudan // 10th January 2018
                    </div>

                    <div class="title">
                        Aliquam et auctor neque. Donec aliquet efficitur magna, eget euismod.
                    </div>

                </article>

                <article class="col-xs-12 col-sm-4">

                    <div class="image" style="background-color: #ff5630">

                        <img src="https://marketingland.com/wp-content/ml-loads/2014/08/youtube-iconsbkgd-fade-1920.jpg" class="img-fluid" alt="Responsive image">

                    </div>

                    <div class="category">
                        Sudan // 2nd January 2018
                    </div>

                    <div class="title">
                        Donec eu augue ut nunc molestie pharetra. Suspendisse consequat gravida.
                    </div>

                </article>

            </div>

        </div>

    </div>

@endsection