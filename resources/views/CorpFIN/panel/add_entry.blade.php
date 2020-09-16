@extends('CorpFIN.layout.corpfin')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Manage Transaction Entries</h5>
                <span class="d-block m-t-5">Register New Transaction Entry</span>
            </div>
            <div class="card-body table-border-style">
                <div class="row">
                <div class="col-xl-4 col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Entry Samples</h5>
                            </div>
                            <div class="card-body">
                                <div id='external-events' class="external-events">
                                    @foreach($sample_entries as $sample_entry)
                                    <div class='fc-event' data-key="{{ $sample_entry }}" style="background-color: {{ $sample_entry->color }}; border-color: {{ $sample_entry->color }};">{{ $sample_entry->title }}</div>
                                    @endforeach
                                    @if(empty($sample_entries))
                                    No sample entry
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="switch switch-primary d-inline m-r-10">
                                        <input type="checkbox" id="drop-remove">
                                        <label for="drop-remove" class="cr"></label>
                                    </div>
                                    <label>Remove Event</label>
                                </div>
                                <ul class="fc-color-picker" id="color-chooser">
                                    <li id="bj" onclick="changeButtonColor('#00c0ef')"><span class="fc-color" style="color: #00c0ef"><i class="fa fa-square"></i></span></li>
                                    <li onclick="changeButtonColor('#0073b7')"><span class="fc-color" style="color: #0073b7"><i class="fa fa-square"></i></span></li>
                                    <li onclick="changeButtonColor('#3c8dbc')"><span class="fc-color" style="color: #3c8dbc"><i class="fa fa-square"></i></span></li>
                                    <li onclick="changeButtonColor('#39cccc')"><span class="fc-color" style="color: #39cccc"><i class="fa fa-square"></i></span></li>
                                    <li onclick="changeButtonColor('#f39c12')"><span class="fc-color" style="color: #f39c12"><i class="fa fa-square"></i></span></li>
                                    <li onclick="changeButtonColor('#ff851b')"><span class="fc-color" style="color: #ff851b"><i class="fa fa-square"></i></span></li>
                                    <li onclick="changeButtonColor('#00a65a')"><span class="fc-color" style="color: #00a65a"><i class="fa fa-square"></i></span></li>
                                    <li onclick="changeButtonColor('#01ff70')"><span class="fc-color" style="color: #01ff70"><i class="fa fa-square"></i></span></li>
                                    <li onclick="changeButtonColor('#dd4b39')"><span class="fc-color" style="color: #dd4b39"><i class="fa fa-square"></i></span></li>
                                    <li onclick="changeButtonColor('#605ca8')"><span class="fc-color" style="color: #605ca8"><i class="fa fa-square"></i></span></li>
                                    <li onclick="changeButtonColor('#f012be')"><span class="fc-color" style="color: #f012be"><i class="fa fa-square"></i></span></li>
                                    <li onclick="changeButtonColor('#777')"><span class="fc-color" style="color: #777"><i class="fa fa-square"></i></span></li>
                                    <li onclick="changeButtonColor('#001f3f')"><span class="fc-color" style="color: #001f3f"><i class="fa fa-square"></i></span></li>
                                </ul>
                                <div class="input-group">
                                    <!-- <input id="new-event" type="text" class="form-control" placeholder="Event Title"> -->
                                    <div class="input-group-btn mt-3">
                                        <button onclick="loadEntryModal('event')" id="add-new-event" type="button" class="btn btn-primary btn-flat btn-block">Add
                                        </button>
                                    </div>
                                    <!-- /btn-group -->
                                </div>
                            </div>
                        </div>

                        <!-- <div id='external-events' class="external-events">
                            <h4>Events</h4>
                            <div class='fc-event'>Launch</div>
                            <div class='fc-event'>Homework</div>
                            <div class='fc-event'>Sleep</div>
                            <div class='fc-event'>Home Coming</div>
                            <div class='fc-event'>Sleep Tight</div>
                        </div> -->
                        <div class="">
                                <!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
                            <div class="card">
                                <div class="card-header">
                                    <h5>Add Transaction Entry</h5>
                                </div>
                                <div class="card-body table-border-style">
                                    <button  type="button" class="btn btn-primary btn-block" onclick="loadEntryModal('entry')" >Add Entry
                                    </button>
                                </div>
                            </div>
                            <!-- /input-group -->
                        </div>
                    </div>
                    <div class="col-xl-8 col-md-8">
                        <div id='calendar' class='calendar'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade add-entry-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="new-entry-modal-title">Add Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form method="post" action="" id="ledger-entry-form">
                    {{ csrf_field() }}
                    <input type="hidden" name="pp" id="pp" value="0">
                    <div class="row">
                        <div class="col-md-6" id="trans-title-box">
                            <div class="form-group">
                                <label for="tt">Transaction Title</label>
                                <input type="text" class="form-control" name="TT" id="transaction-title" placeholder="Transaction Title" required>
                            </div>
                        </div>
                        <div class="col-md-6" id="tpartners-box">
                            <div class="form-group">
                                <label for="tt">Transaction Partner</label>
                                <select class="form-control" name="partner" id="transaction-partner" required>
                                    <option value="">--Select Transaction Partner--</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6" id="date-box">
                            <div class="form-group">
                                <label for="tt">Transaction Date</label>
                                <div class="input-group date" data-provide="datepicker">
                                    <input type="date" class="form-control " name="date"
                                           id="transaction-date" placeholder="Transaction Date" required>
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                                @if($errors->has('date'))
                                    <span>{{$errors->first('date')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6" id="trans-category-box" >
                            <div class="form-group">
                                <label for="account_id">Select Transaction Category</label>
                                <select name="account_id[]" id="transaction-category" class="form-control" onchange="getTransactionTypes()">
                                    <option value="" disabled="" selected="">-- Options --</option>
                                    @foreach($trans_categories as $trans_cat)
                                        <option value="{{$trans_cat->id}}">{{$trans_cat->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="trans-types-box" class="col-md-12">
                           {{-- <label for="TTN">Transaction Type Name</label>
                            <select class="form-control" id="TTN" name="TTN"
                                    data-live-search="true" required>
                            </select>--}}
                            <label for="account_id">Select Transaction Type</label>
                            <select name="" class="form-control" onchange="checkTransactionType()" id="trans-types">
                                <option value="" disabled="" selected="">-- Options --</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        
                    </div>
                   <div class="row vat_type" style="display:none;">
                        <div class="col-md-12">
                            <label for="vat_type">Select Vat Type</label>
                            <select class="form-control" id="vat_type" name="vat_type">
                                <option value="Inclusive">Inclusive</option>
                                <option value="Exclusive">Exclusive</option>
                            </select>
                        </div>
                    </div>   
                    <div id="product-box" style="display:none;">
                        <div class="row  mt-3">
                            <div class="col-md-6 " >
                                <label for="product">Select Product</label>
                                <select class="form-control" name="product" id="product-item" name="product"
                                        data-live-search="true" >
                                         <option value="" disabled="" selected="">-- Options --</option>
                                </select>
                            </div>
                            <div class="col-md-6" >
                                <label for="quantity_sold">Units sold</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" placeholder="Unit Sold" aria-label="Unit Sold" aria-describedby="basic-addon2" value="1" id="product-item-unit" min="0">
                                    <div class="input-group-append">
                                        <button class="btn  btn-primary" type="button" onclick="addProductItem()">Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div  id="service-box" style="display:none;">
                        <div class="row  mt-3">
                            <div class="col-md-12 " >
                                <label for="service">Select Service</label>
                                
                                <div class="input-group mb-3">
                                    <select class="form-control" id="service-item" name="service" data-live-search="true" >
                                        <option value="" disabled="" selected="">-- Options --</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn  btn-primary" type="button" onclick="addServiceItem()">Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="product-table" style="display:none;">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Unit Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="product-tbody">
                                    
                                        <!-- <tr>
                                           <td>#</td>
                                            <td>bag</td>
                                            <td>600</td>
                                            <td>vat</td>
                                            <td>del</td>
                                            
                                        </tr> -->
                                        
                                </tbody>
                                <tbody id="product-tbody-totals">
                                    <tr>
                                       <td colspan='3'></td>
                                        <td>Vat</td>
                                        <td id="product-vat-amount"></td>
                                    </tr>
                                    <tr>
                                       <td colspan='3'></td>
                                        <td>Total</td>
                                        <td id="product-total-amount"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6 amt" id="amt-box">
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="number" class="form-control money" id="trans-amount"  name="product_amount">
                            </div>
                        </div>
                        <div class="col-md-6" id="subaccount-box">
                            <div class="form-group">
                                <label>Asset Type</label>
                                <select class="form-control" name="subaccount" id="subaccount-item"
                                        data-live-search="true" >
                                         <option value="" disabled="" selected="">-- Options --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="dep-subaccount-box">
                            <div class="form-group">
                                <label>Asset Type</label>
                                <select class="form-control" name="subaccount" id="dep-subaccount-item"
                                        data-live-search="true" >
                                         <option value="" disabled="" selected="">-- Options --</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- <div class="col-md-6 amt" id="gross-box"  style="">
                            <div class="form-group">
                                <label for="gross">Gross Amount</label>
                                <input type="text" name="gross" id="gross" class="form-control money" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 amt" id="markup-box"  style="">
                            <div class="form-group">
                                <label for="markup">Markup</label>
                                <input type="text" name="markup"
                                       id="markup" class="form-control"
                                       readonly value="">
                            </div>
                        </div>
                        <div class="col-md-6 amt" id="vat-box" style="">
                            <label for="vat">VAT amount</label>
                            <input type="text" class="form-control money"
                                   id="vat" value="0" name="vat"
                                   readonly>
                        </div>
                        <div class="col-md-6 amt" id="net-box"  style="">
                            <label for="net">Net Amount</label>
                            <input type="text" class="form-control money"
                                   id="net" value="0" name="net"
                                   readonly>
                        </div> -->
                    </div>
                    <button type="button" id="add-entry" onclick="addEntry()" class="btn btn-primary float-right mt-4">Add Entry
                        <span id="add-entry-form-loader">
                            <div class="spinner-border spinner-border-sm"  role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade edit-sample-entry-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="new-entry-modal-title">Make Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form method="post" action="">
               {{ csrf_field() }}
                    <input type="hidden" name="pp" id="pp" value="0">
                    <div class="row">
                        <div class="col-md-6" id="trans-title-box">
                            <div class="form-group">
                                <label for="tt">Transaction Title</label>
                                <input type="text" class="form-control" name="TT" id="sp-transaction-title" placeholder="Transaction Title" required>
                            </div>
                        </div>
                        <div class="col-md-6" id="tpartners-box">
                            <div class="form-group">
                                <label for="tt">Transaction Partner</label>
                                <select class="form-control" name="partner" id="sp-transaction-partner" required>
                                    <option value="">--Select Transaction Partner--</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 amt" id="sp-amt-box">
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="number" class="form-control money" id="sp-trans-amount"  name="product_amount" required="">
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-sp-entry" onclick="addSpEntry()" class="btn btn-primary float-right mt-4">Add Entry
                        <span id="add-entry-form-loader">
                            <div class="spinner-border spinner-border-sm"  role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </span>
                        
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    #amt-box {
        display: none;
    }
    #subaccount-box{
        display: none;
    }
    #dep-subaccount-box{
        display: none;
    }
</style>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> -->
<!-- <script src="{{ asset('entry.js') }}"></script> -->
<script type="text/javascript">
// const token = <?php json_encode(Auth::user()->api_token); ?>

// $(document).ready(function(){
    // const axios = require('axios');

    //case 1: sales of good without tax
    // $("#cep").on("change", function() {
    //    alert(1);
    // });
    let sampleEntryButtonColor ='';
    let productTableCount = 0;
    let entryType = '';
    let productTableArray = [];
    let productTableVat = 0;
    let productTableTotal = 0;
    let productItemsArray = [];
    // var newEntryModalTitle = document.getElementById("new-entry-modal-title").innerHTML;
    var transTitleBox = document.getElementById("trans-title-box");
    var tpartnersBox = document.getElementById("tpartners-box");
    var transCatgeoryBox = document.getElementById("trans-category-box");
    var dateBox = document.getElementById("date-box");
    var productBox = document.getElementById("product-box");
    var serviceBox = document.getElementById("service-box");
    var amountBox = document.getElementById("amt-box");
    var subaccountBox = document.getElementById("subaccount-box");
    var depSubaccountBox = document.getElementById("dep-subaccount-box");
    var productTable = document.getElementById("product-table");
    let addEntryFormLoader = document.getElementById("add-entry-form-loader").style.display = "none";


    const loadEntryModal = (entry_type) => {
        entryType = entry_type;
        if(entryType === 'entry')
        {
            document.getElementById("new-entry-modal-title").innerHTML = 'Add Entry';
            tpartnersBox.style.display = 'block';
            dateBox.style.display = 'block';
            transCatgeoryBox.classList.remove('col-md-12')
            transTitleBox.classList.remove('col-md-12')
            console.log(entryType)
            $('.add-entry-modal').modal('show')
        }
        if(entryType === 'event')
        {
            document.getElementById("new-entry-modal-title").innerHTML = 'Add Transaction';
            tpartnersBox.style.display = 'none';
            dateBox.style.display = 'none';
            transTitleBox.classList.add('col-md-12')
            transCatgeoryBox.classList.add('col-md-12')
            console.log(entryType)
            $('.add-entry-modal').modal('show')
        }
    }
    const getTransactionTypes = () => {
        productTableArray =[]
        $("#product-tbody").empty();
        productBox.style.display = "none";

        serviceBox.style.display = "none";

        amountBox.style.display = "none";
        productTable.style.display = "none";
        subaccountBox.style.display = "none";


        let transactionCategoryId = document.getElementById("transaction-category").value;
        $.ajax({
          type: "GET",
          url: `{{ url('corpfin/api/transaction') }}/${transactionCategoryId}`,
          
          // dataType: "html",
          success: function (data) {
              var select = document.getElementById("trans-types"); 
            // Optional: Clear all existing options first:
            select.innerHTML = "";
            select.innerHTML += "<option value='' disabled='' selected=''>-- Options --</option>";
            // Populate list with options:
            for(var i = 0; i < data.length; i++) {
                var opt = data[i];
                select.innerHTML += "<option value=\"" + opt.id + "\">" + opt.name + "</option>";
            }
          }
      });
        
    }

    
    /**
     * @mejthod checkSubaccount
     * check id subaccount is a product or service 
     * to show product field or service field
     */
     const checkTransactionType = () => {
        transTypeId = JSON.parse(document.getElementById("trans-types").value);
        

        // var productTbody = document.getElementById("product-tbody");
        productTable.style.display = "none";
        productTableArray =[]
        $("#product-tbody").empty();
        // var productTbody = document.getElementById("product-tbody").empty();

        // transaction type == sales of goods without tax
        if (transTypeId === 1) {
            productBox.style.display = "block";
            getProducts({ id: transTypeId, taxes: 'none' })
            
        }else if (transTypeId === 3) {
            productBox.style.display = "block";
            getProducts({ id: transTypeId, markup: true })
            
        } else if (transTypeId === 5) {
            productBox.style.display = "block";
            getProducts({ id: transTypeId, taxes: 'vat' })
            
        } else {
            productBox.style.display = "none";
        }
        
        if (transTypeId === 2){
            serviceBox.style.display = "block";
            getServices({ id: transTypeId, taxes: 'both' })
        }  else if (transTypeId === 6){
            serviceBox.style.display = "block";
            getServices({ id: transTypeId, taxes: 'vat' })
        }  else  {
            serviceBox.style.display = "none";
        }
        if (
            transTypeId === 4 ||
            transTypeId === 9 ||
            transTypeId === 10 ||
            transTypeId === 11 ||
            transTypeId === 12 ||
            transTypeId === 13 ||
            transTypeId === 14 ||
            transTypeId === 15 ||
            transTypeId === 16 ||
            transTypeId === 17 ||
            transTypeId === 18 ||
            transTypeId === 19 ||
            transTypeId === 20 ||
            transTypeId === 21 ||
            transTypeId === 22 ||
            transTypeId === 23 ||
            transTypeId === 24 ||
            transTypeId === 25 ||
            transTypeId === 29 ||
            transTypeId === 30 ||
            transTypeId === 31 ||
            transTypeId === 35 ||
            transTypeId === 37 ||
            transTypeId === 38 ||
            transTypeId === 39 ||
            transTypeId === 40 ||
            transTypeId === 41 ||
            transTypeId === 42 ||
            transTypeId === 43 ||
            transTypeId === 44 ||
            transTypeId === 45 ||
            transTypeId === 46 ||
            transTypeId === 47 ||
            transTypeId === 48 ||
            transTypeId === 49 ||
            transTypeId === 50 ||
            transTypeId === 51 ||
            transTypeId === 52 ||
            transTypeId === 53 ||
            transTypeId === 55 ||
            transTypeId === 56 ||
            transTypeId === 76 ||
            transTypeId === 77 ||
            transTypeId === 78 ||
            transTypeId === 79 ||
            transTypeId === 80 ||
            transTypeId === 81 ||
            transTypeId === 82 ||
            transTypeId === 83 ||
            transTypeId === 84 ||
            transTypeId === 85 ||
            transTypeId === 86 ||
            transTypeId === 87 ||
            transTypeId === 88 ||
            transTypeId === 89 ||
            transTypeId === 90 ||
            transTypeId === 91 ||
            transTypeId === 92 ||
            transTypeId === 93 ||
            transTypeId === 94 ||
            transTypeId === 95 ||
            transTypeId === 96 ||
            transTypeId === 97 ||
            transTypeId === 98 ||
            transTypeId === 99 ||
            transTypeId === 100 ||
            transTypeId === 101 ||
            transTypeId === 102 ||
            transTypeId === 103 ||
            transTypeId === 104 ||
            transTypeId === 105 ||
            transTypeId === 106 ||
            transTypeId === 107 ||
            transTypeId === 108 ||

            transTypeId === 65 ||
            transTypeId === 67 ||
            transTypeId === 57 ||
            transTypeId === 71 ||
            transTypeId === 72 ||
            transTypeId === 73 ||
            transTypeId === 74 ||
            transTypeId === 75 ||
            transTypeId === 69 ||
            transTypeId === 68 ||
            transTypeId === 61 ||
            transTypeId === 62 ||
            transTypeId === 63 ||
            transTypeId === 59 ||
            transTypeId === 64 ||
            transTypeId === 60 ||
            transTypeId === 58 ||
            transTypeId === 66 


            ){
            document.getElementById("trans-amount").value ='';
            amountBox.style.display = "block";
        } else {
            amountBox.style.display = "none";

        }
        if (transTypeId === 97 || transTypeId === 87 || transTypeId === 23 || transTypeId === 24 || transTypeId === 25 || transTypeId === 17 || transTypeId === 18) {
            document.getElementById("trans-amount").value ='';
            
            subaccountBox.style.display = "block";
            getSubAccount();
            
        } else {
            subaccountBox.style.display = "none";
        }
        if( transTypeId === 22 ){
            depSubaccountBox.style.display = "block";
            getdepSubAccount();
        }else{
            depSubaccountBox.style.display = "none";
        }
     }

     /**
      * @method getProducts
      * get products 
      */
      const getProducts = (obj) =>
      {
        $.ajax({
          type: "POST",
          url: `{{ url('corpfin/api/product/filter') }}`,
          data :obj,
          dataType: 'json',// dataType: "html",
          success: function (data) {
            productItemsArray = data;
              var select = document.getElementById("product-item"); 
            
            select.innerHTML = "";
            select.innerHTML += "<option value='' disabled='' selected=''>-- Options --</option>";
            // Populate list with options:
            for(var i = 0; i < data.length; i++) {
                var opt = data[i];
                select.innerHTML += "<option value=\"" + opt.id + "\">" + opt.name + "</option>";
            }
          }
        });
      }

      /**
      * @method getProducts
      * get products 
      */
      const getSubAccount = () =>
      {
        let url;
        if(transTypeId == 22)
        {
            url = `{{ url('corpfin/get_depreciation_exp_sub_acct') }}`;
        }
        if(transTypeId == 87 || transTypeId === 17 || transTypeId === 18)
        {
            url = `{{ url('corpfin/get_asset_sub_acct') }}`;
        }
        if(transTypeId == 97 || transTypeId == 23 || transTypeId === 24 || transTypeId === 25)
        {
            url = `{{ url('corpfin/get_opex_sub_acct') }}`;
        }
        
        $.ajax({
          type: "GET",
          url: url,
          // data :obj,
          dataType: 'json',// dataType: "html",
          success: function (data) {
            productItemsArray = data;
              var select = document.getElementById("subaccount-item"); 
            
            select.innerHTML = "";
            select.innerHTML += "<option value='' disabled='' selected=''>-- Options --</option>";
            // Populate list with options:
            for(var i = 0; i < data.length; i++) {
                var opt = data[i];
                select.innerHTML += "<option value=\"" + opt.id + "\">" + opt.name + "</option>";
            }
          }
        });
      }
      /**
      * @method getdepSubAccount
      * get depreciation sub account 
      */
      const getdepSubAccount = () =>
      {
        let url;
        if(transTypeId == 22)
        {
            url = `{{ url('corpfin/get_depreciation_exp_sub_acct') }}`;
        }
        $.ajax({
          type: "GET",
          url: url,
          // data :obj,
          dataType: 'json',// dataType: "html",
          success: function (data) {
            productItemsArray = data;
              var select = document.getElementById("dep-subaccount-item"); 
            
            select.innerHTML = "";
            select.innerHTML += "<option value='' disabled='' selected=''>-- Options --</option>";
            // Populate list with options:
            for(var i = 0; i < data.length; i++) {
                var opt = data[i];
                select.innerHTML += "<option value=\"" + opt.asset_type_id + "\">" + opt.name + "</option>";
            }
          }
        });
      }

      /**
      * @method getServices
      * get products 
      */
      const getServices = (obj) =>
      {
        $.ajax({
          type: "POST",
          url: `{{ url('corpfin/api/service/filter') }}`,
          data :obj,
          dataType: 'json',// dataType: "html",
          success: function (data) {
            productItemsArray = data;
            // console.log(data)
              var select = document.getElementById("service-item"); 
            
            select.innerHTML = "";
            select.innerHTML += "<option value='' disabled='' selected=''>-- Options --</option>";
            // Populate list with options:
            for(var i = 0; i < data.length; i++) {
                var opt = data[i];
                select.innerHTML += "<option value=\"" + opt.id + "\">" + opt.name + "</option>";
            }
          }
        });
      }
    /**
      * @method addProductItem
      * add product to table
      */
    const addProductItem = () => {
        var productId = document.getElementById("product-item").value;
        if(!productId || productId ==0) return;
        let productItem;// = getProductFromProductArray(productId)
        // console.log(productItem)
        for(var i = 0; i < productItemsArray.length; i++) {
            // console.log(productItemsArray[i].id)
            // console.log(productId)
            if(productItemsArray[i].id == productId )
            {
                productItem = productItemsArray[i];
            }

            // return;
        }

        var productItemUnitValue = document.getElementById("product-item-unit").value;
        if(!productItemUnitValue)
        {
            productItemUnitValue = 1;
        }
        // var productTable = document.getElementById("product-table");
        var productTbody = document.getElementById("product-tbody");
        productTable.style.display = "block";
        var row = productTbody.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        var cell6 = row.insertCell(5);
        
        productTableCount = productTableCount + 1;
          cell1.innerHTML = productTableCount;
          cell2.innerHTML = productItem.name;
          cell3.innerHTML = productItem.price;
          cell4.innerHTML = productItemUnitValue;
          let total = parseFloat(productItem.price * productItemUnitValue).toFixed(2);
          cell5.innerHTML = total;
          cell6.innerHTML = "<button class='btn btn-danger' type='button' id='"+productItem.id+", this' onclick='removeProduct(this,"+productItem.id+")'>&times;</button>";
         productItem.total = total;
         productItem.qty = productItemUnitValue;
         productTableArray.push(productItem)
         calculateProductTotal()
        

    }

    // const clearProductTable = () => {
    //     var productTable = document.getElementById("product-table");
    //     var productTbody = document.getElementById("product-tbody");
    //     var new_tbody = document.createElement('tbody');
    //     populate_with_new_rows(productTbody);
    //     old_tbody.parentNode.replaceChild(new_tbody, old_tbody)
    // }
    /**
      * @method addProductItem
      * add product to table
      */
    const addServiceItem = () => {
        var serviceId = document.getElementById("service-item").value;
        if(!serviceId) return;
        
        let productItem;// = getProductFromProductArray(serviceId)
        // console.log(productItem)
        for(var i = 0; i < productItemsArray.length; i++) {
            // console.log(productItemsArray[i].id)
            // console.log(serviceId)
            if(productItemsArray[i].id == serviceId )
            {
                productItem = productItemsArray[i];
            }

            // return;
        }

        // var productItemUnitValue = document.getElementById("service-item-unit").value;
        // if(!productItemUnitValue)
        // {
            productItemUnitValue = 1;
        // }
        var productTable = document.getElementById("product-table");
        var productTbody = document.getElementById("product-tbody");
        productTable.style.display = "block";
        var row = productTbody.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        var cell6 = row.insertCell(5);
        
        productTableCount = productTableCount + 1;
          cell1.innerHTML = productTableCount;
          cell2.innerHTML = productItem.name;
          cell3.innerHTML = productItem.price;
          cell4.innerHTML = productItemUnitValue;
          let total = parseFloat(productItem.price * productItemUnitValue).toFixed(2);
          cell5.innerHTML = total;
          cell6.innerHTML = "<button class='btn btn-danger' type='button' id='"+productItem.id+", this' onclick='removeProduct(this,"+productItem.id+")'>&times;</button>";
         productItem.total = total;
         productItem.qty = productItemUnitValue;
         productTableArray.push(productItem)
         calculateProductTotal()
        

    }

     /**
     * @method addEntry
     *
     */
     const addEntry = () => {
        $( "#add-entry-form-loader" ).toggle();
        // let addEntryFormLoader = document.getElementById("add-entry-form-loader").style.display = "block";
        // if (transTypeId === 2){
        //     serviceBox.style.display = "block";
        // }
        let transactionTitle = document.getElementById("transaction-title").value;
        let transactionPartnerId = parseInt(document.getElementById("transaction-partner").value);
        let transactionDate = document.getElementById("transaction-date").value;
        let transactionCategoryId = parseInt(document.getElementById("transaction-category").value);
        let transactionTypeId = parseInt(document.getElementById("trans-types").value);
        let assetTypeId = parseInt(document.getElementById("subaccount-item").value);
        let depAssetTypeId = parseInt(document.getElementById("dep-subaccount-item").value);
        let data = {
                title: transactionTitle,
                transaction_category_id: transactionCategoryId,
                transaction_type_id: transactionTypeId,
                transaction_date: transactionDate,
                transaction_partner_id: transactionPartnerId,
            }
        // double entry
        // invoice sales of goods without tax
        
        if( transactionTypeId ===  1 || transactionTypeId ===  3 || transactionTypeId ===  5)
        {
            data.products= productTableArray
            // data.amount = productTableTotal;
        }
        // invoice sales of services without tax
        if( transactionTypeId ===  2 || transactionTypeId ===  6)
        {
            data.services= productTableArray
            //data.amount = productTableTotal;
        }
        //double entry
        // subaccount_type
        if( transactionTypeId ===  22)
        {
            data.asset_type = depAssetTypeId;
        }
        //Asset sub-account
        if( transactionTypeId ===  87 || transTypeId === 17 || transTypeId === 18)
        {
            data.asset_sub_acct = assetTypeId;
        }
        if( transactionTypeId ===  97 || transactionTypeId ===  23 || transactionTypeId ===  24 || transactionTypeId ===  25)
        {
            data.opex_sub_acct = assetTypeId
            // data.amount = productTableTotal;
        }
        if( 
            transactionTypeId ===  4 ||
            transactionTypeId ===  9 ||
            transactionTypeId ===  10 ||
            transactionTypeId ===  11 ||
            transactionTypeId ===  12 ||
            transactionTypeId ===  13 ||
            transactionTypeId ===  14 ||
            transactionTypeId ===  15 ||
            transactionTypeId ===  16 ||
            transactionTypeId ===  17 ||
            transactionTypeId ===  18 ||
            transactionTypeId ===  19 ||
            transactionTypeId ===  20 ||
            transactionTypeId ===  21 ||
            transactionTypeId === 22 ||
            transactionTypeId === 23 ||
            transactionTypeId === 24 ||
            transactionTypeId === 25 ||
            transactionTypeId === 29 ||
            transactionTypeId === 30 ||
            transactionTypeId === 31 ||
            transactionTypeId === 35 ||
            transactionTypeId === 37 ||
            transactionTypeId === 38 ||
            transactionTypeId === 39 ||
            transactionTypeId === 40 ||
            transactionTypeId === 41 ||
            transactionTypeId === 42 ||
            transactionTypeId === 43 ||
            transactionTypeId === 44 ||
            transactionTypeId === 45 ||
            transactionTypeId === 46 ||
            transactionTypeId === 47 ||
            transactionTypeId === 48 ||
            transactionTypeId === 49 ||
            transactionTypeId === 50 ||
            transactionTypeId === 51 ||
            transactionTypeId === 52 ||
            transactionTypeId === 53 ||
            transactionTypeId === 55 ||
            transactionTypeId === 56 ||
            transTypeId === 76 ||
            transTypeId === 77 ||
            transTypeId === 78 ||
            transTypeId === 79 ||
            transTypeId === 80 ||
            transTypeId === 81 ||
            transTypeId === 82 ||
            transTypeId === 83 ||
            transTypeId === 84 ||
            transTypeId === 85 ||
            transTypeId === 86 ||
            transTypeId === 87 ||
            transTypeId === 88 ||
            transTypeId === 89 ||
            transTypeId === 90 ||
            transTypeId === 91 ||
            transTypeId === 92 ||
            transTypeId === 93 ||
            transTypeId === 94 ||
            transTypeId === 95 ||
            transTypeId === 96 ||
            transTypeId === 97 ||
            transTypeId === 98 ||
            transTypeId === 99 ||
            transTypeId === 100 ||
            transTypeId === 101 ||
            transTypeId === 102 ||
            transTypeId === 103 ||
            transTypeId === 104 ||
            transTypeId === 105 ||
            transTypeId === 106 ||
            transTypeId === 107 ||
            transTypeId === 108 ||

            transTypeId === 65 ||
            transTypeId === 67 ||
            transTypeId === 57 ||
            transTypeId === 71 ||
            transTypeId === 72 ||
            transTypeId === 73 ||
            transTypeId === 74 ||
            transTypeId === 75 ||
            transTypeId === 69 ||
            transTypeId === 68 ||
            transTypeId === 61 ||
            transTypeId === 62 ||
            transTypeId === 63 ||
            transTypeId === 59 ||
            transTypeId === 64 ||
            transTypeId === 60 ||
            transTypeId === 58 ||
            transTypeId === 66 
            )
        {
            let transactionAmount = parseInt(document.getElementById("trans-amount").value);
            data.amount= transactionAmount
        }
        console.log(data);
        if(entryType === 'entry')
        {
            $.ajax({
                type: "POST",
                url: `{{ url('corpfin/addentry') }}`,
                data: data,
                
                // dataType: "html",
                success: function (data) {
                    console.log(data)
                    if(data.status =='ok')
                    {
                        var form = document.getElementById("ledger-entry-form");
                            form.reset();
                        swal(data.msg, {
                            icon: "success",
                        });
                        $('.add-entry-modal').modal('hide')

                    }else{
                        swal('Validation Error!! please all fields are required', {
                            icon: "error",
                        });
                    }
                    // return;
                    
                    //window.location.reload()
                    
                }
            });
        }
        if(entryType === 'event')
        {
            data['color'] = sampleEntryButtonColor? sampleEntryButtonColor : '#4680ff';
            $.ajax({
                type: "POST",
                url: `{{ url('corpfin/sample-entry') }}`,
                data: data,
                
                // dataType: "html",
                success: function (data) {
                    window.location.reload()
                }
            });
            console.log(entryType)
        }
    }
    /**
     * @method calculateProductTotal
     *
     */
     const calculateProductTotal = () => {
        productTableTotal = 0;
        for(var i = 0; i < productTableArray.length; i++) {
            productTableTotal += parseFloat(productTableArray[i].total);
            
        }
        document.getElementById("product-vat-amount").innerHTML = productTableVat.toFixed(2);
        document.getElementById("product-total-amount").innerHTML = productTableTotal.toFixed(2);
     } 
// });

    /**
      * @method removeProduct
      * remove product from table
      */
    const removeProduct = (r, productId) => {
        console.log(r)
        console.log(productId)
        // var i = r.parentNode.parentNode.rowIndex;
        // document.getElementById("product-tbody").deleteRow(i);
        var row = upTo(r, 'tr')

        for(var i = 0; i < productTableArray.length; i++) {
            console.log(productTableArray[i].id);
            if(productTableArray[i].id == productId )
            {
                // productItem = productTableArray[i];
                productTableArray.splice(i, 1);
            }

            // return;
        }
        if (row) row.parentNode.removeChild(row);
        calculateProductTotal()
    }

    //delete helper function
    function upTo(el, tagName) {
      tagName = tagName.toLowerCase();

      while (el && el.parentNode) {
        el = el.parentNode;
        if (el.tagName && el.tagName.toLowerCase() == tagName) {
            console.log(el)
          return el;
        }
      }
      return null;
    }    
    /**
     * @method changeButtonColor
     *
     */
    const changeButtonColor = (color) => {
        document.getElementById("add-new-event").style.backgroundColor = color;
        document.getElementById("add-new-event").style.borderColor = color;
        sampleEntryButtonColor = color;
        return false;
    }
    /**
     * @addEvent
     *
     */
    const addEvent = () => {
       /* let eventValue = document.getElementById("new-event").value;
        if (eventValue.length == 0) {
            return;
        }
        console.log(eventValue)*/
        console.log('eventValue')

    }

    /**
     * @method getProductFromProductArray
     *
     */
     const getProductFromProductArray = (productId) => {
                // console.log(productItemsArray)
                // console.log(productId)
        for(var i = 0; i < productItemsArray.length; i++) {
            console.log(productItemsArray[i].id)
            // console.log(productId)
            /*if(productItemsArray[i].id == productId )
            {
                console.log('match')
                console.log(productItemsArray[i])
                return productItemsArray[i]
            }
                console.log('no match')

            return;*/
        }
        /*var newArray = productItemsArray.filter(function (item) {
          if(item.id == productId){
            return item;
          }
        });*/
     } 
// });
</script>
<style type="text/css">
    .fc-color-picker{
        list-style: none; 
        margin: 0;
        padding: 0;
    }
    .fc-color-picker > li {
        float: left;
    }
    .fc-color{
        font-size: 30px;
        margin-right: 5px;
        line-height: 30px;
    }
</style>
@endsection
