@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Add Product Line</h5>
                <span class="d-block m-t-5">Products</span>
            </div>
            <div class="card-body table-border-style">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <form  action="{{route('productline.store')}}" method="post">

                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                 <input type="hidden" name="url" id="url" value="{{url('')}}">
                                   
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="row">
                                        <div class="col-sm-12">

                                            <div class="form-group">
                                                <label>Product Line Name</label>
                                                <input type="text" name="name" class="form-control" placeholder="Enter Product Line Name"
                                                       required>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">

                                            <div class="form-group">
                                                <label>Additional information</label>
                                                <textarea name="additional_info" class="form-control" placeholder = "Additional information about line"></textarea>
                                                
                                            </div>
                                        </div>
                                      
                                    </div>

                                   

                                  
                                    <br>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block" type="submit">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/general/Setup.js')}}"></script>
@endsection
