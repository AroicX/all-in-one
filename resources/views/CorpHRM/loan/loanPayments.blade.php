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
                		<h5>Loan Repayments</h5>
                        <a href="{{url('corphrm/loanpayment/new')}}">
                            <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                        </a>
                	</div>

                        <div class="card-body table-responsive no-padding">
                            <table class="table table-hover">

                                <tr>
                                    <th>ID</th>
                                    <th>Transaction Id</th>
                                    <th>Transaction Date</th>
                                    <th>Employee</th>
                                    <th>Payment mode</th>
                                    <th>Payment type</th>
                                    <th>Amount Paid</th>
                                    <th>Outstanding balance</th>
                                    <th>Status</th>
                                    {{--  <th>Action</th>  --}}
                                </tr>
                                <?php $sn = 0; ?>
                                @foreach ($loanpayments as $loanpayment)
                                <?php $sn += 1;?>
                                <tr>
                                    <td>{{$sn}}</td>
                                    <td>{{ $loanpayment->transaction_id }}</td>
                                    <td>{{ $loanpayment->transaction_date }}</td>
                                    <td>{{ $loanpayment->employee_id }}</td>
                                    <td>{{ $loanpayment->payment_mode }}</td>
                                    <td>{{ $loanpayment->payment_type }}</td>
                                    <td>{{ round($loanpayment->amount_paid) }}</td>
                                    <td>{{ round($loanpayment->outstanding_balance) }} (Pending: <i style="color: red;">{{ round($loanpayment->outstanding_balance - $loanpayment->amount_paid) }}</i>)</td>
                                    <td>{{ $loanpayment->status }}</td>
                                    {{--  <td>
                                    </td>  --}}
                                </tr>
                                @endforeach
                            </table>
                            @if(!$loanpayments)
                            <td><p style="text-align:center;" >No Claims Application.
                                </p></td>

                            @endif
                        </div>
                </div>
            </div>
        </div>
    </section>


@stop
