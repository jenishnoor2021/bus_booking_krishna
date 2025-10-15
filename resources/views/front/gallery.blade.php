@extends('layouts.front')

@section('content')

<div class="breadcumb-wrapper" data-bg-src="{{asset('front_assets/img/bg/breadcumb-bg.jpg')}}">
    <div class="container">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Our Gallery</h1>
            <ul class="breadcumb-menu">
                <li><a href="{{URL::to('/')}}">Home</a></li>
                <li>Our Gallery</li>
            </ul>
        </div>
    </div>
</div>

<div class="overflow-hidden space" id="gallery-sec">
    <div class="container-fuild">
        <div class="title-area mb-30 text-center"><span class="sub-title">Explore Us</span>
            <h2 class="sec-title">A truly exceptional experience</h2>
        </div>
        <div class="row gy-4 gallery-row4">
            <!-- Wedding Catering -->
            @foreach($galleries as $gallery)
            <div class="col-auto">
                <div class="gallery-box style5">
                    <div class="gallery-img global-img"><img src="{{ asset($gallery->file) }}" alt="gallery image"> <a href="{{ asset($gallery->file) }}" class="icon-btn popup-image"><i class="fal fa-magnifying-glass-plus"></i></a></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('page_script')
@endsection