@extends('leaveapplication::layouts.app')

@section('content')

    <div class="container-fluid">

        <div class="content-header">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Apply For Leave</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('leave_application.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Apply</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="row">
                <div class="col-lg-9">
                    <livewire:leaveapplication::leave-form
                        :staff="$staff"
                        :financialYear="$financialYear"
                        :leaveType="$leaveType"
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

