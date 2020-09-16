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
                        <h3>Interview Process</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{route('corphrm.rec_application')}}" method="post">
                            <div class="form-group col-sm-3">
                                <label for="">Process Name</label>
                                <select id="process_name" name="process_name" class="form-control" required="required">
                                    <option value=""></option>
                                    <option value=""></option>
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Candidate Name</label>
                                <input type="text" id="candidate_name" name="candidate_name" class="form-control" required="required">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Candidate Name</label>
                                <input type="text" id="candidate_name" name="candidate_name" class="form-control" required="required">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Resume Code</label>
                                <input type="text" id="resume_code" name="resume_code" class="form-control" required="required">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="">Job Code</label>
                                <input type="text" id="job_code" name="job_code" class="form-control" required="required">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="">Job Profile</label>
                                <input type="text" id="job_profile" name="job_profile" class="form-control" required="required">
                            </div>
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table>
                                        <tr>
                                            <td>Details</td>
                                            <td>&nbsp</td>
                                            <td>&nbsp</td>
                                        </tr>
                                        <tr>
                                            <td>Description</td>
                                            <td>&nbsp</td>
                                            <td>&nbsp</td>
                                        </tr>
                                        <tr>
                                            <td>Rating %</td>
                                            <td>&nbsp</td>
                                            <td>&nbsp</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="">General Comment</label>
                                    <textarea class="form-control" id="general_comment" name="general_comment"></textarea>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="">Status</label>
                                    <select id="status" name="status" class="form-control" required="required">
                                        <option value="approve">Approve</option>
                                        <option value="reject">Reject</option>
                                        <option value="void">Void</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 text-center">
                                {{csrf_field()}}
                                <button type="submit" class="btn btn-create">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop