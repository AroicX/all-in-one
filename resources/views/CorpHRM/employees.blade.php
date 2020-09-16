@extends('CorpHRM.layout.master')

@section('content')
<section class="content">
	<div class="row">

		<div class="col-md-12">
			@if(isset($success))
			<div class="alert alert-success">* Successfully Added</div>
			@endif

			<div class="card">
				<div class="card-header">
					<h5>Generate Report</h5>
				</div>
				<div class="card-body">
					<form method="GET" action="{{route('corphrm.reports.ActiveEmployees')}}" target="_blank">

						<div class="row">
							<div class="col-md-4">

								<div class="form-group">
									<label>Branch</label>
									<select class="form-control" name="branch">
										@foreach($branches as $branch)
										<option value="{{$branch->id}}">{{$branch->name}}</option>
										@endforeach
									</select>
								</div>


							</div>

							<div class="col-md-4">

								<div class="form-group">
									<label>File Format</label>
									<select class="form-control" name="format">
										<option>PDF</option>
										<option>Excel</option>
									</select>
								</div>



							</div>

							<div class="col-md-4">
								<div class="form-group">
									<button class="btn btn-primary btn-sm" style="margin-top:30px;">submit</button>
								</div>
							</div>
						</div>

					</form>
				</div>
			</div>


			<div class="card card-primary">
				<div class="card-header with-border">
					<h3>
						Employees @if(CorpHRMAccessRoles('add_employee'))
						<a href="{{url('corphrm/employee/new')}}">
							<button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
						</a>

						<button class="btn btn-success btn-sm button_upload_csv"
							style="float:right; margin-right:9px;">Bulk Upload With Excel</button> @endif
					</h3>
				</div>

				<div class="card-body table-responsive table-bordered table-hover table-striped no-padding" id="BlockUI">
					<table class="table table-hover">

						<tr>
							<th>ID</th>
							<th>FullName</th>
							<th>Employee Code</th>
							<th>Grade</th>
							<th>Branch</th>
							<th>Department</th>
							<th>Designation</th>
							<th>Status</th>
							<th>On Leave</th>
							<th>Action</th>
						</tr>
						<?php $sn = 0; ?> @foreach ($employees as $employee)
						<?php $sn += 1;?>
						<tr>
							<td>{{$sn}}</td>
							<td>{{ $employee['name']}}</td>
							<td>{{ $employee['employee_code'] }}</td>
							<td>{{ $employee['grade'] }}</td>
							<td>{{ $employee['branch'] }}</td>
							<td>{{ $employee['department'] }}</td>
							<td>{{ $employee['designation'] }}</td>
							<td>
								@if($employee['status'] == "Active")
								<span style="color:green; font-weight:600;">{{ $employee['status'] }}</span>
								@elseif($employee['status'] != "")
								<span style="color:red; font-weight:600;">{{ $employee['status'] }}ed</span> @endif
								@if($employee['status'] == "Active")
								<br>
								<a onclick="return confirm('Are you sure you want to suspend this user');"
									href="{{ url('/corphrm/action/edit') }}?type=employees&id={{ $employee['user_id']}}&action=Suspend"
									style="font-size:12px;">Suspend</a>
								<a onclick="return confirm('Are you sure you want to retire this user');"
									href="{{ url('/corphrm/action/edit') }}?type=employees&id={{ $employee['user_id']}}&action=Retire"
									style="font-size:12px;">Retire</a> @else
								<br>
								<a onclick="return confirm('Are you sure you want to activate this user');"
									href="{{ url('/corphrm/action/edit') }}?type=employees&id={{ $employee['user_id']}}&action=Active"
									style="font-size:12px;">Activate</a> @endif
							</td>
							<td>
								<span style="color:green; font-weight:600;">
									{{$employee['leave_status']}}
								</span>
							</td>
							<td>
								@if(CorpHRMAccessRoles('edit_employee'))
								<a
									href="{{ url('corphrm/employee') }}?query=edit&id={{ $employee['id']}}&uid={{$employee['user_id']}}">
									<button type="button" title="Edit" class="btn btn-sm btn-success">
										{{--  <i class="fa fa-check "></i>  --}}
										Edit
									</button>
								</a> @endif @if(CorpHRMAccessRoles('delete_employee'))
								{{-- <a href="{{ url('corphrm/employee') }}?query=delete&id={{ $employee['id']}}">
								<button type="button" title="Delete" class="btn btn-sm btn-danger">
									<i class="fa fa-remove "></i>
								</button>
								</a> --}} @endif
							</td>
						</tr>
						@endforeach
					</table>
					@if(empty($employees))
					<td>
						<p style="text-align:center;">No employee Yet.
						</p>
					</td>

					@endif
				</div>

			</div>
		</div>
	</div>
</section>

<!-- Bulk Upload Modal -->
<div id="staff-upload-modal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Excel File <span class="text-danger"
					style="font-size:12px !important; font-weight:600;">(Password is employee middlename!)</marquee>
				</span>
				<button type="button" class="close" data-dismiss="modal">&times;</button>

				</h4>
			</div>
			<div class="modal-body">
				<form method='post' action="{{route('corphrm_bulk_staff_upload')}}" enctype='multipart/form-data'>
					<br>
					<a href="/uploads/misc/bulk-staff-upload-template.xlsx" class="pull-right">Download Template</a>
					<br>
					<div class="form-group">
						<label>Excel File <span class="text-danger">(*required)</span></label>
						<input type="file" name="file" class="form-control" required="">
					</div>

					<button type="submit" class="btn btn-sm btn-primary pull-right">Upload</button>
					<br>
				</form>
			</div>
			<div class="modal-footer">
				<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
			</div>
		</div>

	</div>
</div>

<script src="{{asset('calendar/js/jquery.min.js')}}"></script>

<script>
	$('.button_upload_csv').click(function () {
		$('#staff-upload-modal').modal('show');
		return false;
	});
</script>

@stop