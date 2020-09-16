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
                <a href="#"><i class="fa fa-circle text-success"></i>Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i
                            class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            {{--  <li class="treeview">
            <a href="{{route('corphrm.dashboard')}}">
            <i class="fa fa-dashboard"></i><span>Dashboard</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            </li> --}}
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Employee</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if(CorpHRMAccessRoles('view_employee'))
                    <li>
                        <a href="{{url('/corphrm/employees')}}">
                            <i class="fa fa-th"></i> <span>Employee Listing</span>
                        </a>
                    </li>
                    @endif
                    @if(CorpHRMAccessRoles('view_emanager'))
                    <li>
                        <a href="{{url('/corphrm/employee/new')}}">
                            <i class="fa fa-th"></i> <span>Employee Manager</span>
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{url('/corphrm/employee')}}?query=edit&id=1&uid={{Auth::user()->id}}">
                            <i class="fa fa-th"></i> <span>Employee Details</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Recruitment</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if(CorpHRMAccessRoles('view_rprocess'))
                    <li><a href="{{url('/corphrm/rec_process')}}"><i class="fa fa-circle-o"></i>Recruitment Process </a>
                    </li>
                    @endif
                    @if(CorpHRMAccessRoles('view_rapplication'))
                    <li><a href="{{url('/corphrm/job_profile')}}"><i class="fa fa-circle-o"></i>Job Profile</a></li>
                    @endif
                    @if(CorpHRMAccessRoles('view_rapplication'))
                    <li><a href="{{url('/corphrm/rec_applications')}}"><i class="fa fa-circle-o"></i>Recruitment
                            Application </a></li>
                    @endif
                    @if(CorpHRMAccessRoles('vieW_rposting'))
                    <li><a href="{{url('/corphrm/rec_posting')}}"><i class="fa fa-circle-o"></i>Recruitment Posting </a>
                    </li>
                    @endif
                    @if(CorpHRMAccessRoles('view_iprocess'))
                    <li><a href="{{url('/corphrm/interview_process')}}"><i class="fa fa-circle-o"></i>Interview Process
                        </a></li>
                    @endif
                    @if(CorpHRMAccessRoles('view_irating'))
                    <li><a href="{{url('/corphrm/interview_rating')}}"><i class="fa fa-circle-o"></i>Interview Process
                            Rating </a></li>
                    @endif
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i><span>Claims</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if(CorpHRMAccessRoles('view_cmaster'))
                    <li><a href="{{url('/corphrm/claim_masters')}}"><i class="fa fa-circle-o"></i>Claims Master </a>
                    </li>
                    @endif
                    @if(CorpHRMAccessRoles('view_capplication'))
                    <li><a href="{{url('/corphrm/claim_applications')}}"><i class="fa fa-circle-o"></i>Claims
                            Application </a></li>
                    @endif
                    <li><a href="{{url('/corphrm/my/claim_applications')}}"><i class="fa fa-circle-o"></i>My Claims
                            Application </a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i><span>Loan</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if(CorpHRMAccessRoles('view_lmaster'))
                    <li><a href="{{url('/corphrm/loanmaster')}}"><i class="fa fa-circle-o"></i>Loan master </a></li>
                    @endif
                    @if(CorpHRMAccessRoles('view_lapplication'))
                    <li><a href="{{url('/corphrm/loanapp')}}"><i class="fa fa-circle-o"></i>Loan Application </a></li>
                    @endif
                    <li><a href="{{url('/corphrm/my/loanapp')}}"><i class="fa fa-circle-o"></i>My Loan Application </a>
                    </li>
                    @if(CorpHRMAccessRoles('view_lpayment'))
                    <li><a href="{{url('/corphrm/loanpayment')}}"><i class="fa fa-circle-o"></i>Loan Repayment </a></li>
                    @endif
                    <li><a href="{{url('/corphrm/my/loanpayment')}}"><i class="fa fa-circle-o"></i>My Loan Payment </a>
                    </li>
                    @if(CorpHRMAccessRoles('view_ldisbursment'))
                    <li><a href="{{url('/corphrm/loandisbursement')}}"><i class="fa fa-circle-o"></i>Loan Disbursment
                        </a></li>
                    @endif
                    <li><a href="{{url('/corphrm/my/loandisbursement')}}"><i class="fa fa-circle-o"></i>My Loan
                            Disbursment </a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i><span>Leave</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if(CorpHRMAccessRoles('view_lemaster'))
                    <li><a href="{{url('/corphrm/leavemaster')}}"><i class="fa fa-circle-o"></i>Leave master </a></li>
                    @endif
                    @if(CorpHRMAccessRoles('view_lecredit'))
                    <li><a href="{{url('/corphrm/leavecredit')}}"><i class="fa fa-circle-o"></i>Leave credit </a></li>
                    @endif
                    <li><a href="{{url('/corphrm/my/leavecredit')}}"><i class="fa fa-circle-o"></i>My Leave credit </a>
                    </li>
                    @if(CorpHRMAccessRoles('view_lecalendar'))
                    <li><a href="{{url('/corphrm/leavecalendar')}}"><i class="fa fa-circle-o"></i>Leave calendar </a>
                    </li>
                    @endif
                    @if(CorpHRMAccessRoles('view_leallowance'))
                    <li><a href="{{url('/corphrm/leaveallowance')}}"><i class="fa fa-circle-o"></i>Leave allowance </a>
                    </li>
                    @endif
                    <li><a href="{{url('/corphrm/my/leaveallowance')}}"><i class="fa fa-circle-o"></i>My Leave allowance
                        </a></li>
                    @if(CorpHRMAccessRoles('view_leapplication'))
                    <li><a href="{{url('/corphrm/leaveapp')}}"><i class="fa fa-circle-o"></i>Leave applicaton </a></li>
                    @endif
                    <li><a href="{{url('/corphrm/my/leaveapp')}}"><i class="fa fa-circle-o"></i>My Leave applicaton </a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i><span>Cash Advance</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if(CorpHRMAccessRoles('view_leapplication'))
                    <li><a href="{{url('/corphrm/cashadvance/disbursment')}}"><i class="fa fa-circle-o"></i>Disbursments
                        </a></li>
                    @endif
                    <li><a href="{{url('/corphrm/cashadvance/my/disbursment')}}"><i class="fa fa-circle-o"></i>My
                            Disbursments </a></li>
                    @if(CorpHRMAccessRoles('view_leapplication'))
                    <li><a href="{{url('/corphrm/cashadvance/retirement')}}"><i class="fa fa-circle-o"></i>Retirements
                        </a></li>
                    @endif
                    <li><a href="{{url('/corphrm/cashadvance/my/retirement')}}"><i class="fa fa-circle-o"></i>My
                            Retirements </a></ @if(CorpHRMAccessRoles('view_leapplication')) <li><a
                            href="{{url('/corphrm/cashadvance/advance')}}"><i class="fa fa-circle-o"></i>Advance</a>
                    </li>
                    @endif
                    <li><a href="{{url('/corphrm/cashadvance/my/advance')}}"><i class="fa fa-circle-o"></i>My
                            Advance</a></li>
                    @if(CorpHRMAccessRoles('view_leapplication'))
                    <li><a href="{{url('/corphrm/cashadvance/retirement_approval')}}"><i
                                class="fa fa-circle-o"></i>Retirement Approval</a></li>
                    @endif

                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i><span>Payroll</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if(CorpHRMAccessRoles('view_payroll'))
                    <li><a href="{{url('/corphrm/payroll/staffs')}}"><i class="fa fa-circle-o"></i>Generate Staff
                            Payroll</a></li>
                    @endif

                    <li><a href="{{url('/corphrm/payroll/staff')}}"><i class="fa fa-circle-o"></i>View Payslip</a></li>

                    <li><a href="{{url('/corphrm/payroll/staff_fees')}}"><i class="fa fa-circle-o"></i>Add Fees</a></li>
                </ul>
            </li>
            @if(CorpHRMAccessRoles('view_payment'))
            <li class="treeview">
                <a href="{{url('/corphrm/payments')}}">
                    <i class="fa fa-dashboard"></i><span>Payments</span>
                    {{--  <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>  --}}
                </a>
            </li>
            @endif
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i><span>Trainings</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('/corphrm/trainingmaster')}}"><i class="fa fa-circle-o"></i>Training Master </a>
                    </li>
                    <li><a href="{{url('/corphrm/trainingfacilitator')}}"><i class="fa fa-circle-o"></i>Training
                            facilitator </a></li>
                    <li><a href="{{url('/corphrm/trainingplan')}}"><i class="fa fa-circle-o"></i>Training Plan </a></li>
                </ul>
            </li>
            @if(CorpHRMAccessRoles('view_settings'))
            <li>
                <a href="{{url('/corphrm/settings')}}">
                    <i class="fa fa-th"></i> <span>Settings</span>

                </a>
            </li>
            @endif
            @if(CorpHRMAccessRoles('view_logs'))
            <li>
                <a href="{{route('corphrm.logged_user_actions')}}">
                    <i class="fa fa-dashboard"></i><span>Logs</span>
                    {{--  <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>  --}}
                </a>
            </li>
            @endif
        </ul>
    </section>

    <!-- /.sidebar -->
</aside>