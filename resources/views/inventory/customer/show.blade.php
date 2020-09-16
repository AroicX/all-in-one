<!doctype html>
<html>
<title>CorpERM </title>
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
				<section class="content" id="blockUI" style="background:#fff !important; margin-left:10px; margin-right:50px;">
				
                <div class="row">
                    <div class="col-sm-8 col-md-offset-2">
                    <h1>Customer details</h1>
                        <table class="table table-striped">
                            <tr><th>Name</th><td>{{$customer->title}} {{$customer->lastname}} {{$customer->middle_name}} {{$customer->first_name}}</td></tr>
                            <tr><th>Email</th><td>{{$customer->email}}</td></tr>
                            <tr><th>Website</th><td>{{$customer->website}}</td></tr>
                            <tr><th>Customer Group</th><td>{{$customer->customer_group}}</td></tr>
                            <tr><th>Tax/Vat Number</th><td>{{$customer->tax_vat}}</td></tr>
                            <tr><th>DOB</th><td>{{date('F d, Y', strtotime($customer->DOB)) }}</td></tr>
                            <tr><th>Gender</th><td>{{$customer->gender}}</td></tr>
                            <tr><th>Additional Information</th><td>{{$customer->additional_info}}</td></tr>
                        </table>
                        <div class="row">
                            <div class="col-sm-4">
                                <a href="#" class="btn btn-primary">Customer Report</a>
                            </div>
                            <div class="col-sm-4">
                                <a href="{{route('customer.edit', $customer->id)}}" class="btn btn-warning">Edit Customer</a>
                            </div>
                            <div class="col-sm-4">
                                <form action="{{route('customer.destroy', $customer->id)}}" method="post">
                                {{ method_field('DELETE')}}
                                    {{ csrf_field()}}
                                    <button class="btn btn-danger">Delete Customer</button>
                                </form>
                                    
                            </div>
                        </div>
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
<script src="{{asset('js/general/Setup.js')}}"></script>
</body>
</html>
