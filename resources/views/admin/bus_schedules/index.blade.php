@extends('layouts.admin')
@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Bus Schedule List & booking </h4>
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
                                @if(Session::get('user')['role'] == 'Admin')
                                <a class="btn btn-info waves-effect waves-light"
                                    href="{{ route('admin.bus_schedules.create') }}"><i class="fa fa-plus editable" style="font-size:15px;">&nbsp;ADD</i></a>
                                @endif
                                <!-- <a href="{{ route('admin.generateSchedules') }}"
                                    class="btn btn-primary"
                                    onclick="return confirm('Generate next 15 days schedules for all active buses?')">
                                    Generate Next 10 Days Schedules
                                </a> -->

                                <form method="GET" action="{{ route('admin.bus_schedules.index') }}" class="mb-1">
                                    <div class="row align-items-end">

                                        <!-- Bus Filter -->
                                        <div class="col-md-4">
                                            <label for="bus_id" class="form-label">Filter by Bus</label>
                                            <select name="bus_id" id="bus_id" class="form-control">
                                                <option value="">All Buses</option>
                                                @foreach($buses as $bus)
                                                <option value="{{ $bus->id }}" {{ request('bus_id') == $bus->id ? 'selected' : '' }}>
                                                    {{ $bus->bus_no }} ({{ $bus->bus_type }})
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Date Filter -->
                                        <div class="col-md-3">
                                            <label for="travel_date" class="form-label">Filter by Date</label>
                                            <input type="date" name="travel_date" id="travel_date" class="form-control" value="{{ request('travel_date') }}">
                                        </div>

                                        <!-- Buttons -->
                                        <div class="col-md-3 d-flex gap-2 mt-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="{{ route('admin.bus_schedules.index') }}" class="btn btn-light">Reset</a>
                                        </div>

                                    </div>
                                </form>

                            </div>
                        </span>

                        @if(request('bus_id') || request('travel_date'))
                        <div class="alert alert-info mb-3">
                            Showing schedules
                            @if(request('bus_id'))
                            for <strong>{{ $buses->firstWhere('id', request('bus_id'))->bus_no ?? 'selected bus' }}</strong>
                            @endif
                            @if(request('travel_date'))
                            on <strong>{{ request('travel_date') }}</strong>
                            @endif
                        </div>
                        @endif

                    </div>
                </div>

                <table id="datatable" class="table table-bordered dt-responsive w-100 mt-3">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <!-- <th>Id</th> -->
                            <th>Bus</th>
                            <th>Bus Route</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($busSchedules as $busSchedule)
                        <tr>
                            <td>
                                <a href="{{ route('admin.bus_schedules.edit', $busSchedule->id) }}"
                                    class="btn btn-outline-primary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Edit"><i
                                        class="fa fa-edit"></i></a>
                                <a href="{{ route('admin.bus_schedules.destroy', $busSchedule->id) }}"
                                    onclick="return confirm('Sure ! You want to delete ?');"
                                    class="btn btn-outline-danger waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Delete"><i
                                        class="fa fa-trash"></i></a>
                                <a href="{{ route('admin.bus_schedules.book', $busSchedule->id) }}"
                                    class="btn btn-outline-success">
                                    Book Seat
                                </a>
                            </td>
                            <!-- <td>{{ $busSchedule->id }}</td> -->
                            <td>{{ $busSchedule->bus->bus_no }}</td>
                            <td>{{ $busSchedule->route->route_name }}</td>
                            <td>{{ $busSchedule->travel_date }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection

@section('script')
<script>
    $(document).on('change', '.toggle-status-switch', function() {
        const toggleSwitch = $(this);
        const agentId = toggleSwitch.data('id');
        const isChecked = toggleSwitch.is(':checked');

        $.ajax({
            url: "{{ route('admin.bus_routes.active') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: agentId
            },
            success: function(response) {
                if (response.success) {
                    toggleSwitch.next('label').text(response.status);
                    alert('Status updated successfully');
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
                // Revert toggle state in case of an error
                toggleSwitch.prop('checked', !isChecked);
            }
        });
    });

    $('#travel_date').on('focus click', function() {
        this.showPicker && this.showPicker();
    });
</script>
@endsection