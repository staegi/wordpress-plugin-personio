<div class="wrap">
    <h2><?php esc_html_e('Personio Settings', 'wp-personio'); ?></h2>
    <form method="post" action="<?php echo esc_url(admin_url('options.php')); ?>">
        <?php settings_fields('wp-personio'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <label for="personio_client_id"><?php esc_html_e('Client ID', 'wp-personio'); ?>*</label>
                </th>
                <td>
                    <input name="personio_client_id" type="text" id="personio_client_id" value="<?php echo esc_attr(get_option('personio_client_id')); ?>" class="regular-text"/>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="personio_client_secret"><?php esc_html_e('Client Secret', 'wp-personio'); ?>*</label>
                </th>
                <td>
                    <input name="personio_client_secret" type="password" id="personio_client_secret" value="<?php echo esc_attr(get_option('personio_client_secret')); ?>" class="regular-text"/>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="personio_employee_template"><?php esc_html_e('Template for a single employee', 'wp-personio'); ?>*</label>
                </th>
                <td>
                    <?php wp_editor(get_option('personio_employee_template'), 'personio_employee_template'); ?>
                    <p class="description">
                        <?php esc_html_e('You can add an employee field by a shortcode. See your available fields:', 'wp-personio'); ?>
                    </p>
                    <p>
                        <?php foreach ($fields as $field) : ?>
                            <span class="mailtag code used"><?php printf('[personio field="%s"]', $field); ?></span>
                        <?php endforeach; ?>
                    </p>
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
        <p class="description">* <?php esc_html_e('These fields are required', 'wp-personio'); ?></p>
    </form>
</div>