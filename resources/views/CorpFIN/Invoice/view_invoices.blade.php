

@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5>View Invoice</h5>
        <span class="d-block m-t-5">All Invoice</span>
      </div>
      <div class="card-body table-border-style">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Invoice #</th>
                <th>Invoice Status</th>
                <th>Due Date </th>
                <th>Balance </th>
                <th>View</th>

              </tr>
            </thead>

            <tbody>
                @foreach($invoices as $invoice)
                <tr>
                  <td>{{$invoice->invoice_no}}</td>
                  <td>{{$invoice->status}}</td>
                  <td>{{date('F d, Y', strtotime( $invoice->due_date))}}</td>
                  <td>{{number_format($invoice->balance,2)}}</td>
                  <td><a class="btn btn-primary" href="{{url('')}}\corpfin\invoice\view\{{$invoice->id}}"> <i class="fa fa-eye"></i></a></td>
                </tr>
               @endforeach
            </tbody>

          </table>
          <div class="pager">
              {{ $invoices->links() }}
          </div>
          @if(empty($invoices))
          <td><p style="text-align:center;">No Invoice Added.
                  <a href="{{url('corpfin/invoice/add')}}"> Add Invoice</a>
              </p></td>

          @endif

        </div>
      </div>
    </div>
  </div>

</div>


<script type="text/javascript">
  $(".date").datepicker({ 
       format:'dd-mm-yyyy',
defaultDate:  "0d",
maxDate: 0,
minDate: new Date(01, 01, 2000)
});



</script>
@if(session('status'))
<script type="text/javascript">
      Command: toastr["success"]("Saved!")
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

@if($errors->has('amount'))
<script type="text/javascript">
  $('payment_modal').modal();
</script>
@endif
@endsection
