@extends('dashboard::frame')

@section('title') <h1>Create a new Page</h1> @endsection

@section('information')
    <p>To keep your audience interested you should focus on providing content that will relate to the page name<br>
        SEO is also important, we give you the tools to make this possible in a simplistic way, we do the rest.</p>
@endsection

@section('content')

    <div class="flex-display">

        <ul class="nav nav-tabs" role="tablist" id="tabbed">
            <li class="active">
                <a href="#seo" aria-controls="seo" role="tab" data-toggle="tab">SEO Editor</a>
            </li>
            <li>
                <a href="#content" aria-controls="keywords" role="tab" data-toggle="tab">Content Editor</a>
            </li>
            <li>
                <a href="#options" aria-controls="description" role="tab" data-toggle="tab">Page Options</a>
            </li>
        </ul>

        <div class="form-box blue">

            <form method="POST" action="{{ route('admin.pages.store') }}" id="form">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane fade in active" id="seo">

                        <div class="form form-panel">

                            <div class="heading blue">

                                <div class="title">

                                    <h2>Seo Editor</h2>

                                </div>

                            </div>

                            <div class="form-body">

                                <div class="form-horizontal form-bordered form-label-stripped">
                                    <div class="form-group {{ $errors->has('title') ? 'error' : null }} row">
                                        <label class="control-label col-md-3">Title<span class="required" aria-required="true"> * </span></label>
                                        <div class="col-xs-10">
                                            <input type="text" name="title" class="form-control" placeholder="{{ old('title') }}" value="{{ old('title') }}">
                                            @if($errors->has('title'))
                                                <span class="validation-error">{{ $errors->first('title') }}</span>
                                            @endif
                                            <span class="help-block"> Titles are one words that tell people what they are viewing. </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Slug</label>
                                        <div class="col-xs-10">
                                            <input class="form-control" name="slug" type="text" placeholder="Feature Coming Soon..." readonly>
                                            <span class="help-block"> Customize the url that must be visited to see this page. </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Creator</label>
                                        <div class="col-xs-10">
                                            <input class="form-control" name="creator" type="text" placeholder="{{ account()->fullName() }} [{{ account()->role->title() }}]" readonly>
                                            <span class="help-block"> The user who will/has uploaded this page. </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Keywords</label>
                                        <div class="col-xs-10">
                                            <input type="text" name="keywords" class="form-control" placeholder="{{ old('keywords') }}" value="{{ old('keywords') }}">
                                            <span class="help-block"> Keywords help people who try search for your website through google. </span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Description</label>
                                        <div class="col-xs-10">
                                            <input type="text" name="description" class="form-control" placeholder="{{ old('description') }}" value="{{ old('description') }}">
                                            <span class="help-block"> Descriptions helps people know what your page content will contain. </span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div role="tabpanel" class="tab-pane fade in" id="content">

                        <div class="form form-panel box blue">

                            <div class="heading blue">

                                <div class="title">

                                    <h2>Content Editor</h2>

                                </div>

                            </div>

                            <div class="form-body">
                                <div class="form-horizontal form-bordered form-label-stripped">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Content</label>
                                        <div class="col-xs-10">
                                            <div class="content" id="editor">
                                                <textarea id="tinymce-textarea" name="content">{{ old('content') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div role="tabpanel" class="tab-pane fade in" id="options">

                        <div class="form form-panel box blue">

                            <div class="heading blue">

                                <div class="title">

                                    <h2>Page Options</h2>

                                </div>

                            </div>

                            <div class="form-body">

                                <div class="form-horizontal form-bordered form-label-stripped">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Sitemap</label>
                                        <div class="col-xs-10">
                                            <input type="checkbox" checked data-on-text="True" data-off-text="False" name="sitemap" class="make-switch" {{ old('sitemap_checkbox') }} data-size="small">
                                            <span class="help-block"> Allow this page to create a listing for website search browsers. </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Privacy</label>
                                        <div class="col-xs-10">
                                            <input type="checkbox" checked data-toggle="toggle" data-on="Public" data-off="Private" data-onstyle="success" data-offstyle="danger" name="enabled">
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
                        <button id="btn-cancel" data-redirect="{{ url('/admin/pages') }}" type="button" class="button blue">
                            <i class="fa fa-times"></i> Cancel</button>
                    </div>
                </div>

            </form>

        </div>

    </div>

@endsection