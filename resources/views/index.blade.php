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
                        Hello, I'm Tony O'Riordan, An Irish Jesuit Priest now assigned to work with the refugees and
                        internally displaced people of South Sudan, I am the leader of the refugee service team and I
                        wish to document my work with you through my website.
                    </p>
                    
                    <a href="{{ url('about') }}"><button type="button" class="btn btn-primary">Read More...</button></a>
                    
                    <button type="button" class="btn btn-outline-primary">Explore Analysis of South Sudan (PDF)</button>

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