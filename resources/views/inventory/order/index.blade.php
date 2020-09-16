@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Placed Orders</h5>
                <span class="d-block m-t-5">Manage Orders</span>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#Ref</th>
                                <th>Purchase date</th>
                                <th>Total</th>
                                <th>View Details</th>

                            </tr>
                        </thead>

                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>000{{$order->id}}</td>
                                <td>{{date('F d, Y' , strtotime($order->purchase_date))}}</td>
                                <td>{{number_format($order->total_invoice_cost,2)}}</td>
                                <td><a class="btn btn-primary" href="{{url('inventory/order/show', $order->id)}}"><i
                                            class="fa fa-eye"></i></a></td>
                            </tr>
                            @endforeach
                            @if(count($orders) < 1) <p>You haven't recorded any orders. <a class="btn btn-primary"
                                    href="{{url('inventory/order/create')}}">Add Order</a></p>
                                @endif
                        </tbody>

                    </table>
                    <div class="pager">
                        {{ $orders->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>




@endsection