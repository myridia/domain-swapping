<?php
/**
 * Hard Fork from https://wordpress.org/plugins/host-changer/
 *
 * @link              https://domain-swapping.myridia.com
 * @since             1.0.0
 * @package           Domain-swapping
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

/*
require_once __DIR__ . '/app/base/Activate.php';
require_once __DIR__ . '/app/base/Deactivate.php';
require_once __DIR__ . '/app/base/Base.php';
require_once __DIR__ . '/app/filters/Filterhook.php';

use Wpds\App\base\Activate;
use Wpds\App\base\Deactivate;
use Wpds\App\base\Base;
use Wpds\App\filters\FilterHook;


}


register_activation_hook(__FILE__, 'activate_wpds_plugin');
//register_deactivation_hook(__FILE__, 'deactivate_wpds_plugin');


(new WPDSBase())->register();

$options1 = get_option('wpdssetting_option');
$site_url = (new WPDSFilterHook)->wpdsget_old_url();
$site_url = parse_url($site_url);
$site_url = $site_url['host'];

if (!empty($options1)) {
    array_push($options1['include'], $site_url);
} else {
    $options1['include'][] = $site_url;
}

if(!empty($options1['enableds']) && $options1['enableds'] === 'on' )
{
    $_SERVER['HTTP_HOST'] =	$_SERVER['SERVER_NAME'];

    if (!empty($options1['include']) && in_array($_SERVER['HTTP_HOST'], $options1['include'])) {
        (new WPDSFilterHook)->run();
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
*/
