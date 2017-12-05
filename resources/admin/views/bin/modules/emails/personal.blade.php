
<p>Hello {{ ($email->to->forename() != '') ? $email->to->forename() : '' }}!</p>

<p>Your account has been successfully created and is ready for use, on our Coffeebreak CMS Platform.</p>

@if($email->to->password() != '')
    <p>Your password has already been assigned and can be retrieved by contacting {{ account()->fullName() }} at {{ account()->email() }}</p>
@else
    <p>Once you have clicked the link below, you will then be asked to create your new password, this will be used along with your email.</p>
@endif

<p>Please use the link below to automatically verify your account with us.</p>

<p><a href="{!! route('AccountVerify', $email->content['link']) !!}">Verify my account</a></p>

<p>Best regards,<br /> Coffeebreak CMS</p>
