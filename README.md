# MightyWeb

<p align="center">
    <strong>A modern Laravel package for managing mobile app configurations</strong>
</p>

<p align="center">
    <a href="https://packagist.org/packages/shynne109/mightyweb"><img src="https://img.shields.io/packagist/v/shynne109/mightyweb" alt="Latest Version"></a>
    <a href="https://packagist.org/packages/shynne109/mightyweb"><img src="https://img.shields.io/packagist/dt/shynne109/mightyweb" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/shynne109/mightyweb"><img src="https://img.shields.io/packagist/l/shynne109/mightyweb" alt="License"></a>
</p>

---

## 📱 Overview

MightyWeb is a comprehensive Laravel package that provides a beautiful admin interface for managing mobile app configurations. Built with **Livewire Volt** and **Tailwind CSS 4**, it offers a modern, intuitive way to control your mobile app's content, appearance, and behavior.

Perfect for managing Flutter, React Native, or any mobile app that needs dynamic configuration!

---

## ✨ Features

### 🎨 **8 Core Modules**

| Module | Description |
|--------|-------------|
| **App Configuration** | Manage app name, version, logo, URLs, and integrations |
| **Theme Configuration** | Customize colors, fonts, and dark mode with live preview |
| **Walkthrough Screens** | Create beautiful onboarding experiences |
| **Menu Management** | Build hierarchical navigation menus |
| **Page Management** | Create and manage content pages |
| **Tabs** | Configure bottom navigation tabs |
| **Navigation Icons** | Manage header icons (left/right) |
| **Floating Button** | Configure floating action buttons |

### 🚀 **Modern Technology Stack**

- ✅ **Livewire Volt** - Single-file components with class-based syntax
- ✅ **Livewire Flux** - Professional, accessible UI component library
- ✅ **Tailwind CSS 4** - Modern utility-first styling
- ✅ **Alpine.js** - Reactive UI components
- ✅ **Vite** - Lightning-fast asset bundling
- ✅ **PHP 8.2+** - Full type safety
- ✅ **Laravel 11/12** - Latest framework features

### 💎 **User Experience**

- ✅ **Modal-based CRUD** - Fast, intuitive editing without page reloads
- ✅ **Flux UI Components** - Professional, WCAG-compliant components
- ✅ **Dark Mode** - Full dark mode support throughout
- ✅ **Responsive Design** - Works on desktop, tablet, and mobile
- ✅ **Search & Filter** - Find what you need quickly
- ✅ **Image Upload** - Easy image management with previews
- ✅ **Auto-save Feedback** - Loading states and success messages
- ✅ **Accessibility** - WCAG 2.1 AA compliant out of the box

---

## 📋 Requirements

- **PHP** 8.2 or higher
- **Laravel** 11.0 or 12.0
- **Livewire** 3.5 or higher
- **Livewire Flux** 2.6 or higher (automatically installed)
- **Tailwind CSS** 4.0 or higher
- **Alpine.js** 3.14 or higher

---

## 🚀 Installation

### Step 1: Install Package

```bash
composer require shynne109/mightyweb
```

### Step 2: Run Migrations

```bash
php artisan migrate
```

### Step 3: Publish Assets

```bash
php artisan vendor:publish --tag=mightyweb-assets
```

**Optional:** Publish configuration file for advanced customization:

```bash
php artisan vendor:publish --tag=mightyweb-config
```

**Optional:** Publish views for complete customization:

```bash
php artisan vendor:publish --tag=mightyweb-views
```

**Optional:** Publish migrations to customize database schema:

```bash
php artisan vendor:publish --tag=mightyweb-migrations
```

**Publish everything at once:**

```bash
php artisan vendor:publish --provider="MightyWeb\MightyWebServiceProvider"
```

### Step 4: Add to Your Layout

Add these directives to your main layout file:

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your App</title>
    
    {{-- Your app's Vite assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- MightyWeb package assets --}}
    @mightywebAssets
</head>
<body>
    @yield('content')
    
    {{-- MightyWeb package scripts --}}
    @mightywebScripts
</body>
</html>
```

### Step 5: Access the Dashboard

Visit `http://yourapp.com/mightyweb` to access the unified admin dashboard.

**Or** embed the dashboard component anywhere in your app:

```blade
{{-- In any Blade view --}}
@livewire('mightyweb.dashboard')
```

This single component gives you access to all 8 configuration modules in a beautiful tabbed interface! 🎉

---

## 📖 Usage

### Quick Start: Unified Dashboard

The easiest way to use MightyWeb is through the **unified dashboard component**:

```blade
{{-- In your admin page --}}
@extends('layouts.app')

@section('content')
    @livewire('mightyweb.dashboard')
@endsection
```

This provides instant access to all modules:
- ⚙️ **App Configuration** - Settings, URLs, integrations
- 🎨 **Theme** - Colors, fonts, dark mode  
- 🎓 **Walkthrough** - Onboarding screens
- ☰ **Menus** - Navigation structure
- 📄 **Pages** - Content pages
- ⬜ **Bottom Tabs** - Tab bar navigation
- ⚡ **Nav Icons** - Header icons
- ➕ **FAB** - Floating action buttons

See [Dashboard Documentation](docs/DASHBOARD.md) for advanced usage.

### Accessing the Admin Panel

Once installed, you can access the MightyWeb admin panel at:

```
http://yourapp.com/mightyweb
```

### Configuring Your App

#### 1. App Configuration
Set up basic app information:
- App name, version, and package name
- App logo (with upload and preview)
- Website and support URLs
- API settings and timeouts
- Social media links
- Firebase and analytics integration

#### 2. Theme Configuration
Customize your app's appearance:
- Choose from 5 preset themes (Default, Dark, Ocean, Sunset, Forest)
- Customize 5 color values (primary, secondary, accent, background, text)
- Select from 8 font families
- Enable/disable dark mode
- See live preview of changes

#### 3. Walkthrough Screens
Create onboarding experiences:
- Add multiple walkthrough screens
- Upload images for each screen
- Write titles and descriptions
- Set display order
- Enable/disable screens

#### 4. Menu Management
Build navigation menus:
- Create parent menus
- Add child menu items
- Set icons and URLs
- Control visibility
- Reorder items

#### 5. Pages
Manage content pages:
- Create pages with titles and descriptions
- Set page URLs
- Control visibility
- Link from menus

#### 6. Bottom Tabs
Configure bottom navigation:
- Add up to 5 tabs
- Upload custom icons
- Set labels and URLs
- Control active state

#### 7. Navigation Icons
Manage header icons:
- Left and right positions
- Upload custom icons
- Set actions/URLs
- Show/hide icons

#### 8. Floating Button
Configure floating action button:
- Upload button icon
- Set button action
- Control visibility
- Position customization

### Exporting Configuration

Export all configurations as JSON for your mobile app:

```
GET http://yourapp.com/mightyweb/export-json
```

This returns a complete JSON object with all your app configurations that your mobile app can consume.

### API Endpoint

Get configurations via API:

```
GET http://yourapp.com/api/mightyweb/config
```

Returns JSON response with all app settings, menus, pages, tabs, icons, etc.

---

## 🎨 Customization

### Publishing Configuration

Publish the configuration file to customize settings:

```bash
php artisan vendor:publish --tag=mightyweb-config
```

This creates `config/mightyweb.php` where you can customize:
- Database connection
- Storage paths
- Image dimensions
- Upload limits

### Publishing Views

Customize the UI by publishing views:

```bash
php artisan vendor:publish --tag=mightyweb-views
```

Views will be copied to `resources/views/vendor/mightyweb/` for customization.

### Publishing Migrations

Need to modify database structure?

```bash
php artisan vendor:publish --tag=mightyweb-migrations
```

---

## 🔧 Development

### Building Assets

If you need to customize and rebuild the package assets:

**1. Navigate to package directory:**
```bash
cd vendor/shynne109/mightyweb
```

**2. Install dependencies:**
```bash
npm install
```

**3. Build for production:**
```bash
npm run build
```

**4. Or run development server with HMR:**
```bash
npm run dev
```

### Asset Output

Built assets are located in:
```
public/vendor/mightyweb/build/
├── .vite/manifest.json
└── assets/
    ├── app-[hash].css  (82KB → 12KB gzipped)
    └── app-[hash].js   (48KB → 17KB gzipped)
```

---

## 🏗️ Architecture

### Livewire Volt Components

All modules use Livewire Volt class-based components:

```blade
<?php

use function Livewire\Volt\{state, rules};

state(['items' => fn() => Item::all()]);

rules(['form.name' => 'required|string|max:255']);

$save = function() {
    // Save logic
};

?>

<div>
    <!-- Template -->
</div>
```

### File Structure

```
shynne109/mightyweb/
├── src/
│   ├── Models/              # 9 Eloquent models
│   ├── Http/Controllers/    # 3 controllers
│   ├── Services/            # 2 services
│   └── MightyWebServiceProvider.php
├── resources/
│   ├── views/
│   │   ├── livewire/        # 8 Volt components
│   │   └── components/      # 7 shared components
│   ├── css/                 # Tailwind CSS
│   └── js/                  # Alpine.js scripts
├── database/
│   └── migrations/          # Database tables
├── routes/
│   ├── web.php             # Web routes
│   └── api.php             # API routes
└── public/
    └── vendor/mightyweb/build/  # Built assets
```

---

## 🎯 Key Concepts

### Modal-Based CRUD

All create, edit, and delete operations happen in modals:
- ✅ No page reloads
- ✅ Faster user experience  
- ✅ Better focus and context
- ✅ Loading states built-in

### Shared Components

7 reusable Blade components for consistency:
- `<x-modal>` - Full-featured modals
- `<x-confirmation-modal>` - Delete confirmations
- `<x-form.input>` - Text inputs
- `<x-form.textarea>` - Text areas
- `<x-form.select>` - Dropdowns
- `<x-form.file-upload>` - File uploads
- `<x-button>` - Styled buttons

### Dark Mode

Full dark mode support:
- Automatically detects system preference
- Toggle available in theme settings
- Consistent dark colors throughout
- All components support both modes

---

## 📊 Performance

### Asset Sizes

| Asset | Size | Gzipped |
|-------|------|---------|
| CSS | 82.05 KB | 12.37 KB |
| JS | 47.65 KB | 17.13 KB |
| **Total** | **129.7 KB** | **29.5 KB** |

### Optimizations

- ✅ Vite bundles with tree-shaking
- ✅ CSS purged of unused styles
- ✅ Automatic code splitting
- ✅ Cache busting with hashed filenames
- ✅ Gzip compression support

---

## 🧪 Testing

Run package tests:

```bash
composer test
```

---

## 🐛 Troubleshooting

### Assets Not Loading

**Problem:** 404 errors for CSS/JS files

**Solution:**
```bash
php artisan vendor:publish --tag=mightyweb-assets --force
php artisan cache:clear
php artisan view:clear
```

### Styles Not Applying

**Problem:** Tailwind classes not working

**Solution:** Ensure your parent project has Tailwind CSS configured. Add package paths to your `tailwind.config.js`:

```javascript
export default {
    content: [
        './resources/**/*.blade.php',
        './vendor/shynne109/mightyweb/resources/**/*.blade.php',
    ],
    // ...
}
```

### Livewire Not Working

**Problem:** Livewire components not interactive

**Solution:** Ensure Livewire is properly installed and `@livewireScripts` is in your layout.

---

## � Troubleshooting

### Dashboard Component Not Found

If you get the error: `Unable to find component: [mightyweb.dashboard]`

**Solution:**

1. Clear your application caches:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan livewire:discover
```

2. Make sure the package service provider is registered (auto-discovery should handle this in Laravel 11+):
```bash
composer dump-autoload
```

3. Verify Livewire 3.5+ is installed:
```bash
composer show livewire/livewire
```

4. Ensure the MightyWeb service provider is loaded:

**Laravel 12+ Auto-Discovery (Default)**

The package service provider is automatically registered via `composer.json`:

```json
"extra": {
    "laravel": {
        "providers": [
            "MightyWeb\\MightyWebServiceProvider"
        ]
    }
}
```

**Manual Registration (if needed)**

If auto-discovery fails, add to `bootstrap/providers.php`:

```php
<?php

return [
    App\Providers\AppServiceProvider::class,
    MightyWeb\MightyWebServiceProvider::class, // Add this
];
```

Then run:
```bash
php artisan optimize:clear
composer dump-autoload
```

5. If still not working, try publishing the views:
```bash
php artisan vendor:publish --tag=mightyweb-views
```

**Note:** The dashboard component is registered as a standard Livewire component (`MightyWeb\Http\Livewire\Dashboard`), not a Volt component, so it works seamlessly in any Laravel application.

### Assets Not Loading

If styles or scripts don't appear:

1. Ensure you've published the assets:
```bash
php artisan vendor:publish --tag=mightyweb-assets --force
```

2. Check that directives are in your layout:
```blade
{{-- In <head> --}}
@mightywebAssets

{{-- Before </body> --}}
@mightywebScripts
```

3. Clear browser cache and hard refresh (Ctrl+Shift+R)

### Dark Mode Not Working

Make sure Flux appearance is loaded in your layout:
```blade
<head>
    @mightywebAssets {{-- This includes @fluxAppearance --}}
</head>
```

### Image Upload Issues

1. Ensure storage is linked:
```bash
php artisan storage:link
```

2. Check directory permissions:
```bash
chmod -R 775 storage/app/public
```

3. Verify `intervention/image` is installed:
```bash
composer show intervention/image
```

---

## �📚 Documentation

Additional documentation files:

- `CHANGELOG.md` - Version history and changes
- `VITE_INTEGRATION.md` - Detailed Vite configuration guide
- `BUILD_GUIDE.md` - Asset compilation instructions

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

### Development Setup

1. Clone the repository
2. Run `composer install`
3. Run `npm install`
4. Run `npm run dev` for development

### Code Style

- Follow PSR-12 coding standards
- Use PHP 8.2+ type hints
- Write meaningful commit messages
- Add tests for new features

---

## 📄 License

MightyWeb is open-sourced software licensed under the [MIT license](LICENSE).

---

## 👨‍💻 Author

**Adedoyin Shina**  
Email: sbatch2016@gmail.com

---

## 🙏 Credits

Built with:
- [Laravel](https://laravel.com)
- [Livewire](https://livewire.laravel.com)
- [Tailwind CSS](https://tailwindcss.com)
- [Alpine.js](https://alpinejs.dev)
- [Vite](https://vitejs.dev)

---

## ⭐ Support

If you find this package helpful, please consider giving it a star on GitHub!

---

<p align="center">Made with ❤️ for the Laravel community</p>
