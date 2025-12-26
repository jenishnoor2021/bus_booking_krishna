@extends('layouts.admin')
@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Edit Locations</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {!! Form::model($location, [
                'method' => 'PATCH',
                'action' => ['AdminLocationsController@update', $location->id],
                'files' => true,
                'class' => 'form-horizontal',
                'name' => 'editlocationForm',
                ]) !!}
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="pickupdrop_id">City<span class="text-danger">*</span></label>
                            <select name="pickupdrop_id" id="pickupdrop_id" class="form-control" required>
                                <option value="">Select City</option>
                                @foreach ($pickupDrops as $pickup)
                                <option value="{{$pickup->id}}" {{ $pickup->id == $location->pickupdrop_id ? 'selected' : '' }}>{{$pickup->place_name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('pickupdrop_id'))
                            <div class="error text-danger">{{ $errors->first('pickupdrop_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="location_name">Location Name<span class="text-danger">*</span></label>
                            <input type="text" name="location_name" class="form-control" id="location_name"
                                placeholder="Enter Location Name" value="{{ $location->location_name }}" required>
                            @if ($errors->has('location_name'))
                            <div class="error text-danger">{{ $errors->first('location_name') }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-1 align-self-center">
                    <div class="d-flex gap-2">
                        <input type="submit" class="btn btn-primary w-md" id="submitBtn" value="Submit" />
                        <span id="loadingText" style="display:none; margin-left:10px;"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>
                        <a class="btn btn-light mt-3 mt-lg-0" href="{{ URL::to('/admin/locations') }}">Back</a>
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
        $("form[name='editlocationForm']").validate({
            rules: {
                pickupdrop_id: {
                    required: true,
                },
                location_name: {
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
@endsection