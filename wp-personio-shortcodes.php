<?php

require_once('classes/PersonioAPI.php');

if (!function_exists('wp_personio_team_shortcode')) {
    add_shortcode('personio_team', 'wp_personio_team_shortcode');

    function wp_personio_team_shortcode($attributes = [])
    {
        $attributes = is_array($attributes) ? $attributes : [];

        // check settings
        $template = get_option('personio_employee_template');
        if (!trim($template)) {
            return;
        }

        // fetch employees via Personio API
        $api = new PersonioAPI();
        $employees = $api->getEmployees();
        if (is_int($employees)) {
            return;
        }

        // normalize attribute keys, lowercase
        $attributes = array_change_key_case($attributes, CASE_LOWER);

        // filter the result by the attributes given in the shortcode
        foreach ($attributes as $attribute => $filter) {
            $employees = array_filter($employees, function ($employee) use ($attribute, $filter) {
                if (!property_exists($employee->attributes, $attribute)) return true;

                $value = $employee->attributes->$attribute->value;
                if ($attribute == 'office') {
                    $value = $value->attributes->name;
                }

                return preg_match('/' . $filter . '/s', $value) === 1;
            }, ARRAY_FILTER_USE_BOTH);
        }

        // here the user has the capability to filter by a custom function, see readme.md
        $employees = apply_filters('wp_personio_filter_team', $employees);

        // show this template if no employee is left after filtering
        if (empty($employees)) {
            return include 'includes/empty-employees.php';
        }

        // finally render the employees
        $wrapper = '<div class="wp-personio-team">%s</div>';
        $content = [];
        foreach ($employees as $employee) {
            global $employee;
            if (!$employee) continue;
            $content[] = do_shortcode($template);
            $employee = null;
        }

        return sprintf($wrapper, join('', $content));
    }
}

if (!function_exists('wp_personio_field_shortcode')) {
    add_shortcode('personio', 'wp_personio_field_shortcode');

    function wp_personio_field_shortcode(array $attributes = [])
    {
        global $employee;

        if (!is_object($employee)) return;

        // normalize attribute keys, lowercase
        $attributes = array_change_key_case($attributes, CASE_LOWER);

        // check whether the attribute exists
        $fieldName = $attributes['field'];
        if (!property_exists($employee->attributes, $fieldName)) {
            return;
        }

        // the office contains an object instead of a plain string
        $value = $employee->attributes->$fieldName->value;
        if ($fieldName == 'office') {
            return $value->attributes->name;
        }

        return $value;
    }
}


