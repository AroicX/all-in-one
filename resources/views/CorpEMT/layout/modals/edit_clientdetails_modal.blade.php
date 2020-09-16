<div class="modal fade modal-default" id="edit-clientdetails" tabindex="-1" role="dialog" aria-labelledby="clientDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="{{url('corpemt/client/updatepersonaldetails')}}" class="form-horizontal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pencil"></i> Edit Personal Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class='col-sm-12'>Full Name</label>
                                    <div class="col-sm-12">
                                        <input type="text" name="name" class="form-control" value="{{$details->name}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class='col-sm-12'>Job Title</label>
                                    <div class="col-sm-12">
                                        <input type="text" name="job_title" class="form-control" value="{{$details->job_title}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class='col-sm-12'>Phone Number</label>
                                    <div class="col-sm-12">
                                        <input type="tel" name="phone" class="form-control" value="{{$details->phone}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class='col-sm-12'>Email</label>
                                    <div class="col-sm-12">
                                        <input type="email" name="email" class="form-control" value="{{$details->email}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Url</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="url" value="{{$details->url}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Address</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" name="address">{{$details->address}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="col-sm-12">Country</label>
                                    <div class="col-sm-12">
                                        <input type="text" name="country" class="form-control" value="{{$details->country}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-sm-12">State</label>
                                    <div class="col-sm-12">
                                        <input type="text" name="state" class="form-control" value="{{$details->state}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="form-group">
                            <div class="row">
                                 <div class="col-sm-6">
                                    <label class="col-sm-12">City</label>
                                    <div class="col-sm-12">
                                        <input type="text" name="city" class="form-control" value="{{$details->city}}">
                                    </div>
                                </div>
                                 <div class="col-sm-6">
                                    <label class="col-sm-12">Zip Code</label>
                                    <div class="col-sm-12">
                                        <input type="text" name="zip" class="form-control" value="{{$details->zip}}">
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