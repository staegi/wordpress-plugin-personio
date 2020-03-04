=== Personio ===
Contributors: tomcat2111
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=FW95HB4TZDWP8&source=url
Tags: personio, hr, employees
Requires at least: 4.9
Tested up to: 5.3
Requires PHP: 5.2.4
Stable Tag: 0.0.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This plugin provides a shortcode to display your employees from Personio.

== Description ==

You can use such a shortcode to display the employees list or grid. By using the attributes you can filter the fields with a regular expression. You have to set up these fields in Personio. But on the settings page of this plugin you can see the available fields.

    [personio_team office=Berlin gender=male custom_999999=foo]

If you need addtional filtering then you can add a hook like the following.

    if (!function_exists('wp_personio_filter_team')) {
        function wp_personio_filter_team($employees)
        {
            return array_filter($employees, function($employee){
                return $employee->attributes->gender->value == 'male';
            }, ARRAY_FILTER_USE_BOTH);
        }

        add_filter('wp_personio_filter_team', 'wp_personio_filter_team');
    }

== Installation ==

After installing and activating this plugin you need to enter the client ID and secret on the settings page. You can get these from Personio.
