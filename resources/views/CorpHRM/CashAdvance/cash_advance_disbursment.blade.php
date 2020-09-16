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
                		<h5>Cash Advance Disbursment</h5>
                	</div>

                	<div class="card-body">
                		<form action="{{url('corphrm/cashadvance/disbursment/new')}}" method="post">
                            <div class="row">
                    			<div class="form-group col-sm-6">
    								<label for="">Disbursment Date</label>
    								<input type="date" name="disbursment_date" class="form-control" required="required">
    							</div>

                                <div class="form-group col-sm-6">
                                    <label for="">Approval Code </label>
                                    <input type="text" name="approval_code" class="form-control" required="required">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="">Approved Date</label>
                                    <input type="date" name="approved_date" class="form-control" required="required">
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="">Approved Amount</label>
                                    <input type="number" name="approved_amount" class="form-control" required="required">
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
                                    <label for="">Payment Mode</label>
                                    <select name="payment_mode" class="form-control" required="required">
                                    <option value="Cash">Cash</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="Transfer">Transfer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="">Bank</label>
                                    <select name="bank" class="form-control" required="required">
                                    <option value="Bank A">Bank A</option>
                                    <option value="Bank B">Bank B</option>
                                    </select>
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