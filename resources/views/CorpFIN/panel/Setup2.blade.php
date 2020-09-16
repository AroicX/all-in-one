<!DOCTYPE html>
<html>
<title>CORPFIN | Company Setup</title>
 @include('CorpFIN.includes.Head')
 <meta id="token" name="token" content="{ { csrf_token() } }">
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

   @include('CorpFIN.includes.Header')
  <!-- Left side column. contains the logo and sidebar -->
      @if(Auth::user()->Corpfin_menutype == "Traditional")
            @include('CorpFIN.includes.Traditional_menu')
   @else
            @include('CorpFIN.includes.Diary_menu')
    @endif
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       
        <p style="text-transform:;">Setup your Company - Business Information</p>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Setup</li>
         <li class="active">Business Information</li>
      </ol>
    </section>
<br>
 @include('includes.status')
    <!-- Main content -->
    <section class="content" id="blockUI" style="background:#fff !important; margin-left:10px; margin-right:10px;">
      <!-- Small boxes (Stat box) -->
      <form action="<?php echo "setup2"; ?>" id="setup2" method="post">
      <input type="hidden" name="url" id="url" value="{{url('')}}">
            <div class="alert alert-danger display-hide" style="text-align:center;" id="val_fail">
                    <button class="close" data-close="alert"></button>
                    <span>Company Name Already Exist!</span>
                </div>

<div class="alert alert-danger display-hide" style="text-align:center;" id="empty">
                    <button class="close" data-close="alert"></button>
                    <span>Fill in all Fields!</span>
                </div>
                <div class="alert alert-danger display-hide" style="text-align:center;" id="empty">
                    <button class="close" data-close="alert"></button>
                    <span>Unable to Process Request. Try Again!</span>
                </div>
      <br>
<div class="row">
<div class="col-md-12">
<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

<input type="hidden" name="c_id" id="c_id" value="<?php echo $company_id; ?>">

<div class="row">
  <div class="col-sm-6">
    
                        <div class="form-group">
                        <label>Business Type</label>
 <select class="form-control" name="business_type" required>
 <option value="">Select Business Type</option>
   <option value="Sole Propietorship">Sole Propietorship</option>
   <option value="LTD">Private Limited Company(LTD)</option>
   <option value="PLC">Public Limited Company</option>
   <option value="Guarantee Company">Guarantee Company(Not-For-Profit)</option>
   <option value="Partnership">Partnership</option>
 </select>
                </div>
  </div>

  <div class="col-sm-6">
    
                        <div class="form-group">
                        <label>Industry Type</label>
 <select class="form-control selectpicker" data-live-search="true" name="industry_type" required>
 <option value="">Select Industry Type</option>
   <option value="Accounting & Book-Keeping">Accounting & Book-Keeping</option>
   <option value="Advertising & Public Relations">Advertising & Public Relations</option>
   <option value="Agriculture, Ranching & Farming">Agriculture, Ranching & Farming</option>
   <option value="Art, Writing & Photography">Art, Writing & Photography</option>
   <option value="Automotive Sales & Repair">Automotive Sales & Repair</option>
 </select>
                </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-6">
    
                        <div class="form-group">
                        <label>Tax Jurisdiction</label>
<select class="selectpicker form-control" name="TJ" data-live-search="true" required>
 <?php foreach($states as $state): ?>
<option value="<?php echo $state->id; ?>"><?php echo $state->name; ?></option>
 <?php endforeach; ?>
</select>
                </div>
  </div>
    <div class="col-sm-6">
                        <div class="form-group">
                          <label>Fiscal Year End</label>
 <div class="col-md-12">
                    
<div class="col-sm-6">
 <select class="form-control" name="FYE1" required>
 <option>Select Month</option>
   <option id="2" value="01" >January</option>
   <option id="0" value="02">February</option>
   <option id="2" value="03">March</option>
   <option id="1" value="04">April</option>
   <option id="2" value="05">May</option>
   <option id="1" value="06">June</option>
   <option id="2" value="07">July</option>
   <option id="2" value="08">August</option>
   <option id="1" value="09">September</option>
   <option id="2" value="10">October</option>
   <option id="1" value="11">November</option>
   <option id="2" value="12">December</option>
 </select>
</div>
<div class="col-sm-6">
  <select class="form-control" name="FYE2" required>
  <option>Select Day</option>
   <option value="1" >1</option>
   <option value="2">2</option>
   <option value="3">3</option>
   <option value="4">4</option>
   <option value="5">5</option>
   <option value="6">6</option>
   <option value="7">7</option>
   <option value="8">8</option>
   <option value="9">9</option>
   <option value="10">10</option>
   <option value="11">11</option>
   <option value="12">12</option>
   <option value="13">13</option>
   <option value="14">14</option>
   <option value="15">15</option>
   <option value="16">16</option>
   <option value="17">17</option>
   <option value="18">18</option>
   <option value="19">19</option>
   <option value="20">20</option>
   <option value="21">21</option>
   <option value="22">22</option>
   <option value="23">23</option>
   <option value="24">24</option>
   <option value="25">25</option>
   <option value="26">26</option>
   <option value="27">27</option>
   <option value="28">28</option>
   <option value="29">29</option>
   <option id="30" value="30">30</option>
   <option id="31" value="31">31</option>
 </select>
 </div>

                </div>
                </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-6">
                        <div class="form-group">
                        <label>Functional Currency</label>
             <div class="input-group">
@foreach ($currency as $curr)
  <span class="input-group-addon" id="basic-addon1">{{$curr->p_currency}}</span>
  <input type="number" class="form-control" name="FC1" min="0" max="100000000.00" placeholder="0" aria-describedby="basic-addon1" required>
  <span class="input-group-addon" id="basic-addon1"><strong>.</strong></span>
  <input type="number" class="form-control"  name="FC2" min="0" max="100000000.00" placeholder="00" aria-describedby="basic-addon1" required>
  <span class="input-group-addon" id="basic-addon1">{{$curr->s_currency}}</span>
@endforeach
</div>
                </div>
  </div>
    <div class="col-sm-6">
    
                        <div class="form-group">
                        <label>Timezone</label>
        <select class="selectpicker form-control" data-live-search="true" name="TZ" placeholder="" required>
        <option value="">Select Timezone</option>
        <?php foreach($timezones as $timezone){ ?>
             <option value="<?= $timezone['zone']; ?>"><?php echo $timezone['diff_from_GMT'] . ' - ' . $timezone['zone']; ?></option>
<?php } ?>
             </select>
                </div>
  </div>
</div>

<div class="row">
<div class="col-sm-6">
<div class="form-group" style="">
<div class="col-md-10">
 <div id="dynamicInput">
          Branches<br><input class="form-control" type="text" name="branches[]">
     </div>
</div>
<div class="col-md-2">
<br>
        <a href="javascript:void(0)" onClick="addInput('dynamicInput');">
          <span class="glyphicon glyphicon-plus"></span> Add Branches
        </a>
</div>
</div>
</div>
    <div class="col-sm-6">
    
                        <div class="form-group" style="">
                        <label>Inventory Valuation</label>
<select class="form-control" name="inventory" required>
<option>Select Inventory Valuation</option>
 <option value="FIFO">FIFO</option>
 <option value="Weighted Average">Weighted Average</option> 
</select>
                </div>

                <td id="test">
                  
                </td>
  </div>
</div>


<div class="row">
<div class="col-sm-12">
<div class="form-group" style="">
<label>What do You Sell</label>
<select class="form-control" name="FD" required>
<option>Select Company Sellable</option>
 <option value="Product">Product</option>
 <option value="Services">Services</option>
  <option value="Both">Both</option> 
</select>
</div>
</div>
</div>

<br>
<div class="form-group">
  <button class="btn btn-primary btn-block">Finish</button>
</div>
</div>
</div>
</form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
   @include('includes.Footer') 
@include('includes.Sidebar')
</div>
<!-- ./wrapper -->
 @include('includes.Includes')
 <script src="{{asset('js/corpfin/setup.js')}}"></script>
</body>
</html>
