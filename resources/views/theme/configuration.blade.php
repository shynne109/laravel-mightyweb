<?php

use Livewire\Volt\Component;
use MightyWeb\Models\AppSetting;

new class extends Component {
    public string $themeStyle = 'Default';
    public string $customColor = '#195CDD';
    public string $gradientColor1 = '#4788ff';
    public string $gradientColor2 = '#4788ff';

    public array $themeOptions = [
        ['value' => 'Default', 'label' => 'Default', 'preview' => '#195CDD'],
        ['value' => 'Theme1', 'label' => 'Theme 1', 'preview' => '#880e4f'],
        ['value' => 'Theme2', 'label' => 'Theme 2', 'preview' => '#e667b1'],
        ['value' => 'Theme3', 'label' => 'Theme 3', 'preview' => '#4a148c'],
        ['value' => 'Theme4', 'label' => 'Theme 4', 'preview' => '#b71c1c'],
        ['value' => 'Theme5', 'label' => 'Theme 5', 'preview' => '#1a237e'],
        ['value' => 'Theme6', 'label' => 'Theme 6', 'preview' => '#0d47a1'],
        ['value' => 'Theme7', 'label' => 'Theme 7', 'preview' => '#01579b'],
        ['value' => 'Theme8', 'label' => 'Theme 8', 'preview' => '#094c4f'],
        ['value' => 'Theme9', 'label' => 'Theme 9', 'preview' => '#bfc726'],
        ['value' => 'Theme10', 'label' => 'Theme 10', 'preview' => '#1b5e20'],
        ['value' => 'Theme11', 'label' => 'Theme 11', 'preview' => '#ba8d06'],
        ['value' => 'Theme12', 'label' => 'Theme 12', 'preview' => '#6835f2'],
        ['value' => 'Theme13', 'label' => 'Theme 13', 'preview' => '#212121'],
        ['value' => 'Theme14', 'label' => 'Theme 14', 'preview' => '#263238'],
        ['value' => 'Theme15', 'label' => 'Theme 15', 'preview' => '#dd2c00'],
        ['value' => 'Theme16', 'label' => 'Theme 16', 'preview' => '#1b5ddb'],
    ];

    public function mount(): void
    {
        $themeData = AppSetting::get('theme');
        
        if ($themeData) {
            $this->themeStyle = $themeData['themeStyle'] ?? 'Default';
            $this->customColor = $themeData['customColor'] ?? '#195CDD';
            $this->gradientColor1 = $themeData['gradientColor1'] ?? '#4788ff';
            $this->gradientColor2 = $themeData['gradientColor2'] ?? '#4788ff';
        }
    }

    protected function rules(): array
    {
        return [
            'themeStyle' => 'required|string',
            'customColor' => 'required|string|regex:/^#[A-Fa-f0-9]{6}$/',
            'gradientColor1' => 'required|string|regex:/^#[A-Fa-f0-9]{6}$/',
            'gradientColor2' => 'required|string|regex:/^#[A-Fa-f0-9]{6}$/',
        ];
    }

    public function save(): void
    {
        $this->validate();

        $themeData = [
            'themeStyle' => $this->themeStyle,
            'customColor' => $this->customColor,
            'gradientColor1' => $this->gradientColor1,
            'gradientColor2' => $this->gradientColor2,
        ];

        AppSetting::set('theme', $themeData);

        session()->flash('success', 'Theme configuration saved successfully!');
    }
}; ?>

<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <flux:heading size="xl">Theme Style</flux:heading>
        <flux:subheading>Customize your app's theme and colors</flux:subheading>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="mb-6">
            <flux:badge size="lg" color="green" variant="solid" icon="check-circle">
                {{ session('success') }}
            </flux:badge>
        </div>
    @endif

    <!-- Form -->
    <form wire:submit.prevent="save">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="p-6 space-y-6">
                <!-- Predefined Themes -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Predefined Themes</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach ($themeOptions as $option)
                            <label class="cursor-pointer">
                                <input type="radio" 
                                       wire:model.live="themeStyle" 
                                       name="themeStyle" 
                                       value="{{ $option['value'] }}" 
                                       class="sr-only peer">
                                <div class="flex items-center justify-between p-4 border-2 rounded-lg transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $option['label'] }}</span>
                                    <div class="w-10 h-10 rounded" style="background-color: {{ $option['preview'] }}"></div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Custom Color Theme -->
                <div>
                    <label class="cursor-pointer flex items-center">
                        <input type="radio" 
                               wire:model.live="themeStyle" 
                               name="themeStyle" 
                               value="Custom" 
                               class="w-4 h-4 text-blue-600 border-gray-300 dark:border-gray-600 focus:ring-blue-500">
                        <span class="ml-3 text-sm font-semibold text-gray-700 dark:text-gray-300">Custom Color Theme</span>
                    </label>
                    
                    @if ($themeStyle === 'Custom')
                        <div class="mt-4 ml-7 max-w-md">
                            <label for="customColor" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Custom Color</label>
                            <div class="flex items-center space-x-4">
                                <input type="color" 
                                       wire:model.defer="customColor" 
                                       id="customColor"
                                       class="h-12 w-20 rounded-lg border-2 border-gray-300 dark:border-gray-600 cursor-pointer">
                                <input type="text" 
                                       wire:model.defer="customColor" 
                                       class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg font-mono text-sm dark:bg-gray-700 dark:text-white uppercase focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="#4788ff"
                                       maxlength="7">
                            </div>
                            @error('customColor')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                </div>

                <!-- Gradient Color Theme -->
                <div>
                    <label class="cursor-pointer flex items-center">
                        <input type="radio" 
                               wire:model.live="themeStyle" 
                               name="themeStyle" 
                               value="Gradient" 
                               class="w-4 h-4 text-blue-600 border-gray-300 dark:border-gray-600 focus:ring-blue-500">
                        <span class="ml-3 text-sm font-semibold text-gray-700 dark:text-gray-300">Gradient Color Theme</span>
                    </label>
                    
                    @if ($themeStyle === 'Gradient')
                        <div class="mt-4 ml-7">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <label for="gradientColor1" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gradient Color 1</label>
                                        <div class="flex items-center space-x-4">
                                            <input type="color" 
                                                   wire:model.live="gradientColor1" 
                                                   id="gradientColor1"
                                                   class="h-12 w-20 rounded-lg border-2 border-gray-300 dark:border-gray-600 cursor-pointer">
                                            <input type="text" 
                                                   wire:model.defer="gradientColor1" 
                                                   class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg font-mono text-sm dark:bg-gray-700 dark:text-white uppercase focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                   placeholder="#4788ff"
                                                   maxlength="7">
                                        </div>
                                        @error('gradientColor1')
                                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="gradientColor2" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gradient Color 2</label>
                                        <div class="flex items-center space-x-4">
                                            <input type="color" 
                                                   wire:model.live="gradientColor2" 
                                                   id="gradientColor2"
                                                   class="h-12 w-20 rounded-lg border-2 border-gray-300 dark:border-gray-600 cursor-pointer">
                                            <input type="text" 
                                                   wire:model.defer="gradientColor2" 
                                                   class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg font-mono text-sm dark:bg-gray-700 dark:text-white uppercase focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                   placeholder="#4788ff"
                                                   maxlength="7">
                                        </div>
                                        @error('gradientColor2')
                                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preview</label>
                                    <div class="h-40 rounded-lg" style="background: linear-gradient(135deg, {{ $gradientColor1 }} 0%, {{ $gradientColor2 }} 100%);"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <flux:button type="submit" variant="primary">
                    Save
                </flux:button>
            </div>
        </div>
    </form>
</div>