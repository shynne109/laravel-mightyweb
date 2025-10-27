# Changelog

All notable changes to MightyWeb will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [1.1.0] - 2025-10-26

### 🚀 UI Enhancement: Livewire Flux Integration

This release integrates Livewire Flux v2.6, replacing all custom Blade components with professionally designed, accessible UI components.

### Added
- **Livewire Flux v2.6** - Professional UI component library integration
- **Unified Dashboard Component** - `@livewire('mightyweb.dashboard')` - All 8 modules in one tabbed interface
- `@fluxAppearance` directive - Automatic theme and color scheme management
- `@fluxScripts` directive - Interactive component JavaScript
- Flux CSS in Vite build pipeline (~185KB added for comprehensive component library)
- Dashboard documentation (`docs/DASHBOARD.md`)

### Changed
- **All 8 Volt Components Migrated to Flux**:
  - `floating-button/index.blade.php` - Now uses Flux modals, buttons, inputs, badges, icons
  - `tab/index.blade.php` - Flux form components and file uploads
  - `navigation-icon/index.blade.php` - Flux badges and buttons
  - `walkthrough/index.blade.php` - Flux image upload and forms
  - `menu/index.blade.php` - Flux hierarchical forms
  - `page/index.blade.php` - Flux standard CRUD components
  - `theme/configuration.blade.php` - Flux color inputs (enhanced)
  - `app-configuration.blade.php` - Flux tabs and complex forms
- Replaced `<x-mightyweb::button>` with `<flux:button>`
- Replaced `<x-mightyweb::modal>` with `<flux:modal variant="flyout">`
- Replaced custom form inputs with `<flux:input>`, `<flux:textarea>`, `<flux:select>`
- Replaced custom badges with `<flux:badge>`
- Added Flux icons throughout UI (`<flux:icon.*>`)

### Removed
- Custom Blade components directory (`resources/views/components/`)
  - `button.blade.php` (120 lines) - Replaced by Flux buttons
  - `modal.blade.php` (150 lines) - Replaced by Flux modals
  - `confirmation-modal.blade.php` (90 lines) - Replaced by Flux modals
  - `form/input.blade.php` - Replaced by Flux inputs
  - `form/textarea.blade.php` - Replaced by Flux textareas
  - `form/select.blade.php` - Replaced by Flux selects
  - `form/file-upload.blade.php` - Native file inputs with Flux styling

### Improved
- ♿ **Accessibility** - All Flux components are WCAG 2.1 AA compliant out of the box
- 🎨 **Consistency** - Unified design language across all modules
- 🌓 **Dark Mode** - Enhanced dark mode support with Flux's color system
- 📦 **Maintenance** - Less custom CSS to maintain, leveraging battle-tested library
- 🚀 **Performance** - Optimized component rendering and interactions

### Technical Details
- Asset size: 82KB → 267KB CSS (includes complete Flux component library)
- Total code reduction: ~400 lines of custom components removed
- Zero breaking changes - all public APIs remain unchanged
- Flux components use Alpine.js (already included in stack)

---

## [1.0.0] - 2025-10-26

### 🎉 Initial Release

MightyWeb is a comprehensive Laravel package for managing mobile app configurations with a modern, intuitive interface built using Livewire Volt and Tailwind CSS 4.

### Features

#### Core Modules
- **App Configuration** - Manage basic app settings (name, version, package name, logo, URLs)
- **Theme Configuration** - Customize app colors, fonts, and dark mode settings  
- **Walkthrough Screens** - Create onboarding tutorials with images and descriptions
- **Menu Management** - Build hierarchical navigation menus with parent-child relationships
- **Page Management** - Create and manage content pages with descriptions and URLs
- **Tabs** - Configure bottom navigation tabs with icons and labels
- **Navigation Icons** - Manage header icons (left and right positions)
- **Floating Button** - Configure floating action buttons with icons and actions

#### Technical Features
- **Livewire Volt Architecture** - Modern class-based single-file components
- **Modal-based CRUD** - All create, edit, and delete operations in modals
- **Vite Asset Compilation** - Optimized builds with automatic cache busting (82KB CSS, 48KB JS)
- **Tailwind CSS 4** - Modern utility-first styling with custom theme
- **Alpine.js Integration** - Reactive UI components for rich interactions
- **Dark Mode Support** - Full dark mode throughout the interface
- **Responsive Design** - Works seamlessly on all screen sizes
- **Type Safety** - Full PHP 8.2+ type hints throughout
- **Image Upload** - Built-in image handling with preview and validation
- **Search & Filtering** - Debounced search (300ms) with column sorting
- **Pagination** - Configurable items per page (5, 10, 25, 50)
- **Loading States** - Visual feedback for all async operations
- **Auto-dismiss Alerts** - Success messages auto-dismiss after 3 seconds

#### Developer Experience
- **Auto-Discovery** - Volt components automatically registered
- **Blade Directives** - Simple `@mightywebAssets` and `@mightywebScripts` tags
- **Pre-built Assets** - No build process required for end users
- **Hot Module Replacement** - Instant updates during development with `npm run dev`
- **Comprehensive Documentation** - Full guides for installation and usage
- **Clean Namespace** - Simple `MightyWeb\` namespace throughout

### Requirements

- **PHP**: 8.2 or 8.3
- **Laravel**: 11.0 or 12.0
- **Livewire**: 3.5 or higher
- **Tailwind CSS**: Provided by parent project
- **Alpine.js**: Provided by parent project

### Installation

```bash
# Install package
composer require shynne109/laravel-mightyweb

# Run migrations
php artisan migrate

# Publish assets
php artisan vendor:publish --tag=mightyweb-assets
```

Add to your layout:
```blade
<head>
    @mightywebAssets
</head>
<body>
    @yield('content')
    @mightywebScripts
</body>
```

### Package Structure

- **8 Volt Components** - Single-file components with modal CRUD
- **7 Shared Blade Components** - Reusable UI elements
- **9 Eloquent Models** - Full type-hinted models
- **3 Controllers** - Dashboard, JSON export, API
- **2 Services** - File upload and JSON export services
- **Pre-built Vite Assets** - Ready-to-use CSS/JS

### What's Included

- ✅ Complete CRUD interfaces for all modules
- ✅ JSON export functionality for mobile apps
- ✅ API endpoints for mobile app consumption
- ✅ Database migrations with proper indexes
- ✅ Publishable views, config, and assets
- ✅ Comprehensive error handling
- ✅ Loading states and user feedback
- ✅ Auto-dismiss success messages
- ✅ Image upload with preview
- ✅ Parent-child menu relationships
- ✅ Position-based icon filtering
- ✅ Theme presets with live preview
- ✅ 5-tab organized app settings

### Asset Details

**CSS (82.05 KB → 12.37 KB gzipped)**
- Tailwind CSS 4 custom theme
- Modal animations (fade-in, slide-in, slide-out)
- Component styles (buttons, cards, tables, forms)
- Dark mode styles
- Responsive utilities
- Custom scrollbar styling

**JavaScript (47.65 KB → 17.13 KB gzipped)**
- Alpine.js 3.14+
- Auto-dismiss alerts (3-second timer)
- Modal interactions
- Component behaviors

### Routes

**Web Routes:**
- `GET /mightyweb` - Dashboard
- `GET /mightyweb/export-json` - Export JSON configuration

**API Routes:**
- `GET /api/mightyweb/config` - Get app configuration

### Blade Directives

**`@mightywebAssets`** - Loads CSS/JS via Vite
**`@mightywebScripts`** - Loads footer scripts and utilities

### Configuration

Publish config file:
```bash
php artisan vendor:publish --tag=mightyweb-config
```

Default configuration includes database connection, storage paths, and image settings.

---

## Future Plans

- Bulk operations (delete, activate multiple items)
- Import/Export configurations (JSON/CSV)
- Multi-language support
- Advanced filtering and search
- Activity logging and audit trails
- API rate limiting
- Webhook integrations
- Role-based permissions

---

## Links

- **Repository**: https://github.com/shynne109/laravel-mightyweb
- **Issues**: https://github.com/shynne109/laravel-mightyweb/issues
- **Documentation**: See README.md

---

[1.0.0]: https://github.com/shynne109/laravel-mightyweb/releases/tag/v1.0.0
