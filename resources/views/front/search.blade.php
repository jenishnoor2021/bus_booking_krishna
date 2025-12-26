@extends('layouts.front')

@section('page_style')
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
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

    .search-row {
        border-bottom: 1px solid #eee;
        padding: 12px 0;
    }

    /* Booking Drawer Styles */
    /* .booking-drawer {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 9999;
        display: none;
    }

    .booking-drawer.active {
        display: block;
    }

    .drawer-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
    }

    .drawer-content {
        position: fixed;
        top: 0;
        right: 0;
        width: 90%;
        max-width: 1400px;
        height: 100vh;
        background: white;
        box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
        overflow-y: auto;
        animation: slideIn 0.3s ease;
    } */

    @keyframes slideIn {
        from {
            transform: translateX(100%);
        }

        to {
            transform: translateX(0);
        }
    }

    .close-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        border: none;
        background: #f0f0f0;
        border-radius: 50%;
        font-size: 24px;
        cursor: pointer;
        z-index: 10;
    }

    .close-btn:hover {
        background: #e0e0e0;
    }

    /* .booking-container {
        display: flex;
        gap: 30px;
        padding: 40px;
        min-height: 100vh;
    }

    .form-area {
        flex: 1;
        max-width: 800px;
    }

    .form-section {
        background: white;
        padding: 25px;
        margin-bottom: 25px;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
    }

    .form-section h3 {
        color: #d4be37;
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 20px;
    } */

    .grid-2,
    .grid-3,
    .grid-4 {
        display: grid;
        gap: 15px;
    }

    .grid-2 {
        grid-template-columns: repeat(2, 1fr);
    }

    .grid-3 {
        grid-template-columns: repeat(3, 1fr);
    }

    .grid-4 {
        grid-template-columns: repeat(4, 1fr);
    }

    .form-section label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #333;
        font-size: 14px;
    }

    .form-section input,
    .form-section select,
    .form-section textarea {
        width: 100%;
        /* padding: 10px; */
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    .form-section input:focus,
    .form-section select:focus,
    .form-section textarea:focus {
        outline: none;
        border-color: #d4be37;
    }

    .input-group {
        display: flex;
        gap: 10px;
    }

    .input-group select {
        width: 80px;
        flex-shrink: 0;
    }

    .input-group input {
        flex: 1;
    }

    .payment-methods {
        margin-top: 20px;
    }

    /* .payment-option {
        display: flex;
        align-items: center;
        padding: 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .payment-option:hover {
        border-color: #d4be37;
        background: #fafafa;
    }

    .payment-option input[type="radio"] {
        margin-right: 10px;
        width: 18px;
        height: 18px;
        cursor: pointer;
    } */

    /* .upi-methods {
        display: flex;
        gap: 15px;
        margin-left: 30px;
        margin-top: 10px;
    }

    .upi-methods img {
        height: 30px;
        width: auto;
    }

    .terms {
        margin: 20px 0;
        font-size: 13px;
        color: #666;
    }

    .terms a {
        color: #d4be37;
        text-decoration: none;
    } */

    .btn-proceed {
        width: 100%;
        padding: 15px;
        background: #d4be37;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-proceed:hover {
        background: #c9a600;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(212, 190, 55, 0.3);
    }

    .side-panel {
        width: 350px;
        position: sticky;
        top: 20px;
        height: fit-content;
    }

    .service-details,
    .fare-details {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .service-details h4,
    .fare-details h4 {
        color: #d4be37;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #d4be37;
    }

    .service-details p,
    .fare-details p {
        margin: 10px 0;
        color: #333;
        font-size: 14px;
    }

    .service-details strong,
    .fare-details strong {
        color: #555;
        font-weight: 600;
    }

    @media (max-width: 1024px) {
        .booking-container {
            flex-direction: column;
        }

        .side-panel {
            width: 100%;
            position: relative;
        }

        .drawer-content {
            width: 100%;
        }
    }

    @media (max-width: 768px) {

        .grid-2,
        .grid-3,
        .grid-4 {
            grid-template-columns: 1fr;
        }

        .booking-container {
            padding: 20px;
        }
    }

    .route-name {
        font-weight: 600;
        color: #222;
    }

    .via-link {
        color: #c9a600;
        font-size: 13px;
    }

    .clock_icon {
        margin-right: 4px;
        color: #555;
    }

    .btn-warning {
        background-color: #d4be37;
        border: none;
        color: #000;
        font-weight: 600;
        border-radius: 4px;
    }

    .route-details-desktop {
        font-weight: 600;
        color: #666;
        font-size: 14px;
    }

    .dept-arr {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }

    .ant-row-flex {
        display: flex;
        align-items: center;
    }

    /* .ant-col-2,
    .ant-col-3,
    .ant-col-4,
    .ant-col-5,
    .ant-col-7 {
        padding: 0 10px;
    }

    .ant-col-4 {
        width: 16.66%;
    }

    .ant-col-5 {
        width: 20.83%;
    }

    .ant-col-7 {
        width: 29.16%;
    }

    .ant-col-3 {
        width: 12.5%;
    }

    .ant-col-2 {
        width: 8.33%;
    }

    .ant-col-9 {
        width: 37.5%;
    }

    .ant-col-6 {
        width: 25%;
    } */

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .bus-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        /* two equal columns */
        gap: 20px;
        align-items: start;
    }

    .bus-deck {
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 6px;
    }

    @media (max-width: 768px) {
        .bus-grid {
            grid-template-columns: 1fr;
        }
    }

    .form-control[readonly] {
        background-color: #fff;
    }
</style>
@endsection

@section('content')

<div class="breadcumb-wrapper" data-bg-src="{{asset('front_assets/img/bg/breadcumb-bg.jpg')}}">
    <div class="container">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Manage Booking</h1>
            <ul class="breadcumb-menu">
                <li><a href="{{URL::to('/')}}">Home</a></li>
                <li>Booking</li>
            </ul>
        </div>
    </div>
</div>

<div class="booking-sec">
    <div class="container">
        <form id="searchForm" class="booking-form ajax-contact">
            @csrf
            <div class="input-wrap">
                <div class="row align-items-center justify-content-between">
                    <div class="form-group col-md-6 col-lg-auto">
                        <div class="icon"><i class="fa-light fa-route"></i></div>
                        <div class="search-input">
                            <label for="from_id">Origin</label>
                            <select name="from_id" id="from_id" class="form-select nice-select" required>
                                <option value="" disabled {{ !isset($fromId) ? 'selected' : '' }}>Select Destination</option>
                                @foreach($pickupDrops as $place)
                                <option value="{{ $place->id }}" {{ (isset($fromId) && $fromId == $place->id) ? 'selected' : '' }}>{{ $place->place_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-lg-auto">
                        <div class="icon"><i class="fa-light fa-route"></i></div>
                        <div class="search-input">
                            <label for="to_id">Destination</label>
                            <select name="to_id" id="to_id" class="form-select nice-select" required>
                                <option value="" disabled {{ !isset($toId) ? 'selected' : '' }}>Select Destination</option>
                                @foreach($pickupDrops as $place)
                                <option value="{{ $place->id }}" {{ (isset($toId) && $toId == $place->id) ? 'selected' : '' }}>{{ $place->place_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-lg-auto">
                        <div class="icon"><i class="fa-regular fa-calendar-days"></i></div>
                        <div class="search-input">
                            <label for="travel_date">Date</label>
                            <input type="date" name="travel_date" id="travel_date" value="{{ $date ?? '' }}" placeholder="Y-m-d" required>
                        </div>
                    </div>
                    <div class="form-btn col-md-12 col-lg-auto">
                        <button class="th-btn" type="submit"><img src="{{asset('front_assets/img/icon/search.svg')}}" alt="">Search</button>
                    </div>
                </div>
                <p class="form-messages mb-0 mt-3"></p>
            </div>
        </form>
    </div>
</div>

<section class="search-results-page mt-5">
    <div class="root-list-common">
        <div class="ant-tabs ant-tabs-top root-tab ant-tabs-line">
            <div class="ant-tabs-content ant-tabs-content-animated" style="margin-left: 0%;">
                <div role="tabpanel" aria-hidden="false" class="ant-tabs-tabpane ant-tabs-tabpane-active">
                    <div class="search-result-parent">
                        <!-- Header Row -->
                        <div class="search-row">
                            <div class="container">
                                <div class="ant-row-flex ant-row-flex-middle">
                                    <div class="ant-col-4">
                                        <div class="route-details-desktop">Service</div>
                                    </div>
                                    <div class="ant-col-5">
                                        <div class="route-details-desktop">Bus Type</div>
                                    </div>
                                    <div class="ant-col-7">
                                        <div class="ant-row dept-arr">
                                            <div class="ant-col-9">
                                                <label class="route-details-desktop">
                                                    Departure
                                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" style="margin-left: 10px;">
                                                        <path d="M277.375 85v259.704l119.702-119.702L427 256 256 427 85 256l29.924-29.922 119.701 118.626V85h42.75z"></path>
                                                    </svg>
                                                </label>
                                            </div>
                                            <div class="ant-col-6"><label class="route-details-desktop">Duration</label></div>
                                            <div class="ant-col-9"><label class="route-details-desktop">Arrival</label></div>
                                        </div>
                                    </div>
                                    <div class="ant-col-3 text-center"><label class="route-details-desktop">Available Seat</label></div>
                                    <div class="ant-col-2 text-center"><label class="route-details-desktop">Fare</label></div>
                                    <div class="ant-col-3 btn-block1 text-right"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Results Section -->
                        <div id="resultsSection" class="search-row normal-service results-section">
                            <div class="container" id="busResults"></div>
                        </div>

                        <!-- Booking Section -->
                        <div class="booking-section" id="bookingSection">
                            <div class="container">

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

                                <button type="button" class="btn btn-secondary back-button" onclick="backToResults()">
                                    ← Back to Results
                                </button>

                                <!-- Selected Seats Info -->
                                <div class="selected-seats-info" id="selectedInfo" style="display: none;">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Booking Drawer -->
<div class="booking-drawer" id="bookingDrawer">
    <div class="drawer-overlay" onclick="closeBookingDrawer()"></div>
    <div class="drawer-content">
        <button class="close-btn" onclick="closeBookingDrawer()">&times;</button>

        <form method="POST" id="bookingForm">
            @csrf
            <input type="hidden" name="seat_numbers" id="seat_numbers">
            <input type="hidden" name="total_amount" id="total_amount_hidden">
            <input type="hidden" name="schedule_id" id="schedule_id">

            <div class="booking-container">
                <!-- Left Form -->
                <div class="form-area">
                    <div class="form-section">
                        <h3>Passenger Details</h3>
                        <div class="grid-4">
                            <div>
                                <label>S.No</label>
                                <input type="text" id="seatNo" readonly>
                            </div>
                            <div>
                                <label>Title</label>
                                <select name="title" required>
                                    <option value="Mr">Mr</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Mrs">Mrs</option>
                                </select>
                            </div>
                            <div>
                                <label>Name *</label>
                                <input type="text" name="customer_name" required>
                            </div>
                            <div>
                                <label>Age *</label>
                                <input type="number" name="age" min="1" max="120" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Contact Details</h3>
                        <div class="grid-2">
                            <div>
                                <label>Email *</label>
                                <input type="email" name="customer_email" required>
                            </div>
                            <div>
                                <label>Mobile *</label>
                                <div class="input-group">
                                    <select name="country_code">
                                        <option value="+91">+91</option>
                                    </select>
                                    <input type="text" name="customer_phone" pattern="[0-9]{10}" required>
                                </div>
                            </div>
                            <div>
                                <label>Alternate Number</label>
                                <div class="input-group">
                                    <select name="alt_country_code">
                                        <option value="+91">+91</option>
                                    </select>
                                    <input type="text" name="alternate_phone" pattern="[0-9]{10}" placeholder="Alternate No">
                                </div>
                            </div>
                            <div>
                                <label>Address *</label>
                                <textarea name="address" rows="2" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <p style="margin-bottom: 15px; color: #666;">Please enter your residential location address</p>
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
                                <input type="text" name="pin_code" pattern="[0-9]{6}" required>
                            </div>
                            <div>
                                <label>State *</label>
                                <select name="state" required>
                                    <option value="">Select State</option>
                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                    <option value="Assam">Assam</option>
                                    <option value="Bihar">Bihar</option>
                                    <option value="Chhattisgarh">Chhattisgarh</option>
                                    <option value="Goa">Goa</option>
                                    <option value="Gujarat">Gujarat</option>
                                    <option value="Haryana">Haryana</option>
                                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                                    <option value="Jharkhand">Jharkhand</option>
                                    <option value="Karnataka">Karnataka</option>
                                    <option value="Kerala">Kerala</option>
                                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                                    <option value="Maharashtra">Maharashtra</option>
                                    <option value="Manipur">Manipur</option>
                                    <option value="Meghalaya">Meghalaya</option>
                                    <option value="Mizoram">Mizoram</option>
                                    <option value="Nagaland">Nagaland</option>
                                    <option value="Odisha">Odisha</option>
                                    <option value="Punjab">Punjab</option>
                                    <option value="Rajasthan">Rajasthan</option>
                                    <option value="Sikkim">Sikkim</option>
                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                    <option value="Telangana">Telangana</option>
                                    <option value="Tripura">Tripura</option>
                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                    <option value="Uttarakhand">Uttarakhand</option>
                                    <option value="West Bengal">West Bengal</option>
                                    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                    <option value="Chandigarh">Chandigarh</option>
                                    <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                                    <option value="Delhi">Delhi</option>
                                    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                    <option value="Ladakh">Ladakh</option>
                                    <option value="Lakshadweep">Lakshadweep</option>
                                    <option value="Puducherry">Puducherry</option>
                                </select>
                            </div>
                            <div>
                                <label>City *</label>
                                <input type="text" name="city" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <!-- <h3>Payment Method</h3> -->
                        <div class="payment-methods">
                            <!--<label class="payment-option">
                                <input type="radio" name="payment" value="Credit Card"> Credit Card
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="payment" value="Debit Card"> Debit Card
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="payment" value="Net Banking"> Net Banking
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="payment" value="UPI" checked> UPI
                                <div class="upi-methods">
                                    <img src="{{asset('front_assets/img/gpay.png')}}" alt="GPay">
                                    <img src="{{asset('front_assets/img/bhim.png')}}" alt="BHIM">
                                    <img src="{{asset('front_assets/img/phonepe.png')}}" alt="PhonePe">
                                    <img src="{{asset('front_assets/img/whatsapp.png')}}" alt="WhatsApp" style="width: 30px; height: 30px;">
                                </div>
                            </label>

                            <div class="terms">
                                By continuing you agree to our <a href="#">TERMS & CONDITIONS</a> and <a href="#">Cancellation Policies</a>
                            </div> -->

                            <button type="submit" class="btn-proceed th-btn">Proceed to Payment</button>
                        </div>
                    </div>
                </div>

                <!-- Right Info Panel -->
                <div class="side-panel">
                    <div class="service-details">
                        <h4>Service Details</h4>
                        <p><strong>From:</strong> <span id="drawerFrom">-</span></p>
                        <p><strong>To:</strong> <span id="drawerTo">-</span></p>
                        <p><strong>Date:</strong> <span id="drawerDate">-</span></p>
                        <p><strong>Service:</strong> <span id="drawerService">-</span></p>
                        <p><strong>Seats:</strong> <span id="drawerSeats">-</span></p>
                        <p><strong>Bus Type:</strong> <span id="drawerBusType">-</span></p>
                        <p><strong>Boarding:</strong> <span id="drawerBoarding">-</span></p>
                        <p><strong>Dropoff:</strong> <span id="drawerDropoff">-</span></p>
                    </div>

                    <div class="fare-details">
                        <h4>Fare Details</h4>
                        <p><strong>Ticket Fare:</strong> ₹<span id="drawerTicketFare">0.00</span></p>
                        <p><strong>GST (5%):</strong> ₹<span id="drawerGST">0.00</span></p>
                        <p><strong>Grand Total:</strong> ₹<span id="drawerGrandTotal">0.00</span></p>
                        <p><strong>Payable Amount:</strong> ₹<span id="drawerPayableAmount">0.00</span></p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('page_script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById('searchForm');
        const params = new URLSearchParams(window.location.search);

        // Fill form with query params
        if (params.has('from_id')) form.from_id.value = params.get('from_id');
        if (params.has('to_id')) form.to_id.value = params.get('to_id');
        if (params.has('travel_date')) form.travel_date.value = params.get('travel_date');

        // Auto-submit if all params exist
        if (params.has('from_id') && params.has('to_id') && params.has('travel_date')) {
            autoSubmitSearchForm(form);
        }

        // Normal AJAX submit
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            autoSubmitSearchForm(this);
        });
    });

    function autoSubmitSearchForm(form) {
        const formData = new FormData(form);
        const url = '{{ route("site.search.results") }}?' + new URLSearchParams(formData);

        fetch(url)
            .then(res => res.json())
            .then(data => displayResults(data))
            .catch(err => console.error('Search error:', err));
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#travel_date", {
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

        if (!data.schedules || data.schedules.length === 0) {
            resultsDiv.innerHTML = '<div class="alert alert-warning">No buses found for selected route/date.</div>';
            resultsSection.style.display = 'block';
            return;
        }

        let html = '';

        data.schedules.forEach(schedule => {
            const route = schedule.route || {};
            const bus = schedule.bus || {};
            const departure = route.departure_time || '-';
            const arrival = route.arrival_time || '-';
            const duration = route.total_duration || '-';
            const seats = schedule.available_seats || 0;
            const fare = route.price || 0;

            html += `
            <div class="ant-row-flex ant-row-flex-middle border-bottom py-3">
                <div class="ant-col-4">
                    <div class="route-name">
                        ${route.route_name || 'N/A'}
                    </div>
                    <a href="javascript:void(0)" title="${route.via || ''}" class="via-link">Via</a>
                </div>

                <div class="ant-col-5">
                    <i class="fa-light fa-bus" style="color:#d4be37;"></i>
                    ${bus.bus_type || 'N/A'} (${bus.total_seats || '0'} seats)
                </div>

                <div class="ant-col-7">
                    <div class="ant-row dept-arr">
                        <div class="ant-col-9">
                            <span class="clock_icon">🕒</span> 
                            <span class="clock_text">${departure}</span>
                        </div>
                        <div class="ant-col-6 text-center">
                            <span>${duration}</span>
                        </div>
                        <div class="ant-col-9">
                            <span class="clock_icon">🕒</span> 
                            <span class="clock_text">${arrival}</span>
                        </div>
                    </div>
                </div>

                <div class="ant-col-3 text-center">
                    <div>${seats}</div>
                    <span>Seats available</span>
                </div>

                <div class="ant-col-2 text-center">
                    <label style="font-size: 18px; font-weight: bold;">
                        ₹ ${fare}/-
                    </label>
                </div>

                <div class="ant-col-3 text-right">
                    <button class="btn btn-warning px-3" 
                            onclick='selectBus(${JSON.stringify(schedule)})'>
                        VIEW SEATS
                    </button>
                </div>
            </div>
        `;
        });

        resultsDiv.innerHTML = html;
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
                renderBusLayout(schedule.bus.seat_layout, schedule.bus.type);

                document.getElementById('resultsSection').style.display = 'none';
                document.getElementById('bookingSection').style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
                bookedSeats = [];
                renderBusLayout(schedule.bus.seat_layout, schedule.bus.type);

                document.getElementById('resultsSection').style.display = 'none';
                document.getElementById('bookingSection').style.display = 'block';
            });
    }

    function renderBusLayout(layoutJson, type) {
        const layout = JSON.parse(layoutJson);
        const layoutDiv = document.getElementById('busLayout');

        let html = '';

        html += '<div class="bus-grid">';

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
                        html += `<div class="seat ${statusClass}" data-seat="${seat}" onclick="toggleSeat('${seat}')" style="${type == 'sleeper' ? 'height:100px;' : ''}">${seat}</div>`;
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
                        html += `<div class="seat ${statusClass}" data-seat="${seat}" onclick="toggleSeat('${seat}')" style="${type == 'sleeper' ? 'height:100px;' : ''}">${seat}</div>`;
                    } else {
                        html += '<div class="seat-spacer"></div>';
                    }
                });
                html += '</div>';
            });

            html += '</div></div>';
        }

        html += '</div>';

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

        // Populate hidden fields
        document.getElementById('seat_numbers').value = JSON.stringify(selectedSeats);
        document.getElementById('total_amount_hidden').value = selectedSeats.length * seatPrice;
        document.getElementById('schedule_id').value = currentSchedule.id;

        // Populate seat number
        document.getElementById('seatNo').value = selectedSeats.join(', ');

        const fromSelect = document.getElementById('from_id');
        const toSelect = document.getElementById('to_id');

        const fromText = fromSelect.options[fromSelect.selectedIndex].text;
        const toText = toSelect.options[toSelect.selectedIndex].text;

        const pickSelect = document.getElementById('pick_location');
        const dropSelect = document.getElementById('drop_location');

        const pickLocation = pickSelect.options[pickSelect.selectedIndex].text;
        const dropLocation = dropSelect.options[dropSelect.selectedIndex].text;

        // Populate service details
        document.getElementById('drawerFrom').textContent = currentSchedule.route.from_place || fromText;
        document.getElementById('drawerTo').textContent = currentSchedule.route.to_place || toText;
        document.getElementById('drawerDate').textContent = currentSchedule.travel_date || '-';
        document.getElementById('drawerService').textContent = currentSchedule.route.route_name || '-';
        document.getElementById('drawerSeats').textContent = selectedSeats.join(', ');
        document.getElementById('drawerBusType').textContent = `${currentSchedule.bus.bus_type} (${currentSchedule.bus.total_seats} seats)`;
        // document.getElementById('drawerBoarding').textContent = `${currentSchedule.route.departure_time} - ${fromText}`;
        // document.getElementById('drawerDropoff').textContent = `${currentSchedule.route.arrival_time} - ${toText}`;
        document.getElementById('drawerBoarding').textContent = `${pickLocation}`;
        document.getElementById('drawerDropoff').textContent = `${dropLocation}`;

        // Calculate fare details
        const ticketFare = selectedSeats.length * seatPrice;
        // const gst = (ticketFare * 0.05).toFixed(2);
        const gst = 0;
        const grandTotal = (parseFloat(ticketFare) + parseFloat(gst)).toFixed(2);

        document.getElementById('drawerTicketFare').textContent = ticketFare.toFixed(2);
        document.getElementById('drawerGST').textContent = gst;
        document.getElementById('drawerGrandTotal').textContent = grandTotal;
        document.getElementById('drawerPayableAmount').textContent = grandTotal;

        // Show drawer
        document.getElementById('bookingDrawer').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeBookingDrawer() {
        document.getElementById('bookingDrawer').classList.remove('active');
        document.body.style.overflow = 'auto';
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
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
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
                alert('An error occurred, check console for details');
            });
    });
</script>
<script>
    $(document).ready(function() {

        const fromSelect = $('#from_id');
        const toSelect = $('#to_id');

        // Store original options ONCE
        const originalOptions = fromSelect.find('option').clone();

        function rebuildSelect(source, target) {
            const selectedVal = source.val();
            const targetOldValue = target.val();

            // Restore original options
            target.empty().append(originalOptions.clone());

            // Remove selected value from opposite dropdown
            if (selectedVal) {
                target.find(`option[value="${selectedVal}"]`).remove();
            }

            // Restore previous selection if valid
            if (targetOldValue && target.find(`option[value="${targetOldValue}"]`).length) {
                target.val(targetOldValue);
            } else {
                target.val('');
            }

            // ONLY update (never destroy)
            target.niceSelect('update');
        }

        fromSelect.on('change', function() {
            rebuildSelect(fromSelect, toSelect);
        });

        toSelect.on('change', function() {
            // rebuildSelect(toSelect, fromSelect);
        });
    });
</script>
@endsection