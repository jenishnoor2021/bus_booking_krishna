@extends('layouts.admin')
@section('style')
<style>
    /* Add your styling here */
    .accordion {
        display: flex;
        flex-direction: column;
        max-width: 100%;
        /* Adjust as needed */
    }

    .accordion-item {
        border: 1px solid #ddd;
        margin-bottom: 5px;
        overflow: hidden;
    }

    .accordion-header {
        background-color: transparent;
        padding: 10px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .accordion-content {
        display: none;
        padding: 10px;
    }

    .accordion-arrow {
        transition: transform 0.3s ease-in-out;
    }

    .accordion-item.active .accordion-arrow {
        transform: rotate(180deg);
    }

    .drag-handle {
        cursor: move;
    }

    .ui-state-highlight {
        height: 40px;
        background: #f0f0f0;
        border: 2px dashed #ccc;
    }
</style>
@endsection
@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Edit Route</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <!-- <h4 class="card-title mb-4">Edit</h4> -->

                @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-check-all me-2"></i>
                    {{ session()->get('success') }}
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

                <div class="accordion p-1">
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <b>Edit Route Information</b>
                            <span class="accordion-arrow">&#9658;</span>
                        </div>
                        <div class="accordion-content">

                            {!! Form::model($busRoute, [
                            'method' => 'PATCH',
                            'action' => ['AdminBusRouteController@update', $busRoute->id],
                            'files' => true,
                            'class' => 'form-horizontal',
                            'name' => 'editbusRouteform',
                            ]) !!}
                            @csrf

                            <div class="row">
                                <!-- <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="buses_id">Bus Number<span class="text-danger">*</span></label>
                                        <select name="buses_id" id="buses_id" class="form-control" required readonly>
                                            <option value="">-- Select Bus --</option>
                                            @foreach ($buses as $bus)
                                            <option value="{{$bus->id}}" {{ $busRoute->buses_id == $bus->id ? 'selected' : ''}}>{{$bus->bus_no}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('buses_id'))
                                        <div class="error text-danger">{{ $errors->first('buses_id') }}</div>
                                        @endif
                                    </div>
                                </div> -->
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="route_name">Route Name<span class="text-danger">*</span></label>
                                        <input type="text" name="route_name" class="form-control" id="route_name"
                                            placeholder="Enter route name" value="{{ $busRoute->route_name }}" required>
                                        @if ($errors->has('route_name'))
                                        <div class="error text-danger">{{ $errors->first('route_name') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="from_id">From<span class="text-danger">*</span></label>
                                        <select name="from_id" id="from_id" class="form-control" required>
                                            <option value="">-- Select boarding point --</option>
                                            @foreach ($pickupdrops as $pickupdrop)
                                            <option value="{{$pickupdrop->id}}" {{ $busRoute->from_id == $pickupdrop->id ? 'selected' : ''}}>{{$pickupdrop->place_name}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('from_id'))
                                        <div class="error text-danger">{{ $errors->first('from_id') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="departure_time">Departure Time<span class="text-danger">*</span></label>
                                        <input type="time" name="departure_time" class="form-control" value="{{ $busRoute->departure_time }}" id="departure_time" required>
                                        @if($errors->has('departure_time'))
                                        <div class="error text-danger">{{ $errors->first('departure_time') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="to_id">To<span class="text-danger">*</span></label>
                                        <select name="to_id" id="to_id" class="form-control" required>
                                            <option value="">-- Select dropping point --</option>
                                            @foreach ($pickupdrops as $pickupdrop)
                                            <option value="{{$pickupdrop->id}}" {{ $busRoute->to_id == $pickupdrop->id ? 'selected' : ''}}>{{$pickupdrop->place_name}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('to_id'))
                                        <div class="error text-danger">{{ $errors->first('to_id') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="arrival_time">Arrival Time<span class="text-danger">*</span></label>
                                        <input type="time" name="arrival_time" class="form-control" value="{{ $busRoute->arrival_time }}" id="arrival_time" required>
                                        @if($errors->has('arrival_time'))
                                        <div class="error text-danger">{{ $errors->first('arrival_time') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="total_duration">Duration<span class="text-danger">*</span></label>
                                        <input type="text" name="total_duration" class="form-control" value="{{ $busRoute->total_duration }}" id="total_duration" required maxlength="5" placeholder="HH:MM Hrs">
                                        @if($errors->has('total_duration'))
                                        <div class="error text-danger">{{ $errors->first('total_duration') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="total_seat">Total Seats<span class="text-danger">*</span></label>
                                        <input type="number" name="total_seat" class="form-control" id="total_seat" placeholder="Enter GST No" value="{{ $busRoute->total_seat }}" required>
                                        @if($errors->has('total_seat'))
                                        <div class="error text-danger">{{ $errors->first('total_seat') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="price">Price<span class="text-danger">*</span></label>
                                        <input type="number" name="price" class="form-control" id="price" placeholder="Enter price" value="{{ $busRoute->price }}" required>
                                        @if($errors->has('price'))
                                        <div class="error text-danger">{{ $errors->first('price') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="run">Travel<span class="text-danger">*</span></label>
                                        <select name="run" id="run" class="form-control" required>
                                            <option value="daily" {{ $busRoute->run == 'daily' ? 'selected' : ''}}>Daily</option>
                                        </select>
                                        @if($errors->has('run'))
                                        <div class="error text-danger">{{ $errors->first('run') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-1 align-self-center">
                                <div class="d-flex gap-2">
                                    <input type="submit" class="btn btn-primary w-md" id="submitBtn" value="Submit" />
                                    <span id="loadingText" style="display:none; margin-left:10px;"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>
                                    <a class="btn btn-light mt-3 mt-lg-0" href="{{ URL::to('/admin/bus_routes') }}">Back</a>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="container">
                    <p>Manage Journey for <span style="color:red">{{ $busRoute->route_name }}</span></p>
                    <button id="addRow" class="btn btn-primary mb-3">Add Stop</button>

                    <form id="journeyForm">
                        @csrf
                        <input type="hidden" name="bus_route_id" value="{{ $busRoute->id }}">
                        <table class="table" id="journeyTable">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:100px;">Drag & Drop</th>
                                    </th>
                                    <th>Stop</th>
                                    <th>Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($journeyPlaces as $place)
                                <tr data-id="{{ $place->id }}">
                                    <td class="drag-handle text-center" title="move"><i class="fa fa-arrows" style="font-size:25px"></i></td>
                                    <td>
                                        <select name="places[{{ $place->id }}][pickupdrop_id]" class="form-control">
                                            @foreach($pickupdrops as $pickup)
                                            <option value="{{ $pickup->id }}" {{ $pickup->id == $place->pickupdrop_id ? 'selected' : '' }}>{{ $pickup->place_name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="time" name="places[{{ $place->id }}][time]" value="{{ $place->time }}" class="form-control"></td>
                                    <td><button type="button" class="btn btn-danger removeRow">Remove</button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-success">Save Journey</button>
                        <a class="btn btn-light mt-3 mt-lg-0" href="{{ URL::to('/admin/bus_routes') }}">Back</a>
                    </form>
                </div>
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
        $("form[name='editbusRouteform']").validate({
            rules: {
                route_name: {
                    required: true,
                },
                slug: {
                    required: true,
                },
                from_id: {
                    required: true,
                },
                departure_time: {
                    required: true,
                },
                to_id: {
                    required: true,
                },
                arrival_time: {
                    required: true,
                },
                total_duration: {
                    required: true,
                },
                total_seat: {
                    required: true,
                },
                price: {
                    required: true,
                },
                run: {
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

    $('#departure_time, #arrival_time').on('focus click', function() {
        this.showPicker && this.showPicker();
    });

    document.getElementById("total_duration").addEventListener("input", function() {
        let val = this.value.replace(/\D/g, ""); // keep only digits

        if (val.length > 2) {
            this.value = val.slice(0, 2) + ":" + val.slice(2, 4); // HH:MM
        } else {
            this.value = val;
        }
    });
</script>

<script>
    $(document).ready(function() {
        // Toggle accordion content and arrow rotation when clicking on the header
        $('.accordion-header').click(function() {
            $(this).parent('.accordion-item').toggleClass('active');
            $(this).find('.accordion-arrow').text(function(_, text) {
                return text === '►' ? '▼' : '►';
            });
            $(this).next('.accordion-content').slideToggle();
            $(this).parent('.accordion-item').siblings('.accordion-item').removeClass('active').find('.accordion-content').slideUp();
            $(this).parent('.accordion-item').siblings('.accordion-item').find('.accordion-arrow').text('►');
        });
    });
</script>


<script>
    $(document).ready(function() {
        let counter = 0;

        $('#addRow').click(function() {
            counter++;
            let row = `<tr data-id="">
            <td class="drag-handle text-center" title="move"><i class="fa fa-arrows" style="font-size:25px"></i></td>
            <td>
                <select name="places[new${counter}][pickupdrop_id]" class="form-control">
                    @foreach($pickupdrops as $pickup)
                        <option value="{{ $pickup->id }}">{{ $pickup->place_name }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="time" name="places[new${counter}][time]" class="form-control timepicker"></td>
            <td><button type="button" class="btn btn-danger removeRow">Remove</button></td>
        </tr>`;
            $('#journeyTable tbody').append(row);
        });

        $(document).on('click', '.removeRow', function() {
            let tr = $(this).closest('tr');
            let id = tr.data('id');

            if (!confirm('Are you sure you want to delete this row?')) {
                return; // Exit if user clicks "Cancel"
            }

            if (id) {
                $.ajax({
                    url: '/bus-route/journey/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.success) {
                            tr.remove();
                        } else {
                            alert('Failed to delete the row.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while deleting.');
                    }
                });
            } else {
                tr.remove();
            }
        });

        $('#journeyForm').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.post('{{ route("bus_route.journey.save") }}', formData, function(res) {
                if (res.success) {
                    alert(res.message);
                    location.reload();
                }
            });
        });
    });

    $(document).on('focus', 'input[type="time"]', function() {
        this.showPicker?.();
    });
</script>

<!-- jQuery + jQuery UI -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
    $(function() {
        $("#journeyTable tbody").sortable({
            handle: ".drag-handle", // user grabs the handle
            placeholder: "ui-state-highlight",
            update: function(event, ui) {
                let order = [];
                $("#journeyTable tbody tr").each(function(index) {
                    order.push({
                        id: $(this).data("id"),
                        position: index + 1
                    });
                });

                // Send order to backend
                $.ajax({
                    url: '{{ route("bus_route.journey.reorder") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        order: order
                    },
                    success: function(res) {
                        if (res.success) {
                            console.log("Order updated");
                        }
                    }
                });
            }
        }).disableSelection();
    });
</script>
@endsection