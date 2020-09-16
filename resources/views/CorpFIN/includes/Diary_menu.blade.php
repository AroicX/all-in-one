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
            <li class="header">Main Navigation</li>
            <li class="treeview">
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Main Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ route('corpfin.dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>CorpFIN Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-files-o"></i> <span>Switch Views</span>
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

            {{--{{ $company }}--}}
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
                        <a href="{{ route('corpfin.product.view') }}">
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

            <li class="header">INVOICING</li>


            @endif

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Transaction Partners</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route("corpfin.transaction.view") }}">
                            <i class="fa fa fa-th-list"></i>
                            View Partners
                        </a>
                    </li>
                    <li>
                        <a href="{{ route("corpfin.transaction.add") }}">
                            <i class="fa fa fa-user-plus"></i>
                            Add Partner
                        </a>
                    </li>
                </ul>
            </li>
            
            <!--      <li class="treeview">
                    <a href="#">
                        <i class="fa fa-money"></i> <span>Transaction Types</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ route('corpfin.trans.types.view') }}">
                                <i class="fa fa fa-th-list"></i>
                                View Types
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('corpfin.trans.types.add') }}">
                                <i class="fa fa fa-th-list"></i>
                                Add Types
                            </a>
                        </li>
                    </ul>
                </li> -->
            <!--        <li class="treeview">
                          <a href="#">
                            <i class="fa fa-dashboard"></i> <span> Manage Assets</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                          </a>
                          <ul class="treeview-menu">
                            <li><a href="finops/addasset.html"><i class="fa fa fa-th-list"></i> Add Assets</a></li>
                            <li><a href="finops/assets.html"><i class="fa fa fa-th-list"></i> View Asset</a></li>
                          </ul>
                        </li> -->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file-text"></i> <span> Manage Entries</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('corpfin/add_entries') }}"><i class="fa fa fa-th-list"></i> Add Entries</a>
                    </li>

                    <li><a href="{{ url('corpfin/view_ledgers') }}"><i class="fa fa fa-th-list"></i> View
                            Ledger</a>
                    </li>
                </ul>
            </li>
            <li class="header">INVOICING</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Quotes</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('corpfin/invoice/quotes/add') }}"><i class="fa fa fa-th-list"></i>
                            Create
                            Quote</a>
                    </li>
                    <li><a href="{{ url('corpfin/invoice/quote/view') }}"><i class="fa fa fa-th-list"></i> View
                            Quotes</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-folder-open"></i> <span>Invoices</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('corpfin/invoice/add') }}"><i class="fa fa fa-th-list"></i> Create
                            Invoice</a>
                    </li>
                    <li><a href="{{ url('corpfin/invoice/view') }}"><i class="fa fa fa-th-list"></i> View
                            Invoices</a>
                    </li>
                </ul>
            </li>


            <li class="header">MAN-RETAIL</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Orders</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('inventory/order/create')}}"><i class="fa fa fa-th-list"></i>
                            Record Order</a>
                    </li>
                    <li><a href="{{url('inventory/order/')}}"><i class="fa fa fa-th-list"></i> View
                            Orders</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Warehouse</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('warehouse.create')}}"><i class="fa fa fa-th-list"></i>
                            Add Warehouse</a>
                    </li>
                    <li><a href="{{route('warehouse.index')}}"><i class="fa fa fa-th-list"></i> View
                            Warehouses</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-folder-open"></i> <span>Product Lines</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('productline.create')}}"><i class="fa fa fa-th-list"></i> Create
                            Product Line</a>
                    </li>
                    <li><a href="{{route('productline.index')}}"><i class="fa fa fa-th-list"></i> View
                            Product Lines</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-folder-open"></i> <span>Inventory Products</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                    <li><a href="{{route('product.index')}}"><i class="fa fa fa-th-list"></i> View
                            Products</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-folder-open"></i> <span>Shops</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('shop.create')}}"><i class="fa fa fa-th-list"></i> Add Shop</a>
                    </li>
                    <li><a href="{{route('shop.index')}}"><i class="fa fa fa-th-list"></i> View
                            Shops</a>
                    </li>
                </ul>
            </li>
            <!-- end man retail -->
            <li class="header">REPORTS</li>
            <li class="treeview">
                <a href="{{ url('corpfin/reports') }}">
                    <i class="fa fa-file-archive-o"></i> <span> Generate Reports</span>
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
                    <li><a href="{{ url('corpfin/settings/markup') }}"><i class="fa fa fa-th-list"></i>Markup
                            Settings</a>
                    </li>
                    <li><a href="{{ url('corpfin/view_entries') }}"><i class="fa fa fa-th-list"></i>System
                            Settings</a>
                    </li>
                </ul>
            </li>
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>