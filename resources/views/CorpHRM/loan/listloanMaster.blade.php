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
                		<h5>Loan Master</h5>
                        <a href="{{url('corphrm/loanmaster/new')}}">
                            <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                        </a>
                	</div>

                        <div class="card-body table-responsive no-padding">
                            <table class="table table-hover">

                                <tr>
                                    <th>ID</th>
                                    <th>Loan Name</th>
                                    <th>Maximum Limit</th>
                                    <th>Annual Gross Limit</th>
                                    <th>Multiple Loans</th>
                                    <th>Action</th>
                                </tr>
                                <?php $sn = 0; ?>
                                @foreach ($LoansMaster as $LoanMaster)
                                <?php $sn += 1;?>
                                <tr>
                                    <td>{{$sn}}</td>
                                    <td>{{ $LoanMaster->loan_name }}</td>
                                    <td>{{ $LoanMaster->loan_maximum_limit }}</td>
                                    <td>{{ $LoanMaster->loan_limit_annual_gross }}</td>
                                    <td> @if($LoanMaster->multiple_loan = "1")
                                            Yes
                                        @elseif($LoanMaster->multiple_loan = "0")
                                        No
                                        @endif
                                    </td>
 
                                    <td>
                                    <a href="{{url('corphrm/loanmaster/edit')}}/{{ $LoanMaster->id }}">
                                        <button class="btn btn-primary btn-sm" >Edit</button>
                                    </a>
                                    <a href="{{url('corphrm/delete/loanmaster')}}/{{ $LoanMaster->id }}">
                                        <button class="btn btn-danger btn-sm" >Delete</button>
                                    </a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            @if(!$LoansMaster)
                            <td><p style="text-align:center;" >No Loans Master.
                                </p></td>

                            @endif
                        </div>
                </div>
            </div>
        </div>
    </section>


@stop
