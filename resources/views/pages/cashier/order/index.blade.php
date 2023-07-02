@extends('layouts.cashier')

@section('title')
    Admin Dashboard
@endsection

@section('content')
    <button onclick="window.location.href ='{{ route('cashier.order.create') }}'" class="btn btn-primary btn-burger"
        data-bs-toggle="modal" data-bs-target="#create">
        <div class="flex align-middle">
            <span class="material-symbols-outlined d-flex justify-content-center align-items-center">
                add
            </span>
        </div>
    </button>

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
                                <th>Cashier Name</th>
                                <th>Customer Name</th>
                                <th>Reservation</th>
                                <th>Date</th>
                                <th>time</th>
                                <th>Table Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Cashier Name</th>
                                <th>Customer Name</th>
                                <th>Reservation</th>
                                <th>Date</th>
                                <th>time</th>
                                <th>Table Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="align-middle">{{ $no }}</td>
                                    <td class="align-middle">{{ $order->cashier_name }}</td>
                                    <td class="align-middle">{{ $order->customer_name == null ? "null" : $order->customer_name}}</td>
                                    <td class="align-middle">{{ $order->customer_name == null ? "no" : "yes" }}</td>
                                    <td class="align-middle">{{ 'Rp' . number_format($order->total_price, 0, '.', '.') }}
                                    </td>
                                    <td class="align-middle">{{ date('l, j F Y', strtotime($order->created_at)) }}</td>
                                    <td class="align-middle">{{ $order->table_name }}</td>
                                    <td class="align-middle">
                                        @if ($order->is_paid)
                                            <span class="badge badge-success">Paid</span>
                                        @else
                                            <span class="badge badge-danger">Unpaid</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button
                                            onclick="window.location.href ='{{ route('cashier.order.edit', $order->id) }}'"
                                            class="btn btn-primary btn-burger btn-sm me-3" data-bs-toggle="modal"
                                            data-bs-target="#edittable">
                                            <span
                                                class="material-symbols-outlined d-flex justify-content-center align-item-center">
                                                edit
                                            </span>
                                        </button>
                                        <button
                                            onclick="window.location.href ='{{ route('cashier.order.show', $order->id) }}'"
                                            class="btn btn-primary btn-burger btn-sm me-3" data-bs-toggle="modal"
                                            data-bs-target="#edittable">
                                            <span class="material-symbols-outlined d-flex justify-content-center align-item-center">
                                              visibility
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
    @endsection

    @section('scripts')
        <script>
            $("#date").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
            });
        </script>
    @endsection
