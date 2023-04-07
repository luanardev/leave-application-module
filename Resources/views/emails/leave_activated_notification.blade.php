@component('mail::message')
<h2>Dear {{$leave->staff->fullname()}}</h2>

<p>Your <strong>{{$leave->getPeriodString()}} {{$leave->leaveType->getName()}}</strong> was Activated. You are now officially on Leave.</p>
<p>You can <a href="{{route('login')}}">login</a> to your staff account to check your Leave status.</p>

{{ config('app.name') }}
@endcomponent
