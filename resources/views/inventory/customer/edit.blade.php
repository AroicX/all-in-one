<!doctype html>
<html>
<title>CorpERM </title>
@include('includes.Head')
<meta id="token" name="token" content="{ { csrf_token() } }">
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

@include('includes.Header')
@include('includes.Menu')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
      
        <br>
    @include('includes.status')
    <!-- Main content -->
				<section class="content" id="blockUI" style="background:#fff !important; margin-left:10px; margin-right:50px;">
				<h3>Edit Customer</h3>
            <!-- Small boxes (Stat box) -->
            <form  action="{{route('customer.update', $customer->id)}}" method="post">
                {{method_field('PATCH')}}
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-sm-6">
                                 <div class="form-group">
                                    <label>Title</label>
                                    <select class="selectpicker form-control "
                                           name="title" placeholder="" required>
                                        <option value="{{$customer->title}}" disabled selected>{{$customer->title}}</option>
                                        <option value="Mr.">Mr.</option>
                                        <option value="Mrs.">Mrs.</option>
                                        <option value="Ms.">Ms.</option>
                                        <option value="Miss">Miss</option>
                                        <option value="Master">Master</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label>Customer's Last name</label>
                                    <input type="text" name="lastname" class="form-control"
                                           placeholder="Enter customer's last name" value="{{$customer->lastname}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label>Customer's Middle name</label>
                                    <input type="text" name="middle_name" class="form-control"
                                       value="{{$customer->middle_name}}"    placeholder="Enter customer's middle name"  >
                                </div>
                            </div>
                             <div class="col-sm-6">

                                <div class="form-group">
                                    <label>Customer's First name</label>
                                    <input type="text" name="first_name" class="form-control"
                                       value="{{$customer->first_name}}"    placeholder="Enter customer's first name" required>
                                </div>
                            </div>
                          
                        </div>

                        <div class="row">
                              <div class="col-sm-6">
                                 <div class="form-group" style="">
                                    <label>Date of Birth</label>
                                    <input type="date" name="DOB" class="form-control" placeholder="yyyy-mm-dd"
                                        value="{{$customer->DOB}}"   required>
                                </div>
                            </div>
                               <div class="col-sm-6">
                               	 <div class="form-group">
                                    <label>Gender</label>
                                    <select class="selectpicker form-control "
                                           name="gender" placeholder="" required>
                                        <option value="{{$customer->gender}}" disabled selected>{{$customer->gender}}</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                               </div>
                            
                        </div>

                        <div class="row">
                          

                            <div class="col-sm-6">

                                <div class="form-group" style="">
                                    <label>Customer's Email</label>
                                    <input type="text" name="email" class="form-control" placeholder="Enter customer's email"
                                        value="{{$customer->email}}"   required>
                                </div>
                                    </div>
                            <div class="col-sm-6">

                                <div class="form-group" style="">
                                    <label>Website</label>
                                    <input type="text" name="website" class="form-control" value="{{$customer->website}}" placeholder="Customer's Website"
                                           >
                                </div>
                               
                            </div>
                            
                        </div>
                         <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group" style="">
                                    <label>Customer's Tax/Vat Number</label>
                                    <input type="text" name="tax_vat" class="form-control" value="{{$customer->tax_vat}}" placeholder="Enter customer's Tax/Vat"
                                           >
                                </div>
                                    </div>
                            <div class="col-sm-6">

                                <div class="form-group" style="">
                                    <label>Customer Group</label>
                                    <select  class="selectpicker form-control " name="customer_group" required>
                                        <option disabled selected value="{{$customer->customer_group}}">{{$customer->customer_group}}</option>
                                        <option value="Wholesale">Wholesale</option>
                                        <option value="Retail">Retail</option>
                                        <option value="General">General</option>
                                        <option value="Employee">Employee</option>
                                    </select>
                                </div>
                               
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Additional Information</label>
                                    <input type="text" name="additional_info" class="form-control" value="{{$customer->additional_info}}" placeholder = "Additional information">
                                </div>
                                
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Edit customer</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
		  </div>
    <!-- /.content-wrapper -->
    @include('includes.Footer')
    @include('includes.Sidebar')
</div>
<!-- ./wrapper -->
@include('includes.Includes')
<script src="{{asset('js/general/Setup.js')}}"></script>
</body>
</html>
