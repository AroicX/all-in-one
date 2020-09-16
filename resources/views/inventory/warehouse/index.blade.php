@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Manage Warehouses</h5>
                <span class="d-block m-t-5">Warehouses</span>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
								<th>#Ref</th>
								<th>Name</th>
								<th>Address</th>
								<th>City</th>
								<th>State</th>
								<th>Country</th>    
									<th>View Details</th>

                            </tr>
                        </thead>

                        <tbody>
							@foreach($warehouses as $warehouse)
							<tr>
								<td>{{$warehouse->id}}</td>
								<td>{{$warehouse->name}}</td>
								<td>{{$warehouse->address}}</td>
								<td>{{$warehouse->city}}</td>
								<td>{{$warehouse->state}}</td>
								<td>{{$warehouse->country }}</td>
								<td><a class="btn btn-primary" href="{{route('warehouse.show', $warehouse->id)}}"><i class = "fa fa-eye"></i></a></td>
							</tr>
						@endforeach
							@if(count($warehouses) < 1)
							<p>You haven't added any warehouses. <a class="btn btn-primary" href="{{route('warehouse.create')}}">Add Warehouse</a></p>
						@endif
                        </tbody>

                    </table>
                    <div class="pager">
                        {{ $warehouses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>




@endsection