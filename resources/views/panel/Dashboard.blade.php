
@extends('layout.master')


@section('title')
    <title>CorpERM Dashboard</title>
@endsection

@section('content')
<section class="content">
    <!-- Small boxes (Stat box) -->
    
    <div class="row">

       
            <!-- page statustic card start -->
           
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="text-c-yellow">$30200</h4>
                                    <h6 class="text-muted m-b-0">All Earnings</h6>
                                </div>
                                <div class="col-4 text-right">
                                    <i class="feather icon-bar-chart-2 f-28"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-c-yellow">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-white m-b-0">% change</p>
                                </div>
                                <div class="col-3 text-right">
                                    <i class="feather icon-trending-up text-white f-16"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="text-c-green">290+</h4>
                                    <h6 class="text-muted m-b-0">Page Views</h6>
                                </div>
                                <div class="col-4 text-right">
                                    <i class="feather icon-file-text f-28"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-c-green">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-white m-b-0">% change</p>
                                </div>
                                <div class="col-3 text-right">
                                    <i class="feather icon-trending-up text-white f-16"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="text-c-red">145</h4>
                                    <h6 class="text-muted m-b-0">Task</h6>
                                </div>
                                <div class="col-4 text-right">
                                    <i class="feather icon-calendar f-28"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-c-red">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-white m-b-0">% change</p>
                                </div>
                                <div class="col-3 text-right">
                                    <i class="feather icon-trending-down text-white f-16"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class="text-c-blue">500</h4>
                                    <h6 class="text-muted m-b-0">Downloads</h6>
                                </div>
                                <div class="col-4 text-right">
                                    <i class="feather icon-thumbs-down f-28"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-c-blue">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-white m-b-0">% change</p>
                                </div>
                                <div class="col-3 text-right">
                                    <i class="feather icon-trending-down text-white f-16"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
         
            <!-- page statustic card end -->
    
        <!-- prject ,team member start -->
    
        <div class="col-xl-8 col-md-12">
            <div class="card latest-update-card">
                <div class="card-header">
                    <h5>Latest Updates</h5>
                    <div class="card-header-right">
                        <div class="btn-group card-option">
                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="feather icon-more-horizontal"></i>
                            </button>
                            <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                                <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                                <li class="dropdown-item reload-card"><a href="#!"><i class="feather icon-refresh-cw"></i> reload</a></li>
                                <li class="dropdown-item close-card"><a href="#!"><i class="feather icon-trash"></i> remove</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="latest-update-box">
                        <div class="row p-t-30 p-b-30">
                            <div class="col-auto text-right update-meta">
                                <p class="text-muted m-b-0 d-inline-flex">2 hrs ago</p>
                                <i class="feather icon-twitter bg-twitter update-icon"></i>
                            </div>
                            <div class="col">
                                <a href="#!">
                                    <h6>+ 1652 Followers</h6>
                                </a>
                                <p class="text-muted m-b-0">You’re getting more and more followers, keep it up!</p>
                            </div>
                        </div>
                        <div class="row p-b-30">
                            <div class="col-auto text-right update-meta">
                                <p class="text-muted m-b-0 d-inline-flex">4 hrs ago</p>
                                <i class="feather icon-briefcase bg-c-red update-icon"></i>
                            </div>
                            <div class="col">
                                <a href="#!">
                                    <h6>+ 5 New Products were added!</h6>
                                </a>
                                <p class="text-muted m-b-0">Congratulations!</p>
                            </div>
                        </div>
                        <div class="row p-b-0">
                            <div class="col-auto text-right update-meta">
                                <p class="text-muted m-b-0 d-inline-flex">2 day ago</p>
                                <i class="feather icon-facebook bg-facebook update-icon"></i>
                            </div>
                            <div class="col">
                                <a href="#!">
                                    <h6>+1 Friend Requests</h6>
                                </a>
                                <p class="text-muted m-b-10">This is great, keep it up!</p>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <tbody><tr>
                                            <td class="b-none">
                                                <a href="#!" class="align-middle">
                                                    <img src="assets/images/user/avatar-2.jpg" alt="user image" class="img-radius wid-40 align-top m-r-15">
                                                    <div class="d-inline-block">
                                                        <h6>Jeny William</h6>
                                                        <p class="text-muted m-b-0">Graphic Designer</p>
                                                    </div>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="#!" class="b-b-primary text-primary">View all Projects</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- prject ,team member start -->
        <!-- seo start -->
       
       
        <!-- seo end -->

        <!-- Latest Customers start -->
       
        <div class="col-lg-4 col-md-12">
            <div class="card chat-card">
                <div class="card-header">
                    <h5>Chat</h5>
                    <div class="card-header-right">
                        <div class="btn-group card-option">
                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="feather icon-more-horizontal"></i>
                            </button>
                            <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                                <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                                <li class="dropdown-item reload-card"><a href="#!"><i class="feather icon-refresh-cw"></i> reload</a></li>
                                <li class="dropdown-item close-card"><a href="#!"><i class="feather icon-trash"></i> remove</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row m-b-20 received-chat">
                        <div class="col-auto p-r-0">
                            <img src="assets/images/user/avatar-2.jpg" alt="user image" class="img-radius wid-40">
                        </div>
                        <div class="col">
                            <div class="msg">
                                <p class="m-b-0">Nice to meet you!</p>
                            </div>
                            <p class="text-muted m-b-0"><i class="fa fa-clock-o m-r-10"></i>10:20am</p>
                        </div>
                    </div>
                    <div class="row m-b-20 send-chat">
                        <div class="col">
                            <div class="msg">
                                <p class="m-b-0">Nice to meet you!</p>
                            </div>
                            <p class="text-muted m-b-0"><i class="fa fa-clock-o m-r-10"></i>10:20am</p>
                        </div>
                        <div class="col-auto p-l-0">
                            <img src="assets/images/user/avatar-3.jpg" alt="user image" class="img-radius wid-40">
                        </div>
                    </div>
                    <div class="row m-b-20 received-chat">
                        <div class="col-auto p-r-0">
                            <img src="assets/images/user/avatar-2.jpg" alt="user image" class="img-radius wid-40">
                        </div>
                        <div class="col">
                            <div class="msg">
                                <p class="m-b-0">Nice to meet you!</p>
                                <img src="assets/images/widget/dashborad-1.jpg" alt="">
                                <img src="assets/images/widget/dashborad-3.jpg" alt="">
                            </div>
                            <p class="text-muted m-b-0"><i class="fa fa-clock-o m-r-10"></i>10:20am</p>
                        </div>
                    </div>
                    <div class="form-group m-t-15">
                        <label class="floating-label" for="Project">Send message</label>
                        <input type="text" name="task-insert" class="form-control" id="Project">
                        <div class="form-icon">
                            <button class="btn btn-primary btn-icon">
                                <i class="feather icon-message-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
        <!-- Latest Customers end -->
    </div>
</section>

@endsection