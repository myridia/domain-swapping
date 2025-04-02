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


use MK\MyPlugin\Main\Class01;
use MK\MyPlugin\Main\Class02;
use MK\MyPlugin\Service\Class03;
 

spl_autoload_register(function(string $className) {
    if (false === strpos($className, 'MK\\MyPlugin')):
        return;
    endif;
    $className = str_replace('MK\\MyPlugin\\', __DIR__ . '/src/', $className);
    $classFile =  str_replace('\\', '/', $className) . '.php';
    require_once $classFile;
});


$class01 = new Class01();
$class02 = new Class02();
$class03 = new Class03();
