@extends('layouts.manager')

@section('title')
    Manager Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <h1>
              Resto Statistic
            </h1>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-lg-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Revenue</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenue">Your browser does not support the canvas element.</canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Menu</h5>
                </div>
                <div class="card-body">
                    <canvas id="menu">Your browser does not support the canvas element.</canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Table</h5>
                </div>
                <div class="card-body">
                    <canvas id="table">Your browser does not support the canvas element.</canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/assets/plugins/chartjs/chart.bundle.min.js"></script>
    <script src="/assets/js/pages/charts-chartjs.js"></script>

    <script>
        let menus = @json($menus);
        let tables = @json($tables);
        let revenue = @json($revenue);

        console.log(revenue);
        new Chart(
            document.getElementById('menu'), {
                type: 'bar',
                data: {
                    labels: menus.map((menu) => menu.menu_name),
                    datasets: [{
                        label: 'Penjualan',
                        data: menus.map((menu) => menu.total_orders)
                    }]
                }
            }
        );

        new Chart(
            document.getElementById('table'), {
                type: 'bar',
                data: {
                    labels: tables.map((table) => table.name),
                    datasets: [{
                        label: 'Penjualan',
                        data: tables.map((table) => table.used)
                    }]
                }
            }
        );

        new Chart(
            document.getElementById('revenue'), {
                type: 'bar',
                data: {
                    labels: revenue.map((revenue) => {
                      let month = new Date(0, revenue.month - 1).toLocaleString('default', { month: 'long' })
                      return `${month} ${revenue.year}`;
                    }),
                    datasets: [{
                        label: 'Penjualan',
                        data: revenue.map((revenue) => parseInt(revenue.monthly_earnings))
                    }]
                }
            }
        );
    </script>
@endsection
