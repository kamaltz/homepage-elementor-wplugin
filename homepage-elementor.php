<?php
/**
 * Plugin Name: Homepage Elementor
 * Description: Plugin homepage editor untuk Elementor dengan elemen kustomisasi lengkap
 * Version: 1.0.0
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
        add_action('plugins_loaded', [$this, 'init']);
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('wp_ajax_check_github_update', [$this, 'check_github_update']);
        
        // Initialize updater
        new Homepage_Elementor_Updater(__FILE__, '1.0.0');
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
                            <input type="checkbox" name="homepage_auto_update" value="1" <?php checked(get_option('homepage_auto_update'), 1); ?> />
                            <label>Enable automatic updates from GitHub</label>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
            
            <h2>Manual Update</h2>
            <button type="button" id="check-update" class="button button-primary">Check for Updates</button>
            <div id="update-status"></div>
            
            <script>
            jQuery(document).ready(function($) {
                $('#check-update').click(function() {
                    $('#update-status').html('Checking for updates...');
                    $.post(ajaxurl, {
                        action: 'check_github_update'
                    }, function(response) {
                        $('#update-status').html(response.data);
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
        
        if (version_compare($release['tag_name'], $current_version, '>')) {
            $this->download_and_install($release['zipball_url'], $token);
            wp_send_json_success('Updated to version ' . $release['tag_name']);
        } else {
            wp_send_json_success('Plugin is up to date (v' . $current_version . ')');
        }
    }
    
    private function download_and_install($zip_url, $token = '') {
        $args = ['timeout' => 300];
        if ($token) {
            $args['headers'] = ['Authorization' => 'token ' . $token];
        }
        
        $temp_file = download_url($zip_url, 300, false, $args);
        
        if (is_wp_error($temp_file)) {
            return false;
        }
        
        $plugin_dir = WP_PLUGIN_DIR . '/homepage-elementor';
        
        // Backup current plugin
        if (is_dir($plugin_dir)) {
            rename($plugin_dir, $plugin_dir . '_backup_' . time());
        }
        
        // Extract new version
        $unzip = unzip_file($temp_file, WP_PLUGIN_DIR);
        unlink($temp_file);
        
        return !is_wp_error($unzip);
    }
}

new Homepage_Elementor();