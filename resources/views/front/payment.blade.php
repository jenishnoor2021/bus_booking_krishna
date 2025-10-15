@extends('layouts.front')

@section('content')
<div class="breadcumb-wrapper" data-bg-src="{{asset('front_assets/img/bg/breadcumb-bg.jpg')}}">
  <div class="container">
    <div class="breadcumb-content">
      <h1 class="breadcumb-title">Payment</h1>
      <ul class="breadcumb-menu">
        <li><a href="{{URL::to('/')}}">Home</a></li>
        <li><a href="{{URL::to('/search')}}">Manage Booking</a></li>
        <li>Payment</li>
      </ul>
    </div>
  </div>
</div>

<section class="payment-section py-5">
  <div class="container text-dark">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow">
          <div class="card-header bg-success text-white">
            <h4 class="mb-0">Booking Summary</h4>
          </div>
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-md-6">
                <h6>Passenger Details</h6>
                <p class="mb-1"><strong>Name:</strong> {{ $booking->customer_name }}</p>
                <p class="mb-1"><strong>Phone:</strong> {{ $booking->customer_phone }}</p>
                @if($booking->customer_email)
                <p class="mb-1"><strong>Email:</strong> {{ $booking->customer_email }}</p>
                @endif
              </div>
              <div class="col-md-6">
                <h6>Journey Details</h6>
                <p class="mb-1"><strong>Bus:</strong> {{ $booking->schedule->bus->bus_no }}</p>
                <p class="mb-1"><strong>Route:</strong> {{ $booking->schedule->route->route_name }}</p>
                <p class="mb-1"><strong>Date:</strong> {{ $booking->schedule->travel_date }}</p>
                <p class="mb-1"><strong>Time:</strong> {{ $booking->schedule->route->departure_time }}</p>
              </div>
            </div>

            <hr>

            <div class="row mb-3">
              <div class="col-md-6">
                <h6>Seat Details</h6>
                <p class="mb-1"><strong>Selected Seats:</strong>
                  {{ is_array($booking->seat_numbers) ? implode(', ', $booking->seat_numbers) : $booking->seat_numbers }}
                </p>
                <p class="mb-1"><strong>Number of Seats:</strong>
                  {{ is_array($booking->seat_numbers) ? count($booking->seat_numbers) : 1 }}
                </p>
              </div>
              <div class="col-md-6 text-end">
                <h5 class="text-success">Total Amount</h5>
                <h3 class="text-success mb-0">₹{{ number_format($booking->total_amount, 2) }}</h3>
              </div>
            </div>

            <hr>

            <div class="alert alert-info">
              <strong>Booking ID:</strong> {{ $booking->id }}<br>
              <strong>Status:</strong> <span class="badge bg-warning">{{ ucfirst($booking->status) }}</span>
            </div>

            <form method="POST" action="{{ route('site.payment.process', $booking->id) }}">
              @csrf
              <div class="mb-3">
                <label class="form-label"><strong>Select Payment Method</strong></label>
                <!-- <div class="form-check">
                  <input class="form-check-input" type="radio" name="payment_method" id="upi" value="upi" checked>
                  <label class="form-check-label" for="upi">UPI Payment</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="payment_method" id="card" value="card">
                  <label class="form-check-label" for="card">Credit/Debit Card</label>
                </div> -->
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="payment_method" id="netbanking" value="netbanking" checked>
                  <label class="form-check-label" for="netbanking">Net Banking</label>
                </div>
              </div>

              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success btn-lg">
                  Proceed to Pay ₹{{ number_format($booking->total_amount, 2) }}
                </button>
                <a href="{{ route('site.search') }}" class="btn btn-outline-secondary">
                  Cancel Booking
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection