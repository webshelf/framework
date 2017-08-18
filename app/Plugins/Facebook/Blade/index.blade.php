@extends('dashboard::frame')


@section('content')

    <div class="table-panel border light">

        <div class="panel panel-default">
            <div class="panel-body">


                @foreach($posts as $post)

                @php($attachments = [])

                    @if(isset($post['attachments'][0]['media']['image']['src']))

                        @php($attachments[] = ($post['attachments'][0]['media']['image']['src']))

                    @else

                        @foreach($post['attachments'][0]['subattachments'] as $attachment)

                            @php($attachments[] = ($attachment['media']['image']['src']))

                        @endforeach

                    @endif

                    <li><img src="{{ $post['icon'] }}"> {{ str_limit($post['message'],150,'...') }} {{ count($attachments) }}</li>

                @endforeach
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                @foreach($images as $image)
                    <li><img src="{{ $post['icon'] }}"> {{ $image['link'] }}</li>
                @endforeach
            </div>
        </div>

    </div>

@endsection