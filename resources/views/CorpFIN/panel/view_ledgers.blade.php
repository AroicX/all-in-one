@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5>Manage Transaction Entries</h5>
            <span class="d-block m-t-5">Ledgers</span>
        </div>
        <div class="card-body table-border-style">
          <div class="box-header with-header">
             <div class="row center">
              <div class="col-md-11 col-md-offset-1">
                  
               <form class="form-inline" action="#">
                {{csrf_field()}}
                  <div class="form-group">
                  <label class="m-2">Account</label>
                      <select class="form-control" name="account_id">
                            <option value="all" id ="fil_acct_id" selected>All accounts</option>
                          @foreach(App\Account::all() as $account)
                              <option value="{{$account->id}}">{{$account->acct_name}}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="form-group">
                      <label class="m-2" for="tt">From</label>
                          <div class="input-group date" data-provide="datepicker">
                              <input type="date" class="form-control " name="from" id="fil_from" 
                                      placeholder="Transaction Date" value="{{date('m/1/Y')}}"  required>
                              <div class="input-group-addon">
                                  <span class="glyphicon glyphicon-th"></span>
                              </div>
                          </div>
                  </div>
                  <div class="form-group">
                      <label class="m-2" for="tt">To</label>
                          <div class="input-group date" data-provide="datepicker">
                              <input type="date" class="form-control " name="to"
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
         </div>
            <div class="table-responsive mt-5">
              <table class="table table-striped table-hover">
                 <div class="card-header">
                      <h5>General Ledger</h5>
                  </div>
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
                           <th>TOTAL</th>
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
                           <td>{{date('F d, Y ' , strtotime($ledger->date))}}</td>
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
                                    <tbody>
                                        <tr>
                                        <?php?>
                                        <td class="info">N{{number_format($debit_sum -= $ledger->Dr, 2 )}}</td>
                                        <td class="warning">N{{number_format($credit_sum -= $ledger->Cr, 2 )}}</td>
                                    </tr>
                                </tbody>
                                </table>
                           </td>
                       </tr>
                       @endforeach
                   </tbody>
               </table>
               <div class="pager">
                  {{ $ledgers->links() }}
                </div>
                @if(empty($ledgers))
                <td><p style="text-align:center;">No Ledger Added.
                        <a href="{{url('corpfin/addentry')}}"> Add Ledgera>
                    </p></td>
                @endif
            </div>
        </div>
      </div>
    </div>
  </div>
  
    <script>
          $(document).ready(function(){
     //filter results 
    $("#filter").click(function(){

     var id =$("select[name=account_id]").val();
     var from = $("#fil_from").val();
     var to = $("#fil_to").val();
    
       window.location.href = '/corpfin/filter_ledger'+'?account='+id+'&from='+from+'&to='+to;
    });
  });
    </script>
    <script src="{{asset('entry.js')}}"></script>
    @if(session('status'))
        <script>
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


@endsection
