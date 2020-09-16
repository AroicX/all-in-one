<div class="modal fade modal-default" id="add-management" tabindex="-1" role="dialog" aria-labelledby="addManagerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="{{url('corpemt/engagement/addmanagement')}}" class="form-horizontal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> Management</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                          <div class="row">
                            <div class="col-sm-4">
                                <label class="col-sm-12">Title <span class="text-danger">*required</span></label>
                                <div class="col-sm-12">
                                    <select class="form-control" name="title">
                                        <option value="">--SELECT--</option>
                                        <option value="Mr.">Mr.</option>
                                        <option value="Mrs.">Mrs.</option>
                                        <option value="Miss.">Miss.</option>
                                        <option value="Dr.">Dr.</option>
                                        <option value="Prof.">Prof.</option>
                                        <option value="Engr.">Engr.</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <label class="col-sm-12">Full Name <span class="text-danger">*required</span></label>
                                <div class="col-sm-12">
                                    <input type="text" name="fullname" class="form-control">
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="col-sm-12">Position <span class="text-danger">*required</span></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="position" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-sm-12">Working Exeprience <span class="text-danger">*required</span></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="exeprience" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Discuss any factors that should be known about key client management (i.e. experience, age, health, ease of replacement, internet checks, EASENET checks, etc.): <span class="text-danger">*required</span></label>
                            <div class="col-sm-12">
                                <textarea class="form-control" name="discuss"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-flat">Save</button>
                <input type="hidden" name="company_id" value="{{$company_id}}">
                <input type="hidden" name="deal_id" value="{{$deal_id}}">
                <input type="hidden" name="client_id" value="{{$client_id}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
        </div>
        </form>
    </div>
</div>