@extends('CorpHRM.layout.master')

@section('content')
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                @if(isset($success))
                <div class="alert alert-success">* Successfully Added</div>
                @endif
                <div class="card card-primary">
                    <div class="card-header with-border">
                        <h5>Cash Advance Retirement</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{url('corphrm/cashadvance/retirement/new')}}" method="post">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="">Transaction Date</label>
                                    <input type="date" name="transaction_date" class="form-control" required="required">
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="">Advance Retirement Code</label>
                                    <input type="text" value="{{$retirment_code}}" readonly="" name="retirement_code" class="form-control" required="required">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="">Advance Disbursed</label>
                                    <select name="disbursment_id" class="form-control" required="required">
                                    @foreach($result_disbursments as $result_disbursment)
                                        <option value="{{$result_disbursment['id']}}">{{$result_disbursment['name']}}::amount Left-> {{$result_disbursment['amount_left']}}</option>
                                    @endforeach
                                    </select>
                                </div>

                            
                            <div class="form-group col-sm-6">
                                   <label for="">Retirement Amount</label>
                                    <input type="number" name="retirement_amount" class="form-control" required="required">
                                </div>
                                </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                  <label for="">Attached Doc.</label>
                                    <input type="file" name="upload_doc" class="form-control" required="required">
                                </div>

                            <div class="form-group col-sm-6">
                                    <label for="">Remarks</label>
                                    <textarea name="remarks" class="form-control" required="required" cols="3"></textarea>
                                </div>
                            </div>
                            
                            <div class="col-sm-12 text-center">
                                <button type="submit" id="add_claim" class="btn btn-primary">Add</button>
                            </div>
                            {{csrf_field()}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop