@extends('CorpPay.layout.base')

@section('content')
	<section class="content">
		 <div class="row">

            <div class="col-md-12">
              
                <div class="box box-primary">

	                <div class="box-header with-border">
	                    <h3 class="box-title">Vendors List</h3>
	                </div>

	                <div class="box-body">
	                	
	                	<table class="table">
	                		<thead>
	                			<tr>
	                				<th>Bid Number</th>
	                				<th>Company Name</th>
	                				<th>Email</th>
	                				<th id="type">{{$type}}</th>
	                			</tr>
	                		</thead>
	                		<tbody>
	                			@foreach($vendors as $vendor)
	                			<tr>
	                				<td>{{$vendor->bid_number}}</td>
	                				<td>{{$vendor->company_name}}</td>
	                				<td>{{$vendor->email}}</td>
	                				<td><a class="btn btn-sm btn-success btn-disabled" id="{{$vendor->id}}">send</a></td>
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
<script type="text/javascript">
$(document).ready(function(){

	$('.btn').on('click',function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		var type = $('#type').text();
		//send ajax request to send mail to vendor
		$(this).text('sending');
		$.ajax({
			type: 'POST',
			url: "/corp-pay/send_mail",
			data: {id: id, type:type},
			dataType: 'text',
			success: function(response){
				toastr.info(response);
				$('#'+id).attr('disabled','disabled');
				$('#'+id).text('sent');
			},
			error: function(){
				toastr.info('An error occured while trying to send the mail');
				$('#'+id).text('send');
			}
		});
	});
});
</script>
@stop