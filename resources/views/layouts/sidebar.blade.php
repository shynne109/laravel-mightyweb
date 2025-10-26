<!-- Sidebar Overlay (Mobile) -->
<div x-show="sidebarOpen" 
     @click="sidebarOpen = false"
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 lg:hidden"
     x-cloak>
</div>

<!-- Sidebar -->
<aside 
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 overflow-y-auto"
    x-cloak>
    
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200 dark:border-gray-700">
        <a href="{{ route('mightyweb.dashboard') }}" class="flex items-center space-x-2">
            <img src="{{ asset('vendor/mightyweb/images/logo.png') }}" 
                 alt="MightyWeb" 
                 class="h-8 w-auto dark:hidden">
            <img src="{{ asset('vendor/mightyweb/images/dark-logo.png') }}" 
                 alt="MightyWeb" 
                 class="h-8 w-auto hidden dark:block">
            <span class="text-xl font-bold text-gray-900 dark:text-white">MightyWeb</span>
        </a>
        <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <i class="ri-close-line text-2xl"></i>
        </button>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-6 px-3">
        <div class="space-y-1">
            
            <!-- Dashboard -->
            <a href="{{ route('mightyweb.dashboard') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('mightyweb.dashboard') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300' }}">
                <i class="ri-dashboard-line text-lg mr-3"></i>
                <span>Dashboard</span>
            </a>

            <!-- App Configuration -->
            <a href="{{ route('mightyweb.configuration') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('mightyweb.configuration') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300' }}">
                <i class="ri-settings-3-line text-lg mr-3"></i>
                <span>App Configuration</span>
            </a>

            <!-- Divider -->
            <div class="pt-4 pb-2">
                <h3 class="px-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Content</h3>
            </div>

            <!-- Walkthrough -->
            <a href="{{ route('mightyweb.walkthrough.index') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('mightyweb.walkthrough.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300' }}">
                <i class="ri-slideshow-3-line text-lg mr-3"></i>
                <span>Walkthrough</span>
            </a>

            <!-- Menu -->
            <a href="{{ route('mightyweb.menu.index') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('mightyweb.menu.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300' }}">
                <i class="ri-menu-line text-lg mr-3"></i>
                <span>Menu</span>
            </a>

            <!-- Navigation Icons -->
            <div x-data="{ open: {{ request()->routeIs('mightyweb.navigation-icons.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                    <div class="flex items-center">
                        <i class="ri-layout-grid-line text-lg mr-3"></i>
                        <span>Navigation Icons</span>
                    </div>
                    <i class="ri-arrow-down-s-line text-lg transition-transform" :class="{ 'rotate-180': open }"></i>
                </button>
                <div x-show="open" x-collapse class="ml-6 mt-1 space-y-1">
                    <a href="{{ route('mightyweb.navigation-icons.left') }}" 
                       class="flex items-center px-3 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('mightyweb.navigation-icons.left') ? 'text-primary-700 dark:text-primary-300' : 'text-gray-600 dark:text-gray-400' }}">
                        <i class="ri-arrow-left-circle-line text-base mr-2"></i>
                        <span>Left Icons</span>
                    </a>
                    <a href="{{ route('mightyweb.navigation-icons.right') }}" 
                       class="flex items-center px-3 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('mightyweb.navigation-icons.right') ? 'text-primary-700 dark:text-primary-300' : 'text-gray-600 dark:text-gray-400' }}">
                        <i class="ri-arrow-right-circle-line text-base mr-2"></i>
                        <span>Right Icons</span>
                    </a>
                </div>
            </div>

            <!-- Tabs -->
            <a href="{{ route('mightyweb.tabs.index') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('mightyweb.tabs.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300' }}">
                <i class="ri-layout-bottom-line text-lg mr-3"></i>
                <span>Bottom Tabs</span>
            </a>

            <!-- Pages -->
            <a href="{{ route('mightyweb.pages.index') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('mightyweb.pages.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300' }}">
                <i class="ri-pages-line text-lg mr-3"></i>
                <span>Pages</span>
            </a>

            <!-- Divider -->
            <div class="pt-4 pb-2">
                <h3 class="px-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Appearance</h3>
            </div>

            <!-- Theme -->
            <a href="{{ route('mightyweb.theme') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('mightyweb.theme') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300' }}">
                <i class="ri-palette-line text-lg mr-3"></i>
                <span>Theme</span>
            </a>

            <!-- Splash Screen -->
            <a href="{{ route('mightyweb.splash') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('mightyweb.splash') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300' }}">
                <i class="ri-image-line text-lg mr-3"></i>
                <span>Splash Screen</span>
            </a>

            <!-- Progress Bar -->
            <a href="{{ route('mightyweb.progress-bar') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('mightyweb.progress-bar') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300' }}">
                <i class="ri-loader-line text-lg mr-3"></i>
                <span>Progress Bar</span>
            </a>

            <!-- Divider -->
            <div class="pt-4 pb-2">
                <h3 class="px-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Features</h3>
            </div>

            <!-- AdMob -->
            <a href="{{ route('mightyweb.admob') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('mightyweb.admob') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300' }}">
                <i class="ri-advertisement-line text-lg mr-3"></i>
                <span>AdMob</span>
            </a>

            <!-- OneSignal -->
            <a href="{{ route('mightyweb.onesignal') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('mightyweb.onesignal') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300' }}">
                <i class="ri-notification-line text-lg mr-3"></i>
                <span>Push Notifications</span>
            </a>

            <!-- Floating Button -->
            <a href="{{ route('mightyweb.floating-button') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('mightyweb.floating-button') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300' }}">
                <i class="ri-add-circle-line text-lg mr-3"></i>
                <span>Floating Button</span>
            </a>

            <!-- Exit Popup -->
            <a href="{{ route('mightyweb.exit-popup') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('mightyweb.exit-popup') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300' }}">
                <i class="ri-logout-box-line text-lg mr-3"></i>
                <span>Exit Popup</span>
            </a>

            <!-- Share -->
            <a href="{{ route('mightyweb.share') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('mightyweb.share') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300' }}">
                <i class="ri-share-line text-lg mr-3"></i>
                <span>Share</span>
            </a>

            <!-- About -->
            <a href="{{ route('mightyweb.about') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('mightyweb.about') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300' }}">
                <i class="ri-information-line text-lg mr-3"></i>
                <span>About</span>
            </a>

            <!-- User Agent -->
            <a href="{{ route('mightyweb.user-agent') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('mightyweb.user-agent') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300' }}">
                <i class="ri-smartphone-line text-lg mr-3"></i>
                <span>User Agent</span>
            </a>

        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-4 mt-6 mb-4 mx-3 border-t border-gray-200 dark:border-gray-700">
        <div class="text-xs text-gray-500 dark:text-gray-400 text-center">
            <p>MightyWeb v1.0.0</p>
            <p class="mt-1">© {{ date('Y') }} All rights reserved</p>
        </div>
    </div>
</aside>
