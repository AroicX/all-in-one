<!DOCTYPE html>
<html>
<title>CORPFIN | Company Setup</title>
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
    <section class="content-header">
      <h1>
       
            <p style="text-transform:uppercase;">Setup Your Company - General Information</p>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="">Setup</li>
         <li class="active">General Information</li>
      </ol>
    </section>
<br>
 @include('includes.status')
    <!-- Main content -->
    <section class="content" id="blockUI" style="background:#fff !important; margin-left:10px; margin-right:10px;">
      <!-- Small boxes (Stat box) -->
      <form id="setup1" action="{{url('corpfin/setup2')}}" method="post">
      <div class="alert alert-danger display-hide" style="text-align:center;" id="val_fail">
                    <button class="close" data-close="alert"></button>
                    <span>Company Name Already Exist!</span>
                </div>

<div class="alert alert-danger display-hide" style="text-align:center;" id="empty">
                    <button class="close" data-close="alert"></button>
                    <span>Fill in all Fields!</span>
                </div>
                <div class="alert alert-danger display-hide" style="text-align:center;" id="empty">
                    <button class="close" data-close="alert"></button>
                    <span>Unable to Process Request. Try Again!</span>
                </div>
      <br>
<div class="row">
<div class="col-md-12">
<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
<div class="row">
  <div class="col-sm-6">
    
                        <div class="form-group">
                        <label>Company Name</label>
 <input type="text" name="name" class="form-control"  placeholder="Enter Company Name" required>
                </div>
  </div>
    <div class="col-sm-6">
    
                        <div class="form-group">
                        <label>Company Registration Number (If Applicable)</label>
 <input type="text" name="crn" class="form-control" placeholder="Enter Company Registration Number" required>
                </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-6">
    
                        <div class="form-group">
                        <label>Business Address</label>
 <input type="text" name="address" class="form-control" placeholder="Business Address" required>
                </div>
  </div>
    <div class="col-sm-6">
    
                        <div class="form-group">
                        <label>Country</label>
        <select class="selectpicker form-control country" id="country" data-live-search="true" name="country" placeholder="" required>
             <option value="">Choose Country</option>
             @foreach (\App\Country::all() as $country)
      <option value="{{ $country->name }}" id="{{ $country->id }}" >
      {{ $country->name }}
      </option>
                 @endforeach
             </select>
                </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-6">
                        <div class="form-group">
                        <label>State</label>
             <select id="state" data-live-search="true" name="state" class="form-control" required></select>
                </div>
  </div>
    <div class="col-sm-6">
    
                        <div class="form-group" style="">
                        <label>City</label>
 <input type="text" name="city" class="form-control" placeholder="Enter City" required>
                </div>

                <td id="test">
                  
                </td>
  </div>
</div>

<div class="row">
  <div class="col-sm-6">
    
                        <div class="form-group" style="">
                        <label>Phone Number</label>
 <input type="text" name="phone" class="form-control"  placeholder="Phone Number" required>
                </div>
  </div>
    <div class="col-sm-6">
    
                        <div class="form-group" style="">
                        <label>Email-Address</label>
 <input type="text" name="email" class="form-control" placeholder="Email Address" required>
                </div>
  </div>
</div>
<br>
<div class="form-group">
  <button class="btn btn-primary btn-block">Next</button>
</div>
</div>
</div>
</form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
   @include('includes.Footer') 
@include('includes.Sidebar')
</div>
<!-- ./wrapper -->
 @include('includes.Includes')

 <script type="text/javascript">
    $("#country").change(function(e){
      console.log(e);
        var id = $('#country :selected').attr('id');
        $.ajax({
            type: "GET",
            url: "{{ url('') }}/corpfin/getstates/"+id,
       // dataType: "html",
        success: function(data)
        {
       $('#state').empty();
for(var key in data){
  var name = data[key].name;
  var sel = document.getElementById('state');
    var opt = document.createElement('option');
     opt.text = data[key].name;
     opt.value = data[key].name;
     sel.appendChild(opt);

}
}
        });
    });
</script>
<script type="text/javascript">
  $("input").keypress(function(event) {
            if (event.which == 13) {
                event.preventDefault();
                $("#setup1").submit();
            }
        });
 $('#setup1').submit(function (e) {
    e.preventDefault();
    url = $(this).attr('action');
    $('#empty').hide();
    $('#val_fail').hide();
    $('#fail').hide();
if ($('[name|="name"]').val() == "" || $('[name|="crn"]  ').val() == "" || $('[name|="address"]  ').val() == "" ){
$('#empty').show();
return false;
            };
            App.blockUI({ 
                target: '#blockUI',
                boxed: true,
                textOnly: true,
                message: '<img src="{{asset('img/spinner.gif')}}" /> Just a moment...'
            });
                        postData = $(this).serialize();
            $.ajax({
                url: url,
                type:'post',
beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));},
                data: postData,
                dataType:'json',
                success: function(data){
                    if (data.result == 'success') {
                       window.location.href = '{{ url('corpfin/setup') }}';
                       // alert("OKK");
                    }
                    if (data.result == 'val_fail'){
                        App.unblockUI('#blockUI');
                        $('#val_fail').show();
                    }
                    if (data.result == 'fail') {
                        App.unblockUI('#blockUI');
                        $('#fail').show();
                    }
                }
            })
  });
</script>
</body>
</html>
