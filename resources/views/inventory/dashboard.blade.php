<!doctype html>
<html>
<title>Inventory </title>
@include('includes.Head')
<meta id="token" name="token" content="{ { csrf_token() } }">
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
@include('includes.Header')

  @include('includes.Menu')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
      
        <br>
    @include('includes.status')
    <!-- Main content -->
     	<div class="container">
     		<div class="row">
     			<div class="col-sm-10 col-sm-offset-1">
     				<div class="row">
                          <div class="col-lg-12 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>Orders</h3>

                            <p>Procurement Reports</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{url('inventory/order/')}}" class="small-box-footer">View Orders <i class="fa fa-arrow-circle-right"></i></a>
                        <a href="{{url('inventory/order/create')}}" class="small-box-footer">Add Order <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-12 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>My Products</h3>
                            <p>New Applications</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{route('product.index')}}" class="small-box-footer">View Products <i class="fa fa-arrow-circle-right"></i></a>
                        <a href="{{route('product.create')}}" class="small-box-footer">Add Product <i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-12 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>My Warehouses</h3>

                            <p>Total Revenue</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('warehouse.index')}}" class="small-box-footer">View Warehouses <i class="fa fa-arrow-circle-right"></i></a>
                        <a href="{{route('warehouse.create')}}" class="small-box-footer">Register Warehouse <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-12 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>Product Lines</h3>

                            <p>Completed Payments</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{route('productline.index')}}" class="small-box-footer">View Product Lines <i class="fa fa-arrow-circle-right"></i></a>
                    	<a href="{{route('productline.create')}}" class="small-box-footer">Add Product Line <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-12 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>My Shops</h3>
                            <p>Successful Engagements</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{route('shop.index')}}" class="small-box-footer">View Shops <i class="fa fa-arrow-circle-right"></i></a>
                        <a href="{{route('shop.create')}}" class="small-box-footer">Register Shop <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                   <div class="col-lg-12 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>My Customers</h3>

                            <p>Total Revenue</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('customer.index')}}" class="small-box-footer">View Customers <i class="fa fa-arrow-circle-right"></i></a>
                        <a href="{{route('customer.create')}}" class="small-box-footer">Register Customer <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
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