@component('mail::message')
<h2>Dear {{$staff->fullname()}}</h2>

<p>Your <strong>{{$leave->getPeriodString()}} {{$leave->leaveType->getName()}}</strong> application which you submitted on <strong>{{$leave->appliedDate()}}</strong> was received.</p>
<p>Please wait for feedback as this application is being processed. It may take up to three working days to complete the application review and provide feedback.</p>
<p>You can <a href="{{route('login')}}">login</a> to your staff account to check your application status.</p>

{{ config('app.name') }}
@endcomponent
