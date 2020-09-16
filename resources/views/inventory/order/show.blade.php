@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5> Order Details</h5>
                <span class="d-block m-t-5">Products</span>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table table-striped"> 
                        <tr><th>Total Invoice cost</th><td>{{number_format($order->total_invoice_cost, 2)}}</td></tr>
                        <tr><th>Shipping</th><td>{{number_format($order->shipping, 2)}}</td></tr>
                        <tr><th>Commission</th><td>{{number_format($order->commission, 2)}}</td></tr>
                        <tr><th>Clearing</th><td>{{number_format($order->clearing,2)}}</td></tr>
                        <tr><th>Insurance</th><td>{{number_format($order->insurance,2)}}</td></tr>
                        <tr><th>Miscellaneous</th><td>{{number_format($order->other_costs, 2)}}</td></tr>
                        <tr><th>Amount Paid</th><td>{{number_format($order->amount_paid, 2)}}</td></tr>
                        <tr><th>Balance</th><th>{{number_format($order->total - $order->amount_paid, 2)}}</th></tr>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <a class="btn btn-warning btn-large center" href="{{url('inventory\order\edit', $order->id)}}">Edit Order</a>
                    </div>
                    <div class="col-md-4">
                        <form method="post" action="{{url('inventory\order\destroy', $order->id)}}">
                            
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button class="btn btn-danger" type="submit">
                                Delete Order
                            </button>
                        </form>
                    </div>
                    
                    <div class="col-md-4">
                          <div class="btn-group" role="group" aria-label="...">
                         

                      <div class="btn-group" role="group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Options
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a href="{{url('inventory\product\create', $order->id)}}" >Add Product</a></li>
                          @if(empty($order->date_received))
                          
                          <li><a href="#" data-toggle="modal" data-target="#order-receipt">Confirm order receipt</a></li>
                          @endif    
                          @if($order->total > $order->amount_paid)
                          <li><a href="#" data-toggle="modal" data-target="#payment-modal">Record payment</a></li>
                          @endif
                        </ul>
                      </div>
                    </div>
                    </div>

                  

                    <!-- button group -->
                </div>
            </div>
            <div class="card-header">
                <h5>Products Ordered</h5>
                <span class="d-block m-t-5">Products</span>
            </div>
            <div class="card-body table-border-style">
                <div  class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Serial No</th>
                                <th>Description</th>
                                <th>Store Keeping Unit</th>
                                <th>View Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                        <tr>
                            <td>{{$product->barcode}}</td>
                            <td>{{$product->serial_no}}</td>
                            <td>{{$product->description}}</td>
                            <td>{{$product->SKU}}</td>
                            <td><a class="btn btn-primary" href="{{route('product.show', $product->id)}}"><i class = "fa fa-eye"></i></a></td>
                        </tr>
                    @endforeach
                        @if(count($products) < 1)
                            <p>You have not added any products to this order. <a href="{{url('inventory\product\create', $order->id)}}" class="btn btn-primary">Add Product</a></p>
                        @endif
                        <p></p>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- order receipt modal -->
    <!-- Modal -->
        <div id="order-receipt" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Receipt of Inventory</h4>
              </div>
              <form class="form-horizontal" method="post" action="{{url('inventory/confirm_order', $order->id)}}">
              <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Date received</label>
                                         <div class="input-group date" data-provide="datepicker">
                                            <input type="text" name="date_received" id="date_received"
                                                   placeholder="Select Date received" class="form-control  date" value="{{old('date_received')}}" required>
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                              @if ($errors->has('date_received'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('date_received') }}</strong>
                                    </span>
                                    @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Describe Inventory</label>
                                        <select name="description" class="form-control" required>
                                        <option selected disabled>Choose...</option>
                                            
                                            @foreach(App\SubAccount::where('account_id', 3)->get() as $inventory)
                                            @if($inventory->id != 13)
                                                <option value="{{$inventory->id}}">{{$inventory->name}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                     @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                    </div>
                                </div>
                              
                            </div>
                        
                    </div>
                </div>
              </div>
              <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Confirm</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
              </form>
            </div>

          </div>
        </div>
        <!-- end order receipt -->
        <!-- order receipt modal -->
    <!-- Modal -->
        <div id="payment-modal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Record Payment</h4>
              </div>
              <form class="form-horizontal" method="post" action="{{url('inventory/order/update', $order->id)}}">
              <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Payment Date</label>
                                         <div class="input-group date" data-provide="datepicker">
                                            <input type="text" name="payment_date" id="payment_date"
                                                   placeholder="Select payment date" class="form-control  date" value="{{old('payment_date')}}" >
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Amount Paid</label>
                                        <input type="text" name="amount_paid" placeholder="0.00" class="form-control" value="{{old('amount_paid')}}">
                                          @if ($errors->has('amount_paid'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('amount_paid') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                </div>
              </div>
              <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Confirm</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
              </form>
            </div>

          </div>
        </div>
        <!-- end order receipt -->  
@if($errors->first('date_received') || $errors->first('description')  || $errors->first('warehouse_id'))
<script type="text/javascript">
    $("#order-receipt").modal()
</script>

@endif
@if($errors->first('payment_date') || $errors->first('amount_paid'))

<script type="text/javascript">
    $("#payment-modal").modal()
</script>

@endif


@if(session('status'))
  <script type="text/javascript">
        Command: toastr["success"]("Saved!")
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
  </script>

@endif
<script type="text/javascript">
        $(".date").datepicker({ 
         format:'dd-mm-yyyy',
  defaultDate:  "0d",
  maxDate: 0,
  minDate: new Date(01, 01, 2000)
});


</script>
@endsection
