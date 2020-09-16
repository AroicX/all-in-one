
@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Edit Product</h5>
                <span class="d-block m-t-5">Products</span>
            </div>
            <div class="card-body table-border-style">
                
                <form  action="{{route('product.update', $product->id)}}" method="post">
                    {{method_field('PATCH')}}
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label>Product serial No.</label>
                                        <input type="text" name="serial_no" class="form-control" value="{{$product->serial_no}}" placeholder="Enter Product serial number"
                                               required>
                                    </div>
                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label>Product purchase date</label>
                                        <input type="date" name="purchase_date" class="form-control"
                                            value="{{$product->purchase_date}}"   placeholder="yyyy-mm-dd" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label>Product description</label>
                                        <input type="text" name="description" class="form-control"
                                             value="{{$product->description}}"  placeholder="Enter product description" required>
                                    </div>
                                </div>
                                 <div class="col-sm-6">

                                    <div class="form-group">
                                        <label>Stock Keeping Unit</label>
                                        <input type="text" name="SKU" class="form-control"
                                            value="{{$product->SKU}}"   placeholder="Enter stock keeping unit" required>
                                    </div>
                                </div>
                              
                            </div>

                            <div class="row">
                                
                                <div class="col-sm-6">

                                    <div class="form-group" style="">
                                        <label>Margin Control</label>
                                        <input type="text" name="margin_control" class="form-control" placeholder="Enter Margin Control"
                                            value="{{$product->margin_control}}"   required>
                                    </div>
                                        </div>
                                   <div class="col-sm-6">
                                     <div class="form-group">
                                        <label>Product Price Method</label>
                                        <select class="selectpicker form-control "
                                               name="price_method" placeholder="" required>
                                            <option value="{{$product->price_method}}" disabled selected>{{$product->price_method}}</option>
                                            <option value="Margin Based">Margin Based</option>
                                            <option value="Target profit Based">Target Profit Based</option>
                                            <option value="User defined">User defined</option>
                                            <option value="Flexible">Flexible</option>
                                        </select>
                                    </div>
                                   </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group" style="">
                                        <label>Price Setting</label>
                                        <input type="text" name="price_setting" class="form-control" placeholder="Price setting"
                                            value="{{$product->price_setting}}"   required>
                                    </div>
                                </div>
                             
                            </div>
                            <br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/general/Setup.js')}}"></script>
<script type="text/javascript">
     jQuery(document).ready(function($) {
    // Set the Options for "Bloodhound" suggestion engine
    var engine = new Bloodhound({
        remote: {
            url: '/product/search?q=%QUERY%',
            wildcard: '%QUERY%'
        },
        datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
        queryTokenizer: Bloodhound.tokenizers.whitespace
    });

    $(".search-input").typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        source: engine.ttAdapter(),

        // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
        name: 'usersList',

        // the key from the array we want to display (name,id,email,etc...)
        templates: {
            empty: [
                '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
            ],
            header: [
                '<div class="list-group search-results-dropdown">'
            ],
            suggestion: function (data) {
                 alert(data);
                return '<a href="' + data.result.id + '" class="list-group-item">' + data.name + '- @' + data.result.description + '</a>'
      }
        }
    });
});
</script>
@endsection
