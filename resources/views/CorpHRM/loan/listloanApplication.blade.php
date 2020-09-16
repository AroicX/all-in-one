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
					<form class="row" method="GET" action="{{route('corphrm.reports.loans')}}" target="_blank">
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
					<h5>Loan Application</h5>
					<a href="{{url('corphrm/loanapp/new')}}">
                            <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                        </a>
				</div>

				<div class="card-body table-responsive no-padding">
					<table class="table table-hover">

						<tr>
							<th>ID</th>
							<th>Ref Id</th>
							<th>Application Date</th>
							<th>Contact No.</th>
							<th>Loan Amount</th>
							<th>No. of Installments</th>
							<th>Remark</th>
							<th>Loan Doc.</th>
							<th>Status</th>
							@if($type == "All")
							<th>Action</th>

							@endif
						</tr>
						<?php $sn = 0; ?> @foreach ($LoansApplication as $LoanApplication)
						<?php $sn += 1;?>
						<tr>
							<td>{{$sn}}</td>
							<td>{{ $LoanApplication->application_ref }}</td>
							<td>{{ $LoanApplication->application_date }}</td>
							<td>{{ $LoanApplication->contact_no }}</td>
							<td>{{ $LoanApplication->loan_amount }}</td>
							<td> {{ $LoanApplication->no_of_installments }} </td>
							<td>{{ $LoanApplication->remarks }}</td>
							<td>{{ $LoanApplication->loan_doc_file }}</td>
							<td>{{ $LoanApplication->status }}</td>
							@if($type == "All")
							<td>

								@if($LoanApplication->stage == "0")
								<!--Level 1-->
								@if($LoanApplication->status != "Hold")
								<a href="{{url('corphrm/loanapp/update')}}?id={{ $LoanApplication->id }}&status=Hold">
<button class="btn btn-warning btn-flat btn-sm">Hold</button>
</a> @endif @if($LoanApplication->status != "Rejected")
								<a href="{{url('corphrm/loanapp/update')}}?id={{ $LoanApplication->id }}&status=Rejected">
<button class="btn btn-danger btn-flat btn-sm">Reject</button>
</a> @endif @if($LoanApplication->status != "Approved")
								<a href="{{url('corphrm/loanapp/update')}}?id={{ $LoanApplication->id }}&status=approve1">
<button class="btn btn-success btn-flat btn-sm">Approve</button>
</a> @endif @elseif($LoanApplication->stage == "1")
								<!--Level 2-->
								@if($LoanApplication->status != "Rejected")
								<a href="{{url('corphrm/loanapp/update')}}?id={{ $LoanApplication->id }}&status=Rejected">
<button class="btn btn-danger btn-flat btn-sm">Reject</button>
</a> @endif @if($LoanApplication->status != "Disbursed")
								<a href="{{url('corphrm/loanapp/update')}}?id={{ $LoanApplication->id }}&status=approve2">
<button class="btn btn-success btn-flat btn-sm">Disburse</button>
</a> @endif @elseif($LoanApplication->stage == "2" && $LoanApplication->status == "Disbursed")
								<p style="color: green;">Disbursed</p>
								@endif


							</td>

							@endif
						</tr>
						@endforeach
					</table>
					@if(!$LoansApplication)
					<td>
						<p style="text-align:center;">No Loans Master.
						</p>
					</td>

					@endif
				</div>
			</div>
		</div>
	</div>
</section>


@stop