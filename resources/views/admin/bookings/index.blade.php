@extends('layouts.admin')
@section('content')
<!-- start page title -->
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
      <h4 class="mb-sm-0 font-size-18">All Bookings</h4>
    </div>
  </div>
</div>
<!-- end page title -->

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">

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

        <div id="right">
          <div id="menu" class="mb-3">

            <span id="menu-navi"
              class="d-sm-flex flex-wrap text-center text-sm-start justify-content-sm-between">
              <div class="d-flex align-items-center gap-2 flex-wrap mb-3">

                {{-- FILTER FORM --}}
                <form method="GET" action="{{ route('admin.bookings.index') }}" class="row g-3 mb-1">
                  <div class="col-md-4">
                    <label for="bus_id" class="form-label">Select Bus</label>
                    <select name="bus_id" id="bus_id" class="form-select">
                      <option value="">All Buses</option>
                      @foreach($buses as $bus)
                      <option value="{{ $bus->id }}" {{ request('bus_id') == $bus->id ? 'selected' : '' }}>
                        {{ $bus->bus_no }}
                      </option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-md-4">
                    <label for="travel_date" class="form-label">Travel Date</label>
                    <input type="date" name="travel_date" id="travel_date" class="form-control"
                      value="{{ request('travel_date') }}">
                  </div>

                  <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Reset</a>
                  </div>
                </form>

                @if(request()->has('travel_date') || request()->has('bus_id'))
                <div class="mb-3">
                  <a href="{{ route('admin.bookings.export', request()->all()) }}" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i> Export Bookings
                  </a>
                </div>
                @endif

              </div>
            </span>

          </div>
        </div>

        <table id="datatable" class="table table-bordered dt-responsive w-100 mt-3">
          <thead>
            <tr>
              <th>#</th>
              <th>Bus</th>
              <th>Route</th>
              <th>Date</th>
              <th>Seats</th>
              <th>Customer</th>
              <th>Booked By</th>
              <th>Status</th>
              <th>Payment Status</th>
              <th>Actions</th>
              <th>Ticket</th>
            </tr>
          </thead>

          <tbody>
            @foreach($bookings as $key => $booking)
            <tr>
              <td>{{ $bookings->firstItem() + $key }}</td>
              <td>{{ $booking->schedule->bus->bus_no ?? '-' }}</td>
              <td>{{ $booking->schedule->route->route_name ?? '-' }}</td>
              <td>{{ $booking->schedule->travel_date ?? '-' }}</td>
              <td>
                @foreach($booking->seat_numbers as $seat)
                <span class="badge bg-info text-white p-1">{{ $seat }}</span>
                @endforeach
              </td>
              <td>
                {{ $booking->customer_name ?? 'N/A' }}<br>
                <small>{{ $booking->customer_phone ?? '' }}</small>
              </td>
              <td>
                <span class="badge p-1 {{ $booking->booked_by == 'admin' ? 'bg-primary' : 'bg-success' }}">
                  {{ ucfirst($booking->booked_by) }}
                </span>
              </td>
              <td>
                <span class="badge
              @if($booking->status == 'confirmed') bg-success
              @elseif($booking->status == 'pending') bg-warning
              @else bg-danger @endif p-1">
                  {{ ucfirst($booking->status) }}
                </span>
              </td>
              <td>
                <span class="badge
              @if($booking->payment_status == 'paid') bg-success
              @elseif($booking->payment_status == 'pending') bg-warning
              @else bg-danger @endif p-1">
                  {{ ucfirst($booking->payment_status) }}
                </span>
              </td>
              <td>
                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-secondary">
                  View
                </a>
                <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-sm btn-warning">
                  <i class="bi bi-pencil"></i> Edit
                </a>
                @if($booking->status == 'confirmed' || $booking->status == 'pending')
                <a href="{{ route('admin.bookings.cancel', $booking->id) }}"
                  class="btn btn-outline-danger btn-sm"
                  onclick="return confirm('Cancel this booking and make seats available again?');">
                  <i class="fa fa-ban"></i> Cancel
                </a>
                @endif
              </td>
              <td>
                <a href="{{ route('admin.bookings.ticket', $booking->id) }}" class="btn btn-sm btn-outline-secondary" title="Download ticket">
                  Download
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

        <div class="mt-3">
          {{ $bookings->links() }}
        </div>

      </div>
    </div>
  </div> <!-- end col -->
</div> <!-- end row -->
@endsection

@section('script')
<script>
  $('#travel_date').on('focus click', function() {
    this.showPicker && this.showPicker();
  });
</script>
@endsection