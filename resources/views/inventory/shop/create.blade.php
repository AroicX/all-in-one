@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Register Shop</h5>
                <span class="d-block m-t-5">Shop</span>
            </div>
            <div class="card-body table-border-style">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <form  action="{{route('shop.store')}}" method="post">

                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                 <input type="hidden" name="url" id="url" value="{{url('')}}">
                                   
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="row">
                                        <div class="col-sm-12">

                                            <div class="form-group">
                                                <label>Shop Name</label>
                                                <input type="text" name="name" class="form-control" placeholder="Enter Shop Name"
                                                       required>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">

                                            <div class="form-group">
                                                <label>shop Address</label>
                                                <input type="text" name="address" class="form-control"
                                                       placeholder="shop Address" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">

                                            <div class="form-group">
                                                <label>Country</label>
                                                <select class="selectpicker form-control country" id="country"
                                                        data-live-search="true" name="country" placeholder="" onchange="getStates()" required>
                                                    <option value="">Choose Country</option>
                                                    <?php foreach (App\Country::all() as $country) { ?>
                                                    <option value="{{ $country->name }}" id="{{ $country->id }}">
                                                        {{ $country->name }}
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>State</label>
                                                <select id="state" data-live-search="true" name="state" class="form-control"
                                                        required></select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">

                                            <div class="form-group" style="">
                                                <label>City</label>
                                                <input type="text" name="city" class="form-control" placeholder="Enter City"
                                                       required>
                                            </div>

                                            <td id="test">

                                            </td>
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
<script type="text/javascript">
    const getStates = () => {
        var id = $('#country :selected').attr('value');
        console.log(id)
        $.ajax({
            type: "GET",
            url: "{{ route("corpfin.api.state.name.get") }}?name=" + id,
            // dataType: "html",
            success: function (data) {
                $('#state').empty();
                for (var key in data) {
                    var name = data[key].name;
                    var sel = document.getElementById('state');
                    var opt = document.createElement('option');
                    opt.text = data[key].name;
                    opt.value = data[key].name;
                    sel.appendChild(opt);

                }
            }
        });
    } 
</script>
@endsection