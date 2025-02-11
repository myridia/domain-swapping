<?php

namespace Wphc\App\base;

defined( 'ABSPATH' ) or die( 'Something went wrong' );

/**
 * Fired during plugin deactivation
 *
 * @link       https://iqonic.design/
 * @since      1.0.1
 *
 * @package    Wphc
 * @subpackage Wphc/App/base
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.1
 * @package    Wphc
 * @subpackage Wphc/App/base
 * @author     Iqonic Design <hello@iqonic.design>
 */

class WPHCDeactivate{
    function __construct() {
    }

    public function deactivate(){
        delete_option('wphc_setting_option');
    }
}