@component('mail::message')
<h2>Dear {{$leave->staff->fullname()}}</h2>

<p>Your <strong>{{$leave->getPeriodString()}} {{$leave->leaveType->getName()}}</strong> Ended on <strong>{{$leave->endDate()}}</strong></p>
<p>Apparently, you did not report for duties as prescribed in the Leave conditions. Please make sure to report for duties in good time.</p>
<p>You can <a href="{{route('login')}}">login</a> to your staff account to check your Leave status.</p>

{{ config('app.name') }}
@endcomponent
