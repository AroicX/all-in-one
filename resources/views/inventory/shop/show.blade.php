@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Shop Details</h5>
                <span class="d-block m-t-5">Shops</span>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table table-striped">
                       <tr> <th>Name</th><td>{{$shop->name}}</td> </tr>
                        <tr><th>Address</th><td>{{$shop->address}}</td></tr>
                        <tr><th>City</th><td>{{$shop->city}}</td></tr>
                        <tr><th>Sate/Region</th><td>{{$shop->state}}</td></tr>
                        <tr><th>Country</th><td>{{$shop->country}}</td></tr>
                    
                    </table>
                </div>
                <div class="row">
                  <div class="col-md-3">
                      <a class="btn btn-warning btn-large" href="{{route('shop.edit', $shop->id)}}">Edit shop</a>
                  </div>
                  <div class="col-md-3">
                      <form method="post" action="{{route('shop.destroy', $shop->id)}}">
                          
                          {{ method_field('DELETE') }}
                          {{ csrf_field() }}
                          <button class="btn btn-danger btn-large" type="submit">Delete shop</button>
                      </form>
                    
                  </div>
                  <div class="col-md-3">
                      <a class="btn btn-primary btn-large" href="{{route('shop.index')}}">Back</a>
                  </div>
                  <div class="col-md-3">
                      <a class="btn btn-success btn-large" href="#" data-toggle="modal" data-target="#ledger">Ledger</a>
                  </div>
              </div> 
            </div>
            <br>
            <div class="card-header">
                <h5>Warehouse Movements</h5>
            </div>
            <div class="card-body table-border-style">
              <table class="table table-striped">
                <thead>
                    <th>Moved From</th>
                    <th>Quantity moved</th>
                    <th>Quantity Received</th>
                    <th>Confirm</th>
                </thead>
                <tbody>
                    @foreach(App\inventory\ShopMovement::where('shop_id', $shop->id)->get()  as $sm)
                       <tr> 
                        <?php $from = App\inventory\Warehouse::find($sm->from)  ?>
                        <td>{{$from->name}}</td>
                      
                           <td>{{$sm->quantity_moved}}</td>
                           <td>{{$sm->quantity_received}}</td>
                           @if($sm->status == "Confirmed")
                           <td>Confirmed</td>
                           @else
                           <td><a href="#" class="btn btn-primary sm" id="{{$sm->id}}" data-toggle="modal" data-target="#myModal"><i class="fa fa-check"></i></a></td>
                       
                           @endif
                           </tr> 
                    @endforeach
                </tbody>
            </table>
            </div>
            <br>
            <div class="card-header">
                <h5>Products in Store</h5>
            </div>
            <div class="card-body table-border-style">
              <table class="table table-striped">
                <thead>
                    <th>Batch ref</th>
                    <th>Product Description</th>
                    <th>Quantity in store</th>
                </thead>
                <tbody>
                     @foreach($shop_products as $product)
                        <tr>
                            @if($product->quantity > 0)
                                <td>{{$product->batch_id}}</td>
                                @foreach($products as $prod)
                                    @if($prod->id == $product->product_id)
                                <td>{{$prod->description}}</td>    
                                    @endif
                                @endforeach
                                <td>{{$product->quantity}}</td>
                            @endif
                             </tr>
                        @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/general/Setup.js')}}"></script>

@endsection
