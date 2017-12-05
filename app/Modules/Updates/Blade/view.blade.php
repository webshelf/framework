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

            @foreach($updates as $update)

                <tr>

                    <td>{{ md5($update->id) }}</td>

                    <td>{!! bool2Status(true, 'Completed', 'Failed') !!}</td>

                    <td>{{ $update->batch }}</td>

                    <td>{{ $update->created_at->diffForHumans() }}</td>
                </tr>

            @endforeach

        </tbody>
    </table>

    </div>

@endsection

@section('javascript')

    <script>
        $(document).ready(function(){
            $('#table-datatables').DataTable({
                'iDisplayLength': 50
            });
        });
    </script>

@endsection