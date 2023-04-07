<div>
    <div class="card card-outline card-info">
        <div class="card-header">
            <div class="card-title">Leave Requests Awaiting My Approval</div>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                @if(count($pendingLeaves) > 0)
                    <div class="table-responsive pre-scrollable">
                        <table class="table table-striped projects">

                            <tbody>
                            @foreach($pendingLeaves as $key => $leave)
                                <tr>
                                    <td>
                                        <div class="user-block">
                                            @if(!is_null($leave->staff->avatar))
                                                <img src="{{ asset('storage/'.$leave->staff->avatar) }}"
                                                     class="img-circle img-bordered-sm img-fluid" alt="user image"/>
                                            @else
                                                <img src="{{ asset('img/default.png') }}"
                                                     class="img-circle img-bordered-sm img-fluid" alt="user image"/>
                                            @endif
                                            <span class="username">
                                                <a href="#">{{$leave->staff->fullname()}}</a>
                                             </span>
                                            <span class="description"
                                                  style="font-size: 16px">{{$leave->leaveType->getName() }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        {{$leave->appliedPeriod()}}
                                    </td>
                                    <td>
                                        <a href="{{route('leave_application.approve', $leave)}}"
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
                            No requests awaiting approval found
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
