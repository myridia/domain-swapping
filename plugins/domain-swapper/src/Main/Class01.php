<?php

namespace WP\Ds\Main;

class Class01
{
    public function __construct()
    {
        // echo 'Class01 instantiated.';
    }

    /*
      Default Activate
    */
    public static function activate()
    {
        $options = [
            'include' => [],
        ];

        if (false == get_option('plugin_'.WPDS_NAME)) {
            update_option('plugin_'.WPDS_NAME, $options);
        }
    }

    /*
      Default Deacativation
    */
    public static function deactivate()
    {
        delete_option('plugin_'.WPDS_NAME);
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
        require_once WPDS_PATH.'/src/views/settings.php';
    }
}
