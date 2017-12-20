<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ settings()->getDefault('website_name') ?: config('engine.name') }} | Admin Login</title>

    <!-- Include all compiled css -->
    <link href="{{ route('ApplicationResource', 'compiled.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css"/>

    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

    <style>

        body {
            background: #eeeeee;
            font-family: 'Segoe UI', 'Lato', 'Open Sans', sans-serif;
        }

        h1 {
            color: rgb(46,46,46);
            font-size: 20px;
            padding: 20px 0;
            border-bottom: 1px solid #D8D8DA;
            margin-bottom: 20px;
            font-weight: normal;
        }

        .login-wrapper {
            /* max-width: 600px; */
            margin: 0 auto;
            text-align: center;
            /* padding: 50px; */
            position: absolute;
            top: 25%;
            left: 38%;
            background-color: white;
            border-radius: 5px;
            border: 1px solid #cccccc;
        }

        .login-container {
            margin: auto;
            width: 480px;
            padding: 20px 90px 30px 90px;
        }

        .login-container .actions {
            width:300px;
        }

    </style>

</head>

<body>

<div class="login-wrapper">
    <div class="login-container">
        <h1>
            @if(settings()->has('website_name'))
                {{ settings()->getDefault('website_name') }} <br><small>Please enter the following details to finish creating your account.</small>
            @else
                {{ config('engine.name') }} Account Registration
            @endif
        </h1>

        <div class="actions">
            <form action="{{ route('UpdateAccount') }}" method="post">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <input type="hidden" name="account_id" value="{{ encrypt($account->id) }}">

                @if($account->forename() == '')
                <div class="form-group row">
                    <div class="input-group">
                        <span class="input-group-addon"></span><input class="form-control" name="forename" placeholder="First Name" value="{{ old('forename') }}">
                    </div>
                </div>
                @endif

                @if($account->surname() == '')
                <div class="form-group row">
                    <div class="input-group">
                        <span class="input-group-addon"></span><input class="form-control" name="surname" placeholder="Last Name" value="{{ old('surname') }}">
                    </div>
                </div>
                @endif

                @if($account->password() == '')
                    <div class="form-group row">
                        <div class="input-group">
                            <span class="input-group-addon"></span><input class="form-control" name="password" placeholder="Password" type="password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="input-group">
                            <span class="input-group-addon"></span><input class="form-control" name="confirmed_password" placeholder="Retype Password" type="password">
                        </div>
                    </div>
                @endif

                <div style="padding: 10px 0;">
                    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Complete my Registration!" style="margin-bottom: 20px">
                </div>

            </form>
        </div>

        @include('dashboard::components.copyright')

    </div>

</div>

<!-- Include all compiled javascript-->
<script src="{{ route('ApplicationResource', 'compiled.js') }}"></script>

<script>
    /*global jQuery */
    /*!
     * FitText.js 1.2
     *
     * Copyright 2011, Dave Rupert http://daverupert.com
     * Released under the WTFPL license
     * http://sam.zoy.org/wtfpl/
     *
     * Date: Thu May 05 14:23:00 2011 -0600
     */

    (function( $ ){

        $.fn.fitText = function( kompressor, options ) {

            // Setup options
            var compressor = kompressor || 1,
                    settings = $.extend({
                        'minFontSize' : Number.NEGATIVE_INFINITY,
                        'maxFontSize' : Number.POSITIVE_INFINITY
                    }, options);

            return this.each(function(){

                // Store the object
                var $this = $(this);

                // Resizer() resizes items based on the object width divided by the compressor * 10
                var resizer = function () {
                    $this.css('font-size', Math.max(Math.min($this.width() / (compressor*10), parseFloat(settings.maxFontSize)), parseFloat(settings.minFontSize)));
                };

                // Call once to set.
                resizer();

                // Call on resize. Opera debounces their resize by default.
                $(window).on('resize.fittext orientationchange.fittext', resizer);

            });

        };

    })( jQuery );

    jQuery("h1").fitText(1.4);

</script>

</body>

</html>