@extends('layouts.admin')
@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Company List</h4>
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
                                <a class="btn btn-info waves-effect waves-light"
                                    href="{{ route('admin.company.create') }}"><i class="fa fa-plus editable" style="font-size:15px;">&nbsp;ADD</i></a>
                            </div>
                        </span>

                    </div>
                </div>



                <table id="datatable" class="table table-bordered dt-responsive w-100 mt-3">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>GST</th>
                            <th>PAN</th>
                            <th>Address</th>
                            <!-- <th>CGST</th> -->
                            <!-- <th>SGST</th> -->
                            <!-- <th>Active</th> -->
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($comapyes as $company)
                        <tr>
                            <td>
                                <a href="{{ route('admin.company.edit', $company->id) }}"
                                    class="btn btn-outline-primary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Edit"><i
                                        class="fa fa-edit"></i></a>
                                @if(count($comapyes) > 1)
                                <a href="{{ route('admin.company.destroy', $company->id) }}"
                                    onclick="return confirm('Sure ! You want to delete ?');"
                                    class="btn btn-outline-danger waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Delete"><i
                                        class="fa fa-trash"></i></a>
                                @endif
                            </td>
                            <td><img src="{{ $company->logo }}" alt="img" width="50px" hight="50px" loading="lazy"></td>
                            <td>{{ $company->name }}</td>
                            <td>{{ $company->email }}</td>
                            <td>{{ $company->contact }}</td>
                            <td>{{ $company->gst_no }}</td>
                            <td>{{ $company->pan_no }}</td>
                            <td>
                                <div class="html-read-more-content">{{ $company->address }}</div>
                            </td>
                            <!-- <td>{{ $company->cgst }}</td> -->
                            <!-- <td>{{ $company->sgst }}</td> -->
                            <!-- <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input toggle-status-switch" type="checkbox"
                                        id="toggleSwitch{{ $company->id }}" data-id="{{ $company->id }}"
                                        {{ $company->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="toggleSwitch{{ $company->id }}">
                                        {{ $company->is_active ? 'Active' : 'De-active' }}
                                    </label>
                                </div>
                            </td> -->
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
            url: "{{ route('admin.company.active') }}",
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