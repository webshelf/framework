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
                        <h4>Application Settings</h4>
                        <p>Modify the settings of your CMS Application..</p>
                    </div>
                    <div class="col-1">
                        <button class="btn" type="button" data-toggle="collapse" data-parent="#settings" href="#website-settings" aria-controls="website-settings">Expand</button>
                    </div>
                </div>

                <div id="website-settings" class="collapse item container" role="tabpanel">
                    <div class="form-group">
                        <label for="setting[app.name]">Application Name</label>
                        <input type="text" class="form-control" name="setting[app.name]" id="websiteName" aria-describedby="websiteNameHelp" value="{{ config('app.name') }}" required>
                        <small id="websiteNameHelp" class="form-text text-muted">{{ App\Model\Configuration::describe('app.name') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="setting[app.mode]">Application Mode</label>
                        <select class="form-control" name="setting[app.mode]" id="setting[maintenance_mode]" required>
                            <option value="normal" {{ config('app.mode') == 'normal' ? 'selected' : 'null' }}>Normal</option>
                            <option value="maintenance" {{ config('app.mode') == 'maintenance' ? 'selected' : 'null' }}>Maintenance</option>
                        </select>
                        <small id="websiteModeHelp" class="form-text text-muted">{{ App\Model\Configuration::describe('app.mode') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="setting[app.logo]">Application Logo</label>
                        <div class="input-group">
                            <div class="input-group">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary popup_selector" data-inputid="app_logo" type="button">Choose App Logo</button>
                            </span>
                                <input id="app_logo" type="text" class="form-control" name="setting[app.logo]" value="{{ config('app.logo') }}" required>
                            </div>
                        </div>
                        <small id="helpId" class="form-text text-muted">{{ App\Model\Configuration::describe('app.logo') }}</small>
                    </div>
                </div>

            </div>

            <hr>

            <div id="page">
                <div class="row">
                    <div class="col-11">
                        <h4>HTML Tag Settings</h4>
                        <p>Control the settings that make up the html tag of your website.</p>
                    </div>
                    <div class="col-1">
                        <button class="btn" type="button" data-toggle="collapse" data-parent="#settings" href="#page-settings" aria-controls="page-settings">Expand</button>
                    </div>
                </div>

                <div id="page-settings" class="collapse item container" role="tabpanel">
                    <div class="form-group">
                        <label for="setting[website.tag.title.text]">Append HTML Tag Title</label>
                        <input type="text" class="form-control" name="setting[website.tag.title.text]" id="setting[website.tag.title.text]" aria-describedby="seoTextHelp" value="{{ config('website.tag.title.text') }}">
                        <small id="seoTextHelp" class="form-text text-muted">{{ App\Model\Configuration::describe('website.tag.title.text') }}</small>
                    </div>

                    <div class="form-group">
                        <label for="setting[website.tag.keywords.default]">Default Page Keywords</label>
                        <input type="text" class="form-control" name="setting[website.tag.keywords.default]" id="setting[website.tag.keywords.default]" aria-describedby="defaultPageKeywordsHelp" value="{{ config('website.tag.keywords.default') }}">
                        <small id="defaultPageKeywordsHelp" class="form-text text-muted">{{ App\Model\Configuration::describe('website.tag.keywords.default') }}</small>
                    </div>

                    <div class="form-group">
                        <label for="setting[website.tag.description.default]">Default Page Description</label>
                        <input type="text" class="form-control" name="setting[website.tag.description.default]" id="setting[website.tag.description.default]" aria-describedby="defaultPageDescriptionHelp" value="{{ config('website.tag.description.default') }}">
                        <small id="defaultPageDescriptionHelp" class="form-text text-muted">{{ App\Model\Configuration::describe('website.tag.description.default') }}</small>
                    </div>

                    <div class="form-group">
                        <label for="setting[website.tag.title.position]">Append HTML Tag title to Position</label>
                        <select class="form-control" name="setting[website.tag.title.position]" id="setting[website.tag.title.position]" aria-describedby="seoTextPositionHelp">
                            <option value="left" {{ config('website.tag.title.position') == 'left' ? 'selected' : 'null' }}>Left</option>
                            <option value="right" {{ config('website.tag.title.position') == 'right' ? 'selected' : 'null' }}>Right</option>
                        </select>
                        <small id="seoTextPositionHelp" class="form-text text-muted">{{ App\Model\Configuration::describe('website.tag.title.position') }}</small>
                    </div>

                    <div class="form-group">
                        <label for="setting[website.tag.title.separator]">Append Separator to HTML Tag Title</label>
                        <input type="text" class="form-control" name="setting[website.tag.title.separator]" id="setting[website.tag.title.separator]" aria-describedby="textSeperatorHelp" value="{{ config('website.tag.title.separator') }}">
                        <small id="textSeperatorHelp" class="form-text text-muted">{{ App\Model\Configuration::describe('website.tag.title.separator') }}</small>
                    </div>
                </div>
            </div>

            <hr>

            <div id="contact">
                <div class="row">
                    <div class="col-11">
                        <h4>Website Contact Details</h4>
                        <p>Define the details on your website that allows visitors to get in touch.</p>
                    </div>
                    <div class="col-1">
                        <button class="btn" type="button"  data-toggle="collapse" data-parent="#settings" href="#contact-settings" aria-controls="contact-settings">Expand</button>
                    </div>
                </div>

                <div id="contact-settings" class="collapse item container" role="tabpanel">
                    <div class="form-group">
                        <label for="setting[website.contact.address]">Address</label>
                        <textarea class="form-control" name="setting[website.contact.address]" id="setting[website.contact.address]" rows="3" aria-describedby="addressHelp">{{ config('website.contact.address') }}</textarea>
                        <small id="addressHelp" class="form-text text-muted">{{ App\Model\Configuration::describe('website.contact.address') }}</small>
                    </div>

                    <div class="form-group">
                        <label for="setting[website.contact.phone]">Telephone Number</label>
                        <input class="form-control" type="text" name="setting[website.contact.phone]" id="setting[website.contact.phone]" aria-describedby="telephoneHelp" value="{{ config('website.contact.phone') }}">
                        <small id="telephoneHelp" class="form-text text-muted">{{ App\Model\Configuration::describe('website.contact.phone') }}</small>
                    </div>

                    <div class="form-group">
                        <label for="setting[website.contact.fax]">Fax Number</label>
                        <input type="text" class="form-control" name="setting[website.contact.fax]" id="setting[website.contact.fax]" aria-describedby="faxNumberHelp" value="{{ config('website.contact.fax') }}">
                        <small id="faxNumberHelp" class="form-text text-muted">{{ App\Model\Configuration::describe('website.contact.fax') }}</small>
                    </div>

                    <div class="form-group">
                        <label for="setting[website.contact.email]">Email Address</label>
                        <input type="email" class="form-control" name="setting[website.contact.email]" id="setting[website.contact.email]" aria-describedby="emailAddressHelp" value="{{ config('website.contact.email') }}">
                        <small id="emailAddressHelp" class="form-text text-muted">{{ App\Model\Configuration::describe('website.contact.email') }}</small>
                    </div>
                </div>
            </div>

            <hr>

            <div id="webmaster">
                <div class="row">
                    <div class="col-11">
                        <h4>Third Party Services</h4>
                        <p>Integrate interaction from third party services such as google, facebook etc.</p>
                    </div>
                    <div class="col-1">
                        <button class="btn" type="button" data-toggle="collapse" data-parent="#settings" href="#webmaster-settings" aria-controls="webmaster-settings">Expand</button>
                    </div>
                </div>

                <div id="webmaster-settings" class="collapse item" role="tabpanel">
                    <div class="form-group">
                        <label for="setting[website.webmaster.google.tracking]">Google Site Tag</label>
                        <input type="text" class="form-control" name="setting[website.webmaster.google.tracking]" id="setting[website.webmaster.google.tracking]" aria-describedby="googleHelp" value="{{ config('website.webmaster.google.tracking') }}">
                        <small id="googleHelp" class="form-text text-muted">{{ App\Model\Configuration::describe('website.webmaster.google.tracking') }}</small>
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
