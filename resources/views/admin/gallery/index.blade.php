@extends('layouts.admin')
@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Gallery</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">
                    Add Image
                </h4>

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
                'action' => 'AdminGalleryController@store',
                'files' => true,
                'class' => 'form-horizontal',
                'name' => 'addAlbumForm',
                ]) !!}
                @csrf

                <div class="row">
                    <div class="mb-3">
                        <label for="file">Image<span class="text-danger">*</span></label>
                        <input type="file" name="file" class="form-control" id="file"
                            placeholder="Enter file" value="" accept="image/*" required>
                        @if ($errors->has('file'))
                        <div class="error text-danger">{{ $errors->first('file') }}</div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-1 align-self-center">
                    <div class="d-flex gap-2">
                        <input type="submit" class="btn btn-primary w-md" id="submitBtn" value="Submit" />
                        <span id="loadingText" style="display:none; margin-left:10px;"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>
                    </div>
                </div>
                </form>

            </div>
        </div>
    </div> <!-- end col -->

    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <h4 class="card-title mb-0">Gallery List</h4>
                </div>

                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-check-all me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <table id="datatable" class="table table-bordered dt-responsive nowrap w-100 mt-3">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <!-- <th>Type</th> -->
                            <th>Image</th>
                            <th>Show/Hide</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($images as $image)
                        <tr>
                            <td>
                                <a href="{{ route('admin.album.edit', $image->id) }}"
                                    class="btn btn-outline-primary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Edit"><i class="fa fa-edit"></i></a>
                                <a href="{{ route('admin.album.destroy', $image->id) }}"
                                    onclick="return confirm('Sure ! You want to delete ?');"
                                    class="btn btn-outline-danger waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Delete"><i class="fa fa-trash"></i></a>
                            </td>
                            <!-- <td></td> -->
                            <td>
                                <img src="{{ $image->file }}" alt="{{ $image->file }}" width="50px" hight="50px" loading="lazy">
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input toggle-status-switch" type="checkbox"
                                        id="toggleSwitch{{ $image->id }}" data-id="{{ $image->id }}"
                                        {{ $image->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="toggleSwitch{{ $image->id }}">
                                        {{ $image->is_active ? 'Show' : 'Hide' }}
                                    </label>
                                </div>
                            </td>
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
    $(function() {
        $("form[name='addAlbumForm']").validate({
            rules: {
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

<script>
    $(document).on('change', '.toggle-status-switch', function() {
        const toggleSwitch = $(this);
        const agentId = toggleSwitch.data('id');
        const isChecked = toggleSwitch.is(':checked');

        $.ajax({
            url: "{{ route('admin.album.active') }}",
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
</script>
@endsection