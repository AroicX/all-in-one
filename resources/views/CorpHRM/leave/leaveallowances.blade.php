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
                		<h5>Leave Allowances</h5>
                        <a href="{{url('corphrm/leaveallowance/new')}}">
                            <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                        </a>
                	</div>

                        <div class="card-body table-responsive no-padding">
                            <table class="table table-hover">

                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Grade</th>
                                    <th>Allowance</th>
                                    <th>Action</th>
                                </tr>
                                <?php $sn = 0; ?>
                                @foreach ($leaveallowances as $leaveallowance)
                                <?php $sn += 1;?>
                                <tr>
                                    <td>{{$sn}}</td>
                                    <td>{{ $leaveallowance['name'] }}</td>
                                    <td>{{ $leaveallowance['grade'] }}</td>
                                    <td>{{ $leaveallowance['allowance_percent'] }}</td>
                                    <td>
                                    <a href="{{url('corphrm/leaveallowance/edit')}}/{{ $leaveallowance['id'] }}">
                                        <button class="btn btn-primary btn-sm" >Edit</button>
                                    </a>
                                    <a href="{{url('corphrm/delete/leaveallowance')}}/{{ $leaveallowance['id'] }}">
                                        <button class="btn btn-danger btn-sm" >Delete</button>
                                    </a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            @if(!$leaveallowances)
                            <td><p style="text-align:center;" >No Leave Allowance.
                                </p></td>

                            @endif
                        </div>
                </div>
            </div>
        </div>
    </section>


@stop
