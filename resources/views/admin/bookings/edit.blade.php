@extends('layouts.admin')
@section('content')
<!-- start page title -->
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
      <h4 class="mb-sm-0 font-size-18">Edit Bookings</h4>
    </div>
  </div>
</div>
<!-- end page title -->

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">

        <h3>Edit Booking #{{ $booking->id }}</h3>

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

        <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
          @csrf

          <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
              <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
              <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
          </div>

          <div class="mb-3">
            <label>Payment Status</label>
            <select name="payment_status" class="form-control" required>
              <option value="pending" {{ $booking->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="paid" {{ $booking->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
              <option value="failed" {{ $booking->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
          </div>

          <div class="mb-3">
            <label>Razorpay Payment ID</label>
            <input type="text" name="razorpay_payment_id" class="form-control" value="{{ $booking->razorpay_payment_id }}">
          </div>

          <div class="mb-3">
            <label>Razorpay Order ID</label>
            <input type="text" name="razorpay_order_id" class="form-control" value="{{ $booking->razorpay_order_id }}">
          </div>

          <button type="submit" class="btn btn-primary">Update Booking</button>
          <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
        </form>

      </div>
    </div>
  </div> <!-- end col -->
</div> <!-- end row -->
@endsection

@section('script')

@endsection