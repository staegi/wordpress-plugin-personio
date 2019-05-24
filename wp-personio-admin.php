<?php

if (!function_exists('wp_personio_register_settings')) {
    add_action('admin_init', 'wp_personio_register_settings');

    function wp_personio_register_settings()
    {
        global $wp_personio_options;

        foreach ($wp_personio_options as $name => $value) {
            register_setting('wp-personio', $name);
        }
    }
}

if (!function_exists('wp_personio_menus')) {
    add_action('admin_menu', 'wp_personio_menus');

    // This function adds the required page (only 1 at the moment).
    function wp_personio_menus()
    {
        if (function_exists('add_submenu_page')) {
            add_options_page(__('Personio Settings', 'wp-personio'), __('Personio', 'wp-personio'), 'manage_options', 'wp-personio', 'wp_personio_options_page');
        }
    }
}

if (!function_exists('wp_personio_options_page')) {
    function wp_personio_options_page()
    {
        require_once 'classes/PersonioAPI.php';
        $api = new PersonioAPI();
        $fields = $api->getEmployeesFieldList();
        include 'includes/options-page.php';
    }
}
