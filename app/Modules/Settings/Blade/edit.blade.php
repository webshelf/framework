@extends('dashboard::frame')

@section('title')
    Settings
@endsection

@section('information')
    Your application can be modified with straight forward, powerful options that you can change to match your needs.
@endsection

@section('content')

    <style>
        .form-group label {
            font-weight: 600;
        }
    </style>

    <div id="settings" data-children=".item">

        <div id="website">
            <div class="row">
                <div class="col-11">
                    <h4>Website Settings</h4>
                    <p>Update your project name, description, avatar, and other general settings.</p>
                </div>
                <div class="col-1">
                    <button class="btn" data-toggle="collapse" data-parent="#settings" href="#website-settings" aria-controls="website-settings">Expand</button>
                </div>
            </div>

            <div id="website-settings" class="collapse item container" role="tabpanel">
                <div class="form-group">
                    <label for="setting[string][site_name]">Website Name</label>
                    <input type="text" class="form-control" name="setting[string][site_name]" id="websiteName" aria-describedby="websiteNameHelp" placeholder="">
                    <small id="websiteNameHelp" class="form-text text-muted">The name of your website.</small>
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
                    <button class="btn" data-toggle="collapse" data-parent="#settings" href="#page-settings" aria-controls="page-settings">Expand</button>
                </div>
            </div>

            <div id="page-settings" class="collapse item container" role="tabpanel">
                <div class="form-group">
                    <label for="setting[string][seo_keywords]">Default Page Keywords</label>
                    <input type="text" class="form-control" name="setting[string][seo_keywords]" id="setting[string][seo_keywords]" aria-describedby="defaultPageKeywordsHelp" placeholder="">
                    <small id="defaultPageKeywordsHelp" class="form-text text-muted">This is the default set of keywords used on pages without keywords set.</small>
                </div>

                <div class="form-group">
                    <label for="setting[string][seo_description]">Default Page Description</label>
                    <input type="text" class="form-control" name="setting[string][seo_description]" id="setting[string][seo_description]" aria-describedby="defaultPageDescriptionHelp" placeholder="">
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
                    <button class="btn" data-toggle="collapse" data-parent="#settings" href="#seo-settings" aria-controls="seo-settings">Expand</button>
                </div>
            </div>

            <div id="seo-settings" class="collapse item container" role="tabpanel">
                <div class="form-group">
                    <label for="setting[string][seo_title_text_append]">SEO Text</label>
                    <input type="text" class="form-control" name="setting[string][seo_title_text_append]" id="setting[string][seo_title_text_append]" aria-describedby="seoTextHelp" placeholder="">
                    <small id="seoTextHelp" class="form-text text-muted">Append additional text to your website pages, globally.</small>
                </div>

                <div class="form-group">
                    <label for="setting[select][seo_title_text_position]">Append Text Position</label>
                    <select class="form-control" name="seoTextPosition" id="setting[select][seo_title_text_position]" aria-describedby="seoTextPositionHelp">
                        <option>Left</option>
                        <option>Right</option>
                    </select>
                    <small id="seoTextPositionHelp" class="form-text text-muted">Append the text to which side of the page name.</small>
                </div>

                <div class="form-group">
                    <label for="setting[string][seo_title_text_seperator]">Text Seperator</label>
                    <input type="text" class="form-control" name="setting[string][seo_title_text_seperator]" id="setting[string][seo_title_text_seperator]" aria-describedby="textSeperatorHelp" placeholder="">
                    <small id="textSeperatorHelp" class="form-text text-muted">Seperate the text with the page name with an symbol or character.</small>
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
                    <button class="btn" data-toggle="collapse" data-parent="#settings" href="#contact-settings" aria-controls="contact-settings">Expand</button>
                </div>
            </div>

            <div id="contact-settings" class="collapse item container" role="tabpanel">
                <div class="form-group">
                    <label for="setting[string][address]">Address</label>
                    <textarea class="form-control" name="setting[string][address]" id="setting[string][address]" rows="3" aria-describedby="addressHelp"></textarea>
                    <small id="addressHelp" class="form-text text-muted">Visitors can use this address to find your location.</small>
                </div>

                <div class="form-group">
                    <label for="setting[string][phone_number]">Telephone Number</label>
                    <input class="form-control" type="text" name="setting[string][phone_number]" id="setting[string][phone_number]" aria-describedby="telephoneHelp">
                    <small id="telephoneHelp" class="form-text text-muted">Users can use this number to get in contact with you.</small>
                </div>

                <div class="form-group">
                    <label for="setting[string][fax_number]">Fax Number</label>
                    <input type="text" class="form-control" name="setting[string][fax_number]" id="setting[string][fax_number]" aria-describedby="faxNumberHelp" placeholder="">
                    <small id="faxNumberHelp" class="form-text text-muted">Users can use this number to send fax messages to you.</small>
                </div>

                <div class="form-group">
                    <label for="setting[string][email_address]">Email Address</label>
                    <input type="email" class="form-control" name="setting[string][email_address]" id="setting[string][email_address]" aria-describedby="emailAddressHelp" placeholder="">
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
                    <button class="btn" data-toggle="collapse" data-parent="#settings" href="#webmaster-settings" aria-controls="webmaster-settings">Expand</button>
                </div>
            </div>

            <div id="webmaster-settings" class="collapse item" role="tabpanel">
                <div class="form-group">
                    <label for="setting[string][fb_page_id]">Facebook Page ID</label>
                    <input type="text" class="form-control" name="setting[string][fb_page_id]" id="setting[string][fb_page_id]" aria-describedby="facebookPageIdHelp" placeholder="">
                    <small id="facebookPageIdHelp" class="form-text text-muted">
                        Provide public access to this platform by providing your facebook page id. <br>
                        You can retrieve your facebook id following this link : findmyfbid.com
                    </small>
                </div>
            </div>
        </div>

    </div>

@endsection