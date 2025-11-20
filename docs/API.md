# API Documentation

This document provides comprehensive documentation for the Sustainable Theme's REST API endpoints and PHP class methods.

## REST API Endpoints

All endpoints are prefixed with `/wp-json/sustainable-theme/v1/`

### Authentication

All API requests require a valid WordPress nonce in the `X-WP-Nonce` header:

```javascript
const response = await fetch('/wp-json/sustainable-theme/v1/settings', {
  headers: {
    'X-WP-Nonce': wpApiSettings.nonce,
    'Content-Type': 'application/json'
  }
});
```

### Settings Management

#### Get Settings
```http
GET /wp-json/sustainable-theme/v1/settings
```

**Response:**
```json
{
  "success": true,
  "data": {
    "sustainability_mode": "base",
    "enable_image_optimization": true,
    "enable_lazy_loading": true,
    "use_grid_awareness": false,
    "electricity_maps_api_key": null,
    "limit_post_revisions": 5,
    "remove_default_image_sizes": false,
    "above_fold_image_limit": 2,
    "max_image_size": "large"
  }
}
```

#### Update Settings
```http
POST /wp-json/sustainable-theme/v1/settings
```

**Request Body:**
```json
{
  "sustainability_mode": "super",
  "enable_image_optimization": true,
  "use_grid_awareness": true,
  "electricity_maps_api_key": "your-api-key"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Settings updated successfully",
  "data": {
    "sustainability_mode": "super",
    "enable_image_optimization": true,
    "use_grid_awareness": true,
    "electricity_maps_api_key": "your-api-key"
  }
}
```

#### Update Settings by Mode
```http
POST /wp-json/sustainable-theme/v1/settings/mode
```

**Request Body:**
```json
{
  "mode": "super"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Settings updated to super mode",
  "data": {
    "mode": "super",
    "settings": {
      "sustainability_mode": "super",
      "enable_image_optimization": true,
      "enable_lazy_loading": true,
      "use_grid_awareness": true,
      "limit_post_revisions": 1,
      "remove_default_image_sizes": true
    }
  }
}
```

#### Reset Settings
```http
POST /wp-json/sustainable-theme/v1/settings/reset
```

**Response:**
```json
{
  "success": true,
  "message": "Settings reset to defaults",
  "data": {
    "sustainability_mode": "base",
    "enable_image_optimization": true,
    "enable_lazy_loading": true,
    "use_grid_awareness": false
  }
}
```

### Plugin Management

#### Get Recommended Plugins
```http
GET /wp-json/sustainable-theme/v1/plugins/recommended
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "slug": "wp-smushit",
      "name": "Smush - Image Optimization",
      "description": "Automatically optimize images for better performance and reduced bandwidth usage.",
      "is_installed": false,
      "is_active": false
    },
    {
      "slug": "litespeed-cache",
      "name": "LiteSpeed Cache",
      "description": "Advanced caching plugin for improved page load speeds and reduced server load.",
      "is_installed": true,
      "is_active": false
    }
  ]
}
```

#### Install Plugin
```http
POST /wp-json/sustainable-theme/v1/plugins/install
```

**Request Body:**
```json
{
  "plugin_slug": "wp-smushit"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Plugin installed successfully. You can now activate it.",
  "action": "installed",
  "status_code": 200
}
```

#### Activate Plugin
```http
POST /wp-json/sustainable-theme/v1/plugins/activate
```

**Request Body:**
```json
{
  "plugin_slug": "wp-smushit"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Plugin activated successfully",
  "action": "activated",
  "status_code": 200
}
```

#### Install Plugin (AJAX)
```http
POST /wp-json/sustainable-theme/v1/plugins/install-ajax
```

Enhanced version with better error handling and filesystem management.

**Request Body:**
```json
{
  "plugin_slug": "wp-smushit"
}
```

**Response (Success):**
```json
{
  "success": true,
  "message": "Plugin installed successfully. You can now activate it.",
  "action": "installed",
  "status_code": 200
}
```

**Response (Filesystem Credentials Required):**
```json
{
  "success": false,
  "message": "Automatic installation not available. Please install manually.",
  "action": "manual_install_required",
  "plugin_url": "/wp-admin/plugin-install.php?s=wp-smushit&tab=search&type=term",
  "plugin_name": "Smush - Image Optimization",
  "plugin_description": "Automatically optimize images for better performance and reduced bandwidth usage.",
  "status_code": 200
}
```

### Database Operations

#### Database Cleanup
```http
POST /wp-json/sustainable-theme/v1/database/cleanup
```

**Response:**
```json
{
  "success": true,
  "message": "Database cleaned up successfully! Removed 40 items: 15 revisions, 3 auto-drafts, 8 orphaned postmeta, 2 orphaned commentmeta, 12 expired transients.",
  "stats": {
    "revisions_deleted": 15,
    "auto_drafts_deleted": 3,
    "orphaned_postmeta_deleted": 8,
    "orphaned_commentmeta_deleted": 2,
    "expired_transients_deleted": 12
  }
}
```

### Filesystem Operations

#### Check Filesystem Access
```http
GET /wp-json/sustainable-theme/v1/filesystem/access
```

**Response:**
```json
{
  "success": true,
  "access_info": {
    "direct_access": true,
    "ftp_available": false,
    "plugin_dir_writable": true,
    "methods_available": ["direct"]
  },
  "message": "Direct filesystem access available"
}
```

### Grid Awareness

#### Get Grid Status
```http
GET /wp-json/sustainable-theme/v1/grid-status
```

**Response:**
```json
{
  "success": true,
  "data": {
    "is_green": true,
    "grid_intensity": 75,
    "grid_intensity_label": "low",
    "region": "NL",
    "country_name": "Netherlands",
    "carbon_intensity": 250,
    "last_updated": "2024-01-15 14:30:00"
  },
  "development": false
}
```

## PHP Class Methods

### Settings Class

#### `get_settings(): \WP_REST_Response`
Returns current theme settings.

#### `update_settings(\WP_REST_Request $request): \WP_REST_Response`
Updates theme settings with validation.

#### `update_by_mode(\WP_REST_Request $request): \WP_REST_Response`
Updates settings based on sustainability mode (base/super/custom).

#### `reset_settings(\WP_REST_Request $request): \WP_REST_Response`
Resets all settings to defaults.

#### `get_default_settings(): array`
Returns default settings array.

#### `get_mode_settings(string $mode): array`
Returns settings for specific sustainability mode.

### PluginManager Class

#### `get_recommended_plugins(): array`
Returns array of recommended plugins with installation status.

#### `install_plugin(string $plugin_slug): array`
Installs a plugin from WordPress.org repository.

#### `activate_plugin(string $plugin_slug): array`
Activates an installed plugin.

#### `install_plugin_ajax(string $plugin_slug): array`
Enhanced plugin installation with better error handling.

### FilesystemManager Class

#### `initialize_filesystem(): array`
Initializes WordPress filesystem with multi-method support.

#### `check_filesystem_access(): array`
Checks filesystem access capabilities and permissions.

#### `get_available_methods(): array`
Returns available filesystem access methods.

#### `is_plugin_dir_writable(): bool`
Checks if plugin directory is writable.

#### `request_credentials(): array`
Requests filesystem credentials from user.

#### `test_connection(): array`
Tests filesystem connection and capabilities.

### Database Class

#### `cleanup_database(): array`
Performs comprehensive database cleanup.

#### `register_db_cleanup(): void`
Registers scheduled database cleanup task.

#### `handle_cleanup_request(): \WP_REST_Response`
Handles manual database cleanup requests.

### GridAwareness Class

#### `get_grid_status(): \WP_REST_Response`
Returns current grid intensity data via REST API.

#### `get_grid_status_for_plugin(): array`
Static method for other plugins to get grid status.

#### `get_status_message_for_display(): string`
Static method for themes to display grid status.

#### `display_grid_intencity_banner(): void`
Displays server-rendered grid intensity banner.

### SecurityManager Class

#### `checkRateLimit(string $action, int $user_id = null): bool`
Checks if user has exceeded rate limit for action.

#### `generate_nonce(string $action): string`
Generates security nonce for action.

#### `verify_nonce(string $nonce, string $action): bool`
Verifies security nonce.

#### `get_security_status(): array`
Returns current security status.

#### `security_scan(): array`
Performs comprehensive security scan.

### Logger Class

#### `log(string $level, string $message, array $context = []): void`
Logs message with specified level and context.

#### `info(string $message, array $context = []): void`
Logs info level message.

#### `warning(string $message, array $context = []): void`
Logs warning level message.

#### `error(string $message, array $context = []): void`
Logs error level message.

#### `debug(string $message, array $context = []): void`
Logs debug level message.

#### `get_recent_logs(int $lines = 50): array`
Returns recent log entries.

#### `clear_logs(): bool`
Clears log file.

## Error Handling

### Common Error Responses

#### Rate Limit Exceeded
```json
{
  "success": false,
  "message": "Rate limit exceeded. Please wait before running another operation.",
  "status_code": 429
}
```

#### Permission Denied
```json
{
  "success": false,
  "message": "Insufficient permissions",
  "status_code": 403
}
```

#### Invalid Input
```json
{
  "success": false,
  "message": "Invalid input data",
  "status_code": 400
}
```

#### Server Error
```json
{
  "success": false,
  "message": "Internal server error",
  "status_code": 500
}
```

## Usage Examples

### Frontend JavaScript Integration

```javascript
// Get current settings
async function getSettings() {
  const response = await fetch('/wp-json/sustainable-theme/v1/settings', {
    headers: {
      'X-WP-Nonce': wpApiSettings.nonce
    }
  });
  return await response.json();
}

// Update settings
async function updateSettings(settings) {
  const response = await fetch('/wp-json/sustainable-theme/v1/settings', {
    method: 'POST',
    headers: {
      'X-WP-Nonce': wpApiSettings.nonce,
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(settings)
  });
  return await response.json();
}

// Install plugin
async function installPlugin(pluginSlug) {
  const response = await fetch('/wp-json/sustainable-theme/v1/plugins/install-ajax', {
    method: 'POST',
    headers: {
      'X-WP-Nonce': wpApiSettings.nonce,
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ plugin_slug: pluginSlug })
  });
  return await response.json();
}
```

### PHP Integration

```php
// Get grid status for other plugins
$grid_data = SustainableTheme\GridAwareness::get_grid_status_for_plugin();
if ($grid_data['success']) {
    $intensity = $grid_data['data']['grid_intensity'];
    $is_green = $grid_data['data']['is_green'];
}

// Get status message for display
$message = SustainableTheme\GridAwareness::get_status_message_for_display();
echo "<p class='grid-status'>{$message}</p>";

// Check security status
$security_status = SustainableTheme\SecurityManager::get_security_status();
if ($security_status['rate_limiting_enabled']) {
    // Rate limiting is active
}

// Log custom events
SustainableTheme\Logger::info('Custom event occurred', [
    'user_id' => get_current_user_id(),
    'action' => 'custom_action'
]);
```

## Rate Limiting

The API implements rate limiting to prevent abuse:

- **Database cleanup**: 3 requests per hour per user
- **Plugin installation**: 1 request per 30 seconds per user
- **Settings updates**: 10 requests per minute per user

Rate limits are enforced using WordPress transients and reset automatically.

## Security Considerations

- All endpoints require valid WordPress nonces
- User capabilities are checked for each operation
- Input validation and sanitization on all requests
- Error messages don't expose sensitive information
- API keys are handled server-side only
- Rate limiting prevents abuse
- Comprehensive logging for audit trails
