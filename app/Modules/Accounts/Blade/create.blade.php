@extends('dashboard::frame')

@section('title')
    <h1>Create a new user account.</h1>
@endsection

@section('information')
    <p>Accounts allow user access to your website dashboard, you are able to assign roles which can limit the functionality and permissions granted.</p>
@endsection

@section('content')

    <div class="flex-display">

        <ul class="nav nav-tabs" role="tablist" id="tabbed">
            <li class="active">
                <a href="#seo" aria-controls="staff" role="tab" data-toggle="tab">New Staff</a>
            </li>
        </ul>

        <div class="form-box blue">

            <form method="POST" action="{{ route('admin.accounts.store') }}" id="form">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane fade in active" id="staff">

                        <div class="form form-panel">

                            <div class="heading blue">

                                <div class="title">

                                    <h2>New Staff</h2>

                                </div>

                            </div>

                            <div class="form-body">

                                <div class="form-horizontal form-bordered form-label-stripped">

                                    <div class="form-group {{ $errors->has('forename') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">Forename<span class="required" aria-required="true"> * </span></label>
                                        <div class="col-xs-10">
                                            <input type="text" name="forename" class="form-control" placeholder="{{ old('forename') }}" value="{{ old('forename') }}">
                                            @if($errors->has('forename'))
                                                <span class="validation-error">{{ $errors->first('forename') }}</span>
                                            @endif
                                            <span class="help-block"> First name of the user. </span>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('surname') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">Surname<span class="required" aria-required="true"> * </span></label>
                                        <div class="col-xs-10">
                                            <input type="text" name="surname" class="form-control" placeholder="{{ old('surname') }}" value="{{ old('surname') }}">
                                            @if($errors->has('surname'))
                                                <span class="validation-error">{{ $errors->first('surname') }}</span>
                                            @endif
                                            <span class="help-block"> Second name of the user. </span>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('password') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">Password<span class="required" aria-required="true"> * </span></label>
                                        <div class="col-xs-10">
                                            <input type="password" name="password" class="form-control" placeholder="{{ old('password') }}" value="{{ old('password') }}">
                                            @if($errors->has('password'))
                                                <span class="validation-error">{{ $errors->first('password') }}</span>
                                            @endif
                                            <span class="help-block"> User account password for authentication. </span>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('email') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">Email<span class="required" aria-required="true"> * </span></label>
                                        <div class="col-xs-10">
                                            <input type="text" name="email" class="form-control" placeholder="{{ old('email') }}" value="{{ old('email') }}">
                                            @if($errors->has('email'))
                                                <span class="validation-error">{{ $errors->first('email') }}</span>
                                            @endif
                                            <span class="help-block"> Email address for password resets and authentication. </span>
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('group') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">Group<span class="required" aria-required="true"> * </span></label>
                                        <div class="col-xs-10">
                                            <select class="form-control {{ $errors->has('group') ? 'error' : null }} chosen-select" name="group">

                                                <option aria-checked="true"></option>

                                                @foreach($groups as $group)
                                                    <?php /** @var \App\Model\Role $group */ ?>
                                                    <option value="{{ $group->id }}">{{ $group->title() }}</option>

                                                @endforeach

                                            </select>
                                            @if($errors->has('group'))
                                                <span class="validation-error">{{ $errors->first('group') }}</span>
                                            @endif
                                            <span class="help-block"> Assign a group authority to this user. </span>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('language') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">Language</label>
                                        <div class="col-xs-10">
                                            <select class="form-control {{ $errors->has('language') ? 'error' : null }} chosen-select" name="language">

                                                <option aria-checked="true">English</option>

                                            </select>
                                            @if($errors->has('language'))
                                                <span class="validation-error">{{ $errors->first('language') }}</span>
                                            @endif
                                            <span class="help-block"> Selected language for this user. </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Confirmation email.</label>
                                        <div class="col-xs-10">
                                            <input type="checkbox" data-on-text="Public" data-off-text="Private" data-on-color="success" data-off-color="danger" name="confirmation_email" class="make-switch" checked data-size="small">
                                            <span class="help-block">Send a confirmation to the user about their account with their new password. </span>
                                        </div>
                                    </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="form-actions" id="vue-buttons">
                    <div class="row">
                        <button type="submit" name="submit" class="button blue">
                            <i class="fa fa-check"></i> Submit</button>
                        <button id="btn-refresh" type="button" class="button blue" >
                            <i class="fa fa-refresh"></i> Restart</button>
                        <button id="btn-cancel" data-redirect="{{ url('/admin/accounts') }}" type="button" class="button blue">
                            <i class="fa fa-times"></i> Cancel</button>
                    </div>
                </div>

            </form>

        </div>

    </div>

@endsection