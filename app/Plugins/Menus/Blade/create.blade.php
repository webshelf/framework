@extends('dashboard::frame')

@section('title')
    Creating a new Menu
@endsection

@section('information')
    Pages are stored content viewable to a user in a form of a page, these can be modified, viewed and edited by clicking on the page name on the below table.<br>
    The best pages are those that are easy to view and read in which they also stay true to the title.
@endsection

@section('tools')
    No tools available
@endsection

@section('content')

    <div class="flex-display">

        <ul class="nav nav-tabs" role="tablist" id="tabbed">
            <li role="presentation" class="active">
                <a href="#menu" aria-controls="seo" role="tab" data-toggle="tab">Menu Creation</a>
            </li>
        </ul>

        <div class="form-box blue">

            <form action="{{ route('MakeMenu') }}" method="POST" id="form"> {{ csrf_field() }}

                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane fade in active" id="menu">

                        <div class="form form-panel">

                            <div class="heading blue">

                                <div class="title">

                                    <h2>Menu Creation</h2>

                                </div>

                                <div class="tools">

                                    @yield('tools')

                                </div>

                            </div>

                            <div class="form-body">

                                <div class="form-horizontal form-bordered form-label-stripped">
                                    <div class="form-group {{ $errors->has('title') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">Text<span class="required" aria-required="true"> * </span></label>
                                        <div class="col-xs-10">
                                            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                                            @if($errors->has('title'))
                                                <span class="validation-error">{{ $errors->first('title') }}</span>
                                            @endif
                                            <span class="help-block"> The title of the menu as you would like it appeared to viewers. </span>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('page_id') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">Internal Page</label>
                                        <div class="col-xs-10">
                                            <select class="form-control {{ $errors->has('page_id') ? 'error' : null }} chosen-select" name="page_id">

                                                <option aria-checked="true"></option>

                                                @foreach($pages as $key => $page)

                                                    <option value="{{ $key }}">{{ $page }}</option>

                                                @endforeach

                                            </select>
                                            @if($errors->has('page_id'))
                                                <span class="validation-error">{{ $errors->first('page_id') }}</span>
                                            @endif
                                            <span class="help-block"> Internal Page links help you link up created pages with ease. </span>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('external_link') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">External Link</label>
                                        <div class="col-xs-10">
                                            <input class="form-control" name="external_link" type="text" value="{{ old('external_link') }}">
                                            @if($errors->has('external_link'))
                                                <span class="validation-error">{{ $errors->first('external_link') }}</span>
                                            @endif

                                            <span class="help-block"> Outsource your links, this will disable internal attached page. </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Submenu of</label>
                                        <div class="col-xs-10">
                                            <select class="form-control chosen-select" name="submenu_id">

                                                <option aria-checked="true"></option>

                                                @foreach($submenus as $key => $menu)

                                                    <option value="{{ $key }}">{{ $menu }}</option>

                                                @endforeach

                                            </select>
                                            <span class="help-block"> Submenus are listed below top level menus / Leave blank to create a new Top Level Menu </span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Target</label>
                                        <div class="col-xs-10">
                                            <select class="form-control chosen-select" name="target">

                                                <option value="_self" aria-checked="true">_self (Page will open on the current browser window)</option>
                                                <option value="_blank">_blank (Page will open on a new browser tab window)</option>

                                            </select>
                                            <span class="help-block"> How do you want the browser to interact with this menu? </span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Privacy</label>
                                        <div class="col-xs-10">
                                            <input type="checkbox" data-on-text="Public" data-off-text="Private" data-on-color="success" data-off-color="danger" name="enabled" class="make-switch" checked data-size="small">
                                            <span class="help-block">Set the privacy of the page and who can view it. </span>
                                        </div>
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
                        <button id="btn-cancel" data-redirect="{{ route('menus') }}" type="button" class="button blue">
                            <i class="fa fa-times"></i> Cancel</button>
                    </div>
                </div>

            </form>

        </div>

    </div>

@endsection