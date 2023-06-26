@extends('layouts.manager')

@section('title')
    Manager Dashboard
@endsection`

@section('content')
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
                                <th>Price</th>
                                <th>Description</th>
                                <th>Sold</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Sold</th>
                                <th>Revenue</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($popularMenus as $popularMenu)
                                <tr>
                                    <td class="align-middle">{{ $popularMenu->menu_id }}</td>
                                    <td class="align-middle">{{ $popularMenu->menu_name }}</td>
                                    <td class="align-middle">{{ 'Rp' . number_format($popularMenu->menu_price, 0, '.', '.') }}</td>
                                    <td class="align-middle">{{ $popularMenu->menu_description }}</td>
                                    <td class="align-middle">{{ $popularMenu->total_orders }}</td>
                                    <td class="align-middle">{{ 'Rp' . number_format($popularMenu->total_orders * $popularMenu->menu_price, 0, '.', '.') }}</td>
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
