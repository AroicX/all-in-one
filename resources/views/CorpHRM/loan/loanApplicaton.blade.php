@extends('CorpHRM.layout.master')

@section('content')
<section class="content">
    <div class="row">
        @if(isset($success))
        <div class="alert alert-success">Successfully added</div>
        @endif
        @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}.
        </div>
        @elseif(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}.
        </div>
        @endif

        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header with-border">
                    <h5>Loan Application</h5>
                        <a href="{{url('corphrm/loanapp')}}">
                            <button class="btn btn-primary btn-sm" style="float:right;">Return Back</button>
                        </a>
                    
                </div>

                <div class="card-body">

                    <div class="alert alert-warning multiple_loan_message" style="display:none;">
                        If you have any pending loan to be complted, this application will be not be processed!
                    </div>
                    <form class="row" action="{{route('corphrm.loanappform')}}" method="post">
                        <div class="form-group col-sm-6">
                            <label for="application_ref">Application Ref:</label>
                            <input type="text" name="application_ref" value="{{ $app_ref }}" class="form-control"
                                required="required" readonly="">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="application_date">Application Date:</label>
                            <input type="date" name="application_date" class="form-control" required="required">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Loan Master</label>
                            <select name="loanmaster_id" id="loanmaster_id" class="form-control loanmaster_id">
                                <option value="" data-lml="0">select one</option>
                                @foreach($loanmasters as $loanmaster)
                                <option value="{{$loanmaster->id}}" data-multiple_loan="{{$loanmaster->multiple_loan}}"
                                    data-lml="{{$loanmaster->loan_maximum_limit}}">{{$loanmaster->loan_name}} (<span
                                        style="color: red !important;">Maximum Limit:
                                        {{$loanmaster->loan_maximum_limit}}</span>)</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="contact_number">Contact Number:</label>
                            <input type="text" name="contact_number" value="{{ Auth::user()->phone }}"
                                class="form-control" required="required">
                        </div>

                        <!--                                 <div class="form-group col-sm-6">
                                    <label>Loan Name</label>
                                    <select name="loan_id" class="form-control">
                                        @foreach($loanDetails as $detail)
                                        <option value="{{$detail->id}}">{{$detail->loan_name}} (Limit: {{$detail->loan_maximum_limit}})</option>
                                        @endforeach
                                    </select>
                                </div> -->

                        <!--                                 <div class="form-group col-sm-6">
                                    <label for="loan_max_limit">Loan Max limit:</label>
                                    <input type="text" name="loan_max_limit" class="form-control" required="required">
                                </div> -->

                        <div class="form-group col-sm-6">
                            <label for="loan_amount">Loan Amount:</label>
                            <input type="number" onkeyup="handle_max_limit(this)" name="loan_amount"
                                class="form-control loan_amount key" id="loan_amount" required="required">
                            <p style="color: red;"><span id="loan_maximum_limit"></span> </p>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="no_of_installments">No of installments:</label>
                            <input type="number" name="no_of_installments" class="form-control no_of_installments key"
                                id="no_of_installments" required="required">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="installment_amount">Installment Amount:</label>
                            <input type="number" name="installment_amount" class="form-control installment_amount"
                                id="installment_amount" readonly="">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Remarks:</label>
                            <textarea name="remarks" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Loan Doc (if applicable)</label>
                            <input name="doc_file" type="file">
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

@stop
<script src="{{asset('calendar/js/jquery.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".installment_amount").val("0");
        $(".key").val("");

        function calc() {

            var $loan_amount = ($.trim($(".loan_amount").val()) != "" && !isNaN($(".loan_amount").val())) ?
                parseInt($(".loan_amount").val()) : 0;
            //console.log($loan_amount);
            var $no_of_installments = ($.trim($(".no_of_installments").val()) != "" && !isNaN($(
                ".no_of_installments").val())) ? parseInt($(".no_of_installments").val()) : 0;
            // console.log($no_of_installments);
            if ($(".loan_amount").val() == "") {
                $(".installment_amount").val($no_of_installments);
            } else if ($(".no_of_installments").val() == "") {
                $(".installment_amount").val($loan_amount);
            } else {
                $(".installment_amount").val($loan_amount / $no_of_installments);
            }
        }
        $(".key").keyup(function () {
            calc();
        });
        $('.loanmaster_id').change(function () {
            var multiple_loan = $('.loanmaster_id option:selected').data('multiple_loan');

            if (multiple_loan == "0") {
                $('.multiple_loan_message').show();
            } else {
                $('.multiple_loan_message').hide();
            }
        });

    });

    function handle_max_limit(input) {

        var max_limit = $('.loanmaster_id option:selected').data('lml');
        if (max_limit == "0") {
            alert("choose a loan master");
            return false;
        }

        if (input.value < 0) {
            input.value = 0;
        }
        if (input.value > max_limit) {

            input.value = max_limit;
            alert("Maximum loan limit is: " + max_limit);
        }
    }
</script>