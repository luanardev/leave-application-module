<div>
    <div class="card card-outline card-success">
        <div class="card-header">
            <div class="card-title">My Applications</div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    @if(count($recentLeaves) > 0)
                        <div class="table-responsive pre-scrollable">
                            <table class="table table-striped projects">
                                <thead>
                                <tr>
                                    <td>#</td>
                                    <th>Leave Type</th>
                                    <th>Period</th>
                                    <th>Starts On</th>
                                    <th>Ends On</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($recentLeaves as $key => $leave)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{$leave->leaveType->getName()}}</td>
                                        <td>{{$leave->getPeriodString()}}</td>
                                        <td>{{$leave->startDate()}}</td>
                                        <td>{{$leave->endDate()}}</td>
                                        <td>{!! $leave->statusBadge() !!}</td>
                                        <td>
                                            <a href="{{route('leave_application.show', $leave)}}"
                                               class="btn btn-sm btn-outline-primary">Open</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="callout callout-info py-2 mb-4">
                            <p>
                                No recent applications found.
                            </p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

</div>

