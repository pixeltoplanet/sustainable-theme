# WordPress Sustainability Features

This theme implements comprehensive sustainability optimizations to reduce the carbon footprint of WordPress websites. These optimizations improve performance, reduce server load, minimize data transfer, and optimize resource usage.

## Core Sustainability Settings

### 🌱 Base Mode Features
**Existing Features:**
- ✅ `disable_emojis`: Remove emoji scripts and stylesheets (~30KB savings)
- ✅ `remove_embeds`: Disable oEmbed functionality to reduce external requests
- ✅ `remove_header_metadata`: Remove unnecessary meta tags from HTML head
- ✅ `disable_self_pingbacks`: Prevent self-referential trackbacks
- ✅ `remove_jquery_migrate`: Remove deprecated jQuery migration library

**New Features:**
- 🆕 `remove_shortlinks`: Remove wp-shortlink header and meta tags
- 🆕 `limit_post_revisions`: Limit to 3 revisions per post (vs unlimited default)
- 🆕 `remove_query_strings`: Safely remove version parameters from CSS/JS files for better caching (preserves critical resources like fonts)

### 🚀 Super Mode Features
**All Base Mode features plus:**

**Existing Features:**
- ✅ `dequeue_non_sustainable`: Remove non-essential scripts and styles
- ✅ `use_grid_awareness`: Optimize for clean energy grid times
- ✅ `disable_rss_feed`: Disable RSS feeds and related functionality
- ✅ `remove_rest_output`: Remove REST API discovery links
- ✅ `disable_xmlrpc`: Disable XML-RPC for security and performance
- ✅ `force_data_mode`: Force light/dark mode to reduce processing

**New Features:**
- 🆕 `disable_heartbeat`: Completely disable WordPress heartbeat API
- 🆕 `limit_post_revisions`: Limit to 1 revision per post
- 🆕 `disable_comments`: System-wide comment removal
- 🆕 `remove_wp_version`: Remove WordPress version for security/efficiency
- 🆕 `remove_dns_prefetch`: Remove DNS prefetch hints
- 🆕 `disable_dashicons_frontend`: Remove Dashicons CSS on frontend
- 🆕 `remove_wlwmanifest`: Remove Windows Live Writer manifest link
- 🆕 `disable_file_editing`: Disable theme/plugin file editing in admin
- 🆕 `reduce_heartbeat_frequency`: Reduce heartbeat from 15s to 120s
- 🆕 `disable_gravatar`: Replace Gravatars with lightweight SVG placeholders
- 🆕 `remove_capital_p_dangit`: Remove WordPress auto-correction filters
- 🆕 `disable_automatic_updates`: Disable all automatic updates
- 🆕 `remove_theme_editor`: Remove theme editor from admin (preserves theme installation functionality)
- 🆕 `optimize_database_tables`: Manual database optimization option

## Environmental Impact

### 🌍 Carbon Footprint Reduction

**Data Transfer Reduction:**
- **Emoji removal**: ~30KB per page load
- **Query string removal**: Improves CDN/browser caching efficiency
- **Dashicons removal**: ~24KB CSS file on frontend
- **Gravatar replacement**: Eliminates external HTTP requests + uses lightweight SVG
- **Header metadata removal**: ~2-5KB HTML reduction

**Server Processing Reduction:**
- **Heartbeat disable**: Eliminates constant AJAX polling (every 15-60s)
- **Revision limits**: Reduces database size and query complexity
- **Comments disable**: Removes comment processing overhead
- **Auto-updates disable**: Reduces background processing

**Database Optimization:**
- **Revision limits**: Prevents database bloat from unlimited revisions
- **Comment removal**: Eliminates comment-related queries and storage
- **Manual table optimization**: Defragments and optimizes database tables

### 📊 Performance Metrics

Based on research and real-world implementations:

**Potential CO2 Reduction per Page Load:**
- Small sites (< 1MB): 15-25% reduction
- Medium sites (1-3MB): 20-35% reduction  
- Large sites (> 3MB): 25-45% reduction

**Real-world Example:**
A site with 22 million annual visits reduced CO2 emissions from 1.13g to 0.39g per page load:
- **Annual savings**: 16 tonnes of CO2
- **Equivalent to**: 6.48 tonnes of coal or 7,000 liters of gasoline

## Technical Implementation

### 🔧 WordPress Hooks Used

**Frontend Optimizations:**
```php
// Remove unnecessary head elements
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');

// Disable scripts and styles
wp_deregister_script('heartbeat');
wp_dequeue_style('dashicons');

// Filter resource URLs
add_filter('script_loader_src', 'remove_query_strings');
add_filter('style_loader_src', 'remove_query_strings');
```

**Backend Optimizations:**
```php
// Disable features
add_filter('wp_revisions_to_keep', 'limit_revisions');
add_filter('comments_open', '__return_false');
add_filter('automatic_updater_disabled', '__return_true');

// Security enhancements
define('DISALLOW_FILE_EDIT', true);
// Note: DISALLOW_FILE_MODS removed to preserve theme installation functionality
```

### 🎛️ Configuration Options

**Sustainability Mode:**
- `base`: Conservative optimizations, minimal risk
- `super`: Aggressive optimizations, maximum sustainability

**Individual Overrides:**
All features can be individually enabled/disabled regardless of mode.

**Data Mode:**
- `auto`: System preference detection
- `light`: Force light theme (can reduce processing)
- `dark`: Force dark theme (potentially less energy on OLED screens)

**Grid Awareness:**
- Detects clean energy availability
- Optimizes resource loading during low-carbon periods

## Best Practices

### 🎯 Recommended Settings for Different Sites

**Blog/Content Sites:**
- Use `super` mode
- Keep `disable_comments` as needed
- Enable `limit_post_revisions` to 1-3

**Business Sites:**
- Use `base` mode initially
- Enable `remove_query_strings` for better caching
- Consider `disable_gravatar` for privacy/performance

**E-commerce Sites:**
- Use `base` mode (avoid disabling heartbeat)
- Enable `remove_shortlinks` and `remove_wp_version`
- Careful with `disable_comments` if using reviews

### 🚨 Considerations

**Compatibility:**
- Heartbeat disable may affect auto-save functionality
- Comment disable affects plugins that depend on comment system
- Automatic update disable requires manual security monitoring

**Security:**
- File editing disable improves security
- Theme editor removal prevents accidental code modifications (while preserving theme installation)
- WordPress version removal adds security through obscurity
- Manual update management becomes critical

**Performance Monitoring:**
- Test thoroughly after enabling super mode
- Monitor Core Web Vitals before/after changes
- Use tools like GTmetrix or Google PageSpeed Insights

## Integration with Carbon Measurement

The theme integrates with carbon footprint measurement tools:

**Supported Metrics:**
- Page load CO2 emissions
- Data transfer optimization
- Server processing reduction
- Caching efficiency improvements

**Measurement Tools:**
- Website Carbon Calculator compatibility
- Core Web Vitals integration
- Performance budget tracking

## Recent Improvements

### 🔄 Version Updates

**Admin Bar Management:**
- Removed `disable_admin_bar_frontend` setting for better user experience
- Admin bar now always visible on frontend for easier site management
- Simplified settings interface by removing unnecessary toggles

**Theme Management Enhancement:**
- Improved `remove_theme_editor` implementation
- Now removes only theme editor menu items (not entire theme installation)
- Preserves "Add New Theme" functionality while maintaining security
- Uses targeted menu removal instead of broad `DISALLOW_FILE_MODS`

**Grid Awareness Integration:**
- Integrated `@greenweb/grid-aware-websites` package
- Secure API key handling via backend REST API
- Dynamic body classes based on grid carbon intensity
- Real-time adaptation to local energy conditions

## Future Enhancements

**Planned Features:**
- Image optimization automation
- Critical CSS inlining
- Progressive Web App optimizations
- Advanced caching strategies
- Carbon offset calculation integration

**Research Areas:**
- Machine learning for optimal loading patterns
- Real-time grid carbon intensity adaptation
- Advanced resource prioritization
- Collaborative sustainability metrics

---

*This theme is committed to making WordPress more sustainable. Every optimization reduces environmental impact while improving user experience.* 