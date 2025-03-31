<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Apple Cell - @yield('title')</title>
  <!-- Favicon vacío para eliminar el de Laravel -->
  <link rel="icon" href="data:,">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.3/cdn.min.js" defer></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">

  <style>
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
      overflow: hidden;
    }

    .wrapper {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      height: 100%;
    }

    .content-wrapper {
      display: flex;
      flex: 1;
      height: calc(100% - 50px); /* Restar altura del footer */
      overflow: hidden;
    }

    .sidebar {
      background-color: #1a202c;
      width: 16rem;
      color: white;
      display: flex;
      flex-direction: column;
      height: 100vh; /* Altura completa de la ventana */
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      z-index: 30;
      transition: transform 0.3s ease;
    }

    .sidebar-content {
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    .main-content {
      flex: 1;
      margin-left: 16rem; /* Ancho del sidebar */
      overflow-y: auto;
      background-color: white;
      transition: margin-left 0.3s ease;
    }

    .main-content-nosidebar {
      margin-left: 0;
    }

    .header {
      background-color: white;
      padding: 1rem;
      display: flex;
      justify-content: flex-end;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .sidebar-toggle-btn {
      transition: all 0.3s ease;
      position: fixed;
      left: 16rem;
      top: 50%;
      transform: translateY(-50%);
      z-index: 40;
      background-color: #1a202c;
      padding: 0.75rem 0.5rem;
      border-radius: 0 0.5rem 0.5rem 0;
      color: white;
      border: none;
      cursor: pointer;
    }

    .sidebar-toggle-btn:hover {
      background-color: #2d3748;
    }

    .sidebar-toggle-btn.rotated {
      transform: translateY(-50%) rotate(180deg);
      left: 0;
    }

    .logo {
      height: 2.5rem;
      width: auto;
      transition: all 0.3s ease;
    }

    .logo:hover {
      transform: scale(1.05);
    }

    .logo-text {
      background: linear-gradient(to right, #3b82f6, #10b981);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      font-weight: 700;
    }

    .brand-container {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .sidebar-item.active {
      background-color: rgba(255, 255, 255, 0.1);
      color: white;
    }

    .sidebar-item:hover {
      background-color: rgba(255, 255, 255, 0.05);
      color: white;
    }

    .footer {
      background-color: #1a202c;
      color: white;
      padding: 1rem;
      text-align: center;
    }

    @media (max-width: 1024px) {
      .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
      }

      .sidebar.open {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0;
      }
    }
  </style>
  <!-- Favicon estándar -->
  <link rel="icon" href="{{ asset('img/logo2.png') }}" type="image/png">

  <!-- Para Safari en macOS -->
  <link rel="mask-icon" href="{{ asset('img/logo2.png') }}" color="#000000">

  <!-- Para dispositivos Apple -->
  <link rel="apple-touch-icon" href="{{ asset('img/logo2.png') }}">

  <!-- Para Windows 8/10 -->
  <meta name="msapplication-TileImage" content="{{ asset('img/logo2.png') }}">
</head>
<body x-data="{ sidebarOpen: window.innerWidth > 1024 }">
  <div class="wrapper">
    <!-- Sidebar -->
    <aside class="sidebar" :class="{'open': sidebarOpen, 'transform translate-x-0': sidebarOpen, 'transform -translate-x-full': !sidebarOpen}">
      <div class="sidebar-content">
        <div class="p-4 flex items-center justify-between border-b border-gray-800">
          <a href="{{ route('inicio') }}" class="brand-container">
            <img src="{{ asset('img/logo2.png') }}" alt="Apple Cell Logo" class="logo">
            <span class="logo-text">Apple Cell</span>
          </a>
          <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white">
            <i class="fas fa-times"></i>
          </button>
        </div>

        <nav class="flex-1 overflow-y-auto p-4 space-y-1">
          <a href="{{ route('inicio') }}"
            class="sidebar-item flex items-center px-4 py-3 rounded-md
                  {{ Request::is('inicio') ? 'active' : 'text-gray-300' }}">
            <i class="fas fa-home mr-3 w-5 text-center"></i>
            <span>Inicio</span>
          </a>

          <a href="{{ route('catalogos.index') }}"
            class="sidebar-item flex items-center px-4 py-3 rounded-md
                  {{ Request::is('catalogos*') ? 'active' : 'text-gray-300' }}">
            <i class="fas fa-book mr-3 w-5 text-center"></i>
            <span>Catálogos</span>
          </a>

          <a href="{{ route('ventas.index') }}"
            class="sidebar-item flex items-center px-4 py-3 rounded-md
                  {{ Request::is('ventas*') ? 'active' : 'text-gray-300' }}">
            <i class="fas fa-shopping-cart mr-3 w-5 text-center"></i>
            <span>Registrar Venta</span>
          </a>

          <a href="{{ route('compras.index') }}"
            class="sidebar-item flex items-center px-4 py-3 rounded-md
                  {{ Request::is('compras*') ? 'active' : 'text-gray-300' }}">
            <i class="fas fa-shopping-basket mr-3 w-5 text-center"></i>
            <span>Registrar Compra</span>
          </a>

          <a href="{{ route('reparaciones.index') }}"
            class="sidebar-item flex items-center px-4 py-3 rounded-md
                  {{ Request::is('reparaciones*') ? 'active' : 'text-gray-300' }}">
            <i class="fas fa-tools mr-3 w-5 text-center"></i>
            <span>Registrar Reparación</span>
          </a>

          <a href="{{ route('balance') }}"
            class="sidebar-item flex items-center px-4 py-3 rounded-md
                  {{ Request::is('balance*') ? 'active' : 'text-gray-300' }}">
            <i class="fas fa-chart-line mr-3 w-5 text-center"></i>
            <span>Balance Final</span>
          </a>

          <a href="{{ route('calculadora') }}"
            class="sidebar-item flex items-center px-4 py-3 rounded-md
                  {{ Request::is('calculadora*') ? 'active' : 'text-gray-300' }}">
            <i class="fas fa-calculator mr-3 w-5 text-center"></i>
            <span>Calculadora</span>
          </a>
        </nav>
      </div>
    </aside>

    <div class="content-wrapper">
      <!-- Overlay para móvil -->
      <div x-show="sidebarOpen" @click="sidebarOpen = false"
          class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"
          x-transition:enter="transition-opacity ease-out duration-300"
          x-transition:enter-start="opacity-0"
          x-transition:enter-end="opacity-100"
          x-transition:leave="transition-opacity ease-in duration-200"
          x-transition:leave-start="opacity-100"
          x-transition:leave-end="opacity-0">
      </div>

      <!-- Main content -->
      <div class="main-content transition-all duration-300" :class="{'ml-64': sidebarOpen, 'ml-0': !sidebarOpen}">
        <!-- Header principal - solo visible en escritorio -->
        <header class="header hidden lg:flex">
          @auth
          <div class="relative">
            <div>
              <button type="button" class="flex items-center text-sm rounded-full focus:outline-none" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                <span class="sr-only">Abrir menú usuario</span>
                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                  {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="ml-2 text-gray-700">{{ auth()->user()->name }}</span>
                <i class="fas fa-chevron-down ml-1 text-gray-500"></i>
              </button>
            </div>

            <!-- Dropdown menu -->
            <div class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" id="user-menu">
              <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                <i class="fas fa-user-edit mr-2"></i> Editar perfil
              </a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                  <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
                </button>
              </form>
            </div>
          </div>
          @endauth
        </header>

        <!-- Header móvil -->
        <header class="lg:hidden bg-gray-900 text-white p-4 flex items-center justify-between">
          <button @click="sidebarOpen = true" class="text-white focus:outline-none">
            <i class="fas fa-bars text-xl"></i>
          </button>
          <div class="w-6"></div> <!-- Espaciador -->
        </header>

        <!-- Desktop sidebar toggle -->
        <button @click="sidebarOpen = !sidebarOpen"
              class="hidden lg:block sidebar-toggle-btn transition-all duration-300"
              :class="{ 'rotated': !sidebarOpen, 'left-0': !sidebarOpen, 'left-64': sidebarOpen }">
          <i class="fas fa-chevron-left"></i>
        </button>

        <!-- Content -->
        <div class="p-4 md:p-6">
          <div class="max-w-7xl mx-auto">
            @yield('content')
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
      <div class="container mx-auto">
        <p>&copy; 2025 Apple Cell - Todos los derechos reservados</p>
      </div>
    </footer>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const userMenuButton = document.getElementById('user-menu-button');
      const userMenu = document.getElementById('user-menu');

      if (userMenuButton && userMenu) {
        userMenuButton.addEventListener('click', function() {
          const expanded = this.getAttribute('aria-expanded') === 'true';
          this.setAttribute('aria-expanded', !expanded);
          userMenu.classList.toggle('hidden');
        });

        // Cerrar el menú al hacer clic fuera
        document.addEventListener('click', function(event) {
          if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
            userMenuButton.setAttribute('aria-expanded', 'false');
            userMenu.classList.add('hidden');
          }
        });
      }
    });
  </script>
</body>
</html>
