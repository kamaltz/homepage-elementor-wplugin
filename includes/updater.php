<?php
if (!defined('ABSPATH')) {
    exit;
}

class Homepage_Elementor_Updater {
    
    private $plugin_file;
    private $version;
    private $repo;
    private $token;
    
    public function __construct($plugin_file, $version) {
        $this->plugin_file = $plugin_file;
        $this->version = $version;
        $this->repo = get_option('homepage_github_repo');
        $this->token = get_option('homepage_github_token');
        
        // Only enable if auto-update is enabled
        if (get_option('homepage_auto_update')) {
            add_filter('pre_set_site_transient_update_plugins', [$this, 'check_for_update']);
            add_filter('plugins_api', [$this, 'plugin_info'], 20, 3);
            add_action('in_plugin_update_message-' . plugin_basename($this->plugin_file), [$this, 'plugin_update_message']);
        }
        
        add_action('upgrader_process_complete', [$this, 'after_plugin_update'], 10, 2);
    }
    
    public function check_for_update($transient) {
        if (empty($transient->checked) || !$this->repo) {
            return $transient;
        }
        
        $plugin_slug = plugin_basename($this->plugin_file);
        $remote_version = $this->get_remote_version();
        
        // Get current version from file (not cached)
        $current_plugin_data = get_plugin_data($this->plugin_file, false, false);
        $current_version = $current_plugin_data['Version'];
        
        // Also check constructor version
        $constructor_version = $this->version;
        
        // Use the higher version between file and constructor
        $actual_version = version_compare($current_version, $constructor_version, '>') ? $current_version : $constructor_version;
        
        if (version_compare($actual_version, $remote_version, '<')) {
            $transient->response[$plugin_slug] = (object) [
                'slug' => dirname($plugin_slug),
                'plugin' => $plugin_slug,
                'new_version' => $remote_version,
                'url' => "https://github.com/{$this->repo}",
                'package' => $this->get_download_url()
            ];
        } else {
            // Remove from response if up to date
            unset($transient->response[$plugin_slug]);
            
            // Also remove from no_update to prevent caching issues
            if (isset($transient->no_update)) {
                unset($transient->no_update[$plugin_slug]);
            }
        }
        
        return $transient;
    }
    
    public function plugin_info($result, $action, $args) {
        $plugin_slug = dirname(plugin_basename($this->plugin_file));
        
        if ($action !== 'plugin_information' || $args->slug !== $plugin_slug) {
            return $result;
        }
        
        return (object) [
            'name' => 'Homepage Elementor',
            'slug' => $plugin_slug,
            'version' => $this->get_remote_version(),
            'author' => 'kamaltz',
            'homepage' => "https://github.com/{$this->repo}",
            'download_link' => $this->get_download_url(),
            'sections' => [
                'description' => 'Plugin homepage editor untuk Elementor dengan elemen kustomisasi lengkap'
            ]
        ];
    }
    
    private function get_remote_version() {
        $api_url = "https://api.github.com/repos/{$this->repo}/releases/latest";
        $args = ['timeout' => 10];
        
        if ($this->token) {
            $args['headers'] = ['Authorization' => 'token ' . $this->token];
        }
        
        $response = wp_remote_get($api_url, $args);
        
        if (is_wp_error($response)) {
            return $this->version;
        }
        
        $release = json_decode(wp_remote_retrieve_body($response), true);
        $tag_name = isset($release['tag_name']) ? $release['tag_name'] : $this->version;
        
        // Remove 'v' prefix if exists
        return ltrim($tag_name, 'v');
    }
    
    private function get_download_url() {
        return "https://api.github.com/repos/{$this->repo}/zipball/main";
    }
    

    
    public function plugin_update_message($plugin_data) {
        echo '<br><strong>Update available from GitHub repository.</strong>';
    }
    
    public function after_plugin_update($upgrader_object, $options) {
        if ($options['action'] == 'update' && $options['type'] == 'plugin') {
            $plugin_slug = plugin_basename($this->plugin_file);
            
            if (isset($options['plugins']) && in_array($plugin_slug, $options['plugins'])) {
                // Clear all caches after update
                delete_site_transient('update_plugins');
                delete_transient('homepage_elementor_last_check');
                wp_cache_flush();
                
                // Force refresh plugin data
                wp_cache_delete($plugin_slug, 'plugin_meta');
                wp_cache_delete('plugins', 'plugins');
                
                // Set flag that update completed
                set_transient('homepage_elementor_updated', time(), 300);
            }
        }
    }
}