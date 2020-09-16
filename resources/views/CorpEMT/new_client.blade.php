@include('CorpEMT.layout.includes.header')
<title>CorpEMT | Dashboard</title>
@include('CorpEMT.layout.includes.common_stylesheet')
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
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
            <h1> {{$page}} </h1>
            <ol class="breadcrumb">
                <li><a href="{{url('/client/new')}}"><i class="fa fa-users"></i> Client</a></li>
                <li class="active">{{$page}}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row"    >
                <div class="col-sm-12">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                @if (session('error'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif
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
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title with-border">
                                <b><i class="fa fa-book"></i> Client Details</b>
                            </h3>
                        </div>
                        <div class="box-body">
                            <form method="post" action="{{url('corpemt/client/new')}}" class="form-horizontal">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="col-sm-12">First Name
                                                <small class="text-danger">*Required</small>
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="text" name="firstname" placeholder="Enter First Name"
                                                       class="form-control" required="required">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-sm-12">Last Name
                                                <small class="text-danger">*Required</small>
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="text" name="lastname" placeholder="Enter Last Name"
                                                       class="form-control" required="required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="col-sm-12">Job Title
                                                <small class="text-danger">*Required</small>
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="text" name="job_title" placeholder="Enter Job title"
                                                       class="form-control" required="required">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-sm-12">Company
                                                <small class="text-danger">*Required</small>
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="text" name="company" placeholder="Enter Company Name"
                                                       class="form-control" required="required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="col-sm-12">Phone Number
                                                <small class="text-danger">*Required</small>
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="tel" name="phonenumber" placeholder="Enter Phone Number"
                                                       class="form-control" required="required">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="col-sm-12">Email
                                                <small class="text-danger">*Required</small>
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="email" name="email" placeholder="Enter Email"
                                                       class="form-control" required="required">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="col-sm-12">Url</label>
                                            <div class="col-sm-12">
                                                <input type="text" name="url"
                                                       placeholder="Enter Url e.g website or social media links"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12">Address
                                        <small class="text-danger">*Required</small>
                                    </label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control" name="address" placeholder="Enter Address"
                                                  required="required"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="col-sm-12">Status
                                                <small class="text-danger">*Required</small>
                                            </label>
                                            <div class="col-sm-12">
                                                <select class="form-control" name="status" required="required">
                                                    <option value="lead">Lead</option>
                                                    <option value="prospect">Prospect</option>
                                                    <option value="customer">Customer</option>
                                                    <option value="inactive">Inactive</option>
                                                    <option value="general">General</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="col-sm-12">Tags</label>
                                            <div class="col-sm-12">
                                                <input type="text" name="tags"
                                                       placeholder="Kindly seperate tags with a comma"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="col-sm-12">Lead Source</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" name="lead_source">
                                                    @if($sources->isEmpty())
                                                        <option value="">Yet to add lead source</option>
                                                    @else
                                                        <option value="">SELECT</option>
                                                        @foreach($sources as $source)
                                                            <option value="{{$source->title}}">{{$source->title}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12">Background</label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control" name="background"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="col-sm-12">Owner
                                                <small class="text-danger">*Required</small>
                                            </label>
                                            <div class="col-sm-12">
                                                <select class="form-control" name="owner" required="required">
                                                    <option value="{{$user_id}}">{{$current_user->name}} (Me)</option>
                                                    @if(!$users->isEmpty())
                                                        @foreach($users as $user)
                                                            @if($user->id != $user_id)
                                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="col-sm-12">Birthday</label>
                                            <div class="col-sm-12">
                                                <input type="text" name="birthday" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="col-sm-12">Option</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" name="option">
                                                    <option value="public">Public</option>
                                                    <option value="private">Private</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-success btn-flat">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--prospect task ends here-->

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

