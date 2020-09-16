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
	                				<th>Bid Name</th>
	                				<th>Bid Opening Datee</th>
	                				<th>Bid Opening Time</th>
	                				<th>view</th>
	                				<th>vendors</th>

	                			</tr>
	                		</thead>
	                		<tbody>
	                			@foreach($bids as $bid)
	                				<tr>
	                					<td>{{$bid->bid_number}}</td>
	                					<td>{{$bid->name}}</td>
	                					<td>{{$bid->bid_opening_date}}</td>
	                					<td>{{$bid->bid_opening_time}}</td>
	                					<td><a class="view	btn btn-default" id="{{$bid->bid_number}}">view bids</a></td>
	                					<td><a href="{{url('/corp-pay/pending_vendors/')."/".$bid->bid_number}}" class="btn btn-default" id="{{$bid->bid_number}}">manage</a></td>
	                				</tr>
	                			@endforeach
	                		</tbody>
	                	</table>
	                </div>
	            </div>
	        </div>

	    </div>

	</section>

	<div id="myModal" class="modal fade" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4>List of items in this bid</h4>
				</div>
				<div class="modal-body">
					<table class="table" id="myTable">
						<thead>
							<tr>
								<th>S/N</th>
								<th>Item Name</th>
								<th>Item Brand</th>
								<th>Quantity</th>
								
							</tr>
						</thead>
						<tbody>
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
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.view').click(function(){
		var id = $(this).attr('id');
		//alert(id);

		$.ajax({
				type: 'POST',
				url: "/corp-pay/manage_bid/get_items",
				data: {bid_number: id},
				dataType: 'json',
				success: function(response){
					
					$.each(response,function(index,elem){
						var input = "<tr>";
						input += '<td>' + (index + 1) + '</td>';
						input += '<td>' + elem.item_name + '</td>';
						input += '<td>' + elem.item_brand + '</td>';
						input += '<td>' + elem.item_quantity + '</td>';
						
						input += '</tr>';

						$('#myTable tbody').append(input);
					});

					$('#myModal').modal();		

					//$('.modal-body').text(response);
				},
				error: function(response){
					alert("An error occured when trying to submit this data");
				}
			});
		
	});
});
</script>
@stop