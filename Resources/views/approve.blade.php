@extends('leaveapplication::layouts.app')

@section('content')

    <div class="container-fluid">

        <div class="content-header">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Application Approval</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('leave_application.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Approval</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="content">

            <div class="row">
                <div class="col-lg-9">
                    <livewire:leaveapplication::leave-approval
                        :leave="$leave"
                        :approver="$staff"
                    />
                </div>

                <div class="col-lg-3">
                    <livewire:leaveapplication::leave-days
                        :staff="$staff"
                        :financialYear="$financialYear"
                        :leaveType="$leaveType"
                    />
                </div>
            </div>
        </div>
    </div>

@endsection

