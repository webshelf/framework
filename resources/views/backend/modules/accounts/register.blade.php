@extends('dashboard::frame')

@section('title')
    <h1>Register Account</h1>
@endsection
@section('information')
    <p>Grant permissions and allow changes to be made to the core application.</p>
@endsection

@section('content')

    <div class="flex-display">

        <ul class="nav nav-tabs" role="tablist" id="tabbed">
            <li class="active">
                <a href="#login" aria-controls="login" role="tab" data-toggle="tab"> Login Information</a>
            </li>
            <li>
                <a href="#personal" aria-controls="login" role="tab" data-toggle="tab"> Personal Information</a>
            </li>
        </ul>

        <div class="form-box blue">

            <form action="{{ route('AccountRegistration') }}" method="POST" id="form">
                {{ csrf_field() }}

                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane fade in active" id="login">

                        <div class="form form-panel">

                            <div class="heading blue">

                                <div class="title">

                                    <h2>Login Information</h2>

                                </div>

                                <div class="tools">

                                    @yield('tools')

                                </div>

                            </div>

                            <div class="form-body">

                                <div class="form-horizontal form-bordered form-label-stripped">
                                    <div class="form-group {{ $errors->has('email') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">Email Address<span class="required" aria-required="true"> * </span></label>
                                        <div class="col-xs-10">
                                            <input v-model="slug" type="text" name="email" class="form-control" value="{{ old('email') }}">
                                            @if($errors->has('email'))
                                                <span class="validation-error">{{ $errors->first('email') }}</span>
                                            @endif
                                            <span class="help-block"> A valid email that the user will use to login. </span>
                                            <span class="help-block"> A validation email will be sent that they must complete. </span>
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('password') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">Password</label>
                                        <div class="col-xs-10">
                                            <input type="password" name="password" class="form-control" value="">
                                            @if($errors->has('password'))
                                                <span class="validation-error">{{ $errors->first('password') }}</span>
                                            @endif
                                            <span class="help-block"> <span style="color:#2259ff;" aria-required="true"> * </span>This can be left blank and prompted on the account to be set up.</span>
                                            <span class="help-block"> The password that will be used to login to this account.</span>
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('password') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">Confirm Password</label>
                                        <div class="col-xs-10">
                                            <input type="password" name="confirmed_password" class="form-control" value="">
                                            @if($errors->has('password'))
                                                <span class="validation-error">{{ $errors->first('password') }}</span>
                                            @endif
                                            <span class="help-block"> <span style="color:#2259ff;" aria-required="true"> * </span>This can be left blank and prompted on the account to be set up.</span>
                                            <span class="help-block"> Enter the password again to verify the correct details.</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Account Role<span class="required" aria-required="true"> * </span></label>
                                        <div class="col-xs-10">
                                            <select class="form-control chosen-select" name="role_id">

                                                @foreach($roles as $role)

                                                    <option value="{{ $role->id() }}" @if($role->title() == 'External User') aria-checked="true" @endif >{{ $role->title() }} - <span style="color:green;">{{ $role->description() }}</span></option>

                                                @endforeach

                                            </select>
                                            <span class="help-block"> The accounts role in your application. </span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div role="tabpanel" class="tab-pane fade in" id="personal">

                        <div class="form form-panel">

                            <div class="heading blue">

                                <div class="title">

                                    <h2>Personal Information</h2>

                                </div>

                                <div class="tools">

                                    @yield('tools')

                                </div>

                            </div>

                            <div class="form-body">

                                <div class="form-horizontal form-bordered form-label-stripped">
                                    <div class="form-group {{ $errors->has('forename') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">Forename</label>
                                        <div class="col-xs-10">
                                            <input name="forename" class="form-control" value="{{ old('forename') }}">
                                            @if($errors->has('forename'))
                                                <span class="validation-error">{{ $errors->first('forename') }}</span>
                                            @endif
                                            <span class="help-block"> <span style="color:#2259ff;" aria-required="true"> * </span>This can be left blank and prompted on the account to be set up.</span>
                                            <span class="help-block"> The account first name as you would like it to appear on the account.</span>
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('surname') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">Surname</label>
                                        <div class="col-xs-10">
                                            <input name="surname" class="form-control" value="{{ old('surname') }}">
                                            @if($errors->has('surname'))
                                                <span class="validation-error">{{ $errors->first('surname') }}</span>
                                            @endif
                                            <span class="help-block"> <span style="color:#2259ff;" aria-required="true"> * </span>This can be left blank and prompted on the account to be set up.</span>
                                            <span class="help-block"> The account second name as you would it to appear on the account.</span>
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('address') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">Address</label>
                                        <div class="col-xs-10">
                                            <input name="address" class="form-control" value="{{ old('address') }}">
                                            @if($errors->has('address'))
                                                <span class="validation-error">{{ $errors->first('address') }}</span>
                                            @endif
                                            <span class="help-block">In case of contact, the address of the account holder.</span>
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('number') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">Phone no.</label>
                                        <div class="col-xs-10">
                                            <input name="number" class="form-control" value="{{ old('number') }}">
                                            @if($errors->has('number'))
                                                <span class="validation-error">{{ $errors->first('number') }}</span>
                                            @endif
                                            <span class="help-block"> In case of contact, the contact number of the account holder.</span>
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
                            <i class="fa fa-check"></i> Register Account</button>
                        <button v-on:click="loadUrl('{{ url('admin/accounts') }}')" type="button" class="button blue">
                            <i class="fa fa-times"></i> Cancel</button>
                    </div>
                </div>

            </form>

        </div>

    </div>

@endsection