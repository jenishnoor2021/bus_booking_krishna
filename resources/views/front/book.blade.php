@extends('layouts.front')

@section('page_style')
<style>
  .deck-label {
    font-weight: bold;
    margin-top: 20px;
  }

  .bus-layout {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .seat-row {
    display: flex;
    justify-content: center;
    margin-bottom: 5px;
  }

  .seat {
    width: 50px;
    height: 30px;
    background: #000;
    border-radius: 6px;
    margin: 3px;
    text-align: center;
    line-height: 30px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 500;
    color: #fff;
  }

  .seat.selected {
    background: #4caf50;
    color: white;
  }

  .seat.booked {
    background: #ff5252;
    color: white;
    cursor: not-allowed;
  }

  .seat.sleeper {
    height: 40px;
    width: 60px;
  }
</style>
@endsection

@section('content')
<!--Map Section-->
<section class="inner-banner">
  <div class="image-layer" style="background-image: url({{asset('front_assets/images/resource/aboutbg.jpg')}})"></div>
  <div class="auto-container">
    <div class="inner">
      <h1><span>Book</span></h1>
    </div>
  </div>
</section>
<!--Contact Info Section-->

<div class="container py-5">
  <h4 class="mb-3">Select Your Seat - {{ $schedule->bus->bus_no }}</h4>
  <p>Route: <strong>{{ $schedule->route->route_name }}</strong> | Date: <strong>{{ $schedule->travel_date }}</strong></p>

  {{-- Lower Deck --}}
  <div class="deck-label">Lower Deck</div>
  <div class="bus-layout">
    @foreach($layout['lower']['rows'] as $row)
    <div class="seat-row">
      @foreach($row as $seat)
      @if($seat)
      <div class="seat sleeper {{ in_array($seat, $bookedSeats) ? 'booked' : '' }}" data-seat="{{ $seat }}">{{ $seat }}</div>
      @else
      <div style="width:40px;"></div>
      @endif
      @endforeach
    </div>
    @endforeach
  </div>

  {{-- Upper Deck --}}
  <div class="deck-label">Upper Deck</div>
  <div class="bus-layout">
    @foreach($layout['upper']['rows'] as $row)
    <div class="seat-row">
      @foreach($row as $seat)
      @if($seat)
      <div class="seat sleeper {{ in_array($seat, $bookedSeats) ? 'booked' : '' }}" data-seat="{{ $seat }}">{{ $seat }}</div>
      @else
      <div style="width:40px;"></div>
      @endif
      @endforeach
    </div>
    @endforeach
  </div>
</div>

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('site.book.confirm', $schedule->id) }}" id="bookingForm">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Passenger Information</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="seat_numbers" id="seat_numbers">
          <input type="hidden" name="total_amount" id="total_amount">

          <p>Selected Seat: <strong id="modalSeat"></strong></p>

          <div class="mb-3">
            <label>Name</label>
            <input type="text" name="customer_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="customer_phone" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Email (optional)</label>
            <input type="email" name="customer_email" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Proceed to Payment</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection


@section('page_script')
<script>
  const price = <?= $schedule->route->price ?? 500 ?>;
  const seats = document.querySelectorAll('.seat:not(.booked)');
  const modal = new bootstrap.Modal(document.getElementById('bookingModal'));
  let selectedSeat = null;

  seats.forEach(s => {
    s.addEventListener('click', () => {
      selectedSeat = s.dataset.seat;
      document.getElementById('modalSeat').innerText = selectedSeat;
      document.getElementById('seat_numbers').value = JSON.stringify([selectedSeat]);
      document.getElementById('total_amount').value = price;
      modal.show();
    });
  });
</script>
@endsection