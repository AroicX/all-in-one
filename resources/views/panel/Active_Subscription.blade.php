<!DOCTYPE html>
<html>
  <title>CorpERM | Subscription</title>
@include('includes.Head')
<meta id="token" name="token" content="{ { csrf_token() } }">
<body class="hold-transition skin-blue sidebar-mini">
    <!-- <link href="{{asset('css/corpfin/pricing.min.css')}}" rel="stylesheet" type="text/css" /> -->
       <!-- <link href="{{asset('css/corpfin/components.min.css')}}" rel="stylesheet" id="style_components" type="text/css" /> -->
<div class="wrapper">
  
@include('includes.Header')
@include('includes.Menu')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Subscription History
        <small>CorpERM</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Subscription</li>
        <li class="active">History</li>
      </ol>
    </section>
 @include('includes.status')
    <!-- Main content -->
    <section class="content"  style="background:#fff !important;" id="blockUI">

                                      <div class="card-box card-tabs" >
                            <ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#active">Active Suscriptions</a></li>
  <li><a data-toggle="tab" href="#inactive">Inactive Subscriptions</a></li>
</ul>

<div class="tab-content">
  <div id="active" class="tab-pane fade in active">
<br>
<input type="hidden" name="url" id="url" value="{{url('')}}">
<?php foreach($active_subs as $active_package){ 
     $today = date('Y-m-d');
     $today = date_create($today);
     $lincense_duration = $active_package->duration;
    $date_activattd = date_create($active_package->date);
    $date_difference = date_diff($date_activattd, $today);
    $days_used = $date_difference->format("%a");
    $lincense_countdown = $lincense_duration - $days_used;
    $x = $lincense_countdown / $lincense_duration;
    $percentage = floor($x * 100);
    if($lincense_countdown > 10) {
    ?>
   <div class="panel panel-success">
     <div class="panel-heading"><?=$active_package->product; ?></div>
  <div class="panel-body">
  <div class="progress">
  <div class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar" aria-valuenow="<?= $percentage; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $percentage; ?>%">
    <?= $percentage; ?>%
  </div>
</div>
<p>
 <span style="padding-right:15px;" >Date Activated: 
 <b>
    <?= date('d M Y', strtotime($active_package->date)); ?>
 </b>
 </span>
<span style="padding-right:15px;">Days Used: <b><?= $days_used; ?></b> </span>
 <span style="padding-right:15px;">Days Left: <b><?= $lincense_countdown; ?></b></span>
  <span><a class="cancel_plan" idd="<?= $active_package->id; ?>" href="javascript:void(0)" data-toggle="tooltip" title="Cancel to upgrade plan!">Cancel And Upgrade Current Plan</a></span> 
 </p> 

 </div>
</div>
    <?php }elseif($lincense_countdown < 10) { ?>
<div class="panel panel-warning">
  <div class="panel-heading"><?=$active_package->product; ?></div>
  <div class="panel-body">
  <div class="progress">
  <div class="progress-bar progress-bar-striped progress-bar-warning active" role="progressbar" aria-valuenow="<?= $percentage; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $percentage; ?>%">
    <?= $percentage; ?>%
  </div>
</div>
<p>
 <span style="padding-right:15px;" >Date Activated: 
 <b> 
    <?= date('d M Y', strtotime($active_package->date)); ?>
    </b>
    </span>
<span style="padding-right:15px;">Days Used: <b><?= $days_used; ?></b> </span>
 <span style="padding-right:15px;">Days Left: <b><?= $lincense_countdown; ?></b></span>
  <span><a class="cancel_plan" href="javascript:void(0)" idd="<?= $active_package->id; ?>" data-toggle="tooltip" title="Cancel to upgrade plan!">Cancel And Upgrade Current Plan</a></span> 
 </p>
  </div>
</div>
    <?php } 
} ?>
  </div>
  <div id="inactive" class="tab-pane fade">
  <br>
<?php foreach($expired_subs as $expired_package){ 
     $today = date('Y-m-d');
     $today = date_create($today);
     $lincense_duration = $expired_package->duration;
    $date_activattd = date_create($expired_package->date);
    $date_difference = date_diff($date_activattd, $today);
    $days_used = $date_difference->format("%a");
    $lincense_countdown = $lincense_duration - $days_used;
    $x = $lincense_countdown / $lincense_duration;
    $percentage = $x * 100;
?>
  <div class="panel panel-danger">
  <div class="panel-heading"><?=$expired_package->product; ?></div>
  <div class="panel-body">
  <div class="progress">
  <div class="progress-bar progress-bar-striped progress-bar-danger active" role="progressbar" aria-valuenow="0%" aria-valuemin="0" aria-valuemax="100" style="width:0%">
 0%
  </div>
</div>
<p>
 <span style="padding-right:15px;" >Date Activated: <b>
    <?= date('d M Y', strtotime($expired_package->date)); ?>
      </b>
      </span>
<span style="padding-right:15px;">Days Used: <b> - </b> </span>
 <span >Days Left: <b> 0 </b></span>
 </p>
  </div>
</div>

<?php }  ?>
<?php if(empty($expired_subs)) { ?>
<br>
<p style="text-align:center;">No Expired Plan</p>
<?php } ?>
  </div>
</div>

                                </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 @include('includes.Footer') 
@include('includes.Sidebar')
</div>
<!-- ./wrapper -->
 @include('includes.Includes')
   <script src="{{asset('js/general/active_sub.js')}}"></script>
</body>
</html>
