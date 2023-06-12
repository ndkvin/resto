<div class="app-sidebar">
    <div class="logo">
        <a href="index.html" class="logo-icon"><span class="logo-text">Neptune</span></a>
        <div class="sidebar-user-switcher user-activity-online">
            <a href="#">
                <img src="/assets/images/avatars/avatar.png">
                <span class="activity-indicator"></span>
                <span class="user-info-text">Chloe<br><span class="user-state-info">On a call</span></span>
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
                        <a href="{{ route('admin.category.index') }}"
                            class="{{ request()->is('admin/category') ? ' active' : '' }}">Category</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.menu.index') }}"
                            class="{{ request()->is('admin/menu') ? ' active' : '' }}">Menu</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.cashier.index') }}"
                            class="{{ request()->is('admin/cashier') ? ' active' : '' }}">Cashier</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.table.index') }}"
                            class="{{ request()->is('admin/table') ? ' active' : '' }}">Table</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-title">
                UI Elements
            </li>
            <li>
                <a href="#"><i class="material-icons-two-tone">color_lens</i>Styles<i
                        class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="styles-typography.html">Typography</a>
                    </li>
                    <li>
                        <a href="styles-code.html">Code</a>
                    </li>
                    <li>
                        <a href="styles-icons.html">Icons</a>
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
