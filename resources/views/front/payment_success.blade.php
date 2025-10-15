@extends('layouts.front')

@section('content')

<div class="breadcumb-wrapper" data-bg-src="{{asset('front_assets/img/bg/breadcumb-bg.jpg')}}">
  <div class="container">
    <div class="breadcumb-content">
      <h1 class="breadcumb-title">Payment</h1>
      <ul class="breadcumb-menu">
        <li><a href="{{URL::to('/')}}">Home</a></li>
        <li><a href="{{URL::to('/search')}}">Manage Booking</a></li>
        <li>Status</li>
      </ul>
    </div>
  </div>
</div>

<section class="py-5 text-center">
  <h2 class="text-success">Payment Successful!</h2>
  <p>Your booking ID is <strong>#{{ $booking->id }}</strong></p>
  <p>Amount Paid: ₹{{ number_format($booking->total_amount, 2) }}</p>
  <a href="{{ route('site.search') }}" class="btn btn-primary mt-3">Go Back to Home</a>
</section>
@endsection