@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Payment Method</h5>
                <span class="d-block m-t-5">Tax Rates</span>
                <a href="" class="btn btn-success float-right" data-toggle="modal" data-target="#tr_modal">Add New</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                      <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>options</th>
                      </tr>
                      <?php $sn=1; ?>
                      @foreach($trs as $tr)
                      <tr>
                          <td>{{$sn}}</td>
                          <td>{{$tr->name}}</td>
                          <td>
                              <button class="btn btn-success edit_btn" id="{{$tr->id}}" title="edit"><i class="ion ion-edit"></i></button>
                              <button type="button" id="delete_selected" class="btn btn-danger delete_selected"><i class="fa fa-remove "></i></button>
                          </td>
                      </tr>
                      <?php $sn +=1; ?>
                      @endforeach
                    </table>
                    <? if(empty($trs)){  ?>
                    <td><p style="text-align:center;">No Payment Method Added. 
                      <a href="javascript:void(0)" data-toggle="modal" data-target="#tr_modal"> Add Payment Method</a>
                      </p>
                    </td>
                  <? } ?>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="tr_modal" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md" style="">
    <div class="modal-content">
      <div class="modal-header">
        <center><h4 class="modal-title" style="color:#1d74b7;">Manage Payment Method</h4></center>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="{{url('corpfin/settings/add/payment_method')}}" method="post" enctype="multipart/form-data" name="form" id="form">
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
          </div>
          <div class="modal-footer">
            <center><button type="submit" class="btn pull-right btn-embossed btn-success" style="background:#1d74b7;">Submit</button></center>
          </div>
      </form>
    </div>
  </div>
</div>
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
     document.form.action = "{{url('corpfin/settings/edit/payment_method')}}";
                     App.blockUI({ 
                    target: '#BlockUI',
                    boxed: true,
                    textOnly: true,
                    message: '<img src="{{asset('img/spinner.gif')}}" /> Just a moment...'
                });
    // alert("wait");
     $.ajax({
        url : "{{url('')}}/corpfin/get/payment_method/"+id,
        type: "GET",
        dataType: "JSON",
        cache: false,
        success: function(data)
        {  
            App.unblockUI('#BlockUI');
          //alert(data);
          $('#tr_modal').modal('show'); // show bootstrap modal when complete loaded
          $('[name="id"]').val(id);
          $('[name="name"]').val(data.name);
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
@endsection
