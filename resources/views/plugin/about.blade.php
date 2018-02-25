@extends('website::frame')

@section('content')

    <div id="about-page">

        <div id="blog-heading" class="d-none d-md-block">
                
            <div class="block-heading-250">

        
            </div>

        </div>

        <div class="container">

            <div class="row">

                <div class="col-xs-12 col-lg-8">

                    {!! $webpage->page->content() !!}

                </div>

                <div class="col-xs-12 col-lg-3 offset-lg-1 mt-4 mt-lg-0" id="sidebar" data-sticky-container>

                    <div class="sticky-bar" data-margin-top="20" data-margin-bottom="20">

                        <h3>Explore</h3>

                        <ul>
                            <li>South Sudan (PDF)</li>
                            <li>Moyross Parish</li>
                            <li>Jesuits Worldwide</li>
                        </ul>

                        <h3>Charities</h3>

                        <img src="https://scholarlykitchen.sspnet.org/wp-content/uploads/2015/04/oxfam.png" alt="Oxfam Logo" width="75%">

                        <img src="https://www.ucanews.com/uploads/2013/03/1363337284.jpg" alt="Click for Jesuits Ireland Website" width="75%">

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection