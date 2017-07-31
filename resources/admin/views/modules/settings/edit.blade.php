@extends('dashboard::frame')

@section('title')
    <h1>Systemwide Settings</h1>
@endsection

@section('information')
    <p>
        Your application can be modified with straight forward, powerful options that you can change to match your needs.
    </p>
@endsection

@section('content')

    <div class="flex-display">

        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#general" data-toggle="tab" aria-expanded="true"> General </a>
            </li>
            <li class="">
                <a href="#seo" data-toggle="tab" aria-expanded="false"> SEO </a>
            </li>
            <li class="">
                <a href="#contact" data-toggle="tab" aria-expanded="false"> Contact </a>
            </li>
            <li class="">
                <a href="#webmaster" data-toggle="tab" aria-expanded="false"> Webmaster </a>
            </li>
        </ul>

        <div class="form-box blue">

            <form action="{{ route('SaveSettings') }}" method="post">
                {{ csrf_field() }}

                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane fade in active" id="general">

                        <div class="form form-panel">

                            <div class="heading blue">

                                <div class="title">

                                    <h2>General</h2>

                                </div>

                            </div>

                            <div class="form-body">

                                <div class="form-horizontal form-bordered form-label-stripped">
                                    <div class="form-group row">
                                        <label class="col-md-3 control-label">Site Name</label>
                                        <div class="col-xs-10">
                                            <input type="text" name="setting[string][site_name]" class="form-control"
                                                   placeholder="{{ settings()->getShadow('site_name') }}"
                                                   value="{{ settings()->getValue('site_name') }}">
                                            <span class="help-block"> Set the name used as your dashboard and login sitename. </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Disabled Features</label>
                                        <div class="col-xs-10">
                                            <input type="hidden"  name="setting[boolean][feature_hide_disabled]" title="default" value="0">
                                            <input type="checkbox" name="setting[boolean][feature_hide_disabled]" data-on-text="Show" data-off-text="Hide" data-on-color="success" class="make-switch" {{ settings()->getValue('feature_hide_disabled') ? 'checked' : null }} data-size="small">
                                            <span class="help-block"> Remove all disabled features from the sidebar menu. </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Frontend Website</label>
                                        <div class="col-xs-10">
                                            <input type="hidden"  name="setting[boolean][enable_website]" title="default" value="0">
                                            <input type="checkbox" name="setting[boolean][enable_website]" data-on-text="Active" data-off-text="Hidden" data-on-color="success" data-off-color="danger" class="make-switch" {{ settings()->getValue('enable_website') ? 'checked' : null }} data-size="small">
                                            <span class="help-block"> Turn your website on or off, at a click of a button! </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Frontend Breadcrumbs</label>
                                        <div class="col-xs-10">
                                            <input type="hidden"  name="setting[boolean][site_breadcrumbs]" title="default" value="0">
                                            <input type="checkbox" name="setting[boolean][site_breadcrumbs]" data-on-text="Powered" data-off-text="Removed" class="make-switch" {{ settings()->getValue('site_breadcrumbs') ? 'checked' : null }} data-size="small">
                                            <span class="help-block"> Visual representation of the current page in a crumb trail of links. </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Copyright Footer</label>
                                        <div class="col-xs-10">
                                            <input type="text" name="setting[string][website_copyright]"
                                                   class="form-control"
                                                   placeholder="{{ settings()->getShadow('website_copyright') }}"
                                                   value="{{ settings()->getValue('website_copyright') }}">
                                            <span class="help-block"> Display the copyright data for your website. [Symbols : &copy; &reg;]</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane fade in" id="seo">

                        <div class="form form-panel">

                            <div class="heading blue">

                                <div class="title">

                                    <h2>SEO</h2>

                                </div>

                            </div>

                            <div class="form-body">

                                <div class="form-horizontal form-bordered form-label-stripped">

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Search Engine Indexing</label>
                                        <div class="col-xs-10">
                                            <input type="hidden"  name="setting[boolean][search_engine_indexing]" title="default" value="0">
                                            <input type="checkbox" name="setting[boolean][search_engine_indexing]" data-on-text="Public" data-off-text="Private" data-on-color="success" data-off-color="danger" class="make-switch" {{ settings()->getValue('search_engine_indexing') ? 'checked' : null}} data-size="small">
                                            <span class="help-block"> Allow this site to appear in search engine results. </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Append SEO Text</label>
                                        <div class="col-xs-10">
                                            <input type="text" name="setting[string][seo_title_text_append]"
                                                   class="form-control"
                                                   placeholder="{{ settings()->getShadow('seo_title_text_append') }}"
                                                   value="{{ settings()->getValue('seo_title_text_append') }}">
                                            <span class="help-block"> Append text to your pages current name ex. [Example (- Example.com)] </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Append SEO Text
                                            Position </label>
                                        <div class="col-xs-10">
                                            <select class="form-control chosen-select"
                                                    name="setting[select][seo_title_text_position]">

                                                <option value="left" {{ settings()->getValue('seo_title_text_position') == 'left' ? 'selected=true' : null }}>
                                                    Left
                                                </option>
                                                <option value="right" {{ settings()->getValue('seo_title_text_position') == 'right' ? 'selected=true' : null }}>
                                                    Right
                                                </option>

                                            </select>
                                            <span class="help-block"> Do you want this text to be appended (left) or prepended (right) to the page title? </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Append SEO Separator</label>
                                        <div class="col-xs-10">
                                            <input type="text"
                                                   name="setting[string][seo_title_text_seperator]"
                                                   class="form-control"
                                                   placeholder="{{ settings()->getShadow('seo_title_text_seperator') }}"
                                                   value="{{ settings()->getValue('seo_title_text_seperator') }}">
                                            <span class="help-block"> The separator you wish to use between the pagename and the above text </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Default SEO Keywords</label>
                                        <div class="col-xs-10">
                                            <input type="text" name="setting[string][seo_keywords]"
                                                   class="form-control"
                                                   placeholder="{{ settings()->getShadow('seo_keywords') }}"
                                                   value="{{ settings()->getValue('seo_keywords') }}">
                                            <span class="help-block"> Set a global set of Seo Keywords for your page. </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Default SEO Description</label>
                                        <div class="col-xs-10">
                                            <input type="text" name="setting[string][seo_description]"
                                                   class="form-control"
                                                   placeholder="{{ settings()->getShadow('seo_description') }}"
                                                   value="{{ settings()->getValue('seo_description') }}">
                                            <span class="help-block"> Set a global description for your page. </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane fade in" id="contact">

                        <div class="form form-panel">

                            <div class="heading blue">

                                <div class="title">

                                    <h2>Contact</h2>

                                </div>

                            </div>

                            <div class="form-body">

                                <div class="form-horizontal form-bordered form-label-stripped">

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Address, Line 1</label>
                                        <div class="col-xs-10">
                                            <input type="text" name="setting[string][address_name]" class="form-control"
                                                   placeholder="{{ settings()->getShadow('address_name') }}"
                                                   value="{{ settings()->getValue('address_name') }}">
                                            <span class="help-block"> Postal business name or building </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Address, Line 2</label>
                                        <div class="col-xs-10">
                                            <input type="text" name="setting[string][address_location]"
                                                   class="form-control"
                                                   placeholder="{{ settings()->getShadow('address_location') }}"
                                                   value="{{ settings()->getValue('address_location') }}">
                                            <span class="help-block"> Postal street address or location </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Address, Line 3</label>
                                        <div class="col-xs-10">
                                            <input type="text" name="setting[string][address_county]"
                                                   class="form-control"
                                                   placeholder="{{ settings()->getShadow('address_county') }}"
                                                   value="{{ settings()->getValue('address_county') }}">
                                            <span class="help-block"> Postal county and country </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Telephone Number</label>
                                        <div class="col-xs-10">
                                            <input type="text" name="setting[string][phone_number]" class="form-control"
                                                   value="{{ settings()->getValue('phone_number') }}"
                                                    placeholder="{{ settings()->getShadow('phone_number') }}">
                                            <span class="help-block"> Allow visitors to contact you with a callable number </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Faxable Number</label>
                                        <div class="col-xs-10">
                                            <input type="text" name="setting[string][fax_number]" class="form-control"
                                                   value="{{ settings()->getValue('fax_number') }}"
                                                    placeholder="{{ settings()->getShadow('fax_number') }}">
                                            <span class="help-block"> Accept invoices and other items with a faxable number </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Email Address</label>
                                        <div class="col-xs-10">
                                            <input type="text" name="setting[string][email_address]"
                                                   class="form-control"
                                                   placeholder="{{ settings()->getShadow('email_address') }}"
                                                   value="{{ settings()->getValue('email_address') }}">
                                            <span class="help-block"> Accept emails from visitors who might view your site</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane fade in" id="webmaster">

                        <div class="form form-panel">

                            <div class="heading blue">

                                <div class="title">

                                    <h2>Webmaster</h2>

                                </div>

                            </div>

                            <div class="form-body">

                                <div class="form-horizontal form-bordered form-label-stripped">

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Google Tracking ID</label>
                                        <div class="col-xs-10">
                                            <input type="text" name="setting[string][google_analitycs_code]"
                                                   class="form-control"
                                                   placeholder="{{ settings()->getShadow('google_analitycs_code') }}"
                                                   value="{{ settings()->getValue('google_analitycs_code') }}">
                                            <span class="help-block"> Google analytics requires a special ID which profiles your site. </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Google Project ID</label>
                                        <div class="col-xs-10">
                                            <input type="text" name="setting[string][google_project_id]"
                                                   class="form-control"
                                                   placeholder="{{ settings()->getShadow('google_project_id') }}"
                                                   value="{{ settings()->getValue('google_project_id') }}">
                                            <span class="help-block"> Google Project ID is the required code for google analytics display. </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Google Webmaster Code</label>
                                        <div class="col-xs-10">
                                            <input type="text" name="setting[string][google_webmaster_code]"
                                                   class="form-control"
                                                   placeholder="{{ settings()->getShadow('google_webmaster_code') }}"
                                                   value="{{ settings()->getValue('google_webmaster_code') }}">
                                            <span class="help-block"> Google Webmaster tools allow this site to properly manage pages with Google Search Engine. </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Bing Webmaster Code</label>
                                        <div class="col-xs-10">
                                            <input type="text" name="setting[string][bing_webmaster_code]"
                                                   class="form-control"
                                                   placeholder="{{ settings()->getShadow('bing_webmaster_code') }}"
                                                   value="{{ settings()->getValue('bing_webmaster_code') }}">
                                            <span class="help-block"> Bing Webmaster tools allow this site to properly manage pages with Bing Search Engine. </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Facebook Page ID</label>
                                        <div class="col-xs-10">
                                            <input type="text" name="setting[string][fb_page_id]"
                                                   class="form-control"
                                                   placeholder="{{ settings()->getShadow('fb_page_id') }}"
                                                   value="{{ settings()->getValue('fb_page_id') }}">
                                            <span class="help-block"> Provide public access to this platform by providing your facebook page id.<br>
                                                                      You can retrieve your facebook id following this link : <a href="http://findmyfbid.com/" target="_blank">findmyfbid.com</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-actions" id="vue-buttons">
                    <div class="row">
                        <button type="submit" name="submit"class="button blue">
                            <i class="fa fa-check"></i> Submit</button>
                        <button v-on:click="refreshPage" name="refresh" type="button" class="button blue" >
                            <i class="fa fa-refresh"></i> Restart</button>
                    </div>
                </div>

            </form>

        </div>

    </div>

@endsection