@extends('CorpHRM.layout.master')
@section('content')
<section class="content">
        <div class="col-md-12">
                @if(isset($success))
                <div class="alert alert-success">* Successfully Added</div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
            </div>
            <div class="col-sm-12">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
            </div>
    <div class="row">


        <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                            <h5 style="float:left;">Interview Process</h5>
                            <div style="float:right; margin-top:16px;">
                                <a href="{{url('corphrm/interview_process')}}">
                                    <button class="btn btn-primary">Return back</button>
                                </a>
                            </div>
                    </div>
                    <div class="card-body">
                            <form class="row" action="{{url('corphrm/interview_process/edit')}}" method="post">
                                <div class="form-group col-sm-4">
                                    <label for="">Process Name</label>
                                    <input type="text" id="process_name" value="{{$InterviewProcess['process_name']}}"
                                        name="process_name" class="form-control" required="required">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">Recruitment Posting</label>
                                    <select id="rec_posting" name="rec_posting" class="form-control" required="required">
                                        <option value=""></option>
                                        @foreach($rec_postings as $rec_posting)
                                        <option @if($InterviewProcess['rec_posting']==$rec_posting['id']) selected="selected" @endif
                                            value="{{$rec_posting['id']}}">{{$rec_posting['job_title']}}
                                            ({{$rec_posting['start_date']}} - {{$rec_posting['end_date']}})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">Recruitment Dates</label>
                                    <select id="rec_date" name="rec_date" class="form-control" required="required">
                                        <option value=''>Select Recruitment Date</option>
                                    </select>
                                </div>
                    
                                <div class="form-group col-sm-6">
                                    <label for="">From Time</label>
                                    <input type="time" id="from_time" value="{{$InterviewProcess['from_time']}}" name="from_time"
                                        class="form-control" required="required">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="">To Time</label>
                                    <input type="time" id="to_time" value="{{$InterviewProcess['to_time']}}" name="to_time"
                                        class="form-control" required="required">
                                </div>
                                <div class="input_fields_wrap">
                                    <div class="form-group col-sm-12">
                                        <button class="add_field_button btn btn-primary btn-sm pull-right" style="border-radius: 0px;">Add
                                            Interviewer</button>
                                       
                                        <select class="form-control" data-live-search="true" id="interview_one"
                                            name="interviewers[]" required="">
                                            @foreach($employees as $employee)
                                            <option value="{{$employee->id}}">
                                                {{$employee->surname.' '.$employee->firstname.' '.$employee->middlename}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                    
                                <div class="form-group col-sm-3">
                                    <label for="">Sorting No</label>
                                    <input type="text" id="sorting_no" value="{{$InterviewProcess['sorting_no']}}" name="sorting_no"
                                        class="form-control" required="required" readonly="">
                                </div>
                    
                                <div class="form-group col-sm-12 text-center">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="{{$InterviewProcess['id']}}">
                                    <button type="submit" class="btn btn-primary has-ripple">Submit</button>
                                </div>
                            </form>
                            
                    </div>
                </div>
            </div>

        
    </div>
    </div>
</section>
<script src="{{asset('calendar/js/jquery.min.js')}}"></script>

<script>
    $(document).ready(function () {
        var max_fields = 10; //maximum input cardes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_button"); //Add button ID

        var x = 1; //initlal text card count
        $(add_button).click(function (e) { //on add input button click
            e.preventDefault();
            if (x < max_fields) { //max input card allowed
                x++; //text card increment
                $(wrapper).append(
                    '<br><div class="col-md-12"><select class="form-control" name="interviewers[]"  required="" >@foreach($employees as $employee)<option value="{{$employee->id}}">{{$employee->surname.'
                    '.$employee->firstname.'
                    '.$employee->middlename}}</option>@endforeach</select><a href="#" class="remove_field">Remove</a></div>'
                    ); //add input card
            }
        });

        $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    });

    $(document).ready(function () {
        $("#rec_posting").change(function () {
            $('[name="sorting_no"]').val("");
            var select = document.getElementById("rec_date");
            document.getElementById("rec_date").options.length = 0;
            var rec_posting = $('option:selected', this).val();
            $.ajax({
                type: "GET",
                url: "{{url('corphrm/interview_process/details')}}/" + rec_posting,
                //dataType: "html",   //expect html to be returned                
                success: function (response) {
                    $('[name="sorting_no"]').val(response.sorting_no);
                    var obj = response.rec_dates;
                    var areaOption = "<option value=''>Select Recruitment Date</option>";
                    for (var i = 0; i < obj.length; i++) {
                        areaOption += '<option value="' + obj[i] + '">' + obj[i] +
                            '</option>'
                    }
                    $("#rec_date").html(areaOption);
                }

            });
        });

        $('select').selectpicker();
    });
</script>
@stop
@section('scripts')

@endsection