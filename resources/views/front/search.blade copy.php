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

    .search-row {
        border-bottom: 1px solid #eee;
        padding: 12px 0;
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
        <form id="searchForm" class="booking-form ajax-contact" style="margin-top: 0;">
            @csrf
            <div class="input-wrap">
                <div class="row align-items-center justify-content-between">
                    <div class="form-group col-md-6 col-lg-auto">
                        <div class="icon"><i class="fa-light fa-route"></i></div>
                        <div class="search-input">
                            <label for="from_id">Origin</label>
                            <select name="from_id" id="from_id" class="form-select nice-select">
                                <option value="Select Destination" selected="selected" disabled="disabled">Select Destination</option>
                                @foreach($pickupDrops as $place)
                                <option value="{{ $place->id }}">{{ $place->place_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-lg-auto">
                        <div class="icon"><i class="fa-light fa-route"></i></div>
                        <div class="search-input">
                            <label for="to_id">Destination</label>
                            <select name="to_id" id="to_id" class="form-select nice-select">
                                <option value="Select Destination" selected="selected" disabled="disabled">Select Destination</option>
                                @foreach($pickupDrops as $place)
                                <option value="{{ $place->id }}">{{ $place->place_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-lg-auto">
                        <div class="icon"><i class="fa-regular fa-calendar-days"></i></div>
                        <div class="search-input">
                            <label for="travel_date">Date</label>
                            <input type="date" name="travel_date" id="travel_date">
                        </div>
                    </div>
                    <!-- <div class="form-group col-md-6 col-lg-auto">
                        <div class="icon"><i class="fa-regular fa-calendar-days"></i></div>
                        <div class="search-input">
                            <label>Return</label>
                            <input type="date" name="ReturnDate" id="ReturnDate">
                        </div>
                    </div> -->
                    <div class="form-btn col-md-12 col-lg-auto">
                        <button class="th-btn"><img src="{{asset('front_assets/img/icon/search.svg')}}" alt="">Search</button>
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
                                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" attr="[object Object]" height="1em" width="1em" style="margin-left: 10px;">
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
                        <div id="resultsSection" class="search-row normal-service results-section">
                            <div class="container" id="busResults"></div>
                        </div>

                        <div class="view_seats" style="position: relative; border-bottom: 1px solid rgb(238, 238, 238);">
                            <div class="service-details-container container">
                                <div style="padding: 25px 0px;">
                                    <div href="" title="close" class="service-close-btn">
                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" attr="[object Object]" height="2em" width="2em">
                                            <path
                                                d="M331.3 308.7L278.6 256l52.7-52.7c6.2-6.2 6.2-16.4 0-22.6-6.2-6.2-16.4-6.2-22.6 0L256 233.4l-52.7-52.7c-6.2-6.2-15.6-7.1-22.6 0-7.1 7.1-6 16.6 0 22.6l52.7 52.7-52.7 52.7c-6.7 6.7-6.4 16.3 0 22.6 6.4 6.4 16.4 6.2 22.6 0l52.7-52.7 52.7 52.7c6.2 6.2 16.4 6.2 22.6 0 6.3-6.2 6.3-16.4 0-22.6z"></path>
                                            <path
                                                d="M256 76c48.1 0 93.3 18.7 127.3 52.7S436 207.9 436 256s-18.7 93.3-52.7 127.3S304.1 436 256 436c-48.1 0-93.3-18.7-127.3-52.7S76 304.1 76 256s18.7-93.3 52.7-127.3S207.9 76 256 76m0-28C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48z"></path>
                                        </svg>
                                    </div>
                                    <div style="text-align: center;">
                                        <div class="normal-coach-layout">
                                            <table style="border-collapse: collapse;">
                                                <tbody>
                                                    <tr>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 0px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 0px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 0px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 0px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 0px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 0px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 0px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 0px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">I</label></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 25px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="e_ticketing_seat"><label style="display: block; font-size: 11px;">J</label></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 25px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">D1</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">D2</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">RAJ</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">DHANI</label></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 0px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 0px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="e_ticketing_seat"><label style="display: block; font-size: 11px;">5</label></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 25px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="e_ticketing_seat"><label style="display: block; font-size: 11px;">6</label></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 25px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="gents_qta_seat e_ticketing_seat"><label style="display: block; font-size: 11px;">A</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="gents_qta_seat e_ticketing_seat"><label style="display: block; font-size: 11px;">B</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">VIP1</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">VIP2</label></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 0px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 0px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">7</label></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 25px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="e_ticketing_seat"><label style="display: block; font-size: 11px;">8</label></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 25px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="gents_qta_seat available_seat"><label style="display: block; font-size: 11px;">C</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="e_ticketing_seat"><label style="display: block; font-size: 11px;">D</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">1</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">2</label></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 0px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 0px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="e_ticketing_seat"><label style="display: block; font-size: 11px;">9</label></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 25px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="e_ticketing_seat"><label style="display: block; font-size: 11px;">10</label></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 25px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">11</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">12</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">3</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">4</label></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 0px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 0px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="e_ticketing_seat"><label style="display: block; font-size: 11px;">18</label></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 25px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="e_ticketing_seat"><label style="display: block; font-size: 11px;">19</label></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 25px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">15</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">16</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">13</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">14</label></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 0px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                        <td rowspan="1" colspan="1" class="gangway" style="text-align: center; height: 0px; width: 25px;">
                                                            <div class=""></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="gents_qta_seat e_ticketing_seat"><label style="display: block; font-size: 11px;">29</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="gents_qta_seat e_ticketing_seat"><label style="display: block; font-size: 11px;">28</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="e_ticketing_seat"><label style="display: block; font-size: 11px;">24</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="gents_qta_seat available_seat"><label style="display: block; font-size: 11px;">23</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">21</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">22</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">26</label></div>
                                                        </td>
                                                        <td rowspan="2" colspan="1" class="" style="height: 54px; line-height: 54px; width: 25px; cursor: pointer;">
                                                            <div class="available_seat"><label style="display: block; font-size: 11px;">27</label></div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="coach-legend-wrap">
                                            <div>
                                                <div class="coach-legend">
                                                    <span class="text-left"><span class="available_seat"></span><span title="Available Seat"> Available</span></span>
                                                    <span class="text-left"><span class="SelectedSeat"></span><span title="Selected Seat">Selected</span></span>
                                                    <span class="text-left"><span class="e_ticketing_seat"></span><span title="Reserved Seat">Booked</span></span>
                                                    <span class="text-left"><span class="booked_by_ladies_seat e_ticketing_seat"></span><span title="Ladies Confirmed Seat">Ladies(L)</span></span>
                                                    <span class="text-left"><span class="legend ladies_qta_seat e_ticketing_seat"></span><span title="Ladies Available Seat">Available(L)</span></span>
                                                </div>
                                                <div>
                                                    <h4 class="side-heading" style="font-weight: bold;">Fare Details</h4>
                                                    <div class="fare_info">
                                                        <div class="net_fare_area">
                                                            <div><span>Seats </span><span>16</span></div>
                                                            <div><span>Ticket Fare</span><span><i class="currency" style="font-style: normal;">₹&nbsp;</i>500.00</span></div>
                                                            <div><span>GST (5%)</span><span><i class="currency" style="font-style: normal;">₹&nbsp;</i>25.00</span></div>
                                                            <div><span>Grand Total</span><span><i class="currency" style="font-style: normal;">₹&nbsp;</i>525.00</span></div>
                                                            <div><span>Payable Amount</span><span><i class="currency" style="font-style: normal;">₹&nbsp;</i>525.00</span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="boarding_droping_point">
                                                <div class="ant-row" style="margin-left: -8px; margin-right: -8px;">
                                                    <div class="ant-col-12" style="padding-left: 8px; padding-right: 8px;">
                                                        <div class="boardingPointcls" style="margin-bottom: 25px;">
                                                            <h4 class="side-heading" style="font-weight: bold;">Boarding Point</h4>
                                                            <div class="ant-row ant-form-item" style="float: none;">
                                                                <div class="ant-form-item-control-wrapper">
                                                                    <div class="ant-form-item-control has-success">
                                                                        <span class="ant-form-item-children">
                                                                            <div class="ant-select ant-select-enabled" style="width: 100%;">
                                                                                <select id="boarding-point" name="boarding-point">
                                                                                    <option value="Amreli">Amreli</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="landmark-info">
                                                                                <div class="landmark-content">
                                                                                    <svg stroke="#d4be37" fill="currentColor" stroke-width="0" viewBox="0 0 12 16" attr="[object Object]" height="1em" width="1em">
                                                                                        <path
                                                                                            fill-rule="evenodd"
                                                                                            d="M6 0C2.69 0 0 2.5 0 5.5 0 10.02 6 16 6 16s6-5.98 6-10.5C12 2.5 9.31 0 6 0zm0 14.55C4.14 12.52 1 8.44 1 5.5 1 3.02 3.25 1 6 1c1.34 0 2.61.48 3.56 1.36.92.86 1.44 1.97 1.44 3.14 0 2.94-3.14 7.02-5 9.05zM8 5.5c0 1.11-.89 2-2 2-1.11 0-2-.89-2-2 0-1.11.89-2 2-2 1.11 0 2 .89 2 2z"></path>
                                                                                    </svg>
                                                                                    <span>Baradiya</span>
                                                                                </div>
                                                                                <div class="landmark-content">
                                                                                    <svg stroke="#d4be37" fill="currentColor" stroke-width="0" viewBox="0 0 10 16" attr="[object Object]" height="1em" width="1em">
                                                                                        <path
                                                                                            fill-rule="evenodd"
                                                                                            d="M9 0H1C.45 0 0 .45 0 1v14c0 .55.45 1 1 1h8c.55 0 1-.45 1-1V1c0-.55-.45-1-1-1zM5 15.3c-.72 0-1.3-.58-1.3-1.3 0-.72.58-1.3 1.3-1.3.72 0 1.3.58 1.3 1.3 0 .72-.58 1.3-1.3 1.3zM9 12H1V2h8v10z"></path>
                                                                                    </svg>
                                                                                    <span>9426077776</span>
                                                                                </div>
                                                                            </div>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ant-col-12" style="padding-left: 8px; padding-right: 8px;">
                                                        <div class="droppingPointcls" style="margin-bottom: 25px;">
                                                            <h4 class="side-heading" style="font-weight: bold;">Dropoff Point</h4>
                                                            <div class="ant-row ant-form-item" style="float: none;">
                                                                <div class="ant-form-item-control-wrapper">
                                                                    <div class="ant-form-item-control">
                                                                        <span class="ant-form-item-children">
                                                                            <div class="ant-select ant-select-enabled" style="width: 100%;">
                                                                                <select id="boarding-point" name="boarding-point">
                                                                                    <option value="Bhavnagar Bus Stand">Bhavnagar Bus Stand - 06:00 AM</option>
                                                                                    <option value="Bhavnagar Railway Station">Bhavnagar Railway Station - 06:30 AM</option>
                                                                                    <option value="Waghwadi Circle">Waghwadi Circle - 07:00 AM</option>
                                                                                    <option value="Ghogha Ferry Terminal">Ghogha Ferry Terminal - 07:30 AM</option>
                                                                                    <option value="Mahavirnagar">Mahavirnagar - 08:00 AM</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="landmark-info">
                                                                                <div class="landmark-content">
                                                                                    <svg stroke="#d4be37" fill="currentColor" stroke-width="0" viewBox="0 0 12 16" attr="[object Object]" height="1em" width="1em">
                                                                                        <path
                                                                                            fill-rule="evenodd"
                                                                                            d="M6 0C2.69 0 0 2.5 0 5.5 0 10.02 6 16 6 16s6-5.98 6-10.5C12 2.5 9.31 0 6 0zm0 14.55C4.14 12.52 1 8.44 1 5.5 1 3.02 3.25 1 6 1c1.34 0 2.61.48 3.56 1.36.92.86 1.44 1.97 1.44 3.14 0 2.94-3.14 7.02-5 9.05zM8 5.5c0 1.11-.89 2-2 2-1.11 0-2-.89-2-2 0-1.11.89-2 2-2 1.11 0 2 .89 2 2z"></path>
                                                                                    </svg>
                                                                                    <span>Bhavnagar Bus Stand</span>
                                                                                </div>
                                                                                <div class="landmark-content">
                                                                                    <svg stroke="#d4be37" fill="currentColor" stroke-width="0" viewBox="0 0 10 16" attr="[object Object]" height="1em" width="1em">
                                                                                        <path
                                                                                            fill-rule="evenodd"
                                                                                            d="M9 0H1C.45 0 0 .45 0 1v14c0 .55.45 1 1 1h8c.55 0 1-.45 1-1V1c0-.55-.45-1-1-1zM5 15.3c-.72 0-1.3-.58-1.3-1.3 0-.72.58-1.3 1.3-1.3.72 0 1.3.58 1.3 1.3 0 .72-.58 1.3-1.3 1.3zM9 12H1V2h8v10z"></path>
                                                                                    </svg>
                                                                                    <span>9426077776</span>
                                                                                </div>
                                                                            </div>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ant-row AmenitiesContainer"></div>
                                            <button type="button" class="ant-btn ant-btn-primary open-booking-btn" style="float: right; margin-top: 25px;"><span>Continue</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" aria-hidden="true" class="ant-tabs-tabpane ant-tabs-tabpane-inactive"></div>
            </div>
        </div>
    </div>
</section>

<!-- Booking Drawer -->
<div class="booking-drawer">
    <div class="drawer-overlay"></div>
    <div class="drawer-content">
        <button class="close-btn">&times;</button>

        <div class="booking-container">
            <!-- Left Form -->
            <div class="form-area">
                <div class="form-section">
                    <h3>Passenger Details</h3>
                    <div class="grid-4">
                        <div><label>S.No</label><input type="text" value="16"></div>
                        <div><label>Title</label>
                            <select>
                                <option>Mr</option>
                                <option>Ms</option>
                                <option>Mrs</option>
                            </select>
                        </div>
                        <div><label>Name</label><input type="text" value="Milan Gajera"></div>
                        <div><label>Age</label><input type="number" value="25"></div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Contact Details</h3>
                    <div class="grid-2">
                        <div><label>Email</label><input type="email" value="gajeramilan22@gmail.com"></div>
                        <div><label>Mobile</label>
                            <div class="input-group">
                                <select style="width: 70px;">
                                    <option>91</option>
                                </select>
                                <input type="text" value="9638468606">
                            </div>
                        </div>
                        <div><label>Alternate Number</label>
                            <div class="input-group">
                                <select style="width: 70px;">
                                    <option>91</option>
                                </select>
                                <input type="text" placeholder="Alternate No">
                            </div>
                        </div>
                        <div><label>Address</label>
                            <textarea rows="2">Sudama Chowk, Mota Varachha, Surat</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <p>Please Enter your residential location address</p>
                    <div class="grid-3">
                        <div><label>Pin Code</label><input type="text" value="394101"></div>
                        <div>
                            <label for="state">State</label>
                            <select id="state" name="state">
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
                        <div><label>City</label><input type="text" value="SURAT"></div>
                    </div>
                </div>

                <div class="form-section">

                    <div class="payment-methods">
                        <!-- Card/Net Banking -->
                        <label class="payment-option">
                            <input type="radio" name="payment" value="Credit Card"> Credit Card
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment" value="Debit Card"> Debit Card
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment" value="Net Banking"> Net Banking
                        </label>

                        <!-- UPI Options -->
                        <label class="payment-option">
                            <input type="radio" name="payment" value="UPI" checked> UPI
                            <div class="upi-methods">
                                <img src="assets/img/gpay.png" alt="GPay">
                                <img src="assets/img/bhim.png" alt="BHIM">
                                <img src="assets/img/phonepe.png" alt="PhonePe">
                                <img src="assets/img/whatsapp1.png" alt="WhatsApp" style="width: 25px;">
                            </div>
                        </label>

                        <div class="terms">
                            By continuing you agree to our <a href="#">TERMS & CONDITIONS</a> and <a href="#">Cancellation Policies</a>
                        </div>

                        <button class="btn-proceed th-btn">Proceed to Payment</button>

                    </div>
                </div>
            </div>

            <!-- Right Info -->
            <div class="side-panel">
                <div class="service-details">
                    <h4>Service Details</h4>
                    <p><strong>From:</strong> Bhesan</p>
                    <p><strong>To:</strong> Ahmedabad</p>
                    <p><strong>Date:</strong> 11/10/2025</p>
                    <p><strong>Service:</strong> Bhilkha - Ahmedabad</p>
                    <p><strong>Seats:</strong> 16</p>
                    <p><strong>Bus Type:</strong> 2+1, Sleeper, Non-AC (38 seats)</p>
                    <p><strong>Boarding:</strong> 08:30 PM - Bhesan</p>
                    <p><strong>Dropoff:</strong> 05:05 AM - Ujala Circle Near Sunrise Hotel</p>
                </div>

                <div class="fare-details">
                    <h4>Fare Details</h4>
                    <p><strong>Ticket Fare:</strong> ₹500.00</p>
                    <p><strong>GST (5%):</strong> ₹25.00</p>
                    <p><strong>Grand Total:</strong> ₹525.00</p>
                    <p><strong>Payable Amount:</strong> ₹525.00</p>
                </div>
            </div>
        </div>
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

        if (!data.schedules || data.schedules.length === 0) {
            resultsDiv.innerHTML = '<div class="alert alert-warning">No buses found for selected route/date.</div>';
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