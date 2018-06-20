@extends('dashboard::frame')

@section('content')

    <?php use App\Model\AccessLog; ?>

    <div class="dashboard">
            <div class="panel" id="welcome">

                <h3 class="title">Welcome {{ account()->fullName() }} ({{ account()->role->title }})</h3>
        
                <p>Welcome back to Webshelf CMS, Your last sign in was</p>
        
                <p class="last-login">{{  AccessLog::latestAttemptFrom(account())->created_at->format('D, M dS, Y, H:i') }}</p>
        
                <a href="https://github.com/webshelf/framework/issues">View Platform Issue Tracker</a>
        
            </div>
        
            <div class="panel" id="status">
        
                <h3 class="title">Platform Status</h3>
        
                <ul>
                    <li>
                        <span class="status icon green"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                        <span class="status text">Software is up to date</span>
                        <span class="status message"> v{{  framework()->version }}</span>
                    </li>
                    <li>
                        <span class="status icon green"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                        <span class="status text">No warnings to display</span>
                        <span class="status badge">0</span>
                    </li>
                    <li>
                        <span class="status icon green"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                        <span class="status text">Migration service active</span>
                        {{-- <span class="status badge">0</span> --}}
                    </li>
                    <li>
                        <span class="status icon green"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                        <span class="status text">Website is currently online</span>
                        {{-- <span class="status message">Not Available</span> --}}
                    </li>
                </ul>
        
            </div>

            <div class="panel" id="activity">

                <h3 class="title">Activity Log</h3>

                    <div class="content-table">

                        @foreach ($activities as $activity)

                        <div class="row">

                                <span class="avatar-radius-50">
                                    <img src="{{ $activity->causer->avatar }}" alt="{{ $activity->causer->fullName() }} Image">
                                </span>

                                <div class="event">
                                    <div class="title">{{ $activity->causer->fullName() }}</span> {{ $activity->description }} {{ ucfirst($activity->subject->table) }}</div>
                                    <div class="description">Activity Logged @ {{ $activity->created_at }}</div>
                                </div>
        
                                <div class="details">
                                    {{ $activity->created_at->diffForHumans() }}
                                </div>
                        </div>

                        @endforeach

                    </div>
                
            </div>
    </div>

@endsection