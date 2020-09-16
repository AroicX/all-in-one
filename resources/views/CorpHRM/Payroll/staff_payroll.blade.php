@extends('CorpHRM.layout.master')

@section('content')
<section class="content">
    <div class="row">

        <div class="col-md-12">
            @if(isset($success))
            <div class="alert alert-success">* Successfully Added</div>
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
            <div class="card card-primary">
                <div class="card-header with-border">
                    <h5>Employee Payslip</h5>
                </div>
                <div class="card-body table-responsive" id="BlockUI">
                   
                            <div class="col-md-12" style="padding-top:30px;">
                                <div class="col-md-3">
                                    <p><b>Pension till date</b>: {{$additions['pension']}}</p>
                                </div>
                                <div class="col-md-3">
                                    <p><b>PAYEE till date</b>: {{$additions['paye']}}</p>
                                </div>
                                <div class="col-md-3">
                                    <p><b>NHF till date</b>: {{$additions['nhf']}}</p>
                                </div>
                                <div class="col-md-3">
                                    <p><b>NHIS till date</b>: {{$additions['nhis']}}</p>
                                </div>
                            </div>

                            <div class="col-md-12" style="padding-top:10px;">
                                {{--  <form method="GET" action="{{ url('corphrm/payroll/generate') }}/{{ Auth::user()->id }}">
                                --}}
                                <div class="form-group">
                                    <center>
                                        <label>Generate Payslip For Previous Month</label>
                                    </center>
                                    <div class="row py-2 px-3">
                                        @if($salary['wages_type'] == "daily" || $salary['wages_type'] == "Daily")
                                        <div class="col-md-3">
                                            <select class="form-control col-md-6" id="payslip_day" required=""
                                                name="day">
                                                <option value="">Choose Day</option>
                                                @for($i=0;$i<31;$i++) <option value="$i">$i</option>
                                                    @endfor
                                            </select>
                                        </div>
                                        @endif
                                        <div class="col-md-3">
                                            <select class="form-control col-md-6" id="payslip_month" required=""
                                                name="month">
                                                <option value="">Choose Month</option>
                                                <option value="01">January</option>
                                                <option value="02">Febuary</option>
                                                <option value="03">March</option>
                                                <option value="04">April</option>
                                                <option value="05">May</option>
                                                <option value="06">June</option>
                                                <option value="07">July</option>
                                                <option value="08">August</option>
                                                <option value="09">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control" id="payslip_year" required="" name="year">
                                                <option value="">Choose Year</option>
                                                <?php for($i = 2000; $i <= date('Y'); $i++){ ?>
                                                <option><?php echo $i; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3" style="">
                                            <button type="submit" onclick="generate_payslip()"
                                                class="btn btn-primary">Generate</button>
                                        </div>
                                    </div>
                                    {{--  </form>  --}}
                                    <div style="padding-top:15px;">
                                        {{--  <h1 style="text-align:center; text-transform:uppercase;">Payroll for current month.</h1>  --}}
                                       
                                    </div>
                                </div>
                            </div>

                            <iframe id="payslip-frame"
                                style="width:100%; height:600px; border-color:#FFFFFF; border:0px !important;"
                                src="{{ url('corphrm/payroll/generate') }}/<?php echo $uid; ?>
                                    ?month={{ date('m') }}
                                    &year={{ date('Y') }}
                                    &type=payslip
                                    <?php if($salary['wages_type'] == 'daily' || $salary['wages_type'] == 'Daily'){ ?>
                                    &day=<?php echo date('d'); ?>
                                    <?php } ?>">
                            </iframe>

                        </div>
                    </div>
                </div>
</section>
<!--upload scores Modal -->

<script src="{{asset('calendar/js/jquery.min.js')}}"></script>
<script>
    function generate_payslip() {
        var day = $("#payslip_day").val();
        var month = $("#payslip_month").val();
        var year = $("#payslip_year").val();
        if (month == "" || year == "" < ? php
            if ($salary['wages_type'] == 'daily' || $salary['wages_type'] == 'Daily') {
                ?
                > || day == "" < ? php
            } ? > ) {
            alert(
                "select respective <?php if($salary['wages_type'] == 'daily' || $salary['wages_type'] == 'Daily'){ ?>Day and <?php } ?> Month and Year!"
                );
            return false;
        }
        var url = "{{ url('corphrm/payroll/generate') }}/<?php echo $uid; ?>?month=" + month + "&year=" + year +
            "&type=payslip <?php if($salary['wages_type'] == 'daily' || $salary['wages_type'] == 'Daily'){ ?>&day=" +
            day + "<?php } ?>";
        document.getElementById('payslip-frame').src = url;
    }
</script>
@stop