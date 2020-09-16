@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
          <h5>Warehouse Details </h5>
          <span class="d-block m-t-5">Warehouse</span>
      </div>
      <div class="card-body table-border-style">
        <table class="table table-striped">
        
           <tr> <th>Name</th><td>{{$warehouse->name}}</td> </tr>
            <tr><th>Address</th><td>{{$warehouse->address}}</td></tr>
            <tr><th>City</th><td>{{$warehouse->city}}</td></tr>
            <tr><th>Sate/Region</th><td>{{$warehouse->state}}</td></tr>
            <tr><th>Country</th><td>{{$warehouse->country}}</td></tr>
        
        </table>
        <div class="row">
            <div class="col-md-3">
                <a class="btn btn-warning btn-large" href="{{route('warehouse.edit', $warehouse->id)}}">Edit warehouse</a>
            </div>
            <div class="col-md-3">
                <form method="post" action="{{route('warehouse.destroy', $warehouse->id)}}">
                    
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button class="btn btn-danger btn-large" type="submit">Delete warehouse</button>
                </form>
              
            </div>
            <div class="col-md-3">
                <a class="btn btn-primary btn-large" href="{{route('warehouse.index')}}">Back</a>
            </div>

            <div class="col-md-3">
                <a class="btn btn-primary btn-large" href="#" data-toggle="modal" data-target="#ledger">Ledger</a>
            </div>
        </div>
      </div>
      <div class="card-header">
          <h5>Warehouse Movements</h5>
      </div>
      <div class="card-body table-border-style">
        <table class="table table-striped">
          <thead>
              <th>Moved From</th>
              <th>Quantity moved</th>
              <th>Quantity Received</th>
              <th>Confirm</th>warehouse
          </thead>
          <tbody>
              @foreach(App\inventory\WarehouseMovement::where('to', $warehouse->id)->get()  as $wm)
                 <tr> 
                  <?php $from = App\inventory\Warehouse::find($wm->from)  ?>
                  <td>{{$from->name}}</td>
                
                     <td>{{$wm->quantity_moved}}</td>
                     <td>{{$wm->quantity_received}}</td>
                     @if($wm->status == "Confirmed")
                     <td>Confirmed</td>
                     @else
                     <td><a href="#" class="btn btn-success wm" id="{{$wm->id}}" data-toggle="modal" data-target="#myModal"><i class="fa fa-check"></i></a></td>
                 
                     @endif
                     </tr> 
              @endforeach
          </tbody>
        </table>
      </div>
      <div class="card-header">
          <h5>Products in Store</h5>
      </div>
      <div class="card-body table-border-style">
        <table class="table table-striped">
          <thead>
              <th>Batch ref</th>
              <th>Product Description</th>
              <th>Quantity in store</th>
              <th>Return</th>
          </thead>
          <tbody>
              
                  @foreach($warehouseproduct as $product)
                  <tr>
                      @if($product->quantity > 0)
                          <td>{{$product->batch_id}}</td>
                          @foreach($products as $prod)
                              @if($prod->id == $product->product_id)
                          <td>{{$prod->description}}</td>    
                              @endif
                          @endforeach
                          <td>{{$product->quantity}}</td>
                          <td><a href="#" class="btn btn-danger products" id="{{$product->batch_id}}" data-toggle="modal" data-target="#return">Return</a></td>
                      @endif
                       </tr>
                  @endforeach
             
          </tbody>
      </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="return" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Return to supplier</h4>
      </div>
      <form class="form-horizontal" id = "return" method="post" action="{{url('/inventory/return')}}">
          <div class="modal-body">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                        {{csrf_field()}}
                        <input type="hidden" name="batch_id" value="" id="return_batch_id" required>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label>Quantity returned</label>
                                    <input type="text" name="quantity" value="{{old('quantity_returned')}}" class="form-control">
                                    @if($errors->has('quantity_returned'))
                                        <span class="help-block">{{$errors->first('quantity_returned')}}</span>
                                    @endif
                                </div>
                               
                            </div>
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label>Amount refunded</label>
                                    <input type="text" name="amount_returned" placeholder="0.00" value="{{old('amount_returned')}}" class="form-control">
                                    @if($errors->has('amount_returned'))
                                        <span class="help-block">{{$errors->first('amount_returned')}}</span>
                                    @endif
                                </div>
                               
                            </div>
                            <div class="col-md-10 col-md-offset-1">
                                 <div class="form-group">
                                    <label>Reason for returning product</label>
                                   <textarea name="note" class="form-control"></textarea>
                                     @if($errors->has('note'))
                                        <span class="help-block">{{$errors->first('note')}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                   
                </div>
            </div>
          </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" >Confirm</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>
<!-- end modal -->
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirm Receipt of Inventory</h4>
      </div>
      <form class="form-horizontal" id = "confirm_receipt" method="post" action="">
          <div class="modal-body">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label>Quantity received</label>
                                    <input type="text" name="quantity" value="{{old('quantity')}}" class="form-control">
                                    @if($errors->has('quantity'))
                                        <span class="help-block">{{$errors->first('quantity')}}</span>
                                    @endif
                                </div>
                               
                            </div>
                            <div class="col-md-10 col-md-offset-1">
                                 <div class="form-group">
                                    <label>Date received</label>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="text" name="date_received" id="date_received" 
                                                class="form-control date" value="{{old('date_received')}}">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                     @if($errors->has('date_received'))
                                        <span class="help-block">{{$errors->first('date_received')}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                   
                </div>
            </div>
          </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" >Confirm</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>
<!-- end modal -->
<!-- Modal -->
<div id="ledger" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ledger</h4>
      </div>
      <div class="row">
          <div class="col-md-10 col-md-offset-1">
              <table class="table table-striped table-hover">
                               <caption class="center"><h4>General Ledger</h4></caption>
                           <thead>
                               <tr>
                                   <th>Date</th>
                                   <th>Description</th>
                                   <th>Memo</th>
                                   <th>Transaction</th>
                                   <th>Balance</th>
                               </tr>
                               
                           </thead>
                           <tbody>
                               <tr>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                   <td>
                                        <table class="table">
                                            <thead><tr>
                                                <th>Debit</th>
                                                <th>Credit</th>
                                            </tr></thead>
                                        </table>

                                   </td>
                                   <td>
                                        <table class="table">
                                            <thead><tr>
                                                <th>Debit</th>
                                                <th>Credit</th>
                                            </tr></thead>
                                        </table>

                                   </td>
                               </tr>
                               <tr>
                                   <td></td>
                                   <td></td>
                                   <th>TOTAL</th>
                                   <td>
                                        <table class="table table-bordered">
                                            <thead><tr>
                                                <th class="success">{{number_format($debit_sum, 2)}}</th>
                                                <th class="danger">{{number_format($credit_sum, 2)}}</th>
                                            </tr></thead>
                                        </table>

                                   </td>
                                   <td>
                                        <table class="table">
                                            <thead><tr>
                                                <th class="info">{{number_format($debit_sum, 2)}}</th>
                                                <th class="info">{{number_format($credit_sum, 2)}}</th>
                                            </tr></thead>
                                        </table>

                                   </td>
                               </tr>
                               @foreach($ledgers as $ledger)
                                 <tr>
                                   <td>{{$ledger->date}}</td>
                                   <td>{{$ledger->description}}</td>
                                   <td>{{$ledger->acc_name}}</td>
                                  
                                   <td>
                                        <table class="table table-bordered">
                                            <tbody><tr>
                                                <td class="success">N{{number_format($ledger->Dr, 2)}}</td>
                                                <td class="danger">N{{number_format($ledger->Cr, 2)}}</td>
                                            </tr></tbody>
                                        </table>

                                   </td>
                                   <td>
                                        <table class="table">
                                            <tbody><tr>
                                                 <?php?>   
                                                <td class="info">N{{number_format($debit_sum -= $ledger->Dr, 2 )}}</td>
                                                <td class="warning">N{{number_format($credit_sum -= $ledger->Cr, 2 )}}</td>
                                            </tr></tbody>
                                        </table>

                                   </td>
                               </tr>
                               @endforeach
                           </tbody>
                       </table>
          </div>
      </div>
    </div>

  </div>
</div>

@if($errors->has('quantity') || $errors->has('date_received'))
    <script type="text/javascript">
        $("#myModal").modal();
    </script>
@endif
@if($errors->has('quantity')  || $errors->has('amount_returned') )

@endif
<script src="{{asset('js/general/Setup.js')}}"></script>
<script type="text/javascript">

    $(".wm").click(function(){
        var id = $(this).attr('id');
        $("#confirm_receipt").attr("action", "/inventory/confirm_movement/"+id+"");
       
    });

    $(".products").click(function(){
        var id = $(this).attr('id');
        $("#return_batch_id").val(id);
        //alert($("#return").attr('action'));
    });
    // $("#return").submit(function(e){
    //   e.preventDefault();
    //   alert($("#return").attr('action'));
    // })

        $(".date").datepicker({ 
         format:'dd-mm-yyyy',
          defaultDate:  "0d",
          maxDate: 0,
          minDate: new Date(01, 01, 2000)
        });

</script>
@endsection