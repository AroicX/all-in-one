@extends('layout.master')


@section('title')
<title>{{ Auth::User()->name }} - Profile</title>
@endsection


@section('content')

<style>
  .tab-content{
    border: 0px none !important;
  }
</style>


  <div class="card">

    <ul class="nav nav-tabs py-4">
      <li class="active mx-2 "><a data-toggle="tab" href="#general">General Settings</a></li>
      <li><a class="mx-2 py-2" data-toggle="tab" href="#password">Password Settings</a></li>
      <li><a class="mx-2 py-2" data-toggle="tab" href="#picture">Picture Settings</a></li>
      <li><a class="mx-2 py-2"  href="new_user">Add User</a></li>
      <li><a class="mx-2 py-2"  href="view_users">View Users</a></li>
    </ul>

    <!--start tab content-->
    <div class="tab-content">
      <!--General Settings-->
      <div id="general" class="tab-pane active">
        <br>
        <br>
        <!--content start-->
        <div class="px-2">
       
          <div class="card-body" id="blockUI">
            <!--form start-->
            <form method="post" action="{{url('profile/general')}}" id="profile-general">
              <!--col-md-12-->
              <div class="col-md-12">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="url" id="url" value="{{url('')}}">
                <div class="row">
                  <div class="col-sm-12">
                    <label for="name">Full Name*</label>
                    <input type="text" name="name" id="name" value="{{ Auth::user()->name }}"
                      placeholder="Full Name" class="form-control" required>
                  </div>
                </div>

                <div class="row" style="padding-top:15px;">
                  <div class="col-sm-6">
                    <label for="email">Email Address*</label>
                    <input type="email" name="email" id="email" value="{{ Auth::user()->email }}"
                      placeholder="Email Address" class="form-control" required>
                  </div>
                  <div class="col-sm-6">
                    <label for="phone">Phone*</label>
                    <input type="text" name="phone" id="phone" value="{{ Auth::user()->phone }}"
                      placeholder="Contact Number" class="form-control" required>
                  </div>
                </div>

                <div class="row" style="padding-top:15px;">
                  <div class="col-sm-12">
                    <label for="address">Resident Address</label>
                    <textarea type="text" name="address" id="address" placeholder="Resident Address"
                      class="form-control">
                      {{ Auth::user()->address }}
                    </textarea>
                  </div>
                </div>

                <div class="row" style="padding-top:15px;">
                  <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary btn-block">Update</button>
                  </div>
                </div>

              </div>
              <!-- End col-md-12-->
            </form>
            <!--form end-->
          </div>
        </div>
        <!--End content-->
      </div>
      <!--End general settings-->

      <!--Password Settings-->

      <div id="password" class="tab-pane fade">
        <br>
        <br>
        <!--Content start-->
        <div class="px-2">
          {{-- <div class="card-heading">Password Settings </div> --}}
          <div class="card-body" id="blockUI1">
            <!--form start-->
            <form method="post" action="{{url('profile/password')}}" id="profile-password">
              <!--col-md-12-->
              <div class="col-md-12">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="row">
                  <div class="col-sm-12">
                    <label for="old-password">Old Password*</label>
                    <input type="password" name="old_password" id="old-password" placeholder="Old Password"
                      class="form-control" required>
                  </div>
                </div>

                <div class="row" style="padding-top:15px;">
                  <div class="col-sm-12">
                    <label for="new-password">New password*</label>
                    <input type="password" name="password" id="new-password" placeholder="New Password"
                      class="form-control" required>
                  </div>
                </div>

                <div class="row" style="padding-top:15px;">
                  <div class="col-sm-12">
                    <label for="con-new-password">Confirm New password*</label>
                    <input type="password" name="con_password" id="con-new-password"
                      placeholder="Confirm New Password" class="form-control" required>
                  </div>
                </div>


                <div class="row" style="padding-top:15px;">
                  <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary btn-block">Update</button>
                  </div>
                </div>

              </div>
              <!-- End col-md-12-->
            </form>
            <!--form end-->
          </div>
        </div>
        <!--End Content-->
      </div>

      <!--End Password Settings-->

      <!--picture settings-->

      <div id="picture" class="tab-pane fade">
        <br>
        <br>
        <!--Content start-->
        <div class="px-2">
          {{-- <div class="card-heading">Picture Settings </div> --}}
          <div class="card-body" id="blockUI2">
            <!--form start-->
            <form action="{{url('profile/picture')}}" enctype="multipart/form-data" method="post"
              id="profile-picture">
              <!--col-md-12-->
              <div class="col-md-12">
               
                <div class="row">
                  <div class="col-sm-12">
                    <label for="old-password">Select Picture*</label>
                    <input type="file" name="image" id="image" placeholder="Select Picture" class="form-control"
                      required>
                  </div>
                </div>


                <div class="row" style="padding-top:15px;">
                  <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary btn-block">Update</button>
                  </div>
                </div>

              </div>
              <!-- End col-md-12-->
            </form>
            <!--form end-->
          </div>
        </div>
        <!--End Content-->
      </div>

      <!--End Picture settings-->
    </div>
    <!--End tab content-->

  </div>


@endsection


@section('js')

<script src="{{asset('js/general/profile-general.js')}}"></script>
<script src="{{asset('js/general/profile-password.js')}}"></script>
<script src="{{asset('js/general/profile-picture.js')}}"></script>
@endsection