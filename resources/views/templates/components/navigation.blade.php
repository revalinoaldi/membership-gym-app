
<div class="app-brand demo ">
    <a href="/" class="app-brand-link">
        <div class="app-brand-logo demo in-dashboard">
            <img src="/assets/img/logo/logo.png" class="app-brand-logo demo layout">
        </div>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
        <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
    </a>
</div>

<div class="menu-inner-shadow"></div>

<ul class="menu-inner py-1">
    <li class="menu-item {{ Request::is('home*') ? 'active' : '' }}">
        <a href="{{ route('home') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
            <div data-i18n="Dashboard">Dashboard</div>
        </a>
    </li>
    <li class="menu-item {{ Request::is('paket*') ? 'active' : '' }}">
        <a href="{{ route('paket.index') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-mail"></i>
            <div data-i18n="Paket">Paket</div>
        </a>
    </li>
    <li class="menu-item {{ Request::is('transaksi*') ? 'active' : '' }}">
        <a href="{{ route('transaksi.index') }}" class="menu-link">
            <i class="menu-icon flex-shrink-0 ti ti-credit-card ti-sm"></i>
            <div data-i18n="Transaksi">Transaksi</div>
        </a>
    </li>
    <li class="menu-item {{ Request::is('list-dayin*') ? 'active' : '' }}">
        <a href="#" class="menu-link">
            <i class="menu-icon tf-icons ti ti-arrows-diff"></i>
            <div data-i18n="Checkin / Checkout">Checkin / Checkout</div>
        </a>
    </li>
    <li class="menu-item {{ Request::is('dayin*') ? 'active' : '' }}">
        <a href="{{ route('dayin.index') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-book-upload"></i>
            <div data-i18n="Day In Gym">Day In Gym</div>
        </a>
    </li>

    <li class="menu-item {{ Request::is('user*') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-users"></i>
            <div data-i18n="Users">Users</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ Request::is('user/list*') ? 'active' : '' }}">
                <a href="{{ route('list.index') }}" class="menu-link">
                    <div data-i18n="Users">Users</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('user/member*') ? 'active' : '' }}">
                <a href="{{ route('member.index') }}" class="menu-link">
                    <div data-i18n="Member">Member</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('user/roles*') ? 'active' : '' }}">
                <a href="#" class="menu-link">
                    <div data-i18n="Roles">Roles</div>
                </a>
            </li>
        </ul>
    </li>

    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-book"></i>
            <div data-i18n="Reporting">Reporting</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <div data-i18n="Report Semua Member">Report Semua Member</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <div data-i18n="Report Daily Checkin">Report Daily Checkin</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <div data-i18n="Report Transaksi">Report Transaksi</div>
                </a>
            </li>
        </ul>
    </li>
</ul>
