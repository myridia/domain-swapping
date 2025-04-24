<?php

namespace Wpds\App\base;

defined('ABSPATH') or die('Something went wrong');

class Activate
{
    function __construct()
    {

    }

    public function activate()
    {

        $default_options = array(
            'include' => [],
        );

        //if (false == get_option('wpdssetting_option')) {
            //var_dump($default_options);
            //exit;
        //    update_option('wpdssetting_option', $default_options);
        //}
    }
}
