<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8fafc;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #1E293B;
            color: white;
            padding-top: 30px;
        }
        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #334155;
            color: #fff;
        }
        .main-content {
            padding: 30px;
        }
        .navbar {
            background-color: #fff;
            border-bottom: 1px solid #e5e7eb;
        }
        .card-hover:hover {
            transform: translateY(-3px);
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="d-flex">
        {{-- Sidebar --}}
        <div class="sidebar p-3">
            <h4 class="text-center mb-4">📘 Admin Panel</h4>

            {{-- ✅ 用你的 route 名称 --}}
            <a href="{{ route('admin.homepage') }}" class="{{ request()->routeIs('admin.homepage') ? 'active' : '' }}">🏠 Dashboard</a>
            <a href="{{ route('admin.books.index') }}">📚 Manage Books</a>
            <a href="{{ route('admin.borrows.index') }}">🔄 Borrow Management</a>
            <a href="{{ route('admin.borrowhistorymanagement.index') }}">📖 Borrow History</a>
            <a href="{{ route('admin.usermanagement.index') }}">👥 Manage Users</a>
            <a href="{{ route('admin.profile.index') }}">👤 Profile</a>
            <hr style="border-color: #475569;">
            <a href="{{ route('logout') }}">🚪 Logout</a>
        </div>

        {{-- Main Content --}}
        <div class="flex-grow-1">
            <nav class="navbar navbar-light px-4 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">@yield('title')</h5>
                <span class="text-muted">Welcome, Admin 👋</span>
            </nav>
            <div class="main-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
