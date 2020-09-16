@extends('CorpHRM.layout.master')
<script src="https://js.paystack.co/v1/inline.js"></script>
@section('content')
<section class="content">
    <div class="row">
        @if(isset($success))
        <div class="alert alert-success">Successfully added</div>
        @endif
        @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}.
        </div>
        @elseif(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}.
        </div>
        @endif
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header with-border">
                    <h5>Leave Allowance </h5>
                    <a href="{{url('corphrm/leaveallowance')}}">
                        <button class="btn btn-primary btn-sm" style="float:right;">Return Back</button>
                    </a>

                </div>

                <div class="card-body">
                    <form class="row" action="{{route('corphrm.editleaveallowanceform')}}" method="post"
                        id="payment_form">

                        <div class="form-group col-sm-12 col-md-6">
                            <label>Name</label>
                            <input type="text" value="{{$leaveallowance['name']}}" name="name" class="form-control"
                                required="">
                        </div>


                        <div class="form-group col-sm-6">
                            <label for="">Grade</label>
                            <select class="form-control" name="grade_id" required="required">
                                @foreach($grades as $grade)
                                <option @if($leaveallowance['grade_id']==$grade->id) selected="selected" @endif
                                    value="{{ $grade->id }}">{{ $grade->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group col-sm-12 col-md-6">
                            <label for="allowance_percent">Allowance:</label>
                            <input type="number" value="{{$leaveallowance['allowance_percent']}}"
                                name="allowance_percent" id="allowance_percent" class="form-control"
                                required="required">
                        </div>


                        <div class="form-group col-sm-12 col-md-12">
                            {{csrf_field()}}
                            <input type="hidden" value="{{$leaveallowance['id']}}" name="id">
                            <button type="submit" class="btn btn-primary btn-submit">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@stop