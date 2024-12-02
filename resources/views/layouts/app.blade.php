<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>@yield('title', env('APP_NAME'))</title>

    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="robots" content="noindex, nofollow">
    <link rel="shortcut icon" href="/assets/media/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/assets/media/favicons/favicon-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/media/favicons/apple-touch-icon-180x180.png">
    <link rel="stylesheet" id="css-main" href="/assets/css/dashmix.min.css">
    @vite('resources/js/app.js')
    <style>
        .form-group {
            margin-bottom: 15px;
        }
    </style>
    @livewireStyles()
</head>

<body>
    <div id="page-container"
        class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">
        <nav id="sidebar" aria-label="Main Navigation">
            <div class="bg-header-dark">
                <div class="content-header bg-white-5">
                    <a class="fw-semibold text-white tracking-wide" href="index.html">
                        <span class="smini-visible">
                            D<span class="opacity-75">x</span>
                        </span>
                        <span class="smini-hidden">
                            Dash<span class="opacity-75">mix</span>
                        </span>
                    </a>

                    <div>

                        <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="class-toggle"
                            data-target="#sidebar-style-toggler" data-class="fa-toggle-off fa-toggle-on"
                            onclick="Dashmix.layout('sidebar_style_toggle');Dashmix.layout('header_style_toggle');">
                            <i class="fa fa-toggle-off" id="sidebar-style-toggler"></i>
                        </button>

                        <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="class-toggle"
                            data-target="#dark-mode-toggler" data-class="far fa"
                            onclick="Dashmix.layout('dark_mode_toggle');">
                            <i class="far fa-moon" id="dark-mode-toggler"></i>
                        </button>

                        <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none" data-toggle="layout"
                            data-action="sidebar_close">
                            <i class="fa fa-times-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="js-sidebar-scroll">
                <div class="content-side">
                    <ul class="nav-main">
                        <li class="nav-main-item">
                            <a class="nav-main-link active" href="{{ route('dashboard.index') }}">
                                <i class="nav-main-link-icon fa fa-location-arrow"></i>
                                <span class="nav-main-link-name">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-main-heading">Party Management</li>
                        <li class="nav-main-item">
                            <a class="nav-main-link " href="{{ route('party.index') }}">
                                <i class="nav-main-link-icon fa fa-location-arrow"></i>
                                <span class="nav-main-link-name">Manage Party</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link " href="{{ route('party.create') }}">
                                <i class="nav-main-link-icon fa fa-location-arrow"></i>
                                <span class="nav-main-link-name">Add new Party</span>
                            </a>
                        </li>
                        <li class="nav-main-heading">Product Management</li>
                        <li class="nav-main-item">
                            <a class="nav-main-link " href="{{ route('product.index') }}">
                                <i class="nav-main-link-icon fa fa-location-arrow"></i>
                                <span class="nav-main-link-name">All Products</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link " href="{{ route('product.create') }}">
                                <i class="nav-main-link-icon fa fa-location-arrow"></i>
                                <span class="nav-main-link-name">Add new Product</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link " href="{{ route('plai.index') }}">
                                <i class="nav-main-link-icon fa fa-location-arrow"></i>
                                <span class="nav-main-link-name">All Plais</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link " href="{{ route('plai.create') }}">
                                <i class="nav-main-link-icon fa fa-location-arrow"></i>
                                <span class="nav-main-link-name">Add new Plai</span>
                            </a>
                        </li>
                        <li class="nav-main-heading">Quotation Management</li>
                        <li class="nav-main-item">
                            <a class="nav-main-link " href="{{ route('quotation.index') }}">
                                <i class="nav-main-link-icon fa fa-location-arrow"></i>
                                <span class="nav-main-link-name">All Quotation</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link " href="{{ route('quotation.create') }}">
                                <i class="nav-main-link-icon fa fa-location-arrow"></i>
                                <span class="nav-main-link-name">Add new Quotation</span>
                            </a>
                        </li>
                        <li class="nav-main-heading">Invoice Management</li>
                        <li class="nav-main-item">
                            <a class="nav-main-link " href="{{ route('invoice.index') }}">
                                <i class="nav-main-link-icon fa fa-location-arrow"></i>
                                <span class="nav-main-link-name">All Invoices</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link " href="{{ route('invoice.create') }}">
                                <i class="nav-main-link-icon fa fa-location-arrow"></i>
                                <span class="nav-main-link-name">Add new Invoices</span>
                            </a>
                        </li>
                        <li class="nav-main-heading">Payment Management</li>
                        <li class="nav-main-item">
                            <a class="nav-main-link " href="{{ route('payment.index') }}">
                                <i class="nav-main-link-icon fa fa-location-arrow"></i>
                                <span class="nav-main-link-name">All Payments</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link " href="{{ route('payment.create') }}">
                                <i class="nav-main-link-icon fa fa-location-arrow"></i>
                                <span class="nav-main-link-name">Add new Payments</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <header id="page-header">
            <div class="content-header">
                <div class="space-x-1">
                    <button type="button" class="btn btn-alt-secondary" data-toggle="layout"
                        data-action="sidebar_toggle">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>
                <div class="space-x-1">
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn btn-alt-secondary" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-fw fa-user d-sm-none"></i>
                            <span class="d-none d-sm-inline-block">Admin</span>
                            <i class="fa fa-fw fa-angle-down opacity-50 ms-1 d-none d-sm-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="page-header-user-dropdown">
                            <div class="bg-primary-dark rounded-top fw-semibold text-white text-center p-3">
                                User Options
                            </div>
                            <div class="p-2">
                                <a class="dropdown-item" href="{{ route('invoice.index') }}">
                                    <i class="far fa-fw fa-file-alt me-1"></i> Invoices
                                </a>
                                <div role="separator" class="dropdown-divider"></div>

                                <div role="separator" class="dropdown-divider"></div>
                                <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
                                <a class="dropdown-item" href="#" id="logoutLink">
                                    <i class="far fa-fw fa-arrow-alt-circle-left me-1"></i> Sign Out
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn btn-alt-secondary" id="page-header-notifications-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-fw fa-bell"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="bg-primary-dark rounded-top fw-semibold text-white text-center p-3">
                                Notifications
                            </div>
                            <ul class="nav-items my-2">
                                @forelse (auth()->user()->notifications()->take(5) as $notification)
                                    <li class="px-2">
                                        <a class=""
                                            href="{{ $notification->redirect_url ? $notification->redirect_url : '#' }}">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <i class="fa fa-fw fa-check-circle text-success"></i>
                                                </div>
                                                <div class="flex-grow-1 ps-3">
                                                    <div class="fw-semibold">{{ $notification->title }}</div>
                                                    <div>{{ $notification->created_at->diffForHumans() }}</div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @empty
                                    <li class="px-2">
                                        <a class="" href="javascript:void(0)">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <i class="fa fa-fw fa-info-circle text-secondary"></i>
                                                </div>
                                                <div class="flex-grow-1 ps-3">
                                                    <div class="fw-semibold">No Notification Found</div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforelse
                            </ul>
                            <div class="p-2 border-top">
                                <a class="btn btn-alt-primary w-100 text-center" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-eye opacity-50 me-1"></i> View All
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="page-header-search" class="overlay-header bg-header-dark">
                <div class="bg-white-10">
                    <div class="content-header">
                        <form class="w-100" action="be_pages_generic_search.html" method="POST">
                            <div class="input-group">
                                <button type="button" class="btn btn-alt-primary" data-toggle="layout"
                                    data-action="header_search_off">
                                    <i class="fa fa-fw fa-times-circle"></i>
                                </button>
                                <input type="text" class="form-control border-0" placeholder="Search or hit ESC.."
                                    id="page-header-search-input" name="page-header-search-input">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="page-header-loader" class="overlay-header bg-header-dark">
                <div class="bg-white-10">
                    <div class="content-header">
                        <div class="w-100 text-center">
                            <i class="fa fa-fw fa-sun fa-spin text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main id="main-container">
            <div class="content">
                <div
                    class="d-md-flex justify-content-md-between align-items-md-center py-3 pt-md-3 pb-md-0 text-center text-md-start">
                    <div>
                        <h1 class="h3 mb-1">
                            Welcome {{ auth()->user()->name }}!
                        </h1>
                    </div>

                </div>
            </div>

            <div class="content">
                @yield('content')
            </div>

        </main>
        <footer id="page-footer" class="bg-body-light">
            <div class="content py-0">
                <div class="row fs-sm">
                    <div class="col-sm-6 order-sm-2 mb-1 mb-sm-0 text-center text-sm-end">
                        Crafted with <i class="fa fa-heart text-danger"></i> by <a href="https://asanwebs.com"
                            target="_blank" class="opacity-75">ASANWEBS</a></div>
                    <div class="col-sm-6 order-sm-1 text-center text-sm-start">
                        {{ env('APP_NAME') }} &copy; <span data-toggle="year-copy"></span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="/assets/js/dashmix.app.min.js"></script>
    <script src="/assets/js/lib/jquery.min.js"></script>
    <script src="/assets/js/plugins/chart.js/chart.min.js"></script>
    <script src="/assets/js/pages/be_pages_dashboard.min.js"></script>
    <script src="/assets/js/custom.js"></script>
    <x-alert />
    @livewireScripts()
</body>

</html>
