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

                <div class="col-lg-7 col-md-12">

                    <h2>Finding and Spreading Hope in our World!</h2>

                    <p>
                        Welcome to `SpesMundi’ my personal webpage. My name is Tony O’Riordan. I am Irish Jesuit priest
                        and recently I have been assigned to South Sudan. I have been appointed the Project Director of
                        the Jesuit Refugee Service (JRS) in Maban which is in the North East of the Country and I am
                        due to start in March 2018.
                    </p>
                    
                    <a href="{{ url('about') }}"><button type="button" class="btn btn-primary">Read More...</button></a>

                    <a class="btn btn-outline-primary" href="{{ asset('uploads/PDF/south-sudan.pdf') }}" target="_blank">Explore Analysis of South Sudan (PDF)</a>

                </div>

                <div class="col-lg-5 mt-xs-5 mt-lg-0 d-none d-lg-block">

                    <div class="pull-right" id="selfie">

                        <img src="{{ url('uploads/assets/selfie.jpg') }}" class="img-fluid" alt="Responsive image">

                    </div>

                </div>
            </div>


        </div>

    </div>

    <div class="quick-glance pt-5 pb-4">

        <div class="container">

            <h2>Latest Articles</h2>

            <div class="article-group row">

                <?php /** @var \App\Classes\Library\PageLoader\Webpage $webpage */ ?>
                <?php /** @var \App\Model\Article $article */ ?>
                @foreach ($webpage->plugins->articles()->take(3) as $article)

                    @if ($loop->iteration == 1 || $loop->iteration == 2)
                        <article class="col-xs-12 col-sm-6 col-lg-4">

                            <a href="{{ route('articles.article', $article->slug) }}">

                                <div class="image" style="background-color: #00b8d9">

                                    <img src="{{ url($article->featured_img ?: '') }}" class="img-fluid" alt="Responsive image">

                                </div>

                                <div class="category">
                                    {{ $article->category->title or 'Uncategorised' }} // {{ $article->created_at->format('dS M Y') }}
                                </div>

                                <div class="title">
                                    <h3>{{ ucfirst($article->title) }}</h3>
                                </div>

                            </a>

                        </article>
                    @else
                        <article class="col-xs-12 col-sm-6 col-lg-4 d-none d-lg-block">

                            <a href="{{ route('articles.article', $article->slug) }}">

                                <div class="image" style="background-color: #00b8d9">

                                    <img src="{{ url($article->featured_img ?: '') }}" class="img-fluid" alt="Responsive image">

                                </div>

                                <div class="category">
                                    {{ $article->category->title or 'Uncategorised' }} // {{ $article->created_at->format('dS M Y') }}
                                </div>

                                <div class="title">
                                    <h3>{{ ucfirst($article->title) }}</h3>
                                </div>

                            </a>

                        </article>
                    @endif

                @endforeach

            </div>

        </div>

    </div>

    <div class="quick-glance pt-4 pb-5">

        <div class="container">

            <h2>Popular Articles</h2>

            <div class="article-group row">

                @foreach ($webpage->plugins->articles()->repository->mostViewed(3) as $article)

                    @if ($loop->iteration == 1 || $loop->iteration == 2)
                        <article class="col-xs-12 col-sm-6 col-lg-4">

                            <a href="{{ route('articles.article', $article->slug) }}">

                                <div class="image" style="background-color: #00b8d9">

                                    <img src="{{url($article->featured_img ?: '') }}" class="img-fluid" alt="Responsive image">

                                </div>

                                <div class="category">
                                    {{ $article->category->title or 'Uncategorised' }} // {{ $article->created_at->format('dS M Y') }}
                                </div>

                                <div class="title">
                                    <h3>{{ ucfirst($article->title) }}</h3>
                                </div>

                            </a>

                        </article>
                    @else
                        <article class="col-xs-12 col-sm-6 col-lg-4 d-none d-lg-block">

                            <a href="{{ route('articles.article', $article->slug) }}">

                                <div class="image" style="background-color: #00b8d9">

                                    <img src="{{ url($article->featured_img ?: '') }}" class="img-fluid" alt="Responsive image">

                                </div>

                                <div class="category">
                                    {{ $article->category->title or 'Uncategorised' }} // {{ $article->created_at->format('dS M Y') }}
                                </div>

                                <div class="title">
                                    <h3>{{ ucfirst($article->title) }}</h3>
                                </div>

                            </a>

                        </article>
                    @endif

                @endforeach

            </div>

        </div>

    </div>

@endsection