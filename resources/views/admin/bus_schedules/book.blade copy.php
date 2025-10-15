@extends('layouts.admin')
@section('content')

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

<p>Route: <strong>{{ $schedule->route->route_name }}</strong> | Date: <strong>{{ $schedule->travel_date }}</strong></p>

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

<form method="POST" action="{{ route('admin.bus_schedules.book.store', $schedule->id) }}" id="adminBookingForm">
  @csrf
  <input type="hidden" name="seat_numbers" id="seat_numbers">
  <div class="mt-3">
    <label>Customer Name (optional)</label>
    <input type="text" name="customer_name" class="form-control" placeholder="If booking for someone">
  </div>
  <div class="mt-3">
    <label>Phone (optional)</label>
    <input type="text" name="customer_phone" class="form-control" placeholder="If booking for someone">
  </div>
  <button type="submit" class="btn btn-success mt-3">Confirm Booking</button>
</form>

@endsection

@section('script')

<script>
  const seats = document.querySelectorAll('.seat:not(.booked)');
  const selectedSeats = [];
  seats.forEach(seat => {
    seat.addEventListener('click', () => {
      seat.classList.toggle('selected');
      const seatNo = seat.dataset.seat;
      if (selectedSeats.includes(seatNo))
        selectedSeats.splice(selectedSeats.indexOf(seatNo), 1);
      else
        selectedSeats.push(seatNo);

      document.getElementById('seat_numbers').value = JSON.stringify(selectedSeats);
    });
  });
</script>

@endsection