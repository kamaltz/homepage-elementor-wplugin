<?php
/**
 * Plugin Name: Homepage Elementor
 * Description: Plugin homepage editor untuk Elementor dengan elemen kustomisasi lengkap
 * Version: 1.0.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit;
}

define('HOMEPAGE_URL', plugin_dir_url(__FILE__));
define('HOMEPAGE_PATH', plugin_dir_path(__FILE__));

class Homepage_Elementor {
    
    public function __construct() {
        add_action('plugins_loaded', [$this, 'init']);
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
        if (!is_admin()) {
            wp_enqueue_script('slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['jquery'], '1.8.1', true);
            wp_enqueue_script('homepage-js', HOMEPAGE_URL . 'assets/js/homepage.js', ['jquery', 'slick-js'], '1.0.0', true);
        }
    }
    
    public function enqueue_styles() {
        wp_enqueue_style('slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', [], '1.8.1');
        wp_enqueue_style('homepage-css', HOMEPAGE_URL . 'assets/css/homepage.css', [], '1.0.0');
    }
}

new Homepage_Elementor();