@extends('layouts.admin')
@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Edit Bus</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Edit</h4>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {!! Form::model($bus, [
                'method' => 'PATCH',
                'action' => ['AdminBusController@update', $bus->id],
                'files' => true,
                'class' => 'form-horizontal',
                'name' => 'editbusform',
                ]) !!}
                @csrf

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="file">Bus Image<span class="text-danger">*</span></label>
                            <input type="file" name="file" class="form-control" accept="image/*" id="file">
                            <img src="{{ $bus->file }}" alt="Your Logo" width="50px" hight="50px" loading="lazy">
                            @if($errors->has('file'))
                            <div class="error text-danger">{{ $errors->first('file') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="bus_no">Bus Number<span class="text-danger">*</span></label>
                            <input type="text" name="bus_no" class="form-control" id="bus_no"
                                placeholder="Enter bus no" value="{{ $bus->bus_no }}" required pattern="\S+">
                            @if ($errors->has('bus_no'))
                            <div class="error text-danger">{{ $errors->first('bus_no') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="bus_type">Bus Type<span class="text-danger">*</span></label>
                            <!-- <select name="bus_type" id="bus_type" class="form-control" required>
                                <option value="">-- Select Bus Type --</option>
                                <option value="AC" {{ $bus->bus_type == 'AC' ? 'selected' : '' }}>AC</option>
                                <option value="NonAC" {{ $bus->bus_type == 'NonAC' ? 'selected' : '' }}>Non-AC</option>
                            </select> -->
                            <input type="text" name="bus_type" class="form-control" id="bus_type"
                                placeholder="Enter bus Type" value="{{ $bus->bus_type }}" required>
                            @if($errors->has('bus_type'))
                            <div class="error text-danger">{{ $errors->first('bus_type') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="seat_layout" class="form-label">Seat Layout<span class="text-danger">*</span></label>
                    <textarea type="text" name="seat_layout" class="form-control" id="seat_layout" placeholder="Enter seat layout">{{ $bus->seat_layout }}</textarea>
                    @if ($errors->has('seat_layout'))
                    <div class="error text-danger">{{ $errors->first('seat_layout') }}</div>
                    @endif
                </div>

                <div class="col-lg-1 align-self-center">
                    <div class="d-flex gap-2">
                        <input type="submit" class="btn btn-primary w-md" id="submitBtn" value="Submit" />
                        <span id="loadingText" style="display:none; margin-left:10px;"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>
                        <a class="btn btn-light mt-3 mt-lg-0" href="{{ URL::to('/admin/bus') }}">Back</a>
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

        $("form[name='editbusform']").validate({
            rules: {
                bus_no: {
                    required: true,
                },
                // file: {
                //     required: true,
                // },
                bus_type: {
                    required: true,
                },
                seat_layout: {
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
</script>
<script>
    document.getElementById("bus_no").addEventListener("input", function() {
        this.value = this.value.replace(/\s/g, ""); // remove all spaces
    });
</script>
@endsection