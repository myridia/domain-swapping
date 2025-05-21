<?php

namespace WP\Ds\Main;

class Class01
{
    private $options;

    public function __construct()
    {
        $this->options = [
            'include' => ['ww1.app.local', 'ww2.app.local', 'ww3.app.local', 'foo.bar.local'],
        ];
    }

    /*
      Default Activate
    */
    public static function activate()
    {
        $options = [
            'include' => ['ww1.app.local', 'ww2.app.local', 'ww3.app.local', 'foo.bar.local'],
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
            'manage_options',
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
        register_setting(WPDS_OPTION, WPDS_OPTION);

        // https://developer.wordpress.org/reference/functions/add_settings_section/
        add_settings_section(
            'section1',
            __('Settings', WPDS_TEXT),
            [$this, 'callback'],
            WPDS_OPTION
        );
        // https://developer.wordpress.org/reference/functions/add_settings_field/
        add_settings_field(
            'activate',
            __('Activate', WPDS_TEXT),
            [$this, 'field_active'],
            WPDS_OPTION,
            'section1',
            [
                'label_for' => 'wporg_field_active',
                'class' => 'wporg_row',
                'wporg_custom_data' => 'custom',
            ]
        );
        add_settings_field(
            'include',
            __('Include Domains', WPDS_TEXT),
            [$this, 'field_include'],
            WPDS_OPTION,
            'section1',
            [
                'label_for' => 'wporg_field_include',
                'class' => 'wporg_row',
                'wporg_custom_data' => 'custom',
            ]
        );
    }

    public function callback()
    {
        esc_html_e('Settings Saved to ', WPDS_TEXT);
    }

    public function field_active($args)
    {
        $options = get_option(WPDS_OPTION);
        ?>
        <input type="checkbox" id="<?php echo esc_attr($args['label_for']); ?>" name="<?php echo esc_attr($args['label_for']); ?>" />

	<?php
    }

    public function field_include($args)
    {
        $o = get_option(WPDS_OPTION);
        foreach ($o['include'] as $i) {
            ?>
        <input type="text" id="<?php echo esc_attr($args['label_for']); ?>" name="<?php echo esc_attr($args['label_for']); ?>" value="<?php echo $i; ?>" />
  	   <?php
        }
    }

    public function wporg_options_page_html()
    {
        if (!current_user_can('manage_options')) {
            return;
        }
        if (isset($_GET['settings-updated'])) {
            add_settings_error('wporg_messages', 'wporg_message', __('Settings saved successfully to the database option settings:  '.WPDS_OPTION, WPDS_TEXT), 'updated');
        }
        settings_errors('wporg_messages');
        ?>
	<div class="wrap">
		<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
		<form action="options.php" method="post">
			<?php

        settings_fields(WPDS_OPTION);
        do_settings_sections(WPDS_OPTION);
        submit_button('Save Settings');
        ?>
		</form>
	</div>
	<?php
    }
}
