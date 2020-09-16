@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Tax(WHT) Rate</h5>
                <span class="d-block m-t-5">Tax Rates</span>
                <a href="" class="btn btn-success float-right" data-toggle="modal" data-target="#tr_modal">Add New</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            {{--<th>ID</th>--}}
                            <th>Type</th>
                            <th>Rate(%)</th>
                            <th>options</th>
                        </tr>
                        <?php $sn = 0; ?>
                        <tbody>
                        @foreach ($company->whts as $wht)
                            <?php $sn += 1;?>
                            <tr>
                                {{--<td>{{$sn}}</td>--}}
                                <td>{{$wht->type}}</td>
                                <td>{{$wht->rate}}</td>
                                <td>
                                    <!-- <button class="btn btn-success btn-sm edit_btn" id="{{ $wht->id }}"
                                            title="edit"><i class="fa fa-edit"></i></button> -->
                                    <a href="{{ route('delete.wht') }}?id={{$wht->id}} id={{ $wht->id }}"
                                            class="btn btn-danger btn-sm delete_wht">
                                        <i class="fa fa-trash "></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @if(!$company->whts->count())
                    <div class="col-sm-8 text-center">
                        <p style="text-align:center;">No Tax(WHT) Rate Added.
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#tr_modal"> Add Tax Rate</a>
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tr_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" style="">
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title" style="color:#1d74b7;">Manage Tax Rate</h4></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('whtrates') }}" method="post"
                  enctype="multipart/form-data" name="form" id="form">
                <input type="hidden" name="id" autocomplete="off" style="background:#ffffff;"
                       class="form-control" placeholder="" required>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Type</label>
                                <div class="append-icon">
                                    <input type="text" name="type" autocomplete="off"
                                           style="background:#ffffff;" class="form-control"
                                           required>
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Tax Rate (%)</label>
                                <div class="append-icon">
                                    <input type="number" name="rate" autocomplete="off"
                                           style="background:#ffffff;" class="form-control" value="0"
                                           required>
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer text-center">
                        {{--<center>--}}
                            <button type="submit" class="btn pull-right btn-embossed btn-success"
                                    style="background:#1d74b7;">Submit
                            </button>
                        {{--</center>--}}
                    </div>
            </form>
        </div>
    </div>
</div>

@endsection
