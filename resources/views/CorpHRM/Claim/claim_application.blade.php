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
                    <h5>Claim Application </h5>
                    <a href="{{url('corphrm/claim_applications')}}">
                        <button class="btn btn-primary btn-sm" style="float:right;">Return Back</button>
                    </a>

                </div>

                <div class="card-body">
                    <form action=" @if($action == " Edit") @else
                        {{route('corphrm.claim_application',['id'=> $trans_id])}} @endif " method=" post" files="true"
                        enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="">Transaction ID</label>
                                <input type="number" name="transaction_id" @if($action=="Edit" )disabled="disabled"
                                    @if($app['transaction_id']) value="{{$app['transaction_id']}}" @endif @else
                                    value="{{$trans_id}}" @endif class="form-control" disabled="disabled">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Transaction Date</label>
                                <input type="date" name="transaction_date" @if($action=="Edit" )disabled="disabled"
                                    @if($app['transaction_date'])value="{{$app['transaction_date']}}" @endif @else
                                    value="" @endif class="form-control" required="required">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-9">
                                <label for="">Employee Name</label>
                                <input type="text" name="employee_name" @if($action=="Edit" )disabled="disabled"
                                    @if($app['employee_name'])value="{{$app['employee_name']}}" @endif @else value=""
                                    @endif class="form-control" required="required" readonly="">
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="">Claim Date</label>
                                <input type="date" name="claim_date" @if($action=="Edit" )disabled="disabled"
                                    @if($app['claims_date'])value="{{$app['claims_date']}}" @endif @else value="" @endif
                                    class="form-control" required="required">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="">Expense Type</label>
                                <input type="text" name="expense_type" @if($action=="Edit" )disabled="disabled"
                                    @if($app['expense_type'])value="{{$app['expense_type']}}" @endif @else value=""
                                    @endif class="form-control" required="required">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Amount</label>
                                <input type="number" name="amount" @if($action=="Edit" )disabled="disabled"
                                    @if($app['amount'])value="{{$app['amount']}}" @endif @else value="" @endif
                                    class="form-control" required="required">
                                <input type="hidden" name="claimmaster_id" value="{{ $claimmaster['id'] }}">
                                @if($action != "Edit")
                                <p style="color: red;">Maximum amount allocated is {{ $claimmaster['max_limit'] }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="">Purpose</label>
                                <textarea class="form-control" @if($action=="Edit" )disabled="disabled"
                                    @if($app['purpose'])value="{{$app['purpose']}}" @endif @endif name="purpose"
                                    required="required"></textarea>
                            </div>
                        </div>
                        @if($action != "Edit")
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="">Attach doc.</label>
                                <input type="file" name="doc" class="form-control" required="required">
                            </div>
                        </div>
                        @endif
                        <div class="col-sm-12 text-center">
                            {{csrf_field()}}
                            @if($action != "Edit")
                            <button type="submit" id="submit-claim" class="btn btn-create">Submit</button>
                            @endif
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@stop

@section('script')
<script type="text/javascript">
    $(document).ready(function () {

    });
</script>
@stop