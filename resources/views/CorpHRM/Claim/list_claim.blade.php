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

			@if($type == "All")
			<div class="card card-primary">
				<div class="card-header with-border">
					<div class="col-md-12">
						<p style="font-weight:600;">Generate Report</p>
					</div>
					<form class="row" method="GET" action="{{route('corphrm.reports.claims')}}" target="_blank">
						<div class="col-lg-3 col-md-12">
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
								<label>Month</label>
								<select class="form-control" name="month">
										@for($i =  1; $i <= 12; $i++)
											<option @if(date('m') == $i)selected="selected"@endif value="{{$i}}"> {{date('F', mktime(0, 0, 0, $i, 10))}}</option>
										@endfor
                                </select>
							</div>
						</div>
						<div class="col-lg-3 col-md-12">
							<div class="form-group">
								<label>Year</label>
								<select class="form-control" name="year">
										@for($i =  2016; $i <= date('Y'); $i++)
											<option @if(date('Y') == $i)selected="selected"@endif value="{{$i}}"> {{$i}}</option>
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
					<h3>Claims
						<a href="{{url('corphrm/claim_application')}}?action=new">
                            <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                        </a>
					</h3>

				</div>

				<div class="card-body table-responsive no-padding">
					<table class="table table-hover">

						<tr>
							<th>ID</th>
							<th>Transaction Date</th>
							<th>Transaction Id</th>
							{{--
							<th>Employee</th> --}}
							<th>claims Date</th>
							<th>Status</th>
							@if($type == "All")
							<th>Action</th>
							@endif
						</tr>
						<?php $sn = 0; ?> @foreach ($claims as $claim)
						<?php $sn += 1;?>
						<tr>
							<td>{{$sn}}</td>
							<td>{{ $claim->transaction_date }}</td>
							<td>{{ $claim->transaction_id }}</td>

							<td>{{ $claim->claims_date }}</td>
							<td>
								<?php if($claim->status != "0" && $claim->status != "1" && $claim->status != "2"){ ?>
								<p style="color: orange;">Pending</p>
								<?php }if($claim->status == "0"){ ?>
								<p style="color: red;">Cancelled</p>
								<?php }if($claim->status == "1"){ ?>
								<p style="color: orange;">Processing</p>
								<?php }if($claim->status == "2"){ ?>
								<p style="color: orange;">Approved</p>
								<?php } ?>
							</td>
							@if($type == "All")
							<td>
								@if(empty($claim->status) || $claim->status == NULL)
								<a href="{{url('corphrm/claim_application/update')}}?id={{$claim->id}}&status=Level1" onclick="return confirm('Are you sure you want to process claim for stage 1?')">
                                            <button class="btn btn-primary btn-sm" title="accept claim for stage 1">Level 1 <i class="fa fa-check "></i></button>
                                            </a> @endif @if($claim->status == '1')
								<a href="{{url('corphrm/claim_application/update')}}?id={{$claim->id}}&status=Level2" onclick="return confirm('Are you sure you want to process claim for stage 2 and confirm payment?')">
                                        <button class="btn btn-primary btn-sm" title="accept claim for stage 2 and eligiblity for payment" claim_id = "{{ $claim->id }}">Level 2 <i class="fa fa-check "></i></button>
                                        </a> @endif @if($claim->status != "2" && $claim->status != "0")
								<a href="{{url('corphrm/claim_application/update')}}?id={{$claim->id}}&status=Cancel" onclick="return confirm('Are you sure you want to cancel claim? This process cannot be undone!')">
                                        <button class="btn btn-danger btn-sm" title="cancel claim"><i class="fas fa-window-close"></i></button>
                                        </a> @endif
								<a href="{{ url('corphrm/claim_application') }}?action=edit&id={{ $claim->id }}">
                                    <button class="btn btn-sm btn-success">view</button>
                                    </a>
							</td>
							@endif
						</tr>
						@endforeach
					</table>
					@if(!$claims)
					<td>
						<p style="text-align:center;">No Claims Application.
						</p>
					</td>

					@endif
				</div>
			</div>
		</div>
	</div>
</section>


@stop