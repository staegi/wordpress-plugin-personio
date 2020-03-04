<?php
/**
 * Plugin Name: wp-personio
 * Description: A plugin to have the shortcodes to embed an overview of employees and their details view
 * Version: 0.0.2
 * Author: Thomas Stägemann
 * Author URI: http://www.staegemann.info
 */

// Version of the plugin
define('WP_PERSONIO_CURRENT_VERSION', '0.0.2');

$wp_personio_options = array(
    'personio_client_id'         => '',
    'personio_client_secret'     => '',
    'personio_employee_template' => file_get_contents(__DIR__ . '/templates/employee.html'),
);
global $wp_personio_options;

if (!function_exists('wp_personio_activate')) {
    register_activation_hook(__FILE__, 'wp_personio_activate');

    // Activation function. This function creates the required options and defaults.
    function wp_personio_activate()
    {
        global $wp_personio_options;

        // Create the required options...
        foreach ($wp_personio_options as $name => $val) {
            add_option($name, $val);
        }
    }
}

if (is_admin()) {
    require_once(dirname(__FILE__) . '/wp-personio-admin.php');
} else {
    require_once(dirname(__FILE__) . '/wp-personio-shortcodes.php');
}
