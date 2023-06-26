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
                    <h5 class="modal-title" id="exampleModalLabel">New Table</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.table.store') }}" method="POST" id="formCreate"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                min="3">
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="capacity" class="form-label">Capacity</label>
                            <input type="number" class="form-control" id="capacity" name="capacity" required>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="is_paid" class="form-label">Paid</label>
                            <div class="input-group mb-3">
                                <select class="form-select" id="is_paid" name="is_paid" type="number" required
                                    min="0" max="1">
                                    <option value="0">False</option>
                                    <option value="1">True</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price">
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
                    <h5 class="card-title">Table</h5>
                </div>
                <div class="card-body table-responsive">
                    <table id="datatable4" class="display nowrap table" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Capacity</th>
                                <th>Is Paid</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>no</th>
                                <th>Name</th>
                                <th>Capacity</th>
                                <th>Is Paid</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($tables as $table)
                                <tr>
                                    <td class="align-middle">{{ $table->id }}</td>
                                    <td class="align-middle">{{ $table->name }}</td>
                                    <td class="align-middle">{{ number_format($table->capacity, 0, '.', '.') }}</td>
                                    <td class="align-middle">{{ $table->is_paid ? 'yes' : 'no' }}</td>
                                    <td class="align-middle">{{ $table->is_paid ? 'Rp' . number_format($table->price, 0, '.', '.') : 'Free' }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-burger btn-sm me-3"
                                            data-bs-toggle="modal" data-bs-target="#edittable"
                                            data-id="{{ $table->id }}">
                                            <span class="material-symbols-outlined">
                                                edit
                                            </span>
                                        </button>

                                        <button type="button" class="btn btn-danger btn-burger btn-sm me-3"
                                            data-bs-toggle="modal" data-bs-target="#deleteTable"
                                            data-id="{{ $table->id }}">
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
        <div class="modal fade" id="edittable" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit table</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/admin/table/id" method="POST" id="formCreate">
                            @method('PUT')
                            @csrf
                            <div class="col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required
                                    min="3">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="capacity" class="form-label">Capacity</label>
                                <input type="number" class="form-control" id="capacity" name="capacity" required>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="is_paid" class="form-label">Paid</label>
                                <div class="input-group mb-3">
                                    <select class="form-select" id="is_paid" name="is_paid" type="number" required
                                        min="0" max="1">
                                        <option value="0">False</option>
                                        <option value="1">True</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price">
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
        <div class="modal fade" id="deleteTable" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete table</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure to delete <span id="tableName"></span>?
                        <form action="/admin/table/id" method="POST" id="formCreate">
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


            $('#edittable').on('show.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('id');
                const url = `/admin/table/${id}`;

                $.get(url, function(response) {
                    $(e.currentTarget).find('form[action="/admin/table/id"]').attr('action',
                        `/admin/table/${id}`);
                    $(e.currentTarget).find('input[name="name"]').val(response.name);
                    $(e.currentTarget).find('input[name="capacity"]').val(response.capacity);
                    $(e.currentTarget).find('input[name="price"]').val(response.price);
                    $(e.currentTarget).find('select[name="category_id"]').val(response.category_id);
                    $(e.currentTarget).find('img[id="img"]').attr('src', `/storage/${response.image}`);
                });
            });

            $('#deleteTable').on('show.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('id');
                const url = `/admin/table/${id}`;
                console.log(url)
                $.get(url, function(response) {
                    console.log(response)
                    $(e.currentTarget).find('form[action="/admin/table/id"]').attr('action',
                        `/admin/table/${id}`);
                    $('#tableName').text(response.name);
                });
            });
        </script>
    @endsection
