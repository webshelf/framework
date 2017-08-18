@extends('dashboard::frame')

@section('content')

    <div class="note note-success">
        <h3>Information to the Masses</h3>
        <p>Articles are a great way to provide a daily blog of information, giving users a reason to come back to explore new content.</p>
    </div>

    <form action="{{ route('UpdateNews', $article->slug()) }}" method="post" id="form_page">

        <div class="portlet light ">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-share font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase">Editing the News Article : {{ $article->title() }}</span>
                </div>
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#portlet_tab1" data-toggle="tab" aria-expanded="true"> Publish Tools </a>
                    </li>
                    <li class="">
                        <a href="#portlet_tab2" data-toggle="tab" aria-expanded="false"> Article Editor</a>
                    </li>
                    <li class="">
                        <a href="#portlet_tab3" data-toggle="tab" aria-expanded="false"> SEO Editor</a>
                    </li>
                </ul>
            </div>


            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="portlet_tab1">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Publisher</label>
                                <div class="col-md-9">
                                    <input type="text" name="publisher_name" class="form-control" readonly value="{{ account()->fullName() }}">
                                    <span class="help-block"> The account that is publishing the article. </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Title</label>
                                <div class="col-md-9">
                                    <input type="text" name="title" class="form-control" placeholder="" value="{{ old('title') ?: $article->title() }}">
                                    <span class="help-block"> Summarize the Article Post in an easy to read manner. </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Defined Post Date</label>
                                <div class="col-md-9">
                                    <div class="input-group date form_datetime" data-date="2012-12-21T15:25:00Z">
                                        <input type="text" name="defined_date" size="16" class="form-control" value="{{ old('date') }}">
                                        <span class="help-block"> Control the date at which the post was created at, by default this is set to the current time. (Default: Leave Blank)</span>
                                    </div>
                                </div>

                                <script type="text/javascript">
                                    $(function() {
                                        $('input[name="defined_date"]').datetimepicker({
                                            'ShowClear' : true
                                        });
                                    });
                                </script>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="portlet_tab2">
                        <textarea id="summernote" name="content">{{ old('content') ?: $article->content() }}</textarea>
                        <script>
                            $(document).ready(function() {
                                $('#summernote').summernote({
                                    minHeight: 350,
                                    focus: true                  // set focus to editable area after initializing summernote
                                });
                            });
                        </script>
                    </div>

                    <div class="tab-pane" id="portlet_tab3">

                        <div class="alert alert-info" style="margin-bottom: 25px;">
                            <strong>Wait!; </strong> This is for fine tuning and are automatically created if empty.
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">SEO Title</label>
                            <div class="col-md-9">
                                <input type="text" name="seo_title" class="form-control" value="{{ old('seo_title') ?: $article->seo_title() }}">
                                <span class="help-block"> Keywords help people who try search for your website through google. </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">SEO Keywords</label>
                            <div class="col-md-9">
                                <input type="text" name="seo_keywords" class="form-control" value="{{ old('seo_keywords') ?: $article->seo_keywords() }}">
                                <span class="help-block"> Keywords help people who try search for your website through google. </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">SEO Description</label>
                            <div class="col-md-9">
                                <input type="text" name="seo_description" class="form-control" value="{{ old('seo_description') ?: $article->seo_description() }}">
                                <span class="help-block"> Keywords help people who try search for your website through google. </span>
                            </div>
                        </div>

                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6 col-sm-6">

                            <button type="submit" class="btn btn-default" id="save">
                                Save and Exit
                            </button>

                            <button type="button" class="btn btn-default" id="btn-refresh">
                                Restart
                            </button>

                        </div>

                    </div>

                </div>
            </div>

        </div>

    </form>

@endsection