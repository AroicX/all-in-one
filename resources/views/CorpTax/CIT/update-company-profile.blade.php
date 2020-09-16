@extends('CorpTax.layout.master')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Company Profile</h5>
                </div>
                <div class="card-body">
                    <form role="form">

                        {{--$dummyData = ['company_name'=> 'okeke and sons',--}}
                        {{--'tax_id'=>'er33433d',--}}
                        {{--'incorporation_date'=>'01/03/2017',--}}
                        {{--'registered_address' =>'22 close umuahia',--}}
                        {{--'state'=>'Lagos',--}}
                        {{--'LGA'=>'Amuwo Odofin',--}}
                        {{--'business_address'=>'01/03/2017',--}}
                        {{--'b_state'=>'Lagos',--}}
                        {{--'b_LGA'=>'Amuwo Odofin',--}}
                        {{--'YOA'=>'2016',--}}
                        {{--'YOAc'=>'2015',--}}

                        {{--];--}}
                        @if(!empty($Profile))
                        <div class="row">

                            <div class="form-group col-sm-4">
                                <label for="">Company Name</label>
                                <input type="text" class="form-control" placeholder="Company Name"
                                    value="{{$Profile['company_name'] ? $Profile['company_name'] :''}}">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="">Tax Identification Number</label>
                                <input type="text" class="form-control" placeholder="Tax Identification Number"
                                    value="{{$Profile['tax_id'] ? $Profile['tax_id'] : ''}}">
                            </div>

                            <div class="form-group col-sm-4">
                                <label for="">Date of incorporation </label>
                                <input type="text" class="form-control" placeholder="Date of incorporation">
                            </div>

                            <div class="form-group col-sm-4">
                                <label for="">Registered Address</label>
                                <input type="text" class="form-control" placeholder="Registered Address">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="">State</label>
                                <input type="text" class="form-control" placeholder="State">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="">Local Government</label>
                                <input type="text" class="form-control" placeholder="Local Government">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="">Business Address</label>
                                <input type="text" class="form-control" placeholder="Business Address">
                            </div>

                            <div class="form-group col-sm-4">
                                <label for="">State</label>
                                <input type="text" class="form-control" placeholder="State">
                            </div>

                            <div class="form-group col-sm-4">
                                <label for="">Local government</label>
                                <input type="text" class="form-control" placeholder="Local government">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="">Describe Major Business Activities</label>
                                <input type="text" class="form-control"
                                    placeholder="Describe Major Business Activities">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="">Date of commencement business operations</label>
                                <input type="text" class="form-control"
                                    placeholder="Date of commencement business operations">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="">Year of assessment</label>
                                <input type="text" class="form-control" placeholder="Year of assessment">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="">Yeah of account</label>
                                <input type="text" class="form-control" placeholder="Yeah of account">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="">Existing or new company</label>
                                <select name="" id="" class="form-control">
                                    <option value="" disabled selected>Existing or new company</option>
                                    <option value="">Existing</option>
                                    <option value="">New</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="">Company industry</label>
                                <input type="text" class="form-control" placeholder="Company industry">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="">Type of company</label>
                                <select name="" id="" class="form-control">
                                    <option value="">Incorporated</option>
                                    <option value="">Un-incorporated</option>
                                    <option value="">non-resident</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for=""> Company Share Capital(Local Ownership)</label>
                                <input type="text" class="form-control" placeholder="Company Share Capital">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="">Company Share Capital(Foreign Ownership)</label>
                                <input type="text" class="form-control" placeholder="Loss on exchange differences">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="">Is this the first year of filing?</label>
                                <select name="" id="" class="form-control">
                                    <option value="" selected disabled>first year of filing?</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="">Is this an ammended return ?</label>
                                <select name="" id="" class="form-control">
                                    <option value="" disabled selected>Ammended return ?</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="">Company's year of account changed since last returns ?</label>
                                <select name="" id="year-of-account" class="form-control">
                                    <option value="" disabled selected>Year of account changed since last returns ?
                                    </option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-4 hide">
                                <label for="">Reason</label>
                                <input type="text" class="form-control" placeholder="Reason">
                            </div>
                            <div class="form-group col-sm-4 hide">
                                <label for="">New Year of account</label>
                                <input type="text" data-provide="datepicker" class="form-control"
                                    placeholder="New Date">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="">Is company resident in nigeria ?</label>
                                <select name="" id="year-of-account" class="form-control">
                                    <option value="" disabled selected>Company resident in nigeria?</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-4 hide">
                                <label for="">Country of residence</label>
                                <input type="text" class="form-control" placeholder="Country of residence">
                            </div>

                        </div>
                        @endif
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button class="btn btn-info">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection