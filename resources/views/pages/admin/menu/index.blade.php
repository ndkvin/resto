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
                    <h5 class="modal-title" id="exampleModalLabel">New Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.menu.store') }}" method="POST" id="formCreate"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                min="3">
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="category" class="form-label">Category</label>
                            <div class="input-group mb-3">
                                <select class="form-select" id="categorieslist" name="category_id">

                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="form-control" id="price" name="price" required
                                min="3">
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description" required>
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
                    <h5 class="card-title">Menu</h5>
                </div>
                <div class="card-body table-responsive">
                    <table id="datatable4" class="display nowrap table" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>

                        </thead>
                        <tfoot>
                            <tr>
                                <th>no</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($menus as $menu)
                                <tr>
                                    <td class="align-middle">{{ $no }}</td>
                                    <td class="align-middle">{{ $menu->name }}</td>
                                    <td class="align-middle">{{ $menu->category->name }}</td>
                                    <td class="align-middle">{{ $menu->price }}</td>
                                    <td class="align-middle">{{ $menu->description }}</td>

                                    <td>
                                        <button type="button" class="btn btn-primary btn-burger btn-sm me-3"
                                            data-bs-toggle="modal" data-bs-target="#editMenu" data-id="{{ $menu->id }}">
                                            <span class="material-symbols-outlined">
                                                edit
                                            </span>
                                        </button>

                                        <button type="button" class="btn btn-danger btn-burger btn-sm me-3"
                                            data-bs-toggle="modal" data-bs-target="#deleteMenu"
                                            data-id="{{ $menu->id }}">
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
        <div class="modal fade" id="editMenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/admin/menu/id" method="POST" id="formCreate"  enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required
                                    min="3">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="category_id" class="form-label">Category</label>
                                <div class="input-group mb-3">
                                    <select class="form-select" id="categorieslist" name="category_id">

                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="price" class="form-label">Price</label>
                                <input type="text" class="form-control" id="price" name="price" required
                                    min="3">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                            <div class="col-md-12 mt-2">
                                <img src="" alt="" id="img" width="100%">
                            </div>
                            <figure class="mt-3">
                                <figcaption class="blockquote-footer">
                                    Leave blank if you don't want to change
                                </figcaption>
                            </figure>
                            <div class="col-md-12 mt-2">
                                <label for="description" class="form-label">Description</label>
                                <input type="text" class="form-control" id="description" name="description" required>
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

        <div class="modal fade" id="deleteMenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure to delete <span id="menuName"></span>?
                        <form action="/admin/menu/id" method="POST" id="formCreate">
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

            $('#editMenu').on('show.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('id');
                const url = `/admin/menu/${id}`;

                $.get(url, function(response) {
                    $(e.currentTarget).find('form[action="/admin/menu/id"]').attr('action',
                        `/admin/menu/${id}`);
                    $(e.currentTarget).find('input[name="name"]').val(response.name);
                    $(e.currentTarget).find('input[name="description"]').val(response.description);
                    $(e.currentTarget).find('input[name="price"]').val(response.price);
                    $(e.currentTarget).find('select[name="category_id"]').val(response.category_id);
                    $(e.currentTarget).find('img[id="img"]').attr('src', `/storage/${response.image}`);
                });
            });

            $('#deleteMenu').on('show.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('id');
                const url = `/admin/menu/${id}`;

                $.get(url, function(response) {
                    $(e.currentTarget).find('form[action="/admin/menu/id"]').attr('action',
                        `/admin/menu/${id}`);

                    $('#menuName').text(response.name);
                });
            });
        </script>
    @endsection
