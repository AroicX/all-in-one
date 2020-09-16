<!DOCTYPE html>
<html>
@include('includes.Head')
  <title>CorpERM | Subscription</title>
<body class="hold-transition skin-blue sidebar-mini">
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
        <li class="javascript:void(0)">{{$Packages}}</li>
        <li class="active">{{$subpackage}}</li>

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
</h3>
            </div>
            <!-- /.box-header -->

            <div class="row">
            <!--Transaction Box-->
            <div class="col-md-8">
<!-- form start -->
<div style="padding:15px;">
            <?php foreach ($package_details as $i => $packages) { ?>
            <form method="post" class="subscribe" id="subscribe">
  <input type="hidden" name="email" value="{{ Auth::user()->email }}" id="email" class="form-control email" >
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" id="user_id" class="form-control user_id" >
  <input type="hidden" name="refx_code" id="refx_code" value="{{$ref_code}}">
    <input type="hidden" name="package" id="package" value="">
  <input type="hidden" name="url" value="{{ url('') }}" id="url">
   <input type="hidden" name="total" class="form-control" id="tot" readonly>
                            <br>

            <div class="row" style="padding:7px;">
             <div class="col-md-12">
                          <div class="form-group">
                  <label for="subscription">Select Duration</label>
        <select class="form-control" id="subscription" name="subscription" placeholder="" required>
             <option value="">Duration</option>
           <option value="1" duration="month" price="<?php 
            $total = 0;
            foreach ($package_details as $i => $price) {

                $total = $total + $price->pricing;

            }
             echo $total; 
            ?>">1 Month</option>
           <option value="3" duration="month" price="<?php
            $total = 0;
            foreach ($package_details as $i => $price) {

                $total = $total + $price->pricing;

            }
             echo $total; 
            ?>">3 Month</option>
           <option value="6" duration="month" price="<?php 
            $total = 0;
            foreach ($package_details as $i => $price) {

                $total = $total + $price->pricing;
         

            }
             echo $total; 
            ?>">6 Month</option>
           <option value="9" duration="month" price="<?php 
            $total = 0;
            foreach ($package_details as $i => $price) {

                $total = $total + $price->pricing;

            }
             echo $total; 
            ?>">9 Month</option>
           <option value="11" duration="year" price="<?php 
            $total = 0;
            foreach ($package_details as $i => $price) {

                $total = $total + $price->pricing;
         
            }
             echo $total; 
            ?>">Annual</option>
          </select>
                </div>
                                </div>
                </div>


                        <div class="form-group" style="padding:7px;">
 <input type="text" name="totalprice" class="form-control" value="" id="totalprice" placeholder="$0.00" readonly>
                </div>
<div class="form-group" style="text-align:center;">
                <button type="submit" class="btn btn-primary pay_btn" id="pay_btn">PAY NOW</button>
                </div>
                <br>
                <br>
            </form>
            <?php } ?>

<!-- / .end form-->
</div>
            </div>
            <!-- /.End Transaction Box -->

            <!--details box-->               
            <div class="col-md-4">
  <div class="col-md-12" style=" box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1), 0 3px 10px 0 rgba(0, 0, 0, 0.10);">
            <br>
<h1 style="text-align:center; font-size:19px;">Details</h1>
<hr>
<p>jfjdfjdfjjkfjkfjkfjkjfdkjfdkdfjkdfjjkf</p>
<p> fjfdfdkjfdkkjfkjfkjfdkjkjffdjfdjkjkf</p>
  <p>fnfjkfdkjdfjkdfkjkjfdjkdfjkfdjfdkjkf</p>
<p>fnfjkfdkjdfjkdfkjkjfdjkdfjkfdkdfllkfd</p>
<p>fnfjkfdkjdfjkdfkjkjfdjkdfjkfjfdjjkdfjk</p>
<p>fnfjkfdkjdfjkdfkjkjfdjkdfjkfdjkdfjkfdj</p>
<p>fnfjkfdkjdfjkdfkjkjfdjkdfjkfkjdfkjkf</p>
<p>fnfjkfdkjdfjkdfkjkjfdjkdfjkfjkfdjkkjfd</p>
</div>
            </div>
            <!-- /.end details box -->
</div>

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
 <script type="text/javascript">
  document.getElementById('subscription').addEventListener('change', function () {
var quantity = $('#subscription').val();
var price = $('#subscription :selected').attr('price');
var total = price * quantity;
var x = (total + '').replace(/(\d)(?=(\d{3})+$)/g,'$1,');
$('#tot').val(total);
$("#totalprice").val("$"+x);
});
</script>
</body>
</html>
