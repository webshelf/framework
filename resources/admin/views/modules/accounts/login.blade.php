<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ settings()->getDefault('site_name') ?: config('engine.name') }} | Admin Login</title>

    <!-- Include all compiled css -->
    <link href="{{ mix('assets/backend.css') }}" rel="stylesheet">
    <script src="{{ mix('assets/backend.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
</head>

<body>

<script>
    new WOW().init();
</script>

<style>

    body {
        background: #eeeeee;
        background: url({{ asset('packages/webshelf/images/authenticate.png') }});
        background-repeat: no-repeat;
        background-size: cover;
    }

    h1 {
        color: rgb(46,46,46);
        font-size: 20px;
        padding: 20px 0;
        border-bottom: 1px solid #D8D8DA;
        margin-bottom: 20px;
        font-weight: normal;
    }

    #wrapper {
        text-align: center;
        margin:auto;
        width:480px;
        margin-top:250px;
        background-color: white;
        border-radius: 5px;
        border: 1px solid #cccccc;
    }

    .login-container {
        margin: auto;
        width: 480px;
        padding: 5px 90px 30px 90px;
    }

    .login-container .actions {
        width:300px;
    }

    .alert {
        padding:10px;
    }
    .alert-danger ul {
        padding: 0;
        list-style: none;
    }

</style>

<div id="wrapper" class="wow fadeInDown">
    <div class="login-container">
        <h1>
           {{ settings()->getDefault('site_name') }}
        </h1>

        <div class="actions">
            <form action="{{ route('AuthLogin') }}" method="post">
                {!! csrf_field() !!}

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group row">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span><input class="form-control" name="email" placeholder="Username or Email" type="text">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span><input class="form-control" name="password" placeholder="Password" type="password">
                    </div>
                </div>

                <input class="btn btn-lg btn-primary btn-block" type="submit" value="Log in" style="margin-bottom: 20px; background-color:#337ab7;">

            </form>
        </div>

        @include('dashboard::components.copyright')

    </div>

</div>

</body>

</html>
