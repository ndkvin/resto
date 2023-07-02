@extends('layouts.cashier')

@section('title')
    Admin Dashboard
@endsection

@section('content')
    <button type="button" class="btn btn-primary btn-burger" data-bs-toggle="modal" data-bs-target="#create">
        <div class="flex align-middle">
            <span class="material-symbols-outlined d-flex justify-content-center align-item-center">
                add
            </span>
        </div>
    </button>

    <!-- create modal -->
    <div class="modal fade" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Reservation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('cashier.reservation.store') }}" method="POST" id="formCreate"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12">
                            <label for="name" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Customer Name" required min="3">
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="number" class="form-control" id="phone" name="phone"
                                placeholder="Phone Number" required>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="date" class="form-label">Date</label>
                            <input class="form-control flatpickr2" class="date" type="text" name="date"
                                placeholder="Select Date..">
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="amount" class="form-label">Table</label>
                            <div class="input-group mb-3">
                                <select class="form-select" id="amount" name="table_id" type="number"
                                    aria-placeholder="Table">
                                    @foreach ($tables as $table)
                                        <option value="{{ $table->id }}">
                                            {{ "$table->name - Rp" . number_format($table->price, 0, '.', '.') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="peyment_method" class="form-label">Payment Method</label>
                            <select class="form-select" id="peyment_method" name="payment_method"
                                aria-placeholder="payment">
                                <option value="cash">
                                    Cash
                                </option>
                                <option value="mandiri">
                                    Mandiri
                                </option>
                                <option value="bri">
                                    BRI
                                </option>
                                <option value="bni">
                                    BNI
                                </option>
                                <option value="bca">
                                    BCA
                                </option>
                            </select>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="rekening" class="form-label">Nomor Rekening</label>
                            <input type="number" class="form-control" id="norek" name="rekening"
                                placeholder="Nomor Rekening">
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="amount" class="form-label">Down Payment</label>
                            <input type="number" class="form-control" id="amount" name="amount"
                                placeholder="Down payment">
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
                                <th>Phone</th>
                                <th>Down Payment</th>
                                <th>Date</th>
                                <th>time</th>
                                <th>Table Name</th>
                                <th>Action</th>
                            </tr>

                        </thead>
                        <tfoot>
                            <tr>
                                <th>no</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Down Payment</th>
                                <th>Date</th>
                                <th>time</th>
                                <th>Table Name</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($reservations as $reservation)
                                <tr>
                                    <td class="align-middle">{{ $no }}</td>
                                    <td class="align-middle">{{ $reservation->name }}</td>
                                    <td class="align-middle">{{ $reservation->phone }}</td>
                                    <td class="align-middle">{{ 'Rp' . number_format($reservation->amount, 0, '.', '.') }}
                                    </td>
                                    <td class="align-middle">{{ date('l, j F Y, H:i', strtotime($reservation->date)) }}
                                    </td>
                                    <td class="align-middle">{{ date('H:i', strtotime($reservation->date)) }}</td>
                                    <td class="align-middle">{{ $reservation->table_name }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-burger btn-sm me-3"
                                            data-bs-toggle="modal" data-bs-target="#edittable"
                                            data-id="{{ $reservation->id }}">
                                            <span
                                                class="material-symbols-outlined d-flex justify-content-center align-item-center">
                                                edit
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
                        <h5 class="modal-title" id="exampleModalLabel">Edit Reservation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/cashier/reservation/id" method="POST" id="formCreate">
                            @method('PUT')
                            @csrf
                            <div class="col-md-12">
                                <label for="name" class="form-label">Customer Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Customer Name" required min="3">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="number" class="form-control" id="phone" name="phone"
                                    placeholder="Phone Number" required>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="date" class="form-label">Date</label>
                                <input class="form-control flatpickr2" class="date" type="text" name="date"
                                    placeholder="Select Date..">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="amount" class="form-label">Table</label>
                                <div class="input-group mb-3">
                                    <select class="form-select" id="amount" name="table_id" type="number"
                                        aria-placeholder="Table">
                                        @foreach ($tables as $table)
                                            <option value="{{ $table->id }}">
                                                {{ "$table->name - Rp" . number_format($table->price, 0, '.', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="peyment_method" class="form-label">Payment Method</label>
                                <select class="form-select" id="peyment_method" name="payment_method"
                                    aria-placeholder="payment">
                                    <option value="cash">
                                        Cash
                                    </option>
                                    <option value="mandiri">
                                        Mandiri
                                    </option>
                                    <option value="bri">
                                        BRI
                                    </option>
                                    <option value="bni">
                                        BNI
                                    </option>
                                    <option value="bca">
                                        BCA
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="rekening" class="form-label">Nomor Rekening</label>
                                <input type="number" class="form-control" id="norek" name="rekening"
                                    placeholder="Nomor Rekening">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="amount" class="form-label">Down Payment</label>
                                <input type="number" class="form-control" id="amount" name="amount"
                                    placeholder="Down payment">
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
    @endsection

    @section('scripts')
        <script>
            $("#date").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
            });

            function submitCreate() {
                $('#createSubmit').click();
            }

            function submitEdit() {
                $('#editSubmit').click();
            }

            $('#edittable').on('show.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('id');
                const url = `/cashier/reservation/${id}`;

                $.get(url, function(response) {
                    response = response[0];
                    console.log(response)
                    $(e.currentTarget).find('form[action="/cashier/reservation/id"]').attr('action',
                        `/cashier/reservation/${id}`);
                    $(e.currentTarget).find('input[name="name"]').val(response.name);
                    $(e.currentTarget).find('input[name="phone"]').val(response.phone);
                    $(e.currentTarget).find('input[name="amount"]').val(response.amount);
                    $(e.currentTarget).find('input[type="datetime-local"]').val(response.date);
                    $(e.currentTarget).find('input[name="date"]').val(response.date);
                    $(e.currentTarget).find('select[name="table_id"]').val(response.table_id);
                    $(e.currentTarget).find('select[name="payment_method"]').val(response.payment_method);
                    $(e.currentTarget).find('input[name="rekening"]').val(response.rekening);
                });
            });
        </script>
    @endsection
