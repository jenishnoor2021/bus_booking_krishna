@extends('layouts.admin')
@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">ADD Route</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">ADD</h4>

                @if (session()->has('message'))
                <div class="alert text-white" style="background-color:#7EDD72">
                    {{ session()->get('message') }}
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

                {!! Form::open([
                'method' => 'POST',
                'action' => 'AdminBusRouteController@store',
                'files' => true,
                'class' => 'form-horizontal',
                'name' => 'addbusrouteform',
                ]) !!}
                @csrf

                <div class="row">
                    <!-- <div class="col-md-4">
                        <div class="mb-3">
                            <label for="buses_id">Bus Number<span class="text-danger">*</span></label>
                            <select name="buses_id" id="buses_id" class="form-control" required>
                                <option value="">-- Select Bus --</option>
                                @foreach ($buses as $bus)
                                <option value="{{$bus->id}}">{{$bus->bus_no}}</option>
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
                                placeholder="Enter route name" value="{{ old('route_name') }}" required>
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
                                <option value="{{$pickupdrop->id}}">{{$pickupdrop->place_name}}</option>
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
                            <input type="time" name="departure_time" class="form-control" value="{{ old('departure_time') }}" id="departure_time" required>
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
                                <option value="{{$pickupdrop->id}}">{{$pickupdrop->place_name}}</option>
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
                            <input type="time" name="arrival_time" class="form-control" value="{{ old('arrival_time') }}" id="arrival_time" required>
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
                            <input type="text" name="total_duration" class="form-control" value="{{ old('total_duration') }}" id="total_duration" required maxlength="5" placeholder="HH:MM">
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
                            <input type="number" name="total_seat" class="form-control" id="total_seat" placeholder="Enter No" value="{{ old('total_seat') }}" required>
                            @if($errors->has('total_seat'))
                            <div class="error text-danger">{{ $errors->first('total_seat') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="price">Price<span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control" id="price" placeholder="Enter price" value="{{ old('price') }}" required>
                            @if($errors->has('price'))
                            <div class="error text-danger">{{ $errors->first('price') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="run">Travel<span class="text-danger">*</span></label>
                            <select name="run" id="run" class="form-control" required>
                                <option value="daily">Daily</option>
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

        $("form[name='addbusrouteform']").validate({
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
@endsection