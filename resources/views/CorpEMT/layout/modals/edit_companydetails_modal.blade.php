<div class="modal fade modal-default" id="edit-companydetails" tabindex="-1" role="dialog" aria-labelledby="companyDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="{{url('corpemt/client/updatecompanydetails')}}" class="form-horizontal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pencil"></i> Edit Company Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class='col-sm-12'>Company Name</label>
                                    <div class="col-sm-12">
                                        <input type="text" name="company_name" class="form-control" value="{{$details->client_company}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class='col-sm-12'>Company Phone Number</label>
                                    <div class="col-sm-12">
                                        <input type="text" name="company_phone" class="form-control" value="{{$details->company_phone}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Company Website</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="company_website" value="{{$details->company_url}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Company Address</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" name="company_address">{{$details->company_address}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Company Description</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" name="company_description">{{$details->company_description}}</textarea>
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