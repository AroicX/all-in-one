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
                		<h5>Cash Advance Retirements</h5>
                        <a href="{{url('/corphrm/cashadvance/retirement/new')}}">
                            <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                        </a>
                	</div>

                        <div class="card-body table-responsive no-padding">
                            <table class="table table-hover">

                                <tr>
                                    <th>ID</th>
                                    <th>Transaction Date</th>
                                    <th>Retirement Code</th>
                                    <th>Disbursment</th>
                                    <th>Retirement Amount</th>
                                    {{--  <th>Approved Amount</th>  --}}
                                    <th>Employee</th>
                                    {{--  <th>Balance</th>  --}}
                                    <th>Uploaded Doc.</th>
                                    <th>Action</th>
                                </tr>
                                <?php $sn = 0; ?>
                                @foreach ($retirements as $retirement)
                                <?php $sn += 1;?>
                                <tr>
                                    <td>{{$sn}}</td>
                                    <td>{{ $retirement['transaction_date'] }}</td>
                                    <td>{{ $retirement['retirement_code'] }}</td>
                                    <td>{{ $retirement['disbursment'] }}</td>
                                    <td>{{ $retirement['retirement_amount'] }}</td>
                                    {{--  <td>{{ $retirement['approved_amount'] }}</td>  --}}
                                    <td>{{ $retirement['employee'] }}</td>
                                    {{--  <td>{{ $retirement['balance'] }}</td>  --}}
                                    <td>{{ $retirement['upload_doc'] }}</td>
                                     <td>{{ $retirement['status'] }}</td>
                                    <td>
                                      <a href="{{url('corphrm/delete/cashadvance_retirement')}}/{{ $retirement['id'] }}">
                                        <button class="btn btn-danger btn-sm" >Delete</button>
                                    </a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            @if(!$retirements)
                            <td><p style="text-align:center;" >No Retirements.
                                </p></td>

                            @endif
                        </div>
                </div>
            </div>
        </div>
    </section>


@stop
