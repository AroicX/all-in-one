<?php 
    $status = \App\Subscription::where('company_id', Auth::User()->company_id)->where('product','=','CorpHRM')->first();                                
?>        
        
        <li class="nav-item pcoded-hasmenu">
            <a href="#!" class="nav-link ">
                <span class="pcoded-micon"><i class="feather icon-user-check"></i></span>
                <span class="pcoded-mtext"> Employee</span></a>
            <ul class="pcoded-submenu">
                @if(CorpHRMAccessRoles('view_employee'))
                <li>
                    <a href="{{url('/corphrm/employees')}}">
                        <span>Employee Listing</span>
                    </a>
                </li>
                @endif
                @if(CorpHRMAccessRoles('view_emanager'))
                <li>
                    <a href="{{url('/corphrm/employee/new')}}">
                        <span>Employee Manager</span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{url('/corphrm/employee')}}?query=edit&id=1&uid={{Auth::user()->id}}">
                        <span>Employee Details</span>
                    </a>
                </li>
            </ul>
        </li>


      

        <li class="nav-item pcoded-hasmenu">
            <a href="#!" class="nav-link ">
                <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                <span class="pcoded-mtext"> Recruitment</span></a>
            <ul class="pcoded-submenu">
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
       


        <li class="nav-item pcoded-hasmenu">
            <a href="#!" class="nav-link ">
                <span class="pcoded-micon"><i class="feather icon-tag"></i></span>
                <span class="pcoded-mtext"> Claims</span></a>
            <ul class="pcoded-submenu">
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

        <li class="nav-item pcoded-hasmenu">
            <a href="#!" class="nav-link ">
                <span class="pcoded-micon"><i class="feather icon-thumbs-up"></i></span>
                <span class="pcoded-mtext"> Loan </span></a>
            <ul class="pcoded-submenu">
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

        <li class="nav-item pcoded-hasmenu">
            <a href="#!" class="nav-link ">
                <span class="pcoded-micon"><i class="feather icon-user-minus"></i></span>
                <span class="pcoded-mtext"> Leave </span></a>
            <ul class="pcoded-submenu">
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
        <li class="nav-item pcoded-hasmenu">
            <a href="#!" class="nav-link ">
                <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
                <span class="pcoded-mtext"> Cash Advance </span></a>
            <ul class="pcoded-submenu">
                @if(CorpHRMAccessRoles('view_leapplication'))
                <li><a href="{{url('/corphrm/cashadvance/disbursment')}}"><i class="fa fa-circle-o"></i>Disbursments
                    </a></li>
                @endif
                <li><a href="{{url('/corphrm/my/cashadvance/disbursment')}}"><i class="fa fa-circle-o"></i>My
                        Disbursments </a></li>
                @if(CorpHRMAccessRoles('view_leapplication'))
                <li><a href="{{url('/corphrm/cashadvance/retirement')}}"><i class="fa fa-circle-o"></i>Retirements
                    </a></li>
                @endif
                <li><a href="{{url('/corphrm/my/cashadvance/retirement')}}"><i class="fa fa-circle-o"></i>My
                        Retirements </a></ @if(CorpHRMAccessRoles('view_leapplication')) <li><a
                        href="{{url('/corphrm/cashadvance/advance')}}"><i class="fa fa-circle-o"></i>Advance</a>
                </li>
                @endif
                <li><a href="{{url('/corphrm/my/cashadvance/advance')}}"><i class="fa fa-circle-o"></i>My
                        Advance</a></li>
                @if(CorpHRMAccessRoles('view_leapplication'))
                <li><a href="{{url('/corphrm/cashadvance/retirement_approval')}}"><i
                            class="fa fa-circle-o"></i>Retirement Approval</a></li>
                @endif
            </ul>
        </li>
        <li class="nav-item pcoded-hasmenu">
            <a href="#!" class="nav-link ">
                <span class="pcoded-micon"><i class="feather icon-list"></i></span>
                <span class="pcoded-mtext"> Payroll </span></a>
            <ul class="pcoded-submenu">
                <li><a href="{{url('/corphrm/payroll/salary')}}"><i class="fa fa-circle-o"></i>Salary </a></li>
                @if(CorpHRMAccessRoles('view_payroll'))
                <li><a href="{{url('/corphrm/payroll/staffs')}}"><i class="fa fa-circle-o"></i>Generate Staff
                        Payroll</a></li>
                @endif

                <li><a href="{{url('/corphrm/payroll/staff')}}"><i class="fa fa-circle-o"></i>View Payslip</a></li>

                <li><a href="{{url('/corphrm/payroll/staff_fees')}}"><i class="fa fa-circle-o"></i>Add Fees</a></li>
            </ul>
        </li>
        @if(CorpHRMAccessRoles('view_payment'))
        <li class="nav-item">
            <a href="{{url('/corphrm/payments')}}" class="nav-link ">
                <span class="pcoded-micon"><i class="feather icon-hash"></i></span>
                <span class="pcoded-mtext">Payments</span>
            </a>
        </li>
        @endif
        {{-- <li class="nav-item pcoded-hasmenu">
            <a href="#!" class="nav-link ">
                <span class="pcoded-micon"><i class="feather icon-trending-up"></i></span>
                <span class="pcoded-mtext"> Trainings </span></a>
            <ul class="pcoded-submenu">
                <li><a href="{{url('/corphrm/trainingmaster')}}"><i class="fa fa-circle-o"></i>Training Master </a>
                </li>
                <li><a href="{{url('/corphrm/trainingfacilitator')}}"><i class="fa fa-circle-o"></i>Training
                        facilitator </a></li>
                <li><a href="{{url('/corphrm/trainingplan')}}"><i class="fa fa-circle-o"></i>Training Plan </a></li>
            </ul>
        </li> --}}
        @if(CorpHRMAccessRoles('view_settings'))
        <li class="nav-item">
            <a href="{{url('/corphrm/settings')}}" class="nav-link ">
                <span class="pcoded-micon"><i class="feather icon-settings"></i></span>
                <span class="pcoded-mtext">Settings</span>
            </a>
        </li>

        @endif
        @if(CorpHRMAccessRoles('view_logs'))
        <li class="nav-item">
            <a href="{{route('corphrm.logged_user_actions')}}" class="nav-link ">
                <span class="pcoded-micon"><i class="feather icon-list"></i></span>
                <span class="pcoded-mtext">Logs</span>
            </a>
        </li>
        @endif