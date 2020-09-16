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
	<div class="container">
		<div class="row">
			<div class = "col-sm-12">
				<section class="content" id="blockUI" style="background:#fff !important; margin-left:10px; margin-right:50px;">
				<h3>Customers</h3>
            	<table class="table table-striped">
            	<thead>
                        <th>#Ref</th>
            		<th>Name</th>
            		<th>Email</th>
            		<th>Customer Group</th>
            		    <th>View Details</th>
            	</thead>
            	<tbody>
            		@foreach($customers as $customer)
            			<tr>
            				<td>{{$customer->id}}</td>
            				<td>{{$customer->title}} {{$customer->lastname}} {{$customer->middle_name}} {{$customer->first_name}}</td>
            				<td>{{$customer->email}}</td>
            				<td>{{$customer->customer_group}}</td>
                                   
            				<td><a class="btn btn-primary" href="{{route('customer.show', $customer->id)}}"><i class = "fa fa-eye"></i></a></td>
            			</tr>
            		@endforeach
            	</tbody>		
            	</table>
        		</section>
			</div>
		</div>
	</div></div>
    <!-- /.content-wrapper -->
    @include('includes.Footer')
    @include('includes.Sidebar')
</div>
<!-- ./wrapper -->
@include('includes.Includes')
<script src="{{asset('js/general/Setup.js')}}"></script>
</body>
</html>
