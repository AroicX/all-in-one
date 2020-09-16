@extends('CorpHRM.layout.master')
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
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
                    <h5>Leave Credit </h5>
                    <a href="{{url('corphrm/leavecredit')}}">
                        <button class="btn btn-primary btn-sm" style="float:right;">Return Back</button>
                    </a>

                </div>

                <div class="card-body">
                    <form class="row" action="{{route('corphrm.leavecreditform')}}" method="post">
                        <div class="form-group col-sm-6">
                            <label for="effective_date">Effective Date:</label>
                            <input type="date" name="effective_date" class="form-control" required="required">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Employee Name</label>
                            <select name="employee_id" id="employee_id" data-live-search="true" class="form-control">
                                <option>Select one</option>
                                @foreach($profiles as $profile)
                                <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="leave_type">Leave Type:</label>

                            <select name="leave_type" id="leave_type" data-live-search="true" class="form-control">
                                <option>Select one</option>
                                @foreach($masters as $master)
                                <option value="{{ $master->id }}">{{ $master->name }}</option>
                                @endforeach
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
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

    $('select').selectpicker();
</script>
@stop