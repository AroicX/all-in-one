<div class="modal fade modal-default" id="add-deal" tabindex="-1" role="dialog" aria-labelledby="DealModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="{{url('corpemt/client/adddeal')}}" class="form-horizontal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-money"></i> Add Deal</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="row">
                              <div class="col-sm-6">
                                <label class="col-sm-12">Deal Name</label>
                                <div class="col-sm-12">
                                  <input type="text" name="deal_name" class="form-control">
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <label class="col-sm-12">Deal Amount (In Dollar)</label>
                                <div class="col-sm-12">
                                  <input type="text" name="deal_amount" class="form-control">
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                  <label class="col-sm-12">Expected Close Date</label>
                                  <div class="col-sm-12">
                                    <div class='input-group input-append date'>
                                        <input type='text' class="form-control" placeholder="Enter Date" name="expected_close_date">
                                        <span class="input-group-addon add-on">
                                           <i class="fa fa-calendar fa-fw"></i>
                                        </span>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-sm-12">Deal Stage</label>
                                    <div class="col-sm-12">
                                        <select name="deal_stage" class="form-control">
                                         <option value="">SELECT</option>
                                          <option value="lost">Lost</option>
                                          <option value="10">10% (Qualification)</option>
                                          <option value="25">25% (Pending)</option>
                                          <option value="50">50% (Decision)</option>
                                          <option value="75">75% (Processing)</option>
                                          <option value="90">90% (Negotiation)</option>
                                          <option value="won">Won</option>
                                        </select>
                                    </div>
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