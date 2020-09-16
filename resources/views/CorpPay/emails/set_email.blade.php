@extends('CorpPay.layout.base')

@section('content')
	<section class="content">
		 <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                @if(isset($success))
                <div class="alert alert-success">* Email Template succesfully {{$success}}</div>
                @endif
                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">Email Settings</h3>
                    </div>

                    <form action="{{url('/corp-pay/set_email')}}" method="post">
                    	{{csrf_field()}}
                    <div class="box-body">
	                    <div class="form-group col-sm-4">
	                    	<label for="type">Type</label>
	                    	<select name="type" class="form-control">
	                    		<option value="price_quote">Price Quote</option>
	                    		<option value="purchase_order">Purchase Order</option>
	                    		<option value="invoice">Invoice</option>
	                    	</select>
	                    </div>

	                    <div class="form-group col-sm-9">
	                    	<label for="content">Title</label>
	                    	<input type="text" name="title" id="title" class="form-control" required="required">
	                    </div>

	                    <div class="form-group col-sm-9">
	                    	<label for="content">Content</label>
	                    	<textarea name="content" id="content" class="form-control" rows="10" required="required"></textarea>
	                    </div>

	                    <div class="col-sm-12 text-center"><button type="submit" id="create_bid" class="btn btn-create">Create Template</button></div>

                    </div>
                	</form>

                </div>
            </div>
        </div>
	</section>

	
@stop

@section('script')
<script type="text/javascript">
</script>
@stop