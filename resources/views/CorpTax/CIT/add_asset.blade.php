@extends('CorpTax.index')

@section('content')
    <section class="content">
        <div class="row">

            <div class="col-md-12">

                <!-- general form elements -->
                <div class="box box-primary">
                	<div class="box-header">
                		<h4> Add New Asset</h4>
                	</div>

                	<form action="{{url('/dashboard/corp-tax/CIT/add_asset')}}" method="post">
                	<div class="box-body">
                		
                			<div class="form-group col-sm-6">
								<label>Category of Expenditure</label>
                					<select class="form-control" name="exp_cat" id="exp_cat">
                						@foreach($rates as $rate)
                						<option value="{{$rate->id}}">{{$rate->rates_name}}</option>
                						@endforeach
                					</select>
							</div>
							<div class="form-group col-sm-6">
								<label>Cost of Asset</label>
                					<input type="text" id="cost" name="cost" class="form-control" required="required">
							</div>
                            

                            <div class="text-center"><button id="calculate" class="btn btn-create">Calculate</button></div>

                		
                	</div>
                	<div class="box-footer" style="display:block">
                		<input type="hidden" id="asset">
                		<div class="form-group col-sm-4">
							<label>Initial Allowance Rate</label>
            				<input type="text" id="initial_allowance_rate" name="initial_allowance_rate" class="form-control" disabled="disabled">
						</div>
						<div class="form-group col-sm-4">
							<label>Annual Allowance Rate</label>
            				<input type="text" id="annual_allowance_rate" name="annual_allowance_rate" class="form-control" disabled="disabled">
						</div>
						<div class="form-group col-sm-4">
							<label>Investment Allowance Rate</label>
            				<input type="text" id="investment_allowance_rate" name="investment_alowance_rate" class="form-control" disabled="disabled">
						</div>

						<div class="form-group col-sm-4">
							<label>Initial Allowance</label>
            				<input type="text" id="init" name="initial_allowance" class="form-control" disabled="disabled">
						</div>
						<div class="form-group col-sm-4">
							<label>Annual Allowance</label>
            				<input type="text" id="ann" name="annual_allowance" class="form-control" disabled="disabled">
						</div>
						<div class="form-group col-sm-4">
							<label>Investment Allowance</label>
            				<input type="text" id="inv" name="investment_allowance" class="form-control" disabled="disabled">
						</div>
						
            				<input type="hidden" id="total" name="total" class="form-control" disabled="disabled">
						

						<div class="text-center"><button type="submit" id="save" class="btn btn-create">Save</button></div>
                	</div>
                	</form>
                </div>
                <div class="alert alert-success" style="display:none">New Asset added</div>
            </div>
        </div>
    </section>    

@stop
@section('script')
<script type="text/javascript">
$(document).ready(function(){
var init_all,ann_all,inv_all = 0;
var asset;
$('#calculate').click(function(){
	var id = $('#exp_cat').val();
	var cost = $('#cost').val();
	$('#exp_cat').disabled = 'disabled';
	$.ajax({
				type: 'POST',
				url: "/dashboard/corp-tax/CIT/get_rate",
				data: {id: id},
				dataType: 'json',
				success: function(response){
					init_all = parseInt(response.initial_allowance);
					ann_all = parseInt(response.annual_allowance);
					inv_all = response.investment_allowance != null ? parseInt(response.investment_allowance) : 0;
					asset = response.rates_name;
					$('#initial_allowance_rate').val(init_all);
					$('#annual_allowance_rate').val(ann_all);
					$('#investment_allowance_rate').val(inv_all);
					$('#asset').val(asset);

					var init = (init_all / 100) * cost;
					var ann = (cost - init) * (ann_all / 100);
					if(inv_all == 0){
						var inv = 0;
					}
					else{
						var inv = (inv_all / 100) * cost ;
					}

					$('#init').val(init);
					$('#ann').val(ann);
					$('#inv').val(inv);

					var total = init + ann + inv;
					$('#total').val(total);
				},
				error: function(response){
					alert("An error occured when trying to submit this data");
				}
			}); 
	$(this).hide();
	
	return false;
});

$('#save').click(function(){
	var formData = [];
	formData[0]= $('#asset').val();
	formData[1] = $('#cost').val();
	formData[2] = $('#initial_allowance_rate').val();
	formData[3] = $('#annual_allowance_rate').val();
	formData[4] = $('#investment_allowance_rate').val();
	formData[5] = $('#init').val();
	formData[6] = $('#ann').val();
	formData[7] = $('#inv').val();
	formData[8] = $('#total').val();

	$.ajax({
				type: 'POST',
				url: "/dashboard/corp-tax/CIT/add_asset",
				data: {formData: formData},
				dataType: 'text',
				success: function(response){
					$('.alert').css('display','block');
				},
				error: function(response){
					alert("An error occured when trying to submit this data");
				}
			}); 
	return false;
});

});
</script>
@stop