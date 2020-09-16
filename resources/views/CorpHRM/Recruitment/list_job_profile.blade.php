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
                    <h5> Job Profiles </h5>
                    @if(CorpHRMAccessRoles('add_rapplication'))
                    <a href="{{url('corphrm/job_profile/new')}}">
                        <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                    </a>
                    @endif

                </div>

                <div class="card-body table-responsive table-bordered table-hover table-striped no-padding"
                    id="BlockUI">
                    <table class="table table-hover">

                        <tr>
                            <th>ID</th>
                            <th>Job Title </th>
                            <th>Qualification Details</th>
                            <th>Experience Details</th>
                            <th>Skill Details</th>
                            <th>Job Description</th>
                            <th>Action</th>
                        </tr>
                        <?php $sn = 0; ?>
                        @foreach ($jobprofiles as $jobprofile)
                        <?php $sn += 1;?>
                        <tr>
                            <td>{{$sn}}</td>
                            <td>{{ $jobprofile->job_title }}</td>
                            <td>{{ $jobprofile->qualification_details }}</td>
                            <td>{{ $jobprofile->experience_details }}</td>
                            <td>{{ $jobprofile->skill_details }}</td>
                            <td>{{ $jobprofile->job_description}}</td>
                            <td>
                                @if(CorpHRMAccessRoles('edit_rapplication'))
                                <a href="{{url('corphrm/job_profile/edit')}}/{{ $jobprofile->id }}">
                                    <button type="button" title="Edit" class="btn btn-sm btn-success">
                                        <i class="fa fa-check "></i>
                                    </button>
                                </a>
                                @endif
                                @if(CorpHRMAccessRoles('delete_rapplication'))
                                <a href="{{url('corphrm/delete/job_profile')}}/{{ $jobprofile->id}}">
                                    <button type="button" title="Delete" class="btn btn-sm btn-danger">
                                        <i class="fa fa-remove "></i>
                                    </button>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @if(count($jobprofiles) == "0")
                    <td>
                        <p style="text-align:center;">No Job profile Yet.
                        </p>
                    </td>

                    @endif
                </div>

            </div>
        </div>
    </div>
</section>
@stop