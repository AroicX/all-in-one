@extends('CorpHRM.layout.master') @section('content')
<section class="content">
	<div class="row">

		<div class="col-md-12">
			@if(isset($success))
			<div class="alert alert-success">* Successfully Added</div>
			@endif @if(session('error'))
			<div class="alert alert-error">
				{{ session('error') }}.
			</div>
			@elseif(session('success'))
			<div class="alert alert-success">
				{{ session('success') }}.
			</div>
			@endif @if($type == "All")
			<div class="card card-primary">
				<div class="card-header with-border">
					<div class="col-md-12">
						<p style="font-weight:600;">Generate Report</p>
					</div>
					<form class="row" method="GET" action="{{route('corphrm.reports.leaves')}}" target="_blank">
						<div class="col-lg-2 col-md-12">
							<div class="form-group">
								<label>Branch</label>
								<select class="form-control" name="branch">
									@foreach($branches as $branch)
									<option value="{{$branch->id}}">{{$branch->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-lg-2 col-md-12">
							<div class="form-group">
								<label>Leave Type</label>
								<select class="form-control" name="type">
									@foreach($masters as $master)
									<option value="{{$master->id}}">{{$master->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-lg-2 col-md-12">
							<div class="form-group">
								<label>Month</label>
								<select class="form-control" name="month">
									@for($i = 1; $i <= 12; $i++) <option @if(date('m')==$i)selected="selected" @endif
										value="{{$i}}"> {{$i}}</option>
										@endfor
								</select>
							</div>
						</div>
						<div class="col-lg-2 col-md-12">
							<div class="form-group">
								<label>Year</label>
								<select class="form-control" name="year">
									@for($i = 2016; $i <= date('Y'); $i++) <option @if(date('Y')==$i)selected="selected"
										@endif value="{{$i}}"> {{$i}}</option>
										@endfor
								</select>
							</div>
						</div>
						<div class="col-lg-2 col-md-12">
							<div class="form-group">
								<label>File Format</label>
								<select class="form-control" name="format">
									<option>PDF</option>
									<option>Excel</option>
								</select>
							</div>
						</div>
						<div class="col-lg-2 col-md-12">
							<div class="form-group">
								<button class="btn btn-primary btn-sm" style="margin-top:30px;">submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			@endif
			<div class="card card-primary">
				<div class="card-header with-border">
					<h5>Leave Applications	</h5>

						<a href="{{url('corphrm/leaveapp/new')}}">
							<button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
						</a>
				
				</div>

				<div class="card-body table-responsive no-padding">
					<table class="table table-hover">

						<tr>
							<th>ID</th>
							<th>Transaction Id</th>
							<th>Transaction Date</th>
							<th>Employee</th>
							<th>Leave Master</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>Phone</th>
							<th>Stage</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
						<?php $sn = 0; ?> @foreach ($LeavesApplication as $LeaveApplication)
						<?php $sn += 1;?>
						<tr>
							<td>{{$sn}}</td>
							<td>{{ $LeaveApplication['transaction_id'] }}</td>
							<td>{{ $LeaveApplication['transaction_date'] }}</td>
							<td>{{ $LeaveApplication['employee'] }}</td>
							<td>{{ $LeaveApplication['leave_master'] }}</td>
							<td> {{ $LeaveApplication['start_date'] }} </td>
							<td>{{ $LeaveApplication['end_date'] }}</td>
							<td>{{ $LeaveApplication['phone'] }}</td>
							<td>{{ $LeaveApplication['stage'] }}</td>
							<td>{{ $LeaveApplication['status'] }}</td>
							@if($LeaveApplication['status'] != "Approved" && $type == "All")
							<td>
								<a href="{{url('corphrm/leaveapp/edit')}}/{{ $LeaveApplication['id'] }}">
									<button class="btn btn-primary btn-sm">Edit</button>
								</a>
								<a href="{{url('corphrm/delete/leaveapp')}}/{{ $LeaveApplication['id'] }}">
									<button class="btn btn-danger btn-sm">Delete</button>
								</a>
							</td>
							@endif
						</tr>
						@endforeach
					</table>
					@if(!$LeavesApplication)
					<td>
						<p style="text-align:center;">No Leave Application.
						</p>
					</td>

					@endif
				</div>
			</div>
		</div>
	</div>
</section>


@stop