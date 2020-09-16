@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5>View Quotes</h5>
        <span class="d-block m-t-5">All Quotes</span>
      </div>
      <div class="card-body table-border-style">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Qoute #</th>
                <th>Qoute Status</th>
                <th>Total </th>
                <th>View</th>

              </tr>
            </thead>

            <tbody>
              @foreach(App\Models\CorpFIN\Invoice::where('type' , 'quote')->get() as $invoice)
                <tr>
                  <td>{{$invoice->invoice_no}}</td>
                  <td>{{$invoice->status}}</td>
                  <td>{{number_format($invoice->balance,2)}}</td>
                  <td><a class="btn btn-primary" href="{{url('')}}\corpfin\invoice\view\{{$invoice->id}}"> <i
                        class="fa fa-eye"></i></a></td>
                </tr>
              @endforeach
            </tbody>

          </table>

        </div>
      </div>
    </div>
  </div>

</div>

<div class="modal fade" id="view_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md" style="">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
        <center>
          <h4 class="modal-title" style="color:#1d74b7;">Manage Quotes</h4>
        </center>
      </div>
      <form action="{{url('corpfin/edit/inv')}}" method="post" enctype="multipart/form-data" name="form" id="form">
        <input type="hidden" name="id" autocomplete="off" style="background:#ffffff;" class="form-control"
          placeholder="" required>
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label class="control-label">Client Name</label>
                <div class="append-icon">
                  <input type="text" name="name" autocomplete="off" style="background:#ffffff;" class="form-control"
                    placeholder="" required>
                  <i class="icon-user"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="row" style="padding-top:15px;">
            <div class="col-sm-12">
              <label for="qdate">Quote Date<span style="color:red;">*</span></label>
              <div class="input-group date" data-provide="datepicker">
                <input type="text" name="qdate" id="qdate" placeholder="Select Quote Date" class="form-control"
                  required>
                <div class="input-group-addon">
                  <span class="glyphicon glyphicon-th"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="row" style="padding-top:15px;">
            <div class="col-sm-12">
              <label for="qdate">Expiry<span style="color:red;">*</span></label>
              <div class="input-group date" data-provide="datepicker">
                <input type="text" name="date_due" id="date_due" placeholder="Expiry Date" class="form-control">
                <div class="input-group-addon">
                  <span class="glyphicon glyphicon-th"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="row" style="padding-top:15px;">
            <div class="col-sm-12">
              <label class="control-label">Add Product/Services</label>

              <table id="products_table" class="table table-bordered table-striped">
                <tbody>
                  <tr>
                    <th>&nbsp;</th>
                    <th>name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Tax Rate</th>
                  </tr>
                  <?php $i =0; ?>
                  @foreach($products as $product)
                  <?php $i= $i+1; ?>
                  <tr class="product">
                    <td class="text-left">
                      <input type="checkbox" name="product_ids[]" class="cbox" value="<?= $product->id; ?>">
                    </td>
                    <td nowrap="" class="text-left">
                      <b><?= $product->name; ?></b>
                      <input type="hidden" value="<?= $product->name; ?>" name="<?= $product->id; ?>_product_name">
                    </td>
                    <td class="text-right">

                      <input type="text" class="form-control" value="<?= $product->price; ?>"
                        name="<?= $product->id; ?>_product_price">
                    </td>
                    <td>
                      <input type="number" class="form-control" value="1" name="<?= $product->id; ?>_product_quantity">
                    </td>
                    <td>
                      <select type="text" name="<?= $product->id; ?>_product_tax" class="form-control">
                        <option value=""></option>
                        @foreach($tax_rates as $tax_rate)
                        <option value="<?= $tax_rate->rate; ?>">
                          <?= $tax_rate->name; ?>
                          (<?= $tax_rate->rate; ?> %)</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <input type="number" class="form-control" value="1" name="<?= $product->id; ?>_product_discount">
                    </td>
                  </tr>
                  @endforeach
                  <!-- Todo
            <tr class="bold-border">
                            <td colspan="3">
                                                            </td>
                        </tr>
            -->
                </tbody>
              </table>
            </div>
          </div>
          <div class="row" style="padding-top:15px;">
            <div class="col-sm-12">
              <label for="address">Invoice Group<span style="color:red;">*</span></label>
              <select type="text" name="group" id="group" class="form-control" required>
                <option value=""></option>
                @foreach($invoice_groups as $invoice_group)
                <option value="<?= $invoice_group->name; ?>">
                  <?= $invoice_group->name; ?></option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row" style="padding-top:15px;">
            <div class="col-sm-12">
              <label for="address">Status<span style="color:red;">*</span></label>
              <select type="text" name="status" id="status" class="form-control">
                <option value=""></option>
                <option value="draft">Draft</option>
                <option value="sent">Sent</option>
                <option value="viewed">Viewed</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
                <option value="canceled">Canceled</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <center><button type="submit" class="btn btn-embossed btn-success"
                style="background:#1d74b7;">Update</button></center>
          </div>
      </form>
    </div>
  </div>
</div>



<!-- Initialize the plugin: -->
<!--Ajax edit admin call_up script -->
<script>
  //Ajax Load data from ajax
  $(function () {
    $('.edit_modal').click(function () {
      var id = $(this).attr('id');
      // alert("wait");
      App.blockUI({
        target: '#BlockUI',
        boxed: true,
        textOnly: true,
        message: '<img src="{{asset('img/ spinner.gif')}}" /> Just a moment...'
      });
    $.ajax({
      url: "{{url('')}}/corpfin/get/inv/" + id,
      type: "GET",
      dataType: "JSON",
      success: function (data) {
        //alert(data);
        App.unblockUI('#BlockUI');
        $('#view_modal').modal('show'); // show bootstrap modal when complete loaded
        $('[name="id"]').val(data.id);
        $('[name="name"]').val(data.client_name);
        $('[name="qdate"]').val(data.invoice_date);
        $('[name="date_due"]').val(data.date_due);
        $('[name="group"]').val(data.invoice_group);
        $('[name="status"]').val(data.status);

      },
      error: function (jqXHR, textStatus, errorThrown) {
        App.unblockUI('#BlockUI');
        alert('Error Retrieving Data!');
      }
    });
  });
             });
</script>
<!--/Ajax edit admin call_up script -->
<script type="text/javascript">
  $('.delete_selected').click(function () {
    //   if ($('input.checkboxes').is(':checked')) {
    //       var values = $('input.checkboxes:checked').map(function () {
    //           return this.value;
    //       }).get();
    var id = $(this).attr('iid');
    confirm_statement = "Are you sure you want to delete this Quote?";
    if (confirm(confirm_statement)) {
      App.blockUI({
        target: '#BlockUI',
        boxed: true,
        textOnly: true,
        message: '<img src="{{asset('img/ spinner.gif')}}" /> Just a moment...'
    });
  $.ajax({
    // url: '{{ url('corpfin/del/tp') }}',
    // type:'post',
    // data: { "hall_id" : values },
    type: "GET",
    url: "{{ url('') }}/corpfin/del/inv/" + id,
    dataType: 'json',
    success: function (data) {
      if (data.result == 'success') {
        location.reload();
        Command: toastr["success"]("Quote deleted Successfully!")
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
        // alert("OKK");
      }
      if (data.result == 'fail') {
        App.unblockUI('#BlockUI');
        // $('#fail').show();
        Command: toastr["error"]("Error Completing Request. Try Again!")

        toastr.options = {
          "closeButton": false,
          "debug": false,
          "newestOnTop": false,
          "progressBar": false,
          "positionClass": "toast-top-right",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "3000",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }
      }
      if (data.result == 'login') {
        window.location.href = u + '/login';
        Command: toastr["error"]("Session Expired. Login to continue!")

        toastr.options = {
          "closeButton": false,
          "debug": false,
          "newestOnTop": false,
          "progressBar": false,
          "positionClass": "toast-top-right",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "3000",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }
      }
    }
  })
}
})
</script>

@endsection