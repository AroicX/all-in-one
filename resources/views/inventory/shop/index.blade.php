@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>View Shops</h5>
                <span class="d-block m-t-5">Shops</span>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                                <th>#Ref</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Country</th>    
                                <th>View Details</th>
                        </thead>
                        <tbody>
                            @foreach($shop as $shop)
                                <tr>
                                    <td>{{$shop->id}}</td>
                                    <td>{{$shop->name}}</td>
                                    <td>{{$shop->address}}</td>
                                    <td>{{$shop->city}}</td>
                                            <td>{{$shop->state}}</td>
                                            <td>{{$shop->country}}</td>
                                    <td><a class="btn btn-primary" href="{{route('shop.show', $shop->id)}}"><i class = "fa fa-eye"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/general/Setup.js')}}"></script>

@endsection