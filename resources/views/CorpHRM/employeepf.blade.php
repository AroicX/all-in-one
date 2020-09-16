@extends('CorpHRM.layout.master')

@section('title')
<title>Personal Information</title>
@endsection

@section('content')

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>Employee</h5>
                </div>
                <div class="card-body">
                    <div class="bt-wizard" id="progresswizard">
                        <ul class="nav nav-pills nav-fill mb-3">
                            <li class="nav-item"><a href="#progress-t-tab1" class="nav-link active"
                                    data-toggle="tab">Profile</a></li>
                            <li class="nav-item"><a href="#progress-t-tab2" class="nav-link has-ripple"
                                    data-toggle="tab">Personal</a></li>
                            <li class="nav-item"><a href="#progress-t-tab3" class="nav-link has-ripple"
                                    data-toggle="tab">Dependent</a></li>
                            <li class="nav-item"><a href="#progress-t-tab4" class="nav-link has-ripple"
                                    data-toggle="tab">Qualifiications</a></li>
                            <li class="nav-item"><a href="#progress-t-tab5" class="nav-link has-ripple"
                                    data-toggle="tab">Emergency</a></li>
                            <li class="nav-item"><a href="#progress-t-tab6" class="nav-link has-ripple"
                                    data-toggle="tab">Skills</a></li>
                            <li class="nav-item"><a href="#progress-t-tab7" class="nav-link has-ripple"
                                    data-toggle="tab">Experience</a></li>
                            <li class="nav-item"><a href="#progress-t-tab8" class="nav-link has-ripple"
                                    data-toggle="tab">Language</a></li>
                            <li class="nav-item"><a href="#progress-t-tab9" class="nav-link has-ripple"
                                    data-toggle="tab">Asset Assigned</a></li>
                            <li class="nav-item"><a href="#progress-t-tab10" class="nav-link has-ripple"
                                    data-toggle="tab">References</a></li>
                            <li class="nav-item"><a href="#progress-t-tab11" class="nav-link has-ripple"
                                    data-toggle="tab">Document</a></li>
                            <li class="nav-item"><a href="#progress-t-tab12" class="nav-link has-ripple"
                                    data-toggle="tab">Salary</a></li>
                        </ul>

                        <form role="form" action="{{route('profile')}}" method="post" enctype='multipart/form-data'>
                            @if(count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                                @foreach($errors->all() as $error)
                                <p> <i class="icon fa fa-ban"></i> {{$error}} </p>
                                @endforeach
                            </div>
                            @endif

                            <div class="tab-content">

                                <div class="tab-pane active" id="progress-t-tab1">
                                    <div class="row flex-reserve">

                                        <div class="form-group col-md-4">
                                            <label for="name">Title </label>
                                            <input type="text" class="form-control" name="title" id="title"
                                                placeholder="Enter Title">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Surname </label>
                                            <input type="text" class="form-control" name="surname" id="surname"
                                                placeholder="Enter Surname">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="name">MiddleName </label>
                                            <input type="text" class="form-control" name="middlename" id="middlename"
                                                placeholder="Enter Middlename">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="name">FirstName </label>
                                            <input type="text" class="form-control" name="firstname" id="firstname"
                                                placeholder="Enter Firstname">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="name">Employee Code</label>
                                            <input type="text" class="form-control" readonly value="{{$employee_code}}"
                                                name="employee_code" id="employee_code"
                                                placeholder="Enter EmployeeCode">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Designation </label>
                                            <select class="form-control" name="designation">
                                                <option>Select Designation</option>
                                                @foreach($designations as $designation)
                                                <option value="{{$designation->name}}">{{$designation->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Catergory </label>
                                            <select class="form-control" name="category">
                                                <option>-Select-</option>
                                                @foreach($categories as $category)
                                                <option value="{{$category->name}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Grade </label>
                                            <select class="form-control" name="grade">
                                                <option>Select a Grade</option>
                                                @foreach($grades as $grade)
                                                <option value="{{$grade->name}}">{{$grade->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Department </label>
                                            <select class="form-control" name="department">
                                                <option>Select a Department</option>
                                                @foreach($departments as $department)
                                                <option value="{{$department->name}}">{{$department->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Branch </label>
                                            <select class="form-control" name="branch">
                                                <option>Select a Branch</option>
                                                @foreach($branches as $branch)
                                                <option value="{{$branch->name}}">{{$branch->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Joining Date </label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="date" class="form-control pull-right" id="join_date"
                                                    name="join_date">
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="file">Choose a Picture</label>
                                            <input type="file" class="form-control" name="file" id="file">
                                        </div>
                                    </div>




                                </div>
                                <div class="tab-pane " id="progress-t-tab2">
                                    <div class="row">

                                        <div class="form-group col-md-4">
                                            <label>Religion</label>
                                            <select class="form-control" name="religion">
                                                <option>Select a Religion</option>
                                                <option value="C">Christianity</option>
                                                <option value="I">Islam</option>
                                                <option value="O">Others</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>SBIRS</label>
                                            <select class="form-control" name="sbirs">
                                                <option>-Select-</option>
                                                @foreach($revenues as $revenue)
                                                <option value="{{$revenue->name}}">{{$revenue->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="telephone_no">Telephone Number</label>
                                            <input type="text" class="form-control" name="telephone_number"
                                                id="telephone_number" placeholder="Enter Telephone Number">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="mobile_no">Mobile Number</label>
                                            <input type="text" class="form-control" name="mobile_number"
                                                id="mobile_number" placeholder="Enter Mobile Number">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="personal_email_address">Personal Email Address</label>
                                            <input type="text" class="form-control" name="personal_email_address"
                                                id="personal_email_address" placeholder="Enter Personal Email Address">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="official_email_address">Official Email Address</label>
                                            <input type="text" class="form-control" name="official_email_address"
                                                id="official_email_address" placeholder="Enter Official Email Address">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="national_id_no">National ID Number</label>
                                            <input type="text" class="form-control" name="national_id_no"
                                                id="national_id_no" placeholder="Enter National ID Number">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="driver_license_no">Driver License Number</label>
                                            <input type="text" class="form-control" name="driver_license_no"
                                                id="driver_license_no" placeholder="Enter Driver License Number">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="state_of_origin">State Of Origin</label>
                                            <select class="form-control" name="state_of_origin" id="state_of_origin">
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

                                        <div class="form-group col-md-4">
                                            <label for="local_govt_area">Local Government Area</label>
                                            <input type="text" class="form-control" name="local_govt_area"
                                                id="local_govt_area" placeholder="Enter Local Government Area">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Blood Group</label>
                                            <select class="form-control" name="blood_group">
                                                <option>Select a Blood Group</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="O">Others</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Genotype</label>
                                            <select class="form-control" name="genotype">
                                                <option>Select a Genotype</option>
                                                <option value="AA">AA</option>
                                                <option value="AB">AB</option>
                                                <option value="O">O</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>HMo</label>
                                            <select class="form-control" name="hmo">
                                                <option>Select a HMO </option>
                                                @foreach($healths as $health)
                                                <option value="{{$health->name}}">{{$health->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Postal Address</label>
                                            <textarea class="form-control" rows="3" placeholder="Postal Address"
                                                name="postal_address"></textarea>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Residential Address</label>
                                            <textarea class="form-control" rows="3" placeholder="Enter Address"
                                                name="residential_address"></textarea>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Permanent Address</label>
                                            <textarea class="form-control" rows="3" placeholder="Enter Address"
                                                name="permanent_address"></textarea>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Pension Fund Administrator</label>
                                            <select class="form-control" name="pension_fund_administrator">
                                                <option>Select a Pension Fund Administrator </option>
                                                @foreach($pfas as $pfa)
                                                <option value="{{$pfa->name}}">{{$pfa->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Pension Pin Number</label>
                                            <input type="text" class="form-control" name="pension_pin_no"
                                                id="pension_pin_no" placeholder="Enter Pension Pin Number">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Number of Children</label>
                                            <input type="text" class="form-control" name="no_of_children"
                                                id="no_of_children" placeholder="Enter Number of Children">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Name of Spouse</label>
                                            <input type="text" class="form-control" name="name_of_spouse"
                                                id="name_of_spouse" placeholder="Enter Name of Spouse">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Gender</label>
                                            <select class="form-control" name="gender">
                                                <option>Select Gender </option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Date of Birth</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="date" class="form-control pull-right" id="date_of_birth"
                                                    name="date_of_birth">
                                            </div>
                                            <!-- /.input group -->
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>PhoneNumber of Spouse</label>
                                            <input type="text" class="form-control" name="phone_no_spouse"
                                                id="phone_no_spouse" placeholder="Enter PhoneNumber of Spouse">
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label>Marital Status</label>
                                            <select class="form-control" name="marital_status">
                                                <option>Select Marital Status </option>
                                                <option value="single">Single</option>
                                                <option value="married">Married</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Nationality</label>
                                            <input type="text" class="form-control" name="nationality" id="nationality"
                                                placeholder="Enter Nationality">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>City</label>
                                            <input type="text" class="form-control" name="city" id="city"
                                                placeholder="Enter City">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Country Address</label>
                                            <input type="text" class="form-control" name="country_address"
                                                id="country_address" placeholder="Country Address">
                                        </div>


                                    </div>


                                </div>
                                <div class="tab-pane " id="progress-t-tab3">
                                    <div class="row">

                                        <div class="form-group col-md-4">
                                            <label for="name">FirstName</label>
                                            <input type="text" class="form-control" name="dependent_firstname[]"
                                                id="dependent_firstname" placeholder="Enter FirstName">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="name">LastName</label>
                                            <input type="text" class="form-control" name="dependent_lastname[]"
                                                id="dependent_LastName" placeholder="Enter LastName">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Relationship</label>
                                            <input type="text" class="form-control" name="dependent_relationship[]"
                                                id="dependent_relationship" placeholder="Enter Relationship">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Date of Birth</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="date" class="form-control pull-right"
                                                    id="dependent_date_of_birth" name="dependent_date_of_birth[]">
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Gender</label>
                                            <select class="form-control" name="dependent_gender[]">
                                                <option>Select Gender </option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>

                                    </div>

                                </div>
                                <div class="tab-pane " id="progress-t-tab4">
                                    <div class="row">
                                        <div class="form-group col-md-6 py-4">
                                            <button type="button" class="btn btn-primary pull-right" id="add2">Add More
                                                <span class="glyphicon glyphicon-add"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="form-group col-md-4">
                                            <label for="name">Qulaification</label>
                                            <input type="text" class="form-control" name="qualification[]" id="name"
                                                placeholder="Enter Qualification">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Specialization</label>
                                            <input type="text" class="form-control" name="specialization[]" id="name"
                                                placeholder="Enter Specialization">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Year of Completion</label>
                                            <input type="text" class="form-control" name="completion[]" id="completion"
                                                placeholder="Enter Year of Completion">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Start Date</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="date" class="form-control pull-right" id="start_date"
                                                    name="start_date[]">
                                            </div>
                                            <!-- /.input group -->
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>End Date</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="date" class="form-control pull-right" id="end_date"
                                                    name="end_date[]">
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Comments</label>
                                            <textarea class="form-control" rows="3" name="comments[]"></textarea>
                                        </div>

                                        <input type="hidden" name="_token" value="{{Session::token()}}" />


                                        <!--row-->
                                    </div>
                                </div>
                                <div class="tab-pane " id="progress-t-tab5">
                                    <div class="row py-4">
                                        <div class="form-group col-md-6">
                                            <button type="button" class="btn btn-primary pull-right"
                                                onclick="AddMore('emergency','formemergency',this.id)">Add More
                                                <span class="glyphicon glyphicon-add"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">


                                        <div class="form-group col-md-4">
                                            <label for="name">FirstName</label>
                                            <input type="text" class="form-control" name="emergency_firstname[]"
                                                id="emergency_firstname" placeholder="Enter FirstName">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">LastName</label>
                                            <input type="text" class="form-control" name="emergency_lastname[]"
                                                id="emergency_lastname" placeholder="Enter LastName">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Relationship</label>
                                            <input type="text" class="form-control" name="emergency_relationship[]"
                                                id="emergency_relationship" placeholder="Enter Relationship">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="name">Mobile Number</label>
                                            <input type="text" class="form-control" name="emergency_mobile_number[]"
                                                id="emergency_mobile_number" placeholder="Enter Mobile Number">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Phone Number</label>
                                            <input type="text" class="form-control" name="emergency_phone_number[]"
                                                id="emergency_phone_number" placeholder="Enter Mobile Number">
                                        </div>
                                        <input type="hidden" name="_token" value="{{Session::token()}}" />
                                    </div>


                                    <!--row-->
                                </div>
                                <div class="tab-pane " id="progress-t-tab6">
                                    <div class="row py-4">
                                        <div class="form-group col-md-6">
                                            <button type="button" class="btn btn-primary pull-right"
                                                onclick="AddMore('skills','formskills')">Add More
                                                <span class="glyphicon glyphicon-add"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="form-group col-md-4">
                                            <label>Skill Name</label>
                                            <input type="text" class="form-control" name="skill_name[]"
                                                placeholder="Enter Skills">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Year of Experience</label>
                                            <input type="text" class="form-control" name="experience[]" id="experience"
                                                placeholder="Enter Experience">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Comments</label>
                                            <textarea class="form-control" rows="3" placeholder="Enter Comments"
                                                name="comments[]"></textarea>
                                        </div>



                                        <!--row-->
                                    </div>
                                </div>
                                <div class="tab-pane " id="progress-t-tab7">
                                    <div class="row py-4">
                                        <div class="form-group col-md-6">
                                            <button type="button" class="btn btn-primary pull-right"
                                                onclick="AddMore('experiencef','formexperience')">Add More
                                                <span class="glyphicon glyphicon-add"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Employer</label>
                                            <input type="text" class="form-control" name="employer[]">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Designation</label>
                                            <input type="text" class="form-control" name="experience_designation[]">

                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Job Description</label>
                                            <textarea class="form-control" name="job_description[]" rows="3"
                                                placeholder="Enter Comments"></textarea>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Period</label>
                                            <input type="text" class="form-control" name="period[]" id="period"
                                                placeholder="Enter Period">
                                        </div>
                                        <input type="hidden" name="_token" value="{{Session::token()}}" />
                                        <!--row-->
                                    </div>
                                </div>
                                <div class="tab-pane " id="progress-t-tab8">
                                    <div class="row py-4">
                                        <div class="form-group col-md-6">
                                            <button type="button" class="btn btn-primary pull-right"
                                                onclick="AddMore('language','formlanguage')">Add More
                                                <span class="glyphicon glyphicon-add"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="form-group col-md-4">
                                            <label for="name">Langauage</label>
                                            <input type="text" class="form-control" name="language[]" id="language"
                                                placeholder="Enter Experience">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Fluency</label>
                                            <select class="form-control" name="fluency[]">
                                                <option>Select Fluency </option>
                                                <option value="good">Good</option>
                                                <option value="basic">Basic</option>
                                                <option value="native">NativeLanguage</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Ability</label>
                                            <select class="form-control" name="ability[]">
                                                <option>Select Fluency </option>
                                                <option value="writing">Writing</option>
                                                <option value="basic">Reading</option>
                                                <option value="native">Speaking</option>
                                            </select>
                                        </div>
                                        <input type="hidden" name="_token" value="{{Session::token()}}" />

                                        <!--row-->
                                    </div>
                                </div>
                                <div class="tab-pane " id="progress-t-tab9">
                                    <div class="row py-4">
                                        <div class="form-group col-md-6">
                                            <button type="button" class="btn btn-primary pull-right"
                                                onclick="AddMore('asset','formasset')">Add More
                                                <span class=""></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="form-group col-md-4">
                                            <label for="name">Asset Name</label>
                                            <input type="text" class="form-control" name="asset_name[]" id="asset_name"
                                                placeholder="Enter AssetNAme">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Model Number</label>
                                            <input type="text" class="form-control" name="model_number[]"
                                                id="model_number" placeholder="Enter ModelNumber">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Issue Date</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="date" class="form-control pull-right" id="issue_date"
                                                    name="issue_date[]">
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Return Date</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="date" class="form-control pull-right" id="return_date"
                                                    name="return_date[]">
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        {{csrf_field()}}


                                        <!--row-->
                                    </div>
                                </div>
                                <div class="tab-pane " id="progress-t-tab10">
                                    <div class="row py-4">
                                        <div class="form-group col-md-6">
                                            <button type="button" class="btn btn-primary pull-right"
                                                onclick="AddMore('references','formrefrences')">Add More
                                                <span class="glyphicon glyphicon-add"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">


                                        <div class="form-group col-md-4">
                                            <label for="name">firstName</label>
                                            <input type="text" class="form-control" name="reference_firstname[]"
                                                id="name" placeholder="Enter Name">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">lastName</label>
                                            <input type="text" class="form-control" name="reference_lastname[]"
                                                id="name" placeholder="Enter Name">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label> Address</label>
                                            <textarea class="form-control" name="reference_address[]" rows="3"
                                                placeholder="Enter Comments"></textarea>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Mobile Number</label>
                                            <input type="text" class="form-control" name="reference_phone_number[]"
                                                id="mobile" placeholder="Enter Mobile">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Mobile Number</label>
                                            <input type="text" class="form-control" name="reference_mobile_number[]"
                                                id="mobile" placeholder="Enter Mobile">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Email</label>
                                            <input type="text" class="form-control" name="reference_email[]" id="email"
                                                placeholder="Enter Email">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Organisation</label>
                                            <input type="text" class="form-control" name="reference_organisation[]"
                                                id="organisation" placeholder="Enter Organisation">
                                        </div>


                                        <!--row-->
                                    </div>
                                </div>
                                <div class="tab-pane " id="progress-t-tab11">
                                    <div class="row py-4">
                                        <div class="form-group col-md-6">
                                            <button type="button" class="btn btn-primary pull-right"
                                                onclick="AddMore('document','formdocument')">Add More
                                                <span class="glyphicon glyphicon-add"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">


                                        <div class="form-group col-md-4">
                                            <label for="name">firstName</label>
                                            <input type="text" class="form-control" name="reference_firstname[]"
                                                id="name" placeholder="Enter Name">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">lastName</label>
                                            <input type="text" class="form-control" name="reference_lastname[]"
                                                id="name" placeholder="Enter Name">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label> Address</label>
                                            <textarea class="form-control" name="reference_address[]" rows="3"
                                                placeholder="Enter Comments"></textarea>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Mobile Number</label>
                                            <input type="text" class="form-control" name="reference_phone_number[]"
                                                id="mobile" placeholder="Enter Mobile">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Mobile Number</label>
                                            <input type="text" class="form-control" name="reference_mobile_number[]"
                                                id="mobile" placeholder="Enter Mobile">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Email</label>
                                            <input type="text" class="form-control" name="reference_email[]" id="email"
                                                placeholder="Enter Email">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Organisation</label>
                                            <input type="text" class="form-control" name="reference_organisation[]"
                                                id="organisation" placeholder="Enter Organisation">
                                        </div>


                                        <!--row-->
                                    </div>
                                </div>
                                <div class="tab-pane " id="progress-t-tab12">
                                    <div class="row py-4">
                                        <div class="form-group col-md-6">
                                            <button type="button" class="btn btn-primary pull-right"
                                                onclick="AddMore('document','formdocument')">Add New
                                                <span class="glyphicon glyphicon-add"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">


                                        <div class="form-group col-md-6">
                                            <label for="name">Currency Type<span
                                                    class="text-danger">(required*)</span></label>
                                            <input type="text" class="form-control" name="currency_type"
                                                id="currency_type" placeholder="Enter Currency Salary">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Wages Type<span class="text-danger">(required*)</span></label>
                                            <select class="form-control" name="wages_type">
                                                <option>Select WagesType </option>
                                                <option value="daily">Daily</option>
                                                <option value="weekly">Weekly</option>
                                                <option value="native">Monthly</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Payment Mode<span class="text-danger">(required*)</span></label>
                                            <select class="form-control" name="payment_mode">
                                                <option>Select WagesType </option>
                                                <option value="cash">Cash</option>
                                                <option value="transfer">Transfer</option>
                                                <option value="cheque">Cheque</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Bank Name<span
                                                    class="text-danger">(required*)</span></label>
                                            <select class="form-control" name="bank_name">
                                                <option>Select Bank </option>
                                                @foreach($banks as $bank)
                                                <option value="{{$bank->name}}">{{$bank->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Bank Account Number<span
                                                    class="text-danger">(required*)</span></label>
                                            <input type="text" class="form-control" name="bank_acc_no" id="bank_acc_no"
                                                placeholder="Enter Bank Account Number">
                                        </div>
                                    </div>


                                    <div class="box-footer">
                                        <button class="btn btn-primary nextBtn btn-md pull-right" style="margin: 2px;"
                                            type="submit">Update</button>
                                    </div>

                                    <!--row-->
                                </div>
                            </div>
                        </form>






                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>




    <!-- /.row -->
    <div class="modal" id="step1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-md-6">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Earnings</h4>
                    </div>
                    <div class="col-md-6">
                        <h4 class="modal-title">Deduction</h4>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="col-md-6">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="name" value="name"> Name
                            </label>
                            <label>
                                <input type="checkbox" name="email" value="email"> Email
                            </label>
                            <label>
                                <input type="checkbox" name="phone" value="phone"> PhoneNumber
                            </label>
                            <label>
                                <input type="checkbox" name="address" value="address"> Address
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-prev">Prev</button>
                    <button type="button" id="btn1" class="btn btn-primary btn-next">Next</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>




</section>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#file").change(function () {
        readURL(this);
    });
    var i = 0;

    function AddMore(divName, args, elem) {
        i++;
        var newdiv = document.createElement('div');
        newdiv.setAttribute('class', 'box-body');
        newdiv.innerHTML = $('#' + args).html();
        document.getElementById(divName).append(newdiv);
    }
    $(document).ready(function () {
        $('#add').click(function () {
            AddMore('dependent', 'formdependent', this)
        })
        $('#add2').click(function () {
            AddMore('qualification', 'formqualification', this)
        })
    });

    $('#join_date').datepicker({
        autoclose: true
    });
    $('#start_date').datepicker({
        autoclose: true
    });
    $('#end_date').datepicker({
        autoclose: true
    });
    $('#issue_date').datepicker({
        autoclose: true
    });
    $('#return_date').datepicker({
        autoclose: true
    });
</script>
<script src="{{asset('calendar/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {
        var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn');
        prevBtn = $('.prevBtn');

        allWells.hide();

        navListItems.click(function (e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                $item = $(this);

            if (!$item.hasClass('disabled')) {
                navListItems.removeClass('btn-primary').addClass('btn-default');
                $item.addClass('btn-primary');
                allWells.hide();
                $target.show();
                $target.find('input:eq(0)').focus();
            }
        });

        allNextBtn.click(function () {
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next()
                .children("a"),
                curInputs = curStep.find("input[type='text'],input[type='url']"),
                isValid = true;

            $(".form-group").removeClass("has-error");
            for (var i = 0; i < curInputs.length; i++) {
                if (!curInputs[i].validity.valid) {
                    isValid = false;
                    $(curInputs[i]).closest(".form-group").addClass("has-error");
                }
            }

            if (isValid)
                nextStepWizard.removeAttr('disabled').trigger('click');
        });

        prevBtn.click(function () {
            // alert('ok');
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next()
                .children("a"),
                curInputs = curStep.find("input[type='text'],input[type='url']"),
                isValid = true;

            $(".form-group").removeClass("has-error");
            for (var i = 0; i < curInputs.length; i--) {
                if (!curInputs[i].validity.valid) {
                    isValid = false;
                    $(curInputs[i]).closest(".form-group").addClass("has-error");
                }
            }
        });
        $('div.setup-panel div a.btn-primary').trigger('click');
    });
</script>
<!-- end main content -->
@endsection