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
            <h4 class="mb-sm-0 font-size-18">Contact List</h4>
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

                        <!-- <span id="menu-navi"
                            class="d-sm-flex flex-wrap text-center text-sm-start justify-content-sm-between">
                            <div class="d-flex align-items-center gap-2 flex-wrap mb-3">
                                <a class="btn btn-info waves-effect waves-light"
                                    href="{{ route('admin.contact.create') }}"><i class="fa fa-plus editable"
                                        style="font-size:15px;">&nbsp;ADD</i></a>
                            </div>
                        </span> -->

                    </div>
                </div>

                <form id="bulk-delete-form" action="{{ route('admin.contact.bulkDelete') }}" method="POST">
                    @csrf
                    <input type="hidden" name="ids" id="bulk-delete-ids">
                    <button type="submit" class="btn btn-danger mb-3" onclick="return confirm('Are you sure to delete selected records?')">Delete Selected</button>
                </form>

                <table id="datatable" class="table table-bordered dt-responsive w-100 mt-3">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>Action</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Message</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($contacts as $contact)
                        <tr>
                            <td>
                                <input type="checkbox" name="ids[]" value="{{ $contact->id }}" class="checkbox-item">
                            </td>
                            <td>
                                <!-- <a href="{{ route('admin.contact.edit', $contact->id) }}"
                                    class="btn btn-outline-primary waves-effect waves-light"><i
                                        class="fa fa-edit"></i></a> -->
                                <a href="{{ route('admin.contact.destroy', $contact->id) }}"
                                    onclick="return confirm('Sure ! You want to delete ?');"
                                    class="btn btn-outline-danger waves-effect waves-light"><i
                                        class="fa fa-trash"></i></a>
                            </td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->contact }}</td>
                            <td>
                                <p class="add-read-more show-less-content">{{ $contact->message }}</p>
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
            url: "{{ route('admin.contact.active') }}",
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
<script>
    document.getElementById('select-all').addEventListener('change', function() {
        const checked = this.checked;
        document.querySelectorAll('.checkbox-item').forEach(cb => cb.checked = checked);
    });

    document.getElementById('bulk-delete-form').addEventListener('submit', function(e) {
        const selectedIds = Array.from(document.querySelectorAll('.checkbox-item:checked')).map(cb => cb.value);
        if (selectedIds.length === 0) {
            e.preventDefault();
            alert('Please select at least one record to delete.');
        } else {
            document.getElementById('bulk-delete-ids').value = selectedIds.join(',');
        }
    });
</script>
@endsection