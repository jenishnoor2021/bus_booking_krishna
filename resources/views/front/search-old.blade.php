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
            <h1><span>Search</span></h1>
        </div>
    </div>
</section>
<!--Contact Info Section-->

<section class="search-section py-5">
    <div class="container">
        <h3 class="mb-4 text-center">Find Your Luxury Bus</h3>

        <form method="GET" action="{{ route('site.search.results') }}" class="mb-4">
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
                    <input type="date" name="travel_date" id="travel_date" class="form-control datetimepicker" placeholder="select travel date" required>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
            </div>
        </form>
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