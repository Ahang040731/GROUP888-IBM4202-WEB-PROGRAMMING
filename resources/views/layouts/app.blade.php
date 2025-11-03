<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title', 'Dashboard')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  {{-- Alpine for simple interactivity (no install needed) --}}
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50 text-gray-900" x-data="{ sidebarOpen: false }">

  <!-- Header -->
  <header class="sticky top-0 z-40 bg-white border-b">
    <div class="max-w-screen-2xl mx-auto px-4 h-14 flex items-center justify-between">
      <div class="flex items-center gap-2">
        <button class="md:hidden p-2 rounded hover:bg-gray-100"
                @click="sidebarOpen = !sidebarOpen" aria-label="Toggle sidebar">
          <!-- burger -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
               viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round"
               stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <a href="{{ url('/') }}" class="font-semibold">📚 Library Admin</a>
      </div>

      <div class="flex items-center gap-3">
        <a class="font-semibold">Guest</a>
        <form action="{{ route('login') ?? '#' }}" method="POST" class="hidden md:block">
          @csrf
          <button class="px-3 py-1.5 rounded bg-gray-900 text-white hover:opacity-90">Login</button>
        </form>
      </div>
    </div>
  </header>

  <div class="max-w-screen-2xl mx-auto flex">
    <!-- Sidebar (desktop) -->
    <aside class="hidden md:block w-64 border-r min-h-[calc(100vh-56px)] bg-white">
      <nav class="p-3 space-y-1">
        <a href="{{ route('dashboard') ?? url('/') }}"
           class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->is('/') ? 'bg-gray-100 font-medium' : '' }}">🏠 Dashboard</a>
        <a href="{{ route('login') ?? '#' }}"
           class="">test login</a>
        {{-- <a href="{{ route('books.index') ?? '#' }}"
           class="block px-3 py-2 rounded hover:bg-gray-100">📖 Books</a>
        <a href="{{ route('members.index') ?? '#' }}"
           class="block px-3 py-2 rounded hover:bg-gray-100">👤 Members</a>
        <a href="{{ route('loans.index') ?? '#' }}"
           class="block px-3 py-2 rounded hover:bg-gray-100">🔄 Loans</a>
        <a href="{{ route('reports.index') ?? '#' }}"
           class="block px-3 py-2 rounded hover:bg-gray-100">📈 Reports</a> --}}
      </nav>
    </aside>

    <!-- Sidebar (mobile drawer) -->
    <div class="md:hidden fixed inset-0 z-40" x-show="sidebarOpen" x-cloak>
      <div class="absolute inset-0 bg-black/40" @click="sidebarOpen=false"></div>
      <aside class="absolute left-0 top-0 h-full w-72 bg-white border-r p-3">
        <div class="flex items-center justify-between mb-2">
          <span class="font-semibold">Menu</span>
          <button class="p-2" @click="sidebarOpen=false">✖</button>
        </div>
        <nav class="space-y-1">
          <a href="{{ route('dashboard') ?? url('/') }}"
             class="block px-3 py-2 rounded hover:bg-gray-100">🏠 Dashboard</a>
          {{-- <a href="{{ route('books.index') ?? '#' }}"
             class="block px-3 py-2 rounded hover:bg-gray-100">📖 Books</a>
          <a href="{{ route('members.index') ?? '#' }}"
             class="block px-3 py-2 rounded hover:bg-gray-100">👤 Members</a>
          <a href="{{ route('loans.index') ?? '#' }}"
             class="block px-3 py-2 rounded hover:bg-gray-100">🔄 Loans</a>
          <a href="{{ route('reports.index') ?? '#' }}"
             class="block px-3 py-2 rounded hover:bg-gray-100">📈 Reports</a> --}}
        </nav>
      </aside>
    </div>

    <!-- Main content -->
    <main class="flex-1 min-h-[calc(100vh-56px)] p-4">
      @yield('content')
    </main>
  </div>
</body>
</html>
