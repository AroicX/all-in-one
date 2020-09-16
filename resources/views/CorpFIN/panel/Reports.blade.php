@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Generate Report</h5>
                <span class="d-block m-t-5">Reports</span>
            </div>
            <div class="card-body">
              <div class="row">
                  <div class="col-sm-4" style="    text-align: center;">
                        <span class="step size-96 ">
                        <a href="javascript:void(0)" url="{{ url('corpfin/reports/balance_sheet') }}" onclick="loadReportModal('balance_sheet')">
                          <i class="fas fa-book balancesheet" style="font-size: 150px"></i>
                        </a>
                      </span>
                       <p class="mt-3 balancesheet_text"> Balance Sheet (SOFP)</p>
                  </div>
                  <div class="col-sm-4" style="    text-align: center;">
                    <span class="step size-96">
                    <a  href="javascript:void(0)" onclick="loadReportModal('income_statement')" url="{{ url('corpfin/reports/profit_loss') }}" data-toggle="modal" data-target="#continue-modal">
                            <i class="fas fa-clipboard income-statement" style="font-size: 150px"></i>
                    </a>
                      </span>
                       <p class="mt-3 income-statement_text"> Income Statement(SOPOLOCI)</p>
                  </div>
                  <div class="col-sm-4" style="    text-align: center;">
                            <span class="step size-96">
                            <a href="javascript:void(0)" onclick="loadReportModal('asset_register')" url="{{ url('corpfin/reports/profit-loss') }}">
                                 <i class="fas fa-money-check-alt profit-loss" style="font-size: 150px"></i>
                            </a>
                      </span>
                       <p class="mt-3 profit-loss_text"> Fixed Asset Register</p>
                  </div>
                  <div class="col-sm-4" style="    text-align: center;">
                            <span class="step size-96">
                            <a href="javascript:void(0)" onclick="loadReportModal('trial_balance')" url="{{ url('corpfin/reports/trial_balance') }}">
                                 <i class="fas fa-book-open profit-loss" style="font-size: 150px"></i>
                            </a>
                      </span>
                       <p class="mt-3 profit-loss_text"> Trial Balance</p>
                  </div> 
              </div>
            </div>
        </div>
    </div>

<div id="continue-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Return to supplier</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <form>
              <div class="form-group" style="padding:30px;">
                <div class="input-group" >
                  <span class="input-group-addon" id="basic-addon1"><strong>From</strong></span>
                    <input type="date" class="form-control" value="<?= date('Y'); ?>-<?= $month; ?>-<?= $day; ?>" id="start_date">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                  <span class="input-group-addon" id="basic-addon1"><strong>To</strong></span>
                    <input type="date" class="form-control" value="<?= date('Y-m-d') ?>" id="end_date">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
                <br>
                <button type="button" class="btn btn-success btn-flat" id="proceed" onclick="generateReport()">Proceed</button> 
                <button class="btn btn-danger btn-flat" id="cancel">Cancel</button>  
              </div>      
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"> 

let reportType = null
const loadReportModal = (type) => {
  $('#continue-modal').modal('show');
  reportType = type
}
const generateReport = () => {
  var start_date = $("#start_date").val();
  var end_date = $("#end_date").val();
  window.open(window.localStorage.getItem('cpurl')+`/corpfin/reports/generate?type=${reportType}&start_date=${start_date}&end_date=${end_date}`, '_blank');
  return false;
}
</script> 
@endsection