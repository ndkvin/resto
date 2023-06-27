@extends('layouts.cashier')

@section('title', 'Order')

@section('content')

    <div class="row">
        <div class="col">
            <div class="page-description page-description-tabbed">
                <h1>Menus</h1>
                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                    @foreach ($menus as $index => $menu)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $index == 0 ? 'active' : '' }}" id="{{ $menu['category']->slug }}-tab"
                                data-bs-toggle="tab" data-bs-target="#{{ $menu['category']->slug }}" type="button"
                                role="tab" aria-controls="hoaccountme"
                                aria-selected="true">{{ $menu['category']->name }}</button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <form action="">
        <div class="row">
            <div class="col">
                <div class="tab-content" id="myTabContent">
                    @foreach ($menus as $index => $menu)
                        <div class="tab-pane fade show {{ $index == 0 ? 'active' : '' }}" id="{{ $menu['category']->slug }}"
                            role="tabpanel" aria-labelledby="account-tab">
                            <div class="py-5 row">
                                @foreach ($menu['menus'] as $menu_item)
                                    <div class="col-md-4 col-8 mx-auto">
                                        <div class="card">
                                            <img src="{{ asset('/storage/' . $menu_item->image) }}"
                                                style="height: 200px;object-fit: cover;" class="card-img-top"
                                                alt="{{ $menu_item->name }}-image">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $menu_item->name }} </h5>
                                                <h6 class="card-subtitle mb-2 text-muted">
                                                    {{ 'Rp' . number_format($menu_item->price, 0, '.', '.') }}</h6>
                                                <p class="card-text mt-2">
                                                    {{ $menu_item->description }}
                                                </p>
                                                <div class="input-group">
                                                    <button class="btn btn-primary" onclick="$('#{{ $menu_item->slug }}-input').stepdown()" type="button"
                                                        id="min">-</button>
                                                    <input type="number" class="form-control" id="{{ $menu_item->slug }}-input"
                                                        aria-describedby="count" aria-label="Upload">
                                                        
                                                    <button class="btn btn-primary" type="button"
                                                        id="add">+</button>
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
    </form>
@endsection
