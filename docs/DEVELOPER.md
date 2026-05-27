# Developer Guide

This guide provides comprehensive information for developers who want to extend, customize, or contribute to the Sustainable Theme.

## Architecture Overview

### Core Components

The theme follows a modular architecture with clear separation of concerns:

```
sustainable-theme/
├── includes/           # PHP backend classes
│   ├── class-settings.php          # Settings management
│   ├── class-plugin-manager.php     # Plugin operations
│   ├── class-filesystem-manager.php # Filesystem operations
│   ├── class-database.php           # Database optimization
│   ├── class-grid-awareness.php     # Grid intensity monitoring
│   ├── class-security-manager.php   # Security features
│   ├── class-logger.php             # Logging system
│   └── class-rest-api-manager.php   # API coordination
├── src/               # React frontend components
│   ├── components/    # Reusable React components
│   ├── views/         # Page-level components
│   ├── lib/           # Utility functions
│   └── styles/        # SCSS stylesheets
└── build/             # Compiled assets
```

### Design Patterns

#### Dependency Injection
The theme uses dependency injection for clean architecture:

```php
class RestApiManager
{
    public function __construct(
        Settings $settings,
        PluginManager $plugin_manager,
        FilesystemManager $filesystem_manager
    ) {
        $this->settings = $settings;
        $this->plugin_manager = $plugin_manager;
        $this->filesystem_manager = $filesystem_manager;
    }
}
```

#### Manager Pattern
Each major functionality is encapsulated in a manager class:

- **Settings**: Configuration management
- **PluginManager**: Plugin operations
- **FilesystemManager**: File system operations
- **SecurityManager**: Security features
- **Logger**: Logging system

## Extending the Theme

### Adding New Settings

#### 1. Update Settings Schema

Add new settings to the `get_default_settings()` method in `class-settings.php`:

```php
public function get_default_settings(): array
{
    return [
        // Existing settings...
        'your_new_setting' => 'default_value',
        'another_setting' => [
            'option1' => 'value1',
            'option2' => 'value2'
        ]
    ];
}
```

#### 2. Add Validation

Update the `sanitize_settings()` method to handle your new settings:

```php
public function sanitize_settings(array $settings): array
{
    // Existing sanitization...
    
    if (isset($settings['your_new_setting'])) {
        $settings['your_new_setting'] = sanitize_text_field($settings['your_new_setting']);
    }
    
    return $settings;
}
```

#### 3. Create React Component

Add a new component in `src/components/`:

```jsx
import { useState } from '@wordpress/element';
import { Button, TextControl } from '@wordpress/components';

export default function YourNewSetting({ value, onChange }) {
    const [localValue, setLocalValue] = useState(value);

    const handleSave = () => {
        onChange(localValue);
    };

    return (
        <div className="your-setting-panel">
            <TextControl
                label="Your Setting"
                value={localValue}
                onChange={setLocalValue}
            />
            <Button onClick={handleSave} variant="primary">
                Save Setting
            </Button>
        </div>
    );
}
```

#### 4. Integrate with Admin Interface

Add your component to the appropriate admin page:

```jsx
// In src/views/SettingsPage.js
import YourNewSetting from '../components/YourNewSetting';

export default function SettingsPage() {
    const [settings, setSettings] = useState({});

    return (
        <div className="settings-page">
            {/* Existing components... */}
            <YourNewSetting 
                value={settings.your_new_setting}
                onChange={(value) => setSettings(prev => ({
                    ...prev,
                    your_new_setting: value
                }))}
            />
        </div>
    );
}
```

### Adding New REST API Endpoints

#### 1. Register Route

Add your endpoint to `class-rest-api-manager.php`:

```php
private function register_your_routes(): void
{
    register_rest_route('sustainable-theme/v1', '/your-endpoint', [
        'methods' => 'GET',
        'callback' => [$this, 'handle_your_endpoint'],
        'permission_callback' => [$this, 'check_permissions'],
    ]);
}
```

#### 2. Implement Handler

```php
public function handle_your_endpoint(\WP_REST_Request $request): \WP_REST_Response
{
    try {
        // Your logic here
        $data = $this->process_your_request($request);
        
        return $this->format_response([
            'success' => true,
            'data' => $data
        ]);
    } catch (\Exception $e) {
        Logger::error('Your endpoint failed', [
            'error' => $e->getMessage(),
            'user_id' => get_current_user_id()
        ]);
        
        return $this->format_response([
            'success' => false,
            'message' => 'Operation failed: ' . $e->getMessage()
        ], 500);
    }
}
```

#### 3. Frontend Integration

Use your endpoint in React components:

```javascript
const fetchYourData = async () => {
    const response = await fetch('/wp-json/sustainable-theme/v1/your-endpoint', {
        headers: {
            'X-WP-Nonce': wpApiSettings.nonce
        }
    });
    return await response.json();
};
```

### Adding New Optimization Features

#### 1. Create Optimization Class

Create a new class in `includes/`:

```php
<?php

namespace SustainableTheme;

class YourOptimization
{
    private $settings;

    public function __construct()
    {
        $this->settings = get_option('sustainable_theme_settings', []);
        
        if ($this->should_enable_optimization()) {
            $this->init_optimization();
        }
    }

    private function should_enable_optimization(): bool
    {
        return !empty($this->settings['enable_your_optimization']);
    }

    private function init_optimization(): void
    {
        // Add WordPress hooks
        add_action('wp_enqueue_scripts', [$this, 'optimize_scripts']);
        add_filter('your_filter', [$this, 'your_callback']);
    }

    public function optimize_scripts(): void
    {
        // Your optimization logic
    }

    public function your_callback($value)
    {
        // Your filter logic
        return $value;
    }
}
```

#### 2. Register with Theme

Add to `functions.php`:

```php
// Initialize your optimization
new SustainableTheme\YourOptimization();
```

#### 3. Add Settings Integration

Update settings to include your optimization toggle:

```php
// In class-settings.php
public function get_default_settings(): array
{
    return [
        // Existing settings...
        'enable_your_optimization' => false,
    ];
}
```

### Creating Custom React Components

#### Component Structure

Follow the established pattern for React components:

```jsx
import { useState, useEffect } from '@wordpress/element';
import { 
    Button, 
    Card, 
    CardBody, 
    CardHeader,
    Spinner 
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';

export default function YourComponent({ 
    initialValue, 
    onSave, 
    isLoading = false 
}) {
    const [value, setValue] = useState(initialValue);
    const [isSaving, setIsSaving] = useState(false);

    const handleSave = async () => {
        setIsSaving(true);
        try {
            await onSave(value);
        } catch (error) {
            console.error('Save failed:', error);
        } finally {
            setIsSaving(false);
        }
    };

    if (isLoading) {
        return <Spinner />;
    }

    return (
        <Card>
            <CardHeader>
                <h3>{__('Your Component', 'sustainable')}</h3>
            </CardHeader>
            <CardBody>
                {/* Your component content */}
                <Button 
                    onClick={handleSave}
                    disabled={isSaving}
                    variant="primary"
                >
                    {isSaving ? __('Saving...', 'sustainable') : __('Save', 'sustainable')}
                </Button>
            </CardBody>
        </Card>
    );
}
```

#### Styling Components

Use SCSS for component styling:

```scss
// In src/styles/admin.scss
.your-component {
    margin: 1rem 0;
    
    &__header {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    &__content {
        padding: 1rem;
        background: #f9f9f9;
        border-radius: 4px;
    }
    
    &__button {
        margin-top: 1rem;
        
        &:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    }
}
```

## Development Workflow

### Local Development Setup

1. **Install Dependencies**
   ```bash
   bun install
   ```

2. **Start Development Server**
   ```bash
   bun run dev
   ```

3. **Build for Production**
   ```bash
   bun run build
   ```

### Code Standards

#### PHP Standards
- Follow WordPress Coding Standards
- Use PSR-4 autoloading
- Document all public methods
- Use type hints where possible

#### JavaScript Standards
- Use React functional components with hooks
- Follow WordPress JavaScript standards
- Use TypeScript for type safety
- Implement proper error handling

#### CSS Standards
- Use SCSS for styling
- Follow BEM methodology
- Use CSS custom properties for theming
- Ensure responsive design

### Testing

#### PHP Testing
```php
// Example test structure
class TestYourClass extends WP_UnitTestCase
{
    public function test_your_method()
    {
        $instance = new YourClass();
        $result = $instance->your_method();
        
        $this->assertTrue($result['success']);
        $this->assertEquals('expected', $result['data']);
    }
}
```

#### JavaScript Testing
```javascript
// Example test structure
import { render, screen } from '@testing-library/react';
import YourComponent from '../YourComponent';

describe('YourComponent', () => {
    it('renders correctly', () => {
        render(<YourComponent initialValue="test" />);
        expect(screen.getByText('test')).toBeInTheDocument();
    });
});
```

### Debugging

#### PHP Debugging
Use the built-in Logger class:

```php
use SustainableTheme\Logger;

// Log different levels
Logger::info('Operation started', ['user_id' => get_current_user_id()]);
Logger::warning('Potential issue detected', ['context' => $data]);
Logger::error('Operation failed', ['error' => $exception->getMessage()]);
```

#### JavaScript Debugging
Use browser dev tools and console logging:

```javascript
// Debug API calls
const debugApiCall = async (endpoint, data) => {
    console.log('API Call:', endpoint, data);
    try {
        const response = await fetch(endpoint, data);
        const result = await response.json();
        console.log('API Response:', result);
        return result;
    } catch (error) {
        console.error('API Error:', error);
        throw error;
    }
};
```

## Performance Considerations

### Frontend Performance
- Use React.memo for expensive components
- Implement proper loading states
- Optimize bundle size with code splitting
- Use lazy loading for non-critical components

### Backend Performance
- Implement proper caching strategies
- Use database indexes for queries
- Optimize image processing
- Monitor memory usage

### Database Performance
- Use the built-in Database class for cleanup
- Implement proper query optimization
- Monitor query performance
- Use database indexes effectively

## Security Best Practices

### Input Validation
Always validate and sanitize user input:

```php
public function sanitize_input($input)
{
    if (is_string($input)) {
        return sanitize_text_field($input);
    }
    
    if (is_array($input)) {
        return array_map([$this, 'sanitize_input'], $input);
    }
    
    return $input;
}
```

### Permission Checks
Always check user capabilities:

```php
public function check_permissions(): bool
{
    return current_user_can('manage_options');
}
```

### Rate Limiting
Use the SecurityManager for rate limiting:

```php
if (!SecurityManager::checkRateLimit('your_action')) {
    return new \WP_REST_Response([
        'success' => false,
        'message' => 'Rate limit exceeded'
    ], 429);
}
```

## Contributing Guidelines

### Pull Request Process
1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Update documentation
6. Submit a pull request

### Code Review Checklist
- [ ] Code follows established patterns
- [ ] Tests pass
- [ ] Documentation is updated
- [ ] Security considerations addressed
- [ ] Performance impact considered

### Commit Message Format
```
type(scope): description

Detailed explanation if needed

Closes #issue_number
```

Types: `feat`, `fix`, `docs`, `style`, `refactor`, `test`, `chore`

## Troubleshooting

### Common Issues

#### Build Errors
```bash
# Clear node modules and reinstall
rm -rf node_modules
bun install

# Clear build cache
bun run build --clean
```

#### PHP Errors
- Check WordPress debug log
- Enable WP_DEBUG in wp-config.php
- Use the Logger class for debugging

#### API Issues
- Verify nonce is valid
- Check user permissions
- Review rate limiting settings
- Check browser network tab

### Getting Help
- Check existing issues on GitHub
- Review the API documentation
- Test with minimal configuration
- Use debugging tools provided

## Advanced Topics

### Custom Hooks and Filters
Add custom WordPress hooks for extensibility:

```php
// Allow other plugins to modify settings
$settings = apply_filters('sustainable_theme_settings', $settings);

// Allow customization of optimization behavior
do_action('sustainable_theme_before_optimization', $context);
```

### Integration with Other Plugins
Create integration points for popular plugins:

```php
// WooCommerce integration example
if (class_exists('WooCommerce')) {
    add_action('woocommerce_init', [$this, 'init_woocommerce_integration']);
}
```

### Custom Post Types
Add custom post types for sustainability features:

```php
public function register_sustainability_post_type()
{
    register_post_type('sustainability_report', [
        'labels' => [
            'name' => __('Sustainability Reports', 'sustainable'),
            'singular_name' => __('Sustainability Report', 'sustainable'),
        ],
        'public' => true,
        'has_archive' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
    ]);
}
```

This developer guide provides the foundation for extending the Sustainable Theme. For specific implementation details, refer to the API documentation and existing code examples.
