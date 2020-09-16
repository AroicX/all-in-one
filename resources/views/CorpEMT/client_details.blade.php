@include('CorpEMT.layout.includes.header')
<title>CorpEMT | Dashboard</title>
@include('CorpEMT.layout.includes.common_stylesheet')
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="{{asset('datepicker/datepicker.css')}}">
<link rel="stylesheet" href="{{asset('clockpicker/clockpicker.css')}}">
<link rel="stylesheet" href="{{asset('timeline/timeline.css')}}">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
@include('CorpEMT.layout.includes.topheader')
<!-- Left side column. contains the logo and sidebar -->
@include('CorpEMT.layout.includes.menu')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{$page}}
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url('corpemt/client/manage')}}"><i class="fa fa-users"></i> Clients</a></li>
                <li class="active">{{$page}}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-sm-12">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            <p>{{session('success')}}</p>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <p>{{session('error')}}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-sm-7">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-user"></i> <b>Personal Details</b></h3>
                            <span class="pull-right">
                                <button class="btn btn-primary btn-xs" data-target="#edit-clientdetails" data-toggle="modal"><i class="fa fa-pencil"></i> Edit Details</button>
                            </span>
                        </div>
                        <div class="box-body">
                            <div class="pull-right image">
                                <img src="{{asset('adminLTE/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image" width="100">
                            </div>
                            <h3> {{$details->name}} </h3>
                            <h4><b>Job Description</b> - {{$details->job_title}}</h4>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label><i class="fa fa-phone"></i> Phone</label>
                                    <p>{{ $details->phone }}</p>
                                    <label><i class="fa fa-envelope"></i> Email</label>
                                    <p>{{$details->email}}</p>
                                    <label><i class="fa fa-home"></i> Address</label>
                                    <p>{{$details->address}}</p>
                                </div>
                                <div class="col-sm-6">
                                    <label><i class="fa fa-home"></i> Zip Code</label>
                                    <p>{{ !empty($details->zip) ? $details->zip : "Not Set" }}</p>
                                    <label><i class="fa fa-map-marker"></i> State</label>
                                    <p>{{ !empty($details->state) ? $details->state : "Not Set" }}</p>
                                    <label><i class="fa fa-location-arrow"></i> City</label>
                                    <p>{{ !empty($details->city) ? $details->city : "Not Set" }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-building"></i> <b>Company Details</b></h3>
                            <span class="pull-right">
                                <button class="btn btn-primary btn-xs" data-target="#edit-companydetails" data-toggle="modal"><i class="fa fa-pencil"></i> Update Details</button>
                            </span>
                        </div>
                        <div class="box-body">
                            <h4>{{ucwords($details->client_company)}}</h4>
                            <label><i class="fa fa-phone"></i> Phone</label>
                            <p>{{ !empty($details->company_phone) ? $details->company_phone : "No phone set" }}</p>
                            <label><i class="fa fa-link"></i> Website</label>
                            <p>{{ !empty($details->company_url) ? $details->company_url : "Website not set" }}</p>
                            <label><i class="fa fa-map-marker"></i> Address</label>
                            <p>{{ !empty($details->company_address) ? $details->company_address : "Address not set" }}</p>
                            <label><i class="fa fa-info"></i> Description</label>
                            <p>{{ !empty($details->company_description) ? $details->company_description : "Description not set" }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-info"></i> <b>Other Information</b></h3>
                        </div>
                        <div class="box-body">
                            <form method="post" action="{{url('corpemt/client/updateotherinformation')}}" class="form-horizontal">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="col-sm-12">Status</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" name="status">
                                                    {{--<option value="{{$details->status}}">{{ucfirst($details->status)}}</option>--}}
                                                    <option value="lead" {{ $details->status == 'lead' ? "selected" : '' }}>Lead</option>
                                                    <option value="prospect" {{ $details->status == 'prospect' ? "selected" : '' }}>Prospect</option>
                                                    <option value="customer" {{ $details->status == 'customer' ? "selected" : '' }}>Customer</option>
                                                    <option value="inactive" {{ $details->status == 'inactive' ? "selected" : '' }}>Inactive</option>
                                                    <option value="general" {{ $details->status == 'general' ? "selected" : '' }}>General</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="col-sm-12">Tags</label>
                                            <div class="col-sm-12">
                                                <input type="text" name="tags" class="form-control" value="{{ $details->tags }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="col-sm-12">Lead Source</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" name="source">
                                                    <option value="{{$details->lead_source}}">{{$details->lead_source}}</option>
                                                    @foreach($sources as $source)
                                                        <option value="{{$source->title}}">{{$source->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12">Background</label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control"
                                                  name="background">{{$details->background}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-success btn-flat">Save</button>
                                        <input type="hidden" name="client_id" value="{{$details->id}}">
                                        <input type="hidden" name="company_id" value="{{$details->company_id}}">
                                        <input type="hidden" name="unique_id" value="{{$details->unique_id}}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title"><i class="fa fa-briefcase"></i> <b>Action List</b></h4>
                            <span class="pull-right">
                                <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#add-action"><i class="fa fa-plus"></i> Add Next Action</button></span>
                        </div>
                        <div class="box-body">
                            @if($actions->isEmpty())
                                <p>You are yet to add an action</p>
                            @else
                                <ul class="timeline">
                                    @foreach($actions as $action)
                                        <li>
                                            <div class="timeline-badge primary"><i class="fa fa-briefcase"></i></div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <span class="pull-right">
                                                  <form method="post" action="{{url('corpemt/client/markasdone')}}">
                                                  @if($action->status == 'pending')
                                                          <button type="submit" name="done" class="btn btn-success btn-xs"><i class="fa fa-check"></i> Mark as done</button>
                                                          <button type="button" class="btn btn-primary btn-xs edit"
                                                                  data-note="{{$action->note}}" data-identity="{{$action->id}}"
                                                                  data-dt="{{$action->schedule_date}}" data-tm="{{$action->schedule_time}}"
                                                                  data-schedule="{{$action->schedule}}" data-toggle="modal"
                                                                  data-target="#edit-action"><i class="fa fa-pencil"></i> Edit</button>
                                                          <input type="hidden" name="action_id" value="{{$action->id}}">
                                                          <input type="hidden" name="unique_id" value="{{$details->unique_id}}">
                                                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                      @else
                                                          <i class="fa fa-check fa-3x text-success"></i>
                                                      @endif
                                                  </form>
                                                </span>
                                                    <h3 class="timeline-title"><i class="fa fa-clock-o"></i> {{ucfirst($action->status)}}</h3>
                                                    @if($action->schedule == 'datetime')
                                                        <p>
                                                            <small class="text-muted"><i class="fa fa-calendar"></i>
                                                                Schedule Date: {{date('D, M d Y', strtotime($action->schedule_date))}}
                                                                - Schedule Time: {{$action->schedule_time}}</small>
                                                        </p>
                                                    @elseif($action->schedule == 'date')
                                                        <p>
                                                            <small class="text-muted"><i class="fa fa-calendar"></i>
                                                                Schedule
                                                                Date: {{date('D, M d Y', strtotime($action->schedule_date))}}
                                                            </small>
                                                        </p>
                                                    @else
                                                        <p>
                                                            <small class="text-muted"><i class="fa fa-calendar"></i>
                                                                Schedule {{strtoupper($action->schedule)}}</small>
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="timeline-body">
                                                    <p>{{$action->note}}</p>
                                                </div>
                                                @if($action->status == 'pending')
                                                    <span class="pull-left">
                             <form method="post" action="{{url('corpemt/client/deleteaction')}}">
                                <button type="submit" name="delete" class="btn btn-danger btn-xs"><i
                                            class="fa fa-trash"></i> Delete</button>
                                <input type="hidden" name="action_id" value="{{$action->id}}">
                                <input type="hidden" name="unique_id" value="{{$details->unique_id}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                             </form>
                          </span>

                            <span class="pull-right">
                            @if(!empty($action->date_created))
                                <p><small class="text-muted"><i class="fa fa-calendar"></i> Action Created: {{date('D, M d Y', strtotime($action->date_created))}}</small></p>
                            @endif

                            @if(!empty($action->date_edited))
                                <p><small class="text-muted"><i class="fa fa-calendar"></i> Edited On: {{date('D, M d Y', strtotime($action->date_edited))}}</small></p>
                            @endif
                          </span>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#call" data-toggle="tab" aria-expanded="false"><i class="fa fa-phone"></i>
                                    Calls</a>
                            </li>
                            <li>
                                <a href="#deal" data-toggle="tab" aria-expanded="false"><i class="fa fa-money"></i>
                                    Deals</a>
                            </li>
                            <li>
                                <a href="#note" data-toggle="tab" aria-expanded="false"><i class="fa fa-file-text"></i>
                                    Notes</a>
                            </li>
                            <li class="pull-right">
                                <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#add-call"><i
                                            class="fa fa-plus"></i> Add Call
                                </button>
                                <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#add-deal"><i
                                            class="fa fa-plus"></i> Add Deal
                                </button>
                                <button class="btn btn-xs btn-warning" data-target="#add-note" data-toggle="modal"><i
                                            class="fa fa-plus"></i> Add Note
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane" id="note">
                                <div class="row">
                                    <div class="col-sm-12">
                                        @if($notes->isEmpty())
                                            <p>No Note added yet</p>
                                        @else
                                            <ul class="timeline">
                                                @foreach($notes as $note)
                                                    <li>
                                                        <div class="timeline-badge warning"><i
                                                                    class="fa fa-file-text"></i></div>
                                                        <div class="timeline-panel">
                                                            <div class="timeline-heading">
                                  <span class="pull-right">
                                    <button type="button" class="btn btn-primary btn-xs edit-note"
                                            data-note="{{$note->note}}" data-identity="{{$note->id}}"
                                            data-nd="{{$note->deal_id}}" data-toggle="modal" data-target="#edit-note"><i
                                                class="fa fa-pencil"></i> Edit</button>
                                  </span>
                                                                <p>
                                                                    <small class="text-muted"><i
                                                                                class="fa fa-calendar"></i> Date
                                                                        Created: {{date('D, M d Y', strtotime($note->date_created))}}
                                                                    </small>
                                                                </p>
                                                            </div>
                                                            <div class="timeline-body">
                                                                <p>{{$note->note}}</p>
                                                                @if(!empty($note->date_edited))
                                                                    <p>
                                                                        <small class="text-muted"><i
                                                                                    class="fa fa-calendar"></i> Edited
                                                                            On {{date('D, M d Y', strtotime($note->date_edited))}}
                                                                        </small>
                                                                    </p>
                                                                @endif
                                                            </div>
                                                            <p>
                                <span class="pull-left">
                                   <form method="post" action="{{url('corpemt/client/deletenote')}}">
                                      <button type="submit" name="delete" class="btn btn-danger btn-xs"><i
                                                  class="fa fa-trash"></i> Delete</button>
                                      <input type="hidden" name="note_id" value="{{$note->id}}">
                                      <input type="hidden" name="unique_id" value="{{$details->unique_id}}">
                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                   </form>
                                </span>
                                                            </p>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane active" id="call">
                                <div class="row">
                                    <div class="col-sm-12">
                                        @if($calls->isEmpty())
                                            <p>No calls made yet</p>
                                        @else
                                            <ul class="timeline">
                                                @foreach($calls as $call)
                                                    <li>
                                                        <div class="timeline-badge success"><i class="fa fa-phone"></i>
                                                        </div>
                                                        <div class="timeline-panel">
                                                            <div class="timeline-heading">
                                  <span class="pull-right">
                                    <button type="button" class="btn btn-primary btn-xs edit-call"
                                            data-note="{{$call->note}}" data-identity="{{$call->id}}"
                                            data-feedback="{{$call->feedback}}" data-toggle="modal"
                                            data-target="#edit-call"><i class="fa fa-pencil"></i> Edit</button>
                                  </span>
                                                                <h3 class="timeline-title"><i
                                                                            class="fa fa-mobile"></i> {{ucfirst($call->feedback)}}
                                                                </h3>
                                                                @if(!empty($call->date_created))
                                                                    <p>
                                                                        <small class="text-muted"><i
                                                                                    class="fa fa-calendar"></i> Call
                                                                            Made
                                                                            on: {{date('D, M d Y', strtotime($call->date_created))}}
                                                                        </small>
                                                                    </p>
                                                                @endif
                                                            </div>
                                                            <div class="timeline-body">
                                                                <p>{{$call->note}}</p>
                                                            </div>
                                                            <p>
                                <span class="pull-left">
                                   <form method="post" action="{{url('corpemt/client/deletecall')}}">
                                      <button type="submit" name="delete" class="btn btn-danger btn-xs"><i
                                                  class="fa fa-trash"></i> Delete</button>
                                      <input type="hidden" name="call_id" value="{{$call->id}}">
                                      <input type="hidden" name="unique_id" value="{{$details->unique_id}}">
                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                   </form>
                                </span>
                                                                <span class="pull-right">
                                                            @if(!empty($call->date_edited))
                                                                <p>
                                                                    <small class="text-muted"><i
                                                                                class="fa fa-calendar"></i> Edited
                                                                        on: {{date('D, M d Y', strtotime($call->date_edited))}}
                                                                    </small>
                                                                </p>
                                                                @endif
                                                                </span>
                                                                </p>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="deal">
                                <div class="row">
                                    <div class="col-sm-12">
                                        @if($deals->isEmpty())
                                            <p>No Deal added yet</p>
                                        @else
                                            <ul class="timeline">
                                                @foreach($deals as $deal)
                                                    <li>
                                                        <div class="timeline-badge danger"><i class="fa fa-money"></i>
                                                        </div>
                                                        <div class="timeline-panel">
                                                            <div class="timeline-heading">
                                  <span class="pull-right">
                                    <button type="button" class="btn btn-primary btn-xs edit-deal"
                                            data-name="{{$deal->deal_name}}" data-amount="{{$deal->amount}}"
                                            data-stage="{{$deal->deal_stage}}" data-note="{{$deal->note}}"
                                            data-identity="{{$deal->id}}" data-ecd="{{$deal->expected_close_date}}"
                                            data-toggle="modal" data-target="#edit-deal"><i class="fa fa-pencil"></i> Edit</button>
                                  </span>
                                                                <h3 class="timeline-title"><i class="fa fa-handshake-o"></i> {{$deal->deal_name}} -
                                                                    <small class="text-muted">Amount: ${{$deal->amount}}</small>
                                                                </h3>
                                                                <p>
                                                                    @if($deal->deal_stage == '10')
                                                                        Qualification Stage
                                                                        - {{ucfirst($deal->deal_stage)}}%
                                                                    @elseif($deal->deal_stage == '25')
                                                                        Pedning Stage - {{ucfirst($deal->deal_stage)}}%
                                                                    @elseif($deal->deal_stage == '50')
                                                                        Decision Stage - {{ucfirst($deal->deal_stage)}}%
                                                                    @elseif($deal->deal_stage == '75')
                                                                        Processing Stage
                                                                        - {{ucfirst($deal->deal_stage)}}%
                                                                    @elseif($deal->deal_stage == '90')
                                                                        Negotiation Stage
                                                                        - {{ucfirst($deal->deal_stage)}}%
                                                                    @elseif($deal->deal_stage == 'won')
                                                                        <span class="text-success">
                                                                            <i class="fa fa-check"></i> {{ucfirst($deal->deal_stage)}}
                                                                        </span>
                                                                    @else
                                                                        <span class="text-danger"><b><i class="fa fa-times"></i> {{ucfirst($deal->deal_stage)}}</b></span>
                                                                    @endif
                                                                </p>
                                                                <p>
                                                                    <small class="text-muted"><i class="fa fa-calendar"></i> Deal Created: {{date('D, M d Y', strtotime($deal->date_created))}}
                                                                    </small>
                                                                </p>
                                                            </div>
                                                            <div class="timeline-body">
                                                                <p>{{$deal->note}}</p>
                                                                <p>
                                                                    <small class="text-muted"><i class="fa fa-calendar"></i> Expected Close
                                                                        Date {{date('D, M d Y', strtotime($deal->expected_close_date))}}
                                                                    </small>
                                                                </p>
                                                            </div>
                                                            <p>
                                                                @if(!in_array($deal->deal_stage, array('won', 'lost')))
                                                                    <span class="pull-left">
                                   <form method="post" action="{{url('corpemt/client/deletedeal')}}">
                                      <button type="submit" name="delete" class="btn btn-danger btn-xs"><i
                                                  class="fa fa-trash"></i> Delete</button>
                                      <input type="hidden" name="deal_id" value="{{$deal->id}}">
                                      <input type="hidden" name="unique_id" value="{{$details->unique_id}}">
                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                   </form>
                                </span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    @include('CorpEMT.layout.modals.add_action_modal')
                    @include('CorpEMT.layout.modals.edit_action_modal')
                    @include('CorpEMT.layout.modals.edit_clientdetails_modal')
                    @include('CorpEMT.layout.modals.edit_companydetails_modal')
                    @include('CorpEMT.layout.modals.add_call_modal')
                    @include('CorpEMT.layout.modals.edit_call_modal')
                    @include('CorpEMT.layout.modals.add_note_modal')
                    @include('CorpEMT.layout.modals.edit_note_modal')
                    @include('CorpEMT.layout.modals.add_deal_modal')
                    @include('CorpEMT.layout.modals.edit_deal_modal')
                </div>
            </div>

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
</html>
<script src="{{asset('clockpicker/clockpicker.js')}}"></script>
<script type="text/javascript">
    $('.clockpicker').clockpicker();
</script>
<script src="{{asset('datepicker/datepicker.js')}}"></script>
<script type="text/javascript">
    $('.date').datepicker().on('changeDate', function (ev) {
        $(this).datepicker('hide');
    });
</script>
<script type="text/javascript">
    $('.edit').click(function () {
        $('#action-note').html($(this).data('note'));
        $('#date').val($(this).data('dt'));
        $('#time').val($(this).data('tm'));
        $('#schedule').val($(this).data('schedule'));
        $('#action-id').val($(this).data('identity'));
    });
</script>
<script type="text/javascript">
    $('.edit-call').click(function () {
        $('#call-note').html($(this).data('note'));
        $('#feedback').val($(this).data('feedback'));
        $('#call-id').val($(this).data('identity'));
    });
</script>
<script type="text/javascript">
    $('.edit-deal').click(function () {
        $('#deal-name').val($(this).data('name'));
        $('#deal-amount').val($(this).data('amount'));
        $('#deal-id').val($(this).data('identity'));
        $('#deal-date').val($(this).data('ecd'));
        $('#deal-stage').val($(this).data('stage'));
        $('#deal-note').val($(this).data('note'));
    });
</script>
<script type="text/javascript">
    $('.edit-note').click(function () {
        $('#note-note').val($(this).data('note'));
        $('#note-note-id').val($(this).data('identity'));
        $('#note-deal').val($(this).data('nd'));
    });
</script>


