        <li class="nav-item">
            <a href="{{ route('corptax-index') }}" class="nav-link ">
                <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                <span class="pcoded-mtext">CorpTax Dashboard</span>
            </a>
        </li>
        <li class="nav-item pcoded-menu-caption">
            <label>Tax Computation</label>
        </li>

        <li class="nav-item pcoded-hasmenu">
            <a href="#!" class="nav-link ">
                <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                <span class="pcoded-mtext"> Value Added TAX</span></a>
            <ul class="pcoded-submenu">
                <li><a href="{{route('logTransaction')}}"> Log Transaction</a></li>
                <li><a href="{{route('MonthlyVATReturn')}}"> Monthly VAT Returns</a></li>
                <li><a href="{{route('VATMovementSchedule')}}"> Prepare Movement Schedule</a></li>
            </ul>
        </li>
        <li class="nav-item pcoded-hasmenu">
            <a href="#!" class="nav-link ">
                <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                <span class="pcoded-mtext"> Withholding TAX </span></a>
            <ul class="pcoded-submenu">
                <li><a href="{{route('logTransactions')}}">Log Transactions</a></li>
                <li><a href="{{route('viewTransactions')}}">View Transaction by Period</a></li>
                <li><a href="{{route('accounts_movement')}}">Prepare Movement Schedule</a></li>
            </ul>
        </li>
        <li class="nav-item pcoded-hasmenu">
            <a href="#!" class="nav-link ">
                <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                <span class="pcoded-mtext"> Company Income TAX </span></a>
            <ul class="pcoded-submenu">
                <li><a href="{{route('profile-update')}}">Update Profile</a></li>
                <li><a href="{{route('cit-computation')}}">Compute CIT</a></li>
            </ul>
        </li>

        <li class="nav-item pcoded-menu-caption">
            <label> REPORTS</label>
        </li>



        <li class="nav-item pcoded-hasmenu">
            <a href="#!" class="nav-link ">
                <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                <span class="pcoded-mtext"> Generate Reports </span></a>
            <ul class="pcoded-submenu">
                <li><a href="javascript:void(0)">CIT Summary Computation</a></li>
                <li><a href="javascript:void(0)">DIT Summary</a></li>
                <li><a href="javascript:void(0)">ETR</a></li>
                <li><a href="{{route('accounts_movement')}}">Accounts Movement</a></li>
                <li><a href="javascript:void(0)">Tax Return Form</a></li>
            </ul>
        </li>