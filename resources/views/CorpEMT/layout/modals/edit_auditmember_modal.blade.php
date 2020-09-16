<div class="modal fade modal-default" id="edit-auditmember" tabindex="-1" role="dialog" aria-labelledby="addManagerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="{{url('corpemt/engagement/editauditcommittee')}}" class="form-horizontal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i>Edit Audit Committee Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                          <div class="row">
                            <div class="col-sm-8">
                                <label class="col-sm-12">Full Name <span class="text-danger">*required</span></label>
                                <div class="col-sm-12">
                                    <input type="text" name="fullname" class="form-control" id="a-fullname">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label class="col-sm-12">Position <span class="text-danger">*required</span></label>
                                <div class="col-sm-12">
                                    <select class="form-control" name="position" id="a-position">
                                        <option value="">--SELECT--</option>
                                        <option value="chairman">Chairman</option>
                                        <option value="member">Member</option>
                                    </select>
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-flat">Save</button>
                <input type="hidden" name="committee_id" id="committee-id">
                <input type="hidden" name="client_id" value="{{$client_id}}">
                <input type="hidden" name="deal_id" value="{{$deal_id}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
        </div>
        </form>
    </div>
</div>