@component('mail::message')    
<p>Hi {{$user->first_name}},</p>
<p>A reset password request was received for your MAYC account.</p>
<p>Your new password is: <b>{{$password}}</b></p><br>
<p>Once you are logged in, you can go to <b>My Profile> Change Password</b> to set a new password on the account.</p><br>
<p>Kind Regards,</p>
<p>MAYC Team</p>
@endcomponent
