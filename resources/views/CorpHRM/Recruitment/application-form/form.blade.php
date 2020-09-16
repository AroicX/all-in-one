<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
@foreach($company_details as $company_detail)
<title>{{$company_detail->name}} Job Application Form</title>
@endforeach
<!-- Add to Head -->
<meta name="viewport" content="width=device-width,initial-scale=1.0" />
<!-- <script src="//s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script> -->
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" />
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" />
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js" type="text/javascript"></script>
<script src='//www.google.com/recaptcha/api.js'></script> -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css" rel="stylesheet" />
<!-- <script language="JavaScript" type="text/javascript" src="https://code.jquery.com/jquery-1.11.2.min.js"></script> -->
<!-- <script language="JavaScript" type="text/javascript" src="{{asset('application/js/jquery.validate.min.js')}}"></script> -->
<!-- <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" /> -->
<link rel="stylesheet" href="{{asset('application/css/html5reset.css')}}" media="all">
<link rel="stylesheet" href="{{asset('application/css/col.css')}}" media="all">
<link rel="stylesheet" href="{{asset('application/css/1cols.css')}}" media="all">
<link rel="stylesheet" href="{{asset('application/css/2cols.css')}}" media="all">
<!-- jQuery Form Validation code -->

<style>
.container {
    margin-top: 1%;
}

input{
border-radius: 0px !important;
}
select{
border-radius: 0px !important;
}
</style>
</head>
<body>
<div class="margin">

<div id="Information-Modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="text-align:center;">Kindly read through the Following Carefully before you proceed!</h4>
            </div>
            <div class="modal-body">
                <p>
                <br>
                <br>
                    @foreach($results as $result)
                    @foreach($results2 as $result2)
                        <p><b>Branch</b>: {{$result->qualification_details}}</p>
                        <hr>
                        <p><b>Location</b>: {{$result2->location}}</p>
                        <hr>
                        <p><b>Designation</b>: {{$result->designation}}</p>
                        <hr>
                        <p><b>Job Description</b>: {{$result->job_description}}</p>
                        <hr>
                        <p><b>Years Of Experience</b> : {{$result2->years_of_experience}}</p>
                        <hr>
                       <p><b>Qualification Details</b> : {{$result->qualification_details}}</p>
                       <hr>
                       <p><b>Experience Details</b> : {{$result->experience_details}}</p>
                       <hr>
                       <p><b>Skill Details</b> : {{$result->skill_details}}</p>
                       <hr>
                       @if(!empty($result2->other_details))
                       <p><b>Other Details</b> : {{$result2->other_details}}</p>
                       @endif
                    @endforeach
                    @endforeach
                    <br>
                    <br>
                </p>

            </div>
            <div class="modal-footer">
              <div class="pull-left">
              <p><input type="checkcard" id="agree" name="agree">&nbsp;&nbsp;&nbsp;I Agree </p></div>
              <button class="btn btn-sm btn-success pull-right" id="agreebtn" disabled="">Proceed</button>
            </div>
        </div>
    </div>
</div>

 <!--form-->

<center> 
<br>
@foreach($company_details as $company_detail)
@if(!empty($company_detail->logo))
<p ><img src="{{url($company_detail->logo)}}" style="width:200px;"></p>  
@endif
@if(empty($company_detail->logo))
<h1>{{$company_detail->name}}</h1>
@endif
<br>
<p>Job Application Portal</p>
<br> 
<p>
  <strong>Phone</strong> : {{$company_detail->phone}}, <strong>Email-Address</strong>: {{$company_detail->email}}
</p>
<hr>
@endforeach     
</center>
<br>
<br>
<div class="container">
<div class="row" style="margin-bottom: 50px;">
<div class="col-md-10 col-md-offset-1" style=" height: auto; padding: 10px; -webkit-card-shadow: 0 0 5px 2px grey; -moz-card-shadow: 0 0 5px 2px grey; card-shadow: 0 0 5px 2px grey;">
 @include('includes.errors')
<br>
<form method="post" action="{{route('corphrm.postapplicationform')}}" enctype='multipart/form-data'>
@foreach($results as $result)
<input type="hidden" name="app_id" value="{{$result->id}}">
@endforeach
<p style="font-weight: 600; text-align: center;"> Personal Information</p>
<hr>
  <div class="col-md-6">
    <div class="form-group">
      <label>First Name<span style="color: red;">*</span></label>
      <input type="text" class="form-control" name="fname" required="">
    </div>
  </div>
    <div class="col-md-6">
    <div class="form-group">
      <label>Last Name<span style="color: red;">*</span></label>
      <input type="text" class="form-control" name="lname" required="">
    </div>
  </div>
<div class="col-md-6">
  <div class="form-group">
    <label>Title<span style="color: red;">*</span></label>
    <select class="form-control" name="alias" required="">
     <option value="Mr">Mr</option>
     <option value="Mrs">Mrs</option>
     <option value="Miss">Miss</option> 
    </select>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label>Marital Status<span style="color: red;">*</span></label>
    <select class="form-control" name="marital_status" required="">
     <option value="Single">Single</option>
     <option value="Married">Married</option>
    </select>
  </div>
</div>
    <div class="col-md-6">
    <div class="form-group">
      <label>Age<span style="color: red;">*</span></label>
      <input type="number" class="form-control" name="age" required="">
    </div>
  </div>
    <div class="col-md-6">
    <div class="form-group">
      <label>Qualifications<span style="color: red;">*</span></label>
      <input type="text" class="form-control" name="qualification" placeholder="Bsc., Msc., HND, Phd ..." required="">
    </div>
  </div>
      <div class="col-md-6">
    <div class="form-group">
      <label>Address<span style="color: red;">*</span></label>
      <input type="text" class="form-control" name="address" required="">
    </div>
  </div>
      <div class="col-md-6">
    <div class="form-group">
      <label>City<span style="color: red;">*</span></label>
      <input type="text" class="form-control" name="city" required="">
    </div>
  </div>
      <div class="col-md-6">
    <div class="form-group">
      <label>State<span style="color: red;">*</span></label>
      <input type="text" class="form-control" name="state" required="">
    </div>
  </div>
      <div class="col-md-6">
    <div class="form-group">
      <label>Country<span style="color: red;">*</span></label>
      <input type="text" class="form-control" name="country" required="">
    </div>
  </div>
        <div class="col-md-6">
    <div class="form-group">
      <label>Email<span style="color: red;">*</span></label>
      <input type="email" class="form-control" name="email" required="">
    </div>
  </div>
        <div class="col-md-6">
    <div class="form-group">
      <label>Phone Number<span style="color: red;">*</span></label>
      <input type="text" class="form-control" name="phone" required="">
    </div>
  </div>

<div class="file-section" style="margin-top: 50px !important;">
<br>
<br>
<p style="font-weight: 600; text-align: center;">
Attachements
</p>
<hr>
      <div class="col-md-6">
    <div class="form-group">
      <label>CV Upload [pdf,png,jpg]<span style="color: red;">*</span></label>
      <input type="file" class="form-control" name="cv_file" accept=".pdf,image*" required="">
    </div>
  </div>
      <div class="col-md-6">
    <div class="form-group">
      <label>Other Files [pdf,png,jpg]</label>
      <input type="file" class="form-control" name="other_file" accept=".pdf,image*">
    </div>
  </div>
  </div>

  <div class="job-history-section" style="margin-top: 50px !important;">
<br>
<br>
<p style="font-weight: 600; text-align: center;">
Job History
</p>
<hr>
        <div class="col-md-6">
    <div class="form-group">
      <label>Last Employer</label>
      <input type="text" class="form-control" name="last_employer">
    </div>
  </div>
          <div class="col-md-6">
    <div class="form-group">
      <label>Last Salary</label>
      <input type="text" class="form-control" name="last_salary">
    </div>
  </div>

        <div class="col-md-12">
    <div class="form-group">
      <label>Nature Of Employment</label>
      <textarea class="form-control" name="nature_of_employment"></textarea>
    </div>
  </div>
</div>

  <div class="others-section" style="margin-top: 50px !important;">
<br>
<br>
<p style="font-weight: 600; text-align: center;">
Others
</p>
<hr>
        <div class="col-md-12">
    <div class="form-group">
      <label>Comment</label>
      <textarea class="form-control" name="Comment"></textarea>
    </div>
  </div>
</div>
<div class="col-md-12">
  <div class="form-group">
   <button type="Submit" class="btn btn-primary pull-right" style="border-radius: 0px; margin: 5px;">Submit</button>
    <button type="reset" value="Reset" class="btn btn-warning pull-right" style="border-radius: 0px; margin: 5px;" >Reset</button>
  </div>
</div>
<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
</form>

</div>

</div>


 <!--End Form-->

</div>
<footer style="">
  <p style="text-align: center;">© <?php echo date('Y'); ?> @foreach($company_details as $company_detail){{$company_detail->name}}@endforeach. All Rights Reserved </p>
<br>
</footer>
</body>
<script type="text/javascript">
$(window).on('load',function(){
  $('#Information-Modal').modal({backdrop: 'static', keyboard: false});
        $('#Information-Modal').modal('show');
    });

$(document).ready(function() {
   var the_terms = $("#agree");
   var agreebtn = $("#agreebtn");
    the_terms.click(function() {
        if ($(this).is(":checked")) {
            $("#agreebtn").removeAttr("disabled");
        } else {
            $("#agreebtn").attr("disabled", "disabled");
        }
    });

    agreebtn.click(function() {
      $(function () {
         $('#Information-Modal').modal('toggle');
      });
    });

});
</script>
</html>
