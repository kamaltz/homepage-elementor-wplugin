<?php
/**
 * Plugin Name: Homepage Elementor
 * Description: Plugin homepage editor untuk Elementor dengan elemen kustomisasi lengkap
 * Version: 1.0.7
 * Author: kamaltz
 */

if (!defined('ABSPATH')) {
    exit;
}

define('HOMEPAGE_URL', plugin_dir_url(__FILE__));
define('HOMEPAGE_PATH', plugin_dir_path(__FILE__));

require_once HOMEPAGE_PATH . 'includes/updater.php';

class Homepage_Elementor {
    
    public function __construct() {
        add_action('init', [$this, 'init']);
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('wp_ajax_check_github_update', [$this, 'check_github_update']);
        add_action('wp_ajax_clear_update_cache', [$this, 'clear_update_cache']);
        add_action('wp_ajax_manual_update_plugin', [$this, 'manual_update_plugin']);
        add_action('wp_ajax_clear_update_notification', [$this, 'clear_update_notification']);
        
        // Initialize updater
        new Homepage_Elementor_Updater(__FILE__, '1.0.7');
    }
    
    public function init() {
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_elementor']);
            return;
        }
        
        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'enqueue_styles']);
    }
    
    public function admin_notice_missing_elementor() {
        echo '<div class="notice notice-warning is-dismissible"><p>Homepage Elementor membutuhkan plugin Elementor untuk berfungsi.</p></div>';
    }
    
    public function register_widgets() {
        require_once HOMEPAGE_PATH . 'widgets/category-banner.php';
        require_once HOMEPAGE_PATH . 'widgets/steps-section.php';
        require_once HOMEPAGE_PATH . 'widgets/follow-us.php';
        require_once HOMEPAGE_PATH . 'widgets/footer-section.php';
        
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Category_Banner_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Steps_Section_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Follow_Us_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Footer_Section_Widget());
        
        // Add custom category
        add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);
    }
    
    public function add_elementor_widget_categories($elements_manager) {
        $elements_manager->add_category(
            'homepage-elements',
            [
                'title' => 'Homepage Elements',
                'icon' => 'fa fa-home',
            ]
        );
    }
    
    public function enqueue_scripts() {
        wp_enqueue_script('slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['jquery'], '1.8.1', true);
        wp_enqueue_script('homepage-js', HOMEPAGE_URL . 'assets/js/homepage.js', ['jquery', 'slick-js'], '1.0.0', true);
    }
    
    public function enqueue_styles() {
        wp_enqueue_style('slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', [], '1.8.1');
        wp_enqueue_style('slick-theme-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', [], '1.8.1');
        wp_enqueue_style('homepage-css', HOMEPAGE_URL . 'assets/css/homepage.css', ['slick-css'], '1.0.0');
    }
    
    public function add_admin_menu() {
        add_options_page(
            'Homepage Elementor Settings',
            'Homepage Elementor',
            'manage_options',
            'homepage-elementor-settings',
            [$this, 'settings_page']
        );
    }
    
    public function register_settings() {
        register_setting('homepage_elementor_settings', 'homepage_github_repo');
        register_setting('homepage_elementor_settings', 'homepage_github_token');
        register_setting('homepage_elementor_settings', 'homepage_auto_update');
    }
    
    public function settings_page() {
        ?>
        <div class="wrap">
            <h1>Homepage Elementor Settings</h1>
            <div class="notice notice-info">
                <p><strong>Plugin Version:</strong> <?php echo get_plugin_data(__FILE__)['Version']; ?> | 
                <strong>Author:</strong> kamaltz | 
                <strong>Last Updated:</strong> <?php echo date('Y-m-d H:i:s', filemtime(__FILE__)); ?></p>
            </div>
            <form method="post" action="options.php">
                <?php settings_fields('homepage_elementor_settings'); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">GitHub Repository</th>
                        <td>
                            <input type="text" name="homepage_github_repo" value="<?php echo esc_attr(get_option('homepage_github_repo', 'username/homepage-elementor-wplugin')); ?>" class="regular-text" />
                            <p class="description">Format: username/repository-name</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">GitHub Token</th>
                        <td>
                            <input type="password" name="homepage_github_token" value="<?php echo esc_attr(get_option('homepage_github_token')); ?>" class="regular-text" />
                            <p class="description">Personal Access Token untuk private repo (optional)</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Auto Update</th>
                        <td>
                            <input type="checkbox" name="homepage_auto_update" value="1" disabled />
                            <label style="color: #666;">Disabled - Use manual update only to prevent notification loops</label>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
            
            <h2>Manual Update</h2>
            <p><strong>Current Version:</strong> <?php echo get_plugin_data(__FILE__)['Version']; ?></p>
            <p><strong>Repository:</strong> <?php echo esc_html(get_option('homepage_github_repo', 'Not configured')); ?></p>
            <button type="button" id="check-update" class="button button-primary">Check for Updates</button>
            <div id="update-status"></div>
            
            <h3>Debug Info</h3>
            <p><strong>Plugin File:</strong> <?php echo plugin_basename(__FILE__); ?></p>
            <p><strong>Plugin Directory:</strong> <?php echo dirname(__FILE__); ?></p>
            <p><strong>Auto Update:</strong> <?php echo get_option('homepage_auto_update') ? 'Enabled' : 'Disabled'; ?></p>
            <p><strong>Last Check:</strong> <?php 
                $last_check = get_transient('homepage_elementor_last_check');
                echo $last_check ? date('Y-m-d H:i:s', $last_check) : 'Never';
            ?></p>
            <p><strong>Update Status:</strong> <?php 
                $updated = get_transient('homepage_elementor_updated');
                echo $updated ? 'Recently updated (' . date('Y-m-d H:i:s', $updated) . ')' : 'Normal';
            ?></p>
            <p><strong>Version Check:</strong> 
                File: <?php echo get_plugin_data(__FILE__)['Version']; ?> | 
                Constructor: 1.0.7
            </p>
            <p><strong>Plugin Directory:</strong> 
                <?php echo dirname(__FILE__); ?>
            </p>
            <p><strong>Auto-Update Status:</strong> 
                <span style="color: red;">DISABLED</span> - WordPress notifications disabled to prevent loops. Use manual update only.
            </p>
            <p><strong>Note:</strong> If you see persistent update notifications, click "Clear Update Notification" button above.</p>
            <button type="button" id="clear-cache" class="button">Clear Update Cache</button>
            <button type="button" id="clear-notification" class="button button-secondary">Clear Update Notification</button>
            
            <script>
            jQuery(document).ready(function($) {
                // Clear cache functionality
                $('#clear-cache').click(function() {
                    $.post(ajaxurl, {
                        action: 'clear_update_cache'
                    }, function() {
                        alert('Cache cleared');
                    });
                });
                
                // Clear notification functionality
                $('#clear-notification').click(function() {
                    $.post(ajaxurl, {
                        action: 'clear_update_notification'
                    }, function() {
                        alert('Update notification cleared.');
                    });
                });
                
                // Check update functionality
                $('#check-update').click(function() {
                    $('#update-status').html('Checking for updates...');
                    $.post(ajaxurl, {
                        action: 'check_github_update'
                    }, function(response) {
                        $('#update-status').html(response.data);
                        
                        // Bind manual update button
                        $('#manual-update').click(function() {
                            var version = $(this).data('version');
                            $(this).prop('disabled', true).text('Updating...');
                            
                            $.post(ajaxurl, {
                                action: 'manual_update_plugin',
                                version: version
                            }, function(response) {
                                if (response.success) {
                                    $('#update-status').html('<div class="notice notice-success"><p>' + response.data + '</p></div>');
                                    setTimeout(function() {
                                        location.reload();
                                    }, 2000);
                                } else {
                                    $('#update-status').html('<div class="notice notice-error"><p>' + response.data + '</p></div>');
                                    $('#manual-update').prop('disabled', false).text('Update Now');
                                }
                            });
                        });
                    });
                });
            });
            </script>
        </div>
        <?php
    }
    
    public function check_github_update() {
        $repo = get_option('homepage_github_repo');
        $token = get_option('homepage_github_token');
        
        if (!$repo) {
            wp_die('GitHub repository not configured');
        }
        
        $api_url = "https://api.github.com/repos/{$repo}/releases/latest";
        $args = ['timeout' => 30];
        
        if ($token) {
            $args['headers'] = ['Authorization' => 'token ' . $token];
        }
        
        $response = wp_remote_get($api_url, $args);
        
        if (is_wp_error($response)) {
            wp_send_json_error('Failed to check GitHub: ' . $response->get_error_message());
        }
        
        $release = json_decode(wp_remote_retrieve_body($response), true);
        $current_version = get_plugin_data(__FILE__)['Version'];
        $remote_version = ltrim($release['tag_name'], 'v');
        
        if (version_compare($remote_version, $current_version, '>')) {
            wp_send_json_success(sprintf(
                'Update available! Current: v%s → Remote: v%s. <button id="manual-update" class="button button-primary" data-version="%s">Update Now</button>',
                $current_version,
                $remote_version,
                $remote_version
            ));
        } else {
            wp_send_json_success(sprintf(
                'Plugin is up to date. Current: v%s, Remote: v%s',
                $current_version,
                $remote_version
            ));
        }
    }
    
    private function download_and_install($zip_url, $token = '') {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';
        
        $args = ['timeout' => 300];
        if ($token) {
            $args['headers'] = ['Authorization' => 'token ' . $token];
        }
        
        $temp_file = download_url($zip_url, 300, false, $args);
        
        if (is_wp_error($temp_file)) {
            return false;
        }
        
        // Always use 'homepage-elementor-wplugin' as directory name
        $target_plugin_dir = WP_PLUGIN_DIR . '/homepage-elementor-wplugin';
        $backup_dir = $target_plugin_dir . '_backup_' . time();
        
        // Backup current plugin
        if (is_dir($target_plugin_dir)) {
            rename($target_plugin_dir, $backup_dir);
        }
        
        // Create temp extraction directory
        $temp_dir = WP_CONTENT_DIR . '/temp_plugin_' . time();
        wp_mkdir_p($temp_dir);
        
        // Extract to temp directory
        $unzip = unzip_file($temp_file, $temp_dir);
        unlink($temp_file);
        
        if (is_wp_error($unzip)) {
            // Restore backup
            if (is_dir($backup_dir)) {
                rename($backup_dir, $target_plugin_dir);
            }
            return false;
        }
        
        // Find extracted folder (GitHub creates folder with repo name)
        $extracted_folders = glob($temp_dir . '/*', GLOB_ONLYDIR);
        if (empty($extracted_folders)) {
            return false;
        }
        
        // Move extracted content to target plugin directory
        rename($extracted_folders[0], $target_plugin_dir);
        
        // Clean up
        $this->delete_directory($temp_dir);
        
        // Force WordPress to recognize the new version
        wp_cache_flush();
        
        // Force plugin data refresh
        $plugin_file = $target_plugin_dir . '/homepage-elementor.php';
        if (file_exists($plugin_file)) {
            $new_plugin_data = get_plugin_data($plugin_file);
            if (isset($new_plugin_data['Version'])) {
                update_option('homepage_elementor_version', $new_plugin_data['Version']);
                
                // Update WordPress plugin cache with consistent basename
                $plugin_basename = 'homepage-elementor-wplugin/homepage-elementor.php';
                wp_cache_delete($plugin_basename, 'plugin_meta');
                wp_cache_delete('plugins', 'plugins');
            }
        }
        
        // Clean up any duplicate directories
        $this->cleanup_duplicate_directories();
        
        return true;
    }
    
    private function delete_directory($dir) {
        if (!is_dir($dir)) return;
        
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            is_dir($path) ? $this->delete_directory($path) : unlink($path);
        }
        rmdir($dir);
    }
    
    private function cleanup_duplicate_directories() {
        $plugins_dir = WP_PLUGIN_DIR;
        $target_name = 'homepage-elementor-wplugin';
        
        // Look for directories that might be duplicates
        $possible_duplicates = [
            'homepage-elementor',
            'homepage-elementor-plugin',
            'homepage-elementor-master'
        ];
        
        foreach ($possible_duplicates as $duplicate) {
            $duplicate_path = $plugins_dir . '/' . $duplicate;
            if (is_dir($duplicate_path) && $duplicate !== $target_name) {
                // Check if it contains our plugin file
                if (file_exists($duplicate_path . '/homepage-elementor.php')) {
                    $this->delete_directory($duplicate_path);
                }
            }
        }
    }
    
    public function clear_update_cache() {
        delete_site_transient('update_plugins');
        wp_send_json_success('Cache cleared');
    }
    
    public function manual_update_plugin() {
        if (!current_user_can('update_plugins')) {
            wp_send_json_error('Insufficient permissions');
        }
        
        $repo = get_option('homepage_github_repo');
        $token = get_option('homepage_github_token');
        $version = sanitize_text_field($_POST['version']);
        
        if (!$repo) {
            wp_send_json_error('GitHub repository not configured');
        }
        
        // Get download URL
        $download_url = "https://api.github.com/repos/{$repo}/zipball/v{$version}";
        
        // Download and install
        $result = $this->download_and_install($download_url, $token);
        
        if ($result) {
            // Update plugin version in database
            $plugin_file = plugin_basename(__FILE__);
            $plugin_data = get_plugin_data(__FILE__);
            
            // Force refresh plugin data
            wp_cache_delete('plugins', 'plugins');
            
            // Clear all update caches
            delete_site_transient('update_plugins');
            delete_transient('plugin_slugs');
            
            // Trigger plugin data refresh
            if (function_exists('wp_update_plugins')) {
                wp_update_plugins();
            }
            
            wp_send_json_success("Successfully updated to version {$version}! Please refresh the page.");
        } else {
            wp_send_json_error('Failed to update plugin');
        }
    }
    
    public function clear_update_notification() {
        // Clear all update-related transients
        delete_site_transient('update_plugins');
        delete_site_transient('update_themes');
        delete_transient('homepage_elementor_last_check');
        delete_transient('homepage_elementor_updated');
        
        // Clear plugin-specific caches
        $plugin_slug = plugin_basename(__FILE__);
        wp_cache_delete($plugin_slug, 'plugin_meta');
        wp_cache_delete('plugins', 'plugins');
        
        // Force WordPress to forget about updates
        global $wp_current_filter;
        remove_all_filters('pre_set_site_transient_update_plugins');
        
        wp_cache_flush();
        wp_send_json_success('All update notifications cleared');
    }
}

new Homepage_Elementor();