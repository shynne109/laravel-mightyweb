<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use MightyWeb\MightyWeb\Models\AppSetting;
use MightyWeb\MightyWeb\Services\FileUploadService;

new class extends Component {
    use WithFileUploads;

    // App Basic Info
    public string $app_name = '';
    public string $app_version = '';
    public string $app_package_name = '';
    public $app_logo = null;
    public ?string $app_logo_preview = null;
    
    // URLs
    public string $website_url = '';
    public string $privacy_policy_url = '';
    public string $terms_conditions_url = '';
    
    // API Configuration
    public string $api_base_url = '';
    public int $api_timeout = 30;
    
    // App Behavior
    public bool $force_update = false;
    public bool $maintenance_mode = false;
    public string $maintenance_message = '';
    
    // Cache & Performance
    public bool $cache_enabled = true;
    public int $cache_duration = 60;
    
    // Social Media Links
    public string $facebook_url = '';
    public string $twitter_url = '';
    public string $instagram_url = '';
    public string $youtube_url = '';
    public string $linkedin_url = '';
    
    // Contact Information
    public string $contact_email = '';
    public string $contact_phone = '';
    public string $support_url = '';
    
    // Firebase Configuration
    public bool $firebase_enabled = false;
    public string $firebase_api_key = '';
    public string $firebase_project_id = '';
    
    // Analytics
    public bool $analytics_enabled = false;
    public string $analytics_tracking_id = '';

    protected function rules(): array
    {
        return [
            'app_name' => 'required|string|max:255',
            'app_version' => 'required|string|max:50',
            'app_package_name' => 'required|string|max:255',
            'app_logo' => 'nullable|image|max:2048',
            'website_url' => 'nullable|url|max:500',
            'privacy_policy_url' => 'nullable|url|max:500',
            'terms_conditions_url' => 'nullable|url|max:500',
            'api_base_url' => 'nullable|url|max:500',
            'api_timeout' => 'nullable|integer|min:5|max:120',
            'force_update' => 'boolean',
            'maintenance_mode' => 'boolean',
            'maintenance_message' => 'nullable|string|max:500',
            'cache_enabled' => 'boolean',
            'cache_duration' => 'nullable|integer|min:1|max:1440',
            'facebook_url' => 'nullable|url|max:500',
            'twitter_url' => 'nullable|url|max:500',
            'instagram_url' => 'nullable|url|max:500',
            'youtube_url' => 'nullable|url|max:500',
            'linkedin_url' => 'nullable|url|max:500',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'support_url' => 'nullable|url|max:500',
            'firebase_enabled' => 'boolean',
            'firebase_api_key' => 'nullable|string|max:255',
            'firebase_project_id' => 'nullable|string|max:255',
            'analytics_enabled' => 'boolean',
            'analytics_tracking_id' => 'nullable|string|max:255',
        ];
    }

    public function mount(): void
    {
        $this->loadSettings();
    }

    public function loadSettings(): void
    {
        $settings = AppSetting::pluck('value', 'key')->toArray();
        
        // App Basic Info
        $this->app_name = $settings['app_name'] ?? '';
        $this->app_version = $settings['app_version'] ?? '1.0.0';
        $this->app_package_name = $settings['app_package_name'] ?? '';
        $this->app_logo_preview = $settings['app_logo'] ?? null;
        
        // URLs
        $this->website_url = $settings['website_url'] ?? '';
        $this->privacy_policy_url = $settings['privacy_policy_url'] ?? '';
        $this->terms_conditions_url = $settings['terms_conditions_url'] ?? '';
        
        // API Configuration
        $this->api_base_url = $settings['api_base_url'] ?? '';
        $this->api_timeout = (int)($settings['api_timeout'] ?? 30);
        
        // App Behavior
        $this->force_update = filter_var($settings['force_update'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $this->maintenance_mode = filter_var($settings['maintenance_mode'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $this->maintenance_message = $settings['maintenance_message'] ?? '';
        
        // Cache & Performance
        $this->cache_enabled = filter_var($settings['cache_enabled'] ?? true, FILTER_VALIDATE_BOOLEAN);
        $this->cache_duration = (int)($settings['cache_duration'] ?? 60);
        
        // Social Media
        $this->facebook_url = $settings['facebook_url'] ?? '';
        $this->twitter_url = $settings['twitter_url'] ?? '';
        $this->instagram_url = $settings['instagram_url'] ?? '';
        $this->youtube_url = $settings['youtube_url'] ?? '';
        $this->linkedin_url = $settings['linkedin_url'] ?? '';
        
        // Contact
        $this->contact_email = $settings['contact_email'] ?? '';
        $this->contact_phone = $settings['contact_phone'] ?? '';
        $this->support_url = $settings['support_url'] ?? '';
        
        // Firebase
        $this->firebase_enabled = filter_var($settings['firebase_enabled'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $this->firebase_api_key = $settings['firebase_api_key'] ?? '';
        $this->firebase_project_id = $settings['firebase_project_id'] ?? '';
        
        // Analytics
        $this->analytics_enabled = filter_var($settings['analytics_enabled'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $this->analytics_tracking_id = $settings['analytics_tracking_id'] ?? '';
    }

    public function updatedAppLogo(): void
    {
        $this->validate([
            'app_logo' => 'image|max:2048',
        ]);
    }

    public function save(): void
    {
        $this->validate();

        try {
            $fileUploadService = app(FileUploadService::class);
            
            // Handle logo upload
            $logoPath = $this->app_logo_preview;
            if ($this->app_logo) {
                $logoPath = $fileUploadService->uploadImage(
                    $this->app_logo,
                    'app_logo',
                    $this->app_logo_preview
                );
            }

            // Prepare settings array
            $settings = [
                'app_name' => $this->app_name,
                'app_version' => $this->app_version,
                'app_package_name' => $this->app_package_name,
                'app_logo' => $logoPath,
                'website_url' => $this->website_url,
                'privacy_policy_url' => $this->privacy_policy_url,
                'terms_conditions_url' => $this->terms_conditions_url,
                'api_base_url' => $this->api_base_url,
                'api_timeout' => $this->api_timeout,
                'force_update' => $this->force_update,
                'maintenance_mode' => $this->maintenance_mode,
                'maintenance_message' => $this->maintenance_message,
                'cache_enabled' => $this->cache_enabled,
                'cache_duration' => $this->cache_duration,
                'facebook_url' => $this->facebook_url,
                'twitter_url' => $this->twitter_url,
                'instagram_url' => $this->instagram_url,
                'youtube_url' => $this->youtube_url,
                'linkedin_url' => $this->linkedin_url,
                'contact_email' => $this->contact_email,
                'contact_phone' => $this->contact_phone,
                'support_url' => $this->support_url,
                'firebase_enabled' => $this->firebase_enabled,
                'firebase_api_key' => $this->firebase_api_key,
                'firebase_project_id' => $this->firebase_project_id,
                'analytics_enabled' => $this->analytics_enabled,
                'analytics_tracking_id' => $this->analytics_tracking_id,
            ];

            // Save each setting
            foreach ($settings as $key => $value) {
                AppSetting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            // Clear the temporary logo upload
            $this->app_logo = null;
            $this->app_logo_preview = $logoPath;

            session()->flash('success', 'App configuration saved successfully!');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error saving configuration: ' . $e->getMessage());
        }
    }

    public function removeLogo(): void
    {
        if ($this->app_logo_preview) {
            $fileUploadService = app(FileUploadService::class);
            $fileUploadService->deleteFile($this->app_logo_preview);
            $this->app_logo_preview = null;
            
            AppSetting::where('key', 'app_logo')->update(['value' => null]);
            
            session()->flash('success', 'App logo removed successfully!');
        }
    }
}; ?>

<div class="py-6" x-data="{ activeTab: 'basic' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-6">
            <h2 size="xl">App Configuration</h2>
            <p size="sm" class="text-gray-600 dark:text-gray-400">
                Configure your mobile app settings, URLs, and integrations
            </p>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div x-data="{ show: true }" x-show="show" class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tabs Navigation -->
        <div class="bg-white dark:bg-gray-800 rounded-t-lg shadow-sm border border-gray-200 dark:border-gray-700 border-b-0">
            <div class="flex overflow-x-auto">
                <button @click="activeTab = 'basic'" 
                        :class="activeTab === 'basic' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    <i class="ri-smartphone-line mr-2"></i>Basic Info
                </button>
                <button @click="activeTab = 'urls'" 
                        :class="activeTab === 'urls' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    <i class="ri-links-line mr-2"></i>URLs & Links
                </button>
                <button @click="activeTab = 'api'" 
                        :class="activeTab === 'api' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    <i class="ri-server-line mr-2"></i>API & Behavior
                </button>
                <button @click="activeTab = 'social'" 
                        :class="activeTab === 'social' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    <i class="ri-share-line mr-2"></i>Social & Contact
                </button>
                <button @click="activeTab = 'integrations'" 
                        :class="activeTab === 'integrations' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    <i class="ri-puzzle-line mr-2"></i>Integrations
                </button>
            </div>
        </div>

        <!-- Configuration Form -->
        <form wire:submit.prevent="save">
            <div class="bg-white dark:bg-gray-800 rounded-b-lg shadow-sm border border-gray-200 dark:border-gray-700">
                
                <!-- Tab: Basic Info -->
                <div x-show="activeTab === 'basic'" class="p-6 space-y-6">
                    
                    <!-- App Name -->
                    <div>
                        <label for="app_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            App Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="app_name" 
                               wire:model="app_name"
                               class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                               placeholder="Enter app name">
                        @error('app_name') 
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- App Version & Package Name -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="app_version" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                App Version <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="app_version" 
                                   wire:model="app_version"
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                   placeholder="1.0.0">
                            @error('app_version') 
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="app_package_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Package Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="app_package_name" 
                                   wire:model="app_package_name"
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                   placeholder="com.example.app">
                            @error('app_package_name') 
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- App Logo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            App Logo
                        </label>
                        <div class="flex items-start space-x-4">
                            <!-- Logo Preview -->
                            <div class="flex-shrink-0">
                                @if ($app_logo)
                                    <img src="{{ $app_logo->temporaryUrl() }}" 
                                         alt="Logo Preview" 
                                         class="w-24 h-24 rounded-lg object-cover border-2 border-gray-300 dark:border-gray-600">
                                @elseif ($app_logo_preview)
                                    <img src="{{ asset('storage/' . $app_logo_preview) }}" 
                                         alt="Current Logo" 
                                         class="w-24 h-24 rounded-lg object-cover border-2 border-gray-300 dark:border-gray-600">
                                @else
                                    <div class="w-24 h-24 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center border-2 border-gray-300 dark:border-gray-600">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Upload Controls -->
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <label class="cursor-pointer px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                        <i class="ri-upload-line mr-2"></i>
                                        Choose Logo
                                        <input type="file" 
                                               wire:model="app_logo" 
                                               accept="image/*" 
                                               class="hidden">
                                    </label>
                                    
                                    @if ($app_logo_preview)
                                        <button type="button" 
                                                wire:click="removeLogo"
                                                class="px-4 py-2 bg-red-50 dark:bg-red-900/20 border border-red-300 dark:border-red-600 rounded-lg text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors">
                                            <i class="ri-delete-bin-line mr-2"></i>
                                            Remove
                                        </button>
                                    @endif
                                </div>
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    PNG, JPG up to 2MB. Recommended size: 512x512px
                                </p>
                                @error('app_logo') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                
                                <div wire:loading wire:target="app_logo" class="mt-2 text-sm text-blue-600 dark:text-blue-400">
                                    <i class="ri-loader-4-line animate-spin mr-1"></i>
                                    Uploading...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: URLs & Links -->
                <div x-show="activeTab === 'urls'" class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Website URL -->
                        <div>
                            <label for="website_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Website URL
                            </label>
                            <input type="url" 
                                   id="website_url" 
                                   wire:model="website_url"
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                   placeholder="https://example.com">
                            @error('website_url') 
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Privacy Policy URL -->
                        <div>
                            <label for="privacy_policy_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Privacy Policy URL
                            </label>
                            <input type="url" 
                                   id="privacy_policy_url" 
                                   wire:model="privacy_policy_url"
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                   placeholder="https://example.com/privacy">
                            @error('privacy_policy_url') 
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Terms & Conditions URL -->
                        <div>
                            <label for="terms_conditions_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Terms & Conditions URL
                            </label>
                            <input type="url" 
                                   id="terms_conditions_url" 
                                   wire:model="terms_conditions_url"
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                   placeholder="https://example.com/terms">
                            @error('terms_conditions_url') 
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Support URL -->
                        <div>
                            <label for="support_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Support URL
                            </label>
                            <input type="url" 
                                   id="support_url" 
                                   wire:model="support_url"
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                   placeholder="https://example.com/support">
                            @error('support_url') 
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Tab: API & Behavior -->
                <div x-show="activeTab === 'api'" class="p-6 space-y-6">
                    <!-- API Configuration -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">API Configuration</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-2">
                                <label for="api_base_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    API Base URL
                                </label>
                                <input type="url" 
                                       id="api_base_url" 
                                       wire:model="api_base_url"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="https://api.example.com">
                                @error('api_base_url') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="api_timeout" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    API Timeout (seconds)
                                </label>
                                <input type="number" 
                                       id="api_timeout" 
                                       wire:model="api_timeout"
                                       min="5" 
                                       max="120"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="30">
                                @error('api_timeout') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- App Behavior -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">App Behavior</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Force Update -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div>
                                    <label for="force_update" class="font-medium text-gray-900 dark:text-white">
                                        Force Update
                                    </label>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Require users to update the app</p>
                                </div>
                                <button type="button"
                                        wire:click="$toggle('force_update')"
                                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 @if($force_update) bg-blue-600 @else bg-gray-200 dark:bg-gray-700 @endif">
                                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform @if($force_update) translate-x-6 @else translate-x-1 @endif"></span>
                                </button>
                            </div>

                            <!-- Maintenance Mode -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div>
                                    <label for="maintenance_mode" class="font-medium text-gray-900 dark:text-white">
                                        Maintenance Mode
                                    </label>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Show maintenance message</p>
                                </div>
                                <button type="button"
                                        wire:click="$toggle('maintenance_mode')"
                                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 @if($maintenance_mode) bg-blue-600 @else bg-gray-200 dark:bg-gray-700 @endif">
                                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform @if($maintenance_mode) translate-x-6 @else translate-x-1 @endif"></span>
                                </button>
                            </div>

                            <!-- Cache Enabled -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div>
                                    <label for="cache_enabled" class="font-medium text-gray-900 dark:text-white">
                                        Enable Caching
                                    </label>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Cache data for better performance</p>
                                </div>
                                <button type="button"
                                        wire:click="$toggle('cache_enabled')"
                                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 @if($cache_enabled) bg-blue-600 @else bg-gray-200 dark:bg-gray-700 @endif">
                                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform @if($cache_enabled) translate-x-6 @else translate-x-1 @endif"></span>
                                </button>
                            </div>

                            <!-- Cache Duration -->
                            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <label for="cache_duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Cache Duration (minutes)
                                </label>
                                <input type="number" 
                                       id="cache_duration" 
                                       wire:model="cache_duration"
                                       min="1" 
                                       max="1440"
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="60">
                                @error('cache_duration') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Maintenance Message (shown when maintenance mode is on) -->
                        @if($maintenance_mode)
                            <div>
                                <label for="maintenance_message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Maintenance Message
                                </label>
                                <textarea id="maintenance_message" 
                                          wire:model="maintenance_message"
                                          rows="3"
                                          class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                          placeholder="We're currently performing maintenance. Please check back soon."></textarea>
                                @error('maintenance_message') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tab: Social & Contact -->
                <div x-show="activeTab === 'social'" class="p-6 space-y-6">
                    <!-- Social Media -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Social Media Links</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="facebook_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="ri-facebook-fill text-blue-600 mr-1"></i> Facebook URL
                                </label>
                                <input type="url" 
                                       id="facebook_url" 
                                       wire:model="facebook_url"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="https://facebook.com/yourpage">
                                @error('facebook_url') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="twitter_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="ri-twitter-fill text-blue-400 mr-1"></i> Twitter URL
                                </label>
                                <input type="url" 
                                       id="twitter_url" 
                                       wire:model="twitter_url"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="https://twitter.com/yourhandle">
                                @error('twitter_url') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="instagram_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="ri-instagram-fill text-pink-600 mr-1"></i> Instagram URL
                                </label>
                                <input type="url" 
                                       id="instagram_url" 
                                       wire:model="instagram_url"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="https://instagram.com/yourprofile">
                                @error('instagram_url') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="youtube_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="ri-youtube-fill text-red-600 mr-1"></i> YouTube URL
                                </label>
                                <input type="url" 
                                       id="youtube_url" 
                                       wire:model="youtube_url"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="https://youtube.com/yourchannel">
                                @error('youtube_url') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="linkedin_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="ri-linkedin-fill text-blue-700 mr-1"></i> LinkedIn URL
                                </label>
                                <input type="url" 
                                       id="linkedin_url" 
                                       wire:model="linkedin_url"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="https://linkedin.com/company/yourcompany">
                                @error('linkedin_url') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Contact Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="contact_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="ri-mail-line mr-1"></i> Contact Email
                                </label>
                                <input type="email" 
                                       id="contact_email" 
                                       wire:model="contact_email"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="contact@example.com">
                                @error('contact_email') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="contact_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="ri-phone-line mr-1"></i> Contact Phone
                                </label>
                                <input type="text" 
                                       id="contact_phone" 
                                       wire:model="contact_phone"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="+1 (555) 123-4567">
                                @error('contact_phone') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: Integrations -->
                <div x-show="activeTab === 'integrations'" class="p-6 space-y-6">
                    <!-- Firebase -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                <i class="ri-fire-fill text-orange-500 mr-2"></i>Firebase Configuration
                            </h4>
                            <button type="button"
                                    wire:click="$toggle('firebase_enabled')"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 @if($firebase_enabled) bg-blue-600 @else bg-gray-200 dark:bg-gray-700 @endif">
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform @if($firebase_enabled) translate-x-6 @else translate-x-1 @endif"></span>
                            </button>
                        </div>

                        @if($firebase_enabled)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="firebase_api_key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Firebase API Key
                                    </label>
                                    <input type="text" 
                                           id="firebase_api_key" 
                                           wire:model="firebase_api_key"
                                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                                           placeholder="AIza...">
                                    @error('firebase_api_key') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="firebase_project_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Firebase Project ID
                                    </label>
                                    <input type="text" 
                                           id="firebase_project_id" 
                                           wire:model="firebase_project_id"
                                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                                           placeholder="your-project-id">
                                    @error('firebase_project_id') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Analytics -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                <i class="ri-bar-chart-box-fill text-green-500 mr-2"></i>Analytics Configuration
                            </h4>
                            <button type="button"
                                    wire:click="$toggle('analytics_enabled')"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 @if($analytics_enabled) bg-blue-600 @else bg-gray-200 dark:bg-gray-700 @endif">
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform @if($analytics_enabled) translate-x-6 @else translate-x-1 @endif"></span>
                            </button>
                        </div>

                        @if($analytics_enabled)
                            <div>
                                <label for="analytics_tracking_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Analytics Tracking ID
                                </label>
                                <input type="text" 
                                       id="analytics_tracking_id" 
                                       wire:model="analytics_tracking_id"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                                       placeholder="UA-XXXXXXXXX-X or G-XXXXXXXXXX">
                                @error('analytics_tracking_id') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Save Button (fixed at bottom of form) -->
            <div class="bg-gray-50 dark:bg-gray-900 px-6 py-4 border-t border-gray-200 dark:border-gray-700 rounded-b-lg flex justify-end space-x-3">
                <button type="submit" 
                        wire:loading.attr="disabled"
                        class="inline-flex justify-center items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors disabled:opacity-50">
                    <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="save">Save Configuration</span>
                    <span wire:loading wire:target="save">Saving...</span>
                </button>
            </div>
        </form>
    </div>
</div>

