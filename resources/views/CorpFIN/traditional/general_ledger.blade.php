@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
          <h5>Transaction Entries | General Ledger</h5>
          <span class="d-block m-t-5">Ledgers</span>
          <a href="" class="btn btn-success float-right " data-toggle="modal" data-target="#myModal">Add New Entry</a>
      </div>
      <div class="card-body">
        <div class="row center">
          <div class="col-md-11 col-md-offset-1">
              
          <form class="form-inline" action="#">
            {{csrf_field()}}
              <div class="form-group">
              <label>Account</label>
                  <select class="form-control" name="account_id">
                        <option value="all" id ="fil_acct_id" selected>All accounts</option>
                      @foreach(App\Account::all() as $account)
                          <option value="{{$account->id}}">{{$account->acct_name}}</option>
                      @endforeach
                  </select>
              </div>
              <div class="form-group">
                  <label for="tt">From</label>
                      <div class="input-group date" data-provide="datepicker">
                          <input type="text" class="form-control " name="from" id="fil_from" 
                                  placeholder="Transaction Date" value="{{date('m/1/Y')}}"  required>
                          <div class="input-group-addon">
                              <span class="glyphicon glyphicon-th"></span>
                          </div>
                      </div>
              </div>
              <div class="form-group">
                  <label for="tt">To</label>
                      <div class="input-group date" data-provide="datepicker">
                          <input type="text" class="form-control " name="to"
                                  placeholder="Transaction Date" id="fil_to" value="{{date('m/d/Y')}}" required>
                          <div class="input-group-addon">
                              <span class="glyphicon glyphicon-th"></span>
                          </div>
                      </div>
              </div>
              <button type="button" id="filter" class="btn btn-primary"><i class="fa fa-filter"></i></button>
          </form>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-striped table-hover">         
           <thead>
               <tr>
                   <th>Date</th>
                   <th>Description</th>
                   <th>Memo</th>
                   <th>Transaction</th>
                   <th>Balance</th>
               </tr>
               
           </thead>
           <tbody>
               <tr>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td>
                        <table class="table">
                            <thead><tr>
                                <th>Debit</th>
                                <th>Credit</th>
                            </tr></thead>
                        </table>

                   </td>
                   <td>
                        <table class="table">
                            <thead><tr>
                                <th>Debit</th>
                                <th>Credit</th>
                            </tr></thead>
                        </table>

                   </td>
               </tr>
               <tr>
                   <td></td>
                   <td></td>
                   <td>TOTAL</td>
                   <td>
                        <table class="table table-bordered">
                            <thead><tr>
                                <th class="success">{{number_format($debit_sum, 2)}}</th>
                                <th class="danger">{{number_format($credit_sum, 2)}}</th>
                            </tr></thead>
                        </table>

                   </td>
                   <td>
                        <table class="table">
                            <thead><tr>
                                <th class="info">{{number_format($debit_sum, 2)}}</th>
                                <th class="info">{{number_format($credit_sum, 2)}}</th>
                            </tr></thead>
                        </table>

                   </td>
               </tr>
               @foreach($ledgers as $ledger)
                 <tr>
                   <td>{{$ledger->date}}</td>
                   <td>{{$ledger->description}}</td>
                   <td>{{$ledger->acc_name}}</td>
                  
                   <td>
                        <table class="table table-bordered">
                            <tbody><tr>
                                <td class="success">N{{number_format($ledger->Dr, 2)}}</td>
                                <td class="danger">N{{number_format($ledger->Cr, 2)}}</td>
                            </tr></tbody>
                        </table>

                   </td>
                   <td>
                        <table class="table">
                            <tbody><tr>
                                 <?php?>   
                                <td class="info">N{{number_format($debit_sum -= $ledger->Dr, 2 )}}</td>
                                <td class="warning">N{{number_format($credit_sum -= $ledger->Cr, 2 )}}</td>
                            </tr></tbody>
                        </table>

                   </td>
               </tr>
               @endforeach
           </tbody>
       </table>
      </div>  
      </div>
    </div>
  </div>
</div>
 <!--Add new entry Modal -->
<div id="myModal" class="modal fade " role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add New Entry</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
             <form class="form-horizontal" action="{{url('')}}/corpfin/traditional/store_diary" method="post">
             {{csrf_field()}}
             <div id="entry_row">
                <div class="row">
                    <div class="col-md-6" >
                      <div class="form-group">
                        <label for="name">Name of Transaction</label>
                        <input type="text" name="name" class="form-control" required>
                      </div>
                        
                    </div>
                    <div class=" col-md-6" >
                      <div class="form-group">
                        <label for="date">Transaction Date</label>
                        <div class="input-group date" data-provide="datepicker">
                            <input type="text" class="form-control " name="date"
                                    placeholder="Transaction Date" required>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                      </div>
                        
                    </div>
                </div>
                <hr class="mt-5 mb-5">
                <p>Row 1</p>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="account_id">Select Account</label>
                      <select name="account_id[]" class="form-control">
                          @foreach(App\Account::all() as $account)
                            <option value="{{$account->id}}">{{$account->acct_name}}</option>
                          @endforeach 
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="account_id">Select Sub Account</label>
                      <select name="subaccount_id[]" class="form-control">
                          @foreach(App\SubAccount::all() as $subaccount)
                            <option value="{{$subaccount->id}}">{{$subaccount->name}}</option>
                          @endforeach 
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="debit">Debit</label>
                      <input type="text" name="debit[]" value="0.00" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="credit">Credit</label>
                      <input type="text" name="credit[]" value="0.00" class="form-control">
                    </div>
                </div>
                </div>
                <hr class="mt-5 mb-5">
                <p>Row 2</p>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="account_id">Select Account</label>
                      <select name="account_id[]" class="form-control">
                          @foreach(App\Account::all() as $account)
                            <option value="{{$account->id}}">{{$account->acct_name}}</option>
                          @endforeach 
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="account_id">Select Sub Account</label>
                      <select name="subaccount_id[]" class="form-control">
                          @foreach(App\Subaccount::all() as $subaccount)
                            <option value="{{$subaccount->id}}">{{$subaccount->name}}</option>
                          @endforeach 
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="debit">Debit</label>
                      <input type="text" name="debit[]" value="0.00" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    
                    <div class="form-group">
                      <label for="credit">Credit</label>
                      <input type="text" name="credit[]" value="0.00" class="form-control">
                    </div>
                </div>
                </div>
           </div>     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="add_row">Add Row</button>
        <button type="Submit" class="btn btn-success">Submit Entry</button>
         </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@if(session('status'))
<script type="text/javascript">
   Command: toastr["success"]("Entry added Successfully!")
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
<script src = {{asset('entry.js')}}></script>
<script>
$(document).ready(function(){

  //filter results 
    $("#filter").click(function(){

     var id =$("select[name=account_id]").val();
     var from = $("#fil_from").val();
     var to = $("#fil_to").val();

       window.location.href = '/corpfin/filter_ledger'+'?account='+id+'&from='+from+'&to='+to;
    });

    //$("#entryTable").load("entrytable.html")
    $("button").click(function(){
        $("p").slideToggle();
    });



    //dynamically add rows to the entry
      var counter =3;
      $("#add_row").click(function(){
        
        // $("#entry_row").append("");
        //   $("#entry_row").append("<div class='row'><div class='col-md-6'><div class = 'form-group'><label for='account_id[]'>Select Account</label><select class='form-control' name= 'account_id[]' id='account"+ counter +"'><option value='901290'>Select Account</option></select></div></div></div>");
           var rowdiv = document.createElement("div");
           var rowclass = document.createAttribute("class");
            rowclass.value = "row";
            rowdiv.setAttributeNode(rowclass);

           var par = document.createElement("p");
           var par_t = document.createTextNode('Row '+counter+'');
           par.appendChild(par_t);
           rowdiv.appendChild(par);

           var coldiv = document.createElement("div");
           var colclass = document.createAttribute("class");
           colclass.value = "col-md-6";
           coldiv.setAttributeNode(colclass);
           rowdiv.appendChild(coldiv);

           var formdiv = document.createElement("div");
           var formclass = document.createAttribute("class");
           formclass.value = "form-group";
           formdiv.setAttributeNode(formclass);
           coldiv.appendChild(formdiv);

           var label = document.createElement("label");
           var labelfor = document.createAttribute("for");
           labelfor.value = "account_id[]";
           var t = document.createTextNode("Select Account");
           label.appendChild(t);
           label.setAttributeNode(labelfor);
           formdiv.appendChild(label);

           var acct_sel = document.createElement("select");
           var selval = document.createAttribute("name");
           selval.value = "account_id[]";
           acct_sel.setAttributeNode(selval);

           var selclass = document.createAttribute("class");
           selclass.value = "form-control";
           acct_sel.setAttributeNode(selclass);
           formdiv.appendChild(acct_sel);
          //get accounts 
            $.ajax({
                  type: "GET",
                  url: "{{ url('') }}/corpfin/traditional/get_accounts" ,
                  
                  // dataType: "html",
                  success: function (data) {
                      
                     
                      for (var key in data) {
                          var opt = document.createElement('option');
                          opt.text = data[key].acct_name;
                          opt.value = data[key].id;
                          acct_sel.appendChild(opt);

                      }
                  }
              });
            
            //subvaccount
            

           var coldiv = document.createElement("div");
           var colclass = document.createAttribute("class");
           colclass.value = "col-md-6";
           coldiv.setAttributeNode(colclass);
           rowdiv.appendChild(coldiv);

           var formdiv = document.createElement("div");
           var formclass = document.createAttribute("class");
           formclass.value = "form-group";
           formdiv.setAttributeNode(formclass);
           coldiv.appendChild(formdiv);

           var label = document.createElement("label");
           var labelfor = document.createAttribute("for");
           labelfor.value = "subaccount_id[]";
           var t = document.createTextNode("Select Sub-Account");
           label.appendChild(t);
           label.setAttributeNode(labelfor);
           formdiv.appendChild(label);

           var subacct_sel = document.createElement("select");
           var subselval = document.createAttribute("name");
           subselval.value = "subaccount_id[]";
           subacct_sel.setAttributeNode(subselval);

           var selclass = document.createAttribute("class");
           selclass.value = "form-control";
           subacct_sel.setAttributeNode(selclass);
           formdiv.appendChild(subacct_sel);
          //get accounts 
            $.ajax({
                  type: "GET",
                  url: "{{ url('') }}/corpfin/traditional/get_subaccounts" ,
                  
                  // dataType: "html",
                  success: function (data) {
                      
                     
                      for (var key in data) {
                          var opt = document.createElement('option');
                          opt.text = data[key].name;
                          opt.value = data[key].id;
                          subacct_sel.appendChild(opt);

                      }
                  }
              });

            var entry_row = document.getElementById("entry_row");
            entry_row.appendChild(rowdiv);
            var x = document.createElement("HR");
            entry_row.appendChild(x);

            
          $("#entry_row").append("<div class='row'><div class='col-md-6'><div class = 'form-group'><label for='debit[]'>Debit</label><input type='text' name='debit[]' value='0.00' class='form-control'></div></div><div class='col-md-6'><div class = 'form-group'><label for='credit[]'>Credit</label><input type='text' name='credit[]' value='0.00' class='form-control'></div></div></div>");

            counter++;
      });


});


</script>
@endsection