@component('mail::message')
<h2>Dear {{$staff->fullname()}}</h2>

@if($leave->isApproved())
<p>We are pleased to inform you that your <strong>{{$leave->getPeriodString()}} {{$leave->leaveType->getName()}}</strong> application which you submitted on {{$leave->appliedDate()}} was <strong>Approved</strong>.</p>
<p>Please be reminded that you are supposed to report back for duties on {{$leave->endDate()}}.</p>
<p>You can <a href="{{route('login')}}">login</a> to your staff account to check your application status.</p>
@endif

@if($leave->isRejected())
<p>We regret to inform you that your <strong>{{$leave->getPeriodString()}} {{$leave->leaveType->getName()}}</strong> application which you submitted on {{$leave->appliedDate()}} was <strong>Rejected</strong>.</p>
<p>We are very sorry for any inconveniences this may cause. Please refer this case to your Supervisor for any assistance or clarification on the matter</p>
<p>You can <a href="{{route('login')}}">login</a> to your staff account to check the reason for your application rejection.</p>
@endif

{{ config('app.name') }}
@endcomponent
