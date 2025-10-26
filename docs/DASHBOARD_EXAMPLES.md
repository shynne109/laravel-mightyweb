# MightyWeb Dashboard - Usage Examples

Quick reference for integrating the MightyWeb dashboard into your Laravel application.

---

## 🚀 Quick Start (Simplest)

```blade
{{-- resources/views/admin/mightyweb.blade.php --}}
@extends('layouts.app')

@section('content')
    @livewire('mightyweb.dashboard')
@endsection
```

Access at: `http://yourapp.com/admin/mightyweb`

---

## 📋 Common Integration Patterns

### 1. Standalone Page

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Configuration</title>
    @mightywebAssets
</head>
<body class="bg-gray-50">
    @livewire('mightyweb.dashboard')
    @mightywebScripts
</body>
</html>
```

### 2. Inside Admin Dashboard

```blade
@extends('admin.layout')

@section('content')
    <div class="container mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold">Mobile App Settings</h1>
            <p class="text-gray-600">Configure your mobile app from here</p>
        </div>
        
        @livewire('mightyweb.dashboard')
    </div>
@endsection
```

### 3. With Sidebar Layout

```blade
<div class="flex min-h-screen">
    {{-- Admin Sidebar --}}
    <aside class="w-64 bg-gray-800 text-white">
        @include('admin.sidebar')
    </aside>
    
    {{-- Main Content --}}
    <main class="flex-1">
        @livewire('mightyweb.dashboard')
    </main>
</div>
```

### 4. Protected with Middleware

```php
// routes/web.php
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/app-config', function () {
        return view('admin.mightyweb');
    });
});
```

```blade
{{-- resources/views/admin/mightyweb.blade.php --}}
@extends('layouts.admin')

@section('content')
    @can('manage-app-settings')
        @livewire('mightyweb.dashboard')
    @else
        <div class="alert alert-danger">
            You don't have permission to manage app settings.
        </div>
    @endcan
@endsection
```

---

## 🎯 Starting on Specific Tab

### Method 1: Query Parameter

```php
// routes/web.php
Route::get('/mightyweb', function () {
    return view('mightyweb::pages.dashboard');
})->name('mightyweb.dashboard');

// Usage in links:
<a href="{{ route('mightyweb.dashboard', ['tab' => 'theme']) }}">
    Manage Theme
</a>
```

Then update the component to read query params:

```php
// resources/views/livewire/dashboard.blade.php
public function mount()
{
    $this->activeTab = request()->query('tab', 'app-config');
}
```

### Method 2: Component Property

```blade
@livewire('mightyweb.dashboard', ['activeTab' => 'theme'])
```

---

## 🔐 Access Control Examples

### Example 1: Role-Based Access

```blade
@if(auth()->user()->hasRole('super-admin'))
    @livewire('mightyweb.dashboard')
@else
    <div class="alert alert-warning">
        Only super admins can access this dashboard.
    </div>
@endif
```

### Example 2: Permission-Based Access

```blade
@can('manage-app-config')
    @livewire('mightyweb.dashboard')
@elsecan('view-app-config')
    {{-- Read-only version --}}
    <div x-data="{ readOnly: true }">
        @livewire('mightyweb.dashboard')
    </div>
@else
    <x-permission-denied />
@endcan
```

### Example 3: Multiple Permission Levels

```php
// In your controller or route
public function showDashboard()
{
    $canEdit = auth()->user()->can('edit-app-config');
    $canViewTheme = auth()->user()->can('manage-theme');
    
    return view('admin.mightyweb', compact('canEdit', 'canViewTheme'));
}
```

```blade
{{-- In view --}}
@if($canEdit)
    @livewire('mightyweb.dashboard')
@elseif($canViewTheme)
    @livewire('mightyweb.dashboard', ['activeTab' => 'theme'])
@else
    <p>No access</p>
@endif
```

---

## 🎨 Custom Styling

### Example 1: Custom Container

```blade
<div class="max-w-screen-2xl mx-auto p-8 bg-white rounded-lg shadow-xl">
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-bold text-gray-900">
            🚀 App Control Center
        </h1>
        <p class="text-gray-600 mt-2">
            Manage every aspect of your mobile app
        </p>
    </div>
    
    @livewire('mightyweb.dashboard')
</div>
```

### Example 2: Dark Theme Wrapper

```blade
<div class="dark">
    <div class="bg-gray-900 min-h-screen">
        @livewire('mightyweb.dashboard')
    </div>
</div>
```

### Example 3: Custom Header

```blade
{{-- Your custom header --}}
<header class="bg-blue-600 text-white p-6 mb-8">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold">My App Dashboard</h1>
        <nav>
            <a href="/home">Home</a>
            <a href="/settings">Settings</a>
        </nav>
    </div>
</header>

{{-- MightyWeb Dashboard --}}
<div class="container mx-auto">
    @livewire('mightyweb.dashboard')
</div>
```

---

## 📱 Responsive Examples

### Mobile-First Layout

```blade
<div class="min-h-screen bg-gray-50">
    {{-- Mobile header --}}
    <div class="lg:hidden bg-white border-b p-4">
        <button id="mobile-menu">Menu</button>
    </div>
    
    <div class="lg:flex">
        {{-- Desktop sidebar --}}
        <aside class="hidden lg:block w-64 bg-white border-r">
            @include('partials.sidebar')
        </aside>
        
        {{-- Main content --}}
        <main class="flex-1 p-4 lg:p-8">
            @livewire('mightyweb.dashboard')
        </main>
    </div>
</div>
```

---

## 🔔 With Notifications

```blade
<div x-data="{ notification: false }">
    {{-- Success notification --}}
    <div x-show="notification" 
         x-transition
         class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
        Configuration saved successfully!
    </div>
    
    {{-- Dashboard --}}
    <div @config-saved.window="notification = true; setTimeout(() => notification = false, 3000)">
        @livewire('mightyweb.dashboard')
    </div>
</div>
```

---

## 📊 With Analytics

```blade
<div x-data="{ tabViews: {} }" 
     @tab-changed.window="
         let tab = $event.detail.tab;
         tabViews[tab] = (tabViews[tab] || 0) + 1;
         console.log('Tab views:', tabViews);
         
         // Send to analytics
         gtag('event', 'tab_view', {
             'tab_name': tab,
             'view_count': tabViews[tab]
         });
     ">
    @livewire('mightyweb.dashboard')
</div>
```

---

## 🚀 Advanced: Custom Actions

```blade
<div class="space-y-6">
    {{-- Custom action buttons --}}
    <div class="flex gap-3 justify-end">
        <button onclick="exportConfig()" class="btn btn-secondary">
            Export Configuration
        </button>
        <button onclick="importConfig()" class="btn btn-primary">
            Import Configuration
        </button>
    </div>
    
    {{-- Dashboard --}}
    @livewire('mightyweb.dashboard')
</div>

<script>
function exportConfig() {
    fetch('/api/mightyweb/export')
        .then(res => res.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'mightyweb-config.json';
            a.click();
        });
}

function importConfig() {
    document.getElementById('import-file').click();
}
</script>
```

---

## 🎯 Pro Tips

### Tip 1: Preload Specific Tab
```blade
{{-- Load theme tab by default --}}
@livewire('mightyweb.dashboard', ['activeTab' => 'theme'])
```

### Tip 2: Hide Tabs You Don't Need
Edit `resources/views/livewire/dashboard.blade.php` and remove unwanted tabs.

### Tip 3: Add Custom CSS
```css
/* Custom scrollbar for tabs */
.dashboard-tabs::-webkit-scrollbar {
    height: 4px;
}

.dashboard-tabs::-webkit-scrollbar-thumb {
    background: #3b82f6;
    border-radius: 4px;
}
```

### Tip 4: Deep Link to Tabs
```html
<nav>
    <a href="/mightyweb?tab=app-config">App Settings</a>
    <a href="/mightyweb?tab=theme">Theme</a>
    <a href="/mightyweb?tab=menu">Menus</a>
</nav>
```

---

## 📚 More Examples

See the full documentation:
- [Dashboard Component Docs](DASHBOARD.md)
- [Package README](../README.md)
- [Usage Guide](../USAGE.md)

---

**Need help?** Check the [troubleshooting guide](DASHBOARD.md#troubleshooting) in the dashboard documentation.
