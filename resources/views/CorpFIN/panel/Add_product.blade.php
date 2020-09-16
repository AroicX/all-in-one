@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Add New Product</h5>
                <span class="d-block m-t-5">Products</span>
            </div>
            <div class="card-body table-border-style">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" id="add_product" method="post" action="{{ route('corpfin.product.add') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="company_id" value="{{$company->id}}">
                            <input type="hidden" name="url" id="url" value="{{url('')}}">
                            {{--todo: how to go about category--}}
                            <input type="hidden" name="category" value="Product">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <input type="text" class="form-control" name="name" id="product_name"
                                           placeholder="Name of Product" required>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Measure</label>
                                            <select class="form-control" name="measure" id="measure" required>
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
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Rate / Price</label>
                                            <select class="form-control" name="rp" id="RP" required>
                                                <option value="">Select Rate / Price</option>
                                                <option value="Rate">Rate</option>
                                                <option value="Price">Price</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Cost price per Product</label>
                                            <div class="input-group">
                                                @foreach($currency as $c)
                                                <span class="input-group-addon"
                                                      id="basic-addon1">{{ $c->p_currency }}</span>
                                                <input type="number" class="form-control price" name="price" id="price" min="0"
                                                       max="100000000.00" placeholder="0" value="0" 
                                                       aria-describedby="basic-addon1" required>
                                                <span class="input-group-addon"
                                                      id="basic-addon1"><strong>.</strong></span>
                                                <input type="number" class="form-control price" name="price2" id="price2" min="0"
                                                       max="100000000.00" placeholder="00"
                                                       aria-describedby="basic-addon1" required value="0">
                                                <span class="input-group-addon"
                                                      id="basic-addon1">{{ $c->s_currency }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Markup</label>
                                            <input type="text" name="markup" class="form-control" placeholder="0.00">
                                        </div>
                                    </div>
                               
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="taxes">Taxes</label>
                                            <select class="form-control" id="taxes" name="taxes" required>
                                                <option value="">Select Taxes Type</option>
                                                <option value="vat">VAT</option>
                                                <option value="wht">WHT</option>
                                                <option value="both">Both</option>
                                                <option value="none">None</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6" id="wht_type_id" style="display:none;">
                                        <div class="form-group">
                                            <label for="wht_type">WHT Type</label>
                                            <select class="form-control" id="wht_id" name="wht_id">
                                                <option value="">Select WHT Type</option>
                                                {{--@foreach($company->whts as $wht)
                                                <option value="{{ $wht->id }}"
                                                        id="{{ $wht->id }}">
                                                     {{ $wht->type }}
                                                </option>
                                                @endforeach--}}
                                                <option value="">5</option>
                                                <option value="">10</option>
                                                <option value="">20</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-sm-6" id="vat_type_id" style="display:none;">
                                        <div class="form-group">
                                            <label for="vat_type">VAT Type</label>
                                            <select class="form-control" name="type" id="vat_id">
                                                <option value="">Select VAT Type</option>
                                                {{--@foreach($company->vats as $vat)
                                                    <option value="{{ $vat->type }}">{{ $vat->type }}</option>
                                                @endforeach--}}
                                                <option value="Inclusive">Inclusive</option>
                                                <option value="Exclusive">Exclusive</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="row" id="tax-box" style="display:none;">
                                    <div class="col-md-4">
                                         <div class="form-group">
                                    <label for="gross">Gross amount</label>
                                    <input type="text" class="form-control" name="gross" id="gross"
                                           placeholder="0.00" readonly>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                         <div class="form-group">
                                    <label for="net">Net amount</label>
                                    <input type="text" class="form-control" name="net" id="net"
                                           placeholder="0.00" readonly>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                         <div class="form-group">
                                    <label for="gross">Vat amount</label>
                                    <input type="text" class="form-control" name="vat" id="vat"
                                           placeholder="0.00" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6" id="c_init" style="display:none;">
                                        <div class="form-group">
                                            <label for="company">Company Percentage</label>
                                            <input type="text" name="company" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6" id="i_init" style="display:none;">
                                        <div class="form-group">
                                            <label for="individual">Individual Percentage</label>
                                            <input type="text" name="individual" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="view_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" style="">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                class="fa fa-close"></i></button>
                    <center><h4 class="modal-title" style="color:#1d74b7;">Product</h4></center>
                </div>
                <form action="{{ route('corpfin.product.edit') }}" method="post"
                      enctype="multipart/form-data" name="form" id="form">
                    <input type="hidden" name="id" autocomplete="off" style="background:#ffffff;"
                           class="form-control" placeholder="" required>
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Product Name</label>
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
