<?php

namespace Wphc\App\base;

defined('ABSPATH') or die('Something went wrong');

/**
 * Fired during plugin activation
 *
 * @link       https://iqonic.design/
 * @since      1.0.1
 *
 * @package    Wphc
 * @subpackage Wphc/App/base
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.1
 * @package    Wphc
 * @subpackage Wphc/App/base
 * @author     Iqonic Design <hello@iqonic.design>
 */

class WPHCActivate
{
    function __construct()
    {

    }

    public function activate()
    {

        $default_options = array(
            'include' => [],
        );

        if (false == get_option('wphc_setting_option')) {
            update_option('wphc_setting_option', $default_options);
        }
    }
}