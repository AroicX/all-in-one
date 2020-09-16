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
                		<h5>Loan Disbursments</h5>
                        <a href="{{url('corphrm/loandisbursement/new')}}">
                            <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                        </a>
                	</div>

                        <div class="card-body table-responsive no-padding">
                            <table class="table table-hover">

                                <tr>
                                    <th>ID</th>
                                    <th>Transaction Id</th>
                                    <th>Transaction Date</th>
                                    <th>Employee.</th>
                                    <th>Disbursed ampunt</th>
                                    <th>Disbursment mode</th>
                                    <th>Status</th>
                                    {{--  <th>Action</th>  --}}
                                </tr>
                                <?php $sn = 0; ?>
                                @foreach ($LoansDisbursments as $LoansDisbursment)
                                <?php $sn += 1;?>
                                <tr>
                                    <td>{{$sn}}</td>
                                    <td>{{ $LoansDisbursment->trasaction_id }}</td>
                                    <td>{{ $LoansDisbursment->transaction_date }}</td>
                                    <td>{{ $LoansDisbursment->employee_id }}</td>
                                    <td> {{ $LoansDisbursment->disbursed_amount }} </td>
                                    <td>{{ $LoansDisbursment->mode_of_disbursement }}</td>
                                    <td>{{ $LoansDisbursment->status }}</td>
                                    {{--  <td></td>  --}}
                                </tr>
                                @endforeach
                            </table>
                            @if(!$LoansDisbursments)
                            <td><p style="text-align:center;" >No Loans Master.
                                </p></td>

                            @endif
                        </div>
                </div>
            </div>
        </div>
    </section>


@stop
