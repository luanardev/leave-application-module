<div>
    <div class="card card-outline card-info">
        <div class="card-header">
            <div class="card-title">Draft Applications</div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    @if(count($draftLeaves) > 0)
                        <div class="table-responsive pre-scrollable">
                            <table class="table table-striped projects">
                                <thead>
                                <tr>
                                    <td>#</td>
                                    <th>Leave Type</th>
                                    <th>Period</th>
                                    <th>Starts On</th>
                                    <th>Ends On</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($draftLeaves as $key => $leave)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{$leave->leaveType->getName()}}</td>
                                        <td>{{$leave->getPeriodString()}}</td>
                                        <td>{{$leave->startDate()}}</td>
                                        <td>{{$leave->endDate()}}</td>
                                        <td>
                                            <a href="{{route('leave_application.edit', $leave)}}"
                                               class="btn btn-sm btn-outline-primary">Edit</a>
                                            <a wire:click.prevent="delete('{{$leave->id}}')" href="#"
                                               class="btn btn-sm btn-outline-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="callout callout-info py-2 mb-4">
                            <p>
                                No draft applications found.
                            </p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

</div>

