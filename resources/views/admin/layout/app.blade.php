<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Əsas səhifə')</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/css/timing.css') }}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{ asset('admin/global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{ asset('admin/global_assets/js/plugins/visualization/d3/d3.min.js') }}"></script>
    <script src="{{ asset('admin/global_assets/js/plugins/visualization/d3/d3_tooltip.js') }}"></script>
    <script src="{{ asset('admin/global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('admin/global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>
    <script src="{{ asset('admin/global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js') }}"></script>

    <script src="{{ asset('admin/global_assets/js/plugins/notifications/sweet_alert.min.js') }}"></script>
    <script src="{{ asset('admin/global_assets/js/plugins/sliders/ion_rangeslider.min.js') }}"></script>
    <script src="{{ asset('admin/global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>

    <script src="{{ asset('admin/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
    <script src="{{ asset('admin/global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>

    <script src="{{ asset('admin/assets/js/timing.js') }}"></script>
    <script src="{{ asset('admin/assets/js/app.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom.js') }}"></script>

    <!-- /theme JS files -->
    <style>
        .width-100 {
            width: 200px !important;
        }
    </style>
</head>

<body>

<!-- Main navbar -->
<div class="navbar navbar-expand-lg navbar-dark navbar-static">
    <div class="d-flex flex-1 d-lg-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-paragraph-justify3"></i>
        </button>
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-transmission"></i>
        </button>
    </div>

    <div class="navbar-brand text-center text-lg-left">
    </div>

    <div class="collapse navbar-collapse order-2 order-lg-1" id="navbar-mobile">
        <span class="badge badge-success my-3 my-lg-0 ml-lg-3">{{ date('d M Y') }}</span>
    </div>

    <ul class="navbar-nav flex-row order-1 order-lg-2 flex-1 flex-lg-0 justify-content-end align-items-center">


        <li class="nav-item nav-item-dropdown-lg dropdown dropdown-user h-100">
            <a href="#" class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle d-inline-flex align-items-center h-100" data-toggle="dropdown">
                <img src="{{ auth()->user()->photo ? asset('storage/'.auth()->user()->photo) : asset('admin/global_assets/images/placeholders/placeholder.jpg') }}" class="rounded-pill mr-lg-2" height="34" alt="">
                <span class="d-none d-lg-inline-block">{{ auth()->user()->name }}</span>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('user.edit', auth()->user()->id) }}" class="dropdown-item"><i class="icon-cog5"></i> Profil</a>
                <a href="{{ route('logout') }}" class="dropdown-item"><i class="icon-switch2"></i> Çıxış</a>
            </div>
        </li>
    </ul>
</div>
<!-- /main navbar -->


<!-- Page content -->
<div class="page-content">


    <!-- Main sidebar -->
    <div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg sidebar-main-resized">

        <!-- Sidebar content -->
        <div class="sidebar-content">

            <!-- Main navigation -->
            <div class="sidebar-section">
                <ul class="nav nav-sidebar" data-nav-type="accordion">
                    <!-- Main -->

                    <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard')  ? 'active' : ''}}"><i class="icon-home"></i> <span>Əsas səhifə</span></a></li>

                    @can('role-list')
                        <li class="nav-item"><a href="{{ route('role.index') }}" class="nav-link"><i class="icon-image4"></i> <span>Rollar</span></a></li>
                    @endcan

                    @can('user-list')
                    <li class="nav-item"><a href="{{ route('user.index') }}" class="nav-link {{ request()->routeIs('user.*')  ? 'active' : ''}}"><i class="icon-user-tie"></i> <span>İstifadəçilər</span></a></li>
                    @endcan

                    @can('order-list')
                        <li class="nav-item"><a href="{{ route('order.index') }}" class="nav-link {{ request()->routeIs('order.*')  ? 'active' : ''}}"><i class="icon-cart"></i> <span>Sifariş</span></a></li>
                    @endcan

                    @can('package-list')
                        <li class="nav-item"><a href="{{ route('package.index') }}" class="nav-link {{ request()->routeIs('package.*')  ? 'active' : ''}}"><i class="icon-cube2"></i> <span>Qablaşdırma</span></a></li>
                    @endcan

                    @can('experiment-list')
                        <li class="nav-item"><a href="{{ route('experiment.index') }}" class="nav-link {{ request()->routeIs('experiment.*')  ? 'active' : ''}}"><i class="icon-lab"></i> <span>Nümunədə aparılacaq sınaqlar</span></a></li>
                    @endcan

                    @can('log-list')
                        <li class="nav-item"><a href="{{ route('log.index') }}" class="nav-link {{ request()->routeIs('log.*')  ? 'active' : ''}}"><i class="icon-file-text"></i> <span>Loqlar</span></a></li>
                    @endcan




                <!-- /page kits -->
                </ul>
            </div>
            <!-- /main navigation -->

        </div>
        <!-- /sidebar content -->

    </div>
    <!-- /main sidebar -->


    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Inner content -->
        <div class="content-inner">

            <!-- Page header -->
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-lg-inline">
                    <div class="page-title d-flex">
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Medical</span> - @yield('title', 'Əsas səhifə')</h4>
                        <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
                    </div>


                </div>

                <div class="breadcrumb-line breadcrumb-line-light header-elements-lg-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Medical</a>

                            @hasSection('module')
                                <span class="breadcrumb-item">@yield('module')</span>
                            @endif
                            <span class="breadcrumb-item active">@yield('title', 'Əsas səhifə')</span>
                        </div>

                        <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
                    </div>


                </div>
            </div>
            <!-- /page header -->

            @yield('content')

            <!-- Footer -->
            <div class="navbar navbar-expand-lg navbar-light border-bottom-0 border-top">
                <div class="text-center d-lg-none w-100">
                    <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
                        <i class="icon-unfold mr-2"></i>
                        Footer
                    </button>
                </div>

                <div class="navbar-collapse collapse" id="navbar-footer">
                    <span class="navbar-text">
                        &copy; {{ date('Y') }}. <a href="https://najafzade.com">Kamran Najafzade</a>
                    </span>
                </div>
            </div>
            <!-- /footer -->
        </div>
        <!-- /inner content -->
    </div>
    <!-- /main content -->
</div>
<!-- /page content -->
</body>
</html>
