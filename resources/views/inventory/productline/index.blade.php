@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Product Lines</h5>
                <span class="d-block m-t-5">All Products Lines</span>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                                <th>#Ref</th>
                            <th>Name</th>
                            <th>Additional information</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($productlines as $productline)
                                <tr>   
                                            <td>{{$productline->id}}</td>
                                            <td>{{$productline->name}}</td>
                                            <td>{{$productline->additional_info}}</td>
                                    <td><a class="btn btn-primary" href="{{route('productline.show', $productline->id)}}"><i class = "fa fa-eye"></i></a></td>
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