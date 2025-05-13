<?php

namespace WP\Ds\Main;
class Class01
{
    public function __construct()
    {
        //echo 'Class01 instantiated.';
    }

    static function activate()
    {
        $options = array(
            'include' => [],
        );

        if (false == get_option('plugin_'. WPDS_NAME)) {
            update_option('plugin_'. WPDS_NAME, $options);
        }
    }

    static function deactivate()
    {
      delete_option('plugin_'. WPDS_NAME);
    }

    public function register()
    {
        add_submenu_page(
            'options-general.php',
            esc_html__('WPMultiHost','host-changer'),
            esc_html__('WPMultiHost','host-changer'),
            'read',
            'host-changer',
            array($this, 'wpdsadmin_dashboard')
        );

    }    

}
