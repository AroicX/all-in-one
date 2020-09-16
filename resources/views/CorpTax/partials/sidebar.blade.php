<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{  Auth::user() ? Auth::user()->name :'' }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i>Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">Main Navigation</li>
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Home</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="{{route('corptax-overview')}}"><i class="fa fa-circle-o"></i> Overview</a></li>
                </ul>
            </li>
            <li class="header">Tax Computation</li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Value Added TAX</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('logTransaction')}}"><i class="fa fa fa-th-list"></i> Log Transaction</a></li>
                    <li><a href="{{route('MonthlyVATReturn')}}"><i class="fa fa fa-th-list"></i> Monthly VAT Returns</a></li>
                    <li><a href="{{route('VATMovementSchedule')}}"><i class="fa fa fa-th-list"></i> Prepare Movement Schedule</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Withholding TAX</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('logTransactions')}}"><i class="fa fa fa-th-list"></i>Log Transactions</a></li>
                    <li><a href="{{route('viewTransactions')}}"><i class="fa fa fa-th-list">
                            </i>View Transaction by Period</a></li>
                    <li><a href="{{route('accounts_movement')}}"><i class="fa fa fa-th-list">
                            </i>Prepare Movement Schedule</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span> Company Income TAX</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('profile-update')}}"><i class="fa fa fa-th-list"></i> Update Profile</a></li>
                    <li><a href="{{route('cit-computation')}}"><i class="fa fa fa-th-list"></i> Compute CIT</a></li>
                </ul>
            </li>

            <li class="header">REPORTS</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span> Generate Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="javascript:void(0)"><i class="fa fa fa-th-list"></i>CIT Summary Computation</a></li>
                    <li><a href="javascript:void(0)"><i class="fa fa fa-th-list"></i>DIT Summary</a></li>
                    <li><a href="javascript:void(0)"><i class="fa fa fa-th-list"></i>ETR</a></li>
                    <li><a href="{{route('accounts_movement')}}"><i class="fa fa fa-th-list"></i>Accounts Movement</a></li>
                    <li><a href="javascript:void(0)"><i class="fa fa fa-th-list"></i>Tax Return Form</a></li>
                </ul>
            </li>
           {{-- <li class="treeview">
                <a href="javascript:void(0)">
                    <i class="fa fa-wrench"></i> <span>Settings</span>
                </a>
            </li>--}}

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
