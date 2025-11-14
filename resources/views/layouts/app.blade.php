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
    /* ==================== CUSTOM SCROLLBAR ==================== */
          html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden; /* Prevent body scroll since main-content handles it */
      }
      header {
  position: sticky;
  top: 0;
  z-index: 50;
}

/* On desktop, shift header content to align with main content */
@media (min-width: 768px) {
  header .max-w-screen-2xl {
    margin-left: 0;
    margin-right: auto;
    padding-left: calc(256px + 1.5rem); /* 256px (w-64) + original padding */
  }
}
      /* Add this new rule */
      .flex.h-screen {
        height: 100vh;
        overflow: hidden;
      }

      /* Ensure main content scrolls consistently */
      main.main-content {
        overflow-y: scroll !important; /* Force scrollbar to always show */
      }

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

    /* ==================== TEXT ANIMATIONS ==================== */
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

    @keyframes fadeInLeft {
      from {
        opacity: 0;
        transform: translateX(-20px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes fadeInRight {
      from {
        opacity: 0;
        transform: translateX(20px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes textGlow {
      0%, 100% {
        text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
      }
      50% {
        text-shadow: 0 0 20px rgba(255, 255, 255, 0.8), 0 0 30px rgba(255, 255, 255, 0.6);
      }
    }

    .animate-fade-in-up {
      animation: fadeInUp 0.6s ease-out;
    }

    .animate-fade-in-left {
      animation: fadeInLeft 0.6s ease-out;
    }

    .animate-fade-in-right {
      animation: fadeInRight 0.6s ease-out;
    }

    .animate-slide-down {
      animation: slideDown 0.3s ease-out;
    }

    .animate-text-glow {
      animation: textGlow 2s ease-in-out infinite;
    }

    /* ==================== HEADER STYLES ==================== */
    .header-gradient {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
      position: relative;
    }

    .header-gradient::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
      animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
      to {
        left: 100%;
      }
    }

    /* ==================== SIDEBAR STYLES ==================== */
    .sidebar {
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(20px);
      box-shadow: 2px 0 20px rgba(0, 0, 0, 0.05);
      border-right: 1px solid rgba(102, 126, 234, 0.1);
    }

    .nav-link {
      position: relative;
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 14px 18px;
      border-radius: 14px;
      color: #64748b;
      font-weight: 600;
      font-size: 0.9375rem;
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
      border-radius: 0 4px 4px 0;
    }

    .nav-link::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
      opacity: 0;
      transition: opacity 0.3s ease;
      border-radius: 14px;
    }

    .nav-link:hover {
      color: #667eea;
      transform: translateX(6px);
    }

    .nav-link:hover::after {
      opacity: 1;
    }

    .nav-link:hover::before {
      transform: scaleY(1);
    }

    .nav-link.active {
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.12) 0%, rgba(118, 75, 162, 0.12) 100%);
      color: #667eea;
      font-weight: 700;
      box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
    }

    .nav-link.active::before {
      transform: scaleY(1);
    }

    .nav-icon {
      width: 24px;
      height: 24px;
      transition: transform 0.3s ease;
      filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
    }

    .nav-link:hover .nav-icon,
    .nav-link.active .nav-icon {
      transform: scale(1.15) rotate(5deg);
    }

    /* ==================== CREDIT CARD STYLES ==================== */
    .credit-card {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-radius: 20px;
      padding: 24px;
      margin: 20px;
      color: white;
      box-shadow: 0 10px 30px rgba(102, 126, 234, 0.35);
      position: relative;
      overflow: hidden;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      cursor: pointer;
    }

    .credit-card::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
      animation: card-shimmer 4s infinite;
    }

    @keyframes card-shimmer {
      0%, 100% {
        transform: translate(0, 0);
      }
      50% {
        transform: translate(-25%, -25%);
      }
    }

    .credit-card::after {
      content: '';
      position: absolute;
      inset: 0;
      background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
      opacity: 0.3;
    }

    .credit-card:hover {
      transform: translateY(-6px) scale(1.02);
      box-shadow: 0 20px 50px rgba(102, 126, 234, 0.45);
    }

    a:has(.credit-card) {
      text-decoration: none;
    }

    .credit-label {
      font-size: 0.8125rem;
      opacity: 0.9;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      margin-bottom: 8px;
      font-weight: 600;
      position: relative;
      z-index: 2;
    }

    .credit-amount {
      font-size: 2.25rem;
      font-weight: 800;
      display: flex;
      align-items: baseline;
      gap: 6px;
      position: relative;
      z-index: 2;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .credit-currency {
      font-size: 1.375rem;
      font-weight: 700;
    }

    .credit-icon-wrapper {
      position: absolute;
      bottom: 20px;
      right: 20px;
      opacity: 0.2;
      animation: float-icon 3s ease-in-out infinite;
    }

    .credit-icon-wrapper svg {
      width: 64px;
      height: 64px;
    }

    @keyframes float-icon {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-10px);
      }
    }

    .topup-btn {
      margin-top: 16px;
      padding: 10px 20px;
      background: rgba(255, 255, 255, 0.25);
      border: 1px solid rgba(255, 255, 255, 0.4);
      border-radius: 12px;
      color: white;
      font-size: 0.9375rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
      backdrop-filter: blur(10px);
      position: relative;
      z-index: 2;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .topup-btn:hover {
      background: rgba(255, 255, 255, 0.35);
      transform: translateY(-3px);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    /* ==================== MOBILE MENU ==================== */
    .mobile-menu-enter {
      animation: slideInLeft 0.4s cubic-bezier(0.4, 0, 0.2, 1);
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

    /* ==================== BUTTON STYLES ==================== */
    .btn-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 12px 28px;
      border-radius: 14px;
      font-weight: 700;
      transition: all 0.3s ease;
      border: none;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.35);
      position: relative;
      overflow: hidden;
    }

    .btn-primary::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.3);
      transform: translate(-50%, -50%);
      transition: width 0.6s ease, height 0.6s ease;
    }

    .btn-primary:hover::before {
      width: 300px;
      height: 300px;
    }

    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(102, 126, 234, 0.45);
    }

    .btn-primary:active {
      transform: translateY(-1px);
    }

    /* ==================== USER MENU ==================== */
    .user-menu {
      position: relative;
    }

    .user-avatar {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
      border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .user-avatar:hover {
      transform: scale(1.1) rotate(5deg);
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
    }

    .dropdown-menu {
      position: absolute;
      top: calc(100% + 12px);
      right: 0;
      background: white;
      border-radius: 16px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
      min-width: 240px;
      overflow: hidden;
      z-index: 100;
      border: 1px solid rgba(102, 126, 234, 0.1);
    }

    .dropdown-menu.show {
      animation: dropdownFade 0.3s ease-out;
    }

    @keyframes dropdownFade {
      from {
        opacity: 0;
        transform: translateY(-12px) scale(0.95);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    .dropdown-item {
      padding: 14px 20px;
      color: #475569;
      display: flex;
      align-items: center;
      gap: 12px;
      transition: all 0.2s ease;
      cursor: pointer;
      font-weight: 600;
      font-size: 0.9375rem;
    }

    .dropdown-item:hover {
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
      color: #667eea;
      padding-left: 24px;
    }

    .dropdown-item svg {
      width: 20px;
      height: 20px;
    }

    /* ==================== BADGE STYLES ==================== */
    .badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 5px 12px;
      border-radius: 50px;
      font-size: 0.75rem;
      font-weight: 700;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      margin-left: auto;
      box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
      animation: pulse-badge 2s ease-in-out infinite;
    }

    @keyframes pulse-badge {
      0%, 100% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.05);
      }
    }

    /* ==================== LOADING SPINNER ==================== */
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

    /* ==================== MAIN CONTENT ==================== */
    .main-content {
      padding: 0;
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.95) 0%, rgba(118, 75, 162, 0.95) 100%);
      min-height: auto; 
      height: auto;  
      animation: contentFadeIn 0.6s ease-out;
    }

    @keyframes contentFadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* ==================== NOTIFICATION BADGE ==================== */
    .notification-badge {
      position: absolute;
      top: -6px;
      right: -6px;
      background: #ef4444;
      color: white;
      font-size: 0.6875rem;
      font-weight: 800;
      padding: 3px 7px;
      border-radius: 12px;
      border: 2px solid white;
      box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
      animation: notification-pulse 2s ease-in-out infinite;
    }

    @keyframes notification-pulse {
      0%, 100% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.1);
      }
    }

    /* ==================== MENU BUTTON ==================== */
    .menu-btn {
      width: 44px;
      height: 44px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 12px;
      transition: all 0.3s ease;
      background: rgba(255, 255, 255, 0.25);
      border: 1px solid rgba(255, 255, 255, 0.3);
      backdrop-filter: blur(10px);
      cursor: pointer;
    }

    .menu-btn:hover {
      background: rgba(255, 255, 255, 0.35);
      transform: scale(1.05);
    }

    .menu-btn:active {
      transform: scale(0.95);
    }

    /* ==================== LOGO ==================== */
    .logo {
      font-size: 1.5rem;
      font-weight: 800;
      color: white;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: all 0.3s ease;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .logo:hover {
      transform: scale(1.05);
      filter: brightness(1.1);
    }

    .logo-icon {
      animation: logo-bounce 2s ease-in-out infinite;
      width: 96px;
      height: 96px;
      filter: drop-shadow(0 2px 6px rgba(0, 0, 0, 0.2));
    }

    @keyframes logo-bounce {
      0%, 100% {
        transform: translateY(0) rotate(0deg);
      }
      25% {
        transform: translateY(-6px) rotate(-5deg);
      }
      75% {
        transform: translateY(-3px) rotate(5deg);
      }
    }

    /* ==================== CART BUTTON ==================== */
    .cart-btn {
      position: relative;
      width: 44px;
      height: 44px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 12px;
      transition: all 0.3s ease;
      background: rgba(255, 255, 255, 0.25);
      border: 1px solid rgba(255, 255, 255, 0.3);
      backdrop-filter: blur(10px);
      cursor: pointer;
    }

    .cart-btn:hover {
      background: rgba(255, 255, 255, 0.35);
      transform: scale(1.05) rotate(-5deg);
    }

    .cart-badge {
      position: absolute;
      top: -6px;
      right: -6px;
      background: #ef4444;
      color: white;
      font-size: 0.6875rem;
      font-weight: 800;
      padding: 3px 7px;
      min-width: 20px;
      height: 20px;
      border-radius: 12px;
      border: 2px solid #667eea;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
    }

    /* ==================== NOTIFICATION DROPDOWN ==================== */
    .notification-dropdown {
      position: absolute;
      top: calc(100% + 16px);
      right: 0;
      width: 440px;
      max-height: 650px;
      background: white;
      border-radius: 20px;
      box-shadow: 0 15px 50px rgba(0, 0, 0, 0.25);
      overflow: hidden;
      z-index: 100;
      border: 1px solid rgba(102, 126, 234, 0.1);
    }

    .notification-dropdown.show {
      animation: dropdownFade 0.3s ease-out;
    }

    .notif-header {
      padding: 20px 24px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .notif-title {
      font-size: 1.25rem;
      font-weight: 800;
    }

    .notif-count-badge {
      background: rgba(255, 255, 255, 0.3);
      padding: 6px 12px;
      border-radius: 14px;
      font-size: 0.8125rem;
      font-weight: 800;
      border: 1px solid rgba(255, 255, 255, 0.4);
      backdrop-filter: blur(10px);
    }

    .notif-list {
      max-height: 550px;
      overflow-y: auto;
    }

    .notif-section-label {
      padding: 10px 24px;
      font-size: 0.8125rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      background: #f9fafb;
      color: #6b7280;
      border-top: 1px solid #e5e7eb;
      position: sticky;
      top: 0;
      z-index: 10;
      display: flex;
      align-items: center;
      gap: 8px;
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
      gap: 14px;
      padding: 14px 24px;
      border-bottom: 1px solid #f3f4f6;
      transition: all 0.2s ease;
      text-decoration: none;
      color: inherit;
    }

    .notif-item:hover {
      background: #f9fafb;
      transform: translateX(6px);
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
      width: 40px;
      height: 40px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
      flex-shrink: 0;
    }

    .notif-icon svg {
      width: 24px;
      height: 24px;
    }

    .notif-icon.urgent {
      background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
      color: #dc2626;
    }

    .notif-icon.warning {
      background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
      color: #d97706;
    }

    .notif-icon.due-soon {
      background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
      color: #f59e0b;
    }

    .notif-icon.info {
      background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
      color: #2563eb;
    }

    .notif-icon.success {
      background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
      color: #16a34a;
    }

    .notif-content {
      flex: 1;
      min-width: 0;
    }

    .notif-text {
      font-size: 0.9375rem;
      color: #1f2937;
      margin-bottom: 4px;
      font-weight: 600;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .notif-subtext {
      font-size: 0.8125rem;
      color: #6b7280;
      font-weight: 500;
    }

    .notif-arrow {
      margin-left: auto;
      color: #9ca3af;
      font-size: 1.5rem;
      font-weight: 300;
      flex-shrink: 0;
      transition: transform 0.2s ease;
    }

    .notif-item:hover .notif-arrow {
      transform: translateX(4px);
    }

    .notif-view-all {
      display: block;
      padding: 16px 24px;
      text-align: center;
      background: #f9fafb;
      color: #667eea;
      font-weight: 700;
      font-size: 0.9375rem;
      text-decoration: none;
      transition: all 0.2s ease;
      border-top: 1px solid #e5e7eb;
    }

    .notif-view-all:hover {
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
      color: #764ba2;
    }

    .notif-empty {
      padding: 60px 24px;
      text-align: center;
    }

    .notif-empty-icon {
      font-size: 4rem;
      margin-bottom: 16px;
      opacity: 0.5;
    }

    .notif-empty-icon svg {
      width: 80px;
      height: 80px;
      margin: 0 auto;
      color: #9ca3af;
    }

    .notif-empty-text {
      font-size: 1.125rem;
      font-weight: 700;
      color: #1f2937;
      margin-bottom: 6px;
    }

    .notif-empty-subtext {
      font-size: 0.9375rem;
      color: #6b7280;
    }

    /* Mobile Notification Dropdown */
    .notification-dropdown-mobile {
      position: absolute;
      top: calc(100% + 16px);
      right: 0;
      width: 300px;
      background: white;
      border-radius: 20px;
      box-shadow: 0 15px 50px rgba(0, 0, 0, 0.25);
      overflow: hidden;
      z-index: 100;
      border: 1px solid rgba(102, 126, 234, 0.1);
    }

    .notification-dropdown-mobile.show {
      animation: dropdownFade 0.3s ease-out;
    }

    .notif-mobile-quick {
      padding: 16px;
    }

    .notif-mobile-link {
      display: block;
      padding: 14px;
      text-align: center;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      font-weight: 700;
      font-size: 0.9375rem;
      text-decoration: none;
      border-radius: 12px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .notif-mobile-link:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
    }

    /* ==================== RESPONSIVE DESIGN ==================== */
    @media (max-width: 768px) {
      .notification-dropdown {
        width: 340px;
      }
      
      .credit-card {
        margin: 16px;
        padding: 20px;
      }
      
      .credit-amount {
        font-size: 1.875rem;
      }
    }

    @media (max-width: 480px) {
      .notification-dropdown-mobile {
        width: 280px;
      }
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased" 
      x-data="{ 
        sidebarOpen: false,
        userMenuOpen: false,
        notifOpen: false,
        mobileNotifOpen: false,
        notifications: 3,
        currentPage: '{{ Route::currentRouteName() ?? 'dashboard' }}',
        closeAllDropdowns() {
          this.userMenuOpen = false;
          this.notifOpen = false;
          this.mobileNotifOpen = false;
        }
      }"
      @click.away="closeAllDropdowns()">
  
  <!-- Header -->
  <header class="sticky top-0 z-50 header-gradient">
    <div class="max-w-screen-2xl mx-auto px-4 lg:px-6 h-16 flex items-center justify-between">
      <!-- Left Section -->
      <div class="flex items-center gap-4 animate-fade-in-left">
        <!-- Mobile Menu Button -->
        <button class="md:hidden menu-btn"
                @click.stop="sidebarOpen = !sidebarOpen" 
                aria-label="Toggle sidebar">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
        
      <!-- Logo -->
          <a href="{{ url('/') }}" class="logo">
      <img src="{{ asset('images/Books(2).gif') }}"
          alt="Group 888 Library Management System Logo"
          class="logo-icon" />
      <span class="hidden sm:inline animate-text-glow">
        Group 888 Library Management System
      </span>
    </a>
      </div>
      <!-- Right Section -->
      <div class="flex items-center gap-3 animate-fade-in-right">
        <!-- Notifications (Mobile) -->
        @auth
        <div class="relative md:hidden">
          @php
            $mobileNotifCount = 0;
            if (auth()->user()->user) {
              $userId = auth()->user()->user->id;
              $mobileNotifCount = \App\Models\Fine::where('user_id', $userId)->whereIn('status', ['unpaid', 'pending'])->count() +
                                 \App\Models\BorrowHistory::where('user_id', $userId)->whereNull('returned_at')->where('approve_status', 'approved')->where('status', 'overdue')->count() +
                                 \App\Models\BorrowHistory::where('user_id', $userId)->where('approve_status', 'pending')->count();
            }
          @endphp
          <button class="menu-btn relative" @click.stop="mobileNotifOpen = !mobileNotifOpen; notifOpen = false; userMenuOpen = false">
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
          <div x-show="mobileNotifOpen" 
               x-cloak
               @click.stop
               :class="mobileNotifOpen ? 'show' : ''"
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

        <!-- Notifications (Desktop) -->
        @auth
        <div class="relative hidden md:block">
          @php
            $notificationCount = 0;
            $notificationItems = [];
            if (auth()->user()->user) {
              $userId = auth()->user()->user->id;
              
              $unpaidFines = \App\Models\Fine::with('borrowHistory.book')
                ->where('user_id', $userId)
                ->whereIn('status', ['unpaid', 'pending'])
                ->orderByDesc('created_at')
                ->get();
              
              $overdueBooks = \App\Models\BorrowHistory::with('book')
                ->where('user_id', $userId)
                ->whereNull('returned_at')
                ->where('approve_status', 'approved')
                ->where('status', 'overdue')
                ->orderBy('due_at', 'asc')
                ->get();
              
              $dueSoonBooks = \App\Models\BorrowHistory::with('book')
                ->where('user_id', $userId)
                ->whereNull('returned_at')
                ->where('approve_status', 'approved')
                ->where('status', 'active')
                ->whereBetween('due_at', [now(), now()->addDays(3)])
                ->orderBy('due_at', 'asc')
                ->get();
              
              $pendingRequests = \App\Models\BorrowHistory::with('book')
                ->where('user_id', $userId)
                ->where('approve_status', 'pending')
                ->orderByDesc('created_at')
                ->get();
              
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
          <button class="menu-btn relative" @click.stop="notifOpen = !notifOpen; userMenuOpen = false; mobileNotifOpen = false">
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
               @click.stop
               :class="notifOpen ? 'show' : ''"
               class="notification-dropdown">
            
            <div class="notif-header">
              <h3 class="notif-title">Notifications</h3>
              @if($notificationCount > 0)
                <span class="notif-count-badge">{{ $notificationCount }}</span>
              @endif
            </div>

            <div class="notif-list">
              @if($notificationCount > 0 || isset($dueSoonBooks) && $dueSoonBooks->count() > 0 || isset($recentlyApproved) && $recentlyApproved->count() > 0)
                
                @if(isset($overdueBooks) && $overdueBooks->count() > 0)
                  <div class="notif-section-label urgent">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Overdue ({{ $overdueBooks->count() }})
                  </div>
                  @foreach($overdueBooks as $borrow)
                    <a href="{{ route('client.borrowhistory.index') }}" class="notif-item urgent">
                      <div class="notif-icon urgent">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                      </div>
                      <div class="notif-content">
                        <p class="notif-text">{{ \Illuminate\Support\Str::limit($borrow->book->book_name, 25) }}</p>
                        <p class="notif-subtext">{{ $borrow->late_days }} day(s) overdue</p>
                      </div>
                      <div class="notif-arrow">›</div>
                    </a>
                  @endforeach
                @endif

                @if(isset($unpaidFines) && $unpaidFines->count() > 0)
                  <div class="notif-section-label warning">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Unpaid Fines ({{ $unpaidFines->count() }})
                  </div>
                  @foreach($unpaidFines as $fine)
                    <a href="{{ route('fines.index') }}" class="notif-item warning">
                      <div class="notif-icon warning">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                      </div>
                      <div class="notif-content">
                        <p class="notif-text">RM {{ number_format($fine->amount, 2) }}</p>
                        <p class="notif-subtext">{{ $fine->status === 'pending' ? 'Pending' : 'Pay now' }}</p>
                      </div>
                      <div class="notif-arrow">›</div>
                    </a>
                  @endforeach
                @endif

                @if(isset($dueSoonBooks) && $dueSoonBooks->count() > 0)
                  <div class="notif-section-label due-soon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Due Soon ({{ $dueSoonBooks->count() }})
                  </div>
                  @foreach($dueSoonBooks as $borrow)
                    @php
                      $dueDate = \Carbon\Carbon::parse($borrow->due_at);
                      $daysUntilDue = now()->diffInDays($dueDate, false);
                    @endphp
                    <a href="{{ route('client.borrowhistory.index') }}" class="notif-item due-soon">
                      <div class="notif-icon due-soon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                      </div>
                      <div class="notif-content">
                        <p class="notif-text">{{ \Illuminate\Support\Str::limit($borrow->book->book_name, 25) }}</p>
                        <p class="notif-subtext">Due in {{ $daysUntilDue }} day(s)</p>
                      </div>
                      <div class="notif-arrow">›</div>
                    </a>
                  @endforeach
                @endif

                @if(isset($pendingRequests) && $pendingRequests->count() > 0)
                  <div class="notif-section-label info">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Pending ({{ $pendingRequests->count() }})
                  </div>
                  @foreach($pendingRequests as $request)
                    <a href="{{ route('client.borrowhistory.index') }}" class="notif-item info">
                      <div class="notif-icon info">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                      </div>
                      <div class="notif-content">
                        <p class="notif-text">{{ \Illuminate\Support\Str::limit($request->book->book_name, 25) }}</p>
                        <p class="notif-subtext">Awaiting approval</p>
                      </div>
                      <div class="notif-arrow">›</div>
                    </a>
                  @endforeach
                @endif

                @if(isset($recentlyApproved) && $recentlyApproved->count() > 0)
                  <div class="notif-section-label success">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Approved ({{ $recentlyApproved->count() }})
                  </div>
                  @foreach($recentlyApproved as $approved)
                    <a href="{{ route('client.borrowhistory.index') }}" class="notif-item success">
                      <div class="notif-icon success">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                      </div>
                      <div class="notif-content">
                        <p class="notif-text">{{ \Illuminate\Support\Str::limit($approved->book->book_name, 25) }}</p>
                        <p class="notif-subtext">Ready to pick up!</p>
                      </div>
                      <div class="notif-arrow">›</div>
                    </a>
                  @endforeach
                @endif

                <a href="{{ route('client.notifications.index') }}" class="notif-view-all">
                  View All Notifications →
                </a>
              @else
                <div class="notif-empty">
                  <div class="notif-empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                  <p class="notif-empty-text">All caught up!</p>
                  <p class="notif-empty-subtext">No new notifications</p>
                </div>
              @endif
            </div>
          </div>
        </div>
        @endauth

        <!-- User Menu -->
        <div class="user-menu">
          <div class="user-avatar" @click.stop="userMenuOpen = !userMenuOpen; notifOpen = false; mobileNotifOpen = false">
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

          <div x-show="userMenuOpen" 
               x-cloak 
               @click.stop
               :class="userMenuOpen ? 'show' : ''"
               class="dropdown-menu">
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
              <a href="{{ route('client.profile.update') }}" class="dropdown-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>Settings</span>
              </a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item w-full text-left border-t border-gray-100">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                  </svg>
                  <span>Logout</span>
                </button>
              </form>
            @else
              <a href="{{ route('login') }}" class="dropdown-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                <span>Login</span>
              </a>
            @endauth
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Layout -->
  <div class="flex h-screen">
    
    <!-- Desktop Sidebar -->
    <aside class="hidden md:flex md:flex-col w-64 sidebar">
      <!-- Credit Card (Only for authenticated users) -->
      @auth
        @php
          $userCredit = auth()->user()->user ? auth()->user()->user->credit : 0;
        @endphp
        <a href="{{ route('client.credit.topup') }}">
          <div class="credit-card">
            <div class="credit-label animate-fade-in-up">Your Balance</div>
            <div class="credit-amount animate-fade-in-up">
              <span class="credit-currency">RM</span>
              <span>{{ number_format($userCredit, 2) }}</span>
            </div>
            <div class="credit-icon-wrapper">
              <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24">
                <path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
              </svg>
            </div>
            <button class="topup-btn" onclick="event.preventDefault(); window.location.href='{{ route('client.credit.topup') }}'">
              Top Up Now
            </button>
          </div>
        </a>
      @endauth

      <!-- Navigation -->
      <nav class="flex-1 px-4 py-6 overflow-y-auto">
        <div class="space-y-2">
          <a href="{{ route('client.homepage.index') }}" 
             class="nav-link {{ request()->routeIs('client.homepage.index') ? 'active' : '' }}">
            <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Home</span>
          </a>

          @auth
            <a href="{{ route('client.books.index') }}" 
               class="nav-link {{ request()->routeIs('client.books.*') ? 'active' : '' }}">
              <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
              </svg>
              <span>Browse Books</span>
            </a>

            <a href="{{ route('client.borrowhistory.index') }}" 
               class="nav-link {{ request()->routeIs('client.borrowhistory.*') ? 'active' : '' }}">
              <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              <span>My Borrows</span>
              @php
                $activeBorrows = auth()->user()->user ? 
                  \App\Models\BorrowHistory::where('user_id', auth()->user()->user->id)
                    ->whereNull('returned_at')
                    ->where('approve_status', 'approved')
                    ->count() : 0;
              @endphp
              @if($activeBorrows > 0)
                <span class="badge">{{ $activeBorrows }}</span>
              @endif
            </a>

            <a href="{{ route('client.favourites.index') }}" 
               class="nav-link {{ request()->routeIs('client.favourites.*') ? 'active' : '' }}">
              <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
              </svg>
              <span>Favorites</span>
            </a>

            <a href="{{ route('fines.index') }}" 
               class="nav-link {{ request()->routeIs('fines.*') ? 'active' : '' }}">
              <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>Fines</span>
              @php
                $unpaidFines = auth()->user()->user ? 
                  \App\Models\Fine::where('user_id', auth()->user()->user->id)
                    ->whereIn('status', ['unpaid', 'pending'])
                    ->count() : 0;
              @endphp
              @if($unpaidFines > 0)
                <span class="badge">{{ $unpaidFines }}</span>
              @endif
            </a>

            <a href="{{ route('client.notifications.index') }}" 
               class="nav-link {{ request()->routeIs('client.notifications.*') ? 'active' : '' }}">
              <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
              </svg>
              <span>Notifications</span>
            </a>

            <a href="{{ route('client.credit.topup') }}" 
               class="nav-link {{ request()->routeIs('client.credit.topup') ? 'active' : '' }}">
              <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
              </svg>
              <span>Top Up</span>
            </a>
          @else
            <a href="{{ route('login') }}" class="nav-link">
              <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
              <span>Login to Explore</span>
            </a>
          @endauth
        </div>
      </nav>

      <!-- Sidebar Footer -->
      <div class="p-4 border-t border-gray-200">
        <div class="text-center text-sm text-gray-500 animate-fade-in-up">
          <p class="font-semibold">Library System</p>
          <p class="text-xs mt-1">© 2024 All rights reserved</p>
        </div>
      </div>
    </aside>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" 
         x-cloak
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden mobile-menu-overlay">
    </div>

    <!-- Mobile Sidebar -->
    <aside x-show="sidebarOpen"
           x-cloak
           @click.away="sidebarOpen = false"
           class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-2xl transform md:hidden mobile-menu-enter">
      
      <!-- Mobile Sidebar Header -->
      <div class="flex items-center justify-between p-4 border-b border-gray-200">
        <div class="flex items-center gap-2">
          <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
          </svg>
          <span class="font-bold text-lg text-gray-900">Menu</span>
        </div>
        <button @click="sidebarOpen = false" 
                class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors">
          <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <!-- Credit Card (Mobile) -->
      @auth
        <a href="{{ route('client.credit.topup') }}" @click="sidebarOpen = false">
          <div class="credit-card">
            <div class="credit-label">Your Balance</div>
            <div class="credit-amount">
              <span class="credit-currency">RM</span>
              <span>{{ number_format($userCredit, 2) }}</span>
            </div>
            <div class="credit-icon-wrapper">
              <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24">
                <path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
              </svg>
            </div>
            <button class="topup-btn" onclick="event.preventDefault(); event.stopPropagation(); window.location.href='{{ route('client.credit.topup') }}'">
              Top Up Now
            </button>
          </div>
        </a>
      @endauth

      <!-- Mobile Navigation -->
      <nav class="flex-1 px-4 py-6 overflow-y-auto">
        <div class="space-y-2">
          <a href="{{ route('client.homepage.index') }}" 
             @click="sidebarOpen = false"
             class="nav-link {{ request()->routeIs('client.homepage.index') ? 'active' : '' }}">
            <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Home</span>
          </a>

          @auth
            <a href="{{ route('client.books.index') }}" 
               @click="sidebarOpen = false"
               class="nav-link {{ request()->routeIs('client.books.*') ? 'active' : '' }}">
              <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
              </svg>
              <span>Browse Books</span>
            </a>

            <a href="{{ route('client.borrowhistory.index') }}" 
               @click="sidebarOpen = false"
               class="nav-link {{ request()->routeIs('client.borrowhistory.*') ? 'active' : '' }}">
              <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              <span>My Borrows</span>
              @if($activeBorrows > 0)
                <span class="badge">{{ $activeBorrows }}</span>
              @endif
            </a>

            <a href="{{ route('client.favourites.index') }}" 
               @click="sidebarOpen = false"
               class="nav-link {{ request()->routeIs('favourites.*') ? 'active' : '' }}">
              <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
              </svg>
              <span>Favorites</span>
            </a>

            <a href="{{ route('fines.index') }}" 
               @click="sidebarOpen = false"
               class="nav-link {{ request()->routeIs('fines.*') ? 'active' : '' }}">
              <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>Fines</span>
              @if($unpaidFines > 0)
                <span class="badge">{{ $unpaidFines }}</span>
              @endif
            </a>

            <a href="{{ route('client.notifications.index') }}" 
               @click="sidebarOpen = false"
               class="nav-link {{ request()->routeIs('client.notifications.*') ? 'active' : '' }}">
              <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
              </svg>
              <span>Notifications</span>
            </a>

            <a href="{{ route('client.credit.topup') }}" 
               @click="sidebarOpen = false"
               class="nav-link {{ request()->routeIs('client.topup.*') ? 'active' : '' }}">
              <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
              </svg>
              <span>Top Up</span>
            </a>
          @else
            <a href="{{ route('login') }}" 
               @click="sidebarOpen = false"
               class="nav-link">
              <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
              <span>Login to Explore</span>
            </a>
          @endauth
        </div>
      </nav>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 overflow-y-auto main-content">
      @yield('content')
    </main>
  </div>

  <!-- Success/Error Messages -->
  @if(session('success'))
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false,
        position: 'top-end',
        toast: true,
        background: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
        color: '#fff',
        iconColor: '#fff'
      });
    });
  </script>
  @endif

  @if(session('error'))
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}',
        timer: 3000,
        showConfirmButton: false,
        position: 'top-end',
        toast: true
      });
    });
  </script>
  @endif

  @stack('scripts')
</body>
</html>