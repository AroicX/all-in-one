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
                		<h5>Trainings Plan</h5>
                        <a href="{{url('corphrm/trainingplan/new')}}">
                            <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                        </a>
                	</div>

                        <div class="card-body table-responsive no-padding">
                            <table class="table table-hover table-bordered">

                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Grade</th>
                                    <th>Department</th>
                                    <th>Facilitator</th>
                                    <th>Venue Time</th>
                                    <th>Training Budget</th>
                                    <th>Branch</th>
                                    <th>Designation</th>
                                    <th>Objectives</th>
                                    <th>Training Type</th>
                                    <th>Mode of delivery</th>
                                    <th>Action</th>
                                </tr>
                                <?php $sn = 0; ?>
                                @foreach ($TrainingPlans as $TrainingPlan)
                                <?php $sn += 1;?>
                                <tr>
                                    <td>{{$sn}}</td>
                                    <td>{{ $TrainingPlan->title }}</td>
                                    <td>{{ $TrainingPlan->grade }}</td>
                                    <td>{{ $TrainingPlan->department }}</td>
                                    <td>{{ $TrainingPlan->facilitator }}</td>
                                    <td>{{ $TrainingPlan->venue_time }}</td>
                                    <td>{{ $TrainingPlan->training_budget }}</td>
                                    <td>{{ $TrainingPlan->branch }}</td>
                                    <td>{{ $TrainingPlan->designation }}</td>
                                    <td>{{ $TrainingPlan->objectives }}</td>
                                    <td>{{ $TrainingPlan->training_type }}</td>
                                    <td>{{ $TrainingPlan->mode_of_delivery }}</td>
                                    <td>
                                    <a href="">
                                    <button class="btn btn-sm btn-success">Edit</button>
                                    </a>
                                     <a onclick="return confirm('Are you sure you want to delete this facilitator');" href="">
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                    </a>                                   
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            @if(count($TrainingPlans) == "0")
                                <td>
                                    <p style="text-align:center;" >No Training Plan Yet.</p>
                                </td>
                            @endif
                        </div>
                </div>
            </div>
        </div>
    </section>

@stop