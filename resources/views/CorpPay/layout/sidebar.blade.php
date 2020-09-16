<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Oluwole</p>
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
                    <i class="fa fa-dashboard"></i> <span>Bid Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="{{url('corp-pay/create_bid')}}"><i class="fa fa-circle-o"></i>Create Bid</a></li>
                    <li class="active"><a href="{{url('corp-pay/manage_bid')}}"><i class="fa fa-circle-o"></i>Manage Bid</a></li>
                </ul>
            </li>
            <li class="header">Vendor Management</li>

            <li class="treeview">
                <a href="{{url('corp-pay/add_new_vendor')}}">
                    <i class="fa fa-wrench"></i> <span>Add New Vendor</span>
                </a>
            </li>


            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>List of Vendors</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('/corp-pay/list_vendors/price_quote')}}"><i class="fa fa fa-th-list"></i> Request Price Quote</a></li>
                    <li><a href="{{url('/corp-pay/manage_price_quote')}}"><i class="fa fa fa-th-list"></i> Manage Price Quote</a></li>
                    <li><a href="{{url('/corp-pay/list_vendors/purchase_order')}}"><i class="fa fa fa-th-list"></i>Send Purchase Order</a></li>
                    <li><a href="{{url('/corp-pay/list_vendors/invoice')}}"><i class="fa fa fa-th-list"></i> Request Invoice</a></li>
                </ul>
            </li>   

            <li class="header">Payment</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-wrench"></i> <span>Process Payment</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-wrench"></i> <span>Processed Payment</span>
                </a>
            </li>

            <li class="header">Invoice Management</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-wrench"></i> <span>All Invoices</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-wrench"></i> <span>Pending</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-wrench"></i> <span>Approved</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-wrench"></i> <span>Rejected</span>
                </a>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa fa-th-list"></i>Vendor List</a></li>
                    <li><a href="#"><i class="fa fa fa-th-list"></i>Payments by Date</a></li>
                    <li><a href="#"><i class="fa fa fa-th-list"></i>Invoices List by Date</a></li>
                </ul>
            </li>

             <li class="treeview">
                <a href="{{url('/corp-pay/set_email')}}">
                    <i class="fa fa-wrench"></i> <span>Set Email</span>
                </a>
            </li>
       
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>