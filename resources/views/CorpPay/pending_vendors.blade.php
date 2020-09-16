@extends('CorpPay.layout.base')

@section('content')
	<section class="content">
		 <div class="row">

            <div class="col-md-12">
              
                <div class="box box-primary">

	                <div class="box-header with-border">
	                    <h3 class="box-title">Manage Bid Vendors</h3>

	                </div>

	                <div class="box-body">
	                	<div class="text-center">
	                		<h3>{{$bid->name}}</h3>
	                		<h4>{{$bid->bid_number}}</h4>
	                	</div>
	                			@foreach($p_vendors as $vendor)

	                				<div class="panel-group">
	                					<div class="panel panel-default">
	                						<div class="panel-heading">
	                							<h4 class="panel-title">
	                								<a href="#collapse{{$vendor->id}}" data-toggle="collapse">
	                									{{$vendor->company_name}}
	                								</a>
	                								<a id="{{$vendor->id}}" class="pull-right select">select</a>
	                							</h4>
	                						</div>
	                						<?php
                                                $bids_quote = $vendor->bids_quote;
                                                $myArray = unserialize($bids_quote);

                        ?>
	                						<div id="collapse{{$vendor->id}}" class="panel-collapse collapse">
	                							<div class="panel-body">
	                								<table class="table">
								                		<thead>
								                			<tr>
								                				<th>Item</th>
								                				<th>Brand</th>
								                				<th>Quantity</th>
								                				<th>Price</th>
								                				<th>total</th>
								                			</tr>
								                		</thead>
								                		<tbody>
								                			@foreach($myArray as $array)
								                			<tr>
								                				<td>{{$array[0]}}</td>
								                				<td>{{$array[1]}}</td>
								                				<td>{{$array[2]}}</td>
								                				<td>{{$array[3]}}</td>
								                				<td>{{$array[4]?$array[4]:0}}</td>
								                			</tr>
								                			@endforeach
								                		</tbody>
								                	</table>
	                							</div>
	                						</div>
	                					</div>
	                				</div>
	                			@endforeach
	                		
	                	
	                </div>
	            </div>
	        </div>

	    </div>

	</section>

	<!-- Modal for displaying the compared bids -->
	<div id="myModal" class="modal fade" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4>Bids Comparison</h4>
				</div>
				<div class="modal-body">
					<table class="table" id="myTable">
						<thead>
							<tr>
								<th>Bid Items</th>
								<th>Vendor 1</th>
								<th>Vendor 2</th>
							</tr>
						</thead>
						<tbody>
							@foreach($bid_items as $bid_item)
							<tr>
								<td>{{$bid_item->item_name}}</td>
								
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<div><a href="{{url('/corp-pay/update_bid/')."/".$bid->bid_number}}#bid_items_table" class="btn btn-info">Update Items</a></div>
				</div>
			</div>
		</div>
	</div>
	
@stop

@section('script')
<script type="text/javascript">
$(document).ready(function(){
	$('tbody tr').click(function(){
		var result = $(this).index();
		$(this).append().html("<div>Your Content here</div>").toggle('slow');
	});

	$('#compare_bids').click(function(){
		$('#myModal').modal();
	});

	$('.select').click(function(){
		var id= $(this).attr('id');

		$.ajax({
				type: 'POST',
				url: "/corp-pay/add_vendor",
				data: {id: id},
				dataType: 'text',
				success: function(response){
					$(this).text('');
				},
				error: function(response){
					alert("An error occured when trying to submit this data");
				}
			});
	});
});
</script>
@stop
