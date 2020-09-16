@extends('CorpHRM.layout.master')

@section('content')
<section class="content">
    <div class="row">

        <div class="col-md-12">
            @if(isset($success))
            <div class="alert alert-success">* Successfully Added</div>
            @endif
            <div class="card card-primary">
                <div class="card-header with-border">
                    <h5>Claim Master</h5>
                    <a href="{{url('corphrm/claim_masters')}}">
                        <button class="btn btn-primary btn-sm" style="float:right;">Return Back</button>
                    </a>

                </div>

                <div class="card-body">
                    <form action="
                        @if($action == " Edit") {{url('corphrm/claims/edit')}}?cat=master&id={{$master['id']}} @else
                        {{route('corphrm.claim_master')}} @endif " method=" post">
                       
                            <div class="form-group ">
                                <label for="">Claim Name</label>
                                <input type="text" name="claim_name" @if($action=="Edit"
                                    )@if($master['name'])value="{{$master['name']}}" @endif @else @endif
                                    class="form-control" required="required">
                            </div>
                        
                      
                            <div class="form-group ">
                                <label for="">Grade</label>
                                <select class="form-control" name="grade" required="required">
                                    @foreach($grades as $grade)
                                    <option @if($action=="Edit" )@if($master['grade']&& $master['grade']==$grade->
                                        id)selected="selected"@endif@else @endif
                                        value="{{ $grade->id }}">{{ $grade->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                    
                            <div class="form-group ">
                                <label for="">Claim Max. limit</label>
                                <input type="number" @if($action=="Edit" )
                                    @if($master['max_limit'])value="{{$master['max_limit']}}" @endif@else @endif
                                    name="claim_max_limit" class="form-control" required="required">
                            </div>
                       

                        <div class="col-sm-12 text-center">
                            <button type="submit" id="add_claim" class="btn btn-primary has-ripple">submit</button>
                        </div>
                        {{csrf_field()}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@stop