<div class="modal fade modal-default" id="add-action" tabindex="-1" role="dialog" aria-labelledby="ActionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="{{url('corpemt/client/addaction')}}" class="form-horizontal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-briefcase"></i> Add Action</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-sm-12">Note</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" name="note"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-sm-4">
                              <label class="col-sm-12">Schedule</label>
                              <div class="col-sm-12">
                                  <select class="form-control" name="schedule">
                                    <option value="queued">Queued</option>
                                    <option value="date">Date</option>
                                    <option value="datetime">Date &amp; Time</option>
                                    <option value="asap">ASAP</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <label class="col-sm-12">Date</label>
                              <div class="col-sm-12">
                                <div class='input-group input-append date'>
                                    <input type='text' class="form-control" placeholder="Enter Date" name="date">
                                    <span class="input-group-addon add-on">
                                       <i class="fa fa-calendar fa-fw"></i>
                                    </span>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <label class="col-sm-12">Time</label>
                              <div class="col-sm-12">
                                <div class="input-group clockpicker" data-placement="bottom" data-align="left" data-autoclose="true">
                                    <input type="text" class="form-control" value="" name="time" placeholder="Enter Time">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
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
                <input type="hidden" name="client_id" value="{{$details->id}}">
                <input type="hidden" name="company_id" value="{{$details->company_id}}">
                <input type="hidden" name="unique_id" value="{{$details->unique_id}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
        </div>
        </form>
    </div>
</div>