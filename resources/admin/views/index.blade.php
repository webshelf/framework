@extends('dashboard::frame')

@section('content')

    <div class="overview">

        <div class="avatar">

            <img src="{{ url(settings()->getDefault('website_logo')) }}">

        </div>

        <div class="title">

            <h3>{{ settings()->getDefault('website_name') }}</h3>

        </div>

        <div class="buttons">


        </div>

    </div>

    <hr>

        <p class="text-center">{{ url('/') }}</p>

    <hr>

    <div class="webshelf-table">

        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Account</th>
                <th scope="col">Action</th>
                <th scope="col">Table</th>
                <th scope="col">Name</th>
            </tr>
            </thead>
            <tbody>

            <?php /** @var \App\Model\Activity $activity */ ?>
            @foreach ($activities as $activity)
                <tr>
                    <td>{{ $activity->account->fullName() }}</td>
                    <td>{{ $activity->eventName() }}</td>
                    <td>{{ $activity->model->getTable() }}</td>
                    <td>{{ $activity->model->name() }}</td>
                </tr>
            @endforeach

            </tbody>
        </table>

    </div>


@endsection