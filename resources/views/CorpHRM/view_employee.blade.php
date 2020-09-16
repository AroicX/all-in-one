@extends('CorpHRM.layout.master')

@section('content')

<style>
	iframe {
		width: 100%;
		height: 600px;
		border-color: #FFFFFF;
		border: 0px !important;
	}
</style>
<section class="content">
	<div class="row py-5">

		<div class="col-lg-12">
			<h5 class="mb-3 mt-4">Empolyee</h5>
			<div class="bt-wizard" id="verticalwizard">
				<div class="row align-items-stratched mb-4">
					<div class="col-12 col-md-auto col-sm-12">
						<div class="card h-100 mb-0">
							<div class="card-body">
								<ul class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
									<li class="nav-item"><a href="#v-tabs-t-tab1" class="nav-link active"
											data-toggle="tab">Profile</a></li>
									<li class="nav-item"><a href="#v-tabs-t-tab2" class="nav-link has-ripple"
											data-toggle="tab">Personal<span class="ripple ripple-animate"
												style="height: 84.9531px; width: 84.9531px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(70, 128, 255); opacity: 0.4; top: -28.4688px; left: -13.625px;"></span></a>
									</li>
									<li class="nav-item"><a href="#v-tabs-t-tab3" class="nav-link has-ripple "
											data-toggle="tab">Dependent<span class="ripple ripple-animate"
												style="height: 84.9531px; width: 84.9531px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(70, 128, 255); opacity: 0.4; top: -42.4688px; left: 10.375px;"></span></a>
									</li>
									<li class="nav-item"><a href="#v-tabs-t-tab4" class="nav-link has-ripple "
											data-toggle="tab">Emergency<span class="ripple ripple-animate"
												style="height: 84.9531px; width: 84.9531px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(70, 128, 255); opacity: 0.4; top: -42.4688px; left: 10.375px;"></span></a>
									</li>
									<li class="nav-item"><a href="#v-tabs-t-tab5" class="nav-link has-ripple "
											data-toggle="tab">Language<span class="ripple ripple-animate"
												style="height: 84.9531px; width: 84.9531px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(70, 128, 255); opacity: 0.4; top: -42.4688px; left: 10.375px;"></span></a>
									</li>
									<li class="nav-item"><a href="#v-tabs-t-tab6" class="nav-link has-ripple "
											data-toggle="tab">Assets<span class="ripple ripple-animate"
												style="height: 84.9531px; width: 84.9531px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(70, 128, 255); opacity: 0.4; top: -42.4688px; left: 10.375px;"></span></a>
									</li>
									<li class="nav-item"><a href="#v-tabs-t-tab7" class="nav-link has-ripple "
											data-toggle="tab">References<span class="ripple ripple-animate"
												style="height: 84.9531px; width: 84.9531px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(70, 128, 255); opacity: 0.4; top: -42.4688px; left: 10.375px;"></span></a>
									</li>
									<li class="nav-item"><a href="#v-tabs-t-tab8" class="nav-link has-ripple "
											data-toggle="tab">Documents<span class="ripple ripple-animate"
												style="height: 84.9531px; width: 84.9531px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(70, 128, 255); opacity: 0.4; top: -42.4688px; left: 10.375px;"></span></a>
									</li>
									<li class="nav-item"><a href="#v-tabs-t-tab9" class="nav-link has-ripple "
											data-toggle="tab">Salary<span class="ripple ripple-animate"
												style="height: 84.9531px; width: 84.9531px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(70, 128, 255); opacity: 0.4; top: -42.4688px; left: 10.375px;"></span></a>
									</li>
									{{-- <li class="nav-item"><a href="#v-tabs-t-tab10" class="nav-link has-ripple "
											data-toggle="tab">History<span class="ripple ripple-animate"
												style="height: 84.9531px; width: 84.9531px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(70, 128, 255); opacity: 0.4; top: -42.4688px; left: 10.375px;"></span></a>
									</li> --}}

								</ul>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="tab-content card mb-0" id="v-pills-tabContent">

							<div class="tab-pane card-body active" id="v-tabs-t-tab1">

								<form method="post" action="{{ url('corphrm/update_employee') }}/profile">
									<input type="hidden" name="id" value="{{ $profile['id'] }}">
									<div class="row">

										<div class="form-group col-md-6">
											<label for="name">Title</label>
											<input type="text" class="form-control" name="title"
												value="{{ $profile['title'] }}" id="title" placeholder="Enter Title">
										</div>
										<div class="form-group col-md-6">
											<label for="name">Surname</label>
											<input type="text" class="form-control" name="surname"
												value="{{ $profile['surname'] }}" id="surname"
												placeholder="Enter Surname">
										</div>

										<div class="form-group col-md-6">
											<label for="name">MiddleName</label>
											<input type="text" class="form-control" name="middlename"
												value="{{ $profile['middlename'] }}" id="middlename"
												placeholder="Enter Middlename">
										</div>

										<div class="form-group col-md-6">
											<label for="name">FirstName</label>
											<input type="text" class="form-control" name="firstname"
												value="{{ $profile['firstname'] }}" id="firstname"
												placeholder="Enter Firstname">
										</div>

										<div class="form-group col-md-6">
											<label for="name">Employee Code</label>
											<input type="text" readonly class="form-control" name="employee_code"
												value="{{ $profile['employee_code'] }}" id="employee_code"
												placeholder="Enter EmployeeCode">
										</div>

										<div class="form-group col-md-6">
											<label>Designation</label>
											<select class="form-control" name="designation">
												<option>Select Designation</option>
												@foreach($designations as $designation)
												<option
													selected="@if($profile['designation'] == $designation->id)selected @endif"
													value="{{$designation->name}}">{{$designation->name}}
												</option>
												@endforeach
											</select>
										</div>
										<div class="form-group col-md-6">
											<label>Catergory</label>
											<select class="form-control" name="category">
												<option>-Select-</option>
												@foreach($categories as $category)
												<option
													selected="@if($profile['category'] == $category->id)selected @endif"
													value="{{$category->name}}">{{$category->name}}</option>
												@endforeach
											</select>
										</div>
										<div class="form-group col-md-6">
											<label>Grade</label>
											<select class="form-control" name="grade">
												<option>Select a Grade</option>
												@foreach($grades as $grade)
												<option selected="@if($profile['grade'] == $grade->id)selected @endif"
													value="{{$grade->name}}">{{$grade->name}}</option>
												@endforeach
											</select>
										</div>
										<div class="form-group col-md-6">
											<label>Department</label>
											<select class="form-control" name="department">
												<option>Select a Department</option>
												@foreach($departments as $department)
												<option
													selected="@if($profile['department'] == $department->id)selected @endif"
													value="{{$department->name}}">{{$department->name}}</option>
												@endforeach
											</select>
										</div>
										<div class="form-group col-md-6">
											<label>Branch</label>
											<select class="form-control" name="branch">
												<option>Select a Branch</option>
												@foreach($branches as $branch)
												<option selected="@if($profile['branch'] == $branch->id)selected @endif"
													value="{{$branch->name}}">{{$branch->name}}</option>
												@endforeach
											</select>
										</div>
										<div class="form-group col-md-6">
											<label>Joining Date</label>
											<div class="input-group date">
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div>
												<input type="text" value="{{ $profile['join_date'] }}"
													class="form-control pull-right" id="join_date" name="join_date">
											</div>
											<!-- /.input group -->
										</div>

										<div class="form-group col-md-3">
											<label for="file">Choose a Picture</label>
											<input type="file" class="form-control" name="file" id="file">
										</div>
										<div class="col-md-3">
											<img src="{{asset('img/user-avatar-inverse.jpg')}}" id="image"
												class="img-thumbnail">
										</div>


									</div>

									<div class="box-footer">
											<button class="btn btn-primary nextBtn btn-md pull-right"
												style="margin: 2px;" type="submit">Update</button>
										</div>

								</form>
							</div>
							<div class="tab-pane card-body" id="v-tabs-t-tab2">
								<form method="post" action="{{ url('corphrm/update_employee') }}/personal">
									<input type="hidden" name="id" value="{{ $employee['id'] }}">
									<div class="row">

										<div class="form-group col-md-4">
											<label>Religion</label>
											<select class="form-control" name="religion">
												<option>Select a Religion</option>
												<option selected="@if($employee['religion'] == " C")selected @endif"
													value="C">Christianity</option>
												<option selected="@if($employee['religion'] == " I")selected @endif"
													value="I">Islam</option>
												<option selected="@if($employee['religion'] == " O")selected @endif"
													value="O">Others</option>
											</select>
										</div>

										<div class="form-group col-md-4">
											<label>SBIRS</label>
											<select class="form-control" name="sbirs">
												<option>-Select-</option>
												@foreach($revenues as $revenue)
												<option
													selected="@if($employee['sbirs'] == $revenue->name)selected @endif"
													value="{{$revenue->name}}">{{$revenue->name}}</option>
												@endforeach
											</select>
										</div>

										<div class="form-group col-md-4">
											<label for="telephone_no">Telephone Number</label>
											<input type="text" class="form-control"
												value="{{ $employee['telephone_no'] }}" name="telephone_number"
												id="telephone_number" placeholder="Enter Telephone Number">
										</div>
										<div class="form-group col-md-4">
											<label for="mobile_no">Mobile Number</label>
											<input type="text" class="form-control" value="{{ $employee['mobile_no'] }}"
												name="mobile_number" id="mobile_number"
												placeholder="Enter Mobile Number">
										</div>
										<div class="form-group col-md-4">
											<label for="personal_email_address">Personal Email Address</label>
											<input type="text" class="form-control"
												value="{{ $employee['personal_email_address'] }}"
												name="personal_email_address" id="personal_email_address"
												placeholder="Enter Personal Email Address">
										</div>
										<div class="form-group col-md-4">
											<label for="official_email_address">Official Email Address</label>
											<input type="text" class="form-control"
												value="{{ $employee['official_email_address'] }}"
												name="official_email_address" id="official_email_address"
												placeholder="Enter Official Email Address">
										</div>
										<div class="form-group col-md-4">
											<label for="national_id_no">National ID Number</label>
											<input type="text" class="form-control"
												value="{{ $employee['national_id_no'] }}" name="national_id_no"
												id="national_id_no" placeholder="Enter National ID Number">
										</div>
										<div class="form-group col-md-4">
											<label for="driver_license_no">Driver License Number</label>
											<input type="text" class="form-control"
												value="{{ $employee['driver_license_no'] }}" name="driver_license_no"
												id="driver_license_no" placeholder="Enter Driver License Number">
										</div>

										<div class="form-group col-md-4">
											<label for="state_of_origin">State Of Origin</label>
											<select class="form-control" name="state_of_origin" id="state_of_origin">
												<option>- Select -</option>
												<option selected="@if($employee['state_of_origin'] == " Abuja
													FCT")selected @endif" value="Abuja FCT">Abuja FCT</option>
												<option selected="@if($employee['state_of_origin'] == " Abia")selected
													@endif" value="Abia">Abia</option>
												<option selected="@if($employee['state_of_origin'] == "
													Adamawa")selected @endif" value="Adamawa">Adamawa</option>
												<option selected="@if($employee['state_of_origin'] == " Akwa
													Ibom")selected @endif" value="Akwa Ibom">Akwa Ibom</option>
												<option selected="@if($employee['state_of_origin'] == "
													Anambra")selected @endif" value="Anambra">Anambra</option>
												<option selected="@if($employee['state_of_origin'] == " Bauchi")selected
													@endif" value="Bauchi">Bauchi</option>
												<option selected="@if($employee['state_of_origin'] == "
													Bayelsa")selected @endif" value="Bayelsa">Bayelsa</option>
												<option selected="@if($employee['state_of_origin'] == " Benue")selected
													@endif" value="Benue">Benue</option>
												<option selected="@if($employee['state_of_origin'] == " Borno")selected
													@endif" value="Borno">Borno</option>
												<option selected="@if($employee['state_of_origin'] == " Cross
													River")selected @endif" value="Cross River">Cross River</option>
												<option selected="@if($employee['state_of_origin'] == " Delta")selected
													@endif" value="Delta">Delta</option>
												<option selected="@if($employee['state_of_origin'] == " Ebonyi")selected
													@endif" value="Ebonyi">Ebonyi</option>
												<option selected="@if($employee['state_of_origin'] == " Edo")selected
													@endif" value="Edo">Edo</option>
												<option selected="@if($employee['state_of_origin'] == " Ekiti")selected
													@endif" value="Ekiti">Ekiti</option>
												<option selected="@if($employee['state_of_origin'] == " Enugu")selected
													@endif" value="Enugu">Enugu</option>
												<option selected="@if($employee['state_of_origin'] == " Gombe")selected
													@endif" value="Gombe">Gombe</option>
												<option selected="@if($employee['state_of_origin'] == " Imo")selected
													@endif" value="Imo">Imo</option>
												<option selected="@if($employee['state_of_origin'] == " Jigawa")selected
													@endif" value="Jigawa">Jigawa</option>
												<option selected="@if($employee['state_of_origin'] == " Kaduna")selected
													@endif" value="Kaduna">Kaduna</option>
												<option selected="@if($employee['state_of_origin'] == " Kano")selected
													@endif" value="Kano">Kano</option>
												<option selected="@if($employee['state_of_origin'] == "
													Katsina")selected @endif" value="Katsina">Katsina</option>
												<option selected="@if($employee['state_of_origin'] == " Kebbi")selected
													@endif" value="Kebbi">Kebbi</option>
												<option selected="@if($employee['state_of_origin'] == " Kogi")selected
													@endif" value="Kogi">Kogi</option>
												<option selected="@if($employee['state_of_origin'] == " Kwara")selected
													@endif" value="Kwara">Kwara</option>
												<option selected="@if($employee['state_of_origin'] == " Lagos")selected
													@endif" value="Lagos">Lagos</option>
												<option selected="@if($employee['state_of_origin'] == "
													Nassarawa")selected @endif" value="Nassarawa">Nassarawa</option>
												<option selected="@if($employee['state_of_origin'] == " Niger")selected
													@endif" value="Niger">Niger</option>
												<option selected="@if($employee['state_of_origin'] == " Ogun")selected
													@endif" value="Ogun">Ogun</option>
												<option selected="@if($employee['state_of_origin'] == " Ondo")selected
													@endif" value="Ondo">Ondo</option>
												<option selected="@if($employee['state_of_origin'] == " Osun")selected
													@endif" value="Osun">Osun</option>
												<option selected="@if($employee['state_of_origin'] == " Oyo")selected
													@endif" value="Oyo">Oyo</option>
												<option selected="@if($employee['state_of_origin'] == "
													Plateau")selected @endif" value="Plateau">Plateau</option>
												<option selected="@if($employee['state_of_origin'] == " Rivers")selected
													@endif" value="Rivers">Rivers</option>
												<option selected="@if($employee['state_of_origin'] == " Sokoto")selected
													@endif" value="Sokoto">Sokoto</option>
												<option selected="@if($employee['state_of_origin'] == " Taraba")selected
													@endif" value="Taraba">Taraba</option>
												<option selected="@if($employee['state_of_origin'] == " Yobe")selected
													@endif" value="Yobe">Yobe</option>
												<option selected="@if($employee['state_of_origin'] == "
													Zamfara")selected @endif" value="Zamfara">Zamfara</option>
											</select>
										</div>

										<div class="form-group col-md-4">
											<label for="local_govt_area">Local Government Area</label>
											<input type="text" class="form-control"
												value="{{ $employee['local_govt_area'] }}" name="local_govt_area"
												id="local_govt_area" placeholder="Enter Local Government Area">
										</div>

										<div class="form-group col-md-4">
											<label>Blood Group</label>
											<select class="form-control" name="blood_group">
												<option>Select a Blood Group</option>
												<option selected="@if($employee['blood_group'] == " A")selected @endif"
													value="A">A</option>
												<option selected="@if($employee['blood_group'] == " B")selected @endif"
													value="B">B</option>
												<option selected="@if($employee['blood_group'] == " O")selected @endif"
													value="O">Others</option>
											</select>
										</div>

										<div class="form-group col-md-4">
											<label>Genotype</label>
											<select class="form-control" name="genotype">
												<option>Select a Genotype</option>
												<option selected="@if($employee['genotype'] == " AA")selected @endif"
													value="AA">AA</option>
												<option selected="@if($employee['genotype'] == " AB")selected @endif"
													value="AB">AB</option>
												<option selected="@if($employee['genotype'] == " O")selected @endif"
													value="O">O</option>
											</select>
										</div>
										<div class="form-group col-md-4">
											<label>HMo</label>
											<select class="form-control" name="hmo">
												<option>Select a HMO </option>
												@foreach($healths as $health)
												<option selected="@if($employee['hmo'] == $health->name)selected @endif"
													value="{{$health->name}}">{{$health->name}}</option>
												@endforeach
											</select>
										</div>

										<div class="form-group col-md-4">
											<label>Postal Address</label>
											<textarea class="form-control" value="{{ $employee['postal_address'] }}"
												rows="3" placeholder="Postal Address" name="postal_address"></textarea>
										</div>
										<div class="form-group col-md-4">
											<label>Residential Address</label>
											<textarea class="form-control"
												value="{{ $employee['residential_address'] }}" rows="3"
												placeholder="Enter Address" name="residential_address"></textarea>
										</div>
										<div class="form-group col-md-4">
											<label>Permanent Address</label>
											<textarea class="form-control" value="{{ $employee['permanent_address'] }}"
												rows="3" placeholder="Enter Address"
												name="permanent_address"></textarea>
										</div>
										<div class="form-group col-md-4">
											<label>Pension Fund Administrator</label>
											<select class="form-control" name="pension_fund_administrator">
												<option>Select a Pension Fund Administrator </option>
												@foreach($pfas as $pfa)
												<option
													selected="@if($employee['pension_fund_administrator'] == $pfa->name)selected @endif"
													value="{{$pfa->name}}">{{$pfa->name}}</option>
												@endforeach
											</select>
										</div>
										<div class="form-group col-md-4">
											<label>Pension Pin Number</label>
											<input type="text" class="form-control"
												value="{{ $employee['pension_pin_no'] }}" name="pension_pin_no"
												id="pension_pin_no" placeholder="Enter Pension Pin Number">
										</div>

										<div class="form-group col-md-4">
											<label>Number of Children</label>
											<input type="text" class="form-control"
												value="{{ $employee['no_of_children'] }}" name="no_of_children"
												id="no_of_children" placeholder="Enter Number of Children">
										</div>

										<div class="form-group col-md-4">
											<label>Name of Spouse</label>
											<input type="text" class="form-control"
												value="{{ $employee['name_of_spouse'] }}" name="name_of_spouse"
												id="name_of_spouse" placeholder="Enter Name of Spouse">
										</div>

										<div class="form-group col-md-4">
											<label>Gender</label>
											<select class="form-control" name="gender">
												<option>Select Gender </option>
												<option selected="@if($employee['gender'] == " male")selected @endif"
													value="male">Male</option>
												<option selected="@if($employee['gender'] == " female")selected @endif"
													value="female">Female</option>
											</select>
										</div>
										<div class="form-group col-md-4">
											<label>Date of Birth</label>
											<div class="input-group date">
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div>
												<input type="text" class="form-control pull-right"
													value="{{ $employee['date_of_birth'] }}" id="date_of_birth"
													name="date_of_birth">
											</div>
											<!-- /.input group -->
										</div>

										<div class="form-group col-md-4">
											<label>PhoneNumber of Spouse</label>
											<input type="text" class="form-control" name="phone_no_spouse"
												value="{{ $employee['phone_no_spouse'] }}" id="phone_no_spouse"
												placeholder="Enter PhoneNumber of Spouse">
										</div>


										<div class="form-group col-md-4">
											<label>Marital Status</label>
											<select class="form-control" name="marital_status">
												<option>Select Marital Status </option>
												<option selected="@if($employee['marital_status'] == " single")selected
													@endif" value="single">Single</option>
												<option selected="@if($employee['marital_status'] == " married")selected
													@endif" value="married">Married</option>
											</select>
										</div>

										<div class="form-group col-md-4">
											<label>Nationality</label>
											<input type="text" class="form-control" name="nationality"
												value="{{ $employee['nationality'] }}" id="nationality"
												placeholder="Enter Nationality">
										</div>

										<div class="form-group col-md-4">
											<label>City</label>
											<input type="text" class="form-control" name="city"
												value="{{ $employee['city'] }}" id="city" placeholder="Enter City">
										</div>

										<div class="form-group col-md-4">
											<label>Country Address</label>
											<input type="text" class="form-control" name="country_address"
												value="{{ $employee['country_address'] }}" id="country_address"
												placeholder="Country Address">
										</div>


										<div class="box-footer">
											<button class="btn btn-primary nextBtn btn-md pull-right"
												style="margin: 2px;" type="submit">Update</button>
										</div>
									</div>
								</form>
							</div>
							<div class="tab-pane card-body" id="v-tabs-t-tab3">
								<form method="post" action="{{ url('corphrm/update_employee') }}/dependent">
									<input type="hidden" name="id" value="{{ $dependent['id'] }}">
									<div class="row">

										@if($dependent['firstname'])
										@foreach(unserialize($dependent['firstname']) as $firstname)
										<div class="form-group col-md-4">
											<label for="name">FirstName</label>
											<input type="text" class="form-control" value="{{$firstname}}"
												name="dependent_firstname[]" id="dependent_firstname"
												placeholder="Enter FirstName">
										</div>
										@endforeach @endif @if($dependent['lastname'])
										@foreach(unserialize($dependent['lastname']) as $lastname)
										<div class="form-group col-md-4">
											<label for="name">LastName</label>
											<input type="text" class="form-control" value="{{$lastname}}"
												name="dependent_lastname[]" id="dependent_LastName"
												placeholder="Enter LastName">
										</div>
										@endforeach @endif @if($dependent['relationship'])
										@foreach(unserialize($dependent['relationship']) as $relationship)
										<div class="form-group col-md-4">
											<label for="name">Relationship</label>
											<input type="text" class="form-control" value="{{$relationship}}"
												name="dependent_relationship[]" id="dependent_relationship"
												placeholder="Enter Relationship">
										</div>
										@endforeach @endif @if($dependent['date_of_birth'])
										@foreach(unserialize($dependent['date_of_birth']) as
										$dependent_date_of_birth)
										<div class="form-group col-md-4">
											<label>Date of Birth</label>
											<div class="input-group date">
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div>
												<input type="text" class="form-control pull-right"
													value="{{$dependent_date_of_birth}}" id="dependent_date_of_birth"
													name="dependent_date_of_birth[]">
											</div>
											<!-- /.input group -->
										</div>
										@endforeach @endif @if($dependent['gender'])
										@foreach(unserialize($dependent['gender']) as $dependent_gender)
										<div class="form-group col-md-4">
											<label>Gender</label>
											<select class="form-control" name="dependent_gender[]">
												<option>Select Gender </option>
												<option @if($dependent_gender=="male" )selected="selected" @endif
													value="male">Male</option>
												<option @if($dependent_gender=="female" )selected="selected" @endif
													value="female">Female</option>
											</select>
										</div>
										<!--            <input type="hidden" name="_token" value="{{Session::token()}}"/> -->

										@endforeach @endif

									</div>
									<div class="box-footer">
										<button class="btn btn-primary nextBtn btn-md pull-right" style="margin: 2px;"
											type="submit">Update</button>
									</div>
								</form>
							</div>
							<div class="tab-pane card-body" id="v-tabs-t-tab4">

								<form method="post" action="{{ url('corphrm/update_employee') }}/emergency">
									<input type="hidden" name="id" value="{{ $emergency['id'] }}">
									<div class="row" style="padding-top:20px;">

										@if($emergency['firstname']) @foreach(unserialize($emergency['firstname']) as
										$firstname)
										<div class="form-group col-md-4">
											<label for="name">FirstName</label>
											<input type="text" class="form-control" value="{{$firstname}}"
												name="emergency_firstname[]" id="emergency_firstname"
												placeholder="Enter FirstName">
										</div>
										@endforeach @endif @if($emergency['lastname'])
										@foreach(unserialize($emergency['lastname']) as $lastname)
										<div class="form-group col-md-4">
											<label for="name">LastName</label>
											<input type="text" class="form-control" value="{{$lastname}}"
												name="emergency_lastname[]" id="emergency_lastname"
												placeholder="Enter LastName">
										</div>
										@endforeach @endif @if($emergency['relationship'])
										@foreach(unserialize($emergency['relationship']) as $relationship)
										<div class="form-group col-md-4">
											<label for="name">Relationship</label>
											<input type="text" class="form-control" value="{{$relationship}}"
												name="emergency_relationship[]" id="emergency_relationship"
												placeholder="Enter Relationship">
										</div>
										@endforeach @endif @if($emergency['mobile_number'])
										@foreach(unserialize($emergency['mobile_number']) as $mobile_number)
										<div class="form-group col-md-4">
											<label for="name">Mobile Number</label>
											<input type="text" class="form-control" value="{{$mobile_number}}"
												name="emergency_mobile_number[]" id="emergency_mobile_number"
												placeholder="Enter Mobile Number">
										</div>
										@endforeach @endif @if($emergency['phone_number'])
										@foreach(unserialize($emergency['phone_number']) as $phone_number)
										<div class="form-group col-md-4">
											<label for="name">Phone Number</label>
											<input type="text" class="form-control" value="{{$phone_number}}"
												name="emergency_phone_number[]" id="emergency_phone_number"
												placeholder="Enter Mobile Number">
										</div>
										@endforeach @endif
										<input type="hidden" name="_token" value="{{Session::token()}}" />

										<div class="box-footer">
											<button type="submit" class="btn btn-primary nextBtn btn-sm pull-right"
												style="margin: 2px;" type="button">Update</button>
										</div>

									</div>
								</form>

							</div>
							<div class="tab-pane card-body" id="v-tabs-t-tab5">
								<h1>Language</h1>
							</div>
							<div class="tab-pane card-body" id="v-tabs-t-tab6">
								<h1>Assets</h1>
							</div>
							<div class="tab-pane card-body" id="v-tabs-t-tab7">
								<form method="post" action="{{ url('corphrm/update_employee') }}/reference">
									<input type="hidden" name="id" value="{{ $reference['id'] }}">
									<div class="row">

										@if($reference['firstname']) @foreach(unserialize($reference['firstname']) as
										$firstname)
										<div class="form-group col-md-4">
											<label for="name">firstName</label>
											<input type="text" class="form-control" value="{{$firstname}}"
												name="reference_firstname[]" id="name" placeholder="Enter Name">
										</div>
										@endforeach @endif @if($reference['lastname'])
										@foreach(unserialize($reference['lastname']) as $lastname)
										<div class="form-group col-md-4">
											<label for="name">lastName</label>
											<input type="text" class="form-control" value="{{$lastname}}"
												name="reference_lastname[]" id="name" placeholder="Enter Name">
										</div>
										@endforeach @endif @if($reference['address'])
										@foreach(unserialize($reference['address']) as $address)
										<div class="form-group col-md-4">
											<label> Address</label>
											<textarea class="form-control" value="{{$address}}"
												name="reference_address[]" rows="3"
												placeholder="Enter Comments"></textarea>
										</div>
										@endforeach @endif @if($reference['phone_number'])
										@foreach(unserialize($reference['phone_number']) as $phone_number)
										<div class="form-group col-md-4">
											<label for="name">Mobile Number</label>
											<input type="text" class="form-control" value="{{$phone_number}}"
												name="reference_phone_number[]" id="mobile" placeholder="Enter Mobile">
										</div>
										@endforeach @endif @if($reference['mobile_number'])
										@foreach(unserialize($reference['mobile_number']) as $mobile_number)
										<div class="form-group col-md-4">
											<label for="name">Mobile Number</label>
											<input type="text" class="form-control" name="reference_mobile_number[]"
												id="mobile" placeholder="Enter Mobile">
										</div>
										@endforeach @endif @if($reference['email_address'])
										@foreach(unserialize($reference['email_address']) as $email_address)
										<div class="form-group col-md-4">
											<label for="name">Email</label>
											<input type="text" class="form-control" value="{{$email_address}}"
												name="reference_email[]" id="email" placeholder="Enter Email">
										</div>
										@endforeach @endif @if($reference['organization'])
										@foreach(unserialize($reference['organization']) as $organization)
										<div class="form-group col-md-4">
											<label for="name">Organisation</label>
											<input type="text" class="form-control" value="{{$organization}}"
												name="reference_organisation[]" id="organisation"
												placeholder="Enter Organisation">
										</div>
										@endforeach @endif

										<div class="card-footer py-2">
											<button class="btn btn-primary nextBtn btn-md pull-right"
												style="margin: 2px;" type="submit">Update</button>
										</div>
									</div>
								</form>
							</div>
							<div class="tab-pane card-body" id="v-tabs-t-tab8">
								<form method="post" action="{{ url('corphrm/update_employee') }}/document">
									<input type="hidden" name="id" value="{{ $document['id'] }}">
									<div class="row">

										@if($document['document_name'])
										@foreach(unserialize($document['document_name']) as $document_name)
										<div class="form-group col-md-4">
											<label for="name">DocumentName</label>
											<input type="text" class="form-control" value="{{$document_name}}"
												name="document_name[]" id="document_name"
												placeholder="Enter DocumentName">
										</div>
										@endforeach
										@endif

										@if($document['file'])
										@foreach(unserialize($document['file']) as $file)
										<div class="form-group col-md-4">
											<label for="file">previous uploads</label>
											<p>
												<a href="{{url('uploads/doc')}}/{{$file}}">{{$file}}</a>
											</p>
										</div>
										@endforeach
										@else
										<div class="form-group col-md-4">
											<label for="file">Choose a Picture</label>
											<input type="file" class="form-control" name="picture[]" id="file"
												placeholder="">
										</div>
										@endif

										<div class="form-group">
											<button class="btn btn-primary nextBtn btn-md pull-right"
												style="margin: 2px;" type="submit">Update</button>

										</div>
									</div>
								</form>
							</div>
							<div class="tab-pane card-body" id="v-tabs-t-tab9">
								<div class="row" style="padding-top:30px;">
									<div class="col-md-3">
										<p><b>Pension till date</b>: {{$additions['pension']}}</p>
									</div>
									<div class="col-md-3">
										<p><b>PAYEE till date</b>: {{$additions['paye']}}</p>
									</div>
									<div class="col-md-3">
										<p><b>NHF till date</b>: {{$additions['nhf']}}</p>
									</div>
									<div class="col-md-3">
										<p><b>NHIS till date</b>: {{$additions['nhis']}}</p>
									</div>
								</div>


								<div class="col-md-12" style="padding-top:10px;">

									<form method="GET"
										action="{{ url('corphrm/payroll/generate') }}/{{ Auth::user()->id }}">
										<div class="form-group">
											<center>
												<label>Generate Payslip For Previous Month</label>
											</center>
											<div class="row">
												@if($salary['wages_type'] == "daily" || $salary['wages_type'] ==
												"Daily")
												<div class="col-md-3">
													<select class="form-control col-md-6" id="payslip_day" required=""
														name="day">
														<option value="">Choose Day</option>
														@for($i=0;$i<31;$i++) <option value="$i">$i</option>
															@endfor
													</select>
												</div>
												@endif
												<div class="col-md-3">
													<select class="form-control col-md-6" id="payslip_month" required=""
														name="month">
														<option value="">Choose Month</option>
														<option value="01">January</option>
														<option value="02">Febuary</option>
														<option value="03">March</option>
														<option value="04">April</option>
														<option value="05">May</option>
														<option value="06">June</option>
														<option value="07">July</option>
														<option value="08">August</option>
														<option value="09">September</option>
														<option value="10">October</option>
														<option value="11">November</option>
														<option value="12">December</option>
													</select>
												</div>
												<div class="col-md-3">
													<select class="form-control" id="payslip_year" required=""
														name="year">
														<option value="">Choose Year</option>
														<?php for($i = 2000; $i <= date('Y'); $i++){ ?>
														<option><?php echo $i; ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="col-md-3" style="">
													<button type="submit" onclick="generate_payslip()"
														class="btn btn-primary">Generate</button>
												</div>
											</div>
									</form>
								</div>
								<div style="padding-top:15px;">
									<iframe id="payslip-frame" src="{{ url('corphrm/payroll/generate') }}/<?php echo $_GET['uid'];?>?month={{ date('m') }}&year={{ date('Y') }}&type=payslip
														<?php if($salary['wages_type'] == 'daily' || $salary['wages_type'] == 'Daily'){ ?>
														&day=<?php echo date('d'); ?><?php } ?>">
									</iframe>

								</div>
							</div>
							<div class="tab-pane card-body show" id="v-tabs-t-tab10">
									<div class="row">

											<p style="text-align:center; font-weight:600;">Employee History</p>
											{{-- Grade History --}}
											<div class="col-md-6">
												<p style="text-align:center; font-weight:600;">Grade History</p>
												<hr>
												<div class="panel panel-default">
													<div class="panel-body">
														Current: {{$grade['name']}}
													</div>
												</div>
												@foreach($employeetracklogs as $employeetracklog) @if($employeetracklog->type ==
												"Grade")
												<div class="panel panel-default">
													<div class="panel-body">
														{{$employeetracklog->previous}}
													</div>
												</div>
												@endif @endforeach
											</div>
											{{-- Branch History --}}
											<div class="col-md-6">
												<p style="text-align:center; font-weight:600;">Branch History</p>
												<hr>
												<div class="panel panel-default">
													<div class="panel-body">
														Current: {{$branch['name']}}
													</div>
												</div>
												@foreach($employeetracklogs as $employeetracklog) @if($employeetracklog->type ==
												"Branch")
												<div class="panel panel-default">
													<div class="panel-body">
														{{$employeetracklog->previous}}
													</div>
												</div>
												@endif @endforeach
											</div>
											{{-- Department History --}}
											<div class="col-md-6">
												<p style="text-align:center; font-weight:600;">Department History</p>
												<hr>
												<div class="panel panel-default">
													<div class="panel-body">
														Current: {{$department['name']}}
													</div>
												</div>
												@foreach($employeetracklogs as $employeetracklog) @if($employeetracklog->type ==
												"Department")
												<div class="panel panel-default">
													<div class="panel-body">
														{{$employeetracklog->previous}}
													</div>
												</div>
												@endif @endforeach
											</div>
											{{-- Designation History --}}
											<div class="col-md-6">
												<p style="text-align:center; font-weight:600;">Designation History</p>
												<hr>
												<div class="panel panel-default">
													<div class="panel-body">
														Current: {{$designation['name']}}
													</div>
												</div>
												@foreach($employeetracklogs as $employeetracklog) @if($employeetracklog->type ==
												"Designation")
												<div class="panel panel-default">
													<div class="panel-body">
														{{$employeetracklog->previous}}
													</div>
												</div>
												@endif @endforeach
											</div>
											{{-- Category History --}}
											<div class="col-md-6">
												<p style="text-align:center; font-weight:600;">Category History</p>
												<hr>
												<div class="panel panel-default">
													<div class="panel-body">
														Current: {{$category['name']}}
													</div>
												</div>
												@foreach($employeetracklogs as $employeetracklog) @if($employeetracklog->type ==
												"Category")
												<div class="panel panel-default">
													<div class="panel-body">
														{{$employeetracklog->previous}}
													</div>
												</div>
												@endif @endforeach
											</div>
											{{-- Salary History --}}
											<div class="col-md-6">
												<p style="text-align:center; font-weight:600;">Salary History</p>
												<hr>
												<div class="panel panel-default">
													<div class="panel-body">
														Current: {{$grade['basic_salary']}}
													</div>
												</div>
												@foreach($employeetracklogs as $employeetracklog) @if($employeetracklog->type ==
												"Salary")
												<div class="panel panel default">
													<div class="panel-body">
														{{$employeetracklog->previous}}
													</div>
												</div>
												@endif @endforeach
											</div>
		
		
										</div>
							</div>
						


						</div>




{{-- 
						<div class="row justify-content-between card-footer mx-0 btn-page">
							<div class="col-sm-6 pl-0">
								<a href="#!" class="btn btn-primary button-previous">Previous</a>
							</div>
							<div class="col-sm-6 text-md-right pr-0">
								<a href="#!" class="btn btn-primary button-next disabled">Next</a>
							</div>
						</div> --}}
					</div>
				</div>
			</div>
		</div>
	</div>

	</div>
</section>
<script>
	function generate_payslip() {
		var day = $("#payslip_day").val();
		var month = $("#payslip_month").val();
		var year = $("#payslip_year").val();
		if (month == "" || year == "" < ? php
			if ($salary['wages_type'] == 'daily' || $salary['wages_type'] == 'Daily') {
				?
				>
				||
				day == "" < ? php
			} ? > ) {
			alert(
				"select respective <?php if($salary['wages_type'] == 'daily' || $salary['wages_type'] == 'Daily'){ ?>Day and <?php } ?> Month and Year!"
			);
			return false;
		}
		var url = "{{ url('corphrm/payroll/generate') }}/<?php echo $_GET['uid']; ?>?month=" + month + "&year=" + year +
			"&type=payslip <?php if($salary['wages_type'] == 'daily' || $salary['wages_type'] == 'Daily'){ ?>&day=" + day +
			"<?php } ?>";
		document.getElementById('payslip-frame').src = url;
	}
</script>
@stop