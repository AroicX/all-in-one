<!DOCTYPE html>
<html>
  <title>CorpERM | Subscription</title>
@include('includes.Head')
<body class="hold-transition skin-blue sidebar-mini">
<link href="{{asset('css/corpfin/components.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
<div class="wrapper">
 @include('includes.Header')
@include('includes.Menu')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    @include('includes.status')
      <h1>
        Subscription
        <small>CorpERM</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="{{ url('dashboard') }}">Subscription</a></li>
        <li class="active">Custom</li>

      </ol>
    </section>
 @include('includes.status')
    <!-- Main content -->
    <section class="content">
        <div class="row">     
    <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"> 
Customize Your Package <strong></strong>
</h3>
            </div>
            <!-- /.box-header -->
                        <div class="row" style="padding:10px;">

    <?php foreach ($Packages as $key => $package) { ?>
                            <div class="col-md-4 ">
                                <!-- BEGIN Portlet PORTLET-->
                                <div class="portlet box blue">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-money"></i><?= $key; ?> </div>

                                    </div>
                                    <div class="portlet-body">
                                        <div class="scroller" style="height:200px" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
                                            <br/>  
                                            <?php foreach($package as $i){
                                                foreach ($i as $j => $k) {   ?>
                                                <div class="form-group">
                                          <div style="width:100%; padding:3px;">
                                          <div class="" style="float:left;"><?= $k->plan; ?> - <strong>$<?= $k->pricing; ?></strong>/m</div>
                                          <div class="icheckbox_flat-green" aria-checked="true" aria-disabled="false" style="float:right;">

                                          <input type="checkbox" id="flat-red plan" class="<?= $key; ?>" name="plan[]" price="<?= $k->pricing; ?>"  value="<?= $k->plan; ?>" package="<?= $key; ?>" >
                                          </div>
                                          </div>
                                          <hr>
                                          </div>
                                                <?php } 
                                            } ?></div>
      <input type="hidden" value="0" name="<?= $key; ?>_price" id="<?= $key; ?>_price" >
                                    </div>
                                </div>
                                <!-- END Portlet PORTLET-->
                            </div>


    <?php } ?>
  <div class="col-md-12 payment">
      <hr>
      <h1 style="text-align:center; font-size:25px;">ORDER SUMMARY</h1>
      <br>
  <div class="col-sm-3">
    <label for="sub-total"><b>Sub Total:</b> <span class="subtotal" id="subtotal"></span></label>
  </div>

 <div class="col-sm-3">
   <label for="plan_no"><b>No Of plans:</b> <span class="plan_no" id="plan_no"></span></label>
 </div>

<div class="col-sm-3">
  
</div>
  </div>
            </div>
            </div>
            </div>
    </section>
    <!-- /.content -->
<!--pricing modal-->
           <!-- Modal -->
<div data-backdrop="static" data-backdrop="static" data-keyboard="false" class="modal fade" id="pricing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="exitmodal()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" style="text-align:center;" id="myModalLabel"><span class="modalplan"></span></h4>
      </div>
      <div class="modal-body">

<form method="post" action="" id="pricingform">
<input type="hidden" name="c_id" id="c_id" value="<? echo $company_id ?>">
<input type="hidden" value="" name="pp" id="pp">
<input type="hidden" value="" name="mplan" id="mplan">
      <div class="row">
      <div class="col-md-12">
                          <div class="form-group">
                  <label for="subscription">Select Duration</label>
        <select class="form-control" id="subscription" name="subscription" placeholder="" required>
             <option value="">Duration</option>
           <option value="1" duration="month" price="">1 Month</option>
           <option value="3" duration="month" price="">3 Month</option>
           <option value="6" duration="month" price="">6 Month</option>
           <option value="9" duration="month" price="">9 Month</option>
           <option value="11" duration="year" price="">Annual</option>
          </select>
                </div>
</div>
</div>
                        <div class="form-group" style="padding:7px;">
 <input type="text" name="totalprice" class="form-control" value="" id="totalprice" placeholder="$0.00" readonly>
                </div>
</form>
      </div>
      <div class="modal-footer">
      
        <button type="button" class="btn btn-success" onclick="continuemodal()">Continue</button>
         <button type="button" class="btn btn-danger" onclick="exitmodal()" >Cancel</button>
      </div>
    </div>
  </div>
</div>
<!--End Modal-->
<!-- /. end pricing modal-->
  </div>
  <!-- /.content-wrapper -->
 @include('includes.Footer') 
@include('includes.Sidebar')
</div>
<!-- ./wrapper -->
 @include('includes.Includes')
<script src="{{asset('js/custom_sub.js')}}"></script>
</body>
</html>
