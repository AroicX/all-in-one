@extends('CorpHRM.layout.master')

@section('content')
<section class="content">
    <div class="row">

        <div class="col-md-12">
            @if(isset($success))
            <div class="alert alert-success">* Successfully Added</div>
            @endif
            <div class="card ">
                <div class="card-header">
                    <h5>Recruitment Application </h5>

                    @if(CorpHRMAccessRoles('add_rapplication'))
                    <a href="{{url('corphrm/rec_application')}}">
                        <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                    </a>
                    @endif

                </div>

                <div class="card-body table-responsive no-padding" id="BlockUI">
                    <table class="table table-hover">

                        <tr>
                            <th>ID</th>
                            <th>Job Title</th>
                            <th>Posted Date</th>
                            <th>branch</th>
                            <th>designation</th>
                            <th>department</th>
                            <th>Status</th>
                        </tr>
                        <?php $sn = 0; ?>
                        @foreach ($rec_applications as $rec_application)
                        <?php $sn += 1;?>
                        <tr>
                            <td>{{$sn}}</td>
                            <td>{{ $rec_application->job_title }}</td>
                            <td>{{ $rec_application->posted_date }}</td>
                            <td>{{ $rec_application->branch }}</td>
                            <td>{{ $rec_application->designation }}</td>
                            <td>{{ $rec_application->department }}</td>
                            <td>
                                <div class="btn-group">
                                    @if(CorpHRMAccessRoles('view_rapplication'))
                                    <a href="{{url('corphrm/rec_application')}}/{{ $rec_application->id }}">
                                        <button type="button" title="View" class="btn btn-sm btn-primary"><i
                                                class="fa fa-eye "></i>
                                        </button>
                                    </a>

                                    @endif
                                </div>
                                @if($rec_application->status == "Pending")
                                @if(CorpHRMAccessRoles('edit_rapplication'))
                                <a href="{{url('/corphrm/rec_application/approve')}}/{{$rec_application->id}}">
                                    <button type="button" title="Approve" class="btn btn-sm btn-success">
                                        <i class="fa fa-check "></i>
                                    </button>
                                </a>
                                @endif
                                @if(CorpHRMAccessRoles('edit_rapplication'))
                                <a href="{{url('/corphrm/rec_application/cancel')}}/{{$rec_application->id}}">
                                    <button type="button" title="Cancel" class="btn btn-sm btn-danger">
                                        <i class="fa fa-remove "></i>
                                    </button>
                                </a>
                                @endif
                                @endif
                                @if($rec_application->status == "Approved")
                                @if(CorpHRMAccessRoles('edit_rapplication'))
                                <a href="{{url('/corphrm/rec_application/cancel')}}/{{$rec_application->id}}">
                                    <button type="button" title="Cancel" class="btn btn-sm btn-danger">
                                        <i class="fas fa-window-close "></i>
                                    </button>
                                </a>
                                @endif
                                @endif
                                @if($rec_application->status == "Cancelled")
                                @if(CorpHRMAccessRoles('edit_rapplication'))
                                <a href="{{url('/corphrm/rec_application/approve')}}/{{$rec_application->id}}">
                                    <button type="button" title="Approve" class="btn btn-sm btn-success">
                                        <i class="fa fa-check "></i>
                                    </button>
                                </a>
                                @endif
                                @endif
                                @if($rec_application->status == "Approved")
                                @if(CorpHRMAccessRoles('view_slisting'))
                                <a href="{{url('/corphrm/rec_application/applications')}}/{{$rec_application->id}}">
                                    <button type="button" title="View Applicatins & Applicants"
                                        class="btn btn-sm btn-warning">
                                        <i class="fa fa-users "></i>
                                    </button>
                                </a>
                                @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @if(empty($rec_applications))
                    <td>
                        <p style="text-align:center;">No Recruitment Application.
                        </p>
                    </td>

                    @endif
                </div>

            </div>
        </div>
    </div>
</section>

@stop