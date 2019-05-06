@extends('dashboard::frame')

<?php  ?>

@section('title')
    Account Management
@endsection

@section('information')
    Accounts give users permissions to log in to the application and control content providing they have correct permissions.<br>
    This should not be confused with users who log in to the website and create an account. (Users Plugin)
@endsection

@section('content')

<form>
    <div class="searchbar">
        <div class="text form-row">
            <div class="col">
                <input type="text" class="form-control" placeholder="Search..." id="search-table">
            </div>
        </div>
        <div class="pull-right ml-2">
            <a href="{{ route('admin.accounts.create') }}" class="btn btn-create">Create Account</a>
    </div>
    </div>
</form>

<div class="webshelf-table">

    @foreach($accounts as $account)
        <div class="row">

            <div class="avatar">
                <img src="{{ $account->avatar }}" alt="">
            </div>

            <div class="details">
                <div class="title">
                    <a href="{{ route('admin.accounts.edit', $account->id) }}">{{ $account->fullName() }} ({{ ucwords($account->role->title) }})</a>
                </div>
                <div class="website">
                    Created {{ $account->created_at->diffForHumans() }}
                </div>
            </div>

            <div class="console">
                <ul class="list-unstyled">
                    <li><a href="{{ route('admin.accounts.edit', $account->id) }}">Edit</a></li>
                    <li>
                        <button href="{{ route('admin.accounts.destroy', $account->id) }}" data-type="deletion" data-confirm="Are you sure you want to remove this account?">Remove</button>
                    </li>
                </ul>
            </div>

            <div class="stats">
                <div class="timestamp">
                    Last Logged IP: {{ optional(\App\Model\AccessLog::latestAttemptFrom($account))->ip_address ?? 'Never' }}
                </div>
                <div class="views">
                    Last Login: {{ optional($account->last_login)->diffForHumans() ?? 'Never' }}
                </div>
            </div>
        </div>
    @endforeach

</div>

@endsection