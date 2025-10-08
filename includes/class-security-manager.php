<?php

namespace SustainableTheme;

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Security Manager Class
 * 
 * Provides comprehensive security enhancements for the Sustainable Theme
 * including input sanitization, rate limiting, and security monitoring.
 * 
 * @package SustainableTheme
 * @since 1.0.0
 */
class SecurityManager
{
  /**
   * Rate limiting configuration
   */
  private static $rate_limits = [
    'settings_update' => ['limit' => 10, 'window' => 300], // 10 requests per 5 minutes
    'database_cleanup' => ['limit' => 3, 'window' => 3600], // 3 requests per hour
    'api_calls' => ['limit' => 60, 'window' => 3600], // 60 requests per hour
  ];
  
  /**
   * Initialize security features
   */
  public function __construct()
  {
    add_action('init', [$this, 'init_security']);
    add_action('wp_ajax_sustainable_theme_security_check', [$this, 'handle_security_check']);
    add_action('wp_ajax_nopriv_sustainable_theme_security_check', [$this, 'handle_security_check']);
  }
  
  /**
   * Initialize security features
   */
  public function init_security(): void
  {
    // Add security headers
    add_action('send_headers', [$this, 'add_security_headers']);
    
    // Monitor suspicious activity
    add_action('wp_login', [$this, 'log_login_attempt'], 10, 2);
    add_action('wp_login_failed', [$this, 'log_failed_login']);
    
    // Sanitize all inputs
    add_filter('pre_update_option_sustainable_theme_settings', [$this, 'sanitize_settings_input'], 10, 2);
  }
  
  /**
   * Add security headers
   */
  public function add_security_headers(): void
  {
    if (!is_admin()) {
      return;
    }
    
    // Content Security Policy
    header('Content-Security-Policy: default-src \'self\'; script-src \'self\' \'unsafe-inline\' \'unsafe-eval\'; style-src \'self\' \'unsafe-inline\';');
    
    // X-Frame-Options
    header('X-Frame-Options: SAMEORIGIN');
    
    // X-Content-Type-Options
    header('X-Content-Type-Options: nosniff');
    
    // Referrer Policy
    header('Referrer-Policy: strict-origin-when-cross-origin');
    
    // X-XSS-Protection
    header('X-XSS-Protection: 1; mode=block');
  }
  
  /**
   * Check rate limit for specific action
   * 
   * @param string $action Action identifier
   * @param int $user_id User ID (optional)
   * @return bool True if within limits, false if rate limited
   */
  public static function checkRateLimit(string $action, int $user_id = null): bool
  {
    if (!isset(self::$rate_limits[$action])) {
      return true; // No limit defined
    }
    
    $user_id = $user_id ?: get_current_user_id();
    $config = self::$rate_limits[$action];
    $key = "rate_limit_{$action}_{$user_id}";
    
    $requests = get_transient($key) ?: 0;
    
    if ($requests >= $config['limit']) {
      Logger::warning('Rate limit exceeded', [
        'action' => $action,
        'user_id' => $user_id,
        'limit' => $config['limit'],
        'window' => $config['window'],
        'ip_address' => self::get_client_ip()
      ]);
      
      return false;
    }
    
    set_transient($key, $requests + 1, $config['window']);
    
    return true;
  }
  
  /**
   * Sanitize settings input
   * 
   * @param mixed $value New value
   * @param mixed $old_value Old value
   * @return mixed Sanitized value
   */
  public function sanitize_settings_input($value, $old_value)
  {
    if (!is_array($value)) {
      Logger::error('Invalid settings input - not an array', [
        'input_type' => gettype($value),
        'user_id' => get_current_user_id()
      ]);
      return $old_value;
    }
    
    // Validate settings
    $errors = SettingsValidator::validateSettings($value);
    if (!empty($errors)) {
      Logger::error('Settings validation failed', [
        'errors' => $errors,
        'user_id' => get_current_user_id()
      ]);
      
      // Return sanitized version instead of rejecting
      $value = SettingsValidator::sanitizeSettings($value);
    }
    
    // Log settings change
    Logger::info('Settings updated', [
      'user_id' => get_current_user_id(),
      'changed_fields' => array_keys(array_diff_assoc($value, $old_value)),
      'ip_address' => self::get_client_ip()
    ]);
    
    return $value;
  }
  
  /**
   * Log login attempt
   * 
   * @param string $user_login Username
   * @param WP_User $user User object
   */
  public function log_login_attempt(string $user_login, \WP_User $user): void
  {
    Logger::info('Successful login', [
      'username' => $user_login,
      'user_id' => $user->ID,
      'ip_address' => self::get_client_ip(),
      'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
    ]);
  }
  
  /**
   * Log failed login attempt
   * 
   * @param string $username Username that failed to login
   */
  public function log_failed_login(string $username): void
  {
    Logger::warning('Failed login attempt', [
      'username' => $username,
      'ip_address' => self::get_client_ip(),
      'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
    ]);
  }
  
  /**
   * Handle security check AJAX request
   */
  public function handle_security_check(): void
  {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'] ?? '', 'sustainable_theme_security_check')) {
      wp_die('Security check failed');
    }
    
    // Check permissions
    if (!current_user_can('manage_options')) {
      wp_die('Insufficient permissions');
    }
    
    $response = [
      'timestamp' => current_time('mysql'),
      'user_id' => get_current_user_id(),
      'ip_address' => self::get_client_ip(),
      'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
      'memory_usage' => memory_get_usage(true),
      'peak_memory' => memory_get_peak_usage(true),
      'php_version' => PHP_VERSION,
      'wordpress_version' => get_bloginfo('version'),
      'theme_version' => SUSTAINABLE_THEME_VERSION ?? 'unknown'
    ];
    
    wp_send_json_success($response);
  }
  
  /**
   * Get client IP address
   * 
   * @return string Client IP address
   */
  private static function get_client_ip(): string
  {
    $ip_keys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
    
    foreach ($ip_keys as $key) {
      if (array_key_exists($key, $_SERVER) === true) {
        foreach (explode(',', $_SERVER[$key]) as $ip) {
          $ip = trim($ip);
          if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
            return $ip;
          }
        }
      }
    }
    
    return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
  }
  
  /**
   * Generate secure nonce
   * 
   * @param string $action Action identifier
   * @return string Nonce value
   */
  public static function generate_nonce(string $action): string
  {
    return wp_create_nonce("sustainable_theme_{$action}");
  }
  
  /**
   * Verify nonce
   * 
   * @param string $nonce Nonce value
   * @param string $action Action identifier
   * @return bool True if valid
   */
  public static function verify_nonce(string $nonce, string $action): bool
  {
    return wp_verify_nonce($nonce, "sustainable_theme_{$action}");
  }
  
  /**
   * Get security status
   * 
   * @return array Security status information
   */
  public static function get_security_status(): array
  {
    $settings = get_option('sustainable_theme_settings', []);
    
    return [
      'file_editing_disabled' => !empty($settings['disable_file_editing']),
      'theme_editor_removed' => !empty($settings['remove_theme_editor']),
      'wp_version_hidden' => !empty($settings['remove_wp_version']),
      'xmlrpc_disabled' => !empty($settings['disable_xmlrpc']),
      'automatic_updates_disabled' => !empty($settings['disable_automatic_updates']),
      'comments_disabled' => !empty($settings['disable_comments']),
      'security_headers_enabled' => true,
      'rate_limiting_enabled' => true,
      'logging_enabled' => true,
      'last_security_check' => current_time('mysql')
    ];
  }
  
  /**
   * Scan for security vulnerabilities
   * 
   * @return array Security scan results
   */
  public static function security_scan(): array
  {
    $issues = [];
    $warnings = [];
    $recommendations = [];
    
    // Check if file editing is enabled
    if (defined('DISALLOW_FILE_EDIT') && !DISALLOW_FILE_EDIT) {
      $warnings[] = 'File editing is enabled in WordPress admin';
    }
    
    // Check if debug mode is enabled
    if (defined('WP_DEBUG') && WP_DEBUG) {
      $warnings[] = 'WordPress debug mode is enabled';
    }
    
    // Check for weak passwords (this would require additional implementation)
    $weak_passwords = self::check_weak_passwords();
    if (!empty($weak_passwords)) {
      $issues[] = 'Weak passwords detected for some users';
    }
    
    // Check for outdated plugins/themes
    $outdated = self::check_outdated_software();
    if (!empty($outdated)) {
      $warnings[] = 'Outdated software detected';
    }
    
    // Recommendations
    $recommendations[] = 'Enable two-factor authentication';
    $recommendations[] = 'Regular security updates';
    $recommendations[] = 'Strong password policies';
    $recommendations[] = 'Regular security scans';
    
    return [
      'issues' => $issues,
      'warnings' => $warnings,
      'recommendations' => $recommendations,
      'scan_date' => current_time('mysql'),
      'overall_status' => empty($issues) ? 'good' : 'needs_attention'
    ];
  }
  
  /**
   * Check for weak passwords (placeholder implementation)
   * 
   * @return array Array of users with weak passwords
   */
  private static function check_weak_passwords(): array
  {
    // This would require additional implementation
    // For now, return empty array
    return [];
  }
  
  /**
   * Check for outdated software
   * 
   * @return array Array of outdated software
   */
  private static function check_outdated_software(): array
  {
    $outdated = [];
    
    // Check WordPress version
    if (version_compare(get_bloginfo('version'), '6.0', '<')) {
      $outdated[] = 'WordPress version is outdated';
    }
    
    // Check PHP version
    if (version_compare(PHP_VERSION, '8.0', '<')) {
      $outdated[] = 'PHP version is outdated';
    }
    
    return $outdated;
  }
}
