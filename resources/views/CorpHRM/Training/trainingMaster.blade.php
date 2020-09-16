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
                		<h5>Training Master</h5>
                	</div>

                	<div class="card-body">
                            <form action="{{route('corphrm.trainingmasterform')}}" method="post">
                		
                                <div class="form-group ">
                                    <label for="training_name">Training Name:</label>
                                    <input type="text" name="training_name" class="form-control" required="required">
                                </div>

                                <div class="form-group ">
                                    <label>Description of training:</label>
                                    <textarea class="form-control" name="desc_of_training" rows="3"></textarea>
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