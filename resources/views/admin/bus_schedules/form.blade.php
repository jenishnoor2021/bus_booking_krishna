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
          @method('PATCH')
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
            <div class="col-md-4">
              <div class="mb-3">
                <label>Schedule Type <span class="text-danger">*</span></label>
                <select name="schedule_type" id="schedule_type" class="form-control" {{ isset($schedule) ? 'disabled' : '' }}>
                  <option value="single">Single Day</option>
                  <option value="range">Multiple Days</option>
                </select>
              </div>
            </div>
            @if(isset($schedule))
            <input type="hidden" name="schedule_type" value="single">
            @endif
            <div class="col-md-4">
              <div class="mb-3">
                <label for="available_seats">Available Seats<span class="text-danger">*</span></label>
                <input type="number" name="available_seats" class="form-control" id="available_seats" placeholder="Enter available seats" value="{{ $schedule->available_seats ?? '' }}" required>
                @if ($errors->has('available_seats'))
                <div class="error text-danger">{{ $errors->first('available_seats') }}</div>
                @endif
              </div>
            </div>
          </div>

          <div class="row">
            <!-- SINGLE DAY -->
            <div id="singleDateSection" class="col-md-4">
              <div class="mb-3">
                <label>Travel Date</label>
                <input type="date" name="travel_date" id="travel_date" class="form-control" value="{{ old('travel_date', $schedule->travel_date ?? '') }}">
              </div>
            </div>

            <!-- MULTIPLE DAY -->
            <div id="rangeDateSection" class="row" style="display:none;">
              <div class="col-md-4">
                <div class="mb-3">
                  <label>Start Date</label>
                  <input type="date" name="start_date" id="range_start_date" class="form-control" value="{{ old('start_date') }}">
                </div>
              </div>

              <div class="col-md-4">
                <div class="mb-3">
                  <label>End Date</label>
                  <input type="date" name="end_date" id="range_end_date" class="form-control" value="{{ old('end_date') }}">
                </div>
              </div>

              <div class="col-md-4">
                <div class="mb-3">
                  <label>Repeat Interval</label>
                  <select name="interval_days" class="form-control">
                    <option value="1">Every Day</option>
                    <option value="2">Alternate Days</option>
                    <option value="3">Every 3rd Day</option>
                  </select>
                </div>
              </div>
            </div>
          </div>


          <hr>
          <h5 class="mb-3">Trips Per Day</h5>

          <div id="tripRows">

            @if(isset($schedule))
            {{-- EDIT MODE --}}
            <div class="row trip-row mb-2">
              <div class="col-md-5">
                <label>Route</label>
                <select name="bus_route_id" class="form-control" required>
                  @foreach($routes as $route)
                  <option value="{{ $route->id }}"
                    {{ $schedule->bus_route_id == $route->id ? 'selected' : '' }}>
                    {{ $route->route_name }}
                  </option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-5">
                <label>Time</label>
                <input type="time" name="travel_time" class="form-control time-picker"
                  value="{{ $schedule->travel_time }}" required>
              </div>
            </div>

            @else
            {{-- ADD MODE (multiple trips) --}}
            <div class="row trip-row mb-2">
              <div class="col-md-5">
                <label>Route</label>
                <select name="trips[0][route_id]" class="form-control" required>
                  @foreach($routes as $route)
                  <option value="{{ $route->id }}">{{ $route->route_name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-5">
                <label>Time</label>
                <input type="time" name="trips[0][time]" class="form-control time-picker" required>
              </div>

              <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger removeRow">✕</button>
              </div>
            </div>
            @endif

          </div>

          @if(!isset($schedule))
          <button type="button" id="addRow" class="btn btn-outline-primary btn-sm mt-2 mb-3">
            + Add Another Trip
          </button>
          @endif

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

  $('#travel_date, #range_start_date, #range_end_date').on('focus click', function() {
    this.showPicker && this.showPicker();
  });

  $('.time-picker').on('focus click', function() {
    this.showPicker && this.showPicker();
  });
</script>

<script>
  $(document).ready(function() {

    function toggleScheduleType() {
      let type = $('#schedule_type').val();

      if (type === 'range') {
        $('#singleDateSection').hide();
        $('#rangeDateSection').slideDown();
      } else {
        $('#rangeDateSection').hide();
        $('#singleDateSection').slideDown();
      }
    }

    toggleScheduleType();
    $('#schedule_type').on('change', toggleScheduleType);

    // Dynamic trip rows
    let rowIndex = 1;

    $('#addRow').click(function() {
      let row = `
        <div class="row trip-row mb-2">
            <div class="col-md-5">
                <select name="trips[${rowIndex}][route_id]" class="form-control" required>
                    @foreach($routes as $route)
                        <option value="{{ $route->id }}">{{ $route->route_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-5">
                <input type="time" name="trips[${rowIndex}][time]" class="form-control time-picker" required>
            </div>

            <div class="col-md-2">
                <button type="button" class="btn btn-danger removeRow">✕</button>
            </div>
        </div>
        `;
      $('#tripRows').append(row);
      rowIndex++;
    });

    $(document).on('click', '.removeRow', function() {
      $(this).closest('.trip-row').remove();
    });

  });
</script>

@endsection