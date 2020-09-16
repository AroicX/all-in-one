@extends('CorpHRM.layout.master')

@section('content')
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                @if(isset($success))
                <div class="alert alert-success">* Successfully Added</div>
                @endif
                <div class="card card-primary">
                    <div class="card-header with-border">
                        <h5>Recruitment Application</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{route('corphrm.rec_application')}}" method="post">
                        <div class="row">
                                <div class="form-group col-sm-6">
                                        <label for="">Job Title</label>
                                        <select id="job_title" name="job_title" class="form-control" required="required">
                                           @foreach($job_profiles as $job_profile)
                                               <option value="{{$job_profile->job_title}}">{{$job_profile->job_title}}</option>
                                            @endforeach
                                            </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="">Employee Name</label>
                                        <input type="text" id="employee_name" name="employee_name" value="{{  Auth::user() ? Auth::user()->name :'' }}" class="form-control" required="required" readonly="readonly">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="">Posted Date</label>
                                        <input type="date" id="posted_date" name="posted_date" class="form-control" required="required">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="">Branch</label>
                                        <select id="branch" name="branch" class="form-control" required="required">
                                            @foreach($branches as $branch)
                                                <option value="{{$branch->name}}">{{$branch->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="">Designation</label>
                                        <select id="designation" name="designation" class="form-control" required="required">
                                            @foreach($designations as $designation)
                                                <option value="{{$designation->name}}">{{$designation->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="">Department</label>
                                        <select id="department" name="department" class="form-control" required="required">
                                            @foreach($departments as $department)
                                                <option value="{{$department->name}}">{{$department->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="">Category</label>
                                        <select id="category" name="category" class="form-control" required="required">
                                            @foreach($categories as $category)
                                                <option value="{{$category->name}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="">Job Description</label>
                                        <input type="text" id="job_description" name="job_description" class="form-control" required="required">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="">Qualification details</label>
                                        <textarea class="form-control" id="qualification_details" name="qualification_details">
                                        </textarea>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="">Experience Details</label>
                                        <textarea class="form-control" id="experience_details" name="experience_details"></textarea>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="">Skill Details</label>
                                        <textarea class="form-control" id="skill_details" name="skill_details"></textarea>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="">No of Vacancies</label>
                                        <input type="number" id="no_of_vacancies" name="no_of_vacancies" class="form-control" required="required">
                                    </div>
                        </div>

                            <div class="form-group col-sm-12 text-center">
                                {{csrf_field()}}
                                <button type="submit" id="add_job_profile" class="btn btn-primary has-ripple btn-block">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop