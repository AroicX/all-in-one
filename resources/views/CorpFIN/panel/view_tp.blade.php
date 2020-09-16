@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>View Products</h5>
                <span class="d-block m-t-5">All Products</span>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Country</th>
                                <th>State</th>
                                <th>Tel</th>
                                <th>CIN</th>
                                <th>Action</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sn = 0; ?>
                                @if($partners->count())
                                @foreach ($partners as $partner)
                                <?php $sn += 1;?>
                                <tr>
                                    <td>{{$sn}}</td>
                                    <td>{{ $partner->name }}</td>
                                    <td>{{ $partner->country->name }}</td>
                                    <td>{{ $partner->state->name }}</td>
                                    <td>{{ $partner->tel }}</td>
                                    <td>{{ $partner->comp_numb }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{route('corpfin.transaction.edit', ['id'=>$partner->id])}}" class="btn btn-sm btn-success view_tp"
                                                    id="{{ $partner->id }}"><i class="feather icon-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" id="{{ $partner->id }}"
                                                class="btn btn-sm btn-danger" onclick="delete_tp({{ $partner->id }})">
                                            <i class="feather icon-trash-2 "></i>
                                        </button>
                                    </td>
                                </tr>
                               @endforeach

                            @else
                            <td colspan="10"><p style="text-align:center;">No Transaction Partner Added.
                                    <a href="{{route('corpfin.transaction.add')}}"> Add</a> Transaction Partner
                                </p></td>
                            @endif
                        </tbody>
                    </table>
                    <div class="pager">
                        {{ $partners->links() }}
                    </div>
                    @if(empty($partners))
                    <td><p style="text-align:center;">No Parner Added.
                            <a href="{{url('corpfin/transaction/add')}}"> Add Partner</a>
                        </p></td>

                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="view_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" style="">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                class="fa fa-close"></i></button>
                    <center><h4 class="modal-title" style="color:#1d74b7;">Transaction Partner</h4>
                    </center>
                </div>
                <form action="" method="post"
                      enctype="multipart/form-data" name="form" id="form">
                    <input type="hidden" name="id" autocomplete="off" style="background:#ffffff;"
                           class="form-control" placeholder="" required>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Full-Name</label>
                                    <div class="append-icon">
                                        <input type="text" name="name" autocomplete="off"
                                               style="background:#ffffff;" class="form-control"
                                               placeholder="Enter Full-Name" required>
                                        <i class="icon-user"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Email Address</label>
                                    <div class="append-icon">
                                        <input type="text" name="email" autocomplete="off"
                                               style="background:#ffffff;" class="form-control"
                                               placeholder="Email-Address" required>
                                        <i class="icon-envelope"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Phone</label>
                                    <div class="append-icon">
                                        <input type="text" name="phone" autocomplete="off"
                                               style="background:#ffffff;" class="form-control"
                                               placeholder="Phone No" required>
                                        <i class="icon-user"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Address</label>
                                    <div class="option-group">
                                        <textarea type="text" class="form-control"
                                                  autocomplete="off" name="address"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <center>
                                <button type="submit" class="btn btn-embossed btn-success"
                                        style="background:#1d74b7;">Update
                                </button>
                            </center>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    //Ajax Load data from ajax
    {{--$(function () {--}}

        {{--$('.view_tp').click(function () {--}}
            {{--var id = $(this).attr('id');--}}
            {{--//alert(id);--}}
            {{--$.ajax({--}}
                {{--url: "{{route("corpfin.api.transaction.get")}}?id=" + id,--}}
                {{--type: "GET",--}}
                {{--dataType: "JSON",--}}
                {{--success: function (data) {--}}
                    {{--//alert(data);--}}
                    {{--$('#view_modal').modal('show'); // show bootstrap modal when complete loaded--}}
                    {{--$('[name="id"]').val(data.id);--}}
                    {{--$('[name="name"]').val(data.name);--}}
                    {{--$('[name="email"]').val(data.email);--}}
                    {{--$('[name="tel"]').val(data.tel);--}}
                    {{--$('[name="address"]').val(data.address);--}}

                {{--},--}}
                {{--error: function (jqXHR, textStatus, errorThrown) {--}}
                    {{--alert('Error Retrieving Data!');--}}
                {{--}--}}
            {{--});--}}
        {{--});--}}
    {{--});--}}
</script>
<!--/Ajax edit admin call_up script -->
<script type="text/javascript">
    const delete_tp = (id) => {
        //var id = $(this).attr('id');
        swal({
            title: "Are you sure you want to delete this Partner?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                let url= "{{ route("corpfin.api.transaction.delete") }}?id=" + id;
                console.log(url)
                // return 
                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {
                        if (data.result == 'success') {
                            swal("Successful! Data has been deleted!", {
                                icon: "success",
                            });
                            location.reload();
                            
                        }
                        if (data.result == 'fail') {
                            
                        }
                        if (data.result == 'login') {
                            window.location.href = u + '/login';
                            
                        }
                    }
                })
            } else {
                swal("Cancelled!", {
                    icon: "error",
                });
            }
        });
    }
    
</script>
@endsection
