<li class="nav-item">
    <a href="{{ route('corpfin.dashboard') }}" class="nav-link ">
        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
        <span class="pcoded-mtext">CorpFIN Dashboard</span>
    </a>
</li>

{{--{{ $company }}--}}
@if(isset(Auth::user()->company->id))
<?php 
    $status = \App\Subscription::where('company_id', Auth::User()->company_id)->where('product','=','CorpFin')->first();

   

?>
@endif

@if($status->package == 'Basic')

<li class="nav-item pcoded-menu-caption">
        <label>Fin Ops</label>
    </li>


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



<li class="nav-item pcoded-hasmenu">
    <a href="#!" class="nav-link ">
        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
        <span class="pcoded-mtext">Transaction Partners</span></a>
    <ul class="pcoded-submenu">
        <li><a href="{{ route("corpfin.transaction.view") }}">View Partners</a></li>
        <li><a href="{{ route("corpfin.transaction.add") }}">Add Partner</a></li>
    </ul>
</li>
<li class="nav-item pcoded-hasmenu">
    <a href="#!" class="nav-link ">
        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
        <span class="pcoded-mtext">Manage Entries</span></a>
    <ul class="pcoded-submenu">
        <li><a href="{{ url('corpfin/add_entries') }}">Add Entries</a></li>
        <li><a href="{{ url('corpfin/view_ledgers') }}">View Ledger</a></li>
    </ul>
</li>
<li class="nav-item pcoded-menu-caption">
    <label>INVOICING</label>
</li>

<li class="nav-item pcoded-hasmenu">
    <a href="#!" class="nav-link ">
        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
        <span class="pcoded-mtext"> Quotes</span></a>
    <ul class="pcoded-submenu">
        <li><a href="{{ url('corpfin/invoice/quotes/add') }}"> Create Quote</a> </li>
        <li><a href="{{ url('corpfin/invoice/quote/view') }}"> View Quotes</a></li>
    </ul>
</li>
<li class="nav-item pcoded-hasmenu">
    <a href="#!" class="nav-link ">
        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
        <span class="pcoded-mtext"> Invoices</span></a>
    <ul class="pcoded-submenu">
        <li><a href="{{ url('corpfin/invoice/add') }}"> Create Invoice</a></li>
        <li><a href="{{ url('corpfin/invoice/view') }}"> View Invoices</a></li>
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

@else


<li class="nav-item pcoded-menu-caption">
        <label>Fin Ops</label>
    </li>

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
<li class="nav-item pcoded-hasmenu">
    <a href="#!" class="nav-link ">
        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
        <span class="pcoded-mtext">Transaction Partners</span></a>
    <ul class="pcoded-submenu">
        <li><a href="{{ route("corpfin.transaction.view") }}">View Partners</a></li>
        <li><a href="{{ route("corpfin.transaction.add") }}">Add Partner</a></li>
    </ul>
</li>
<li class="nav-item pcoded-hasmenu">
    <a href="#!" class="nav-link ">
        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
        <span class="pcoded-mtext">Manage Entries</span></a>
    <ul class="pcoded-submenu">
        <li><a href="{{ url('corpfin/add_entries') }}">Add Entries</a></li>
        <li><a href="{{ url('corpfin/view_ledgers') }}">View Ledger</a></li>
    </ul>
</li>
<li class="nav-item pcoded-menu-caption">
    <label>INVOICING</label>
</li>

<li class="nav-item pcoded-hasmenu">
    <a href="#!" class="nav-link ">
        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
        <span class="pcoded-mtext"> Quotes</span></a>
    <ul class="pcoded-submenu">
        <li><a href="{{ url('corpfin/invoice/quotes/add') }}"> Create Quote</a> </li>
        <li><a href="{{ url('corpfin/invoice/quote/view') }}"> View Quotes</a></li>
    </ul>
</li>
<li class="nav-item pcoded-hasmenu">
    <a href="#!" class="nav-link ">
        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
        <span class="pcoded-mtext"> Invoices</span></a>
    <ul class="pcoded-submenu">
        <li><a href="{{ url('corpfin/invoice/add') }}"> Create Invoice</a></li>
        <li><a href="{{ url('corpfin/invoice/view') }}"> View Invoices</a></li>
    </ul>
</li>
<li class="nav-item pcoded-menu-caption">
    <label>MAN-RETAIL</label>
</li>
<li class="nav-item pcoded-hasmenu">
    <a href="#!" class="nav-link ">
        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
        <span class="pcoded-mtext"> Orders</span></a>
    <ul class="pcoded-submenu">
        <li><a href="{{ url('inventory/order/create') }}"> Create Order</a></li>
        <li><a href="{{ url('inventory/order') }}"> View Orders</a></li>
    </ul>
</li>
<li class="nav-item pcoded-hasmenu">
    <a href="#!" class="nav-link ">
        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
        <span class="pcoded-mtext"> Warehouse</span></a>
    <ul class="pcoded-submenu">
        <li><a href="{{ url('warehouse/create') }}"> Add Warehouse</a></li>
        <li><a href="{{ url('warehouse') }}"> View Warehouses</a></li>
    </ul>
</li>
<li class="nav-item pcoded-hasmenu">
    <a href="#!" class="nav-link ">
        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
        <span class="pcoded-mtext"> Product Lines</span></a>
    <ul class="pcoded-submenu">
        <li><a href="{{route('productline.create')}}"> Create Product Line</a></li>
        <li><a href="{{route('productline.index')}}"> View Product Lines</a></li>
    </ul>
</li>
<li class="nav-item pcoded-hasmenu">
    <a href="#!" class="nav-link ">
        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
        <span class="pcoded-mtext"> Inventory Products</span></a>
    <ul class="pcoded-submenu">
        <li><a href="{{route('product.index')}}"> View Products</a></li>
    </ul>
</li>
<li class="nav-item pcoded-hasmenu">
    <a href="#!" class="nav-link ">
        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
        <span class="pcoded-mtext"> Shops</span></a>
    <ul class="pcoded-submenu">
        <li><a href="{{route('shop.create')}}"> Add Shop</a></li>
        <li><a href="{{route('shop.index')}}"> View Shops</a></li>
    </ul>
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


@endif