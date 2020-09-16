<li class="nav-item pcoded-menu-caption">
    <label>Fin Ops</label>
</li>
<li class="nav-item">
  <a href="/corpfin/traditional/general_ledger" class="nav-link ">
    <span class="pcoded-micon">
      <i class="feather icon-aperture"></i>
    </span>
    <span class="pcoded-mtext">General Ledger</span>
  </a>
</li>
<li class="nav-item">
  <a href="#" class="nav-link ">
    <span class="pcoded-micon">
      <i class="feather icon-aperture"></i>
    </span>
    <span class="pcoded-mtext">Sales Ledger</span>
  </a>
</li>
<li class="nav-item">
  <a href="#" class="nav-link ">
    <span class="pcoded-micon">
      <i class="feather icon-aperture"></i>
    </span>
    <span class="pcoded-mtext">Purchases Ledger</span>
  </a>
</li>
<li class="nav-item">
  <a href="#" class="nav-link ">
    <span class="pcoded-micon">
      <i class="feather icon-aperture"></i>
    </span>
    <span class="pcoded-mtext">Fixed Assets</span>
  </a>
</li>
<li class="nav-item">
  <a href="#" class="nav-link ">
    <span class="pcoded-micon">
      <i class="feather icon-aperture"></i>
    </span>
    <span class="pcoded-mtext">Cash & Bank</span>
  </a>
</li>
<li class="nav-item">
  <a href="#" class="nav-link ">
    <span class="pcoded-micon">
      <i class="feather icon-aperture"></i>
    </span>
    <span class="pcoded-mtext">Inventory</span>
  </a>
</li>
<li class="nav-item">
  <a href="#" class="nav-link ">
    <span class="pcoded-micon">
      <i class="feather icon-aperture"></i>
    </span>
    <span class="pcoded-mtext">Customer Contact</span>
  </a>
</li>
<li class="nav-item">
  <a href="#" class="nav-link ">
    <span class="pcoded-micon">
      <i class="feather icon-aperture"></i>
    </span>
    <span class="pcoded-mtext">Point Of Sale</span>
  </a>
</li>
 @if(isset(Auth::user()->company->id))
   @if(Auth::user()->company->deliverable_type == "Product")
    <li class="nav-item pcoded-hasmenu">
        <a href="#!" class="nav-link ">
            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
            <span class="pcoded-mtext">Manage Product</span></a>
        <ul class="pcoded-submenu">
            <li><a href="{{ route("corpfin.product.view") }}">View Products</a></li>
            <li><a href="{{ url('corpfin/add_product') }}">Add Product</a></li>
        </ul>
    </li>
    @elseif (Auth::user()->company->deliverable_type == "Services")
    <li class="nav-item pcoded-hasmenu">
        <a href="#!" class="nav-link ">
            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
            <span class="pcoded-mtext">Manage Services</span></a>
        <ul class="pcoded-submenu">
            <li><a href="{{ url('corpfin/view_services') }}">View Services</a></li>
            <li><a href="{{ url('corpfin/add_services') }}">Add Services</a></li>
        </ul>
    </li>
    @elseif (Auth::user()->company->deliverable_type == "Both")
    <li class="nav-item pcoded-hasmenu">
        <a href="#!" class="nav-link ">
            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
            <span class="pcoded-mtext">Manage Product</span></a>
        <ul class="pcoded-submenu">
            <li><a href="{{ route('corpfin.product.view') }}">View Products</a></li>
            <li><a href="{{ route('corpfin.product.add') }}">Add Product</a></li>
        </ul>
    </li>
    <li class="nav-item pcoded-hasmenu">
        <a href="#!" class="nav-link ">
            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
            <span class="pcoded-mtext">Manage Services</span></a>
        <ul class="pcoded-submenu">
            <li><a href="{{ route('corpfin.service.view') }}">View Services</a></li>
            <li><a href="{{ route('corpfin.service.add') }}">Add Services</a></li>
        </ul>
    </li>
    @endif
@endif
<li class="nav-item pcoded-menu-caption">
    <label>REPORTS</label>
</li>
<li class="nav-item">
  <a href="#" class="nav-link ">
    <span class="pcoded-micon">
      <i class="feather icon-aperture"></i>
    </span>
    <span class="pcoded-mtext">Import Transaction</span>
  </a>
</li>
<li class="nav-item pcoded-hasmenu">
    <a href="#!" class="nav-link ">
        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
        <span class="pcoded-mtext"> Reports</span></a>
    <ul class="pcoded-submenu">
        <li><a href="{{ url('corpfin/reports') }}">Generate Reports</a></li>
    </ul>
</li>
<li class="nav-item pcoded-hasmenu">
    <a href="#!" class="nav-link ">
        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
        <span class="pcoded-mtext"> Settings</span></a>
    <ul class="pcoded-submenu">
        <li><a href="{{ url('corpfin/settings/invoice_groups') }}"> Invoice Groups</a></li>
        <li class="pcoded-hasmenu"> 
            <a href="#">Tax Rates</a>
            <ul class="pcoded-submenu">
                <li><a href="{{ route('vatrates') }}">VAT</a></li>
                <li><a href="{{ route('whtrates') }}">WHT</a></li>
            </ul>
        </li>
        <li><a href="{{ url('corpfin/settings/payment_method') }}"> Payment Method</a></li>
        <li><a href="{{ url('corpfin/settings/markup') }}"> Markup Settings</a></li>
        <li><a href="{{ url('corpfin/view_entries') }}"> System Settings</a></li>
    </ul>
</li>