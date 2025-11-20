# Sustainable WordPress Theme

A modern, sustainability-focused WordPress block theme designed to minimize environmental impact while maximizing performance and user experience.

## 🌱 Overview

The Sustainable Theme reduces your website's carbon footprint through intelligent optimizations, performance enhancements, and environmental awareness features. Built with React-powered admin interfaces and comprehensive sustainability settings.

## ✨ Key Features

### Sustainability Optimizations
- **Grid Awareness**: Real-time carbon intensity monitoring with Electricity Maps API
- **Performance Optimization**: Image compression, lazy loading, and caching strategies
- **Resource Reduction**: Removes unnecessary scripts, styles, and metadata
- **Database Optimization**: Automated cleanup and revision management

### Modern Architecture
- **React Admin Interface**: Modern, responsive admin panels
- **REST API Integration**: Comprehensive API for all theme operations
- **Plugin Management**: Automated installation of recommended sustainability plugins
- **Security Features**: Rate limiting, nonce validation, and permission checks

### User Experience
- **Mode-Based Configuration**: Choose between Base, Super, or Custom sustainability levels
- **Real-time Monitoring**: Live grid intensity indicators
- **One-Click Optimization**: Automated plugin installation and configuration
- **Comprehensive Settings**: Fine-grained control over all optimizations

## 🚀 Quick Start

### Installation
1. Upload the theme to `/wp-content/themes/sustainable-theme/`
2. Activate the theme in WordPress admin
3. Navigate to **Sustainable theme** in the admin menu
4. Choose your sustainability mode and configure settings

### Basic Configuration
```php
// Enable base sustainability mode
update_option('sustainable_theme_settings', [
    'sustainability_mode' => 'base',
    'enable_image_optimization' => true,
    'enable_lazy_loading' => true,
    'use_grid_awareness' => true
]);
```

### Grid Awareness Setup
1. Get an API key from [Electricity Maps](https://api-portal.electricitymaps.com/)
2. Add the key in **Sustainability** settings
3. Enable grid awareness to optimize for clean energy times

## 🏗️ Architecture

### Core Classes

#### Settings Management
- **`Settings`**: Central configuration management
- **`SettingsValidator`**: Input validation and sanitization
- **`RestApiManager`**: API endpoint coordination

#### Plugin & Filesystem Management
- **`PluginManager`**: Automated plugin installation and activation
- **`FilesystemManager`**: WordPress filesystem abstraction layer

#### Optimization Classes
- **`SustainabilityOptimizer`**: Core sustainability optimizations
- **`Image_Sizes`**: Responsive image size management
- **`LazyLoading`**: Native lazy loading implementation
- **`Database`**: Automated database cleanup and optimization

#### Security & Monitoring
- **`SecurityManager`**: Rate limiting, headers, and security features
- **`Logger`**: Structured logging with multiple levels
- **`GridAwareness`**: Real-time carbon intensity monitoring

### Frontend Architecture
- **React Components**: Modern admin interface components
- **Webpack Build**: Optimized asset bundling
- **SCSS Styling**: Modular CSS architecture
- **TypeScript Support**: Type-safe development

## 📊 Sustainability Impact

### Performance Improvements
- **15-45% reduction** in page load CO2 emissions
- **30KB+ savings** per page load from optimizations
- **Reduced server load** through intelligent caching
- **Database efficiency** with automated cleanup

### Environmental Features
- **Grid-aware loading**: Optimize for clean energy times
- **Resource minimization**: Remove unnecessary scripts and styles
- **Efficient caching**: Reduce repeated data transfer
- **Carbon tracking**: Monitor and reduce environmental impact

## 🔧 Configuration

### Sustainability Modes

#### Base Mode
Conservative optimizations with minimal risk:
- Image optimization and lazy loading
- Basic script/style removal
- Database cleanup
- Query string optimization

#### Super Mode
Aggressive optimizations for maximum sustainability:
- All Base Mode features
- Heartbeat API disable
- Comment system removal
- Advanced resource optimization
- Gravatar replacement

#### Custom Mode
Fine-grained control over individual features:
- Enable/disable any optimization
- Custom configuration values
- Advanced settings access

### API Endpoints

#### Settings Management
- `GET /wp-json/sustainable-theme/v1/settings` - Get current settings
- `POST /wp-json/sustainable-theme/v1/settings` - Update settings
- `POST /wp-json/sustainable-theme/v1/settings/mode` - Update by mode
- `POST /wp-json/sustainable-theme/v1/settings/reset` - Reset to defaults

#### Plugin Operations
- `GET /wp-json/sustainable-theme/v1/plugins/recommended` - Get recommended plugins
- `POST /wp-json/sustainable-theme/v1/plugins/install` - Install plugin
- `POST /wp-json/sustainable-theme/v1/plugins/activate` - Activate plugin

#### Database Operations
- `POST /wp-json/sustainable-theme/v1/database/cleanup` - Manual database cleanup

#### Grid Awareness
- `GET /wp-json/sustainable-theme/v1/grid-status` - Get current grid status

## 🛠️ Development

### Prerequisites
- Node.js 18+ or Bun 1.0+
- WordPress 6.0+
- PHP 8.0+

### Setup
```bash
# Install dependencies
bun install

# Development build
bun run dev

# Production build
bun run build

# Create theme package
bun run release
```

### Project Structure
```
sustainable-theme/
├── includes/           # PHP classes
├── src/               # React components and JS
├── build/             # Compiled assets
├── parts/             # Block theme parts
├── templates/         # Block theme templates
└── style.css         # Theme stylesheet
```

### Adding New Features
1. Create PHP class in `includes/`
2. Add React component in `src/components/`
3. Register REST API routes in `RestApiManager`
4. Update settings schema in `Settings` class
5. Add admin interface in React components

## 🔒 Security

### Built-in Security Features
- **Nonce validation** for all API requests
- **Rate limiting** to prevent abuse
- **Permission checks** for all operations
- **Input sanitization** and validation
- **Security headers** for enhanced protection

### Best Practices
- Keep WordPress and plugins updated
- Use strong passwords and 2FA
- Regular security scans
- Monitor access logs

## 📈 Performance Monitoring

### Core Web Vitals
The theme optimizes for:
- **Largest Contentful Paint (LCP)**: Faster loading
- **First Input Delay (FID)**: Responsive interactions
- **Cumulative Layout Shift (CLS)**: Stable layouts

### Monitoring Tools
- Google PageSpeed Insights
- GTmetrix
- Website Carbon Calculator
- Core Web Vitals reports

## 🤝 Contributing

### Development Guidelines
- Follow WordPress coding standards
- Use TypeScript for frontend code
- Write comprehensive tests
- Document all public methods
- Follow semantic versioning

### Code Style
- PHP: WordPress coding standards
- JavaScript: ESLint + Prettier
- CSS: SCSS with BEM methodology
- Documentation: Markdown with clear examples

## 📄 License

This theme is licensed under the GPL v2 or later.

## 🙏 Acknowledgments

- [Electricity Maps](https://electricitymaps.com/) for carbon intensity data
- [Green Web Foundation](https://www.thegreenwebfoundation.org/) for sustainability guidance
- WordPress community for core functionality
- React and modern web standards for the admin interface

## 📞 Support

For support, feature requests, or bug reports:
- Create an issue on the project repository
- Check the documentation in `/docs/`
- Review the sustainability features guide

---

**Making WordPress more sustainable, one site at a time.** 🌍
