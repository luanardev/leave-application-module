@component('mail::message')
<h2>Dear {{$approver->fullname()}}</h2>

<p>You are hereby notified that <strong>{{$leave->staff->fullname()}}</strong> who works as <strong>{{$leave->staff->employment->getPosition()}}</strong> applied for <strong>{{$leave->getPeriodString()}} {{$leave->leaveType->getName()}}</strong> on {{$leave->appliedDate()}} that requires your Approval.</p>
<p>{{$leave->staff->genderism()}} would like to leave on {{$leave->startDate()}} and return on {{$leave->endDate()}}.</p>
<p>Please <a href="{{route('login')}}">login</a> to your staff account to approve this request. Your assistance will be appreciated.</p>

{{ config('app.name') }}
@endcomponent
