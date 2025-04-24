<?php
/**
 * Hard Fork from https://wordpress.org/plugins/host-changer/
 *
 * @link              https://domain-swapper.myridia.com
 * @since             1.0.0
 * @package           Domain-swapping
 *
 * @wordpress-plugin
 * Plugin Name: Domain swapper - Use and change/swap multiple domains with one WordPress Site 
 * Plugin URI: https://wordpress.org/plugins/domain-swapper 
 * Description: domain_swapper to access same WordPress site from different domains.
 * Version: 1.0.0
 * Author: Myridia Company
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: domain-swapper
 * Domain Path: /languages
 * Author URI: http://myridia.com
 * Update URL: https://github.com/myridia/domain-swapper 
 **/


defined('ABSPATH') or die('Something went wrong');


use WP\Ds\Main\Class01;
use WP\Ds\Main\Class02;
use WP\Ds\Service\Class03;
 

spl_autoload_register(function(string $className) {
    if (false === strpos($className, 'WP\\Ds')):
        return;
    endif;
    $className = str_replace('WP\\Ds\\', __DIR__ . '/src/', $className);
    $classFile =  str_replace('\\', '/', $className) . '.php';
    require_once $classFile;
});


if (!defined('WPDS_DIR_PATH')):
    define('WPDS_DIR_PATH', plugin_dir_path(__FILE__));
endif;

if (!defined('WPDS_DIR_URI')): 
    define('WPDS_DIR_URI', plugin_dir_url(__FILE__));
endif;

if (!defined('WPDS_BASENAME')):
    define('WPDS_BASENAME', plugin_basename(__FILE__));
endif;

if (!defined('WPDS_PREFIX')):
    define('WPDS_PREFIX', "wpds");
endif;

if (!defined('WPDS_NAME')):
    define('WPDS_NAME', "domain_swapper");
endif;





register_activation_hook( __FILE__, array( 'WP\Ds\Main\Class01', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'WP\Ds\Main\Class01', 'deactivate' ) );



