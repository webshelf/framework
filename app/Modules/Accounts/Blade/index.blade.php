@extends('dashboard::frame')

<?php use App\Model\AccessLog; ?>

@section('title')
    Account Management
@endsection

@section('information')
    Accounts give users permissions to log in to the application and control content providing they have correct permissions.<br>
    This should not be confused with users who log in to the website and create an account. (Users Plugin)
@endsection

@section('content')

<div class="webshelf-scope-menu">

    <ul class="list-unstyled">

        {{-- <li class="item">
            <a href="{{ route('admin.pages.index') }}" class="{{ Request::segment(3) == '' ? 'active' : null }}">
                <span class="title">Normal Pages</span>
            </a>
        </li>
        <li class="item">
            <a href="{{ route('admin.pages.plugin') }}" class="{{ Request::segment(3) == 'plugin' ? 'active' : null }}">
                <span class="title">Plugin Pages</span>
            </a>
        </li>
        <li class="item">
            <a href="{{ route('admin.pages.error') }}" class="{{ Request::segment(3) == 'error' ? 'active' : null }}">
                <span class="title">Error Pages</span>
            </a>
        </li> --}}

    </ul>

</div>

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
                <img src="{{ account()->gravatarUrl() }}" alt="">
            </div>

            <div class="details">
                <div class="title">
                    <a href="{{ route('admin.accounts.edit', $account->id) }}">{{ $account->fullName() }}</a>
                </div>
                <div class="website">
                    Created {{ $account->created_at->diffForHumans() }}
                </div>
            </div>

            <div class="console">
                <ul class="list-unstyled">
                    <li><a href="{{ route('admin.accounts.edit', $account->id) }}">{!! useIcon('user-shield') !!}Administrator</a></li>
                    <li><a href="{{ route('admin.accounts.edit', $account->id) }}">{!! useIcon('user-edit') !!}Edit</a></li>
                    <li><a href="{{ route('admin.accounts.destroy', $account->id) }}" data-type="alert" data-confirm="Are you sure you want to remove this account?" data-method="delete">{!! useIcon('user-times') !!}Remove</a></li>
                </ul>
            </div>

            <div class="stats">
                <div class="timestamp">
                    Last Logged IP: {{ optional(AccessLog::latestAttemptFrom($account))->ip_address ?? 'Never' }}
                </div>
                <div class="views">
                    Last Login: {{ optional($account->last_login)->diffForHumans() ?? 'Never' }}
                </div>
            </div>
        </div>
    @endforeach

</div>

@endsection