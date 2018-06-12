@extends('dashboard::frame')

@section('title')
    Plugin Overview
@endsection

@section('information')
    Products are interfaces which can be switched on and off, allowing complete control of your system.
@endsection

@section('content')

    <div class="webshelf-table">

        <?php /** @var \App\Model\Plugin $product */ ?>

        @foreach($products as $product)
            <div class="row">

                <div class="details">
                    <div class="title">
                        {{ ucfirst($product->name()) }}
                    </div>
                    <div class="website">
                        Version {{ $product->version() }}
                    </div>
                </div>

                <div class="console">
                    <ul class="list-unstyled">

                        @role('developer')
                            @if($product->required == false)
                                @if ($product->enabled)
                                    <li><a href="{{ route('products.uninstall', $product->name) }}">Uninstall</a></li>
                                @else
                                    <li><a href="{{ route('products.install', $product->name) }}">Install</a></li>
                                @endif
                            @else
                                <li>Framework Requirement</li>
                            @endif
                        @else
                            @if ($product->enabled)
                                <li>Currently Active</li>
                            @else
                                <li>Disabled</li>
                            @endif
                        @endrole

                        {{--<li>{!! css()->status->installed($product->isEnabled()) !!}</li>--}}
                        {{--<li>{!! css()->link->edit(route('admin.pages.edit', ["name"=>$page->slug])) !!}</li>--}}
                        {{--<li>{!! css()->status->sitemap($page->sitemap) !!}</li>--}}
                        {{--<li>{!! css()->status->status($page->enabled) !!}</li>--}}
                        {{--<li>{!! css()->link->view(makeUrl($page)) !!}</li>--}}
                    </ul>
                </div>

                <div class="stats">
                    <div class="views">
                        {!! css()->status->check($product->enabled) !!}
                    </div>
                </div>
            </div>
        @endforeach

    </div>

@endsection