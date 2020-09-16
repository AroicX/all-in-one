@extends('CorpTax.layout.master')

@section('content')

<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>CIT Computation</h5>

                    <a href="{{route('downloadTrialBalanceTemplate')}}" class="btn btn-info" id="">Download Trial
                        Balance Template</a>
                    <a class="btn btn-primary text-white" data-toggle="modal" data-target="#uploadTrialBalance">Upload Trial
                        Balance</a>
                </div>
                <div class="card-body">

                    @if(session('error'))
                    <div class="alert alert-error col-sm-4">

                        {{session('error')}}
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success col-sm-4">

                        {{session('success')}}
                    </div>
                    @endif

                    <form role="form">
                        <div class="box-body">

                            <div class="form-group col-sm-4">
                                <label for="">Tax Losses Brought forward</label>
                                <input type="text" class="form-control" placeholder="Tax Losses Brought forward">
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                        </div>
                    </form>


                </div>
            </div>
        </div>


        <div class="box box-primary">
                <div class="modal fade" id="uploadTrialBalance" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Upload Transactions</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <form action="{{route('uploadTrialBalance')}}" method="post" id="T-balance-upload" enctype="multipart/form-data">
                            <div class="modal-body">


                                    <div class="form-group">
                                        <label for="">Upload Trial Balance(in excel)</label>
                                        <input type="file" name="trial_balance">
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                <button type="submit"
                                        class="btn btn-success" id="">Upload</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</section>


@endsection