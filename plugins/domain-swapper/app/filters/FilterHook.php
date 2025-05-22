<?php

namespace Wpds\App\filters;

defined('ABSPATH') or exit('Something went wrong');

class FilterHook
{
    public function __construct()
    {
    }

    public function run()
    {
        // add_action('registered_taxonomy', array($this, 'wpdsbuffer_start_relative_url'));
        // add_action('shutdown', array($this, 'wpdsbuffer_end_relative_url'));

        add_filter('pre_option_home', [$this, 'wpdscustom_siteurl']);
        add_filter('pre_option_siteurl', [$this, 'wpdscustom_siteurl']);
        add_filter('option_home', [$this, 'wpdscustom_content_url']);
        add_filter('option_siteurl', [$this, 'wpdscustom_content_url']);
        add_filter('stylesheet_directory_uri', [$this, 'wpdscustom_style_uri']);
        add_filter('stylesheet_directory', [$this, 'wpdscustom_style_uri']);
        add_filter('template_directory_uri', [$this, 'wpdscustom_style_uri']);

        add_filter('plugins_url', [$this, 'wpdscustom_content_url']);
        add_filter('content_url', [$this, 'wpdscustom_content_url']);
        add_filter('the_content', [$this, 'wpdscustom_content_url']);
        add_filter('style_loader_src', [$this, 'wpdscustom_content_url'], 10, 4);
        add_filter('script_loader_src', [$this, 'wpdscustom_content_url'], 10, 4);
        add_filter('upload_dir', [$this, 'wpdscustom_featured_img_url']);
        add_filter('wp_get_attachment_url', [$this, 'wpdscustom_attachment_url']);
        add_filter('get_the_guid', [$this, 'wpdscustom_content_url']);
        add_filter('avatar_defaults', [$this, 'wpdscustom_content_url']);
    }

    /**
     * change attachment url.
     *
     * @return string|string[]
     */
    public function custom_attachment_url($url)
    {
        $var = explode('/wp-content', $url);

        $url = str_replace($var[0], $this->wpdsget_new_url(), $url);

        return $url;
    }

    /**
     * change  content, plugin, script and style path.
     *
     * @return string|string[]
     */
    public function custom_content_url($url)
    {
        $old_url_parse = parse_url($this->wpdsget_old_url());
        $src_parse = parse_url($url);
        if (isset($src_parse['host']) && $src_parse['host'] == $old_url_parse['host']) {
            $url = str_replace($this->wpdsget_old_url(), $this->wpdsget_new_url(), $url);

            return $url;
        }

        return $url;
    }

    /**
     * get new site url.
     */
    public function get_new_url()
    {
        $new_url = get_option('siteurl');

        // print_r($new_url);
        return $new_url;
    }

    /**
     * get old site url.
     */
    public function get_old_url()
    {
        global $wpdb;
        $old_url = $wpdb->get_var("SELECT option_value from wp9735options where option_name= 'siteurl'");

        return $old_url;
    }

    /**
     * change home and siteurl value.
     */
    public function custom_siteurl()
    {
        $_SERVER['HTTP_HOST'] = $_SERVER['SERVER_NAME'];
        if (!defined('WPDS_CUSTOM_REQUEST_URL')) {
            $abspath = rtrim(ABSPATH, '/');
            if (false != strpos($_SERVER['DOCUMENT_ROOT'], '.valet')) {
                define('WPDS_CUSTOM_REQUEST_URL', 'https://'.$_SERVER['HTTP_HOST']);
            } else {
                define('WPDS_CUSTOM_REQUEST_URL', 'https://'.$_SERVER['HTTP_HOST'].str_replace($_SERVER['DOCUMENT_ROOT'], '', $abspath));
            }

            if (!defined('WP_SITEURL')) {
                define('WP_SITEURL', WPDS_CUSTOM_REQUEST_URL);
            }
            if (!defined('WP_HOME')) {
                define('WP_HOME', WPDS_CUSTOM_REQUEST_URL);
            }
        }

        return WPDS_CUSTOM_REQUEST_URL; // Specify your local dev URL here.
    }

    /**
     * @return string|string[]
     */
    public function custom_style_uri($stylesheet_dir_uri)
    {
        $stylesheet_dir_uri = $this->wpdscustom_content_url($stylesheet_dir_uri);

        return $stylesheet_dir_uri;
    }

    /**
     * @return string|string[]
     */
    public function relative_url($buffer)
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

    public function buffer_start_relative_url()
    {
        ob_start([$this, 'wpdsrelative_url']);
    }

    public function wpdsbuffer_end_relative_url()
    {
        @ob_end_flush();
    }

    /**
     * custom featured image url.
     *
     * @return string|string[]
     */
    public function custom_featured_img_url($src)
    {
        $src = str_replace($this->wpdsget_old_url(), $this->wpdsget_new_url(), $src);

        return $src;
    }
}
