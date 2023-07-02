@extends('layouts.cashier')

@section('title', 'Order')

@section('content')
    <div class="card invoice">
        <div class="card-body">
            <h3>Order Summary</h3>
            <div class="row">
                <div class="table-responsive">
                    <table class="table invoice-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody id="order-list">
                            <?php $no = 1; ?>
                            @foreach ($menus as $menu)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $menu->menu->name }}</td>
                                    <td>{{ 'Rp' . number_format($menu->price_per_item, 0, '.', '.') }}</td>
                                    <td>{{ $menu->quantity }}</td>
                                    <td>{{ 'Rp' . number_format($menu->price_per_item * $menu->quantity, 0, '.', '.') }}
                                    </td>
                                </tr>
                                <?php $no++; ?>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="table-responsive">
                    <table class="table invoice-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Date</th>
                                <th scope="col">Payment Method</th>
                                <th scope="col">Amount</th>
                                <th scope="col">No Rek</th>
                            </tr>
                        </thead>
                        <tbody id="order-list">
                            <?php $no = 1; ?>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ date('l, j F Y', strtotime($payment->created_at)) }}</td>
                                    <td>{{ $payment->payment_method }}</td>
                                    <td>{{ 'Rp' . number_format($payment->amount, 0, '.', '.') }}</td>
                                    <td>{{ $payment->rekening }}</td>
                                    </td>
                                </tr>
                                <?php $no++; ?>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row invoice-summary">
                <div class="col-lg-9">

                </div>
                <div class="col-lg-3">
                    <div class="invoice-info">
                        <?php $total = 0;
                        foreach ($menus as $menu) {
                            $total += $menu->price_per_item * $menu->quantity;
                        }
                        ?>
                        @if ($order->is_paid)
                            <span class="badge badge-success">Paid</span>
                        @else
                            <p class="d-flex">
                            <div class="badge badge-danger">Unpaid</div>
                            <span
                                id="total">-{{ 'Rp' . number_format($order->total_price - $total_paid, 0, '.', '.') }}</span>
                            </p>
                        @endif
                        <p class="">Menu Total <span
                                id="total">{{ 'Rp' . number_format($total, 0, '.', '.') }}</span></p>
                        <p class="">Table Price <span
                                id="total">{{ 'Rp' . number_format($order->total_price - $total, 0, '.', '.') }}</span>
                        </p>
                        <p class="bold">Total <span
                                id="total">{{ 'Rp' . number_format($order->total_price, 0, '.', '.') }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('cashier.order.update', $order->id) }}" method="POST" class="ORDER">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-10 mx-auto col-md-6 mt-2">
                            <label for="is_paid" class="form-label">Lunas</label>
                            <div class="input-group mb-3">
                                <select class="form-select" id="is_paid" name="is_paid" type="number"
                                    aria-placeholder="Table">
                                    <option value="0">
                                        Tidak
                                    </option>
                                    <option value="1">
                                        Ya
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-10 mx-auto col-md-6 mt-2">
                            <label for="peyment_method" class="form-label">Payment</label>
                            <div class="input-group mb-3">
                                <select class="form-select" id="table_id" name="payment_method" aria-placeholder="Table">
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
                        </div>
                        <div class="col-10 mx-auto col-md-6 mt-2">
                            <label for="rekening" class="form-label">Rekening</label>
                            <input type="number" class="form-control" id="rekening" name="rekening">
                        </div>
                        <div class="col-10 mx-auto col-md-6 mt-2">
                            <label for="nominal" class="form-label">Nominal</label>
                            <input type="number" class="form-control" id="nominal" name="nominal">
                        </div>
                        <div class="col-6">

                        </div>
                        <div class="col-10 col-md-6 mt-2">
                          <input type="submit" class="btn btn-primary w-100" value="update">
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection