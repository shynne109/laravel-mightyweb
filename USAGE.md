# MightyWeb Usage Guide

Complete guide for using MightyWeb to manage your mobile app configurations.

---

## 📱 Quick Start

### Installation

```bash
composer require shynne109/mightyweb
php artisan migrate
php artisan vendor:publish --tag=mightyweb-assets
```

### Add to Layout

```blade
<head>
    @mightywebAssets
</head>
<body>
    @yield('content')
    @mightywebScripts
</body>
```

### Access Dashboard

Visit: `http://yourapp.com/mightyweb`

---

## 🎛️ Module Guide

### 1. App Configuration

**Purpose:** Manage basic app information and integrations

**How to Use:**
1. Navigate to **App Configuration**
2. Configure in 5 tabs:

**Tab 1: Basic Info**
- Set app name (e.g., "MyAwesomeApp")
- Set app version (e.g., "1.0.0")
- Set package name (e.g., "com.example.app")
- Upload app logo (recommended: 512x512px PNG)

**Tab 2: URLs & Links**
- Website URL
- Privacy Policy URL
- Terms of Service URL
- Support/Help URL

**Tab 3: API & Behavior**
- API base URL (your backend API)
- API timeout (default: 30 seconds)
- Toggle force update
- Toggle maintenance mode
- Enable/disable caching

**Tab 4: Social & Contact**
- Facebook, Twitter, Instagram URLs
- YouTube, LinkedIn URLs
- Contact email and phone

**Tab 5: Integrations**
- Firebase (enable + API key + Project ID)
- Analytics (enable + Tracking ID)

3. Click **Save Configuration**

**JSON Output:**
```json
{
    "app_name": "MyAwesomeApp",
    "app_version": "1.0.0",
    "app_logo": "/storage/logos/app.png",
    "website_url": "https://example.com",
    "firebase_enabled": true,
    "firebase_api_key": "your-api-key"
}
```

---

### 2. Theme Configuration

**Purpose:** Customize app appearance

**How to Use:**
1. Navigate to **Theme Configuration**
2. Choose a preset theme OR customize colors:

**Preset Themes:**
- Default (Purple/Blue)
- Dark (Gray tones)
- Ocean (Blue/Cyan)
- Sunset (Orange/Red)
- Forest (Green tones)

**Custom Colors:**
- **Primary Color** - Main brand color
- **Secondary Color** - Accent color
- **Accent Color** - Highlights
- **Background Color** - App background
- **Text Color** - Default text

**Font Selection:**
- Choose from 8 font families
- See live preview

**Dark Mode:**
- Toggle dark mode support
- Customize dark color scheme

3. Click **Save Theme**

**JSON Output:**
```json
{
    "theme": {
        "primary_color": "#842DE9",
        "secondary_color": "#9039F0",
        "font_family": "Inter",
        "dark_mode_enabled": true
    }
}
```

---

### 3. Walkthrough Screens

**Purpose:** Create onboarding tutorials for new users

**How to Use:**
1. Navigate to **Walkthrough**
2. Click **Add Walkthrough**
3. Fill in details:
   - **Title** - Screen heading (e.g., "Welcome to MyApp")
   - **Description** - Explanation text
   - **Image** - Upload illustration (recommended: 800x600px)
   - **Sort Order** - Display sequence (1, 2, 3...)
   - **Active** - Show/hide this screen
4. Click **Save**

**Managing Screens:**
- **Edit** - Click pencil icon
- **Delete** - Click trash icon (with confirmation)
- **Toggle Active** - Click switch for quick enable/disable
- **Search** - Find screens by title/description

**Best Practices:**
- Keep 3-5 screens maximum
- Use clear, simple language
- High-quality images
- Logical order (1, 2, 3...)

**JSON Output:**
```json
{
    "walkthrough": [
        {
            "id": 1,
            "title": "Welcome",
            "description": "Get started with our app",
            "image": "/storage/walkthrough/welcome.png",
            "sort_order": 1,
            "is_active": true
        }
    ]
}
```

---

### 4. Menu Management

**Purpose:** Build hierarchical navigation menus

**How to Use:**
1. Navigate to **Menu Management**
2. Click **Add Menu**
3. Configure menu:
   - **Parent Menu** - Leave empty for top-level OR select parent
   - **Title** - Menu label (e.g., "Settings")
   - **Icon** - Upload icon (recommended: 64x64px PNG)
   - **URL** - Link destination (e.g., "/settings")
   - **Sort Order** - Display position
   - **Active** - Visibility toggle
4. Click **Save**

**Creating Nested Menus:**
```
Home (parent)
├─ Dashboard (child of Home)
├─ Profile (child of Home)
Settings (parent)
├─ Account (child of Settings)
└─ Privacy (child of Settings)
```

**Features:**
- Unlimited nesting levels
- Circular reference prevention
- Drag-and-drop ordering (via sort_order)
- Icon preview

**JSON Output:**
```json
{
    "menus": [
        {
            "id": 1,
            "parent_id": null,
            "title": "Home",
            "icon": "/storage/menu/home.png",
            "url": "/home",
            "sort_order": 1,
            "is_active": true,
            "children": [
                {
                    "id": 2,
                    "parent_id": 1,
                    "title": "Dashboard",
                    "url": "/dashboard"
                }
            ]
        }
    ]
}
```

---

### 5. Page Management

**Purpose:** Create and manage content pages

**How to Use:**
1. Navigate to **Pages**
2. Click **Add Page**
3. Fill in:
   - **Title** - Page name (e.g., "About Us")
   - **Description** - Page content or summary
   - **URL** - Page slug (e.g., "/about")
   - **Active** - Publish/unpublish toggle
4. Click **Save**

**Use Cases:**
- About Us page
- Help/FAQ page
- Terms & Conditions
- Privacy Policy
- Contact page

**Linking Pages:**
- Link from menus (Menu → URL: `/about`)
- Link from tabs
- Link from floating button

**JSON Output:**
```json
{
    "pages": [
        {
            "id": 1,
            "title": "About Us",
            "description": "Learn more about our company",
            "url": "/about",
            "is_active": true
        }
    ]
}
```

---

### 6. Tabs (Bottom Navigation)

**Purpose:** Configure bottom navigation bar

**How to Use:**
1. Navigate to **Tabs**
2. Click **Add Tab**
3. Configure tab:
   - **Title** - Tab label (e.g., "Home")
   - **Icon** - Upload icon (recommended: 64x64px PNG)
   - **URL** - Tab destination (e.g., "/home")
   - **Sort Order** - Left-to-right position (1-5)
   - **Active** - Show/hide tab
4. Click **Save**

**Recommended Tabs:**
```
1. Home     (icon: house)
2. Search   (icon: magnifying glass)
3. Favorites (icon: heart)
4. Profile  (icon: user)
```

**Best Practices:**
- Maximum 5 tabs
- Use recognizable icons
- Short, clear labels
- Consistent icon style

**JSON Output:**
```json
{
    "tabs": [
        {
            "id": 1,
            "title": "Home",
            "icon": "/storage/tabs/home.png",
            "url": "/home",
            "sort_order": 1,
            "is_active": true
        }
    ]
}
```

---

### 7. Navigation Icons (Header)

**Purpose:** Manage header icons (left and right)

**How to Use:**
1. Navigate to **Navigation Icons**
2. Filter by position (Left or Right)
3. Click **Add Navigation Icon**
4. Configure:
   - **Title** - Icon purpose (e.g., "Back", "Search")
   - **Icon** - Upload icon (recommended: 64x64px PNG)
   - **URL** - Click action (e.g., "/search")
   - **Position** - Left or Right
   - **Sort Order** - Display order
   - **Active** - Visibility
5. Click **Save**

**Common Usage:**
```
Left Side:          Right Side:
- Back button       - Search
- Menu toggle       - Notifications
- Logo              - Cart
                    - Profile
```

**Position Filter:**
- Click "Left Icons" or "Right Icons" to filter
- Manages icons separately by position

**JSON Output:**
```json
{
    "navigation_icons": {
        "left": [
            {
                "id": 1,
                "title": "Back",
                "icon": "/storage/icons/back.png",
                "url": "back",
                "position": "left",
                "sort_order": 1
            }
        ],
        "right": [
            {
                "id": 2,
                "title": "Search",
                "icon": "/storage/icons/search.png",
                "url": "/search",
                "position": "right"
            }
        ]
    }
}
```

---

### 8. Floating Button

**Purpose:** Configure floating action button (FAB)

**How to Use:**
1. Navigate to **Floating Button**
2. Click **Add Floating Button**
3. Configure:
   - **Title** - Button purpose (e.g., "Add Item")
   - **Icon** - Upload icon (recommended: 128x128px PNG)
   - **URL** - Click action (e.g., "/add")
   - **Active** - Show/hide button
4. Click **Save**

**Common Uses:**
- Add new item (plus icon)
- Start chat (message icon)
- Create post (pencil icon)
- Quick action (star icon)

**Design Tips:**
- Use circular icon with padding
- High contrast color
- Recognizable symbol
- Single, primary action

**JSON Output:**
```json
{
    "floating_button": {
        "id": 1,
        "title": "Add Item",
        "icon": "/storage/floating/add.png",
        "url": "/add",
        "is_active": true
    }
}
```

---

## 🔄 Exporting Configuration

### JSON Export

Get all configurations as JSON for your mobile app:

**Via Browser:**
```
http://yourapp.com/mightyweb/export-json
```

**Via API:**
```bash
curl http://yourapp.com/api/mightyweb/config
```

**Complete JSON Structure:**
```json
{
    "app": { /* App Configuration */ },
    "theme": { /* Theme settings */ },
    "walkthrough": [ /* Array of screens */ ],
    "menus": [ /* Hierarchical menus */ ],
    "pages": [ /* Content pages */ ],
    "tabs": [ /* Bottom nav tabs */ ],
    "navigation_icons": { 
        "left": [ /* Left icons */ ],
        "right": [ /* Right icons */ ]
    },
    "floating_button": { /* FAB config */ }
}
```

### Using in Mobile App

**Flutter Example:**
```dart
Future<AppConfig> fetchConfig() async {
  final response = await http.get(
    Uri.parse('https://yourapi.com/api/mightyweb/config')
  );
  return AppConfig.fromJson(jsonDecode(response.body));
}
```

**React Native Example:**
```javascript
const fetchConfig = async () => {
  const response = await fetch('https://yourapi.com/api/mightyweb/config');
  const config = await response.json();
  return config;
};
```

---

## 🎨 Common Workflows

### Setting Up a New App

1. **App Configuration** - Set name, logo, URLs
2. **Theme Configuration** - Choose colors and font
3. **Walkthrough** - Create 3-4 onboarding screens
4. **Tabs** - Set up bottom navigation (3-5 tabs)
5. **Menu** - Build navigation structure
6. **Pages** - Create About, Help pages
7. **Export** - Get JSON for mobile app

### Updating App Theme

1. Navigate to **Theme Configuration**
2. Choose preset OR customize colors
3. See live preview
4. Click **Save Theme**
5. Re-export JSON for mobile app

### Adding New Feature

1. Create page in **Pages**
2. Add menu item in **Menu Management**
3. OR add tab in **Tabs**
4. Set icon and URL
5. Activate and save
6. Export updated JSON

---

## 🔍 Search & Filter

### Search
- Type in search box (300ms debounce)
- Searches titles, descriptions, URLs
- Works across all modules

### Sort
- Click column headers to sort
- Toggle ascending/descending
- Maintains current filters

### Pagination
- Choose items per page: 5, 10, 25, 50
- Navigate with Previous/Next
- Shows total count

### Active/Inactive Toggle
- Click switch for instant toggle
- No need to open edit modal
- Visual feedback (loading spinner)

---

## ⚙️ Tips & Best Practices

### Images
- **Logo:** 512x512px PNG with transparency
- **Walkthrough:** 800x600px PNG or JPG
- **Icons:** 64x64px PNG with transparency
- **Floating Button:** 128x128px PNG circular

### Performance
- Keep descriptions concise
- Optimize images before upload
- Limit walkthrough to 3-5 screens
- Use consistent icon style

### URLs
- Use relative URLs (/page) for internal
- Use absolute URLs (https://...) for external
- Test all links before deploying

### Sort Orders
- Use increments of 10 (10, 20, 30)
- Makes it easy to insert items later
- Consistent ordering across modules

### Active/Inactive
- Use for A/B testing features
- Temporarily disable without deleting
- Quick enable/disable toggle

---

## 🐛 Troubleshooting

### Issue: Changes Not Showing in App

**Solution:**
1. Verify item is **Active**
2. Re-export JSON
3. Update mobile app config
4. Clear mobile app cache

### Issue: Image Not Displaying

**Solution:**
1. Check image file size (<2MB)
2. Use PNG or JPG format
3. Verify storage directory writable
4. Check full image URL in JSON

### Issue: Menu Not Showing Children

**Solution:**
1. Verify parent_id is correct
2. Check both parent and child are **Active**
3. Ensure circular references don't exist
4. Check sort_order values

---

## 📚 Additional Resources

- **README.md** - Installation and overview
- **CHANGELOG.md** - Version history
- **VITE_INTEGRATION.md** - Asset compilation details

---

## 🆘 Support

Need help? 
- Check the troubleshooting section above
- Review the JSON output format
- Email: sbatch2016@gmail.com

---

**Version:** 1.0.0  
**Last Updated:** October 26, 2025
