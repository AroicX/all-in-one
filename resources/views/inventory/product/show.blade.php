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
                        <tr> <th>Barcode</th><td><?php  echo DNS2D::getBarcodeHTML($product->barcode, "QRCODE")  ?> </td> </tr>
                        @if($pli_exists == true)
                                @foreach($product_lines as $product_line)
                                    @if($pli->product_id == $product_line->id)
                                     <tr><th>Product Line</th><td>{{$product_line->name}}</td></tr>
                                    @endif
                            @endforeach    

                        @endif
                        <tr><th>Serial No</th><td>{{$product->serial_no}}</td></tr>
                        <tr><th>Description</th><td>{{$product->description}}</td></tr>
                        <tr><th>Store Keeping Unit</th><td>{{$product->SKU}}</td></tr>
                        <tr><th>Margin Control</th><td>{{$product->margin_control}}</td></tr>
                        <tr><th>Price Method</th><td>{{$product->price_method}}</td></tr>
                        <tr><th>Price Setting</th><td>{{$product->price_setting}}</td></tr>
                    
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <a class="btn btn-warning btn-large" href="{{route('product.edit', $product->id)}}">Edit Product</a>
                    </div>
                    <div class="col-md-3">
                        <form method="post" action="{{route('product.destroy', $product->id)}}">
                            
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button class="btn btn-danger btn-large" type="submit">Delete Product</button>
                        </form>
                      
                    </div>
                    <div class="col-md-3">
                        <?php $order = $product->order()->first(); ?>
                        @if($order->status != "Received")
                        <a class="btn btn-success btn-large" href="#" disabled>Add Batch</a>
                        @else
                        <a class="btn btn-success btn-large" href="{{url('/create_batch', $product->id)}}">Add Batch</a>
                        @endif
                        
                    </div>
                    <div class="col-md-3">
                    @if($pli_exists == true)
                        <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal2">Edit Product Line</button>
                        @else 
                         <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal">Add Product Line</button>
                     @endif   
                        
                    </div>
                </div>
            </div>
            <br>
            <div class="card-header">
                <h5>Product Batches</h5>
            </div>
            <div class="card-body table-border-style">
              <table class="table table-striped">
                    <thead>
                        <th>#Ref</th>
                        <th>Quantity</th>
                        <th>Margin threshold</th>
                        <th>Unit selling cost</th>
                        <th>Details</th>
                    </thead>
                    <tbody>
                        @foreach($batches as $batch)
                          <tr>
                              <td>{{$batch->id}}</td>
                              <td>{{$batch->quantity_ordered}}</td>
                              <td>{{$batch->margin_threshold}}</td>
                              <td>{{$batch->unit_cost_sold}}</td>
                              <td><a class="btn btn-primary" href="{{route('batch.show', $batch->id)}}"><i class ="fa fa-eye"></i></a></td>
                          </tr>  
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Product Line</h4>
      </div>
      <div class="modal-body">
        
        <form class="form-horizontal" action="{{url('/store_product_line_item')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="product_id" value="{{$product->id}}">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-1">
                    
                <div class="form-group">
                    <label>Product Line</label>
                    <select name="product_line_id" class="form-control">
                        <option disabled selected>Select Product Line</option>
                        @foreach($product_lines as $product_line)
                        <option value="{{$product_line->id}}">{{$product_line->name}}</option>
                        @endforeach
                    </select>
                </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8 col-sm-offset-1">
                    <label>Reorder Level</label>
                    <input type="text" name="reorder_level" class="form-control" placeholder = "Reorder Level">
                </div>
            </div>
             <div class="row">
                <div class="col-sm-8 col-sm-offset-1">
                    <label>Reorder Quantity</label>
                    <input type="text" name="reorder_quantity" class="form-control" placeholder = "Reorder Quantity">
                </div>
            </div>
             <div class="row">
                <div class="col-sm-8 col-sm-offset-1">
                    <label>Overhead Allocation</label>
                    <input type="text" name="overhead_allocation" class="form-control" placeholder = "Overhead Allocation">
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Submit</button>
        </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Product Line</h4>
      </div>
      <div class="modal-body">
      @if($pli_exists == true)
       <form class="form-horizontal" action="{{url('/store_product_line_item')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="product_id" value="{{$product->id}}">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-1">
                    
                <div class="form-group">
                    <label>Product Line</label>
                    <select name="product_line_id" class="form-control">
                        @foreach($product_lines as $product_line)
                        <option value="{{$product_line->id}}">{{$product_line->name}}</option>
                        @endforeach
                    </select>
                </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8 col-sm-offset-1">
                    <label>Reorder Level</label>
                    <input type="text" name="reorder_level" value="{{$pli->reorder_level}}" class="form-control" placeholder = "Reorder Level">
                </div>
            </div>
             <div class="row">
                <div class="col-sm-8 col-sm-offset-1">
                    <label>Reorder Quantity</label>
                    <input type="text" name="reorder_quantity" value="{{$pli->reorder_quantity}}" class="form-control" placeholder = "Reorder Quantity">
                </div>
            </div>
             <div class="row">
                <div class="col-sm-8 col-sm-offset-1">
                    <label>Overhead Allocation</label>
                    <input type="text" name="overhead_allocation" value="{{$pli->overhead_allocation}}" class="form-control" placeholder = "Overhead Allocation">
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Submit</button>
        </form>
      @endif
  </div>
</div>
</div>
</div>
<script src="{{asset('js/general/Setup.js')}}"></script>

@endsection