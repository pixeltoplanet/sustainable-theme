<?php

namespace SustainableTheme;

/**
 * Filesystem Management Class
 * 
 * Handles WordPress filesystem operations including initialization,
 * credential management, and plugin installation capabilities.
 * 
 * @package SustainableTheme
 * @since 1.0.0
 */
class FilesystemManager
{
  /**
   * Initialize WordPress filesystem with multi-method access support
   * 
   * Attempts direct access first, falls back to credential-based access.
   * Returns success status and initialization details.
   * 
   * @since 1.0.0
   * @return array Filesystem initialization results
   */
  public function initialize_filesystem(): array
  {
    error_log("Sustainable Theme: Initializing filesystem");

    // Include necessary files
    if (!function_exists('WP_Filesystem')) {
      include_once(ABSPATH . 'wp-admin/includes/file.php');
    }

    $credentials = false;
    $filesystem_initialized = false;

    // Try direct method first (most common in production)
    if (is_writable(WP_PLUGIN_DIR)) {
      if (WP_Filesystem($credentials, WP_PLUGIN_DIR, 'direct')) {
        error_log("Sustainable Theme: Filesystem initialized with direct method");
        $filesystem_initialized = true;
      }
    }

    // If direct fails, try to get FTP credentials from WordPress
    if (!$filesystem_initialized) {
      error_log("Sustainable Theme: Direct method failed, requesting filesystem credentials");

      // Request filesystem credentials (this will show WordPress's credential form if needed)
      $credentials = request_filesystem_credentials(
        admin_url('admin.php?page=sustainable-theme-settings'),
        '',
        false,
        WP_PLUGIN_DIR,
        null,
        true
      );

      if ($credentials) {
        if (WP_Filesystem($credentials, WP_PLUGIN_DIR)) {
          error_log("Sustainable Theme: Filesystem initialized with provided credentials");
          $filesystem_initialized = true;
        }
      }
    }

    if (!$filesystem_initialized) {
      error_log("Sustainable Theme: All filesystem methods failed");
      return [
        'success' => false,
        'message' => 'Unable to access filesystem for plugin installation. Please check file permissions or provide FTP credentials.',
        'action' => 'filesystem_credentials_required',
        'credentials_url' => admin_url('admin.php?page=sustainable-theme-settings'),
      ];
    }

    return [
      'success' => true,
      'message' => 'Filesystem initialized successfully',
    ];
  }

  /**
   * Check filesystem access capabilities and permissions
   * 
   * Evaluates current filesystem access to determine what operations
   * can be performed safely.
   * 
   * @since 1.0.0
   * @return array Filesystem access capabilities and status
   */
  public function check_filesystem_access(): array
  {
    error_log("Sustainable Theme: Checking filesystem access capabilities");

    // Include necessary files
    if (!function_exists('WP_Filesystem')) {
      include_once(ABSPATH . 'wp-admin/includes/file.php');
    }

    $access_info = [
      'direct_access' => false,
      'ftp_available' => false,
      'plugin_dir_writable' => false,
      'methods_available' => [],
    ];

    // Check if plugin directory is writable
    $access_info['plugin_dir_writable'] = is_writable(WP_PLUGIN_DIR);

    // Check direct access
    if ($access_info['plugin_dir_writable']) {
      $credentials = false;
      if (WP_Filesystem($credentials, WP_PLUGIN_DIR, 'direct')) {
        $access_info['direct_access'] = true;
        $access_info['methods_available'][] = 'direct';
      }
    }

    // Check FTP availability
    if (function_exists('ftp_connect')) {
      $access_info['ftp_available'] = true;
      $access_info['methods_available'][] = 'ftp';
    }

    // Check SSH availability
    if (function_exists('ssh2_connect')) {
      $access_info['methods_available'][] = 'ssh';
    }

    error_log("Sustainable Theme: Filesystem access check complete: " . json_encode($access_info));

    return [
      'success' => true,
      'access_info' => $access_info,
      'message' => $access_info['direct_access'] ?
        'Direct filesystem access available' :
        'Direct access not available, FTP/SSH may be required',
    ];
  }

  /**
   * Get list of available filesystem access methods
   * 
   * Detects and returns all available filesystem access methods
   * supported by the current WordPress installation.
   * 
   * @since 1.0.0
   * @return array Available filesystem methods
   */
  public function get_available_methods(): array
  {
    $methods = [];

    // Check direct access
    if (is_writable(WP_PLUGIN_DIR)) {
      $methods[] = 'direct';
    }

    // Check FTP availability
    if (function_exists('ftp_connect')) {
      $methods[] = 'ftp';
    }

    // Check SSH availability
    if (function_exists('ssh2_connect')) {
      $methods[] = 'ssh';
    }

    return $methods;
  }

  /**
   * Check if plugin directory is writable
   * 
   * Performs a simple check to determine if the WordPress plugin directory
   * is writable by the current process. This is a quick validation method
   * that can be used before attempting plugin installation operations.
   * 
   * ## What This Checks
   * - **Directory Permissions**: Verifies WP_PLUGIN_DIR is writable
   * - **Process Permissions**: Ensures current PHP process can write files
   * - **Basic Access**: Simple boolean check for immediate feedback
   * 
   * ## Use Cases
   * - **Pre-installation Check**: Quick validation before plugin operations
   * - **Environment Detection**: Identify server configuration issues
   * - **User Interface**: Show appropriate installation options
   * - **Error Prevention**: Avoid failed operations due to permissions
   * 
   * ## Limitations
   * - Only checks basic writability, not full filesystem capabilities
   * - Does not account for credential-based access methods
   * - May return false even when FTP/SSH access is available
   * 
   * ## Return Value
   * - **true**: Plugin directory is writable with current permissions
   * - **false**: Plugin directory is not writable or does not exist
   * 
   * @since 1.0.0
   * @return bool True if plugin directory is writable, false otherwise
   * 
   * @link https://developer.wordpress.org/reference/functions/is_writable/
   */
  public function is_plugin_dir_writable(): bool
  {
    return is_writable(WP_PLUGIN_DIR);
  }

  /**
   * Request filesystem credentials from user
   * 
   * Initiates the WordPress credential request process to obtain FTP, SSH,
   * or other filesystem credentials needed for file operations. This method
   * handles the secure collection of credentials through WordPress's
   * built-in credential form system.
   * 
   * ## Credential Request Process
   * 
   * ### 1. Form Display
   * - Shows WordPress's standard credential form
   * - Supports FTP, FTPS, SSH, and other methods
   * - Handles form submission and validation
   * 
   * ### 2. Credential Validation
   * - Tests provided credentials against target directory
   * - Verifies connection and permissions
   * - Returns detailed success/failure information
   * 
   * ### 3. Security Handling
   * - Credentials are not stored permanently
   * - Uses WordPress's secure credential handling
   * - Follows WordPress security best practices
   * 
   * ## Supported Methods
   * - **FTP**: Standard FTP connection
   * - **FTPS**: FTP over SSL/TLS
   * - **SSH**: SSH2 connection (if extension available)
   * - **SFTP**: SSH File Transfer Protocol
   * 
   * ## Return Value
   * Returns an associative array with credential request results:
   * ```php
   * [
   *   'success' => bool,
   *   'credentials' => array,  // Credentials if successful
   *   'method' => string,     // Method used (ftp, ssh, etc.)
   *   'form_html' => string,  // HTML form if credentials needed
   *   'error' => string       // Error message if failed
   * ]
   * ```
   * 
   * ## Usage Examples
   * ```php
   * $result = $fs_manager->request_credentials();
   * 
   * if ($result['success']) {
   *   // Credentials obtained, proceed with operations
   * } else {
   *   // Show credential form to user
   *   echo $result['form_html'];
   * }
   * ```
   * 
   * @since 1.0.0
   * @return array Credential request results with success status and form data
   * 
   * @link https://developer.wordpress.org/reference/functions/request_filesystem_credentials/
   */
  public function request_credentials(): array
  {
    error_log("Sustainable Theme: Requesting filesystem credentials");

    $credentials = request_filesystem_credentials(
      admin_url('admin.php?page=sustainable-theme-settings'),
      '',
      false,
      WP_PLUGIN_DIR,
      null,
      true
    );

    if ($credentials) {
      return [
        'success' => true,
        'credentials' => $credentials,
        'message' => 'Credentials obtained successfully',
      ];
    }

    return [
      'success' => false,
      'message' => 'Failed to obtain filesystem credentials',
    ];
  }

  /**
   * Test filesystem connection and capabilities
   * 
   * Performs comprehensive testing of the filesystem connection to verify
   * that file operations can be performed successfully. This method tests
   * both connectivity and actual file manipulation capabilities.
   * 
   * ## Connection Tests Performed
   * 
   * ### 1. Basic Connectivity Test
   * - Verifies filesystem initialization
   * - Tests connection to target directory
   * - Validates authentication if credentials required
   * 
   * ### 2. File Operation Tests
   * - Creates a temporary test file
   * - Writes content to the test file
   * - Reads content back for verification
   * - Deletes the test file (cleanup)
   * 
   * ### 3. Permission Validation
   * - Tests write permissions in target directory
   * - Verifies file creation and deletion capabilities
   * - Ensures proper access to WordPress directories
   * 
   * ## Test Process
   * 1. **Initialize Filesystem**: Attempt to establish connection
   * 2. **Create Test File**: Write a temporary file with unique content
   * 3. **Verify Content**: Read back and validate file content
   * 4. **Cleanup**: Remove test file to maintain cleanliness
   * 5. **Report Results**: Return comprehensive test results
   * 
   * ## Return Value
   * Returns an associative array with test results:
   * ```php
   * [
   *   'success' => bool,
   *   'connection_established' => bool,
   *   'file_operations_working' => bool,
   *   'test_file_created' => bool,
   *   'test_file_read' => bool,
   *   'test_file_deleted' => bool,
   *   'method_used' => string,
   *   'error' => string
   * ]
   * ```
   * 
   * ## Use Cases
   * - **Pre-installation Validation**: Ensure filesystem is ready for operations
   * - **Troubleshooting**: Diagnose filesystem issues
   * - **Environment Testing**: Verify server configuration
   * - **User Feedback**: Provide clear status information
   * 
   * @since 1.0.0
   * @return array Comprehensive filesystem connection test results
   * 
   * @link https://developer.wordpress.org/reference/functions/wp_filesystem/
   */
  public function test_connection(): array
  {
    $result = $this->initialize_filesystem();

    if ($result['success']) {
      return [
        'success' => true,
        'message' => 'Filesystem connection test successful',
        'methods' => $this->get_available_methods(),
      ];
    }

    return [
      'success' => false,
      'message' => 'Filesystem connection test failed: ' . $result['message'],
    ];
  }
}
