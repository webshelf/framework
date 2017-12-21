@extends('dashboard::frame')

@section('title')
    Settings
@endsection

@section('information')
    Your application can be modified with straight forward, powerful options that you can change to match your needs.
@endsection

@section('content')

    <script type="text/javascript" src="/packages/barryvdh/elfinder/js/standalonepopup.min.js"></script>

    <style>
        .form-group label {
            font-weight: 600;
        }
    </style>

    <form method="post" action="{{ route('admin.settings.update') }}">

        {{ csrf_field() }}

        <div id="settings" data-children=".item">

            <div id="website">
                <div class="row">
                    <div class="col-11">
                        <h4>Website Settings</h4>
                        <p>Update your project name, description, avatar, and other general settings.</p>
                    </div>
                    <div class="col-1">
                        <button class="btn" type="button" data-toggle="collapse" data-parent="#settings" href="#website-settings" aria-controls="website-settings">Expand</button>
                    </div>
                </div>

                <div id="website-settings" class="collapse item container" role="tabpanel">
                    <div class="form-group">
                        <label for="setting[string][website_name]">Website Name</label>
                        <input type="text" class="form-control" name="setting[string][website_name]" id="websiteName" aria-describedby="websiteNameHelp" placeholder="{{ settings()->getShadow('website_name') }}" value="{{ settings()->getValue('website_name') }}">
                        <small id="websiteNameHelp" class="form-text text-muted">The name of your website.</small>
                    </div>
                    <div class="form-group">
                        <label for="setting[string][website_copyright]">Website Copyright</label>
                        <input type="text" class="form-control" name="setting[string][website_copyright]" id="setting[string][website_copyright]" aria-describedby="helpId" placeholder="{{ settings()->getShadow('website_copyright') }}" value="{{ settings()->getValue('website_copyright') }}">
                        <small id="helpId" class="form-text text-muted">Display the copyright license for your website.</small>
                    </div>
                    <div class="form-group">
                        <label for="setting[boolean][maintenance_mode]">Website Status</label>
                        <select class="form-control" name="setting[boolean][maintenance_mode]" id="setting[boolean][maintenance_mode]">
                            <option value="1" {{ settings()->getValue('maintenance_mode') == true ? 'selected' : 'null' }}>Offline</option>
                            <option value="0" {{ settings()->getValue('maintenance_mode') == false ? 'selected' : 'null' }}>Online</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="setting[string][website_logo]">Website Logo</label>
                        <div class="input-group">
                            <div class="input-group">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary popup_selector" data-inputid="website_logo" type="button">Choose Website Logo</button>
                            </span>
                                <input id="website_logo" type="text" class="form-control" name="setting[string][website_logo]" value="{{ settings()->getDefault('website_logo') }}">
                            </div>
                        </div>
                        <small id="helpId" class="form-text text-muted">Logo that represents your website. (URL is relative to the domain)</small>
                    </div>
                </div>

            </div>

            <hr>

            <div id="page">
                <div class="row">
                    <div class="col-11">
                        <h4>Page Settings</h4>
                        <p>Control settings regarding your front end pages.</p>
                    </div>
                    <div class="col-1">
                        <button class="btn" type="button" data-toggle="collapse" data-parent="#settings" href="#page-settings" aria-controls="page-settings">Expand</button>
                    </div>
                </div>

                <div id="page-settings" class="collapse item container" role="tabpanel">
                    <div class="form-group">
                        <label for="setting[string][page_keywords]">Default Page Keywords</label>
                        <input type="text" class="form-control" name="setting[string][page_keywords]" id="setting[string][page_keywords]" aria-describedby="defaultPageKeywordsHelp" placeholder="{{ settings()->getShadow('page_keywords') }}" value="{{ settings()->getValue('page_keywords') }}">
                        <small id="defaultPageKeywordsHelp" class="form-text text-muted">This is the default set of keywords used on pages without keywords set.</small>
                    </div>

                    <div class="form-group">
                        <label for="setting[string][page_description]">Default Page Description</label>
                        <input type="text" class="form-control" name="setting[string][page_description]" id="setting[string][page_description]" aria-describedby="defaultPageDescriptionHelp" placeholder="{{ settings()->getShadow('page_description') }}" value="{{ settings()->getValue('page_description') }}">
                        <small id="defaultPageDescriptionHelp" class="form-text text-muted">This is the default description used on pages without a description.</small>
                    </div>
                </div>
            </div>

            <hr>

            <div id="seo">
                <div class="row">
                    <div class="col-11">
                        <h4>SEO Settings</h4>
                        <p>Search engine optimization settings allow you to control the interaction with google, yahoo & bing.</p>
                    </div>
                    <div class="col-1">
                        <button class="btn" type="button"  data-toggle="collapse" data-parent="#settings" href="#seo-settings" aria-controls="seo-settings">Expand</button>
                    </div>
                </div>

                <div id="seo-settings" class="collapse item container" role="tabpanel">
                    <div class="form-group">
                        <label for="setting[string][seo_text]">SEO Text</label>
                        <input type="text" class="form-control" name="setting[string][seo_text]" id="setting[string][seo_text]" aria-describedby="seoTextHelp" placeholder="{{ settings()->getShadow('seo_text') }}" value="{{ settings()->getValue('seo_text') }}">
                        <small id="seoTextHelp" class="form-text text-muted">Append additional text to your website pages, globally.</small>
                    </div>

                    <div class="form-group">
                        <label for="setting[select][seo_position]">Append Text Position</label>
                        <select class="form-control" name="setting[select][seo_position]" id="setting[select][seo_position]" aria-describedby="seoTextPositionHelp">
                            <option value="left" {{ settings()->getValue('seo_position') == 'left' ? 'selected' : 'null' }}>Left</option>
                            <option value="right" {{ settings()->getValue('seo_position') == 'right' ? 'selected' : 'null' }}>Right</option>
                        </select>
                        <small id="seoTextPositionHelp" class="form-text text-muted">Append the text to which side of the page name.</small>
                    </div>

                    <div class="form-group">
                        <label for="setting[string][seo_separator]">Text Seperator</label>
                        <input type="text" class="form-control" name="setting[string][seo_separator]" id="setting[string][seo_separator]" aria-describedby="textSeperatorHelp" placeholder="{{ settings()->getShadow('seo_separator') }}" value="{{ settings()->getValue('seo_separator') }}">
                        <small id="textSeperatorHelp" class="form-text text-muted">Seperate the text with the page name with an symbol or character.</small>
                    </div>

                    <div class="form-group">
                        <label for="setting[boolean][seo_indexing]">Allow search engine indexing</label>
                        <select class="form-control" name="setting[boolean][seo_indexing]" id="setting[boolean][seo_indexing]">
                            <option value="0" {{ settings()->getValue('seo_indexing') == '0' ? 'selected' : 'null' }}>Deny</option>
                            <option value="1" {{ settings()->getValue('seo_indexing') == '1' ? 'selected' : 'null' }}>Allow</option>
                        </select>
                    </div>
                </div>
            </div>

            <hr>

            <div id="contact">
                <div class="row">
                    <div class="col-11">
                        <h4>Contact Settings</h4>
                        <p>Contact settings allow you to modify your current details or allow new ways for your visitors to get in touch.</p>
                    </div>
                    <div class="col-1">
                        <button class="btn" type="button"  data-toggle="collapse" data-parent="#settings" href="#contact-settings" aria-controls="contact-settings">Expand</button>
                    </div>
                </div>

                <div id="contact-settings" class="collapse item container" role="tabpanel">
                    <div class="form-group">
                        <label for="setting[string][address]">Address</label>
                        <textarea class="form-control" name="setting[string][address]" id="setting[string][address]" rows="3" aria-describedby="addressHelp">{{ settings()->getValue('address') }}</textarea>
                        <small id="addressHelp" class="form-text text-muted">Visitors can use this address to find your location.</small>
                    </div>

                    <div class="form-group">
                        <label for="setting[string][phone_number]">Telephone Number</label>
                        <input class="form-control" type="text" name="setting[string][phone_number]" id="setting[string][phone_number]" aria-describedby="telephoneHelp" value="{{ settings()->getValue('phone_number') }}">
                        <small id="telephoneHelp" class="form-text text-muted">Users can use this number to get in contact with you.</small>
                    </div>

                    <div class="form-group">
                        <label for="setting[string][fax_number]">Fax Number</label>
                        <input type="text" class="form-control" name="setting[string][fax_number]" id="setting[string][fax_number]" aria-describedby="faxNumberHelp" value="{{ settings()->getValue('fax_number') }}">
                        <small id="faxNumberHelp" class="form-text text-muted">Users can use this number to send fax messages to you.</small>
                    </div>

                    <div class="form-group">
                        <label for="setting[string][email_address]">Email Address</label>
                        <input type="email" class="form-control" name="setting[string][email_address]" id="setting[string][email_address]" aria-describedby="emailAddressHelp" value="{{ settings()->getValue('email_address') }}"">
                        <small id="emailAddressHelp" class="form-text text-muted">Users can use this email address to send emails to you.</small>
                    </div>
                </div>
            </div>

            <hr>

            <div id="webmaster">
                <div class="row">
                    <div class="col-11">
                        <h4>Webmaster Settings</h4>
                        <p>Control third party aspects of your website.</p>
                    </div>
                    <div class="col-1">
                        <button class="btn" type="button" data-toggle="collapse" data-parent="#settings" href="#webmaster-settings" aria-controls="webmaster-settings">Expand</button>
                    </div>
                </div>

                <div id="webmaster-settings" class="collapse item" role="tabpanel">
                    <div class="form-group">
                        <label for="setting[string][facebook_id]">Facebook Page ID</label>
                        <input type="text" class="form-control" name="setting[string][facebook_id]" id="setting[string][facebook_id]" aria-describedby="facebookPageIdHelp" value="{{ settings()->getValue('facebook_id') }}">
                        <small id="facebookPageIdHelp" class="form-text text-muted">
                            Provide public access to this platform by providing your facebook page id. <br>
                            You can retrieve your facebook id following this link : findmyfbid.com
                        </small>
                    </div>
                </div>
            </div>

        </div>

        <div class="form-actions">

            <button type="submit" class="btn btn-update">Save Latest Changes</button>

            <div class="pull-right">
                <button type="reset" class="btn btn-reset">Reset</button>
                <a href="{{ route('admin.settings.index') }}" class="btn btn-cancel">Cancel</a>
            </div>
        </div>

    </form>
@endsection