@extends('layouts.front')

@section('page_style')
<!-- Flatpickr CSS -->

<style>
  .error {
    color: red;
  }
</style>
@endsection

@section('content')
<div class="breadcumb-wrapper" data-bg-src="{{asset('front_assets/img/bg/breadcumb-bg.jpg')}}">
  <div class="container">
    <div class="breadcumb-content">
      <h1 class="breadcumb-title">Booking Info</h1>
      <ul class="breadcumb-menu">
        <li><a href="{{URL::to('/')}}">Home</a></li>
        <li>Booking Info</li>
      </ul>
    </div>
  </div>
</div>

<div class="space-extra2-top mb-5" data-bg-src="{{asset('front_assets/img/bg/video_bg_1.jpg')}}">
  <div class="container">
    <div class="row flex-row-reverse justify-content-center align-items-center">
      <div class="col-lg-6">
        <div class="video-box1"><a href="https://www.youtube.com/watch?v=cQfIUPw72Dk" class="play-btn style2 popup-video"><i class="fa-sharp fa-solid fa-play"></i></a></div>
      </div>
      <div class="col-lg-6">
        <div>
          @if (isset($success))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $success }}
          </div>
          @endif

          @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          <form action="{{ URL::to('/bookingInfoFind') }}" method="post" name="bookingInfo" class="php-email-form" id="bookingInfo">
            @csrf
            <input type="text" name="website" style="display:none">
            <h3 class="sec-title mb-30 text-capitalize">Booking Info</h3>
            <div class="row">
              <div class="col-12 form-group">
                <input type="number" class="form-control" name="contact" id="contactNo" placeholder="Enter your Mobile no" required>
              </div>
              <div class="col-12 form-group">
                <input type="date" class="form-control" name="booking_date" id="bookingDate" placeholder="Your booking date" required>
              </div>
              <div id="form-spinner" style="display: none;" class="text-center mt-3">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Sending...</span>
                </div>
              </div>
              <div class="form-btn col-12 mt-24">
                <button type="submit" id="submitBtn" class="th-btn style3">Submit <img src="{{asset('front_assets/img/icon/plane.svg')}}" alt=""></button>
              </div>
            </div>
            <p class="form-messages mb-0 mt-3"></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@if(!empty($bookings) && count($bookings) > 0)
<div class="space-extra2-bottom" data-bg-src="{{asset('front_assets/img/bg/video_bg_1.jpg')}}">
  <div class="container">
    <table id="" class="table table-bordered dt-responsive w-100 mt-3">
      <thead style="background-color:#dedede">
        <tr>
          <th>Bus</th>
          <th>Route</th>
          <th>Journy Date</th>
          <th>Seats</th>
          <th>Customer</th>
          <th>Status</th>
          <th>Payment Status</th>
          <th>Ticket</th>
        </tr>
      </thead>

      <tbody>
        @foreach($bookings as $booking)
        <tr>
          <td>{{ $booking->schedule->bus->bus_no ?? '-' }}</td>
          <td>{{ $booking->schedule->route->route_name ?? '-' }}</td>
          <td>{{ $booking->schedule->travel_date ?? '-' }}</td>
          <td>
            @foreach($booking->seat_numbers as $seat)
            <span>{{ $seat }}</span>
            @endforeach
          </td>
          <td>
            {{ $booking->customer_name ?? 'N/A' }}<br>
            <small>{{ $booking->customer_phone ?? '' }}</small>
          </td>
          <td>
            {{ ucfirst($booking->status) }}
          </td>
          <td>
            {{ ucfirst($booking->payment_status) }}
          </td>
          <td>
            <a href="{{ route('admin.bookings.ticket', $booking->id) }}" class="btn btn-sm btn-success">
              Ticket
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endif
@endsection

@section('page_script')
<!-- form validation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script>
  $(function() {

    $("form[name='bookingInfo']").validate({
      rules: {
        contact: {
          required: true,
        },
        booking_date: {
          required: true,
        },
      },
      submitHandler: function(form) {
        const submitBtn = document.getElementById('submitBtn');
        const spinner = document.getElementById('form-spinner');

        // Disable button & show spinner
        submitBtn.disabled = true;
        spinner.style.display = 'block';

        form.submit();
      }
    });
  });
</script>
@endsection