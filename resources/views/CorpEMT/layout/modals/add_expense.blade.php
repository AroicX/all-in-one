<div class="modal fade modal-default" id="add-expense" tabindex="-1" role="dialog" aria-labelledby="addExpense" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="{{url('corpemt/engagement/add_expense')}}" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Add Expenses</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="col-sm-12">Expense Name <span class="text-danger">*required</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" name="name" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="col-sm-12">Description <span class="text-danger">*required</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" name="description" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="col-sm-12">Amount <span class="text-danger">*required</span></label>
                                        <div class="col-sm-12">
                                            <input type="number" name="amount" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-flat">Add</button>
                    <input type="hidden" name="company_id" value="{{$company_id}}">
                    <input type="hidden" name="client_id" value="{{$client_id}}">
                    <input type="hidden" name="deal_id" value="{{$deal_id}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
            </div>
        </form>
    </div>
</div>