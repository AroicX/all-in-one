<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
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
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
                <a href="{{ url('dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Main Dashboard</span>
                </a>
            </li>
            <li class="active">
                <a href="{{ url('corpemt/dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Clients</span>
                    <span class="label label-primary pull-right">{{$total_client}}</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('corpemt/client/manage') }}"><i class="fa fa-users"></i> Manage Clients</a></li>
                    <li><a href="{{ url('corpemt/client/new') }}"><i class="fa fa-user-plus"></i> New Client</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ url('corpemt/deals') }}">
                    <i class="ion ion-bag"></i> <span>Deals</span>
                    <small class="label pull-right bg-red">{{$pending_deals}} Pending</small>
                </a>
            </li>
            <li>
                <a href="{{ route('emt.pipeline') }}">
                    <i class="fa fa-align-center"></i> <span>Pipeline</span>
                </a>
            </li>
            <li>
                <a href="{{ url('corpemt/action_stream') }}">
                    <i class="fa fa-bell" aria-hidden="true"></i> <span>Action Stream</span>
                    <small class="label pull-right bg-red">{{$pending_action}} Pending</small>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Action Filter</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('corpemt/filter/pending_action') }}"><i class="fa fa-users"></i> Pending Actions</a></li>
                    <li><a href="{{ url('corpemt/filter/completed_action') }}"><i class="fa fa-user-plus"></i> Completed Action</a></li>
                </ul>
            </li>
        <!-- <li class="treeview">
          <a href="#">
            <i class="ion ion-person"></i>
            <span>Team</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('/team/manage') }}"><i class="ion ion-person-stalker"></i> Manage Team</a></li>
            <li><a href="{{ url('/team/new') }}"><i class="ion ion-person-add"></i> Add New Member</a></li>
            <li><a href="{{ url('/team/assign') }}"><i class="ion ion-pin"></i> Assign To Client</a></li>
          </ul>
        </li> -->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-first-order"></i>
                    <span>Engagements</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('corpemt/engagement/manage') }}"><i class="fa fa-circle-o"></i> Manage Engagements</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-briefcase"></i> <span>Projects</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-briefcase"></i> Manage Projects</a></li>
                    <li><a href="#"><i class="fa fa-plus-circle"></i> New Project</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-envelope"></i> <span>Messages</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-inbox"></i> Inbox <span class="label pull-right bg-red">0</span></a>
                    </li>
                    <li><a href="#"><i class="ion ion-android-send"></i> Sent</a></li>
                </ul>
            </li>
            <li class="header">Quick Settings</li>
        <!--   <li><a href="{{ url('setting/status') }}"><i class="ion ion-ios-lightbulb-outline text-yellow"></i> <span>Status</span></a></li> -->
            <li><a href="{{ url('corpemt/setting/source') }}"><i class="ion ion-ios-paw text-aqua"></i> <span>Lead Source</span></a>
            </li>
            <!--       <li><a href="javascript:(0)"><i class="ion ion-ios-shuffle-strong text-green"></i> <span>Filter</span></a></li> -->
        <!-- <li><a href="{{ url('/company') }}"><i class="ion ion-ios-people text-green"></i> <span>Company</span></a></li>
        <li><a href="{{ url('/users') }}"><i class="ion ion-person text-blue"></i> <span>Users</span></a></li -->>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
