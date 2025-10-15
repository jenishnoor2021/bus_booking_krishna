@extends('layouts.admin')
@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">ADD Slider</h4>
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
                <div class="alert text-white" style="background-color:#7EDD72">
                    {{ session()->get('success') }}
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
                'action' => 'AdminSlidersController@store',
                'files' => true,
                'class' => 'form-horizontal',
                'name' => 'addsliderform',
                ]) !!}
                @csrf

                <!-- <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="text">Text<span class="text-danger">*</span></label>
                            <input type="text" name="text" class="form-control" id="text"
                                placeholder="Enter Text" value="{{ old('text') }}" required>
                            @if ($errors->has('text'))
                            <div class="error text-danger">{{ $errors->first('text') }}</div>
                            @endif
                        </div>
                    </div>
                </div> -->

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="file">Image<span class="text-danger">*</span></label>
                            <input type="file" name="file" class="form-control" id="file" accept="image/*" required>
                            @if($errors->has('file'))
                            <div class="error text-danger">{{ $errors->first('file') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="link">Link<span class="text-danger">*</span></label>
                            <input type="text" name="link" class="form-control" id="link" placeholder="Enter link" value="{{ old('link') }}" required>
                            @if($errors->has('link'))
                            <div class="error text-danger">{{ $errors->first('link') }}</div>
                            @endif
                        </div>
                    </div>
                </div> -->

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="is_show">Show<span class="text-danger">*</span></label>
                            <select name="is_show" id="is_show" class="form-control" style="width:100%" required>
                                <option value="1">Show</option>
                                <option value="0">Hide</option>
                            </select>
                            @if($errors->has('is_show'))
                            <div class="error text-danger">{{ $errors->first('is_show') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-1 align-self-center">
                    <div class="d-flex gap-2">
                        <input type="submit" class="btn btn-primary w-md" id="submitBtn" value="Submit" />
                        <span id="loadingText" style="display:none; margin-left:10px;"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>
                        <a class="btn btn-light mt-3 mt-lg-0" href="{{ URL::to('/admin/slider') }}">Back</a>
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

        $("form[name='addsliderform']").validate({
            rules: {
                // text: {
                //     required: true,
                // },
                file: {
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