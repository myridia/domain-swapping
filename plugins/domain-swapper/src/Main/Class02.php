<?php

namespace WP\DS\Main;

class Class02
{
    private $domains;
    private $siteurl;
    private $new_siteurl;

    public function __construct()
    {
        $this->siteurl = get_option('siteurl');
        $o = get_option(WPDS_OPTION);
        $this->domains = $o['include'];
        $this->new_siteurl = self::get_new_siteurl();
        add_action('registered_taxonomy', [$this, 'swap_start_relative_url']);
        add_action('shutdown', [$this, 'swap_end_relative_url']);

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
        add_filter('upload_dir', [$this, 'swap_featured_img_url']);
        add_filter('wp_get_attachment_url', [$this, 'swap_attachment_url']);
    }

    public function swap_start_relative_url()
    {
        ob_start([$this, 'swap_relative_url']);
    }

    public function swap_end_relative_url()
    {
        @ob_end_flush();
    }

    public function swap_relative_url($buffer)
    {
        $home_url = esc_url(home_url('/'));
        $home_url_relative = wp_make_link_relative($home_url);

        $home_url_escaped = str_replace('/', '\/', $home_url);
        $home_url_escaped_relative = str_replace('/', '\/', $home_url_relative);

        $buffer = str_replace($home_url, $home_url_relative, $buffer);
        $buffer = str_replace($home_url_escaped, $home_url_escaped_relative, $buffer);

        return $buffer;
    }

    public function swap_attachment_url($url)
    {
        $var = explode('/wp-content', $url);

        $url = str_replace($var[0], $this->new_siteurl, $url);

        return $url;
    }

    public function swap_featured_img_url($src)
    {
        $src = str_replace($this->siteurl, $this->new_siteurl, $src);

        return $src;
    }

    public function swap_style_uri($stylesheet_dir_uri)
    {
        $stylesheet_dir_uri = $this->swap_content_url($stylesheet_dir_uri);

        return $stylesheet_dir_uri;
    }

    public function swap_content_url($url)
    {
        //        var_dump($url);
        $src_parse = parse_url($url);

        if (isset($src_parse['host'])) {
            $host = $src_parse['scheme'].'://'.$src_parse['host'];

            if (isset($src_parse['port'])) {
                $host = $host.':'.$src_parse['port'];
            }

            if ($host == $this->siteurl) {
                // var_dump($this->siteurl);
                // var_dump($this->new_siteurl);
                $url = str_replace($this->siteurl, $this->new_siteurl, $url);

                return $url;
            }
        }

        return $url;
    }

    private function get_new_siteurl()
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
            return 'https://'.$new_domain;
        } else {
            return $this->siteurl;
        }
    }

    public function swap_siteurl()
    {
        // var_dump($this->new_siteurl);
        // var_dump($this->siteurl);
        if ('' != $this->new_siteurl) {
            if (!defined('WPDS_CUSTOM_REQUEST_URL')) {
                define('WPDS_CUSTOM_REQUEST_URL', $this->new_siteurl);
                if (!defined('WP_SITEURL')) {
                    define('WP_SITEURL', WPDS_CUSTOM_REQUEST_URL);
                }
                if (!defined('WP_HOME')) {
                    define('WP_HOME', WPDS_CUSTOM_REQUEST_URL);
                }
            }

            // return WPDS_CUSTOM_REQUEST_URL;
            return $this->new_siteurl;
        } else {
            return $this->siteurl;
        }
    }
}
