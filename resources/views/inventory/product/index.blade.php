@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Product</h5>
                <span class="d-block m-t-5">Products</span>
            </div>
            <div class="card-body table-border-style">
                <div class="box box-primary">
                        <form class="row mb-4">
                                    <div class="col-md-3">
                                        <div class="form-group custom-search-form">
                                              <input type="search" name="q" id= "search" class="form-control search-input" placeholder = "Enter product name, barcode or batch number">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                              <select name="product_line" class="form-control">
                                                    @foreach($product_lines as $product_line)
                                                    <option value="{{$product_line->id}}">{{$product_line->name}}</option>
                                                    @endforeach
                                              </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                              <button type="submit" class="btn btn-primary float-left" >Search</button>
                                        </div>
                                    </div>
                              </form>
                    </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <th>Barcode</th>
                            <th>Batch No</th>
                            <th>Description</th>
                            <th>Store Keeping Unit</th>
                            <th>View Details</th>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{$product->barcode}}</td>
                                    <td>{{$product->batch_no}}</td>
                                    <td>{{$product->description}}</td>
                                    <td>{{$product->SKU}}</td>
                                    <td><a class="btn btn-primary" href="{{route('product.show', $product->id)}}"><i class = "fa fa-eye"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>        
                    </table>
                </div>
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