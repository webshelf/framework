@extends('dashboard::frame')

@section('title')
    <h1>Account Management</h1>
@endsection

@section('javascript')

    <script>
        $(document).ready(function(){
            $('#table-datatables').DataTable({
                'iDisplayLength': 25
            });
        });
    </script>

@endsection

@section('information')
    <p>
        Accounts give users permissions to log in to the application and control content providing they have correct permissions.<br>
        This should not be confused with users who log in to the website and create an account. (Users Plugin)
    </p>
@endsection

@section('content')

    <div class="table-panel border light">

        <table id="table-datatables" class="table table-striped table-bordered table-hover row-border order-column">

            <thead>
            <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Login Count</th>
                <th>Last Login</th>
                <th>Creation Date</th>
                <th>Status</th>
            </tr>
            </thead>

            <tbody>

            @foreach($accounts as $account)

                @if($account->verified == true)

                    <tr>

                    <td><a href="{{ route('admin.accounts.index', $account->email) }}">{{ $account->fullName() }}</a></td>

                    <td>{{ strtolower($account->email) }}</td>

                    <td>{{ $account->role->title() }}</td>

                    <td>{{ $account->login_count }}</td>

                    <td><a href="#" data-toggle="tooltip" data-placement="bottom" title="Last logged in {{ $account->lastLogin ? $account->lastLogin->diffForHumans() : 'Never'}}">{{ $account->lastLogin ? $account->lastLogin->format('F dS Y') : 'Never'}}</a></td>

                    <td><a href="#" data-toggle="tooltip" data-placement="bottom" title="Account created {{ $account->created_at->diffForHumans() }}">{{ $account->created_at->format('F dS Y') }}</a></td>

                    <td>{!! bool2Status($account->verified, 'Verified', 'Unverified') !!}</td>

                    </tr>

                @else

                    <tr>

                    <td>{{ $account->forename != '' ? $account->fullName() : 'Unassigned'}}</td>

                    <td>{{ strtolower($account->email) }}</td>

                    <td>{{ $account->role->title() }}</td>

                    <td>{{ $account->login_count }}</td>

                    <td>Never</td>

                    <td><a href="#" data-toggle="tooltip" data-placement="bottom" title="Account created {{ $account->created_at->diffForHumans() }}">{{ $account->created_at->format('F dS Y') }}</a></td>

                    <td>{!! bool2Status($account->verified, 'Verified', 'Unverified') !!}</td>

                    </tr>

                @endif

            @endforeach

            </tbody>
        </table>

    </div>

@endsection