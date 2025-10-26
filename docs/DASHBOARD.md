# MightyWeb Dashboard Component

**Version:** 1.1.0  
**Component:** `@livewire('mightyweb.dashboard')`  
**File:** `resources/views/livewire/dashboard.blade.php`

---

## 📋 Overview

The MightyWeb Dashboard is a **unified tabbed interface** that combines all 8 configuration modules into a single, easy-to-use component. This allows users to access and manage their entire mobile app configuration from one place without navigating between different pages.

---

## ✨ Features

### 🎯 Single Component Access
- **All-in-one interface** - Access all 8 modules from one dashboard
- **Tab-based navigation** - Quick switching between modules
- **Smooth transitions** - Animated tab content changes
- **Sticky header** - Navigation stays visible while scrolling

### 🎨 Professional UI
- **Flux components** - Built with Livewire Flux UI library
- **Dark mode support** - Full dark/light theme compatibility
- **Responsive design** - Works on desktop, tablet, and mobile
- **Icon-labeled tabs** - Easy visual identification

### ⚡ Performance
- **Lazy loading** - Components load only when tab is active
- **State preservation** - Tab state persists during navigation
- **Optimized rendering** - Only active tab content is rendered

---

## 🚀 Usage

### Option 1: Direct Component Usage (Recommended)

Simply add the Livewire component to any Blade view:

```blade
@extends('layouts.app')

@section('content')
    @livewire('mightyweb.dashboard')
@endsection
```

### Option 2: Using the Built-in Route

Access the dashboard at the default route:

```
http://yourapp.com/mightyweb
```

The package automatically registers this route in `routes/web.php`.

### Option 3: Custom Integration

Integrate into your own page structure:

```blade
<div class="container">
    <h1>My Custom Admin Panel</h1>
    
    {{-- Embed MightyWeb Dashboard --}}
    <div class="mt-8">
        @livewire('mightyweb.dashboard')
    </div>
</div>
```

---

## 📦 Included Modules

The dashboard provides tabbed access to all 8 MightyWeb modules:

| Tab | Module | Icon | Description |
|-----|--------|------|-------------|
| **App Config** | `mightyweb.app-configuration` | ⚙️ Cog | App settings, URLs, integrations |
| **Theme** | `mightyweb.theme.configuration` | 🎨 Paint Brush | Colors, fonts, dark mode |
| **Walkthrough** | `mightyweb.walkthrough.index` | 🎓 Academic Cap | Onboarding screens |
| **Menus** | `mightyweb.menu.index` | ☰ Bars | Navigation menus |
| **Pages** | `mightyweb.page.index` | 📄 Document | Content pages |
| **Bottom Tabs** | `mightyweb.tab.index` | ⬜ Columns | Bottom navigation |
| **Nav Icons** | `mightyweb.navigation-icon.index` | ⚡ Squares | Header icons |
| **FAB** | `mightyweb.floating-button.index` | ➕ Plus | Floating buttons |

---

## 🎯 Props & State

### Component Properties

```php
public string $activeTab = 'app-config'; // Current active tab
```

### Available Tabs

```php
'app-config'        // App Configuration
'theme'             // Theme Configuration  
'walkthrough'       // Walkthrough Screens
'menu'              // Navigation Menus
'pages'             // Content Pages
'tabs'              // Bottom Tabs
'navigation-icons'  // Navigation Icons
'floating-button'   // Floating Action Button
```

### Methods

```php
public function switchTab(string $tab): void
```
Switches to the specified tab. Called automatically when user clicks tab navigation.

---

## 🎨 Customization

### Changing Default Tab

Modify the initial active tab in your Blade view:

```blade
@livewire('mightyweb.dashboard', ['activeTab' => 'theme'])
```

Or programmatically:

```php
<div x-data="{ tab: 'menu' }">
    @livewire('mightyweb.dashboard', ['activeTab' => 'menu'])
</div>
```

### Custom Tab Order

Edit `resources/views/livewire/dashboard.blade.php` and reorder the tab buttons:

```blade
{{-- Reorder tabs as needed --}}
<button wire:click="switchTab('theme')">...</button>
<button wire:click="switchTab('app-config')">...</button>
{{-- etc --}}
```

### Hiding Specific Tabs

Remove unwanted tab buttons and their corresponding content sections:

```blade
{{-- Remove this tab button --}}
{{-- <button wire:click="switchTab('floating-button')">...</button> --}}

{{-- Remove corresponding content section --}}
{{-- @if ($activeTab === 'floating-button') ... @endif --}}
```

### Custom Styling

Override Tailwind classes in your app's CSS:

```css
/* Custom tab styling */
.mightyweb-dashboard .tab-active {
    @apply border-blue-600 text-blue-600;
}

.mightyweb-dashboard .tab-inactive {
    @apply border-transparent text-gray-400 hover:text-gray-600;
}
```

---

## 🔧 Advanced Usage

### Programmatic Tab Switching

Switch tabs from JavaScript:

```javascript
// Using Alpine.js
Livewire.dispatch('switchTab', { tab: 'theme' });

// Using Livewire directly
@this.switchTab('menu');
```

### Deep Linking to Specific Tab

Add query parameter support:

```php
// In dashboard component
public function mount()
{
    $this->activeTab = request()->query('tab', 'app-config');
}
```

Then access with URL:
```
http://yourapp.com/mightyweb?tab=theme
```

### Event Listening

Listen to tab changes:

```blade
<div x-data @tab-changed.window="console.log($event.detail.tab)">
    @livewire('mightyweb.dashboard')
</div>
```

Dispatch custom event in dashboard component:

```php
public function switchTab(string $tab): void
{
    $this->activeTab = $tab;
    $this->dispatch('tab-changed', tab: $tab);
}
```

---

## 🎯 Integration Examples

### Example 1: Standalone Admin Page

```blade
{{-- resources/views/admin/mightyweb.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>MightyWeb Admin</title>
    @mightywebAssets
</head>
<body>
    @livewire('mightyweb.dashboard')
    @mightywebScripts
</body>
</html>
```

### Example 2: Inside Existing Dashboard

```blade
{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.admin')

@section('content')
    <div class="grid grid-cols-12 gap-6">
        {{-- Sidebar --}}
        <div class="col-span-3">
            @include('partials.sidebar')
        </div>
        
        {{-- Main Content --}}
        <div class="col-span-9">
            <h1>Mobile App Configuration</h1>
            @livewire('mightyweb.dashboard')
        </div>
    </div>
@endsection
```

### Example 3: With Additional Controls

```blade
<div class="space-y-6">
    {{-- Custom Header --}}
    <div class="flex justify-between items-center">
        <h1>App Manager</h1>
        <button class="btn btn-primary">Export Config</button>
    </div>
    
    {{-- Dashboard --}}
    @livewire('mightyweb.dashboard')
    
    {{-- Custom Footer --}}
    <div class="text-center text-sm text-gray-500">
        Last updated: {{ now()->format('M d, Y') }}
    </div>
</div>
```

### Example 4: Conditional Access

```blade
@can('manage-app-config')
    @livewire('mightyweb.dashboard')
@else
    <div class="alert alert-warning">
        You don't have permission to access this dashboard.
    </div>
@endcan
```

---

## 🎨 UI Components Used

The dashboard leverages Flux components for professional UI:

- **`<flux:heading>`** - Page and section headings
- **`<flux:subheading>`** - Descriptive subtitles
- **`<flux:badge>`** - Version badge and active tab indicator
- **`<flux:icon.*>`** - Tab icons (cog, paint-brush, academic-cap, etc.)
- **Tab Navigation** - Custom styled with Tailwind + Flux colors
- **Smooth Transitions** - Alpine.js x-transition animations

---

## ⚡ Performance Tips

### 1. Lazy Load Heavy Tabs
For modules with lots of data, consider lazy loading:

```blade
@if ($activeTab === 'menu')
    <div wire:init="loadMenuData">
        @if ($menuDataLoaded)
            @livewire('mightyweb.menu.index')
        @else
            <div>Loading menus...</div>
        @endif
    </div>
@endif
```

### 2. Cache Configuration
Cache frequently accessed config data:

```php
public function getAppConfigProperty()
{
    return Cache::remember('mightyweb.app-config', 3600, function () {
        return AppSetting::first();
    });
}
```

### 3. Pagination
All tab modules already use pagination for large datasets.

---

## 🐛 Troubleshooting

### Issue: Tabs not switching
**Solution:** Ensure Alpine.js is loaded:
```blade
@mightywebAssets  {{-- Includes Alpine.js --}}
```

### Issue: Livewire components not rendering
**Solution:** Check component naming in service provider:
```php
// Should auto-discover, but can manually register:
Livewire::component('mightyweb.dashboard', Dashboard::class);
```

### Issue: Styles not applied
**Solution:** Rebuild assets:
```bash
cd packages/mightyweb
npm run build
php artisan vendor:publish --tag=mightyweb-assets --force
```

### Issue: Dark mode not working
**Solution:** Ensure Flux appearance directive is loaded:
```blade
@mightywebAssets  {{-- Includes @fluxAppearance --}}
```

---

## 📊 Benefits

### For Developers
✅ **Easy Integration** - Just one line: `@livewire('mightyweb.dashboard')`  
✅ **Flexible Placement** - Works in any Blade view  
✅ **No Routing Needed** - Component handles all navigation internally  
✅ **Customizable** - Easy to modify tabs, order, and styling  

### For End Users
✅ **Single Interface** - No jumping between pages  
✅ **Fast Navigation** - Instant tab switching  
✅ **Visual Clarity** - Icon-labeled tabs  
✅ **Familiar UX** - Standard tabbed interface pattern  

### For Maintenance
✅ **Less Code** - One dashboard vs. 8 separate pages  
✅ **Consistent Layout** - Shared header and navigation  
✅ **Easy Updates** - Modify one component affects all tabs  

---

## 🚀 Next Steps

1. **Customize the dashboard** to match your app's design
2. **Add authentication** to protect the dashboard route
3. **Integrate with your existing admin panel**
4. **Add analytics** to track which tabs are used most
5. **Extend with custom modules** by adding new tabs

---

## 📚 Related Documentation

- [Livewire Volt Documentation](https://livewire.laravel.com/docs/volt)
- [Livewire Flux Components](https://fluxui.dev)
- [MightyWeb Package README](../README.md)
- [Individual Module Documentation](./USAGE.md)

---

**Dashboard Component Ready!** 🎉

Now users can simply add `@livewire('mightyweb.dashboard')` to any page and get instant access to all MightyWeb configuration modules in a beautiful tabbed interface.
