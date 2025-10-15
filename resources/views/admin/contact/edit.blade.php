@extends('layouts.admin')
@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Edit Contact</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Edit</h4>

                {!! Form::model($contact, [
                'method' => 'PATCH',
                'action' => ['AdminContactController@update', $contact->id],
                'files' => true,
                'class' => 'form-horizontal',
                'name' => 'editcontactform',
                ]) !!}
                @csrf

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="name">Name<span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Enter Name" value="{{ $contact->name }}" required>
                            @if ($errors->has('name'))
                            <div class="error text-danger">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="email">Email<span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" id="email"
                                placeholder="Enter email" value="{{ $contact->email }}" required>
                            @if ($errors->has('email'))
                            <div class="error text-danger">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="contact">Contact<span class="text-danger">*</span></label>
                            <input type="number" name="contact" class="form-control" id="contact"
                                placeholder="Enter contact No" value="{{ $contact->contact }}" required>
                            @if ($errors->has('contact'))
                            <div class="error text-danger">{{ $errors->first('contact') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="file">Image<span class="text-danger">*</span></label>
                            <input type="file" name="file" class="form-control" id="file" required>
                            <img src="{{ $contact->file }}" alt="Your file" width="100px">
                            @if ($errors->has('file'))
                            <div class="error text-danger">{{ $errors->first('file') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="subject">Subject<span class="text-danger">*</span></label>
                            <input type="text" name="subject" class="form-control" id="subject" required>
                            <img src="{{ $contact->subject }}" alt="Your subject" width="100px">
                            @if ($errors->has('subject'))
                            <div class="error text-danger">{{ $errors->first('subject') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Message<span class="text-danger">*</span></label>
                    <textarea type="text" name="message" class="form-control" id="message" placeholder="Enter message" required>{{ $contact->message }}</textarea>
                    @if ($errors->has('message'))
                    <div class="error text-danger">{{ $errors->first('message') }}</div>
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-md">Update</button>
                    <a class="btn btn-light w-md" href="{{ URL::to('/admin/contact') }}">Back</a>
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

        $("form[name='editcontactform']").validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                },
                contact: {
                    required: true,
                },
                subject: {
                    required: true,
                },
                message: {
                    required: true,
                },
                // file: {
                //     required: true,
                // },
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>
@endsection