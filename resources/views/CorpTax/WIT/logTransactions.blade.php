@extends('CorpTax.layout.master')
<title>CorpTAX | Log Transactions</title>
@section('content')
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Log Transaction</h5>
                </div>
                <div class="card-body">
                    <form role="form" id="logTransactionManually">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group ">
                                    <label for="">Vendor Type</label>
                                    <select name="company_type" id="company_type" class="form-control">
                                        <option disabled selected>Vendor Type</option>
                                        <option value="company">Company</option>
                                        <option value="individual">Individual</option>
                                    </select>
                                </div>
                                <div class="form-group  ">
                                    <label for="">Name of Vendor</label>
                                    <input required name="vendor_name" type="text" class="form-control" id=""
                                        placeholder="Name of Individual or Corporation">
                                </div>

                                <div class="form-group ">
                                    <label for="">Address of Vendor</label>
                                    <input required name="vendor_address" type="text" class="form-control" id=""
                                        placeholder="Official Address">
                                </div>

                                <div class="form-group ">
                                    <label for="">TIN of Vendor</label>
                                    <input required name="vendor_TIN" type="text" class="form-control" id=""
                                        placeholder="Tax identification number of vendor">
                                </div>

                                <div class="form-group  ">
                                    <label for="">Nature of Activity</label>
                                    <input required type="text" name="nature_of_activity" class="form-control" id=""
                                        placeholder="Nature of Activity">
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="form-group ">
                                    <label for="">Transaction Type</label>
                                    <select required name="transaction_type" id="transaction_type" class="form-control">
                                        <option value="" selected disabled>Transaction type</option>
                                        <option value="Dividend,interest and rent">Dividend,interest and rent</option>
                                        <option value="Royalties">Royalties</option>
                                        <option value="Hire,Rental of equipment, Motor vehicles,Plant and Machinery">
                                            Hire,Rental of equipment, Motor vehicles,Plant and Machinery</option>
                                        <option value="Building, Construction and related Services">
                                            Building, Construction and related Services</option>
                                        <option
                                            value="All types of contracts and agency arrangements other than sales in ordinary course of business">
                                            All types of contracts and agency
                                            arrangements other than sales in ordinary course of business</option>
                                        <option value="Directors fees">Director's fees</option>
                                    </select>
                                </div>

                                <div class="form-group ">
                                    <label for="">Period of transaction</label>
                                    <input required type="text" name="transaction_period" data-provide="datepicker"
                                        class="form-control" placeholder="Period of Transaction">

                                </div>

                                <div class="form-group ">
                                    <label for="">Invoice Amount</label>
                                    <input required type="text" class="form-control" name="invoice_amount"
                                        id="invoice_amount" placeholder="Invoice Amount">
                                </div>

                                <div class="form-group  ">
                                    <label for="">WHT Rate</label>
                                    <input required type="text" class="form-control" name="WHT_rate" id="WHT_rate"
                                        placeholder="WithHolding Tax Rate">
                                </div>

                                <div class="form-group ">
                                    <label for="">Amount of WHT Deducted</label>
                                    <input required type="text" class="form-control" name="amount_of_WHT"
                                        id="WHT_amount" placeholder="Amount of WHT Deducted">
                                </div>
                            </div>


                        </div>
                        <!-- /.box-body -->

                        <div class="form-group">
                            <a href="{{route('WHTScheduleTemplate')}}" class="btn btn-primary has-ripple">Download Excel Template</a>
                            <a class="btn btn-dark text-white" data-toggle="modal" data-target="#uploadTransactionModal">Upload
                                Transactions</a>
                            <button type="submit" id="logTransactions" class="btn btn-success">Submit</button>

                        </div>


                    </form>
                </div>
            </div>
        </div>


     

        <div id="uploadTransactionModal" class="modal fade" tabindex="-1" role="dialog"
            aria-labelledby="uploadtransaction" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadtransaction">Upload Transactions</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="transactionUpload" enctype="multipart/form-data">

                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="">Upload Transactions(in excel)</label>
                                    <input type="file" name="excel_transaction" required>
                                </div>

                                <div class="alert alert-info col-sm-10 col-sm-offset-1">
                                    <span>Enter the column names(from your excel sheet) on the left which
                                        corresponds to that on the right</span>
                                </div>

                                <div class="form-group ">
                                    <input type="text" class="form-control" required
                                        placeholder="input row headers fro your excel file" name="vendor_name">
                                </div>

                                <div class="form-group ">
                                    <input type="text" readonly="" value="Name of Vendor" class="form-control" name="">
                                </div>

                                <div class="form-group ">
                                    <input type="text" class="form-control" required
                                        placeholder="input row headers fro your excel file" name="company_type">
                                </div>


                                <div class="form-group ">
                                    <input type="text" readonly="" value="Vendor Type" class="form-control" name="">
                                </div>

                                <div class="form-group ">
                                    <input type="text" class="form-control" required
                                        placeholder="input row headers fro your excel file" name="vendor_address">
                                </div>

                                <div class="form-group ">
                                    <input type="text" readonly="" value="Address of Vendor" class="form-control"
                                        name="">
                                </div>


                                <div class="form-group ">
                                    <input type="text" class="form-control" required
                                        placeholder="input row headers fro your excel file" name="vendor_TIN">
                                </div>

                                <div class="form-group ">
                                    <input type="text" readonly="" value="TIN of Vendor" class="form-control" name="">

                                </div>


                                <div class="form-group ">
                                    <input type="text" class="form-control" required
                                        placeholder="input row headers fro your excel file"
                                        name="nature_of_transaction">
                                </div>

                                <div class="form-group ">
                                    <input type="text" readonly="" value="Nature of Transaction" class="form-control"
                                        name="">
                                </div>

                                <div class="form-group ">
                                    <input type="text" class="form-control" required
                                        placeholder="input row headers fro your excel file" name="transaction_date">
                                </div>

                                <div class="form-group ">

                                    <input type="text" readonly="" value="Date of Transaction" class="form-control"
                                        name="">
                                </div>


                                <div class="form-group ">
                                    <input type="text" class="form-control" required
                                        placeholder="input row headers fro your excel file" name="transaction_type">
                                </div>

                                <div class="form-group ">
                                    <input type="text" readonly="" value="Transaction Type" class="form-control"
                                        name="">

                                </div>

                                <div class="form-group ">
                                    <input type="text" class="form-control" required
                                        placeholder="input row headers fro your excel file" name="invoice_amount">
                                </div>

                                <div class="form-group ">
                                    <input type="text" readonly="" value="Invoice Amount" class="form-control" name="">
                                </div>

                                <div class="form-group ">
                                    <input type="text" class="form-control" required
                                        placeholder="input row headers fro your excel file" name="WHT_rate">
                                </div>

                                <div class="form-group ">

                                    <input type="text" readonly="" value="WHT Rate" class="form-control" name="">
                                </div>

                                <div class="form-group ">
                                    <input type="text" class="form-control" required
                                        placeholder="input row headers fro your excel file" name="WHT_amount">
                                </div>

                                <div class="form-group ">
                                    <input type="text" readonly="" value="Amount of WHT Deducted" class="form-control"
                                        name="">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary has-ripple" id="uploadTransactions">Upload</button>
                            </div>
                        </form>

                    </div>
                    
                </div>
            </div>
        </div>

    </div>

    <!-- /.row -->
</section>
@endsection