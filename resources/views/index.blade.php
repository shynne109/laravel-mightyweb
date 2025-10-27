<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use MightyWeb\Models\AppSetting;
use MightyWeb\Services\FileUploadService;

new class extends Component {

    public string $activeTab = 'app-config';

    
    public function switchTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

}
?>
<div class="min-h-screen bg-gray-50 dark:bg-zinc-900">
    {{-- Header --}}
    <div class="bg-white dark:bg-zinc-800 border-b border-gray-200 dark:border-zinc-700 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="2xl" class="text-gray-900 dark:text-white">
                            MightyWeb Dashboard
                        </flux:heading>
                        <flux:subheading class="mt-1">
                            Manage your mobile app configuration in one place
                        </flux:subheading>
                    </div>
                    <div class="flex items-center gap-3">
                        <flux:badge size="lg" color="green" icon="check-circle">
                            v1.1.0
                        </flux:badge>
                    </div>
                </div>
            </div>

            {{-- Tab Navigation --}}
            <div class="flex space-x-1 overflow-x-auto pb-px -mb-px scrollbar-thin">
                <button wire:click="switchTab('app-config')"
                    @class([ 'group inline-flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors'
                    , 'border-primary-600 text-primary-600 dark:text-primary-400'=> $activeTab === 'app-config',
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400
                    dark:hover:text-gray-300' => $activeTab !== 'app-config',
                    ])>
                    <flux:icon.cog-6-tooth class="w-5 h-5" />
                    <span>App Config</span>
                </button>

                <button wire:click="switchTab('theme')"
                    @class([ 'group inline-flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors'
                    , 'border-primary-600 text-primary-600 dark:text-primary-400'=> $activeTab === 'theme',
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400
                    dark:hover:text-gray-300' => $activeTab !== 'theme',
                    ])>
                    <flux:icon.paint-brush class="w-5 h-5" />
                    <span>Theme</span>
                </button>

                <button wire:click="switchTab('walkthrough')"
                    @class([ 'group inline-flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors'
                    , 'border-primary-600 text-primary-600 dark:text-primary-400'=> $activeTab === 'walkthrough',
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400
                    dark:hover:text-gray-300' => $activeTab !== 'walkthrough',
                    ])>
                    <flux:icon.academic-cap class="w-5 h-5" />
                    <span>Walkthrough</span>
                </button>

                <button wire:click="switchTab('menu')"
                    @class([ 'group inline-flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors'
                    , 'border-primary-600 text-primary-600 dark:text-primary-400'=> $activeTab === 'menu',
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400
                    dark:hover:text-gray-300' => $activeTab !== 'menu',
                    ])>
                    <flux:icon.bars-3 class="w-5 h-5" />
                    <span>Menus</span>
                </button>

                <button wire:click="switchTab('pages')"
                    @class([ 'group inline-flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors'
                    , 'border-primary-600 text-primary-600 dark:text-primary-400'=> $activeTab === 'pages',
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400
                    dark:hover:text-gray-300' => $activeTab !== 'pages',
                    ])>
                    <flux:icon.document-text class="w-5 h-5" />
                    <span>Pages</span>
                </button>

                <button wire:click="switchTab('tabs')"
                    @class([ 'group inline-flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors'
                    , 'border-primary-600 text-primary-600 dark:text-primary-400'=> $activeTab === 'tabs',
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400
                    dark:hover:text-gray-300' => $activeTab !== 'tabs',
                    ])>
                    <flux:icon.view-columns class="w-5 h-5" />
                    <span>Bottom Tabs</span>
                </button>

                <button wire:click="switchTab('navigation-icons')"
                    @class([ 'group inline-flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors'
                    , 'border-primary-600 text-primary-600 dark:text-primary-400'=> $activeTab === 'navigation-icons',
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400
                    dark:hover:text-gray-300' => $activeTab !== 'navigation-icons',
                    ])>
                    <flux:icon.squares-2x2 class="w-5 h-5" />
                    <span>Nav Icons</span>
                </button>

                <button wire:click="switchTab('floating-button')"
                    @class([ 'group inline-flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors'
                    , 'border-primary-600 text-primary-600 dark:text-primary-400'=> $activeTab === 'floating-button',
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400
                    dark:hover:text-gray-300' => $activeTab !== 'floating-button',
                    ])>
                    <flux:icon.plus-circle class="w-5 h-5" />
                    <span>FAB</span>
                </button>
            </div>
        </div>
    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Welcome Message -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Welcome back, {{ auth()->user()->name ?? 'Admin' }}! 👋
                </h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Here's an overview of your mobile app configuration
                </p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <!-- Walkthrough Screens -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Walkthrough Screens</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                                {{ \MightyWeb\Models\Walkthrough::count() }}
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                            <i class="ri-slideshow-3-line text-2xl text-purple-600 dark:text-purple-400"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('mightyweb.walkthrough.index') }}"
                            class="text-sm text-primary-600 dark:text-primary-400 hover:underline flex items-center">
                            Manage Walkthrough
                            <i class="ri-arrow-right-line ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Menu Items -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Menu Items</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                                {{ \MightyWeb\Models\Menu::count() }}
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <i class="ri-menu-line text-2xl text-blue-600 dark:text-blue-400"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('mightyweb.menu.index') }}"
                            class="text-sm text-primary-600 dark:text-primary-400 hover:underline flex items-center">
                            Manage Menu
                            <i class="ri-arrow-right-line ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Bottom Tabs -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Bottom Tabs</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                                {{ \MightyWeb\Models\Tab::count() }}
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <i class="ri-layout-bottom-line text-2xl text-green-600 dark:text-green-400"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('mightyweb.tabs.index') }}"
                            class="text-sm text-primary-600 dark:text-primary-400 hover:underline flex items-center">
                            Manage Tabs
                            <i class="ri-arrow-right-line ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Pages -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pages</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                                {{ \MightyWeb\Models\Page::count() }}
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                            <i class="ri-pages-line text-2xl text-orange-600 dark:text-orange-400"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('mightyweb.pages.index') }}"
                            class="text-sm text-primary-600 dark:text-primary-400 hover:underline flex items-center">
                            Manage Pages
                            <i class="ri-arrow-right-line ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                            <i class="ri-flashlight-line text-xl mr-2 text-yellow-600"></i>
                            Quick Actions
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('mightyweb.configuration') }}"
                                class="flex flex-col items-center justify-center p-4 bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/20 dark:to-primary-800/20 rounded-lg hover:shadow-md transition-shadow border border-primary-200 dark:border-primary-700">
                                <i class="ri-settings-3-line text-3xl text-primary-600 dark:text-primary-400 mb-2"></i>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">App Config</span>
                            </a>

                            <a href="{{ route('mightyweb.walkthrough.index') }}"
                                class="flex flex-col items-center justify-center p-4 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg hover:shadow-md transition-shadow border border-purple-200 dark:border-purple-700">
                                <i class="ri-slideshow-3-line text-3xl text-purple-600 dark:text-purple-400 mb-2"></i>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Walkthrough</span>
                            </a>

                            <a href="{{ route('mightyweb.menu.index') }}"
                                class="flex flex-col items-center justify-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg hover:shadow-md transition-shadow border border-blue-200 dark:border-blue-700">
                                <i class="ri-menu-line text-3xl text-blue-600 dark:text-blue-400 mb-2"></i>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Menu</span>
                            </a>

                            <a href="{{ route('mightyweb.theme') }}"
                                class="flex flex-col items-center justify-center p-4 bg-gradient-to-br from-pink-50 to-pink-100 dark:from-pink-900/20 dark:to-pink-800/20 rounded-lg hover:shadow-md transition-shadow border border-pink-200 dark:border-pink-700">
                                <i class="ri-palette-line text-3xl text-pink-600 dark:text-pink-400 mb-2"></i>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Theme</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- App Status -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                            <i class="ri-information-line text-xl mr-2 text-blue-600"></i>
                            App Status
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">

                        @php
                        $appSettings = \MightyWeb\Models\AppSetting::pluck('value', 'key')->toArray();
                        @endphp

                        <!-- App Name & Version -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">App Name</p>
                                <p class="text-base font-semibold text-gray-900 dark:text-white">
                                    {{ $appSettings['app_name'] ?? 'Not Set' }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Version</p>
                                <p class="text-base font-semibold text-gray-900 dark:text-white">
                                    {{ $appSettings['app_version'] ?? '1.0.0' }}
                                </p>
                            </div>
                        </div>

                        <!-- Maintenance Mode -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="flex items-center">
                                <i class="ri-tools-line text-xl mr-3 text-gray-600 dark:text-gray-400"></i>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Maintenance Mode</span>
                            </div>
                            @if (filter_var($appSettings['maintenance_mode'] ?? false, FILTER_VALIDATE_BOOLEAN))
                            <span
                                class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 text-xs font-medium rounded-full">
                                Active
                            </span>
                            @else
                            <span
                                class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 text-xs font-medium rounded-full">
                                Inactive
                            </span>
                            @endif
                        </div>

                        <!-- Force Update -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="flex items-center">
                                <i class="ri-refresh-line text-xl mr-3 text-gray-600 dark:text-gray-400"></i>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Force Update</span>
                            </div>
                            @if (filter_var($appSettings['force_update'] ?? false, FILTER_VALIDATE_BOOLEAN))
                            <span
                                class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 text-xs font-medium rounded-full">
                                Enabled
                            </span>
                            @else
                            <span
                                class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 text-xs font-medium rounded-full">
                                Disabled
                            </span>
                            @endif
                        </div>

                        <!-- Cache Status -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="flex items-center">
                                <i class="ri-database-line text-xl mr-3 text-gray-600 dark:text-gray-400"></i>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Caching</span>
                            </div>
                            @if (filter_var($appSettings['cache_enabled'] ?? true, FILTER_VALIDATE_BOOLEAN))
                            <span
                                class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 text-xs font-medium rounded-full">
                                Enabled
                            </span>
                            @else
                            <span
                                class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 text-xs font-medium rounded-full">
                                Disabled
                            </span>
                            @endif
                        </div>

                        <!-- JSON Export -->
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('mightyweb.json.export') }}"
                                class="flex items-center justify-center w-full px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium transition-colors">
                                <i class="ri-download-line text-lg mr-2"></i>
                                Export JSON Configuration
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Getting Started Guide (Optional - shown when stats are zero) -->
            @if (\MightyWeb\Models\Walkthrough::count() === 0 &&
            \MightyWeb\Models\Menu::count() === 0 &&
            \MightyWeb\Models\Tab::count() === 0)
            <div
                class="mt-8 bg-gradient-to-r from-primary-50 to-purple-50 dark:from-primary-900/20 dark:to-purple-900/20 rounded-lg border border-primary-200 dark:border-primary-700 p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-primary-600 rounded-lg flex items-center justify-center">
                            <i class="ri-lightbulb-line text-2xl text-white"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            Getting Started with MightyWeb
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            Let's set up your mobile app! Follow these steps to get started:
                        </p>
                        <ol class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                            <li class="flex items-center">
                                <span
                                    class="flex-shrink-0 w-6 h-6 bg-primary-600 text-white rounded-full flex items-center justify-center text-xs font-bold mr-3">1</span>
                                <span>Configure your app basic information and settings</span>
                            </li>
                            <li class="flex items-center">
                                <span
                                    class="flex-shrink-0 w-6 h-6 bg-primary-600 text-white rounded-full flex items-center justify-center text-xs font-bold mr-3">2</span>
                                <span>Create walkthrough screens to introduce your app</span>
                            </li>
                            <li class="flex items-center">
                                <span
                                    class="flex-shrink-0 w-6 h-6 bg-primary-600 text-white rounded-full flex items-center justify-center text-xs font-bold mr-3">3</span>
                                <span>Set up your menu items and navigation</span>
                            </li>
                            <li class="flex items-center">
                                <span
                                    class="flex-shrink-0 w-6 h-6 bg-primary-600 text-white rounded-full flex items-center justify-center text-xs font-bold mr-3">4</span>
                                <span>Customize theme colors and appearance</span>
                            </li>
                            <li class="flex items-center">
                                <span
                                    class="flex-shrink-0 w-6 h-6 bg-primary-600 text-white rounded-full flex items-center justify-center text-xs font-bold mr-3">5</span>
                                <span>Export your configuration and test in your mobile app</span>
                            </li>
                        </ol>
                        <div class="mt-4">
                            <a href="{{ route('mightyweb.configuration') }}"
                                class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium transition-colors">
                                Start Configuration
                                <i class="ri-arrow-right-line ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

    {{-- Tab Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- App Configuration Tab --}}
        @if ($activeTab === 'app-config')
        <div x-data x-show="true" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            @livewire('mightyweb.app-configuration')
        </div>
        @endif

        {{-- Theme Configuration Tab --}}
        @if ($activeTab === 'theme')
        <div x-data x-show="true" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            @livewire('mightyweb.theme.configuration')
        </div>
        @endif

        {{-- Walkthrough Tab --}}
        @if ($activeTab === 'walkthrough')
        <div x-data x-show="true" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            @livewire('mightyweb.walkthrough.index')
        </div>
        @endif

        {{-- Menu Tab --}}
        @if ($activeTab === 'menu')
        <div x-data x-show="true" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            @livewire('mightyweb.menu.index')
        </div>
        @endif

        {{-- Pages Tab --}}
        @if ($activeTab === 'pages')
        <div x-data x-show="true" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            @livewire('mightyweb.page.index')
        </div>
        @endif

        {{-- Bottom Tabs Tab --}}
        @if ($activeTab === 'tabs')
        <div x-data x-show="true" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            @livewire('mightyweb.tab.index')
        </div>
        @endif

        {{-- Navigation Icons Tab --}}
        @if ($activeTab === 'navigation-icons')
        <div x-data x-show="true" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            @livewire('mightyweb.navigation-icon.index')
        </div>
        @endif

        {{-- Floating Button Tab --}}
        @if ($activeTab === 'floating-button')
        <div x-data x-show="true" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            @livewire('mightyweb.floating-button.index')
        </div>
        @endif
    </div>

    {{-- Quick Info Footer --}}
    <div class="fixed bottom-4 right-4 z-50">
        <flux:badge size="sm" color="zinc" class="shadow-lg">
            <flux:icon.cube class="w-3 h-3" />
            Active: {{ ucwords(str_replace('-', ' ', $activeTab)) }}
        </flux:badge>
    </div>
</div>