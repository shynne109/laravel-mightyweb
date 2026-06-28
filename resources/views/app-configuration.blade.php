<?php

use Flux\Flux;
use Livewire\Component;
use Livewire\WithFileUploads;
use MightyWeb\Models\AppSetting;
use App\Services\App\JsonExportService;
use MightyWeb\Services\FileUploadService;

new class extends Component
{
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

    // AdMob Configuration
    public string $ads_type = 'none';

    public string $admob_banner_id_android = '';

    public string $admob_interstitial_id_android = '';

    public string $admob_banner_id_ios = '';

    public string $admob_interstitial_id_ios = '';

    public string $facebook_banner_id_android = '';

    public string $facebook_interstitial_id_android = '';

    public string $facebook_banner_id_ios = '';

    public string $facebook_interstitial_id_ios = '';

    // Exit Popup Configuration
    public bool $exit_popup_enabled = false;

    public string $exit_popup_title = '';

    public string $exit_popup_positive_text = '';

    public string $exit_popup_negative_text = '';

    public bool $exit_popup_show_image = false;

    public $exit_popup_image = null;

    public ?string $exit_popup_image_preview = null;

    // About App Configuration
    public bool $show_about = false;

    public string $about_whatsapp = '';

    public string $about_instagram = '';

    public string $about_twitter = '';

    public string $about_facebook = '';

    public string $about_phone = '';

    public string $about_snapchat = '';

    public string $about_skype = '';

    public string $about_messenger = '';

    public string $about_youtube = '';

    public string $about_copyright = '';

    public string $about_description = '';

    // App Config - Advanced Settings
    public string $app_language = 'en';

    public string $navigation_style = 'sidedrawer';

    public string $header_style = 'left';

    public string $tab_style = 'simple_tab';

    public string $bottom_navigation_style = 'bottom_navigation_1';

    public string $walkthrough_style = 'walkthrough_style_1';

    public string $floating_button_style = 'regular';

    public bool $javascript_enabled = true;

    public bool $splash_screen_enabled = true;

    public bool $zoom_functionality = false;

    public bool $walkthrough_enabled = false;

    public bool $webrtc_enabled = false;

    public bool $pull_refresh_enabled = true;

    public bool $clear_cookies = false;

    public bool $floating_button_enabled = false;

    public bool $disable_header = false;

    public bool $disable_footer = false;

    public bool $disable_left_icon = false;

    public $floating_button_logo = null;

    public ?string $floating_button_logo_preview = null;

    // OneSignal Configuration
    public string $onesignal_app_id = '';

    public string $onesignal_rest_api_key = '';

    // Progress Bar Configuration
    public bool $progress_bar_enabled = true;

    public string $progress_bar_style = 'Circle';

    // Share Content Configuration
    public string $share_content = '';

    // Splash Screen Configuration
    public string $splash_first_color = '#3788ff';

    public string $splash_second_color = '#4788ff';

    public string $splash_title = '';

    public string $splash_title_color = '#4788ff';

    public bool $splash_show_logo = false;

    public bool $splash_show_title = false;

    public bool $splash_show_background = false;

    public $splash_logo = null;

    public ?string $splash_logo_preview = null;

    public $splash_background = null;

    public ?string $splash_background_preview = null;

    // Theme Configuration
    public string $theme_style = 'Default';

    public string $theme_custom_color = '#4788ff';

    public string $theme_gradient_color1 = '#4788ff';

    public string $theme_gradient_color2 = '#4788ff';

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
            'ads_type' => 'required|in:none,admob,facebook',
            'admob_banner_id_android' => 'nullable|string|max:255',
            'admob_interstitial_id_android' => 'nullable|string|max:255',
            'admob_banner_id_ios' => 'nullable|string|max:255',
            'admob_interstitial_id_ios' => 'nullable|string|max:255',
            'facebook_banner_id_android' => 'nullable|string|max:255',
            'facebook_interstitial_id_android' => 'nullable|string|max:255',
            'facebook_banner_id_ios' => 'nullable|string|max:255',
            'facebook_interstitial_id_ios' => 'nullable|string|max:255',
            'exit_popup_enabled' => 'boolean',
            'exit_popup_title' => 'nullable|string|max:255',
            'exit_popup_positive_text' => 'nullable|string|max:100',
            'exit_popup_negative_text' => 'nullable|string|max:100',
            'exit_popup_show_image' => 'boolean',
            'exit_popup_image' => 'nullable|image|max:2048',
            'show_about' => 'boolean',
            'about_whatsapp' => 'nullable|string|max:50',
            'about_instagram' => 'nullable|url|max:500',
            'about_twitter' => 'nullable|url|max:500',
            'about_facebook' => 'nullable|url|max:500',
            'about_phone' => 'nullable|string|max:50',
            'about_snapchat' => 'nullable|string|max:255',
            'about_skype' => 'nullable|url|max:500',
            'about_messenger' => 'nullable|url|max:500',
            'about_youtube' => 'nullable|url|max:500',
            'about_copyright' => 'nullable|string|max:255',
            'about_description' => 'nullable|string|max:1000',
            'app_language' => 'required|string|max:10',
            'navigation_style' => 'required|string|max:50',
            'header_style' => 'required|string|max:50',
            'tab_style' => 'nullable|string|max:50',
            'bottom_navigation_style' => 'nullable|string|max:50',
            'walkthrough_style' => 'nullable|string|max:50',
            'floating_button_style' => 'nullable|string|max:50',
            'javascript_enabled' => 'boolean',
            'splash_screen_enabled' => 'boolean',
            'zoom_functionality' => 'boolean',
            'walkthrough_enabled' => 'boolean',
            'webrtc_enabled' => 'boolean',
            'pull_refresh_enabled' => 'boolean',
            'clear_cookies' => 'boolean',
            'floating_button_enabled' => 'boolean',
            'disable_header' => 'boolean',
            'disable_footer' => 'boolean',
            'disable_left_icon' => 'boolean',
            'floating_button_logo' => 'nullable|image|max:2048',
            'onesignal_app_id' => 'nullable|string|max:255',
            'onesignal_rest_api_key' => 'nullable|string|max:255',
            'progress_bar_enabled' => 'boolean',
            'progress_bar_style' => 'required|string|max:50',
            'share_content' => 'nullable|string|max:500',
            'splash_first_color' => 'nullable|string|max:20',
            'splash_second_color' => 'nullable|string|max:20',
            'splash_title' => 'nullable|string|max:255',
            'splash_title_color' => 'nullable|string|max:20',
            'splash_show_logo' => 'boolean',
            'splash_show_title' => 'boolean',
            'splash_show_background' => 'boolean',
            'splash_logo' => 'nullable|image|max:2048',
            'splash_background' => 'nullable|image|max:2048',
        ];
    }

    public function mount(): void
    {
        $this->loadSettings();
    }

    /**
     * Migrate legacy appconfiguration JSON structure to individual settings
     */
    protected function migrateLegacyConfiguration(): void
    {
        $legacyConfig = AppSetting::where('key', 'appconfiguration')->first();

        if ($legacyConfig && $legacyConfig->value) {
            $value = is_string($legacyConfig->value) ? json_decode($legacyConfig->value) : $legacyConfig->value;

            if ($value && is_object($value)) {
                $mappings = [
                    'app_name' => $value->app_name ?? null,
                    'website_url' => $value->url ?? null,
                    'app_language' => $value->appLanuguage ?? null,
                    'app_logo' => $value->app_logo ?? null,
                    'navigation_style' => $value->navigationStyle ?? null,
                    'header_style' => $value->header_style ?? null,
                    'tab_style' => $value->tab_style ?? null,
                    'bottom_navigation_style' => $value->bottom_navigation ?? null,
                    'walkthrough_style' => $value->walkthrough_style ?? null,
                    'floating_button_style' => $value->floating_button_style ?? null,
                    'floating_button_logo' => $value->floating_button ?? null,
                    'javascript_enabled' => isset($value->isJavascriptEnable) && $value->isJavascriptEnable === 'true',
                    'splash_screen_enabled' => isset($value->isSplashScreen) && $value->isSplashScreen === 'true',
                    'zoom_functionality' => isset($value->isZoomFunctionality) && $value->isZoomFunctionality === 'true',
                    'walkthrough_enabled' => isset($value->is_walkthrough) && $value->is_walkthrough === 'true',
                    'webrtc_enabled' => isset($value->is_webrtc) && $value->is_webrtc === 'true',
                    'pull_refresh_enabled' => ! isset($value->is_pull_refresh) || $value->is_pull_refresh === 'true',
                    'clear_cookies' => isset($value->clear_cookie) && $value->clear_cookie === 'true',
                    'exit_popup_enabled' => isset($value->isExitPopupScreen) && $value->isExitPopupScreen === 'true',
                    'floating_button_enabled' => isset($value->is_floating_button) && $value->is_floating_button === 'true',
                    'disable_header' => isset($value->disable_header) && $value->disable_header === 'true',
                    'disable_footer' => isset($value->disable_footer) && $value->disable_footer === 'true',
                    'disable_left_icon' => isset($value->disable_left_icon) && $value->disable_left_icon === 'true',
                ];

                foreach ($mappings as $key => $val) {
                    if ($val !== null && ! AppSetting::where('key', $key)->exists()) {
                        AppSetting::updateOrCreate(
                            ['key' => $key],
                            ['value' => is_bool($val) ? ($val ? '1' : '0') : $val]
                        );
                    }
                }

                // Delete legacy config after migration (uncomment when ready)
                // $legacyConfig->delete();
            }
        }
    }

    public function loadSettings(): void
    {
        $settings = AppSetting::pluck('value', 'key')->toArray();

        // Check if legacy appconfiguration exists and merge with individual settings
        if (isset($settings['appconfiguration'])) {
            $legacyConfig = is_string($settings['appconfiguration']) ? json_decode($settings['appconfiguration'], true) : $settings['appconfiguration'];
            if ($legacyConfig && is_array($legacyConfig)) {
                // Merge legacy config into settings array (legacy takes precedence for app config fields)
                $legacyMappings = [
                    'app_name' => $legacyConfig['app_name'] ?? null,
                    'website_url' => $legacyConfig['url'] ?? null,
                    'app_language' => $legacyConfig['appLanuguage'] ?? null,
                    'app_logo' => $legacyConfig['app_logo'] ?? null,
                    'navigation_style' => $legacyConfig['navigationStyle'] ?? null,
                    'header_style' => $legacyConfig['header_style'] ?? null,
                    'tab_style' => $legacyConfig['tab_style'] ?? null,
                    'bottom_navigation_style' => $legacyConfig['bottom_navigation'] ?? null,
                    'walkthrough_style' => $legacyConfig['walkthrough_style'] ?? null,
                    'floating_button_style' => $legacyConfig['floating_button_style'] ?? null,
                    'floating_button_logo' => $legacyConfig['floating_button'] ?? null,
                    'javascript_enabled' => isset($legacyConfig['isJavascriptEnable']) ? ($legacyConfig['isJavascriptEnable'] === 'true') : null,
                    'splash_screen_enabled' => isset($legacyConfig['isSplashScreen']) ? ($legacyConfig['isSplashScreen'] === 'true') : null,
                    'zoom_functionality' => isset($legacyConfig['isZoomFunctionality']) ? ($legacyConfig['isZoomFunctionality'] === 'true') : null,
                    'walkthrough_enabled' => isset($legacyConfig['is_walkthrough']) ? ($legacyConfig['is_walkthrough'] === 'true') : null,
                    'webrtc_enabled' => isset($legacyConfig['is_webrtc']) ? ($legacyConfig['is_webrtc'] === 'true') : null,
                    'pull_refresh_enabled' => isset($legacyConfig['is_pull_refresh']) ? ($legacyConfig['is_pull_refresh'] === 'true') : null,
                    'clear_cookies' => isset($legacyConfig['isCookieEnable']) ? ($legacyConfig['isCookieEnable'] === 'true') : (isset($legacyConfig['clear_cookie']) ? ($legacyConfig['clear_cookie'] === 'true') : null),
                    'exit_popup_enabled' => isset($legacyConfig['isExitPopupScreen']) ? ($legacyConfig['isExitPopupScreen'] === 'true') : null,
                    'floating_button_enabled' => isset($legacyConfig['is_floating_button']) ? ($legacyConfig['is_floating_button'] === 'true') : null,
                    'disable_header' => isset($legacyConfig['disable_header']) ? ($legacyConfig['disable_header'] === 'true') : null,
                    'disable_footer' => isset($legacyConfig['disable_footer']) ? ($legacyConfig['disable_footer'] === 'true') : null,
                    'disable_left_icon' => isset($legacyConfig['disable_left_icon']) ? ($legacyConfig['disable_left_icon'] === 'true') : null,
                ];

                // Merge legacy mappings into settings (only if not null)
                foreach ($legacyMappings as $key => $value) {
                    if ($value !== null) {
                        $settings[$key] = $value;
                    }
                }
            }
        }

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
        $this->api_timeout = (int) ($settings['api_timeout'] ?? 30);

        // App Behavior
        $this->force_update = filter_var($settings['force_update'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $this->maintenance_mode = filter_var($settings['maintenance_mode'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $this->maintenance_message = $settings['maintenance_message'] ?? '';

        // Cache & Performance
        $this->cache_enabled = filter_var($settings['cache_enabled'] ?? true, FILTER_VALIDATE_BOOLEAN);
        $this->cache_duration = (int) ($settings['cache_duration'] ?? 60);

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

        // AdMob - Check for legacy JSON first
        if (isset($settings['admob'])) {
            $admobConfig = is_string($settings['admob']) ? json_decode($settings['admob'], true) : $settings['admob'];
            if ($admobConfig && is_array($admobConfig)) {
                $this->ads_type = $admobConfig['ads_type'] ?? 'none';
                $this->admob_banner_id_android = $admobConfig['admobBannerID'] ?? '';
                $this->admob_interstitial_id_android = $admobConfig['admobIntentialID'] ?? '';
                $this->admob_banner_id_ios = $admobConfig['admobBannerIDIOS'] ?? '';
                $this->admob_interstitial_id_ios = $admobConfig['admobIntentialIDIOS'] ?? '';
                $this->facebook_banner_id_android = $admobConfig['facebookBannerID'] ?? '';
                $this->facebook_interstitial_id_android = $admobConfig['facebookIntentialID'] ?? '';
                $this->facebook_banner_id_ios = $admobConfig['facebookBannerIDIOS'] ?? '';
                $this->facebook_interstitial_id_ios = $admobConfig['facebookIntentialIDIOS'] ?? '';
            }
        } else {
            $this->ads_type = $settings['ads_type'] ?? 'none';
            $this->admob_banner_id_android = $settings['admob_banner_id_android'] ?? '';
            $this->admob_interstitial_id_android = $settings['admob_interstitial_id_android'] ?? '';
            $this->admob_banner_id_ios = $settings['admob_banner_id_ios'] ?? '';
            $this->admob_interstitial_id_ios = $settings['admob_interstitial_id_ios'] ?? '';
            $this->facebook_banner_id_android = $settings['facebook_banner_id_android'] ?? '';
            $this->facebook_interstitial_id_android = $settings['facebook_interstitial_id_android'] ?? '';
            $this->facebook_banner_id_ios = $settings['facebook_banner_id_ios'] ?? '';
            $this->facebook_interstitial_id_ios = $settings['facebook_interstitial_id_ios'] ?? '';
        }

        // Exit Popup - Check for legacy JSON first
        if (isset($settings['exitpopup_configuration'])) {
            // Legacy format: exitpopup_configuration
            $exitPopupConfig = is_string($settings['exitpopup_configuration']) ? json_decode($settings['exitpopup_configuration'], true) : $settings['exitpopup_configuration'];
            if ($exitPopupConfig && is_array($exitPopupConfig)) {
                $this->exit_popup_enabled = true; // If legacy key exists, assume enabled
                $this->exit_popup_title = $exitPopupConfig['title'] ?? '';
                $this->exit_popup_positive_text = $exitPopupConfig['positive_text'] ?? '';
                $this->exit_popup_negative_text = $exitPopupConfig['negative_text'] ?? '';
                $this->exit_popup_show_image = filter_var($exitPopupConfig['enable_image'] ?? false, FILTER_VALIDATE_BOOLEAN);
                $this->exit_popup_image_preview = $exitPopupConfig['exit_image_url'] ?? null;
            }
        } elseif (isset($settings['exit_popup'])) {
            // New format: exit_popup
            $exitPopupConfig = is_string($settings['exit_popup']) ? json_decode($settings['exit_popup'], true) : $settings['exit_popup'];
            if ($exitPopupConfig && is_array($exitPopupConfig)) {
                $this->exit_popup_enabled = filter_var($exitPopupConfig['enabled'] ?? false, FILTER_VALIDATE_BOOLEAN);
                $this->exit_popup_title = $exitPopupConfig['title'] ?? '';
                $this->exit_popup_positive_text = $exitPopupConfig['positive_text'] ?? '';
                $this->exit_popup_negative_text = $exitPopupConfig['negative_text'] ?? '';
                $this->exit_popup_show_image = filter_var($exitPopupConfig['show_image'] ?? false, FILTER_VALIDATE_BOOLEAN);
                $this->exit_popup_image_preview = $exitPopupConfig['image'] ?? null;
            }
        } else {
            // Individual settings
            $this->exit_popup_enabled = filter_var($settings['exit_popup_enabled'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $this->exit_popup_title = $settings['exit_popup_title'] ?? '';
            $this->exit_popup_positive_text = $settings['exit_popup_positive_text'] ?? '';
            $this->exit_popup_negative_text = $settings['exit_popup_negative_text'] ?? '';
            $this->exit_popup_show_image = filter_var($settings['exit_popup_show_image'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $this->exit_popup_image_preview = $settings['exit_popup_image'] ?? null;
        }

        // About App - Check for legacy JSON first
        if (isset($settings['about'])) {
            $aboutConfig = is_string($settings['about']) ? json_decode($settings['about'], true) : $settings['about'];
            if ($aboutConfig && is_array($aboutConfig)) {
                $this->show_about = filter_var($aboutConfig['isShowAbout'] ?? false, FILTER_VALIDATE_BOOLEAN);
                $this->about_whatsapp = $aboutConfig['whatsAppNumber'] ?? '';
                $this->about_instagram = $aboutConfig['instagramUrl'] ?? '';
                $this->about_twitter = $aboutConfig['twitterUrl'] ?? '';
                $this->about_facebook = $aboutConfig['facebookUrl'] ?? '';
                $this->about_phone = $aboutConfig['callNumber'] ?? '';
                $this->about_snapchat = $aboutConfig['snapchat'] ?? '';
                $this->about_skype = $aboutConfig['skype'] ?? '';
                $this->about_messenger = $aboutConfig['messenger'] ?? '';
                $this->about_youtube = $aboutConfig['youtube'] ?? '';
                $this->about_copyright = $aboutConfig['copyright'] ?? '';
                $this->about_description = $aboutConfig['description'] ?? '';
            }
        } else {
            $this->show_about = filter_var($settings['show_about'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $this->about_whatsapp = $settings['about_whatsapp'] ?? '';
            $this->about_instagram = $settings['about_instagram'] ?? '';
            $this->about_twitter = $settings['about_twitter'] ?? '';
            $this->about_facebook = $settings['about_facebook'] ?? '';
            $this->about_phone = $settings['about_phone'] ?? '';
            $this->about_snapchat = $settings['about_snapchat'] ?? '';
            $this->about_skype = $settings['about_skype'] ?? '';
            $this->about_messenger = $settings['about_messenger'] ?? '';
            $this->about_youtube = $settings['about_youtube'] ?? '';
            $this->about_copyright = $settings['about_copyright'] ?? '';
            $this->about_description = $settings['about_description'] ?? '';
        }

        // App Config - Advanced Settings
        $this->app_language = $settings['app_language'] ?? 'en';
        $this->navigation_style = $settings['navigation_style'] ?? 'sidedrawer';
        $this->header_style = $settings['header_style'] ?? 'left';
        $this->tab_style = $settings['tab_style'] ?? 'simple_tab';
        $this->bottom_navigation_style = $settings['bottom_navigation_style'] ?? 'bottom_navigation_1';
        $this->walkthrough_style = $settings['walkthrough_style'] ?? 'walkthrough_style_1';
        $this->floating_button_style = $settings['floating_button_style'] ?? 'regular';
        $this->javascript_enabled = filter_var($settings['javascript_enabled'] ?? true, FILTER_VALIDATE_BOOLEAN);
        $this->splash_screen_enabled = filter_var($settings['splash_screen_enabled'] ?? true, FILTER_VALIDATE_BOOLEAN);
        $this->zoom_functionality = filter_var($settings['zoom_functionality'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $this->walkthrough_enabled = filter_var($settings['walkthrough_enabled'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $this->webrtc_enabled = filter_var($settings['webrtc_enabled'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $this->pull_refresh_enabled = filter_var($settings['pull_refresh_enabled'] ?? true, FILTER_VALIDATE_BOOLEAN);
        $this->clear_cookies = filter_var($settings['clear_cookies'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $this->floating_button_enabled = filter_var($settings['floating_button_enabled'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $this->disable_header = filter_var($settings['disable_header'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $this->disable_footer = filter_var($settings['disable_footer'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $this->disable_left_icon = filter_var($settings['disable_left_icon'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $this->floating_button_logo_preview = $settings['floating_button_logo'] ?? null;

        // OneSignal Configuration - Check for legacy JSON first
        if (isset($settings['onesignal_configuration'])) {
            $onesignalConfig = is_string($settings['onesignal_configuration']) ? json_decode($settings['onesignal_configuration'], true) : $settings['onesignal_configuration'];
            if ($onesignalConfig && is_array($onesignalConfig)) {
                $this->onesignal_app_id = $onesignalConfig['app_id'] ?? '';
                $this->onesignal_rest_api_key = $onesignalConfig['rest_api_key'] ?? '';
            }
        } else {
            $this->onesignal_app_id = $settings['onesignal_app_id'] ?? '';
            $this->onesignal_rest_api_key = $settings['onesignal_rest_api_key'] ?? '';
        }

        // Progress Bar Configuration - Check for legacy JSON first
        if (isset($settings['progressbar'])) {
            // Legacy format: progressbar
            $progressBarConfig = is_string($settings['progressbar']) ? json_decode($settings['progressbar'], true) : $settings['progressbar'];
            if ($progressBarConfig && is_array($progressBarConfig)) {
                $this->progress_bar_enabled = filter_var($progressBarConfig['is_progressbar'] ?? 'true', FILTER_VALIDATE_BOOLEAN) || ($progressBarConfig['is_progressbar'] ?? 'true') === 'true';
                $this->progress_bar_style = $progressBarConfig['loaderStyle'] ?? 'Circle';
            }
        } else {
            // Individual settings
            $this->progress_bar_enabled = filter_var($settings['progress_bar_enabled'] ?? true, FILTER_VALIDATE_BOOLEAN);
            $this->progress_bar_style = $settings['progress_bar_style'] ?? 'Circle';
        }

        // Share Content Configuration - Check for legacy JSON first
        if (isset($settings['share_content'])) {
            $shareConfig = is_string($settings['share_content']) ? json_decode($settings['share_content'], true) : $settings['share_content'];
            if ($shareConfig && is_array($shareConfig)) {
                $this->share_content = $shareConfig['share'] ?? '';
            }
        } else {
            $this->share_content = $settings['share_content'] ?? '';
        }

        // Splash Screen Configuration - Check for legacy JSON first
        if (isset($settings['splash_configuration'])) {
            // Legacy format: splash_configuration
            $splashConfig = is_string($settings['splash_configuration']) ? json_decode($settings['splash_configuration'], true) : $settings['splash_configuration'];
            if ($splashConfig && is_array($splashConfig)) {
                $this->splash_first_color = $splashConfig['first_color'] ?? '#3788ff';
                $this->splash_second_color = $splashConfig['second_color'] ?? '#4788ff';
                $this->splash_title = $splashConfig['title'] ?? '';
                $this->splash_title_color = $splashConfig['title_color'] ?? '#4788ff';
                $this->splash_show_logo = filter_var($splashConfig['enable_logo'] ?? 'false', FILTER_VALIDATE_BOOLEAN) || ($splashConfig['enable_logo'] ?? 'false') === 'true';
                $this->splash_show_title = filter_var($splashConfig['enable_title'] ?? 'false', FILTER_VALIDATE_BOOLEAN) || ($splashConfig['enable_title'] ?? 'false') === 'true';
                $this->splash_show_background = filter_var($splashConfig['enable_background'] ?? 'false', FILTER_VALIDATE_BOOLEAN) || ($splashConfig['enable_background'] ?? 'false') === 'true';
                $this->splash_logo_preview = $splashConfig['splash_logo_url'] ?? null;
                $this->splash_background_preview = $splashConfig['splash_background_url'] ?? null;
            }
        } elseif (isset($settings['splash'])) {
            // New format: splash
            $splashConfig = is_string($settings['splash']) ? json_decode($settings['splash'], true) : $settings['splash'];
            if ($splashConfig && is_array($splashConfig)) {
                $this->splash_first_color = $splashConfig['first_color'] ?? '#FFFFFF';
                $this->splash_second_color = $splashConfig['second_color'] ?? '#FFFFFF';
                $this->splash_title = $splashConfig['title'] ?? '';
                $this->splash_title_color = $splashConfig['title_color'] ?? '#000000';
                $this->splash_show_logo = filter_var($splashConfig['show_logo'] ?? true, FILTER_VALIDATE_BOOLEAN);
                $this->splash_show_title = filter_var($splashConfig['show_title'] ?? true, FILTER_VALIDATE_BOOLEAN);
                $this->splash_show_background = filter_var($splashConfig['show_background'] ?? true, FILTER_VALIDATE_BOOLEAN);
                $this->splash_logo_preview = $splashConfig['logo'] ?? null;
                $this->splash_background_preview = $splashConfig['background'] ?? null;
            }
        } else {
            // Individual settings
            $this->splash_first_color = $settings['splash_first_color'] ?? '#FFFFFF';
            $this->splash_second_color = $settings['splash_second_color'] ?? '#FFFFFF';
            $this->splash_title = $settings['splash_title'] ?? '';
            $this->splash_title_color = $settings['splash_title_color'] ?? '#000000';
            $this->splash_show_logo = filter_var($settings['splash_show_logo'] ?? true, FILTER_VALIDATE_BOOLEAN);
            $this->splash_show_title = filter_var($settings['splash_show_title'] ?? true, FILTER_VALIDATE_BOOLEAN);
            $this->splash_show_background = filter_var($settings['splash_show_background'] ?? true, FILTER_VALIDATE_BOOLEAN);
            $this->splash_logo_preview = $settings['splash_logo'] ?? null;
            $this->splash_background_preview = $settings['splash_background'] ?? null;
        }

        // Theme Configuration - Check for legacy JSON first
        if (isset($settings['theme'])) {
            // Legacy format: theme
            $themeConfig = is_string($settings['theme']) ? json_decode($settings['theme'], true) : $settings['theme'];
            if ($themeConfig && is_array($themeConfig)) {
                $this->theme_style = $themeConfig['themeStyle'] ?? 'Default';
                $this->theme_custom_color = $themeConfig['customColor'] ?? '#4788ff';
                $this->theme_gradient_color1 = $themeConfig['gradientColor1'] ?? '#4788ff';
                $this->theme_gradient_color2 = $themeConfig['gradientColor2'] ?? '#4788ff';
            }
        } else {
            // Individual settings
            $this->theme_style = $settings['theme_style'] ?? 'Default';
            $this->theme_custom_color = $settings['theme_custom_color'] ?? '#4788ff';
            $this->theme_gradient_color1 = $settings['theme_gradient_color1'] ?? '#4788ff';
            $this->theme_gradient_color2 = $settings['theme_gradient_color2'] ?? '#4788ff';
        }
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

            // Handle exit popup image upload
            $exitPopupImagePath = $this->exit_popup_image_preview;
            if ($this->exit_popup_image) {
                $exitPopupImagePath = $fileUploadService->uploadImage(
                    $this->exit_popup_image,
                    'exit_popup',
                    $this->exit_popup_image_preview
                );
            }

            // Handle floating button logo upload
            $floatingButtonLogoPath = $this->floating_button_logo_preview;
            if ($this->floating_button_logo) {
                $floatingButtonLogoPath = $fileUploadService->uploadImage(
                    $this->floating_button_logo,
                    'floating_button',
                    $this->floating_button_logo_preview
                );
            }

            // Handle splash logo upload
            $splashLogoPath = $this->splash_logo_preview;
            if ($this->splash_logo) {
                $splashLogoPath = $fileUploadService->uploadImage(
                    $this->splash_logo,
                    'splash',
                    $this->splash_logo_preview
                );
            }

            // Handle splash background upload
            $splashBackgroundPath = $this->splash_background_preview;
            if ($this->splash_background) {
                $splashBackgroundPath = $fileUploadService->uploadImage(
                    $this->splash_background,
                    'splash',
                    $this->splash_background_preview
                );
            }

            // Prepare settings array
            $settings = [
                // Legacy appconfiguration JSON for mobile app compatibility
                'appconfiguration' => json_encode([
                    'app_name' => $this->app_name,
                    'url' => $this->website_url,
                    'appLanuguage' => $this->app_language,
                    'app_logo' => $logoPath,
                    'navigationStyle' => $this->navigation_style,
                    'header_style' => $this->header_style,
                    'tab_style' => $this->tab_style,
                    'bottom_navigation' => $this->bottom_navigation_style,
                    'walkthrough_style' => $this->walkthrough_style,
                    'floating_button_style' => $this->floating_button_style,
                    'floating_button' => $floatingButtonLogoPath,
                    'isJavascriptEnable' => $this->javascript_enabled ? 'true' : 'false',
                    'isSplashScreen' => $this->splash_screen_enabled ? 'true' : 'false',
                    'isZoomFunctionality' => $this->zoom_functionality ? 'true' : 'false',
                    'is_walkthrough' => $this->walkthrough_enabled ? 'true' : 'false',
                    'is_webrtc' => $this->webrtc_enabled ? 'true' : 'false',
                    'is_pull_refresh' => $this->pull_refresh_enabled ? 'true' : 'false',
                    'isCookieEnable' => $this->clear_cookies ? 'true' : 'false',
                    'clear_cookie' => $this->clear_cookies ? 'true' : 'false',
                    'isExitPopupScreen' => $this->exit_popup_enabled ? 'true' : 'false',
                    'is_floating_button' => $this->floating_button_enabled ? 'true' : 'false',
                    'disable_header' => $this->disable_header ? 'true' : 'false',
                    'disable_footer' => $this->disable_footer ? 'true' : 'false',
                    'disable_left_icon' => $this->disable_left_icon ? 'true' : 'false',
                ]),
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

                // Legacy admob JSON for mobile app compatibility
                'admob' => json_encode([
                    'ads_type' => $this->ads_type,
                    'admobBannerID' => $this->admob_banner_id_android,
                    'admobIntentialID' => $this->admob_interstitial_id_android,
                    'admobBannerIDIOS' => $this->admob_banner_id_ios,
                    'admobIntentialIDIOS' => $this->admob_interstitial_id_ios,
                    'facebookBannerID' => $this->facebook_banner_id_android,
                    'facebookIntentialID' => $this->facebook_interstitial_id_android,
                    'facebookBannerIDIOS' => $this->facebook_banner_id_ios,
                    'facebookIntentialIDIOS' => $this->facebook_interstitial_id_ios,
                ]),

                // Individual AdMob settings for admin panel
                'ads_type' => $this->ads_type,
                'admob_banner_id_android' => $this->admob_banner_id_android,
                'admob_interstitial_id_android' => $this->admob_interstitial_id_android,
                'admob_banner_id_ios' => $this->admob_banner_id_ios,
                'admob_interstitial_id_ios' => $this->admob_interstitial_id_ios,
                'facebook_banner_id_android' => $this->facebook_banner_id_android,
                'facebook_interstitial_id_android' => $this->facebook_interstitial_id_android,
                'facebook_banner_id_ios' => $this->facebook_banner_id_ios,
                'facebook_interstitial_id_ios' => $this->facebook_interstitial_id_ios,

                // Legacy exit popup JSON for compatibility
                'exitpopup_configuration' => json_encode([
                    'title' => $this->exit_popup_title,
                    'positive_text' => $this->exit_popup_positive_text,
                    'negative_text' => $this->exit_popup_negative_text,
                    'enable_image' => $this->exit_popup_show_image ? 'true' : 'false',
                    'exit_image_url' => $exitPopupImagePath,
                ]),

                'exit_popup' => json_encode([
                    'enabled' => $this->exit_popup_enabled,
                    'title' => $this->exit_popup_title,
                    'positive_text' => $this->exit_popup_positive_text,
                    'negative_text' => $this->exit_popup_negative_text,
                    'show_image' => $this->exit_popup_show_image,
                    'image' => $exitPopupImagePath,
                ]),

                // Individual exit popup settings for admin panel
                'exit_popup_enabled' => $this->exit_popup_enabled,
                'exit_popup_title' => $this->exit_popup_title,
                'exit_popup_positive_text' => $this->exit_popup_positive_text,
                'exit_popup_negative_text' => $this->exit_popup_negative_text,
                'exit_popup_show_image' => $this->exit_popup_show_image,
                'exit_popup_image' => $exitPopupImagePath,

                'about' => json_encode([
                    'isShowAbout' => $this->show_about,
                    'whatsAppNumber' => $this->about_whatsapp,
                    'instagramUrl' => $this->about_instagram,
                    'twitterUrl' => $this->about_twitter,
                    'facebookUrl' => $this->about_facebook,
                    'callNumber' => $this->about_phone,
                    'snapchat' => $this->about_snapchat,
                    'skype' => $this->about_skype,
                    'messenger' => $this->about_messenger,
                    'youtube' => $this->about_youtube,
                    'copyright' => $this->about_copyright,
                    'description' => $this->about_description,
                ]),

                // Individual about settings for admin panel
                'show_about' => $this->show_about,
                'about_whatsapp' => $this->about_whatsapp,
                'about_instagram' => $this->about_instagram,
                'about_twitter' => $this->about_twitter,
                'about_facebook' => $this->about_facebook,
                'about_phone' => $this->about_phone,
                'about_snapchat' => $this->about_snapchat,
                'about_skype' => $this->about_skype,
                'about_messenger' => $this->about_messenger,
                'about_youtube' => $this->about_youtube,
                'about_copyright' => $this->about_copyright,
                'about_description' => $this->about_description,

                'app_language' => $this->app_language,
                'navigation_style' => $this->navigation_style,
                'header_style' => $this->header_style,
                'tab_style' => $this->tab_style,
                'bottom_navigation_style' => $this->bottom_navigation_style,
                'walkthrough_style' => $this->walkthrough_style,
                'floating_button_style' => $this->floating_button_style,
                'javascript_enabled' => $this->javascript_enabled,
                'splash_screen_enabled' => $this->splash_screen_enabled,
                'zoom_functionality' => $this->zoom_functionality,
                'walkthrough_enabled' => $this->walkthrough_enabled,
                'webrtc_enabled' => $this->webrtc_enabled,
                'pull_refresh_enabled' => $this->pull_refresh_enabled,
                'clear_cookies' => $this->clear_cookies,
                'floating_button_enabled' => $this->floating_button_enabled,
                'disable_header' => $this->disable_header,
                'disable_footer' => $this->disable_footer,
                'disable_left_icon' => $this->disable_left_icon,
                'floating_button_logo' => $floatingButtonLogoPath,

                // Legacy OneSignal JSON for mobile app compatibility
                'onesignal_configuration' => json_encode([
                    'app_id' => $this->onesignal_app_id,
                    'rest_api_key' => $this->onesignal_rest_api_key,
                ]),

                // Individual OneSignal settings for admin panel
                'onesignal_app_id' => $this->onesignal_app_id,
                'onesignal_rest_api_key' => $this->onesignal_rest_api_key,

                // Legacy progress bar JSON for compatibility
                'progressbar' => json_encode([
                    'is_progressbar' => $this->progress_bar_enabled ? 'true' : 'false',
                    'loaderStyle' => $this->progress_bar_style,
                ]),

                'progress_bar_enabled' => $this->progress_bar_enabled,
                'progress_bar_style' => $this->progress_bar_style,

                // Legacy share content JSON for compatibility
                'share_content' => json_encode([
                    'share' => $this->share_content,
                ]),

                // Legacy splash configuration JSON for compatibility
                'splash_configuration' => json_encode([
                    'first_color' => $this->splash_first_color,
                    'second_color' => $this->splash_second_color,
                    'title' => $this->splash_title,
                    'title_color' => $this->splash_title_color,
                    'enable_logo' => $this->splash_show_logo ? 'true' : 'false',
                    'enable_title' => $this->splash_show_title ? 'true' : 'false',
                    'enable_background' => $this->splash_show_background ? 'true' : 'false',
                    'splash_logo_url' => $splashLogoPath,
                    'splash_background_url' => $splashBackgroundPath,
                ]),

                // Legacy splash JSON for mobile app compatibility
                'splash' => json_encode([
                    'first_color' => $this->splash_first_color,
                    'second_color' => $this->splash_second_color,
                    'title' => $this->splash_title,
                    'title_color' => $this->splash_title_color,
                    'show_logo' => $this->splash_show_logo,
                    'show_title' => $this->splash_show_title,
                    'show_background' => $this->splash_show_background,
                    'logo' => $splashLogoPath,
                    'background' => $splashBackgroundPath,
                ]),

                // Individual splash settings for admin panel
                'splash_first_color' => $this->splash_first_color,
                'splash_second_color' => $this->splash_second_color,
                'splash_title' => $this->splash_title,
                'splash_title_color' => $this->splash_title_color,
                'splash_show_logo' => $this->splash_show_logo,
                'splash_show_title' => $this->splash_show_title,
                'splash_show_background' => $this->splash_show_background,
                'splash_logo' => $splashLogoPath,
                'splash_background' => $splashBackgroundPath,

                // Legacy theme JSON for compatibility
                'theme' => json_encode([
                    'themeStyle' => $this->theme_style,
                    'customColor' => $this->theme_custom_color,
                    'gradientColor1' => $this->theme_gradient_color1,
                    'gradientColor2' => $this->theme_gradient_color2,
                ]),

                // Individual theme settings for admin panel
                'theme_style' => $this->theme_style,
                'theme_custom_color' => $this->theme_custom_color,
                'theme_gradient_color1' => $this->theme_gradient_color1,
                'theme_gradient_color2' => $this->theme_gradient_color2,
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
            session()->flash('error', 'Error saving configuration: '.$e->getMessage());
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

    public function removeFloatingButtonLogo(): void
    {
        if ($this->floating_button_logo_preview) {
            $fileUploadService = app(FileUploadService::class);
            $fileUploadService->deleteFile($this->floating_button_logo_preview);
            $this->floating_button_logo_preview = null;

            AppSetting::where('key', 'floating_button_logo')->update(['value' => null]);

            session()->flash('success', 'Floating button logo removed successfully!');
        }
    }

    public function removeSplashLogo(): void
    {
        if ($this->splash_logo_preview) {
            $fileUploadService = app(FileUploadService::class);
            $fileUploadService->deleteFile($this->splash_logo_preview);
            $this->splash_logo_preview = null;

            AppSetting::where('key', 'splash_logo')->update(['value' => null]);

            session()->flash('success', 'Splash logo removed successfully!');
        }
    }

    public function removeSplashBackground(): void
    {
        if ($this->splash_background_preview) {
            $fileUploadService = app(FileUploadService::class);
            $fileUploadService->deleteFile($this->splash_background_preview);
            $this->splash_background_preview = null;

            AppSetting::where('key', 'splash_background')->update(['value' => null]);

            session()->flash('success', 'Splash background removed successfully!');
        }
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
                text: 'Error during export: '.$e->getMessage(),
                variant: 'danger'
            );
        }
    }
}; ?>

<div class="py-6 px-4" x-data="{ activeTab: 'basic' }">
    <div class="w-full sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-3">
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
                        :class="activeTab === 'basic' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    <i class="ri-smartphone-line mr-2"></i>Basic Info
                </button>
                <button @click="activeTab = 'urls'" 
                        :class="activeTab === 'urls' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    <i class="ri-links-line mr-2"></i>URLs & Links
                </button>
                <button @click="activeTab = 'api'" 
                        :class="activeTab === 'api' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    <i class="ri-server-line mr-2"></i>API & Behavior
                </button>
                <button @click="activeTab = 'social'" 
                        :class="activeTab === 'social' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    <i class="ri-share-line mr-2"></i>Social & Contact
                </button>
                <button @click="activeTab = 'integrations'" 
                        :class="activeTab === 'integrations' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    <i class="ri-puzzle-line mr-2"></i>Integrations
                </button>
                <button @click="activeTab = 'appconfig'" 
                        :class="activeTab === 'appconfig' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    <i class="ri-settings-3-line mr-2"></i>App Config
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
                               class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
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
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
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
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
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
                                    <img src="{{ asset($app_logo_preview) }}" 
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
                                
                                <div wire:loading wire:target="app_logo" class="mt-2 text-sm text-primary-600 dark:text-primary-400">
                                    <i class="ri-loader-4-line animate-spin mr-1"></i>
                                    Uploading...
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- About App Configuration -->
                    <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">About App Configuration</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Configure the About section with social media links and contact information</p>
                            </div>
                            
                            <!-- Show About Toggle -->
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="show_about" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    {{ $show_about ? 'Enabled' : 'Disabled' }}
                                </span>
                            </label>
                        </div>

                        <!-- About Fields (shown when enabled) -->
                        <div x-show="$wire.show_about" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             class="space-y-6">
                            
                            <!-- Social Media Links - Row 1 -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- WhatsApp -->
                                <div>
                                    <label for="about_whatsapp" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="ri-whatsapp-line text-green-500 mr-1"></i>
                                        WhatsApp Number
                                    </label>
                                    <input type="text" 
                                           id="about_whatsapp" 
                                           wire:model="about_whatsapp"
                                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                           placeholder="+1234567890">
                                    @error('about_whatsapp') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Instagram -->
                                <div>
                                    <label for="about_instagram" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="ri-instagram-line text-pink-500 mr-1"></i>
                                        Instagram URL
                                    </label>
                                    <input type="url" 
                                           id="about_instagram" 
                                           wire:model="about_instagram"
                                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                           placeholder="https://instagram.com/username">
                                    @error('about_instagram') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Social Media Links - Row 2 -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Twitter -->
                                <div>
                                    <label for="about_twitter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="ri-twitter-x-line text-gray-900 dark:text-white mr-1"></i>
                                        Twitter/X URL
                                    </label>
                                    <input type="url" 
                                           id="about_twitter" 
                                           wire:model="about_twitter"
                                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                           placeholder="https://twitter.com/username">
                                    @error('about_twitter') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Facebook -->
                                <div>
                                    <label for="about_facebook" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="ri-facebook-line text-primary-600 mr-1"></i>
                                        Facebook URL
                                    </label>
                                    <input type="url" 
                                           id="about_facebook" 
                                           wire:model="about_facebook"
                                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                           placeholder="https://facebook.com/username">
                                    @error('about_facebook') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Contact Info -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Phone -->
                                <div>
                                    <label for="about_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="ri-phone-line text-primary-500 mr-1"></i>
                                        Phone Number
                                    </label>
                                    <input type="text" 
                                           id="about_phone" 
                                           wire:model="about_phone"
                                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                           placeholder="+1234567890">
                                    @error('about_phone') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Snapchat -->
                                <div>
                                    <label for="about_snapchat" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="ri-snapchat-line text-yellow-500 mr-1"></i>
                                        Snapchat Username
                                    </label>
                                    <input type="text" 
                                           id="about_snapchat" 
                                           wire:model="about_snapchat"
                                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                           placeholder="snapchat_username">
                                    @error('about_snapchat') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Additional Platforms -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Skype -->
                                <div>
                                    <label for="about_skype" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="ri-skype-line text-primary-400 mr-1"></i>
                                        Skype URL
                                    </label>
                                    <input type="url" 
                                           id="about_skype" 
                                           wire:model="about_skype"
                                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                           placeholder="https://join.skype.com/...">
                                    @error('about_skype') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Messenger -->
                                <div>
                                    <label for="about_messenger" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="ri-messenger-line text-primary-500 mr-1"></i>
                                        Messenger URL
                                    </label>
                                    <input type="url" 
                                           id="about_messenger" 
                                           wire:model="about_messenger"
                                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                           placeholder="https://m.me/username">
                                    @error('about_messenger') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- YouTube -->
                            <div>
                                <label for="about_youtube" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="ri-youtube-line text-red-600 mr-1"></i>
                                    YouTube Channel URL
                                </label>
                                <input type="url" 
                                       id="about_youtube" 
                                       wire:model="about_youtube"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="https://youtube.com/@channel">
                                @error('about_youtube') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Copyright -->
                            <div>
                                <label for="about_copyright" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="ri-copyright-line mr-1"></i>
                                    Copyright Text
                                </label>
                                <input type="text" 
                                       id="about_copyright" 
                                       wire:model="about_copyright"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="© 2024 Your Company. All rights reserved.">
                                @error('about_copyright') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="about_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="ri-file-text-line mr-1"></i>
                                    About Description
                                </label>
                                <textarea id="about_description" 
                                          wire:model="about_description"
                                          rows="4"
                                          class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white resize-none"
                                          placeholder="Describe your app, company, or provide additional information..."></textarea>
                                @error('about_description') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
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
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
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
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
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
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
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
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
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
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
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
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
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
                                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 @if($force_update) bg-primary-600 @else bg-gray-200 dark:bg-gray-700 @endif">
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
                                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 @if($maintenance_mode) bg-primary-600 @else bg-gray-200 dark:bg-gray-700 @endif">
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
                                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 @if($cache_enabled) bg-primary-600 @else bg-gray-200 dark:bg-gray-700 @endif">
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
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
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
                                          class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                          placeholder="We're currently performing maintenance. Please check back soon."></textarea>
                                @error('maintenance_message') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    </div>

                    <!-- Exit Popup Configuration -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                <i class="ri-logout-box-r-line text-red-500 mr-2"></i>Exit Popup Configuration
                            </h4>
                            <button type="button"
                                    wire:click="$toggle('exit_popup_enabled')"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 @if($exit_popup_enabled) bg-primary-600 @else bg-gray-200 dark:bg-gray-700 @endif">
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform @if($exit_popup_enabled) translate-x-6 @else translate-x-1 @endif"></span>
                            </button>
                        </div>

                        @if($exit_popup_enabled)
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Title -->
                                <div>
                                    <label for="exit_popup_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Title
                                    </label>
                                    <input type="text" 
                                           id="exit_popup_title" 
                                           wire:model="exit_popup_title"
                                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                           placeholder="Are you sure?">
                                    @error('exit_popup_title') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Positive Text -->
                                <div>
                                    <label for="exit_popup_positive_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Positive Text
                                    </label>
                                    <input type="text" 
                                           id="exit_popup_positive_text" 
                                           wire:model="exit_popup_positive_text"
                                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                           placeholder="Yes, Exit">
                                    @error('exit_popup_positive_text') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Negative Text -->
                                <div>
                                    <label for="exit_popup_negative_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Negative Text
                                    </label>
                                    <input type="text" 
                                           id="exit_popup_negative_text" 
                                           wire:model="exit_popup_negative_text"
                                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                           placeholder="No, Stay">
                                    @error('exit_popup_negative_text') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Image Upload Section -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Exit Popup Image
                                        </label>
                                        <button type="button"
                                                wire:click="$toggle('exit_popup_show_image')"
                                                class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400">
                                            {{ $exit_popup_show_image ? 'Hide Image' : 'Show Image' }}
                                        </button>
                                    </div>
                                    
                                    <flux:input 
                                        type="file" 
                                        wire:model="exit_popup_image" 
                                        accept="image/*" 
                                        description="Upload an image for the exit popup (max 2MB)" />
                                    
                                    @error('exit_popup_image') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Image Preview -->
                                @if($exit_popup_image_preview || $exit_popup_image)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Preview
                                        </label>
                                        <div class="relative w-32 h-32 rounded-lg overflow-hidden border-2 border-gray-300 dark:border-gray-600">
                                            @if($exit_popup_image)
                                                <img src="{{ $exit_popup_image->temporaryUrl() }}" 
                                                     alt="Exit popup image preview" 
                                                     class="w-full h-full object-cover">
                                            @elseif($exit_popup_image_preview)
                                                <img src="{{ $exit_popup_image_preview }}" 
                                                     alt="Current exit popup image" 
                                                     class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                    </div>
                                @endif
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
                                    <i class="ri-facebook-fill text-primary-600 mr-1"></i> Facebook URL
                                </label>
                                <input type="url" 
                                       id="facebook_url" 
                                       wire:model="facebook_url"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="https://facebook.com/yourpage">
                                @error('facebook_url') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="twitter_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="ri-twitter-fill text-primary-400 mr-1"></i> Twitter URL
                                </label>
                                <input type="url" 
                                       id="twitter_url" 
                                       wire:model="twitter_url"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
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
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
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
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="https://youtube.com/yourchannel">
                                @error('youtube_url') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="linkedin_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="ri-linkedin-fill text-primary-700 mr-1"></i> LinkedIn URL
                                </label>
                                <input type="url" 
                                       id="linkedin_url" 
                                       wire:model="linkedin_url"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
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
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
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
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
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
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 @if($firebase_enabled) bg-primary-600 @else bg-gray-200 dark:bg-gray-700 @endif">
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
                                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
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
                                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
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
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 @if($analytics_enabled) bg-primary-600 @else bg-gray-200 dark:bg-gray-700 @endif">
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
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                                       placeholder="UA-XXXXXXXXX-X or G-XXXXXXXXXX">
                                @error('analytics_tracking_id') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    </div>

                    <!-- AdMob Configuration -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700" x-data="{ adsType: @entangle('ads_type') }">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                <i class="ri-advertisement-fill text-primary-500 mr-2"></i>Ads Configuration
                            </h4>
                            
                            <!-- Ads Type Selection -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    Select Ads Type
                                </label>
                                <div class="flex flex-wrap gap-4">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" 
                                               wire:model.live="ads_type" 
                                               value="none" 
                                               class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">None</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" 
                                               wire:model.live="ads_type" 
                                               value="admob" 
                                               class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">AdMob</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" 
                                               wire:model.live="ads_type" 
                                               value="facebook" 
                                               class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Facebook</span>
                                    </label>
                                </div>
                                @error('ads_type') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- AdMob Settings -->
                            <div x-show="adsType === 'admob'" class="space-y-4">
                                <h5 class="text-md font-semibold text-gray-800 dark:text-gray-200">AdMob Unit IDs</h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Android -->
                                    <div class="space-y-4">
                                        <h6 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase">Android</h6>
                                        <div>
                                            <label for="admob_banner_id_android" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Banner Unit ID
                                            </label>
                                            <input type="text" 
                                                   id="admob_banner_id_android" 
                                                   wire:model="admob_banner_id_android"
                                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                                                   placeholder="ca-app-pub-XXXXX/XXXXX">
                                            @error('admob_banner_id_android') 
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="admob_interstitial_id_android" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Interstitial Unit ID
                                            </label>
                                            <input type="text" 
                                                   id="admob_interstitial_id_android" 
                                                   wire:model="admob_interstitial_id_android"
                                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                                                   placeholder="ca-app-pub-XXXXX/XXXXX">
                                            @error('admob_interstitial_id_android') 
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- iOS -->
                                    <div class="space-y-4">
                                        <h6 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase">iOS</h6>
                                        <div>
                                            <label for="admob_banner_id_ios" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Banner Unit ID
                                            </label>
                                            <input type="text" 
                                                   id="admob_banner_id_ios" 
                                                   wire:model="admob_banner_id_ios"
                                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                                                   placeholder="ca-app-pub-XXXXX/XXXXX">
                                            @error('admob_banner_id_ios') 
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="admob_interstitial_id_ios" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Interstitial Unit ID
                                            </label>
                                            <input type="text" 
                                                   id="admob_interstitial_id_ios" 
                                                   wire:model="admob_interstitial_id_ios"
                                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                                                   placeholder="ca-app-pub-XXXXX/XXXXX">
                                            @error('admob_interstitial_id_ios') 
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Facebook Ads Settings -->
                            <div x-show="adsType === 'facebook'" class="space-y-4">
                                <h5 class="text-md font-semibold text-gray-800 dark:text-gray-200">Facebook Ads Unit IDs</h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Android -->
                                    <div class="space-y-4">
                                        <h6 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase">Android</h6>
                                        <div>
                                            <label for="facebook_banner_id_android" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Banner Unit ID
                                            </label>
                                            <input type="text" 
                                                   id="facebook_banner_id_android" 
                                                   wire:model="facebook_banner_id_android"
                                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                                                   placeholder="XXXXX_XXXXX">
                                            @error('facebook_banner_id_android') 
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="facebook_interstitial_id_android" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Interstitial Unit ID
                                            </label>
                                            <input type="text" 
                                                   id="facebook_interstitial_id_android" 
                                                   wire:model="facebook_interstitial_id_android"
                                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                                                   placeholder="XXXXX_XXXXX">
                                            @error('facebook_interstitial_id_android') 
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- iOS -->
                                    <div class="space-y-4">
                                        <h6 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase">iOS</h6>
                                        <div>
                                            <label for="facebook_banner_id_ios" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Banner Unit ID
                                            </label>
                                            <input type="text" 
                                                   id="facebook_banner_id_ios" 
                                                   wire:model="facebook_banner_id_ios"
                                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                                                   placeholder="XXXXX_XXXXX">
                                            @error('facebook_banner_id_ios') 
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="facebook_interstitial_id_ios" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Interstitial Unit ID
                                            </label>
                                            <input type="text" 
                                                   id="facebook_interstitial_id_ios" 
                                                   wire:model="facebook_interstitial_id_ios"
                                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                                                   placeholder="XXXXX_XXXXX">
                                            @error('facebook_interstitial_id_ios') 
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- OneSignal Configuration -->
                    <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="mb-4">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                <i class="ri-notification-3-line text-primary-500 mr-2"></i>
                                OneSignal Push Notifications
                            </h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Configure OneSignal for sending push notifications to your mobile app users</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- OneSignal App ID -->
                            <div>
                                <label for="onesignal_app_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="ri-key-line mr-1"></i>
                                    OneSignal App ID
                                </label>
                                <input type="text" 
                                       id="onesignal_app_id" 
                                       wire:model="onesignal_app_id"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                                       placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx">
                                @error('onesignal_app_id') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <i class="ri-information-line mr-1"></i>
                                    Find this in your OneSignal dashboard under Settings → Keys & IDs
                                </p>
                            </div>

                            <!-- OneSignal REST API Key -->
                            <div>
                                <label for="onesignal_rest_api_key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="ri-shield-keyhole-line mr-1"></i>
                                    REST API Key
                                </label>
                                <input type="password" 
                                       id="onesignal_rest_api_key" 
                                       wire:model="onesignal_rest_api_key"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                                       placeholder="Enter your REST API Key">
                                @error('onesignal_rest_api_key') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <i class="ri-information-line mr-1"></i>
                                    Find this in your OneSignal dashboard under Settings → Keys & IDs
                                </p>
                            </div>
                        </div>

                        <!-- Help Text -->
                        <div class="mt-4 p-4 bg-primary-50 dark:bg-primary-900/20 border border-primary-200 dark:border-primary-800 rounded-lg">
                            <div class="flex items-start">
                                <i class="ri-lightbulb-line text-primary-600 dark:text-primary-400 text-xl mr-3 mt-0.5"></i>
                                <div>
                                    <h5 class="text-sm font-medium text-primary-900 dark:text-primary-200 mb-1">How to get your OneSignal credentials:</h5>
                                    <ol class="text-sm text-primary-800 dark:text-primary-300 space-y-1 list-decimal list-inside">
                                        <li>Log in to your <a href="https://onesignal.com" target="_blank" class="underline hover:text-primary-600 dark:hover:text-primary-200">OneSignal account</a></li>
                                        <li>Select your app from the dashboard</li>
                                        <li>Go to Settings → Keys & IDs</li>
                                        <li>Copy your App ID and REST API Key and paste them above</li>
                                    </ol>
                                    <p class="text-sm text-primary-800 dark:text-primary-300 mt-2">
                                        After configuration, you can send push notifications from the <a href="" class="underline hover:text-primary-600 dark:hover:text-primary-200">Push Notifications page</a>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: App Config -->
                <div x-show="activeTab === 'appconfig'" class="p-6 space-y-6" x-data="{ openSection: 'navigation' }">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Advanced Mobile App Configuration</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Configure advanced mobile app settings, navigation styles, and behavior options</p>
                    </div>

                    <!-- Navigation Settings Accordion -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <button type="button" 
                                @click="openSection = openSection === 'navigation' ? '' : 'navigation'"
                                class="w-full flex items-center justify-between px-6 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                            <div class="flex items-center">
                                <i class="ri-navigation-line text-primary-600 dark:text-primary-400 text-xl mr-3"></i>
                                <div class="text-left">
                                    <h4 class="text-md font-semibold text-gray-900 dark:text-white">Navigation & Styles</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Configure app language, navigation, and display styles</p>
                                </div>
                            </div>
                            <i class="ri-arrow-down-s-line text-gray-400 text-xl transition-transform" :class="{ 'rotate-180': openSection === 'navigation' }"></i>
                        </button>
                        
                        <div x-show="openSection === 'navigation'" x-collapse class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                            <!-- App Language & Navigation -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- App Language -->
                        <div>
                            <label for="app_language" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="ri-global-line mr-1"></i>
                                App Language <span class="text-red-500">*</span>
                            </label>
                            <select id="app_language" 
                                    wire:model="app_language"
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="en">English</option>
                                <option value="ar">Arabic</option>
                                <option value="fr">French</option>
                                <option value="de">German</option>
                                <option value="es">Spanish</option>
                                <option value="af">Afrikaans</option>
                                <option value="pt">Portuguese</option>
                                <option value="tr">Turkish</option>
                                <option value="id">Indonesian</option>
                                <option value="ja">Japanese</option>
                                <option value="nl">Dutch</option>
                                <option value="hi">Hindi</option>
                                <option value="it">Italian</option>
                                <option value="ko">Korean</option>
                                <option value="ne">Nepali</option>
                                <option value="ru">Russian</option>
                                <option value="vi">Vietnamese</option>
                                <option value="he">Hebrew</option>
                                <option value="th">Thai</option>
                            </select>
                            @error('app_language') 
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Navigation Style -->
                        <div>
                            <label for="navigation_style" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="ri-navigation-line mr-1"></i>
                                Navigation Style <span class="text-red-500">*</span>
                            </label>
                            <select id="navigation_style" 
                                    wire:model="navigation_style"
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="sidedrawer">Side Drawer</option>
                                <option value="bottom_navigation">Bottom Navigation</option>
                                <option value="fullscreen">Full Screen</option>
                                <option value="tabs">Tabs</option>
                                <option value="sidedrawer_bottom_navigation">Side Drawer & Bottom Navigation</option>
                                <option value="sidedrawer_tabs">Side Drawer & Tab</option>
                            </select>
                            @error('navigation_style') 
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Header Style -->
                        <div>
                            <label for="header_style" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="ri-layout-top-line mr-1"></i>
                                Header Style <span class="text-red-500">*</span>
                            </label>
                            <select id="header_style" 
                                    wire:model="header_style"
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="left">Left</option>
                                <option value="center">Center</option>
                                <option value="empty_header">Empty Header</option>
                            </select>
                            @error('header_style') 
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tab Style -->
                        <div>
                            <label for="tab_style" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="ri-layout-bottom-line mr-1"></i>
                                Tab Style
                            </label>
                            <select id="tab_style" 
                                    wire:model="tab_style"
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="simple_tab">Simple Tabbar</option>
                                <option value="tab_with_title_icon">Tabbar with Title and Icon</option>
                                <option value="tab_with_icon">Tabbar with Icon</option>
                            </select>
                            @error('tab_style') 
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bottom Navigation Style -->
                        <div>
                            <label for="bottom_navigation_style" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="ri-layout-grid-line mr-1"></i>
                                Bottom Navigation Style
                            </label>
                            <select id="bottom_navigation_style" 
                                    wire:model="bottom_navigation_style"
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="bottom_navigation_1">Bottom Navigation 1</option>
                                <option value="bottom_navigation_2">Bottom Navigation 2</option>
                                <option value="bottom_navigation_3">Bottom Navigation 3</option>
                            </select>
                            @error('bottom_navigation_style') 
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Walkthrough Style -->
                        <div>
                            <label for="walkthrough_style" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="ri-slideshow-line mr-1"></i>
                                Walkthrough Style
                            </label>
                            <select id="walkthrough_style" 
                                    wire:model="walkthrough_style"
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="walkthrough_style_1">Walkthrough Style 1</option>
                                <option value="walkthrough_style_2">Walkthrough Style 2</option>
                                <option value="walkthrough_style_3">Walkthrough Style 3</option>
                            </select>
                            @error('walkthrough_style') 
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Floating Button Style -->
                        <div>
                            <label for="floating_button_style" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="ri-add-circle-line mr-1"></i>
                                Floating Button Style
                            </label>
                            <select id="floating_button_style" 
                                    wire:model="floating_button_style"
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="regular">Regular</option>
                                <option value="circular">Circular</option>
                            </select>
                            @error('floating_button_style') 
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                        </div>
                    </div>

                    <!-- Feature Toggles Accordion -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <button type="button" 
                                @click="openSection = openSection === 'features' ? '' : 'features'"
                                class="w-full flex items-center justify-between px-6 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                            <div class="flex items-center">
                                <i class="ri-toggle-line text-primary-600 dark:text-primary-400 text-xl mr-3"></i>
                                <div class="text-left">
                                    <h4 class="text-md font-semibold text-gray-900 dark:text-white">Feature Toggles</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Enable or disable app features and functionality</p>
                                </div>
                            </div>
                            <i class="ri-arrow-down-s-line text-gray-400 text-xl transition-transform" :class="{ 'rotate-180': openSection === 'features' }"></i>
                        </button>
                        
                        <div x-show="openSection === 'features'" x-collapse class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                            <!-- Feature Toggles Section 1 -->
                            <div>
                                <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-4">Core Features</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- JavaScript Enabled -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">JavaScript Enabled</label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Enable JavaScript execution</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="javascript_enabled" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                                </label>
                            </div>

                            <!-- Splash Screen -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Splash Screen</label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Show splash screen on launch</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="splash_screen_enabled" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                                </label>
                            </div>

                            <!-- Zoom Functionality -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Zoom Functionality</label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Allow pinch-to-zoom</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="zoom_functionality" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                                </label>
                            </div>

                            <!-- Walkthrough -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Walkthrough</label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Show onboarding screens</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="walkthrough_enabled" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                                </label>
                            </div>

                            <!-- WebRTC -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">WebRTC Support</label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Enable real-time communication</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="webrtc_enabled" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                                </label>
                            </div>

                            <!-- Pull to Refresh -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Pull to Refresh</label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Enable swipe-to-refresh</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="pull_refresh_enabled" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                                </label>
                            </div>

                            <!-- Clear Cookies -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Clear Cookies</label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Clear cookies on app start</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="clear_cookies" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                                </label>
                            </div>

                            <!-- Floating Button -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Floating Action Button</label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Show floating action button</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="floating_button_enabled" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                                </label>
                            </div>

                            <!-- Disable Header -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Disable Header</label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Hide app header bar</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="disable_header" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                                </label>
                            </div>

                            <!-- Disable Footer -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Disable Footer</label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Hide app footer bar</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="disable_footer" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                                </label>
                            </div>

                            <!-- Disable Left Icon -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Disable Left Icon</label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Hide header left icon</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="disable_left_icon" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Button Logo Upload -->
                    <div x-show="$wire.floating_button_enabled" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Floating Button Logo
                        </label>
                        <div class="flex items-start space-x-4">
                            <!-- Logo Preview -->
                            <div class="flex-shrink-0">
                                @if ($floating_button_logo)
                                    <img src="{{ $floating_button_logo->temporaryUrl() }}" 
                                         alt="Floating Button Preview" 
                                         class="w-24 h-24 rounded-lg object-cover border-2 border-gray-300 dark:border-gray-600">
                                @elseif ($floating_button_logo_preview)
                                    <img src="{{ $floating_button_logo_preview }}" 
                                         alt="Current Floating Button Logo" 
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
                                               wire:model="floating_button_logo" 
                                               accept="image/*" 
                                               class="hidden">
                                    </label>
                                    
                                    @if ($floating_button_logo_preview)
                                        <button type="button" 
                                                wire:click="removeFloatingButtonLogo"
                                                class="px-4 py-2 bg-red-50 dark:bg-red-900/20 border border-red-300 dark:border-red-600 rounded-lg text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors">
                                            <i class="ri-delete-bin-line mr-2"></i>
                                            Remove
                                        </button>
                                    @endif
                                </div>
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    PNG, JPG up to 2MB. Recommended size: 256x256px
                                </p>
                                @error('floating_button_logo') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                
                                <div wire:loading wire:target="floating_button_logo" class="mt-2 text-sm text-primary-600 dark:text-primary-400">
                                    <i class="ri-loader-4-line animate-spin mr-1"></i>
                                    Uploading...
                                </div>
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>

                    <!-- Progress Bar Settings Accordion -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <button type="button" 
                                @click="openSection = openSection === 'progressbar' ? '' : 'progressbar'"
                                class="w-full flex items-center justify-between px-6 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                            <div class="flex items-center">
                                <i class="ri-loader-line text-primary-600 dark:text-primary-400 text-xl mr-3"></i>
                                <div class="text-left">
                                    <h4 class="text-md font-semibold text-gray-900 dark:text-white">Progress Bar Settings</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Configure page loading progress indicators</p>
                                </div>
                            </div>
                            <i class="ri-arrow-down-s-line text-gray-400 text-xl transition-transform" :class="{ 'rotate-180': openSection === 'progressbar' }"></i>
                        </button>
                        
                        <div x-show="openSection === 'progressbar'" x-collapse class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                            <!-- Enable Progress Bar Toggle -->
                            <div class="mb-6">
                                <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-lg">
                                    <div>
                                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Enable Progress Bar</label>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Show loading progress indicator</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" wire:model="progress_bar_enabled" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- Progress Bar Style Selection -->
                            <div x-show="$wire.progress_bar_enabled" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform scale-95"
                                 x-transition:enter-end="opacity-100 transform scale-100">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    <i class="ri-palette-line mr-1"></i>
                                    Select Progress Bar Style
                                </label>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    <!-- Circle -->
                                    <label class="cursor-pointer">
                                        <input type="radio" wire:model="progress_bar_style" value="Circle" class="sr-only peer">
                                        <div class="p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg peer-checked:border-primary-600 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 hover:border-primary-300 transition-colors">
                                            <div class="aspect-square mb-2 flex items-center justify-center">
                                                <img src="https://raw.githubusercontent.com/ybq/Android-SpinKit/master/art/Circle.gif" alt="Circle" class="max-w-full max-h-full">
                                            </div>
                                            <p class="text-xs text-center font-medium">Circle</p>
                                        </div>
                                    </label>

                                    <!-- Circle Flip -->
                                    <label class="cursor-pointer">
                                        <input type="radio" wire:model="progress_bar_style" value="ChasingDots" class="sr-only peer">
                                        <div class="p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg peer-checked:border-primary-600 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 hover:border-primary-300 transition-colors">
                                            <div class="aspect-square mb-2 flex items-center justify-center">
                                                <img src="https://raw.githubusercontent.com/ybq/Android-SpinKit/master/art/ChasingDots.gif" alt="ChasingDots" class="max-w-full max-h-full">
                                            </div>
                                            <p class="text-xs text-center font-medium">Chasing Dots</p>
                                        </div>
                                    </label>

                                    <!-- Cube Grid -->
                                    <label class="cursor-pointer">
                                        <input type="radio" wire:model="progress_bar_style" value="CubeGrid" class="sr-only peer">
                                        <div class="p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg peer-checked:border-primary-600 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 hover:border-primary-300 transition-colors">
                                            <div class="aspect-square mb-2 flex items-center justify-center">
                                                <img src="https://raw.githubusercontent.com/ybq/Android-SpinKit/master/art/CubeGrid.gif" alt="CubeGrid" class="max-w-full max-h-full">
                                            </div>
                                            <p class="text-xs text-center font-medium">Cube Grid</p>
                                        </div>
                                    </label>

                                    <!-- Double Bounce -->
                                    <label class="cursor-pointer">
                                        <input type="radio" wire:model="progress_bar_style" value="DoubleBounce" class="sr-only peer">
                                        <div class="p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg peer-checked:border-primary-600 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 hover:border-primary-300 transition-colors">
                                            <div class="aspect-square mb-2 flex items-center justify-center">
                                                <img src="https://raw.githubusercontent.com/ybq/Android-SpinKit/master/art/DoubleBounce.gif" alt="DoubleBounce" class="max-w-full max-h-full">
                                            </div>
                                            <p class="text-xs text-center font-medium">Double Bounce</p>
                                        </div>
                                    </label>

                                    <!-- Fading Circle -->
                                    <label class="cursor-pointer">
                                        <input type="radio" wire:model="progress_bar_style" value="FadingCircle" class="sr-only peer">
                                        <div class="p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg peer-checked:border-primary-600 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 hover:border-primary-300 transition-colors">
                                            <div class="aspect-square mb-2 flex items-center justify-center">
                                                <img src="https://raw.githubusercontent.com/ybq/Android-SpinKit/master/art/FadingCircle.gif" alt="FadingCircle" class="max-w-full max-h-full">
                                            </div>
                                            <p class="text-xs text-center font-medium">Fading Circle</p>
                                        </div>
                                    </label>

                                    <!-- Folding Cube -->
                                    <label class="cursor-pointer">
                                        <input type="radio" wire:model="progress_bar_style" value="FoldingCube" class="sr-only peer">
                                        <div class="p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg peer-checked:border-primary-600 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 hover:border-primary-300 transition-colors">
                                            <div class="aspect-square mb-2 flex items-center justify-center">
                                                <img src="https://raw.githubusercontent.com/ybq/Android-SpinKit/master/art/FoldingCube.gif" alt="FoldingCube" class="max-w-full max-h-full">
                                            </div>
                                            <p class="text-xs text-center font-medium">Folding Cube</p>
                                        </div>
                                    </label>

                                    <!-- Pulse -->
                                    <label class="cursor-pointer">
                                        <input type="radio" wire:model="progress_bar_style" value="Pulse" class="sr-only peer">
                                        <div class="p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg peer-checked:border-primary-600 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 hover:border-primary-300 transition-colors">
                                            <div class="aspect-square mb-2 flex items-center justify-center">
                                                <img src="https://raw.githubusercontent.com/ybq/Android-SpinKit/master/art/Pulse.gif" alt="Pulse" class="max-w-full max-h-full">
                                            </div>
                                            <p class="text-xs text-center font-medium">Pulse</p>
                                        </div>
                                    </label>

                                    <!-- Rotating Circle -->
                                    <label class="cursor-pointer">
                                        <input type="radio" wire:model="progress_bar_style" value="RotatingCircle" class="sr-only peer">
                                        <div class="p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg peer-checked:border-primary-600 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 hover:border-primary-300 transition-colors">
                                            <div class="aspect-square mb-2 flex items-center justify-center">
                                                <img src="https://raw.githubusercontent.com/ybq/Android-SpinKit/master/art/RotatingCircle.gif" alt="RotatingCircle" class="max-w-full max-h-full">
                                            </div>
                                            <p class="text-xs text-center font-medium">Rotating Circle</p>
                                        </div>
                                    </label>

                                    <!-- Rotating Plane -->
                                    <label class="cursor-pointer">
                                        <input type="radio" wire:model="progress_bar_style" value="RotatingPlane" class="sr-only peer">
                                        <div class="p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg peer-checked:border-primary-600 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 hover:border-primary-300 transition-colors">
                                            <div class="aspect-square mb-2 flex items-center justify-center">
                                                <img src="https://raw.githubusercontent.com/ybq/Android-SpinKit/master/art/RotatingPlane.gif" alt="RotatingPlane" class="max-w-full max-h-full">
                                            </div>
                                            <p class="text-xs text-center font-medium">Rotating Plane</p>
                                        </div>
                                    </label>

                                    <!-- Three Bounce -->
                                    <label class="cursor-pointer">
                                        <input type="radio" wire:model="progress_bar_style" value="ThreeBounce" class="sr-only peer">
                                        <div class="p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg peer-checked:border-primary-600 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 hover:border-primary-300 transition-colors">
                                            <div class="aspect-square mb-2 flex items-center justify-center">
                                                <img src="https://raw.githubusercontent.com/ybq/Android-SpinKit/master/art/ThreeBounce.gif" alt="ThreeBounce" class="max-w-full max-h-full">
                                            </div>
                                            <p class="text-xs text-center font-medium">Three Bounce</p>
                                        </div>
                                    </label>

                                    <!-- Wandering Cubes -->
                                    <label class="cursor-pointer">
                                        <input type="radio" wire:model="progress_bar_style" value="WanderingCubes" class="sr-only peer">
                                        <div class="p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg peer-checked:border-primary-600 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 hover:border-primary-300 transition-colors">
                                            <div class="aspect-square mb-2 flex items-center justify-center">
                                                <img src="https://raw.githubusercontent.com/ybq/Android-SpinKit/master/art/WanderingCubes.gif" alt="WanderingCubes" class="max-w-full max-h-full">
                                            </div>
                                            <p class="text-xs text-center font-medium">Wandering Cubes</p>
                                        </div>
                                    </label>

                                    <!-- Wave -->
                                    <label class="cursor-pointer">
                                        <input type="radio" wire:model="progress_bar_style" value="Wave" class="sr-only peer">
                                        <div class="p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg peer-checked:border-primary-600 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 hover:border-primary-300 transition-colors">
                                            <div class="aspect-square mb-2 flex items-center justify-center">
                                                <img src="https://raw.githubusercontent.com/ybq/Android-SpinKit/master/art/Wave.gif" alt="Wave" class="max-w-full max-h-full">
                                            </div>
                                            <p class="text-xs text-center font-medium">Wave</p>
                                        </div>
                                    </label>
                                </div>
                                @error('progress_bar_style') 
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Share Content Settings Accordion -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <button type="button" 
                                @click="openSection = openSection === 'share' ? '' : 'share'"
                                class="w-full flex items-center justify-between px-6 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                            <div class="flex items-center">
                                <i class="ri-share-line text-primary-600 dark:text-primary-400 text-xl mr-3"></i>
                                <div class="text-left">
                                    <h4 class="text-md font-semibold text-gray-900 dark:text-white">Share Content Settings</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Configure default share message content</p>
                                </div>
                            </div>
                            <i class="ri-arrow-down-s-line text-gray-400 text-xl transition-transform" :class="{ 'rotate-180': openSection === 'share' }"></i>
                        </button>
                        
                        <div x-show="openSection === 'share'" x-collapse class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                            <div>
                                <label for="share_content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="ri-message-3-line mr-1"></i>
                                    Share Message Content
                                </label>
                                <textarea id="share_content" 
                                          wire:model="share_content"
                                          rows="4"
                                          maxlength="500"
                                          class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white resize-none"
                                          placeholder="Enter the default message users will see when sharing your app..."></textarea>
                                <div class="flex justify-between items-center mt-2">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">This message will be pre-filled when users share your app</p>
                                    <span class="text-xs text-gray-500 dark:text-gray-400"><span x-text="($wire.share_content || '').length"></span>/500</span>
                                </div>
                                @error('share_content') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Splash Screen Settings Accordion -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <button type="button" 
                                @click="openSection = openSection === 'splash' ? '' : 'splash'"
                                class="w-full flex items-center justify-between px-6 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                            <div class="flex items-center">
                                <i class="ri-image-line text-primary-600 dark:text-primary-400 text-xl mr-3"></i>
                                <div class="text-left">
                                    <h4 class="text-md font-semibold text-gray-900 dark:text-white">Splash Screen Settings</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Customize splash screen appearance with colors, logo, and background</p>
                                </div>
                            </div>
                            <i class="ri-arrow-down-s-line text-gray-400 text-xl transition-transform" :class="{ 'rotate-180': openSection === 'splash' }"></i>
                        </button>
                        
                        <div x-show="openSection === 'splash'" x-collapse class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 space-y-6">
                            <!-- Gradient Colors -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- First Color -->
                                <div>
                                    <label for="splash_first_color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="ri-palette-line mr-1"></i>
                                        Gradient Start Color
                                    </label>
                                    <input type="color" 
                                           id="splash_first_color" 
                                           wire:model="splash_first_color"
                                           class="w-full h-12 rounded-lg border border-gray-300 dark:border-gray-600 cursor-pointer">
                                    @error('splash_first_color') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Second Color -->
                                <div>
                                    <label for="splash_second_color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="ri-palette-fill mr-1"></i>
                                        Gradient End Color
                                    </label>
                                    <input type="color" 
                                           id="splash_second_color" 
                                           wire:model="splash_second_color"
                                           class="w-full h-12 rounded-lg border border-gray-300 dark:border-gray-600 cursor-pointer">
                                    @error('splash_second_color') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Title Configuration -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Title Text -->
                                <div>
                                    <label for="splash_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="ri-text mr-1"></i>
                                        Splash Title
                                    </label>
                                    <input type="text" 
                                           id="splash_title" 
                                           wire:model="splash_title"
                                           maxlength="255"
                                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                           placeholder="Enter splash screen title">
                                    @error('splash_title') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Title Color -->
                                <div>
                                    <label for="splash_title_color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="ri-font-color mr-1"></i>
                                        Title Color
                                    </label>
                                    <input type="color" 
                                           id="splash_title_color" 
                                           wire:model="splash_title_color"
                                           class="w-full h-12 rounded-lg border border-gray-300 dark:border-gray-600 cursor-pointer">
                                    @error('splash_title_color') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Display Toggles -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Show Logo Toggle -->
                                <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-lg">
                                    <div>
                                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Show Logo</label>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Display logo on splash</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" wire:model="splash_show_logo" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                                    </label>
                                </div>

                                <!-- Show Title Toggle -->
                                <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-lg">
                                    <div>
                                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Show Title</label>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Display title text</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" wire:model="splash_show_title" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                                    </label>
                                </div>

                                <!-- Show Background Toggle -->
                                <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-lg">
                                    <div>
                                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Show Background</label>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Display background image</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" wire:model="splash_show_background" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- Splash Logo Upload -->
                            <div x-show="$wire.splash_show_logo" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform scale-95"
                                 x-transition:enter-end="opacity-100 transform scale-100">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="ri-image-add-line mr-1"></i>
                                    Splash Logo
                                </label>
                                <div class="flex items-start space-x-4 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <!-- Logo Preview -->
                                    <div class="flex-shrink-0">
                                        @if ($splash_logo)
                                            <img src="{{ $splash_logo->temporaryUrl() }}" 
                                                 alt="Splash Logo Preview" 
                                                 class="w-24 h-24 rounded-lg object-cover border-2 border-gray-300 dark:border-gray-600">
                                        @elseif ($splash_logo_preview)
                                            <img src="{{ $splash_logo_preview }}" 
                                                 alt="Current Splash Logo" 
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
                                                       wire:model="splash_logo" 
                                                       accept="image/*" 
                                                       class="hidden">
                                            </label>
                                            
                                            @if ($splash_logo_preview)
                                                <button type="button" 
                                                        wire:click="removeSplashLogo"
                                                        class="px-4 py-2 bg-red-50 dark:bg-red-900/20 border border-red-300 dark:border-red-600 rounded-lg text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors">
                                                    <i class="ri-delete-bin-line mr-2"></i>
                                                    Remove
                                                </button>
                                            @endif
                                        </div>
                                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                            PNG, JPG up to 2MB. Recommended size: 512x512px
                                        </p>
                                        @error('splash_logo') 
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                        
                                        <div wire:loading wire:target="splash_logo" class="mt-2 text-sm text-primary-600 dark:text-primary-400">
                                            <i class="ri-loader-4-line animate-spin mr-1"></i>
                                            Uploading...
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Splash Background Upload -->
                            <div x-show="$wire.splash_show_background" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform scale-95"
                                 x-transition:enter-end="opacity-100 transform scale-100">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="ri-landscape-line mr-1"></i>
                                    Splash Background
                                </label>
                                <div class="flex items-start space-x-4 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <!-- Background Preview -->
                                    <div class="flex-shrink-0">
                                        @if ($splash_background)
                                            <img src="{{ $splash_background->temporaryUrl() }}" 
                                                 alt="Splash Background Preview" 
                                                 class="w-32 h-24 rounded-lg object-cover border-2 border-gray-300 dark:border-gray-600">
                                        @elseif ($splash_background_preview)
                                            <img src="{{ $splash_background_preview }}" 
                                                 alt="Current Splash Background" 
                                                 class="w-32 h-24 rounded-lg object-cover border-2 border-gray-300 dark:border-gray-600">
                                        @else
                                            <div class="w-32 h-24 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center border-2 border-gray-300 dark:border-gray-600">
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
                                                Choose Background
                                                <input type="file" 
                                                       wire:model="splash_background" 
                                                       accept="image/*" 
                                                       class="hidden">
                                            </label>
                                            
                                            @if ($splash_background_preview)
                                                <button type="button" 
                                                        wire:click="removeSplashBackground"
                                                        class="px-4 py-2 bg-red-50 dark:bg-red-900/20 border border-red-300 dark:border-red-600 rounded-lg text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors">
                                                    <i class="ri-delete-bin-line mr-2"></i>
                                                    Remove
                                                </button>
                                            @endif
                                        </div>
                                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                            PNG, JPG up to 2MB. Recommended size: 1080x1920px (portrait)
                                        </p>
                                        @error('splash_background') 
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                        
                                        <div wire:loading wire:target="splash_background" class="mt-2 text-sm text-primary-600 dark:text-primary-400">
                                            <i class="ri-loader-4-line animate-spin mr-1"></i>
                                            Uploading...
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Save Button (fixed at bottom of form) -->
            <div class="bg-gray-50 dark:bg-gray-900 px-6 py-4 border-t border-gray-200 dark:border-gray-700 rounded-b-lg flex justify-end space-x-3">
                <button type="submit" 
                        wire:loading.attr="disabled"
                        class="inline-flex justify-center items-center px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors disabled:opacity-50">
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

