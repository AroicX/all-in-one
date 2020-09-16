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
                <div class="card ">
                	<div class="card-header ">
                		<h5>Cash Advance Disbursments</h5>
                        <a href="{{url('/corphrm/cashadvance/disbursment/new')}}">
                            <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                        </a>
                	</div>

                        <div class="card-body table-responsive no-padding">
                            <table class="table table-hover">

                                <tr>
                                    <th>ID</th>
                                    <th>Disbursment Date</th>
                                    <th>Approval Code</th>
                                    <th>Application Date</th>
                                    <th>Approved Date</th>
                                    <th>Approved Amount</th>
                                    <th>Employee</th>
                                    <th>Payment Mode</th>
                                    <th>Bank</th>
                                    <th>Action</th>
                                </tr>
                                <?php $sn = 0; ?>
                                @foreach ($disbursments as $disbursment)
                                <?php $sn += 1;?>
                                <tr>
                                    <td>{{$sn}}</td>
                                    <td>{{ $disbursment['disbursment_date'] }}</td>
                                    <td>{{ $disbursment['approval_code'] }}</td>
                                    <td>{{ $disbursment['application_date'] }}</td>
                                    <td>{{ $disbursment['approved_date'] }}</td>
                                    <td>{{ $disbursment['approved_amount'] }}</td>
                                    <td>{{ $disbursment['employee'] }}</td>
                                    <td>{{ $disbursment['payment_mode'] }}</td>
                                    <td>{{ $disbursment['bank'] }}</td>
                                    <td>
                                    <a href="{{url('corphrm/delete/cashadvance_disbursment')}}/{{ $disbursment['id'] }}">
                                        <button class="btn btn-danger btn-sm" >Delete</button>
                                    </a></td>
                                </tr>
                                @endforeach
                            </table>
                            @if(!$disbursments)
                            <td><p style="text-align:center;" >No Disbursments.
                                </p></td>

                            @endif
                        </div>
                </div>
            </div>
        </div>
    </section>


@stop
