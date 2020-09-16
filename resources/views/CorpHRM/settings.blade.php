@extends('CorpHRM.layout.master')
@section('title')
<title>General Settings</title>
@endsection
@section('content')


<style>
  .hidden{
    display: none;
  }
</style>

<section class="content-header">
  <div class="row">

    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Settings</h5>


          <div class="form-group ">
            <select class="form-control" id="control_settings">
              {{--  <option>Select the form to fill</option>  --}}
              <option id="allowances" value="allowances">Payroll</option>
              <option id="pension" value="pension">PFA</option>
              <option id="access_roles" value="access_roles">Access Roles</option>
              <option id="health" value="health">Health</option>
              <option id="internal" value="internal">State Internal Revenue Board</option>
              <option id="branches" value="branches">Branches</option>
              <option id="departments" value="departments">Departments</option>
              <option id="currencies" value="currencies">Currenecies</option>
              <option id="qualification" value="qualification">Qualification</option>
              <option id="document" value="document">Document</option>
              <option id="weekoff" value="weekoff">Weekends</option>
              <option id="category" value="category">Category</option>
              <option id="grades" value="grades">Grades</option>
              <option id="designation" value="designation">Designation</option>
              <option id="banks" value="banks">Banks</option>
              <option id="holidays" value="holidays">Holidays</option>
              <option id="email_templates" value="email_templates">Email Templates</option>
            </select>
          </div>
        </div>
      </div>
    </div>



  </div>


  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">

          <div class="" id="box-allowances">
            <div class=" with-border">
              <h5>Payroll Settings
                <div class="pull-right">
                  <button class="btn btn-primary addition_subtraction" addition="1" subtraction="0">Add
                    Addition</button>
                  <button class="btn btn-primary addition_subtraction" addition="0" subtraction="1">Add
                    Deduction</button>
                </div>
              </h5>
            </div>
            <ul class="nav nav-tabs">
              <li class="active mx-2 my-2"><a data-toggle="tab" href="#custom">Custom</a></li>
              <li class="mx-2 my-2"><a data-toggle="tab" href="#basic">Basic</a></li>
              <li class="mx-2 my-2"><a data-toggle="tab" href="#payee">Payee</a></li>
              <li class="mx-2 my-2"><a data-toggle="tab" href="#run_day">Run Day</a></li>
            </ul>
            <div class="tab-content">
              <div id="custom" class="tab-pane show active">

                <div class=" table-responsive no-padding">
                  <table class="table table-hover">

                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th style="text-align: center;">Additon</th>
                      <th style="text-align: center;">Subtraction</th>
                      <th>Action</th>
                    </tr>
                    <?php $sn = 0; ?>
                    @foreach ($custom_settings as $custom_setting)
                    <?php $sn += 1;?>
                    <tr>
                      <td>{{$sn}}</td>
                      <td>{{ $custom_setting->name }}</td>
                      <td style="text-align: center;">@if($custom_setting->addition == "1") <span style="color:green;"
                          class="glyphicon glyphicon-ok"></span> @else <span style="color:red;"
                          class="glyphicon glyphicon-remove"></span> @endif</td>
                      <td style="text-align: center;">@if($custom_setting->subtraction == "1") <span
                          style="color:green;" class="glyphicon glyphicon-ok"></span> @else <span style="color:red;"
                          class="glyphicon glyphicon-remove"></span> @endif</td>
                      <td></td>
                    </tr>
                    @endforeach
                  </table>
                  @if(count($custom_settings) == 0)
                  <td>
                    <p style="text-align:center;">No Custom.
                    </p>
                  </td>

                  @endif
                </div>

              </div>
              <div id="basic" class="tab-pane fade">
                <div class=" table-responsive no-padding">
                  <table class="table table-hover">

                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th style="text-align: center;">Additon</th>
                      <th style="text-align: center;">Subtraction</th>
                      <th>Action</th>
                    </tr>
                    <?php $sn = 0; ?>
                    @foreach ($basic_settings as $basic_setting)
                    <?php $sn += 1;?>
                    <tr>
                      <td>{{$sn}}</td>
                      <td>{{ $basic_setting->name }}</td>
                      <td style="text-align: center;">@if($basic_setting->addition == "1") <span style="color:green;"
                          class="glyphicon glyphicon-ok"></span> @else <span style="color:red;"
                          class="glyphicon glyphicon-remove"></span> @endif</td>
                      <td style="text-align: center;">@if($basic_setting->subtraction == "1") <span style="color:green;"
                          class="glyphicon glyphicon-ok"></span> @else <span style="color:red;"
                          class="glyphicon glyphicon-remove"></span> @endif</td>
                      <td></td>
                    </tr>
                    @endforeach
                  </table>
                  @if(count($basic_settings) == 0)
                  <td>
                    <p style="text-align:center;">No basic.
                    </p>
                  </td>

                  @endif
                </div>
              </div>


              <div id="run_day" class="tab-pane fade">
                <div class="col-md-12" style="float:none !important; padding:10px;">
                  <form action="{{url('corphrm/payroll/settings/runday')}}" method="POST">
                    <div class="form-group">
                      <label>Choose Runday:</label>
                      <select name="runday" class="form-control" required="">
                        @for($i=0;$i<30;$i++) <option value="{{$i}}">{{$i}}</option>
                          @endfor
                      </select>
                    </div>
                  </form>
                </div>
              </div>

              <div id="payee" class="tab-pane fade">
                <div class="col-md-12" style="float:none !important; padding:10px;">
                  <marquee>
                    <p style="color:red;">Please note that once a selection has been made, It can't be
                      undone!</p>
                  </marquee>
                  <div class="panel panel-default">
                    <div class="panel-body"><b>PAYEE YTD</b>
                      <?php if(empty($payee_type) || $payee_type == NULL){ ?>
                      <a href="{{  url('corphrm/payroll/settings/payee') }}?query=YTD">
                        <button class="btn btn-sm btn-primary pull-right" style="margin:3px;">Activate</button>
                      </a>
                      <?php }elseif($payee_type == "YTD"){ ?>
                      <a href="javascript:;">
                        <button class="btn btn-sm btn-warning pull-right" style="margin:3px;">Active</button>
                      </a>
                      <?php } ?>
                    </div>
                  </div>

                  <div class="panel panel-default">
                    <div class="panel-body"><b>PAYEE ANNUALIZED</b>
                      <?php if(empty($payee_type) || $payee_type == NULL){ ?>
                      <a href="{{  url('corphrm/payroll/settings/payee') }}?query=ANNUALIZED">
                        <button class="btn btn-sm btn-primary pull-right" style="margin:3px;">Activate</button>
                      </a>
                      <?php }elseif($payee_type == "ANNUALIZED"){ ?>
                      <a href="javascript:;">
                        <button class="btn btn-sm btn-warning pull-right" style="margin:3px;">Active</button>
                      </a>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{--Pension Box--}}
          <div class=" hidden" id="box-pension">
            <div class=" with-border">
              <h5 class="box-title">Pension Fund Administrator</h5>
            </div>
            <!-- form start -->
            <form method="post" name="pension" action="{{route('pension')}}">
              <div class="">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
                </div>
                <div class="form-group">
                  <label>Address</label>
                  <textarea class="form-control" rows="3" name="address" placeholder="Enter Address"></textarea>
                </div>
                <div class="form-group">
                  <label for="phone">Phone Number</label>
                  <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone">
                </div>

                <div class="form-group">
                  <label for="reporting_bank">Reporting Bank</label>
                  <input type="text" class="form-control" name="reporting_bank" id="reporting_bank"
                    placeholder="Enter Reporting Bank">
                </div>

                <div class="form-group">
                  <label for="account_no">Account Number</label>
                  <input type="text" class="form-control" name="account_no" id="account_no"
                    placeholder="Enter Account Number">
                </div>
              </div>
              <input type="hidden" name="_token" value="{{Session::token()}}" />
              <!-- /. -->
              <div class="box-footer">
                <input type="submit" name="pension_save" class="btn btn-primary" value="Submit"></button>
                <button type="submit" class="btn btn-danger">Clear</button>
              </div>
            </form>


            <div class=" table-responsive padding" style="margin-top: 30px;" id="BlockUI">
              <table class="table table-hover table-bordered">

                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Address</th>
                  <th>Phone</th>
                  <th>Reporting Bank</th>
                  <th>Account No</th>
                  <th>Action</th>
                </tr>
                <?php $sn = 0; ?>
                @foreach ($pfas as $pfa)
                <?php $sn += 1;?>
                <tr>
                  <td>{{$sn}}</td>
                  <td>{{ $pfa->name }}</td>
                  <td>{{ $pfa->address }}</td>
                  <td>{{ $pfa->phone }}</td>
                  <td>{{ $pfa->reporting_bank }}</td>
                  <td>{{ $pfa->account_no }}</td>
                  <td>
                    <a href="{{ url('/corphrm/action/delete') }}?type=pfa&id={{$pfa->id}}"
                      onclick="return confirm('Are you sure you want to delete?');">
                      <button class="btn btn-danger btn-block">Delete</button>
                    </a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <br>

          </div>

          {{--Health Box--}}

          <div class=" hidden" id="box-health">
            <div class=" with-border">
              <h5 class="box-title">Health Management</h5>
            </div>
            <!-- /. -->
            <!-- form start -->
            <form method="post" action="{{route('post_health')}}">
              <div class="">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
                </div>
                <div class="form-group">
                  <label>Address</label>
                  <textarea class="form-control" rows="3" placeholder="Enter Address" name="address"></textarea>
                </div>
                <div class="form-group">
                  <label for="phone">Phone Number</label>
                  <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone">
                </div>
              </div>
              <input type="hidden" name="_token" value="{{Session::token()}}" />
              <!-- /. -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="submit" class="btn btn-danger">Clear</button>
              </div>
            </form>

            <div class=" table-responsive padding" style="margin-top: 30px;" id="BlockUI">
              <table class="table table-hover table-bordered">

                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Address</th>
                  <th>Phone</th>
                  <th>Action</th>
                </tr>
                <?php $sn = 0; ?>
                @foreach ($healths as $health)
                <?php $sn += 1;?>
                <tr>
                  <td>{{$sn}}</td>
                  <td>{{ $health->name }}</td>
                  <td>{{ $health->address }}</td>
                  <td>{{ $health->phone }}</td>
                  <td>
                    <a href="{{ url('/corphrm/action/delete') }}?type=health&id={{$health->id}}"
                      onclick="return confirm('Are you sure you want to delete?');">
                      <button class="btn btn-danger btn-block">Delete</button>
                    </a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <br>

          </div>
          {{--Internal Revenue--}}
          <div class=" hidden" id="box-internal">
            <div class=" with-border">
              <h5 class="box-title"> State Internal Revenue Board</h5>
            </div>
            <!-- /. -->
            <!-- form start -->
            <form method="post" action="{{route('internal')}}">
              <div class="">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
                </div>

                <div class="form-group">
                  <label>Address</label>
                  <textarea class="form-control" rows="3" placeholder="Enter Address" name="address"></textarea>
                </div>
                <div class="form-group">
                  <label for="state">State</label>
                  <select class="form-control" name="state" id="state">
                    <option value="" selected="selected">- Select -</option>
                    <option value="Abuja FCT">Abuja FCT</option>
                    <option value="Abia">Abia</option>
                    <option value="Adamawa">Adamawa</option>
                    <option value="Akwa Ibom">Akwa Ibom</option>
                    <option value="Anambra">Anambra</option>
                    <option value="Bauchi">Bauchi</option>
                    <option value="Bayelsa">Bayelsa</option>
                    <option value="Benue">Benue</option>
                    <option value="Borno">Borno</option>
                    <option value="Cross River">Cross River</option>
                    <option value="Delta">Delta</option>
                    <option value="Ebonyi">Ebonyi</option>
                    <option value="Edo">Edo</option>
                    <option value="Ekiti">Ekiti</option>
                    <option value="Enugu">Enugu</option>
                    <option value="Gombe">Gombe</option>
                    <option value="Imo">Imo</option>
                    <option value="Jigawa">Jigawa</option>
                    <option value="Kaduna">Kaduna</option>
                    <option value="Kano">Kano</option>
                    <option value="Katsina">Katsina</option>
                    <option value="Kebbi">Kebbi</option>
                    <option value="Kogi">Kogi</option>
                    <option value="Kwara">Kwara</option>
                    <option value="Lagos">Lagos</option>
                    <option value="Nassarawa">Nassarawa</option>
                    <option value="Niger">Niger</option>
                    <option value="Ogun">Ogun</option>
                    <option value="Ondo">Ondo</option>
                    <option value="Osun">Osun</option>
                    <option value="Oyo">Oyo</option>
                    <option value="Plateau">Plateau</option>
                    <option value="Rivers">Rivers</option>
                    <option value="Sokoto">Sokoto</option>
                    <option value="Taraba">Taraba</option>
                    <option value="Yobe">Yobe</option>
                    <option value="Zamfara">Zamfara</option>
                  </select>
                </div>
              </div>
              <input type="hidden" name="_token" value="{{Session::token()}}" />
              <!-- /. -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="submit" class="btn btn-danger">Clear</button>
              </div>
            </form>

            <div class=" table-responsive padding" style="margin-top: 30px;" id="BlockUI">
              <table class="table table-hover table-bordered">

                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Address</th>
                  <th>state</th>
                  <th>Action</th>
                </tr>
                <?php $sn = 0; ?>
                @foreach ($internalrevenues as $internalrevenue)
                <?php $sn += 1;?>
                <tr>
                  <td>{{$sn}}</td>
                  <td>{{ $internalrevenue->name }}</td>
                  <td>{{ $internalrevenue->address }}</td>
                  <td>{{ $internalrevenue->state }}</td>
                  <td>
                    <a href="{{ url('/corphrm/action/delete') }}?type=internal_revenue&id={{$internalrevenue->id}}"
                      onclick="return confirm('Are you sure you want to delete?');">
                      <button class="btn btn-danger btn-block">Delete</button>
                    </a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <br>

          </div>

          {{--Holiday form--}}
          <div class=" hidden" id="box-holidays">
            <div class=" with-border">
              <h5 class="box-title">Holidays</h5>
            </div>
            <!-- /. -->
            <!-- form start -->
            <form method="post" action="{{route('holidays')}}">
              <div class="">
                <div class="form-group">
                  <label for="holiday_name">Name</label>
                  <input type="text" class="form-control" name="holiday_name" id="holiday_name"
                    placeholder="Enter Holiday Name">
                </div>
                <!--               <div class="form-group">
                <label for="branch">Branch</label>
                                <select class="form-control" name="branch">
                  <option>Select a Branch</option>
                  @foreach($branches as $branch)
                  <option value="{{ $branch->id }}">{{ $branch->name }} ({{ $branch->code }})</option>
                  @endforeach
                </select>
              </div> -->

                <div class="form-group">
                  <label>Date From:</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="date" class="form-control pull-right" id="date_from" name="date_from">
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>Category</label>
                  <select class="form-control" name="category">
                    <option>Select a Category</option>
                    <option value="fixed">Fixed</option>
                    <option value="variable">Variable</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Date To:</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="date" class="form-control pull-right" id="date_to" name="date_to">
                  </div>
                  <!-- /.input group -->
                </div>

                <div class="form-group">
                  <label>Message</label>
                  <textarea class="form-control" rows="3" placeholder="Enter message" name="message"></textarea>
                </div>
                <div class="form-group">
                  <label>Repeat Annually</label>
                  <select class="form-control" name="repeat_annually">
                    <option>Select one</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                  </select>
                </div>

              </div>
              <input type="hidden" name="_token" value="{{Session::token()}}" />
              <!-- /. -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="submit" class="btn btn-danger">Clear</button>
              </div>
            </form>

            <div class=" table-responsive padding" style="margin-top: 30px;" id="BlockUI">
              <table class="table table-hover table-bordered">

                <tr>
                  <th>ID</th>
                  <th>Holiday Name</th>
                  <th>From Date</th>
                  <th>To Date</th>
                  <th>Category</th>
                  <th>Action</th>
                </tr>
                <?php $sn = 0; ?>
                @foreach ($holidays as $holiday)
                <?php $sn += 1;?>
                <tr>
                  <td>{{$sn}}</td>
                  <td>{{ $holiday->name }}</td>
                  <td>{{ $holiday->from_date }}</td>
                  <td>{{ $holiday->to_date }}</td>
                  <td>{{ $holiday->category }}</td>
                  <td>
                    <a href="{{ url('/corphrm/action/delete') }}?type=holiday&id={{$holiday->id}}"
                      onclick="return confirm('Are you sure you want to delete?');">
                      <button class="btn btn-danger btn-block">Delete</button>
                    </a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <br>
          </div>


          {{--Banches Form--}}
          <div class=" hidden" id="box-branches">
            <div class=" with-border">
              <h5 class="box-title">Branches</h5>
            </div>
            <!-- /. -->
            <!-- form start -->
            <form role="form" method="post" action="{{route('post_branches')}}">
              <div class="">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Enter  Name">
                </div>

                <div class="form-group">
                  <label for="name">Code</label>
                  <input type="text" class="form-control" name="code" id="code" placeholder="Enter Code">
                </div>

                <div class="form-group">
                  <label for="name">City</label>
                  <input type="text" class="form-control" name="city" id="city" placeholder="Enter City">
                </div>
                <div class="form-group">
                  <label for="name">state</label>
                  <select class="form-control" name="state" id="state">
                    <option value="" selected="selected">- Select -</option>
                    <option value="Abuja FCT">Abuja FCT</option>
                    <option value="Abia">Abia</option>
                    <option value="Adamawa">Adamawa</option>
                    <option value="Akwa Ibom">Akwa Ibom</option>
                    <option value="Anambra">Anambra</option>
                    <option value="Bauchi">Bauchi</option>
                    <option value="Bayelsa">Bayelsa</option>
                    <option value="Benue">Benue</option>
                    <option value="Borno">Borno</option>
                    <option value="Cross River">Cross River</option>
                    <option value="Delta">Delta</option>
                    <option value="Ebonyi">Ebonyi</option>
                    <option value="Edo">Edo</option>
                    <option value="Ekiti">Ekiti</option>
                    <option value="Enugu">Enugu</option>
                    <option value="Gombe">Gombe</option>
                    <option value="Imo">Imo</option>
                    <option value="Jigawa">Jigawa</option>
                    <option value="Kaduna">Kaduna</option>
                    <option value="Kano">Kano</option>
                    <option value="Katsina">Katsina</option>
                    <option value="Kebbi">Kebbi</option>
                    <option value="Kogi">Kogi</option>
                    <option value="Kwara">Kwara</option>
                    <option value="Lagos">Lagos</option>
                    <option value="Nassarawa">Nassarawa</option>
                    <option value="Niger">Niger</option>
                    <option value="Ogun">Ogun</option>
                    <option value="Ondo">Ondo</option>
                    <option value="Osun">Osun</option>
                    <option value="Oyo">Oyo</option>
                    <option value="Plateau">Plateau</option>
                    <option value="Rivers">Rivers</option>
                    <option value="Sokoto">Sokoto</option>
                    <option value="Taraba">Taraba</option>
                    <option value="Yobe">Yobe</option>
                    <option value="Zamfara">Zamfara</option>
                    <option value="Outside Nigeria">Outside Nigeria</option>
                  </select>
                </div>
              </div>
              <input type="hidden" name="_token" value="{{Session::token()}}" />
              <!-- /. -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="submit" class="btn btn-danger">Clear</button>
              </div>
            </form>

            <div class=" table-responsive padding" style="margin-top: 30px;" id="BlockUI">
              <table class="table table-hover table-bordered">

                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>code</th>
                  <th>city</th>
                  <th>state</th>
                  <th>Action</th>
                </tr>
                <?php $sn = 0; ?>
                @foreach ($branches as $branch)
                <?php $sn += 1;?>
                <tr>
                  <td>{{$sn}}</td>
                  <td>{{ $branch->name }}</td>
                  <td>{{ $branch->code }}</td>
                  <td>{{ $branch->city }}</td>
                  <td>{{ $branch->state }}</td>
                  <td>
                    <a href="{{ url('/corphrm/action/delete') }}?type=branch&id={{$branch->id}}"
                      onclick="return confirm('Are you sure you want to delete?');">
                      <button class="btn btn-danger btn-block">Delete</button>
                    </a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <br>

          </div>


          {{--Grades Form--}}

          <div class=" hidden" id="box-grades">
            <div class=" with-border">
              <h5 class="box-title">Grades</h5>
            </div>
            <!-- /. -->
            <!-- form start -->
            <form method="post" action="{{route('post_grades')}}">
              <div class="">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Enter  Name">
                </div>
                <div class="form-group">
                  <label for="basic_salary">Basic Salary</label>
                  <input type="number" class="form-control" name="basic_salary" id="basic_salary"
                    placeholder="Enter  Basic Salary">
                </div>
                <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" rows="3" placeholder="Enter Description" name="description"></textarea>
                </div>

              </div>
              <input type="hidden" name="_token" value="{{Session::token()}}" />
              <!-- /. -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="submit" class="btn btn-danger">Clear</button>
              </div>
            </form>

            <div class=" table-responsive padding" style="margin-top: 30px;" id="BlockUI">
              <table class="table table-hover table-bordered">

                <tr>
                  <th>ID</th>
                  <th>Grade</th>
                  <th>Basic Salary</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
                <?php $sn = 0; ?>
                @foreach ($grades as $grade)
                <?php $sn += 1;?>
                <tr>
                  <td>{{$sn}}</td>
                  <td>{{ $grade->name }}</td>
                  <td>{{ $grade->basic_salary }}</td>
                  <td>{{ $grade->description }}</td>
                  <td>
                    <div class="btn-group">
                      <a href="{{ url('/corphrm/action/delete') }}?type=grade&id={{$grade->id}}"
                        onclick="return confirm('Are you sure you want to delete this grade? All staffs under this grad will be affected');">
                        <button type="button" class="btn btn-sm btn-danger">
                          Delete
                        </button>
                      </a>
                    </div>
                    <!--                                         <div class="btn-group">
                                          <a href="">
                                        <button type="button" class="btn btn-sm btn-success">Edit
                                              </button>
                                            </a>
                                        </div> -->
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
          </div>

          {{--Departments Form--}}

          <div class=" hidden" id="box-departments">
            <div class=" with-border">
              <h5 class="box-title">Department</h5>
            </div>
            <!-- /. -->
            <!-- form start -->
            <form method="post" action="{{route('post_departments')}}">
              <div class="">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Enter  Name">
                </div>
                <div class="form-group">
                  <label for="name">Code</label>
                  <input type="text" class="form-control" name="code" id="code" placeholder="Enter Code">
                </div>
                <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" rows="3" placeholder="Enter Description" name="description"></textarea>
                </div>

              </div>
              <input type="hidden" name="_token" value="{{Session::token()}}" />
              <!-- /. -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-danger">Clear</button>
              </div>
            </form>

            <div class=" table-responsive padding" style="margin-top: 30px;" id="BlockUI">
              <table class="table table-hover table-bordered">

                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Code</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
                <?php $sn = 0; ?>
                @foreach ($departments as $department)
                <?php $sn += 1;?>
                <tr>
                  <td>{{$sn}}</td>
                  <td>{{ $department->name }}</td>
                  <td>{{ $department->code }}</td>
                  <td>{{ $department->description }}</td>
                  <td>
                    <a href="{{ url('/corphrm/action/delete') }}?type=department&id={{$department->id}}"
                      onclick="return confirm('Are you sure you want to delete?');">
                      <button class="btn btn-danger btn-block">Delete</button>
                    </a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <br>

          </div>


          {{--Designation Form--}}


          <div class=" hidden" id="box-designation">
            <div class=" with-border">
              <h5 class="box-title">Designation</h5>
            </div>
            <!-- /. -->
            <!-- form start -->
            <form method="post" action="{{route('post_designation')}}">
              <div class="">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Enter  Name">
                </div>
                <div class="form-group">
                  <label for="name">Parent</label>
                  <input type="text" class="form-control" name="parent" id="parent" placeholder="Enter Parent">
                </div>
                <div class="form-group">
                  <label>Is Managerial Post</label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="is_managerial" id="optionsRadios1" value="1"> Yes
                    </label>
                    <label>
                      <input type="radio" name="is_managerial" id="optionsRadios1" value="0" checked>
                      No
                    </label>
                  </div>
                </div>

                <div class="form-group">
                  <label>Is Main Designation</label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="is_main" id="optionsRadios1" value="1"> Yes
                    </label>
                    <label>
                      <input type="radio" name="is_main" id="optionsRadios1" value="0" checked>
                      No
                    </label>
                  </div>
                </div>

              </div>
              <input type="hidden" name="_token" value="{{Session::token()}}" />
              <!-- /. -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="submit" class="btn btn-danger">Clear</button>
              </div>
            </form>

            <div class=" table-responsive padding" style="margin-top: 30px;" id="BlockUI">
              <table class="table table-hover table-bordered">

                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Parents</th>
                  <th>Managerial post</th>
                  <th>Main Designation</th>
                  <th>Action</th>
                </tr>
                <?php $sn = 0; ?>
                @foreach ($designations as $designation)
                <?php $sn += 1;?>
                <tr>
                  <td>{{$sn}}</td>
                  <td>{{ $designation->name }}</td>
                  <td>{{ $designation->parent }}</td>
                  <td>@if($designation->is_mangerial_post == "1") Yes @else No @endif</td>
                  <td>@if($designation->is_main_designation == "1") Yes @else No @endif</td>
                  <td>
                    <a href="{{ url('/corphrm/action/delete') }}?type=designation&id={{$designation->id}}"
                      onclick="return confirm('Are you sure you want to delete?');">
                      <button class="btn btn-danger btn-block">Delete</button>
                    </a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <br>

          </div>


          {{--Banks Form--}}
          <div class=" hidden" id="box-banks">
            <div class=" with-border">
              <h5 class="box-title">Banks</h5>
            </div>
            <!-- /. -->
            <!-- form start -->
            <form method="post" action="{{route('post_banks')}}">
              <div class="">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Enter  Name">
                </div>
                <div class="form-group">
                  <label for="code">Code</label>
                  <input type="text" class="form-control" name="code" id="code" placeholder="Enter Code">
                </div>
                <div class="form-group">
                  <label for="name">Branch</label>
                  <input type="text" class="form-control" name="branch" id="branch" placeholder="Enter Branch">
                </div>

                <div class="form-group">
                  <label for="sort_code">Sort Code</label>
                  <input type="text" class="form-control" name="sort_code" id="sort_code" placeholder="Enter Sort Code">
                </div>

              </div>
              <input type="hidden" name="_token" value="{{Session::token()}}" />
              <!-- /. -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="submit" class="btn btn-danger">Clear</button>
              </div>
            </form>

            <div class=" table-responsive padding" style="margin-top: 30px;" id="BlockUI">
              <table class="table table-hover table-bordered">

                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Code</th>
                  <th>Branch</th>
                  <th>Sort Code</th>
                  <th>Action</th>
                </tr>
                <?php $sn = 0; ?>
                @foreach ($banks as $bank)
                <?php $sn += 1;?>
                <tr>
                  <td>{{$sn}}</td>
                  <td>{{ $bank->name }}</td>
                  <td>{{ $bank->code }}</td>
                  <td>{{ $bank->branch }}</td>
                  <td>{{ $bank->sort_code }}</td>
                  <td>
                    <a href="{{ url('/corphrm/action/delete') }}?type=bank&id={{$bank->id}}"
                      onclick="return confirm('Are you sure you want to delete?');">
                      <button class="btn btn-danger btn-block">Delete</button>
                    </a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <br>

          </div>

          {{--Currencies Form--}}

          <div class=" hidden" id="box-currencies">
            <div class=" with-border">
              <h5 class="box-title">Currency</h5>
            </div>
            <!-- /. -->
            <!-- form start -->
            <form method="post" action="{{route('post_currencies')}}">
              <div class="">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Enter  Name">
                </div>
                <div class="form-group">
                  <label for="symbol">Symbol Code</label>
                  <input type="text" class="form-control" name="symbol" id="symbol" placeholder="Enter Code">
                </div>
                <div class="form-group">
                  <label for="sub_name">Sub Name</label>
                  <input type="text" class="form-control" name="sub_name" id="sub_name" placeholder="Enter Symbol Name">
                </div>
              </div>
              <input type="hidden" name="_token" value="{{Session::token()}}" />
              <!-- /. -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="submit" class="btn btn-danger">Clear</button>
              </div>
            </form>

            <div class=" table-responsive padding" style="margin-top: 30px;" id="BlockUI">
              <table class="table table-hover table-bordered">

                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>symbol</th>
                  <th>sub. name</th>
                  <th>Action</th>
                </tr>
                <?php $sn = 0; ?>
                @foreach ($currencies as $currency)
                <?php $sn += 1;?>
                <tr>
                  <td>{{$sn}}</td>
                  <td>{{ $currency->name }}</td>
                  <td>{{ $currency->symbol }}</td>
                  <td>{{ $currency->sub_name }}</td>
                  <td>
                    <a href="{{ url('/corphrm/action/delete') }}?type=currency&id={{$currency->id}}"
                      onclick="return confirm('Are you sure you want to delete?');">
                      <button class="btn btn-danger btn-block">Delete</button>
                    </a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <br>

          </div>


          {{--Qualification Form --}}


          <div class=" hidden" id="box-qualification">
            <div class=" with-border">
              <h5 class="box-title">Qualification</h5>
            </div>
            <!-- /. -->
            <!-- form start -->
            <form method="post" action="{{route('post_qualification')}}">
              <div class="">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Enter  Name">
                </div>
                <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" rows="3" placeholder="Enter Description" name="description"></textarea>
                </div>
              </div>
              <input type="hidden" name="_token" value="{{Session::token()}}" />
              <!-- /. -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="submit" class="btn btn-danger">Clear</button>
              </div>
            </form>

            <div class=" table-responsive padding" style="margin-top: 30px;" id="BlockUI">
              <table class="table table-hover table-bordered">

                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
                <?php $sn = 0; ?>
                @foreach ($qualifications as $qualification)
                <?php $sn += 1;?>
                <tr>
                  <td>{{$sn}}</td>
                  <td>{{ $qualification->name }}</td>
                  <td>{{ $qualification->description }}</td>
                  <td>
                    <a href="{{ url('/corphrm/action/delete') }}?type=qualification&id={{$qualification->id}}"
                      onclick="return confirm('Are you sure you want to delete?');">
                      <button class="btn btn-danger btn-block">Delete</button>
                    </a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <br>

          </div>


          {{--Access Roles Form--}}

          <div class=" hidden" id="box-access_roles">
            <div class=" with-border">
              <h5 class="box-title">Access Roles</h5>
            </div>
            <!-- /. -->
            <!-- form start -->
            <form method="post" action="{{route('post_access_roles')}}">
              <div class="">
                <div class="form-group">
                  <label for="name">Role Title</label>
                  <select class="form-control" name="role" id="name">
                    <option value="Director">Director</option>
                    <option value="General Manager">General Manager</option>
                    <option value="Super Administrator">Super Administrator</option>
                    <option value="Administrator">Administrator</option>
                    <option value="Reporting/Line managers ">Reporting/Line managers </option>
                    <option value="HR manager">HR manager</option>
                    <option value="Departmental Manager"> Departmental Manager</option>
                    <option value="staff">Staff</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Role Features</label>
                  <div class="col-md-12" style="border: 2px solid grey; border-radius: 4px; height: auto; margin: 5px;">

                    <p style="text-align:center; font-weight: 600;">Employee Management</p>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Employee Listing</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_employee" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_employee" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_employee" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_employee" checked> Delete
                    </div>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Employee Manager</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_emanager" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_emanager" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_emanager" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_emanager" checked> Delete
                    </div>

                  </div>

                  <div class="col-md-12"
                    style="border: 2px solid grey; border-radius: 4px; height: auto; padding: 5px;">
                    <p style="text-align:center; font-weight: 600;">Recruitment</p>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Recruitment Process</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_rprocess" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_rprocess" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_rprocess" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_rprocess" checked> Delete
                    </div>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Recruitment Application</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_rapplication" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_rapplication" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_rapplication" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_rapplication" checked>
                      Delete
                    </div>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Recruitment Posting</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_rposting" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_rposting" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="vieW_rposting" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_rposting" checked> Delete
                    </div>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Interview Process</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_iprocess" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_iprocess" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_iprocess" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_iprocess" checked> Delete
                    </div>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Interview Process Rating</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_irating" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_irating" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_irating" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_irating" checked> Delete
                    </div>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Interview Shortlisting</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_slisting" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_slisting" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_slisting" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_slisting" checked> Delete
                    </div>
                  </div>
                  <div class="col-md-12" style="border: 2px solid grey; border-radius: 4px; height: auto; margin: 5px;">
                    <p style="text-align:center; font-weight: 600;">Claims</p>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Claims Master</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_cmaster" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_cmaster" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_cmaster" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_cmaster" checked> Delete
                    </div>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Claims Application</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add__capplication" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_capplication" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_capplication" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_capplication" checked>
                      Delete
                    </div>
                  </div>

                  <div class="col-md-12" style="border: 2px solid grey; border-radius: 4px; height: auto; margin: 5px;">
                    <p style="text-align:center; font-weight: 600;">Loans</p>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Loan Master</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_lmaster" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_lmaster" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_lmaster" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_lmaster" checked> Delete
                    </div>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Loan Application</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_lapplication" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_lapplication" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_lapplication" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_lapplication" checked>
                      Delete
                    </div>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Loan Payment</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_lpayment" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_lpayment" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_lpayment" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_lpayment" checked> Delete
                    </div>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Loan Disbursment</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_ldisbursment" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_ldisbursment" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_ldisbursment" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_ldisbursment" checked>
                      Delete
                    </div>
                  </div>
                  <div class="col-md-12" style="border: 2px solid grey; border-radius: 4px; height: auto; margin: 5px;">
                    <p style="text-align:center; font-weight: 600;">Leave</p>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Leave Master</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_lemaster" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_lemaster" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_lemaster" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_lemaster" checked> Delete
                    </div>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Leave Application</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_leapplication" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_leapplication" checked>
                      Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_leapplication" checked>
                      View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_leapplication" checked>
                      Delete
                    </div>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Leave Allowance</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_leallowance" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_leallowance" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_leallowance" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_leallowance" checked>
                      Delete
                    </div>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Leave Credit</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_lecredit" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_lecredit" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_lecredit" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_lecredit" checked> Delete
                    </div>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Leave Calendar</p>

                      <input type="checkbox" name="permission[]" id="permission" value="view_lecalendar" checked> View

                    </div>
                  </div>
                  <div class="col-md-12" style="border: 2px solid grey; border-radius: 4px; height: auto; margin: 5px;">
                    <p style="text-align:center; font-weight: 600;">Cash Advance</p>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Disbursment</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_cadisbursment" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_cadisbursment" checked>
                      Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_cadisbursment" checked>
                      View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_cadisbursment" checked>
                      Delete
                    </div>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Retirement</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_caretirement" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_caretirement" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_caretirement" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_caretirement" checked>
                      Delete
                    </div>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Advance</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_caadvance" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_lpayment" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_lpayment" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_lpayment" checked> Delete
                    </div>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Approval</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_caapproval" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_caapproval" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_caapproval" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_caapproval" checked>
                      Delete
                    </div>
                  </div>
                  <div class="col-md-12" style="border: 2px solid grey; border-radius: 4px; height: auto; margin: 5px;">
                    <p style="text-align:center; font-weight: 600;">Payroll</p>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Staff Payroll</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_payroll" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="view_payroll" checked> View

                    </div>

                  </div>
                  <div class="col-md-12" style="border: 2px solid grey; border-radius: 4px; height: auto; margin: 5px;">
                    <p style="text-align:center; font-weight: 600;">Trainings</p>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Training Master</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_tmaster" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_tmaster" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_tmaster" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_tmaster" checked> Delete
                    </div>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Training Facilitator</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add__tfacilitator" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_tfacilitator" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_tfacilitator" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_tfacilitator" checked>
                      Delete
                    </div>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Trainings Plan</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_tplan" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_tplan" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_tplan" checked> View
                      <input type="checkbox" name="permission[]" id="permission" value="delete_tplan" checked> Delete
                    </div>

                  </div>
                  <div class="col-md-12" style="border: 2px solid grey; border-radius: 4px; height: auto; margin: 5px;">
                    <p style="text-align:center; font-weight: 600;">Payments</p>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Payment</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_payment" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_payment" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_payment" checked> View
                    </div>
                  </div>
                  <div class="col-md-12" style="border: 2px solid grey; border-radius: 4px; height: auto; margin: 5px;">
                    <p style="text-align:center; font-weight: 600;">Misc.</p>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Settings</p>
                      <input type="checkbox" name="permission[]" id="permission" value="add_settings" checked> Add
                      <input type="checkbox" name="permission[]" id="permission" value="edit_settings" checked> Edit
                      <input type="checkbox" name="permission[]" id="permission" value="view_settings" checked> View
                    </div>
                    <div class="col-md-6"
                      style="border: 2px solid grey; border-radius: 4px; height: auto; margin-top: 15px !important; margin-bottom: 10px;">
                      <p style="text-align:center; font-weight: 600;">Logs</p>
                      <input type="checkbox" name="permission[]" id="permission" value="view_logs" checked> View
                    </div>
                  </div>
                </div>
                <br>
                <br>
                <div class="form-group">
                  <label>Role Description</label>
                  <textarea class="form-control" rows="3" placeholder="Role Description" name="description"></textarea>
                </div>
              </div>
              <input type="hidden" name="_token" value="{{Session::token()}}" />
              <!-- /. -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="submit" class="btn btn-danger">Clear</button>
              </div>
            </form>

            <div class=" table-responsive padding" style="margin-top: 30px;" id="BlockUI">
              <table class="table table-hover table-bordered">

                <tr>
                  <th>ID</th>
                  <th>Role</th>
                  <th>Description</th>
                  <th>No of employees</th>
                  <th>Action</th>
                </tr>
                <?php $sn = 0; ?>
                @foreach ($access_roles as $access_role)
                <?php $sn += 1;?>
                <tr>
                  <td>{{$sn}}</td>
                  <td>{{ $access_role->role }}</td>
                  <td>{{ $access_role->role_description }}</td>
                  <?php 
                                   $users_id =  explode(',',$access_role->users_id); 
                                   $i = 0;
                                   foreach ($users_id as $user_id){
                                    $i+=1;
                                   }
                                  // return  $i;
                                    ?>
                  <td>{{ $i }}</td>
                  <td>
                    <div class="btn-group">
                      <a href="{{ url('/corphrm/action/delete') }}?type=role&id={{$access_role->id}}"
                        onclick="return confirm('Are you sure you want to delete this role?');">
                        <button type="button" class="btn btn-sm btn-danger">
                          Delete
                        </button>
                      </a>
                    </div>
                    <!--                                         <div class="btn-group">
                                          <a href="">
                                        <button type="button" class="btn btn-sm btn-success">Edit
                                              </button>
                                            </a>
                                        </div> -->
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
          </div>


          {{--Documents Form--}}

          <div class=" hidden" id="box-document">
            <div class=" with-border">
              <h5 class="box-title">Document</h5>
            </div>
            <!-- /. -->
            <!-- form start -->
            <form method="post" action="{{route('post_document')}}">
              <div class="">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Enter  Name">
                </div>
                <div class="form-group">
                  <label>Comments</label>
                  <textarea class="form-control" rows="3" placeholder="Enter Comment" name="comment"></textarea>
                </div>
              </div>
              <input type="hidden" name="_token" value="{{Session::token()}}" />
              <!-- /. -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="submit" class="btn btn-danger">Clear</button>
              </div>
            </form>

            {{--  start display table  --}}
            <div class=" table-responsive padding" style="margin-top: 30px;" id="BlockUI">
              <table class="table table-hover table-bordered">

                <tr>
                  <th>ID</th>
                  <th>name</th>
                  <th>comment</th>
                  <th>Action</th>
                </tr>
                <?php $sn = 0; ?>
                @foreach($documents as $document)
                <?php $sn = $sn + 1; ?>
                <tr>
                  <td>{{$sn}}</td>
                  <td>{{$document->name}}</td>
                  <td>{{$document->comment}}</td>
                  <td>
                    <a href="{{ url('/corphrm/action/delete') }}?type=document&id={{$document->id}}"
                      onclick="return confirm('Are you sure you want to delete?');">
                      <button class="btn btn-danger btn-block">Delete</button>
                    </a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>

          </div>
          {{--  Email Templates  --}}
          <div class=" hidden" id="box-email_templates">
            <div class=" with-border">
              <h5 class="box-title">Email Templates</h5>
            </div>
            <!-- /. -->
            <!-- form start -->
            <form method="post" action="{{route('post_email_template')}}">
              <div class="">
                <div class="form-group">
                  <label>Category*</label>
                  <select name="category" class="form-control" required="required">
                    <option value="claim_app_admin">Claim Application (Admin)</option>
                    <option value="claim_app_user">Claim Application (User)</option>
                    <option value="loan_app_admin">Loan Application (Admin)</option>
                    <option value="loan_app_user">Loan Application (User)</option>
                    <option value="loan_payment_admin">Loan Payment (Admin)</option>
                    <option value="loan_payment_user">Loan Payment (User)</option>
                    <option value="loan_disbursment_user">Loan Disbursment (User)</option>
                    <option value="leave_app_user">Leave Application (User)</option>
                    <option value="cash_advance_advance_user">Cash Advance Advance (User)</option>
                    <option value="cash_advance_advance_admin">Cash Advance Advance (Admin)</option>
                    <option value="cash_advance_disbursment_user">Cash Advance Disbursment (User)</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Title*</label>
                  <input class="form-control" name="title" required>
                </div>
                <div class="form-group">
                  <label>Body*</label>
                  <br>
                  <label class="text-warning">use [user_name] in of email addresse' fullname, ['user_email']
                    in place of email addresse' email, ['company_name'] in place of company name</label>


                  <div id="toolbar-container">
                    <span class="ql-formats">
                      <select class="ql-size">
                        <option value="10px">Small</option>
                        <option selected>Normal</option>
                        <option value="18px">Large</option>
                        <option value="32px">Huge</option>
                      </select>
                    </span>
                    <span class="ql-formats">
                      <select class="ql-color">
                        <option selected></option>
                        <option value="red"></option>
                        <option value="orange"></option>
                        <option value="yellow"></option>
                        <option value="green"></option>
                        <option value="blue"></option>
                        <option value="purple"></option>
                      </select>
                      <select class="ql-background">
                        <option selected></option>
                        <option value="red"></option>
                        <option value="orange"></option>
                        <option value="yellow"></option>
                        <option value="green"></option>
                        <option value="blue"></option>
                        <option value="purple"></option>
                      </select>
                    </span>
                  </div>
                  <div id="editor-container">
                    <textarea rows="10" class="form-control" name="body" required></textarea>
                  </div>

                  <style>
                    #editor-container {
                      height: 175px;
                    }
                  </style>

                </div>
                <div class="form-group">
                  <button class="btn btn-primary pull-right btn-sm">Submit</button>
                </div>
              </div>
            </form>
            {{--  end form  --}}
            {{--  start display table  --}}
            <div class=" table-responsive padding" style="margin-top: 30px;" id="BlockUI">
              <table class="table table-hover table-bordered">

                <tr>
                  <th>ID</th>
                  <th>category</th>
                  <th>title</th>
                  <th>Action</th>
                </tr>
                <?php $sn = 0; ?>
                @foreach($corphrm_email_templates as $corphrm_email_template)
                <?php $sn = $sn + 1; ?>
                <tr>
                  <td>{{$sn}}</td>
                  <td>{{$corphrm_email_template->category}}</td>
                  <td>{{$corphrm_email_template->title}}</td>
                  <td>
                    <a href="{{ url('/corphrm/action/delete') }}?type=email_template&id={{$corphrm_email_template->id}}"
                      onclick="return confirm('Are you sure you want to delete?');">
                      <button class="btn btn-danger btn-block">Delete</button>
                    </a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            {{--  end display table  --}}
          </div>
          {{--Weekends Form--}}
          <div class=" hidden" id="box-weekoff">
            <div class=" with-border">
              <h5 class="box-title">Weekends</h5>
            </div>
            <!-- /. -->
            <!-- form start -->
            <form method="post" action="{{route('post_weekoff')}}">
              <div class="">
                <div class="form-group">
                  {{--  <label for="day">Day</label>  --}}
                  <?php
                    $days = json_decode($weekends['days']);
                ?>
                  <label>Saturday&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" class="" value="Saturday" name="days[]" />
                  </label>
                  </br>
                  <label>Sunday&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" class="" value="Sunday" name="days[]" />
                  </label>
                </div>
              </div>
              <input type="hidden" name="_token" value="{{Session::token()}}" />
              <!-- /. -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="submit" class="btn btn-danger">Clear</button>
              </div>
            </form>
            {{--  <div class="col-md-12">  --}}
            @foreach($days as $day)
            <div class="panel panel-default" style="margin:15px;">
              <div class="panel-body">
                <b>{{ $day }}</b>
                {{--  <a href="#">
                <span style="float:right !important; color:red;">
                  <b>X</b>
                </span>
              </a>  --}}
              </div>
            </div>
            @endforeach
            <br>
            {{--  </div>  --}}
          </div>

          {{--Employee Category--}}



          <div class=" hidden" id="box-category">
            <div class=" with-border">
              <h5 class="box-title">Category</h5>
            </div>
            <!-- /. -->
            <!-- form start -->
            <form method="post" action="{{route('post_category')}}">
              <div class="">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Enter  Name">
                </div>
                <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" rows="3" placeholder="Enter Description" name="description"></textarea>
                </div>
              </div>
              <input type="hidden" name="_token" value="{{Session::token()}}" />
              <!-- /. -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="submit" class="btn btn-danger">Clear</button>
              </div>
            </form>
          </div>


        </div>
      </div>

    </div>
  </div>

  <div class="modal fade" id="modal-addition_subtraction" role="dialog">
      <div class="modal-dialog modal-md">
          <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Add New</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                  <form class="row" method="post" action="{{ url('corphrm/payroll/post_addition_subtraction') }}"
                      enctype='multipart/form-data'>
                      {{csrf_field()}}
                      <input type="hidden" name="addition" required="">
                      <input type="hidden" name="subtraction" required="">

                      <div class="col-md-12">
                          <div class="form-group">
                              <label>Type:</label>
                              <select class="form-control" required="" name="type" id="type">
                                  <option value="">Choose One</option>
                                  <option value="Basic">Basic</option>
                                  <option value="Custom">Custom</option>
                              </select>
                          </div>
                      </div>

                      <div class="col-md-6 custom_name" id="custom_name" style="display: none;">
                          <div class="form-group">
                              <label>Parameter:</label>
                              <input type="text" class="form-control" name="name_c"
                                  placeholder="Enter Parameter Name">
                          </div>
                      </div>
                      <div class="col-md-12" id="basic_name" style="display: none;">
                          <div class="form-group">
                              <label>Parameter:</label>
                              <select class="form-control" name="name_b">
                                  <option value="">select one</option>
                                  <option value="Loan" style="display: none;" class="deductions">Loan</option>
                                  <option value="Cash Advance" style="display: none;" class="deductions">Cash Advance
                                  </option>
                                  <option value="NHF" style="display: none;" class="deductions">NHF</option>
                                  <option value="NHIS" style="display: none;" class="deductions">NHIS</option>
                                  <option value="Pension" style="display: none;" class="deductions">Pension</option>
                                  <option value="Housing" style="display: none;" class="additions">Housing Allowance
                                  </option>
                                  <option value="Transportation" style="display: none;" class="additions">
                                      Transportation Allowance</option>
                                  <option value="Meal" style="display: none;" class="additions">Meal Allowance
                                  </option>
                              </select>
                          </div>
                      </div>
                      <!--         <div class="col-md-6 custom_name" id="ttype" style="display: none;">
          <div class="form-group" >
              <label>Type:</label>
                  <select class="form-control" name="type" >
                  <option value="Loan">Earnings</option>
                  <option value="Cash Advance">Deduction</option>
              </select>
          </div> 
      </div>  -->
                      <div class="col-md-6 custom_name basic_additions" style="display: none;">
                          <div class="form-group">
                              <label>Frequency</label>
                              <select class="form-control" name="frequency">
                                  <option value="Yearly">Yearly</option>
                                  <option value="Half Yearly">Half Yearly</option>
                                  <option value="Quartely">Quartely</option>
                                  <option value="Monthly">Monthly</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-md-6 custom_name basic_additions" style="display: none;">
                          <div class="form-group">
                              <label>Mode</label>
                              <select class="form-control" name="frequency">
                                  <option value="">Select Mode</option>
                                  <option value="Percent">Percent</option>
                                  <option value="Amount">Amount</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-md-6 custom_name basic_additions" style="display: none;">
                          <div class="form-group">
                              <label>Value</label>
                              <input type="number" name="value" class="form-control">
                          </div>
                      </div>

                      <div class="col-md-6 custom_name basic_additions" style="display: none;">
                          <div class="form-group">
                              <label for="effective_month">Effctive Month</label>
                              <select class="form-control" name="effective_month" id="effective_month">
                                  <option value="january">January</option>
                                  <option value="february">February</option>
                                  <option value="march">March</option>
                                  <option value="april">April</option>
                                  <option value="may">May</option>
                                  <option value="june">June</option>
                                  <option value="july">July</option>
                                  <option value="august">August</option>
                                  <option value="september">September</option>
                                  <option value="october">October</option>
                                  <option value="november">November</option>
                                  <option value="december">December</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-md-6 custom_name basic_additions" style="display: none;">
                          <div class="form-group">
                              <label>Calculate On</label>
                              <select class="form-control" name="calculate">
                                  <option value="basic">Basic</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-md-6 custom_name basic_additions" style="display: none;">
                          <div class="form-group">
                              <label for="assign_to_grade">Assign to Grade</label>
                              <select class="form-control" name="assign_to_grade">
                                  <option value="">Select a Grade</option>
                                  @foreach($grades as $grade)
                                  <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                      <div class="form-group custom_name basic_additions col-md-6" style="display: none;">
                          <label>Wages Type</label>
                          <select class="form-control" name="wages_type">
                              <option>Select WagesType </option>
                              <option value="daily">Daily</option>
                              <option value="weekly">Weekly</option>
                              <option value="monthly">Monthly</option>
                          </select>
                      </div>
                      <div class="col-md-6 custom_name basic_additions" id="is_taxable" style="display: none;">
                          <div class="form-group">
                              <label>Is Taxable</label>
                              <br>
                              <label style="font-weight: 400;"><input type="radio" value="1"
                                      name="is_taxable">&nbsp;&nbsp;Yes</label>
                              <label style="font-weight: 400;"><input type="radio" value="0"
                                      name="is_taxable">&nbsp;&nbsp;No</label>
                          </div>
                      </div>

                      <!--               <div class="col-md-6 custom_name" style="display: none;">
            <div class="form-group">
              <label>Nature</label>
              <select class="form-control" name="nature">
                <option>Select nature</option>
                <option value="fixed">Fixed</option>
                <option value="variable">Variable</option>
              </select>
            </div>
            </div> -->

                      <br><br><br><br>
                      <div class="col-md-12">
                          <div class="form-group">
                              <button type="submit" class="btn pull-right btn-primary btn-sm"
                                  style="border-radius: 0px;">submit</button>
                              <br>
                          </div>
                      </div>
                  </form>
              </div>
              <br>
              <div class="modal-footer">
              </div>
          </div>
      </div>
  </div>


  <section>


      <script src="{{asset('calendar/js/jquery.min.js')}}"></script>
  
      
      <script>
          var BackgroundClass = Quill.import('attributors/class/background');
          var ColorClass = Quill.import('attributors/class/color');
          var SizeStyle = Quill.import('attributors/style/size');
          Quill.register(BackgroundClass, true);
          Quill.register(ColorClass, true);
          Quill.register(SizeStyle, true);
      
          var quill = new Quill('#editor-container', {
              modules: {
                  toolbar: '#toolbar-container'
              },
              placeholder: 'Compose e-mail body...',
              theme: 'snow'
          });
      </script>
      <script type="text/javascript">
          $(document).ready(function () {
      
              $('.addition_subtraction').click(function () {
                  var addition = $(this).attr('addition');
                  var subtraction = $(this).attr('subtraction');
                  if (addition == "1") {
                      var elems = document.getElementsByClassName('additions');
                      for (i = 0; i < elems.length; i++) {
                          elems[i].style.display = 'block';
                          //elems[i].style.top = '100%';
                      }
                      var elemss = document.getElementsByClassName('deductions');
                      for (i = 0; i < elemss.length; i++) {
                          elemss[i].style.display = 'none';
                          //elems[i].style.top = '100%';
                      }
      
                  }
                  if (subtraction == "1") {
                      var elems = document.getElementsByClassName('additions');
                      for (i = 0; i < elems.length; i++) {
                          elems[i].style.display = 'none';
                          //elems[i].style.top = '100%';
                      }
                      var elemss = document.getElementsByClassName('deductions');
                      for (i = 0; i < elemss.length; i++) {
                          elemss[i].style.display = 'block';
                          //elems[i].style.top = '100%';
                      }
      
                  }
                  $('[name="addition"]').val(addition);
                  $('[name="subtraction"]').val(subtraction);
                  $('#modal-addition_subtraction').modal('show');
                  return false;
              });
      
              $(".modal").on("hidden.bs.modal", function () {
      
                  $('[name="type"]').val("");
                  $('[name="name_b"]').val("");
                  $('[name="addition"]').val("");
                  $('[name="is_taxable"]').val("");
                  $('[name="subtraction"]').val("");
                  var elems = document.getElementsByClassName('custom_name');
                  for (i = 0; i < elems.length; i++) {
                      elems[i].style.display = 'none';
                      //elems[i].style.top = '100%';
                  }
                  document.getElementById('basic_name').style.display = 'none';
              });
      
              $('#type').on('change', function () {
                  //alert("k")
                  if ($(this).val() == "Basic") {
                      document.getElementById('basic_name').style.display = 'block';
                      var elems = document.getElementsByClassName('custom_name');
                      for (i = 0; i < elems.length; i++) {
                          elems[i].style.display = 'none';
                          //elems[i].style.top = '100%';
                      }
                      // document.getElementById('is_taxable').style.display = 'block';
                      var addition = $('[name="addition"]').val();
                      if (addition == "1") {
                          var elems = document.getElementsByClassName('basic_additions');
                          for (i = 0; i < elems.length; i++) {
                              elems[i].style.display = 'block';
                              //elems[i].style.top = '100%';
                          }
                      }
                  }
                  if ($(this).val() == "Custom") {
                      document.getElementById('basic_name').style.display = 'none';
                      var elems = document.getElementsByClassName('custom_name');
                      for (i = 0; i < elems.length; i++) {
                          elems[i].style.display = 'block';
                          //elems[i].style.top = '100%';
                      }
                      //    document.getElementById('ttype').style.display = 'block';
                  }
              });
      
              $('[name="name_b"]').on('change', function () {
                  //alert("k")
                  if ($(this).val() == "Loan" || $(this).val() == "Cash Advance") {
                      $('[name="is_taxable"]').val(1);
      
                  }
              });
          });
      </script>
      <script>
          $(document).ready(function () {

            // alert('hey');
              $('#control_settings').on('change', function () {
      
                  if ($(this).val() == "allowances") {
                      $('#box-allowances').removeClass('hidden');
                      $('#box-pension').addClass('hidden');
                      $('#box-health').addClass('hidden');
                      $('#box-internal').addClass('hidden');
                      $('#box-branches').addClass('hiddden');
                      $('#box-departments').addClass('hidden');
                      $('#box-currencies').addClass('hidden');
                      $('#box-qualification').addClass('hidden');
                      $('#box-access_roles').addClass('hidden');
                      $('#box-document').addClass('hidden');
                      $('#box-weekoff').addClass('hidden');
                      $('#box-category').addClass('hidden');
                      $('#box-grades').addClass('hidden');
                      $('#box-banks').addClass('hidden');
                      $('#box-designation').addClass('hidden');
                      $('#box-holidays').addClass('hidden');
                      $('#box-email_templates').addClass('hidden');
      
                  }
                  if ($(this).val() == "pension") {
                      $('#box-allowances').addClass('hidden');
                      $('#box-pension').removeClass('hidden');
                      $('#box-health').addClass('hidden');
                      $('#box-internal').addClass('hidden');
                      $('#box-branches').addClass('hidden');
                      $('#box-departments').addClass('hidden');
                      $('#box-currencies').addClass('hidden');
                      $('#box-qualification').addClass('hidden');
                      $('#box-access_roles').addClass('hidden');
                      $('#box-document').addClass('hidden');
                      $('#box-weekoff').addClass('hidden');
                      $('#box-category').addClass('hidden');
                      $('#box-grades').addClass('hidden');
                      $('#box-banks').addClass('hidden');
                      $('#box-designation').addClass('hidden');
                      $('#box-holidays').addClass('hidden');
                      $('#box-email_templates').addClass('hidden');
                  }
                  if ($(this).val() == "health") {
                      $('#box-allowances').addClass('hidden');
                      $('#box-pension').addClass('hidden');
                      $('#box-health').removeClass('hidden');
                      $('#box-internal').addClass('hidden');
                      $('#box-branches').addClass('hiddden');
                      $('#box-departments').addClass('hidden');
                      $('#box-currencies').addClass('hidden');
                      $('#box-qualification').addClass('hidden');
                      $('#box-access_roles').addClass('hidden');
                      $('#box-document').addClass('hidden');
                      $('#box-weekoff').addClass('hidden');
                      $('#box-category').addClass('hidden');
                      $('#box-grades').addClass('hidden');
                      $('#box-banks').addClass('hidden');
                      $('#box-designation').addClass('hidden');
                      $('#box-holidays').addClass('hidden');
                      $('#box-email_templates').addClass('hidden');
                  }
                  if ($(this).val() == "internal") {
                      $('#box-allowances').addClass('hidden');
                      $('#box-pension').addClass('hidden');
                      $('#box-health').addClass('hidden');
                      $('#box-internal').removeClass('hidden');
                      $('#box-branches').addClass('hiddden');
                      $('#box-departments').addClass('hidden');
                      $('#box-currencies').addClass('hidden');
                      $('#box-qualification').addClass('hidden');
                      $('#box-access_roles').addClass('hidden');
                      $('#box-document').addClass('hidden');
                      $('#box-weekoff').addClass('hidden');
                      $('#box-category').addClass('hidden');
                      $('#box-grades').addClass('hidden');
                      $('#box-banks').addClass('hidden');
                      $('#box-designation').addClass('hidden');
                      $('#box-holidays').addClass('hidden');
                      $('#box-email_templates').addClass('hidden');
                  }
                  if ($(this).val() == "branches") {
                      $('#box-allowances').addClass('hidden');
                      $('#box-pension').addClass('hidden');
                      $('#box-health').addClass('hidden');
                      $('#box-internal').addClass('hidden');
                      $('#box-branches').removeClass('hidden');
                      $('#box-departments').addClass('hidden');
                      $('#box-currencies').addClass('hidden');
                      $('#box-qualification').addClass('hidden');
                      $('#box-access_roles').addClass('hidden');
                      $('#box-document').addClass('hidden');
                      $('#box-weekoff').addClass('hidden');
                      $('#box-category').addClass('hidden');
                      $('#box-grades').addClass('hidden');
                      $('#box-banks').addClass('hidden');
                      $('#box-designation').addClass('hidden');
                      $('#box-holidays').addClass('hidden');
                      $('#box-email_templates').addClass('hidden');
                  }
                  if ($(this).val() == "departments") {
                      $('#box-allowances').addClass('hidden');
                      $('#box-pension').addClass('hidden');
                      $('#box-health').addClass('hidden');
                      $('#box-internal').addClass('hidden');
                      $('#box-branches').addClass('hidden');
                      $('#box-departments').removeClass('hidden');
                      $('#box-currencies').addClass('hidden');
                      $('#box-qualification').addClass('hidden');
                      $('#box-access_roles').addClass('hidden');
                      $('#box-document').addClass('hidden');
                      $('#box-weekoff').addClass('hidden');
                      $('#box-category').addClass('hidden');
                      $('#box-grades').addClass('hidden');
                      $('#box-banks').addClass('hidden');
                      $('#box-designation').addClass('hidden');
                      $('#box-holidays').addClass('hidden');
                      $('#box-email_templates').addClass('hidden');
                  }
                  if ($(this).val() == "currencies") {
                      $('#box-allowances').addClass('hidden');
                      $('#box-pension').addClass('hidden');
                      $('#box-health').addClass('hidden');
                      $('#box-internal').addClass('hidden');
                      $('#box-branches').addClass('hiddden');
                      $('#box-departments').addClass('hidden');
                      $('#box-currencies').removeClass('hidden');
                      $('#box-qualification').addClass('hidden');
                      $('#box-access_roles').addClass('hidden');
                      $('#box-document').addClass('hidden');
                      $('#box-weekoff').addClass('hidden');
                      $('#box-category').addClass('hidden');
                      $('#box-grades').addClass('hidden');
                      $('#box-banks').addClass('hidden');
                      $('#box-designation').addClass('hidden');
                      $('#box-holidays').addClass('hidden');
                      $('#box-email_templates').addClass('hidden');
                  }
      
                  if ($(this).val() == "qualification") {
                      $('#box-allowances').addClass('hidden');
                      $('#box-pension').addClass('hidden');
                      $('#box-health').addClass('hidden');
                      $('#box-internal').addClass('hidden');
                      $('#box-branches').addClass('hidden');
                      $('#box-departments').addClass('hidden');
                      $('#box-currencies').addClass('hidden');
                      $('#box-qualification').removeClass('hidden');
                      $('#box-access_roles').addClass('hidden');
                      $('#box-document').addClass('hidden');
                      $('#box-weekoff').addClass('hidden');
                      $('#box-category').addClass('hidden');
                      $('#box-grades').addClass('hidden');
                      $('#box-banks').addClass('hidden');
                      $('#box-designation').addClass('hidden');
                      $('#box-holidays').addClass('hidden');
                      $('#box-email_templates').addClass('hidden');
                  }
                  if ($(this).val() == "document") {
                      $('#box-allowances').addClass('hidden');
                      $('#box-pension').addClass('hidden');
                      $('#box-health').addClass('hidden');
                      $('#box-internal').addClass('hidden');
                      $('#box-branches').addClass('hidden');
                      $('#box-departments').addClass('hidden');
                      $('#box-currencies').addClass('hidden');
                      $('#box-qualification').addClass('hidden');
                      $('#box-access_roles').addClass('hidden');
                      $('#box-document').removeClass('hidden');
                      $('#box-weekoff').addClass('hidden');
                      $('#box-category').addClass('hidden');
                      $('#box-grades').addClass('hidden');
                      $('#box-banks').addClass('hidden');
                      $('#box-designation').addClass('hidden');
                      $('#box-holidays').addClass('hidden');
                      $('#box-email_templates').addClass('hidden');
                  }
                  if ($(this).val() == "access_roles") {
                      $('#box-allowances').addClass('hidden');
                      $('#box-pension').addClass('hidden');
                      $('#box-health').addClass('hidden');
                      $('#box-internal').addClass('hidden');
                      $('#box-branches').addClass('hidden');
                      $('#box-departments').addClass('hidden');
                      $('#box-currencies').addClass('hidden');
                      $('#box-qualification').addClass('hidden');
                      $('#box-access_roles').removeClass('hidden');
                      $('#box-document').addClass('hidden');
                      $('#box-weekoff').addClass('hidden');
                      $('#box-category').addClass('hidden');
                      $('#box-grades').addClass('hidden');
                      $('#box-banks').addClass('hidden');
                      $('#box-designation').addClass('hidden');
                      $('#box-holidays').addClass('hidden');
                      $('#box-email_templates').addClass('hidden');
                  }
                  if ($(this).val() == "weekoff") {
                      $('#box-allowances').addClass('hidden');
                      $('#box-pension').addClass('hidden');
                      $('#box-health').addClass('hidden');
                      $('#box-internal').addClass('hidden');
                      $('#box-branches').addClass('hidden');
                      $('#box-departments').addClass('hidden');
                      $('#box-currencies').addClass('hidden');
                      $('#box-qualification').addClass('hidden');
                      $('#box-access_roles').addClass('hidden');
                      $('#box-document').addClass('hidden');
                      $('#box-weekoff').removeClass('hidden');
                      $('#box-category').addClass('hidden');
                      $('#box-grades').addClass('hidden');
                      $('#box-banks').addClass('hidden');
                      $('#box-designation').addClass('hidden');
                      $('#box-holidays').addClass('hidden');
                      $('#box-email_templates').addClass('hidden');
                  }
                  if ($(this).val() == "category") {
                      $('#box-allowances').addClass('hidden');
                      $('#box-pension').addClass('hidden');
                      $('#box-health').addClass('hidden');
                      $('#box-internal').addClass('hidden');
                      $('#box-branches').addClass('hidden');
                      $('#box-departments').addClass('hidden');
                      $('#box-currencies').addClass('hidden');
                      $('#box-qualification').addClass('hidden');
                      $('#box-access_roles').addClass('hidden');
                      $('#box-document').addClass('hidden');
                      $('#box-weekoff').addClass('hidden');
                      $('#box-category').removeClass('hidden');
                      $('#box-grades').addClass('hidden');
                      $('#box-banks').addClass('hidden');
                      $('#box-designation').addClass('hidden');
                      $('#box-holidays').addClass('hidden');
                      $('#box-email_templates').addClass('hidden');
                  }
                  if ($(this).val() == "grades") {
                      $('#box-allowances').addClass('hidden');
                      $('#box-pension').addClass('hidden');
                      $('#box-health').addClass('hidden');
                      $('#box-internal').addClass('hidden');
                      $('#box-branches').addClass('hiddden');
                      $('#box-departments').addClass('hidden');
                      $('#box-currencies').addClass('hidden');
                      $('#box-qualification').addClass('hidden');
                      $('#box-access_roles').addClass('hidden');
                      $('#box-document').addClass('hidden');
                      $('#box-weekoff').addClass('hidden');
                      $('#box-category').addClass('hidden');
                      $('#box-grades').removeClass('hidden');
                      $('#box-banks').addClass('hidden');
                      $('#box-designation').addClass('hidden');
                      $('#box-holidays').addClass('hidden');
                      $('#box-email_templates').addClass('hidden');
                  }
                  if ($(this).val() == "banks") {
                      $('#box-allowances').addClass('hidden');
                      $('#box-pension').addClass('hidden');
                      $('#box-health').addClass('hidden');
                      $('#box-internal').addClass('hidden');
                      $('#box-branches').addClass('hiddden');
                      $('#box-departments').addClass('hidden');
                      $('#box-currencies').addClass('hidden');
                      $('#box-qualification').addClass('hidden');
                      $('#box-access_roles').addClass('hidden');
                      $('#box-document').addClass('hidden');
                      $('#box-weekoff').addClass('hidden');
                      $('#box-category').addClass('hidden');
                      $('#box-grades').addClass('hidden');
                      $('#box-banks').removeClass('hidden');
                      $('#box-designation').addClass('hidden');
                      $('#box-holidays').addClass('hidden');
                      $('#box-email_templates').addClass('hidden');
                  }
                  if ($(this).val() == "designation") {
                      $('#box-allowances').addClass('hidden');
                      $('#box-pension').addClass('hidden');
                      $('#box-health').addClass('hidden');
                      $('#box-internal').addClass('hidden');
                      $('#box-branches').addClass('hiddden');
                      $('#box-departments').addClass('hidden');
                      $('#box-currencies').addClass('hidden');
                      $('#box-qualification').addClass('hidden');
                      $('#box-access_roles').addClass('hidden');
                      $('#box-document').addClass('hidden');
                      $('#box-weekoff').addClass('hidden');
                      $('#box-category').addClass('hidden');
                      $('#box-grades').addClass('hidden');
                      $('#box-banks').addClass('hidden');
                      $('#box-designation').removeClass('hidden');
                      $('#box-holidays').addClass('hidden');
                      $('#box-email_templates').addClass('hidden');
                  }
                  if ($(this).val() == "holidays") {
                      $('#box-allowances').addClass('hidden');
                      $('#box-pension').addClass('hidden');
                      $('#box-health').addClass('hidden');
                      $('#box-internal').addClass('hidden');
                      $('#box-branches').addClass('hidden');
                      $('#box-departments').addClass('hidden');
                      $('#box-currencies').addClass('hidden');
                      $('#box-qualification').addClass('hidden');
                      $('#box-access_roles').addClass('hidden');
                      $('#box-document').addClass('hidden');
                      $('#box-weekoff').addClass('hidden');
                      $('#box-category').addClass('hidden');
                      $('#box-grades').addClass('hidden');
                      $('#box-banks').addClass('hidden');
                      $('#box-designation').addClass('hidden');
                      $('#box-holidays').removeClass('hidden');
                      $('#box-email_templates').addClass('hidden');
                  }
                  if ($(this).val() == "email_templates") {
                      $('#box-allowances').addClass('hidden');
                      $('#box-pension').addClass('hidden');
                      $('#box-health').addClass('hidden');
                      $('#box-internal').addClass('hidden');
                      $('#box-branches').addClass('hidden');
                      $('#box-departments').addClass('hidden');
                      $('#box-currencies').addClass('hidden');
                      $('#box-qualification').addClass('hidden');
                      $('#box-access_roles').addClass('hidden');
                      $('#box-document').addClass('hidden');
                      $('#box-weekoff').addClass('hidden');
                      $('#box-category').addClass('hidden');
                      $('#box-grades').addClass('hidden');
                      $('#box-banks').addClass('hidden');
                      $('#box-designation').addClass('hidden');
                      $('#box-email_templates').removeClass('hidden');
                      $('#box-holidays').addClass('hidden');
                  }
              });
          });
      </script>
      <script>
          $('#date_from').datepicker({
              autoclose: true
          });
      
          $('#date_to').datepicker({
              autoclose: true
          });
      </script>
    @endsection
    