<?php

namespace WP\DS\Main;

class Class02
{
    private $domains;
    private $siteurl;
    private $new_siteurl;

    public function __construct()
    {
        $o = get_option(WPDS_OPTION);
        $this->domains = $o['include'];
        $this->siteurl = get_option('siteurl');

        add_filter('pre_option_home', [$this, 'swap_siteurl']);
        add_filter('pre_option_siteurl', [$this, 'swap_siteurl']);
        add_filter('option_home', [$this, 'swap_content_url']);
        add_filter('option_siteurl', [$this, 'swap_content_url']);
        add_filter('plugins_url', [$this, 'swap_content_url']);
        add_filter('content_url', [$this, 'swap_content_url']);
        add_filter('the_content', [$this, 'swap_content_url']);
        add_filter('style_loader_src', [$this, 'swap_content_url'], 10, 4);
        add_filter('script_loader_src', [$this, 'swap_content_url'], 10, 4);
        add_filter('get_the_guid', [$this, 'swap_content_url']);
        add_filter('avatar_defaults', [$this, 'swap_content_url']);
        add_filter('stylesheet_directory_uri', [$this, 'swap_style_uri']);
        add_filter('stylesheet_directory', [$this, 'swap_style_uri']);
        add_filter('template_directory_uri', [$this, 'swap_style_uri']);

        /*

        add_filter('upload_dir', [$this, 'wpdscustom_featured_img_url']);
        add_filter('wp_get_attachment_url', [$this, 'wpdscustom_attachment_url']);

        */
    }

    public function swap_style_uri($stylesheet_dir_uri)
    {
        $stylesheet_dir_uri = $this->swap_content_url($stylesheet_dir_uri);

        return $stylesheet_dir_uri;
    }

    public function swap_content_url($url)
    {
        $src_parse = parse_url($url);

        if (isset($src_parse['host'])) {
            $host = $src_parse['scheme'].'://'.$src_parse['host'];

            if (isset($src_parse['port'])) {
                $host = $host.':'.$src_parse['port'];
            }

            if ($host == $this->siteurl) {
                $url = str_replace($this->siteurl, $this->new_siteurl, $url);

                return $url;
            }
        }

        return $url;
    }

    public function swap_siteurl()
    {
        $new_domain = '';
        if (isset($_SERVER['HTTP_HOST'])) {
            if ('' != $_SERVER['HTTP_HOST']) {
                $new_domain = $_SERVER['HTTP_HOST'];
            }
        } elseif (isset($_SERVER['SERVER_NAME'])) {
            if ('' != $_SERVER['SERVER_NAME']) {
                $new_domain = $_SERVER['SERVER_NAME'];
            }
        }

        if (in_array($new_domain, $this->domains)) {
            $this->new_siteurl = $new_domain;
            if (!defined('WPDS_CUSTOM_REQUEST_URL')) {
                define('WPDS_CUSTOM_REQUEST_URL', 'https://'.$new_domain);
                if (!defined('WP_SITEURL')) {
                    define('WP_SITEURL', WPDS_CUSTOM_REQUEST_URL);
                }
                if (!defined('WP_HOME')) {
                    define('WP_HOME', WPDS_CUSTOM_REQUEST_URL);
                }
            }

            return WPDS_CUSTOM_REQUEST_URL;
        } else {
            return $this->siteurl;
        }
    }
}
