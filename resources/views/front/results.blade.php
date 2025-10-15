@extends('layouts.front')

@section('page_style')
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('content')
<!--Map Section-->
<section class="inner-banner">
  <div class="image-layer" style="background-image: url({{asset('front_assets/images/resource/aboutbg.jpg')}})"></div>
  <div class="auto-container">
    <div class="inner">
      <h1><span>Result</span></h1>
    </div>
  </div>
</section>
<!--Contact Info Section-->

<section class="results py-5">
  <div class="container">
    <h4>Available Buses ({{ $search['travel_date'] }})</h4>

    @if($schedules->isEmpty())
    <div class="alert alert-warning mt-3">No buses found for selected route/date.</div>
    @else
    @foreach($schedules as $schedule)
    <div class="card mb-3 shadow-sm">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <h5>{{ $schedule->bus->bus_no }} — {{ $schedule->bus->bus_type }}</h5>
          <p class="mb-1">{{ $schedule->route->route_name }}</p>
          <small>Departs at: {{ $schedule->route->departure_time }} |
            Arrives: {{ $schedule->route->arrival_time }}</small>
        </div>
        <div class="text-end">
          <p class="mb-1">Seats Left: <strong>{{ $schedule->available_seats }}</strong></p>
          <a href="{{ route('site.book', $schedule->id) }}" class="btn btn-success">Book Now</a>
        </div>
      </div>
    </div>
    @endforeach
    @endif
  </div>
</section>

@endsection

@section('page_script')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
  function initializeDateTimePickers() {
    flatpickr(".datetimepicker", {
      enableTime: false,
      dateFormat: "Y-m-d",
      altInput: true,
      altFormat: "F j, Y",
      allowInput: true
    });
  }

  // Initial run for already-rendered input
  initializeDateTimePickers();
</script>
@endsection