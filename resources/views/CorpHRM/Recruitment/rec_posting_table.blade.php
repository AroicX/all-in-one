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
                        <h5> Recruitment Posting </h5>
                        @if(CorpHRMAccessRoles('add_rposting'))
                        <a href="{{url('corphrm/rec_posting/new')}}">
                        <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                        </a>
                        @endif
                       
                    </div>

                        <div class="card-body table-responsive table-bordered table-hover table-striped no-padding" id="BlockUI">
                            <table class="table table-hover table-responsive ">

                                <tr>
                                    <th>ID</th>
                                    <th>Application Title</th>
                                    <th>Recruitment Process</th>
                                    <th>Job Code</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>No of Vacancy</th>
                                    <th>Status</th>
                                    <th>Interview Dates</th>
                                    <th>Url</th>
                                    <th>Action</th>
                                </tr>
                                <?php $sn = 0; ?>
                                @foreach ($rec_postings as $rec_posting)
                                <?php $sn += 1;?>
                                <tr>
                                    <td>{{$sn}}</td>
                                    <td>{{ $rec_posting['app_title'] }}</td>
                                    <td>{{ $rec_posting['rec_process'] }}</td>
                                    <td>{{ $rec_posting['job_code'] }}</td>
                                    <td>{{ $rec_posting['start_date'] }}</td>
                                    <td>{{ $rec_posting['end_date']}}</td>
                                    <td>{{ $rec_posting['no_vacancy']}}</td>
                                    <td>{{ $rec_posting['status'] }}</td>
                                    <td>{{ $rec_posting['interview_dates'] }}</td>
                                    <td>
                                    @if($rec_posting['status'] == "Approved" || $rec_posting['status'] == "approved" || $rec_posting['status'] == "approve")
                                        <p id="url" style="display: none;">{{url('jobs/application-form')}}/<?php echo md5($rec_posting['id']); ?></p>
                                        <button onclick="copyToClipboard('#url')" class="btn btn-sm btn-primary">Copy</button>
<a href="http://www.facebook.com/sharer.php?u={{url('jobs/application-form')}}/<?php echo md5($rec_posting['id']); ?>" target="_blank">
                                <button type="button" class="btn btn-sm btn-primary" title="Share on Facebook">
                                            <i class="fab fa-facebook-f" style="color: #ffffff;" ></i>
                                        </button>
                                        </a>
<a href="http://twitter.com/share?text=New%20Job%20Position&url={{url('jobs/application-form')}}/<?php echo md5($rec_posting['id']); ?>" target="_blank">
                        <button type="button" class="btn btn-sm btn-primary" title="Share on Twitter">
                                           <i class="fab fa-twitter" style="color: #ffffff;" ></i> 
                                           </button>
                                        </a>
<a href="https://www.linkedin.com/shareArticle?mini=true&url={{url('jobs/application-form')}}/<?php echo md5($rec_posting['id']); ?>&title={{ $rec_posting['app_title'] }}&summary=New%20Job%20Application&source=" target="_blank">
                        <button type="button" class="btn btn-sm btn-primary" title="Share on Twitter">
                                           <i class="fab fa-linkedin" style="color: #ffffff;" ></i> 
                                           </button>    
</a>
@endif
@if($rec_posting['status'] == "Pending" || $rec_posting['status'] == "pending")
<p style="color: orange; font-weight: 600;">Waiting for approval</p>
@endif
@if($rec_posting['status'] == "Cancel" || $rec_posting['status'] == "Cancelled" || $rec_posting['status'] == "cancelled" || $rec_posting['status'] == "Declined")
<p style="color:red; font-weight: 600;">Declined</p>
@endif
                                    </td>
                                    <td>
                                    @if(CorpHRMAccessRoles('edit_rposting'))
                                        <a href="{{url('corphrm/rec_posting/edit')}}/<?php echo $rec_posting['id']; ?>">
                                            <button type="button" title="View" 
                                                class="btn btn-sm btn-success">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </a>
                                    @if($rec_posting['status'] !== "Approved")
                                    <a href="{{url('corphrm/update/rec_posting')}}/<?php echo $rec_posting['id']; ?>/Approved">
                                    <button type="button" title="Approve" 
                                        class="btn btn-sm btn-success">
                                        <i class="fa fa-check "></i>
                                    </button>
                                    </a>
                                    @endif
                                    @endif
                                    @if(CorpHRMAccessRoles('edit_rposting'))
                                    @if($rec_posting['status'] !== "Cancelled")
                                            <a href="{{url('corphrm/update/rec_posting')}}/<?php echo $rec_posting['id']; ?>/Cancelled">
                                            <button type="button" title="Cancel" 
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-window-close"></i>
                                            </button>
                                            </a>
                                    @endif
                                    @endif
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            @if(empty($rec_posting))
                            <td><p style="text-align:center;" >No Recruitment Posting.
                                </p></td>

                            @endif
                        </div>

                    </div>
            </div>
        </div>
    </section>
@section('scripts')
<script type="text/javascript">
  function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
}
</script>
@endsection
    @stop
