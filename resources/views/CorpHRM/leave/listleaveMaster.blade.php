@extends('CorpHRM.layout.master')

@section('content')
	<section class="content">
		<div class="row">

            <div class="col-md-12">
                @if(isset($success))
                <div class="alert alert-success">* Successfully Added</div>
                @endif
                                @if(session('error'))
                        <div class = "alert alert-error">
                            {{ session('error') }}.
                        </div>
                    @elseif(session('success'))
                        <div class = "alert alert-success">
                            {{ session('success') }}.
                        </div>
                    @endif
                <div class="card card-primary">
                	<div class="card-header with-border">
                		<h5>Leave Master</h5>
                        <a href="{{url('corphrm/leavemaster/new')}}">
                            <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                        </a>
                	</div>

                        <div class="card-body table-responsive no-padding">
                            <table class="table table-hover">

                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Maximum Days</th>
                                    <th>Grade</th>
                                    <th>Paid Leave</th>
                                    <th>Encashable</th>
                                    <th>Action</th>
                                </tr>
                                <?php $sn = 0; ?>
                                @foreach ($LeavesMaster as $LeaveMaster)
                                <?php $sn += 1;?>
                                <tr>
                                    <td>{{$sn}}</td>
                                    <td>{{ $LeaveMaster['name'] }}</td>
                                    <td>{{ $LeaveMaster['code'] }}</td>
                                    <td>{{ $LeaveMaster['max_days'] }}</td>
                                    <td>{{ $LeaveMaster['grade'] }}</td>
                                    <td>@if($LeaveMaster['paid_leave'] == "1")
                                            Yes
                                        @elseif($LeaveMaster['paid_leave'] == "0")
                                        No
                                        @endif</td>
                                    <td>@if($LeaveMaster['encashable'] == '1')
                                            Yes
                                        @elseif($LeaveMaster['encashable'] == "0")
                                        No
                                        @endif</td>
                                    <td>
                            <a href="{{url('corphrm/leavemaster/edit')}}/{{ $LeaveMaster['id'] }}">
                                        <button class="btn btn-primary btn-sm" >Edit</button>
                                    </a>
                                    <a href="{{url('corphrm/delete/leavemaster')}}/{{ $LeaveMaster['id'] }}">
                                        <button class="btn btn-danger btn-sm" >Delete</button>
                                    </a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            @if(!$LeavesMaster)
                            <td><p style="text-align:center;" >No Leave Master.
                                </p></td>

                            @endif
                        </div>
                </div>
            </div>
        </div>
    </section>


@stop
