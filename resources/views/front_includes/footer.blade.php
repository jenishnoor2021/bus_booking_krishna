<div class="widget-area">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-6 col-xl-4">
                <div class="widget footer-widget">
                    <div class="th-widget-about">
                        <div class="about-logo">
                            <a href="{{URL::to('/')}}">
                                <!-- <img src="assets/img/logo3.svg" alt="Tourm"> -->
                                <span>Krishna Travels</span>
                            </a>
                        </div>
                        <p class="about-text">Krishna Travels is located in Amreli. Krishna Travels is working in Travel agencies, Travel and transportation activities.</p>
                        <div class="th-social"><a href="{{$facebook}}"><i class="fab fa-facebook-f"></i></a> <a href="{{$twitter}}"><i class="fab fa-twitter"></i></a> <a href="{{$linkdin}}"><i class="fab fa-linkedin-in"></i></a> <a href="https://www.whatsapp.com/"><i class="fab fa-whatsapp"></i></a> <a href="{{$instagram}}"><i class="fab fa-instagram"></i></a></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="widget widget_nav_menu footer-widget">
                    <h3 class="widget_title">Quick Links</h3>
                    <div class="menu-all-pages-container">
                        <ul class="menu">
                            <li><a href="{{URL::to('/')}}">Home</a></li>
                            <li><a href="{{URL::to('/search')}}">Manage Bookings</a></li>
                            <li><a href="{{URL::to('/about')}}">About us</a></li>
                            <li><a href="{{URL::to('/gallerys')}}">Gallery</a></li>
                            <li><a href="{{URL::to('/contact')}}">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="widget footer-widget">
                    <h3 class="widget_title">Address</h3>
                    <div class="th-widget-contact">
                        <div class="info-box_text">
                            <div class="icon"><i class="fa-thin fa-phone-volume" style="transform: rotate(-40deg);"></i></div>
                            <div class="details">
                                <p><a href="tel:{{$contact}}" class="info-box_link">{{$contact}}</a></p>
                                <p><a href="tel:+91{{$whatsapp_no}}" class="info-box_link">+91 {{$whatsapp_no}}</a></p>
                            </div>
                        </div>
                        <div class="info-box_text">
                            <div class="icon"><i class="fa-thin fa-envelope"></i></div>
                            <div class="details">
                                <p><a href="mailto:{{$email}}" class="info-box_link">{{$email}}</a></p>
                            </div>
                        </div>
                        <div class="info-box_text">
                            <div class="icon"><i class="fa-thin fa-location-dot"></i></div>
                            <div class="details">
                                <p>{{$address}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="copyright-wrap" data-bg-src="{{ asset('front_assets/img/bg/copyright_bg_1.jpg') }}">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-12 col-12">
                <p class="copyright-text" style="text-align: center;">Copyright <?= date('Y'); ?><a href="{{URL::to('/')}}">Krishna Travels</a>. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</div>