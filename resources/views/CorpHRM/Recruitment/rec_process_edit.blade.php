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
                    <form action="{{url('corphrm/rec_process/edit')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group ">
                            <label for="">Process Name</label>
                            <input type="text" name="process_name" value="{{$rec_process['process_name']}}"
                                class="form-control" required="required">
                        </div>
                        <div class="form-group ">
                            <label for="">Process Description</label>
                            <input type="text" name="process_desc" value="{{$rec_process['process_description']}}"
                                class="form-control" required="required">
                        </div>
                        <div class="form-group" id="input_fields_wrap">
                           
                                <label>Interview Process</label>
                                <a href="javascript:;" class="add_field_button btn btn-primary pull-right"
                                    style="border-radius: 0px;">Add New Process</a>
                                <?php $a= explode(',',$rec_process['interview_processes']); ?>
                                @foreach($a as $b)
                                <input type="text" class="form-control" value="{{$b}}" name="interview_process[]"
                                    required="">
                                @endforeach
                                <br>
                         
                        </div>
                        <input type="hidden" name="id" value="$rec_process['id']">
                        <div class="text-center"><button type="submit" id="add_process"
                                class="btn btn-primary has-ripple">Submit</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@stop
@section('js')
<script>
    $(document).ready(function () {

        // alert('hey')
        var max_fields = 10; //maximum input cardes allowed
        var wrapper = $("#input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_button"); //Add button ID

        var x = 1; //initlal text card count
        $(".add_field_button").click(function (e) { //on add input button click
            // alert("k");
            e.preventDefault();
            if (x < max_fields) { //max input card allowed
                x++; //text card increment
                $(wrapper).append(
                    '<br><div class="col-md-12"><input type="text" class="form-control" required=""  name="interview_process[]"/><a href="#" class="remove_field">Remove</a></div>'
                    ); //add input card
            }
            return false;
        });

        $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        });
        return false;
    });
</script>
@endsection