@extends('CorpTax.index')
<title>CorpTAX | view Transaction</title>
@section('content')
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">

                        <h3 class="box-title col-sm-2">View Transactions</h3>
                        <div class="form-group col-sm-2">
                            {{--<label for="">Period of transaction</label>--}}
                            <input required type="text"  name="from_date" data-provide="datepicker" class="form-control"
                                   placeholder="from date">

                        </div>
                        <div class="form-group col-sm-2">
                            {{--<label for="">Period of transaction</label>--}}
                            <input required type="text"  name="to_date" data-provide="datepicker" class="form-control"
                                   placeholder="To date">
                        </div>

                        <div class="col-sm-1">
                            <button class="btn btn-info dropdown-toggle" data-toggle="dropdown" id="">Filter <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="" id="filterScheduleCompany">Company</a></li>
                                <li><a href="" id="filterScheduleIndividual">Individual</a></li>
                            </ul>

                        </div>

                        <div class="col-sm-1 dropdown">
                            <button class="btn btn-success dropdown-toggle" id="" data-toggle="dropdown">Print Schedule
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="" id="printScheduleCompany">Company</a></li>
                                <li><a href="" id="printScheduleIndividual">Individual</a></li>
                            </ul>
                        </div>

                        <div class="form-group col-sm-3 col-sm-offset-1">
                            <input type="text"  id="transaction_search" class="form-control" placeholder="Search for transactions">
                        </div>



                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" id="logTransactionManually">
                        <div class="box-body">

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Name of Vendor</th>
                                    <th>Address of Vendor</th>
                                    <th>TIN of Vendor</th>
                                    <th>Nature of Activity</th>
                                    <th>Period of Transaction</th>
                                    <th>Transaction Type</th>
                                    <th>Invoice Amount</th>
                                    <th>WHT Rate</th>
                                    <th>Amount of WHT Deducted</th>
                                </tr>
                                </thead>

                                @if(!empty($transactions))
                                <tbody id="transactions">
                                @foreach($transactions as $item)
                                    <tr id="transaction-row">
                                        <td>{{$item->vendor_name ? $item->vendor_name :''}}</td>
                                        <td>{{$item->vendor_address ? $item->vendor_address :''}}</td>
                                        <td>{{$item->vendor_TIN ? $item->vendor_TIN :''}}</td>
                                        <td>{{$item->nature_of_transaction ? $item->nature_of_transaction :''}}</td>
                                        <td>{{$item->transaction_period ? $item->transaction_period :''}}</td>
                                        <td>{{$item->transaction_type ? $item->transaction_type :''}}</td>
                                        <td>{{$item->invoice_amount ? $item->invoice_amount :''}}</td>
                                        <td>{{$item->WHT_rate ? $item->WHT_rate :''}}</td>
                                        <td>{{$item->WHT_amount ? $item->WHT_amount :''}}</td>
                                    </tr>
                                @endforeach
                                </tbody>

                                    @endif
                            </table>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            {{--<a href="{{route('WHTScheduleTemplate')}}" class="btn btn-info">Download Excel Template</a>--}}
                            {{--<a class="btn btn-primary" data-toggle="modal" data-target="#uploadTemplate">Upload Transactions</a>--}}
                            {{--<button type="submit" id="logTransactions" class="btn btn-success">Submit</button>--}}

                        </div>
                    </form>


                    {{--modal--}}
                    <div class="box box-primary">
                        <div class="modal fade" id="uploadTemplate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Upload Transactions</h4>
                                    </div>
                                    <div class="modal-body">

                                        <form action="" id="transactionUpload" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="">Upload Transactions(in excel)</label>
                                                <input type="file" name="excel_transaction">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                        <button type="submit"
                                                class="btn btn-success" id="uploadTransactions">Upload</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <!--/.col (left) -->
        </div>

        <!-- /.row -->
    </section>
@endsection