@extends('CorpHRM.layout.master')

@section('content')
<section class="content">

    <div class="row">
        @include('CorpHRM.Recruitment.cv_modal')
        <div class="col-md-12">
            @if(isset($success))
            <div class="alert alert-success">* Successfully Added</div>
            @endif
            <div class="card card-primary">
                <div class="card-header with-border">
                    <h5>Applicants </h5>
                    <p class="pull-right">Stage {{$stage}}</p>

                </div>

                <div class="card-body no-padding" id="BlockUI">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel with-nav-tabs panel-default">
                                <div class="panel-heading">
                                    <ul class="nav nav-tabs">
                                        <?php $a = 0; ?>
                                        @foreach($interview_processes as $interview_process)
                                        <?php $a++; ?>
                                        <li class="mx-3 py-2" ><a
                                                href="{{url('corphrm/rec_application/applications')}}/{{$rec_app_id}}?s={{$a}}">{{$interview_process->process_name}}</a>
                                        </li>
                                    
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <div class="">
                                        <?php
$o = $stage - 1; ?>
                                        <?php $j = $stage; ?>
                                        <div class="" id="tab_{{$interview_process->id}}">
                                            @if(CorpHRMAccessRoles('edit_slisting'))
                                            <div class="pull-right" style="margin:8px;">
                                                <a
                                                    href="{{ url('corphrm/rec_application/applications/email_applicants/') }}/{{$j}}/{{$interview_processes[$o]->id}}/{{$rec_app_id}}">
                                                    <button class="btn btn-primary" style="border-radius: 0px;">send
                                                        applicant Notification&nbsp;&nbsp;<i
                                                            class="fa fa-envelope"></i></button>
                                                </a>
                                                <a
                                                    href="{{ url('corphrm/rec_application/applications/email_interviewers/') }}/{{$j}}/{{$interview_processes[$o]->id}}/{{$rec_app_id}}">
                                                    <button class="btn btn-primary" style="border-radius: 0px;">send
                                                        interviewer Notification&nbsp;&nbsp;<i
                                                            class="fa fa-envelope"></i></button>
                                                </a>
                                                <a href="{{ url('corphrm/rec_application/applications/pdf/') }}/{{$rec_app_id}}/{{$j}}"
                                                    target="_blank">
                                                    <button class="btn btn-primary" style="border-radius: 0px;">PDF
                                                        Download&nbsp;&nbsp;<i class="fa fa-file-pdf-o"
                                                            aria-hidden="true"></i></button>
                                                </a>
                                                <a href="{{ url('corphrm/rec_application/applications/excel/') }}/{{$rec_app_id}}/{{$j}}"
                                                    target="_blank">
                                                    <button class="btn btn-primary" style="border-radius: 0px;">Excel
                                                        Download&nbsp;&nbsp;<i class="fa fa-file-excel-o"
                                                            aria-hidden="true"></i></button>
                                                </a>
                                                <button class="btn btn-primary upload_applicant_scores"
                                                    rec_id="{{$rec_app_id}}" Iprocess="{{$interview_processes[$o]->id}}"
                                                    stage="{{$j}}" style="border-radius: 0px;">upload scores
                                                    &nbsp;&nbsp;<i class="fa fa-upload"></i></button>
                                                <button class="btn btn-primary upload_applicant_scores_manually"
                                                    style="border-radius: 0px;" rec_id="{{$rec_app_id}}"
                                                    Iprocess="{{$interview_processes[$o]->id}}" stage="{{$j}}">shortlist
                                                    manually&nbsp;&nbsp; <i class="fa fa-sort-amount-desc"></i></button>
                                                @if($applicants)
                                                @if($interview_processes[$o]->lock_scores == "0")
                                                <a
                                                    href="{{url('corphrm/rec_application/applications/lock_scores')}}?id={{$interview_processes[$o]->id}}">
                                                    <button class="btn btn-primary" style="border-radius: 0px;">lock
                                                        scores&nbsp;&nbsp;<i class="fa fa-lock"></i></button>
                                                </a>
                                                @endif
                                                @if($interview_processes[$o]->lock_scores == "1")
                                                <a
                                                    href="{{url('corphrm/rec_application/applications/unlock_scores')}}?id={{$interview_processes[$o]->id}}">
                                                    <button class="btn btn-primary" style="border-radius: 0px;">Unlock
                                                        scores&nbsp;&nbsp;<i class="fa fa-unlock"></i></button>
                                                </a>
                                                @endif
                                                @endif
                                            </div>
                                            @endif
                                        </div>

                                        <table
                                            class="table table-hover ">

                                            <tr>
                                                <th><input type="checkbox" name="checkAll" id="checkAll"></th>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>email</th>
                                                <th>Phone</th>
                                                <th>Qualifications</th>
                                                <th>curriculum vitae</th>
                                                <th>Grade</th>
                                                <!--      <th>Status</th> -->
                                                <th>Action</th>
                                            </tr>
                                            <?php $sn = 0; ?>
                                            @foreach ($applicants as $applicant)
                                            <?php $sn += 1;?>
                                            <tr>
                                                <td><input class="form-checkcard form-check-input" type="checkbox" name="applicant_id[]"
                                                        value="{{$applicant->id}}"></td>
                                                <td>{{$sn}}</td>
                                                <td>{{$applicant->alias}} {{$applicant->name}}</td>
                                                <td>{{$applicant->email}}</td>
                                                <td>{{$applicant->phone}}</td>
                                                <td>{{$applicant->qualification}}</td>
                                                <td>
                                                    <?php if (substr($applicant->cv_file, -3) == 'pdf' || substr($applicant->cv_file, -3) == 'PDF'){ ?>
                                                    <button type="button" class="btn btn-info btn-sm view_pdf"
                                                        style="border-radius: 0px;"
                                                        src="{{url ('/ViewerJS/#..') }}/uploads/files/@foreach($companies as $company){{$company->name}}@endforeach/job_app/cv/{{date_format($applicant->created_at,'Y-m-d')}}/{{$applicant->cv_file}}">View
                                                        CV</button>
                                                    <?php }else{ ?>
                                                    <button type="button" class="btn btn-info btn-sm view_img"
                                                        style="border-radius: 0px;"
                                                        src="{{url ('/') }}/uploads/files/@foreach($companies as $company){{$company->name}}@endforeach/job_app/cv/{{date_format($applicant->created_at,'Y-m-d')}}/{{$applicant->cv_file}}">View
                                                        CV</button>
                                                    <?php } ?>
                                                    @if(!empty($applicant->other_file))
                                                    <?php if (substr($applicant->other_file, -3) == 'pdf' || substr($applicant->other_file, -3) == 'PDF'){ ?>
                                                    <button type="button" class="btn btn-info btn-sm view_pdf"
                                                        style="border-radius: 0px;"
                                                        src="{{url ('/ViewerJS/#..') }}/uploads/files/@foreach($companies as $company){{$company->name}}@endforeach/job_app/cv/{{date_format($applicant->created_at,'Y-m-d')}}/{{$applicant->other_file}}">View
                                                        CV</button>
                                                    <?php }else{ ?>
                                                    <button type="button" class="btn btn-info btn-sm view_img"
                                                        style="border-radius: 0px;"
                                                        src="{{url ('/') }}/uploads/files/@foreach($companies as $company){{$company->name}}@endforeach/job_app/cv/{{date_format($applicant->created_at,'Y-m-d')}}/{{$applicant->cv_file}}">View
                                                        other file</button>
                                                    <?php } ?>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $applicant->grade}}
                                                </td>
                                                <td>

                                                    @if(CorpHRMAccessRoles('view_slisting'))
                                                    <a
                                                        href="{{url('jobs/application-form')}}/{{md5($applicant->rec_app_id)}}/{{$applicant->id}}">
                                                        <button type="button" title="View Application / Applicant"
                                                            class="btn btn-sm btn-success">
                                                            <i class="fa fa-check "></i>
                                                        </button>
                                                    </a>
                                                    @endif

                                                    @if(CorpHRMAccessRoles('delete_slisting'))
                                                    <button type="button" title="Delete" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-window-close "></i>
                                                    </button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </table>
                                        @if(!$applicants)
                                        <td>
                                            <p style="text-align:center;">No Applicant/Application Yet.
                                            </p>
                                        </td>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>
@stop
@section('scripts')
<script type="text/javascript">

</script>
@endsection