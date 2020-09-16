@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Create Invoice</h5>
                <span class="d-block m-t-5">Invoice</span>
            </div>
            <div class="card-body table-border-style">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form method="post" action="{{url('corpfin/invoice/add')}}" id="inv-form">
                            <!--col-md-12-->
                            <div class="col-md-12">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <input type="hidden" name="url" id="url" value="{{url('')}}">
                                <input type="hidden" name="type" value="invoice">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="client">Client<span style="color:red;">*</span></label>
                                        <select type="text" name="client_id" id="client" class="form-control" required>
                                            <option value="">--choose--</option>
                                                @foreach (App\CorpFinTranPartner::where('company_id', Auth::user()->company_id)->get() as $client)
                                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                                @endforeach
                                           
                                        </select>
                                    </div>
                                </div>

                                <div class="row" style="padding-top:15px;">
                                    <div class="col-sm-12">
                                        <label for="qdate">Invoice Date<span style="color:red;">*</span></label>
                                        <div class="input-group date" data-provide="datepicker">
                                            <input type="date" name="invoice_date" id="qdate"
                                                   placeholder="Select Invoice Date" class="form-control" required>
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top:15px;">
                                    <div class="col-sm-12">
                                        <label for="phone">Invoice Password (Optional)</label>
                                        <input type="text" name="password" id="qpassword"
                                               placeholder="Invoice Password" class="form-control">
                                    </div>
                                </div>
                                <div class="row" style="padding-top:15px;">
                                    <div class="col-sm-12">
                                        <label for="address">Invoice Group<span style="color:red;">*</span></label>
                                        <select type="text" name="invoice_group_id" id="group" class="form-control" required>
                                            <option value="">--choose--</option>
                                            @foreach(App\Models\CorpFIN\InvoiceGroup::where('company_id', Auth::user()->company_id)->get() as $invoice_grp)
                                                <option value="{{$invoice_grp->id}}">{{$invoice_grp->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row" style="padding-top:10px;">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-success btn-flat pull-right">Save
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <!-- End col-md-12-->
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
   
</div>

@endsection
