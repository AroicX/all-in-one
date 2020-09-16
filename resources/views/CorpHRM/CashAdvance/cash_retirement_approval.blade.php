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
                		<h5>Cash Retirement Approval</h5>
                	</div>

                	<div class="card-body">
                		<form action="{{url('corphrm/cashadvance/transaction/new')}}" method="post">
                            <div class="row">
                    			<div class="form-group col-sm-6">
    								<label for="">Transaction Date</label>
    								<input type="date" name="transaction_date" class="form-control" required="required">
    							</div>

                                <div class="form-group col-sm-6">
                                    <label for="">Cash Retirement Code </label>
                                    <input type="text" name="cash_retirement_code" class="form-control" required="required">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="">Approval Date</label>
                                    <input type="date" name="approval_date" class="form-control" required="required">
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="">Advanced Amount Disbursed</label>
                                    <input type="number" name="advanced_amount_disbursed" class="form-control" required="required">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="">Employee</label>
                                    <select name="employee" class="form-control" required="required">
                                     @foreach($profiles as $profile)
                                    <option value="{{ $profile->id }}">{{ $profile->name }}</option>
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
                                    <label for="">Approved Retirement Amount</label>
                                    <input type="number" name="approved_retirement_amount" class="form-control" required="required">
                                </div>
    
                            <div class="form-group col-sm-6">
                                    <label for="">Balance</label>
                                    <input type="number" name="balance" class="form-control" required="required">
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Doc.</label>
                                <input type="file" name="doc" class="form-control" required="required">
                            </div>
                                                       <div class="form-group col-sm-6">
                                    <label for="">Remarks</label>
                                    <textarea name="remarks" class="form-control" required="required" cols="3"></textarea>
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