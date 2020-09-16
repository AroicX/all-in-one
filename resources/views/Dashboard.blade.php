<!DOCTYPE html>
<html>
<title>CorpHRM - @yield('page')</title>
@include('includes.Head')
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    @include('includes.Header')
    @include('includes.Menu')
            <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Support
                <small>CorpERM</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Support</li>
            </ol>
        </section>
        @include('includes.status')
                <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('includes.Footer')
    @include('includes.Sidebar')
</div>
<!-- ./wrapper -->
@include('includes.Includes')
@yield('footer')
</body>
</html>
