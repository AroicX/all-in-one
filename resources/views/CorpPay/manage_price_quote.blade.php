@extends('CorpPay.layout.base')

@section('content')
	<section class="content">
		 <div class="row">

            <div class="col-md-12">
              
                <div class="box box-primary">

	                <div class="box-header with-border">
	                    <h3 class="box-title">Manage Bid</h3>
	                </div>

	                <div class="box-body">
	                	<table class="table">
	                		<thead>
	                			<tr>
	                				<th>Bid Number</th>
	                				<th>Vendor ID</th>
	                				<th>document</th>
	                				<th></th>
	                				<th></th>
	                			</tr>
	                		</thead>
	                		<tbody>
	                			@foreach($quotes as $quote)
	                			<tr>
	                				<td>{{$quote->bid_number}}</td>
	                				<td>{{$quote->vendor_id}}</td>
	                				<td><a href="{{url('/corp-pay/view_doc')}}" target="_blank">{{$quote->price_quote_doc}}</a></td>
	                				<td>
	                					@if($quote->status === "accepted")
	                					<a href="#" id="{{$quote->id}}" class="btn btn-sm btn-success" disabled="disabled">Approve</a>
	                					@else
	                					<a href="#" id="{{$quote->id}}" class="btn btn-sm btn-success">Approve</a>
	                					@endif
	                				</td>
	                				<td>
	                					@if($quote->status === "rejected")
	                					<a href="#" id="{{$quote->id}}" class="btn btn-sm btn-danger" disabled="disabled">Reject</a>
	                					@else
	                					<a href="#" id="{{$quote->id}}" class="btn btn-sm btn-danger">Reject</a>
	                					@endif
	                				</td>
	                			</tr>
	                			@endforeach
	                		</tbody>
	                	</table>
	                </div>
	            </div>
	        </div>

	    </div>

	</section>

@stop

@section('script')
<script type="">
$(document).ready(function(){
	$('.btn-success').click(function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		var type = "accepted";
		var elem = this;
		//send request to automate approval
		$.ajax({
			url: "/corp-pay/update_status",
			type: "POST",
			data: {id: id, type: type},
			dataType: "text",
			success: function(response){
				if(response === "success"){
					toastr.info('Vendor price quote has been Accepted');
					$(elem).attr('disabled','disabled');
					$(elem).text('Accepted');
				}
				else{
					toastr.info("An error occured in trying to update status");
				}
				
			},
			error: function(){
				toastr.info('An error occured while trying to perform the operation');
			}
		});
	});

	$('.btn-danger').click(function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		var type = "rejected";
		var elem = this;
		//send request to automate approval
		$.ajax({
			url: "/corp-pay/update_status",
			type: "POST",
			data: {id: id, type: type},
			dataType: "text",
			success: function(response){
				if(response === "success"){
					toastr.info('Vendor price quote has been Rejected');
					$(elem).attr('disabled','disabled');
					$(elem).text('Rejected');
				}
				else{
					toastr.info("An error occured in trying to update status");
				}
				
			},
			error: function(){
				toastr.info('An error occured while trying to perform the operation');
			}
		});
	});
});
</script>
@stop