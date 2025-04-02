<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 * Hard Fork from https://wordpress.org/plugins/host-changer/
 *
 * @link              https://domain-swapping.myridia.com
 * @since             1.0.1
 * @package           domain-swapping
 *
 * @wordpress-plugin
 * Plugin Name: Domain swapping - Use and swap multiple domains with one WordPress Site 
 * Plugin URI: https://wordpress.org/plugins/domain-swapping 
 * Description: domain_swapping to access same WordPress site from different domains.
 * Version: 1.0.0
 * Author: Myridia Company
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: domain-swapping
 * Domain Path: /languages
 * Author URI: http://myridia.com
 * Update URL: https://github.com/myridia/domain-swapping 
 **/


defined('ABSPATH') or die('Something went wrong');

use Wphc\App\base\WPHCActivate;
use Wphc\App\base\WPHCDeactivate;
use Wphc\App\base\WPHCBase;
use Wphc\App\filters\WPHCFilterHook;

// Require once the Composer Autoload
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
} else {
    die('Something went wrong');
}

if (!defined('WPHC_DIR_PATH')) {
    define('WPHC_DIR_PATH', plugin_dir_path(__FILE__));
}

if (!defined('WPHC_DIR_URI')) {
    define('WPHC_DIR_URI', plugin_dir_url(__FILE__));
}

if (!defined('WPHC_BASENAME')) {
    define('WPHC_BASENAME', plugin_basename(__FILE__));
}

if (!defined('WPHC_PREFIX')) {
    define('WPHC_PREFIX', "wphc_");
}

function activate_wphost_change_plugin()
{
    (new WPHCActivate())->activate();
}

function deactivate_wphost_change_plugin()
{
    (new WPHCDeactivate())->deactivate();
}

/**
 * The code that runs during plugin activation
 */
register_activation_hook(__FILE__, 'activate_wphost_change_plugin');

/**
 * The code that runs during plugin deactivation
 */
register_deactivation_hook(__FILE__, 'deactivate_wphost_change_plugin');

(new WPHCBase())->register();

$options1 = get_option('wphc_setting_option');
$site_url = (new WPHCFilterHook)->wphc_get_old_url();
$site_url = parse_url($site_url);
$site_url = $site_url['host'];

if (!empty($options1)) {
    array_push($options1['include'], $site_url);
} else {
    $options1['include'][] = $site_url;
}

if(!empty($options1['enablehostchanger']) && $options1['enablehostchanger'] === 'on' )
{
    $_SERVER['HTTP_HOST'] =	$_SERVER['SERVER_NAME'];

    if (!empty($options1['include']) && in_array($_SERVER['HTTP_HOST'], $options1['include'])) {
        (new WPHCFilterHook)->run();
    }
    else {
        ?>
        <div id="primary" class="content-area">
            <div id="content" class="site-content" role="main">
                <header class="page-header">
                    <h1 class="page-title"><?php esc_html_e('Host/Domain Not Found', 'domain-changer'); ?></h1>
                </header>
                <div class="page-wrapper">
                    <div class="page-content">
                        <h2><?php esc_html_e('Please contact the administrator to allow your host/domain.', 'host-changer'); ?></h2>
                        <p><?php esc_html_e('Your Host/Domain: '.$_SERVER['HTTP_HOST'],'domain-swapping'); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
         exit();
    }

}
