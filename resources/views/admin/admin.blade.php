<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Aseel E-comm</title>

    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 sidebar">
            <h4 class="text-center text-white">Admin Panel</h4>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Home</a>
            <a href="{{ route('admin.categories.create') }}" class="{{ request()->routeIs('admin.categories.create') ? 'active' : '' }}"><i class="fas fa-folder-plus"></i> Add Category </a>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.index') ? 'active' : '' }}"><i class="fas fa-edit"></i> Edit Category</a>
            <a href="{{ route('products.add') }}" class="{{ request()->routeIs('products.add') ? 'active' : '' }}"><i class="fas fa-plus-circle"></i> Add Product</a>
            <a href="{{ route('admin.products') }}" class="{{ request()->routeIs('admin.products') ? 'active' : '' }}"><i class="fas fa-edit"></i> Edit Product</a>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.index') ? 'active' : '' }}"><i class="fas fa-shopping-cart"></i> View Orders</a>
            <a href="{{ route('admin.contact') }}" class="{{ request()->routeIs('admin.contact') ? 'active' : '' }}"><i class="fas fa-envelope"></i> View Requests</a>
            <form action="{{ route('logout') }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-danger w-100"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </nav>

        <main class="col-md-10 content">
            @yield('content')
        </main>
    </div>
</div>

<script src="{{ asset('assets/js/jquery-1.11.3.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>
