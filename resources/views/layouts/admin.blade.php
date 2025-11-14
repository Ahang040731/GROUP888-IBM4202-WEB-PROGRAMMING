<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            {{-- Navigation Links --}}
            <a href="{{ route('admin.homepage') }}" class="{{ request()->routeIs('admin.homepage') ? 'active' : '' }}">🏠 Dashboard</a>
            <a href="{{ route('admin.books.index') }}" class="{{ request()->routeIs('admin.books.index') ? 'active' : '' }}">📚 Manage Books</a>
            <a href="{{ route('admin.borrows.index') }}" class="{{ request()->routeIs('admin.borrows.index') ? 'active' : '' }}">🔄 Borrow Management</a>
            <a href="{{ route('admin.borrowhistorymanagement.index') }}" class="{{ request()->routeIs('admin.borrowhistorymanagement.index') ? 'active' : '' }}">📖 Borrow History</a>
            <a href="{{ route('admin.fines.index') }}" class="{{ request()->routeIs('admin.fines.index') ? 'active' : '' }}">💰 Fines Management</a>
            <a href="{{ route('admin.usermanagement.index') }}" class="{{ request()->routeIs('admin.usermanagement.index') ? 'active' : '' }}">👥 Manage Users</a>
            <a href="{{ route('admin.profile.index') }}" class="{{ request()->routeIs('admin.profile.index') ? 'active' : '' }}">👤 Profile</a>
            <hr style="border-color: #475569;">
            
            {{-- Logout Form --}}
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="sidebar-logout-btn">
                    🚪 Logout
                </button>
            </form>
        </div>

    <style>
    .sidebar-logout-btn {
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        text-align: left;
        width: 100%;
        display: block;
        text-decoration: none;
        transition: all 0.3s ease;
        border-radius: 0.5rem;
    }

    .sidebar-logout-btn:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateX(5px);
    }

    /* Match your sidebar link styles */
    .sidebar a,
    .sidebar-logout-btn {
        color: #e2e8f0;
        display: block;
        padding: 0.75rem 1rem;
        margin-bottom: 0.5rem;
        text-decoration: none;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }

    .sidebar a:hover,
    .sidebar-logout-btn:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateX(5px);
    }

    .sidebar a.active {
        background-color: rgba(255, 255, 255, 0.2);
        font-weight: 600;
    }
    </style>
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

    @stack('scripts')
</body>
</html>
