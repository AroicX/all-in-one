@extends('layouts.setup')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Setup Your Company - General Information</h5>
                <span class="d-block m-t-5">Setup</span>
            </div>
            <div class="card-body">
                <form id="setup1" action="" method="post">
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="url" id="url" value="{{url('')}}">
                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label>Company Name <span class="required">*</span></label>
                                        <input type="text" name="name" class="form-control" placeholder="Enter Company Name"
                                               required="required" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label>Company Registration Number <span class="required">*</span></label>
                                        <input type="text" name="crn" class="form-control"
                                               placeholder="Enter Company Registration Number" required="required" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Country of operation <span class="required">*</span></label>
                                        <select class="selectpicker form-control country" id="country"
                                                data-live-search="true" name="country" placeholder="" required>
                                            <option value="">Choose Country</option>
                                            <?php foreach (App\Country::all() as $country) { ?>
                                            <option value="{{ $country->id }}" id="{{ $country->id }}">
                                                {{ $country->name }}
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>State of operation <span class="required">*</span></label>
                                            <select id="state" data-live-search="true" name="state" class="form-control"
                                                    required></select>
                                        </div>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label>City of operation <span class="required">*</span></label>
                                        <input type="text" name="city" class="form-control" placeholder="Enter City"
                                               required="required" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label>Business Address <span class="required">*</span></label>
                                        <input type="text" name="address" class="form-control"
                                               placeholder="Business Address" required="required" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group" style="">
                                        <label>Phone Number <span class="required">*</span></label>
                                        <input type="text" name="phone" class="form-control" placeholder="Phone Number"
                                               required>
                                    </div>
                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group" style="">
                                        <label>Email-Address <span class="required">*</span></label>
                                        <input type="text" name="email" class="form-control"
                                               value="{{ Auth::user()->email }}" placeholder="Email Address" required>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                <button class="btn btn-primary btn-sm pull-right">continue</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection