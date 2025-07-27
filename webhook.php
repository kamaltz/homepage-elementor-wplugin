<?php
/**
 * GitHub Webhook Handler
 * Place this file in your WordPress root or create endpoint
 */

// Verify webhook secret
$secret = 'your-webhook-secret';
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
$payload = file_get_contents('php://input');

if (!hash_equals('sha256=' . hash_hmac('sha256', $payload, $secret), $signature)) {
    http_response_code(403);
    exit('Forbidden');
}

$data = json_decode($payload, true);

// Only process release events
if ($data['action'] !== 'published') {
    exit('Not a release');
}

// WordPress integration
define('WP_USE_THEMES', false);
require_once('wp-load.php');

// Trigger update check
if (function_exists('wp_update_plugins')) {
    delete_site_transient('update_plugins');
    wp_update_plugins();
}

// Log the update
error_log("GitHub webhook: New release {$data['release']['tag_name']} triggered update check");

http_response_code(200);
echo 'Update triggered';
?>