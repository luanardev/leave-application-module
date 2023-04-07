<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h5>{{$leave->leaveType->getName()}} Application</h5>
            </div>
        </div>
        <div class="card-body">

            <div class="col-lg-12">
                <div class="callout callout-info">
                    <p>{{$leave->getMessage()}}</p>
                </div>
                @if($leave->progress() > 0)
                    <div class="mb-3">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="{{$leave->progress()}}"
                                 aria-valuemin="0" aria-valuemax="100" style="width:{{$leave->progress()}}%">
                                {{$leave->progress()}}%
                            </div>
                        </div>
                    </div>

                @endif
            </div>

            <div class="col-lg-12">
                <div class="card card-widget widget-user">

                    <div class="card-header">
                        <h3 class="widget-user-username">{{$leave->leaveType->getName()}}</h3>
                        <h6 class="widget-user-desc">Applied on {{$leave->appliedDate()}}</h6>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">Period</h5>
                                    <span class="description-text">{{$leave->getPeriodString()}}</span>
                                </div>

                            </div>

                            <div class="col-sm-3 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">Starts On</h5>
                                    <span class="description-text">{{$leave->startDate()}}</span>
                                </div>

                            </div>

                            <div class="col-sm-3 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">Ends On</h5>
                                    <span class="description-text">{{$leave->endDate()}}</span>
                                </div>

                            </div>

                            <div class="col-sm-3">
                                <div class="description-block">
                                    <h5 class="description-header">Status</h5>
                                    <span class="description-text">{!! $leave->statusBadge() !!}  </span>
                                </div>

                            </div>

                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Summary</label>
                                    <textarea class="form-control text-muted" disabled>{{$leave->summary}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Duties Delegation</label>
                                    <textarea class="form-control text-muted" disabled>{{$leave->delegation}}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            @if($leave->hasApprovals())
                <div class="col-lg-12">
                    <livewire:leaveapplication::leave-approvals
                        :leave="$leave"
                    />
                </div>
            @endif
        </div>
    </div>
</div>
