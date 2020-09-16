@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Edit Warehouse</h5>
                <span class="d-block m-t-5">Warehouse</span>
            </div>
            <div class="card-body table-border-style">
                <form  action="{{route('warehouse.update', $warehouse->id)}}" method="post">

                    <br>
                    <div class="row">
                        <div class="col-md-12">
                        {{ method_field('PATCH')}}
                         <input type="hidden" name="url" id="url" value="{{url('')}}">
                           
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-sm-12">

                                    <div class="form-group">
                                        <label>Warehouse Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Enter Warehouse Name"
                                             value="{{$warehouse->name}}"  required>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label>Warehouse Address</label>
                                        <input type="text" name="address" class="form-control"
                                             value="{{$warehouse->address}}"   placeholder="Warehouse Address" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label>Country</label>
                                        <select class="selectpicker form-control country" id="country"
                                                data-live-search="true" name="country" placeholder="" required>
                                            <option value="{{$warehouse->country}}" >{{$warehouse->country}}</option>
                                            <?php foreach (App\Country::all() as $country) { ?>
                                            <option value="{{ $country->name }}" id="{{ $country->id }}">
                                                {{ $country->name }}
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>State</label>
                                        <select id="state" data-live-search="true" name="state" class="form-control"
                                           
                                                required> <option value="{{$warehouse->state}}" >{{$warehouse->state}}</option></select>
                                    </div>
                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group" style="">
                                        <label>City</label>
                                        <input type="text" name="city" class="form-control" placeholder="Enter City"
                                            value="{{$warehouse->city}}"    required>
                                    </div>

                                    <td id="test">

                                    </td>
                                </div>
                            </div>

                          
                            <br>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit">Save changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
