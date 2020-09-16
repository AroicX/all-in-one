
    <nav class="pcoded-navbar menu-light">
        <div class="navbar-wrapper  ">
            <div class="navbar-content scroll-div ps" >
                
                <div class="">
                    <div class="main-menu-header">
                        <img class="img-radius" src="../{{ Auth::user()->pic }}" alt="User-Profile-Image">
                        <div class="user-details">
                            <div id="more-details">{{ Auth::user()->name }} <i class="fa fa-caret-down"></i></div>
                        </div>
                    </div>
                    <div class="collapse" id="nav-user-link">
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="/profile" data-toggle="tooltip" title="View Profile"><i class="feather icon-user"></i></a></li>
                            <li class="list-inline-item"><a href="/messages"><i class="feather icon-mail" data-toggle="tooltip" title="Messages"></i></a></li>
                            <li class="list-inline-item"><a href="auth-signin.html" data-toggle="tooltip" title="Logout" class="text-danger"><i class="feather icon-power"></i></a></li>
                        </ul>
                    </div>
                </div>
                
                <ul class="nav pcoded-inner-navbar ">
                    
                    
                      <li class="nav-item">
                        <a href="{{ url('dashboard') }}" class="nav-link ">
                            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                            <span class="pcoded-mtext">Main Dashboard</span>
                        </a>
                    </li>
                       
                    <?php 
                    $status = \App\Subscription::where('company_id', Auth::User()->company_id)->where('product','=','CorpFin')->first();                                
                ?>
           
                    @if($status->package == 'Standard')

                    <li class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Switch Views</span></a>
                            <ul class="pcoded-submenu">
                                 
                                <li><a href="{{ url('corpfin/menu_view/Traditional') }}">Traditional view</a></li>
                                <li><a href="{{ url('corpfin/menu_view/Diary') }}">Diary view</a></li>
                            </ul>
                        </li>
                    @endif
                   
                    @if(Auth::user()->Corpfin_menutype == "Traditional")
                            @include('CorpFIN.includes.NewTraditional_menu')
                   @else
                            @include('CorpFIN.includes.NewDiary_menu')
                    @endif
                    

                </ul>
                
                <div class="card text-center">
                    <div class="card-block">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="feather icon-sunset f-40"></i>
                        <h6 class="mt-3">Help?</h6>
                        <p>Please contact us on our email for need any support</p>
                        <a href="#!" target="_blank" class="btn btn-primary btn-sm text-white m-0">Support</a>
                    </div>
                </div>
                
            </div>
        </div>
    </nav>
    <!-- [ navigation menu ] end