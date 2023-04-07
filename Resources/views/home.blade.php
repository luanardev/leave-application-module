@extends('leaveapplication::layouts.app')

@section('content')

    <div class="container-fluid">

        <div class="content-header">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Leave Application
                        <span class="text-muted font-weight-lighter">({{strtoupper($financialYear->getName())}})</span>
                    </h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('leave_application.home') }}">Home</a></li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="row">
                <div class="col-lg-9">
                    <livewire:leaveapplication::leave-draft
                        :staff="$staff"
                        :financialYear="$financialYear"
                    />
                    <livewire:leaveapplication::recent-leave
                        :staff="$staff"
                        :financialYear="$financialYear"
                    />

                    @if($approver->canMakeApprovals())
                        <livewire:leaveapplication::leave-awaiting-approval
                            :staff="$staff"
                            :financialYear="$financialYear"
                        />
                        <livewire:leaveapplication::leave-return-request
                            :staff="$staff"
                            :financialYear="$financialYear"
                        />
                    @endif

                    <livewire:leaveapplication::leave-days-balance
                        :staff="$staff"
                        :financialYear="$financialYear"
                    />
                </div>

                <div class="col-lg-3">
                    <livewire:leaveapplication::leave-days
                        :staff="$staff"
                        :financialYear="$financialYear"
                        :leaveType="$leaveType"
                    />
                    <livewire:leaveapplication::staff-on-leave
                        :staff="$staff"
                        :financialYear="$financialYear"
                    />
                </div>
            </div>
        </div>
    </div>

@endsection

