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
                    <h5 class="modal-title" id="exampleModalLabel">New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.category.store') }}" method="POST" id="formCreate">
                        @csrf
                        <div class="col-md-12">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                min="3">
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
                    <h5 class="card-title">Category</h5>
                </div>
                <div class="card-body">
                    <table id="datatable4" class="display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>

                        </thead>
                        <tfoot>
                            <tr>
                                <th>no</th>
                                <th>Name</th>
                                <th>action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-burger btn-sm me-3"
                                            data-bs-toggle="modal" data-bs-target="#editCategory"
                                            data-id="{{ $category->id }}">
                                            <span class="material-symbols-outlined">
                                                edit
                                            </span>
                                        </button>

                                        <button type="button" class="btn btn-danger btn-burger btn-sm me-3"
                                            data-bs-toggle="modal" data-bs-target="#deleteCategory"
                                            data-id="{{ $category->id }}">
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
    </div>

    {{-- edit modal --}}
    <div class="modal fade" id="editCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/admin/category/id" method="POST" id="formCreate">
                        @method('PUT')
                        @csrf
                        <div class="col-md-12">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                min="3">
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

    <div class="modal fade" id="deleteCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure to delete <span id="categoryName"></span>?
                    <form action="/admin/category/id" method="POST" id="formCreate">
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


        $('#editCategory').on('show.bs.modal', function(e) {
            var id = $(e.relatedTarget).data('id');
            const url = `/admin/category/${id}`;

            $.get(url, function(response) {
                $(e.currentTarget).find('form[action="/admin/category/id"]').attr('action',
                    `/admin/category/${id}`);
                $(e.currentTarget).find('input[name="name"]').val(response.name);
            });
        });

        $('#deleteCategory').on('show.bs.modal', function(e) {
            var id = $(e.relatedTarget).data('id');
            const url = `/admin/category/${id}`;

            $.get(url, function(response) {
                $(e.currentTarget).find('form[action="/admin/category/id"]').attr('action',
                    `/admin/category/${id}`);

                $('#categoryName').text(response.name);
            });
        });
    </script>
@endsection
