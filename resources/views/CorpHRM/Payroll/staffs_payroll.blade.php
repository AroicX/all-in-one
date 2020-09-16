@extends('CorpHRM.layout.master')
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
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
                    <h5>Payroll</h5>
                </div>
                <div class="row" style="padding:70px; ">
                    <center>
                        <div class="form-group">
                            <label>Generate Payroll For Current Month</label>
                            <br>
                            <form action="{{ url('corphrm/payroll/generate') }}" target="_blank" method="GET">
                                <div class="row" style="margin-bottom:30px;">
                                    <input type="hidden" name="month" value="{{ date('m') }}">
                                    <input type="hidden" name="year" value="{{ date('Y') }}">
                                    <div class="form-group col-md-6">
                                        <label>Filter By Grade</label>
                                        <select class="form-control" data-live-search="true" name="grade">
                                            <option value="0"></option>
                                            @foreach($grades as $grade)
                                            <option value="{{$grade->id}}">{{$grade->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Filter By Department</label>
                                        <select class="form-control" data-live-search="true" name="department">
                                            <option value="0"></option>
                                            @foreach($departments as $department)
                                            <option value="{{$department->id}}">{{$department->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <br>
                                {{--  <a href="">  --}}
                                <button class="btn btn-primary">Generate</button>
                                {{--  </a>      --}}
                        </div>
                        </form>
                        <form method="GET" target="_blank" action="{{ url('corphrm/payroll/generate') }}">
                            <div class="form-group">
                                <label>Generate Payroll For Previous Month</label>
                                <div class="row">
                                    

                                        <div class="form-group col-md-12">
                                            <label>Choose Month</label>
                                            <select class="form-control" required="" name="month">
                                                <option value=""></option>
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

                                        <div class="form-group col-md-12">
                                            <label>Choose Year</label>
                                            <select class="form-control" required="" name="year">
                                                <option value=""></option>
                                                <?php for($i = 2000; $i <= date('Y'); $i++){ ?>
                                                <option><?php echo $i; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Filter By Grade</label>
                                            <select class="form-control" data-live-search="true" name="grade">
                                                <option value="0"></option>
                                                @foreach($grades as $grade)

                                                <option value="{{$grade->id}}">{{$grade->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Filter By Department</label>
                                            <select class="form-control" data-live-search="true" name="department">
                                                <option value="0"></option>
                                                @foreach($departments as $department)
                                                <option value="{{$department->id}}">{{$department->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group" style="padding-top: 20px;">
                                        <button class="btn btn-primary">Generate</button>
                                    </div>
                                </div>
                        </form>
                </div>
                </center>
            </div>

        </div>
    </div>
    </div>
</section>
<script src="{{asset('calendar/js/jquery.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<!--upload scores Modal -->

<script src="{{asset('calendar/js/jquery.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('select').selectpicker();
    });
</script>
@stop