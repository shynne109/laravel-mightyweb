<header class="sticky top-0 z-30 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
        
        <!-- Left: Mobile Menu Button & Page Title -->
        <div class="flex items-center">
            <button @click="sidebarOpen = !sidebarOpen" 
                    class="lg:hidden p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <i class="ri-menu-line text-2xl"></i>
            </button>
            
            <div class="ml-4 lg:ml-0">
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                    @yield('header-title', 'Dashboard')
                </h1>
            </div>
        </div>

        <!-- Right: Actions -->
        <div class="flex items-center space-x-2 sm:space-x-4">
            
            <!-- JSON Export Button -->
            <a href="{{ route('mightyweb.json.export') }}" 
               class="hidden sm:flex items-center px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors"
               title="Export JSON Configuration">
                <i class="ri-download-line text-lg mr-2"></i>
                <span>Export JSON</span>
            </a>

            <!-- Mobile JSON Export Button -->
            <a href="{{ route('mightyweb.json.export') }}" 
               class="sm:hidden p-2 rounded-lg text-primary-600 hover:bg-primary-50 dark:text-primary-400 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500"
               title="Export JSON Configuration">
                <i class="ri-download-line text-xl"></i>
            </a>

            <!-- Preview Button -->
            <button @click="previewModal = true" 
                    class="hidden sm:flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors"
                    title="Preview App">
                <i class="ri-eye-line text-lg mr-2"></i>
                <span>Preview</span>
            </button>

            <!-- Mobile Preview Button -->
            <button @click="previewModal = true" 
                    class="sm:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
                    title="Preview App">
                <i class="ri-eye-line text-xl"></i>
            </button>

            <!-- Dark Mode Toggle -->
            <button @click="darkMode = !darkMode" 
                    class="p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors"
                    title="Toggle Dark Mode">
                <i x-show="!darkMode" class="ri-moon-line text-xl"></i>
                <i x-show="darkMode" class="ri-sun-line text-xl"></i>
            </button>

            <!-- User Menu Dropdown -->
            <div x-data="{ userMenuOpen: false }" class="relative">
                <button @click="userMenuOpen = !userMenuOpen" 
                        class="flex items-center space-x-2 p-2 rounded-lg text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-white text-sm font-medium">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <span class="hidden sm:block text-sm font-medium">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <i class="ri-arrow-down-s-line text-lg"></i>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="userMenuOpen" 
                     @click.away="userMenuOpen = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-lg shadow-lg border border-gray-200 dark:border-gray-600 py-1 z-50"
                     x-cloak>
                    
                    <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
                    </div>

                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                        <i class="ri-user-line text-lg mr-3"></i>
                        <span>Profile</span>
                    </a>

                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                        <i class="ri-settings-3-line text-lg mr-3"></i>
                        <span>Settings</span>
                    </a>

                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                        <i class="ri-question-line text-lg mr-3"></i>
                        <span>Help & Support</span>
                    </a>

                    <div class="border-t border-gray-200 dark:border-gray-600 my-1"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-gray-600">
                            <i class="ri-logout-box-line text-lg mr-3"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Preview Modal -->
    <div x-show="previewModal" 
         @click="previewModal = false"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
         x-cloak>
        <div @click.stop class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">App Preview</h3>
                <button @click="previewModal = false" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <i class="ri-close-line text-2xl"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="text-center">
                    <div class="mx-auto w-16 h-16 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mb-4">
                        <i class="ri-smartphone-line text-3xl text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">QR Code Preview</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Scan this QR code with your mobile app to see live changes</p>
                    
                    <!-- QR Code Placeholder -->
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-8 mb-4">
                        <div class="w-48 h-48 mx-auto bg-white rounded flex items-center justify-center">
                            <span class="text-gray-400">QR Code Here</span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <a href="{{ route('mightyweb.json.download') }}" 
                           target="_blank"
                           class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg">
                            <i class="ri-download-cloud-line text-lg mr-2"></i>
                            Download JSON
                        </a>
                        <button @click="previewModal = false" 
                                class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Initialize Alpine data -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('header', () => ({
            previewModal: false
        }));
    });
</script>
