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
			@endif
			<div class="card card-primary">
				<div class="card-header with-border">
					<h5>Payroll Settings
					</h5>
				</div>


				<div class="card-body table-responsive no-padding">
					<table class="table table-hover">

						<tr>
							<th>ID</th>
							<th>Employee</th>
							<th>Period</th>
							<th>Amount</th>
							<th>Fee Type</th>
							<th>Description</th>
						</tr>
						<?php $sn = 0; ?> @foreach ($fees_history as $fee_history)
						<?php $sn += 1;?>
						<tr>
							{{$fee_history}}
							<td>{{$sn}}</td>
							{{-- <td>{{ $fee_history['employee'] }}</td>
							<td>{{ $fee_history['period'] }}</td>
							<td>{{ $fee_history['amount'] }}</td>
							<td>{{ $fee_history['fee_type'] }}</td>
							<td>{{ $fee_history['description'] }}</td> --}}
						</tr>
						@endforeach
					</table>
					@if(count($fees_history) == 0)
					<td>
						<p style="text-align:center;">No Fee History.
						</p>
					</td>

					@endif
				</div>
				<hr>
				<div class="row" style="margin-top:20px;">
				
					<div class="col-md-12 py-2 px-5">
							<h5 class="text-align:center;">Add New</h5>
						<form class="row" method="post" action="{{url('corphrm/payroll/staff_fees')}}">

							<div class="col-md-6">
								<div class="form-group">
									<label>Employee*</label>
									<select name="employee" class="form-control" required="">
                                @foreach($employees as $employee)
                                    <option value="{{$employee->id}}">{{$employee->name}}</option>
                                @endforeach
                            </select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Fee Type*</label>
									<select name="addition" class="form-control" required="">
                                    <option value="1">Addition</option>
                                    <option value="0">Subtraction</option>
                            </select>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label>Month*</label>
									<select name="month" class="form-control" required="">
                                @for($i = date('m');$i <= 12;$i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Year*</label>
									<select name="year" class="form-control" required="">
                                @for($i = date('Y');$i <= date('Y');$i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Amount*</label>
									<input name="amount" class="form-control" type="number" required="">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Description*</label>
									<textarea name="description" class="form-control" required=""></textarea>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-sm pull-right">submit</button>
								</div>
								<br>
								<br>
							</div>

						</form>
					</div>
				</div>


			</div>
		</div>
	</div>
</section>

<script src="{{asset('calendar/js/jquery.min.js')}}"></script>
<script type="text/javascript">

</script>
@stop