@extends('layouts.admin')

@section('content')

<style>
  .bus-layout {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 30px;
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
    transition: all 0.2s ease;
  }

  .seat.selected {
    background: #4caf50;
    color: #fff;
  }

  .seat.booked {
    background: #ff5252;
    color: #fff;
    cursor: not-allowed;
  }

  .seat.sleeper {
    height: 40px;
    width: 60px;
  }

  /* Responsive form container */
  .booking-container {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
  }

  .form-area {
    flex: 1 1 60%;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  }

  .side-panel {
    flex: 1 1 35%;
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    height: fit-content;
  }

  .form-section {
    margin-bottom: 25px;
  }

  .form-section h3 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 15px;
    color: #333;
  }

  .grid-2,
  .grid-3,
  .grid-4 {
    display: grid;
    gap: 15px;
  }

  .grid-2 {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  }

  .grid-3 {
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  }

  .grid-4 {
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  }

  .input-group {
    display: flex;
    align-items: center;
  }

  .input-group select {
    flex: 0 0 80px;
    margin-right: 5px;
  }

  .upi-methods img {
    width: 35px;
    margin-right: 8px;
  }

  .btn-proceed {
    width: 100%;
    background: #4caf50;
    color: white;
    font-weight: 600;
    padding: 12px;
    border: none;
    border-radius: 6px;
    margin-top: 10px;
    transition: background 0.3s;
  }

  .btn-proceed:hover {
    background: #43a047;
  }

  @media (max-width: 768px) {
    .booking-container {
      flex-direction: column;
    }

    .side-panel {
      order: -1;
    }
  }

  .bus-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    /* 2 columns */
    gap: 20px;
    /* space between decks */
    align-items: start;
  }

  @media (max-width: 768px) {
    .bus-grid {
      grid-template-columns: 1fr;
    }
  }
</style>

<div class="container-fluid">
  <h4 class="mb-3">Bus Seat Booking</h4>
  <p>
    Route: <strong>{{ $schedule->route->route_name }}</strong> |
    Date: <strong>{{ $schedule->travel_date }}</strong>
  </p>

  <div class="bus-grid">

    {{-- Seat Layout --}}
    <div class="bus-layout mb-4">
      <h5>Lower Deck</h5>
      @foreach($layout['lower']['rows'] as $row)
      <div class="seat-row">
        @foreach($row as $seat)
        @if($seat)
        <div class="seat sleeper {{ in_array($seat, $bookedSeats) ? 'booked' : '' }}" data-seat="{{ $seat }}" style="{{$schedule->bus->type == 'sleeper' ? 'height:100px;' : ''}}">
          {{ $seat }}
        </div>
        @else
        <div style="width:40px;"></div>
        @endif
        @endforeach
      </div>
      @endforeach
    </div>

    <div class="bus-layout">
      <h5>Upper Deck</h5>
      @foreach($layout['upper']['rows'] as $row)
      <div class="seat-row">
        @foreach($row as $seat)
        @if($seat)
        <div class="seat sleeper {{ in_array($seat, $bookedSeats) ? 'booked' : '' }}" data-seat="{{ $seat }}" style="{{$schedule->bus->type == 'sleeper' ? 'height:100px;' : ''}}">
          {{ $seat }}
        </div>
        @else
        <div style="width:40px;"></div>
        @endif
        @endforeach
      </div>
      @endforeach
    </div>

  </div>

  {{-- Booking Form --}}
  <form method="POST" action="{{ route('admin.bus_schedules.book.store', $schedule->id) }}" id="adminBookingForm">
    @csrf
    <input type="hidden" name="seat_numbers" id="seat_numbers">

    <div class="booking-container">
      <!-- Left Form -->
      <div class="form-area">
        <div class="form-section">
          <h3>Passenger Details</h3>
          <div class="grid-4">
            <div>
              <label>S.No</label>
              <input type="text" id="seatNo" class="form-control" placeholder="select seat" readonly>
            </div>
            <div>
              <label>Title</label>
              <select name="title" class="form-control" required>
                <option value="Mr">Mr</option>
                <option value="Ms">Ms</option>
                <option value="Mrs">Mrs</option>
              </select>
            </div>
            <div>
              <label>Name *</label>
              <input type="text" name="customer_name" class="form-control" placeholder="Enter name" required>
            </div>
            <div>
              <label>Age *</label>
              <input type="number" name="age" min="1" max="120" class="form-control" placeholder="Enter age" required>
            </div>
          </div>
        </div>

        <div class="form-section">
          <h3>Contact Details</h3>
          <div class="grid-2">
            <div>
              <label>Email *</label>
              <input type="email" name="customer_email" class="form-control" placeholder="Enter email" required>
            </div>
            <div>
              <label>Mobile *</label>
              <div class="input-group">
                <select name="country_code" class="form-control">
                  <option value="+91">+91</option>
                </select>
                <input type="text" name="customer_phone" class="form-control" pattern="[0-9]{10}" placeholder="Enter number" required>
              </div>
            </div>
            <div>
              <label>Alternate Number</label>
              <div class="input-group">
                <select name="alt_country_code" class="form-control">
                  <option value="+91">+91</option>
                </select>
                <input type="text" name="alternate_phone" class="form-control" pattern="[0-9]{10}" placeholder="Alternate No">
              </div>
            </div>
            <div>
              <label>Address *</label>
              <textarea name="address" rows="2" class="form-control" placeholder="Enter address" required></textarea>
            </div>
          </div>
        </div>

        <div class="form-section">
          <p style="margin-bottom: 15px; color: #666;">Please enter your residential address</p>
          <div class="grid-3">
            <div>
              <label for="pick_location">Pickup location</label>
              <select name="pick_location" id="pick_location" class="form-select nice-select" required>
                <option value="">Select locations</option>
                @foreach($fromLocations as $location)
                <option value="{{ $location->location_name }}">{{ $location->location_name }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label for="drop_location">Drop Location</label>
              <select name="drop_location" id="drop_location" class="form-select nice-select" required>
                <option value="">Select locations</option>
                @foreach($toLocations as $location)
                <option value="{{ $location->location_name }}">{{ $location->location_name }}</option>
                @endforeach
              </select>
            </div>
            <br />
            <div>
              <label>Pin Code *</label>
              <input type="text" name="pin_code" class="form-control" pattern="[0-9]{6}" placeholder="Enter pincode" required>
            </div>
            <div>
              <label>State *</label>
              <select name="state" class="form-control" required>
                <option value="">Select State</option>
                @foreach([
                'Gujarat','Maharashtra','Rajasthan','Karnataka','Kerala','Tamil Nadu',
                'Telangana','Andhra Pradesh','Madhya Pradesh','Delhi','Punjab','Goa'
                ] as $state)
                <option value="{{ $state }}">{{ $state }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label>City *</label>
              <input type="text" name="city" class="form-control" placeholder="Enter city" required>
            </div>
          </div>
        </div>

        <button type="submit" class="btn-proceed">Confirm Booking</button>
      </div>

      <!-- Right Info Panel -->
      <div class="side-panel">
        <div class="service-details">
          <h4>Service Details</h4>
          <p><strong>Route:</strong> {{ $schedule->route->route_name }}</p>
          <p><strong>Date:</strong> {{ $schedule->travel_date }}</p>
          <p><strong>Bus:</strong> {{ $schedule->bus->bus_no ?? 'N/A' }}</p>
          <p><strong>Type:</strong> {{ $schedule->bus->bus_type ?? 'N/A' }}</p>
        </div>

        <!-- <div class="fare-details mt-3">
          <h4>Fare Details</h4>
          <p><strong>Ticket Fare:</strong> ₹<span id="fareAmount">0.00</span></p>
          <p><strong>GST (5%):</strong> ₹<span id="fareGST">0.00</span></p>
          <p><strong>Grand Total:</strong> ₹<span id="fareTotal">0.00</span></p>
        </div> -->
      </div>
    </div>
  </form>
</div>

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
      document.getElementById('seatNo').value = selectedSeats.join(', ');
    });
  });
</script>
@endsection