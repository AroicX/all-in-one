@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>View Services</h5>
                <span class="d-block m-t-5">Services</span>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Measure</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Taxes</th>
                                <th>Action</th>
                                {{--<th>Delete</th>--}}
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sn = 0; ?>
                                @foreach ($services as $service)
                                    <?php $sn += 1;?>
                                    <tr>
                                        <td>{{$sn}}</td>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ $service->measure }}</td>
                                        <td>{{ $service->rp }}</td>
                                        <td>{{ $service->price }}</td>
                                        <td>@if ($service->taxes == "Both")
                                            {{ "WHT, VAT" }}
                                        @else
                                            {{ $service->taxes }}
                                        @endif
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-success edit_services"
                                                        id="{{ $service->id }}"><i class="feather icon-edit"></i>
                                                </button>
                                            </div>
                                            <button type="button" id=" {{ $service->id }} ?>"
                                                    class="btn btn-sm btn-danger delete_service_selected">
                                                <i class="feather icon-trash-2 "></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                        </tbody>
                    </table>
                    <div class="pager">
                        {{ $services->links() }}
                    </div>
                    @if(empty($service))
                        <td><p style="text-align:center;">No Services Added.
                                <a href="{{route('corpfin.service.add')}}"> Add Service</a>
                            </p></td>

                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="view_service_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" style="">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color:#1d74b7;">Service</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('corpfin.service.edit') }}" method="post"
                      enctype="multipart/form-data" name="form" id="form">
                    <input type="hidden" name="id" autocomplete="off" style="background:#ffffff;"
                           class="form-control" placeholder="" required>
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Service Name</label>
                                    <div class="append-icon">
                                        <input type="text" name="name" autocomplete="off"
                                               style="background:#ffffff;" class="form-control"
                                               placeholder="Enter Product Name" required>
                                        <i class="icon-user"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Measure</label>
                                    <select class="form-control" name="measure" id="measure"
                                            required>
                                        <option value="Quantity">Quantity</option>
                                        <option value="Unit">Unit</option>
                                        <option value="Hrs">Hrs</option>
                                        <option value="Miles">Miles</option>
                                        <option value="KM">KM</option>
                                        <option value="Inches">Inches</option>
                                        <option value="Kg">Kg</option>
                                        <option value="Mg">Mg</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Rate / Price</label>
                                    <select class="form-control" name="rp" id="RP" required>
                                        <option>Select Rate / Price</option>
                                        <option value="Rate">Rate</option>
                                        <option value="Price">Price</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Price</label>
                                    <div class="option-group">
                                        <input type="text" class="form-control" autocomplete="off"
                                               name="price">
                                    </div>
                                </div>
                            </div>
                            <div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <center>
                                <button type="submit" class="btn btn-embossed btn-success"
                                        style="background:#1d74b7;">Update
                                </button>
                            </center>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
