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
            'read',
            'host-changer',
            [$this, 'setting_page']
        );
    }

    public function setting_page()
    {
        // var_dump(WPDS_PATH.'/src/views/settings.php');
        $settings = get_option(WPDS_OPTION);
        if (false == $settings) {
            update_option(WPDS_OPTION, $this->options);
        }
        // https://developer.wordpress.org/plugins/settings/settings-api/
        // register_setting(WPDS_OPTION, WPDS_OPTION);
        // add_settings_field('wpdssetting_enable_field', '', [$this, 'wpdssetting_enable_field'], 'hostchanger-setting-panel', WPDS_OPTION);
        // add_settings_field('wpdssetting_field', '', [$this, 'wpdsadd_setting_field'], 'hostchanger-setting-panel', WPDS_OPTION);

        require_once WPDS_PATH.'/src/views/settings.php';
    }
}
