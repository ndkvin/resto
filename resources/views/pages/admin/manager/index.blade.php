@extends('layouts.admin')

@section('title')
    Admin Dashboard
@endsection`

@section('content')
    <button type="button" class="btn btn-primary btn-burger" data-bs-toggle="modal" data-bs-target="#create">
        <div class="flex align-middle">
            <span class="material-symbols-outlined">
                add
            </span>
        </div>
    </button>

    <!-- create modal -->
    <div class="modal fade" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Manager</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.manager.store') }}" method="POST" id="formCreate"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                min="3">
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password">
                        </div>
                        <input type="submit" id="createSubmit" class="d-none">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitCreate()">Create</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Manager</h5>
                </div>
                <div class="card-body table-responsive">
                    <table id="datatable4" class="display nowrap table" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>

                        </thead>
                        <tfoot>
                            <tr>
                                <th>no</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($managers as $manager)
                                <tr>
                                    <td class="align-middle">{{ $no }}</td>
                                    <td class="align-middle">{{ $manager->name }}</td>
                                    <td class="align-middle">{{ $manager->email }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-burger btn-sm me-3"
                                            data-bs-toggle="modal" data-bs-target="#editCashier"
                                            data-id="{{ $manager->id }}">
                                            <span class="material-symbols-outlined">
                                                edit
                                            </span>
                                        </button>

                                        <button type="button" class="btn btn-danger btn-burger btn-sm me-3"
                                            data-bs-toggle="modal" data-bs-target="#deleteCashier"
                                            data-id="{{ $manager->id }}">
                                            <span class="material-symbols-outlined">
                                                delete
                                            </span>
                                        </button>
                                    </td>
                                </tr>
                                <?php $no++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- edit modal --}}
        <div class="modal fade" id="editCashier" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Manager</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/admin/manager/id" method="POST" id="formCreate">
                            @method('PUT')
                            @csrf
                            <div class="col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required
                                    min="3">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="col-md-12 mt-2">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" class="form-control" id="password" name="password">
                            </div>
                            <input type="submit" id="editSubmit" class="d-none">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="submitEdit()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- delete modal --}}
        <div class="modal fade" id="deleteCashier" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Cashier</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure to delete <span id="cashierName"></span>?
                        <form action="/admin/manager/id" method="POST" id="formCreate">
                            @method('DELETE')
                            @csrf
                            <input type="submit" id="deleteSubmit" class="d-none">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="submitDelete()">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection


    @section('scripts')
        <script>
            function submitCreate() {
                $('#createSubmit').click();
            }

            function submitEdit() {
                $('#editSubmit').click();
            }

            function submitDelete() {
                $('#deleteSubmit').click();
            }


            $('#editCashier').on('show.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('id');
                const url = `/admin/manager/${id}`;

                $.get(url, function(response) {
                    $(e.currentTarget).find('form[action="/admin/manager/id"]').attr('action',
                        `/admin/manager/${id}`);
                    $(e.currentTarget).find('input[name="name"]').val(response.name);
                    $(e.currentTarget).find('input[name="email"]').val(response.email);
                });
            });

            $('#deleteCashier').on('show.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('id');
                const url = `/admin/manager/${id}`;
                console.log(url)
                $.get(url, function(response) {
                    console.log(response)
                    $(e.currentTarget).find('form[action="/admin/manager/id"]').attr('action',
                        `/admin/manager/${id}`);
                    $('#cashierName').text(response.name);
                });
            });
        </script>
    @endsection
