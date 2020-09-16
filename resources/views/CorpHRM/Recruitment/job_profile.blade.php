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
                    <h3>Job Profile</h3>
                </div>

                <div class="card-body">
                    <form class="row" action="{{route('corphrm.job_profile')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group col-sm-3">
                            <label for="">Job Title</label>
                            <input type="text" id="job_title" name="job_title" class="form-control" required="required">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="">Job Description</label>
                            <input type="text" id="job_description" name="job_description" class="form-control"
                                required="required">
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
                        <div class="form-group col-sm-12 text-center">
                            <button type="submit" id="add_job_profile" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>



@stop