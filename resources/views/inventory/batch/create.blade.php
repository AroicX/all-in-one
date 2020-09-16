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
	<div class="container">
		<div class="row">
			<div class = "col-sm-12">
				<section class="content" id="blockUI" style="background:#fff !important; margin-left:10px; margin-right:50px;">
				<h3>New Batch | {{$product->barcode}}</h3>
            <!-- Small boxes (Stat box) -->
            <form  action="{{route('batch.store')}}" method="post">
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label>Quantity ordered</label>
                                    <input type="text" name="quantity_ordered" class="form-control" placeholder="Enter quantity ordered"
                                           required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                  
                                <label>Warehouse stored</label>
                                <select class="form-control" name="warehouse_id">
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
                                    <label>Manufacturer's Batch Number</label>
                                    <input type="text" name="man_batch_no" class="form-control" placeholder="Enter manufacturer's batch number for product"
                                          >
                                </div>
                            </div>
                            <div class="col-sm-6">

                                <div class="form-group" style="">
                                    <label>Cost of goods/unit</label>
                                    <input type="text" name="unit_cost_sold" class="form-control" placeholder="0.00"
                                           required>
                                </div>
                                
                            </div>
                           
                        </div>

                         <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Margin Threshold</label>
                                <input type="text" name="margin_treshold" class="form-control" placeholder="Enter batch margin threshold">
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
        </section>
			</div>
		</div>
	</div>
    </div>
    <!-- /.content-wrapper -->
    @include('includes.Footer')
    @include('includes.Sidebar')
</div>
<!-- ./wrapper -->
@include('includes.Includes')
<script src="{{asset('js/general/Setup.js')}}"></script>
</body>
</html>