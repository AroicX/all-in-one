@include('CorpEMT.layout.includes.header')
<title>CorpEMT | {{$page}}</title>
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
            <h1>
                {{$page}}
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url('corpemt/engagement/manage')}}"><i class="fa fa-paperclip"></i> Engagement</a></li>
                <li class="active">{{$page}}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-sm-12">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                <div class="col-sm-12">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
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
            <!--Section A-->
            <div class="row">
                <div class="col-sm-12">
                    <h4>SECTION A</h4>
                </div>
            </div>
        @include('CorpEMT.layout.engagement.section_a')
        <!--Section A Ends-->

        <!--Section C-->
        <div class="row">
            <div class="col-sm-12">
                <h4>SECTION C</h4>
            </div>
        </div>
        @include('CorpEMT.layout.engagement.section_c')
        <!--Section C Ends -->
            <!--prospect task ends here-->
            <!--modals-->
            <div class="row">
                <div class="col-sm-12">

                    @include('CorpEMT.layout.modals.add_management_modal')
                    @include('CorpEMT.layout.modals.edit_management_modal')
                    @include('CorpEMT.layout.modals.add_auditmember_modal')
                    @include('CorpEMT.layout.modals.edit_auditmember_modal')
                    @include('CorpEMT.layout.modals.add_engagement_analysis_modal')
                    @include('CorpEMT.layout.modals.add_expense')
                    @include('CorpEMT.layout.modals.add_discount')
                </div>
            </div>
            <!--end modals-->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('includes.Footer')
</div>
<!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="{{ asset('adminLTE/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.5 -->
<script src="{{asset('adminLTE/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminLTE/dist/js/app.min.js')}}"></script>
<script type="text/javascript">
    $('.liquidity, .company-type, .sec, .potential, .cac, .go-public').click(function () {
        var identity = $(this).data('identity');
        $('#' + identity).val($(this).val());
        $('.' + identity).not(this).attr('checked', false);
        if ($(this).prop('checked') === false) {
            $('#' + identity).val('');
        }
    });
</script>
<script type="text/javascript">
    $('.company-type').click(function () {
        if ($(this).prop('checked') === false) {
            $('.public, .private, .sec-hide').addClass('hidden');
            $('.sec, .potential, .cac, .go-public').attr('checked', false);
        }else {
            $(this).val() == 'private' ? $('.public, .sec-hide').addClass('hidden') : $('.private').addClass('hidden');
            $('.' + $(this).val()).removeClass('hidden');
        }
    });

    $('.sec').click(function () {

        if ($(this).prop('checked') === false) {
            $('.sec-hide').addClass('hidden');
            $('#potential').val('');
            $('.potential').attr('checked', false);
        }
        else {
            if ($(this).val() == 'yes') {
                $('.sec-hide').removeClass('hidden');
            }
            else {
                $('.sec-hide').addClass('hidden');
            }
        }
    });
</script>
<script type="text/javascript">
    $('.select-all').click(function () {
        var prop = $(this).prop('checked');
        $('.delete-box').attr('checked', prop);
    });
</script>
<script type="text/javascript">
    $('.edit-management').click(function(){
        $('#title').val($(this).data('title'));
        $('#m-fullname').val($(this).data('fullname'));
        $('#position').val($(this).data('position'));
        $('#experience').val($(this).data('work'));
        $('#discuss').val($(this).data('description'));
        $('#management-id').val($(this).data('identity'));
    });

    $('.edit-committee').click(function () {
        $('#a-fullname').val($(this).data('name'));
        $('#a-position').val($(this).data('poz'));
        $('#committee-id').val($(this).data('identity'));
    });
</script>
</body>
@include('CorpEMT.layout.includes.footer')