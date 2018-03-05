@extends('website::frame')

@section('content')

    <div id="blog-page">

        <div id="blog-heading" class="d-none d-md-block">

            <div class="block-heading-250"> </div>

        </div>

        <div class="container">

            <div class="row">

                <div class="col-xs-12 col-lg-8">

                    <?php /** @var \App\Model\Article $article */ ?>
                    <?php /** @var \App\Classes\Library\PageLoader\Webpage $webpage */ ?>

                        @if ($articles->count() == 0 )
                            <h2>No Articles Exist with these Parameters.</h2>
                            <p>We understand sometimes this can be distressing, please breath and try something else.</p>
                        @else
                            @foreach ($articles as $article)
                                <article>
                                    <div class="creator">Posted {{ $article->created_at->format('M d, Y') }} by {{ $article->creator->fullName() }}</div>
                                    @if ($articles->count() == 1)
                                    <h2>{{ ucfirst($article->title) }}</h2>
                                    @else
                                    <h2><a href="{{ route('articles.article', $article->slug) }}">{{ ucfirst($article->title) }}</a></h2>
                                    @endif
                                    @if($articles->count() == 1 && !$article->featured_img == '')
                                        <img src="{{ url($article->featured_img) }}" alt="{{ $article->title }}" width="100%" class="img-responsive mb-3 mt-3">
                                    @endif
                                    <div class="content">{!! $article->content !!}</div>
                                    @if ($articles->count() == 1)
                                        <hr>
                                        <h5><a href="{{ url()->previous() }}"><i class="fa fa-arrow-circle-left mr-2"></i>Go Back</a></h5>
                                    @endif
                                </article>
                                @if (!$loop->last)
                                    <hr>
                                @endif
                            @endforeach
                            @if($articles->count() > 1)
                                {{ $articles->links() }}
                            @endif
                        @endif


                </div>

                <div class="col-xs-12 col-lg-3 offset-lg-1 mt-4 mt-lg-0" id="sidebar" data-sticky-container>

                    <div class="sticky-bar" data-margin-top="20" data-margin-bottom="20">

                        <h3>Lookup</h3>

                        <div class="row" style="padding-left:15px; padding-right:15px;">
                            <form method="get" action="{{ route('articles.search') }}" style="display: flex;">
                                <div class="form-group" style="margin-bottom: 0">
                                    <input type="text" class="form-control" name="search" id="search" aria-describedby="helpId" placeholder="Search Articles..." required>
                                </div>

                                <button type="submit" id="search" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </form>
                        </div>

                        <hr>

                        <h3>Categories</h3>

                        <ul>
                            <li><a href="{{ route('articles.index') }}">View All ({{ $webpage->plugins->articles()->articles->count() }})</a></li>
                            @foreach ($webpage->plugins->articles()->categories() as $category)
                                <li><a href="{{ route('articles.category', $category->id) }}">{{ $category->title }} ({{ $category->articles->count() }})</a></li>
                            @endforeach
                        </ul>

                        <hr>

                        <h3>Contributors</h3>

                        <ul>
                            @foreach ($webpage->plugins->articles()->creators() as $article)
                                <li><a href="{{ route('articles.creator', $article->creator->id) }}">{{ $article->creator->fullName() }} ({{ $article->creator->articles->count() }})</a></li>
                            @endforeach
                        </ul>

                        <hr>

                        {{--<h3>Random</h3>--}}

                        {{--<ul>--}}
                        {{--@foreach ($webpage->plugins->articles()->random(1) as $article)--}}
                        {{--<li><a href="{{ route('articles.article', $article->slug) }}">{{ $article->title }}</a></li>--}}
                        {{--@endforeach--}}
                        {{--</ul>--}}

                        {{--<hr>--}}

                        <a href="http://www.jesuitmissions.ie"><img src="{{ asset('uploads/assets/jesuit_logo.png') }}"></a>
                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection