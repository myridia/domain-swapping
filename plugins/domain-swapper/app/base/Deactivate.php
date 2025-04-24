<?php

namespace Wpds\App\base;

defined( 'ABSPATH' ) or die( 'Something went wrong' );

class Deactivate{
    function __construct() {
    }

    public function deactivate(){
        delete_option('wpdssetting_option');
    }
}
