<div class="app-sidebar">
    <div class="logo d-flex justify-content-between">
        <div class="fs-2 fw-bold">
            <a href="{{ route('manager.home') }}" style="text-decoration:none;color:black">
                Resto
            </a>
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
            <li class="active-page">
                <a href="">
                    <i class="material-icons-two-tone">settings</i>
                    Manage
                    <i class="material-icons has-sub-menu">keyboard_arrow_right</i>
                </a>
                <ul class="sub-menu">

                    <li>
                        <a href="{{ route('manager.menu.index') }}"
                            class="{{ request()->is('manager/menu') ? ' active' : '' }}">Menu</a>
                    </li>
                    <li>
                        <a href="{{ route('manager.table.index') }}"
                            class="{{ request()->is('manager/table') ? ' active' : '' }}">Table</a>
                    </li>
                    <li>
                        <a href="{{ route('manager.revenue.index') }}"
                            class="{{ request()->is('manager/revenue') ? ' active' : '' }}">Revenue</a>
                    </li>
                </ul>
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
