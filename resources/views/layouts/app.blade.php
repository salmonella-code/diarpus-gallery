<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem penyimpanan dokumentasi kegiatan foto dan video Diarpus">
    <title>Diarpus Galery</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('css')
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            <a href="index.html"><img style="height: 100px" src="{{ asset('images/logo-kab.png') }}" alt="Logo"></a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="fas fa-times fa-fw"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu mb-5">
                        <li class="sidebar-title">Menu</li>

                        <li class="sidebar-item {{ request()->is('/') ? 'active' : '' }} ">
                            <a href="{{ url('/') }}" class='sidebar-link'>
                                <i class="fas fa-fw fa-th-large"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        @if (auth()->user()->role == 'admin')
                        <li class="sidebar-item {{ request()->is('village*') ? 'active' : '' }} ">
                            <a href="{{ url('/village') }}" class='sidebar-link'>
                                <i class="fas fa-fw fa-map"></i>
                                <span>Desa</span>
                            </a>
                        </li>

                        <li class="sidebar-item {{ request()->is('field*') ? 'active' : '' }} ">
                            <a href="{{ route('field.index') }}" class='sidebar-link'>
                                <i class="fas fa-fw fa-user-check"></i>
                                <span>Bidang</span>
                            </a>
                        </li>

                        <li class="sidebar-item {{ request()->is('admin*') ? 'active' : (request()->is('user*') ? 'active' : '') }} has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="fas fa-fw fa-users" aria-hidden="true"></i>
                                <span>User</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item {{ request()->is('admin*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.index') }}">Admin</a>
                                </li>
                                <li class="submenu-item {{ request()->is('user*') ? 'active' : '' }}">
                                    <a href="{{ route('user.index') }}">User</a>
                                </li>
                                <li class="submenu-item {{ request()->is('village-user*') ? 'active' : '' }}">
                                    <a href="{{ url('/village-user') }}">Desa</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-title">Bidang-bidang</li>

                        @foreach ($fields as $field)
                        <li class="sidebar-item {{ request()->is('gallery/' . $field->slug . '*') ? 'active' : '' }} has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="fas fa-fw fa-users" aria-hidden="true"></i>
                                <span>{{ $field->name }}</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item {{ request()->is('gallery/' . $field->slug . '/photo*') ? 'active' : '' }}">
                                    <a href="{{ route('photo.index', $field->slug) }}">Photo</a>
                                </li>
                                <li class="submenu-item {{ request()->is('gallery/' . $field->slug . '/video*') ? 'active' : '' }}">
                                    <a href="{{ route('video.index', $field->slug) }}">Video</a>
                                </li>
                            </ul>
                        </li>
                        @endforeach
                        <li class="sidebar-title">Desa-desa</li>
                            @foreach ($villages as $village)
                                <li class="sidebar-item {{ request()->is('gallery/' . $village->slug . '*') ? 'active' : '' }} has-sub">
                                    <a href="#" class='sidebar-link'>
                                        <i class="fas fa-fw fa-users" aria-hidden="true"></i>
                                        <span>{{ $village->village }}</span>
                                    </a>
                                    <ul class="submenu ">
                                        <li class="submenu-item {{ request()->is('gallery/' . $village->slug . '/photo*') ? 'active' : '' }}">
                                            <a href="{{ route('photo.index', $village->slug) }}">Photo</a>
                                        </li>
                                        <li class="submenu-item {{ request()->is('gallery/' . $village->slug . '/video*') ? 'active' : '' }}">
                                            <a href="{{ route('video.index', $village->slug) }}">Video</a>
                                        </li>
                                    </ul>
                                </li>
                            @endforeach
                        @endif

                        @if (auth()->user()->role == 'user')
                        @foreach (App\Models\Field::where('id', auth()->user()->field_id)->get() as $field)
                        <li class="sidebar-item {{ request()->is('gallery/' . $field->id . '*') ? 'active' : '' }} has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="fas fa-fw fa-users" aria-hidden="true"></i>
                                <span>{{ $field->name }}</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item {{ request()->is('gallery/' . $field->id . '/photo*') ? 'active' : '' }}">
                                    <a href="{{ route('photo.index', $field->id) }}">Photo</a>
                                </li>
                                <li class="submenu-item {{ request()->is('gallery/' . $field->id . '/video*') ? 'active' : '' }}">
                                    <a href="{{ route('video.index', $field->id) }}">Video</a>
                                </li>
                            </ul>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main" class="d-flex flex-column min-vh-100">
            <header class='mb-3'>
                <nav class="navbar navbar-expand navbar-light p-0">
                    <div class="container-fluid p-0">
                        <a href="#" class="burger-btn d-block">
                            <i class="fas fa-bars fa-fw"></i>
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse bu" id="navbarSupportedContent">
                            <div class="btn-group ms-auto">
                                <div class="dropdown">
                                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                        <div class="user-menu d-flex">
                                            <div class="user-name text-end me-3">
                                                <h6 class="mb-0 text-gray-600">{{ auth()->user()->name }}</h6>
                                                <p class="mb-0 text-sm text-gray-600">{{ auth()->user()->email }}</p>
                                            </div>
                                            <div class="user-img d-flex align-items-center">
                                                <div class="avatar avatar-md">
                                                    <img src="{{ asset('avatar/' . auth()->user()->avatar) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" style="margin: 5px 0px; position: absolute; inset: 0px auto auto 0px; transform: translate(-67px, 38px);" data-popper-placement="bottom-end">
                                        <li>
                                            <h6 class="dropdown-header">Hello, {{ auth()->user()->name }}!</h6>
                                        </li>
                                        <a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a>
                                        <a class="dropdown-item" href="{{ url('/change-password') }}">Change Password</a>
                                        <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logout">
                                            Logout
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>

            <div class="page-heading">
                <h3 class="text-capitalize">@yield('page_title')</h3>
            </div>
            <div class="page-content">
                @yield('content')
            </div>

            <footer class="mt-auto">
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p> {{ now()->year }} &copy; Powered By Diarpus</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    {{-- logout --}}
    @auth()
    <div class="modal fade" id="logout" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="logoutLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutLabel">Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin untuk keluar {{ auth()->user()->name }} ???</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endauth
    {{-- //logout --}}

    <script src="{{ asset('vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('vendors/jquery/jquery.min.js') }}"></script>
    @stack('script')
</body>

</html>
