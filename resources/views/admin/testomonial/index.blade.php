@extends('layouts.admin')
@section('content')
@section('style')
<style>
    .form-check-input {
        width: 2em;
        height: 1em;
        background-color: #e4e4e4;
        border-radius: 1em;
        position: relative;
        appearance: none;
        outline: none;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
    }

    .form-check-input:checked {
        background-color: #4caf50;
    }

    .form-check-input::before {
        content: '';
        position: absolute;
        top: 2px;
        left: 2px;
        width: 0.8em;
        height: 0.8em;
        background-color: white;
        border-radius: 50%;
        transition: transform 0.3s ease-in-out;
    }

    .form-check-input:checked::before {
        transform: translateX(1em);
    }
</style>
@endsection
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Testomonial List</h4>
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

                        <span id="menu-navi" class="d-flex flex-wrap align-items-center gap-2 mb-3">
                            <a class="btn btn-info waves-effect waves-light" href="{{ route('admin.testomonial.create') }}">
                                <i class="fa fa-plus editable" style="font-size:15px;">&nbsp;ADD</i>
                            </a>

                            {!! Form::open(['method'=>'GET', 'action'=> 'AdminTestominalController@searchTestomonial', 'class'=>'d-flex align-items-center gap-2', 'style' => 'margin-bottom: 0;']) !!}
                            @csrf
                            <input type="text" name="quer" class="form-control" placeholder="Search name" value="{{request()->quer}}" />
                            <button type="submit" class="btn btn-info waves-effect waves-light">
                                <i class="fa fa-search"></i>
                            </button>
                            {!! Form::close() !!}
                        </span>

                    </div>
                </div>



                <table id="datatable" class="table table-bordered dt-responsive w-100 mt-3">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Occupation</th>
                            <th>Message</th>
                            <!-- <th>Facebook</th>
                            <th>Twitter</th>
                            <th>Instagram</th>
                            <th>Linkdin</th> -->
                            <th>Rateing</th>
                            <th>Show/Hide</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($testomonial as $emp)
                        <tr>
                            <td>
                                <a href="{{ route('admin.testomonial.edit', $emp->id) }}"
                                    class="btn btn-outline-primary waves-effect waves-light"><i
                                        class="fa fa-edit"></i></a>
                                <a href="{{ route('admin.testomonial.destroy', $emp->id) }}"
                                    onclick="return confirm('Sure ! You want to delete ?');"
                                    class="btn btn-outline-danger waves-effect waves-light"><i
                                        class="fa fa-trash"></i></a>
                            </td>
                            <td>
                                {{$emp->name}}
                            </td>
                            <td>
                                <img height="50" src="{{$emp->file ? $emp->file : 'https://eitrawmaterials.eu/wp-content/uploads/2016/09/person-icon.png'}}" alt="">
                            </td>
                            <td>
                                {{$emp->occupation}}
                            </td>
                            <td>
                                <p class="html-read-more-content">{{ $emp->message }}</p>
                            </td>
                            <!-- <td>
                                {{$emp->facebook}}
                            </td>
                            <td>
                                {{$emp->twitter}}
                            </td>
                            <td>
                                {{$emp->instagram}}
                            </td>
                            <td>
                                {{$emp->linkdin}}
                            </td> -->
                            <td>
                                {{$emp->rate}}
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input toggle-status-switch" type="checkbox"
                                        id="toggleSwitch{{ $emp->id }}" data-id="{{ $emp->id }}"
                                        {{ $emp->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="toggleSwitch{{ $emp->id }}">
                                        {{ $emp->is_active ? 'Show' : 'Hide' }}
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
    $(document).on('change', '.toggle-status-switch', function() {
        const toggleSwitch = $(this);
        const agentId = toggleSwitch.data('id');
        const isChecked = toggleSwitch.is(':checked');

        $.ajax({
            url: "{{ route('admin.testomonial.active') }}",
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