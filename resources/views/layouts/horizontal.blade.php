<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{URL::asset('assets/images/logo-sm.png')}}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{URL::asset('assets/images/logo-dark.png')}}" alt="" height="17">
                    </span>
                </a>

                <a href="index" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{URL::asset('assets/images/logo-sm.png')}}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{URL::asset('assets/images/logo-light.png')}}" alt="" height="18">
                    </span>
                </a>
            </div>

            <button type="button" aria-label="waves-effect" class="btn btn-sm me-2 font-size-24 d-lg-none header-item waves-effect waves-light"
                data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="mdi mdi-menu"></i>
            </button>

        </div>

        <div class="d-flex">

            <!-- App Search-->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="fa fa-search"></span>
                </div>
            </form>

            <div class="dropdown d-none d-md-block ms-2">
                <button type="button" class="btn header-item waves-effect" aria-label="waves-effect" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <img class="me-2" src="{{URL::asset('assets/images/flags/us_flag.jpg')}}" alt="Header Language" height="16"> English
                    <span class="mdi mdi-chevron-down"></span>
                </button>
                <div class="dropdown-menu dropdown-menu-end">

                    <!-- item-->
                    <a href="#" class="dropdown-item notify-item">
                        <img src="{{URL::asset('assets/images/flags/germany_flag.jpg')}}" alt="user-image" class="me-1" height="12"> <span
                            class="align-middle"> German </span>
                    </a>

                    <!-- item-->
                    <a href="#" class="dropdown-item notify-item">
                        <img src="{{URL::asset('assets/images/flags/italy_flag.jpg')}}" alt="user-image" class="me-1" height="12"> <span
                            class="align-middle"> Italian </span>
                    </a>

                    <!-- item-->
                    <a href="#" class="dropdown-item notify-item">
                        <img src="{{URL::asset('assets/images/flags/french_flag.jpg')}}" alt="user-image" class="me-1" height="12"> <span
                            class="align-middle"> French </span>
                    </a>

                    <!-- item-->
                    <a href="#" class="dropdown-item notify-item">
                        <img src="{{URL::asset('assets/images/flags/spain_flag.jpg')}}" alt="user-image" class="me-1" height="12"> <span
                            class="align-middle"> Spanish </span>
                    </a>

                    <!-- item-->
                    <a href="#" class="dropdown-item notify-item">
                        <img src="{{URL::asset('assets/images/flags/russia_flag.jpg')}}" alt="user-image" class="me-1" height="12"> <span
                            class="align-middle"> Russian </span>
                    </a>
                </div>
            </div>

            <div class="dropdown d-none d-lg-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen" aria-label="fullscreen button">
                    <i class="mdi mdi-fullscreen"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false" aria-label="notification button">
                    <i class="mdi mdi-bell-outline"></i>
                    <span class="badge bg-danger rounded-pill">3</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="m-0 font-size-16"> Notifications (258) </h5>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        <a href="#" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <span class="avatar-title bg-success rounded-circle font-size-16">
                                            <i class="mdi mdi-cart-outline"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Your order is placed</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">Dummy text of the printing and typesetting.</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="#" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <span class="avatar-title bg-warning rounded-circle font-size-16">
                                            <i class="mdi mdi-message-text-outline"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">New Message received</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">You have 87 unread messages</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="#" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <span class="avatar-title bg-info rounded-circle font-size-16">
                                            <i class="mdi mdi-glass-cocktail"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Your item is shipped</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">It is a long established fact that a reader will</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="#" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <span class="avatar-title bg-primary rounded-circle font-size-16">
                                            <i class="mdi mdi-cart-outline"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Your order is placed</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">Dummy text of the printing and typesetting industry.</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="#" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <span class="avatar-title bg-danger rounded-circle font-size-16">
                                            <i class="mdi mdi-message-text-outline"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">New Message received</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">You have 87 unread messages</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-top">
                        <div class="d-grid">
                            <a class="btn btn-sm btn-link font-size-14 text-center" href="#">
                                View all
                            </a>
                        </div>    
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="user dropdown">
                    <img class="rounded-circle header-profile-user" src="{{URL::asset('assets/images/users/user-4.jpg')}}"
                        alt="Header Avatar">
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="#"><i
                            class="mdi mdi-account-circle font-size-17 align-middle me-1"></i> Profile</a>
                    <a class="dropdown-item" href="#"><i class="mdi mdi-wallet font-size-17 align-middle me-1"></i> My
                        Wallet</a>
                    <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end">11</span><i
                            class="mdi mdi-cog font-size-17 align-middle me-1"></i> Settings</a>
                    <a class="dropdown-item" href="#"><i
                            class="mdi mdi-lock-open-outline font-size-17 align-middle me-1"></i> Lock screen</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="#"><i
                            class="bx bx-power-off font-size-17 align-middle me-1 text-danger"></i> Logout</a>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect" aria-label="notfication icon">
                    <i class="mdi mdi-cog-outline"></i>
                </button>
            </div>

        </div>
    </div>
</header>

<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index">
                            <i class="ti-home me-2"></i>Dashboard
                        </a>
                    </li>

                    <li class="nav-item dropdown mega-dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button">
                            <i class="ti-package me-2"></i>UI Elements
                        </a>

                        <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-menu-start dropdown-mega-menu-xl"
                            aria-labelledby="topnav-uielement">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div>
                                        <a href="ui-alerts" class="dropdown-item">Alerts</a>
                                        <a href="ui-buttons" class="dropdown-item">Buttons</a>
                                        <a href="ui-cards" class="dropdown-item">Cards</a>
                                        <a href="ui-carousel" class="dropdown-item">Carousel</a>
                                        <a href="ui-dropdowns" class="dropdown-item">Dropdowns</a>
                                        <a href="ui-grid" class="dropdown-item">Grid</a>
                                        <a href="ui-images" class="dropdown-item">Images</a>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div>
                                        <a href="ui-lightbox" class="dropdown-item">Lightbox</a>
                                        <a href="ui-modals" class="dropdown-item">Modals</a>
                                        <a href="ui-rangeslider" class="dropdown-item">Range Slider</a>
                                        <a href="ui-session-timeout" class="dropdown-item">Session Timeout</a>
                                        <a href="ui-progressbars" class="dropdown-item">Progress Bars</a>
                                        <a href="ui-sweet-alert" class="dropdown-item">SweetAlert 2</a>
                                        <a href="ui-tabs-accordions" class="dropdown-item">Tabs & Accordions</a>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div>
                                        <a href="ui-typography" class="dropdown-item">Typography</a>
                                        <a href="ui-video" class="dropdown-item">Video</a>
                                        <a href="ui-general" class="dropdown-item">General</a>
                                        <a href="ui-colors" class="dropdown-item">Colors</a>
                                        <a href="ui-rating" class="dropdown-item">Rating</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components" role="button">
                            <i class="ti-harddrives me-2"></i>Components
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-components">

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-email">
                                    Email <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-email">
                                    <a href="email-inbox" class="dropdown-item">Inbox</a>
                                    <a href="email-read" class="dropdown-item">Email Read</a>
                                    <a href="email-compose" class="dropdown-item">Email Compose</a>
                                </div>
                            </div>

                            <a href="calendar" class="dropdown-item">Calendar</a>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form">
                                    Forms <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-form">
                                    <a href="form-elements" class="dropdown-item">Form Elements</a>
                                    <a href="form-validation" class="dropdown-item">Form Validation</a>
                                    <a href="form-advanced" class="dropdown-item">Form Advanced</a>
                                    <a href="form-editors" class="dropdown-item">Form Editors</a>
                                    <a href="form-uploads" class="dropdown-item">Form File Upload</a>
                                    <a href="form-xeditable" class="dropdown-item">Form Xeditable</a>
                                    <a href="form-repeater" class="dropdown-item">Form Repeater</a>
                                    <a href="form-wizard" class="dropdown-item">Form Wizard</a>
                                    <a href="form-mask" class="dropdown-item">Form Mask</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-chart">
                                    Charts <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-chart">
                                    <a href="charts-morris" class="dropdown-item">Morris Chart</a>
                                    <a href="charts-chartist" class="dropdown-item">Chartist Chart</a>
                                    <a href="charts-chartjs" class="dropdown-item">Chartjs Chart</a>
                                    <a href="charts-flot" class="dropdown-item">Flot Chart</a>
                                    <a href="charts-knob" class="dropdown-item">Jquery Knob Chart</a>
                                    <a href="charts-sparkline" class="dropdown-item">Sparkline Chart</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-table">
                                    Tables <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-table">
                                    <a href="tables-basic" class="dropdown-item">Basic Tables</a>
                                    <a href="tables-datatable" class="dropdown-item">Data Tables</a>
                                    <a href="tables-responsive" class="dropdown-item">Responsive Tables</a>
                                    <a href="tables-editable" class="dropdown-item">Editable Tables</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-icons">
                                    Icons <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-icons">
                                    <a href="icons-material" class="dropdown-item">Material Design</a>
                                    <a href="icons-fontawesome" class="dropdown-item">Font Awesome</a>
                                    <a href="icons-ion" class="dropdown-item">Ion Icons</a>
                                    <a href="icons-themify" class="dropdown-item">Themify Icons</a>
                                    <a href="icons-dripicons" class="dropdown-item">Dripicons</a>
                                    <a href="icons-typicons" class="dropdown-item">Typicons Icons</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-map">
                                    Maps <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-map">
                                    <a href="maps-google" class="dropdown-item"> Google Map</a>
                                    <a href="maps-vector" class="dropdown-item"> Vector Map</a>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown mega-dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-auth" role="button">
                            <i class="ti-archive me-2"></i> Authentication
                        </a>

                        <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-lg" aria-labelledby="topnav-auth">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div>
                                        <a href="pages-login" class="dropdown-item">Login 1</a>
                                        <a href="pages-register" class="dropdown-item">Register 1</a>
                                        <a href="pages-recoverpw" class="dropdown-item">Recover Password 1</a>
                                        <a href="pages-lock-screen" class="dropdown-item">Lock Screen 1</a>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div>
                                        <a href="pages-login-2" class="dropdown-item">Login 2</a>
                                        <a href="pages-register-2" class="dropdown-item">Register 2</a>
                                        <a href="pages-recoverpw-2" class="dropdown-item">Recover Password 2</a>
                                        <a href="pages-lock-screen-2" class="dropdown-item">Lock Screen 2</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown mega-dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-extrapages" role="button">
                            <i class="ti-support me-2"></i> Extra Pages
                        </a>

                        <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-lg" aria-labelledby="topnav-extrapages">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div>
                                        <a href="pages-timeline" class="dropdown-item">Timeline</a>
                                        <a href="pages-invoice" class="dropdown-item">Invoice</a>
                                        <a href="pages-directory" class="dropdown-item">Directory</a>
                                        <a href="pages-starter" class="dropdown-item">Starter Page</a>
                                        <a href="pages-404" class="dropdown-item">Error 404</a>
                                        <a href="pages-500" class="dropdown-item">Error 500</a>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div>
                                        <a href="pages-pricing" class="dropdown-item">Pricing</a>
                                        <a href="pages-gallery" class="dropdown-item">Gallery</a>
                                        <a href="pages-maintenance" class="dropdown-item">Maintenance</a>
                                        <a href="pages-comingsoon" class="dropdown-item">Coming Soon</a>
                                        <a href="pages-faq" class="dropdown-item">Faq</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-emailtemplates" role="button">
                            <i class="ti-bookmark-alt me-2"></i>Email Templates
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-emailtemplates">
                            <a href="email-template-basic" class="dropdown-item">Basic Action Email</a>
                            <a href="email-template-alert" class="dropdown-item">Alert Email</a>
                            <a href="email-template-billing" class="dropdown-item">Billing Email</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button">
                            <i class="ti-layout me-2"></i> Layouts
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-layout">
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-verti"
                                    role="button">
                                    Vertical <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-layout-verti">
                                    <a href="layouts-light-sidebar" class="dropdown-item">Light Sidebar</a>
                                    <a href="layouts-compact-sidebar" class="dropdown-item">Compact Sidebar</a>
                                    <a href="layouts-icon-sidebar" class="dropdown-item">Icon Sidebar</a>
                                    <a href="layouts-boxed" class="dropdown-item">Boxed Layout</a>
                                    <a href="layouts-colored-sidebar" class="dropdown-item">Colored Sidebar</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                    role="button">
                                    Horizontal <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                    <a href="layouts-horizontal" class="dropdown-item">Horizontal</a>
                                    <a href="layouts-hori-topbar-light" class="dropdown-item">Light Topbar</a>
                                    <a href="layouts-hori-boxed" class="dropdown-item">Boxed Layout</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    
                </ul>
            </div>
        </nav>
    </div>
</div>