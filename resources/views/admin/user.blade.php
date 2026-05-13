@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">

        <!-- Header -->
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>All Users</h3>

            <ul class="breadcrumbs flex items-center flex-wrap gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Users</div></li>
            </ul>
        </div>

        <!-- Box -->
        <div class="wg-box">

            <!-- Search + Add -->
            <div class="flex items-center justify-between gap10 flex-wrap">

                <div class="wg-filter flex-grow">
                    <form class="form-search" method="GET">
                        <fieldset class="name">
                            <input type="text" name="name" placeholder="Search users..." required>
                        </fieldset>
                        <div class="button-submit">
                            <button type="submit">
                                <i class="icon-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- <a class="tf-button style-1 w208" href="{{ route('admin.users.add') }}">
                    <i class="icon-plus"></i> Add New
                </a> --}}
            </div>

            <!-- Table -->
            <div class="table-responsive mt-3">
                <table class="table table-striped table-bordered">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $i = 1; @endphp

                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $i++ }}</td>

                            <td>{{ $user->name }}</td>

                            <td>{{ $user->email }}</td>
                            <td>{{ $user->mobile }}</td>
                            <td>{{ $user->utype }}</td>
                            {{-- <td>{{ $user->status ? 'Active' : 'Inactive' }}</td> --}}

                            <td>
                                <div class="list-icon-function">

                                    <a href="#">
                                        <div class="item eye">
                                            <i class="icon-eye"></i>
                                        </div>
                                    </a>

                                    <a href="{{ route('admin.users.edit', $user->id) }}">
                                        <div class="item edit">
                                            <i class="icon-edit-3"></i>
                                        </div>
                                    </a>

                                    <!-- Delete -->
                                    <button type="button"
                                            class="item text-danger open-delete-modal"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal">

                                        <i class="icon-trash-2"></i>
                                    </button>

                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
</div>

<!-- ================= MODAL ================= -->
<div class="modal fade" id="deleteModal">
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Delete User</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="modal-body">

                    <p>Are you sure you want to delete this user?</p>

                    <input type="hidden" id="user_id">

                    <input type="text"
                           class="form-control mt-2"
                           id="user_name"
                           readonly>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-danger">
                        Delete
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>

@endsection


<!-- ================= SCRIPT ================= -->
@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {

    let modal = document.getElementById('deleteModal');

    modal.addEventListener('show.bs.modal', function (event) {

        let button = event.relatedTarget;

        let id = button.getAttribute('data-id');
        let name = button.getAttribute('data-name');

        modal.querySelector('#user_id').value = id;
        modal.querySelector('#user_name').value = name;

        // 🔥 route الصحيح
        let url = "/admin/users/" + id;
        document.getElementById('deleteForm').action = url;
    });

});
</script>
@endpush
