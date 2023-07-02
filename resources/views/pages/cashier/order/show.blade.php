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
                            </p>
                        @endif
                        <p class="">Unpaid<span
                                id="total">{{ 'Rp' . number_format($order->total_price - $total_paid, 0, '.', '.') }}</span>
                        </p>
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
@endsection
