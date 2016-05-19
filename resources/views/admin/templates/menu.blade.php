<ul class="sidebar-menu">
    <li class="header">MENU</li>

    <li class="{{ request()->is('admin') ? "active" : "" }}">
        <a href="{{ route("admin::home") }}">
            <i class="icon ion-ios-home"></i>
            <span>Home</span>
        </a>
    </li>

    <li class="{{ request()->is('admin/usuarios*') ? "active" : "" }}">
        <a href="{{ route("admin::usuarios") }}">
            <i class="icon ion-person"></i>
            <span>Usuários</span>
        </a>
    </li>

</ul>