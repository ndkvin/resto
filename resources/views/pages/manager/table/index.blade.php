@extends('layouts.manager')

@section('title')
    Manager Dashboard
@endsection`

@section('content')
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
                                <th>Price</th>
                                <th>Used</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Capacity</th>
                                <th>Price</th>
                                <th>Used</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($mostUsedTables as $mostUsedTable)
                                <tr>
                                    <td class="align-middle">{{ $mostUsedTable->id }}</td>
                                    <td class="align-middle">{{ $mostUsedTable->name }}</td>
                                    <td class="align-middle">{{ number_format($mostUsedTable->capacity, 0, '.', '.') }}</td>
                                    <td class="align-middle">{{ $mostUsedTable->is_paid ? 'Rp' . number_format($mostUsedTable->price, 0, '.', '.') : 'free' }}
                                    </td>
                                    <td class="align-middle">{{ $mostUsedTable->used }}
                                </tr>
                                <?php $no++; ?>
                            @endforeach
                        </tbody>
                    </table>
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