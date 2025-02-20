@component('mail::message')
# Dear {{$invite->name}}

You have been given a subscription to Miti Magazine online by {{$customer->name}} from {{$customer->company}}

@if($password != '')
An account has been set-up for you
Your password is <h4>{{$password}}<h4>.
@endif

To get access to your magazines kindly click hereunder

@component('mail::button', ['url' => route('user.subscribed.magazines')])
 Get started
@endcomponent

Welcome to the Miti Magazine online subscribers.

<small class="text-sm">
Enjoy the reading!<br>
Miti Magazine Team<br>
Better Globe Forestry LTD. 
</small>

@endcomponent
