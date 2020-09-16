<div class="modal fade modal-default" id="add-item" tabindex="-1" role="dialog" aria-labelledby="addManagerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="{{url('corpemt/engagement/addengagementitem')}}" class="form-horizontal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Add Item</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-7">
                                    <label class="col-sm-12">Full Name <span class="text-danger">*required</span></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="fullname" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <label class="col-sm-12">Designation <span class="text-danger">*required</span></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="designation" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="col-sm-12">Hours <span class="text-danger">*required</span></label>
                                    <div class="col-sm-12">
                                        <input type="number" name="hours" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <label class="col-sm-12">Rate <span class="text-danger">*required</span></label>
                                    <div class="col-sm-12">
                                        <input type="number" name="rate" class="form-control">
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