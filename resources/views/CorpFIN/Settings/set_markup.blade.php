<!DOCTYPE html>
<html>
<title>CORPFIN | Markup</title>
 @include('CorpFIN.includes.Head')
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
        CorpFIN
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('corpfin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="javasctipt:void(0)">Settings</li>
        <li class="active">Payment Method</li>
      </ol>
    </section>

 <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        
        <!-- right column -->
        <div class="col-md-12">
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Markup</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
              </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding" id="BlockUI">
                <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                    <form class="form-horizontal" method="post" action="{{url('/corpfin/settings/markup')}}">
                        {{csrf_field()}}
                      <div class="row">
                      <?php $company = App\Company::find(Auth::user()->company_id);
                            $markup = $company->markup()->first();  ?>
                        <div class="col-md-10 col-md-offset-1">
                          <div class="form-group">
                              <label >Markup Type</label>
                              <select name="type" class="form-control" id="type" required>
                                @if(count($markup) > 0)
                                <option value="{{$markup->type}}">{{$markup->type}}</option>
                                @else
                                <option disabled="true" selected="true">Select Markup type</option>
                                @endif
                                <option value="fixed">Fixed(%)</option>
                                <option value="custom">Custom (User defined)</option>
                              </select>
                              @if($errors->has('type'))
                              <span class="help-block">{{$errors->first('type')}}</span>
                              @endif
                          </div>
                        </div>
                        <div class="col-md-10 col-md-offset-1">
                          <div class="form-group">
                              <label >Value % (optional)</label>
                              @if(count($markup) > 0 && $markup->type != "custom")
                                <input type="text" name="value" class="form-control" id="value" value="{{$markup->value}}" disabled="true">
                                @else
                               <input type="text" name="value" class="form-control" id="value" placeholder="0.00" disabled="true">
                                @endif

                              @if($errors->has('value'))
                              <span class="help-block">{{$errors->first('value')}}</span>
                              @endif
                          </div>
                        </div>
                        <div class="col-md-5 col-md-offset-5">
                          <div class="form-group">
                              <button class="btn btn-success"><i class="fa fa-check"></i> Save Changes</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                           
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- Horizontal Form -->
          
          
          <!-- /.box -->
        </div>
       
      </div>
      <!-- /.row -->
  
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
   @include('includes.Footer') 
@include('includes.Sidebar')
</div>
<!-- ./wrapper -->
 @include('includes.Includes')
</body>
<script type="text/javascript">
      $('.delete_selected').click(function (){
      //   if ($('input.checkboxes').is(':checked')) {
      //       var values = $('input.checkboxes:checked').map(function () {
      //           return this.value;
      //       }).get();
      var id = $(this).attr('iid');
            confirm_statement = "Are you sure you want to delete this Payment Method?";
            if (confirm(confirm_statement)){
                App.blockUI({ 
                    target: '#BlockUI',
                    boxed: true,
                    textOnly: true,
                    message: '<img src="{{asset('img/spinner.gif')}}" /> Just a moment...'
                });
                $.ajax({
                    // url: '{{ url('corpfin/del/tp') }}',
                    // type:'post',
                    // data: { "hall_id" : values },
                     type: "GET",
            url: "{{ url('') }}/corpfin/del/payment_method/"+id,
                    dataType:'json',
                    success: function(data){
                         if (data.result == 'success') {
                       location.reload();
Command: toastr["success"]("Payment Method deleted Successfully!")
toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
                       // alert("OKK");
                    }
                    if (data.result == 'fail') {
                        App.unblockUI('#BlockUI');
                        // $('#fail').show();
                        Command: toastr["error"]("Error Completing Request. Try Again!")

toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "3000",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
                    }
                                        if (data.result == 'login') {
                       window.location.href = u+'/login';
                        Command: toastr["error"]("Session Expired. Login to continue!")

toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "3000",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
                    }
                    }
                })

            }
       
    });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    if($("#type").val() == "fixed"){
        $('#value').attr('disabled', false);
        $('#value').attr('required', true);
      }

    
    $("#type").change(function(){
      if($("#type").val() == "fixed"){
        
        $('#value').attr('disabled', false);
        $('#value').attr('required', true);
      }
      else{
         $('#value').attr('disabled', true);
         $('#value').attr('required', false);
      }
    });
  });
</script>   

@if(session('status'))
<script type="text/javascript">
  Command: toastr["success"]("Done!")
toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
</script>
@endif            
</html>
