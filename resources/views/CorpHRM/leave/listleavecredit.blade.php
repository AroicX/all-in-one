@extends('CorpHRM.layout.master')

@section('content')
	<section class="content">
		<div class="row">

            <div class="col-md-12">
                @if(isset($success))
                <div class="alert alert-success">* Successfully Added</div>
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
                <div class="card card-primary">
                	<div class="card-header with-border">
                		<h5>Leave Credits</h5>
                        <a href="{{url('corphrm/leavecredit/new')}}">
                            <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                        </a>
                	</div>

                        <div class="card-body table-responsive no-padding">
                            <table class="table table-hover">

                                <tr>
                                    <th>ID</th>
                                    <th>Effective Date</th>
                                    <th>Transaction Date</th>
                                    <th>Employee.</th>
                                    <th>Leave Type</th>
                                    <th>Action</th>
                                </tr>
                                <?php $sn = 0; ?>
                                @foreach ($LeaveCredits as $LeaveCredit)
                                <?php $sn += 1;?>
                                <tr>
                                    <td>{{$sn}}</td>
                                    <td>{{ $LeaveCredit['effective_date'] }}</td>
                                    <td>{{ $LeaveCredit['transaction_date'] }}</td>
                                    <td>{{ $LeaveCredit['employee'] }}</td>
                                    <td> {{ $LeaveCredit['leave_type'] }} </td>
                                    <td>
                                                                <a href="{{url('corphrm/leavecredit/edit')}}/{{ $LeaveCredit['id'] }}">
                                        <button class="btn btn-primary btn-sm" >Edit</button>
                                    </a>
                                    <a href="{{url('corphrm/delete/leavecredit')}}/{{ $LeaveCredit['id'] }}">
                                        <button class="btn btn-danger btn-sm" >Delete</button>
                                    </a>
                                    </td>

                                </tr>
                                @endforeach
                            </table>
                            @if(!$LeaveCredits)
                            <td><p style="text-align:center;" >No Leave Credit.
                                </p></td>

                            @endif
                        </div>
                </div>
            </div>
        </div>
    </section>


@stop
