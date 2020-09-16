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
                        <h3>Interview Process</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{route('corphrm.rec_application')}}" method="post">
                            <div class="form-group col-sm-12">
                                <label for="">Search Criteria</label>
                                <select class="form-control" id="" name="">
                                    <option value="qualification">Qualification</option>
                                    <option value="age">Age</option>
                                    <option value="experience">Experience</option>
                                    <option value="job_title">Job title</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-12 text-center">
                                {{csrf_field()}}
                                <button type="submit" class="btn btn-create">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop