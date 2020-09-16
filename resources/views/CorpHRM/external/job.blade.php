<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Job Application</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/corphrm.css')}}">
</head>
<body>
	<div id="landing-page">
		<h3 class="text-center">Job Application Page</h3>
		<button id="to-form-page" class="btn btn-info btn-sm next">Next</button>
	</div>

	<div id="form-page">
		<div class="text-center">
			<h3 >Application Form</h3>
			<h4>Personal Info</h4>
		</div>
		
		<form>
				<div class="row">
					<div class="form-group col-sm-3">
						<label for="">Title</label>
						<input type="text" id="company_name" class="form-control" >
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-3">
						<label for="">First Name</label>
						<input type="text" id="first_name" class="form-control" >
					</div>
					<div class="form-group col-sm-3">
						<label for="">Middle Name</label>
						<input type="text" id="middle_name" class="form-control" >
					</div>
					<div class="form-group col-sm-6">
						<label for="">Last Name</label>
						<input type="text" id="last_name" class="form-control" >
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-3">
						<label for="">Gender</label>
						<input type="text" id="company_name" class="form-control" >
					</div>
					
					
				</div>





				<div class="form-group col-sm-6">
					<label for="">Name (type or print)</label>
					<input type="text" id="name" class="form-control" >
				</div>
				<div class="form-group col-sm-6">
					<label for="">Title</label>
					<input type="text" id="title" class="form-control" >
				</div>
			</form>
	</div>


	
</body>
<script src="{{asset('calendar/js/jquery.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#to-form-page').click(function(){
		$('#landing-page').fadeOut();
		$('#form-page').css('display','block');
	});
});
</script>
</html>