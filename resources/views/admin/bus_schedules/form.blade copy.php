@extends('layouts.admin')
@section('content')
<!-- start page title -->
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
      <h4 class="mb-sm-0 font-size-18">ADD bus schedule</h4>
    </div>
  </div>
</div>
<!-- end page title -->

<div class="row">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-4">ADD</h4>

        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="mdi mdi-check-all me-2"></i>
          {{ session()->get('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="mdi mdi-check-all me-2"></i>
          {{ session()->get('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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

        <form method="POST" action="{{ isset($schedule) ? route('admin.bus_schedules.update', $schedule->id) : route('admin.bus_schedules.store') }}" name="addbusscheduleform">
          @csrf
          @if(isset($schedule))
          @method('PUT')
          @endif

          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label for="bus_id">Bus<span class="text-danger">*</span></label>
                <select name="bus_id" id="bus_id" class="form-control" required>
                  <option value="">Select Bus</option>
                  @foreach($buses as $bus)
                  <option value="{{ $bus->id }}" {{ (isset($schedule) && $schedule->bus_id == $bus->id) ? 'selected' : '' }}>
                    {{ $bus->bus_no }} ({{ $bus->bus_type }})
                  </option>
                  @endforeach
                </select>
                @if($errors->has('bus_id'))
                <div class="error text-danger">{{ $errors->first('bus_id') }}</div>
                @endif
              </div>
            </div>
            <div class="col-md-8">
              <div class="mb-3">
                <label for="bus_route_id">Bus Route<span class="text-danger">*</span></label>
                <select name="bus_route_id" id="bus_route_id" class="form-control" required>
                  <option value="">Select Route</option>
                  @foreach($routes as $route)
                  <option value="{{ $route->id }}" {{ (isset($schedule) && $schedule->bus_route_id == $route->id) ? 'selected' : '' }}>
                    {{ $route->route_name }}
                  </option>
                  @endforeach
                </select>
                @if ($errors->has('bus_route_id'))
                <div class="error text-danger">{{ $errors->first('bus_route_id') }}</div>
                @endif
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label>Trip Type<span class="text-danger">*</span></label>
                <select name="trip_type" id="trip_type" class="form-control" required>
                  <option value="single">Single Trip</option>
                  <option value="multiple">Multiple Trip</option>
                </select>
                @if ($errors->has('trip_type'))
                <div class="error text-danger">{{ $errors->first('trip_type') }}</div>
                @endif
              </div>
            </div>

            <div class="col-md-4 single-trip">
              <div class="mb-3">
                <label for="travel_date">Travel Date</label>
                <input type="date" name="travel_date" class="form-control" id="travel_date"
                  value="{{ $schedule->travel_date ?? '' }}">
                @if ($errors->has('travel_date'))
                <div class="error text-danger">{{ $errors->first('travel_date') }}</div>
                @endif
              </div>
            </div>

            <div class="col-md-4 multiple-trip" style="display:none;">
              <div class="mb-3">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" class="form-control" id="start_date">
                @if ($errors->has('start_date'))
                <div class="error text-danger">{{ $errors->first('start_date') }}</div>
                @endif
              </div>
            </div>

            <div class="col-md-4 multiple-trip" style="display:none;">
              <div class="mb-3">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" class="form-control" id="end_date">
                @if ($errors->has('end_date'))
                <div class="error text-danger">{{ $errors->first('end_date') }}</div>
                @endif
              </div>
            </div>

            <div class="col-md-4 multiple-trip" style="display:none;">
              <div class="mb-3">
                <label for="generate_pattern">Generate Schedule</label>
                <select name="generate_pattern" id="generate_pattern" class="form-control">
                  <option value="1">Every Day (1 day 1 trip)</option>
                  <option value="2">Alternate Days (2 day 1 trip)</option>
                  <option value="3">Every 3rd Day</option>
                </select>
                @if ($errors->has('generate_pattern'))
                <div class="error text-danger">{{ $errors->first('generate_pattern') }}</div>
                @endif
              </div>
            </div>

            <div class="col-md-8">
              <div class="mb-3">
                <label for="available_seats">Available Seats<span class="text-danger">*</span></label>
                <input type="number" name="available_seats" class="form-control" id="available_seats" placeholder="Enter available seats" value="{{ $schedule->available_seats ?? '' }}" required>
                @if ($errors->has('available_seats'))
                <div class="error text-danger">{{ $errors->first('available_seats') }}</div>
                @endif
              </div>
            </div>
          </div>

          <!-- <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label for="travel_date">Travel Date<span class="text-danger">*</span></label>
                <input type="date" name="travel_date" class="form-control" id="travel_date" placeholder="Enter travel Date" value="{{ $schedule->travel_date ?? '' }}" required>
                @if($errors->has('travel_date'))
                <div class="error text-danger">{{ $errors->first('travel_date') }}</div>
                @endif
              </div>
            </div>
          </div> -->

          <div class="col-lg-1 align-self-center">
            <div class="d-flex gap-2">
              <input type="submit" class="btn btn-primary w-md" id="submitBtn" value="{{ isset($schedule) ? 'Update' : 'Add' }}" />
              <span id="loadingText" style="display:none; margin-left:10px;"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>
              <a class="btn btn-light mt-3 mt-lg-0" href="{{ URL::to('/admin/bus_schedules') }}">Back</a>
            </div>
          </div>
        </form>

      </div>
      <!-- end card body -->
    </div>
    <!-- end card -->
  </div>
  <!-- end col -->
</div>
<!-- end row -->
@endsection

@section('script')
<script>
  $(function() {

    $("form[name='addbusscheduleform']").validate({
      rules: {
        bus_id: {
          required: true,
        },
        bus_route_id: {
          required: true,
        },
        available_seats: {
          required: true,
        },
      },
      submitHandler: function(form) {
        $("#submitBtn").prop('disabled', true);
        $("#loadingText").show();

        form.submit();
      }
    });
  });

  $('#travel_date, #start_date, #end_date').on('focus click', function() {
    this.showPicker && this.showPicker();
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const tripType = document.getElementById('trip_type');
    const singleTripFields = document.querySelectorAll('.single-trip');
    const multipleTripFields = document.querySelectorAll('.multiple-trip');

    function toggleTripFields() {
      if (tripType.value === 'multiple') {
        singleTripFields.forEach(el => el.style.display = 'none');
        multipleTripFields.forEach(el => el.style.display = 'block');
      } else {
        singleTripFields.forEach(el => el.style.display = 'block');
        multipleTripFields.forEach(el => el.style.display = 'none');
      }
    }

    tripType.addEventListener('change', toggleTripFields);
    toggleTripFields();
  });
</script>
@endsection