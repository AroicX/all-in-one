<!DOCTYPE html>
<html>
<title>CORPFIN | Manage Transaction Type</title>
@include('CorpFIN.includes.Head')
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    @include('CorpFIN.includes.Header')
            <!-- Left side column. contains the logo and sidebar -->
    @if(Auth::user()->Corpfin_menutype == "Traditional")
            @include('CorpFIN.includes.Traditional_menu')
   @else
            @include('CorpFIN.includes.Diary_menu')
    @endif
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Manage Custom Transaction Types
                <small>Preview</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Manage Transaction Types</a></li>
                <li class="active">View Transaction Types</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->

                <!-- right column -->
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Custom Transaction Types</h3>

                            <div class="box-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control pull-right"
                                           placeholder="Search">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding" id="BlockUI">
                            <table class="table table-hover">

                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Account No.</th>
                                    <th>Delete</th>
                                </tr>
                                @if($trans_types->count())
                                    <?php $sn = 0; ?>
                                    @foreach ($trans_types as $trans_type)
                                        <?php $sn += 1;?>
                                        <tr>
                                            <td>{{$sn}}</td>
                                            <td>{{$trans_type->name}}</td>
                                            <td>{{$trans_type->code}}</td>
                                            <td>{{$trans_type->acct_num}}</td>
                                            <td>
                                                <button type="button" id="delete_selected" idd="{{ $trans_type->id }}"
                                                        class="btn btn-danger delete_selected"><i class="fa fa-remove"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <td><p style="text-align:center;">No Custom Transaction Type Added.
                                            <a href="{{ route('corpfin.trans.types.add') }}"> Add Custom Transaction Type</a>
                                        </p></td>
                            </table>
                            @endif
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                    <!-- Horizontal Form -->


                    <!-- /.box -->
                </div>

            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('includes.Footer')
    @include('includes.Sidebar')
</div>
<!-- ./wrapper -->
@include('includes.Includes')
</body>
<script type="text/javascript">
    $('.delete_selected').click(function () {
        //   if ($('input.checkboxes').is(':checked')) {
        //       var values = $('input.checkboxes:checked').map(function () {
        //           return this.value;
        //       }).get();
        var id = $(this).attr('idd');
        confirm_statement = "Are you sure you want to delete this Transaction Type?";
        if (confirm(confirm_statement)) {
            App.blockUI({
                target: '#BlockUI',
                boxed: true,
                textOnly: true,
                message: '<img src="{{asset('img/spinner.gif')}}" /> Just a moment...'
            });
            $.ajax({
                // url: '{{ url('corpfin/del/tp') }}',
                // type:'post',
                // data: { "hall_id" : values },
                type: "GET",
                url: "{{ url('') }}/corpfin/del/tt/" + id,
                dataType: 'json',
                success: function (data) {
                    if (data.result == 'success') {
                        location.reload();
                        Command: toastr["success"]("Transaction Type deleted Successfully!")
                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        // alert("OKK");
                    }
                    if (data.result == 'fail') {
                        App.unblockUI('#BlockUI');
                        // $('#fail').show();
                        Command: toastr["error"]("Error Completing Request. Try Again!")

                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "3000",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                    }
                    if (data.result == 'login') {
                        window.location.href = u + '/login';
                        Command: toastr["error"]("Session Expired. Login to continue!")

                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "3000",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                    }
                }
            })

        }
        // }else{ 
        //     alert('Select Hall First');
        //     return false;
        // }
    })
</script>
</html>
