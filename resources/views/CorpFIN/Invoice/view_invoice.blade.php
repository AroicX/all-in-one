@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
          <h5>{{$invoice->invoice_no }}</h5>
          <div class="float-right" >
                      <div class="btn-group" role="group" aria-label="...">
                                            
                     <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="caret"></span>
                          Options
                        </button>
                        <ul class="dropdown-menu">
                          <li>
                            <a href="{{url('')}}/corpfin/invoice/send-invoice/{{$invoice->id}}">
                              <i class="fa fa-download"></i>Send Qoute</a>
                          </li>
                          <li><a href="{{url('')}}/corpfin/invoice/pdf/{{$invoice->id}}" target="_blank"><i class="fa fa-download"></i>Download PDF</a></li>
                          <li><a href="#" data-toggle="modal" data-target="#payment_modal"><i class="fa fa-plus"></i>Add Tax</a></li>
                         @if($invoice->type == "invoice")
                          <!-- <li><a href="{{url('')}}/corpfin/invoice/email/{{$invoice->id}}"><i class="fa fa-send"></i>Email Invoice</a></li> -->
                          <li><a href="#" data-toggle="modal" data-target="#payment_modal"><i class="fa fa-credit-card"></i>Record Payment</a></li>
                          
                         @else
                           <!-- /<li><a href="{{url('')}}/corpfin/invoice/email/{{$invoice->id}}"><i class="fa fa-send"></i>Email Quote</a></li> -->
                           <li><a href="{{url('')}}/corpfin/invoice/convert/{{$invoice->id}}"><i class="fa fa-credit-card"></i>Convert to Invoice</a></li>
                          @endif
                           </ul>
                      </div>
                     </div>
               </div>
      </div>
      <div class="card-body table-border-style">
            <div class="row">
              <div class="col-md-4">
              <div class="panel panel-default" style="margin-top: 2%;">
                <div class="panel-heading">
                  Customer
                </div>
                <div class="panel-body">
                <?php $client = App\CorpFinTranPartner::find($invoice->client_id); ?>
                <h2 class="text-success">{{$client->name}}</h2>
                <h5>{{$client->address}}</h5>
                <?php $country = App\Country::find($client->country_id);
                      $state = App\State::find($client->state_id);
                 ?>
                 <h5>{{$state->name}}, {{$country->name}}</h5>
                 <hr>
                <p> {{$client->email}}
                <br> {{$client->tel}}</p>
                </div>
            </div>
          </div>
          <div class="col-md-8">
            <form id="invoice_details" method="post" action="{{url('')}}/corpfin/invoice/edit/{{$invoice->id}}">   
                                {{csrf_field()}}
            <div class="row">
              <div class="col-md-6">
               <div class="form-group">
                <label for="invoice_no">Invoice #</label>
                <input class="form-control" type="text" name="invoice_no" disabled="" value="{{$invoice->invoice_no}}">
               </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  
                <label for="status">Status (Can be changed)</label>
                <select class="form-control" name="status" id="status" >
                  <option selected value="{{$invoice->status}}">{{$invoice->status}}</option>
                  <option value="sent">Sent</option>
                  <option value="viewed">Viewed</option>
                  <option value="Paid">Paid</option>
                </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
               <div class="form-group">
                <label for="invoice_date">Invoice date</label>
                   <div class="input-group date" data-provide="datepicker">
                        <input type="text" name="invoice_date" id="invoice_date" 
                               value="{{date(' d-m-Y', strtotime($invoice->invoice_date))}}" class="form-control date" >
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
               </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  
                <label for="payment_method">Payment Method</label>
                <select class="form-control" name="payment_method" id="payment_method" >
                @if($invoice->payment_method !="")
                  <option selected value="{{$invoice->payment_method}}">{{$invoice->payment_method}}</option>
                @else
                  <option selected="" disabled="">Select Payment Method</option>
                @endif
                  <option value="Cash">Cash</option>
                  <option value="Debit/Credit Card">Debit/Credit Card</option>
                  <option value="Check">Check</option>
                </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
               <div class="form-group">
                <label for="due_date">Due date</label>
                   <div class="input-group date" data-provide="datepicker">
                        @if(!empty($invoice->date_sent))
                          <input type="text" name="due_date" id="due_date"
                               value="{{date('d-m-Y', strtotime($invoice->due_date))}}" class="form-control date" >
                        
                        @else
                        <input type="text" name="due_date" id="due_date"
                                class="form-control date" >
                        @endif
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
               </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  
                <label for="invoice_no">PDF password(optional)</label>
                <input type="text" name="password" id="password" value="{{$invoice->password}}" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
               <div class="form-group">
                <label for="due_date">Date Sent</label>
                   <div class="input-group date" data-provide="datepicker">
                        @if(!empty($invoice->date_sent))
                          <input type="text" name="date_sent" id="date_sent"
                               value="{{date('d-m-Y', strtotime($invoice->date_sent))}}" class="form-control date" >
                        
                        @else
                        <input type="text" name="date_sent" id="date_sent"
                                class="form-control date" >
                        @endif
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
               </div>
              </div>
              
            </div>
            <div class="col-md-6 col-md-offset-4">
               <div class="form-group">
                    <div class="btn-group" role="group" aria-label="...">
                    
                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Save Changes</button>
                  </div>
                 
               </div>
              </div>
            </form>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card-header">Invoice Products
              <div class="float-right">
                  <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-primary" onclick="addItemsModal()"><i class="fa fa-plus"></i> Add Items</button>
                    <button type="button" class="btn btn-primary ml-2" onclick="addTaxModal()"><i class="fa fa-plus"></i> Add Tax</button>
                  </div>
              </div>
            </div>
            <div class="card-body table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                  <th>Product Name</th>
                  <th>Quantity</th>
                  <th>Discount()</th>
                  <th>Vat()</th>
                  <th>Sub-Total()</th>
                  <th>Total</th>
                  <th>Remove</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($invoice_items as $inv_item)
                  <tr>

                    <td>
                      {{ ($inv_item->type == 'product' || $inv_item->type == 'service') ? $inv_item->item->name : $inv_item->description }}
                    </td>
                    <td>
                      @if($inv_item->type == 'product' || $inv_item->type == 'service')
                      <form class="qty" action="{{url('')}}/corpfin/invoice/product/edit" method="post"><div class="input-group">
                          {{csrf_field()}}
                          <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                          <input type="text" name="quantity"  class="form-control " value="{{$inv_item->quantity}}">
                          <input type="hidden" name="rowId" value="{{$inv_item->id}}">
                          <span class="input-group-btn">
                            <button class="btn btn-default " type="submit">Change</button>
                          </span>
                        </form> 
                      @endif
                    </td>
                    <td>{{ $inv_item->discount_percent }}</td>
                    <td>{{ number_format($inv_item->vat, 2)}}</td>
                    <td>{{ number_format($inv_item->sub_total, 2)}}</td>
                    <td>{{ number_format($inv_item->total, 2)}}</td>
                    <td><a href="/corpfin/invoice/product/remove/{{$inv_item->id}}?invoice_id={{$invoice->id}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-6">
            <table class="table table-bordered">
              <thead>
                  <tr>
                  <th>Title</th>
                  <th>Amount</th>
                  <th>Action</th>
                  </tr>
                </thead>
               @foreach($invoice_vat_items as $inv_vat_item)
               <tr>
                <td>{{ $inv_vat_item->description }}</td>
                <td id="inv-items-subtotal">{{ $inv_vat_item->total }}</td>
                <td>
                  <a href="/corpfin/invoice/product/remove/{{$inv_vat_item->id}}?invoice_id={{$invoice->id}}" class="btn btn-danger btn-sm">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
               @endforeach
               <tr><td>Item Tax</td><td id="inv-items-tax">N{{number_format($invoice->item_tax,2)}}</td></tr>
               <tr><td id="inv-tax">Invoice Tax</td><td>N{{number_format($invoice->invoice_tax,2)}}</td></tr>
              </form>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table table-bordered">
               <tr><td>Subtotal</td><td id="inv-items-subtotal">N{{number_format($invoice->subtotal,2)}}</td></tr>
               <tr><td>Item Tax</td><td id="inv-items-tax">N{{number_format($invoice->item_tax,2)}}</td></tr>
               <tr><td id="inv-tax">Invoice Tax</td><td>N{{number_format($invoice->invoice_tax,2)}}</td></tr>
               <tr><td>Discount</td>
               <form action="{{url('')}}/corpfin/invoice/discount/edit" method="post">
               {{csrf_field()}}
               <input type="hidden" name="invoice_id", value="{{$invoice->id}}">
               <td>
                  <div class="row">
                    <div class="col-md-6">
                       <div class="input-group">
                      <span class="input-group-addon" id="basic-addon1">%</span>
                      <input type="text" name="discount_percent" id="discount_percent" class="form-control" value="{{number_format($invoice->discount_percent,2)}}" aria-describedby="basic-addon1">
                      @if($errors->has('discount_percent'))
                      <span>{{$errors->first('discount_percent')}}</span>
                      @endif
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="input-group">
                      <span class="input-group-addon" id="basic-addon1">N</span>
                      <input type="text" class="form-control" name="discount_amount" id="discount_amount" value="{{number_format($invoice->discount_amount,2)}}" aria-describedby="basic-addon1">
                      @if($errors->has('discount_amount'))
                      <span>{{$errors->first('amount')}}</span>
                      @endif
                      </div>
                    </div>
                  </div>
                </td>

                </tr>
               <tr><td>Total</td>
               @if($invoice->total > 0)
               <td>{{number_format($invoice->total, 2)}}</td>
               @else
               <td>N{{Cart::total()}}</td>
               @endif

               </tr>
               <tr><td>Paid</td><td>N{{number_format($invoice->paid,2)}}</td></tr>
               <tr><th>Balance</th><th>N{{number_format($invoice->total - $invoice->paid,2)}}</th></tr>
               <tr><td></td><td> <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Save Changes</button></td></tr>
             
              </form>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog  modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="inv-item-modal-title">Add Invoice Items</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div>
          <div class="">
            <form>
              <div class="row">
                <div class="col-md-3" id="inv-items-options-box">
                  <label>Type</label>
                  <select class="form-control" id="invoice-item-option" name="service" data-live-search="true" required="" onchange="checkInvItemOption()">
                      <option value="" selected="" disabled=""> -- Option --</option>
                      <option value="product">Product</option>
                      <option value="service">Service</option>
                      <option value="vat">Tax</option>
                  </select>
                </div>
                <div class="col-md-7">
                  <div class="row" id="inv-items-box">
                    <div class="col-md-3">
                      <div class="form-group">
                         <label>Quantity</label>
                          <input type="number" class="form-control" value="1" name="qty" id="inv-qty" required="">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                         <label>Discount (%)</label>
                          <input type="number" class="form-control" name="qty" value="0" id="inv-discount" required="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label>Item</label>
                      <div class="form-group mb-3">
                          <input type="text" class="form-control" name="name" id="name_input" list="huge_list" required="">
                          <div class="input-group-append">
                              
                          </div>
                      </div>
                      <datalist id="huge_list">
                        </datalist>
                        <br/>
                    </div>
                  </div>
                  <div  class="row" id="inv-tax-box" style="display: none;">
                  <div class="col-md-6">
                    <div class="form-group">
                       <label>Title</label>
                        <input type="text" class="form-control" name="inv-item-title" id="inv-item-title" required="">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                       <label>Tax (%)</label>
                        <input type="number" class="form-control" name="inv-item-tax-percent" value="0" id="inv-item-tax-percent" required="">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                       <label>Tax (N)</label>
                        <input type="number" class="form-control" name="inv-item-tax-percent" value="0" id="inv-item-tax-amount" required="">
                    </div>
                  </div>
                </div>
                </div>
                
                <div class="col-md-1">
                  <button type="button" class="btn btn-primary mt-4"  onclick="selected_product()">Add</button>
                </div>
              </div>
            </form>
          </div>
            <div class="col-md-12">
              <table class="table table-striped">
                <thead>
                  <tr>
                  <th>Product Name</th>
                  <th>Quantity</th>
                  <th>Discount</th>
                  <th>Total</th>
                  <th>Remove</th>
                  </tr>
                </thead>
                <tbody id="inv-table-tbody">
                  @foreach(Cart::instance($invoice->id)->content() as $cart_product)
                  <tr>
                    <td>{{$cart_product->name}}</td>
                    <td><form class="qty" action="{{url('')}}/corpfin/invoice/product/edit" method="post"><div class="input-group">
                          {{csrf_field()}}
                          <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                          <input type="text" name="quantity"  class="form-control " value="{{$cart_product->qty}}">
                          <input type="hidden" name="rowId" value="{{$cart_product->rowId}}">
                          <span class="input-group-btn">
                            <button class="btn btn-default " type="submit">Change</button>
                          </span></form> 
                        </div>
                    </td>
                    <td>{{number_format($cart_product->total, 2)}}</td>
                    <td><a href="/corpfin/invoice/product/remove/{{$cart_product->rowId}}?invoice_id={{$invoice->id}}" class="btn btn-danger "><i class="fa fa-trash"></i></a></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
                <!-- <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Product Namde</th>
                      <th>Product Price</th>
                    </tr>
                  </thead>
                  <tbody>
                  <form id="product-form" action="{{url('corpfin/invoice/product/add')}}" method="post">
                  <input type="hidden" name="id" value="{{$invoice->id}}">
                    {{csrf_field()}}
                    @foreach($products as $product)
                      <tr>
                        <td><input type="checkbox" value="{{$product->id}}" name="product_id[]" /></td>
                        <td>{{$product->name}}</td>
                        <td>N{{$product->price}}</td>
                      </tr>
                    @endforeach
                   
                  </tbody>
                </table> -->
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success " id="add-inv-item-btn" onclick="addInvItems({{$invoice->id }})">Add Products</button>
        
                  </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- end product modal -->

<!-- Modal -->
<div id="payment_modal" class="modal fade" role="dialog">
  <div class="modal-dialog  modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
    <form class= "form-horizontal" method="post" action="{{url('')}}/corpfin/invoice/payment/add">
                
      <div class="modal-header">
        <h4 class="modal-title">Record Payment</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                   {{csrf_field()}}
                   <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                    <div class="row">
                      <div class="col-md-10 col-md-offset-1">
                        <label>Amount Paid</label>
                        <input type="text" name="amount" placeholder="0.00" class="form-control" required>
                        @if($errors->has('amount'))
                          <SPAN>{{$errors->first('amount')}}</SPAN>
                        @endif
                      </div>
                      <div class="col-md-10 col-md-offset-1">
                        <label>Payment Method</label>
                          <select class="form-control" name="payment_method" id="payment_method" required>
                          @if($invoice->payment_method !="")
                            <option selected value="{{$invoice->payment_method}}">{{$invoice->payment_method}}</option>
                          @else
                            <option selected="" disabled="">Select Payment Method</option>
                          @endif
                            <option value="Cash">Cash</option>
                            <option value="Debit/Credit Card">Debit/Credit Card</option>
                            <option value="Check">Check</option>
                          </select>
                      </div>
                      <div class="col-md-10 col-md-offset-1">
                      <label>Payment Date</label>
                        <div class="input-group date" data-provide="datepicker">
                            
                            <input type="text" name="payment_date" 
                                    class="form-control date" >
                           
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                      </div>
                     
                    </div>
                
            </div>
        </div>
      </div>
      <div class="modal-footer">
        
        
                   <button type="submit" class="btn">submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>
<!-- end tax modal -->

<!-- Modal -->
<div id="payment_modal" class="modal fade" role="dialog">
  <div class="modal-dialog  modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
    <form class= "form-horizontal" method="post" action="{{url('')}}/corpfin/invoice/payment/add">
                
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Tax</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                   {{csrf_field()}}
                   <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                    <div class="row">

                      <div class="col-md-10 col-md-offset-1">
                        <label>Payment Method</label>
                          <select class="form-control" name="payment_method" id="payment_method" required>
                            <option value="5">5.00%</option>
                            <option value="4">4.00%</option>
                            <option value="3">3.00%</option>
                            <option></option>
                          </select>
                      </div>
                     
                    </div>
                
            </div>
        </div>
      </div>
      <div class="modal-footer">
        
        
                   <button type="submit" class="btn">submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>
<script type="text/javascript">

   

  window.addEventListener("load", function(){

    // Add a keyup event listener to our input element
    var name_input = document.getElementById('name_input');

    name_input.addEventListener("keyup", function(event){hinter(event)});

    
    var invItemTaxPercent = document.getElementById('inv-item-tax-percent');
    var invItemTaxAmount = document.getElementById('inv-item-tax-amount');
    invItemTaxPercent.addEventListener("keyup", function(event){
      var taxPercent = event.target;
      if (taxPercent.value <= 0 ) { 
          invItemTaxAmount.disabled = false;
          return;
      }else{
        invItemTaxAmount.disabled = true;
      }
    });
    invItemTaxAmount.addEventListener("keyup", function(event){
      var taxAmount = event.target;
      if (taxAmount.value <= 0 ) { 
        invItemTaxPercent.disabled = false;
          return;
      }else{
        invItemTaxPercent.disabled = true;
      }
    });

    // create one global XHR object 
    // so we can abort old requests when a new one is make
    window.hinterXHR = new XMLHttpRequest();
});

// Autocomplete for form
function hinter(event) {

    // retireve the input element
    var input = event.target;

    // retrieve the datalist element
    var huge_list = document.getElementById('huge_list');
    var invItemOption = document.getElementById('invoice-item-option').value;
    let url = '';
    // minimum number of characters before we start to generate suggestions
    var min_characters = 0;

    if (input.value.length < min_characters ) { 
        return;
    } else { 
        if(invItemOption == 'product'){
          url = `${api}/corpfin/api/product/query/${input.value}`;
        }else if(invItemOption == 'service'){
          url = `${api}/corpfin/api/service/query/${input.value}`;
        }

        // abort any pending requests
        window.hinterXHR.abort();

        window.hinterXHR.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // We're expecting a json response so we convert it to an object
                var response = JSON.parse( this.responseText ); 

                // clear any previously loaded options in the datalist
                huge_list.innerHTML = "";

                response.forEach(function(item) {
                    // Create a new <option> element.
                    var option = document.createElement('option');
                    option.value = item.name;

                    // attach the option to the datalist element
                    huge_list.appendChild(option);
                });
             
            }
        };
        console.log(url)
        // window.hinterXHR.open("GET", "/query.php?query=" + input.value, true);
        window.hinterXHR.open("GET", url, true);
        window.hinterXHR.send()
    }
}

function validateForm(){

    // Get the input element
    var input = document.getElementById('name_input');
    var invItemOption = document.getElementById('invoice-item-option');
    // Get the datalist
    var huge_list = document.getElementById('huge_list');


    // If we find the input inside our list, we submit the form
    for (var element of huge_list.children) {
        if(element.value == input.value) {
            return true;
        }
    }

    // we send an error message
    alert("name input is invalid")
    return false;
}

var invItemOption = document.getElementById('invoice-item-option').value;
var invItemBox = document.getElementById('inv-items-box');
var invTaxBox = document.getElementById('inv-tax-box');
var invModalTitle = document.getElementById('inv-item-modal-title');
var invItemOptionBox = document.getElementById('inv-items-options-box');

const addItemsModal = () => {
  invModalTitle.innerHTML = "Add Invoice Items"
    invItemBox.style.display = 'flex';
    invTaxBox.style.display = 'none';
    invItemOptionBox.style.display = 'block';
  $("#myModal").modal('show');
}
const addTaxModal = () => {
  document.getElementById('invoice-item-option').value = 'vat';
  invModalTitle.innerHTML = "Add Invoice Tax";
  invItemBox.style.display = 'none';
  invTaxBox.style.display = 'flex';
  invItemOptionBox.style.display = 'none';
  $("#myModal").modal('show');
}
const checkInvItemOption = () => {
  
  console.log(invItemOption)
  if(invItemOption == 'vat')
  {
    invItemBox.style.display = 'none';
    invTaxBox.style.display = 'flex';
  }else{
    invItemBox.style.display = 'flex';
    invTaxBox.style.display = 'none';
  }
}

let invTableArray = [];

const selected_product = () => {
    var invQty = document.getElementById('inv-qty').value;
    var invDiscount = document.getElementById('inv-discount').value;
    var value = document.getElementById('name_input').value;
    var huge_list = document.getElementById('huge_list').innerHTML = "";
    var invItemOption = document.getElementById('invoice-item-option').value;
    console.log(invItemOption)
  if(invItemOption.length <1)
  {
    alert("Options is invalid")
    return;
  }
  if(invItemOption == 'vat')
  {
    /*if(invTableArray == undefined || invTableArray.length == 0)
    {
      alert("You must add a product or service be for adding tax");
      return;
    }*/
    var invItemTitle = document.getElementById('inv-item-title').value;
    var invItemTaxPercent = document.getElementById('inv-item-tax-percent').value;
    var invItemTaxAmount = document.getElementById('inv-item-tax-amount').value;
    let invoiceItem = {};
    invoiceItem.type = 'vat';
    invoiceItem.name = invItemTitle;
    invoiceItem.vat_percent = invItemTaxPercent;
    invoiceItem.vat_amount = invItemTaxAmount;
    let total=0;
    if(invItemTaxPercent >0)
    {
      invoiceItem.total = invItemTaxPercent+'%';
    }else{
      invoiceItem.total = invItemTaxAmount;
    }
    
    var productTableCount = 0;
        var productTbody = document.getElementById("inv-table-tbody");
        var row = productTbody.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        // var cell5 = row.insertCell(4);
        // var cell6 = row.insertCell(5);
        productTableCount = productTableCount + 1;
        // cell1.innerHTML = productTableCount;
        cell1.innerHTML = invoiceItem.name;
        // cell3.innerHTML = invoiceItem.price;
        cell2.innerHTML = 0;
        invoiceItem.id = 'v'+productTableCount
        cell3.innerHTML = 0;
        cell4.innerHTML = invoiceItem.total;
        cell5.innerHTML = "<button class='btn btn-danger btn-sm' type='button' id='"+invoiceItem.id+", this' onclick='removeProduct(this,\""+invoiceItem.id+"\", \""+invoiceItem.type+"\")'>&times;</button>";
       
        invTableArray.push(invoiceItem)
        document.getElementById('inv-item-title').value = '';
        document.getElementById('inv-item-tax-percent').value = 0;
        document.getElementById('inv-item-tax-amount').value = 0;

         calculateInvoiceTotal()
    console.log(invoiceItem)
    return;
  }

  if(value.length <1)
  {
    alert("name input is invalid")
    return;
  }
  if(!invQty)
  {
      invQty = 1;
  }
  if(invItemOption == 'product'){
    $.ajax({
      type: "GET",
      url: `${api}/corpfin/api/product/name?name=${value}`,
      // data :obj,
      dataType: 'json',// dataType: "html",
      success: function (data) {
        console.log(data.status)
        if(data.status != 'ok')
        {
          new PNotify.alert({
              title: 'Error notice',
              text: 'no product with this name exist',
              type: 'error'
          });
          return 
        }
        let invoiceItem = data.data
        invoiceItem.type = 'product';
        // var productTable = document.getElementById("inv-items-table");
        var productTableCount = 0;
        var productTbody = document.getElementById("inv-table-tbody");
        var row = productTbody.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        // var cell5 = row.insertCell(4);
        // var cell6 = row.insertCell(5);
        productTableCount = productTableCount + 1;
        // cell1.innerHTML = productTableCount;
        cell1.innerHTML = invoiceItem.name;
        // cell3.innerHTML = invoiceItem.price;
        cell2.innerHTML = invQty;
        let total = parseFloat(invoiceItem.price * invQty).toFixed(2);
        if(invDiscount > 0)
        {
          total = total - calculate_percentage(invDiscount, total)
        }else{
          invDiscount = 0;
        }
        cell3.innerHTML = invDiscount;
        cell4.innerHTML = total;
        cell5.innerHTML = "<button class='btn btn-danger btn-sm' type='button' id='"+invoiceItem.id+", this' onclick='removeProduct(this,"+invoiceItem.id+", \""+invoiceItem.type+"\")'>&times;</button>";
        invoiceItem.total = total;
        invoiceItem.qty = invQty;
        invoiceItem.discount_percent = invDiscount;
       
        invTableArray.push(invoiceItem)
        document.getElementById('name_input').value = '';

         calculateInvoiceTotal()
      },
      error: function(error){
        console.log(error)
        new PNotify.alert({
            title: 'Server error',
            text: 'Contact admin',
            type: 'error'
        });
      }

    });
  }else if(invItemOption == 'service'){
   $.ajax({
      type: "GET",
      url: `${api}/corpfin/api/service/name?name=${value}`,
      // data :obj,
      dataType: 'json',// dataType: "html",
      success: function (data) {
        if(data.status != 'ok')
        {
          new PNotify.alert({
              title: 'Error notice',
              text: 'no Service with this name exist',
              type: 'error'
          });
          return 
        }
        let invoiceItem = data.data
        invoiceItem.type = 'service';
        // var productTable = document.getElementById("inv-items-table");
        var productTableCount = 0;
        var productTbody = document.getElementById("inv-table-tbody");
        var row = productTbody.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        // var cell5 = row.insertCell(4);
        // var cell6 = row.insertCell(5);
        
        productTableCount = productTableCount + 1;
          // cell1.innerHTML = productTableCount;
        cell1.innerHTML = invoiceItem.name;
        // cell3.innerHTML = invoiceItem.price;
        cell2.innerHTML = invQty;
        cell3.innerHTML = invDiscount;
        let total = parseFloat(invoiceItem.price * invQty).toFixed(2);
        if(invDiscount > 0)
        {
          total = total - calculate_percentage(invDiscount, total)
        }else{
          invDiscount = 0;
        }
        cell4.innerHTML = total;
        cell5.innerHTML = "<button class='btn btn-danger btn-sm' type='button' id='"+invoiceItem.id+", this' onclick='removeProduct(this,"+invoiceItem.id+", \""+invoiceItem.type+"\")'>&times;</button>";
        
        invoiceItem.total = total;
        invoiceItem.qty = invQty;
        invoiceItem.discount_percent = invDiscount;
        invTableArray.push(invoiceItem)
        document.getElementById('name_input').value = '';

         calculateInvoiceTotal()
      },
      error: function(error){
        console.log(error)
        new PNotify.alert({
            title: 'Server error',
            text: 'Contact admin',
            type: 'error'
        });
      }

    });
  } 
    document.getElementById('inv-qty').value = '';
    document.getElementById('inv-discount').value = '';
    document.getElementById('invoice-item-option').value = '';

}
/**
 * @method calculate_percentage
 *
 *
 */
 const calculate_percentage = (percent, amount) => (percent/100) * amount
/**
      * @method removeProduct
      * remove product from table
      */
    const removeProduct = (r, productId, type) => {
        var row = upTo(r, 'tr')

        for(var i = 0; i < invTableArray.length; i++) {
            console.log(type);
            if(invTableArray[i].id == productId && invTableArray[i].type == type )
            {
                // productItem = invTableArray[i];
                invTableArray.splice(i, 1);
            }

            // return;
        }
        if (row) row.parentNode.removeChild(row);
         calculateInvoiceTotal()
    }

    //delete helper function
    function upTo(el, tagName) {
      tagName = tagName.toLowerCase();

      while (el && el.parentNode) {
        el = el.parentNode;
        if (el.tagName && el.tagName.toLowerCase() == tagName) {
          return el;
        }
      }
      return null;
    }  
    /**
     * @method calculateInvoiceTotal
     *
     */
     const calculateInvoiceTotal = () => {
        subTotal = 0;
        invBalance = 0;
        invTotal = 0;
        itemTax = 0;
        invTax = 0;
        for(var i = 0; i < invTableArray.length; i++) {
            subTotal += parseFloat(invTableArray[i].total);
            
        }
        // document.getElementById("product-vat-amount").innerHTML = productTableVat.toFixed(2);
        document.getElementById("inv-items-subtotal").innerHTML = subTotal.toFixed(2);
     } 
     /**
      * @method addInvItems
      * save invoice items
      *
      **/
     const addInvItems = (invoice_id) => {

      let data = {
        invoice_id: invoice_id,
        items: invTableArray
      }
      console.log(data)
      var invItemBtn = document.getElementById('add-inv-item-btn')
      invItemBtn.disabled = true;
      $.ajax({
        type: "POST",
        url: `${api}/corpfin/invoice/quote-items/add`,
        data: data,
        dataType: 'json',// dataType: "html",
        success: function (data) {
          console.log(data)
          if(data.status == 'ok')
          {
            new PNotify.alert({
              title: 'Operation Successful',
              text: data.msg,
              type: 'success'
            });
          window.location.reload();
          return;
          }
          new PNotify.alert({
              title: 'Operation Successful',
              text: data.msg,
              type: 'error'
            });
          return;
        },
        error: function(error){
          new PNotify.alert({
              title: 'Server error',
              text: 'contact admin',
              type: 'error'
          });
        }

      });
      invItemBtn.disabled = false;

     }
</script>
<script type="text/javascript">
    /*$(".date").datepicker({ 
         format:'dd-mm-yyyy',
  defaultDate:  "0d",
  maxDate: 0,
  minDate: new Date(01, 01, 2000)
});*/

    //add products to invoice
    /*$("#product-form").submit(function(e){
      e.preventDefault();
       var data = $(this).serializeArray();
       $.ajax({
          type : "post",
          url : "{{url('')}}/corpfin/invoice/product/add",
          dataType : "html",
          data : data,
          success : function(data){
            console.log(data);
            window.location = "{{url('')}}/corpfin/invoice/view/{{$invoice->id}}";
          }

       });
    });*/


 

    //reload page with changes made
    $(".reload").click(function(e){
      e.preventDefault();
       window.location = "{{url('')}}/corpfin/invoice/view/{{$invoice->id}}";
    });

   
    $(document).ready(function(){

     //ensure that both fields correspond
   if($("#discount_amount").val() > 0){
    
      $("#discount_percent").attr("disabled", true);
   }
   else{
      $("#discount_percent").attr("disabled", false);
   }

   if ($("#discount_percent").val() > 0) {
       $("#discount_amount").attr("disabled", true);
   }
   else{
       $("#discount_amount").attr("disabled", false);
   }

   
    $("#discount_amount").change(function(){

      if($(this).val() > 0 ){
    
      $("#discount_percent").attr("disabled", true);
       }
       else{

          $("#discount_percent").attr("disabled", false);
       }
       });

   $("#discount_percent").change(function(){
        if($(this).val() > 0){
    
      $("#discount_amount").attr("disabled", true);
   }
   else{
      $("#discount_amount").attr("disabled", false);
   }
   });
 });

  

</script>
@if(session('status'))
  <script type="text/javascript">
        Command: toastr["success"]("Saved!")
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
  </script>

@endif

@if($errors->has('amount'))
  <script type="text/javascript">
    $('payment_modal').modal();
  </script>
@endif
@endsection