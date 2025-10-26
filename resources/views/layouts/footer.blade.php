<footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-auto">
    <div class="px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex flex-col sm:flex-row items-center justify-between space-y-2 sm:space-y-0">
            
            <!-- Copyright -->
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <p>© {{ date('Y') }} <span class="font-semibold">MightyWeb</span>. All rights reserved.</p>
            </div>

            <!-- Version & Links -->
            <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                <span class="font-medium">v1.0.0</span>
                <span class="text-gray-300 dark:text-gray-600">|</span>
                <a href="https://github.com/mightyweb" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors flex items-center">
                    <i class="ri-github-fill text-lg mr-1"></i>
                    <span class="hidden sm:inline">GitHub</span>
                </a>
                <span class="text-gray-300 dark:text-gray-600">|</span>
                <a href="https://docs.mightyweb.com" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors flex items-center">
                    <i class="ri-book-line text-lg mr-1"></i>
                    <span class="hidden sm:inline">Documentation</span>
                </a>
                <span class="text-gray-300 dark:text-gray-600">|</span>
                <a href="mailto:support@mightyweb.com" 
                   class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors flex items-center">
                    <i class="ri-mail-line text-lg mr-1"></i>
                    <span class="hidden sm:inline">Support</span>
                </a>
            </div>
        </div>

        <!-- Additional Info (Optional) -->
        <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700 hidden sm:block">
            <div class="flex flex-wrap items-center justify-between text-xs text-gray-500 dark:text-gray-500">
                <div class="flex items-center space-x-4">
                    <span class="flex items-center">
                        <i class="ri-shield-check-line text-sm mr-1 text-green-500"></i>
                        Secure
                    </span>
                    <span class="flex items-center">
                        <i class="ri-flashlight-line text-sm mr-1 text-yellow-500"></i>
                        Fast
                    </span>
                    <span class="flex items-center">
                        <i class="ri-smartphone-line text-sm mr-1 text-blue-500"></i>
                        Mobile Ready
                    </span>
                </div>
                <div>
                    Built with <i class="ri-heart-fill text-red-500 mx-1"></i> using <span class="font-semibold">Laravel</span> & <span class="font-semibold">Livewire</span>
                </div>
            </div>
        </div>
    </div>
</footer>
