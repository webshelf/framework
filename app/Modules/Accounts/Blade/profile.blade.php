@extends('dashboard::frame')

@section('title')

    <h1>Edit user account profile</h1>

@endsection

@section('content')

    <div class="flex-display">

        <ul class="nav nav-tabs" role="tablist" id="tabbed">
            <li role="presentation" class="active">
                <a href="#details" aria-controls="detailsz" role="tab" data-toggle="tab">Details</a>
            </li>
        </ul>

        <div class="form-box blue">

            <form action="{{ route('UpdateAccount') }}" method="POST" id="form"> {{ csrf_field() }}

                <input hidden name="account_id" value="{{ encrypt($account->id()) }}">

                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane fade in active" id="details">

                        <div class="form form-panel">

                            <div class="heading blue">

                                <div class="title">

                                    <h2>Details</h2>

                                </div>

                            </div>

                            <div class="form-body">

                                <div class="form-horizontal form-bordered form-label-stripped">

                                    <?php /** @var \App\Model\Account $account */ ?>

                                    <div class="form-group {{ $errors->has('forename') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">First Name<span class="required" aria-required="true"> * </span></label>
                                        <div class="col-xs-10">
                                            <input type="text" name="forename" class="form-control" value="{{ old('forename') ?: $account->forename }}" placeholder="{{ $account->forename }}">
                                            @if($errors->has('forename'))
                                                <span class="validation-error">{{ $errors->first('forename') }}</span>
                                            @endif
                                            <span class="help-block">The account holders first name as you would like to appear.</span>
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('surname') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">Last Name<span class="required" aria-required="true"> * </span></label>
                                        <div class="col-xs-10">
                                            <input type="text" name="surname" class="form-control" value="{{ old('surname') ?: $account->surname }}" placeholder="{{ $account->surname }}">
                                            @if($errors->has('surname'))
                                                <span class="validation-error">{{ $errors->first('surname') }}</span>
                                            @endif
                                            <span class="help-block"> The account holders last name as you would like to appear.</span>
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('email') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">Email<span class="required" aria-required="true"> * </span></label>
                                        <div class="col-xs-10">
                                            <input type="text" name="email" class="form-control" value="{{ old('email') ?: $account->email }}" placeholder="{{ $account->email }}">
                                            @if($errors->has('email'))
                                                <span class="validation-error">{{ $errors->first('email') }}</span>
                                            @endif
                                            <span class="help-block"> The account holders email address for contact</span>
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('phone') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">Phone Number</label>
                                        <div class="col-xs-10">
                                            <input type="text" name="number" class="form-control" value="{{ old('phone') ?: $account->number }}" placeholder="{{ $account->number }}">
                                            @if($errors->has('phone'))
                                                <span class="validation-error">{{ $errors->first('phone') }}</span>
                                            @endif
                                            <span class="help-block"> The accounts phone number for contact</span>
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('address') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">Address</label>
                                        <div class="col-xs-10">
                                            <input type="text" name="address" class="form-control" value="{{ old('address') ?: $account->address}}" placeholder="{{ $account->address }}">
                                            @if($errors->has('address'))
                                                <span class="validation-error">{{ $errors->first('address') }}</span>
                                            @endif
                                            <span class="help-block"> The accounts address for contact</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Account Role</label>
                                        <div class="col-xs-10">
                                            <select class="form-control chosen-select" name="role_id">

                                                @foreach($roles as $role)

                                                    <option value="{{ $role->id() }}" @if($role->title() == $account->role->title()) aria-checked="true" @endif >{{ $role->title() }} - <span style="color:green;">{{ $role->description() }}</span></option>

                                                @endforeach

                                            </select>
                                            <span class="help-block"> The profiles current account role in your application CMS </span>
                                        </div>
                                    </div>

                                </div>

                                </div>

                            </div>

                        </div>

                    </div>

                <div class="form-actions" id="vue-buttons">
                    <div class="row">
                        <button type="submit" class="button blue">
                            <i class="fa fa-check"></i> Submit</button>
                        <button v-on:click="refreshPage" type="button" class="button blue">
                            <i class="fa fa-refresh"></i> Restart</button>
                    </div>
                </div>

            </form>

        </div>

    </div>

@endsection