@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Add Transaction Partners</h5>
                <span class="d-block m-t-5">Partners</span>
            </div>
            <div class="card-body table-border-style">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" id="add_tp" enctype="multipart/form-data" method="post"
                              action="">
                              <input type="hidden" name="company_id" value="{{Auth::user()->company->id}}">
                            @include('partials.CorpFin.partnerForm')
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <input type="submit" class="btn btn-primary" value="Submit" />
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
            url: "{{ route("corpfin.api.state.get") }}?id=" + id,
            // dataType: "html",
            success: function (data) {
                $('#state').empty();
                for (var key in data) {
                    var name = data[key].name;
                    var sel = document.getElementById('state');
                    var opt = document.createElement('option');
                    opt.text = data[key].name;
                    opt.value = data[key].id;
                    sel.appendChild(opt);

                }
            }
        });
    } 
    /*$("#country").change(function (e) {
        var id = $('#country :selected').attr('value');
        console.log(id)
        
    });*/

    var id = $('#country :selected').attr('value');
    if(id != ''){
        $.ajax({
            type: "GET",
            url: "{{ route("corpfin.api.state.get") }}?id=" + id,
            // dataType: "html",
            success: function (data) {
                $('#state').empty();
                for (var key in data) {
                    var name = data[key].name;
                    var sel = document.getElementById('state');
                    var opt = document.createElement('option');
                    opt.text = data[key].name;
                    opt.value = data[key].id;
                    sel.appendChild(opt);

                }
            }
        });
    }

</script>
@endsection
