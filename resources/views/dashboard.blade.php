<?php

use Livewire\Attributes\Computed;
use Livewire\Component;
use MightyWeb\Models\AppSetting;
use MightyWeb\Models\Menu;
use MightyWeb\Models\Page;
use MightyWeb\Models\Tab;
use MightyWeb\Models\Walkthrough;

new class extends Component {

    public string $activeTab = 'app-config';

    #[Computed]
    public function walkthroughCount(): int
    {
        return Walkthrough::count();
    }

    #[Computed]
    public function menuCount(): int
    {
        return Menu::count();
    }

    #[Computed]
    public function tabCount(): int
    {
        return Tab::count();
    }

    #[Computed]
    public function pageCount(): int
    {
        return Page::count();
    }

    #[Computed]
    public function appSettings(): array
    {
        return AppSetting::pluck('value', 'key')->toArray();
    }

    #[Computed]
    public function hasNoContent(): bool
    {
        return $this->walkthroughCount === 0
            && $this->menuCount === 0
            && $this->tabCount === 0;
    }

}
?>
<div x-data="{ activeTab: @entangle('activeTab') }" class="min-h-screen bg-gray-50 dark:bg-zinc-900">
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
                <template x-for="tab in [
                    { key: 'app-config', label: 'App Config', icon: 'cog-6-tooth' },
                    { key: 'theme', label: 'Theme', icon: 'paint-brush' },
                    { key: 'walkthrough', label: 'Walkthrough', icon: 'academic-cap' },
                    { key: 'menu', label: 'Menus', icon: 'bars-3' },
                    { key: 'pages', label: 'Pages', icon: 'document-text' },
                    { key: 'tabs', label: 'Bottom Tabs', icon: 'view-columns' },
                    { key: 'navigation-icons', label: 'Nav Icons', icon: 'squares-2x2' },
                    { key: 'floating-button', label: 'FAB', icon: 'plus-circle' },
                ]" :key="tab.key">
                    <button @click="activeTab = tab.key"
                        :class="activeTab === tab.key
                            ? 'border-primary-600 text-primary-600 dark:text-primary-400'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                        class="group inline-flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">
                        <flux:icon :name="$tab.icon" class="w-5 h-5" />
                        <span x-text="tab.label"></span>
                    </button>
                </template>
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
                                {{ $this->walkthroughCount }}
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
                                {{ $this->menuCount }}
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                            <i class="ri-menu-line text-2xl text-primary-600 dark:text-primary-400"></i>
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
                                {{ $this->tabCount }}
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
                                {{ $this->pageCount }}
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
                                class="flex flex-col items-center justify-center p-4 bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/20 dark:to-primary-800/20 rounded-lg hover:shadow-md transition-shadow border border-primary-200 dark:border-primary-700">
                                <i class="ri-menu-line text-3xl text-primary-600 dark:text-primary-400 mb-2"></i>
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
                            <i class="ri-information-line text-xl mr-2 text-primary-600"></i>
                            App Status
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">

                        <!-- App Name & Version -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">App Name</p>
                                <p class="text-base font-semibold text-gray-900 dark:text-white">
                                    {{ $this->appSettings['app_name'] ?? 'Not Set' }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Version</p>
                                <p class="text-base font-semibold text-gray-900 dark:text-white">
                                    {{ $this->appSettings['app_version'] ?? '1.0.0' }}
                                </p>
                            </div>
                        </div>

                        <!-- Maintenance Mode -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="flex items-center">
                                <i class="ri-tools-line text-xl mr-3 text-gray-600 dark:text-gray-400"></i>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Maintenance Mode</span>
                            </div>
                            @if (filter_var($this->appSettings['maintenance_mode'] ?? false, FILTER_VALIDATE_BOOLEAN))
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
                            @if (filter_var($this->appSettings['force_update'] ?? false, FILTER_VALIDATE_BOOLEAN))
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
                            @if (filter_var($this->appSettings['cache_enabled'] ?? true, FILTER_VALIDATE_BOOLEAN))
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
            @if ($this->hasNoContent)
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
        <div x-show="activeTab === 'app-config'" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            <livewire:mightyweb::app-configuration />
        </div>

        <div x-show="activeTab === 'theme'" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            <livewire:mightyweb::theme.configuration />
        </div>

        <div x-show="activeTab === 'walkthrough'" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            <livewire:mightyweb::walkthrough.index />
        </div>

        <div x-show="activeTab === 'menu'" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            <livewire:mightyweb::menu.index />
        </div>

        <div x-show="activeTab === 'pages'" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            <livewire:mightyweb::page.index />
        </div>

        <div x-show="activeTab === 'tabs'" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            <livewire:mightyweb::tab.index />
        </div>

        <div x-show="activeTab === 'navigation-icons'" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            <livewire:mightyweb::navigation-icon.index />
        </div>

        <div x-show="activeTab === 'floating-button'" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            <livewire:mightyweb::floating-button.index />
        </div>
    </div>

    {{-- Quick Info Footer --}}
    <div class="fixed bottom-4 right-4 z-50">
        <flux:badge size="sm" color="zinc" class="shadow-lg">
            <flux:icon.cube class="w-3 h-3" />
            Active: <span x-text="activeTab.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase())"></span>
        </flux:badge>
    </div>
</div>