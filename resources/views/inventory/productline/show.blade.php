@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
          <h5>Product Line Details</h5>
          <span class="d-block m-t-5">Line Details</span>
      </div>
      <div class="card-body table-border-style">
        <table class="table table-striped">       
            <tr> <th>Name</th><td>{{$productline->name}}</td> </tr>
            <tr><th>Addtional Information</th><td>{{$productline->additional_info}}</td></tr>
        </table>
        <div class="row">
            <div class="col-md-4">
                <a class="btn btn-warning btn-large" href="{{route('productline.edit', $productline->id)}}">Edit shop</a>
            </div>
            <div class="col-md-4">
                <form method="post" action="{{route('productline.destroy', $productline->id)}}" enctype="multipart/form-data">
                    
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button class="btn btn-danger btn-large" type="submit">Delete shop</button>
                </form>
              
            </div>
            <div class="col-md-4">
                <a class="btn btn-primary btn-large" href="{{route('productline.index')}}">Back</a>
            </div>
        </div> 
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Products
                </div>
                <div class="panel-body">
                  
            <table class="table 
            table-striped">
                <thead>
                    <th>Product Barcode</th>
                    <th>Product Name</th>
                    <th>Reorder Level</th>
                    <th>Reorder Quantity</th>
                    <th>Overhead Allocation</th>

                </thead>
                <tbody>
                    @foreach($productline_items as $pl_item)
                        <tr>
                        @foreach($products as $product)
                            @if($product->id == $pl_item->product_id)
                            <td>{{$product->barcode}}</td>
                            <td>{{$product->name}}</td>
                            @endif
                            <td>{{$pl_item->reorder_level}}</td>
                            <td>{{$pl_item->reorder_quantity}}</td>
                            <td>{{$pl_item->overhead_allocation}}</td>
                        @endforeach    
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
<script src="{{asset('js/general/Setup.js')}}"></script>

@endsection

