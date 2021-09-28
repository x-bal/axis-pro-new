<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @auth
    @if(auth()->user()->hasRole('admin'))
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @else
    <link href="{{ asset('css/adjuster.css') }}" rel="stylesheet">
    @endif
    @else
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @endauth

    <link rel="stylesheet" href="{{ asset('/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/jquery.dataTables.min.css') }}">
    <link href="{{ asset('/css/select2.min.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-sm navbar-dark bg-primary shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/dashboard') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item {{ request()->is('dashboard*') ? 'active' : '' }}">
                            <a href="/dashboard" class="nav-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                        </li>
                        @can('insurance-access')
                        <li class="nav-item {{ request()->is('insurance*') ? 'active' : '' }}">
                            <a href="{{ route('insurance.index') }}" class="nav-link"><i class="fas fa-comments"></i> Insurance</a>
                        </li>
                        @endcan
                        @can('case-list-access')
                        <li class="nav-item {{ request()->is('case-list*') ? 'active' : '' }}">
                            <a href="{{ route('case-list.index') }}" class="nav-link"><i class="fas fa-list-alt"></i> Case List</a>
                        </li>
                        @endcan
                        @can('invoice-access')
                        <li class="nav-item {{ request()->is('invoice*') ? 'active' : '' }}">
                            <a href="{{ route('invoice.index') }}" class="nav-link"><i class="fas fa-chart-bar"></i> Invoice</a>
                        </li>
                        @endcan
                        @can('master-access')
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link {{ request()->is('cause-of-loss*') ? 'active' : '' }} {{ request()->is('type-of-business*') ? 'active' : '' }} {{ request()->is('broker*') ? 'active' : '' }} {{ request()->is('fee-based*') ? 'active' : '' }} {{ request()->is('bank*') ? 'active' : '' }} dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-cog"></i> Master
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @can('cause-of-loss-access')
                                <a class="dropdown-item {{ request()->is('cause-of-loss*') ? 'active' : '' }}" href="{{ route('cause-of-loss.index') }}">Cause Of Loss</a>
                                @endcan
                                @can('type-of-business-access')
                                <a class="dropdown-item {{ request()->is('type-of-business*') ? 'active' : '' }}" href="{{ route('type-of-business.index') }}">Type Of Business</a>
                                @endcan
                                @can('broker-access')
                                <a class="dropdown-item {{ request()->is('broker*') ? 'active' : '' }}" href="{{ route('broker.index') }}">Broker</a>
                                @endcan
                                @can('fee-based-access')
                                <a class="dropdown-item {{ request()->is('fee-based*') ? 'active' : '' }}" href="{{ route('fee-based.index') }}">Fee Based</a>
                                @endcan
                                @can('bank-access')
                                <a class="dropdown-item {{ request()->is('bank*') ? 'active' : '' }}" href="{{ route('bank.index') }}">Bank List</a>
                                @endcan
                            </div>
                        </li>
                        @endcan
                        @can('user-access')
                        <li class="nav-item {{ request()->is('users*') ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}" class="nav-link"><i class="fas fa-users"></i> User</a>
                        </li>
                        @endcan
                        @can('group-access')
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link {{ request()->is('roles*') ? 'active' : '' }} {{ request()->is('permission*') ? 'active' : '' }} dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-cogs"></i> Group
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @can('role-access')
                                <a class="dropdown-item {{ request()->is('roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">Roles</a>
                                @endcan
                                @can('permission-access')
                                <a class="dropdown-item {{ request()->is('permission*') ? 'active' : '' }}" href="{{ route('permission.index') }}">Permission</a>
                                @endcan
                            </div>
                        </li>
                        @endcan
                    </ul>
                    @endauth
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest

                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link active dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->nama_lengkap }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    {{ __('Profile') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="{{ asset('/js/select2.full.min.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap4.min.js"></script>

    <!-- <script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script> -->
    <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @yield('footer')

    @if(session('success'))
    <script>
        iziToast.success({
            title: 'Success',
            message: '{{ session("success") }}',
            position: 'topRight',
        });
    </script>
    @endif
    @if(session('error'))
    <script>
        iziToast.error({
            title: 'Error',
            message: '{{ session("error") }}',
            position: 'topRight',
        });
    </script>
    @endif
</body>

</html>