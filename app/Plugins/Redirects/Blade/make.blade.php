@extends('dashboard::frame')

@section('tools')
    No tools available
@endsection

@section('information')
    Redirects are the best possibly way of getting your visitors to the pages you want them to this is great for pages that you you have moved, or pages
    that you do not want the user to see hence a redirect to another page.
@endsection

@section('content')

    <div class="flex-display">

        <ul class="nav nav-tabs" role="tablist" id="tabbed">
            <li role="presentation" class="active">
                <a href="#menu" aria-controls="seo" role="tab" data-toggle="tab">Redirect Pages</a>
            </li>
        </ul>

        <div class="form-box blue">

            <form action="{{ route('CreateRedirect') }}" method="POST" id="form"> {{ csrf_field() }}

                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane fade in active" id="menu">

                        <div class="form form-panel">

                            <div class="heading blue">

                                <div class="title">

                                    <h2>Redirect Pages</h2>

                                </div>

                                <div class="tools">

                                    @yield('tools')

                                </div>

                            </div>

                            <div class="form-body">

                                <div class="form-horizontal form-bordered form-label-stripped">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Redirect from</label>
                                        <div class="col-xs-10">
                                            <select class="form-control chosen-select" name="redirect_from_id">

                                                <option aria-checked="true"></option>

                                                @foreach($pages as $key => $page)

                                                    <option value="{{ $key }}">{{ $page }}</option>

                                                @endforeach

                                            </select>
                                            @if($errors->has('redirect_from_id'))
                                                <span class="validation-error">{{ $errors->first('redirect_from_id') }}</span>
                                            @endif
                                            <span class="help-block"> Designate the page that will have the redirect. </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Redirect to</label>
                                        <div class="col-xs-10">
                                            <select class="form-control chosen-select" name="redirect_to_id">

                                                <option aria-checked="true"></option>

                                                @foreach($pages as $key => $page)

                                                    <option value="{{ $key }}">{{ $page }}</option>

                                                @endforeach

                                            </select>
                                            @if($errors->has('redirect_to_id'))
                                                <span class="validation-error">{{ $errors->first('redirect_to_id') }}</span>
                                            @endif
                                            <span class="help-block"> Assign the page that will be shown on the redirect. </span>
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
                        <button id="btn-refresh" type="button" class="button blue" >
                            <i class="fa fa-refresh"></i> Restart</button>
                        <button id="btn-cancel" data-redirect="{{ route('redirects') }}" type="button" class="button blue">
                            <i class="fa fa-times"></i> Cancel</button>
                    </div>
                </div>

            </form>

        </div>

    </div>

@endsection

@section('javascript')
    {{--Javascript end page.--}}
@endsection