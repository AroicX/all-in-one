@extends('CorpTax.index')

@section('content')
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">

                        <h3 class="box-title col-sm-2">CIT Computation</h3>
                       <span class="">Map the entries from the trial balance to the corresponding category</span>

                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->

                    <form role="form" action="{{route('mapTrialBalance')}}" method="post">
                        <div class="box-body row">

                            <div class="form-group col-sm-3">

                                @if(!empty($excelData))
                                <ul>
                                    @foreach($excelData[0] as $key => $data)
                                        <li><span>{{$key}} 	&nbsp;</span>{{$data}}</li>
                                        @endforeach
                                </ul>
                                @endif
                            </div>
                            
                            <div class="col-sm-4 form-group">
                                <label for="" class="">Operating expenses(allowable)</label>
                                <input type="text" class="form-control" required  name="op_exp_allowable" placeholder="entry numbers eg 1, 29, 3...">

                            </div>
                                <div class="col-sm-4 form-group">
                                    <label for="">Operating expenses(disallowable)</label>
                                <input type="text" class="form-control" required name="op_exp_disallowable" placeholder="entry numbers eg 1, 29, 3...">
                            </div>
                                <div class="col-sm-4 form-group">
                                    <label for="">Revenue(Vatable)</label>
                                <input type="text" class="form-control" required name="revenue_vatable"  placeholder="entry numbers eg 1, 29, 3...">
                            </div>

                                <div class="col-sm-4 form-group">
                                    <label for="">Revenue( Non Vatable)</label>
                                <input type="text" class="form-control" required  name="revenue_nonvatable" placeholder="entry numbers eg 1, 29, 3...">
                            </div>
                                <div class="col-sm-4 form-group">
                                    <label for="">Accumulated Depreciation</label>
                                <input type="text" class="form-control" name="accumulated_depreciation" required placeholder="entry numbers eg 1, 29, 3...">
                            </div>
                                <div class="col-sm-4 form-group">
                                    <label for="">Cos of property plant and equipment</label>
                                <input type="text" class="form-control" name="cost_of_ppe" required placeholder="entry numbers eg 1, 29, 3...">
                            </div>
                                <div class="col-sm-4 form-group">
                                    <label for="">Tax payable</label>
                                <input type="text" class="form-control" name="tax_payable" required placeholder="entry numbers eg 1, 29, 3...">
                            </div>
                                <div class="col-sm-4 form-group">
                                    <label for="">VAT payable</label>
                                <input type="text" class="form-control" name="vat_payable" required placeholder="entry numbers eg 1, 29, 3...">
                            </div>
                                <div class="col-sm-4 form-group">
                                    <label for="">Share Capital</label>
                                <input type="text" class="form-control" name="share_capital" placeholder="entry numbers eg 1, 29, 3...">
                            </div>
                                <div class="col-sm-4 form-group">
                                    <label for="">Reserves</label>
                                <input type="text" class="form-control" name="reserves" required placeholder="entry numbers eg 1, 29, 3...">
                            </div>
                                <div class="col-sm-4 form-group">
                                    <label for="">Deferred Tax Liabilities</label>
                                <input type="text" class="form-control" name="deferred_tax_liabilities" required placeholder="entry numbers eg 1, 29, 3...">
                            </div>
                            <div class="col-sm-4 form-group">
                                    <label for="">Deferred Tax Assets</label>
                                <input type="text" class="form-control" name="deterred_tax_asset" required placeholder="entry numbers eg 1, 29, 3...">
                            </div>
                                <div class="col-sm-4 form-group">
                                    <label for="">WHT Receivables</label>
                                <input type="text" class="form-control" name="wht_receivables" required placeholder="entry numbers eg 1, 29, 3...">
                            </div>
                                <div class="col-sm-4 form-group">
                                    <label for="">WHT Payable</label>
                                <input type="text" class="form-control" required name="wht_payable" placeholder="entry numbers eg 1, 29, 3...">
                            </div>
                                <div class="col-sm-4 form-group">
                                    <label for="">Direct Costs</label>
                                <input type="text" class="form-control" required name="direct_costs" placeholder="entry numbers eg 1, 29, 3...">
                            </div>
                            <div class="col-sm-4 form-group">
                                    <label for="">Others</label>
                                <input type="text" class="form-control" name="others" required placeholder="entry numbers eg 1, 29, 3...">
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <div class="col-sm-2 col-sm-offset-10">
                                <button type="submit" class="btn btn-success">Map</button>
                            </div>
                        </div>
                    </form>

                </div>

            </div>
            <!--/.col (left) -->
        </div>

        <!-- /.row -->
    </section>
@endsection