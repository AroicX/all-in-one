@extends('CorpPay.layout.base')

@section('content')
	<section class="content">
		 <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                @if(isset($success))
                <div class="alert alert-success">* Bid created and open for advert</div>
                @endif
                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">Update Bid</h3>
                    </div>

                    <form action="" method="post">
                    	{{csrf_field()}}
                    <div class="box-body">
	                    <div class="form-group col-sm-6">
	                    	<label for="bid_number">Bid Number</label>
	                    	<input type="number" name="bid_number" class="form-control" id="bid_number" value="{{$bid->bid_number}}" disabled="disabled">
	                    </div>


	                    <div class="form-group col-sm-3">
	                    	<label for="bid_opening_date">Bid Opening Date</label>
	                    	<input type="date" name="bid_opening_date" class="form-control" value="{{$bid->bid_opening_date}}" id="bid_opening_date" disabled="disabled" >
	                    </div>

	                    <div class="form-group col-sm-3">
	                    	<label for="bid_opening_time">Bid Opening Time</label>
	                    	<input type="time" name="bid_opening_time" class="form-control" value="{{$bid->bid_opening_time}}" id="bid_opening_time" disabled="disabled" >
	                    </div>

	                    <div class="text-center"><h4>Bid Manager's Contact Information</h4></div>
	                    <div class="form-group col-sm-6">
	                    	<label for="name">Name</label>
	                    	<input type="text" name="name" class="form-control" id="name" value="{{$bid->name}}" disabled="disabled" >
	                    </div>

	                    <div class="form-group col-sm-6">
	                    	<label>Phone</label>
	                    	<input type="phone" name="phone" class="form-control" id="phone" value="{{$bid->phone}}" disabled="disabled" >
	                    </div>

	                    <div class="form-group col-sm-6">
	                    	<label for="fax">Fax</label>
	                    	<input type="fax" name="fax" class="form-control" id="fax" value="{{$bid->fax}}" disabled="disabled" >
	                    </div>

	                    <div class="form-group col-sm-6">
	                    	<label for="email">Email</label>
	                    	<input type="email" name="email" class="form-control" id="email" value="{{$bid->email}}" disabled="disabled" >
	                    </div>


	                    <div class="form-group col-sm-9">
	                    	<label for="commodity_desc">Commodity Description</label>
	                    	<input type="text" name="commodity_desc" id="commodity_desc" value="{{$bid->commodity_desc}}" class="form-control" disabled="disabled">
	                    </div>

	                    <div class="form-group col-sm-3">
	                    	<label for="scope">Type of Contract</label>
	                    	<select name="contract_type" id="contract_type" class="form-control" value="{{$bid->contract_type}}" disabled="disabled">
	                    		<option value="firm">Firm</option>
	                    		<option value="term">Term</option>
	                    	</select>
	                    </div>

	                    <div class="form-group col-sm-12">
	                    	<label for="scope">Scope</label>
	                    	<textarea type="text" name="scope" id="scope" class="form-control" cols="50" disabled="disabled">{{$bid->scope}}</textarea>
	                    </div>

                    </div>
                    
                        
                    
                	</form>

                	<div class="box-footer text-center" id="bid_items_table" style="display:block">
                    <div class="form-group col-md-12">
                    	<label>Add bid items:</label>
                    	<table class="table" width="100%">	
                    		<thead>
                    			<tr>
                    			<th width="40%">Name</th>
                    			<th width="30%">Brand</th>
                    			<th width="20%">Quantity</th>
                    			<th width="10%"></th>
                    			</tr>
                    		</thead>
                    		<tbody>
                				<tr>
                					<td><input type="text" id="item_name" class="form-control"></td>
                					<td><input type="text" id="item_brand" class="form-control"></td>
                					<td><input type="number" id="item_quantity" class="form-control"></td>
                					<td><button id="addBid">+</button></td>
                				</tr>
                    		</tbody>
                    	</table>

                    	<label>List of Items added:</label>
                    	<table class="table" id="list_item" width="100%">	
                    		<thead>
                    			<tr>
                    			<th width="40%">Name</th>
                    			<th width="30%">Brand</th>
                    			<th width="20%">Quantity</th>
                    			<th></th>
                    			</tr>
                    		</thead>
                    		<tbody class="text-left">
                				@foreach($bid_items as $bid_item)
                					<tr id="item{{$bid_item->id}}">
                						<td>{{$bid_item->item_name}}</td>
                						<td>{{$bid_item->item_brand}}</td>
                						<td>{{$bid_item->item_quantity}}</td>
                						<td><button id="{{$bid_item->id}}" class="btn btn-danger btn-sm delete">delete</button></td>
                					</tr>
                				@endforeach
                    		</tbody>
                    	</table>

                    </div>
                   </div>
                </div>
            </div>
        </div>
	</section>

	
@stop

@section('script')
<script type="text/javascript">
$(document).ready(function(){
	var bid_number = $('#bid_number').val();

	$('.delete').click(function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		
			$.ajax({
				type: 'POST',
				url: "/corp-pay/delete/bid_item",
				data: {id: id},
				dataType: 'text',
				success: function(response){
				$("#item"+id).hide();
				alert("bid item has been deleted");
				},
				error: function(response){
					alert("An error occured while submitting the form.")
				}
			});
		});
	
	//code to add more row to the add bid item table
	$('#addBid').click(function(e){
		e.preventDefault();
		var item_name = $('#item_name').val();
		var item_brand = $('#item_brand').val();
		var item_quantity = $('#item_quantity').val();

		if(item_name != "" && item_brand != "" && item_quantity != ""){
			console.log(item_name + " " + item_brand + " " + item_quantity);
			$.ajax({
				type: 'POST',
				url: "/corp-pay/add_bid_item",
				data: {bid_number: bid_number, item_name: item_name, item_brand: item_brand, item_quantity: item_quantity},
				dataType: 'text',
				success: function(response){
					var newRow = "<tr>";
					newRow += "<td>" + item_name + "</td>";
					newRow += "<td>" + item_brand + "</td>";
					newRow += "<td>" + item_quantity + "</td>";
					newRow += "<td>" + "<button id="+{{$bid_item->id}}+" class='btn btn-danger btn-sm delete'>delete</button>" + "</td>";
					newRow += "</tr>";
					$('#list_item tbody').append(newRow);
				},
				error: function(response){
					alert("An error occured when trying to submit this data");
				}
			});

		}
		else{
			alert('empty values in the fields');
		}
						
	});

	
});
</script>
@stop