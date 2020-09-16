<!DOCTYPE html>
<html>
  <title>CorpFin | Register Transaction Type</title>
@include('CorpFIN.includes.Head')
<meta id="token" name="token" content="{ { csrf_token() } }">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
        Manage Transaction Type
        <small>Preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('corpfin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="javasctipt:void(0)">Manage Transaction Category</a></li>
        <li class="active">Add Transaction Type</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row blockUI" id="blockUI">
        <!-- form start -->
        <form  id="add_tt" action="<? echo "post_tt"; ?>" method="post">
		<div class="col-md-12">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Register Transction Category</h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
            <div class="col-md-12">
<div class="alert alert-danger display-hide" style="text-align:center;" id="val_fail">
                    <button class="close" data-close="alert"></button>
                    <span>...</span>
                </div>

<div class="alert alert-danger display-hide" style="text-align:center;" id="empty">
                    <button class="close" data-close="alert"></button>
                    <span>Fill in all Fields!</span>
                </div>
                <div class="alert alert-danger display-hide" style="text-align:center;" id="empty">
                    <button class="close" data-close="alert"></button>
                    <span>Unable to Process Request. Try Again!</span>
                </div>
<div class="row">
<div class="col-sm-4">
                <div class="form-group">
                  <label for="TTN">Transaction Type Name</label>
          <input type="text" class="form-control" name="TTN" id="TTN" placeholder="Transaction Type Name" required>
                </div>
                </div>
<div class="col-sm-4">
				<div class="form-group">
                  <label for="acc_num">Transaction Type Code</label>
      <input class="form-control" id="tcode" name="tcode" placeholder="Transaction Type code (3 letters long)" required>
                </div>
                </div>
                <div class="col-sm-4">
        <div class="form-group">
                  <label for="acc_num">Account Number</label>
                  <input class="form-control" id="acc_num" name="acc_num" value="100101" placeholder="Account Number" required readonly>
                </div>
                </div>
  </div>

    <div class="row">
<div class="col-sm-12" id="fss">
                <div class="form-group">
                  <label for="type">Finicial sub_catment Category</label>
<select class="form-control" name="type" id="type" required>
  <option>Select FS Category</option>
<option value="Assets" id="1">Assets</option>
<option value="Equity" id="2">Equity</option>
<option value="Expenses" id="3">Expenses</option>
<option value="Income" id="4">Income</option>
<option value="Liabilities" id="5">Liabilities</option>
</select>
                </div>
                </div>
                <div class="col-sm-6" id="main_cat" style="display:none;">
<div class="form-group" style="">
                  <label for="main_cat">Asset Type</label>
<select class="form-control" name="main_cat" id="main_cat">
  <option id="0">Select Asset Type</option>
<option value="Current" id="1">Current</option>
<option value="Non-Current" id="2">Non-Current</option>
</select>

</div>
</div>

                <div class="col-sm-6" id="main_cat1" style="display:none;">
<div class="form-group" style="">
                  <label for="main_cat1">Account Type</label>
<input id="main_catt" name="main_cat1" class="form-control">
</div>
</div>

  </div>


<div class="row hide_init" id="hide_init" style="display:none;">
  <div class="col-sm-6">
                        <div class="form-group">
                        <label>Main Account</label>
             <select id="sub_cat" data-live-search="true" name="sub_cat" class="form-control" required></select>
                </div>
  </div>
    <div class="col-sm-6">
                        <div class="form-group ui-widget">
                        <label for="acc_name">Sub Account</label>
    <input id="acc_name" name="acc_name" class="form-control" required>
                </div>
  </div>
  </div>

  <label for="cat_type">Account Category</label>
<div class="row">
                  <div class="col-sm-12">
                <div class="form-group">
          <select class="form-control" name="acc_cat" id="acc_cat" required>
            <option value="">Select Account Category</option>
            <option value="cr">Credit</option>
            <option value="dr">Debit</option>
          </select>
          </div>
          </div>
  </div>

  </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Add</button>
              </div>
          </div>
          

        </div>
        </form>
        <!--/.end form -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
   @include('includes.Footer') 
@include('includes.Sidebar')
</div>
<!-- ./wrapper -->
 @include('includes.Includes')
   <script src="{{asset('autocomplete/autocomplete.js')}}"></script>
   <script src="{{asset('autocomplete/autocomplete2.js')}}"></script>
</body>
<script type="text/javascript">
      $("#type").click(function(e){
      console.log(e);
        var value = $('#type :selected').attr('value');
      var main_cat = document.getElementById('main_cat');
       var main_cat1 = document.getElementById('main_cat1');
      if(value=="Assets" || value=="Liabilities"){
    if (main_cat.style.display != 'block') {
        main_cat.style.display = 'block';
         main_cat1.style.display = 'none';
        document.getElementById("fss").className = "col-sm-6";
                      var hide_init = document.getElementById('hide_init');
               hide_init.style.display = 'none';
    } else{
        main_cat.style.display = 'none';
        main_cat1.style.display = 'block';
        document.getElementById("fss").className = "col-sm-6";
    }
  }else if(value=="Equity" || value=="Expenses" || value=="Income"){
        main_cat.style.display = 'none';
        main_cat1.style.display = 'block';
        document.getElementById("fss").className = "col-sm-6";
              var hide_init = document.getElementById('hide_init');
               hide_init.style.display = 'block';
        var at_id = $('#main_cat :selected').attr('id');
        var fs_id = $('#type :selected').attr('id');
        $.ajax({
            type: "GET",
            url: "{{ url('') }}/corpfin/list_tt/"+fs_id+"/"+at_id,
       // dataType: "html",
        success: function(data)
        {
       $('#sub_cat').empty();
         hide_init.style.display = 'block';
for(var key in data){
  var name = data[key].main_account;
  var sel = document.getElementById('sub_cat');
    var opt = document.createElement('option');
     opt.text = data[key].main_account;
     opt.value = data[key].main_account;
     sel.appendChild(opt);

}
}
        });
    }
  });

</script>

 <script type="text/javascript">
    $("#main_cat").change(function(e){
      var hide_init = document.getElementById('hide_init');
      console.log(e);
        var at_id = $('#main_cat :selected').attr('id');
        var fs_id = $('#type :selected').attr('id');
        $.ajax({
            type: "GET",
            url: "{{ url('') }}/corpfin/list_tt/"+fs_id+"/"+at_id,
       // dataType: "html",
        success: function(data)
        {
       $('#sub_cat').empty();
         hide_init.style.display = 'block';
for(var key in data){
  var name = data[key].main_account;
  var sel = document.getElementById('sub_cat');
    var opt = document.createElement('option');
     opt.text = data[key].main_account;
     opt.value = data[key].main_account;
     sel.appendChild(opt);

}
}
        });
    });
</script>

<script type="text/javascript">
  $("input").keypress(function(event) {
            if (event.which == 13) {
                event.preventDefault();
                $("#add_tt").submit();
            }
        });
 $('#add_tt').submit(function (e) {
    e.preventDefault();
    url = $(this).attr('action');
    $('#empty').hide();
    $('#val_fail').hide();
    $('#fail').hide();
if ($('[name|="TTN"]').val() == "" || $('[name|="type"]  ').val() == "" ){
$('#empty').show();
return false;
            };
            App.blockUI({ 
                target: '#blockUI',
                boxed: true,
                textOnly: true,
                message: '<img src="{{asset('img/spinner.gif')}}" /> Just a moment...'
            });
                        postData = $(this).serialize();
            $.ajax({
                url: url,
                type:'post',
                beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));},
                data: postData,
                dataType:'json',
                success: function(data){
                    if (data.result == 'success') {
                      alert("Transaction Type Added Successfully");
                       window.location.href = '{{ url('corpfin/view_transaction_types') }}';
                       // alert("OKK");
                    }
                    if (data.result == 'val_fail'){
                        App.unblockUI('#blockUI');
                        $('#val_fail').show();
                    }
                    if (data.result == 'fail') {
                        App.unblockUI('#blockUI');
                        $('#fail').show();
                    }
                }
            })
  });
</script>
</html>
