@extends('layouts.front')

@section('page_style')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    body {
        color: #fff;
    }

    .results-section,
    .booking-section {
        display: none;
    }

    .bus-deck {
        background: #f8f9fa;
        border: 2px solid #dee2e6;
        border-radius: 15px;
        padding: 20px;
        margin: 20px 0;
        position: relative;
    }

    .bus-deck::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 20px;
        width: 40px;
        height: 40px;
        background: #6c757d;
        border-radius: 50%;
        border: 3px solid #495057;
    }

    .deck-title {
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 15px;
        padding-left: 50px;
        color: #495057;
    }

    .seat-layout {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding-left: 50px;
    }

    .seat-row {
        display: flex;
        gap: 8px;
        justify-content: flex-start;
    }

    .seat {
        width: 45px;
        height: 45px;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        background: white;
        transition: all 0.3s ease;
        position: relative;
    }

    .seat:hover:not(.booked):not(.selected) {
        transform: scale(1.05);
        border-color: #007bff;
    }

    .seat.available {
        background: white;
        border-color: #28a745;
        color: #28a745;
    }

    .seat.selected {
        background: #28a745;
        border-color: #28a745;
        color: white;
    }

    .seat.booked {
        background: #e9ecef;
        border-color: #adb5bd;
        color: #6c757d;
        cursor: not-allowed;
    }

    .seat-spacer {
        width: 45px;
        height: 45px;
    }

    .legend {
        display: flex;
        gap: 20px;
        justify-content: center;
        margin: 20px 0;
        flex-wrap: wrap;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .legend-box {
        width: 30px;
        height: 30px;
        border-radius: 5px;
        border: 2px solid;
    }

    .selected-seats-info {
        position: sticky;
        bottom: 0;
        background: white;
        padding: 15px;
        border-top: 2px solid #dee2e6;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    }

    .back-button {
        margin-bottom: 15px;
    }

    .modal-content {
        color: #000 !important;
    }
</style>
@endsection

@section('content')
<section class="inner-banner">
    <div class="image-layer" style="background-image: url({{asset('front_assets/images/resource/aboutbg.jpg')}})"></div>
    <div class="auto-container">
        <div class="inner">
            <h1><span>Book Your Bus</span></h1>
        </div>
    </div>
</section>

<section class="search-section py-5">
    <div class="container">
        <h3 class="mb-4 text-center">Find Your Luxury Bus</h3>

        <form id="searchForm" class="mb-4">
            @csrf
            <div class="row g-3 justify-content-center">
                <div class="col-md-3">
                    <label for="from_id">From</label>
                    <select name="from_id" id="from_id" class="form-control" required>
                        <option value="">Select City</option>
                        @foreach($pickupDrops as $place)
                        <option value="{{ $place->id }}">{{ $place->place_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="to_id">To</label>
                    <select name="to_id" id="to_id" class="form-control" required>
                        <option value="">Select City</option>
                        @foreach($pickupDrops as $place)
                        <option value="{{ $place->id }}">{{ $place->place_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="travel_date">Travel Date</label>
                    <input type="date" name="travel_date" id="travel_date" class="form-control datetimepicker" placeholder="select journy date" required>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
            </div>
        </form>

        <!-- Results Section -->
        <div class="results-section" id="resultsSection">
            <hr class="my-4">
            <h4 class="mb-3">Available Buses</h4>
            <div id="busResults"></div>
        </div>

        <!-- Booking Section -->
        <div class="booking-section" id="bookingSection">
            <hr class="my-4">
            <button type="button" class="btn btn-secondary back-button" onclick="backToResults()">
                ← Back to Results
            </button>

            <h4 class="mb-3" id="busTitle"></h4>
            <p id="busInfo"></p>

            <!-- Legend -->
            <div class="legend">
                <div class="legend-item">
                    <div class="legend-box available" style="background: white; border-color: #28a745;"></div>
                    <span>Available</span>
                </div>
                <div class="legend-item">
                    <div class="legend-box selected" style="background: #28a745; border-color: #28a745;"></div>
                    <span>Selected</span>
                </div>
                <div class="legend-item">
                    <div class="legend-box booked" style="background: #e9ecef; border-color: #adb5bd;"></div>
                    <span>Booked</span>
                </div>
            </div>

            <!-- Bus Layout -->
            <div id="busLayout"></div>

            <!-- Selected Seats Info -->
            <div class="selected-seats-info" id="selectedInfo" style="display: none;">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <strong>Selected Seats:</strong> <span id="selectedSeatsText">None</span><br>
                        <strong>Total Amount:</strong> ₹<span id="totalAmount">0</span>
                    </div>
                    <div class="col-md-4 text-end">
                        <button type="button" class="btn btn-success" onclick="proceedToBooking()">
                            Proceed to Booking
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="bookingForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Passenger Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">X</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="seat_numbers" id="seat_numbers">
                    <input type="hidden" name="total_amount" id="total_amount_hidden">
                    <input type="hidden" name="schedule_id" id="schedule_id">

                    <p>Selected Seats: <strong id="modalSeats"></strong></p>
                    <p>Total Amount: <strong>₹<span id="modalAmount"></span></strong></p>

                    <div class="mb-3">
                        <label>Name *</label>
                        <input type="text" name="customer_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Phone *</label>
                        <input type="text" name="customer_phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email (optional)</label>
                        <input type="email" name="customer_email" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Confirm & Pay</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('page_script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr(".datetimepicker", {
        enableTime: false,
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "F j, Y",
        minDate: "today"
    });

    let selectedSeats = [];
    let currentSchedule = null;
    let seatPrice = 0;
    let bookedSeats = [];

    // Search Form Submit
    document.getElementById('searchForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('{{ route("site.search.results") }}?' + new URLSearchParams(formData))
            .then(response => response.json())
            .then(data => {
                displayResults(data);
            })
            .catch(error => console.error('Error:', error));
    });

    function displayResults(data) {
        const resultsDiv = document.getElementById('busResults');
        const resultsSection = document.getElementById('resultsSection');

        if (data.schedules.length === 0) {
            resultsDiv.innerHTML = '<div class="alert alert-warning">No buses found for selected route/date.</div>';
        } else {
            let html = '';
            data.schedules.forEach(schedule => {
                html += `
                <div class="card mb-3 shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5>${schedule.bus.bus_no} — ${schedule.bus.bus_type}</h5>
                            <p class="mb-1">${schedule.route.route_name}</p>
                            <small>Departs: ${schedule.route.departure_time} | Arrives: ${schedule.route.arrival_time}</small>
                        </div>
                        <div class="text-end">
                            <p class="mb-1">Seats Left: <strong>${schedule.available_seats}</strong></p>
                            <p class="mb-2">Price: <strong>₹${schedule.route.price}</strong></p>
                            <button class="btn btn-success" onclick='selectBus(${JSON.stringify(schedule)})'>
                                Select Seats
                            </button>
                        </div>
                    </div>
                </div>
            `;
            });
            resultsDiv.innerHTML = html;
        }

        resultsSection.style.display = 'block';
        document.getElementById('bookingSection').style.display = 'none';
    }

    function selectBus(schedule) {
        currentSchedule = schedule;
        seatPrice = schedule.route.price;
        selectedSeats = [];

        document.getElementById('busTitle').textContent = `${schedule.bus.bus_no} — ${schedule.bus.bus_type}`;
        document.getElementById('busInfo').textContent = `Route: ${schedule.route.route_name} | Date: ${schedule.travel_date}`;

        // Fetch booked seats
        fetch(`/api/booked-seats/${schedule.id}`)
            .then(response => response.json())
            .then(data => {
                bookedSeats = data.booked_seats || [];
                renderBusLayout(schedule.bus.seat_layout);

                document.getElementById('resultsSection').style.display = 'none';
                document.getElementById('bookingSection').style.display = 'block';
            });
    }

    function renderBusLayout(layoutJson) {
        const layout = JSON.parse(layoutJson);
        const layoutDiv = document.getElementById('busLayout');

        let html = '';

        // Lower Deck
        if (layout.lower && layout.lower.rows) {
            html += '<div class="bus-deck">';
            html += '<div class="deck-title">Lower Deck</div>';
            html += '<div class="seat-layout">';

            layout.lower.rows.forEach(row => {
                html += '<div class="seat-row">';
                row.forEach(seat => {
                    if (seat) {
                        const isBooked = bookedSeats.includes(seat);
                        const statusClass = isBooked ? 'booked' : 'available';
                        html += `<div class="seat ${statusClass}" data-seat="${seat}" onclick="toggleSeat('${seat}')">${seat}</div>`;
                    } else {
                        html += '<div class="seat-spacer"></div>';
                    }
                });
                html += '</div>';
            });

            html += '</div></div>';
        }

        // Upper Deck
        if (layout.upper && layout.upper.rows) {
            html += '<div class="bus-deck">';
            html += '<div class="deck-title">Upper Deck</div>';
            html += '<div class="seat-layout">';

            layout.upper.rows.forEach(row => {
                html += '<div class="seat-row">';
                row.forEach(seat => {
                    if (seat) {
                        const isBooked = bookedSeats.includes(seat);
                        const statusClass = isBooked ? 'booked' : 'available';
                        html += `<div class="seat ${statusClass}" data-seat="${seat}" onclick="toggleSeat('${seat}')">${seat}</div>`;
                    } else {
                        html += '<div class="seat-spacer"></div>';
                    }
                });
                html += '</div>';
            });

            html += '</div></div>';
        }

        layoutDiv.innerHTML = html;
    }

    function toggleSeat(seatNumber) {
        const seatElement = document.querySelector(`.seat[data-seat="${seatNumber}"]`);

        if (seatElement.classList.contains('booked')) {
            return;
        }

        if (selectedSeats.includes(seatNumber)) {
            selectedSeats = selectedSeats.filter(s => s !== seatNumber);
            seatElement.classList.remove('selected');
            seatElement.classList.add('available');
        } else {
            selectedSeats.push(seatNumber);
            seatElement.classList.remove('available');
            seatElement.classList.add('selected');
        }

        updateSelectedInfo();
    }

    function updateSelectedInfo() {
        const selectedInfo = document.getElementById('selectedInfo');
        const selectedSeatsText = document.getElementById('selectedSeatsText');
        const totalAmount = document.getElementById('totalAmount');

        if (selectedSeats.length > 0) {
            selectedInfo.style.display = 'block';
            selectedSeatsText.textContent = selectedSeats.join(', ');
            totalAmount.textContent = (selectedSeats.length * seatPrice).toFixed(2);
        } else {
            selectedInfo.style.display = 'none';
        }
    }

    function backToResults() {
        document.getElementById('bookingSection').style.display = 'none';
        document.getElementById('resultsSection').style.display = 'block';
        selectedSeats = [];
    }

    function proceedToBooking() {
        if (selectedSeats.length === 0) {
            alert('Please select at least one seat');
            return;
        }

        document.getElementById('modalSeats').textContent = selectedSeats.join(', ');
        document.getElementById('modalAmount').textContent = (selectedSeats.length * seatPrice).toFixed(2);
        document.getElementById('seat_numbers').value = JSON.stringify(selectedSeats);
        document.getElementById('total_amount_hidden').value = selectedSeats.length * seatPrice;
        document.getElementById('schedule_id').value = currentSchedule.id;

        const modal = new bootstrap.Modal(document.getElementById('bookingModal'));
        modal.show();
    }

    // Booking Form Submit
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const scheduleId = formData.get('schedule_id');

        fetch(`/book/confirm/${scheduleId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = `/payment/${data.booking_id}`;
                } else {
                    alert(data.message || 'Booking failed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred');
            });
    });
</script>
@endsection