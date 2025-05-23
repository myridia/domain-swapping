<?php

/**
 * Hard Fork from https://wordpress.org/plugins/host-changer/.
 *
 * @see              https://domain-swapper.myridia.com
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: Domain swapper - Use and change/swap multiple domains with one WordPress Site
 * Plugin URI: https://wordpress.org/plugins/domain-swapper
 * Description: domain_swapper to access same WordPress site from different domains.
 * Version: 1.0.0
 * Author: Myridia Company
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: domain_swapper
 * Domain Path: /languages
 * Author URI: http://domain-swapper.myridia.com
 * Update URL: https://github.com/myridia/domain-swapper
 * Constant Prefix: WPDS_
 * Prefix: wpds_
 **/
defined('ABSPATH') or exit('Something went wrong');

use WP\Ds\Main\Class01;

// get the metadata from the plugin header
$m_plugin_data = get_file_data(__FILE__, ['name' => 'Plugin Name', 'version' => 'Version', 'text_domain' => 'Text Domain', 'constant_prefix' => 'Constant Prefix', 'prefix' => 'Prefix']);

//  Define Plugin specific Constants
m_make_constants('NAME', $m_plugin_data['text_domain'], $m_plugin_data);
m_make_constants('DIR', dirname(plugin_basename(__FILE__)), $m_plugin_data);
m_make_constants('BASE', plugin_basename(__FILE__), $m_plugin_data);
m_make_constants('URL', plugin_dir_url(__FILE__), $m_plugin_data);
m_make_constants('URI', plugin_dir_url(__FILE__), $m_plugin_data);
m_make_constants('PATH', plugin_dir_path(__FILE__), $m_plugin_data);
m_make_constants('SLUG', dirname(plugin_basename(__FILE__)), $m_plugin_data);
m_make_constants('BASENAME', dirname(plugin_basename(__FILE__)), $m_plugin_data);
m_make_constants('VERSION', $m_plugin_data['version'], $m_plugin_data);
m_make_constants('TEXT', $m_plugin_data['text_domain'], $m_plugin_data);
m_make_constants('PREFIX', $m_plugin_data['prefix'], $m_plugin_data);
m_make_constants('SETTINGS', $m_plugin_data['prefix'], $m_plugin_data);

// Default Plugin activate and deactivate hooks
register_activation_hook(__FILE__, ['WP\Ds\Main\Class01', 'activate']);
register_deactivation_hook(__FILE__, ['WP\Ds\Main\Class01', 'deactivate']);
add_action('init', 'wp_ds_plugin_init');

function wp_ds_plugin_init()
{
    $plugin = new Class01();
    $plugin->register();
    // echo "xxxx";
    // exit;
}

/*
  Helper Function to register Classes cleanly with namespaces
*/
spl_autoload_register(function (string $className) {
    if (false === strpos($className, 'WP\\Ds')) {
        return;
    }
    $className = str_replace('WP\\Ds\\', __DIR__.'/src/', $className);
    $classFile = str_replace('\\', '/', $className).'.php';
    require_once $classFile;
});

// Helper Function to create Constants
function m_make_constants($name, $value, $pdata)
{
    $prefix = $pdata['constant_prefix'];
    $c_name = $prefix.$name;
    if (!defined($c_name)) {
        define($c_name, $value);
    }
}
