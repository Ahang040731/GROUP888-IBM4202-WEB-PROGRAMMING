<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title', 'Dashboard') - Library System</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <style>
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
      width: 10px;
      height: 10px;
    }
    
    ::-webkit-scrollbar-track {
      background: #f1f5f9;
    }
    
    ::-webkit-scrollbar-thumb {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-radius: 5px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(135deg, #5568d3 0%, #6a3f8f 100%);
    }

    /* Alpine Cloak */
    [x-cloak] { 
      display: none !important; 
    }

    /* Header Styles */
    .header-gradient {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
    }

    /* Sidebar Styles */
    .sidebar {
      background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
    }

    .nav-link {
      position: relative;
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 16px;
      border-radius: 12px;
      color: #475569;
      font-weight: 500;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      overflow: hidden;
    }

    .nav-link::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 4px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      transform: scaleY(0);
      transition: transform 0.3s ease;
    }

    .nav-link:hover {
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
      color: #667eea;
      transform: translateX(4px);
    }

    .nav-link:hover::before {
      transform: scaleY(1);
    }

    .nav-link.active {
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
      color: #667eea;
      font-weight: 600;
    }

    .nav-link.active::before {
      transform: scaleY(1);
    }

    .nav-icon {
      font-size: 1.5rem;
      transition: transform 0.3s ease;
    }

    .nav-link:hover .nav-icon {
      transform: scale(1.2);
    }

    /* Credit Card Styles */
    .credit-card {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-radius: 16px;
      padding: 20px;
      margin: 16px;
      color: white;
      box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
      position: relative;
      overflow: hidden;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .credit-card::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
      animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
      0%, 100% {
        transform: translate(0, 0);
      }
      50% {
        transform: translate(-20%, -20%);
      }
    }

    .credit-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
    }

    a:has(.credit-card) {
      text-decoration: none;
    }

    .credit-label {
      font-size: 0.75rem;
      opacity: 0.9;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 8px;
    }

    .credit-amount {
      font-size: 2rem;
      font-weight: 700;
      display: flex;
      align-items: baseline;
      gap: 4px;
    }

    .credit-currency {
      font-size: 1.25rem;
      font-weight: 600;
    }

    .credit-icon {
      position: absolute;
      bottom: 16px;
      right: 16px;
      opacity: 0.3;
      font-size: 3rem;
    }

    .topup-btn {
      margin-top: 12px;
      padding: 8px 16px;
      background: rgba(255, 255, 255, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.3);
      border-radius: 8px;
      color: white;
      font-size: 0.875rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      backdrop-filter: blur(10px);
    }

    .topup-btn:hover {
      background: rgba(255, 255, 255, 0.3);
      transform: translateY(-2px);
    }

    /* Mobile Menu Animation */
    .mobile-menu-enter {
      animation: slideInLeft 0.3s ease-out;
    }

    .mobile-menu-overlay {
      animation: fadeIn 0.3s ease-out;
    }

    @keyframes slideInLeft {
      from {
        transform: translateX(-100%);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    /* Button Styles */
    .btn-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 10px 24px;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      border: none;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-primary:active {
      transform: translateY(0);
    }

    /* User Menu Dropdown */
    .user-menu {
      position: relative;
    }

    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3);
    }

    .user-avatar:hover {
      transform: scale(1.1);
      box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
    }

    .dropdown-menu {
      position: absolute;
      top: 100%;
      right: 0;
      margin-top: 12px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
      min-width: 200px;
      overflow: hidden;
      animation: dropdownFade 0.3s ease-out;
    }

    @keyframes dropdownFade {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .dropdown-item {
      padding: 12px 16px;
      color: #475569;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: all 0.2s ease;
      cursor: pointer;
    }

    .dropdown-item:hover {
      background: #f8fafc;
      color: #667eea;
    }

    /* Badge Styles */
    .badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 600;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      margin-left: auto;
    }

    /* Loading Spinner */
    .loading-spinner {
      display: inline-block;
      width: 20px;
      height: 20px;
      border: 3px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      border-top-color: white;
      animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    /* Main Content Area */
    .main-content {
      padding: 0%;
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.95) 0%, rgba(118, 75, 162, 0.95) 100%);
      min-height: calc(100vh - 72px);
      animation: fadeInUp 0.5s ease-out;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Notification Badge */
    .notification-badge {
      position: absolute;
      top: -4px;
      right: -4px;
      background: #ef4444;
      color: white;
      font-size: 0.65rem;
      font-weight: 700;
      padding: 2px 6px;
      border-radius: 10px;
      border: 2px solid white;
    }

    /* Mobile Menu Button */
    .menu-btn {
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 10px;
      transition: all 0.3s ease;
      background: rgba(255, 255, 255, 0.2);
    }

    .menu-btn:hover {
      background: rgba(255, 255, 255, 0.3);
      transform: scale(1.05);
    }

    /* Logo Animation */
    .logo {
      font-size: 1.5rem;
      font-weight: 700;
      color: white;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: all 0.3s ease;
    }

    .logo:hover {
      transform: scale(1.05);
    }

    .logo-icon {
      animation: bounce 2s infinite;
    }

    @keyframes bounce {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-5px);
      }
    }

    /* Cart Button Styles */
    .cart-btn {
      position: relative;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 10px;
      transition: all 0.3s ease;
      background: rgba(255, 255, 255, 0.2);
    }

    .cart-btn:hover {
      background: rgba(255, 255, 255, 0.3);
      transform: scale(1.05);
    }

    .cart-badge {
      position: absolute;
      top: -4px;
      right: -4px;
      background: #ef4444;
      color: white;
      font-size: 0.65rem;
      font-weight: 700;
      padding: 2px 6px;
      min-width: 18px;
      height: 18px;
      border-radius: 10px;
      border: 2px solid #667eea;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Notification Dropdown Styles */
    .notification-dropdown {
      position: absolute;
      top: calc(100% + 12px);
      right: 0;
      width: 420px;
      max-height: 600px;
      background: white;
      border-radius: 16px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
      overflow: hidden;
      z-index: 1000;
    }

    .notif-header {
      padding: 16px 20px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .notif-title {
      font-size: 1.125rem;
      font-weight: 700;
    }

    .notif-count-badge {
      background: rgba(255, 255, 255, 0.3);
      padding: 4px 10px;
      border-radius: 12px;
      font-size: 0.75rem;
      font-weight: 700;
    }

    .notif-list {
      max-height: 500px;
      overflow-y: auto;
    }

    /* Notification Section Labels */
    .notif-section-label {
      padding: 8px 20px;
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      background: #f9fafb;
      color: #6b7280;
      border-top: 1px solid #e5e7eb;
      position: sticky;
      top: 0;
      z-index: 10;
    }

    .notif-section-label.urgent {
      background: #fef2f2;
      color: #dc2626;
    }

    .notif-section-label.warning {
      background: #fffbeb;
      color: #d97706;
    }

    .notif-section-label.due-soon {
      background: #fef3c7;
      color: #f59e0b;
    }

    .notif-section-label.info {
      background: #eff6ff;
      color: #2563eb;
    }

    .notif-section-label.success {
      background: #f0fdf4;
      color: #16a34a;
    }

    .notif-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 20px;
      border-bottom: 1px solid #f3f4f6;
      transition: all 0.2s ease;
      text-decoration: none;
      color: inherit;
    }

    .notif-item:hover {
      background: #f9fafb;
      transform: translateX(4px);
    }

    .notif-item.urgent:hover {
      background: #fef2f2;
    }

    .notif-item.warning:hover {
      background: #fffbeb;
    }

    .notif-item.due-soon:hover {
      background: #fef3c7;
    }

    .notif-item.info:hover {
      background: #eff6ff;
    }

    .notif-item.success:hover {
      background: #f0fdf4;
    }

    .notif-icon {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.125rem;
      flex-shrink: 0;
    }

    .notif-icon.urgent {
      background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    }

    .notif-icon.warning {
      background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    }

    .notif-icon.due-soon {
      background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    }

    .notif-icon.info {
      background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    }

    .notif-icon.success {
      background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    }

    .notif-content {
      flex: 1;
      min-width: 0;
    }

    .notif-text {
      font-size: 0.875rem;
      color: #1f2937;
      margin-bottom: 4px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .notif-subtext {
      font-size: 0.75rem;
      color: #6b7280;
    }

    .notif-arrow {
      margin-left: auto;
      color: #9ca3af;
      font-size: 1.25rem;
      font-weight: 300;
      flex-shrink: 0;
    }

    .notif-view-all {
      display: block;
      padding: 14px 20px;
      text-align: center;
      background: #f9fafb;
      color: #667eea;
      font-weight: 600;
      font-size: 0.875rem;
      text-decoration: none;
      transition: all 0.2s ease;
      border-top: 1px solid #e5e7eb;
    }

    .notif-view-all:hover {
      background: #f3f4f6;
      color: #764ba2;
    }

    .notif-empty {
      padding: 40px 20px;
      text-align: center;
    }

    .notif-empty-icon {
      font-size: 3rem;
      margin-bottom: 12px;
    }

    .notif-empty-text {
      font-size: 1rem;
      font-weight: 600;
      color: #1f2937;
      margin-bottom: 4px;
    }

    .notif-empty-subtext {
      font-size: 0.875rem;
      color: #6b7280;
    }

    /* Mobile Notification Dropdown */
    .notification-dropdown-mobile {
      position: absolute;
      top: calc(100% + 12px);
      right: 0;
      width: 280px;
      background: white;
      border-radius: 16px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
      overflow: hidden;
      z-index: 1000;
    }

    .notif-mobile-quick {
      padding: 12px;
    }

    .notif-mobile-link {
      display: block;
      padding: 12px;
      text-align: center;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      font-weight: 600;
      font-size: 0.875rem;
      text-decoration: none;
      border-radius: 10px;
      transition: all 0.2s ease;
    }

    .notif-mobile-link:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased" x-data="{ 
  sidebarOpen: false, 
  userMenuOpen: false,
  notifications: 3,
  currentPage: '{{ Route::currentRouteName() ?? 'dashboard' }}'
}">
  
  <!-- Header -->
  <header class="sticky top-0 z-50 header-gradient">
    <div class="max-w-screen-2xl mx-auto px-4 lg:px-6 h-16 flex items-center justify-between">
      <!-- Left Section -->
      <div class="flex items-center gap-4">
        <!-- Mobile Menu Button -->
        <button class="md:hidden menu-btn"
                @click="sidebarOpen = !sidebarOpen" 
                aria-label="Toggle sidebar">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
        
        <!-- Logo -->
        <a href="{{ url('/') }}" class="logo">
          <span class="logo-icon">📚</span>
          <span class="hidden sm:inline">Library System</span>
        </a>
      </div>

      <!-- Right Section -->
      <div class="flex items-center gap-4">
        <!-- Notifications (Mobile) -->
        @auth
        <div class="relative md:hidden" x-data="{ notifOpen: false }" @click.away="notifOpen = false">
          @php
            $mobileNotifCount = 0;
            if (auth()->user()->user) {
              $userId = auth()->user()->user->id;
              $mobileNotifCount = \App\Models\Fine::where('user_id', $userId)->whereIn('status', ['unpaid', 'pending'])->count() +
                                 \App\Models\BorrowHistory::where('user_id', $userId)->whereNull('returned_at')->where('approve_status', 'approved')->where('status', 'overdue')->count() +
                                 \App\Models\BorrowHistory::where('user_id', $userId)->where('approve_status', 'pending')->count();
            }
          @endphp
          <button class="menu-btn relative" @click="notifOpen = !notifOpen">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" 
                 viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            @if($mobileNotifCount > 0)
              <span class="notification-badge">{{ $mobileNotifCount }}</span>
            @endif
          </button>

          <!-- Mobile Notification Dropdown -->
          <div x-show="notifOpen" 
               x-cloak
               class="notification-dropdown-mobile">
            <div class="notif-header">
              <h3 class="notif-title">Notifications</h3>
              @if($mobileNotifCount > 0)
                <span class="notif-count-badge">{{ $mobileNotifCount }}</span>
              @endif
            </div>
            <div class="notif-mobile-quick">
              <a href="{{ route('client.notifications.index') }}" class="notif-mobile-link">
                View All Notifications →
              </a>
            </div>
          </div>
        </div>
        @endauth

        <!-- Cart Button -->
        @auth
        <a href="{{ route('client.cart.index') }}" class="cart-btn relative">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" 
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
          </svg>
          @php
            $cartCount = auth()->user()->user ? auth()->user()->user->carts()->count() : 0;
          @endphp
          @if($cartCount > 0)
            <span class="cart-badge">{{ $cartCount }}</span>
          @endif
        </a>
        @endauth

        <!-- Notifications -->
        @auth
        <div class="relative hidden md:block" x-data="{ notifOpen: false }" @click.away="notifOpen = false">
          @php
            $notificationCount = 0;
            $notificationItems = [];
            if (auth()->user()->user) {
              $userId = auth()->user()->user->id;
              
              // Get ALL unpaid fines
              $unpaidFines = \App\Models\Fine::with('borrowHistory.book')
                ->where('user_id', $userId)
                ->whereIn('status', ['unpaid', 'pending'])
                ->orderByDesc('created_at')
                ->get();
              
              // Get ALL overdue books
              $overdueBooks = \App\Models\BorrowHistory::with('book')
                ->where('user_id', $userId)
                ->whereNull('returned_at')
                ->where('approve_status', 'approved')
                ->where('status', 'overdue')
                ->orderBy('due_at', 'asc')
                ->get();
              
              // Get books due in next 3 days
              $dueSoonBooks = \App\Models\BorrowHistory::with('book')
                ->where('user_id', $userId)
                ->whereNull('returned_at')
                ->where('approve_status', 'approved')
                ->where('status', 'active')
                ->whereBetween('due_at', [now(), now()->addDays(3)])
                ->orderBy('due_at', 'asc')
                ->get();
              
              // Get ALL pending requests
              $pendingRequests = \App\Models\BorrowHistory::with('book')
                ->where('user_id', $userId)
                ->where('approve_status', 'pending')
                ->orderByDesc('created_at')
                ->get();
              
              // Get recently approved (last 3 days)
              $recentlyApproved = \App\Models\BorrowHistory::with('book')
                ->where('user_id', $userId)
                ->where('approve_status', 'approved')
                ->whereNull('returned_at')
                ->where('updated_at', '>=', now()->subDays(3))
                ->orderByDesc('updated_at')
                ->limit(3)
                ->get();
              
              $notificationCount = $unpaidFines->count() + $overdueBooks->count() + $pendingRequests->count();
            }
          @endphp
          <button class="menu-btn relative" @click="notifOpen = !notifOpen">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" 
                 viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            @if($notificationCount > 0)
              <span class="notification-badge">{{ $notificationCount }}</span>
            @endif
          </button>

          <!-- Notification Dropdown -->
          <div x-show="notifOpen" 
               x-cloak
               x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="opacity-0 scale-95"
               x-transition:enter-end="opacity-100 scale-100"
               x-transition:leave="transition ease-in duration-150"
               x-transition:leave-start="opacity-100 scale-100"
               x-transition:leave-end="opacity-0 scale-95"
               class="notification-dropdown">
            
            <!-- Header -->
            <div class="notif-header">
              <h3 class="notif-title">Notifications</h3>
              @if($notificationCount > 0)
                <span class="notif-count-badge">{{ $notificationCount }}</span>
              @endif
            </div>

            <!-- Notification List -->
            <div class="notif-list">
              @if($notificationCount > 0 || isset($dueSoonBooks) && $dueSoonBooks->count() > 0 || isset($recentlyApproved) && $recentlyApproved->count() > 0)
                
                <!-- URGENT: Overdue Books -->
                @if(isset($overdueBooks) && $overdueBooks->count() > 0)
                  <div class="notif-section-label urgent">🚨 Overdue ({{ $overdueBooks->count() }})</div>
                  @foreach($overdueBooks as $borrow)
                    <a href="{{ route('client.borrowhistory.index') }}" class="notif-item urgent">
                      <div class="notif-icon urgent">📕</div>
                      <div class="notif-content">
                        <p class="notif-text"><strong>{{ \Illuminate\Support\Str::limit($borrow->book->book_name, 25) }}</strong></p>
                        <p class="notif-subtext">{{ $borrow->late_days }} day(s) overdue - Return ASAP!</p>
                      </div>
                      <div class="notif-arrow">›</div>
                    </a>
                  @endforeach
                @endif

                <!-- WARNING: Unpaid Fines -->
                @if(isset($unpaidFines) && $unpaidFines->count() > 0)
                  <div class="notif-section-label warning">💰 Unpaid Fines ({{ $unpaidFines->count() }})</div>
                  @foreach($unpaidFines as $fine)
                    <a href="{{ route('fines.index') }}" class="notif-item warning">
                      <div class="notif-icon warning">💳</div>
                      <div class="notif-content">
                        <p class="notif-text"><strong>RM {{ number_format($fine->amount, 2) }}</strong></p>
                        <p class="notif-subtext">
                          {{ $fine->borrowHistory->book->book_name ?? 'Fine Payment' }} - 
                          {{ $fine->status === 'pending' ? 'Pending approval' : 'Pay now' }}
                        </p>
                      </div>
                      <div class="notif-arrow">›</div>
                    </a>
                  @endforeach
                @endif

                <!-- INFO: Due Soon (Next 3 Days) -->
                @if(isset($dueSoonBooks) && $dueSoonBooks->count() > 0)
                  <div class="notif-section-label due-soon">⏰ Due Soon ({{ $dueSoonBooks->count() }})</div>
                  @foreach($dueSoonBooks as $borrow)
                    @php
                      $dueDate = \Carbon\Carbon::parse($borrow->due_at);
                      $daysUntilDue = now()->diffInDays($dueDate, false);
                    @endphp
                    <a href="{{ route('client.borrowhistory.index') }}" class="notif-item due-soon">
                      <div class="notif-icon due-soon">⏰</div>
                      <div class="notif-content">
                        <p class="notif-text"><strong>{{ \Illuminate\Support\Str::limit($borrow->book->book_name, 25) }}</strong></p>
                        <p class="notif-subtext">Due in {{ $daysUntilDue }} day(s) - {{ $dueDate->format('M d') }}</p>
                      </div>
                      <div class="notif-arrow">›</div>
                    </a>
                  @endforeach
                @endif

                <!-- INFO: Pending Requests -->
                @if(isset($pendingRequests) && $pendingRequests->count() > 0)
                  <div class="notif-section-label info">⏳ Pending Requests ({{ $pendingRequests->count() }})</div>
                  @foreach($pendingRequests as $request)
                    <a href="{{ route('client.borrowhistory.index') }}" class="notif-item info">
                      <div class="notif-icon info">📗</div>
                      <div class="notif-content">
                        <p class="notif-text"><strong>{{ \Illuminate\Support\Str::limit($request->book->book_name, 25) }}</strong></p>
                        <p class="notif-subtext">Awaiting admin approval</p>
                      </div>
                      <div class="notif-arrow">›</div>
                    </a>
                  @endforeach
                @endif

                <!-- SUCCESS: Recently Approved -->
                @if(isset($recentlyApproved) && $recentlyApproved->count() > 0)
                  <div class="notif-section-label success">✅ Recently Approved ({{ $recentlyApproved->count() }})</div>
                  @foreach($recentlyApproved as $approved)
                    <a href="{{ route('client.borrowhistory.index') }}" class="notif-item success">
                      <div class="notif-icon success">✅</div>
                      <div class="notif-content">
                        <p class="notif-text"><strong>{{ \Illuminate\Support\Str::limit($approved->book->book_name, 25) }}</strong></p>
                        <p class="notif-subtext">Ready to pick up!</p>
                      </div>
                      <div class="notif-arrow">›</div>
                    </a>
                  @endforeach
                @endif

                <!-- View All -->
                <a href="{{ route('client.notifications.index') }}" class="notif-view-all">
                  View All Notifications →
                </a>
              @else
                <!-- Empty State -->
                <div class="notif-empty">
                  <div class="notif-empty-icon">🎉</div>
                  <p class="notif-empty-text">You're all caught up!</p>
                  <p class="notif-empty-subtext">No new notifications</p>
                </div>
              @endif
            </div>
          </div>
        </div>
        @endauth

        <!-- User Menu -->
        <div class="user-menu" x-data="{ open: false }" @click.away="open = false">
          <div class="user-avatar" @click="open = !open">
            @php
                $account = auth()->user();
                $profile = null;
                $photoPath = null;

                if ($account) {
                    if (method_exists($account, 'isAdmin') && $account->isAdmin()) {
                        $profile = $account->admin;
                    } else {
                        $profile = $account->user;
                    }

                    $photoPath = $profile?->photo;
                }
            @endphp

            @if($account && $photoPath)
                <img src="{{ asset('storage/' . $photoPath) }}"
                    class="w-full h-full rounded-full object-cover" alt="Profile">
            @elseif($account)
                <img src="{{ asset('images/default_profile.png') }}"
                    class="w-full h-full rounded-full object-cover" alt="Default Profile">
            @else
                <span>G</span>
            @endif
        </div>

          <!-- Dropdown -->
          <div class="dropdown-menu" x-show="open" x-cloak>
            @auth
              <div class="dropdown-item border-b border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <div>
                  <div class="font-semibold text-gray-900">{{ $profile->username ?? 'Guest'}}</div>
                  <div class="text-xs text-gray-500">{{ auth()->user()->email ?? '' }}</div>
                </div>
              </div>
              <a href="{{ route('client.profile.index') ?? '#' }}" class="dropdown-item">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>Settings</span>
              </a>
              <form action="{{ route('logout') ?? '#' }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item w-full text-red-600 hover:bg-red-50">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                  </svg>
                  <span>Logout</span>
                </button>
              </form>
            @else
              <a href="{{ route('login') ?? '#' }}" class="dropdown-item">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                <span>Login</span>
              </a>
              <a href="{{ route('register') ?? '#' }}" class="dropdown-item">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                <span>Register</span>
              </a>
            @endauth
          </div>
        </div>
      </div>
    </div>
  </header>

  <div class="max-w-screen-2xl mx-auto flex">
    <!-- Sidebar (Desktop) -->
    <aside class="hidden md:block w-64 sidebar
         md:sticky md:top-16
         h-[calc(100vh-4rem)]
         overflow-y-auto
         z-40">
      
      <!-- Credit Card Display -->
      @auth
        @php
          $userCredit = auth()->user()->user?->credit ?? 0;
        @endphp
        <a href="{{ route('client.credit.index') }}" class="block">
          <div class="credit-card">
            <div class="relative z-10">
              <div class="credit-label">Your Balance</div>
              <div class="credit-amount">
                <span class="credit-currency">RM</span>
                <span>{{ number_format($userCredit, 2) }}</span>
              </div>
              <button type="button" class="topup-btn w-full" onclick="event.preventDefault(); window.location='{{ route('client.credit.topup') }}'">
                💳 Top Up Credit
              </button>
            </div>
            <div class="credit-icon">💰</div>
          </div>
        </a>
      @endauth

      <nav class="p-4 space-y-2">
        <a href="{{ url('/') }}" 
           class="nav-link"
           :class="{ 'active': currentPage.includes('homepage') }">
          <span class="nav-icon">🏠</span>
          <span>Home Page</span>
        </a>
        
        <a href="{{ route('client.books.index') ?? '#' }}" 
           class="nav-link"
           :class="{ 'active': currentPage.includes('books') }">
          <span class="nav-icon">📖</span>
          <span>Books</span>
          <span class="badge">New</span>
        </a>
        
        <a href="{{ route('client.borrowhistory.index') ?? '#' }}" 
           class="nav-link"
           :class="{ 'active': currentPage.includes('borrowhistory') }">
          <span class="nav-icon">📚</span>
          <span>Borrowed History</span>
        </a>
        
        <a href="{{ route('fines.index') ?? '#' }}" 
           class="nav-link"
           :class="{ 'active': currentPage.includes('fines') }">
          <span class="nav-icon">💰</span>
          <span>Fines</span>
        </a>
        
        <a href="{{ route('client.favourites.index') ?? '#' }}" 
           class="nav-link"
           :class="{ 'active': currentPage.includes('favourites') }">
          <span class="nav-icon">❤️</span>
          <span>Favourites</span>
        </a>

        <div class="border-t border-gray-200 my-4"></div>

        <a href="{{ route('client.profile.index') ?? '#' }}" 
           class="nav-link"
           :class="{ 'active': currentPage.includes('profile') }">
          <span class="nav-icon">👤</span>
          <span>Profile</span>
        </a>
      </nav>
    </aside>

    <!-- Sidebar (Mobile) -->
    <div class="md:hidden fixed inset-0 z-40" x-show="sidebarOpen" x-cloak>
      <div class="absolute inset-0 bg-black/50 mobile-menu-overlay" @click="sidebarOpen=false"></div>
      <aside class="absolute left-0 top-0 h-full w-80 max-w-[85vw] sidebar mobile-menu-enter overflow-y-auto">
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
          <span class="font-bold text-xl bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">Menu</span>
          <button class="p-2 rounded-lg hover:bg-gray-100 transition-colors" @click="sidebarOpen=false">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
        
        <!-- Credit Card Display (Mobile) -->
        @auth
          @php
            $userCredit = auth()->user()->user?->credit ?? 0;
          @endphp
          <a href="{{ route('client.credit.index') }}" class="block">
            <div class="credit-card">
              <div class="relative z-10">
                <div class="credit-label">Your Balance</div>
                <div class="credit-amount">
                  <span class="credit-currency">RM</span>
                  <span>{{ number_format($userCredit, 2) }}</span>
                </div>
                <button type="button" class="topup-btn w-full" onclick="event.preventDefault(); window.location='{{ route('client.credit.topup') }}'">
                  💳 Top Up Credit
                </button>
              </div>
              <div class="credit-icon">💰</div>
            </div>
          </a>
        @endauth
        
        <nav class="p-4 space-y-2">
          <a href="{{ url('/') }}" 
             class="nav-link" 
             @click="sidebarOpen=false">
            <span class="nav-icon">🏠</span>
            <span>Home Page</span>
          </a>
          
          <a href="{{ route('client.books.index') ?? '#' }}" 
             class="nav-link"
             @click="sidebarOpen=false">
            <span class="nav-icon">📖</span>
            <span>Books</span>
            <span class="badge">New</span>
          </a>
          
          <a href="{{ route('client.borrowhistory.index') ?? '#' }}" 
             class="nav-link"
             @click="sidebarOpen=false">
            <span class="nav-icon">📚</span>
            <span>Borrowed History</span>
          </a>
          
          <a href="{{ route('fines.index') ?? '#' }}" 
             class="nav-link"
             @click="sidebarOpen=false">
            <span class="nav-icon">💰</span>
            <span>Fines</span>
          </a>
          
          <a href="{{ route('client.favourites.index') ?? '#' }}" 
             class="nav-link"
             @click="sidebarOpen=false">
            <span class="nav-icon">❤️</span>
            <span>Favourites</span>
          </a>

          <div class="border-t border-gray-200 my-4"></div>

          <a href="{{ route('client.profile.index') ?? '#' }}" 
             class="nav-link"
             @click="sidebarOpen=false">
            <span class="nav-icon">👤</span>
            <span>Profile</span>
          </a>
        </nav>
      </aside>
    </div>

    <!-- Main Content -->
    <main class="flex-1 main-content p-4 lg:p-6">
      @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg animate-pulse" x-data="{ show: true }" x-show="show">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="text-green-500 hover:text-green-700">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>
      @endif

      @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg animate-pulse" x-data="{ show: true }" x-show="show">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <p class="text-red-700 font-medium">{{ session('error') }}</p>
            </div>
            <button @click="show = false" class="text-red-500 hover:text-red-700">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>
      @endif

      @yield('content')
    </main>
  </div>

  <!-- Footer -->
  <footer class="bg-white border-t mt-auto">
    <div class="max-w-screen-2xl mx-auto px-4 py-4 text-center text-sm text-gray-600">
      <p>&copy; {{ date('Y') }} Library Management System. All rights reserved.</p>
    </div>
  </footer>

  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.store('app', {
        loading: false,
        
        startLoading() {
          this.loading = true;
        },
        
        stopLoading() {
          this.loading = false;
        }
      });
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    });

    // Auto-hide notifications after 5 seconds
    setTimeout(() => {
      const alerts = document.querySelectorAll('[x-data*="show"]');
      alerts.forEach(alert => {
        const alpineData = Alpine.$data(alert);
        if (alpineData && alpineData.show !== undefined) {
          alpineData.show = false;
        }
      });
    }, 5000);
  </script>
  @stack('scripts')
</body>
</html>