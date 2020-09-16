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
                    <h3>Recruitment Process
                        <a href="{{url('corphrm/rec_process/')}}">
                            <button class="btn btn-primary btn-sm" style="float:right;">Return Back</button>
                        </a>
                    </h3>
                </div>

                <div class="card-body">
                    <form action="{{route('corphrm.rec_process')}}" method="POST">
                        {{csrf_field()}}
                        <div class="form-group ">
                            <label for="">Process Name</label>
                            <input type="text" name="process_name" class="form-control" required="required">
                        </div>
                        <div class="form-group ">
                            <label for="">Process Description</label>
                            <input type="text" name="process_desc" class="form-control" required="required">
                        </div>
                        <div class="input_fields_wrap">
                            <div class="col-md-12">
                                <label>Interview Process</label>
                                <button class="add_field_button btn btn-primary pull-right"
                                    style="border-radius: 0px;">Add New Process</button>
                                <input type="text" class="form-control" name="interview_process[]" required="">
                                <br>
                            </div>
                        </div>

                        <div class="text-center"><button type="submit" id="add_process" class="btn btn-primary">Add
                                Process</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@stop
@section('scripts')
<script>
    $(document).ready(function () {
        var max_fields = 10; //maximum input cardes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_button"); //Add button ID

        var x = 1; //initlal text card count
        $(add_button).click(function (e) { //on add input button click
            e.preventDefault();
            if (x < max_fields) { //max input card allowed
                x++; //text card increment
                $(wrapper).append(
                    '<br><div class="col-md-12"><input type="text" class="form-control" required=""  name="interview_process[]"/><a href="#" class="remove_field">Remove</a></div>'
                    ); //add input card
            }
        });

        $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    });
</script>
@endsection