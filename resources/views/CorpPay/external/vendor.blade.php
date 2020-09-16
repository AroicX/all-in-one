<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Vendors Bid Request</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/corppay.css')}}">
</head>
<body>
	<div class="read-this">
		<div class="company_details  text-center">
				<h3>Company Name</h3>
				{Address}
				<br>
				{City, State ZIP}
		</div>
		<h4>BID FORMAT</h4>
		<p>
			Any statement in this document that contains the word “will”, “must” or “shall” means that compliance with the intent of the statement is mandatory, and failure by the bidder to satisfy that intent will cause the bid to be rejected. 
			<br>
			All bid pricing must be in Nigerian Naira and kobo. 
			<br>
			Bids will only be accepted in the English language.
		</p>

		<h4>COST</h4>
		<p>
			All charges should be included on the Official Bid Price Sheet(s) which includes all associated costs (including but not limited to delivery, freight etc.) for the goods or services being bid.  Do not include sales taxes in unit prices. Bid pricing should be valid for 30 days following CB opening to allow sufficient time to tabulate and evaluate bid responses.
		</p>

		<h4>SCOPE</h4>
		<p>
			{{$bid->scope}}
		</p>

		<h4>TYPE OF CONTRACT</h4>
		<p>
			{{$bid->contract_type}}
		</p>

		<h4>AWARD CRITERIA AND RESPONSIBILITY</h4>
		<p>
			Bids must meet or exceed all defined specifications. Bids must meet all terms and conditions of this Competitive Bid and the laws of the State of Arkansas.
		</p>

		<h4>PAYMENT AND INVOICE PROVISIONS</h4>
		<p>
			All Invoices shall be forwarded to:
		</p>

		<button class="btn btn-info call-letter">next</button>
	</div>

	<div class="letter">
		<div class="company_details">
				<h4>Company Name</h4>
				{Address}
				<br>
				{City, State ZIP}
		</div>
		<br><br>
		<p>The agency requests delivery within _____ (Agency must set delivery time) calendar days after receipt of the order. 
			If this delivery schedule cannot be met, the bidder must state the number of days required to place the commodity in the ordering agency’s designated location.  Failure to state the delivery time obligates the bidder to complete delivery by the agency’s requested date.  Extended delivery dates may be considered when in the best interest of the State.
		</p>
		<p class="text-center">Delivery _________ calendar days after receipt of order.</p>
		<p>All deliveries must be made during normal state work hours and within the agreed upon number of days unless otherwise arranged and coordinated with the agency.  The vendor shall give the agency immediate notice of any anticipated delays or plant shutdowns that will affect the delivery requirement.
		</p>
		<p>Loss or damage that occurs during shipping, prior to the order being received by the agency, is the vendor’s responsibility. 
			All orders should be properly packaged to prevent damage during shipping.
		</p>

		<button class="btn btn-info call-form">next</button>
	</div>

	<div id="vendor">
		<div class="form-body">
			<div class="company_details  text-center">
				<h3>{{$bid->name}}</h3>
				{Address}
				<br>
				{City, State ZIP}
			</div>
			
		<div class="">
			<form>
				<div class="form-group col-sm-12">
					<label for="">Company Name</label>
					<input type="text" id="company_name" class="form-control" >
				</div>
				<div class="form-group col-sm-6">
					<label for="">Name (type or print)</label>
					<input type="text" id="name" class="form-control" >
				</div>
				<div class="form-group col-sm-6">
					<label for="">Title</label>
					<input type="text" id="title" class="form-control" >
				</div>

				<div class="form-group col-sm-12">
					<label for="">Address</label>
					<input type="text" id="address" class="form-control" >
				</div>

				<div class="form-group col-sm-4">
					<label for="">City</label>
					<input type="text" id="city" class="form-control" >
				</div>
				<div class="form-group col-sm-4">
					<label for="">State</label>
					<input type="text" id="state" class="form-control" >
				</div>
				<div class="form-group col-sm-4">
					<label for="">Zip code</label>
					<input type="text" id="zip" class="form-control" >
				</div>

				<div class="form-group col-sm-6">
					<label for="">Telephone Number</label>
					<input type="text" id="telephone" class="form-control" >
				</div>
				<div class="form-group col-sm-6">
					<label for="">Fax Number</label>
					<input type="fax" id="fax" class="form-control" >
				</div>

				<div class="form-group col-sm-12">
					<label for="">Email Address</label>
					<input type="email" id="email" class="form-control" >
				</div>

				<label class="form-group col-sm-12" for="business">Business Designation</label>
				<div class="form-group col-sm-12">
					<input type="radio" name="business" id="business" value="individual"> Individual &nbsp;&nbsp;&nbsp;
					<input type="radio" name="business" id="business" value="partnership"> Partnership &nbsp;&nbsp;&nbsp;
					<input type="radio" name="business" id="business" value="sole proprietorship"> Sole Proprietorship &nbsp;&nbsp;&nbsp;
					<input type="radio" name="business" id="business" value="public service corp"> Public Service Corp &nbsp;&nbsp;&nbsp;
					<input type="radio" name="business" id="business" value="government/non-profit"> Government/Non-profit &nbsp;&nbsp;&nbsp;
					<input type="radio" name="business" id="business" value="corporation"> Corporation &nbsp;&nbsp;&nbsp;
				</div>

				<div class="text-center"><input type="submit" name="submit" id="submit-form" class="btn btn-create"></div>
			</form>
		</div>
		</div>


	</div>

	<div id="bid-table">
		<table class="table">
			<thead>
				<tr>
					<th>S/N</th>
					<th>Item</th>
					<th>Brand</th>
					<th>Quantity</th>
					<th>Unit price</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
				<?php $counter=1 ?>
				@foreach($bid_items as $bid_item)
					<tr>
						<td class=="">{{$counter}}</td>
						<td class="name{{$counter}}">{{$bid_item->item_name}}</td>
						<td class="brand{{$counter}}">{{$bid_item->item_brand}}</td>
						<td class="q_{{$counter}}">{{$bid_item->item_quantity}}</td>
						<td><input type="number" name="" class="item" id="{{$counter}}"></td>
						<td class="item{{$counter}}">0</td>
					</tr>
        <?php $counter++ ?>
				@endforeach
			</tbody>
			
		</table>
			<div style="text-align:right">Grand Total: <span id="grand_total">0</span></div>
			<div class="text-center"><button id="bid-quote" class="btn btn-default">Save</button></div>
	</div>
</body>

<script src="{{asset('calendar/js/jquery.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function(){

	var counter = {{$counter}} - 1;
	var vendor_id = null;
	var formData = [];

	$('.call-letter').click(function(){
		$('.read-this').fadeOut();
		$('.letter').css('display','block');
	});
	$('.call-form').click(function(){
		$('.letter').fadeOut();
		$('.form-body').css('display','block');
	});

	$('#submit-form').click(function(e){
		e.preventDefault();
		formData[0] = {{$bid->bid_number}}; //0 => bid_number
		formData[1] = $('#company_name').val();  //1 =>company_name
		formData[2] = $('#name').val(); //2 => name
		formData[3] = $('#title').val(); //3 => title
		formData[4] = $('#address').val(); //4 => address
		formData[5] = $('#city').val(); //5 => city
		formData[6] = $('#state').val(); //6 => state
		formData[7] = $('#zip').val(); //7 => zip
		formData[8] = $('#telephone').val(); //8 => telephone
		formData[9] = $('#fax').val(); //9 => fax
		formData[10] = $('#email').val(); //10 => email
		formData[11] = $("input[name=business]:checked").val();
		

		$('#bid_table').css('display','block');
	});

	//code implementation of the bid_item tables for updating total and grand_total
	$('.item').on('change',function(){
		var id = $(this).attr('id');
		
		var price = $(this).val();
		var quantity = $('.q_'+id).text();
		console.log(quantity);
		quantity = parseInt(quantity);
		console.log(quantity);
		var total = price * quantity;

		$('.item'+id).text(total);

		var grand_total = 0;
		for(var i=1;i<=counter;i++){
			console.log("counter: "+ counter);
			var total = $('.item'+i).text();
			console.log("total: "+total);
			grand_total += parseInt(total);
			console.log(total);
		}
		console.log("grand: "+ grand_total);
		$("#grand_total").text(grand_total);

		});

	$("#bid-quote").click(function(){
		var bidArray = [];
		for(var i=1;i<=counter;i++){
			var item_name = $('.name'+i).text();
			var brand_name = $('.brand'+i).text();
			var quantity = $('.q_'+i).text();
			var unit_price = $('#'+i).val();
			var total = $('.item'+i).text();
			var iArray = [item_name,brand_name,quantity,unit_price,total];

			//alert(iArray);
			bidArray.push(iArray);
		}

	$.ajax({
				type: 'POST',
				url: "/add_vendor",
				data: {formData: formData, bidArray: bidArray},
				dataType: 'text',
				success: function(response){
					console.log("saved into db");
					$(this).disabled = "disabled";
				},
				error: function(response){
					alert("An error occured when trying to submit this data");
				}
		}); 
	});

	function getGrandTotal(counter){

	}


});
</script>
</html>
