<?php

namespace MightyWeb\Services;

use MightyWeb\Models\AppSetting;
use MightyWeb\Models\Walkthrough;
use MightyWeb\Models\Menu;
use MightyWeb\Models\LeftHeaderIcon;
use MightyWeb\Models\RightHeaderIcon;
use MightyWeb\Models\Tab;
use MightyWeb\Models\Page;
use MightyWeb\Models\FloatingButton;
use MightyWeb\Models\UserAgent;
use Illuminate\Support\Facades\Storage;

class JsonExportService
{
    /**
     * Generate complete configuration JSON.
     *
     * @return array
     */
    public function generateConfig(): array
    {
        return [
            'app_settings' => $this->getAppSettings(),
            'walkthrough' => $this->getWalkthroughs(),
            'menu' => $this->getMenus(),
            'left_header_icons' => $this->getLeftHeaderIcons(),
            'right_header_icons' => $this->getRightHeaderIcons(),
            'tabs' => $this->getTabs(),
            'pages' => $this->getPages(),
            'floating_buttons' => $this->getFloatingButtons(),
            'theme' => $this->getTheme(),
            'splash' => $this->getSplash(),
            'admob' => $this->getAdmob(),
            'onesignal' => $this->getOneSignal(),
            'progress_bar' => $this->getProgressBar(),
            'exit_popup' => $this->getExitPopup(),
            'share' => $this->getShare(),
            'about' => $this->getAbout(),
            'user_agent' => $this->getUserAgent(),
            'generated_at' => now()->toIso8601String(),
        ];
    }

    /**
     * Export configuration to JSON file.
     *
     * @return string|false Path to the exported file or false on failure
     */
    public function exportToFile()
    {
        $config = $this->generateConfig();
        
        $disk = config('mightyweb.json_export.disk', 'public');
        $path = config('mightyweb.json_export.path', 'mightyweb');
        $filename = config('mightyweb.json_export.filename', 'mightyweb.json');
        
        $fullPath = $path . '/' . $filename;
        
        // Convert to JSON with pretty print
        $json = json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        
        if ($json === false) {
            return false;
        }
        
        // Save to storage
        $saved = Storage::disk($disk)->put($fullPath, $json);
        
        return $saved ? $fullPath : false;
    }

    /**
     * Get app settings.
     *
     * @return array
     */
    protected function getAppSettings(): array
    {
        $appConfig = AppSetting::get('appconfiguration', []);
        
        return is_array($appConfig) ? $appConfig : json_decode($appConfig, true) ?? [];
    }

    /**
     * Get walkthroughs.
     *
     * @return array
     */
    protected function getWalkthroughs(): array
    {
        return Walkthrough::active()
            ->ordered()
            ->get()
            ->map(function ($walkthrough) {
                return [
                    'id' => $walkthrough->id,
                    'title' => $walkthrough->title,
                    'subtitle' => $walkthrough->subtitle,
                    'description' => $walkthrough->subtitle, // Alias for compatibility
                    'image' => $walkthrough->image_url,
                    'status' => $walkthrough->status,
                    'order' => $walkthrough->order,
                ];
            })
            ->toArray();
    }

    /**
     * Get menus with hierarchical structure.
     *
     * @return array
     */
    protected function getMenus(): array
    {
        $parents = Menu::active()
            ->parents()
            ->ordered()
            ->get();

        return $parents->map(function ($menu) {
            return $this->formatMenu($menu);
        })->toArray();
    }

    /**
     * Format menu item with children.
     *
     * @param Menu $menu
     * @return array
     */
    protected function formatMenu(Menu $menu): array
    {
        $data = [
            'id' => $menu->id,
            'title' => $menu->title,
            'type' => $menu->type,
            'image' => $menu->image_url,
            'url' => $menu->url,
            'status' => $menu->status,
            'order' => $menu->order,
        ];

        // Add children if exists
        if ($menu->hasChildren()) {
            $data['children'] = $menu->children->map(function ($child) {
                return $this->formatMenu($child);
            })->toArray();
        }

        return $data;
    }

    /**
     * Get left header icons.
     *
     * @return array
     */
    protected function getLeftHeaderIcons(): array
    {
        return LeftHeaderIcon::active()
            ->get()
            ->map(function ($icon) {
                return [
                    'id' => $icon->id,
                    'title' => $icon->title,
                    'value' => $icon->value,
                    'image' => $icon->image_url,
                    'type' => $icon->type,
                    'url' => $icon->url,
                    'status' => $icon->status,
                ];
            })
            ->toArray();
    }

    /**
     * Get right header icons.
     *
     * @return array
     */
    protected function getRightHeaderIcons(): array
    {
        return RightHeaderIcon::active()
            ->get()
            ->map(function ($icon) {
                return [
                    'id' => $icon->id,
                    'title' => $icon->title,
                    'value' => $icon->value,
                    'image' => $icon->image_url,
                    'type' => $icon->type,
                    'url' => $icon->url,
                    'status' => $icon->status,
                ];
            })
            ->toArray();
    }

    /**
     * Get tabs.
     *
     * @return array
     */
    protected function getTabs(): array
    {
        return Tab::active()
            ->ordered()
            ->get()
            ->map(function ($tab) {
                return [
                    'id' => $tab->id,
                    'title' => $tab->title,
                    'image' => $tab->image_url,
                    'url' => $tab->url,
                    'status' => $tab->status,
                    'order' => $tab->order,
                ];
            })
            ->toArray();
    }

    /**
     * Get pages.
     *
     * @return array
     */
    protected function getPages(): array
    {
        return Page::active()
            ->ordered()
            ->get()
            ->map(function ($page) {
                return [
                    'id' => $page->id,
                    'title' => $page->title,
                    'image' => $page->image_url,
                    'url' => $page->url,
                    'status' => $page->status,
                    'order' => $page->order,
                ];
            })
            ->toArray();
    }

    /**
     * Get floating buttons.
     *
     * @return array
     */
    protected function getFloatingButtons(): array
    {
        return FloatingButton::active()
            ->ordered()
            ->get()
            ->map(function ($button) {
                return [
                    'id' => $button->id,
                    'title' => $button->title,
                    'image' => $button->image_url,
                    'url' => $button->url,
                    'status' => $button->status,
                    'order' => $button->order,
                ];
            })
            ->toArray();
    }

    /**
     * Get theme configuration.
     *
     * @return array
     */
    protected function getTheme(): array
    {
        $theme = AppSetting::get('theme', []);
        
        return is_array($theme) ? $theme : json_decode($theme, true) ?? [];
    }

    /**
     * Get splash screen configuration.
     *
     * @return array
     */
    protected function getSplash(): array
    {
        $splash = AppSetting::get('splash_configuration', []);
        
        return is_array($splash) ? $splash : json_decode($splash, true) ?? [];
    }

    /**
     * Get AdMob configuration.
     *
     * @return array
     */
    protected function getAdmob(): array
    {
        $admob = AppSetting::get('admob', []);
        
        return is_array($admob) ? $admob : json_decode($admob, true) ?? [];
    }

    /**
     * Get OneSignal configuration.
     *
     * @return array
     */
    protected function getOneSignal(): array
    {
        $onesignal = AppSetting::get('onesignal_configuration', []);
        
        return is_array($onesignal) ? $onesignal : json_decode($onesignal, true) ?? [];
    }

    /**
     * Get progress bar configuration.
     *
     * @return array
     */
    protected function getProgressBar(): array
    {
        $progressBar = AppSetting::get('progressbar', []);
        
        return is_array($progressBar) ? $progressBar : json_decode($progressBar, true) ?? [];
    }

    /**
     * Get exit popup configuration.
     *
     * @return array
     */
    protected function getExitPopup(): array
    {
        $exitPopup = AppSetting::get('exitpopup_configuration', []);
        
        return is_array($exitPopup) ? $exitPopup : json_decode($exitPopup, true) ?? [];
    }

    /**
     * Get share content configuration.
     *
     * @return array
     */
    protected function getShare(): array
    {
        $share = AppSetting::get('share_content', []);
        
        return is_array($share) ? $share : json_decode($share, true) ?? [];
    }

    /**
     * Get about configuration.
     *
     * @return array
     */
    protected function getAbout(): array
    {
        $about = AppSetting::get('about', []);
        
        return is_array($about) ? $about : json_decode($about, true) ?? [];
    }

    /**
     * Get user agent configuration.
     *
     * @return array|null
     */
    protected function getUserAgent(): ?array
    {
        $userAgent = UserAgent::getActive();
        
        if (!$userAgent) {
            return null;
        }

        return [
            'id' => $userAgent->id,
            'title' => $userAgent->title,
            'android' => $userAgent->android,
            'ios' => $userAgent->ios,
            'status' => $userAgent->status,
        ];
    }

    /**
     * Get the public URL for the exported JSON file.
     *
     * @return string|null
     */
    public function getJsonFileUrl(): ?string
    {
        $disk = config('mightyweb.json_export.disk', 'public');
        $path = config('mightyweb.json_export.path', 'mightyweb');
        $filename = config('mightyweb.json_export.filename', 'mightyweb.json');
        
        $fullPath = $path . '/' . $filename;
        
        if (!Storage::disk($disk)->exists($fullPath)) {
            return null;
        }
        
        return Storage::disk($disk)->url($fullPath);
    }

    /**
     * Download the JSON configuration file.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|false
     */
    public function downloadJson()
    {
        $disk = config('mightyweb.json_export.disk', 'public');
        $path = config('mightyweb.json_export.path', 'mightyweb');
        $filename = config('mightyweb.json_export.filename', 'mightyweb.json');
        
        $fullPath = $path . '/' . $filename;
        
        if (!Storage::disk($disk)->exists($fullPath)) {
            return false;
        }
        
        return Storage::disk($disk)->download($fullPath);
    }
}

