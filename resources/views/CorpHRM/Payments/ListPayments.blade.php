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
					<div class="col-md-12">
						<p style="font-weight:600;">Generate Report</p>
					</div>
					<form class="row" method="GET" action="{{route('corphrm.reports.PAYE')}}" target="_blank">
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
								<label>SIRB</label>
								<select class="form-control" name="sirb">
									@foreach($sirbs as $sirb)
									<option value="{{$sirb->id}}">{{$sirb->name}}</option>
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
									{{-- <option>Excel</option> --}}
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
			<div class="card card-primary">
				<div class="card-header with-border">
					<div class="col-md-6">
						<h3>Payments</h3>
					</div>
					
						<form class="row"  action="#" method="">
						
							<div class="col-md-4">
								<label>Make Payment</label>
								<select class="form-control" name="pay_utility" required="">
									<option value="">Choose Utility</option>
									<option>Payee</option>
									<option>NHF</option>
									<option>NHIS</option>
									<option>Pension</option>
								</select>
							</div>

							<div class="col-md-4">
								<label>States</label>
								<select class="form-control" name="states" required="">
									<option value="">Choose </option>
									<option>ABUJA FCT</option>
									<option>ABIA</option>
									<option>ADAMAWA</option>
									<option>AKWA IBOM</option>
									<option>ANAMBRA</option>
									<option>BAUCHI</option>
									<option>BAYELSA</option>
									<option>BENUE</option>
									<option>BORNO</option>
									<option>CROSS RIVER</option>
									<option>DELTA</option>
									<option>EBONYI</option>
									<option>EDO</option>
									<option>EKITI</option>
									<option>ENUGU</option>
									<option>GOMBE</option>
									<option>IMO</option>
									<option>JIGAWA</option>
									<option>KADUNA</option>
									<option>KANO</option>
									<option>KATSINA</option>
									<option>KEBBI</option>
									<option>KOGI</option>
									<option>KWARA</option>
									<option>LAGOS</option>
									<option>NASSARAWA</option>
									<option>NIGER</option>
									<option>OGUN</option>
									<option>ONDO</option>
									<option>OSUN</option>
									<option>OYO</option>
									<option>PLATEAU</option>
									<option>RIVERS</option>
									<option>SOKOTO</option>
									<option>TARABA</option>
									<option>YOBE</option>
									<option>ZAMFARA</option>
								</select>
							</div>
							<button type="submit" class="btn btn-primary" style="margin:25px; float:right;">Pay</button>
						</form>
					
				</div>
				<ul class="nav nav-tabs">
					<li class="active mx-2 my-2"><a data-toggle="tab" href="#payee">PAYEE</a></li>
					<li class="mx-2 my-2"><a data-toggle="tab" href="#nhf">NHF</a></li>
					<li class="mx-2 my-2"><a data-toggle="tab" href="#nhis">NHIS</a></li>
					<li class="mx-2 my-2"><a data-toggle="tab" href="#pension">Pension</a></li>
				</ul>
				<div class="tab-content">
					<div id="payee" class="tab-pane show active">

						<div class="card-body table-responsive no-padding">
							<table class="table table-hover">

								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Code</th>
									<th>Designation</th>
									<th>Branch</th>
									<th>Department</th>
									<th>Amount</th>
									<th>Status</th>
								</tr>
								<?php $sn = 0; $total_paye = 0; ?> @foreach ($payee as $payeee)
								<?php $sn += 1; $total_paye = $total_paye + $payeee->PAYE; ?>
								<tr>
									<td>{{$sn}}</td>
									<td>
										<?php $name = json_decode($payeee->user_details) ?> {{$name->name}}
									</td>
									<td>
										<?php $profile = json_decode($payeee->profile) ?> {{$profile->employee_code}}
									</td>
									<td>
										<?php $designation = json_decode($payeee->designation) ?> {{$designation->name}}
									</td>
									<td>
										<?php $branch = json_decode($payeee->branch) ?> {{$branch->name}}
									</td>
									<td>
										<?php $department = json_decode($payeee->department) ?> {{$department->name}}
									</td>
									<td>{{$payeee->PAYE}}</td>
									<td><span style="font-weight:600;" class="text-danger">Unpaid</span></td>
								</tr>
								@endforeach
							</table>

						</div>

					</div>
					<div id="nhf" class="tab-pane fade">
						<div class="card-body table-responsive no-padding">
							<table class="table table-hover">

								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Code</th>
									<th>Designation</th>
									<th>Branch</th>
									<th>Department</th>
									<th>Amount</th>
									<th>Status</th>
								</tr>
								<?php $sn = 0; $total_nhf = 0; ?> @foreach ($nhf as $nhff)

								<?php $sn += 1; $total_nhf = $total_nhf + $nhff->NHF; ?>
								<tr>
									<td>{{$sn}}</td>
									<td>
										<?php $name = json_decode($nhff->user_details) ?> {{$name->name}}
									</td>
									<td>
										<?php $profile = json_decode($nhff->profile) ?> {{$profile->employee_code}}
									</td>
									<td>
										<?php $designation = json_decode($nhff->designation) ?> {{$designation->name}}
									</td>
									<td>
										<?php $branch = json_decode($nhff->branch) ?> {{$branch->name}}
									</td>
									<td>
										<?php $department = json_decode($nhff->department) ?> {{$department->name}}
									</td>
									<td>{{$nhff->NHF}}</td>
									<td><span style="font-weight:600;" class="text-danger">Unpaid</span></td>
								</tr>
								@endforeach
							</table>

						</div>
					</div>
					<div id="nhis" class="tab-pane fade">
						<div class="card-body table-responsive no-padding">
							<table class="table table-hover">

								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Code</th>
									<th>Designation</th>
									<th>Branch</th>
									<th>Department</th>
									<th>Amount</th>
									<th>Status</th>
								</tr>
								<?php $sn = 0; $total_nhis = 0; ?> @foreach ($nhis as $nhiss)
								<?php $sn += 1; $total_nhis = $total_nhis + $nhiss->NHIS; ?>
								<tr>
									<td>{{$sn}}</td>
									<td>
										<?php $name = json_decode($nhiss->user_details) ?> {{$name->name}}
									</td>
									<td>
										<?php $profile = json_decode($nhiss->profile) ?> {{$profile->employee_code}}
									</td>
									<td>
										<?php $designation = json_decode($nhiss->designation) ?> {{$designation->name}}
									</td>
									<td>
										<?php $branch = json_decode($nhiss->branch) ?> {{$branch->name}}
									</td>
									<td>
										<?php $department = json_decode($nhiss->department) ?> {{$department->name}}
									</td>
									<td>{{$nhiss->NHIS}}</td>
									<td><span style="font-weight:600;" class="text-danger">Unpaid</span></td>
								</tr>
								@endforeach
							</table>

						</div>
					</div>
					<div id="pension" class="tab-pane fade">
						<div class="card-body table-responsive no-padding">
							<table class="table table-hover">

								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Code</th>
									<th>Designation</th>
									<th>Branch</th>
									<th>Department</th>
									<th>Amount</th>
									<th>Status</th>
								</tr>
								<?php $sn = 0; $total_pension = 0; ?> @foreach ($pension as $pensionn)
								<?php $sn += 1; $total_pension = $total_pension + $pensionn->pension; ?>
								<tr>
									<td>{{$sn}}</td>
									<td>
										<?php $name = json_decode($pensionn->user_details) ?> {{$name->name}}
									</td>
									<td>
										<?php $profile = json_decode($pensionn->profile) ?> {{$profile->employee_code}}
									</td>
									<td>
										<?php $designation = json_decode($pensionn->designation) ?>
										{{$designation->name}}
									</td>
									<td>
										<?php $branch = json_decode($pensionn->branch) ?> {{$branch->name}}
									</td>
									<td>
										<?php $department = json_decode($pensionn->department) ?> {{$department->name}}
									</td>
									<td>{{$pensionn->pension}}</td>
									<td><span style="font-weight:600;" class="text-danger">Unpaid</span></td>
								</tr>
								@endforeach
							</table>

						</div>
					</div>
				</div>
			</div>
		</div>
</section>


@stop