@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Add Order</h5>
                <span class="d-block m-t-5">Orders</span>
            </div>
            <div class="card-body table-border-style">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form  action="{{url('inventory/order/store')}}" method="post">
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="row">
                                         <div class="col-md-12">
                                            <div class="form-group {{ $errors->has('supplier_name') ? ' has-error' : '' }}" style="">
                                                <label>Supplier's Name</label>
                                                <input type="text" name="supplier_name" class="form-control"
                                                     value="{{old('supplier_name')}}"  required>
                                                       @if ($errors->has('supplier_name'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('supplier_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                       
                                    </div>
                                    <div class="row">
                                         <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('purchase_date') ? ' has-error' : '' }}" style="">
                                                <label>Order Date</label>
                                               
                                                 <div class="input-group date" data-provide="datepicker">
                                                            <input type="date" name="purchase_date" id="purchase_date"
                                                                   placeholder="Select Order Date" class="form-control  date" value="{{old('purchase_date')}}" required>
                                                            <div class="input-group-addon">
                                                                <span class="glyphicon glyphicon-th"></span>
                                                            </div>
                                                        </div>
                                                 @if ($errors->has('purchase_date'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('purchase_date') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                      
                                       
                                        <div class="col-md-6">
            
                                            <div class="form-group {{ $errors->has('total_invoice_cost') ? ' has-error' : '' }}">
                                                <label>Total invoice costs</label>
                                                <input type="text" name="total_invoice_cost" class="form-control"
                                                       placeholder="0.00" value="{{old('total_invoice_cost')}}" required>
                                             @if ($errors->has('total_invoice_cost'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('total_invoice_cost') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
            
                                    <div class="row">
                                        <div class="col-md-6">
            
                                            <div class="form-group {{ $errors->has('shipping') ? ' has-error' : '' }}">
                                                <label>Shipping costs</label>
                                                <input type="text" name="shipping" class="form-control"
                                                       placeholder="0.00" value="{{old('shipping')}}" required>
                                                @if ($errors->has('shipping'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('shipping') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                         <div class="col-md-6">
            
                                            <div class="form-group {{ $errors->has('clearing') ? ' has-error' : '' }}">
                                                <label>Clearing costs</label>
                                                <input type="text" name="clearing" class="form-control"
                                                       placeholder="0.00" value="{{old('clearing')}}" required>
                                                @if ($errors->has('clearing'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('clearing') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                      
                                    </div>
            
                                    <div class="row">
                                        
                                        <div class="col-md-6">
            
                                            <div class="form-group {{ $errors->has('insurance') ? ' has-error' : '' }}" style="">
                                                <label>Insurance</label>
                                                <input type="text" name="insurance" class="form-control" placeholder="0.00" value="{{old('insurance')}}"
                                                       >
                                                @if ($errors->has('insurance'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('insurance') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                                </div>
                                           <div class="col-md-6">
                                                <div class="form-group {{ $errors->has('other_costs') ? ' has-error' : '' }}">
                                                <label>Miscellaneous costs</label>
                                               <input type="text" name="other_costs" class="form-control" placeholder="0.00"
                                                    value="{{old('other_costs')}}"  >
                                                       @if ($errors->has('other_costs'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('other_costs') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                           </div>
                                        
                                    </div>
            
                                    <div class="row">
                                         <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('commission') ? ' has-error' : '' }}" style="">
                                                <label>Commission</label>
                                                <input type="text" name="commission" class="form-control" placeholder="0.00"
                                                     value="{{old('commission')}}"  >
                                                       @if ($errors->has('commission'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('commission') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                           <div class="col-md-6">
                                            <div class="form-group" style="">
                                                <label>Payment Status</label>
                                                <select name="payment_status" id="payment_status" class="form-control" value="{{old('payment_status')}}" required>
                                                    <option disabled="" selected="">Select Payment Status</option>
                                                    <option value="Not yet paid">Not yet paid</option>
                                                    <option value="Paid">Paid</option>
                                                </select>
                                            </div>
                                        </div>
                                       
                                    </div>
                                    
                                    <div class="row payment " style="display: none;">
                                         <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('amount_paid') ? ' has-error' : '' }}" style="">
                                                <label>Amount Paid</label>
                                                <input type="text" name="amount_paid" id = "amount_paid" class="form-control" placeholder="0.00"
                                                      value="{{old('amount_paid')}}" >
                                                       @if ($errors->has('amount_paid'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('amount_paid') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                           <div class="col-md-6">
                                            <div class="form-group{{ $errors->has('payment_date') ? ' has-error' : '' }}" style="">
                                                <label>Payment Date</label>
                                                <div class="input-group date" data-provide="datepicker">
                                                        <input type="text" name="payment_date" id="payment_date"
                                                               placeholder="Select Payment Date" class="form-control  date" value="{{old('payment_date')}}" >
                                                        <div class="input-group-addon">
                                                            <span class="glyphicon glyphicon-th"></span>
                                                        </div>
                                                    </div>
                                                          @if ($errors->has('payment_date'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('payment_date') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                       
                                    </div>
            
                                    <br>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
   
</div>

<script type="text/javascript">
    $(".date").datepicker({ 
     format:'dd-mm-yyyy',
defaultDate:  "0d",
maxDate: 0,
minDate: new Date(01, 01, 2000)
});
//validation

//show the amount paid box
$("#payment_status").change(function(){
if($(this).val() == "Paid"){
    $(".payment").show();
    $("#amount_paid").attr('required', true);
    $("#payment_date").attr('required', true);
}
else{
     $(".payment").hide();
    
    $("#amount_paid").attr('required', false);
    $("#payment_date").attr('required', false);
}
});
</script>

@endsection
