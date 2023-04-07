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

            <p>Please choose the type of leave to apply for.</p>

            <div class="row">
                @foreach($leaveTypes as $type)
                    <div class="col-md-3 col-sm-4">
                        <div class="wrimagecard wrimagecard-topimage">
                            <a href="{{route('leave_application.create', $type)}}">
                                <div class="wrimagecard-topimage_header ">
                                    <p style="font-size: 18px;" class="text-muted text-center">
                                        {{$type->name}}
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

@endsection

