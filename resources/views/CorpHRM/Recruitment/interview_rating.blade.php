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
                        <h3>Interview Rating
                        <a href="{{url('corphrm/interview_rating')}}">
                        <button class="btn btn-primary btn-sm" style="float:right;">Return Back</button>
                        </a>
                        </h3>
                    </div>

                    <div class="card-body">
                        <form action="{{route('corphrm.interview_rating')}}" method="post">

                            <div class="form-group ">
                                <label for="">Interview Process</label>
                                <select class="form-control" required="" name="process_name">
                                    @foreach($interview_processes as $interview_process)
                                    <option value="{{$interview_process->id}}">{{$interview_process->process_name}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group ">
                                <label for="">Minimum Rate</label>
                                <input type="text" id="minimum_rate" name="minimum_rate" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label for="">Maximum Rate</label>
                                <input type="text" id="maximum_rate" name="maximum_rate" class="form-control" required="required">
                            </div>
                            <div class="form-group  text-center">
                                {{csrf_field()}}
                                <button type="submit" class="btn btn-primary has-ripple ">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop