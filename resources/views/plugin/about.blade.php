@extends('website::frame')

@section('content')

    <div id="about-page">

        <div id="blog-heading" class="d-none d-md-block">
                
            <div class="block-heading-250">

        
            </div>

        </div>

        <div class="container">

            <div class="row">

                <div class="col-xs-12 col-lg-9 pr-40">

                    {!! $webpage->page->content() !!}

                </div>

                <div class="col-xs-12 col-lg-3 mt-4 mt-lg-0" id="sidebar" data-sticky-container>

                    <div class="sticky-bar" data-margin-top="20" data-margin-bottom="20">

                        <h3>Explore</h3>

                        <ul>
                            <li><a href="{{ asset('uploads/PDF/south-sudan.pdf') }}" target="_blank">South Sudan (PDF)</a></li>
                            <li><a href="http://moyrossparish.com/">Moyross Parish</a></li>
                            <li><a href="http://jesuits.org/worldwide">Jesuits Worldwide</a></li>
                        </ul>

                        <h3>Charities</h3>

                        <a href="https://jrs.ie/"><img src="{{ asset('uploads/assets/jesuit_refugee_service_logo.png') }}" alt="Click for Jesuits Refugee Service." width="75%"></a>

                        <a href="http://www.jesuits.org/"><img src="{{ asset('uploads/assets/jesuits_org.png') }}" alt="Click for Jesuits Ireland Website." width="75%"></a>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection