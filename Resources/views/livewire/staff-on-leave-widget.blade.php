<div>
    <div class="card card-outline card-success">
        <div class="card-header">
            <div class="card-title">Staff On Leave</div>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                @if(count($staffOnLeave) > 0)

                    <div class="post">
                        @foreach($staffOnLeave as $key => $leave)
                            <div class="user-block">

                                @if(!is_null($leave->staff->avatar))
                                    <img src="{{ asset('storage/'.$leave->staff->avatar) }}" class="img-circle img-sm"
                                         alt="user image"/>
                                @else
                                    <img src="{{ asset('img/default.png') }}" class="img-circle img-sm"
                                         alt="user image"/>
                                @endif

                                <span class="username">
                                <a href="#">{{$leave->staff->fullname()}}</a>
                            </span>
                                <span class="username">
                                {{$leave->leaveType->getName() }}
                            </span>
                                <span class="description" style="font-style: italic; font-size: 12px">
								Returns on {{$leave->endDate()}}
							</span>
                            </div>
                        @endforeach
                    </div>

                @else
                    <div class="callout callout-info py-2 mb-4">
                        <p>
                            No staff on leave found
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
