@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Product Details</h5>
                <span class="d-block m-t-5">Products</span>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table table-striped">
                       <tr> <th>Barcode</th><td>{{$product->barcode}}</td> </tr>
                        <tr><th>Batch No</th><td>{{$product->batch_no}}</td></tr>
                        <tr><th>Description</th><td>{{$product->description}}</td></tr>
                        <tr><th>Store Keeping Unit</th><td>{{$product->SKU}}</td></tr>
                        <tr><th>Margin Control</th><td>{{$product->margin_control}}</td></tr>
                        <tr><th>Price Method</th><td>{{$product->price_method}}</td></tr>
                        <tr><th>Price Setting</th><td>{{$product->price_setting}}</td></tr>
                    
                    </table>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-5">
                            <a class="btn btn-primary btn-large" href="{{route('product.show', $product->id)}}">View Product</a>
                        </div>
                      
                    </div>
                </div>
            </div>
            <br>
            <div class="card-header">
                <h5>Batch Details</h5>
            </div>
            <div class="card-body table-border-style">
                <table class="table table-striped">
                   <tr> <th>Quantity Ordered</th><td>{{$batch->quantity_ordered}}</td> </tr>
                   <tr><th>Quantity Remaining</th><td>{{$batch->quantity}}</td></tr>
                    <tr><th>Total Invoice cost</th><td>{{$batch->total_invoice_cost}}</td></tr>
                    
                    <tr><th>Selling cost/unit</th><td>{{$batch->unit_cost_sold}}</td></tr>
                </table>
                <div class="row">
                    <div class="col-md-3">
                        <a class="btn btn-warning btn-large" href="{{route('batch.edit', $batch->id)}}">Edit Batch</a>
                    </div>
                    <div class="col-md-3">
                        <form method="post" action="{{route('batch.destroy', $batch->id)}}">
                            
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button class="btn btn-danger" type="submit">
                                Delete Batch
                            </button>
                        </form>
                    </div>
                    <div class="col-md-3">
                        <a href="{{url('/move/batch', $batch->id)}}" class="btn btn-success">Move Product</a>
                    </div>
                    <div class="col-md-3">
                        <a href="" class="btn btn-primary">View Report</a>
                    </div>
                </div>  
            </div>
            
            <div class="row">
                <div class="col-sm-6">
                    <div class="card-header">
                        Warehouse Movements
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <th>Moved From</th>
                                    <th>Moved to</th>
                                    <th>Quantity moved</th>
                                    <th>Shipping</th>
                                    <th>Damages</th>
                                    <th>Handling</th>
                                   
                                </thead>
                                <tbody>
                                    @foreach($warehouse_movement  as $wm)
                                       <tr> 
                                        <?php $from = App\inventory\Warehouse::find($wm->from)  ?>
                                        <td>{{$from->name}}</td>
                                       <?php $to = App\inventory\Warehouse::find($wm->to)  ?>
                                        <td>{{$to->name}}</td>
                                       
                                           <td>{{$wm->quantity_moved}}</td>
                                           <td>{{$wm->shipping}}</td>
                                           <td>{{$wm->damages}}</td>
                                           <td>{{$wm->handling}}</td>
                                           
                                       </tr> 
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card-header">
                        Shop Movements
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                     <th>Moved From</th>
                                    <th>Moved to</th>
                                    <th>Quantity moved</th>
                                    <th>Shipping</th>
                                    <th>Damages</th>
                                    <th>Handling</th>
                                   
                                </thead>
                                <tbody>
                                    @foreach($shop_movement as $sm)
                                       <tr>
                                            <?php $shop = App\inventory\Shop::find($sm->shop_id); ?>
                                            <?php $to = App\inventory\Warehouse::find($sm->from);  ?>
                                            <td>{{$to->name}}</td>
                                            <td>{{$shop->name}}</td>
                                           <td>{{$sm->quantity_moved}}</td>
                                           <td>{{$sm->shipping}}</td>
                                           <td>{{$sm->damages}}</td>
                                           <td>{{$sm->handling}}</td>
                                            </tr> 
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirm Receipt of Inventory</h4>
      </div>
      <form class="form-horizontal" id = "confirm_receipt">
          <div class="modal-body">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <form class="form-horizontal" action="" method="post">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label>Quantity received</label>
                                    <input type="text" name="quantity" class="form-control">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
          </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" data-dismiss="modal">Confirm</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>

<script src="{{asset('js/general/Setup.js')}}"></script>
<script type="text/javascript">
    $("#confirm_receipt").attr("action", "http://www.test.com");​
</script>
@endsection