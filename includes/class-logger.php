<?php

namespace SustainableTheme;

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Logger Class
 * 
 * Provides structured logging for the Sustainable Theme with different log levels
 * and contextual information for better debugging and monitoring.
 * 
 * @package SustainableTheme
 * @since 1.0.0
 */
class Logger
{
  /**
   * Log levels
   */
  const EMERGENCY = 'emergency';
  const ALERT = 'alert';
  const CRITICAL = 'critical';
  const ERROR = 'error';
  const WARNING = 'warning';
  const NOTICE = 'notice';
  const INFO = 'info';
  const DEBUG = 'debug';

  /**
   * Log a message with context
   * 
   * @param string $level Log level
   * @param string $message Log message
   * @param array $context Additional context data
   * @return void
   */
  public static function log(string $level, string $message, array $context = []): void
  {
    $log_entry = [
      'timestamp' => current_time('mysql'),
      'level' => $level,
      'message' => $message,
      'context' => $context,
      'user_id' => get_current_user_id(),
      'request_uri' => $_SERVER['REQUEST_URI'] ?? '',
      'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
      'ip_address' => self::get_client_ip(),
      'memory_usage' => memory_get_usage(true),
      'peak_memory' => memory_get_peak_usage(true),
    ];

    // Format log entry
    $formatted_message = self::format_log_entry($log_entry);

    // Write to WordPress error log
    error_log($formatted_message);

    // Also store in custom log file if WP_DEBUG is enabled
    if (defined('WP_DEBUG') && WP_DEBUG) {
      self::write_to_file($log_entry);
    }
  }

  /**
   * Log emergency level message
   */
  public static function emergency(string $message, array $context = []): void
  {
    self::log(self::EMERGENCY, $message, $context);
  }

  /**
   * Log alert level message
   */
  public static function alert(string $message, array $context = []): void
  {
    self::log(self::ALERT, $message, $context);
  }

  /**
   * Log critical level message
   */
  public static function critical(string $message, array $context = []): void
  {
    self::log(self::CRITICAL, $message, $context);
  }

  /**
   * Log error level message
   */
  public static function error(string $message, array $context = []): void
  {
    self::log(self::ERROR, $message, $context);
  }

  /**
   * Log warning level message
   */
  public static function warning(string $message, array $context = []): void
  {
    self::log(self::WARNING, $message, $context);
  }

  /**
   * Log notice level message
   */
  public static function notice(string $message, array $context = []): void
  {
    self::log(self::NOTICE, $message, $context);
  }

  /**
   * Log info level message
   */
  public static function info(string $message, array $context = []): void
  {
    self::log(self::INFO, $message, $context);
  }

  /**
   * Log debug level message
   */
  public static function debug(string $message, array $context = []): void
  {
    self::log(self::DEBUG, $message, $context);
  }

  /**
   * Format log entry for output
   */
  private static function format_log_entry(array $log_entry): string
  {
    $context_str = !empty($log_entry['context']) ? ' ' . json_encode($log_entry['context']) : '';

    return sprintf(
      '[%s] %s: %s%s',
      $log_entry['timestamp'],
      strtoupper($log_entry['level']),
      $log_entry['message'],
      $context_str
    );
  }

  /**
   * Write log entry to custom file
   */
  private static function write_to_file(array $log_entry): void
  {
    $log_file = WP_CONTENT_DIR . '/sustainable-theme.log';
    $formatted_message = self::format_log_entry($log_entry) . PHP_EOL;

    file_put_contents($log_file, $formatted_message, FILE_APPEND | LOCK_EX);
  }

  /**
   * Get client IP address
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
   * Clear log file
   */
  public static function clear_logs(): bool
  {
    $log_file = WP_CONTENT_DIR . '/sustainable-theme.log';

    if (file_exists($log_file)) {
      return unlink($log_file);
    }

    return true;
  }

  /**
   * Get log file size
   */
  public static function get_log_size(): int
  {
    $log_file = WP_CONTENT_DIR . '/sustainable-theme.log';

    if (file_exists($log_file)) {
      return filesize($log_file);
    }

    return 0;
  }

  /**
   * Get recent log entries
   */
  public static function get_recent_logs(int $lines = 50): array
  {
    $log_file = WP_CONTENT_DIR . '/sustainable-theme.log';

    if (!file_exists($log_file)) {
      return [];
    }

    $log_content = file_get_contents($log_file);
    $log_lines = explode(PHP_EOL, $log_content);
    $log_lines = array_filter($log_lines); // Remove empty lines

    return array_slice($log_lines, -$lines);
  }
}
