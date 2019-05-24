# wp-personio

## Installation 

Go to the settings page to set client ID and secret.

## Shortcodes

    [personio_team office=Berlin gender=male custom_999999=foo]

## Filter employees

    if (!function_exists('wp_personio_filter_team')) {
        add_action('wp_personio_filter_team', 'wp_personio_filter_team');
    
        function wp_personio_filter_team($employees)
        {
            return array_filter($employees, function($employee){
                return $employee->attributes->gender->value == 'male';
            }, ARRAY_FILTER_USE_BOTH);
        }
    }
