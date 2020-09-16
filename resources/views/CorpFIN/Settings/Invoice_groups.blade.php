<!DOCTYPE html>
<html>
<title>CORPFIN | Invoice Groups</title>
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
        <li class="active">Invoice Groups</li>
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
              <h3 class="box-title">Invoice Groups</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
 <button class="btn btn-primary btn-embossed pull-right" data-toggle="modal" data-target="#ig_modal">Add New</button>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding" id="BlockUI">
              <table class="table table-hover">
          
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Next ID</th>
                  <th>Left Pad</th>
                  <th>options</th>
                </tr>
                                <?php $sn=0; ?>
                <? foreach ($igs as $key => $ig) { ?>
                  <?php $sn+=1;?>
                <tr>
                  <td>{{$sn}}</td>
                  <td>{{$ig->name}}</td>
                  <td>{{$ig->next_id}}</td>
                  <td>{{$ig->left_pad}}</td>
                  <td>
                    <button class="btn btn-success edit_btn" id="<? echo $ig->id; ?>" title="edit"><i class="ion ion-edit"></i></button>
<button type="button" id="delete_selected" iid="<?php echo $ig->id; ?>" class="btn btn-danger delete_selected">
<i class="fa fa-remove "></i>
</button>
                  </td>
                </tr>
                <? }  ?>

              </table>
                            <? if(empty($igs)){  ?>
                              <td><p style="text-align:center;">No Invoice Group Added. 
                <a href="javascript:void(0)" data-toggle="modal" data-target="#ig_modal"> Add Invoice Group</a>
                </p></td>

<? } ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- Horizontal Form -->
          
          
          <!-- /.box -->
        </div>
       
      </div>
      <!-- /.row -->
                     <!--start modal-->
<div class="modal fade" id="ig_modal" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md" style="">
    <div class="modal-content">
      <div class="modal-header">
        <center><h4 class="modal-title" style="color:#1d74b7;">Manage Invoice Group</h4></center>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="{{url('corpfin/settings/add/invoice_group')}}" method="post" enctype="multipart/form-data" name="form" id="form">
        <input type="hidden" name="id" autocomplete="off" style="background:#ffffff;" class="form-control" placeholder="" required>
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label class="control-label">Name</label>
                  <div class="append-icon">
                    <input type="text" name="name" autocomplete="off" style="background:#ffffff;" class="form-control" placeholder="" required>
                      <i class="icon-user"></i>
                  </div>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                  <label class="control-label">Identifier formatting</label>
                  <br>
                  <label>Year</label>
    <input type="checkbox" name="identifier_year" id="identifier_year" class="" value="1">
    <label>Month</label>
     <input type="checkbox" name="identifier_month" class="" value="1">
     <label>Day</label>
      <input type="checkbox" name="identifier_day" class="" value="1">
                            </div>
                          </div>
                                                    <div class="col-sm-12">
                            <div class="form-group">
                              <label class="control-label">Next ID</label>
                              <div class="append-icon">
    <input type="number" name="next_id" autocomplete="off" style="background:#ffffff;" class="form-control" value="1" required>
                                <i class="icon-user"></i>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-12">
                            <div class="form-group">
                              <label class="control-label">Left Pad</label>
                              <div class="append-icon">
    <input type="number" name="left_pad" autocomplete="off" value="0" style="background:#ffffff;" class="form-control" placeholder="" required>
                                <i class="icon-user"></i>
                              </div>
                            </div>
                          </div>

                        </div>

                <div class="modal-footer">
                   <center><button type="submit" class="btn pull-right btn-embossed btn-success" style="background:#1d74b7;">Submit</button></center>
                </div>
              </form>
              </div>
            </div>
          </div>
          </div>

  <!--/ end modal.-->
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
            confirm_statement = "Are you sure you want to delete this Invoice Group?";
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
            url: "{{ url('') }}/corpfin/del/invoice_group/"+id,
                    dataType:'json',
                    success: function(data){
                         if (data.result == 'success') {
                       location.reload();
Command: toastr["success"]("Invoice Group deleted Successfully!")
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
        // }else{ 
        //     alert('Select Hall First');
        //     return false;
        // }
    })
</script>
                                  <script>
    //Ajax Load data from ajax
       $(function(){
   $('.edit_btn').click(function(){
     var id = $(this).attr('id');
     document.form.action = "{{url('corpfin/settings/edit/invoice_group')}}";
                     App.blockUI({ 
                    target: '#BlockUI',
                    boxed: true,
                    textOnly: true,
                    message: '<img src="{{asset('img/spinner.gif')}}" /> Just a moment...'
                });
    // alert("wait");
     $.ajax({
        url : "{{url('')}}/corpfin/get/invoice_group/"+id,
        type: "GET",
        dataType: "JSON",
        cache: false,
        success: function(data)
        {  
            App.unblockUI('#BlockUI');
          //alert(data);
          $('#ig_modal').modal('show'); // show bootstrap modal when complete loaded
          $('[name="id"]').val(id);
          $('[name="name"]').val(data.name);
          //$('[name="identifier_year"]').val(data.identifier_year);
          if(data.identifier_year == 1){
           $('[name="identifier_year"]').prop("checked",true);
          }
          if(data.identifier_day == 1){
          $('[name="identifier_day"]').prop("checked",true);
           }
           if(data.identifier_month == 1){
          $('[name="identifier_month"]').prop("checked",true);
            }
          $('[name="next_id"]').val(data.next_id);
          $('[name="left_pad"]').val(data.left_pad);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            App.unblockUI('#BlockUI');
            alert('Error Retrieving Data!');
        }
    });
    });
   });
   </script>
</html>
