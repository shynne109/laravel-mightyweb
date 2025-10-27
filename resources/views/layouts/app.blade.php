<!DOCTYPE html>
<!--
    MightyWeb Admin Layout
    
    This layout requires the following from your parent Laravel project:
    - Tailwind CSS (configured in your build process)
    - Alpine.js (via npm or CDN)
    - Remix Icons (via npm or CDN)
    - Livewire 3.5+ (via composer)
    
    Example parent project setup in resources/js/app.js:
    import Alpine from 'alpinejs';
    window.Alpine = Alpine;
    Alpine.start();
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ 
          darkMode: false, 
          sidebarOpen: false,
          previewModal: false
      }" 
      x-init="
          darkMode = localStorage.getItem('darkMode') === 'true';
          $watch('darkMode', value => {
              localStorage.setItem('darkMode', value);
              if (value) {
                  document.documentElement.classList.add('dark');
              } else {
                  document.documentElement.classList.remove('dark');
              }
          });
          if (darkMode) {
              document.documentElement.classList.add('dark');
          }
      " 
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MightyWeb') }} - @yield('title', 'Dashboard')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('vendor/mightyweb/images/favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- MightyWeb Package Assets (Vite) -->
    @mightywebAssets

    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
        
        /* Smooth transitions */
        * {
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #475569;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .dark ::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }
    </style>

    @stack('styles')
    @livewireStyles
    @fluxAppearance
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">
        <!-- Sidebar -->
        @include('mightyweb::layouts.sidebar')

        <!-- Main Content Area -->
        <div class="lg:pl-64">
            <!-- Top Navbar -->
            @include('mightyweb::layouts.header')

            <!-- Page Content -->
            <main class="p-4 lg:p-6">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)" 
                         class="mb-4 bg-green-100 dark:bg-green-900 border-l-4 border-green-500 text-green-700 dark:text-green-200 p-4 rounded-lg shadow-md flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="ri-checkbox-circle-line text-2xl mr-3"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-green-700 dark:text-green-200 hover:text-green-900 dark:hover:text-green-100">
                            <i class="ri-close-line text-xl"></i>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)" 
                         class="mb-4 bg-red-100 dark:bg-red-900 border-l-4 border-red-500 text-red-700 dark:text-red-200 p-4 rounded-lg shadow-md flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="ri-error-warning-line text-2xl mr-3"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button @click="show = false" class="text-red-700 dark:text-red-200 hover:text-red-900 dark:hover:text-red-100">
                            <i class="ri-close-line text-xl"></i>
                        </button>
                    </div>
                @endif

                @if (session('warning'))
                    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)" 
                         class="mb-4 bg-yellow-100 dark:bg-yellow-900 border-l-4 border-yellow-500 text-yellow-700 dark:text-yellow-200 p-4 rounded-lg shadow-md flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="ri-alert-line text-2xl mr-3"></i>
                            <span>{{ session('warning') }}</span>
                        </div>
                        <button @click="show = false" class="text-yellow-700 dark:text-yellow-200 hover:text-yellow-900 dark:hover:text-yellow-100">
                            <i class="ri-close-line text-xl"></i>
                        </button>
                    </div>
                @endif

                @if (session('info'))
                    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)" 
                         class="mb-4 bg-blue-100 dark:bg-blue-900 border-l-4 border-blue-500 text-blue-700 dark:text-blue-200 p-4 rounded-lg shadow-md flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="ri-information-line text-2xl mr-3"></i>
                            <span>{{ session('info') }}</span>
                        </div>
                        <button @click="show = false" class="text-blue-700 dark:text-blue-200 hover:text-blue-900 dark:hover:text-blue-100">
                            <i class="ri-close-line text-xl"></i>
                        </button>
                    </div>
                @endif

                <!-- Page Heading -->
                @hasSection('header')
                    <div class="mb-6">
                        @yield('header')
                    </div>
                @endif

                <!-- Main Content -->
                @yield('content')
            </main>

            <!-- Footer -->
            @include('mightyweb::layouts.footer')
        </div>
    </div>
    @stack('scripts')
    @livewireScripts    
    {{-- Livewire Flux Scripts (includes interactive components) --}}
    @fluxScripts    
    <!-- MightyWeb Package Scripts -->
    @mightywebScripts
</body>
</html>
