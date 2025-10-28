# JSON API Structure Documentation

This document describes the JSON structure exported by the `JsonExportService` and how it maps to the Flutter models.

## Root Structure

```json
{
  "appconfiguration": {},
  "admob": {},
  "progressbar": {},
  "theme": {},
  "about": {},
  "onesignal_configuration": {},
  "menu_style": [],
  "header_icon": {
    "lefticon": [],
    "righticon": []
  },
  "walkthrough": [],
  "floating_button": [],
  "user_agent": [],
  "tabs": [],
  "splash_configuration": {},
  "exitpopup_configuration": {},
  "pages": [],
  "share_content": {}
}
```

## Detailed Field Mappings

### 1. App Configuration (`appconfiguration`)

**Flutter Model:** `Appconfiguration`

**JSON Keys:**
- `app_name` - Application name
- `url` - Main application URL
- `appLanuguage` - App language code
- `isJavascriptEnable` - Enable JavaScript in WebView
- `isSplashScreen` - Show splash screen
- `isZoomFunctionality` - Enable zoom in WebView
- `navigationStyle` - Navigation menu style
- `header_style` - Header bar style
- `app_logo` - Application logo URL
- `is_walkthrough` - Show walkthrough screens
- `is_webrtc` - Enable WebRTC support
- `is_floating_button` - Show floating action buttons
- `floating_button_style` - Style for floating buttons
- `floating_button` - Floating button configuration
- `is_pull_refresh` - Enable pull-to-refresh
- `tab_style` - Bottom tab bar style
- `clear_cookie` - Clear cookies on start
- `bottom_navigation` - Bottom navigation configuration
- `walkthrough_style` - Walkthrough screen style
- `isExitPopupScreen` - Show exit confirmation popup
- `disable_header` - Hide header bar
- `disable_footer` - Hide footer/bottom navigation
- `disable_left_icon` - Hide left header icons

### 2. AdMob Configuration (`admob`)

**Flutter Model:** `Admob`

**JSON Keys:**
- `ads_type` - Ad network type (admob/facebook)
- `admobBannerID` - AdMob banner ad ID (Android)
- `admobIntentialID` - AdMob interstitial ad ID (Android)
- `admobBannerIDIOS` - AdMob banner ad ID (iOS)
- `admobIntentialIDIOS` - AdMob interstitial ad ID (iOS)
- `facebookBannerID` - Facebook banner ad ID (Android)
- `facebookIntentialID` - Facebook interstitial ad ID (Android)
- `facebookBannerIDIOS` - Facebook banner ad ID (iOS)
- `facebookIntentialIDIOS` - Facebook interstitial ad ID (iOS)

### 3. Progress Bar (`progressbar`)

**Flutter Model:** `Progressbar`

**JSON Keys:**
- `loaderStyle` - Loading indicator style
- `is_progressbar` - Show progress bar

### 4. Theme (`theme`)

**Flutter Model:** `Theme`

**JSON Keys:**
- `themeStyle` - Theme style name
- `customColor` - Custom primary color
- `gradientColor1` - First gradient color
- `gradientColor2` - Second gradient color

### 5. About (`about`)

**Flutter Model:** `About`

**JSON Keys:**
- `whatsAppNumber` - WhatsApp contact number
- `instagramUrl` - Instagram profile URL
- `twitterUrl` - Twitter profile URL
- `facebookUrl` - Facebook page URL
- `callNumber` - Phone number
- `snapchat` - Snapchat username
- `skype` - Skype ID
- `messenger` - Messenger link
- `youtube` - YouTube channel URL
- `isShowAbout` - Show about section
- `copyright` - Copyright text
- `description` - About description

### 6. OneSignal Configuration (`onesignal_configuration`)

**Flutter Model:** `OnesignalConfiguration`

**JSON Keys:**
- `app_id` - OneSignal App ID
- `rest_api_key` - OneSignal REST API Key

### 7. Menu Style (`menu_style`)

**Flutter Model:** `MenuStyleModel[]` (Array)

**JSON Structure:**
```json
[
  {
    "id": "1",
    "title": "Home",
    "type": "link",
    "image": "https://...",
    "url": "https://...",
    "status": "active",
    "parent_id": null,
    "children": [
      {
        "id": "2",
        "title": "Submenu",
        "type": "link",
        "image": "https://...",
        "url": "https://...",
        "status": "active",
        "parent_id": "1"
      }
    ]
  }
]
```

**Fields:**
- `id` - Menu item ID (string)
- `title` - Menu title
- `type` - Menu type (link, category, etc.)
- `image` - Menu icon URL
- `url` - Destination URL
- `status` - Active status
- `parent_id` - Parent menu ID (null for top-level)
- `children` - Nested submenu items (recursive)

### 8. Header Icon (`header_icon`)

**Flutter Model:** `HeaderIcon`

**JSON Structure:**
```json
{
  "lefticon": [
    {
      "id": "1",
      "title": "Menu",
      "value": "menu",
      "image": "https://...",
      "type": "action",
      "url": null,
      "status": "active",
      "created_at": "2025-10-28T10:00:00+00:00",
      "updated_at": "2025-10-28T10:00:00+00:00"
    }
  ],
  "righticon": [
    {
      "id": "2",
      "title": "Search",
      "value": "search",
      "image": "https://...",
      "type": "action",
      "url": null,
      "status": "active",
      "created_at": "2025-10-28T10:00:00+00:00",
      "updated_at": "2025-10-28T10:00:00+00:00"
    }
  ]
}
```

### 9. Walkthrough (`walkthrough`)

**Flutter Model:** `Walkthrough[]` (Array)

**JSON Structure:**
```json
[
  {
    "id": "1",
    "title": "Welcome",
    "subtitle": "Get started with our app",
    "image": "https://...",
    "status": "active"
  }
]
```

### 10. Floating Button (`floating_button`)

**Flutter Model:** `FloatingButton[]` (Array)

**JSON Structure:**
```json
[
  {
    "id": "1",
    "title": "Home",
    "image": "https://...",
    "url": "https://...",
    "status": "active"
  }
]
```

### 11. User Agent (`user_agent`)

**Flutter Model:** `UserAgentResponse[]` (Array - wraps single active user agent)

**JSON Structure:**
```json
[
  {
    "id": "1",
    "title": "Custom User Agent",
    "android": "Mozilla/5.0 (Android...)",
    "ios": "Mozilla/5.0 (iPhone...)",
    "status": "active"
  }
]
```

**Note:** Returns array with single active user agent or empty array if none active.

### 12. Tabs (`tabs`)

**Flutter Model:** `TabsResponse[]` (Array)

**JSON Structure:**
```json
[
  {
    "id": "1",
    "title": "Home",
    "image": "https://...",
    "url": "https://...",
    "status": "active"
  }
]
```

### 13. Splash Configuration (`splash_configuration`)

**Flutter Model:** `SplashConfiguration`

**JSON Keys:**
- `id` - Configuration ID
- `first_color` - First gradient color
- `second_color` - Second gradient color
- `title` - Splash screen title
- `title_color` - Title text color
- `enable_title` - Show title
- `enable_logo` - Show logo
- `enable_background` - Show background image
- `splash_logo_url` - Splash logo image URL
- `splash_background_url` - Background image URL

### 14. Exit Popup Configuration (`exitpopup_configuration`)

**Flutter Model:** `ExitPopUpModel`

**JSON Keys:**
- `title` - Popup title
- `positive_text` - Confirm button text
- `negative_text` - Cancel button text
- `enable_image` - Show image in popup
- `exit_image_url` - Popup image URL

### 15. Pages (`pages`)

**Flutter Model:** `TabsResponse[]` (Array - reuses TabsResponse model)

**JSON Structure:**
```json
[
  {
    "id": "1",
    "title": "About Us",
    "image": "https://...",
    "url": "https://...",
    "status": "active"
  }
]
```

### 16. Share Content (`share_content`)

**Flutter Model:** `ShareContent`

**JSON Keys:**
- `share` - Share message text

## Data Type Conversions

### ID Fields
All ID fields are returned as **strings** to ensure compatibility with Flutter's nullable string types.

### Timestamps
All timestamp fields (created_at, updated_at) are returned in **ISO 8601 format**:
```
2025-10-28T10:00:00+00:00
```

### Image URLs
Image URLs are returned as **absolute URLs** using Laravel's asset URL helpers.

### Status Fields
Status fields are returned as **strings** (e.g., "active", "inactive") to match Flutter enums.

## Usage Example

### PHP (Export)
```php
use MightyWeb\Services\JsonExportService;

$service = new JsonExportService();

// Generate configuration array
$config = $service->generateConfig();

// Export to file
$path = $service->exportToFile();

// Get public URL
$url = $service->getJsonFileUrl();

// Download file
$response = $service->downloadJson();
```

### Flutter (Import)
```dart
// Fetch JSON from API
final response = await http.get(Uri.parse('https://your-api.com/config.json'));
final json = jsonDecode(response.body);

// Parse into MainResponse model
final mainResponse = MainResponse.fromJson(json);

// Access data
print(mainResponse.appconfiguration?.appName);
print(mainResponse.tabs?.length);
print(mainResponse.walkthrough?.first.title);
```

## Configuration

The export configuration can be customized in `config/mightyweb.php`:

```php
return [
    'json_export' => [
        'disk' => 'public',           // Storage disk
        'path' => 'mightyweb',        // Directory path
        'filename' => 'mightyweb.json', // File name
    ],
];
```

## API Endpoints

The JSON configuration can be accessed through:

1. **Direct File Access:** `/storage/mightyweb/mightyweb.json`
2. **API Endpoint:** `/api/config` (if implemented)
3. **Download Endpoint:** `/api/config/download` (if implemented)

## Notes

- All arrays maintain insertion order based on `sort_order` or `order` fields
- Only active items are included in arrays (where `status = 'active'`)
- Nested menu structures support unlimited depth
- Image URLs are fully qualified (absolute URLs)
- Null values are returned for optional fields when not set
