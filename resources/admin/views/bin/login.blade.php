<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta id="token" name="csrf-token" content="{!! csrf_token() !!}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ framework()->package }} v{{ framework()->version  }}</title>

        <link href="{{ mix('assets/backend.css') }}" rel="stylesheet">

    </head>

    <body>

        <div class="background">

            <div class="container">

                <div class="alignment" id="login-box">

                    <form id="app-login" action="{{ route('AuthLogin') }}" method="post">
                        {{ csrf_field() }}
                        <div class="login-information">
                            Log in to your account
                        </div>
                        <hr style="margin-bottom: 25px;">
                        @if($errors->first('message'))<small><div class="alert alert-danger" role="alert">{{ $errors->first('message') }}</div></small>@endif
                        <div class="form-group {{ $errors->has('email') ? 'error' : null }} row">
                            <span class="icon-envelope"></span>
                            <label for="exampleInputEmail1">Email address</label>
                            <input v-model="email.value" name="email" type="email" class="form-control" id="emailInput" placeholder="Enter email" required>
                            @if($errors->has('title'))
                                <span class="validation-error">{{ $errors->first('email') }}</span>
                            @else
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('password') ? 'error' : null }} row">
                            <label for="exampleInputPassword1">Password</label>
                            <input v-model="password.value" name="password" type="password" class="form-control" id="passwordInput" placeholder="Password" required>
                            @if($errors->has('title'))
                                <span class="validation-error">{{ $errors->first('email') }}</span>
                            @else
                                <small id="passwordHelp" class="form-text text-muted">Encrypted with the latest technology.</small>
                            @endif
                        </div>
                        <div class="form-check">
                            <label class="form-check-label align-middle">
                                <input type="checkbox" class="form-check-input">
                                Remember me
                            </label>
                            <button type="submit" class="btn btn-primary float-right" style="float:right">Login</button>
                        </div>
                        <hr style="margin-top:35px">
                        <div class="login-poweredBy">
                            Powered by {{ framework()->package }} v{{ framework()->version }}
                        </div>
                    </form>

                </div>

            </div>

        </div>

        <script src="{{ mix('assets/backend.js') }}"></script>

    </body>

</html>