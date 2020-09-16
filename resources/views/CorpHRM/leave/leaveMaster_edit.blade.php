@extends('CorpHRM.layout.master')

@section('content')
<section class="content">
    <div class="row">

        <div class="col-md-12">
            @if(isset($success))
            <div class="alert alert-success">Successfully added</div>
            @endif
            @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}.
            </div>
            @elseif(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}.
            </div>
            @endif
            <div class="card card-primary">
                <div class="card-header with-border">
                    <h5>Leave Master </h5>
                        <a href="{{url('corphrm/leavemaster')}}">
                            <button class="btn btn-primary btn-sm" style="float:right;">Return Back</button>
                        </a>

                </div>

                <div class="card-body">
                    <form class="row" action="{{route('corphrm.editleavemasterform')}}" method="post">
                        <div class="form-group col-sm-6">
                            <label for="name">Leave Name</label>
                            <input type="text" name="name" value="{{$leavemaster['name']}}" class="form-control"
                                required="required">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="code">Leave Code</label>
                            <input type="text" name="code" value="{{$leavemaster['code']}}" class="form-control"
                                required="required">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="max_days">Maximum Days</label>
                            <input type="text" name="max_days" value="{{$leavemaster['max_days']}}" class="form-control"
                                required="required">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="">Grade</label>
                            <select class="form-control" name="grade_id" required="required">
                                @foreach($grades as $grade)
                                <option @if($leavemaster['grade_id']==$grade->id) selected="selected" @endif
                                    value="{{ $grade->id }}">{{ $grade->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group col-sm-6">
                            <label>Paid Leave</label>
                            <label class="radio-inline">
                                <input type="radio" name="paid_leave" id="optionsRadiosInline1" value="1">Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="paid_leave" id="optionsRadiosInline2" value="0" checked>No
                            </label>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Encashable</label>
                            <label class="radio-inline">
                                <input type="radio" name="encashable" id="optionsRadiosInline1" value="1">Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="encashable" id="optionsRadiosInline2" value="0" checked>No
                            </label>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="carry_forward">Carry Forward</label>
                            <input type="text" value="{{$leavemaster['carry_forward']}}" name="carry_forward"
                                class="form-control" required="required">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="notice_period">Notice Period</label>
                            <input type="text" value="{{$leavemaster['notice_period']}}" name="notice_period"
                                class="form-control" required="required">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="no_of_days_after_joining">Number of days after joining</label>
                            <input type="text" value="{{$leavemaster['no_of_days_after_joining']}}"
                                name="no_of_days_after_joining" class="form-control" required="required">
                        </div>

                        <div class="form-group col-sm-12">
                            {{csrf_field()}}
                            <input type="hidden" value="{{$leavemaster['id']}}" name="id">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@stop