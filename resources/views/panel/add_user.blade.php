@extends('layout.master')


@section('title')
<title>Add Users</title>
@endsection


@section('content')


<div class="card">
  <div class="card-body">
    <div class="alert alert-info" style="width:100%;">
      <p style="text-align:center;"> Login Details would be sent to the Users Email-Address
      </p>
    </div>
    <!-- form start -->
    <form role="form" id="add_user">
      <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
      <div class="box-body">

        <div class="form-group">
          <label for="name">FullName</label>
          <input type="text" name="name" class="form-control" id="name" placeholder="FUllName" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" required>
        </div>
        <div class="form-group">
          <label for="phone">Tel</label>
          <input type="text" name="phone" class="form-control" id="phone" placeholder="Telephone Number" required>
        </div>
        <div class="form-group">
          <label for="phone">Status</label>
          <select name="status" class="form-control" id="status" required>
            <option value="">Account Status</option>
            <option value="1">Active</option>
            <option value="0">Suspended</option>
          </select>
        </div>
      </div>
      <!-- /.box-body -->

      <button type="submit" class="btn btn-primary btn-right">Add</button>

    </form>


  </div>
</div>


@endsection


@section('js')

<script type="text/javascript">
  $(document).ready(function () {



    $('#add_user').submit(function (e) {
      e.preventDefault();
      // toastr.info("Processing.....")



      postData = $(this).serialize();


      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('[name="_token"]').val()
        }
      });


      $.ajax({
        url: "{{  url('new_user' )}}",
        headers: {
          'X-CSRF-TOKEN': "{{csrf_token()}}"
        },
        type: "POST",
        data: JSON.stringify(postData),

        success: function (data) {
           
          data = JSON.parse(data);

          if (data.result == 'success') {
            // alert("Transaction Type Added Successfully");
            window.location.href = '{{ url('view_users ') }}';
            toastr.success("User Added Successfully!")

          }
          if (data.result == 'val_fail') {
            // console.log(data.result);
            // console.log(data.error);
            toastr.error(data.error)

          }
          if (data.result == 'fail') {

            toastr.error("Error Completing Request. Try Again!")

          }
          if (data.result == 'login') {
            window.location.href = u + '/login';
            toastr.error("Session Expired. Login to continue!")

          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          alert('Error Retrieving Data!');
        }
      });







    });


  });
</script>

@endsection