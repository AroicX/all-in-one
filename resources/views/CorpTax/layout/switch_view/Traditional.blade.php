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
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">Main Navigation</li>

    <li class="treeview">
          <a href="{{ url('dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Main Dashboard</span>
          </a>
        </li>
            <li class="treeview">
          <a href="{{ url('corpfin/dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>CorpFIN Dashboard</span>
          </a>
        </li>
                    <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Switch Views</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
      <ul class="treeview-menu">

    <li>
    <a href="{{ url('corpfin/menu_view/Traditional') }}">
    <i class="fa fa fa-th-list"></i>
    Traditional view
    </a>
    </li>

      <li>
      <a href="{{ url('corpfin/menu_view/Diary') }}">
      <i class="fa fa fa-th-list"></i>
      Diary view
      </a>
      </li>

      </ul>
        </li>
        
		<li class="header">Fin Ops</li>
		<li class="treeview">
          <a href="/corpfin/traditional/general_ledger">
            <i class="fa fa-dashboard"></i> <span>General Ledger</span>
          </a>
        </li>

		<li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Sales Ledger</span>
          </a>
        </li>

		<li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Purchases Ledger</span>
          </a>
        </li>

		<li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Fixed Assets</span>
          </a>
        </li>

            <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Cash & Bank</span>
          </a>
        </li>

    <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Inventory</span>
          </a>
        </li>

    <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Customer Contact</span>
          </a>
        </li>

    <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Point Of Sale</span>
          </a>
        </li>
      @if(isset(Auth::user()->company->id))
                @if(Auth::user()->company->deliverable_type == "Product")
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-cubes"></i> <span>Manage Product</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{ route("corpfin.product.view") }}">
                                    <i class="fa fa fa-th-list"></i>
                                    View Products
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('corpfin/add_product') }}">
                                    <i class="fa fa fa-th-list"></i>
                                    Add Product
                                </a>
                            </li>
                        </ul>
                    </li>

                @elseif (Auth::user()->company->deliverable_type == "Services")
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-suitcase"></i> <span>Manage Services</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{ url('corpfin/view_services') }}">
                                    <i class="fa fa fa-th-list"></i>
                                    View Services
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('corpfin/add_services') }}">
                                    <i class="fa fa fa-th-list"></i>
                                    Add Services
                                </a>
                            </li>
                        </ul>
                    </li>
                @elseif (Auth::user()->company->deliverable_type == "Both")

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-cubes"></i> <span>Manage Product</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{ route("corpfin.product.view") }}">
                                    <i class="fa fa fa-th-list"></i>
                                    View Products
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('corpfin.product.add') }}">
                                    <i class="fa fa fa-th-list"></i>
                                    Add Product
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-suitcase"></i> <span>Manage Services</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{ route('corpfin.service.view') }}">
                                    <i class="fa fa fa-th-list"></i>
                                    View Services
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('corpfin.service.add') }}">
                                    <i class="fa fa fa-th-list"></i>
                                    Add Services
                                </a>
                            </li>
                        </ul>
                    </li>

                @endif
                @endif
		<li class="header">REPORTS</li>

    <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Import Transaction</span>
          </a>
        </li>

		<li class="treeview">
          <a href="{{ url('corpfin/reports') }}">
            <i class="fa fa-dashboard"></i> <span>Generate Reports</span>
          </a>
        </li>

		  <li class="treeview">
                    <a href="#">
                        <i class="fa fa-wrench"></i> <span>Settings</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('corpfin/settings/invoice_groups') }}"><i class="fa fa fa-th-list"></i>Invoice
                                Groups</a></li>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-wrench"></i> <span>Tax Rates</span>
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ route('vatrates') }}"><i class="fa fa fa-th-list"></i>VAT</a></li>
                            </ul>
                            <ul class="treeview-menu">
                                <li><a href="{{ route('whtrates') }}"><i class="fa fa fa-th-list"></i>WHT</a></li>
                            </ul>
                        </li>

                        <li><a href="{{ url('corpfin/settings/payment_method') }}"><i class="fa fa fa-th-list"></i>Payment
                                Method</a></li>
                        <li><a href="{{ url('corpfin/settings/markup') }}"><i class="fa fa fa-th-list"></i>Markup Settings</a>
                        </li>
                        <li><a href="{{ url('corpfin/view_entries') }}"><i class="fa fa fa-th-list"></i>System
                                Settings</a>
                        </li>
                    </ul>
                </li>
    
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>