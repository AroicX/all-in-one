@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5> Edit Order</h5>
                <span class="d-block m-t-5">Orders</span>
            </div>
            <div class="card-body table-border-style">
                <form  action="{{url('inventory/order/update', $order->id)}}" method="post">
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                 <div class="col-sm-6">
                                    <div class="form-group" style="">
                                        <label>Purchase Date</label>
                                        <input type="date" name="purchase_date" class="form-control" placeholder="yyyy-mm-dd"
                                            value="{{$order->purchase_date}}"   required>
                                    </div>
                                </div>
                              
                               
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label>Total invoice costs</label>
                                        <input type="text" name="total_invoice_cost" class="form-control"
                                             value="{{$order->total_invoice_cost}}"  placeholder="Total invoice costs" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label>Shipping costs</label>
                                        <input type="text" name="shipping" class="form-control"
                                             value="{{$order->shipping}}"  placeholder="Shipping costs" required>
                                    </div>
                                </div>
                                 <div class="col-sm-6">

                                    <div class="form-group">
                                        <label>Clearing costs</label>
                                        <input type="text" name="clearing" class="form-control"
                                             value="{{$order->clearing}}"  placeholder="Enter clearing costs" required>
                                    </div>
                                </div>
                              
                            </div>

                            <div class="row">
                                
                                <div class="col-sm-6">

                                    <div class="form-group" style="">
                                        <label>Insurance</label>
                                        <input type="text" name="insurance" class="form-control" placeholder="Enter insurance costs"
                                            value="{{$order->insurance}}"   >
                                    </div>
                                        </div>
                                   <div class="col-sm-6">
                                     <div class="form-group">
                                        <label>Miscellaneous costs</label>
                                       <input type="text" name="other_costs" class="form-control" placeholder="Enter other costs"
                                            value="{{$order->other_costs}}"  >
                                    </div>
                                   </div>
                                
                            </div>

                            <div class="row">
                                 <div class="col-sm-6">
                                    <div class="form-group" style="">
                                        <label>Commission</label>
                                        <input type="text" name="commission" class="form-control" placeholder="Enter margin threshold"
                                            value="{{$order->commission}}"   >
                                    </div>
                                </div>
                              
                               
                            </div>

                            <br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@if($errors->first('amount_paid') || $errors->first('payment_date'))

<script type="text/javascript">
     $(".payment").show();
       
</script>
@endif
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