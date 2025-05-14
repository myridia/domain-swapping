<?php

namespace WP\Ds\Main;

class Class01
{
    public function __construct()
    {
        // echo 'Class01 instantiated.';
    }

    public static function activate()
    {
        $options = [
            'include' => [],
        ];

        if (false == get_option('plugin_'.WPDS_NAME)) {
            update_option('plugin_'.WPDS_NAME, $options);
        }
    }

    public static function deactivate()
    {
        delete_option('plugin_'.WPDS_NAME);
    }

    public function register()
    {
        add_submenu_page(
            'options-general.php',
            esc_html__('WPMultiHost', 'host-changer'),
            esc_html__('WPMultiHost', 'host-changer'),
            'read',
            'host-changer',
            [$this, 'wpdsadmin_dashboard']
        );
    }
}
