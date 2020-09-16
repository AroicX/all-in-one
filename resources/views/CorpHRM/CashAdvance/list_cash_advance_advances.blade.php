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
                        <h5>Cash Advance Advances</h5>
                        <a href="{{url('/corphrm/cashadvance/advance/new')}}">
                            <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                        </a>
                    </div>

                        <div class="card-body table-responsive no-padding">
                            <table class="table table-hover">

                                <tr>
                                    <th>ID</th>
                                    <th>Approval Code</th>
                                    <th>Approval Date</th>
                                    <th>Application Code</th>
                                    <th>Employee.</th>
                                    <th>Application</th>
                                    <th>Requested Amount</th>
                                    <th>Action</th>
                                </tr>
                                <?php $sn = 0; ?>
                                @foreach ($advances as $advance)
                                <?php $sn += 1;?>
                                <tr>
                                    <td>{{$sn}}</td>
                                    <td>{{ $advance['approval_code'] }}</td>
                                    <td>{{ $advance['approval_date'] }}</td>
                                    <td>{{ $advance['application_code'] }}</td>
                                    <td>{{ $advance['employee'] }}</td>
                                    <td>{{ $advance['application'] }}</td>
                                    <td>{{ $advance['requested_amount'] }}</td>
                                    <td>  <a href="{{url('corphrm/delete/cashadvance_advance')}}/{{ $advance['id'] }}">
                                        <button class="btn btn-danger btn-sm" >Delete</button>
                                    </a></td>
                                </tr>
                                @endforeach
                            </table>
                            @if(!$advances)
                            <td><p style="text-align:center;" >No Advances.
                                </p></td>

                            @endif
                        </div>
                </div>
            </div>
        </div>
    </section>


@stop
