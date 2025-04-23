<?php

namespace Wpds\App\base;

defined('ABSPATH') or die('Something went wrong');

class Base
{
    public $plugin_name;

    function __construct()
    {
        $this->plugin_name = WPDS_BASENAME;
    }

    function register()
    {
        add_action('admin_menu', array($this, 'wpdsadmin_menu'));
        add_filter("plugin_action_links_$this->plugin_name", array($this, 'wpdssettings_link'));
        add_action('admin_init', array($this, 'wpdsadmin_setting'));
        add_action( 'admin_enqueue_scripts', array( $this, 'wpdsenqueueStyles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'wpdsenqueueScripts' ) );
        load_plugin_textdomain('host-changer',false, dirname(WPDS_BASENAME). '/languages/'	);  
    }

    public function admin_menu()
    {
        add_submenu_page(
            'tools.php',
            esc_html__('WPMultiHost','host-changer'),
            esc_html__('WPMultiHost','host-changer'),
            'read',
            'host-changer',
            array($this, 'wpdsadmin_dashboard')
        );
    }

    public function admin_dashboard()
    {
        require_once(WPDS_DIR_PATH . 'assets/admin/settings.php');
    }

    public function settings_link($links)
    {
        $settings_link = '<a href="' . admin_url('tools.php?page=host-changer') . '">'.esc_html__('Settings','host-changer').'</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    public function admin_setting()
    {
        $default_options = array(
            'include' => [],
        );

        if (false == get_option('wpdssetting_option')) {

           add_option('wpdssetting_option');
           update_option('wpdssetting_option', $default_options);
        }

        add_settings_section('wpdssetting_section', '', '', 'hostchanger-setting-panel');
        register_setting('wpdssetting_option', 'wpdssetting_option');
        add_settings_field('wpdssetting_enable_field', '', array($this, 'wpdssetting_enable_field'), 'hostchanger-setting-panel', 'wpdssetting_section');
        add_settings_field('wpdssetting_field', '', array($this, 'wpdsadd_setting_field'), 'hostchanger-setting-panel', 'wpdssetting_section');

    }

    public function setting_enable_field()
    {
        $options1 = get_option('wpdssetting_option');
        ?>
        <tr>
            <th>
                <label for="enableds">
                    <?php echo esc_html__('Enable Domain Swapping','domain-swapping') ?>
                </label>
            </th>
            <td>
                <input id="enableds" name="wpdssetting_option[enableew]" type="checkbox" <?php echo (isset($options1['enableds']) && $options1['enableds'] === 'on'  ? ' checked=checked ' : '') ; ?> >
                <p class="description text-muted" id="enableds-description"><?php echo esc_html__('If you are Enabling Domain Swapping and not in the main domain, then first add your domain in the Allowed host and save settings before enabling.','domain-swapping') ?></p>
            </td>
        </tr>
        <?php
    }

    public function add_setting_field()
    {
        require_once(WPDS_DIR_PATH . 'assets/admin/setting_fields.php');
    }

    public function enqueueStyles() {
        global $pagenow;
        if($pagenow === 'tools.php'  &&  !empty($_GET['page'])  &&  $_GET['page'] === 'host-changer') {
            wp_enqueue_style('wpdsbootstrap_css', WPDS_DIR_URI . 'assets/admin/css/bootstrap.min.css', '1.0.1');
            wp_enqueue_style('wpdscustom_css', WPDS_DIR_URI . 'assets/admin/css/custom.css', '1.0.1');
        }
    }


    public function enqueueScripts()
    {
        wp_enqueue_script('wpdsbootstrap_js', WPDS_DIR_URI . 'assets/admin/js/bootstrap.min.js', ['jquery'], '1.0.1', true);
        wp_enqueue_script('wpdscustom', WPDS_DIR_URI . 'assets/admin/js/custom.js', ['jquery'], '1.0.1', true);
        wp_localize_script('wpdscustom', 'wpdslocalize', array(
            'allow_host' => esc_html__('Allowed Host','host-changer'),
            'no_item' => esc_html__('No Item Found Refresh your page and try again.','host-changer')
        ));
    }
}
