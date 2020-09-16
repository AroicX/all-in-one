@extends('CorpHRM.layout.master')

@section('content')
	<section class="content">
		<div class="row">

            <div class="col-md-12">
                                            @if(isset($success))
                <div class="alert alert-success">* Successfully Added</div>
                @endif
                                @if(session('error'))
                        <div class = "alert alert-error">
                            {{ session('error') }}.
                        </div>
                    @elseif(session('success'))
                        <div class = "alert alert-success">
                            {{ session('success') }}.
                        </div>
                    @endif
                <div class="card card-primary">
                	<div class="card-header with-border">
                		<h5>Payroll Settings
                                <div class="pull-right">
                                    <button class="btn btn-primary addition_subtraction" addition = "1" subtraction="0">Add Addition</button>
                                    <button class="btn btn-primary addition_subtraction" addition = "0" subtraction="1">Add Deduction</button>
                                </div>
                        </h5>
                	</div>
                            <ul class="nav nav-tabs">
                              <li class="active"><a data-toggle="tab" href="#custom">Custom</a></li>
                              <li><a data-toggle="tab" href="#basic">Basic</a></li>
                              <li><a data-toggle="tab" href="#payee">Payee</a></li>
                            </ul>
<div class="tab-content">
  <div id="custom" class="tab-pane fade in active">

                                <div class="card-body table-responsive no-padding">
                            <table class="table table-hover">

                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th style="text-align: center;">Additon</th>
                                    <th style="text-align: center;">Subtraction</th>
                                    <th>Action</th>
                                </tr>
                                <?php $sn = 0; ?>
                                @foreach ($custom_settings as $custom_setting)
                                <?php $sn += 1;?>
                                <tr>
                                    <td>{{$sn}}</td>
                                    <td>{{ $custom_setting->name }}</td>
                                    <td style="text-align: center;">@if($custom_setting->addition == "1") <span style="color:green;" class="glyphicon glyphicon-ok"></span> @else <span style="color:red;" class="glyphicon glyphicon-remove"></span> @endif</td>
                                    <td style="text-align: center;">@if($custom_setting->subtraction == "1") <span style="color:green;" class="glyphicon glyphicon-ok"></span> @else <span style="color:red;" class="glyphicon glyphicon-remove"></span> @endif</td>
                                    <td></td>
                                </tr>
                                @endforeach
                            </table>
                            @if(count($custom_settings) == 0)
                            <td><p style="text-align:center;" >No Custom.
                                </p></td>

                            @endif
                        </div>

  </div>
  <div id="basic" class="tab-pane fade">
                                   <div class="card-body table-responsive no-padding">
                            <table class="table table-hover">

                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th style="text-align: center;">Additon</th>
                                    <th style="text-align: center;">Subtraction</th>
                                    <th>Action</th>
                                </tr>
                                <?php $sn = 0; ?>
                                @foreach ($basic_settings as $basic_setting)
                                <?php $sn += 1;?>
                                <tr>
                                    <td>{{$sn}}</td>
                                    <td>{{ $basic_setting->name }}</td>
                                    <td style="text-align: center;">@if($basic_setting->addition == "1") <span style="color:green;" class="glyphicon glyphicon-ok"></span> @else <span style="color:red;" class="glyphicon glyphicon-remove"></span> @endif</td>
                                    <td style="text-align: center;">@if($basic_setting->subtraction == "1") <span style="color:green;" class="glyphicon glyphicon-ok"></span> @else <span style="color:red;" class="glyphicon glyphicon-remove"></span> @endif</td>
                                    <td></td>
                                </tr>
                                @endforeach
                            </table>
                            @if(count($basic_settings) == 0)
                            <td><p style="text-align:center;" >No basic.
                                </p></td>

                            @endif
                        </div>
  </div>
  <div id="payee" class="tab-pane fade">
  <div class="col-md-12" style="float:none !important; padding:10px;">
  <marquee><p style="color:red;">Please note that once a selection has been made, It can't be undone!</p></marquee>
    <div class="panel panel-default">
    <div class="panel-body"><b>PAYEE YTD</b>
        <?php if(empty($payee_type) || $payee_type == NULL){ ?>
        <a href="{{  url('corphrm/payroll/settings/payee') }}?query=YTD">
            <button class="btn btn-sm btn-primary pull-right" style="margin:3px;">Activate</button>
        </a>
        <?php }elseif($payee_type == "YTD"){ ?>
        <a href="javascript:;">
            <button class="btn btn-sm btn-warning pull-right" style="margin:3px;">Active</button>
        </a>
        <?php } ?>
    </div>
    </div>
    <div class="panel panel-default">
    <div class="panel-body"><b>PAYEE ANNUALIZED</b>
        <?php if(empty($payee_type) || $payee_type == NULL){ ?>
        <a href="{{  url('corphrm/payroll/settings/payee') }}?query=ANNUALIZED">
            <button class="btn btn-sm btn-primary pull-right" style="margin:3px;">Activate</button>
        </a>
        <?php }elseif($payee_type == "ANNUALIZED"){ ?>
        <a href="javascript:;">
            <button class="btn btn-sm btn-warning pull-right" style="margin:3px;">Active</button>
        </a>
        <?php } ?>
    </div>
    </div>
</div>
  </div>
</div>
                </div>
            </div>
        </div>
    </section>
    <!--upload scores Modal -->
  <div class="modal fade" id="modal-addition_subtraction" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New</h4>
        </div>
        <div class="modal-body">
        <form method="post" action="{{ url('corphrm/payroll/post_addition_subtraction') }}" enctype='multipart/form-data'>
        {{csrf_field()}}
        <input type="hidden" name="addition" required="">
        <input type="hidden" name="subtraction" required="">

        <div class="col-md-12">
                <div class="form-group">
            <label>Type:</label>
            <select class="form-control" required="" name="type" id="type">
                <option value="">Choose One</option>
                <option value="Basic">Basic</option>
                <option value="Custom">Custom</option>
            </select>
            </div>  
        </div>

        <div class="col-md-6 custom_name" id="custom_name" style="display: none;">
          <div class="form-group"  >
            <label>Parameter:</label>
            <input type="text" class="form-control"  name="name_c" placeholder="Enter Parameter Name">
          </div>
        </div>
        <div class="col-md-12"  id="basic_name" style="display: none;">
          <div class="form-group">
            <label>Parameter:</label>
                <select class="form-control" name="name_b" >
                  <option value="">select one</option>
                  <option value="Loan" style="display: none;" class="deductions">Loan</option>
                  <option value="Cash Advance" style="display: none;" class="deductions">Cash Advance</option>
                  <option value="NHF" style="display: none;" class="deductions">NHF</option>
                  <option value="NHIS" style="display: none;" class="deductions">NHIS</option>
                  <option value="Pension" style="display: none;" class="deductions">Pension</option>
                  <option value="Housing" style="display: none;" class="additions">Housing Allowance</option>
                  <option value="Transportation" style="display: none;" class="additions">Transportation Allowance</option>
                  <option value="Meal" style="display: none;" class="additions">Meal Allowance</option>
            </select>
            </div>
        </div>
<!--         <div class="col-md-6 custom_name" id="ttype" style="display: none;">
            <div class="form-group" >
                <label>Type:</label>
                    <select class="form-control" name="type" >
                    <option value="Loan">Earnings</option>
                    <option value="Cash Advance">Deduction</option>
                </select>
            </div> 
        </div>  -->   
        <div class="col-md-6 custom_name basic_additions" style="display: none;">
            <div class="form-group">
            <label>Frequency</label>
                <select class="form-control" name="frequency">
                    <option value="Yearly">Yearly</option>
                    <option value="Half Yearly">Half Yearly</option>
                    <option value="Quartely">Quartely</option>
                    <option value="Monthly">Monthly</option>
                </select>
            </div>
        </div> 
        <div class="col-md-6 custom_name basic_additions" style="display: none;">
            <div class="form-group">
            <label>Mode</label>
                <select class="form-control" name="frequency">
                    <option value="">Select Mode</option>
                    <option value="Percent">Percent</option>
                    <option value="Amount">Amount</option>
                </select>
            </div>
        </div> 
        <div class="col-md-6 custom_name basic_additions" style="display: none;">
            <div class="form-group">
                <label>Value</label>
                <input type="number" name="value" class="form-control">
            </div>
        </div>

        <div class="col-md-6 custom_name basic_additions" style="display: none;">
            <div class="form-group">
                <label for="effective_month">Effctive Month</label>
                <select class="form-control" name="effective_month" id="effective_month">
                  <option value="january">January</option>
                  <option value="february">February</option>
                  <option value="march">March</option>
                  <option value="april">April</option>
                  <option value="may">May</option>
                  <option value="june">June</option>
                  <option value="july">July</option>
                  <option value="august">August</option>
                  <option value="september">September</option>
                  <option value="october">October</option>
                  <option value="november">November</option>
                  <option value="december">December</option>
                </select>
              </div>
        </div>
            <div class="col-md-6 custom_name basic_additions" style="display: none;">
            <div class="form-group">
                <label>Calculate On</label>
                <select class="form-control" name="calculate">
                 <option value="basic">Basic</option>
                </select>
              </div>
              </div>
              <div class="col-md-6 custom_name basic_additions" style="display: none;">
              <div class="form-group">
                <label for="assign_to_grade">Assign to Grade</label>
                <select class="form-control" name="assign_to_grade">
                  <option value="">Select a Grade</option>
                  @foreach($grades as $grade)
                  <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                  @endforeach
                </select>
              </div>
              </div>
                          <div class="form-group custom_name basic_additions col-md-6" style="display: none;">
                <label>Wages Type</label>
                <select class="form-control" name="wages_type">
                    <option>Select WagesType </option>
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                </select>
            </div>
                      <div class="col-md-6 custom_name basic_additions" id="is_taxable" style="display: none;">
            <div class="form-group">
            <label>Is Taxable</label>
            <br>
                <label style="font-weight: 400;"><input type="radio" value="1" name="is_taxable">&nbsp;&nbsp;Yes</label>
                <label style="font-weight: 400;"><input type="radio" value="0" name="is_taxable">&nbsp;&nbsp;No</label>
            </div>
        </div>

<!--               <div class="col-md-6 custom_name" style="display: none;">
              <div class="form-group">
                <label>Nature</label>
                <select class="form-control" name="nature">
                  <option>Select nature</option>
                  <option value="fixed">Fixed</option>
                  <option value="variable">Variable</option>
                </select>
              </div>
              </div> -->

        <br><br><br><br>
        <div class="col-md-12">
          <div class="form-group">
            <button type="submit" class="btn pull-right btn-primary btn-sm" style="border-radius: 0px;">submit</button>
            <br>
          </div>
        </div>
          </form>
        </div>
        <br>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
<script src="{{asset('calendar/js/jquery.min.js')}}"></script>
<script type="text/javascript">
      $(document).ready(function () {

    $('.addition_subtraction').click(function () {
        var addition = $(this).attr('addition');
        var subtraction = $(this).attr('subtraction');
        if(addition == "1"){
        var elems  = document.getElementsByClassName('additions');
          for (i = 0; i < elems.length; i++) {
            elems[i].style.display = 'block';
            //elems[i].style.top = '100%';
          }
          var elemss  = document.getElementsByClassName('deductions');
          for (i = 0; i < elemss.length; i++) {
            elemss[i].style.display = 'none';
            //elems[i].style.top = '100%';
          }

        }if(subtraction == "1"){
        var elems  = document.getElementsByClassName('additions');
          for (i = 0; i < elems.length; i++) {
            elems[i].style.display = 'none';
            //elems[i].style.top = '100%';
          }
          var elemss  = document.getElementsByClassName('deductions');
          for (i = 0; i < elemss.length; i++) {
            elemss[i].style.display = 'block';
            //elems[i].style.top = '100%';
          }

        }
        $('[name="addition"]').val(addition);
        $('[name="subtraction"]').val(subtraction);
        $('#modal-addition_subtraction').modal('show');
        return false;
    });

      $(".modal").on("hidden.bs.modal", function() {

        $('[name="type"]').val("");
        $('[name="name_b"]').val("");
        $('[name="addition"]').val("");
        $('[name="is_taxable"]').val("");
        $('[name="subtraction"]').val("");
        var elems  = document.getElementsByClassName('custom_name');
          for (i = 0; i < elems.length; i++) {
            elems[i].style.display = 'none';
            //elems[i].style.top = '100%';
          }
        document.getElementById('basic_name').style.display = 'none';
  });

     $('#type').on('change',function(){
        //alert("k")
        if($(this).val() == "Basic"){
            document.getElementById('basic_name').style.display = 'block';
        var elems  = document.getElementsByClassName('custom_name');
          for (i = 0; i < elems.length; i++) {
            elems[i].style.display = 'none';
            //elems[i].style.top = '100%';
          }
           // document.getElementById('is_taxable').style.display = 'block';
           var addition = $('[name="addition"]').val();
           if(addition == "1"){
        var elems  = document.getElementsByClassName('basic_additions');
          for (i = 0; i < elems.length; i++) {
            elems[i].style.display = 'block';
            //elems[i].style.top = '100%';
          }
           }
        }
        if($(this).val() == "Custom"){
            document.getElementById('basic_name').style.display = 'none';
        var elems  = document.getElementsByClassName('custom_name');
          for (i = 0; i < elems.length; i++) {
            elems[i].style.display = 'block';
            //elems[i].style.top = '100%';
          }
         //    document.getElementById('ttype').style.display = 'block';
        }
    });

    $('[name="name_b"]').on('change',function(){
        //alert("k")
        if($(this).val() == "Loan" || $(this).val() == "Cash Advance"){
          $('[name="is_taxable"]').val(1);

        }
    });
});
</script>
@stop
