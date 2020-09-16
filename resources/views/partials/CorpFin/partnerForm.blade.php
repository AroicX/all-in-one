
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    <div class="box-body">

        <div class="form-group">
            <label for="name">Name of Individual or Corporation</label>
            <input type="text" name="name" value="{{ old('name', @$partner->name) }}" class="form-control" id="name"
                   placeholder="Name of Individual or Corporation" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email', @$partner->email) }}" class="form-control" id="email"
                   placeholder="Email Address" required>
        </div>
        <div class="form-group">
            <label for="phone">Tel</label>
            <input type="text" name="tel" value="{{ old('tel', @$partner->tel) }}" class="form-control" id="phone"
                   placeholder="Telephone Number" required>
        </div>
        <div class="form-group">
            <label>Country</label>
            <select class="selectpicker form-control country" id="country"
                    data-live-search="true" name="country_id" placeholder="" onchange="getStates()" required>
                <option value="">Choose Country</option>
                @foreach (App\Country::all() as $country)
                    <option value="{{ $country->id }}"
                            {{ old('country_id', @$partner->country->id) == $country->id ? "selected='selected":'' }}>{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>State</label>
            <select id="state" data-live-search="true" name="state_id" class="form-control"
                    required>
                <option value="">--choose--</option>
            </select>
        </div>
        <div class="form-group">
            <label for="cin">Company Incorporation Number</label>
            <input type="text" value="{{ old('comb_num', @$partner->comp_numb) }}" class="form-control" name="comp_numb"
                   placeholder="Company Incorporation Number" required>
        </div>
        <div class="form-group">
            <label for="tin">Tax Identificatin Number</label>
            <input type="text" class="form-control" name="tin" id="tin" placeholder="TIN"
                   required value="{{ old('tim', @$partner->tin) }}">
        </div>
        <div class="form-group">
            <label for="address">Official Address</label>
                                    <textarea class="form-control" name="address" id="address" required
                                              placeholder="Official Address">{{ old('address', @$partner->address) }}</textarea>
        </div>
        <div class="form-group">
            <label for="document">Upload Supporting Documents</label>
            <input type="file" id="document" name="document">
        </div>
    </div>

    <!-- /.box-body -->