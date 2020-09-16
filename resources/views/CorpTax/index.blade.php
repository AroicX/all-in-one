<!DOCTYPE html>
<html>
@include('includes.Head')
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    @include('includes.Header')
    @include('CorpTax.partials.sidebar')
            <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Tax Computation Engine
                <small>CorpTAX</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">CorpTax</li>
            </ol>
        </section>
        @include('includes.status')

                @yield('content')

        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('includes.Footer')
    {{--@include('includes.Sidebar')--}}
</div>
<!-- ./wrapper -->
@include('includes.Includes')
</body>
</html>
