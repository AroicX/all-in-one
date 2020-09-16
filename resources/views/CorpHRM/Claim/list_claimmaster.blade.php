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
                		<h5>Claims Master</h5>
                        <a href="{{url('corphrm/claim_master')}}?action=new">
                            <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                        </a>
                	</div>

                        <div class="card-body table-responsive no-padding">
                            <table class="table table-hover table-bordered">

                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Claims Limit</th>
                                    <th>Action</th>
                                </tr>
                                <?php $sn = 0; ?>
                                @foreach ($claimsmaster as $claimmaster)
                                <?php $sn += 1;?>
                                <tr>
                                    <td>{{$sn}}</td>
                                    <td>{{ $claimmaster->name }}</td>
                                    <td>{{ $claimmaster->max_limit }}</td>
                                    <td>
                                    <a href="{{ url('corphrm/claim_master') }}?action=edit&id={{ $claimmaster->id }}">
                                    <button class="btn btn-sm btn-success">Edit</button>
                                    </a>
                                     <a onclick="return confirm('Are you sure you want to suspend this claim master');" href="{{ url('corphrm/claims/delete') }}?cat=master&id={{ $claimmaster->id }}">
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                    </a>                                   
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            @if(!$claimsmaster)
                            <td><p style="text-align:center;" >No Claims Master Yet.
                                </p></td>

                            @endif
                        </div>
                </div>
            </div>
        </div>
    </section>

@stop