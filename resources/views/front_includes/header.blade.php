<div class="header-top">
    <div class="container th-container">
        <div class="row justify-content-center justify-content-xl-between align-items-center">
            <div class="col-auto d-none d-md-block">
                <div class="header-links">
                    <ul>
                        <li class="d-none d-xl-inline-block"><i class="fa-sharp fa-regular fa-location-dot"></i> <span>Station Rd, D.L.B. Society, Amreli, Gujarat 365601, India</span></li>
                        <li class="d-none d-xl-inline-block"><i class="fa-regular fa-clock"></i> <span>Sun to Friday: 8.00 am - 7.00 pm</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="sticky-wrapper">
    <div class="menu-area">
        <div class="container th-container">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <div class="header-logo">
                        <a href="{{URL::to('/')}}">
                            <!-- <img src="assets/img/logo.svg" alt="Tourm"> -->
                            Krishna Travels
                        </a>
                    </div>
                </div>
                <div class="col-auto">
                    <nav class="main-menu d-none d-xl-inline-block">
                        <ul>
                            <li><a class="{{ Request::is('/') ? 'active' : '' }}" href="{{URL::to('/')}}">Home</a></li>
                            <li><a class="{{ Request::is('search') ? 'active' : '' }}" href="{{URL::to('/search')}}">Manage Booking</a></li>
                            <li><a class="{{ Request::is('about') ? 'active' : '' }}" href="{{URL::to('/about')}}">About Us</a></li>
                            <li><a class="{{ Request::is('gallerys') ? 'active' : '' }}" href="{{URL::to('/gallerys')}}">Gallery</a></li>
                            <li><a class="{{ Request::is('contact') ? 'active' : '' }}" href="{{URL::to('/contact')}}">Contact us</a></li>
                            <li><a class="{{ Request::is('booking-info') ? 'active' : '' }}" href="{{URL::to('/booking-info')}}">Booking Info</a></li>
                        </ul>
                    </nav>
                    <button type="button" class="th-menu-toggle d-block d-xl-none"><i class="far fa-bars"></i></button>
                </div>
            </div>
        </div>
        <div class="logo-bg" data-mask-src="{{ asset('front_assets/img/logo_bg_mask.png') }}"></div>
    </div>
</div>