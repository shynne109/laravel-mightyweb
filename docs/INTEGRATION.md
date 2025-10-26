# Using MightyWeb Dashboard in Your Laravel Application

## Method 1: Using Livewire Directive (Recommended)

This is the simplest and most common way to use the dashboard component.

### In Any Blade View

```blade
{{-- In your admin dashboard page --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">App Configuration</h1>
        
        @livewire('mightyweb.dashboard')
    </div>
@endsection
```

### In a Route Closure

```php
// routes/web.php
use Illuminate\Support\Facades\Route;

Route::get('/admin/mightyweb', function () {
    return view('admin.mightyweb');
})->middleware(['auth', 'admin']);
```

Then create `resources/views/admin/mightyweb.blade.php`:

```blade
@extends('layouts.app')

@section('content')
    @livewire('mightyweb.dashboard')
@endsection
```

## Method 2: Using Livewire Component Tag

```blade
<livewire:mightyweb.dashboard />
```

## Method 3: Rendering Directly in Controller

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function mightywebDashboard()
    {
        return view('admin.mightyweb');
    }
}
```

## Method 4: Including in Blade Components

```blade
{{-- resources/views/components/admin-layout.blade.php --}}
<div class="min-h-screen bg-gray-100">
    <nav>
        <!-- Your navigation -->
    </nav>
    
    <main class="py-6">
        {{ $slot }}
    </main>
</div>
```

Then use it:

```blade
<x-admin-layout>
    @livewire('mightyweb.dashboard')
</x-admin-layout>
```

## Method 5: With Authentication & Authorization

```php
// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/mightyweb/dashboard', function () {
        // Check if user has permission
        if (!auth()->user()->can('manage-app-config')) {
            abort(403, 'Unauthorized access');
        }
        
        return view('mightyweb.dashboard-page');
    })->name('mightyweb.dashboard');
});
```

## Method 6: Using Package Route (Already Available)

The package already provides a route at `/mightyweb`:

```bash
# Just visit this URL in your browser
http://yourapp.com/mightyweb
```

## Complete Example with Middleware

```php
// routes/web.php
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    
    Route::get('/app-config', function () {
        return view('admin.app-config');
    })->name('admin.app-config');
    
});
```

Create `resources/views/admin/app-config.blade.php`:

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MightyWeb Dashboard</title>
    
    {{-- Your app CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- MightyWeb Assets (includes Flux) --}}
    @mightywebAssets
    
    @livewireStyles
</head>
<body class="antialiased">
    
    @livewire('mightyweb.dashboard')
    
    {{-- MightyWeb Scripts (includes Flux) --}}
    @mightywebScripts
    
    @livewireScripts
</body>
</html>
```

## Important Notes

1. **Component Registration**: The dashboard component is automatically registered by the package service provider as `mightyweb.dashboard`

2. **Assets Required**: Make sure you have included:
   - `@mightywebAssets` in your `<head>`
   - `@mightywebScripts` before `</body>`
   - `@livewireStyles` and `@livewireScripts`

3. **Namespace**: The component is registered as `mightyweb.dashboard`, which maps to the class `MightyWeb\Http\Livewire\Dashboard`

4. **No Publishing Required**: The component works out of the box, no need to publish unless you want to customize

## Troubleshooting

If you get "Unable to find component" error:

```bash
# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan livewire:discover

# Regenerate autoload
composer dump-autoload
```

## Starting on a Specific Tab

You can't pass props to Livewire components directly in the `@livewire` directive, but you can use Livewire's wire:ignore or dispatch events.

For more advanced usage, see `docs/DASHBOARD.md` and `docs/DASHBOARD_EXAMPLES.md`.
