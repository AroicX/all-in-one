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
                    <div class="col-md-6">
                        <h5>Recruitment Posting</h5>
                    </div>
                    <div style="float:right; margin-top:25px;" class="col-md-6">
                        @if($rec_applications['status'] == "Pending")
                            <a href="{{url('/corphrm/rec_application/approve')}}/{{$rec_applications['id']}}">
                            <button class="btn btn-block btn-info btn-sm" >Approve</button>
                            </a>
                        @endif
                        @if($rec_applications['status'] == "Approved")
                            <p style="color: green; font-weight: 600;">APPROVED</p>
                        @endif
                        @if($rec_applications['status'] == "Cancelled")
                            <p style="color: green; font-weight: 600;">Cancelled</p>
                        @endif
                    </div>
                    </div>

                    <div class="card-body no-padding" id="BlockUI">
                        <div class="row" style="background:#FFFFFF; margin-top: 20px; margin-bottom: 40px;">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <label>Job Title</label>
                                <p>{{$rec_applications['job_title']}}</p>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <label>Employee Name</label>
                                <p>{{$rec_applications['employee_name']}}</p>  
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <label>Posted Date</label>
                                <p>{{$rec_applications['posted_date']}}</p>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <label>Branch</label>
                                <p>{{$rec_applications['branch']}}</p>  
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <label>Designation</label>
                                <p>{{$rec_applications['designation']}}</p>  
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <label>Department</label>
                                <p>{{$rec_applications['department']}}</p>  
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <label>Category</label>
                                <p>{{$rec_applications['category']}}</p>  
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <label>Job Description</label>
                                <p>{{$rec_applications['job_description']}}</p>  
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <label>Qualification Details</label>
                                <p>{{$rec_applications['qualification_details']}}</p>  
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <label>Experience Details</label>
                                <p>{{$rec_applications['experience_details']}}</p>  
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <label>Skill Details</label>
                                <p>{{$rec_applications['skill_details']}}</p>  
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <label>No of Vacancies</label>
                                <p>{{$rec_applications['no_of_vacancies']}}</p>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @stop