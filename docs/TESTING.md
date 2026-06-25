# Sustainability Settings Testing Guide

This document provides a comprehensive guide for testing all sustainability settings in the Sustainable Theme.

## ⚠️ Important Note

**Not all settings are currently implemented!** Some settings are defined in the UI but may not have backend implementations yet. The automated tester will identify which settings are properly implemented.

### Settings That May Need Implementation
- `dequeue_non_sustainable` - May need implementation
- `remove_header_metadata` - Partially implemented (only generator removed)
- `remove_rest_output` - May need implementation  
- `disable_xmlrpc` - May need implementation
- `disable_self_pingbacks` - May need implementation
- `remove_jquery_migrate` - May need implementation
- `disable_emojis` - May need implementation

Use the automated tester (see below) to verify which settings are actually working.

## Testing Overview

### Prerequisites
- WordPress installation with the Sustainable Theme activated
- Browser Developer Tools (Chrome DevTools, Firefox DevTools)
- Access to WordPress admin panel
- Basic knowledge of HTML/CSS inspection

### Testing Tools
- **Browser DevTools**: View page source, network requests, console
- **WordPress Debug Mode**: Enable `WP_DEBUG` in `wp-config.php`
- **Page Speed Tools**: GTmetrix, PageSpeed Insights
- **cURL/Postman**: Test API endpoints

## Settings Checklist

### ✅ Core WordPress Features

#### 1. Disable Emojis (`disable_emojis`)
**Expected Behavior**: Emoji scripts and stylesheets should not load
**How to Test**:
1. Enable the setting
2. View page source (Ctrl+U or Cmd+U)
3. Search for: `wp-emoji-release.min.js` or `emoji`
4. **Should NOT find**: Emoji-related scripts/styles
5. Check Network tab: No requests to `/wp-includes/js/wp-emoji-release.min.js`

**Verification**:
```bash
curl -s https://yoursite.com | grep -i emoji
# Should return nothing
```

#### 2. Remove Embeds (`remove_embeds`)
**Expected Behavior**: oEmbed functionality disabled, wp-embed script removed
**How to Test**:
1. Enable the setting
2. View page source
3. Search for: `wp-embed`, `wp_oembed`, `oembed`
4. **Should NOT find**: oEmbed discovery links or wp-embed script
5. Try pasting a YouTube URL in a post - should NOT auto-embed

**Verification**:
```bash
curl -s https://yoursite.com | grep -i "wp-embed\|oembed"
# Should return nothing
```

#### 3. Remove Header Metadata (`remove_header_metadata`)
**Expected Behavior**: RSD, WLW manifest, generator tags removed
**How to Test**:
1. Enable the setting
2. View page source
3. Search for: `rsd.xml`, `wlwmanifest.xml`, `generator`
4. **Should NOT find**: These meta tags in `<head>`

**Verification**:
```bash
curl -s https://yoursite.com | grep -E "rsd|wlwmanifest|generator"
# Should return nothing
```

#### 4. Remove REST Output (`remove_rest_output`)
**Expected Behavior**: REST API discovery links removed from head
**How to Test**:
1. Enable the setting
2. View page source
3. Search for: `wp-json` in `<head>`
4. **Should NOT find**: REST API link tags

**Verification**:
```bash
curl -s https://yoursite.com | grep -i "wp-json" | grep -i "link"
# Should return nothing (REST API endpoint itself may still exist)
```

#### 5. Disable XML-RPC (`disable_xmlrpc`)
**Expected Behavior**: XML-RPC endpoint disabled
**How to Test**:
1. Enable the setting
2. Visit: `https://yoursite.com/xmlrpc.php`
3. **Should see**: 403 Forbidden or connection refused
4. Check error logs for XML-RPC attempts

**Verification**:
```bash
curl -X POST https://yoursite.com/xmlrpc.php
# Should return 403 or connection error
```

#### 6. Disable Self Pingbacks (`disable_self_pingbacks`)
**Expected Behavior**: Internal links don't create pingbacks
**How to Test**:
1. Enable the setting
2. Create a post with a link to another post on your site
3. Publish the post
4. Check the linked post's comments - **Should NOT see** pingback

**Verification**: Manual test - check comments after linking

#### 7. Remove jQuery Migrate (`remove_jquery_migrate`)
**Expected Behavior**: jQuery migrate script not loaded
**How to Test**:
1. Enable the setting
2. Open DevTools → Network tab
3. Reload page
4. Search for: `jquery-migrate`
5. **Should NOT find**: jquery-migrate.min.js requests

**Verification**:
```bash
curl -s https://yoursite.com | grep -i "jquery-migrate"
# Should return nothing
```

### ✅ Performance Optimizations

#### 8. Remove Shortlinks (`remove_shortlinks`)
**Expected Behavior**: Shortlink headers and meta tags removed
**How to Test**:
1. Enable the setting
2. View page source
3. Search for: `shortlink` or `?p=`
4. **Should NOT find**: Shortlink meta tags or headers

**Verification**:
```bash
curl -I https://yoursite.com | grep -i shortlink
# Should return nothing
```

#### 9. Remove Query Strings (`remove_query_strings`)
**Expected Behavior**: Version parameters removed from CSS/JS URLs
**How to Test**:
1. Enable the setting
2. View page source
3. Check CSS/JS file URLs
4. **Should NOT see**: `?ver=6.x` in URLs
5. Font files may still have query strings (by design)

**Verification**:
```bash
curl -s https://yoursite.com | grep -E "\.(css|js)\?ver="
# Should return nothing (except fonts)
```

#### 10. Remove WordPress Version (`remove_wp_version`)
**Expected Behavior**: WordPress version removed from HTML
**How to Test**:
1. Enable the setting
2. View page source
3. Search for: WordPress version number (e.g., "6.4")
4. **Should NOT find**: Version in meta tags or comments

**Verification**:
```bash
curl -s https://yoursite.com | grep -i "wordpress.*[0-9]\.[0-9]"
# Should return nothing
```

#### 11. Remove DNS Prefetch (`remove_dns_prefetch`)
**Expected Behavior**: DNS prefetch hints removed
**How to Test**:
1. Enable the setting
2. View page source
3. Search for: `dns-prefetch`
4. **Should NOT find**: DNS prefetch link tags

**Verification**:
```bash
curl -s https://yoursite.com | grep -i "dns-prefetch"
# Should return nothing
```

### ✅ Server Resource Management

#### 12. Disable Heartbeat (`disable_heartbeat`)
**Expected Behavior**: Heartbeat script not loaded
**How to Test**:
1. Enable the setting
2. Open DevTools → Network tab
3. Reload page
4. Search for: `heartbeat`
5. **Should NOT find**: heartbeat.min.js requests
6. **Note**: Auto-save may not work

**Verification**:
```bash
curl -s https://yoursite.com | grep -i heartbeat
# Should return nothing
```

#### 13. Reduce Heartbeat Frequency (`reduce_heartbeat_frequency`)
**Expected Behavior**: Heartbeat runs less frequently (every 2 minutes)
**How to Test**:
1. Enable the setting (disable_heartbeat must be false)
2. Open DevTools → Network tab
3. Monitor heartbeat requests
4. **Should see**: Requests every ~120 seconds (instead of 15-60s)

**Verification**: Manual monitoring in Network tab

#### 14. Limit Post Revisions (`limit_post_revisions`)
**Expected Behavior**: Only specified number of revisions kept
**How to Test**:
1. Enable and set limit (e.g., 3)
2. Edit a post multiple times (more than limit)
3. Check database: `SELECT COUNT(*) FROM wp_posts WHERE post_parent = [post_id] AND post_type = 'revision'`
4. **Should see**: Maximum of limit number of revisions

**Verification**:
```sql
SELECT COUNT(*) FROM wp_posts 
WHERE post_parent = [YOUR_POST_ID] 
AND post_type = 'revision';
```

### ✅ Feature Removal

#### 15. Disable Comments (`disable_comments`)
**Expected Behavior**: Comment system completely removed
**How to Test**:
1. Enable the setting
2. Check admin menu - **Should NOT see** "Comments"
3. Edit post - **Should NOT see** comment meta boxes
4. Frontend - **Should NOT see** comment forms or existing comments

**Verification**: Visual inspection of admin and frontend

#### 16. Disable RSS Feed (`disable_rss_feed`)
**Expected Behavior**: RSS feeds disabled and redirected
**How to Test**:
1. Enable the setting
2. Visit: `https://yoursite.com/feed/`
3. **Should see**: Redirect to homepage (301)
4. View page source - **Should NOT find** feed links in head

**Verification**:
```bash
curl -I https://yoursite.com/feed/
# Should return 301 redirect
```

#### 17. Disable Gravatar (`disable_gravatar`)
**Expected Behavior**: Gravatar replaced with SVG placeholder
**How to Test**:
1. Enable the setting
2. View page with avatars (comments, author)
3. Check image source - **Should see**: data URI SVG instead of gravatar.com
4. Check Network tab - **Should NOT see** requests to gravatar.com

**Verification**:
```bash
curl -s https://yoursite.com | grep -i gravatar
# Should return nothing
```

### ✅ Frontend Optimizations

#### 18. Disable Dashicons Frontend (`disable_dashicons_frontend`)
**Expected Behavior**: Dashicons CSS not loaded on frontend
**How to Test**:
1. Enable the setting
2. Open DevTools → Network tab
3. Reload page
4. Search for: `dashicons`
5. **Should NOT find**: dashicons.min.css requests

**Verification**:
```bash
curl -s https://yoursite.com | grep -i dashicons
# Should return nothing
```

### ✅ Security & Maintenance

#### 19. Disable File Editing (`disable_file_editing`)
**Expected Behavior**: Theme/plugin editor disabled
**How to Test**:
1. Enable the setting
2. Go to Appearance → Theme Editor
3. **Should see**: "File editing is disabled" message
4. Check `wp-config.php` - **Should see**: `define('DISALLOW_FILE_EDIT', true);`

**Verification**: Visual inspection in admin

#### 20. Remove Theme Editor (`remove_theme_editor`)
**Expected Behavior**: Theme editor menu item removed
**How to Test**:
1. Enable the setting
2. Go to Appearance menu
3. **Should NOT see**: "Theme Editor" submenu item

**Verification**: Visual inspection in admin

#### 21. Disable Automatic Updates (`disable_automatic_updates`)
**Expected Behavior**: Automatic updates disabled
**How to Test**:
1. Enable the setting
2. Check WordPress update settings
3. **Should see**: Updates disabled
4. Monitor update attempts in logs

**Verification**: Check update logs and settings

#### 22. Remove Capital P Dangit (`remove_capital_p_dangit`)
**Expected Behavior**: WordPress auto-correction disabled
**How to Test**:
1. Enable the setting
2. Create post with "wordpress" (lowercase p)
3. Publish and view
4. **Should see**: "wordpress" unchanged (not "WordPress")

**Verification**: Manual test with lowercase "wordpress"

### ✅ Image & Lazy Loading

#### 23. Enable Lazy Loading (`enable_lazy_loading`)
**Expected Behavior**: Images load lazily with loading="lazy" attribute
**How to Test**:
1. Enable the setting
2. View page source
3. Check image tags
4. **Should see**: `loading="lazy"` on images (except above-fold)

**Verification**:
```bash
curl -s https://yoursite.com | grep -i "loading=\"lazy\""
# Should find lazy loading attributes
```

#### 24. Above Fold Image Limit (`above_fold_image_limit`)
**Expected Behavior**: First N images load immediately
**How to Test**:
1. Set limit (e.g., 2)
2. View page source
3. First 2 images - **Should NOT have** `loading="lazy"`
4. Remaining images - **Should have** `loading="lazy"`

**Verification**: Count images without lazy attribute

#### 25. Enable Image Optimization (`enable_image_optimization`)
**Expected Behavior**: Responsive image sizes created
**How to Test**:
1. Enable the setting
2. Upload an image
3. Check media library - **Should see**: Multiple size variants
4. View page source - **Should see**: `srcset` attributes

**Verification**:
```bash
curl -s https://yoursite.com | grep -i srcset
# Should find srcset attributes
```

#### 26. Remove Default Image Sizes (`remove_default_image_sizes`)
**Expected Behavior**: WordPress default sizes not created
**How to Test**:
1. Enable the setting
2. Upload an image
3. Check uploads folder
4. **Should NOT see**: `-medium.jpg`, `-large.jpg` files

**Verification**: Check uploads directory

### ✅ Upload Size Limit

#### 27. Upload Size Limit (1MB)
**Expected Behavior**: Files larger than 1MB rejected
**How to Test**:
1. Try uploading file > 1MB
2. **Should see**: Error message about file size
3. Try uploading file < 1MB
4. **Should succeed**

**Verification**: Manual upload test

## Automated Testing

### REST API Endpoint

The theme includes an automated testing system accessible via REST API:

**Endpoint**: `GET /wp-json/sustainable-theme/v1/test-settings`

**Usage**:
```bash
curl -X GET "https://yoursite.com/wp-json/sustainable-theme/v1/test-settings" \
  -H "X-WP-Nonce: YOUR_NONCE"
```

**Response**:
```json
{
  "success": true,
  "summary": {
    "total": 20,
    "passed": 15,
    "partial": 3,
    "not_tested": 2,
    "success_rate": 75.0
  },
  "results": {
    "disable_emojis": {
      "enabled": true,
      "action_removed": true,
      "status": "pass",
      "message": "Emojis successfully disabled"
    },
    ...
  },
  "formatted_report": "<div>...</div>"
}
```

### Using the Tester in PHP

```php
require_once get_template_directory() . '/includes/class-sustainability-tester.php';

$tester = new \SustainableTheme\SustainabilityTester();
$results = $tester->run_all_tests();
$summary = $tester->get_summary();

// Get formatted HTML report
$report = $tester->get_formatted_report();
echo $report;
```

### What the Tester Checks

The automated tester verifies:
- ✅ Settings are enabled/disabled correctly
- ✅ WordPress hooks/actions are registered/removed
- ✅ Filters are properly applied
- ✅ Scripts/styles are deregistered
- ✅ Constants are set correctly
- ✅ Classes are instantiated

**Note**: The tester checks if hooks/filters are registered, but cannot verify frontend output without actually rendering pages. Use manual testing for frontend verification.

## Testing Modes

### Base Mode Testing
1. Switch to Base mode
2. Verify all Base mode settings are active
3. Test each feature listed above

### Super Mode Testing
1. Switch to Super mode
2. Verify all Super mode settings are active
3. Test each feature listed above

### Custom Mode Testing
1. Switch to Custom mode
2. Enable/disable individual settings
3. Test each enabled feature

## Common Issues

### Settings Not Taking Effect
- Clear WordPress cache
- Clear browser cache
- Check if setting is saved correctly in database
- Verify hooks are firing (enable WP_DEBUG)

### Conflicts with Plugins
- Some plugins may override theme settings
- Test with default plugins only
- Check plugin compatibility

### PHP Restrictions
- Some settings require PHP functions that may be disabled
- Check PHP error logs
- Verify `ini_set` permissions

## Reporting Issues

When reporting issues, include:
1. Setting name
2. Expected behavior
3. Actual behavior
4. WordPress version
5. PHP version
6. Active plugins
7. Browser and version
8. Error messages (if any)

