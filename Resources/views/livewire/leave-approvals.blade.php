<div>
    <div class="card card-widget widget-user">
        <div class="card-header">
            <div class="card-title">
                <p>Approvals</p>
            </div>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                @if($leave->hasApprovals())
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th>Stage</th>
                            <th>Decision</th>
                            <th>Comment</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($leave->approvals as $key => $approval)
                            <tr>
                                <td>
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="{{ asset('img/default.png') }}"
                                             alt="user image">
                                        <span class="username">
                                            <a href="#">{{$approval->stage->name}}</a>
                                         </span>
                                        <span class="username text-muted">{{$approval->approver->name() }}</span>
                                    </div>
                                </td>
                                <td>{!! $approval->decisionBadge() !!}</td>
                                <td>{{$approval->comment}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="callout callout-info py-2 mb-4">
                        <p>
                            No approvals found
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
