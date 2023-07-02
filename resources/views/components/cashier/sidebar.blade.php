<div class="app-sidebar">
    <div class="logo d-flex justify-content-between">
        <div class="fs-2 fw-bold">
            Resto
        </div>
        <div class="sidebar-user-switcher user-activity-online d-flex align-items-center justify-content-center">
            <a href="#" class="d-flex align-items-center justify-content-center">
                <span class="user-info-text ">{{ auth()->user()->name }}</span>
            </a>
        </div>
    </div>
    <div class="app-menu">
        <ul class="accordion-menu">
            <li class="sidebar-title">
                Resto
            </li>
            <li class="{{ request()->is('cashier/table') ? 'active-page' : ''}}">
                <a href="">
                    <i class="material-icons-two-tone">settings</i>
                    Manage
                    <i class="material-icons has-sub-menu">keyboard_arrow_right</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('cashier.table.index') }}"
                            class="{{ request()->is('cashier/table') ? ' active' : '' }}">Table</a>
                    </li>
                </ul>
            </li>
            <li class="{{ !request()->is('cashier/table') ? 'active-page' : ''}}">
                <a href="">
                    <i class="material-symbols-outlined">list_alt</i>
                    Order
                    <i class="material-icons has-sub-menu">keyboard_arrow_right</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('cashier.reservation.index') }}"
                            class="{{ request()->is('cashier/reservation') ? ' active' : '' }}">Reservation</a>
                    </li>
                    <li>
                        <a href="{{ route('cashier.order.index') }}"
                            class="{{ request()->is('cashier/order') ? ' active' : '' }}">Order</a>
                    </li>
                </ul>
            </li>
            </li>
            <li>
                <a href="#" onclick="$('#logout').click()"><i class="material-icons-two-tone">logout</i>Logout</a>
                <form action="{{ route('logout') }}" method="POST" id="formCreate">
                    @csrf
                    <input type="submit" id="logout" class="d-none">
                </form>
            </li>

        </ul>
    </div>
</div>
