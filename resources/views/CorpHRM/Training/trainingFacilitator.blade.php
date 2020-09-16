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
                		<h5>Training Facilitator</h5>
                	</div>

                	<div class="card-body">
                            <form class="row" action="{{route('corphrm.trainingfacilitatorform')}}" method="post">
                		
                                <div class="form-group col-sm-6">
                                    <label>Training Name</label>
                                    <select name="training_name" class="form-control">
                                        @foreach($details as $detail)
                                        <option value="{{$detail->training_name}}">{{$detail->training_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label for="facilitator_name">Facilitator Name:</label>
                                    <input type="text" name="facilitator_name" class="form-control" required="required">
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label for="contact_person_name">Contact Person Name:</label>
                                    <input type="text" name="contact_person_name" class="form-control" required="required">
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label for="mobile_no">Mobile Number:</label>
                                    <input type="text" name="mobile_no" class="form-control" required="required">
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label>Address:</label>
                                    <textarea class="form-control" name="address" rows="3"></textarea>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label for="email">Email:</label>
                                    <input type="email" name="email" class="form-control" required="required">
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