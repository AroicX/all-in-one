@extends('CorpHRM.layout.master')

@section('content')
	<section class="content">
		<div class="row">
            @if(isset($success))
                <div class="alert alert-success">Successfully added</div>
            @endif
                            @if(session('error'))
                        <div class = "alert alert-error">
                            {{ session('error') }}.
                        </div>
                    @elseif(session('success'))
                        <div class = "alert alert-success">
                            {{ session('success') }}.
                        </div>
                    @endif

            <div class="col-md-12">

                <div class="card card-primary">
                	<div class="card-header with-border">
                		<h5>Leave Application   </h5>
                                                            <a href="{{url('corphrm/leaveapp')}}">
                        <button class="btn btn-primary btn-sm" style="float:right;">Return Back</button>
                        </a>
                     
                	</div>

                	<div class="card-body">
                            <form class="row" action="{{route('corphrm.editleaveappform')}}" method="post">
                		<div class="form-group col-sm-6">
                                    <label for="transaction_id">Transaction Id:</label>
                                    <input type="text" name="transaction_id" value="{{ $leaveapp['transaction_id'] }}" class="form-control" required="required" readonly="">
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label for="phone">Contact Number:</label>
                                    <input type="text" name="phone" value="{{ $leaveapp['phone'] }}" class="form-control" required="required">
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label for="start_date">Start Date:</label>
                                    <input type="date" name="start_date" {{ $leaveapp['start_date'] }} class="form-control start_date key" id="start_date" required="required">
                                </div>
                                 <div class="form-group col-sm-6">
                                    <label for="end_date">End Date:</label>
                                    <input type="date" name="end_date" value="{{ $leaveapp['end_date'] }}" class="form-control end_date key" id="end_date" required="required">
                                </div>                                
                                <div class="form-group col-sm-6 hidden">
                                    <label for="no_of_installments">No of installments:</label>
                                    <input type="number" value="0" name="no_of_installments" class="form-control no_of_installments key" id="no_of_installments" required="required">
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label for="no_of_days">No. of days:</label>
                                    <input type="number" value="{{ $leaveapp['no_of_days'] }}" name="no_of_days" class="form-control no_of_days" id="no_of_days" required="">
                                </div>

                                <div class="form-group col-sm-6">
                                    <label>Responsibilities handed over to</label>
                                    <select name="responsibilities_employee_id" id="responsibilities_employee_id" class="form-control" required="">
                                        <option>Select one</option>
                                        @foreach($users as $profile)
                                            <option @if($leaveapp['responsibilities_employee_id'] == $profile->id) @endif value="{{ $profile->id }}">{{ $profile->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label>Reasons:</label>
                                    <textarea name="reason" class="form-control" rows="3" required="">{{ $leaveapp['reason'] }}</textarea>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label>Do you want to take your Leave Allowance</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="take_leave" id="optionsRadiosInline1" value="1" >Yes
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="take_leave" id="optionsRadiosInline2" value="0" checked>No
                                    </label>
                                </div>
                                
                                <div class="form-group col-sm-12">
                                    {{csrf_field()}}
                                    <input type="hidden" value="{{$leaveapp['id']}}" name="id">
                                    <input type="hidden" name="leave_master_id" value="{{ $leavemaster['id'] }}" required="">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                
                            </form>
                	</div>
                </div>
            </div>
        </div>
    </section>

@stop

