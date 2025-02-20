<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
</head>

<body>
    <p>{{ $intro }}</p>

    <div>
        <p>Thank you for your subscriptions to Miti Magazine, the tree farmers magazine for Africa!</p>
        <p>Kindly find hereunder the link to your account.</p>
        <p>@if($password != '')
            An account has been set-up for you with password: {{$password}}
            Your password i
        @endif
        </p>

        <p>From there, you will be able to invite members of your choice:,</p>

           <p><a href="https://miti-magazine.betterglobeforestry.com">Log on to your account</a> &#x3e; Manage Account &#x3e; Invite Others &#x2192; Invite Member</p>

           <p> Add their Name, Email, select the plan you wish to invite them and click send Invite.</p>
           <p>They will receive an e-mail with the link to their digital subscription.</p>

        <p>If you have questions, please forward to Miti-magazine@betterglobeforestry.com or call 0719619006.</p>
        <small class="text-sm">
            Thanks,<br>
            Enjoy!<br>
            Miti Magazine Team<br>
            Better Globe Forestry LTD.
        </small>
        <br>
        <hr style="color:#e6e6e6" />
        <p style="color:#e6e6e6"><small>This email has been sent to you as a registered member of <a href="https://betterglobeforestry.com" style="color:#e6e6e6">betterglobeforestry.com</a></small></p>
        <p style="color:#e6e6e6"><small>&copy; {{ \Carbon\Carbon::now()->format('Y') }} Copyright Better Globe Forestry LTD. All rights reserved.</small></p>
    </div>
</body>

</html>