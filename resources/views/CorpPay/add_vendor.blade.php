@extends('CorpPay.layout.base')

@section('content')
	<section class="content">
		<div class="row">

            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">Add New Vedor</h3>
                    </div>

                    <div class="box-body with-border">
                    	@if(count($errors) > 0)
	                		<div class="alert alert-danger">
	                			<ul>
	                				@foreach($errors->all() as $error)
	                					<li>{{$error}}</li>
	                				@endforeach
	                			</ul>
	                		</div>
	                	@endif
	                	@if(isset($success))
	                	<div class="alert alert-success">Vendor added to the Vendors List</div>
	                	@endif
						<form action="{{url('/corp-pay/add_new_vendor')}}" method="post" id="">
							<div class="form-group col-sm-3">
								<label for="">Bid Number</label>
								<input type="text" id="bid_number" name="bid_number" class="form-control" required="required">
							</div>
							<div class="form-group col-sm-9">
								<label for="">Company Name</label>
								<input type="text" name="company_name" id="company_name" class="form-control" required="required">
							</div>
							<div class="form-group col-sm-6">
								<label for="">Name (type or print)</label>
								<input type="text" name="name" id="name" class="form-control" required="required">
							</div>
							<div class="form-group col-sm-6">
								<label for="">Title</label>
								<input type="text" name="title" id="title" class="form-control" required="required">
							</div>

							<div class="form-group col-sm-9">
								<label for="">Address</label>
								<input type="text" name="address" id="address" class="form-control" required="required">
							</div>

							<div class="form-group col-sm-4">
								<label for="">City</label>
								<input type="text" name="city" id="city" class="form-control" required="required">
							</div>
							<div class="form-group col-sm-4">
								<label for="">State</label>
								<input type="text" name="state" id="state" class="form-control" required="required">
							</div>
							<div class="form-group col-sm-4">
								<label for="">Zip code</label>
								<input type="text" name="zip_code" id="zip" class="form-control" required="required">
							</div>

							<div class="form-group col-sm-6">
								<label for="">Telephone Number</label>
								<input type="text" name="telephone" id="telephone" class="form-control" required="required">
							</div>
							<div class="form-group col-sm-6">
								<label for="">Fax Number</label>
								<input type="fax" name="fax" id="fax" class="form-control" required="required">
							</div>

							<div class="form-group col-sm-9">
								<label for="">Email Address</label>
								<input type="email" name="email" id="email" class="form-control" required="required">
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

							<div class="text-center col-sm-12"><input type="submit" name="submit" class="btn btn-create" value="Add Vendor"></div>
							
						</form>
		
                    </div>
            	</div>
        	</div>
        </div>
	</section>	
@stop

@section('script')
<script type="text/javascript">

</script>
@stop