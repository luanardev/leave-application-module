<div>
    <div class="card card-outline card-info">
        <div class="card-header">
            <div class="card-title">Leave {{ucfirst(strtolower($calendarUnit))}} Balance</div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    @if(count($staffLeaves) > 0)
                        <div class="table-responsive pre-scrollable">
                            <table class="table table-striped projects">
                                <thead>
                                <tr>
                                    <th>Leave Type</th>
                                    <th>Days Taken</th>
                                    <th>Balance</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($staffLeaves as $key => $staffLeave)
                                    <tr>
                                        <td>{{$staffLeave->leaveType()->getName()}}</td>
                                        <td>{{$staffLeave->daysTaken()}} {{$staffLeave->leaveType()->getUnit()}}</td>
                                        <td>{{$staffLeave->daysRemaining()}} {{$staffLeave->leaveType()->getUnit()}}</td>
                                        <td>
                                            @if($staffLeave->hasLeaveDays())
                                                <a href="{{route('leave_application.create', $staffLeave->leaveType())}}"
                                                   class="btn btn-sm btn-outline-primary">
                                                    Apply
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="callout callout-info py-2 mb-4">
                            <p>
                                No leave days balance found.
                            </p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

</div>

