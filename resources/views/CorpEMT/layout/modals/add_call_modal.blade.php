<div class="modal fade modal-default" id="add-call" tabindex="-1" role="dialog" aria-labelledby="CallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="{{url('corpemt/client/addcall')}}" class="form-horizontal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-phone"></i> Add Call</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                          <div class="row">
                            <div class="col-sm-4">
                              <label class="col-sm-12">Feed Back</label>
                              <div class="col-sm-12">
                                  <select class="form-control" name="feedback">
                                    <option value="">SELECT</option>
                                    <option value="interested">Interested</option>
                                    <option value="not interested">Not Interested</option>
                                    <option value="left message">Left Message</option>
                                    <option value="no answer">No Answer</option>
                                    <option value="other">Other</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-4">
                                <label class="col-sm-12"><i class="fa fa-user"></i> Mobile</label>
                                <p class="col-sm-12"><i class="fa fa-phone"></i> {{$details->phone}} </p>
                            </div>
                            <div class="col-sm-4">
                                <label class="col-sm-12"><i class="fa fa-building"></i> Company</label>
                                <p class="col-sm-12"><i class="fa fa-phone"></i> {{$details->company_phone}} </p>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Note</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" name="note"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-flat">Save</button>
                <input type="hidden" name="client_id" value="{{$details->id}}">
                <input type="hidden" name="company_id" value="{{$details->company_id}}">
                <input type="hidden" name="unique_id" value="{{$details->unique_id}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
        </div>
        </form>
    </div>
</div>