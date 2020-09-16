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
                        <h5>Cash Retirement Approvals</h5>
                        {{--  <a href="{{url('/corphrm/cashadvance/retirement_approval/new')}}">
                            <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                        </a>  --}}
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
                                    @if($retirement['status'] != "Cancelled")
                                      <a href="{{url('corphrm/delete/cashadvance_retirement_update_approve')}}/{{ $retirement['id'] }}">
                                        <button class="btn btn-primary btn-sm" >Approve</button>
                                    </a>
                                    @else
                                            <a href="{{url('corphrm/delete/cashadvance_retirement_update_cancel')}}/{{ $retirement['id'] }}">
                                        <button class="btn btn-danger btn-sm" >Cancel</button>
                                    </a>
                                    @endif
                                    </td>
                                </tr>
                                @endforeach
                            </table>

                        </div>
                </div>
            </div>
        </div>
    </section>


@stop
