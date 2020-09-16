@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5> Register Product</h5>
               
            </div>
            <div class="card-body">
                <form  action="{{route('product.store')}}" method="post">
                    <input type="hidden" name="order_id" value="{{$order->id}}">
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label>Product serial No.</label>
                                        <input type="text" name="serial_no" class="form-control" placeholder="Enter Product serial number"
                                               required>
                                    </div>
                                </div>
                               <div class="col-sm-6">

                                    <div class="form-group">
                                        <label>Product description</label>
                                        <input type="text" name="description" class="form-control"
                                               placeholder="Enter product description" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                
                                 <div class="col-sm-6">

                                    <div class="form-group">
                                        <label>Stock Keeping Unit</label>
                                        <input type="text" name="SKU" class="form-control"
                                               placeholder="Enter stock keeping unit" required>
                                    </div>
                                   
                                </div>
                               <div class="col-sm-6">
                                     <div class="form-group">
                                        <label>Product Price Method</label>
                                        <select id="price_method" class="selectpicker form-control "
                                            name="price_method" placeholder="" required>
                                            <option value="" disabled selected>Choose Price Method</option>
                                            <option value="Margin Based">Margin Based</option>
                                            <option value="User defined">User defined</option>       
                                            </select>
                                    </div>
                                   </div>
                            </div>

                            <div class="row">
                                
                                <div class="col-sm-6">

                                    <div class="form-group" style="" >
                                        <label>Margin Control</label>
                                        <input type="text" name="margin_control" id="margin_control" class="form-control" placeholder="Enter Margin Control"
                                            disabled>
                                    </div>
                                        </div>
                                   
                                 <div class="col-sm-6">

                                    <div class="form-group" style="">
                                        <label>Price Setting</label>
                                        <input type="text" name="price_setting" class="form-control" placeholder="Price setting"
                                               required>
                                    </div>
                                </div>
                            </div>

                            
                            <br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Save</button>
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