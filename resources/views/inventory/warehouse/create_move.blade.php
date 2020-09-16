<!doctype html>
<html>
<title>ManRetail | Warehouse</title>
@include('CorpFIN.includes.Head')
<meta id="token" name="token" content="{ { csrf_token() } }">
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    @include('CorpFIN.includes.Header')
            <!-- Left side column. contains the logo and sidebar -->
    @if(Auth::user()->Corpfin_menutype == "Traditional")
        @include('CorpFIN.includes.Traditional_menu')
    @else
        @include('CorpFIN.includes.Diary_menu')
    @endif


<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
      
        <br>
    @include('includes.status')
    <!-- Main content -->

 <section class="content" id="blockUI" style="background:#fff !important; margin-left:10px; margin-right:10px;">
          	<h1>Move Batch</h1>
     
           <ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#home">Move to warehouse</a></li>
  <li><a data-toggle="tab" href="#menu1">Move to shop</a></li></ul>

<div class="tab-content">
  <div id="home" class="tab-pane fade in active">
     <form  action="{{url('/store_warehouse_movement')}}" method="post">

                <br>
                <div class="row">
                    <div class="col-md-12">
                     <input type="hidden" name="url" id="url" value="{{url('')}}">
                       
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      

                        <div class="row">
                              <div class="col-sm-6">
                                   <div class="form-group">
                                  
                                <label>From Warehouse </label>
                                <select class="form-control" name="from">

                                    <option disabled selected="">Select warehouse</option>
                                    @foreach(App\inventory\Warehouse::where('company_id', Auth::user()->company_id)->get() as $warehouse)
                                     @foreach(App\WarehouseProduct::where('batch_id' , $batch->id )->get() as $wp)
                                     @if($wp->warehouse_id == $warehouse->id && $wp->quantity > 0)
                                     <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>   
                                        @endif
                                     @endforeach   
                                    @endforeach
                                    
                                </select>
                              </div>
                              </div>
                              <div class="col-sm-6">
                                  
                         
                                <div class="form-group">
                                  
                                <label>To Warehouse </label>
                                <select class="form-control" name="to">
                                    <option disabled selected="">Select warehouse</option>
                                    @foreach(App\inventory\Warehouse::where('company_id', Auth::user()->company_id)->get() as $warehouse)
                                     @if($warehouse->name != "Transit warehouse")
                                     <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>   
                                        @endif
                                    @endforeach
                                    
                                </select>
                              </div>
                              </div>
                           
                        </div>

                        <div class="row">
                           
                            <div class="col-sm-6">

                                <div class="form-group" style="">
                                    <label>Damages</label>
                                    <input type="text" name="damages" class="form-control" placeholder="Enter Damages"
                                           required>
                                </div>
                            </div>
                               <div class="col-sm-6">

                                <div class="form-group" style="">
                                    <label>Handling Charges</label>
                                    <input type="text" name="handling" class="form-control" placeholder="Enter Handling Charges"
                                           required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                         <div class="col-sm-6">
                                 <div class="form-group" style="">
                                    <label>Shipping Cost</label>
                                    <input type="text" name="shipping" class="form-control" placeholder="Enter Shipping costs"
                                           required>
                                </div>
                                
                            </div>
                          <div class="col-sm-6">
                            <div form-group>
                              <label>Quantity Moved</label>
                              <input type="text" name="quantity_moved" class="form-control" placeholder = "Enter Quantity of products moved" required>
                            </div>
                            <input type="hidden" name="batch_id" value="{{$batch->id}}">
                            <input type="hidden" name="from" value="{{$batch->warehouse_id}}">
                          </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Move Batch</button>
                        </div>
                    </div>
                </div>
            </form>
  </div>
  <div id="menu1" class="tab-pane fade">
     <form  action="{{url('/shop_movement')}}" method="post" id="shop_move">

                <br>
                <div class="row">
                    <div class="col-md-12">
                     <input type="hidden" name="url" id="url" value="{{url('')}}">
                       
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      
                        <input type="hidden" name="type" value="" id="type">
                        <div class="row">
                        <div class="col-sm-6">
                                   <div class="form-group">
                                  
                                <label>From Warehouse/Shop </label>
                                <select class="form-control" name="from" id="shop_from" required>

                                    <optgroup label="Warehouses">
                                     @foreach(App\inventory\Warehouse::where('company_id', Auth::user()->company_id)->get() as $warehouse)
                                     @foreach(App\WarehouseProduct::where('batch_id' , $batch->id )->get() as $wp)
                                     @if($wp->warehouse_id == $warehouse->id && $wp->quantity > 0)
                                     <option value="{{$warehouse->id}}" class="warehouse">{{$warehouse->name}}</option>   
                                        @endif
                                     @endforeach   
                                    @endforeach 
                                    </optgroup>
                                     <optgroup label="Shops">
                                       @foreach(App\inventory\Shop::where('company_id', Auth::user()->company_id)->get() as $shop)
                                     @foreach(App\inventory\ShopProduct::where('batch_id' , $batch->id )->get() as $sp)
                                     @if($sp->shop_id == $shop->id && $sp->quantity > 0)
                                     <option value="{{$shop->id}}" class="shop">{{$shop->name}}</option>   
                                        @endif
                                     @endforeach   
                                    @endforeach
                                     </optgroup>
                                     
                                </select>
                              </div>
                              </div>
                              <div class="col-sm-6">
                                  
                            <div class="form-group">
                                  
                                <label>Shop </label>
                                <select class="form-control" name="shop_id" required>
                                    <option disabled selected="">Select shop</option>
                                    @foreach(App\inventory\Shop::where('company_id', Auth::user()->company_id)->get()  as $shop)
                                     <option value="{{$shop->id}}">{{$shop->name}}</option>   
                                    @endforeach
                                    
                                </select>
                              </div>
                              </div>
                           
                        </div>

                        <div class="row">
                           
                            <div class="col-sm-6">

                                <div class="form-group" style="">
                                    <label>Damages</label>
                                    <input type="text" name="damages" class="form-control" placeholder="Enter Damages"
                                           >
                                </div>
                            </div>
                               <div class="col-sm-6">

                                <div class="form-group" style="">
                                    <label>Handling Charges</label>
                                    <input type="text" name="handling" class="form-control" placeholder="Enter Handling Charges"
                                           >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                         <div class="col-sm-6">
                                 <div class="form-group" style="">
                                    <label>Shipping Cost</label>
                                    <input type="text" name="shipping" class="form-control" placeholder="Enter Shipping costs"
                                          >
                                </div>
                                
                            </div>
                          <div class="col-sm-6">
                            <div form-group>
                              <label>Quantity Moved</label>
                              <input type="text" name="quantity_moved" class="form-control" placeholder = "Enter Quantity of products moved" required>
                            </div>
                            <input type="hidden" name="batch_id" value="{{$batch->id}}">
                            
                          </div>
                        </div>
                       
                        <br>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Move Batch</button>
                        </div>
                    </div>
                </div>
            </form>
  </div>
  
</div>
        </section>
       </div>
    <!-- /.content-wrapper -->
    @include('includes.Footer')
    @include('includes.Sidebar')
</div>
<!-- ./wrapper -->
@include('includes.Includes')
<script type="text/javascript">
    $("#shop_from").change(function(){
      var value = $("#shop_from option:selected").attr("class");
      if(value == "shop"){
        $("#shop_move").attr('action', '/shop_shop');
        $("#type").val('shop');
      }
      else{
       $("#shop_move").attr('action', '/shop_movement'); 
       $("#type").val('warehouse'); 
      }
    });

</script>
<script src="{{asset('js/general/Setup.js')}}"></script>
</body>
</html>
