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
                		<h5>Choose Employee</h5>
                        {{--  <a href="{{url('corphrm/trainingfacilitator/new')}}">
                            <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                        </a>  --}}
                	</div>

                        <div class="card-body table-responsive no-padding">
                            <table class="table table-hover table-bordered">

                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Employe Code</th>
                                </tr>
                                <?php $sn = 0; ?>
                                @foreach ($eligible_employees as $eligible_employee)
                                <?php $sn += 1;?>
                                <tr>
                                    <td><input type="checkcard" name="checkcard" value="{{ $eligible_employee->id }}" /> </td>
                                    <td>{{$sn}}</td>
                                    <td>{{ $eligible_employee->title }} {{ $eligible_employee->surname }} {{ $eligible_employee->firstname }}</td>
                                    <td>{{ $eligible_employee->employee_code }}</td>
                                </tr>
                                @endforeach
                            </table>
                            @if(count($eligible_employees) == "0")
                            <td><p style="text-align:center;" >No Training Facilitator Yet.
                                </p></td>

                            @endif
                        </div>
                </div>
            </div>
        </div>
    </section>

@stop