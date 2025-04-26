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
 * Author URI: http://domain-swapper.myridia.com
 * Update URL: https://github.com/myridia/domain-swapper 
 **/


defined('ABSPATH') or die('Something went wrong');


use WP\Ds\Main\Class01;
use WP\Ds\Main\Class02;
use WP\Ds\Service\Class03;
 
/*
  Helper Function to register Classes cleanly with namespaces 
*/
spl_autoload_register(function(string $className) {
    if (false === strpos($className, 'WP\\Ds')):
        return;
    endif;
    $className = str_replace('WP\\Ds\\', __DIR__ . '/src/', $className);
    $classFile =  str_replace('\\', '/', $className) . '.php';
    require_once $classFile;
});


$plugin_data = get_file_data( __FILE__, array( 'name'=>'domain-swapper', 'version'=>'1.0', 'text'=>'domain-swapper' ) );
function allmetatags_constants( $constant_name, $value ) {
    $constant_name_prefix = 'WPDS_';
    $constant_name = $constant_name_prefix . $constant_name;
    if ( !defined( $constant_name ) )
        define( $constant_name, $value );
}

/*
  Define Plugin specific Constants
*/

allmetatags_constants( 'DIR', dirname( plugin_basename( __FILE__ ) ) );
allmetatags_constants( 'BASE', plugin_basename( __FILE__ ) );
allmetatags_constants( 'URL', plugin_dir_url( __FILE__ ) );
allmetatags_constants( 'URI', plugin_dir_url( __FILE__ ) );
allmetatags_constants( 'PATH', plugin_dir_path( __FILE__ ) );
allmetatags_constants( 'SLUG', dirname( plugin_basename( __FILE__ ) ) );
allmetatags_constants( 'BASENAME', dirname( plugin_basename( __FILE__ ) ) );
allmetatags_constants( 'NAME', $plugin_data['name'] );
allmetatags_constants( 'VERSION', $plugin_data['version'] );
allmetatags_constants( 'TEXT', $plugin_data['text'] );
allmetatags_constants( 'PREFIX', 'wpds' );
allmetatags_constants( 'SETTINGS', 'wpds' )

/*
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
/*



/*
 Default Plugin activate and deactivate hooks
*/
register_activation_hook( __FILE__, array( 'WP\Ds\Main\Class01', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'WP\Ds\Main\Class01', 'deactivate' ) );



