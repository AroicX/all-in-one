@extends('CorpHRM.layout.master')

@section('content')
<section class="content">
    <div class="row">
        @if(isset($success))
        <div class="alert alert-success">Successfully added</div>
        @endif
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header with-border">
                    <h5>Loan Disbursement </h5>
                    <a href="{{url('corphrm/loandisbursement')}}">
                        <button class="btn btn-primary btn-sm" style="float:right;">Return Back</button>
                    </a>

                </div>

                <div class="card-body">
                    <form class="row" action="{{route('corphrm.loandisbursementform')}}" method="post">
                        <div class="form-group col-sm-6">
                            <label for="transaction_id">Transaction id:</label>
                            <input type="text" name="transaction_id" value="{{ $transaction_id }}" class="form-control"
                                required="required" readonly="">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Employee Name</label>
                            <select name="employee_id" id="employee_id" class="form-control">
                                <option>Select one</option>
                                @foreach($profiles as $profile)
                                <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Loan Name</label>
                            <select name="loan_id" id="loan_id" class="form-control">
                                <option>Select one</option>
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="disbursement_amount">Disbursement Amount:</label>
                            <input type="text" name="disbursement_amount" id="disbursement_amount" class="form-control"
                                readonly="" required="required">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Mode of Disbursement</label>
                            <select name="mode_of_disbursement" class="form-control">
                                <option value="cash">Cash</option>
                                <option value="transfer">Transfer</option>
                                <option value="cheque">Cheque</option>
                            </select>
                        </div>

                        <div class="form-group col-sm-12">
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{asset('calendar/js/jquery.min.js')}}"></script>
<script type="text/javascript">
    $("#employee_id").change(function (e) {
        //alert("okay")
        var id = $(this).val();
        $.ajax({
            type: "GET",
            url: "{{url('corphrm/get/get_loan')}}/" + id,
            // dataType: "html",
            success: function (data) {
                for (var key in data) {
                    var sel = document.getElementById('loan_id');
                    var opt = document.createElement('option');
                    opt.text = data[key].text;
                    opt.value = data[key].value;
                    sel.appendChild(opt);

                }
            }
        });

    });

    $("#loan_id").change(function (e) {
        //alert("okay")
        var id = $(this).val();
        $.ajax({
            type: "GET",
            url: "{{url('corphrm/get/disbursement_amount')}}/" + id,
            // dataType: "html",
            success: function (data) {
                $("#disbursement_amount").val(data);
            }
        });

    });
</script>
@stop