# MightyWeb API Documentation

## Overview

MightyWeb provides a JSON-based configuration API that exports all app settings for mobile applications. This document describes the available endpoints and data structures.

## Base URL

```
https://yourdomain.com/mightyweb/api
```

## Authentication

Currently, the API endpoints are publicly accessible for reading configuration data. For production environments, consider implementing authentication middleware.

## Endpoints

### 1. Get Full Configuration

**Endpoint:** `GET /config/export`

**Description:** Exports all application configuration including splash screens, walkthroughs, menus, pages, tabs, navigation icons, floating buttons, and theme settings.

**Response Format:** JSON

**Example Request:**
```bash
curl -X GET https://yourdomain.com/mightyweb/api/config/export
```

**Example Response:**
```json
{
  "app": {
    "name": "MightyWeb App",
    "version": "1.0.0",
    "last_updated": "2025-10-26T10:30:00Z"
  },
  "splash_screen": {
    "logo": "/upload/splash_logo.png",
    "background": "/upload/splash_background.png",
    "duration": 3000,
    "background_color": "#FFFFFF"
  },
  "walkthroughs": [
    {
      "id": 1,
      "title": "Welcome",
      "description": "Welcome to our amazing app",
      "image": "/upload/walkthrough/welcome.png",
      "sort_order": 1,
      "is_active": true
    }
  ],
  "menus": [
    {
      "id": 1,
      "title": "Home",
      "icon": "/upload/menu/home.png",
      "page_id": 1,
      "sort_order": 1,
      "is_active": true
    }
  ],
  "pages": [
    {
      "id": 1,
      "title": "Home Page",
      "url": "https://example.com",
      "parent_id": null,
      "is_active": true
    }
  ],
  "tabs": [
    {
      "id": 1,
      "title": "Home",
      "icon_active": "/upload/tabs/home_active.png",
      "icon_inactive": "/upload/tabs/home_inactive.png",
      "page_id": 1,
      "sort_order": 1,
      "is_active": true
    }
  ],
  "navigation_icons": {
    "left": [
      {
        "id": 1,
        "title": "Menu",
        "icon": "/upload/navigationicons/left/menu.png",
        "action": "menu",
        "position": "left",
        "sort_order": 1,
        "is_active": true
      }
    ],
    "right": [
      {
        "id": 2,
        "title": "Search",
        "icon": "/upload/navigationicons/right/search.png",
        "action": "search",
        "position": "right",
        "sort_order": 1,
        "is_active": true
      }
    ]
  },
  "floating_buttons": [
    {
      "id": 1,
      "title": "Add",
      "icon": "/upload/floatingbutton/add.png",
      "action": "add",
      "sort_order": 1,
      "is_active": true
    }
  ],
  "theme": {
    "primary_color": "#3B82F6",
    "secondary_color": "#8B5CF6",
    "accent_color": "#10B981",
    "background_color": "#FFFFFF",
    "text_color": "#1F2937",
    "font_family": "Roboto",
    "style_preset": "default",
    "is_dark_mode": false
  }
}
```

### 2. Get Splash Screen Configuration

**Endpoint:** `GET /config/splash-screen`

**Description:** Returns only the splash screen configuration.

**Response Structure:**
```json
{
  "logo": "/upload/splash_logo.png",
  "background": "/upload/splash_background.png",
  "duration": 3000,
  "background_color": "#FFFFFF"
}
```

### 3. Get Walkthroughs

**Endpoint:** `GET /config/walkthroughs`

**Description:** Returns all active walkthrough screens in order.

**Response Structure:**
```json
[
  {
    "id": 1,
    "title": "Welcome",
    "description": "Welcome to our amazing app",
    "image": "/upload/walkthrough/welcome.png",
    "sort_order": 1,
    "is_active": true
  }
]
```

### 4. Get Menus

**Endpoint:** `GET /config/menus`

**Description:** Returns all active menu items in order.

### 5. Get Pages

**Endpoint:** `GET /config/pages`

**Description:** Returns all active pages with hierarchy.

### 6. Get Tabs

**Endpoint:** `GET /config/tabs`

**Description:** Returns all active bottom navigation tabs.

### 7. Get Navigation Icons

**Endpoint:** `GET /config/navigation-icons`

**Description:** Returns navigation bar icons grouped by position (left/right).

### 8. Get Floating Buttons

**Endpoint:** `GET /config/floating-buttons`

**Description:** Returns all active floating action buttons.

### 9. Get Theme Configuration

**Endpoint:** `GET /config/theme`

**Description:** Returns theme colors, fonts, and style settings.

## Data Structures

### Splash Screen Object

| Field | Type | Description |
|-------|------|-------------|
| logo | string | Path to splash logo image |
| background | string | Path to background image |
| duration | integer | Display duration in milliseconds |
| background_color | string | Hex color code |

### Walkthrough Object

| Field | Type | Description |
|-------|------|-------------|
| id | integer | Unique identifier |
| title | string | Walkthrough title |
| description | string | Walkthrough description |
| image | string | Path to image |
| sort_order | integer | Display order |
| is_active | boolean | Active status |

### Menu Object

| Field | Type | Description |
|-------|------|-------------|
| id | integer | Unique identifier |
| title | string | Menu item title |
| icon | string | Path to icon image |
| page_id | integer | Associated page ID |
| sort_order | integer | Display order |
| is_active | boolean | Active status |

### Page Object

| Field | Type | Description |
|-------|------|-------------|
| id | integer | Unique identifier |
| title | string | Page title |
| url | string | Web page URL |
| parent_id | integer/null | Parent page ID for nested pages |
| is_active | boolean | Active status |

### Tab Object

| Field | Type | Description |
|-------|------|-------------|
| id | integer | Unique identifier |
| title | string | Tab title |
| icon_active | string | Path to active state icon |
| icon_inactive | string | Path to inactive state icon |
| page_id | integer | Associated page ID |
| sort_order | integer | Display order |
| is_active | boolean | Active status |

### Navigation Icon Object

| Field | Type | Description |
|-------|------|-------------|
| id | integer | Unique identifier |
| title | string | Icon title |
| icon | string | Path to icon image |
| action | string | Action identifier or URL |
| position | string | "left" or "right" |
| sort_order | integer | Display order within position |
| is_active | boolean | Active status |

### Floating Button Object

| Field | Type | Description |
|-------|------|-------------|
| id | integer | Unique identifier |
| title | string | Button title |
| icon | string | Path to icon image |
| action | string | Action identifier or URL |
| sort_order | integer | Display order |
| is_active | boolean | Active status |

### Theme Object

| Field | Type | Description |
|-------|------|-------------|
| primary_color | string | Primary color hex code |
| secondary_color | string | Secondary color hex code |
| accent_color | string | Accent color hex code |
| background_color | string | Background color hex code |
| text_color | string | Text color hex code |
| font_family | string | Font family name |
| style_preset | string | Applied style preset name |
| is_dark_mode | boolean | Dark mode enabled |

## Image Paths

All image paths in the API responses are relative to your application's public directory. To construct full URLs:

```
Full URL = Base URL + Image Path
Example: https://yourdomain.com/upload/splash_logo.png
```

## Action Types

### Navigation Icon Actions

- `menu` - Open navigation drawer/menu
- `back` - Navigate back
- `home` - Go to home page
- `search` - Open search
- `filter` - Open filters
- `/custom-page` - Navigate to custom URL

### Floating Button Actions

- `add` - Create new item
- `create` - Create new content
- `compose` - Compose message
- `chat` - Open chat
- `/custom-action` - Custom action or URL

## Error Responses

### 404 Not Found
```json
{
  "error": "Resource not found",
  "message": "The requested configuration does not exist"
}
```

### 500 Server Error
```json
{
  "error": "Server error",
  "message": "An error occurred while processing your request"
}
```

## Usage in Mobile Apps

### Flutter Example

```dart
import 'package:http/http.dart' as http;
import 'dart:convert';

Future<Map<String, dynamic>> fetchAppConfig() async {
  final response = await http.get(
    Uri.parse('https://yourdomain.com/mightyweb/api/config/export'),
  );

  if (response.statusCode == 200) {
    return json.decode(response.body);
  } else {
    throw Exception('Failed to load configuration');
  }
}
```

### React Native Example

```javascript
async function fetchAppConfig() {
  try {
    const response = await fetch('https://yourdomain.com/mightyweb/api/config/export');
    const config = await response.json();
    return config;
  } catch (error) {
    console.error('Failed to load configuration:', error);
    throw error;
  }
}
```

### Swift (iOS) Example

```swift
func fetchAppConfig() {
    guard let url = URL(string: "https://yourdomain.com/mightyweb/api/config/export") else { return }
    
    URLSession.shared.dataTask(with: url) { data, response, error in
        guard let data = data, error == nil else { return }
        
        do {
            let config = try JSONDecoder().decode(AppConfig.self, from: data)
            // Use configuration
        } catch {
            print("Failed to decode configuration: \(error)")
        }
    }.resume()
}
```

### Kotlin (Android) Example

```kotlin
suspend fun fetchAppConfig(): AppConfig {
    val response = httpClient.get("https://yourdomain.com/mightyweb/api/config/export")
    return response.body()
}
```

## Caching Recommendations

To optimize performance:

1. **Cache the configuration** locally in your mobile app
2. **Check for updates** periodically (e.g., on app launch)
3. **Use ETags or Last-Modified headers** to avoid downloading unchanged data
4. **Implement offline mode** using cached configuration

Example caching strategy:

```javascript
const CACHE_KEY = 'app_config';
const CACHE_DURATION = 3600000; // 1 hour

async function getConfig() {
  const cached = localStorage.getItem(CACHE_KEY);
  const cacheTime = localStorage.getItem(CACHE_KEY + '_time');
  
  if (cached && cacheTime && (Date.now() - cacheTime < CACHE_DURATION)) {
    return JSON.parse(cached);
  }
  
  const config = await fetchAppConfig();
  localStorage.setItem(CACHE_KEY, JSON.stringify(config));
  localStorage.setItem(CACHE_KEY + '_time', Date.now().toString());
  
  return config;
}
```

## Versioning

The API follows semantic versioning. Check the `app.version` field in the response to track configuration changes.

## Support

For issues or questions:
- GitHub: https://github.com/yourusername/mightyweb
- Email: support@yourdomain.com
- Documentation: https://yourdomain.com/docs

## Rate Limiting

Currently, no rate limiting is implemented. For production use, consider implementing rate limiting based on your needs.

## CORS Configuration

If your mobile app needs to access the API from a different domain, ensure CORS is properly configured in your Laravel application:

```php
// config/cors.php
'paths' => ['mightyweb/api/*'],
'allowed_methods' => ['GET'],
'allowed_origins' => ['*'],
'allowed_headers' => ['*'],
```

## Security Considerations

1. **HTTPS Only**: Always use HTTPS in production
2. **Authentication**: Consider adding API authentication for sensitive data
3. **Rate Limiting**: Implement rate limiting to prevent abuse
4. **Input Validation**: All admin panel inputs are validated server-side
5. **File Upload Security**: Images are validated and sanitized before storage

## Changelog

### Version 1.0.0 (2025-10-26)
- Initial API release
- Full configuration export endpoint
- Individual resource endpoints
- Support for all app features

