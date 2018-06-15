@extends('dashboard::frame')

@section('title')
    @if($account->exists)
        Edit User Accounts
    @else
        Create User Accounts
    @endif
@endsection

@section('information')
    @if($account->exists)
        Edit an already existing user on your website platform.
    @else
        Create a new user on your website platform.
    @endif
@endsection

@section('content')

    @include('dashboard::structure.validation')

    @if($account->exists)
        <form action="{{ route('admin.accounts.update', $account->id) }}" method="post">
        <input type="hidden" name="_method" value="PATCH">
    @else
        <form action="{{ route('admin.accounts.store') }}" method="post">
    @endif

    {{ csrf_field() }}

    <div class="row">
        <div class="col-4">
            <div class="form-group">
                <label for="forename">First name</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">{!! useIcon('font') !!}</div>
                    </div>
                    <input type="text" name="forename" id="forename" class="form-control" value="{{ old('forename', optional($account)->forename) }}" aria-describedby="forenameHelp" required>
                </div>
                <small id="forenameHelp" class="text-muted">Enter the accounts first name.</small>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
              <label for="surname">Last name</label>
              <input type="text" name="surname" id="surname" class="form-control" value="{{ old('surname', optional($account)->surname) }}" aria-describedby="surnameHelp">
              <small id="surnameHelp" class="text-muted">Enter the accounts last name.</small>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">{!! useIcon('at') !!}</div>
                    </div>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', optional($account)->email) }}" aria-describedby="emailAddressHelp" required>
                </div>
                <small id="emailAddressHelp" class="text-muted">The email that will be used for login access.</small>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
                <div class="form-group">
                    <label for="password">{{ $account->exists ? 'New ' : '' }}Password</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">{!! useIcon('key') !!}</div>
                        </div>
                        <input type="password" name="password" id="password" class="form-control" placeholder="{{ $account->exists ? 'Leave Blank to keep unchanged' : '' }}" aria-describedby="passwordHelp">
                    </div>
                    <small id="passwordHelp" class="text-muted">The password that will be used for login access.</small>
                </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="password_confirmation">Confirm password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="" aria-describedby="passwordConfirmationHelp">
                <small id="passwordConfirmationHelp" class="text-muted">Confirm the password so we can be sure you entered it correctly.</small>
            </div>
        </div>
    </div>

    <div class="form-group">
      <label for="role_id">Choose a Role Permission</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">{!! useIcon('project-diagram') !!}</div>
            </div>
            <select class="form-control" name="role_id" id="role_id">
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ formSelect(old('role_id', optional($account->roles->first())->id), $role->id) }}>{{ $role->title }}</option>
                @endforeach
            </select>
        </div>
      <small id="surnameHelp" class="text-muted">Roles are defined by a set of permissions, choose the one viable for this account.</small>
      <small id="surnameHelp" class="text-muted">
          <ul>
              @foreach ($roles as $role)
                <li><b>{{ $role->title }}</b>: {{ $role->description }}</li>
              @endforeach
          </ul>
      </small>
    </div>
    
    <div class="form-actions">

        @if ($account->exists)
            <button type="submit" class="btn btn-create">Update Account Details</button>
        @else
            <button type="submit" class="btn btn-create">Create Account</button>
        @endif

        <div class="pull-right">
            <button type="reset" class="btn btn-reset">Reset</button>
            <a href="{{ route('admin.accounts.index') }}" class="btn btn-cancel">Cancel</a>
        </div>
    </div>

@endsection