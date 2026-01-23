@extends('layouts.front')

@section('page_style')
<!-- Flatpickr CSS -->

<style>
  .ticket {
    width: 90%;
    margin: 0 auto 80px;
    display: flex;
    background: #F5F5F5;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
  }

  /* LEFT SIDE */
  .ticket-left {
    width: 70%;
    padding: 25px;
    position: relative;
  }

  .ticket-header {
    background: #d4be3759;
    color: #113d48;
    font-size: 32px;
    font-weight: bold;
    padding: 10px 20px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .ticket-header span {
    width: 40px;
    height: 3px;
    background: #113d48;
    margin-left: 10px;
    display: inline-block;
  }

  .ticket-body {
    display: flex;
    margin-top: 25px;
  }

  .bus-icon {
    font-size: 70px;
    color: #3b82b4;
    margin-right: 20px;
  }

  .ticket-info p {
    margin: 6px 0;
    font-size: 15px;
  }

  .numbers {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    gap: 20px;
  }

  .numbers span {
    font-size: 16px;
    font-weight: bold;
  }

  /* RIGHT SIDE */
  .ticket-right {
    width: 30%;
    background: #F5F5F5;
    border-left: 3px dashed #333;
    padding: 20px;
    text-align: left;
  }

  .passenger-title {
    font-weight: bold;
    font-size: 18px;
    margin-bottom: 15px;
  }

  .barcode {
    font-size: 22px;
    letter-spacing: 3px;
    margin-bottom: 20px;
  }

  .ticket-info.small p {
    font-size: 14px;
    margin: 5px 0;
  }

  @media(max-width: 767px) {
    .numbers {
      grid-template-columns: 1fr 1fr 1fr;
      gap: 15px;
    }

    .ticket-header {
      font-size: 24px;
    }

    .passenger-title,
    .numbers span,
    .numbers>div {
      font-size: 14px;
      line-height: 20px;
    }

    .booking-info-form .video-box1 {
      padding-top: 0;
      padding-bottom: 20px;
    }

    .bus-icon {
      font-size: 40px;
    }
  }

  @media(max-width: 650px) {
    .ticket {
      flex-direction: column;
    }

    .ticket-left,
    .ticket-right {
      width: 100%;
    }

    .ticket-right {
      border-left: none;
      border-top: 3px dashed #333;
    }

    .ticket-header span {
      display: none;
    }
  }

  @media(max-width: 450px) {
    .numbers {
      grid-template-columns: 1fr 1fr;
    }
  }

  .error {
    color: red;
  }
</style>
@endsection

@section('content')
<div class="breadcumb-wrapper" data-bg-src="{{asset('front_assets/img/bg/breadcumb-bg.jpg')}}">
  <div class="container">
    <div class="breadcumb-content">
      <h1 class="breadcumb-title">Booking Information</h1>
      <ul class="breadcumb-menu">
        <li><a href="{{URL::to('/')}}">Home</a></li>
        <li>Booking Information</li>
      </ul>
    </div>
  </div>
</div>

<div class="space-extra2-top space-extra2-bottom booking-info-form" data-bg-src="{{asset('front_assets/img/bg/video_bg_1.jpg')}}">
  <div class="container">
    <div class="row flex-row-reverse justify-content-center align-items-center">
      <div class="col-lg-3">
        <div class="video-box1"><img src="{{asset('front_assets/img/destination/route.jpg')}}" style="border-radius: 0;"></div>
      </div>
      <div class="col-lg-9">
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
          <form action="{{ URL::to('/bookingInfoFind') }}" method="post" name="bookingInfo" class="contact-form style2 ajax-contact" id="bookingInfo">
            @csrf
            <h3 class="sec-title mb-30 text-capitalize">Get Booking Information</h3>
            <div class="row">
              <div class="col-12 form-group">
                <input type="number" class="form-control" name="contact" id="contactNo" placeholder="Mobile Number" required> <img src="{{asset('front_assets/img/icon/user.svg')}}" alt="">
              </div>
              <div class="col-12 form-group">
                <input type="date" class="form-control" name="booking_date" id="bookingDate" placeholder="Date"> <img src="{{asset('front_assets/img/icon/01.svg')}}" alt="">
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

@foreach($bookings as $booking)

<div class="ticket">

  <!-- LEFT MAIN TICKET -->
  <div class="ticket-left">

    <div class="ticket-header">
      Krishna Travels
      <span></span><span></span><span></span><span></span>
    </div>

    <div class="ticket-body">

      <div class="bus-icon">🚌</div>

      <div class="ticket-info">
        <div class="numbers">

          <div class="bus-no">
            Bus No.<br>
            <span>{{ $booking->schedule->bus->bus_no ?? '-' }}</span>
          </div>

          <div class="seat-no">
            Seat No.<br>
            <span>
              @foreach($booking->seat_numbers as $seat)
              {{ $seat }}@if(!$loop->last), @endif
              @endforeach
            </span>
          </div>

          <div class="from-location">
            From:<br>
            <span>{{ $booking->schedule->route->from->place_name ?? '-' }}</span>
          </div>

          <div class="to-location">
            To:<br>
            <span>{{ $booking->schedule->route->to->place_name ?? '-' }}</span>
          </div>

          <div class="arrival-time">
            Bus Type:<br>
            <span>{{ $booking->schedule->bus->bus_type ?? '-' }}</span>
          </div>

          <div class="departure-time">
            Departure Time:<br>
            <span>{{ \Carbon\Carbon::parse($booking->schedule->travel_time)->format('h:i A') }}</span>
          </div>

          <div class="arrival-time">
            Journey Date:<br>
            <span>{{ \Carbon\Carbon::parse($booking->schedule->travel_date)->format('d-m-Y') }}</span>
          </div>

        </div>
      </div>

    </div>
  </div>

  <!-- RIGHT PASSENGER TICKET -->
  <div class="ticket-right">

    <p class="passenger-title">PASSENGER DETAILS:</p>

    <div class="ticket-info small">
      <p><strong>Invoice no:</strong> {{ $booking->id ?? 'N/A' }}</p>
      <p><strong>Name:</strong> {{ $booking->customer_name ?? 'N/A' }}</p>
      <p><strong>Mo.No.:</strong> {{ $booking->customer_phone ?? '-' }}</p>
      <p><strong>Pickup:</strong> {{ $booking->pick_location ?? '-' }}</p>
      <p><strong>Drop:</strong> {{ $booking->drop_location ?? '-' }}</p>
      <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
      <p><strong>Payment:</strong> {{ ucfirst($booking->payment_status) }}</p>
      <p><strong>Download Ticket:</strong> <a href="{{ route('admin.bookings.ticket', $booking->id) }}" class="btn btn-sm btn-default text-primary" title="click me">
          <i class="fa fa-download fa-2x"></i>
        </a>
      </p>
    </div>

  </div>
</div>

@endforeach
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