@extends('dashboard::frame')

@section('title')
    Updates
@endsection

@section('information')
    Our database updates is one of the most powerful features we have to offer, when a database update exists, it shall be applied on page load. (less than 1ms)
    <br>
    It is important to note, that this does not mean client updates or dashboard changes.
@endsection

@section('content')

    <div class="row">
        <div class="col-4">
            <div class="card bg-light mb-3" style="max-width: 20rem;">
                <div class="card-body">
                    <h4 class="card-title">Successfull Updates</h4>
                    <p class="card-text">{{ count($updates) }}</p>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card bg-light mb-3" style="max-width: 20rem;">
                <div class="card-body">
                    <h4 class="card-title">Failed Updates</h4>
                    <p class="card-text">0</p>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card bg-light mb-3" style="max-width: 20rem;">
                <div class="card-body">
                    <h4 class="card-title">Total Updates</h4>
                    <p class="card-text">{{ count($updates) }}</p>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="webshelf-table">

        @foreach($updates as $update)
            <div class="row">

                    <div class="col-4 text-left">
                        <i class="fa fa-key" aria-hidden="true"></i> {{ md5($update->id) }}
                    </div>

                    <div class="col-3 text-center">
                        {!! bool2Status(true, 'Completed', 'Failed') !!}
                    </div>

                    <div class="col-2 text-center">
                        #{{ $update->batch }}
                    </div>

                    <div class="col-3 text-right">
                        {{ $update->created_at->diffForHumans() }}<br>
                    </div>

            </div>

        @endforeach

@endsection