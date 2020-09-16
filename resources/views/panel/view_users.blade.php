@extends('layout.master')


@section('title')
<title>View Users</title>
@endsection


@section('content')


<div class="card">
  <div class="card-body">

    <table class="table table-hover">

      <tr>
        <th>ID</th>
        <th>FullName</th>
        <th>Email-Address</th>
        <th>Phone No.</th>
        <th>Status</th>
        <th>Action</th>
        <th>Delete</th>
      </tr>

      <tbody>
        <tr>
          @foreach($users as $key => $user)
          <td>{{$key + 1}}</td>
          <td>{{$user->name}}</td>
          <td>{{$user->email}}</td>
          <td>{{$user->phone}}</td>
          <td> <?php if($user->activated == "1"){ echo "Active"; }else{ echo "Suspended"; }  ?></td>
          <td>
            <div class="btn-group">
              <button type="button" class="btn btn-primary btn-xs">Action</button>
              <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Edit</a></li>
                <li><a href="#">View</a></li>
              </ul>
            </div>
          </td>
          <td> <button type="button" id="delete_selected" iid="<?php echo $user->id; ?>"
              class="btn btn-danger delete_selected">
              <i class="fas fa-window-close"></i>
            </button></td>


          @endforeach
        </tr>


      </tbody>

    </table>

    @if(empty($users))
    <td>
      <p style="text-align:center;">No User Added.
        <a href="{{url('new_user')}}"> Add User</a>
      </p>
    </td>

    @endif


  </div>
</div>


@endsection


@section('js')


<script type="text/javascript">
  $('.delete_selected').click(function () {
    //   if ($('input.checkboxes').is(':checked')) {
    //       var values = $('input.checkboxes:checked').map(function () {
    //           return this.value;
    //       }).get();
    var id = $(this).attr('iid');
    confirm_statement = "Are you sure you want to delete this User?";
    if (confirm(confirm_statement)) {

      $.ajax({
        // url: '{{ url('corpfin/del/tp') }}',
        // type:'post',
        // data: { "hall_id" : values },
        type: "GET",
        url: "{{ url('') }}/del/user/" + id,
        dataType: 'json',
        success: function (data) {
          if (data.result == 'success') {
            location.reload();
            Command: toastr["success"]("User deleted Successfully!")
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
            // App.unblockUI('#BlockUI');
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
            window.location.href = u + '/login';
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

@endsection