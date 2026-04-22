<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Rice Sales Management') - Laravel</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f4f6f9;
        }
        .sidebar {
            background-color: #2c3e50;
            color: white;
            min-height: 100vh;
            padding-top: 20px;
        }
        .sidebar a {
            color: #ecf0f1;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background-color: #34495e;
            padding-left: 30px;
        }
        .sidebar .nav-title {
            color: #95a5a6;
            font-weight: bold;
            padding: 15px 20px;
            margin-top: 20px;
            font-size: 12px;
            text-transform: uppercase;
        }
        .container-main {
            padding: 20px;
            min-height: 100vh;
        }
        .navbar-custom {
            background-color: #34495e;
        }
        .navbar-custom .navbar-brand, 
        .navbar-custom .nav-link {
            color: #ecf0f1 !important;
        }
        .navbar-custom .nav-link:hover {
            color: #f39c12 !important;
        }
        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .table thead {
            background-color: #34495e;
            color: white;
        }
        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }
        .btn-primary:hover {
            background-color: #2980b9;
        }
        .btn-warning {
            background-color: #f39c12;
            border-color: #f39c12;
        }
        .btn-danger {
            background-color: #e74c3c;
            border-color: #e74c3c;
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>

    @yield('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @if(Auth::check())
                <div class="col-md-2 sidebar">
                    <div class="p-3 border-bottom mb-3">
                        <h5 class="text-white mb-0">{{ Auth::user()->name }}</h5>
                        <small class="text-muted">Administrator</small>
                    </div>

                    <div class="nav-title">Main Menu</div>
                    <a href="{{ route('dashboard') }}">Dashboard</a>

                    <div class="nav-title">Management</div>
                    <a href="{{ route('rice.index') }}">Rice Products</a>
                    <a href="{{ route('order.index') }}">Orders</a>
                    <a href="{{ route('payment.index') }}">Payments</a>

                    <div class="nav-title">Account</div>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-link text-danger w-100 text-start" style="padding: 12px 20px;">
                         Logout
                        </button>
                    </form>
                </div>
            @endif

            <!-- Main Content -->
            <div class="@if(Auth::check()) col-md-10 @else col-md-12 @endif">
                @if(Auth::check())
                    <nav class="navbar navbar-expand navbar-custom mb-4">
                        <div class="container-fluid">
                            <span class="navbar-brand mb-0 h1"> Rice Sales Management System</span>
                        </div>
                    </nav>
                @endif

                <div class="container-main">
                    <!-- Success Message -->
                    @if($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>✓ Success!</strong> {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Error Message -->
                    @if($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>✗ Error!</strong> {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Validation Errors -->
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>⚠ Validation Errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Page Content -->
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
