<?php

use Livewire\Volt\Component;
use MightyWeb\Models\Theme;

new class extends Component {
    public ?Theme $theme = null;
    public string $primary_color = '';
    public string $secondary_color = '';
    public string $accent_color = '';
    public string $background_color = '';
    public string $text_color = '';
    public string $font_family = '';
    public string $style_preset = '';
    public bool $is_dark_mode = false;

    public array $availableFonts = [
        'Roboto' => 'Roboto',
        'Open Sans' => 'Open Sans',
        'Lato' => 'Lato',
        'Montserrat' => 'Montserrat',
        'Poppins' => 'Poppins',
        'Inter' => 'Inter',
        'Nunito' => 'Nunito',
        'Raleway' => 'Raleway',
    ];

    public array $stylePresets = [
        'default' => [
            'name' => 'Default',
            'primary_color' => '#3B82F6',
            'secondary_color' => '#8B5CF6',
            'accent_color' => '#10B981',
            'background_color' => '#FFFFFF',
            'text_color' => '#1F2937',
        ],
        'dark' => [
            'name' => 'Dark Theme',
            'primary_color' => '#60A5FA',
            'secondary_color' => '#A78BFA',
            'accent_color' => '#34D399',
            'background_color' => '#1F2937',
            'text_color' => '#F9FAFB',
        ],
        'ocean' => [
            'name' => 'Ocean Blue',
            'primary_color' => '#0EA5E9',
            'secondary_color' => '#06B6D4',
            'accent_color' => '#14B8A6',
            'background_color' => '#F0F9FF',
            'text_color' => '#164E63',
        ],
        'sunset' => [
            'name' => 'Sunset Orange',
            'primary_color' => '#F97316',
            'secondary_color' => '#EF4444',
            'accent_color' => '#FBBF24',
            'background_color' => '#FFF7ED',
            'text_color' => '#7C2D12',
        ],
        'forest' => [
            'name' => 'Forest Green',
            'primary_color' => '#10B981',
            'secondary_color' => '#059669',
            'accent_color' => '#84CC16',
            'background_color' => '#F0FDF4',
            'text_color' => '#14532D',
        ],
    ];

    public function mount(): void
    {
        $this->theme = Theme::firstOrCreate(
            ['id' => 1],
            [
                'primary_color' => '#3B82F6',
                'secondary_color' => '#8B5CF6',
                'accent_color' => '#10B981',
                'background_color' => '#FFFFFF',
                'text_color' => '#1F2937',
                'font_family' => 'Roboto',
                'style_preset' => 'default',
                'is_dark_mode' => false,
            ]
        );

        $this->loadThemeData();
    }

    protected function loadThemeData(): void
    {
        $this->primary_color = $this->theme->primary_color;
        $this->secondary_color = $this->theme->secondary_color;
        $this->accent_color = $this->theme->accent_color;
        $this->background_color = $this->theme->background_color;
        $this->text_color = $this->theme->text_color;
        $this->font_family = $this->theme->font_family;
        $this->style_preset = $this->theme->style_preset;
        $this->is_dark_mode = $this->theme->is_dark_mode;
    }

    protected function rules(): array
    {
        return [
            'primary_color' => 'required|string|regex:/^#[A-Fa-f0-9]{6}$/',
            'secondary_color' => 'required|string|regex:/^#[A-Fa-f0-9]{6}$/',
            'accent_color' => 'required|string|regex:/^#[A-Fa-f0-9]{6}$/',
            'background_color' => 'required|string|regex:/^#[A-Fa-f0-9]{6}$/',
            'text_color' => 'required|string|regex:/^#[A-Fa-f0-9]{6}$/',
            'font_family' => 'required|string|max:100',
            'style_preset' => 'required|string|max:50',
            'is_dark_mode' => 'boolean',
        ];
    }

    public function applyPreset(): void
    {
        if (isset($this->stylePresets[$this->style_preset])) {
            $preset = $this->stylePresets[$this->style_preset];
            
            $this->primary_color = $preset['primary_color'];
            $this->secondary_color = $preset['secondary_color'];
            $this->accent_color = $preset['accent_color'];
            $this->background_color = $preset['background_color'];
            $this->text_color = $preset['text_color'];
            
            $this->is_dark_mode = ($this->style_preset === 'dark');

            session()->flash('info', 'Preset applied. Click "Save Changes" to persist.');
        }
    }

    public function resetToDefaults(): void
    {
        $this->style_preset = 'default';
        $this->applyPreset();
        $this->font_family = 'Roboto';
        
        session()->flash('info', 'Reset to defaults. Click "Save Changes" to persist.');
    }

    public function save(): void
    {
        $this->validate();

        $this->theme->update([
            'primary_color' => $this->primary_color,
            'secondary_color' => $this->secondary_color,
            'accent_color' => $this->accent_color,
            'background_color' => $this->background_color,
            'text_color' => $this->text_color,
            'font_family' => $this->font_family,
            'style_preset' => $this->style_preset,
            'is_dark_mode' => $this->is_dark_mode,
        ]);

        session()->flash('success', 'Theme configuration saved successfully.');
    }
}; ?>

<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h2 size="xl">Theme Configuration</h2>
        <p size="sm" class="text-gray-600 dark:text-gray-400">Customize your app's colors, fonts, and visual style</p>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('info'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-200 px-4 py-3 rounded-lg">
            {{ session('info') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-show="show" class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Info Card -->
    <div class="mb-6 bg-gradient-to-r from-purple-50 to-blue-50 dark:from-purple-900/20 dark:to-blue-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div class="text-sm text-purple-800 dark:text-purple-200">
                <p class="font-medium mb-1">Theme applies to the entire mobile app</p>
                <p>Colors and fonts set here will be exported to the JSON configuration file for use in your mobile application. Changes take effect after re-exporting the configuration.</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Color Configuration -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Style Presets -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Style Presets</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Quick start with pre-configured themes</p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach($stylePresets as $key => $preset)
                                <button type="button"
                                        wire:click="$set('style_preset', '{{ $key }}')"
                                        wire:then="applyPreset"
                                        class="relative p-4 border-2 rounded-lg transition @if($style_preset === $key) border-blue-500 bg-blue-50 dark:bg-blue-900/20 @else border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-700 @endif">
                                    <div class="flex space-x-2 mb-2">
                                        <div class="w-6 h-6 rounded" style="background-color: {{ $preset['primary_color'] }}"></div>
                                        <div class="w-6 h-6 rounded" style="background-color: {{ $preset['secondary_color'] }}"></div>
                                        <div class="w-6 h-6 rounded" style="background-color: {{ $preset['accent_color'] }}"></div>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $preset['name'] }}</p>
                                    @if($style_preset === $key)
                                        <svg class="absolute top-2 right-2 w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Custom Colors -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Custom Colors</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Fine-tune your theme colors</p>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Primary Color -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Primary Color <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center space-x-4">
                                <input type="color" 
                                       wire:model.live="primary_color" 
                                       class="h-12 w-20 rounded-lg border-2 border-gray-300 dark:border-gray-600 cursor-pointer">
                                <input type="text" 
                                       wire:model.blur="primary_color" 
                                       class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg font-mono text-sm dark:bg-gray-700 dark:text-white uppercase focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="#3B82F6"
                                       maxlength="7">
                                <div class="w-12 h-12 rounded-lg border-2 border-gray-300 dark:border-gray-600" style="background-color: {{ $primary_color }}"></div>
                            </div>
                            @error('primary_color')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Secondary Color -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Secondary Color <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center space-x-4">
                                <input type="color" 
                                       wire:model.live="secondary_color" 
                                       class="h-12 w-20 rounded-lg border-2 border-gray-300 dark:border-gray-600 cursor-pointer">
                                <input type="text" 
                                       wire:model.blur="secondary_color" 
                                       class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg font-mono text-sm dark:bg-gray-700 dark:text-white uppercase focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="#8B5CF6"
                                       maxlength="7">
                                <div class="w-12 h-12 rounded-lg border-2 border-gray-300 dark:border-gray-600" style="background-color: {{ $secondary_color }}"></div>
                            </div>
                            @error('secondary_color')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Accent Color -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Accent Color <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center space-x-4">
                                <input type="color" 
                                       wire:model.live="accent_color" 
                                       class="h-12 w-20 rounded-lg border-2 border-gray-300 dark:border-gray-600 cursor-pointer">
                                <input type="text" 
                                       wire:model.blur="accent_color" 
                                       class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg font-mono text-sm dark:bg-gray-700 dark:text-white uppercase focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="#10B981"
                                       maxlength="7">
                                <div class="w-12 h-12 rounded-lg border-2 border-gray-300 dark:border-gray-600" style="background-color: {{ $accent_color }}"></div>
                            </div>
                            @error('accent_color')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Background Color -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Background Color <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center space-x-4">
                                <input type="color" 
                                       wire:model.live="background_color" 
                                       class="h-12 w-20 rounded-lg border-2 border-gray-300 dark:border-gray-600 cursor-pointer">
                                <input type="text" 
                                       wire:model.blur="background_color" 
                                       class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg font-mono text-sm dark:bg-gray-700 dark:text-white uppercase focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="#FFFFFF"
                                       maxlength="7">
                                <div class="w-12 h-12 rounded-lg border-2 border-gray-300 dark:border-gray-600" style="background-color: {{ $background_color }}"></div>
                            </div>
                            @error('background_color')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Text Color -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Text Color <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center space-x-4">
                                <input type="color" 
                                       wire:model.live="text_color" 
                                       class="h-12 w-20 rounded-lg border-2 border-gray-300 dark:border-gray-600 cursor-pointer">
                                <input type="text" 
                                       wire:model.blur="text_color" 
                                       class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg font-mono text-sm dark:bg-gray-700 dark:text-white uppercase focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="#1F2937"
                                       maxlength="7">
                                <div class="w-12 h-12 rounded-lg border-2 border-gray-300 dark:border-gray-600" style="background-color: {{ $text_color }}"></div>
                            </div>
                            @error('text_color')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Preview & Settings -->
            <div class="space-y-6">
                <!-- Font Family -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Typography</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label for="font_family" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Font Family <span class="text-red-500">*</span>
                            </label>
                            <select id="font_family" 
                                    wire:model.live="font_family"
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @foreach($availableFonts as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('font_family')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Preview:</p>
                            <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700" style="font-family: {{ $font_family }}, sans-serif;">
                                <p class="text-lg font-semibold mb-1">The quick brown fox</p>
                                <p class="text-sm">jumps over the lazy dog</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Theme Mode -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Theme Mode</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <label for="is_dark_mode" class="text-sm font-medium text-gray-700 dark:text-gray-300">Dark Mode</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Enable dark theme by default</p>
                            </div>
                            <button type="button"
                                    wire:click="$toggle('is_dark_mode')"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 @if($is_dark_mode) bg-blue-600 @else bg-gray-200 dark:bg-gray-700 @endif">
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform @if($is_dark_mode) translate-x-6 @else translate-x-1 @endif"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Color Preview -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Live Preview</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3 p-4 rounded-lg border-2 border-gray-200 dark:border-gray-700" style="background-color: {{ $background_color }}; color: {{ $text_color }}; font-family: {{ $font_family }}, sans-serif;">
                            <button type="button" class="w-full px-4 py-2 rounded-lg font-medium text-white" style="background-color: {{ $primary_color }}">
                                Primary Button
                            </button>
                            <button type="button" class="w-full px-4 py-2 rounded-lg font-medium text-white" style="background-color: {{ $secondary_color }}">
                                Secondary Button
                            </button>
                            <button type="button" class="w-full px-4 py-2 rounded-lg font-medium text-white" style="background-color: {{ $accent_color }}">
                                Accent Button
                            </button>
                            <p class="text-sm mt-4 pt-4 border-t" style="border-color: {{ $text_color }}33;">
                                Sample text paragraph using the selected text color and font family.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="p-6 space-y-3">
                        <button type="submit" 
                                wire:loading.attr="disabled"
                                class="w-full inline-flex justify-center items-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors disabled:opacity-50">
                            <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="save">Save Changes</span>
                            <span wire:loading wire:target="save">Saving...</span>
                        </button>

                        <button type="button" 
                                wire:click="resetToDefaults"
                                wire:loading.attr="disabled"
                                class="w-full px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg transition-colors disabled:opacity-50">
                            Reset to Defaults
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

