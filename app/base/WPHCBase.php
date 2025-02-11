<?php

namespace Wphc\App\base;

defined('ABSPATH') or die('Something went wrong');

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin line.
 *
 * @link       https://iqonic.design
 * @since      1.0.1
 *
 * @package    Wphc
 * @subpackage Wphc/App/base
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.1
 * @package    Wphc
 * @subpackage Wphc/App/base
 * @author     Iqonic Design < hello@iqonic.design>
 */

class WPHCBase
{
    public $plugin_name;

    function __construct()
    {
        $this->plugin_name = WPHC_BASENAME;
    }

    function register()
    {
        add_action('admin_menu', array($this, 'wphc_admin_menu'));
        add_filter("plugin_action_links_$this->plugin_name", array($this, 'wphc_settings_link'));
        add_action('admin_init', array($this, 'wphc_admin_setting'));
        add_action( 'admin_enqueue_scripts', array( $this, 'wphc_enqueueStyles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'wphc_enqueueScripts' ) );
        load_plugin_textdomain('host-changer',false, dirname(WPHC_BASENAME). '/languages/'	);  
    }

    public function wphc_admin_menu()
    {
        add_submenu_page(
            'tools.php',
            esc_html__('WPMultiHost','host-changer'),
            esc_html__('WPMultiHost','host-changer'),
            'read',
            'host-changer',
            array($this, 'wphc_admin_dashboard')
        );
    }

    public function wphc_admin_dashboard()
    {
        require_once(WPHC_DIR_PATH . 'assets/admin/settings.php');
    }

    public function wphc_settings_link($links)
    {
        $settings_link = '<a href="' . admin_url('tools.php?page=host-changer') . '">'.esc_html__('Settings','host-changer').'</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    public function wphc_admin_setting()
    {
        $default_options = array(
            'include' => [],
        );

        if (false == get_option('wphc_setting_option')) {

           add_option('wphc_setting_option');
           update_option('wphc_setting_option', $default_options);
        }

        add_settings_section('wphc_setting_section', '', '', 'hostchanger-setting-panel');
        register_setting('wphc_setting_option', 'wphc_setting_option');
        add_settings_field('wphc_setting_enable_field', '', array($this, 'wphc_setting_enable_field'), 'hostchanger-setting-panel', 'wphc_setting_section');
        add_settings_field('wphc_setting_field', '', array($this, 'wphc_add_setting_field'), 'hostchanger-setting-panel', 'wphc_setting_section');

    }

    public function wphc_setting_enable_field()
    {
        $options1 = get_option('wphc_setting_option');
        ?>
        <tr>
            <th>
                <label for="enablehostchanger">
                    <?php echo esc_html__('Enable Multiple Domains','host-changer') ?>
                </label>
            </th>
            <td>
                <input id="enablehostchanger" name="wphc_setting_option[enablehostchanger]" type="checkbox" <?php echo (isset($options1['enablehostchanger']) && $options1['enablehostchanger'] === 'on'  ? ' checked=checked ' : '') ; ?> >
                <p class="description text-muted" id="enablehostchanger-description"><?php echo esc_html__('If you are Enabling Multiple Domains and not in the main domain, Then first add your domain in the Allowed host and save settings before enabling.','host-changer') ?></p>
            </td>
        </tr>
        <?php
    }

    public function wphc_add_setting_field()
    {
        require_once(WPHC_DIR_PATH . 'assets/admin/setting_fields.php');
    }

    public function wphc_enqueueStyles() {
        global $pagenow;
        if($pagenow === 'tools.php'  &&  !empty($_GET['page'])  &&  $_GET['page'] === 'host-changer') {
            wp_enqueue_style('wphc_bootstrap_css', WPHC_DIR_URI . 'assets/admin/css/bootstrap.min.css', '1.0.1');
            wp_enqueue_style('wphc_custom_css', WPHC_DIR_URI . 'assets/admin/css/custom.css', '1.0.1');
        }
    }


    public function wphc_enqueueScripts()
    {
        wp_enqueue_script('wphc_bootstrap_js', WPHC_DIR_URI . 'assets/admin/js/bootstrap.min.js', ['jquery'], '1.0.1', true);
        wp_enqueue_script('wphc_custom', WPHC_DIR_URI . 'assets/admin/js/custom.js', ['jquery'], '1.0.1', true);
        wp_localize_script('wphc_custom', 'wphc_localize', array(
            'allow_host' => esc_html__('Allowed Host','host-changer'),
            'no_item' => esc_html__('No Item Found Refresh your page and try again.','host-changer')
        ));
    }
}