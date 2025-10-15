@extends('layouts.front')

@section('page_style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('content')

<div class="th-hero-wrapper hero-1" id="hero">
    <div class="swiper th-slider hero-slider-1" id="heroSlide1"
        data-slider-options='{"effect":"fade","loop":true,"pagination":{"el":".slider-pagination","clickable":true},"navigation":{"nextEl":".slider-next","prevEl":".slider-prev"}}'>
        <!-- <div class="swiper th-slider hero-slider-1" id="heroSlide1" data-slider-options='{"effect":"fade","menu": ["", "", ""],"heroSlide1": {"swiper-container": {"pagination": {"el": ".swiper-pagination", "clickable": true }}}}'> -->
        <div class="swiper-wrapper">
            @foreach ($sliders as $slider)
            <div class="swiper-slide">
                <div class="hero-inner">
                    <div class="th-hero-bg">
                        <img src="{{ $slider->file }}" alt="Slider Image">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="th-swiper-custom">
            <button data-slider-prev="#heroSlide1" class="slider-arrow slider-prev"><img src="{{ asset('front_assets/img/icon/right-arrow.svg') }}" alt=""></button>
            <div class="slider-pagination"></div>
            <button data-slider-next="#heroSlide1" class="slider-arrow slider-next"><img src="{{ asset('front_assets/img/icon/left-arrow.svg') }}" alt=""></button>
        </div>
    </div>
</div>

<div class="booking-sec">
    <div class="container">
        <!-- <form action="mail.php" method="POST" class="booking-form ajax-contact">
            <div class="input-wrap">
                <div class="row align-items-center justify-content-between">
                    <div class="form-group col-md-6 col-lg-auto">
                        <div class="icon"><i class="fa-light fa-route"></i></div>
                        <div class="search-input">
                            <label>Origin</label>
                            <select name="subject" id="subject" class="form-select nice-select">
                                <option value="Select Destination" selected="selected" disabled="disabled">Select Destination</option>
                                @foreach($pickupDrops as $place)
                                <option value="{{ $place->id }}">{{ $place->place_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-lg-auto">
                        <div class="icon"><i class="fa-light fa-route"></i></div>
                        <div class="search-input">
                            <label>Destination</label>
                            <select name="subject" id="subject" class="form-select nice-select">
                                <option value="Select Destination" selected="selected" disabled="disabled">Select Destination</option>
                                @foreach($pickupDrops as $place)
                                <option value="{{ $place->id }}">{{ $place->place_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-lg-auto">
                        <div class="icon"><i class="fa-regular fa-calendar-days"></i></div>
                        <div class="search-input">
                            <label>Date</label>
                            <input type="date" name="Date" id="Date">
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-lg-auto">
                        <div class="icon"><i class="fa-regular fa-calendar-days"></i></div>
                        <div class="search-input">
                            <label>Return</label>
                            <input type="date" name="ReturnDate" id="ReturnDate">
                        </div>
                    </div>
                    <div class="form-btn col-md-12 col-lg-auto">
                        <button class="th-btn"><img src="{{ asset('front_assets/img/icon/search.svg') }}" alt="">Search</button>
                    </div>
                </div>
                <p class="form-messages mb-0 mt-3"></p>
            </div>
        </form> -->
        <form id="searchForm" method="GET" action="{{ route('site.search') }}" class="booking-form">
            @csrf
            <div class="input-wrap">
                <div class="row align-items-center justify-content-between">
                    <div class="form-group col-md-6 col-lg-auto">
                        <div class="icon"><i class="fa-light fa-route"></i></div>
                        <div class="search-input">
                            <label for="from_id">Origin</label>
                            <select name="from_id" id="from_id" class="form-select nice-select" required>
                                <option value="" selected disabled>Select Destination</option>
                                @foreach($pickupDrops as $place)
                                <option value="{{ $place->id }}">{{ $place->place_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-lg-auto">
                        <div class="icon"><i class="fa-light fa-route"></i></div>
                        <div class="search-input">
                            <label for="to_id">Destination</label>
                            <select name="to_id" id="to_id" class="form-select nice-select" required>
                                <option value="" selected disabled>Select Destination</option>
                                @foreach($pickupDrops as $place)
                                <option value="{{ $place->id }}">{{ $place->place_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-lg-auto">
                        <div class="icon"><i class="fa-regular fa-calendar-days"></i></div>
                        <div class="search-input">
                            <label for="travel_date">Date</label>
                            <input type="date" name="travel_date" id="travel_date" required>
                        </div>
                    </div>
                    <div class="form-btn col-md-12 col-lg-auto">
                        <button class="th-btn" type="submit"><img src="{{asset('front_assets/img/icon/search.svg')}}" alt="">Search</button>
                    </div>
                </div>
                <p class="form-messages mb-0 mt-3"></p>
            </div>
        </form>
    </div>
</div>

<section class="category-area bg-top-center" data-bg-src="{{ asset('front_assets/img/bg/category_bg_1.png') }}">
    <div class="container th-container">
        <div class="title-area text-center"><span class="sub-title">Wornderful Place For You</span>
            <h2 class="sec-title">Tour Categories</h2>
        </div>
        <div class="swiper th-slider has-shadow categorySlider" id="categorySlider1" data-bg-src="{{ asset('front_assets/img/bg/category_bg_1.png') }}" data-slider-options='{"spaceBetween": "50","breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"},"1400":{"slidesPerView":"3"}}}'>
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="category-card single">
                        <div class="box-img global-img">
                            <img src="{{ asset('front_assets/img/category/category-3.png') }}" alt="Image">
                        </div>
                        <h3 class="box-title">Bus</h3>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="category-card single">
                        <div class="box-img global-img">
                            <img src="{{ asset('front_assets/img/category/category-2.png') }}" alt="Image">
                        </div>
                        <h3 class="box-title">Tempo Traveller</h3>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="category-card single">
                        <div class="box-img global-img">
                            <img src="{{ asset('front_assets/img/category/category-4.png') }}" alt="Image">
                        </div>
                        <h3 class="box-title">Car</h3>
                    </div>
                </div>
            </div>
            <div class="slider-pagination"></div>
        </div>
    </div>
</section>

<div class="feature-area overflow-hidden space-bottom" id="feature-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="title-area text-center"><span class="sub-title style1">Krishna Travels</span>
                    <h2 class="sec-title">Amenities</h2>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            <div class="col-md-6 col-xl-3">
                <div class="feature-item th-ani">
                    <div class="feature-item_icon"><img src="{{ asset('front_assets/img/icon/mobile-charging.png') }}" alt="icon"></div>
                    <div class="media-body">
                        <h3 class="box-title">Charging Point</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="feature-item th-ani">
                    <div class="feature-item_icon"><img src="{{ asset('front_assets/img/icon/pillow.png') }}" alt="icon"></div>
                    <div class="media-body">
                        <h3 class="box-title">Pillow</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="feature-item th-ani">
                    <div class="feature-item_icon"><img src="{{ asset('front_assets/img/icon/reading.png') }}" alt="icon"></div>
                    <div class="media-body">
                        <h3 class="box-title">Reading Lamp</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="feature-item th-ani">
                    <div class="feature-item_icon"><img src="{{ asset('front_assets/img/icon/water-bottle.png') }}" alt="icon"></div>
                    <div class="media-body">
                        <h3 class="box-title">Water Bottle</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="position-relative overflow-hidden">
    <div class="container">
        <div class="title-area text-center"><span class="sub-title">Top Destination</span>
            <h2 class="sec-title">All Routes</h2>
        </div>
        <div class="swiper th-slider destination-slider slider-drag-wrap" id="aboutSlider1" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"}},"effect":"coverflow","coverflowEffect":{"rotate":"0","stretch":"95","depth":"212","modifier":"1"},"centeredSlides":"true"}'>
            <div class="swiper-wrapper">
                @for ($i = 1; $i <= 10; $i++)
                    <div class="swiper-slide">
                    <div class="destination-box gsap-cursor">
                        <div class="destination-img">
                            <img src="{{ asset('front_assets/img/destination/route.jpg') }}" alt="destination image">
                        </div>
                    </div>
            </div>
            @endfor
        </div>
    </div>
</div>

<div class="about-area position-relative overflow-hidden space" id="about-sec" style="padding-bottom: 0;">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="img-box1">
                    <div><img src="{{ asset('front_assets/img/normal/about.png') }}" alt="About"></div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="ps-xl-4 ms-xl-2">
                    <div class="title-area mb-20 pe-xl-5 me-xl-5"><span class="sub-title style1">Let’s Go Together</span>
                        <h2 class="sec-title mb-20 heading">Krishna Travels</h2>
                        <p class="sec-text mb-30">There are many variations of passages of available but the majority have suffered alteration in some form, by injected hum randomised words which don't look even slightly.</p>
                    </div>
                    <div class="mt-35"><a href="{{URL::to('/about')}}" class="th-btn style3 th-icon">Learn More</a></div>
                </div>
            </div>
        </div>
        <div class="shape-mockup shape1 d-none d-xl-block" data-top="12%" data-left="-16%"><img src="{{ asset('front_assets/img/shape/shape_1.png') }}" alt="shape"></div>
        <div class="shape-mockup shape2 d-none d-xl-block" data-top="20%" data-left="-16%"><img src="{{ asset('front_assets/img/shape/shape_2.png') }}" alt="shape"></div>
        <div class="shape-mockup shape3 d-none d-xl-block" data-top="14%" data-left="-10%"><img src="{{ asset('front_assets/img/shape/shape_3.png') }}" alt="shape"></div>
        <div class="shape-mockup about-shape movingX d-none d-xxl-block" data-bottom="0%" data-right="-11%"><img src="{{ asset('front_assets/img/normal/about-slide-img.png') }}" alt="shape"></div>
        <div class="shape-mockup about-rating d-none d-xxl-block" data-bottom="50%" data-right="-20%"><i class="fa-sharp fa-solid fa-star"></i><span>4.9k</span></div>
        <div class="shape-mockup about-emoji d-none d-xxl-block" data-bottom="25%" data-right="5%"><img src="{{ asset('front_assets/img/icon/emoji.png') }}" alt="shape"></div>
    </div>
</div>

<div class="gallery-area">
    <div class="container th-container">
        <div class="title-area text-center"><span class="sub-title">Make Your Tour More Pleasure</span>
            <h2 class="sec-title">Recent Gallery</h2>
        </div>
        <div class="row gy-10 gx-10 justify-content-center align-items-center">
            @foreach ($galleries as $gallery)
            <div class="col-md-6 col-lg-2">
                <div class="gallery-card">
                    <div class="box-img global-img">
                        <a href="{{$gallery->file}}" class="popup-image">
                            <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div><img src="{{$gallery->file}}" alt="gallery image">
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="shape-mockup d-none d-xl-block" data-top="-25%" data-left="0%"><img src="{{ asset('front_assets/img/shape/line.png') }}" alt="shape"></div>
        <div class="shape-mockup movingX d-none d-xl-block" data-top="30%" data-left="-3%"><img class="gmovingX" src="{{ asset('front_assets/img/shape/shape_4.png') }}" alt="shape"></div>
    </div>
</div>

<div class="counter-area space">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-xl-3 counter-card-wrap">
                <div class="counter-card">
                    <div class="counter-shape"><span></span></div>
                    <div class="media-body">
                        <h3 class="box-number"><span class="counter-number">12</span></h3>
                        <h6 class="counter-title">Years Experience</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 counter-card-wrap">
                <div class="counter-card">
                    <div class="counter-shape"><span></span></div>
                    <div class="media-body">
                        <h3 class="box-number"><span class="counter-number">97</span>%</h3>
                        <h6 class="counter-title">Retention Rate</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 counter-card-wrap">
                <div class="counter-card">
                    <div class="counter-shape"><span></span></div>
                    <div class="media-body">
                        <h3 class="box-number"><span class="counter-number">8</span>k</h3>
                        <h6 class="counter-title">Tour Completed</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 counter-card-wrap">
                <div class="counter-card">
                    <div class="counter-shape"><span></span></div>
                    <div class="media-body">
                        <h3 class="box-number"><span class="counter-number">19</span>k</h3>
                        <h6 class="counter-title">Happy Travellers</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="shape-mockup shape1 d-none d-xl-block" data-top="30%" data-left="-15%"><img src="{{ asset('front_assets/img/shape/shape_1.png') }}" alt="shape"></div>
        <div class="shape-mockup shape2 d-none d-xl-block" data-top="45%" data-left="-13%"><img src="{{ asset('front_assets/img/shape/shape_2.png') }}" alt="shape"></div>
        <div class="shape-mockup shape3 d-none d-xl-block" data-top="32%" data-left="-7%"><img src="{{ asset('front_assets/img/shape/shape_3.png') }}" alt="shape"></div>
        <div class="shape-mockup d-none d-xl-block" data-bottom="-24%" data-left="-15%"><img src="{{ asset('front_assets/img/shape/shape_6.png') }}" alt="shape"></div>
        <div class="shape-mockup jump d-none d-xl-block" data-top="5%" data-right="-10%"><img src="{{ asset('front_assets/img/shape/shape_5.png') }}" alt="shape"></div>
    </div>
</div>

<section class="testi-area overflow-hidden space" id="testi-sec">
    <div class="container-fluid p-0">
        <div class="title-area mb-20 text-center"><span class="sub-title">Testimonial</span>
            <h2 class="sec-title">What Client Say About us</h2>
        </div>
        <div class="slider-area">
            <div class="swiper th-slider testiSlider1 has-shadow" id="testiSlider1" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"767":{"slidesPerView":"2","centeredSlides":"true"},"992":{"slidesPerView":"2","centeredSlides":"true"},"1200":{"slidesPerView":"2","centeredSlides":"true"},"1400":{"slidesPerView":"3","centeredSlides":"true"}}}'>
                <div class="swiper-wrapper">
                    @foreach ($testomonials as $testomonial)
                    <div class="swiper-slide">
                        <div class="testi-card">
                            <div class="testi-card_wrapper">
                                <div class="testi-card_profile">
                                    <div class="testi-card_avater"><img src="{{$testomonial->file}}" alt="testimonial"></div>
                                    <div class="media-body">
                                        <h3 class="box-title">{{$testomonial->name}}</h3><span class="testi-card_desig">{{$testomonial->occupation}}</span>
                                    </div>
                                </div>
                                <div class="testi-card_review"><i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i></div>
                            </div>
                            <p class="testi-card_text">“{{$testomonial->message}}”</p>
                            <div
                                class="testi-card-quote"><img src="{{ asset('front_assets/img/icon/testi-quote.svg') }}" alt="img"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="slider-pagination"></div>
            </div>
        </div>
    </div>
    <div class="shape-mockup d-none d-xl-block" data-bottom="-2%" data-right="0%"><img src="{{ asset('front_assets/img/shape/line2.png') }}" alt="shape"></div>
    <div class="shape-mockup movingX d-none d-xl-block" data-top="30%" data-left="5%"><img src="{{ asset('front_assets/img/shape/shape_7.png') }}" alt="shape"></div>
</section>
@endsection

@section('page_script')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#travel_date", {
        enableTime: false,
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "F j, Y",
        minDate: "today"
    });
</script>
@endsection