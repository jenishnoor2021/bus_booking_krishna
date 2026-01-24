@extends('layouts.admin')
@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Edit User</h4>
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

                {!! Form::model($user, [
                'method' => 'PATCH',
                'action' => ['AdminController@update', $user->id],
                'files' => true,
                'class' => 'form-horizontal',
                'name' => 'userEditForm',
                ]) !!}
                @csrf

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="role">Role<span class="text-danger">*</span></label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="User" {{ $user->role == 'User' ? 'selected' : '' }}>User</option>
                            </select>
                            @if ($errors->has('role'))
                            <div class="error text-danger">{{ $errors->first('role') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Enter Your Name" value="{{ $user->name }}" required>
                            @if ($errors->has('name'))
                            <div class="error text-danger">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" id="email"
                                placeholder="Enter Your Email" onkeypress='return (event.charCode != 32)'
                                value="{{ $user->email }}" required>
                            @if ($errors->has('email'))
                            <div class="error text-danger">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile no<span class="text-danger">*</span></label>
                            <input type="number" name="mobile" class="form-control" id="mobile" maxlength="10"
                                pattern="\d{10}" placeholder="Enter number" title="Enter exactly 10 digits"
                                value="{{ $user->mobile }}">
                            @if ($errors->has('mobile'))
                            <div class="error text-danger">{{ $errors->first('mobile') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea type="text" name="address" class="form-control" id="address" placeholder="Enter Address">{{ $user->address }}</textarea>
                            @if ($errors->has('address'))
                            <div class="error text-danger">{{ $errors->first('address') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username<span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control" id="username"
                                placeholder="Enter username" onkeypress='return (event.charCode != 32)'
                                value="{{ $user->username }}" required>
                            @if ($errors->has('username'))
                            <div class="error text-danger">{{ $errors->first('username') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                            <input type="text" name="password" class="form-control" id="password"
                                placeholder="Enter password" value="{{ $user->original_password }}">
                            @if ($errors->has('password'))
                            <div class="error text-danger">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-1 align-self-center">
                    <div class="d-flex gap-2">
                        <input type="submit" class="btn btn-primary w-md" id="submitBtn" value="Submit" />
                        <span id="loadingText" style="display:none; margin-left:10px;"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>
                        @if(Session::get('user')['role'] == 'Admin')
                        <a class="btn btn-light mt-3 mt-lg-0" href="{{ URL::to('/admin/users') }}">Back</a>
                        @endif
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

        $("form[name='userEditForm']").validate({
            rules: {
                role: {
                    required: true,
                },
                name: {
                    required: true,
                },
                username: {
                    required: true,
                },
                // address: {
                //     required: true,
                // },
                // mobile: {
                //     required: true,
                // },
                password: {
                    required: true,
                },
                // email: {
                //     required: true,
                // }
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