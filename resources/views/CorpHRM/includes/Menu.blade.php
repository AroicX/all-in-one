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
        <li class="header">HRM</li>
       <li>
       <a href="hrmops/department.html">
       <i class="fa  fa-dashboard"></i>
       <span>Dashboard</span>
       </a>
       </li>
    <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i> <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
      <ul class="treeview-menu">
            <li><a href="hrmops/addjob.html"><i class="fa  fa-th-list"></i> Post Jobs </a></li>
      <li><a href="hrmops/applicantlist.html"><i class="fa fa fa-th-list"></i> Applicant List </a></li>
      <li><a href="hrmops/interviewlist.html"><i class="fa fa fa-th-list"></i> Interview List </a></li>
      <li><a href="hrmops/hiredemployee.html"><i class="fa fa fa-th-list"></i> Hired Employee </a></li>
      
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-usd"></i> <span>Finance</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
      <ul class="treeview-menu">
            <li><a href="hrmops/managepayroll.html"><i class="fa fa fa-th-list"></i> Manage Payroll Template </a></li>
      <li><a href="hrmops/salary.html"><i class="fa fa fa-th-list"></i> Set Salary Details </a></li>
            <li><a href="pages/pay/employeesalary.html"><i class="fa fa fa-th-list"></i> Employee Salary List </a></li>
          </ul>
        </li>
         <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i> <span>Employee Managment</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="hrmops/employee.html"><i class="fa fa fa-th-list"></i> View Employee </a></li>
      <li><a href="hrmops/addemployee.html"><i class="fa fa fa-th-list"></i> Add Employee</a></li>
          </ul>
        </li>
                 <li class="treeview">
          <a href="#">
            <i class="fa fa-user-plus"></i> <span>Human Resource</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview">
            <a href="hrmops/employee.html"><i class="fa fa fa-th-list"></i><span>Recuitment</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
          <ul class="treeview-menu">
            <li><a href="hrmops/employee.html"><i class="fa fa fa-th-list"></i>Recuitment Application</a></li>
          </ul>
            </li>
      <li><a href="hrmops/addemployee.html"><i class="fa fa fa-th-list"></i> Tranings</a></li>
          </ul>
        </li>
    <li class="treeview">
          <a href="#">
            <i class="fa fa-clone"></i> <span> Organization</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
      <ul class="treeview-menu">
            <li><a href="hrmops/addtraining.html"><i class="fa fa fa-th-list"></i> Add Training</a></li>
      <li><a href="hrmops/training.html"><i class="fa fa fa-th-list"></i> View Training</a></li>
          </ul>
        </li>
    <li class="treeview">
          <a href="#">
            <i class="fa fa-balance-scale"></i> <span> Performance Metrics</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
                <ul class="treeview-menu">
            <li><a href="hrmops/addtraining.html"><i class="fa fa fa-th-list"></i> Add Training</a></li>
      <li><a href="hrmops/training.html"><i class="fa fa fa-th-list"></i> View Training</a></li>
          </ul>
        </li>
            <li class="treeview">
          <a href="#">
            <i class="fa fa-cogs"></i> <span>Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
                <ul class="treeview-menu">
            <li><a href="hrmops/addtraining.html"><i class="fa fa fa-th-list"></i> Add Training</a></li>
      <li><a href="hrmops/training.html"><i class="fa fa fa-th-list"></i> View Training</a></li>
          </ul>
        </li>
    <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-wrench"></i> <span>Settings</span>
          </a>
        </li> -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>