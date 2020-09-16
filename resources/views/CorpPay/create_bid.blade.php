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
                        <h3 class="box-title">Create Bid</h3>
                    </div>

                    <form action="" method="post">
                    	{{csrf_field()}}
                    <div class="box-body">
	                    <div class="form-group col-sm-6">
	                    	<label for="bid_number">Bid Number</label>
	                    	<input type="number" name="bid_number" class="form-control" id="bid_number" value="{{$bid_no}}" required="required" disabled="disabled">
	                    </div>


	                    <div class="form-group col-sm-3">
	                    	<label for="bid_opening_date">Bid Opening Date</label>
	                    	<input type="date" name="bid_opening_date" class="form-control" id="bid_opening_date" required="required" >
	                    </div>

	                    <div class="form-group col-sm-3">
	                    	<label for="bid_opening_time">Bid Opening Time</label>
	                    	<input type="time" name="bid_opening_time" class="form-control" id="bid_opening_time" required="required" >
	                    </div>

	                    <div class="text-center"><h4>Bid Manager's Contact Information</h4></div>
	                    <div class="form-group col-sm-6">
	                    	<label for="name">Name</label>
	                    	<input type="text" name="name" class="form-control" id="name" required="required" >
	                    </div>

	                    <div class="form-group col-sm-6">
	                    	<label>Phone</label>
	                    	<input type="phone" name="phone" class="form-control" id="phone" required="required" >
	                    </div>

	                    <div class="form-group col-sm-6">
	                    	<label for="fax">Fax</label>
	                    	<input type="fax" name="fax" class="form-control" id="fax" required="required" >
	                    </div>

	                    <div class="form-group col-sm-6">
	                    	<label for="email">Email</label>
	                    	<input type="email" name="email" class="form-control" id="email" required="required" >
	                    </div>


	                    <div class="form-group col-sm-9">
	                    	<label for="commodity_desc">Commodity Description</label>
	                    	<input type="text" name="commodity_desc" id="commodity_desc" class="form-control" required="required">
	                    </div>

	                    <div class="form-group col-sm-3">
	                    	<label for="scope">Type of Contract</label>
	                    	<select name="contract_type" id="contract_type" class="form-control">
	                    		<option value="firm">Firm</option>
	                    		<option value="term">Term</option>
	                    	</select>
	                    </div>

	                    <div class="form-group col-sm-12">
	                    	<label for="scope">Scope</label>
	                    	<textarea type="text" name="scope" id="scope" class="form-control" cols="50" required="required"></textarea>
	                    </div>

	                    <div class="text-center"><button type="submit" id="create_bid" class="btn btn-create">Create Bid</button></div>

                    </div>
                    
                        
                    
                	</form>

                	<div class="box-footer text-center">
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
                    			</tr>
                    		</thead>
                    		<tbody>
                				
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

	$('#create_bid').click(function(e){
		e.preventDefault();
		var bid_opening_date = $('#bid_opening_date').val();
		var bid_opening_time = $('#bid_opening_time').val();
		var name = $('#name').val();
		var phone = $('#phone').val();
		var fax = $('#fax').val();
		var email = $('#email').val();
		var commodity_desc = $('#commodity_desc').val();
		var contract_type = $('#contract_type').val();
		var scope = $('#scope').val();

		if(bid_number != "" &&bid_opening_date != "" &&bid_opening_time != "" &&name != "" &&phone != "" &&fax != "" &&email != "" &&commodity_desc != "" &&contract_type != "" &&scope != ""){
			$.ajax({
				type: 'POST',
				url: "/corp-pay/get_bid",
				data: {bid_number: bid_number, bid_opening_date: bid_opening_date, bid_opening_time: bid_opening_time, name: name, phone: phone, fax: fax, email: email, commodity_desc: commodity_desc, contract_type: contract_type, scope: scope},
				dataType: 'text',
				success: function(response){
				alert(response);
				$(this).disabled = "disabled";
				$('.box-footer').css('display','block').slideDown('slow');
				},
				error: function(response){
					alert("An error occured while submitting the form.")
				}
			});
		}
		else{
			alert('please make sure you fill all the fields as required');
		}
		
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