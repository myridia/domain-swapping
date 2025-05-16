<?php

namespace WP\Ds\Main;

class Class01
{
    private $options;

    public function __construct()
    {
        $this->options = [
            'include' => [],
        ];
    }

    /*
      Default Activate
    */
    public static function activate()
    {
        $options = [
            'include' => [],
        ];
        if (false == get_option(WPDS_OPTION)) {
            update_option(WPDS_OPTION, $options);
        }
    }

    /*
      Default Deacativation
    */
    public static function deactivate()
    {
        delete_option(WPDS_OPTION);
    }

    /*
      Add Menu Setting
    */
    public function add_menu_setting()
    {
        add_submenu_page(
            'options-general.php',
            esc_html__('Domain Swapper', 'domain_swapper'),
            esc_html__('Domain Swapper', 'domain_swapper'),
            'edit_pages',
            'domain-swapper',
            [$this, 'wporg_options_page_html'],
            99
        );
    }

    /*
      Add an API based Setting Page
      // https://developer.wordpress.org/plugins/settings/custom-settings-page/
    */
    public function register_settings()
    {
        register_setting('wporg', 'wporg_options');

        add_settings_section(
            'wporg_section_developers',
            __('The Matrix has you.', 'wporg'),
            [$this, 'callback'],
            'wporg'
        );

        add_settings_field(
            'wporg_field_pill',
            __('Pill', 'wporg'),
            [$this, 'field_pill_cb'],
            'wporg',
            'wporg_section_developers',
            [
                'label_for' => 'wporg_field_pill',
                'class' => 'wporg_row',
                'wporg_custom_data' => 'custom',
            ]
        );
    }

    public function callback()
    {
        esc_html_e('Page limit is 10', 'text-domain');
    }

    public function field_pill_cb($args)
    {
        // Get the value of the setting we've registered with register_setting()
        $options = get_option('wporg_options');
        ?>
	<select
			id="<?php echo esc_attr($args['label_for']); ?>"
			data-custom="<?php echo esc_attr($args['wporg_custom_data']); ?>"
			name="wporg_options[<?php echo esc_attr($args['label_for']); ?>]">
		<option value="red" <?php echo isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], 'red', false)) : (''); ?>>
			<?php esc_html_e('red pill', 'wporg'); ?>
		</option>
 		<option value="blue" <?php echo isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], 'blue', false)) : (''); ?>>
			<?php esc_html_e('blue pill', 'wporg'); ?>
		</option>
	</select>
	<p class="description">
		<?php esc_html_e('You take the blue pill and the story ends. You wake in your bed and you believe whatever you want to believe.', 'wporg'); ?>
	</p>
	<p class="description">
		<?php esc_html_e('You take the red pill and you stay in Wonderland and I show you how deep the rabbit-hole goes.', 'wporg'); ?>
	</p>
	<?php
    }

    public function wporg_options_page_html()
    {
        // check user capabilities
        if (!current_user_can('manage_options')) {
            return;
        }

        // add error/update messages

        // check if the user have submitted the settings
        // WordPress will add the "settings-updated" $_GET parameter to the url
        if (isset($_GET['settings-updated'])) {
            // add settings saved message with the class of "updated"
            add_settings_error('wporg_messages', 'wporg_message', __('Settings Saved', 'wporg'), 'updated');
        }

        // show error/update messages
        settings_errors('wporg_messages');
        ?>
	<div class="wrap">
		<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
		<form action="options.php" method="post">
			<?php
                // output security fields for the registered setting "wporg"
                settings_fields('wporg');
        // output setting sections and their fields
        // (sections are registered for "wporg", each field is registered to a specific section)
        do_settings_sections('wporg');
        // output save settings button
        submit_button('Save Settings');
        ?>
		</form>
	</div>
	<?php
    }
}
