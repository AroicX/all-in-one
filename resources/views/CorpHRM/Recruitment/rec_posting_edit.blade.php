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
                    <h5>Recruitment Posting</h5>
                </div>

                <div class="card-body">
                    <form class="row" action="{{url('corphrm/rec_posting/edit')}}" method="post">
                        {{csrf_field()}}

                        <div class="form-group col-sm-4">
                            <label for="">Recruitment Application</label>
                            <select id="rec_application_id" name="rec_application_id" class="form-control"
                                required="required">
                                <option value="">Select Recruitment Application</option>
                                @foreach($rec_apps as $rec_app)
                                <option @if($rec_posting['rec_application_id']==$rec_app->id) selected="selected" @endif
                                    value="{{$rec_app->id}}">{{$rec_app->job_title}} ({{$rec_app->posted_date}})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="">Recruitment Process</label>
                            <select id="rec_process_id" name="rec_process_id" class="form-control" required="required">
                                <option value="">Select Recruitment Process</option>
                                @foreach($rec_processes as $rec_process)
                                <?php $k = explode(',',$rec_process->interview_processes); ?>
                                <option value="{{$rec_process->id}}" @if($rec_posting['rec_process_id']==$rec_process->
                                    id) selected="selected" @endif
                                    interview_dates="<?php echo count($k); ?>">{{$rec_process->process_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="">Job Code</label>
                            <input type="text" id="job_code" name="job_code" class="form-control"
                                value="{{$rec_posting['job_code']}}" readonly>
                        </div>
                        <!--                            <div class="form-group col-sm-12">
                                <label for="">Job Description</label>
                                <input type="text" id="job_description" name="job_description" class="form-control" required="required">
                            </div> -->
                        <div class="form-group col-sm-4">
                            <label for="">Posted Date</label>
                            <input type="date" id="posted_date" name="" value="{{$rec_posting['posted_date']}}"
                                class="form-control" required="required">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="">Start Date</label>
                            <input type="date" id="start_date" name="start_date" value="{{$rec_posting['start_date']}}"
                                class="form-control" required="required">
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="">End Date</label>
                            <input type="date" id="end_date" name="end_date" value="{{$rec_posting['end_date']}}"
                                class="form-control" required="required">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="">Location</label>
                            <input type="text" id="location" name="location" value="{{$rec_posting['location']}}"
                                class="form-control" required="required">
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="">No of Vacancies</label>
                            <input type="number" id="no_of_vacancies" value="{{$rec_posting['no_of_vacancies']}}"
                                name="no_of_vacancies" class="form-control" required="required">
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="">Years of Experience</label>
                            <input type="number" id="years_of_experience"
                                value="{{$rec_posting['years_of_experience']}}" name="years_of_experience"
                                class="form-control" required="required">
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="">Qualification details</label>
                            <textarea class="form-control" value="" id="qualification_details"
                                name="qualification_details">{{$rec_posting['qualification_details']}}</textarea>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="">Experience Details</label>
                            <textarea class="form-control" id="" value=""
                                name="experience_details">{{$rec_posting['experience_details']}}</textarea>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="">Other Details</label>
                            <textarea class="form-control" id="other_details" value=""
                                name="other_details">{{$rec_posting['other_details']}}</textarea>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="">Email ID</label>
                            <input type="text" id="email_id" name="email_id" value="{{$rec_posting['email']}}"
                                class="form-control" required="required">
                        </div>
                        <div id="text" class="form-group col-sm-12"></div>

                        <!--                             <div class="form-group col-sm-3">
                                <label for="">Application Status</label>
                                <select id="status" name="status" class="form-control" required="required">
                                    <option value="approve">Approve</option>
                                    <option value="pending">Pending</option>
                                    <option value="reject">Reject</option>
                                </select>
                            </div> -->
                        <div class="form-group col-sm-12 text-center">
                            <input type="hidden" name="id" value="{{$rec_posting['id']}}">
                            <button type="submit" class="btn btn-primary has-ripple ">Edit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@stop
@section('scripts')
<script src="{{asset('calendar/js/jquery.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#rec_process_id").change(function () {
            //Find if there is already a input card
            //if yes then remove it
            $("#text").find("input").remove();
            $("#text").find("label").remove();
            var count = $('option:selected', this).attr('interview_dates');
            //$(this).attr("interview_dates");
            //$(this).val();
            //alert(count);
            for (var i = 1; i <= count; i++) {
                var ipcardName = "myInput" + i;
                var ipcard = '&nbsp;&nbsp;<label for="">Interview Date ' + i +
                    '</label><input type="date" class="form-control" name="interview_dates[]" required="">';
                $('div#text').append(ipcard);

            }
        });
    });
</script>