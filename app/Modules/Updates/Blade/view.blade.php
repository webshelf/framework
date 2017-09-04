@extends('dashboard::frame')

@section('javascript')

    <script>
        $(document).ready(function(){
            $('#table-datatables').DataTable({
                'iDisplayLength': 50
            });
        });
    </script>

@endsection

@section('title')
    <h1>Database Updated</h1>
@endsection

@section('information')
    <p>
        Our database updates is one of the most powerful features we have to offer, when a database update exists, it shall be applied on page load. (less than 1ms)
        <br>
        It is important to note, that this does not mean client updates or dashboard changes.
    </p>
@endsection

@section('content')

    <div class="table-panel border light">

        <table id="table-datatables" class="table table-striped table-bordered table-hover row-border order-column">

        <thead>
        <tr>
            <th>Encryption Key</th>
            <th>Status</th>
            <th>Batch #</th>
            <th>Executed</th>
        </tr>
        </thead>

        <tbody>

            @foreach($migrations as $migration)

                <tr>

                    <td>{{ md5($migration->id) }}</td>

                    <td>{!! bool2Status(true, 'Completed', 'Failed') !!}</td>

                    <td>{{ $migration->batch }}</td>

                    <td>{{ $migration->created_at->diffForHumans() }}</td>
                </tr>

            @endforeach

        </tbody>
    </table>

    </div>

@endsection