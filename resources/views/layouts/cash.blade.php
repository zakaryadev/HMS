<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.5/b-2.4.1/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.css" />
    <link id="theme-style" rel="stylesheet" href="/assets/css/portal.css" />
    <style>
        .page-link.active,
        .active>.page-link {
            background-color: #15a362;
            border-color: #15a362;
        }
    </style>
</head>

<body class="app">
    <header class="app-header fixed-top">
        <div class="app-header-inner">
            <div class="container-fluid py-2">
                <div class="app-header-content">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                    viewBox="0 0 30 30" role="img">
                                    <title>Menu</title>
                                    <path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10"
                                        stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path>
                                </svg>
                            </a>
                        </div>
                        <!--//col-->
                        <div class="app-utilities col-auto">
                            <div class="app-utility-item app-user-dropdown dropdown">
                                <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown"
                                    href="#" role="button" aria-expanded="false">
                                    <img src="https://ui-avatars.com/api/?background=15a362&color=fff&rounded=true&name={{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}"
                                        alt="user profile" />
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
                                    <li>
                                        <a class="dropdown-item d-flex flex-column">
                                            <p>
                                                {{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}
                                            </p>
                                            <small>
                                                {{ auth()->user()->cashier->name }}
                                            </small>
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button class="dropdown-item" type="submit">Выйти</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            <!--//app-user-dropdown-->
                        </div>
                        <!--//app-utilities-->
                    </div>
                    <!--//row-->
                </div>
                <!--//app-header-content-->
            </div>
            <!--//container-fluid-->
        </div>
        <!--//app-header-inner-->
        <div id="app-sidepanel" class="app-sidepanel">
            <div id="sidepanel-drop" class="sidepanel-drop"></div>
            <div class="sidepanel-inner d-flex flex-column">
                <a href="{{ route('cash.index') }}" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
                <div class="app-branding">
                    <a class="app-logo" href="{{ route('cash.index') }}">
                        <img class="logo-icon me-2" src="/assets/images/app-logo.svg" alt="logo" />
                        <span class="logo-text">КАССА</span>
                    </a>
                </div>

                <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
                    <ul class="app-menu list-unstyled accordion" id="menu-accordion">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteName() === 'cash.index' ? 'active' : '' }}"
                                href="{{ route('cash.index') }}">
                                <span class="nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                        <path
                                            d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z" />
                                    </svg>
                                </span>
                                <span class="nav-link-text">Пациенты</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  {{ Route::currentRouteName() === 'cash.analyse' ? 'active' : '' }}"
                                href="{{ route('cash.analyse') }}">
                                <span class="nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-pie-chart" viewBox="0 0 16 16">
                                        <path
                                            d="M7.5 1.018a7 7 0 0 0-4.79 11.566L7.5 7.793V1.018zm1 0V7.5h6.482A7.001 7.001 0 0 0 8.5 1.018zM14.982 8.5H8.207l-4.79 4.79A7 7 0 0 0 14.982 8.5zM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8z" />
                                    </svg>
                                </span>
                                <span class="nav-link-text">Статистика</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  {{ Route::currentRouteName() === 'cash.debts' ? 'active' : '' }}"
                                href="{{ route('cash.debts') }}">
                                <span class="nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-pie-chart" viewBox="0 0 16 16">
                                        <path
                                            d="M7.5 1.018a7 7 0 0 0-4.79 11.566L7.5 7.793V1.018zm1 0V7.5h6.482A7.001 7.001 0 0 0 8.5 1.018zM14.982 8.5H8.207l-4.79 4.79A7 7 0 0 0 14.982 8.5zM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8z" />
                                    </svg>
                                </span>
                                <span class="nav-link-text">Долг</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  {{ Route::currentRouteName() === 'cash.doctor' ? 'active' : '' }}"
                                href="{{ route('cash.doctor') }}">
                                <span class="nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-pie-chart" viewBox="0 0 16 16">
                                        <path
                                            d="M7.5 1.018a7 7 0 0 0-4.79 11.566L7.5 7.793V1.018zm1 0V7.5h6.482A7.001 7.001 0 0 0 8.5 1.018zM14.982 8.5H8.207l-4.79 4.79A7 7 0 0 0 14.982 8.5zM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8z" />
                                    </svg>
                                </span>
                                <span class="nav-link-text">Отчеты по врачу</span>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <div class="app-wrapper">
        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">
                <h1 class="app-page-title">@yield('title')</h1>
            </div>
            @yield('content')
        </div>
        <!--//container-fluid-->
    </div>
    <!--//app-content-->
    </div>
    <!--//app-wrapper-->
    <!-- Javascript -->

    <!-- Page Specific JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.5/b-2.4.1/datatables.min.js"></script>
    <script src="/assets/plugins/popper.min.js"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.js"></script>
    <script src="/assets/plugins/chart.js/chart.min.js"></script>
    <script src="/assets/js/app.js"></script>
    <script>
        $('.order_table').DataTable({
            order: [
                [0, 'desc']
            ],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Russian.json'
            }
        });
    </script>
</body>

</html>
