@component('mail::message')
<h2>Dear {{$approver->fullname()}}</h2>

<p>You are hereby notified that <strong>{{$leave->staff->fullname()}}</strong> submitted {{$leave->leaveType->getName()}} Return Request.</p>
<p>Please <a href="{{route('login')}}">login</a> to your staff account to review this request. Your assistance will be appreciated.</p>

{{ config('app.name') }}
@endcomponent
