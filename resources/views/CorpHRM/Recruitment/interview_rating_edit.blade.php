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
                    <h5>Interview Rating </h5>
                    <a href="{{url('corphrm/interview_rating')}}">
                        <button class="btn btn-primary btn-sm" style="float:right;">Return Back</button>
                    </a>

                </div>

                <div class="card-body">
                    <form action="{{url('corphrm/interview_rating/edit')}}" method="post">

                        <div class="form-group ">
                            <label for="">Interview Process</label>
                            <select class="form-control" required="" name="process_name">
                                @foreach($interview_processes as $interview_process)
                                <option @if($interview_rating['process_name']==$interview_process->id)
                                    selected="selected" @endif
                                    value="{{$interview_process->id}}">{{$interview_process->process_name}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group ">
                            <label for="">Minimum Rate</label>
                            <input type="text" id="minimum_rate" value="{{$interview_rating['minimum_rate']}}"
                                name="minimum_rate" class="form-control" required="required">
                        </div>
                        <div class="form-group ">
                            <label for="">Maximum Rate</label>
                            <input type="text" id="maximum_rate" value="{{$interview_rating['maximum_rate']}}"
                                name="maximum_rate" class="form-control" required="required">
                        </div>
                        <div class="form-group text-center">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$interview_rating['id']}}">
                            <button type="submit" class="btn btn-primary has-ripple btn-block">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@stop