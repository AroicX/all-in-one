<style type="text/css">
	        .display-hide{
            display:none;
        }
</style>
<!-- jQuery 2.2.3 -->
<script src="{{asset('calendar/js/jquery.min.js')}}"></script>


<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('calendar/js/jquery-ui.min.js') }}"></script>
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/toastr/build/toastr.min.js')}}"></script>
<script>


</script>

{{--<script src="{{asset('js/jquery.form.js')}}"></script>--}}
<!-- <script src="{{asset('js/scripts-bundle.js')}}"></script> -->
{{--<script src="{{asset('js/app.js')}}"></script>--}}




<!-- fullCalendar 2.2.5 -->
<script src="{{ asset('calendar/js/moment.min.js') }}"></script>
<script src="{{ asset('calendar/js/fullcalendar.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

<!--Block UI-->
<script src="{{asset('js/blockUI/jquery.blockUI.js')}}"></script>
<!--<script src="{{asset('js/blockUI/jquery.js')}}"></script>-->
<!--<script src="{{asset('js/blockUI/script.js')}}"></script>-->
<script src="{{asset('js/blockUI/app.js')}}"></script>
<script src="{{asset('js/blockUI/app.min.js')}}"></script>
<!-- Bootstrap 3.3.6 -->
<!--Bootstrap select-->
  <script src="{{asset('bootstrap/select/bootstrap-select.min.js')}}"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{asset('plugins/morris/morris.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('plugins/sparkline/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap -->
<script src="{{asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('plugins/knob/jquery.knob.js')}}"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{asset('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('plugins/fastclick/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('js/app.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="{{asset('js/pages/dashboard.js')}}"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="{{asset('js/demo.js')}}"></script>
<!-- <script src="{{asset('js/paystack/paystack.js')}}"></script>
 --><script type="text/javascript">
	$("#price_method").change(function(e){
    console.log(e);
    var selected = $("#price_method :selected").val();
    if(selected == "Margin Based"){
        $("#margin_control").prop('disabled', false);
        $("#margin_control").prop('required', true);
           
    }
    else{
    	 $("#margin_control").prop('disabled', true);
        $("#margin_control").prop('required', false);
    }
});
</script>