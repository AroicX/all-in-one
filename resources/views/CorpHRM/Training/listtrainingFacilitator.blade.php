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
                		<h5>Trainings Facilitator</h5>
                        <a href="{{url('corphrm/trainingfacilitator/new')}}">
                            <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                        </a>
                	</div>

                        <div class="card-body table-responsive no-padding">
                            <table class="table table-hover table-bordered">

                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Facilitator Name</th>
                                    <th>Contact Person</th>
                                    <th>Mobile No</th>
                                    <th>Facilitator Email</th>
                                    <th>Action</th>
                                </tr>
                                <?php $sn = 0; ?>
                                @foreach ($TrainingFacilitators as $TrainingFacilitator)
                                <?php $sn += 1;?>
                                <tr>
                                    <td>{{$sn}}</td>
                                    <td>{{ $TrainingFacilitator->training_name }}</td>
                                    <td>{{ $TrainingFacilitator->facilitator_name }}</td>
                                    <td>{{ $TrainingFacilitator->contact_person_name }}</td>
                                    <td>{{ $TrainingFacilitator->mobile_no }}</td>
                                    <td>{{ $TrainingFacilitator->facilitator_email }}</td>
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
                            @if(count($TrainingFacilitators) == "0")
                            <td><p style="text-align:center;" >No Training Facilitator Yet.
                                </p></td>

                            @endif
                        </div>
                </div>
            </div>
        </div>
    </section>

@stop