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
                <button 
                    wire:click="switchTab('app-config')"
                    @class([
                        'group inline-flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors',
                        'border-primary-600 text-primary-600 dark:text-primary-400' => $activeTab === 'app-config',
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' => $activeTab !== 'app-config',
                    ])>
                    <flux:icon.cog-6-tooth class="w-5 h-5" />
                    <span>App Config</span>
                </button>

                <button 
                    wire:click="switchTab('theme')"
                    @class([
                        'group inline-flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors',
                        'border-primary-600 text-primary-600 dark:text-primary-400' => $activeTab === 'theme',
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' => $activeTab !== 'theme',
                    ])>
                    <flux:icon.paint-brush class="w-5 h-5" />
                    <span>Theme</span>
                </button>

                <button 
                    wire:click="switchTab('walkthrough')"
                    @class([
                        'group inline-flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors',
                        'border-primary-600 text-primary-600 dark:text-primary-400' => $activeTab === 'walkthrough',
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' => $activeTab !== 'walkthrough',
                    ])>
                    <flux:icon.academic-cap class="w-5 h-5" />
                    <span>Walkthrough</span>
                </button>

                <button 
                    wire:click="switchTab('menu')"
                    @class([
                        'group inline-flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors',
                        'border-primary-600 text-primary-600 dark:text-primary-400' => $activeTab === 'menu',
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' => $activeTab !== 'menu',
                    ])>
                    <flux:icon.bars-3 class="w-5 h-5" />
                    <span>Menus</span>
                </button>

                <button 
                    wire:click="switchTab('pages')"
                    @class([
                        'group inline-flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors',
                        'border-primary-600 text-primary-600 dark:text-primary-400' => $activeTab === 'pages',
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' => $activeTab !== 'pages',
                    ])>
                    <flux:icon.document-text class="w-5 h-5" />
                    <span>Pages</span>
                </button>

                <button 
                    wire:click="switchTab('tabs')"
                    @class([
                        'group inline-flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors',
                        'border-primary-600 text-primary-600 dark:text-primary-400' => $activeTab === 'tabs',
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' => $activeTab !== 'tabs',
                    ])>
                    <flux:icon.view-columns class="w-5 h-5" />
                    <span>Bottom Tabs</span>
                </button>

                <button 
                    wire:click="switchTab('navigation-icons')"
                    @class([
                        'group inline-flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors',
                        'border-primary-600 text-primary-600 dark:text-primary-400' => $activeTab === 'navigation-icons',
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' => $activeTab !== 'navigation-icons',
                    ])>
                    <flux:icon.squares-2x2 class="w-5 h-5" />
                    <span>Nav Icons</span>
                </button>

                <button 
                    wire:click="switchTab('floating-button')"
                    @class([
                        'group inline-flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors',
                        'border-primary-600 text-primary-600 dark:text-primary-400' => $activeTab === 'floating-button',
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' => $activeTab !== 'floating-button',
                    ])>
                    <flux:icon.plus-circle class="w-5 h-5" />
                    <span>FAB</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Tab Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- App Configuration Tab --}}
        @if ($activeTab === 'app-config')
            <div x-data x-show="true" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                @livewire('mightyweb.app-configuration')
            </div>
        @endif

        {{-- Theme Configuration Tab --}}
        @if ($activeTab === 'theme')
            <div x-data x-show="true" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                @livewire('mightyweb.theme.configuration')
            </div>
        @endif

        {{-- Walkthrough Tab --}}
        @if ($activeTab === 'walkthrough')
            <div x-data x-show="true" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                @livewire('mightyweb.walkthrough.index')
            </div>
        @endif

        {{-- Menu Tab --}}
        @if ($activeTab === 'menu')
            <div x-data x-show="true" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                @livewire('mightyweb.menu.index')
            </div>
        @endif

        {{-- Pages Tab --}}
        @if ($activeTab === 'pages')
            <div x-data x-show="true" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                @livewire('mightyweb.page.index')
            </div>
        @endif

        {{-- Bottom Tabs Tab --}}
        @if ($activeTab === 'tabs')
            <div x-data x-show="true" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                @livewire('mightyweb.tab.index')
            </div>
        @endif

        {{-- Navigation Icons Tab --}}
        @if ($activeTab === 'navigation-icons')
            <div x-data x-show="true" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                @livewire('mightyweb.navigation-icon.index')
            </div>
        @endif

        {{-- Floating Button Tab --}}
        @if ($activeTab === 'floating-button')
            <div x-data x-show="true" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
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
