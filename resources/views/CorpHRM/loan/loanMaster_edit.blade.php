@extends('CorpHRM.layout.master')

@section('content')
<section class="content">
    <div class="row">

        <div class="col-md-12">
            @if(isset($success))
            <div class="alert alert-success">Successfully added</div>
            @endif
            <div class="card card-primary">
                <div class="card-header with-border">
                    <h5>Loan Master </h5>
                    <a href="{{url('corphrm/loanmaster')}}">
                        <button class="btn btn-primary btn-sm" style="float:right;">Return Back</button>
                    </a>

                </div>

                <div class="card-body">
                    <form class="row" action="{{route('corphrm.loanmastereditform')}}" method="post">
                        <div class="form-group col-sm-6">
                            <label for="loan_name">Loan Name</label>
                            <input type="text" value="{{$loanmaster['loan_name']}}" name="loan_name"
                                class="form-control" required="required">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="loan_maximum_limit">Loan Maximum Limit</label>
                            <input type="text" value="{{$loanmaster['loan_maximum_limit']}}" name="loan_maximum_limit"
                                class="form-control" required="required">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="loan_annual_gross">Loan Limit % on Annal gross</label>
                            <input type="text" value="{{$loanmaster['loan_limit_annual_gross']}}"
                                name="loan_annual_gross" class="form-control" required="required">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="">Grade</label>
                            <select class="form-control" name="grade" required="required">
                                @foreach($grades as $grade)
                                <option @if($loanmaster['grade']==$grade->id) selected="selected" @endif
                                    value="{{ $grade->id }}">{{ $grade->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group col-sm-12">
                            <label>Allow multiple loan</label>
                            <label class="radio-inline">
                                <input type="radio" name="allow_multiple_loan" id="optionsRadiosInline1" value="1">Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="allow_multiple_loan" id="optionsRadiosInline2" value="0"
                                    checked>No
                            </label>
                        </div>

                        <div class="form-group col-sm-12">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$loanmaster['id']}}">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@stop