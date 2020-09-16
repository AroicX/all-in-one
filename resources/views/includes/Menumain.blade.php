        <!-- Left side column. contains the logo and sidebar -->
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
        <li class="header">MODULES</li>
        <li class="treeview">
          <a href="{{url('dashboard')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboards</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="{{url('corpfin/dashboard')}}">
            <i class="fa fa-files-o"></i>
            <span>CorpFin</span>
<!--             <span class="pull-right-container">
              <span class="label pull-right bg-red">3</span>
			  <span class="label pull-right bg-yellow">12</span>
			  <span class="label label-primary pull-right">4</span>
			  <span class="label pull-right bg-green">new*</span>
            </span> -->
          </a>
<!--           <ul class="treeview-menu">
            <li><a href="CorpFin/finops/addentry.html"><i class="fa fa-circle-o"></i>Launch Application</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>My Profile</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Print Reports</a></li>
          </ul> -->
        </li>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>CorpHRM</span>
<!--             <span class="pull-right-container">
              <span class="label pull-right bg-red">3</span>
			  <span class="label pull-right bg-yellow">12</span>
			  <span class="label label-primary pull-right">4</span>
			  <span class="label pull-right bg-green">new*</span>
            </span> -->
          </a>
<!--           <ul class="treeview-menu">
            <li><a href="CorpHRM/hrmops/addjob.html"><i class="fa fa-circle-o"></i>Launch Application</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>My Profile</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Print Reports</a></li>
          </ul> -->
        </li>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>CorpTax</span>
<!--             <span class="pull-right-container">
              <span class="label pull-right bg-red">3</span>
			  <span class="label pull-right bg-yellow">12</span>
			  <span class="label label-primary pull-right">4</span>
			  <span class="label pull-right bg-green">new*</span>
            </span> -->
          </a>
<!--           <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i>Launch Application</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>My Profile</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Print Reports</a></li>
          </ul> -->
        </li>
            <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>CorpEMT</span>
<!--             <span class="pull-right-container">
              <span class="label pull-right bg-red">3</span>
        <span class="label pull-right bg-yellow">12</span>
        <span class="label label-primary pull-right">4</span>
        <span class="label pull-right bg-green">new*</span>
            </span> -->
          </a>
<!--           <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i>Launch Application</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>My Profile</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Print Reports</a></li>
          </ul> -->
        </li>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>CorpPay</span>
<!--             <span class="pull-right-container">
              <span class="label pull-right bg-red">3</span>
			  <span class="label pull-right bg-yellow">12</span>
			  <span class="label label-primary pull-right">4</span>
			  <span class="label pull-right bg-green">new*</span>
            </span> -->
          </a>
<!--           <ul class="treeview-menu">
            <li><a href="CorpPay/payops/accounts.html"><i class="fa fa-circle-o"></i>Launch Application</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>My Profile</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Print Reports</a></li>
          </ul> -->
        </li>
		<li>
          <a href="mailbox/mailbox.html">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
<!--             <span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span> -->
          </a>
        </li>
        </ul>
            </section>
    <!-- /.sidebar -->
  </aside>