@extends('layouts.cashier')

@section('title', 'Order')

@section('content')
    <form action="{{ route('cashier.order.update', $order->id) }}" method="POST" class="ORDER">
        @csrf
        <div class="row">
            <div class="col">
                <div class="page-description page-description-tabbed">
                    <h1>Menus</h1>
                    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                        @foreach ($menu_list as $index => $menu)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $index == 0 ? 'active' : '' }}"
                                    id="{{ $menu['category']->slug }}-tab" data-bs-toggle="tab"
                                    data-bs-target="#{{ $menu['category']->slug }}" type="button" role="tab"
                                    aria-controls="hoaccountme" aria-selected="true">{{ $menu['category']->name }}</button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="tab-content" id="myTabContent">
                    @foreach ($menu_list as $index => $menu)
                        <div class="tab-pane fade show {{ $index == 0 ? 'active' : '' }}" id="{{ $menu['category']->slug }}"
                            role="tabpanel" aria-labelledby="account-tab">
                            <div class="py-5 row">
                                @foreach ($menu['menus'] as $menu_item)
                                    <div class="col-md-4 col-8 mx-auto">
                                        <div class="card">
                                            <img src="{{ asset('/storage/' . $menu_item->image) }}"
                                                style="height: 300px;object-fit: cover;" class="card-img-top"
                                                alt="{{ $menu_item->name }}-image">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $menu_item->name }} </h5>
                                                <h6 class="card-subtitle mb-2 text-muted">
                                                    {{ 'Rp' . number_format($menu_item->price, 0, '.', '.') }}</h6>
                                                <p class="card-text mt-2">
                                                    {{ $menu_item->description }}
                                                </p>
                                                <div class="input-group">
                                                    <button class="btn btn-primary min"
                                                        onclick="$('#{{ $menu_item->slug }}-input')[0].stepDown()"
                                                        type="button" id="min" data-slug="{{ $menu_item->slug }}"
                                                        data-name="{{ $menu_item->name }}"
                                                        data-price="{{ $menu_item->price }}">-</button>
                                                    <input type="hidden" name="menu_id[]"
                                                        id="input-{{ $menu_item->slug }}" value="{{ $menu_item->id }}">
                                                    <input type="number" class="form-control"
                                                        id="{{ $menu_item->slug }}-input" aria-describedby="amount"
                                                        aria-label="Upload" min="0" value="0" name="amount[]">

                                                    <button class="btn btn-primary plus" data-slug="{{ $menu_item->slug }}"
                                                        data-name="{{ $menu_item->name }}"
                                                        data-price="{{ $menu_item->price }}"
                                                        onclick="$('#{{ $menu_item->slug }}-input')[0].stepUp()"
                                                        type="button" id="add">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
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
            <div class="card-body">
                <div class="row">
                    <div class="col-10 col-md-6 mx-auto">
                        <label for="table_id" class="form-label">Table</label>
                        <div class="input-group mb-3">
                            <select class="form-select" id="table_id" name="table_id" type="number"
                                aria-placeholder="Table">
                                @foreach ($tables as $table)
                                    <option value="{{ $table->id }}"
                                        {{ $order->table_id == $table->id ? 'selected' : '' }}>
                                        {{ "$table->name - Rp" . number_format($table->price, 0, '.', '.') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-10 mx-auto col-md-6">
                        <label for="is_paid" class="form-label">Lunas</label>
                        <div class="input-group mb-3">
                            <select class="form-select" id="is_paid" name="is_paid" type="number"
                                aria-placeholder="Table">
                                <option value="0" {{ $order->is_paid == 0 ? 'selected' : '' }}>
                                    Tidak
                                </option>
                                <option value="1" {{ $order->is_paid == 1 ? 'selected' : '' }}>
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
                </div>
            </div>
            <div class="card-footer">
                <div class="row invoice-summary">
                    <div class="col-lg-8">

                    </div>
                    <div class="col-lg-4">
                        <div class="invoice-info">
                            <?php $total = 0;
                            foreach ($menus as $menu) {
                                $total += $menu->price_per_item * $menu->quantity;
                            }
                            ?>
                            @if ($order->is_paid)
                                <span class="badge badge-success">Paid</span>
                            @else
                                <div class="badge badge-danger">Unpaid</div>
                            @endif
                            <p class="">Paid<span
                                    id="paid">{{ 'Rp' . number_format($total_paid, 0, '.', '.') }}</span>
                            </p>
                            <p class="">Unpaid<span
                                    id="unpaid">{{ 'Rp' . number_format($order->total_price - $total_paid, 0, '.', '.') }}</span>
                            </p>
                            <p class="">Menu Total <span
                                    id="menu">{{ 'Rp' . number_format($total, 0, '.', '.') }}</span></p>
                            <p class="">Table Price <span
                                    id="table">{{ 'Rp' . number_format($table_price, 0, '.', '.') }}</span>
                            </p>
                            <p class="bold">Total <span
                                    id="total">{{ 'Rp' . number_format($order->total_price, 0, '.', '.') }}</span></p>
                            <input type="submit" class="btn btn-primary w-100" value="update">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @method('PUT')
    </form>
@endsection

@section('scripts')
    <script>
        let menus = @json($menus);
        let newMenus = [];
        menus.forEach(function(menu) {
            let id = `#${menu.menu.slug}-input`;

            $(id).val(menu.quantity);
            newMenus.push({
                slug: menu.menu.slug,
                name: menu.menu.name,
                price: menu.price_per_item,
                amount: menu.quantity,
            });
        });

        let order = {
            menus: newMenus,
            total: 0,
            table: {{ $table_price }},
        }
        calculateTotal();
        showOrder();
        $('.min').click(function() {
            var name = $(this).data('name');
            var slug = $(this).data('slug');
            var price = $(this).data('price');
            var input = $('#' + slug + '-input');
            var value = input.val();
            input.val(parseInt(value));
            console.log(value);
            if (value > 1) {
                order.menus.forEach(function(menu) {
                    if (menu.slug == slug) {
                        menu.amount = value;
                    }
                });
            } else {
                order.menus = order.menus.filter(function(menu) {
                    return menu.slug != slug;
                });
            }
            calculateTotal();
            showOrder();
        });

        $('.plus').click(function() {
            var name = $(this).data('name');
            var slug = $(this).data('slug');
            var price = $(this).data('price');
            var input = $('#' + slug + '-input');
            var value = input.val();
            input.val(parseInt(value));
            console.log(value);

            if (value > 1) {
                order.menus.forEach(function(menu) {
                    if (menu.slug == slug) {
                        menu.amount = value;
                    }
                });
            } else {
                order.menus.push({
                    name: name,
                    slug: slug,
                    price: price,
                    amount: value
                });
            }
            calculateTotal();
            showOrder();
        });

        function calculateTotal() {
            var total = order.table;
            order.menus.forEach(function(menu) {
                total += menu.price * menu.amount;
            });
            order.total = total;
        }

        function showOrder() {
            // show oder in table
            var orderList = $('#order-list');
            orderList.empty();
            order.menus.forEach(function(menu, index) {
                orderList.append(`
              <tr>
                <td>${index + 1}</td>
                <td>${menu.name}</td>
                <td>Rp.${menu.price}</td>
                <td>${menu.amount}</td>
                <td>Rp${menu.price * menu.amount}</td>
              </tr>
            `);
            });
            let paid = {{ $total_paid }};
            // show total
            $('#total').text(`Rp${order.total}`);
            $('#menu').text(`Rp${order.total-order.table}`);
            $('#table').text(`Rp${order.table}`);
            $('#unpaid').text(`Rp${order.total - paid}`);
        }

        $('#table_id').on('change', function() {
            // get value from select
            var tableId = $(this).val();

            let url = `/cashier/table/${tableId}`;

            $.ajax({
                url,
                method: 'GET',
                success: function(data) {
                    order.table = data.price;
                    calculateTotal();
                    showOrder()
                }
            })
        })
    </script>
@endsection
