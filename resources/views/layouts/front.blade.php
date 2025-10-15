<!doctype html>
<html class="no-js" lang="zxx">

<head>
    @include('front_includes.head')

    @yield('page_style')
</head>

<body>
    <div class="cursor-follower"></div>
    <div class="slider-drag-cursor"><i class="fas fa-angle-left me-2"></i> DRAG <i class="fas fa-angle-right ms-2"></i></div>
    <div id="preloader" class="preloader">
        <!-- <div class="preloader-inner"><img src="assets/img/logo3.svg" alt=""></div> -->
        <div id="loader" class="th-preloader">
            <div class="animation-preloader">
                <div class="txt-loading">
                    <span preloader-text="K" class="characters">K </span>
                    <span preloader-text="R" class="characters">R </span>
                    <span preloader-text="I" class="characters">I </span>
                    <span preloader-text="S" class="characters">S </span>
                    <span preloader-text="H" class="characters">H</span>
                    <span preloader-text="N" class="characters">N</span>
                    <span preloader-text="A" class="characters">A</span>
                    <span preloader-text="T" class="characters">T</span>
                    <span preloader-text="R" class="characters">R</span>
                    <span preloader-text="A" class="characters">A</span>
                    <span preloader-text="V" class="characters">V</span>
                    <span preloader-text="E" class="characters">E</span>
                    <span preloader-text="L" class="characters">L</span>
                    <span preloader-text="S" class="characters">S</span>
                </div>
            </div>
        </div>
    </div>

    <div class="sidemenu-wrapper sidemenu-info">
        <div class="sidemenu-content">
            <button class="closeButton sideMenuCls"><i class="far fa-times"></i></button>
            <div class="widget">
                <div class="th-widget-about">
                    <div class="about-logo">
                        <a href="{{URL::to('/')}}"><img src="{{ asset('front_assets/img/logo2.svg') }}" alt="Tourm"></a>
                    </div>
                    <p class="about-text">Rapidiously myocardinate cross-platform intellectual capital model. Appropriately create interactive infrastructures</p>
                    <div class="th-social"><a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a> <a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a> <a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://www.whatsapp.com/"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            <div class="widget">
                <h3 class="widget_title">Recent Posts</h3>
                <div class="recent-post-wrap">
                    <div class="recent-post">
                        <div class="media-img">
                            <a href="blog-details.html"><img src="{{ asset('front_assets/img/blog/recent-post-1-1.jpg') }}" alt="Blog Image"></a>
                        </div>
                        <div class="media-body">
                            <div class="recent-post-meta"><a href="blog.html"><i class="far fa-calendar"></i>24 Jun , 2025</a></div>
                            <h4 class="post-title"><a class="text-inherit" href="blog-details.html">Where Vision Meets Concrete Reality</a></h4>
                        </div>
                    </div>
                    <div class="recent-post">
                        <div class="media-img">
                            <a href="blog-details.html"><img src="{{ asset('front_assets/img/blog/recent-post-1-2.jpg') }}" alt="Blog Image"></a>
                        </div>
                        <div class="media-body">
                            <div class="recent-post-meta"><a href="blog.html"><i class="far fa-calendar"></i>22 Jun , 2025</a></div>
                            <h4 class="post-title"><a class="text-inherit" href="blog-details.html">Raising the Bar in Construction.</a></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget">
                <h3 class="widget_title">Get In Touch</h3>
                <div class="th-widget-contact">
                    <div class="info-box_text">
                        <div class="icon"><img src="{{ asset('front_assets/img/icon/phone.svg') }}" alt="img"></div>
                        <div class="details">
                            <p><a href="tel:+01234567890" class="info-box_link">+01 234 567 890</a></p>
                            <p><a href="tel:+09876543210" class="info-box_link">+09 876 543 210</a></p>
                        </div>
                    </div>
                    <div class="info-box_text">
                        <div class="icon"><img src="{{ asset('front_assets/img/icon/envelope.svg') }}" alt="img"></div>
                        <div class="details">
                            <p><a href="mailto:mailinfo00@tourm.com" class="info-box_link">mailinfo00@tourm.com</a></p>
                            <p><a href="mailto:support24@tourm.com" class="info-box_link">support24@tourm.com</a></p>
                        </div>
                    </div>
                    <div class="info-box_text">
                        <div class="icon"><img src="{{ asset('front_assets/img/icon/location-dot.svg') }}" alt="img"></div>
                        <div class="details">
                            <p>Station Rd, D.L.B. Society, Amreli, Gujarat 365601, India</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="popup-search-box">
        <button class="searchClose"><i class="fal fa-times"></i></button>
        <form action="#">
            <input type="text" placeholder="What are you looking for?">
            <button type="submit"><i class="fal fa-search"></i></button>
        </form>
    </div>
    <div class="th-menu-wrapper onepage-nav">
        <div class="th-menu-area text-center">
            <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
            <div class="mobile-logo">
                <a href="{{URL::to('/')}}"><img src="{{ asset('front_assets/img/logo2.svg') }}" alt="Tourm"></a>
            </div>
            <div class="th-mobile-menu">
                <ul>
                    <li><a class="active" href="{{URL::to('/')}}">Home</a></li>
                    <li><a href="{{URL::to('/search')}}">Manage Booking</a></li>
                    <li><a href="{{URL::to('/about')}}">About Us</a></li>
                    <li><a href="{{URL::to('/gallerys')}}">Gallery</a></li>
                    <li><a href="{{URL::to('/contact')}}">Contact us</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- ======= Header ======= -->
    <header class="th-header header-layout1">
        @include('front_includes.header')
    </header>

    <!-- ============================================================== -->
    <!-- Start Content here -->
    <!-- ============================================================== -->
    @yield('content')
    <!-- end main content-->

    <footer class="footer-wrapper footer-layout1">
        @include('front_includes.footer')
    </footer>



    <div class="scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewbox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;"></path>
        </svg>
    </div>
    <div id="login-form" class="popup-login-register mfp-hide">
        <ul class="nav" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-menu" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="false">Login</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-menu active" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="true">Register</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <h3 class="box-title mb-30">Sign in to your account</h3>
                <div class="th-login-form">
                    <form action="mail.php" method="POST" class="login-form ajax-contact">
                        <div class="row">
                            <div class="form-group col-12">
                                <label>Username or email</label>
                                <input type="text" class="form-control" name="email" id="email" required="required">
                            </div>
                            <div class="form-group col-12">
                                <label>Password</label>
                                <input type="password" class="form-control" name="pasword" id="pasword" required="required">
                            </div>
                            <div class="form-btn mb-20 col-12">
                                <button class="th-btn btn-fw th-radius2">Send Message</button>
                            </div>
                        </div>
                        <div id="forgot_url"><a href="my-account.html">Forgot password?</a></div>
                        <p class="form-messages mb-0 mt-3"></p>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade active show" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <h3 class="th-form-title mb-30">Sign in to your account</h3>
                <form action="mail.php" method="POST" class="login-form ajax-contact">
                    <div class="row">
                        <div class="form-group col-12">
                            <label>Username*</label>
                            <input type="text" class="form-control" name="usename" id="usename" required="required">
                        </div>
                        <div class="form-group col-12">
                            <label>First name*</label>
                            <input type="text" class="form-control" name="firstname" id="firstname" required="required">
                        </div>
                        <div class="form-group col-12">
                            <label>Last name*</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" required="required">
                        </div>
                        <div class="form-group col-12">
                            <label for="new_email">Your email*</label>
                            <input type="text" class="form-control" name="new_email" id="new_email" required="required">
                        </div>
                        <div class="form-group col-12">
                            <label for="new_email_confirm">Confirm email*</label>
                            <input type="text" class="form-control" name="new_email_confirm" id="new_email_confirm" required="required">
                        </div>
                        <div class="statement"><span class="register-notes">A password will be emailed to you.</span></div>
                        <div class="form-btn mt-20 col-12">
                            <button class="th-btn btn-fw th-radius2">Sign up</button>
                        </div>
                    </div>
                    <p class="form-messages mb-0 mt-3"></p>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('front_assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('front_assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('front_assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front_assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('front_assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('front_assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('front_assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('front_assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('front_assets/js/gsap.min.js') }}"></script>
    <script src="{{ asset('front_assets/js/circle-progress.js') }}"></script>
    <script src="{{ asset('front_assets/js/matter.min.js') }}"></script>
    <script src="{{ asset('front_assets/js/matterjs-custom.js') }}"></script>
    <script src="{{ asset('front_assets/js/nice-select.min.js') }}"></script>
    <script src="{{ asset('front_assets/js/main.js') }}"></script>
    @yield('page_script')
</body>

</html>