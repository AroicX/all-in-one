@extends('CorpHRM.layout.master')

@section('content')
	<section class="content">
		<div class="row">
            @if(isset($success))
                <div class="alert alert-success">Successfully added</div>
            @endif
            <div class="col-md-12">
                <div class="card card-primary">
                	<div class="card-header with-border">
                		<h5>Training Plan</h5>
                	</div>

                	<div class="card-body">
                            <form class="row" action="{{route('corphrm.trainingplanform')}}" method="post">
                		
                                <div class="form-group col-sm-6">
                                    <label>Training Title</label>
                                    <select name="training_title" class="form-control">
                                    @foreach($train_masters as $train_master)
                                        <option value="{{$train_master->training_name}}">{{$train_master->training_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label>Select Grade</label>
                                    <select name="grade" class="form-control">
                                        @foreach($grades as $grade)
                                            <option value="{{$grade->id}}">{{$grade->name}}</option>
                                            @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label>Select Department</label>
                                    <select name="department" class="form-control">
                                        @foreach($departments as $department)
                                            <option value="{{$department->id}}">{{$department->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label>Select Facilitator</label>
                                    <select name="facilitator" class="form-control">
                                        @foreach($facilitators as $facilitator)
                                            <option value="{{$facilitator->facilitator_name}}">{{$facilitator->facilitator_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label>Select Branch</label>
                                    <select name="branch" class="form-control">
                                        @foreach($branches as $branch)
                                            <option value="{{$branch->id}}">{{$branch->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label>Select Designation</label>
                                    <select name="select_designation" class="form-control">
                                        @foreach($designations as $designation)
                                            <option value="{{$designation->id}}">{{$designation->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label>Venue & Time of training:</label>
                                    <textarea class="form-control" name="venue_time" rows="3"></textarea>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label for="facilitator_name">Training Budget:</label>
                                    <input type="text" name="training_budget" class="form-control" required="required">
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label for="facilitator_name">Training Objectives:</label>
                                    <input type="text" name="training_objective" class="form-control" required="required">
                                </div>
                                
                                <div class="form-group col-sm-12">
                                    <label>Training Type</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="training_type" id="optionsRadiosInline1" value="1" >Indoor
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="training_type" id="optionsRadiosInline2" value="0" checked>Outdoor
                                    </label>
                                </div>
                                
                                <div class="form-group col-sm-12">
                                    <label>Mode of Delivery</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="mode_of_delivery" id="optionsRadiosInline1" value="1" >Webinar
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="mode_of_delivery" id="optionsRadiosInline2" value="0" checked>Self Study
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="mode_of_delivery" id="optionsRadiosInline2" value="0" checked>Class Room
                                    </label>
                                </div>
                                
                                <div class="form-group col-sm-12">
                                    {{csrf_field()}}
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                
                            </form>
                	</div>
                </div>
            </div>
        </div>
    </section>

@stop