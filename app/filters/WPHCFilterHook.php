<?php

namespace Wphc\App\filters;

defined('ABSPATH') or die('Something went wrong');

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://iqonic.design/
 * @since      1.0.1
 *
 * @package    Wphc
 * @subpackage Wphc/App/filters
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
 * @subpackage Wphc/App/filters
 * @author     Iqonic Design <hello@iqonic.design>
 */

class WPHCFilterHook{

    function __construct()
    {

    }

    public function run()
    {
        //add_action('registered_taxonomy', array($this, 'wphc_buffer_start_relative_url'));
        //add_action('shutdown', array($this, 'wphc_buffer_end_relative_url'));
        add_filter('pre_option_home', array($this, 'wphc_custom_siteurl'));
        add_filter('pre_option_siteurl', array($this, 'wphc_custom_siteurl'));
        add_filter('option_home', array($this, 'wphc_custom_content_url'));
        add_filter('option_siteurl', array($this, 'wphc_custom_content_url'));
        add_filter('stylesheet_directory_uri', array($this, 'wphc_custom_style_uri'));
        add_filter('stylesheet_directory', array($this, 'wphc_custom_style_uri'));
        add_filter('template_directory_uri', array($this, 'wphc_custom_style_uri'));
        add_filter('plugins_url', array($this, 'wphc_custom_content_url'));
        add_filter('content_url', array($this, 'wphc_custom_content_url'));
        add_filter('the_content', array($this, 'wphc_custom_content_url'));
        add_filter('style_loader_src', array($this, 'wphc_custom_content_url'), 10, 4);
        add_filter('script_loader_src', array($this, 'wphc_custom_content_url'), 10, 4);
        add_filter('upload_dir', array($this, 'wphc_custom_featured_img_url'));
        add_filter('wp_get_attachment_url', array($this, 'wphc_custom_attachment_url'));
        add_filter('get_the_guid', array( $this, 'wphc_custom_content_url'));
        add_filter( 'avatar_defaults', array( $this, 'wphc_custom_content_url') );
    }

    /**
     * change attachment url
     * @param $url
     * @return string|string[]
     */
    function wphc_custom_attachment_url($url)
    {
        $var = explode('/wp-content', $url);

        $url = str_replace($var[0], $this->wphc_get_new_url(), $url);
        return $url;
    }

    /**
     * change  content, plugin, script and style path
     * @param $url
     * @return string|string[]
     */
    function wphc_custom_content_url($url)
    {
        $old_url_parse = parse_url($this->wphc_get_old_url());
        $src_parse = parse_url($url);
        if (isset($src_parse['host']) && $src_parse['host'] == $old_url_parse['host']) {
            $url = str_replace($this->wphc_get_old_url(), $this->wphc_get_new_url(), $url);
            return $url;
        }

        return $url;
    }

    /**
     * get new site url
     */
    function wphc_get_new_url()
    {
        $new_url = get_option('siteurl');
        //print_r($new_url);
        return $new_url;
    }

    /**
     * get old site url
     */

    function wphc_get_old_url(){
        global $wpdb;
        $old_url=$wpdb->get_var( "SELECT option_value from wp9735options where option_name= 'siteurl'" ) ;
        return $old_url;
    }

    /**
     * change home and siteurl value
     */
    function wphc_custom_siteurl()
    {
        
        $_SERVER['HTTP_HOST'] = $_SERVER['SERVER_NAME'];
        if (!defined('WPHC_CUSTOM_REQUEST_URL')) {
            $abspath = rtrim(ABSPATH, "/");
            if (strpos($_SERVER["DOCUMENT_ROOT"], '.valet') != false) {
                define('WPHC_CUSTOM_REQUEST_URL', 'https://' . $_SERVER['HTTP_HOST']);
            } else {
                define('WPHC_CUSTOM_REQUEST_URL', 'https://' . $_SERVER['HTTP_HOST'] . str_replace($_SERVER["DOCUMENT_ROOT"], '', $abspath));
            }

            if (!defined('WP_SITEURL')) {
                define('WP_SITEURL', WPHC_CUSTOM_REQUEST_URL);
            }
            if (!defined('WP_HOME')) {
                define('WP_HOME', WPHC_CUSTOM_REQUEST_URL);
            }
        }

        return WPHC_CUSTOM_REQUEST_URL; //Specify your local dev URL here.
    }

    /**
     * @param $stylesheet_dir_uri
     * @return string|string[]
     */
    public function wphc_custom_style_uri($stylesheet_dir_uri)
    {
        $stylesheet_dir_uri = $this->wphc_custom_content_url($stylesheet_dir_uri);
        return $stylesheet_dir_uri;
    }

    /**
     * @param $buffer
     * @return string|string[]
     */
    function wphc_relative_url($buffer)
    {
        // Replace normal URLs
        $home_url = esc_url(home_url('/'));
        $home_url_relative = wp_make_link_relative($home_url);

        // Replace URLs in inline scripts
        $home_url_escaped = str_replace('/', '\/', $home_url);
        $home_url_escaped_relative = str_replace('/', '\/', $home_url_relative);

        $buffer = str_replace($home_url, $home_url_relative, $buffer);
        $buffer = str_replace($home_url_escaped, $home_url_escaped_relative, $buffer);

        return $buffer;
    }


    public function wphc_buffer_start_relative_url()
    {
        ob_start(array($this, 'wphc_relative_url'));
    }

    public function wphc_buffer_end_relative_url()
    {
        @ob_end_flush();
    }

    /**
     * custom featured image url
     * @param $src
     * @return string|string[]
     */
    public function wphc_custom_featured_img_url($src)
    {
        $src = str_replace($this->wphc_get_old_url(), $this->wphc_get_new_url(), $src);
        return $src;
    }
}
