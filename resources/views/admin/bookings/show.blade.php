@extends('layouts.admin')
@section('content')
<!-- start page title -->
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
      <h4 class="mb-sm-0 font-size-18">All Bookings</h4>
    </div>
  </div>
</div>
<!-- end page title -->

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">

        <h3>Booking #{{ $booking->id }}</h3>
        <hr>

        <p><strong>Bus:</strong> {{ $booking->schedule->bus->bus_no }}</p>
        <p><strong>Route:</strong> {{ $booking->schedule->route->route_name }}</p>
        <p><strong>Date:</strong> {{ $booking->schedule->travel_date }}</p>
        <p><strong>Seats:</strong>
          @foreach($booking->seat_numbers as $seat)
          <span class="badge bg-info text-white p-1">{{ $seat }}</span>
          @endforeach
        </p>
        <p><strong>Customer Name:</strong> {{ $booking->customer_name }}</p>
        <p><strong>Phone:</strong> {{ $booking->customer_phone }}</p>
        <p><strong>Booked By:</strong> {{ ucfirst($booking->booked_by) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
        <p><strong>razorpay_order_id:</strong> {{ ucfirst($booking->razorpay_order_id) }}</p>
        <p><strong>razorpay_payment_id:</strong> {{ ucfirst($booking->razorpay_payment_id) }}</p>
        <p><strong>payment_status:</strong> {{ ucfirst($booking->payment_status) }}</p>

        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary mt-3">Back to List</a>

      </div>
    </div>
  </div> <!-- end col -->
</div> <!-- end row -->
@endsection

@section('script')

@endsection