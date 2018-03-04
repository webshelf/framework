@extends('website::frame')

@section('content')

    <div id="about-page">

        <div id="blog-heading">

            <div class="block-heading-250">


            </div>

        </div>

        <div class="container">

            <div class="row">

                <div class="col-xs-12 col-lg-8">

                    <div class="container">

                        <div class="row">

                            <div class="col-12">

                                {!! $webpage->page->content() !!}

                            </div>

                        </div>

                    </div>

                </div>

                {{--<div class="col-xs-12 col-lg-3 offset-md-1" id="sidebar">--}}

                    {{--<div class="container">--}}
                        {{--<h1>Explore</h1>--}}

                        {{--<ul>--}}
                            {{--<li>South Sudan (PDF)</li>--}}
                            {{--<li>Moyross Parish</li>--}}
                            {{--<li>Jesuits Worldwide</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}

                    {{--<div class="container">--}}
                        {{--<h1>Charities</h1>--}}

                        {{--<img src="https://scholarlykitchen.sspnet.org/wp-content/uploads/2015/04/oxfam.png" alt="Oxfam Logo" width="75%">--}}

                        {{--<img src="https://www.ucanews.com/uploads/2013/03/1363337284.jpg" alt="Jesuits Logo" width="75%">--}}
                    {{--</div>--}}

                {{--</div>--}}

            </div>

        </div>

    </div>

@endsection