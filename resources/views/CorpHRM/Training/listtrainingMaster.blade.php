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
                		<h5>Trainings Master</h5>
                        <a href="{{url('corphrm/trainingmaster/new')}}">
                            <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                        </a>
                	</div>

                        <div class="card-body table-responsive no-padding">
                            <table class="table table-hover table-bordered">

                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                                <?php $sn = 0; ?>
                                @foreach ($trainingmasters as $trainingmaster)
                                <?php $sn += 1;?>
                                <tr>
                                    <td>{{$sn}}</td>
                                    <td>{{ $trainingmaster->training_name }}</td>
                                    <td>{{ $trainingmaster->description }}</td>
                                    <td>
                                    <a href="">
                                    <button class="btn btn-sm btn-success">Edit</button>
                                    </a>
                                     <a onclick="return confirm('Are you sure you want to delete this training master');" href="">
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                    </a>                                   
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            @if(count($trainingmasters) == "0")
                            <td><p style="text-align:center;" >No Training Master Yet.
                                </p></td>

                            @endif
                        </div>
                </div>
            </div>
        </div>
    </section>

@stop