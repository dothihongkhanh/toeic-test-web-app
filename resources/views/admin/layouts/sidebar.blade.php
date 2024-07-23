<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion !text-white" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin">
        <div class="sidebar-brand-text mx-3">Toeic Study</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Thống kê</span></a>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item ">
        <a class="nav-link" href="{{ route('admin.parts.list') }}">
            <i class="fas fa-fw fa-bookmark"></i>
            <span>Part</span></a>
    </li>
    <li class="nav-item ">
        <a class="nav-link" href="{{ route('admin.listening.list') }}">
            <i class="fas fa-fw fa-headphones"></i>
            <span>Listening</span></a>
    </li>
    <li class="nav-item ">
        <a class="nav-link" href="{{ route('admin.reading.list') }}">
            <i class="fas fa-fw fa-book-open"></i>
            <span>Reading</span></a>
    </li>
    <li class="nav-item ">
        <a class="nav-link" href="{{ route('admin.user') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Người dùng</span></a>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>