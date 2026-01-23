<?php

use Carbon\Carbon;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bus Ticket</title>
  <style>
    .ticket {
      width: 400px;
      padding: 20px;
      border: 2px solid #333;
      border-radius: 10px;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .header {
      text-align: center;
      border-bottom: 2px dashed #ccc;
      padding-bottom: 10px;
      margin-bottom: 10px;
    }

    .header h1 {
      margin: 0;
      font-size: 24px;
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 10px;
    }

    table th,
    table td {
      padding: 8px 0;
      text-align: left;
    }

    table th {
      font-weight: bold;
      color: #555;
    }

    .footer {
      text-align: center;
      border-top: 2px dashed #ccc;
      padding-top: 10px;
      margin-top: 10px;
      font-size: 14px;
      color: #777;
    }

    /* Print specific styles */
    @media print {
      body {
        background-color: #fff;
      }

      .ticket {
        border: none;
        box-shadow: none;
        width: auto;
      }
    }
  </style>
</head>

<body>

  <div class="ticket">
    <div class="header">
      <h1>{{$company->name}}</h1>
      <p class="office-address">{{$company->address}}</p>
      <p>Tel: {{$company->contact}}</p>
      <p>Mobile No: +91 {{$company->contact}}</p>
    </div>
    <table>
      <tr>
        <th>Invoice no:</th>
        <td>{{$booking->id}}</td>
      </tr>
      <tr>
        <th>Invoice Date:</th>
        <td>{{ \Carbon\Carbon::parse(Carbon::now())->format('d-m-Y H:i:s') }}</td>
      </tr>
      <tr>
        <th>Passenger Name:</th>
        <td>{{ $booking->customer_name ?? 'N/A' }}</td>
      </tr>
      <tr>
        <th>Mobile No:</th>
        <td>{{ $booking->customer_phone ?? '-' }}</td>
      </tr>
      <tr>
        <th>Bus No:</th>
        <td>{{ $booking->schedule->bus->bus_no ?? '-' }}</td>
      </tr>
      <tr>
        <th>Seat No:</th>
        <td>
          <span>
            @foreach($booking->seat_numbers as $seat)
            {{ $seat }}@if(!$loop->last), @endif
            @endforeach
          </span>
        </td>
      </tr>
      <tr>
        <th>From:</th>
        <td>{{ $booking->schedule->route->from->place_name ?? '-' }}</td>
      </tr>
      <tr>
        <th>To:</th>
        <td>{{ $booking->schedule->route->to->place_name ?? '-' }}</td>
      </tr>
      <tr>
        <th>Pickup:</th>
        <td>{{ $booking->pick_location ?? '-' }}</td>
      </tr>
      <tr>
        <th>Drop:</th>
        <td>{{ $booking->drop_location ?? '-' }}</td>
      </tr>
      <tr>
        <th>Journy Date:</th>
        <td>{{ \Carbon\Carbon::parse($booking->schedule->travel_date)->format('d-m-Y') }}</td>
      </tr>
      <tr>
        <th>Departure Time:</th>
        <td>{{ \Carbon\Carbon::parse($booking->schedule->travel_time)->format('h:i A') }}</td>
      </tr>
      <tr>
        <th>Arrival Time:</th>
        <td>-</td>
      </tr>
    </table>
    <div class="footer">
      <p>Please present this ticket at boarding</p>
    </div>
  </div>
</body>

</html>