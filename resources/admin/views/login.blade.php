<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta id="token" name="csrf-token" content="{!! csrf_token() !!}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ framework()->package }} v{{ framework()->version  }}</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ mix('assets/backend.css') }}">

        <script src="{{ mix('assets/backend.js') }}"></script>

    </head>

    <body id="login-form">

        <div class="container-fluid">

            <div class="row">

                <div class="hidden-xs col-sm-7 col-md-8 background">

                    <div class="app-info">

                        <h1>{{ framework()->package }} v{{ framework()->version }}</h1>

                        <p>Welcome to a unique, refreshing website management system.</p>

                    </div>

                </div>

                <div class="col-xs-12 col-sm-5 col-md-4 login-sidebar">

                    <div class="login-container">

                        <p>Sign into {{ settings()->getDefault('website_name') }}</p>

                        @include('dashboard::structure.validation')

                        <form action="{{ route('AuthLogin') }}" method="post">

                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="emailAddress">Email Address</label>
                                <input type="email" class="form-control" name="email" id="emailAddress"
                                       aria-describedby="emailAddressHelp"
                                       placeholder="" required>
                                <small id="emailAddressHelp" class="form-text text-muted">The email address you associate with.</small>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password"
                                       aria-describedby="passwordHelp"
                                       placeholder="" required>
                                <small id="passwordHelp" class="form-text text-muted">Enter the password for this account email.</small>
                            </div>

                            <button type="submit" class="btn btn-webshelf">Login!</button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </body>

</html>