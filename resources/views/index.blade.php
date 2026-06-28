<?php

use Illuminate\Support\Facades\Storage;
use Flux\Flux;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use MightyWeb\Services\JsonExportService;

new class extends Component {

    #[Url(as: 'tab')]
    public string $activeTab = 'app-config';

    public function rendering($view): void
    {
        $this->layout(config('mightyweb.layout', 'mightyweb::layouts.app'));
    }

    #[Computed]
    public function configUrl()
    {
        $disk = config('mightyweb.json_export.disk', 'public');
        $path = config('mightyweb.json_export.path', 'app');
        $filename = config('mightyweb.json_export.filename', 'app.json');
        
        $fullPath = $path . '/' . $filename;
        
        if (!Storage::disk($disk)->exists($fullPath)) {
            return "";
        }

        return Storage::disk($disk)->url($fullPath);
    }

    public function exportConfiguration()
    {
        try {
            $jsonExportService = app(JsonExportService::class);
            $path = $jsonExportService->exportToFile();

            if ($path === false) {
                Flux::toast(
                    heading: 'Export failed.',
                    text: 'Failed to export configuration. Please try again.',
                    variant: 'danger'
                );
            }
            Flux::toast(
                heading: 'Export successful.',
                text: 'Configuration exported successfully!',
                variant: 'success'
            );
        } catch (\Exception $e) {
            Flux::toast(
                heading: 'Export failed.',
                text: 'Error during export: ' . $e->getMessage(),
                variant: 'danger'
            );            
        }
    }

}
?>
<div x-data="{ activeTab: @entangle('activeTab').live }" class="min-h-screen bg-gray-50 dark:bg-zinc-900">
    {{-- Header --}}
    <div class="bg-white dark:bg-zinc-800 border-b border-gray-200 dark:border-zinc-700 sticky top-0 z-40">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row justify-between items-center">
                <div>
                    <h1 class="text-lg font-medium">App Configuration</h1>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage application settings and configurations.</p>
                </div>
                <div>
                    <flux:input icon="link" value="{{ $this->configUrl }}" readonly copyable />
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

    {{-- Tab Content --}}
    <div class="w-full py-4">
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
        <flux:button
            icon="arrow-down-tray"
            variant="primary"
            size="sm"
            class="mr-2"
            wire:click="exportConfiguration"
        >
            Export
        </flux:button>
        <flux:badge size="sm" color="zinc" class="shadow-lg">
            <flux:icon.cube class="w-3 h-3" />
            Active: <span x-text="activeTab.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase())"></span>
        </flux:badge>
    </div>
</div>