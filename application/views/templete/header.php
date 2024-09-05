<?php
if($this->session->MName=='' || $this->session->MLogin==false)
{
    $this->session->set_flashdata('msg', 'Your session has been expired');
    redirect(base_url().'login/index');
}
$user=$this->admin_model->getRow('admins',['id'=>$_SESSION['MUserId']]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?=$title;?></title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="description" content="Gradient Able Bootstrap admin template made using Bootstrap 4. The starter version of Gradient Able is completely free for personal project." />
      <meta name="keywords" content="free dashboard template, free admin, free bootstrap template, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
      <meta name="author" content="codedthemes">
      <!-- Favicon icon -->
      <link rel="icon" href="<?php echo base_url().'assets/images/shoplogo1.png'?>" type="image/x-icon">
      <!-- Google font-->
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
      <!-- Required Fremwork -->
      <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/bootstrap/css/bootstrap.min.css">
      <!-- themify-icons line icon -->
      <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/icon/themify-icons/themify-icons.css">
	  <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/icon/font-awesome/css/font-awesome.min.css">
      <!-- ico font -->
      <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/icon/icofont/css/icofont.css">
      <!-- Style.css -->
      <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/style.css">
      <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/jquery.mCustomScrollbar.css">
     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
     
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
     
       <!-- Include Parsley.js -->
       <style>
        label.error {
            color: red;
        }
        .pag-link{
    padding: 0.5rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1;
    border-radius: 0.21rem;
    margin: 5px;
    background: var(--primary);
    
    color:blue;
    transition: .2s;
}
.pag-link:hover{
    -webkit-box-shadow: 0 1px 2px 0 rgb(105 103 206 / 45%), 0 1px 3px 1px rgb(105 103 206 / 30%);
    box-shadow: 0 1px 2px 0 rgb(105 103 206 / 45%), 0 1px 3px 1px rgb(105 103 206 / 30%);
    color: #000;
}
    </style>
  </head>

  <body>
  <body>
	  <div class="fixed-button">
		<!-- <a href="https://codedthemes.com/item/gradient-able-admin-template" target="_blank" class="btn btn-md btn-primary">
			<i class="fa fa-shopping-cart" aria-hidden="true"></i> Upgrade To Pro
		</a> -->
	  </div>
       <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="loader-track">
            <div class="loader-bar"></div>
        </div>
    </div>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <nav class="navbar header-navbar pcoded-header">
               <div class="navbar-wrapper">
                   <div class="navbar-logo">
                       <a class="mobile-menu" id="mobile-collapse" href="#!">
                           <i class="ti-menu"></i>
                       </a>
                       <div class="mobile-search">
                           <div class="header-search">
                               <div class="main-search morphsearch-search">
                                   <div class="input-group">
                                       <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                                       <input type="text" class="form-control" placeholder="Enter Keyword">
                                       <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <a href="<?=base_url('dashboard');?>">
                           <img class="img-fluid" src="<?php echo base_url().'assets/images/shoplogo1.png'?>" width="60px" alt="Theme-Logo" />
                       </a>
                       <a class="mobile-options">
                           <i class="ti-more"></i>
                       </a>
                   </div>

                   <div class="navbar-container container-fluid">
                       <ul class="nav-left">
                           <li>
                               <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                           </li>
                           <li class="header-search">
                               <div class="main-search morphsearch-search">
                                   <div class="input-group">
                                       <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                                       <input type="text" class="form-control">
                                       <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                                   </div>
                               </div>
                           </li>
                           <li>
                               <a href="#!" onclick="javascript:toggleFullScreen()">
                                   <i class="ti-fullscreen"></i>
                               </a>
                           </li>
                       </ul>
                       <ul class="nav-right">
                           <li class="header-notification">
                               <a href="#!">
                                   <i class="ti-bell"></i>
                                   <span class="badge bg-c-pink"></span>
                               </a>
                               <ul class="show-notification">
                                   <li>
                                       <h6>Notifications</h6>
                                       <label class="label label-danger">New</label>
                                   </li>
                                   <li>
                                       <div class="media">
                                           <img class="d-flex align-self-center img-radius" src="assets/images/avatar-2.jpg" alt="Generic placeholder image">
                                           <div class="media-body">
                                               <h5 class="notification-user">John Doe</h5>
                                               <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                               <span class="notification-time">30 minutes ago</span>
                                           </div>
                                       </div>
                                   </li>
                                   <li>
                                       <div class="media">
                                           <img class="d-flex align-self-center img-radius" src="assets/images/avatar-4.jpg" alt="Generic placeholder image">
                                           <div class="media-body">
                                               <h5 class="notification-user">Joseph William</h5>
                                               <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                               <span class="notification-time">30 minutes ago</span>
                                           </div>
                                       </div>
                                   </li>
                                   <li>
                                       <div class="media">
                                           <img class="d-flex align-self-center img-radius" src="assets/images/avatar-3.jpg" alt="Generic placeholder image">
                                           <div class="media-body">
                                               <h5 class="notification-user">Sara Soudein</h5>
                                               <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                               <span class="notification-time">30 minutes ago</span>
                                           </div>
                                       </div>
                                   </li>
                               </ul>
                           </li>
                           
                           <li class="user-profile header-notification">
                               <a href="#!">
                                   <img src="assets/images/avatar-4.jpg" class="img-radius" alt="User-Profile-Image">
                                   <span><?=$_SESSION['MName'];?></span>
                                   <i class="ti-angle-down"></i>
                               </a>
                               <ul class="show-notification profile-notification">
                                   <!-- <li>
                                       <a href="#!">
                                           <i class="ti-settings"></i> Settings
                                       </a>
                                   </li> -->
                                   <li>
                                       <a href="user-profile.html">
                                           <i class="ti-user"></i> Profile
                                       </a>
                                   </li>
                                   
                                   <!-- <li>
                                       <a href="auth-lock-screen.html">
                                           <i class="ti-lock"></i> Lock Screen
                                       </a>
                                   </li> -->
                                   <li>
                                       <a href="<?php echo base_url().'login/logout';?>">
                                       <i class="ti-layout-sidebar-left"></i> Logout
                                   </a>
                                   </li>
                               </ul>
                           </li>
                       </ul>
                   </div>
               </div>
           </nav>
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                        <div class="pcoded-inner-navbar main-menu">
                            
                            <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation"></div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="active">
                                    <a href="<?=base_url('dashboard');?>">
                                        <span class="pcoded-micon"><i class="ti-home"></i><b></b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                            </ul>

                            <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-hasmenu ">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i><b></b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.menu-levels.main">Category</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="">
                                            <a href="<?=base_url();?>manage-category">
                                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                <span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-21">Manage Category</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="pcoded-hasmenu ">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i><b></b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.menu-levels.main">Product</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="">
                                            <a href="<?=base_url('manage-product');?>">
                                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                <span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-21">Manage Product</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="<?=base_url('home-header');?>">
                                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                <span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-21">Home Headers</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                 <li class="">
                                      <a href="<?=base_url('manage-customers');?>">
                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i><b></b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-21">Manage Customers</span>
                                        <span class="pcoded-mcaret"></span>
                                      </a>
                                 </li>
                                 <li class="">
                                      <a href="<?=base_url('manage-pincode');?>">
                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i><b></b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-21">Manage Pincode</span>
                                        <span class="pcoded-mcaret"></span>
                                      </a>
                                 </li>
                                 <li class="pcoded-hasmenu ">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i><b></b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.menu-levels.main">Manage Offers</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="">
                                            <a href="<?=base_url('offers');?>">
                                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                <span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-21">Create Offers</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="<?=base_url('apply-offer');?>">
                                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                <span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-21">Apply Offers</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                    </ul>

                                </li>
                                <li class="pcoded-hasmenu ">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i><b></b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.menu-levels.main">Manage Oders</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="">
                                            <a href="<?=base_url('orders');?>">
                                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                <span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-21">orders</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                    </ul>
                                    
                                </li>
                                 <li class="">
                                      <a href="<?=base_url('manage-banner');?>">
                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i><b></b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-21">Manage Banners</span>
                                        <span class="pcoded-mcaret"></span>
                                      </a>
                                 </li>
                                  <li class="">
                                      <a href="<?=base_url('manage-super-offer');?>">
                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i><b></b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-21">Manage Super Offer</span>
                                        <span class="pcoded-mcaret"></span>
                                      </a>
                                 </li>
                            </ul>
                        </div>
                    </nav>