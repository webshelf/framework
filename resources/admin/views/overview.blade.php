@extends('dashboard::frame')

@section('title')
    <h1>Welcome, {{ ucfirst(account()->fullName()) }}</h1>
@endsection

@section('information')
    <p>
        This is the heart of your CMS Application, giving you a quick overview glance of everything that has been going on lately.
        <br>
        Our live statistical feeds come straight from google analytics, giving you the professional data you can rely on.
    </p>
@endsection

@section('content')

    <div id="dashboard">

        <div class="column left">

            <div class="statistics">

                <div class="heading">

                    <h3>Website user count</h3>

                </div>

                <div id="page-views"></div>

            </div>

            <div class="update-notice">

                <div class="heading">

                    <h3>Application updates</h3>

                    @foreach($fb_messages as $update)

                        @if(isset($update['message']))

                            <p>

                                <b>{{ $update['created_time']->format('d M Y') }}</b>

                                <br>

                                {{ nl2br($update['message']) }}

                            </p>

                        @endif

                    @endforeach

                </div>

            </div>

        </div>

        <div class="column right">

            <div class="feeds">

                <div class="activity">

                    <div class="heading">

                        <h3>Dashbord activities</h3>

                    </div>

                    <div class="feed">

                        @foreach ($audits as $audit)

                            <?php /** @var \App\Model\Audit $audit */ ?>

                                @if ($audit->auditable)

                                <div class="col">

                                    <div class="date">{{ $audit->created_at->diffForHumans() }}</div>

                                    @if (! $audit->user)
                                        <div class="text"><a href="{{ $audit->auditable->auditUrl() }}">{{ $audit->auditable->auditTitle() }}</a> {{ $audit->beforeActionVerb() }} by the CMS.</div>
                                    @else
                                        <div class="text"><span style="font-weight: 400; color:#0c82dc;">{{ $audit->user->fullName() }}</span> {{ $audit->afterActionVerb() }} {{ $audit->model() }} <a href="{{ $audit->auditable->auditUrl() }}">{{ $audit->auditable->auditTitle() }}</a></div>
                                    @endif

                                </div>

                                @endif

                        @endforeach

                        {{--@foreach($interactions as $interaction)--}}

                            {{--<div class="col">--}}

                            {{--<div class="date">{{ $interaction->getCreatedAt()->diffForHumans() }}</div>--}}

                            {{--@if($interaction->isInteraction(App\Model\Activity::$interactions['created']))--}}

                                    {{--@if($interaction->activity->trashed())--}}
                                        {{--<div class="text"><span style="font-weight: 400; color:#0c82dc;">{{ $interaction->account->fullName() }}</span> created the {{ $interaction->activity_name() }} <span style="text-decoration: line-through">{!!  ucfirst($interaction->title()) !!}</span></div>--}}
                                    {{--@else--}}
                                        {{--<div class="text"><span style="font-weight: 400; color:#0c82dc;">{{ $interaction->account->fullName() }}</span> created the {{ $interaction->activity_name() }} <span style="color:#0c82dc">{!!  $interaction->link() ? '<a href="'.$interaction->link().'">'. ucfirst($interaction->title()).'</a>' : ucfirst($interaction->title()) !!}</span></div>--}}
                                    {{--@endif--}}

                                {{--@elseif ($interaction->isInteraction(App\Model\Activity::$interactions['deleted']))--}}

                                    {{--<div class="text"><span style="font-weight: 400; color:#0c82dc;">{{ $interaction->account->fullName() }}</span> removed the {{ $interaction->activity_name() }} <span style="color:#0c82dc;"><a href="#" data-toggle="tooltip" data-placement="bottom" title="Removed objects cannot be viewed">{!!  ucfirst($interaction->title()) !!}</a></span></div>--}}

                                {{--@elseif($interaction->isInteraction(App\Model\Activity::$interactions['modified']))--}}

                                    {{--@if($interaction->activity->trashed())--}}
                                        {{--<div class="text"><span style="font-weight: 400; color:#0c82dc;">{{ $interaction->account->fullName() }}</span> updated the {{ $interaction->activity_name() }} <span style="text-decoration: line-through">{!!  ucfirst($interaction->title()) !!}</span></div>--}}
                                    {{--@else--}}
                                        {{--<div class="text"><span style="font-weight: 400; color:#0c82dc;">{{ $interaction->account->fullName() }}</span> updated the {{ $interaction->activity_name() }} <span style="color:#0c82dc">{!!  $interaction->link() ? '<a href="'.$interaction->link().'">'. ucfirst($interaction->title()).'</a>' : ucfirst($interaction->title()) !!}</span></div>--}}
                                    {{--@endif--}}

                                {{--@endif--}}

                            {{--</div>--}}

                        {{--@endforeach--}}

                    </div>

                </div>

            </div>

            <div class="products">

                <div class="heading">

                    <h3>Product plugins</h3>

                </div>

                <div>

                    @foreach($products as $product)

                        <div class="tile">

                            <div class="image">

                                <i class="fa {{ $product->icon() }}" aria-hidden="true"></i>

                            </div>

                            <div class="name">

                                {{ ucwords($product->name()) }}

                            </div>

                            <div class="status">

                                {!! $product->isEnabled() ? '<span style="color:green">Enabled</span>' : '<span style="color:red">Disabled</span>' !!}

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

    </div>
@endsection

@section('javascript')
    <script>
        new Morris.Line({
            // ID of the element in which to draw the chart.
            element: 'page-views',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data: [
                { date: 'Months', users: '0' },
            ],
            // The name of the data record attribute that contains x-values.
            xkey: 'date',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['users'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Users']
        });
    </script>
@endsection