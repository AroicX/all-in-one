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
                        <h3>All Process Approval</h3>
                    </div>

                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group col-sm-3">
                                <label for="">Branch</label>
                                <select id="branch" name="branch" class="form-control" required="required">
                                    </select>
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="">Designation</label>
                                <select id="designation" name="designation" class="form-control" required="required">
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">From Date</label>
                                <select id="department" name="department" class="form-control" required="required">
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Effective Date</label>
                                <input type="date" id="effective_date" name="effective_date" class="form-control" required="required">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Grade</label>
                                <select id="grade" name="grade" class="form-control" required="required">
                                </select>
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="">Annual Gross Salary</label>
                                <input type="text" id="annual" name="annual" class="form-control" required="required">
                            </div>

                            <div class="form-group col-sm-12 text-center">
                                {{csrf_field()}}
                                <button type="submit" class="btn btn-create">Send offer Letter by mail</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop